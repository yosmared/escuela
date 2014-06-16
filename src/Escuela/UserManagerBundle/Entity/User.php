<?php

namespace Escuela\UserManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManager;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Escuela\UserManagerBundle\Repository\UserRepository")
 * 
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;
    
    /**
     * 
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;
    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     */
    protected $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="identification_card", type="integer", nullable=false, unique=true)
     */
    protected $identification;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", nullable=true)
     */
    protected $telephone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telephone_celular", type="string", nullable=true)
     */
    protected $celular;
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    protected $address; 
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    protected $isDeleted;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Roles", inversedBy="userid")
     * @ORM\JoinTable(name="users_roles",
     *   joinColumns={
     *     @ORM\JoinColumn(name="userid", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="rolesid", referencedColumnName="id")
     *   }
     * )
     **/
    protected $rolesid;

   
    /**
     *
     * @ORM\ManyToOne(targetEntity="QuestionSecurity", inversedBy="users")
     * @ORM\JoinColumn(name="questionsecurity_id", referencedColumnName="id")
     */
    protected $questionsecurity;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userQuestionGroups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rolesid = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->servicesid = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->questionsecurity = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->isDeleted = false;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        
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
     * Set username
     *
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Users
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    
        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Users
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
     * Set lastname
     *
     * @param string $lastname
     * @return Users
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Add rolesid
     *
     * @param \Escuela\UserManagerBundle\Entity\Roles $rolesid
     * @return Users
     */
    public function addRolesid(\Escuela\UserManagerBundle\Entity\Roles $rolesid)
    {
        $this->rolesid[] = $rolesid;
    
        return $this;
    }

    /**
     * Remove rolesid
     *
     * @param \Escuela\UserManagerBundle\Entity\Roles $rolesid
     */
    public function removeRolesid(\Escuela\UserManagerBundle\Entity\Roles $rolesid)
    {
        $this->rolesid->removeElement($rolesid);
    }

    /**
     * Get rolesid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRolesid()
    {
        return $this->rolesid;
    }
    
 
    public function setQuestionSecurity(\Escuela\UserManagerBundle\Entity\QuestionSecurity $qsecurity)
    {
    	$this->questionsecurity = $qsecurity;
    
    	return $this;
    }
    
    
    /**
     * Get QuestionSecurity
     *
     * @return \Escuela\UserManagerBundle\Entity\QuestionSecurity
     */
    public function getQuestionSecurity()
    {
    	return $this->questionsecurity;
    }
      
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
    	return serialize(array(
    			$this->id,
    	));
    }
    
    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
    	list (
    			$this->id,
    	) = unserialize($serialized);
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
    	return $this->getRolesid()->toArray();
    }
    
    /**
     * @inheritDoc
     */
    public function getSalt()
    {
    	return $this->salt;
    }

    /**
     * Set identification
     *
     * @param string $identification
     * @return Users
     */
    public function setIdentification($identification)
    {  	
    	$this->identification = $identification; 	
    }
    
    /**
     * Set telephone
     *
     * @param string telephone
     * @return Users
     */
    public function setTelephone($telephone)
    {    	 
    	$this->telephone = $telephone;	 
    }
    
    /**
     * Set telephone_celular
     *
     * @param string $celular
     * @return Users
     */
    public function setCelular($celular)
    {
    	$this->celular = $celular;	 
    }
    
    /**
     * Set address
     *
     * @param string $address
     * @return Users
     */
    public function setAddress($address)
    {
    	$this->address = $address;
    }
    
    /**
     * Set cov
     *
     * @param string $cov
     * @return Users
     */
    public function setCov($cov)
    {
    	$this->cov = $cov;
    }
    
    /**
     * Set mpps
     *
     * @param string $mpps
     * @return Users
     */
    public function setMpps($mpps)
    {
    	$this->mpps = $mpps;
    }
    
    /**
     * Get identification
     *
     * @return integer
     */
    public function getIdentification()
    {
    	return $this->identification;
    }
    
    /**
     * Get telephone
     *
     * @return String
     */
    public function getTelephone()
    {
    	return $this->telephone;
    }
    
    /**
     * Get telephone_celular
     *
     * @return String
     */
    public function getCelular()
    {
    	return $this->celular;
    }
    
    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
    	return $this->address;
    }
    
    /**
     * Get cov
     *
     * @return integer
     */
    public function getCov()
    {
    	return $this->cov;
    }
    
    /**
     * Get mpps
     *
     * @return integer
     */
    public function getMpps()
    {
    	return $this->mpps; 
    }
        
    
    /**
     * Este método fue tomado para validar el usuario eliminado logicamente,
     * aunque segun la interfaz es usado para validar la expiración de la cuenta
     *
     * @return boolean
     */
    public function isAccountNonExpired()
    {
    	if($this->isDeleted()){
    		return false;
    	}else{
    		
    		return true;
    	}
    }
    
    public function isAccountNonLocked()
    {
    	return true;
    }
    
    public function isCredentialsNonExpired()
    {
    	return true;
    }
    
    public function isEnabled()
    {
    	
    	return $this->isActive;
    	
    }
    
    public function isDeleted()
    {
    	return $this->isDeleted;
    }
    
    public function setDeleted($status = true)
    {
    	$this->isDeleted = $status;
    }
    
    public function setEnabled($status = true)
    {
    	$this->isActive = $status;
    }
       
    public function equals(UserInterface $user)
    {
    	if (!$user instanceof User) {
    		return false;
    	}
    
    	if ($this->password !== $user->getPassword()) {
    		return false;
    	}
    
    	if ($this->getSalt() !== $user->getSalt()) {
    		return false;
    	}
    
    	if ($this->username !== $user->getUsername()) {
    		return false;
    	}
    
    	return true;
    }
}