<?php

namespace Escuela\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Institute
 *
 * @ORM\Table(name="institute")
 * @ORM\Entity
 */
class Institute
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
     * @ORM\Column(name="code_school", type="string", length=45, nullable=true)
     */
    private $codeSchool;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=45, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=45, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="municipality", type="string", length=45, nullable=true)
     */
    private $municipality;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=45, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="number_zone", type="string", length=45, nullable=true)
     */
    private $numberZone;



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
     * Set codeSchool
     *
     * @param string $codeSchool
     * @return Institute
     */
    public function setCodeSchool($codeSchool)
    {
        $this->codeSchool = $codeSchool;
    
        return $this;
    }

    /**
     * Get codeSchool
     *
     * @return string 
     */
    public function getCodeSchool()
    {
        return $this->codeSchool;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Institute
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
     * Set address
     *
     * @param string $address
     * @return Institute
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
     * @return Institute
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
     * Set municipality
     *
     * @param string $municipality
     * @return Institute
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;
    
        return $this;
    }

    /**
     * Get municipality
     *
     * @return string 
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Institute
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set numberZone
     *
     * @param string $numberZone
     * @return Institute
     */
    public function setNumberZone($numberZone)
    {
        $this->numberZone = $numberZone;
    
        return $this;
    }

    /**
     * Get numberZone
     *
     * @return string 
     */
    public function getNumberZone()
    {
        return $this->numberZone;
    }
}