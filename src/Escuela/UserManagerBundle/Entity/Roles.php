<?php
namespace Escuela\UserManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Escuela\UserManagerBundle\Repository\RolesRepository")
 * 
 */
class Roles implements RoleInterface, Translatable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * 
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=95, nullable=false)
     */
    private $name;
    
    /**
     * 
     * @ORM\Column(name="role", type="string", length=100, unique=true, nullable=false)
     */
    private $role;

    /**
     * @var string 
     * @Gedmo\Translatable
     * 
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="rolesid")
     */
    private $userid;
    
    /**
     * @ORM\Column(name="is_delete", type="boolean")
     */
    private $isDeleted;

   
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usersid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isDeleted = false;
        //$this->setTranslatableLocale("es_ES");
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
     * @return Roles
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Roles
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add userid
     *
     * @param \Escuela\UserManagerBundle\Entity\User $userid
     * @return Roles
     */
    public function addUsersid(\Escuela\UserManagerBundle\Entity\User $userid)
    {
        $this->userid[] = $userid;
    
        return $this;
    }

    /**
     * Remove usersid
     *
     * @param \Escuela\UserManagerBundle\Entity\User $userid
     */
    public function removeUserid(\Escuela\UserManagerBundle\Entity\User $userid)
    {
        $this->userid->removeElement($userid);
    }

    /**
     * Get userid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserid()
    {
        return $this->userid;
    }
    
    public function getRole(){ 
    	
    	return $this->role;
    	
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Roles
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Set Is Deleted
     *
     * @param boolean $deleted
     * @return Roles
     */
    public function setDeleted($deleted)
    {
    	$this->isDeleted = $deleted;
    
    	return $this;
    }
    
    /**
     * Get Is Deleted
     *
     * @return string 
     */
    public function getDeleted()
    {
        return $this->isDeleted;
    }

    public function setTranslatableLocale($locale)
    {
    	$this->locale = $locale;
    }
}