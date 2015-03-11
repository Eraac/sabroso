<?php

namespace KLS\AdminBundle\Controller;

use KLS\AdminBundle\Entity\Press;
use KLS\AdminBundle\Form\PressType;
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
class PressController extends Controller
{
    const NO_CONTENT = 204;
    const NOT_FOUND = 404;

    /**
     * @Route("/add/press", name="sabroso_admin_add_press")
     * @Template("KLSAdminBundle:Press:press.html.twig")
     */
    public function addPressAction(Request $request)
    {
        $press = new Press();

        $form = $this->pressForm($request, $press);

        if ($form->isValid())
        {
            $message = "Ajouté avec succès.";

            $this->persistPress($request, $press, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/list/press", name="sabroso_admin_list_press")
     * @Template("KLSAdminBundle::list.html.twig")
     */
    public function listPressAction()
    {
        $smallTitle = "Choisir un article";
        $headers = array('Contenu', 'Source');
        $type = "press";
        $items = array();
        $titles = array();

        $em = $this->getDoctrine()->getManager()->getRepository('KLSAdminBundle:Press');

        $press = $em->findAll();

        if (!empty($press)) {
            $items[] = $press;
            $titles[] = "Les articles de presse";
        }

        return array("smallTitle" => $smallTitle, "lists" => $items, "titles" => $titles, "headers" => $headers, 'type' => $type);
    }

    /**
     * @Route("/edit/press/{id}", name="sabroso_admin_edit_press")
     * @ParamConverter("press", class="KLSAdminBundle:Press")
     * @Template("KLSAdminBundle:Press:press.html.twig")
     */
    public function editPressAction(Request $request, Press $press)
    {
        $form = $this->pressForm($request, $press);

        if ($form->isValid())
        {
            $message = "Modifié avec succès.";

            $this->persistPress($request, $press, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/delete/press/{id}", name="sabroso_admin_delete_press", options={"expose"=true})
     * @Method({"POST"})
     */
    public function deletePressAction(Request $request, $id)
    {
        $codeHTTP = 0;

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('KLSAdminBundle:Press');

        $press = $repository->find($id);

        if (null === $press)
            $codeHTTP = self::NOT_FOUND;
        else
        {
            $codeHTTP = self::NO_CONTENT;

            $em->remove($press);
            $em->flush();
        }

        $response = new Response("", $codeHTTP);

        $response->prepare($request);

        return $response->send();
    }

    /**
     * @Route("/enable/press", name="sabroso_admin_enable_press", options={"expose"=true})
     * @Method({"POST"})
     * @Template()
     */
    public function enablePressAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $variable = $em->getRepository('KLSAdminBundle:Variable')->getByName(Press::PRESS_VARIABLE_NAME);

        if (null !== $variable)
        {
            $variable->setValue(true);
            $em->flush();
        }

        return $this->makeResponse($request, $variable);
    }

    /**
     * @Route("/disable/press", name="sabroso_admin_disable_press", options={"expose"=true})
     * @Method({"POST"})
     * @Template()
     */
    public function disablePressAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $variable = $em->getRepository('KLSAdminBundle:Variable')->getByName(Press::PRESS_VARIABLE_NAME);

        if (null !== $variable)
        {
            $variable->setValue(false);
            $em->flush();
        }

        return $this->makeResponse($request, $variable);
    }

    private function makeResponse(Request $request, $resultat)
    {
        if (null !== $resultat) {
            $codeHTTP = self::NO_CONTENT;
        }
        else {
            $codeHTTP = self::NOT_FOUND;
        }

        $response = new Response("", $codeHTTP);

        $response->prepare($request);

        return $response->send();
    }

    private function pressForm(Request $request, $press)
    {
        $form = $this->createForm(new PressType(), $press);

        $form->handleRequest($request);

        return $form;
    }

    private function persistPress(Request $request, $press, $message)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($press);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', $message);
    }
}
