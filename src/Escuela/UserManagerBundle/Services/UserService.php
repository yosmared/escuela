<?php
namespace Escuela\UserManagerBundle\Services;

use Escuela\UserManagerBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Role\Role;
use Escuela\UserManagerBundle\Entity\Roles;
use Doctrine\ORM\EntityRepository;
use Escuela\UserManagerBundle\Form\ListType;

use Doctrine\Common\Collections\Criteria;
use Escuela\UserManagerBundle\Entity\AnswersQuestionSecurity;
use Escuela\UserManagerBundle\Form\ValidateUsernameType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;


class UserService extends BaseService{
	
	protected $request;
	protected $formType;
	protected $formFactory;
	protected $router;
	protected $encoderFactory;

	
	public function setDependenciesInyectionUser(Request $request = null,
			FormFactory $formFactory,
			AbstractType $formType, 
			Router $router, 
			EncoderFactory $encoder, $gedmoListenerLoggable)
	{
		parent::setDependenciesInyection($request, $formFactory, $formType, $router);
		$this->encoderFactory = $encoder;
		$this->loggable = $gedmoListenerLoggable;
		
	}

	
	public function newUser()
	{
		$entity = new User();
		
		$options = array(
				'action' => $this->router->generate('user_create', array(), UrlGeneratorInterface::ABSOLUTE_PATH),
				'method' => 'POST',
		);
		
		$form = $this->createForm($this->formType, $entity,$options);
		$roles = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findAllActive();
		
		$answertext = '';

		return array(
			'roles' 			=> $roles,
            'entity' 			=> $entity,
            'form'   			=> $form->createView(),
            'answertext' 		=> $answertext
        );
	}
	
	public function createUser(){
		
		$entity = new User();
		
		$options = array(
            'action' => $this->router->generate('user_create', array(), UrlGeneratorInterface::ABSOLUTE_PATH),
            'method' => 'POST',
        );
		
		$form = $this->createForm($this->formType, $entity, $options);
		
		$form->handleRequest($this->request);
		
		// Validations		
		//Check if any Treatment is checked/set
		$arr = $this->request->request->get("softclear_usermanager_user");		
		if(!array_key_exists('rolesid', $arr)) {
			$transRoles = $this->translator->trans("user.roles.select",array(),"validators");
			$form->addError(new FormError($transRoles));
		}
				
		if($arr['answertext']=="") {
			$transAnswer = $this->translator->trans("user.enteranswer",array(),"validators");
			$form->addError(new FormError($transAnswer));
		}

		if ($form->isValid()) 
		{
			$user = $form->getData();
			$encoder = $this->encoderFactory->getEncoder($user);
			$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
			$user->setPassword($password);
			
			$this->entityManager->persist($user);
			$this->entityManager->flush();

			$this->saveAnswerSecurity($user->getQuestionSecurity(), $user, $arr['answertext']);
			
			$this->entityManager->flush();

			return $user;

		} else {
			$roles = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findAllActive();

			return array(
				'roles' 			=> $roles,
	            'entity' 			=> $entity,
	            'form'   			=> $form->createView(),
	            'answertext' 		=> $arr['answertext']
        	);
			
		}
		
	}
			
	public function showUser($id){
		
		$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->find($id);

		if (!$entity) {
			return array('name'=> $id, 'message_id' => 'flash.user.warning.not_found');
		}

		return array(
				'entity'     		=> $entity,
		);
	}

	public function listUser($page=null) {
		$query = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->findAllActiveByQueryBuilder();
		$entities = $this->pager->paginate($query,$this->request->query->get('page', $page),self::PER_PAGE);
		
		$listForm = $this->createListForm();
		return array (
				'list_form' => $listForm->createView (),
				'phrase' => "",
				'entities' => $entities,
		);
	}
	
	public function editUser($id){
		
		$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->find($id);

		if (!$entity) {
			return array('name'=> $id, 'message_id' => 'flash.user.warning.not_found');
		}

		$editForm = $this->createEditForm($entity);

		$roles = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findAllActive();

		//Creamos un criterio de busqueda
		$criteria = array('qsid'=>$entity->getQuestionSecurity()->getId(),'userid'=>$entity->getId());
		//Buscamos y obtenemos la respuesta secreta de acuerdo a ese criterio
		$answertext = $this->entityManager->getRepository('EscuelaUserManagerBundle:AnswersQuestionSecurity')->findOneBy($criteria);

		return array(
				'roles' 				 => $roles,
				'entity'      			 => $entity,
				'edit_form'   			 => $editForm->createView(),
				'answertext' 			 => $answertext->getAnswer()
		);
	}

