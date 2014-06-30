<?php

namespace Escuela\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Escuela\CoreBundle\Entity\Student;
use Escuela\CoreBundle\Entity\Score;
use Escuela\CoreBundle\Form\StudentType;
use Escuela\UserManagerBundle\Form\ListType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Escuela\CoreBundle\Form\ScoresType;

/**
 * Student controller.
 *
 * @Route("/student")
 */
class StudentController extends Controller
{

    /**
     * Lists all Student entities.
     *
     * @Route("/list/{page}", name="student_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($page=1)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EscuelaCoreBundle:Student')->findAll();

        return array(
            'entities' => $entities,
        	'list_form'=>$this->createListForm()->createView(),
        	'service'=>'',
        );
    }
    /**
     * Creates a new Student entity.
     *
     * @Route("/", name="student_create")
     * @Method("POST")
     * @Template("EscuelaCoreBundle:Student:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Student();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('student_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Student entity.
    *
    * @param Student $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Student $entity)
    {
        $form = $this->createForm(new StudentType(), $entity, array(
            'action' => $this->generateUrl('student_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Student entity.
     *
     * @Route("/new", name="student_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Student();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Student entity.
     *
     * @Route("/{id}", name="student_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        	'service'=>''
        );
    }

    /**
     * Displays a form to edit an existing Student entity.
     *
     * @Route("/{id}/edit", name="student_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
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
    * Creates a form to edit a Student entity.
    *
    * @param Student $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Student $entity)
    {
        $form = $this->createForm(new StudentType(), $entity, array(
            'action' => $this->generateUrl('student_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Student entity.
     *
     * @Route("/{id}", name="student_update")
     * @Method("PUT")
     * @Template("EscuelaCoreBundle:Student:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EscuelaCoreBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('student_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Student entity.
     *
     * @Route("/{id}", name="student_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EscuelaCoreBundle:Student')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Student entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('student'));
    }

    /**
     * Creates a form to delete a Student entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('student_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function createListForm() {
    	$options = array (
    			'action' => $this->generateUrl('student_deletes', array(), UrlGeneratorInterface::ABSOLUTE_PATH ),
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
     * @Route("/deletes/{page}", name="student_deletes", defaults={"page"=1})
     * @Method("DELETE")
     */
    public function deleteVariousAction(Request $request, $page)
    {
    	$form = $this->createDeleteForm($id);
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$entity = $em->getRepository('EscuelaCoreBundle:Student')->find($id);
    
    		if (!$entity) {
    			throw $this->createNotFoundException('Unable to find Student entity.');
    		}
    
    		$em->remove($entity);
    		$em->flush();
    	}
    
