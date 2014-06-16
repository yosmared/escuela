<?php
namespace Escuela\UserManagerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Escuela\UserManagerBundle\Entity\QuestionSecurity;

use Gedmo\Translatable\Entity;



class LoadQuestionSecurityData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
	/**
	* @var ContainerInterface
	*/
	private $container;
	
	const ES = 'es_ES';
	const EN = 'en_US';
	
	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
	public function load(ObjectManager $manager){
		
		$transRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
		
		$id = 1;

		$em = $this->container->get('doctrine.orm.entity_manager');
		$questions = $this->getQuestionSecurity();
		$field = "question";
		foreach ($questions as $question){
			
			$entity = new QuestionSecurity();
			$entity->setQuestion($question[self::EN]);
			//$entity->setTranslatableLocale("en");
			// persisting multiple translations, assume default locale is ES
			
			$transRepository->translate($entity, $field, 'es_ES', $question[self::ES]);
			
			$em->persist($entity);

			$em->flush();
			
			
		}
		
		

		$q = $manager->getRepository('EscuelaUserManagerBundle:QuestionSecurity')->findOneBy(array());
		//var_dump($q->getId()); die;
		
		$this->addReference('question-security-admin', $q);//die;
		
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 1; // the order in which fixtures will be loaded
	}
	
	/**
	 * 
	 * @return multitype:multitype:string
	 */
	public function getQuestionSecurity(){
		
		return array(1=>array("es_ES"=>"¿Cuál es el segundo nombre de mi mamá?","en_US"=>"What is my mom's middle name?"),
			2=>array("es_ES"=>"¿Cuál es el nombre de mi primera mascota?","en_US"=>"What is the name of my first pet?"),
			3=>array("es_ES"=>"¿Que edad tiene mi hijo mayor?","en_US"=>"How old is my oldest son?"),
			4=>array("es_ES"=>"¿Fecha de nacimiento de su esposa?","en_US"=>"Your wife's date of birth?"));
		
	}
	
}