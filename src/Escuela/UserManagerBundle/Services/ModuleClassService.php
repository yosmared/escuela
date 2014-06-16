<?php
namespace Escuela\UserManagerBundle\Services;
use Doctrine\ORM\EntityManager;

class ModuleClassService extends BaseService{
	
	public function getAllItemsMenu(){
		
		$items = $this->entityManager->getRepository("EscuelaUserManagerBundle:ModuleClass")->findAll();
		
		return $items;
	}
	
	
}