	public function updateUser($id) {
			
		$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->find($id);
		$currentPassword = $entity->getPassword();
		
		if (!$entity) {
			throw new NotFoundHttpException('Unable to find User entity.');
		}

		$arr = $this->request->request->get("softclear_usermanager_user");
		$qsecurityRequest = $arr['questionsecurity'];
		$qsecurityEntity = $entity->getQuestionSecurity()->getId();
		
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($this->request);
		
		$transAnswer = $this->translator->trans("user.enteranswer",array(),"validators");
		$transRoles = $this->translator->trans("user.roles.select",array(),"validators");
		
		if(!key_exists('rolesid', $arr)){
			$editForm->addError(new FormError($transRoles));
		} 

		if(($qsecurityRequest != $qsecurityEntity) && $arr['answertext']==""){
			$editForm->addError(new FormError($transAnswer));
		}

		if ($editForm->isValid()) {

			$user = $editForm->getData();
			if($user->getPassword()!="") { 
				
				$encoder = $this->encoderFactory->getEncoder($user);
				$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
				$user->setPassword($password);
				
			} else {
				$user->setPassword($currentPassword);
			}
			
			$this->entityManager->flush($user);


			$question = $user->getQuestionSecurity();
			
			$criteria = array('qsid'=>$question->getId(),'userid'=>$user->getId());
			$answer = $this->entityManager->getRepository('EscuelaUserManagerBundle:AnswersQuestionSecurity')->findOneBy($criteria);
			
			if($answer instanceof AnswersQuestionSecurity){
				if($arr['answertext']!=""){
					$answer->setAnswer($arr['answertext']);
					$this->entityManager->flush($answer);
				}
			} else {
				
				$criteria = array('userid'=>$user->getId());
				$ans = $this->entityManager->getRepository('EscuelaUserManagerBundle:AnswersQuestionSecurity')->findBy($criteria);
				
				if($ans instanceof AnswersQuestionSecurity){
				
					$this->entityManager->remove($ans);
					$this->entityManager->flush();
				} else {
					foreach ($ans as $v){
						$this->entityManager->remove($v);
						$this->entityManager->flush();
					}
				}

				//se guarda la respuesta de seguridad a la pregunta de seguridad.
				$this->saveAnswerSecurity($question, $user, $arr['answertext']);

				$this->entityManager->flush();
			}

			return $user;
		}

		$roles = $this->entityManager->getRepository('EscuelaUserManagerBundle:Roles')->findAllActive();

		$criteria = array('qsid'=>$entity->getQuestionSecurity()->getId(),'userid'=>$entity->getId());
		$answertext = $this->entityManager->getRepository('EscuelaUserManagerBundle:AnswersQuestionSecurity')->findOneBy($criteria);

		return array(
				'roles' 			=> $roles,
				'entity'      		=> $entity,
				'edit_form'   		=> $editForm->createView(),
				'answertext' 		=> $answertext->getAnswer()
		);
	}
	
	public function deleteUser($id)
	{	
		$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->find($id);
		if (! $entity) {
			// throw new NotFoundHttpException ( 'Unable to find User entity.' );
			return array('error'=>true, 'name'=> $id, 'message_id' => 'flash.user.warning.not_found');
		}
		
		$entity->setDeleted(true);
		$this->entityManager->flush();
		
		return $entity;
	}
	
	public function createForm(AbstractType $type, $data, $options=array()){
		$form = $this->formFactory->create($type, $data, $options);
		$form->add('submit', 'submit', array('label' => 'Create'));
		
		return $form;
	}
	
	public function createDeleteForm($id){	
		$form = $this->formFactory->createBuilder()->setAction($this->router->generate('product_delete', array('id' => $id)),UrlGeneratorInterface::ABSOLUTE_PATH)
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
	
		return $form;
	}
	
	public function createEditForm($entity){
	
		$form = $this->formFactory->createBuilder($this->formType,$entity)->setAction(	$this->router->generate('user_update',array('id' => $entity->getId())),	UrlGeneratorInterface::ABSOLUTE_PATH)->setMethod('PUT')->getForm();
		
		$form->add(
					'username',					'text',
					array(
						'label'=>'Username',
						'read_only'=>true
					)
				);
		$form->add(
					'password',
					'repeated',
					array(
						'first_name'  	=> 'password',
						'second_name' 	=> 'confirm',
						'type'        	=> 'password',
						'required'		=> false
					)
				);
		$form->add(
					'questionsecurity',
					'entity',
					array(
						'class'		=> 'EscuelaUserManagerBundle:QuestionSecurity',
						'property'	=> 'question',
						'expanded'	=> false,
						'multiple'	=> false,
				//'empty_value'=>'select.empty.value','translation_domain' => 'validators'
					)
				);
		$form->add(
					'answertext',
					'password',
					array(
						'label'		=> 'Answers',
						'mapped'	=> false,
						'required'	=> false
					)
				);

		$form->add('submit', 'submit', array('label' => 'Update'));
	
		return $form;
	}
	
