<?php 
namespace Escuela\UserManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Escuela\UserManagerBundle\EscuelaSoftOdontoBundle;
use Escuela\UserManagerBundle\Entity\User;
use Escuela\UserManagerBundle\Entity\QuestionSecurity;
use Escuela\UserManagerBundle\Repository\SoftOdontoRepository;
use Symfony\Component\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
	public  $user;
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    	$builder
            ->add('username','text',array('label'=>'Username','required'=>true))
            ->add('name','text',array('label'=>'Name','required'=>true))
            ->add('lastname','text',array('label'=>'Last Name','required'=>true))
            ->add('identification','number',array('label'=>'DNI','required'=>true, 'invalid_message'=> 'Cédula inválida'))
            ->add('telephone','text',array('label'=>'Telephone','required'=>false,'max_length'=>11))
            ->add('celular','text',array('label'=>'Celular','required'=>false,'max_length'=>11))
            ->add('address','textarea',array('label'=>'Address','required'=>false))
            ->add('password', 'repeated', array(
            		'first_name'  => 'password',
            		'second_name' => 'confirm',
            		'type'        => 'password',
            ))

            ->add('mail','email',array('label'=>'E-mail','required'=>true))
            ->add('rolesid','entity',array('class'=>'EscuelaUserManagerBundle:Roles','multiple'=>true,'property'=>'name', 'expanded'=>true,'label'=>'Roles'))
            ->add('questionsecurity','entity',array(
        		'class'=>'EscuelaUserManagerBundle:QuestionSecurity',
        		'property'=>'question', 'expanded'=> false, 'multiple'=>false,
            	'empty_value'=>'select.empty.value','translation_domain' => 'validators'
        		))
			 ->add('answertext','password',array('label'=>'Answers','mapped'=>false));
           

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\UserManagerBundle\Entity\User',
        	//'compound'=>true,
        ));
        
        
    }

    public function getName()
    {
        return 'escuela_usermanager_user';
    }
}