    	return $this->redirect($this->generateUrl('student'));
    }
    
    /**
     * Search a Student entity.
     *
     * @Route("/search/{phrase}/{page}", name="student_search", defaults={"page"=1})
     * @Method({"GET", "POST"})
     * @Template("EscuelaCoreBundle:Student:index.html.twig")
     */
    public function searchAction($phrase = null, $page=null){
    	
    	
    }
    
    /**
     * Get Notas.
     *
     * @Route("/score/{id}", name="student_notas")
     * @Method("GET")
     * @Template("EscuelaCoreBundle:Student:scores.html.twig")
     */
    public function getScoreForm($id){
    	
    	$score = $this->getScore($id);
    	$bool = false;

    	if(!$score instanceof Score){
    		
    		$score = new Score();
    		$bool=true;
    		
    	}
    	
    	$form = $this->createScoreForm($score,$bool,$id);
    	return array('form'=>$form->createView());
    	
    }
    
    /**
     * Creates a form to create a Student entity.
     *
     * @param Student $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createScoreForm(Score $entity,$create=true,$id=null)
    {
    	if($create){
    		
    		$form = $this->createForm(new ScoresType(), $entity, array(
    				'action' => $this->generateUrl('student_score_create',array('id'=>$id)),
    				'method' => 'POST',
    		));
    		
    		$form->add('submit', 'submit', array('label' => 'Create'));
    	}else{
    		$form = $this->createForm(new ScoresType(), $entity, array(
    				'action' => $this->generateUrl('student_score_update',array('id'=>$entity->getStudent()->getId())),
    				'method' => 'PUT',
    		));
    		
    		$form->add('submit', 'submit', array('label' => 'Guardar'));
    		
    		
    	}
    	
    
    	return $form;
    }
    
    /**
     * Creates a new Student entity.
     *
     * @Route("/{id}/score/save", name="student_score_create")
     * @Method("POST")
     * @Template("EscuelaCoreBundle:Student:new.html.twig")
     */
    public function saveScore(Request $request,$id){
    	
    	$score = new Score();
    	$bool = true;
    	
    	$em = $this->getDoctrine()->getManager();
    	$student = $em->getRepository('EscuelaCoreBundle:Student')->find($id);
    	$grade = $student->getGrade();
    	
    	$c=array('current'=>true);
    	$year = $em->getRepository('EscuelaCoreBundle:SchoolYear')->findOneBy($c);

    	$score->setStudent($student);
    	$score->setGrade($grade[0]);
    	$score->setSchoolYear($year);
    	
    	
    	$editForm = $this->createScoreForm($score,$bool,$id);
    	$editForm->handleRequest($request);
    	 
    	if ($editForm->isValid()) {
    		
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($score);
    		$em->flush();
    		 
    		return $this->redirect($this->generateUrl('student_notas', array('id' => $id)));
    	}
    	 
    	return array(
    			'entity' => $score,
    			'form'   => $editForm->createView(),
    	);
    	
    }
    
    /**
     * Creates a new Student entity.
     *
     * @Route("/{id}/score/update", name="student_score_update")
     * @Method("PUT")
     * @Template("EscuelaCoreBundle:Student:new.html.twig")
     */
    public function updateScore(Request $request,$id){

    	$score = $this->getScore($id);
    	$bool = false;
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$editForm = $this->createScoreForm($score,$bool);
    	$editForm->handleRequest($request);
    	
    	if ($editForm->isValid()) {
    		$em->flush();
    	
    		return $this->redirect($this->generateUrl('student_notas', array('id' => $id)));
    	}
    	
    	return array(
    			'entity' => $entity,
    			'form'   => $editForm->createView(),
    	);
    	 
    	 
    }
    
    public function getScore($id){
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$student = $em->getRepository('EscuelaCoreBundle:Student')->find($id);
    	
    	$grade = $student->getGrade();
    	
    	$c=array('current'=>true);
    	$year = $em->getRepository('EscuelaCoreBundle:SchoolYear')->findOneBy($c);
    	
    	$criteria= array('grade'=>$grade[0],'student'=>$student,'schoolYear'=>$year);
    	
    	return $em->getRepository('EscuelaCoreBundle:Score')->findOneBy($criteria);
    	
    }
    
    /**
     * Creates a new Student entity.
     *
     * @Route("/{id}/constancy", name="student_print")
     * @Method("GET")
     * @Template("EscuelaCoreBundle:Student:print.html.twig")
     */
    public function printAction($id){
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	
    	$student = $em->getRepository('EscuelaCoreBundle:Student')->find($id);
    	
    	$c=array('current'=>true);
    	$year = $em->getRepository('EscuelaCoreBundle:SchoolYear')->findOneBy($c);
    	
    	$y=array('director'=>true);
    	$director = $em->getRepository('EscuelaCoreBundle:Employee')->findOneBy($y);
    	
    	$ago = $this->calculateAgo(date('Y-m-d',$student->getBirthdate()->getTimestamp()));
    	
    	return array(
    			'director'=>$director,
    			'ago'=>$ago,
    			'year'=>$year,
    			'student'=>$student,
    	);
    }
    
    private function calculateAgo($fecha){
	    list($Y,$m,$d) = explode("-",$fecha);
	    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}
}
