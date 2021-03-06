<?php
namespace Escuela\UserManagerBundle\Services;

use Symfony\Component\Security\Acl\Model\DomainObjectInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;



abstract class BaseService  implements DomainObjectInterface {
	
	protected $request;
	protected $formType;
	protected $formFactory;
	protected $entityManager;
	protected $router;
	protected $pager;
	protected $translator;
	
	const PER_PAGE = 10;
	
	public function __construct(EntityManager $entityManager, Paginator $paginator, Translator $translator){	
		$this->entityManager = $entityManager;
		$this->pager = $paginator;
		$this->translator =$translator;
	}
	
	public function setDependenciesInyection(Request $request = null, 
			FormFactory $formFactory, 
			AbstractType $formType, 
			Router $router) {
		$this->request = $request;
		$this->formFactory = $formFactory;
		$this->formType = $formType;
		$this->router = $router;
	}

	public function createForm(AbstractType $type, $data, $options = array()) {
		$form = $this->formFactory->create ( $type, $data, $options );
		$form->add ( 'submit', 'submit', array (
				'label' => 'Create' 
		) );
		return $form;
	}
	
	public function getObjectIdentifier()
	{
		$class = new \ReflectionClass($this);
		$classname = $class->getShortName();
	
		$criteria = array('serviceclass'=>$classname);
	
		$result = $this->entityManager->getRepository('EscuelaUserManagerBundle:ModuleClass')->findOneBy($criteria);
		return $result->getId();
	}
	
	/**
	 * Reemplaza todos los acentos por sus equivalentes sin ellos
	 *
	 * @param $string
	 *  string la cadena a sanear
	 *
	 * @return $string
	 *  string saneada
	 */
	function sanear_string($string)
	{
		$string = trim($string);
		$string = str_replace(
				array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
				array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
				$string
		);
		$string = str_replace(
				array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
				array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
				$string
		);
		$string = str_replace(
				array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
				array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
				$string
		);
		$string = str_replace(
				array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
				array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
				$string
		);
		$string = str_replace(
				array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
				array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
				$string
		);
		$string = str_replace(
				array('ñ', 'Ñ', 'ç', 'Ç'),
				array('n', 'N', 'c', 'C',),
				$string
		);
		//Esta parte se encarga de eliminar cualquier caracter extraño
		$string = str_replace(
				array("\\", "¨", "º", "-", "~",
						"#", "@", "|", "!", "\"",
						"·", "$", "%", "&", "/",
						"(", ")", "?", "'", "¡",
						"¿", "[", "^", "`", "]",
						"+", "}", "{", "¨", "´",
						">", "< ", ";", ",", ":",
						".", " "),
				'',
				$string
		);
		return $string;
	}
	
	public function getMyclassname(){
		
		$class = new \ReflectionClass($this);
		$classname = $class->getShortName();
		
		return $classname;
		
	}
}