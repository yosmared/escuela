<?php 
namespace Escuela\UserManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnswersQuestionSecurityType extends AbstractType
{
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         	
    	$builder->add('answertext','text');
    	

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\UserManagerBundle\Entity\AnswersQuestionSecurity',
        	'compound' => true,
        ));
    }

    public function getName()
    {
        return 'escuela_usermanager_answersquestionsecurity';
    }
}