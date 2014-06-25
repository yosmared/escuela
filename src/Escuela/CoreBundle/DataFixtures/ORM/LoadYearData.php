<?php
namespace Escuela\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Escuela\CoreBundle\Entity\SchoolYear;



class LoadYearData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
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
		
		$y = date('Y');
		$until = ($y+100);
		$x=0;
		for($i=$y;$i<$until;$i++){
					
			$year = new SchoolYear();
			
			$year->setYear($i);
			if($x==0){
				$year->setCurrent(true);	
			}else{
				$year->setCurrent(false);
			}
			
			$x++;
			
			$em->persist($year);
			$em->flush();
			
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 14;
	}
	
	
	
}