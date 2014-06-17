<?php

namespace Escuela\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grade
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity
 */
class Grade
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Student", mappedBy="grade")
     */
    private $student;

    /**
     * @var \Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     * })
     */
    private $section;

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
     * @return Grade
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
     * Add student
     *
     * @param \Escuela\CoreBundle\Entity\Student $student
     * @return Grade
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

    /**
     * Set section
     *
     * @param \Escuela\CoreBundle\Entity\Section $section
     * @return Grade
     */
    public function setSection(\Escuela\CoreBundle\Entity\Section $section = null)
    {
        $this->section = $section;
    
        return $this;
    }

    /**
     * Get section
     *
     * @return \Escuela\CoreBundle\Entity\Section 
     */
    public function getSection()
    {
        return $this->section;
    }
}