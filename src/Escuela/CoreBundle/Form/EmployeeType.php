<?php

namespace Escuela\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmployeeType extends AbstractType
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
            ->add('gender','choice',array('choices'=>array('F'=>'FEMENINO','M'=>'MASCULINO')))
            ->add('director')
            ->add('employeeType','entity',array('class'=>'EscuelaCoreBundle:EmployeeType','property'=>'name'))
            ->add('grade','entity',array('class'=>'EscuelaCoreBundle:Grade','property'=>'name'))
            ->add('institute','entity',array('class'=>'EscuelaCoreBundle:Institute','property'=>'name'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\CoreBundle\Entity\Employee'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'escuela_corebundle_employee';
    }
}
