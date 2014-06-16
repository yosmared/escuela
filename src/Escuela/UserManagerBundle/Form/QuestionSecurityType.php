<?php 
namespace Escuela\UserManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Escuela\UserManagerBundle\Repository\BaseRepository;

class QuestionSecurityType extends AbstractType
{
	//public  $user;
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         	
    	
    	

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\UserManagerBundle\Entity\QuestionSecurity'
        ));
    }

    public function getName()
    {
        return 'escuela_usermanager_questionsecurity';
    }
}