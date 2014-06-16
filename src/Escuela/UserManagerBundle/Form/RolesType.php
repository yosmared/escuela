<?php
namespace Escuela\UserManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RolesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array('label'=>'Name','required'=>true))
            ->add('description','textarea',array('label'=>'Description','required'=>false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\UserManagerBundle\Entity\Roles'
        ));
    }

    public function getName()
    {
        return 'escuela_usermanager_roles';
    }
}