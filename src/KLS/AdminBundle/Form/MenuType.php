<?php

namespace KLS\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use KLS\CoreBundle\Form\ImageType;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => "Nom de la recette"))
            ->add('description', 'textarea') // TODO: Mettre un éditeur HTML
            ->add('position', 'choice', array('choices' => array("Non affiché", "En haut à gauche", "En haut à droite", "En bas à gauche", "En bas à droite")))
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
            'data_class' => 'KLS\AdminBundle\Entity\Menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kls_adminbundle_menu';
    }
}
