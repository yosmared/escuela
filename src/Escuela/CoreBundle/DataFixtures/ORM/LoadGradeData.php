<?php
namespace Escuela\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Escuela\CoreBundle\Entity\Grade;



class LoadGradeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
	/**
	* @var ContainerInterface
	*/
	private $container;
	
	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
	public function load(ObjectManager $manager){
		
		$em = $this->container->get('doctrine.orm.entity_manager');
		

		$sections = $manager->getRepository('EscuelaCoreBundle:Section')->findAll();
		
		$grades = $this->getGrades();
		
		foreach ($grades as $grade) {
			
			$g = new Grade();
			
			foreach ($sections as $section){
				
				$g->setName($grade['name']." ".$section->getName());
				
				$g->setSection($section);
	
				$em->persist($g);
				
				$em->flush();
			}
		}
		

	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 12;
	}
	
	public function getGrades(){
		
		return array(1=>array('name'=>'1º'),
					2=>array('name'=>'2º'),
				    3=>array('name'=>'3º'),4=>array('name'=>'4º'),
				5=>array('name'=>'5º'),6=>array('name'=>'6º'));
		
	}
	
}