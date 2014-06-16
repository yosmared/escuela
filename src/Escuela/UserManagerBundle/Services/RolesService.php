<?php

namespace Escuela\UserManagerBundle\Services;

use Escuela\UserManagerBundle\Entity\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Model\DomainObjectInterface;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;
use Symfony\Component\Security\Acl\Model\MutableAclProviderInterface;
use Symfony\Component\Process\Exception\RuntimeException;
use Escuela\UserManagerBundle\Form\ListType;

class RolesService extends BaseService {
	
	protected $request;
	protected $formType;
	protected $formFactory;
	protected $router;
	protected $bitmask = array ();
	protected $aclService;
	const ES="es_ES";
	const EN="en_US";
	
	public function setDependenciesInyectionRole(Request $request = null, 
			FormFactory $formFactory, 
			AbstractType $formType, 
			Router $router, 
			$aclService) {
		parent::setDependenciesInyection($request, $formFactory, $formType, $router);
		$this->aclService = $aclService;
	}
	public function newRoles() {
		$entity = new Roles ();
		
		$options = array (
				'action' => $this->router->generate ( 'roles_create', array (), UrlGeneratorInterface::ABSOLUTE_PATH ),
				'method' => 'POST' 
		);
		
		$form = $this->createForm ( $this->formType, $entity, $options );

		$modules = $this->processRequestPermissions();
		return array (
				'modules' => $modules,
				'entity' => $entity,
				'form' => $form->createView () 
		);
	}
	public function createForm(AbstractType $type, $data, $options = array()) {
		$form = $this->formFactory->create ( $type, $data, $options );
		$form->add ( 'submit', 'submit', array (
				'label' => 'Create' 
		) );
		return $form;
	}
	public function createRoles() {
		$entity = new Roles ();
		$entity->setTranslatableLocale(self::EN);
		$options = array (
				'action' => $this->router->generate ( 'roles_create', array (), UrlGeneratorInterface::ABSOLUTE_PATH ),
				'method' => 'POST' 
		);
		$form = $this->createForm ( $this->formType, $entity, $options );
		$form->handleRequest ( $this->request );

		$role = $entity->getName();
		$role = $this->sanear_string($role);
		$role = strtoupper($role);
		$role = "ROLE_" . $role;
		$role = str_replace (" ","_",$role);
		$entity->setRole($role);
		
		$arr = $this->request->request->get ( 'softclear_usermanager_modules' );
		if (! is_array ( $arr ) || sizeof ( $arr ) < 0) {
			$form->addError ( new FormError ( $this->translator->trans('form_error.roles.choose_permission', array(), 'form_error')) );
		}
		
		if ($this->validateExistence ( $role )) {
			$entityExists = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findOneBy(array('role' => $role));
			$entityExists->setTranslatableLocale(self::EN);
			// validar si está borrada logicamente
			if ($entityExists->getDeleted ()) {
				$repo = $this->entityManager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
				$entityExists->setName($entity->getName());
				$repo->translate($entityExists, "name", self::ES, $entity->getName());
				$entityExists->setDescription($entity->getDescription());
				$repo->translate($entityExists, "description", self::ES, $entity->getDescription());
				$entity = $entityExists;
				$entity->setDeleted ( false );
				$form = $this->createForm ( $this->formType, $entity, $options );
				$form->handleRequest ( $this->request );
			}else{
				$form->addError ( new FormError ( $this->translator->trans('form_error.roles.name_exists', array(), 'form_error')) );				
			}

		} else {
			$repo = $this->entityManager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
			$repo->translate($entity, "name", self::ES, $entity->getName());
			$repo->translate($entity, "description", self::ES, $entity->getDescription());
			
			$this->entityManager->persist ( $entity );
		}
		
		if ($form->isValid ()) {
			$this->entityManager->flush ();
			$this->assignPermissionsToRole ( $role, true );
			
			return $form->getData ();
		}
		$modules = $this->processRequestPermissions();

		return array (

				'modules' => $modules,
				'entity' => $entity,
				'form' => $form->createView () 
		);
	}
	public function validateExistence($role) {
		return $this->entityManager->getRepository ( 'EscuelaUserManagerBundle:Roles' )->existsValueUnique ( 'role', $role );
	}
	public function showRoles($id) {
		$entity = $this->entityManager->getRepository ( 'EscuelaUserManagerBundle:Roles' )->find ( $id );

		$repo = $this->entityManager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
			
		$t = $repo->findTranslations($entity);
		$entity->setName($t[$this->request->getLocale()]["name"]);
		$entity->setDescription($t[$this->request->getLocale()]["description"]);

		
		
        if (! $entity) {
			return array('name'=> $id, 'message_id' => 'flash.role.warning.role_not_found');
		}
		
		$modules = $this->getModulesAndPermissions ( $entity->getRole () );
		return array (
				'modules'=>$modules,
				'entity' => $entity 
		);
	}
	public function editRoles($id) {
		$entity = $this->entityManager->getRepository ( 'EscuelaUserManagerBundle:Roles' )->find ( $id );
		
		$repo = $this->entityManager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
			
		$t = $repo->findTranslations($entity);
		$entity->setName($t[$this->request->getLocale()]["name"]);
		$entity->setDescription($t[$this->request->getLocale()]["description"]);
		
		if (! $entity) {
			// throw new NotFoundHttpException ( 'Unable to find Roles entity.' );
			return array('name'=> $id, 'message_id' => 'flash.role.warning.role_not_found');
		}
		
		$modules = $this->getModulesAndPermissions ( $entity->getRole () );
		
		$editForm = $this->createEditForm ( $entity );
		
		return array (
				'modules' => $modules,
				'entity' => $entity,
				'edit_form' => $editForm->createView () 
		);
	}
	public function createEditForm($entity) {
		$options = array (
				'action' => $this->router->generate ( 'roles_update', array (
						'id' => $entity->getId () 
				), UrlGeneratorInterface::ABSOLUTE_PATH ),
				'method' => 'PUT' 
		);
		$form = $this->formFactory->create ( $this->formType, $entity, $options );
		$form->add('deleteall_btn', 'button');	
		$form->add ( 'submit', 'submit', array ('label' => 'Update') );
		return $form;
	}
	public function updateRoles($id) {
		$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->find($id);
		if (!$entity) {
			throw new NotFoundHttpException('Unable to find Roles entity.');
		}
		
		$oldRoleName = $entity->getName();
		$oldRoleNameSaneado = strtoupper($this->sanear_string($oldRoleName));
		
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($this->request);
		
		$newRoleName = $entity->getName();
		$newRoleNameSaneado = strtoupper($this->sanear_string($newRoleName));
		
		$role = $entity->getName();
		$role = $this->sanear_string($role);
		$role = strtoupper($role);
		$role = "ROLE_" . $role;
		$role = str_replace (" ","_",$role);
		
		if (($oldRoleNameSaneado != $newRoleNameSaneado) && $this->validateExistence($role)) {
			$editForm->addError ( new FormError ( $this->translator->trans('form_error.roles.name_exists', array(), 'form_error')) );
		}
		
		$arr = $this->request->request->get('softclear_usermanager_modules');
		if (!is_array($arr)) {
			$editForm->addError ( new FormError ( $this->translator->trans('form_error.roles.choose_permission', array(), 'form_error')) );
		}
		
		if ($editForm->isValid()) {
			$entity->setTranslatableLocale($this->request->getLocale());
			$entity->setRole($role);
			$this->entityManager->flush();
			
			$this->assignPermissionsToRole($role);
			
			return $editForm->getData();
		}
		$modules = $this->processRequestPermissions();
		
		return array (
				
				'modules' => $modules,
				'entity' => $entity,
				'edit_form' => $editForm->createView () 
		);
	}
	public function listRoles($page=null) {
		
		$query = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findAllActiveByQueryBuilder();
		//var_dump($query); exit;
		$entities = $this->pager->paginate($query,$this->request->query->get('page', $page),self::PER_PAGE);
		
		$repo = $this->entityManager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
		foreach ($entities as $key=>$entity){
			
			$t = $repo->findTranslations($entity);
			$entity->setName($t[$this->request->getLocale()]["name"]);
			$entity->setDescription($t[$this->request->getLocale()]["description"]);
			$entities [$key]=$entity;
		}

        $listForm = $this->createListForm();
		return array (
				'list_form' => $listForm->createView (),
				'phrase' => "",
				'entities' => $entities 
		);
	}
	public function deleteRoles($id) {
		$entity = $this->entityManager->getRepository ( 'EscuelaUserManagerBundle:Roles' )->find ( $id );
		if (! $entity) {
			// throw new NotFoundHttpException ( 'Unable to find Roles entity.' );
			return array('error'=>true, 'name'=> $id, 'message_id' => 'flash.role.warning.role_not_found');
		}
		
		// validar que no tenga usuarios asociados y activos
		$userid = $entity->getUserid();		
		if (count($userid) > 0) {
			// throw new RuntimeException ( 'Unable to delete Roles entity.' );
			return array('error'=>true, 'name'=> $entity->getName(),  'message_id' => 'flash.role.warning.user_linked');
		}
		
		$entity->setDeleted (true);
		$this->entityManager->flush();
		
		return $entity;
	}
	private function assignPermissionsToRole($role, $isNew = false) {
		$arr = $this->request->request->get ( 'softclear_usermanager_modules' );
		
		$entities = $this->entityManager->getRepository ( 'EscuelaUserManagerBundle:ModuleClass' )->findAll ();
		
		foreach ( $entities as $entity ) {
			if (! array_key_exists ( strtolower ( $entity->getServiceclass () ), $arr )) {
				// Eliminar ACEs y ACL sino esta seleccionado ningun permiso a un objeto//
				try {
					$acl = $this->aclService->getAcl ( $entity->getServiceid (), array (
							$this->aclService->getSecurityId ( $role ) 
					) );
					
					foreach ( $acl->getClassAces () as $index => $ace ) {
						if ($ace->getSecurityIdentity ()->equals ( $this->aclService->getSecurityId ( $role ) )) {
							
							$acl->deleteClassAce ( $index );
							
							break;
						}
					}
					
					$this->aclService->updateAcl ( $acl ); // Update ACL
				} catch ( AclNotFoundException $e ) {
					continue;
				}
			}
			
			if (array_key_exists ( strtolower ( $entity->getServiceclass () ), $arr )) {
				// Obtengo la mascara de bits
				$v = $arr [strtolower ( $entity->getServiceclass () )];
				$build = new MaskBuilder ();
				foreach ( $v as $bit ) {
					$build->add ( intval ( $bit ) );
				}
				
				$mask = $build->get ();
				
				if ($isNew) {
					try {
						
						$acl = $this->aclService->getAcl ( $entity->getServiceid (), array (
								$this->aclService->getSecurityId ( $role ) 
						) );
						
						$acl->insertClassAce ( $this->aclService->getSecurityId ( $role ), $mask );
						
						$this->aclService->updateAcl ( $acl );
					} catch ( AclNotFoundException $e ) {
						
						$this->aclService->create ( $role, $entity->getServiceid (), $mask ); // Create ACL al crear usuario
					}
				} else {
					
					// Si hay acl, hacer update sino create
					try {
						
						$acl = $this->aclService->getAcl ( $entity->getServiceid (), array (
								$this->aclService->getSecurityId ( $role ) 
						) ); // Obtengo acl
						                                                            // print_r($acl->getObjectAces()); die;
						if (sizeof ( $acl->getClassAces () ) > 0) {
							$y = 0;
							foreach ( $acl->getClassAces () as $index => $ace ) 							// recorro los ACE del ACL
							{
								if ($ace->getSecurityIdentity ()->equals ( $this->aclService->getSecurityId ( $role ) )) { // Si coincide con el rol hace update
									
									$acl->updateClassAce ( $index, $mask );
									$y ++;
									break;
								}
							}
							
							if ($y == 0) {
								$acl->insertClassAce ( $this->aclService->getSecurityId ( $role ), $mask );
							}
							
							$this->aclService->updateAcl ( $acl );
						} else {
							$acl->insertClassAce ( $this->aclService->getSecurityId ( $role ), $mask );
							$this->aclService->updateAcl ( $acl );
						}
					} catch ( AclNotFoundException $e ) {
						$this->aclService->create ( $role, $entity->getServiceid (), $mask ); // Create ACL al crear usuario
					}
				}
			}
		}
	}
	
