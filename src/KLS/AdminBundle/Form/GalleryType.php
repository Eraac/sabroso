<?php

namespace KLS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use KLS\CoreBundle\Form\ImageType;

class GalleryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => "Nom"))
            ->add('position', 'choice', array('choices' => array("Non affiché", "1er position", "2ème position", "3ème position")))
            ->add('image', new ImageType())
            ->add('Envoyer', 'submit', array('attr' => array('class' => 'btn btn-success')))
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
        return 'kls_adminbundle_gallery';
    }
}
