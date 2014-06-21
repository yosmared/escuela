<?php

namespace Escuela\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Escuela\CoreBundle\Entity\Parents;
use Escuela\CoreBundle\Form\ParentsType;
use Escuela\UserManagerBundle\Form\ListType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Parents controller.
 *
 * @Route("/parents")
 */
class ParentsController extends Controller
{

    /**
     * Lists all Parents entities.
     *
     * @Route("/list/{studentid}", name="parents_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($studentid)
    {	$em = $this->getDoctrine()->getManager();
    	if($studentid==null){

        	$entities = $em->getRepository('EscuelaCoreBundle:Parents')->findAll();
        
    	}else{
    		$criteria = array("id"=>$studentid);
    		$student = $em->getRepository('EscuelaCoreBundle:Student')->findOneBy($criteria);
    		$entities = $student->getParents();
    	}

        return array(
            'entities' => $entities,
        	'list_form'=>$this->createListForm()->createView(),
        	'service'=>'',
        	'studentid'=>$studentid
        );
    }
    

    
    
    
    /**
     * Creates a new Parents entity.
     *
     * @Route("/", name="parents_create")
     * @Method("POST")
     * @Template("EscuelaCoreBundle:Parents:new.html.twig")
     */
    public function createAction(Request $request)
    {
    	$parent =$request->request->get('escuela_corebundle_parents');
    	$studentid = $parent['studentid'];

        $entity = new Parents();
        $form = $this->createCreateForm($entity);
        $form->add('studentid','hidden',array('data'=>$studentid,'mapped'=>false));
        $form->handleRequest($request);
        
		
        if ($form->isValid()) {
        	
        	$em = $this->getDoctrine()->getManager();
 
            $em->persist($entity);
            $em->flush();
            
            $student = $em->getRepository('EscuelaCoreBundle:Student')->find($studentid); //var_dump($student); die;
             
            $student->addParent($entity);
            
            $em->flush($student);

            return $this->redirect($this->generateUrl('parents_show', array('id' => $entity->getId(),'studentid'=>$studentid)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'studentid'=>$studentid
        );
    }

    /**
    * Creates a form to create a Parents entity.
    *
    * @param Parents $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Parents $entity)
    {
        $form = $this->createForm(new ParentsType(), $entity, array(
            'action' => $this->generateUrl('parents_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Parents entity.
     *
     * @Route("/new/{studentid}", name="parents_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($studentid)
    {
        $entity = new Parents();
        $form   = $this->createCreateForm($entity);
		$form->add('studentid','hidden',array('data'=>$studentid,'mapped'=>false));
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'studentid'=>$studentid
        );
    }

    /**
     * Finds and displays a Parents entity.
     *
     * @Route("/{id}/show/{studentid}", name="parents_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id,$studentid)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parents entity.');
        }

        return array(
            'entity'      => $entity,
        	'service'=>'',
        	'studentid'=> $studentid
        );
    }

    /**
     * Displays a form to edit an existing Parents entity.
     *
     * @Route("/{id}/edit/{studentid}", name="parents_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id,$studentid)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parents entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->add('studentid','hidden',array('data'=>$studentid,'mapped'=>false));


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'service'=>'',
        	'studentid'=>$studentid
        );
    }

    /**
    * Creates a form to edit a Parents entity.
    *
    * @param Parents $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Parents $entity)
    {
        $form = $this->createForm(new ParentsType(), $entity, array(
            'action' => $this->generateUrl('parents_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Parents entity.
     *
     * @Route("/{id}", name="parents_update")
     * @Method("PUT")
     * @Template("EscuelaCoreBundle:Parents:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
    	$parent =$request->request->get('escuela_corebundle_parents');
    	$studentid = $parent['studentid'];
    	
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parents entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->add('studentid','hidden',array('data'=>$studentid,'mapped'=>false));
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parents_show', array('id' => $id,'studentid'=>$studentid)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'service'=>'',
        	'studentid'=>$studentid
        );
    }
    /**
     * Deletes a Parents entity.
     *
     * @Route("/{id}/delete/{studentid}", name="parents_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id, $studentid)
    {
       	 
    	
          $em = $this->getDoctrine()->getManager();
          $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);
			
           if (!$entity) {
                throw $this->createNotFoundException('Unable to find Parents entity.');
           }
           
           $student = $em->getRepository('EscuelaCoreBundle:Student')->find($studentid);
           $student->removeParent($entity);
           $em->flush($student);

           $em->remove($entity);
           $em->flush();
        

        return $this->redirect($this->generateUrl('parents_list',array('studentid'=>$studentid)));
    }

    /**
     * Creates a form to delete a Parents entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id,$studentid)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parents_delete', array('id' => $id,'studentid'=>$studentid)))
            ->setMethod('GET')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function createListForm() {
    	$options = array (
    			'action' => $this->generateUrl('parents_deletes', array(), UrlGeneratorInterface::ABSOLUTE_PATH ),
    			'method' => 'POST'
    	);
    	$form = $this->createForm ( new ListType(), null, $options );
    	$form->add('deleteall_btn', 'button');
    	$form->add ( 'submit', 'submit', array ('label' => 'Eliminar') );
    	return $form;
    }
    
    /**
     * Deletes a Student entity.
     *
     * @Route("/deletes/{page}", name="parents_deletes", defaults={"page"=1})
     * @Method("DELETE")
     */
    public function deleteVariousAction(Request $request, $page)
    {
    	$form = $this->createDeleteForm($id);
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);
    
    		if (!$entity) {
    			throw $this->createNotFoundException('Unable to find Student entity.');
    		}
    
    		$em->remove($entity);
    		$em->flush();
    	}
    
    	return $this->redirect($this->generateUrl('parents_list'));
    }
    
    /**
     * Search a Student entity.
     *
     * @Route("/search/{phrase}/{page}", name="parents_search", defaults={"page"=1})
     * @Method({"GET", "POST"})
     * @Template("EscuelaCoreBundle:Parents:index.html.twig")
     */
    public function searchAction($phrase = null, $page=null){
    	 
    	 
    }
}