	public function setEnabledUser($id, $boolean=true)
	{
		$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->find($id);
		
		if (!$entity) {
			// throw new NotFoundHttpException('Unable to find User entity.');
			return array('name'=> $id, 'message_id' => 'flash.user.warning.not_found');
		}
		$entity->setEnabled($boolean);
		$this->entityManager->flush();
		
		return $entity;
	}
	
	public function addRoles($userid,Array $roles)
	{
		$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->find($userid);
		
		if (!$entity) {
			throw new NotFoundHttpException('Unable to find User entity.');
		}
		
		foreach ($roles as $role){
			$entity->addRolesid($roles);
		}
		
		$this->entityManager->flush();
		
		return $entity;
	}
	
	public function searchUser($phrase, $page=null) {
		$criteriaArray = array('username'=>$phrase, 'name' => $phrase, 'lastname' => $phrase);
		$query = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->findByCriteriaByQueryBuilder($criteriaArray);
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
				'action' => $this->router->generate ('user_deletes', array(), UrlGeneratorInterface::ABSOLUTE_PATH ),
				'method' => 'POST'
		);
		$form = $this->formFactory->create ( new ListType(), null, $options );
		$form->add('deleteall_btn', 'button');	
		$form->add ( 'submit', 'submit', array (
				'label' => 'Eliminar'
		) );
		return $form;
	}	
	
	
	public function deleteVariousUsers($page) {		
		$arr = $this->request->request->get("listelem");

		// Just to grab deleted items
		$deleted_items = array();
		if ($arr != null) {
			foreach ($arr as $id) {
	    		$deleted_items[]= $this->deleteUser($id);
			}
		}

		$query = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->findAllActiveByQueryBuilder();		
		$entities = $this->pager->paginate($query,$this->request->query->get('page', $page),self::PER_PAGE);
		
		$listForm = $this->createListForm();
		return array (
				'list_form' => $listForm->createView (),
				'phrase' => "",
				'entities' => $entities,
				'deleted_items' => $deleted_items 
		);
	}
	
	public function showFormUsername(){
		
		$form = $this->formFactory->createBuilder()->setAction($this->router->generate('user_validate_username', array()),UrlGeneratorInterface::ABSOLUTE_PATH)
            ->setMethod('POST')
        ->add('username', 'text',array('required'=>true))
        ->getForm();		
		
		return array(				
				'form'   => $form->createView(),
		);
		
	}
	
	public function validateUsername($validator)
	{

		$form = $this->formFactory->createBuilder()->setAction($this->router->generate('user_validate_username', array()),UrlGeneratorInterface::ABSOLUTE_PATH)
            ->setMethod('POST')
        ->add('username', 'text',array('required'=>true))
        ->getForm();
		
		$form->handleRequest($this->request);
		$data = $this->request->request->get('form');
		//Validadores
		$field = "username";
		$this->groupValidatorRecover($form, $data, $validator, $field);
		
		if($form->isValid()){
			$data = $form->getData();
			$criteria = array('username'=>$data['username']);
			$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->findOneBy($criteria);
			if (!$entity) {
				$trans = $this->translator->trans("user.notexist",array(),"validators");
				$form->addError(new FormError($trans));
				return array(

	            'form'   => $form->createView(),
        		);
			}
			
			return $entity;
		}else {
			
			return array(
	            'form'   => $form->createView(),
        	);
			
		}
	}
	
	
	private function groupValidatorRecover($form, $data,$validator,$field)
	{
		
		if($field=="username")
		{
		
			$notBlank= new NotBlank(array('message'=>'user.username.not_blank'));
			
			$regex= new Regex(array('message'=>'user.username.regex','pattern'=>'/^[a-zA-Z]((\.|_|-)?[a-zA-Z0-9]+){4}$/Di'));
			
			$length= new Length(array('maxMessage'=>'user.username.max','max'=>20));
			
		}else{
			$notBlank= new NotBlank(array('message'=>'recover.qsecurity.not_blank'));
				
			$regex= new Regex(array('message'=>'recover.qsecurity.regex','pattern'=>'/^[a-zA-Z]((\.|_|-)?[a-zA-Z0-9]+){4}$/Di'));
				
			$length= new Length(array('maxMessage'=>'recover.qsecurity.max','max'=>20));
		}
		
		//Codigo de evaluacion
		$errors = $validator->validateValue($data,$notBlank);
		if(count($errors)>0)
		{
			$form->addError(new FormError($errors[0]->getMessage()));
		}
		
		$errors = $validator->validateValue($data[$field],$regex);
		if(count($errors)>0)
		{
			$form->addError(new FormError($errors[0]->getMessage()));
		}
		
		$errors = $validator->validateValue($data[$field],$length);
		if(count($errors)>0)
		{
			$form->addError(new FormError($errors[0]->getMessage()));
		}
		
		return $form;
		
	} 
	public function validateQuestionSecurity($validator)
	{
		
		$form = $this->formFactory->createBuilder()->setAction($this->router->generate('user_validate_question_security', array()),UrlGeneratorInterface::ABSOLUTE_PATH)
		->setMethod('POST')
		->add('answer', 'text',array('required'=>true))
		->add('id','hidden')
		->add('uid','hidden')
		->getForm();
		
		$form->handleRequest($this->request);
		$qsname = $this->request->getSession()->get('qsname');
		
		$data = $this->request->request->get('form');
		//Validadores
		$field = "answer";
		
		$this->groupValidatorRecover($form, $data, $validator, $field);
		
		
		if($form->isValid()){
			$data = $form->getData();
			$criteria = array('answertext'=>$data['answer'],'qsid'=>$data['id'],'userid'=>$data['uid']);
			$entity = $this->entityManager->getRepository('EscuelaUserManagerBundle:AnswersQuestionSecurity')->findOneBy($criteria);
			if (!$entity) {
				$transAnswer = $this->translator->trans("user.answernotmatch",array(),"validators");
				$form->addError(new FormError($transAnswer));
				return array(
						'qsname'=>$qsname,
						'form'   => $form->createView(),
				);
			}

			$this->request->getSession()->remove('qsid');
			$this->request->getSession()->remove('qsname');
			$this->request->getSession()->remove('uid');
			
			return $entity;
		}else {
				
			return array(
					'qsname'=>$qsname,
					'form'   => $form->createView(),
			);
				
		}
	}
	
	public function assignNewPassword($validator){
		
		$form = $this->formFactory->createBuilder()->setAction($this->router->generate('user_setpassword', array()),UrlGeneratorInterface::ABSOLUTE_PATH)
		->setMethod('POST')
		->add('password', 'repeated', array(
            		'first_name'  => 'password',
            		'second_name' => 'confirm',
            		'type'        => 'password',
            ))
		->add('uid','hidden')->getForm();
		
		$form->handleRequest($this->request);
		
		$data = $this->request->request->get('form'); //print_r($data); die;
		//Validadores
		if(trim($data["password"]["password"])=="" && trim($data["password"]["confirm"])=="" ){
			$trans = $this->translator->trans("recover.password.not_blank",array(),"validators");
			$form->addError(new FormError($trans));
		}

		if($form->isValid()){
			
			$data = $form->getData();
			$user = $this->entityManager->getRepository('EscuelaUserManagerBundle:User')->find($data['uid']);
			
			$this->loggable->setUsername($user->getUsername());
			$encoder = $this->encoderFactory->getEncoder($user);
			$password = $encoder->encodePassword($data['password'], $user->getSalt());
			$user->setPassword($password);
				
			$this->entityManager->flush();
			
				
			return $user;
		}else {
				
			return array(
					'form'   => $form->createView(),
			);
				
		}
		
	}
	
	private function groupValidatorPasswordReset($form, $data,$validator)
	{
	
		$notBlank= new NotBlank(array('message'=>'user.username.not_blank'));

		//Codigo de evaluacion
		$errors = $validator->validateValue($data,$notBlank);
		if(count($errors)>0)
		{
			$form->addError(new FormError($errors[0]->getMessage()));
		}
	
		return $form;	
	}

	/**
	* Funcion que guarda la respuesta secreta a la pregunta de seguridad
	*
	* @author Manuel Migueles (mmigueles@softclear.net)
	* @param \Escuela\SoftOdontoBundle\Entity\QuestionSecurity $questionSecurity
	* @param \Escuela\SoftOdontoBundle\Entity\User $user
	* @param string $answer	
	* @param boolean $flush
	**/
	private function saveAnswerSecurity($questionSecurity, $user, $answer, $flush=false) {
		$ans = new AnswersQuestionSecurity();
		$ans->setQuestionSecurity($questionSecurity);
		$ans->setUserid($user);
		$ans->setAnswer($answer);

		$this->entityManager->persist($ans);

		if ($flush) {
			$this->entityManager->flush();
		}
	}

}