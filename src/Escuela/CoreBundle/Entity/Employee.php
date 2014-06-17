<?php

namespace Escuela\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity
 */
class Employee
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
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=45, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="identification", type="string", length=45, nullable=true)
     */
    private $identification;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=45, nullable=true)
     */
    private $gender;

    /**
     * @var boolean
     *
     * @ORM\Column(name="director", type="boolean", nullable=true)
     */
    private $director;

    /**
     * @var \EmployeeType
     *
     * @ORM\ManyToOne(targetEntity="EmployeeType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_type_id", referencedColumnName="id")
     * })
     */
    private $employeeType;

    /**
     * @var \Grade
     *
     * @ORM\ManyToOne(targetEntity="Grade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grade_id", referencedColumnName="id")
     * })
     */
    private $grade;

    /**
     * @var \Institute
     *
     * @ORM\ManyToOne(targetEntity="Institute")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     * })
     */
    private $institute;



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
     * @return Employee
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
     * @return Employee
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
     * @param string $identification
     * @return Employee
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    
        return $this;
    }

    /**
     * Get identification
     *
     * @return string 
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Employee
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
     * Set director
     *
     * @param boolean $director
     * @return Employee
     */
    public function setDirector($director)
    {
        $this->director = $director;
    
        return $this;
    }

    /**
     * Get director
     *
     * @return boolean 
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set employeeType
     *
     * @param \Escuela\CoreBundle\Entity\EmployeeType $employeeType
     * @return Employee
     */
    public function setEmployeeType(\Escuela\CoreBundle\Entity\EmployeeType $employeeType = null)
    {
        $this->employeeType = $employeeType;
    
        return $this;
    }

    /**
     * Get employeeType
     *
     * @return \Escuela\CoreBundle\Entity\EmployeeType 
     */
    public function getEmployeeType()
    {
        return $this->employeeType;
    }

    /**
     * Set grade
     *
     * @param \Escuela\CoreBundle\Entity\Grade $grade
     * @return Employee
     */
    public function setGrade(\Escuela\CoreBundle\Entity\Grade $grade = null)
    {
        $this->grade = $grade;
    
        return $this;
    }

    /**
     * Get grade
     *
     * @return \Escuela\CoreBundle\Entity\Grade 
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set institute
     *
     * @param \Escuela\CoreBundle\Entity\Institute $institute
     * @return Employee
     */
    public function setInstitute(\Escuela\CoreBundle\Entity\Institute $institute = null)
    {
        $this->institute = $institute;
    
        return $this;
    }

    /**
     * Get institute
     *
     * @return \Escuela\CoreBundle\Entity\Institute 
     */
    public function getInstitute()
    {
        return $this->institute;
    }
}