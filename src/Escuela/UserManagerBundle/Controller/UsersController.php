<?php

namespace Escuela\UserManagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Escuela\UserManagerBundle\Entity\User;
use Escuela\UserManagerBundle\Form\UserType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Util\ClassUtils;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Escuela\UserManagerBundle\Entity\AnswersQuestionSecurity;


/**
 * User controller.
 *
 * @Route("/admin/user")
 */
class UsersController extends BaseController
{

	/**
	 * @Route("/login", name="usermanager_homepage")
	 * @Template()
	 */
	public function loginAction(Request $request)
	{

		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
		}

		if($request->getSession()->get('_security.last_username')!=""){
			$criteria = array("username"=>$request->getSession()->get('_security.last_username'));
			$entity = $this->getDoctrine()->getRepository('EscuelaUserManagerBundle:User')->findBy($criteria);
			
			if(!$entity){
				try{
				$error = new \Exception('userdontexist');
				}catch(Exception $e){
					$error = $e;
				}
			}
		}
		return $this->render('EscuelaUserManagerBundle:Users:login.html.twig', array(
            // el último nombre de usuario ingresado por el usuario
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
		
	}
	
	/**
	 * securityCheck.
	 *
	 * @Route("/login_check", name="_security_check")
	 * @Template()
	 */
	public function securityCheckAction(){
		
		// The security layer will intercept this request
		return true;
	}
	
	/**
	 * @Route("/logout", name="usermanager_logout")
	 */
	public function logoutAction()
	{
		// The security layer will intercept this request
	}
	
	
	/**
	 * Create a new User entity
	 * @Route("/", name="user_create")
	 * @Method("POST")
	 * @Template("EscuelaUserManagerBundle:Users:new.html.twig")
	 */
	public function createAction(){ 
		$service = $this->get('escuela.usermanager.user');
		if($this->isGranted('CREATE',$service)) {
			$rs = $service->createUser();
			if($rs instanceof User) {
				$name= $rs->getName()." ".$rs->getLastName();
				$translated = $this->translate('flash.user.success.save',array('%name%' => $name), 'flash');
				$this->get('session')->getFlashBag()->add('success', $translated);
				return $this->redirect($this->generateUrl('user_show', array('id' => $rs->getId())));
			} else {
                $rs['service']= $service;
				return $rs;
			}
		}
	}
	
	/**
	 * Displays a form to create a new Product entity.
	 *
	 * @Route("/new", name="user_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$service = $this->get('escuela.usermanager.user');
		if($this->isGranted('CREATE',$service)) {
			$new = $service->newUser();
            $new['service']=$service;
            return $new;
		}
	}
	
	/**
	 * @Route("/show/{id}", name="user_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{ 
		//con esto se obtiene el usuario autenticado
		$user = $this->get('security.context')->getToken()->getUser();

		$service = $this->get('escuela.usermanager.user');

		if(($this->isGranted('VIEW',$service)) OR ($user->getId() == $id)) {
			$rs= $service->showUser($id);

			// If there is not entities shows flash error
			if( !array_key_exists('entity', $rs)  )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$this->get('session')->getFlashBag()->add('warning', $translated);
				return $this->redirect($this->generateUrl('user_list'));
			}

			return array(
				'entity'			=> $rs['entity'],
				//'questionGroupList' => $rs['questionGroupList'],
				'service'			=> $service,
				'current_user'		=> $user->getId()
			);
		}
	}

	/**
	 * Displays a form to list entities.
	 *
	 * @Route("/list/{page}", name="user_list", defaults={"page"=1})
	 * @Method("GET")
	 * @Template()
	 */
	public function listAction($page)
	{
		$service = $this->get('escuela.usermanager.user');

		if($this->isGranted('VIEW',$service) || $this->isGranted('EDIT',$service) || $this->isGranted('CREATE',$service)|| $this->isGranted('DELETE',$service)) {
			$list= $service->listUser($page);
			// Set the first page if there's nothing to show
			if(count($list['entities']) == 0){
				$page=1;
				$list= $service->listUser($page);	
			}
			$list['service']=$service;
			return  $list;
		}
	}
	
	/**
	 * Displays a form to create a new Product entity.
	 *
	 * @Route("/edit/{id}", name="user_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		//con esto se obtiene el usuario autenticado
		$user = $this->get('security.context')->getToken()->getUser();

		$service = $this->get('escuela.usermanager.user');

		if($this->isGranted('EDIT',$service) OR ($user->getId() == $id)) {

			$rs= $service->editUser($id);

			// If there is not entities shows flash error
			if( !array_key_exists('entity', $rs)  )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$this->get('session')->getFlashBag()->add('warning', $translated);
				return $this->redirect($this->generateUrl('user_list'));
			}

			//le agrego la variable service al arreglo
			$rs['service'] = $service;

			return  $rs;
		}
	}
	
	/**
	 * Displays a form to create a new Product entity.
	 *
	 * @Route("/delete/{id}/{page}", name="user_delete", defaults={"page"=1})
	 * @Method("GET")
	 * @Template()
	 */
	public function deleteAction($id, $page)
	{
		$service = $this->get('escuela.usermanager.user');
		if($this->isGranted('DELETE',$service)) {

			$rs= $service->deleteUser($id);
			if( !($rs instanceof User) )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$msg_type= 'warning';
			} else {
				$translated = $this->translate('flash.user.success.deleted',array('%name%' => $rs->getName()." ".$rs->getLastName()), 'flash');
				$msg_type= 'success';
			}
			$this->get('session')->getFlashBag()->add($msg_type, $translated);
			
			return $this->redirect($this->generateUrl('user_list', array('page' => $page)));	
		}
	}
	
