<?php

namespace Escuela\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScoresType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stageOne','text',array('max_length'=>1))
            ->add('stageTwo','text',array('mapped'=>false,'max_length'=>1))
            ->add('stageThree','text',array('mapped'=>false,'max_length'=>1))
            ->add('scoreFinal','text',array('mapped'=>false,'max_length'=>1))
            ->add('grade','entity',array('class'=>'EscuelaCoreBundle:Grade','property' => 'name','expanded'=>false,'multiple'=>false))
            //->add('year','entity',array('class'=>'EscuelaCoreBundle:SchoolYear','property' => 'name','expanded'=>false,'multiple'=>true,'mapped'=>false))
            //->add('parents')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'Escuela\CoreBundle\Entity\Student'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'escuela_corebundle_scores';
    }
}
