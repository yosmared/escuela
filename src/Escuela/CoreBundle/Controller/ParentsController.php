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
     * @Route("/list", name="parents_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EscuelaCoreBundle:Parents')->findAll();

        return array(
            'entities' => $entities,
        	'list_form'=>$this->createListForm()->createView(),
        	'service'=>'',
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
        $entity = new Parents();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('parents_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
     * @Route("/new", name="parents_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Parents();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Parents entity.
     *
     * @Route("/{id}", name="parents_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parents entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        	'service'=>''
        );
    }

    /**
     * Displays a form to edit an existing Parents entity.
     *
     * @Route("/{id}/edit", name="parents_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parents entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        	'service'=>''
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parents entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parents_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Parents entity.
     *
     * @Route("/{id}", name="parents_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EscuelaCoreBundle:Parents')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Parents entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('parents'));
    }

    /**
     * Creates a form to delete a Parents entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parents_delete', array('id' => $id)))
            ->setMethod('DELETE')
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
