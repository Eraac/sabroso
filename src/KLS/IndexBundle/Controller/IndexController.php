<?php

namespace KLS\IndexBundle\Controller;

use Doctrine\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use KLS\AdminBundle\Entity\VariableRepository;
use KLS\AdminBundle\Entity\Press;

class IndexController extends Controller
{
    const MAX_RECIPES = 8;
    const MAX_PLANNING = 5;

    /**
     * @Route("/", name="sabroso_index")
     * @Template()
     */
    public function indexAction()
    {
        // TODO Charger les textes et les prochains jours
        $em = $this->getDoctrine()->getManager();

        $text       = $this->getText($em);
        $days       = $this->getNextDays($em);
        $recipes    = $this->getRecipes($em);
        $gallery    = $this->getGallery($em);
        $press      = $this->getPress($em);

        return array('text' => $text, 'days' => $days, 'recipes' => $recipes, 'gallery' => $gallery, 'press' => $press);
    }

    private function getPress(EntityManager &$em)
    {
        $pressIsEnable = $em->getRepository('KLSAdminBundle:Variable')->getValue(Press::PRESS_VARIABLE_NAME, false);

        if ($pressIsEnable)  {
            $press = $em->getRepository('KLSAdminBundle:Press')->getOneRandom();
        } else {
            $press = null;
        }

        return $press;
    }

    private function getNextDays(EntityManager &$em)
    {
        $timestamp = strtotime('today');

        $today = new \Datetime();
        $today->setTimestamp($timestamp);

        $repository = $em->getRepository('KLSAdminBundle:Planning');

        $planning = $repository->nextDays(self::MAX_PLANNING, $today);

        return $planning;
    }

    private function getGallery(EntityManager &$em)
    {
        $repository = $em->getRepository('KLSAdminBundle:Gallery');

        $gallery = $repository->getSlider();

        return $gallery;
    }

    private function getRecipes(EntityManager &$em)
    {
        $repository = $em->getRepository('KLSAdminBundle:Menu');

        $recipes = $repository->getRecipes(self::MAX_RECIPES);

        return $recipes;
    }

    private function getText(EntityManager &$em)
    {
        $repository = $em->getRepository('KLSAdminBundle:Text');

        $contents = $repository->findAll();
        $text = array();

        foreach ($contents as $content) {
            $text[$content->getKey()] = $content->getContent();
        }

        return $text;
    }
}
