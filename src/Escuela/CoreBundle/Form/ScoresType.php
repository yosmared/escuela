<?php

namespace Escuela\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScoresType extends AbstractType
{

     
	public function __construct(){
		
		
	}
     
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stageOne','text',array('max_length'=>1))
            ->add('stageTwo','text',array('max_length'=>1))
            ->add('stageThree','text',array('max_length'=>1))
            ->add('scoreFinal','text',array('max_length'=>1))
            //->add('grade','choice',array('choices'=>array($this->grade->getId()=>$this->grade->getName()),'expanded'=>false,'multiple'=>false))
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
            'data_class' => 'Escuela\CoreBundle\Entity\Score'
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
