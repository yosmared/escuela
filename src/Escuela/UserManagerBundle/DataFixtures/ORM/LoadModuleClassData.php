<?php
namespace Escuela\UserManagerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Escuela\UserManagerBundle\Entity\ModuleClass;

use Gedmo\Translatable\Entity;


class LoadModuleClassData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
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
		

		$arrayModules = $this->getModulesClass();
		$transRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
		
		foreach ($arrayModules as $modules){
			
			$module = new ModuleClass();
			$module->setModulename($modules["en_US"]["modulename"]);
			$module->setServicename($modules["en_US"]["servicename"]);
			$module->setServiceclass($modules["en_US"]["serviceclass"]);
			$module->setServiceid($modules["en_US"]["serviceid"]);
			$module->setRoute($modules["en_US"]["route"]);
			$module->setOrder($modules["en_US"]["order"]);

			$transRepository->translate($module, "modulename", "es_ES", $modules["es_ES"]["modulename"])->translate($module, "servicename", "es_ES", $modules["es_ES"]["servicename"]);
			
			
			$em->persist($module);
			
			$em->flush();
		}

		
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		//return 1; // the order in which fixtures will be loaded
		return  2;
	}
	
	public function getModulesClass(){
		
		return array(1=>array("en_US"=>array("modulename"=>"Access","servicename"=>"Roles Management","serviceclass"=>"RolesService","serviceid"=>'escuela.usermanager.roles',"route"=>"roles_list","order"=>1),
						"es_ES"=>array("modulename"=>"Acceso","servicename"=>"Gestión de Roles")),
					2=>array("en_US"=>array("modulename"=>"Access","servicename"=>"User Management","serviceclass"=>"UserService","serviceid"=>"escuela.usermanager.user","route"=>"user_list","order"=>2),
						"es_ES"=>array("modulename"=>"Acceso","servicename"=>"Gestión de Usuarios")),
					
	
				);
		
	}
	
}