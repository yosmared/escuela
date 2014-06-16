<?php
namespace Escuela\UserManagerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Escuela\UserManagerBundle\Entity\User;

use Escuela\UserManagerBundle\Entity\AnswersQuestionSecurity;


class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
	
	/**
	 * @var ContainerInterface
	 */
	private $container;

	const ES = 'es_ES';
	const EN = 'en_US';
	
	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
	public function load(ObjectManager $manager){
		
		$user = new User();
		$user->setUsername('admin');
		$user->setName('Super');
		$user->setLastname('Admin');
		$user->setMail('admin@softodonto.net');
		$user->setIdentification('111111111');	
		
		$qsecurity = $this->getReference('question-security-admin');
		$rolesid = $this->getReference('role-admin');
		
		$user->setQuestionSecurity($qsecurity);
		$user->addRolesid($rolesid);
		
		$encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
		$user->setPassword($encoder->encodePassword('123456', $user->getSalt()));

		$manager->persist($user);
		$manager->flush();
		
		//Answer security
		$answersecurity = new AnswersQuestionSecurity();
		$answersecurity->setUserid($user);
		$answersecurity->setQuestionSecurity($user->getQuestionSecurity());
		$answersecurity->setAnswer('second');
			
			
		$manager->persist($answersecurity);
		$manager->flush();

			
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 4; // the order in which fixtures will be loaded
	}
	
}