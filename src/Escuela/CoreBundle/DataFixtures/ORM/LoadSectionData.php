<?php
namespace Escuela\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Escuela\CoreBundle\Entity\Section;



class LoadSectionData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
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
		

		$sections = $this->getSections();
		
		foreach ($sections as $section){
			
			$s = new Section();
			$s->setName($section['name']);

			$em->persist($s);
			
			$em->flush();
		}
		
		//$sec = $modules = $manager->getRepository('EscuelaCoreBundle:Section')->findAll();
		//$this->addReference('sections', $sec);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 11;
	}
	
	public function getSections(){
		
		return array(1=>array('name'=>'A'),2=>array('name'=>'A'),3=>array('name'=>'A'));
		
	}
	
}