<?php

namespace KLS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use KLS\CoreBundle\Form\ImageType;

class EditGalleryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', new ImageType(), array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KLS\AdminBundle\Entity\Gallery'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kls_adminbundle_editgallery';
    }

    public function getParent()
    {
        return new GalleryType();
    }
}
