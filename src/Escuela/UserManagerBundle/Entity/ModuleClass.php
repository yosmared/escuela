<?php

namespace Escuela\UserManagerBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Doctrine\ORM\Mapping as ORM;


/**
 * ModuleClass
 *
 * @ORM\Table(name="moduleclass")
 * @ORM\Entity(repositoryClass="Escuela\UserManagerBundle\Repository\ModuleClassRepository")
 */
class ModuleClass
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="modulename", type="string", length=255, nullable=false)
     */
    private $modulename;
    
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="servicename", type="string", length=255, nullable=false)
     */
    private $servicename;

    /**
     * @var string
     *
     * @ORM\Column(name="serviceclass", type="string", length=255, nullable=false)
     */
    private $serviceclass;
    
    /** 
    * @var string
    *
    * @ORM\Column(name="serviceid", type="string", length=255, nullable=false)
    */
    private $serviceid;
    
    /**
     * 
     * @var string
     * @ORM\Column(name="route", type="string",length=255 ,nullable=true)
     */
	private $route;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="`order`", type="integer", nullable=false)
	 */
	private $order;
	
	
    public function __construct(){
    	
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ModuleClass
     */
    public function setModulename($name)
    {
        $this->modulename = $name;
    
        return $this;
    }

    /**
     * Get servicename
     *
     * @return string 
     */
    public function getServicename()
    {
        return $this->servicename;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return ModuleClass
     */
    public function setServicename($name)
    {
    	$this->servicename = $name;
    
    	return $this;
    }
    
    /**
     * Get firstname
     *
     * @return string
     */
    public function getModulename()
    {
    	return $this->modulename;
    }

    /**
     * Set serviceclass
     *
     * @param string $serviceclass
     * @return ModuleClass
     */
    public function setServiceclass($serviceclass)
    {
        $this->serviceclass = $serviceclass;
    
        return $this;
    }

    /**
     * Get serviceclass
     *
     * @return string 
     */
    public function getServiceclass()
    {
        return $this->serviceclass;
    }

    
    /**
     * Set serviceid
     *
     * @param string $serviceid
     * @return ModuleClass
     */
    public function setServiceid($serviceid)
    {
    	$this->serviceid = $serviceid;
    
    	return $this;
    }
    
    /**
     * Get serviceid
     *
     * @return string
     */
    public function getServiceid()
    {
    	return $this->serviceid;
    }
    
    /**
     * Set parentid
     *
     * @param string $parentid
     * @return ModuleClass
     */
    public function setRoute($route)
    {
    	$this->route = $route;
    
    	return $this;
    }
    
    /**
     * Get parentid
     *
     * @return string
     */
    public function getRoute()
    {
    	return $this->route;
    }
    
    /**
     * Set order
     *
     * @param string $order
     * @return ModuleClass
     */
    public function setOrder($order)
    {
    	$this->order = $order;
    
    	return $this;
    }
    
    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
    	return $this->order;
    }
    
  
}