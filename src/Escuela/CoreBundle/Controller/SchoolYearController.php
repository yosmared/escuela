<?php

namespace Escuela\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Escuela\CoreBundle\Entity\SchoolYear;
use Escuela\CoreBundle\Form\SchoolYearType;

/**
 * SchoolYear controller.
 *
 * @Route("/schoolyear")
 */
class SchoolYearController extends Controller
{

    /**
     * Lists all SchoolYear entities.
     *
     * @Route("/", name="schoolyear")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EscuelaCoreBundle:SchoolYear')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SchoolYear entity.
     *
     * @Route("/", name="schoolyear_create")
     * @Method("POST")
     * @Template("EscuelaCoreBundle:SchoolYear:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SchoolYear();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('schoolyear_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a SchoolYear entity.
    *
    * @param SchoolYear $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(SchoolYear $entity)
    {
        $form = $this->createForm(new SchoolYearType(), $entity, array(
            'action' => $this->generateUrl('schoolyear_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SchoolYear entity.
     *
     * @Route("/new", name="schoolyear_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SchoolYear();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SchoolYear entity.
     *
     * @Route("/{id}", name="schoolyear_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:SchoolYear')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SchoolYear entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SchoolYear entity.
     *
     * @Route("/{id}/edit", name="schoolyear_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:SchoolYear')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SchoolYear entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a SchoolYear entity.
    *
    * @param SchoolYear $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SchoolYear $entity)
    {
        $form = $this->createForm(new SchoolYearType(), $entity, array(
            'action' => $this->generateUrl('schoolyear_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SchoolYear entity.
     *
     * @Route("/{id}", name="schoolyear_update")
     * @Method("PUT")
     * @Template("EscuelaCoreBundle:SchoolYear:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:SchoolYear')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SchoolYear entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('schoolyear_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SchoolYear entity.
     *
     * @Route("/{id}", name="schoolyear_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EscuelaCoreBundle:SchoolYear')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SchoolYear entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('schoolyear'));
    }

    /**
     * Creates a form to delete a SchoolYear entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('schoolyear_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
