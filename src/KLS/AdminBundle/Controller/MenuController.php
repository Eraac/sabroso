<?php

namespace KLS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use KLS\AdminBundle\Form\MenuType;
use KLS\AdminBundle\Form\EditMenuType;
use KLS\AdminBundle\Entity\Menu;

/**
 * @Route("/admin")
 */
class MenuController extends Controller
{
    const NO_CONTENT = 204;
    const NOT_FOUND = 404;

    /**
     * @Route("/add/menu", name="sabroso_admin_add_menu")
     * @Template("KLSAdminBundle:Menu:menu.html.twig")
     */
    public function addMenuAction(request $request)
    {
        $menu = new Menu();

        $form = $this->menuForm($request, $menu);

        if ($form->isValid())
        {
            $position = $menu->getPosition();

            if ($position != 0)
            {
                $em = $this->getDoctrine()->getManager();
                $movedMenu = $em->getRepository('KLSAdminBundle:Menu')->findByPosition($position);

                if (null !== $movedMenu) {
                    $movedMenu->setPosition(0);

                    $em->flush();
                }
            }

            $message = "Ajouté avec succès.";

            $this->persistMenu($request, $menu, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/list/menu", name="sabroso_admin_list_menu")
     * @Template("KLSAdminBundle::list.html.twig")
     */
    public function listMenuAction()
    {
        $smallTitle = "Choisir un menu";
        $headers = array('Nom');
        $type = "menu";
        $items = array();
        $titles = array();

        $em = $this->getDoctrine()->getManager()->getRepository('KLSAdminBundle:Menu');

        $menu = $em->findAll();

        if (!empty($menu)) {
            $items[] = $menu;
            $titles[] = "Les menus";
        }

        return array("smallTitle" => $smallTitle, "lists" => $items, "titles" => $titles, "headers" => $headers, 'type' => $type);
    }

    /**
     * @Route("/edit/menu/{id}", name="sabroso_admin_edit_menu")
     * @ParamConverter("menu", class="KLSAdminBundle:Menu")
     * @Template("KLSAdminBundle:Menu:Menu.html.twig")
     */
    public function editMenuAction(Request $request, Menu $menu)
    {
        $oldPosition = $menu->getPosition();

        $form = $this->menuForm($request, $menu);

        if ($form->isValid())
        {
            $newPosition = $menu->getPosition();

            if ($newPosition > 0)
            {
                $em = $this->getDoctrine()->getManager();
                $movedMenu = $em->getRepository('KLSAdminBundle:Menu')->findByPosition($newPosition);

                if (null !== $movedMenu) {
                    $movedMenu->setPosition($oldPosition);

                    $em->flush();
                }
            }

            $message = "Modifié avec succès.";

            $this->persistMenu($request, $menu, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/delete/menu/{id}", name="sabroso_admin_delete_menu", options={"expose"=true})
     * @Method({"POST"})
     */
    public function deleteMenuAction(Request $request, $id)
    {
        $codeHTTP = 0;

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('KLSAdminBundle:Menu');

        $menu = $repository->find($id);

        if (null === $menu)
            $codeHTTP = self::NOT_FOUND;
        else
        {
            $codeHTTP = self::NO_CONTENT;

            $em->remove($menu);
            $em->flush();
        }

        $response = new Response("", $codeHTTP);

        $response->prepare($request);

        return $response->send();
    }

    private function menuForm(Request $request, Menu $menu)
    {
        $type = ($menu->getId() == null) ? new MenuType() : new EditMenuType();

        $form = $this->createForm($type, $menu);

        $form->handleRequest($request);

        return $form;
    }

    private function persistMenu(Request $request, Menu $menu, $message)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($menu);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', $message);
    }
}
