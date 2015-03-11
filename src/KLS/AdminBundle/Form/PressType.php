<?php

namespace KLS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PressType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', array('label' => "Extrait de l'article"))
            ->add('source', 'text', array('label' => "Nom de la source"))
            ->add('url', 'url', array('label' => "Lien de la source", "required" => false))
            ->add('Envoyer', 'submit', array('attr' => array('class' => 'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KLS\AdminBundle\Entity\Press'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kls_adminbundle_press';
    }
}