	private function getModulesAndPermissions($role) {
		$modules = $this->entityManager->getRepository ( 'EscuelaUserManagerBundle:ModuleClass' )->findAll ();
		
		$modulesAndPermissions = array ();
		
		foreach ( $modules as $module ) {
			$mask = array ();
			try {
				
				$acl = $this->aclService->getAcl ( $module->getServiceid (), array (
						$this->aclService->getSecurityId ( $role ) 
				) );
				foreach ( $acl->getClassAces () as $index => $ace ) {
					if ($ace->getSecurityIdentity ()->equals ( $this->aclService->getSecurityId ( $role ) )) {
						
						$maskBuilder = new MaskBuilder ( $ace->getMask () );
						
						$pattern = '................................';
						$length = strlen ( $pattern );
						$bitmask = str_pad ( decbin ( $ace->getMask () ), $length, '0', STR_PAD_LEFT );
						
						for($i = $length - 1; $i >= 0; $i --) {
							if ('1' === $bitmask [$i]) {
								try {
									$mask [] = 1 << ($length - $i - 1);
									/*
									 * echo MaskBuilder::getCode(1 << ($length - $i - 1)); die; $pattern[$i] = self::getCode(1 << ($length - $i - 1));
									 */
								} catch ( \Exception $notPredefined ) {
									$pattern [$i] = self::ON;
								}
							}
						}
						
						// $mask = $maskBuilder->getPattern();
						
						break;
					}
				}

				$modulesAndPermissions [] = array (
						"module" => $module,
						"bitmask" => $mask 
				);
			} catch ( AclNotFoundException $e ) {
				$modulesAndPermissions [] = array (
						"module" => $module,
						"bitmask" => $mask 
				);
				continue;
			}
		}
		
		return $modulesAndPermissions;
	}
	
