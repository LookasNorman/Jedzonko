<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\ChoiceList\ORMQueryBuilderLoader;
use AppBundle\Entity\Plan;


class PlanController extends Controller
{
    /**
     * @return Response
     * @Route("/plan/add/")
     */
    public function addAction(): Response
    {
        return $this->render('dashboard/plan/add.html.twig', []);
    }
    
    /**
     * @return Response
     * @Route("/plan/edit/{id}")
     */
    public function editAction(): Response
    {
        return $this->render('dashboard/plan/edit.html.twig', []);
    }
    
    /**
     * @return Response
     * @Route("/plan/details")
     */
    public function detailsAction(): Response
    {
        return $this->render('dashboard/plan/details.html.twig', []);
    }
    
    /**
     * @return Response
     * @Route("/plan/list")
     */
    public function listAction(): Response
    {
        return $this->render('dashboard/plan/list.html.twig', []);
    }
    
    /**
     * @return Response
     * @Route("/plan/add/recipe ")
     */
    public function addRecipeAction(): Response
    {
        return $this->render('dashboard/plan/addRecipe.html.twig', []);
    }
    
    
    /**
     * @return Response
     * @Route("/test")
     */
    public function countPlanAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Plan');
        $plan = $repository->findAll();
        $noPlan = count($plan);
        
        return new Response ('liczba planów : ' . $noPlan);
        
    }
}
