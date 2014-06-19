<?php

namespace Escuela\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParentsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$x=array();
    	$y = 1950;
    	$z = ($y+100);
    	for ($i=$y;$i<$z;$i++){
    		
    		$x[] = $i;
    	}
        $builder
            ->add('name')
            ->add('lastname')
            ->add('identification')
            ->add('nationality','choice',array('choices'=>array('VENEZOLANO'=>'VENEZOLANO','EXTRANJERO'=>'EXTRANJERO')))
            ->add('birthdate','birthday',array('years'=>$x))
            ->add('address')
            ->add('telephone')
            ->add('gender','choice',array('choices'=>array('F'=>'FEMENINO','M'=>'MASCULINO')))
            ->add('profession')
            ->add('addressWork')
            ->add('alphabet')
            ->add('representant')
            //->add('student')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Escuela\CoreBundle\Entity\Parents'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'escuela_corebundle_parents';
    }
}
