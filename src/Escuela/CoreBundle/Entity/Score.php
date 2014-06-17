<?php

namespace Escuela\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity
 */
class Score
{
    /**
     * @var string
     *
     * @ORM\Column(name="stage_one", type="string", length=45, nullable=true)
     */
    private $stageOne;

    /**
     * @var string
     *
     * @ORM\Column(name="stage_two", type="string", length=45, nullable=true)
     */
    private $stageTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="stage_three", type="string", length=45, nullable=true)
     */
    private $stageThree;

    /**
     * @var string
     *
     * @ORM\Column(name="score_final", type="string", length=45, nullable=true)
     */
    private $scoreFinal;

    /**
     * @var \Grade
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Grade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="grade_id", referencedColumnName="id")
     * })
     */
    private $grade;

    /**
     * @var \Student
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Student")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     * })
     */
    private $student;

    /**
     * @var \SchoolYear
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SchoolYear")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="school_year_id", referencedColumnName="id")
     * })
     */
    private $schoolYear;



    /**
     * Set stageOne
     *
     * @param string $stageOne
     * @return Score
     */
    public function setStageOne($stageOne)
    {
        $this->stageOne = $stageOne;
    
        return $this;
    }

    /**
     * Get stageOne
     *
     * @return string 
     */
    public function getStageOne()
    {
        return $this->stageOne;
    }

    /**
     * Set stageTwo
     *
     * @param string $stageTwo
     * @return Score
     */
    public function setStageTwo($stageTwo)
    {
        $this->stageTwo = $stageTwo;
    
        return $this;
    }

    /**
     * Get stageTwo
     *
     * @return string 
     */
    public function getStageTwo()
    {
        return $this->stageTwo;
    }

    /**
     * Set stageThree
     *
     * @param string $stageThree
     * @return Score
     */
    public function setStageThree($stageThree)
    {
        $this->stageThree = $stageThree;
    
        return $this;
    }

    /**
     * Get stageThree
     *
     * @return string 
     */
    public function getStageThree()
    {
        return $this->stageThree;
    }

    /**
     * Set scoreFinal
     *
     * @param string $scoreFinal
     * @return Score
     */
    public function setScoreFinal($scoreFinal)
    {
        $this->scoreFinal = $scoreFinal;
    
        return $this;
    }

    /**
     * Get scoreFinal
     *
     * @return string 
     */
    public function getScoreFinal()
    {
        return $this->scoreFinal;
    }

    /**
     * Set grade
     *
     * @param \Escuela\CoreBundle\Entity\Grade $grade
     * @return Score
     */
    public function setGrade(\Escuela\CoreBundle\Entity\Grade $grade)
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
     * Set student
     *
     * @param \Escuela\CoreBundle\Entity\Student $student
     * @return Score
     */
    public function setStudent(\Escuela\CoreBundle\Entity\Student $student)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \Escuela\CoreBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set schoolYear
     *
     * @param \Escuela\CoreBundle\Entity\SchoolYear $schoolYear
     * @return Score
     */
    public function setSchoolYear(\Escuela\CoreBundle\Entity\SchoolYear $schoolYear)
    {
        $this->schoolYear = $schoolYear;
    
        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return \Escuela\CoreBundle\Entity\SchoolYear 
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }
}