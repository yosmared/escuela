<?php
namespace Escuela\UserManagerBundle\Menu;

use Knp\Menu\FactoryInterface;

use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Util\ClassUtils;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Translation\Translator;

class Builder extends ContainerAware
{

	public function mainMenu(FactoryInterface $factory, array $options)
	{
		// Find out which entity is given a route
		$currentRoute= $this->container->get('request')->get('_route'); 
		$currentEntity= $this->entityExtractor($currentRoute);

		$repository = $this->container->get('doctrine.orm.default_entity_manager')->getRepository('EscuelaUserManagerBundle:ModuleClass');
		$modules = $repository->findBy(array(),array('order'=>'ASC'));
		$modulesName = array();
		
		$menu = $factory->createItem('root');
		$menu->setChildrenAttributes(array('class'=>'nav','id'=>'demo1'));

		$isActive= (empty($currentEntity) ? 'active' : false );
        $translatedHome= $this->container->get('translator')->trans("menu.home", array(), 'menu');

		// Home item
		$menu->addChild($translatedHome, array('route' => '_usermanager_root','attributes'=>array('class'=>$isActive)));

        foreach ($modules as $module){

            if($module->getOrder()>0){
                $service = $this->container->get($module->getServiceid());
                $objectIdentity = new  ObjectIdentity($service->getObjectIdentifier(),ClassUtils::getRealClass($service));
                $security = $this->container->get('security.context');

                $class = new \ReflectionClass($service);
                $classname = $class->getShortName();

                if (true === $security->isGranted(array('VIEW'),$objectIdentity)
                    ||true === $security->isGranted(array('CREATE'),$objectIdentity)||true === $security->isGranted(array('DELETE'),$objectIdentity)
                    ||true === $security->isGranted(array('EDIT'),$objectIdentity)) {


                    if(in_array($module->getModulename(), $modulesName)){
                        $menu[$module->getModulename()]->addChild($module->getServicename(), array('route' => $module->getRoute()))->setAttribute('divider_append', true);
                    }else{
                        $modulesName[]= $module->getModulename();
                        $menu->addChild($module->getModulename(),array('uri'=>'#'))->setAttributes(array('dropdown'=> true));
                        $menu[$module->getModulename()]->addChild($module->getServicename(), array('route' => $module->getRoute()))->setAttribute('divider_append', true);
                    }

                    // If entity is empty means that is the root item
                    if(!empty($currentEntity)){
                        $result= strpos($module->getRoute(), $currentEntity);
                    }else{
                        $result= false;
                    }

                    // Sets as open the parent menu item and active the child menu
                    if($result !== false){
                        $menu[$module->getModulename()]->setAttributes(array('dropdown'=> true,'class'=>'open'));
                        $menu[$module->getModulename()]->addChild($module->getServicename(), array( 'route' => $module->getRoute()))->setAttribute('divider_append', true)->setAttribute('class', 'active');
                    }else{
                        $menu[$module->getModulename()]->addChild($module->getServicename(), array( 'route' => $module->getRoute()))->setAttribute('divider_append', true);
                    }

                }
            }

        }
        return $menu;
	}

	public function entityExtractor($route){
		$entity = explode('_', $route);
		return $entity[0];
	}

}