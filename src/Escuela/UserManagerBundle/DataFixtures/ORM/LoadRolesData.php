<?php
namespace Escuela\UserManagerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;
use Escuela\UserManagerBundle\Entity\Roles;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;




class LoadRolesData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
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

		$roleEntity = new Roles();
        $roleEntity->setName('Administrator');
        $roleEntity->setDescription("Super User");
        $roleEntity->setRole("ROLE_ADMINISTRATOR");
        
        $transRepository->translate($roleEntity, "name", self::ES, "Administrador");
        $transRepository->translate($roleEntity, "description", self::ES, "Super Usuario");
        //$transRepository->translate($roleEntity, "name", self::ES, "Administrador");
        

        $manager->persist($roleEntity);
        
		$manager->flush();
		
		$role= $roleEntity->getRole();

		$aclService = $this->container->get('escuela.usermanager.acl');
		$modules = $manager->getRepository('EscuelaUserManagerBundle:ModuleClass')->findAll();
		
		
		$build = new MaskBuilder();
		$build->add ( intval ( '128') ); //OWNER
		$mask = $build->get();
		$this->cleanAcls();
		foreach ($modules as $module)
		{
			
				$aclService->create ( $role, $module->getServiceid (), $mask ); // Create ACL al crear usuario

		}
		
		$this->addReference('role-admin', $roleEntity);
		
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		//return 1; // the order in which fixtures will be loaded
		return  3;
	}
	
	public function cleanAcls(){
		
		$em = $this->container->get('doctrine.orm.entity_manager');
		
		$conn = $em->getConnection();
		$sql = "DELETE FROM acl_classes;
				DELETE FROM acl_entries;
				DELETE FROM acl_object_identities;
				DELETE FROM acl_object_identity_ancestors;
				DELETE FROM acl_security_identities;";
		
		$conn->query($sql);
		
	}
	
}