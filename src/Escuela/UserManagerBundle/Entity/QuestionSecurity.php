<?php

namespace Escuela\UserManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Questions
 *
 * @ORM\Table(name="questions_security")
 * @ORM\Entity(repositoryClass="Escuela\UserManagerBundle\Repository\QuestionSecurityRepository")
 * 
 */
class QuestionSecurity
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
     * @Gedmo\Translatable
     * @ORM\Column(name="question", type="string", nullable=false, length=255, unique=true)
     */
    private $question;


    /**
     * @var string
     *
     * @ORM\Column(name="`group`", type="integer", nullable=false)
     */
    private $group;

     /**
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="questionsecurity")
     */
    private $users;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
		$this->group = 1;

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
     * Get question (alias) of the question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }


    /**
     * Set question (alias) of the question
     *
     * @param string $name
     * @return Questions
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }
    
    /**
     * Get group (alias) of the question
     *
     * @return string
     */
    public function getGroup()
    {
    	return $this->group;
    }
    
    
    /**
     * Set group (alias) of the question
     *
     * @param string $name
     * @return Questions
     */
    public function setGroup($group)
    {
    	$this->group = $group;
    
    	return $this;
    }

   
    /**
     * Add addUsers
     *
     * @param \Escuela\UserManagerBundle\Entity\User $user
     * @return QuestionSecurity
     */
    public function addUser(\Escuela\UserManagerBundle\Entity\User $user)
    {
        $this->users[] = $user;
    
        return $this;
    }

    /**
     * Remove Users
     *
     * @param \Escuela\UserManagerBundle\Entity\User $user
     */
    public function removeUserid(\Escuela\UserManagerBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get Users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserid()
    {
        return $this->users;
    }
 
}