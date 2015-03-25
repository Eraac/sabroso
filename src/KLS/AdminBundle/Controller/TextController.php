<?php

namespace KLS\AdminBundle\Controller;

use KLS\AdminBundle\Entity\Text;
use KLS\AdminBundle\Form\EditTextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class TextController extends Controller
{
    /**
     * @Route("/list/text", name="sabroso_admin_list_text")
     * @Template("KLSAdminBundle::list.html.twig")
     */
    public function listPressAction()
    {
        $smallTitle = "Choisir un texte";
        $headers = array('Description');
        $type = "text";
        $items = array();
        $titles = array();

        $em = $this->getDoctrine()->getManager()->getRepository('KLSAdminBundle:Text');

        $textes = $em->findAll();

        if (!empty($textes)) {
            $items[] = $textes;
            $titles[] = "Les textes";
        }

        return array("smallTitle" => $smallTitle, "lists" => $items, "titles" => $titles, "headers" => $headers, 'type' => $type);
    }

    /**
     * @Route("/edit/text/{id}", name="sabroso_admin_edit_text")
     * @ParamConverter("press", class="KLSAdminBundle:Text")
     * @Template("KLSAdminBundle:Text:text.html.twig")
     */
    public function editPressAction(Request $request, Text $text)
    {
        $form = $this->textForm($request, $text);

        if ($form->isValid())
        {
            $message = "Modifié avec succès.";

            $this->persistText($request, $text, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    private function textForm(Request $request, $text)
    {
        $form = $this->createForm(new EditTextType(), $text);

        $form->handleRequest($request);

        return $form;
    }

    private function persistText(Request $request, $text, $message)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($text);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', $message);
    }
}