	/**
	 * Displays a form to create a new Product entity.
	 *
	 * @Route("/update/{id}", name="user_update")
	 * @Method("PUT")
	 * @Template("EscuelaUserManagerBundle:Users:edit.html.twig")
	 */
	public function updateAction($id)
	{
		//con esto se obtiene el usuario autenticado
		$user = $this->get('security.context')->getToken()->getUser();

		$service = $this->get('escuela.usermanager.user');

		if (($this->isGranted('EDIT',$service)) OR ($user->getId() == $id)) {
			$rs = $service->updateUser($id);
			
			if($rs instanceof User)
			{				
				$name= $rs->getName()." ".$rs->getLastName();
				$translated = $this->translate('flash.user.success.edit.save',array('%name%' => $name), 'flash');
				$this->get('session')->getFlashBag()->add('success', $translated);

        		return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
	        }else{
	        	$rs['service']= $service;
	        	return $rs;
	        }
		}
	}

	/**
	 * @Route("/active/{id}/{page}", name="user_active", defaults={"page"=1})
	 * @Method("GET")
	 * @Template()
	 */
	public function activeAction($id, $page)
	{
		$service = $this->get('escuela.usermanager.user');
		if($this->isGranted('EDIT',$service)) {
			$rs=$service->setEnabledUser($id);
			if( !($rs instanceof User) )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$msg_type= 'warning';
			}else 
			{
				$translated = $this->translate('flash.user.success.activated', array('%name%' => $rs->getName()." ".$rs->getLastName()), 'flash');
				$msg_type= 'success';
			}
			$this->get('session')->getFlashBag()->add($msg_type, $translated);

			return $this->redirect($this->generateUrl('user_list', array('page' => $page)));
		}
	}
	
	/**
	 *
	 *
	 * @Route("/inactive/{id}/{page}", name="user_inactive", defaults={"page"=1})
	 * @Method("GET")
	 * @Template()
	 */
	public function inactiveAction($id, $page)
	{
		$service = $this->get('escuela.usermanager.user');
		if($this->isGranted('EDIT',$service)) {
			$rs= $service->setEnabledUser($id,false);
			
			if( !($rs instanceof User) )
			{
				$translated= $this->translate($rs['message_id'], array('%name%' => $rs['name']), 'flash');
				$msg_type= 'warning';
			}else 
			{
				$translated = $this->translate('flash.user.success.deactivated', array('%name%' => $rs->getName()." ".$rs->getLastName()), 'flash');
				$msg_type= 'success';
			}
			$this->get('session')->getFlashBag()->add($msg_type, $translated);

			return $this->redirect($this->generateUrl('user_list', array('page' => $page)));
		}
	}

	/**
	 * Displays a form to search entities.
	 *
	 * @Route("/search/{phrase}/{page}", name="user_search", defaults={"page"=1})
	 * @Method({"GET", "POST"})
	 * @Template("EscuelaUserManagerBundle:Users:list.html.twig")
	 */
	public function searchAction($phrase = null, $page=null)
	{
		$service = $this->get('escuela.usermanager.user');
		if($this->isGranted('OWNER',$service)) {
			$list = $service->searchUser($phrase, $page);
			$list['service']=$service;
			return $list;
		}
	}

	/**
	 * Deletes selected entities
	 *
	 * @Route("/deletes/{page}", name="user_deletes", defaults={"page"=1})
	 * @Method({"GET", "POST"})
	 * @Template("EscuelaUserManagerBundle:Users:list.html.twig")
	 */
	public function deleteVariousAction($page=null)
	{
		$service = $this->get('escuela.usermanager.user');
		if($this->isGranted('DELETE',$service)) {
			$list = $service->deleteVariousUsers($page);

			// Loop into deleted items and extract their names
			$deleted_items= array();
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
				$translated= $this->translateChoice('flash.user.success.deletedall', count($deleted_items), array('%count%'=>count($deleted_items), '%name%' => $deleted_items_string), 'flash');
				$this->get('session')->getFlashBag()->add('success', $translated);				
			}

			$list['service']=$service;
			return $list;
		}
	}
	
	/**
	 * 
	 *
	 * @Route("/recover", name="user_forgotpassword")
	 * @Method("GET")
	 * @Template("EscuelaUserManagerBundle:Users:showform_username.html.twig")
	 */
	public function showFormUsernameAction(){
		
		$service = $this->get('escuela.usermanager.user');
		
		return  $service->showFormUsername();
		
	}
	
	/**
	 *
	 *
	 * @Route("/recover/validate", name="user_validate_username")
	 * @Method("POST")
	 * @Template("EscuelaUserManagerBundle:Users:showform_username.html.twig")
	 */
	public function validateUsernameAction()
	{
	
		$service = $this->get('escuela.usermanager.user');
		$validator = $this->get('validator');
			$rs = $service->validateUsername($validator);
			if($rs instanceof User) {

				$qs = $rs->getQuestionSecurity();
				if($qs!=''){
					
					$session = $this->getRequest()->getSession();
					$session->set('qsid', $qs->getId());
					$session->set('qsname', $qs->getQuestion());
					$session->set('uid', $rs->getId());
				}else{
					
					$this->get('session')->getFlashBag()->add('error', 'Error');
					
				}

				return $this->forward("EscuelaUserManagerBundle:Users:showQuestionSecurity");
			} else {
				return $rs;
			}
		
	}
	
	/**
	 *
	 *
	 * @Route("/recover/question", name="user_questionsecurity")
	 * @Method("GET")
	 * @Template("EscuelaUserManagerBundle:Users:show_questionsecurity.html.twig")
	 */
	public function showQuestionSecurityAction()
	{
		$session = $this->getRequest()->getSession();
		$qsid = $session->get('qsid');
		$qsname = $session->get('qsname');
		$uid = $session->get('uid');

		$session->remove('uid');
		$session->remove('qsid');
		$session->remove('qsname');
		
		$form = $this->createFormBuilder()->setAction($this->generateUrl('user_validate_question_security'))->setMethod('POST')
		->add('answer','password',array('required'=>true))
		->add('id','hidden',array('data'=>$qsid))
		->add('uid','hidden',array('data'=>$uid))->getForm();

		return array('qsname'=>$qsname,'form'=>$form->createView());
	}
	
	/**
	 *
	 *
	 * @Route("/recover/validate/question", name="user_validate_question_security")
	 * @Method("POST")
	 * @Template("EscuelaUserManagerBundle:Users:show_questionsecurity.html.twig")
	 */
	public function validateQuestionSecurityAction()
	{

		$service = $this->get('escuela.usermanager.user');
		$validator = $this->get('validator');
		$rs = $service->validateQuestionSecurity($validator); 
		if($rs instanceof AnswersQuestionSecurity) {

			$session = $this->getRequest()->getSession();
			$session->set('uid', $rs->getUserid()->getId());
			
			return $this->forward("EscuelaUserManagerBundle:Users:showResetPassword");
		} else {
			
			return $rs;
		}
		
	}
	
	/**
	 *
	 *
	 * @Route("/recover/reset", name="user_resetpassword")
	 * @Method("GET")
	 * @Template("EscuelaUserManagerBundle:Users:show_resetpassword.html.twig")
	 */
	public function showResetPasswordAction(){
		
		$session = $this->getRequest()->getSession();
		$uid = $session->get('uid');
		
		$session->remove('uid');
		
		$form = $this->createFormBuilder()->setAction($this->generateUrl('user_setpassword'))->setMethod('POST')
		->add('password', 'repeated', array(
            		'first_name'  => 'password',
            		'second_name' => 'confirm',
            		'type'        => 'password',
            ))
		->add('uid','hidden',array('data'=>$uid))->getForm();

		return array('form'=>$form->createView());
	}
	
	/**
	 *
	 *
	 * @Route("/recover/reset", name="user_setpassword")
	 * @Method("POST")
	 * @Template("EscuelaUserManagerBundle:Users:show_resetpassword.html.twig")
	 */
	public function resetPasswordAction()
	{
	
		$service = $this->get('escuela.usermanager.user');
		$validator = $this->get('validator');
		
		$rs = $service->assignNewPassword($validator);
		if($rs instanceof User) {
			$this->get('session')->getFlashBag()->add('success', 'flash.user.success.reset_password', 'flash');
			return $this->redirect($this->generateUrl('usermanager_homepage'),'301');
			
		} else {
			return $rs;
		}
	
	}
	
	/**
	 *
	 *
	 * @Route("/recover/cancel", name="recover_cancel")
	 * @Method("GET")
	 * @Template()
	 */
	public function cancelResetPasswordAction()
	{
		$session = $this->getRequest()->getSession();
		$session->remove('uid');
		$session->remove('qsid');
		$session->remove('qsname');
	
		return $this->redirect($this->generateUrl('usermanager_homepage'),'301');
		
	}
	
}