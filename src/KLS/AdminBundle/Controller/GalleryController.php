<?php

namespace KLS\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use KLS\AdminBundle\Entity\Gallery;
use KLS\AdminBundle\Form\GalleryType;
use KLS\AdminBundle\Form\EditGalleryType;

/**
 * @Route("/admin")
 */
class GalleryController extends Controller
{
    const NO_CONTENT = 204;
    const NOT_FOUND = 404;

    /**
     * @Route("/add/gallery", name="sabroso_admin_add_gallery")
     * @Template("KLSAdminBundle:Gallery:gallery.html.twig")
     */
    public function addGalleryAction(Request $request)
    {
        $gallery = new Gallery();

        $form = $this->galleryForm($request, $gallery);

        if ($form->isValid())
        {
            $position = $gallery->getPosition();

            if ($position != 0)
            {
                $em = $this->getDoctrine()->getManager();
                $movedGallery = $em->getRepository('KLSAdminBundle:Menu')->findByPosition($position);

                if (null !== $movedGallery) {
                    $movedGallery->setPosition(0);

                    $em->flush();
                }
            }

            $message = "Ajouté avec succès.";

            $this->persistGallery($request, $gallery, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/list/gallery", name="sabroso_admin_list_gallery")
     * @Template("KLSAdminBundle::list.html.twig")
     */
    public function listGalleryAction()
    {
        $smallTitle = "Choisir un image";
        $headers = array('Nom');
        $type = "gallery";
        $items = array();
        $titles = array();

        $em = $this->getDoctrine()->getManager()->getRepository('KLSAdminBundle:Gallery');

        $gallery = $em->findAll();

        if (!empty($gallery)) {
            $items[] = $gallery;
            $titles[] = "La gallerie";
        }

        return array("smallTitle" => $smallTitle, "lists" => $items, "titles" => $titles, "headers" => $headers, 'type' => $type);
    }

    /**
     * @Route("/edit/gallery/{id}", name="sabroso_admin_edit_gallery")
     * @ParamConverter("gallery", class="KLSAdminBundle:Gallery")
     * @Template("KLSAdminBundle:Gallery:Gallery.html.twig")
     */
    public function editGalleryAction(Request $request, $gallery)
    {
        $oldPosition = $gallery->getPosition();

        $form = $this->galleryForm($request, $gallery);

        if ($form->isValid())
        {
            $newPosition = $gallery->getPosition();

            if ($newPosition > 0)
            {
                $em = $this->getDoctrine()->getManager();
                $movedGallery = $em->getRepository('KLSAdminBundle:Menu')->findByPosition($newPosition);

                if (null !== $movedGallery) {
                    $movedGallery->setPosition($oldPosition);

                    $em->flush();
                }
            }

            $message = "Modifié avec succès.";

            $this->persistGallery($request, $gallery, $message);

            return $this->redirect($this->generateUrl("sabroso_admin"));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/delete/gallery/{id}", name="sabroso_admin_delete_gallery", options={"expose"=true})
     * @Method({"POST"})
     */
    public function deleteGalleryAction(Request $request, $id)
    {
        $codeHTTP = 0;

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('KLSAdminBundle:Gallery');

        $gallery = $repository->find($id);

        if (null === $gallery)
            $codeHTTP = self::NOT_FOUND;
        else
        {
            $codeHTTP = self::NO_CONTENT;

            $em->remove($gallery);
            $em->flush();
        }

        $response = new Response("", $codeHTTP);

        $response->prepare($request);

        return $response->send();
    }

    private function galleryForm(Request $request, Gallery $gallery)
    {
        $type = ($gallery->getId() == null) ? new GalleryType() : new EditGalleryType();

        $form = $this->createForm($type, $gallery);

        $form->handleRequest($request);

        return $form;
    }

    private function persistGallery(Request $request, Gallery $gallery, $message)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($gallery);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', $message);
    }
}
