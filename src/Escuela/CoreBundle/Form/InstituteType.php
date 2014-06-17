<?php

namespace Escuela\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstituteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeSchool')
            ->add('name')
            ->add('address')
            ->add('telephone')
            ->add('municipality')
            ->add('state')
            ->add('numberZone')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\CoreBundle\Entity\Institute'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'escuela_corebundle_institute';
    }
}
