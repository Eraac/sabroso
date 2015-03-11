<?php

namespace KLS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanningType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date')
            ->add('latlng', 'oh_google_maps', array('label' => "Adresse"))
            ->add('address', 'hidden')
            ->add('Ajouter', 'submit', array('attr' => array('class' => 'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KLS\AdminBundle\Entity\Planning'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kls_adminbundle_planning';
    }
}
