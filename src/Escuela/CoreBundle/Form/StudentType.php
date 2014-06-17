<?php

namespace Escuela\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastname')
            ->add('identification')
            ->add('cityBirth')
            ->add('birthdate')
            ->add('address')
            ->add('createat')
            ->add('telephone')
            ->add('schoolOrigin')
            ->add('viruela')
            ->add('polio')
            ->add('tifus')
            ->add('tetano')
            ->add('sarampion')
            ->add('disease')
            ->add('explain')
            ->add('grade')
            ->add('parents')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\CoreBundle\Entity\Student'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'escuela_corebundle_student';
    }
}
