<?php
namespace Escuela\UserManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Util\ClassUtils;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

class DefaultController extends BaseController
{
	/**
	 * @Route("/", name="_usermanager_root")
	 * @Template()
	 */
	public function indexMasterAction(){
		
		//return $this->redirect($this->generateUrl('_usermanager_index'));
		return $this->forward('EscuelaUserManagerBundle:Default:index');
	}
	
	
	/**
	 * #@Route("/{_locale}", name="_usermanager_index")
	 * #@Template()
	 */
	
    public function indexAction($name='foo')
    {
    	 $user =  $this->getRequest()->getSession();
        return $this->render('EscuelaUserManagerBundle:Default:index.html.twig', array('name' => $user->getName()));
    }
   
}
