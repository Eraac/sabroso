<?php

namespace KLS\AdminBundle\Twig;

use KLS\AdminBundle\Entity\Planning;

class KLSExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('renderList', array($this, 'renderList'), array('needs_environment' => true, 'is_safe' => array('html'))),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('renderModal', array($this, 'renderModal'), array('needs_environment' => true, 'is_safe' => array('html')))
        );
    }

    public function renderList(\Twig_Environment $twig, array $list, $title = "", $type, array $headers = array())
    {
        $type = ucfirst($type);
        $parameters = array('list' => $list, 'title' => $title, 'headers' => $headers, 'type' => $type);

        return $twig->render('KLSAdminBundle:Extensions:baseList.html.twig', $parameters);
    }

    public function renderModal(\Twig_Environment $twig, array $modals, $type)
    {
        return $twig->render('KLSAdminBundle:Extensions:baseModal.html.twig', array('modals' => $modals, 'type' => $type));
    }

    public function getName()
    {
        return 'kls_extension';
    }
}