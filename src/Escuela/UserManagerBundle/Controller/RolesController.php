<?php
namespace Escuela\UserManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Escuela\UserManagerBundle\Entity\Roles;
use Escuela\UserManagerBundle\Form\RolesType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Util\ClassUtils;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

/**
 * Roles controller.
 *
 * @Route("/admin/role")
 */
class RolesController extends BaseController
{
	/**
	 * Displays a form to create a new Roles entity.
	 *
	 * @Route("/new", name="roles_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('CREATE',$service)) {
			return  $service->newRoles();
		}
	}

	/**
	 * Creates a new Role entity
	 * 
	 * @Route("/", name="roles_create")
	 * @Method("POST")
	 * @Template("EscuelaUserManagerBundle:Roles:new.html.twig")
	 */
	public function createAction() 
	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('CREATE',$service)) {
			$rs = $service->createRoles();
			if($rs instanceof Roles) {
				$name= $rs->getName();
				$translated = $this->translate('flash.role.success.save',array('%name%' => $name), 'flash');
				$this->get('session')->getFlashBag()->add('success', $translated);
				return $this->redirect($this->generateUrl('roles_show', array('id' => $rs->getId())));
			} else {
				return $rs;
			}
		}
	}

	/**
	 * Shows a Role details
	 * 
	 * @Route("/show/{id}", name="roles_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('VIEW',$service)) {
			$rs= $service->showRoles($id);

			// If there is not entities shows flash error
			if( !array_key_exists('entity', $rs) )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$this->get('session')->getFlashBag()->add('warning', $translated);
				return $this->redirect($this->generateUrl('roles_list'));
			}

			return array('entity'=>$rs['entity'],'modules'=>$rs['modules'], 'service'=>$service);
		}
	}

	/**
	 * Displays a list of all existing entities.
	 *
	 * @Route("/list/{page}", name="roles_list", defaults={"page"=1})
	 * @Method("GET")
	 * @Template()
	 */
	public function listAction($page=null)
	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('VIEW',$service) || $this->isGranted('EDIT',$service) || $this->isGranted('CREATE',$service)|| $this->isGranted('DELETE',$service)) {
			$list= $service->listRoles($page);
			// Set the first page if there's nothing to show
			if(count($list['entities']) == 0){
				$page=1;
				// Do the query again with the first page
				$list= $service->listRoles($page);	
			}
			
			$list['service']=$service;

			return  $list;
		}
	}

	/**
	 * Displays a form to edit a Role entity.
	 *
	 * @Route("/edit/{id}", name="roles_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('EDIT',$service)) {
			$rs= $service->editRoles($id);

			// If there is not entities shows flash error
			if( !array_key_exists('entity', $rs)  )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$this->get('session')->getFlashBag()->add('warning', $translated);
				return $this->redirect($this->generateUrl('roles_list'));
			}

			return  $rs;
		}
	}

	/**
	 * Updates a Roles entity.
	 *
	 * @Route("/update/{id}", name="roles_update")
	 * @Method("PUT")
	 * @Template("EscuelaUserManagerBundle:Roles:edit.html.twig")
	 */
	public function updateAction($id)
	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('EDIT',$service)) {
			$rs = $service->updateRoles($id);

			if($rs instanceof Roles)
			{	 
				$name= $rs->getName();
				$translated = $this->translate('flash.role.success.edit.save',array('%name%' => $name), 'flash');
				$this->get('session')->getFlashBag()->add('success', $translated);

				return $this->redirect($this->generateUrl('roles_show', array('id' => $id)));	 
			}else{
				return $rs;	 
			}
		}
	}

	/**
	 * Deletes a Role entity
	 *
	 * @Route("/delete/{id}/{page}", name="roles_delete", defaults={"page"=1})
	 * @Method("GET")
	 * @Template()
	 */
	public function deleteAction($id, $page)
	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('DELETE',$service)) {
			$rs= $service->deleteRoles($id);
			
			if( !($rs instanceof Roles) )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$msg_type= 'warning';
			}else 
			{
				$translated = $this->translate('flash.role.success.deleted',array('%name%' => $rs->getName()), 'flash');
				$msg_type= 'success';
			}
			$this->get('session')->getFlashBag()->add($msg_type, $translated);

			return $this->redirect($this->generateUrl('roles_list', array('page' => $page)));
		}
	}
	
	/**
	 * Displays a form to search entities.
	 *
	 * @Route("/search/{phrase}/{page}", name="roles_search", defaults={"page"=1})
	 * @Method({"GET", "POST"})
	 * @Template("EscuelaUserManagerBundle:Roles:list.html.twig")
	 */
	public function searchAction($phrase = null, $page=null)
	{
		$service = $this->get('escuela.usermanager.roles');
		
		$list = $service->searchRoles($phrase, $page);
		$list['service']=$service;
		return $list;
		
	}

	/**
	 * Deletes selected entities
	 *
	 * @Route("/deletes/{page}", name="roles_deletes", defaults={"page"=1})
	 * @Method({"GET", "POST"})
	 * @Template("EscuelaUserManagerBundle:Roles:list.html.twig")
	 */
	public function deleteVariousAction($page=null)
	{
		$service = $this->get('escuela.usermanager.roles');
		if($this->isGranted('DELETE',$service)) {
			$deleted_items = array();
			$list = $service->deleteVariousRoles($page);

			// Loop into deleted items and extract their names
			foreach ($list['deleted_items'] as $key => $item) {
				
				// Handle if there is any error in deletion process
				if(array_key_exists('error', $item))
				{
					$translated= $this->translate($item['message_id'], array('%name%' => $item['name']), 'flash');
					// If there is any error create a another flashbag to be the stacked
					$this->get('session')->getFlashBag()->add('warning', $translated);					
				}
				else
				{
					// If there is no error, extract item name to be shown
					$deleted_items[]= $item->getName();
				}

			}

			// Show success flash if there any is deleted elements
			if(count($deleted_items) > 0)
			{
				$deleted_items_string= implode(', ', $deleted_items);
				$translated= $this->translateChoice('flash.roles.success.deletedall', count($deleted_items), array('%count%'=>count($deleted_items), '%name%' => $deleted_items_string), 'flash');
				$this->get('session')->getFlashBag()->add('success', $translated);				
			}

			$list['service']=$service;
			return $list;
		}
	}
}