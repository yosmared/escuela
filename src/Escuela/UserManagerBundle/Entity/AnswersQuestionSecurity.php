<?php

namespace Escuela\UserManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Answers
 *
 * @ORM\Table(name="answers_questionsecurity")
 * @ORM\Entity(repositoryClass="Escuela\UserManagerBundle\Repository\AnswersQuestionSecurityRepository")
 */
class AnswersQuestionSecurity{
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="userid", referencedColumnName="id")
	 **/
	private $userid;
	
	/**
	 * @ORM\ManyToOne(targetEntity="QuestionSecurity")
	 * @ORM\JoinColumn(name="qsid", referencedColumnName="id")
	 **/
	private $qsid;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="text", type="string", length=255, nullable=true)
	 */
	private $answertext;
	
	
	public function getId()
	{
		return $this->id;
	}
	/**
	 * Set Userid
	 * @param \Escuela\UserManagerBundle\Entity\User $userid
	 * @return \Escuela\UserManagerBundle\Entity\AnswersQuestionSecurity
	 */
	public function setUserid(\Escuela\UserManagerBundle\Entity\User $userid)
	{
		$this->userid = $userid;
		
		return $this;
	}
	
	/**
	 * Get Userid
	 * @return \Escuela\UserManagerBundle\Entity\User
	 */
	public function getUserid()
	{
		return $this->userid;
	}
	
	/**
	 * Set QuestionSecurity
	 * @param Escuela\UserManagerBundle\Entity\QuestionSecurity $question
	 * @return \Escuela\UserManagerBundle\Entity\AnswersQuestionSecurity
	 */
	public function setQuestionSecurity(\Escuela\UserManagerBundle\Entity\QuestionSecurity $question)
	{
		$this->qsid = $question;
		
		return $this;
		
	}
	
	/**
	 * Get QuestionSecurity
	 * @return \Escuela\UserManagerBundle\Entity\QuestionSecurity
	 */
	public function getQuestionSecurity()
	{
		return $this->qsid;
	}
	
	/**
	 * Set Answer
	 * @param unknown $text
	 * @return \Escuela\UserManagerBundle\Entity\AnswersQuestionSecurity
	 */
	public function setAnswer($text)
	{
		$this->answertext = $text;
		
		return $this;
	}
	
	/**
	 * Get Answer
	 * @return string
	 */
	public function getAnswer()
	{
		return $this->answertext;
	}
}