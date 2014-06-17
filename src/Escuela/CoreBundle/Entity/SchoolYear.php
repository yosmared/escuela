<?php

namespace Escuela\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchoolYear
 *
 * @ORM\Table(name="school_year")
 * @ORM\Entity
 */
class SchoolYear
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
     * @var \DateTime
     *
     * @ORM\Column(name="year", type="datetime", nullable=false)
     */
    private $year;

    /**
     * @var boolean
     *
     * @ORM\Column(name="current", type="boolean", nullable=false)
     */
    private $current;



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
     * Set year
     *
     * @param \DateTime $year
     * @return SchoolYear
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set current
     *
     * @param boolean $current
     * @return SchoolYear
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    
        return $this;
    }

    /**
     * Get current
     *
     * @return boolean 
     */
    public function getCurrent()
    {
        return $this->current;
    }
}