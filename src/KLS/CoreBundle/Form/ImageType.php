<?php

namespace KLS\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alt', 'text', array('label' => "Information sur l'image"))
            ->add('file', 'file', array('label' => "Fichier"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KLS\CoreBundle\Entity\Image'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kls_corebundle_image';
    }
}
