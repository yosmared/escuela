<?php 
namespace Escuela\UserManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Escuela\UserManagerBundle\EscuelaSoftOdontoBundle;

class ListType extends AbstractType
{	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
    	$builder
            ->add('phrase','text',array('label'=>'Phrase','required'=>false))            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    public function getName()
    {
        return 'escuela_list';
    }
}