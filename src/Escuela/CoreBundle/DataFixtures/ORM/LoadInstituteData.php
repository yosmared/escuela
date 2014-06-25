<?php
namespace Escuela\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Escuela\CoreBundle\Entity\Institute;



class LoadInstitueData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
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
		
		$institute = new Institute();
		$institute->setId('1');
		$institute->setCodeSchool('OD05070702');
		$institute->setName('UNIDAD EDUCATIVA "DR. MANUEL SALVADOR GOMEZ"');
		$institute->setAddress('Calle Mariscal Sucre, Barrio Simón Bolívar, Caicara del Orinoco');
		$institute->setTelephone('02846667339');
		$institute->setMunicipality('CEDEÑO');
		$institute->setState('BOLIVAR');
		$institute->setNumberZone('02');
		
		$em->persist($institute);
		$em->flush();
		
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 15;
	}
	
	
	
}