<?php

namespace KLS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use KLS\AdminBundle\Entity\Planning;
use KLS\AdminBundle\Form\PlanningType;

/**
 * @Route("/admin")
 */
class PlanningController extends Controller
{
    const maxNextDays = 40;
    const maxPreviousDays = 10;
    const NO_CONTENT = 204;
    const NOT_FOUND = 404;

    /**
     * @Route("/add/planning", name="sabroso_admin_add_planning")
     * @Template("KLSAdminBundle:Planning:planning.html.twig")
     */
    public function addPlanningAction(Request $request)
    {
        $planning = new Planning();

        $form = $this->planningForm($request, $planning);

        if ($form->isValid())
        {
            $message = "Ajouté avec succès.";

            $this->persistPlanning($request, $planning, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/list/planning", name="sabroso_admin_list_planning")
     * @Template("KLSAdminBundle::list.html.twig")
     */
    public function listPlanningAction()
    {
        $smallTitle = "Choisir une date";
        $headers = array('Adresse', 'Date');
        $type = "planning";
        $items = array();
        $titles = array();

        $em = $this->getDoctrine()->getManager()->getRepository('KLSAdminBundle:Planning');

        $nextPlannings = $em->nextDays(self::maxNextDays);
        $previousPlannings = $em->previousDays(self::maxPreviousDays);

        if (!empty($nextPlannings)) {
            $items[] = $nextPlannings;
            $titles[] = "Les prochains jours";
        }

        if (!empty($previousPlannings)) {
            $items[] = $previousPlannings;
            $titles[] = "Les anciens jours";
        }

        return array("smallTitle" => $smallTitle, "lists" => $items, "titles" => $titles, "headers" => $headers, 'type' => $type);
    }

    /**
     * @Route("/edit/planning/{id}", name="sabroso_admin_edit_planning")
     * @ParamConverter("planning", class="KLSAdminBundle:Planning")
     * @Template("KLSAdminBundle:Planning:planning.html.twig")
     */
    public function editPlanningAction(Request $request, Planning $planning)
    {
        $form = $this->planningForm($request, $planning);

        if ($form->isValid())
        {
            $message = "Modifié avec succès.";

            $this->persistPlanning($request, $planning, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/delete/planning/{id}", name="sabroso_admin_delete_planning", options={"expose"=true})
     * @Method({"POST"})
     */
    public function deletePlanningAction(Request $request, $id)
    {
        $codeHTTP = 0;

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('KLSAdminBundle:Planning');

        $planning = $repository->find($id);

        if (null === $planning)
            $codeHTTP = self::NOT_FOUND;
        else
        {
            $codeHTTP = self::NO_CONTENT;

            $em->remove($planning);
            $em->flush();
        }

        $response = new Response("", $codeHTTP);

        $response->prepare($request);

        return $response->send();
    }

    private function planningForm(Request &$request, &$planning)
    {
        $form = $this->createForm(new PlanningType(), $planning);

        $form->handleRequest($request);

        return $form;
    }

    private function persistPlanning(Request &$request, &$planning, $message)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($planning);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', $message);
    }
}
