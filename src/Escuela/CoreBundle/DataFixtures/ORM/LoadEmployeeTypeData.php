<?php
namespace Escuela\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Escuela\CoreBundle\Entity\EmployeeType;



class LoadEmployeeTypeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
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
		

		$employee = $this->getEmployeeType();
		
		foreach ($employee as $type){
			
			$etype = new EmployeeType();
			$etype->setName($type['name']);

			$em->persist($etype);
			
			$em->flush();
		}

		
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 10;
	}
	
	public function getEmployeeType(){
		
		return array(1=>array('name'=>'Docente'),2=>array('name'=>'Administrativo'),3=>array('name'=>'Obrero'));
		
	}
	
}