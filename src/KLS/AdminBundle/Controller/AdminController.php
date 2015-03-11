<?php

namespace KLS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use KLS\AdminBundle\Entity\Press;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route(name="sabroso_admin")
     * @Template()
     */
    public function adminAction()
    {
        $pressIsEnable = $this->getDoctrine()->getManager()->getRepository('KLSAdminBundle:Variable')->getValue(Press::PRESS_VARIABLE_NAME, false);

        return array('pressIsEnable' => $pressIsEnable);
    }
}
