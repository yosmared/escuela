<?php

namespace Escuela\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity
 */
class Student
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=45, nullable=false)
     */
    private $lastname;

    /**
     * @var integer
     *
     * @ORM\Column(name="identification", type="integer", nullable=false)
     */
    private $identification;
    
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string",length=1, nullable=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="city_birth", type="string", length=45, nullable=false)
     */
    private $cityBirth;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=false)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createAt", type="datetime", nullable=false)
     */
    private $createat;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=13, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="school_origin", type="string", length=45, nullable=true)
     */
    private $schoolOrigin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="viruela", type="boolean", nullable=true)
     */
    private $viruela;

    /**
     * @var boolean
     *
     * @ORM\Column(name="polio", type="boolean", nullable=true)
     */
    private $polio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tifus", type="boolean", nullable=true)
     */
    private $tifus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tetano", type="boolean", nullable=true)
     */
    private $tetano;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sarampion", type="boolean", nullable=true)
     */
    private $sarampion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disease", type="boolean", nullable=true)
     */
    private $disease;

    /**
     * @var string
     *
     * @ORM\Column(name="`explain`", type="text", nullable=true)
     */
    private $explain;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Grade", inversedBy="student")
     * @ORM\JoinTable(name="student_has_grade",
     *   joinColumns={
     *     @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="grade_id", referencedColumnName="id")
     *   }
     * )
     */
    private $grade;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Parents", inversedBy="student")
     * @ORM\JoinTable(name="student_has_parents",
     *   joinColumns={
     *     @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="parents_id", referencedColumnName="id")
     *   }
     * )
     */
    private $parents;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grade = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Student
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
     * @return Student
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
     * Set identification
     *
     * @param integer $identification
     * @return Student
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    
        return $this;
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
     * Set identification
     *
     * @param integer $identification
     * @return Student
     */
    public function setGender($gender)
    {
    	$this->gender = $gender;
    
    	return $this;
    }
    
    /**
     * Get identification
     *
     * @return integer
     */
    public function getGender()
    {
    	return $this->gender;
    }

    /**
     * Set cityBirth
     *
     * @param string $cityBirth
     * @return Student
     */
    public function setCityBirth($cityBirth)
    {
        $this->cityBirth = $cityBirth;
    
        return $this;
    }

    /**
     * Get cityBirth
     *
     * @return string 
     */
    public function getCityBirth()
    {
        return $this->cityBirth;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Student
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Student
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
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
     * Set createat
     *
     * @param \DateTime $createat
     * @return Student
     */
    public function setCreateat($createat)
    {
        $this->createat = $createat;
    
        return $this;
    }

    /**
     * Get createat
     *
     * @return \DateTime 
     */
    public function getCreateat()
    {
        return $this->createat;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Student
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set schoolOrigin
     *
     * @param string $schoolOrigin
     * @return Student
     */
    public function setSchoolOrigin($schoolOrigin)
    {
        $this->schoolOrigin = $schoolOrigin;
    
        return $this;
    }

    /**
     * Get schoolOrigin
     *
     * @return string 
     */
    public function getSchoolOrigin()
    {
        return $this->schoolOrigin;
    }

    /**
     * Set viruela
     *
     * @param boolean $viruela
     * @return Student
     */
    public function setViruela($viruela)
    {
        $this->viruela = $viruela;
    
        return $this;
    }

    /**
     * Get viruela
     *
     * @return boolean 
     */
    public function getViruela()
    {
        return $this->viruela;
    }

    /**
     * Set polio
     *
     * @param boolean $polio
     * @return Student
     */
    public function setPolio($polio)
    {
        $this->polio = $polio;
    
        return $this;
    }

    /**
     * Get polio
     *
     * @return boolean 
     */
    public function getPolio()
    {
        return $this->polio;
    }

    /**
     * Set tifus
     *
     * @param boolean $tifus
     * @return Student
     */
    public function setTifus($tifus)
    {
        $this->tifus = $tifus;
    
        return $this;
    }

    /**
     * Get tifus
     *
     * @return boolean 
     */
    public function getTifus()
    {
        return $this->tifus;
    }

    /**
     * Set tetano
     *
     * @param boolean $tetano
     * @return Student
     */
    public function setTetano($tetano)
    {
        $this->tetano = $tetano;
    
        return $this;
    }

    /**
     * Get tetano
     *
     * @return boolean 
     */
    public function getTetano()
    {
        return $this->tetano;
    }

    /**
     * Set sarampion
     *
     * @param boolean $sarampion
     * @return Student
     */
    public function setSarampion($sarampion)
    {
        $this->sarampion = $sarampion;
    
        return $this;
    }

    /**
     * Get sarampion
     *
     * @return boolean 
     */
    public function getSarampion()
    {
        return $this->sarampion;
    }

    /**
     * Set disease
     *
     * @param boolean $disease
     * @return Student
     */
    public function setDisease($disease)
    {
        $this->disease = $disease;
    
        return $this;
    }

    /**
     * Get disease
     *
     * @return boolean 
     */
    public function getDisease()
    {
        return $this->disease;
    }

    /**
     * Set explain
     *
     * @param string $explain
     * @return Student
     */
    public function setExplain($explain)
    {
        $this->explain = $explain;
    
        return $this;
    }

    /**
     * Get explain
     *
     * @return string 
     */
    public function getExplain()
    {
        return $this->explain;
    }

    /**
     * Add grade
     *
     * @param \Escuela\CoreBundle\Entity\Grade $grade
     * @return Student
     */
    public function addGrade(\Escuela\CoreBundle\Entity\Grade $grade)
    {
        $this->grade[] = $grade;
    
        return $this;
    }

    /**
     * Remove grade
     *
     * @param \Escuela\CoreBundle\Entity\Grade $grade
     */
    public function removeGrade(\Escuela\CoreBundle\Entity\Grade $grade)
    {
        $this->grade->removeElement($grade);
    }

    /**
     * Get grade
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGrade()
    {
        return $this->grade;
    }
    
    public function setGrade(\Escuela\CoreBundle\Entity\Grade $grade){
    	
    	$this->addGrade($grade);
    
    } 

    /**
     * Add parents
     *
     * @param \Escuela\CoreBundle\Entity\Parents $parents
     * @return Student
     */
    public function addParent(\Escuela\CoreBundle\Entity\Parents $parents)
    {
        $this->parents[] = $parents;
    
        return $this;
    }

    /**
     * Remove parents
     *
     * @param \Escuela\CoreBundle\Entity\Parents $parents
     */
    public function removeParent(\Escuela\CoreBundle\Entity\Parents $parents)
    {
        $this->parents->removeElement($parents);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParents()
    {
        return $this->parents;
    }
}