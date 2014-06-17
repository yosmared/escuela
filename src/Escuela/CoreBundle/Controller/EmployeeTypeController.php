<?php

namespace Escuela\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Escuela\CoreBundle\Entity\EmployeeType;
use Escuela\CoreBundle\Form\EmployeeTypeType;

/**
 * EmployeeType controller.
 *
 * @Route("/employeetype")
 */
class EmployeeTypeController extends Controller
{

    /**
     * Lists all EmployeeType entities.
     *
     * @Route("/", name="employeetype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EscuelaCoreBundle:EmployeeType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new EmployeeType entity.
     *
     * @Route("/", name="employeetype_create")
     * @Method("POST")
     * @Template("EscuelaCoreBundle:EmployeeType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new EmployeeType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('employeetype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a EmployeeType entity.
    *
    * @param EmployeeType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(EmployeeType $entity)
    {
        $form = $this->createForm(new EmployeeTypeType(), $entity, array(
            'action' => $this->generateUrl('employeetype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EmployeeType entity.
     *
     * @Route("/new", name="employeetype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EmployeeType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EmployeeType entity.
     *
     * @Route("/{id}", name="employeetype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:EmployeeType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeeType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EmployeeType entity.
     *
     * @Route("/{id}/edit", name="employeetype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:EmployeeType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeeType entity.');
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
    * Creates a form to edit a EmployeeType entity.
    *
    * @param EmployeeType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EmployeeType $entity)
    {
        $form = $this->createForm(new EmployeeTypeType(), $entity, array(
            'action' => $this->generateUrl('employeetype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EmployeeType entity.
     *
     * @Route("/{id}", name="employeetype_update")
     * @Method("PUT")
     * @Template("EscuelaCoreBundle:EmployeeType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:EmployeeType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EmployeeType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('employeetype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EmployeeType entity.
     *
     * @Route("/{id}", name="employeetype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EscuelaCoreBundle:EmployeeType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EmployeeType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('employeetype'));
    }

    /**
     * Creates a form to delete a EmployeeType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('employeetype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
