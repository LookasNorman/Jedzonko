<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RecipePlan;
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
     * @Route("/plan/{id}", name="plan_details", methods={"GET"})
     */
    public function detailsAction($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $plan = $em->getRepository(Plan::class)->find($id);
        $recipiesPlan = $em->getRepository(RecipePlan::class)->groupByDay($id);

        return $this->render('dashboard/plan/details.html.twig', [
            'plan' => $plan,
            'recipiesPlan' => $recipiesPlan
        ]);
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
    
    
}
