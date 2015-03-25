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
            ->add('position', 'choice', array('choices' =>
                array(
                    "Non affiché",
                    "En haut à gauche (avec image)",
                    "En haut à droite (avec image)",
                    "En bas à gauche (avec image)",
                    "En bas à droite (avec image)",
                    "Les autres (1er)",
                    "Les autres (2ème)",
                    "Les autres (3ème)",
                    "Les autres (4ème)"
                )))
            ->add('image', new ImageType(), array('required' => false))
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
