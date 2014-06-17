<?php

namespace Escuela\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parents
 *
 * @ORM\Table(name="parents")
 * @ORM\Entity
 */
class Parents
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
     * @ORM\Column(name="nationality", type="string", length=45, nullable=false)
     */
    private $nationality;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime", nullable=false)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=13, nullable=false)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=45, nullable=true)
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="address_work", type="text", nullable=true)
     */
    private $addressWork;

    /**
     * @var boolean
     *
     * @ORM\Column(name="alphabet", type="boolean", nullable=true)
     */
    private $alphabet;

    /**
     * @var boolean
     *
     * @ORM\Column(name="representant", type="boolean", nullable=true)
     */
    private $representant;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Student", mappedBy="parents")
     */
    private $student;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->student = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Parents
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
     * @return Parents
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
     * @return Parents
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
     * Set nationality
     *
     * @param string $nationality
     * @return Parents
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    
        return $this;
    }

    /**
     * Get nationality
     *
     * @return string 
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return Parents
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
     * @return Parents
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
     * Set telephone
     *
     * @param string $telephone
     * @return Parents
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
     * Set gender
     *
     * @param string $gender
     * @return Parents
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set profession
     *
     * @param string $profession
     * @return Parents
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;
    
        return $this;
    }

    /**
     * Get profession
     *
     * @return string 
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set addressWork
     *
     * @param string $addressWork
     * @return Parents
     */
    public function setAddressWork($addressWork)
    {
        $this->addressWork = $addressWork;
    
        return $this;
    }

    /**
     * Get addressWork
     *
     * @return string 
     */
    public function getAddressWork()
    {
        return $this->addressWork;
    }

    /**
     * Set alphabet
     *
     * @param boolean $alphabet
     * @return Parents
     */
    public function setAlphabet($alphabet)
    {
        $this->alphabet = $alphabet;
    
        return $this;
    }

    /**
     * Get alphabet
     *
     * @return boolean 
     */
    public function getAlphabet()
    {
        return $this->alphabet;
    }

    /**
     * Set representant
     *
     * @param boolean $representant
     * @return Parents
     */
    public function setRepresentant($representant)
    {
        $this->representant = $representant;
    
        return $this;
    }

    /**
     * Get representant
     *
     * @return boolean 
     */
    public function getRepresentant()
    {
        return $this->representant;
    }

    /**
     * Add student
     *
     * @param \Escuela\CoreBundle\Entity\Student $student
     * @return Parents
     */
    public function addStudent(\Escuela\CoreBundle\Entity\Student $student)
    {
        $this->student[] = $student;
    
        return $this;
    }

    /**
     * Remove student
     *
     * @param \Escuela\CoreBundle\Entity\Student $student
     */
    public function removeStudent(\Escuela\CoreBundle\Entity\Student $student)
    {
        $this->student->removeElement($student);
    }

    /**
     * Get student
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudent()
    {
        return $this->student;
    }
}