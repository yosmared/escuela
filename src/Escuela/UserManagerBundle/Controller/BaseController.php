<?php

namespace Escuela\UserManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Util\ClassUtils;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class BaseController extends Controller {
	
	public function isGranted($permission,$service){
	
		$object = $service;
	
		$objectIdentity = new  ObjectIdentity($object->getObjectIdentifier(),ClassUtils::getRealClass($object));
	
		$security = $this->get('security.context');
	
		if (false === $security->isGranted($permission,$objectIdentity)) {
			return false;
		}
	
		return true;
	}

	public function translate($subject, $params= array(), $domain=null){
		return $this->get('translator')->trans($subject, $params, $domain);
	}

	public function translateChoice($subject, $howmany, $params= array(), $domain=null){
		return $this->get('translator')->transChoice($subject, $howmany, $params, $domain);
	}
	
}