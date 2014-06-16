<?php
namespace Escuela\UserManagerBundle\Services;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Exception\AclNotFoundException;
use Symfony\Component\Security\Core\Util\ClassUtils;

class AclService{
	
	
	protected $securityAcl;
	protected $container;
	
	
	public function setDependenciesInyection(ContainerInterface $container)
	{

		$this->container = $container;

	}
	
	public function create($role, $serviceid, $mask){
		
		$aclProvider = $this->container->get('security.acl.provider');
		$object = $this->container->get($serviceid);
		
		//$objectIdentity = ObjectIdentity::fromDomainObject($object);
		$objectIdentity = new  ObjectIdentity($object->getObjectIdentifier(),ClassUtils::getRealClass($object));
		
		$acl = $aclProvider->createAcl($objectIdentity);
		
		$roleSecurityIdentity = new RoleSecurityIdentity($role);
		
		// grant owner access
		$acl->insertClassAce($roleSecurityIdentity, $mask);
		$aclProvider->updateAcl($acl);

	}
	
	public function getAcl($serviceid,$sid)
	{
		
		$aclProvider = $this->container->get('security.acl.provider');
		$object = $this->container->get($serviceid);
		
		$objectIdentity = new  ObjectIdentity($object->getObjectIdentifier(),ClassUtils::getRealClass($object));
		
		try {
			
			$acl = $aclProvider->findAcl($objectIdentity,$sid);
			
		} catch (AclNotFoundException $e) {
			
			throw $e;
		}
		
	    return $acl;
	}
	
	
	public function getSecurityId($role){
		
		return new RoleSecurityIdentity($role);
		
	}
	public function updateAcl($acl){
		
		$aclProvider = $this->container->get('security.acl.provider');
		
		$aclProvider->updateAcl($acl);
	}
	
	public function deleteAcl($serviceid){
		
		$aclProvider = $this->container->get('security.acl.provider');
		$object = $this->container->get($serviceid);
		
		$objectIdentity = new  ObjectIdentity($object->getObjectIdentifier(),ClassUtils::getRealClass($object));
		
		$aclProvider->deleteAcl($objectIdentity);
		
	}

}