	private function processRequestPermissions()
	{
		$arr = $this->request->request->get ( 'softclear_usermanager_modules' );
		
		$entities = $this->entityManager->getRepository ( 'EscuelaUserManagerBundle:ModuleClass' )->findAll ();
		$modulesPerm= array();
		
		foreach ($entities as $module)
		{	
			if(count($arr)>0){
				if (array_key_exists ( strtolower ( $module->getServiceclass () ), $arr ))
				{
					$modulesPerm[] = array("module"=>$module,"bitmask"=>$arr[strtolower($module->getServiceclass ())]);
				}else{
					$modulesPerm[] = array("module"=>$module,"bitmask"=>array());
				}
			}else{
				$modulesPerm[] = array("module"=>$module,"bitmask"=>array());
			}
		}
		return $modulesPerm;
	}
	
	public function searchRoles($phrase, $page=null) {
		$criteriaArray = array('name'=>$phrase, 'description' => $phrase);
		$query = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findByCriteriaByQueryBuilder($criteriaArray);
		$entities = $this->pager->paginate($query, $this->request->query->get('page', $page), self::PER_PAGE);
		$listForm = $this->createListForm();
		return array (
				'list_form' => $listForm->createView (),
				'phrase' => $phrase,
				'entities' => $entities,
		);
	}

	public function createListForm() {
		$options = array (
				'action' => $this->router->generate ('roles_deletes', array(), UrlGeneratorInterface::ABSOLUTE_PATH ),
				'method' => 'POST'
		);
		$form = $this->formFactory->create ( new ListType(), null, $options );
		$form->add('deleteall_btn', 'button');
		$form->add ( 'submit', 'submit', array ('label' => 'Eliminar') );
		return $form;
	}
	
	public function deleteVariousRoles($page) {		
		$arr = $this->request->request->get("listelem");
		
		// Just to grab deleted items
		$deleted_items = array();
		if ($arr != null) {
			foreach ($arr as $id) {
	    		$deleted_items[]= $this->deleteRoles($id);
			}
		}
		$query = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findAllActiveByQueryBuilder();		
		$entities = $this->pager->paginate($query,$this->request->query->get('page', $page),self::PER_PAGE);

		$listForm = $this->createListForm();
		return array (
				'list_form' => $listForm->createView (),
				'phrase' => "",
				'entities' => $entities,
				'deleted_items' => $deleted_items
		);
	}
}