<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RecipePlan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
     * @Route("/plan/list/{id}", name="plan_details", methods={"GET"})
     */
    public function detailsAction($id): Response
    {
        $daysName = [];
        $em = $this->getDoctrine()->getManager();

        //Get plan
        $plan = $em->getRepository(Plan::class)->find($id);

        //Get all recipe for plan
        $recipesPlan = $em->getRepository(RecipePlan::class)->findBy(['plan' => $id]);

        //Get days for recipe plan and remove duplicate
        foreach ($recipesPlan as $key => $recipePlan) {
            if (!in_array($recipePlan->getDayName(), $daysName)) {
                $daysName [] = $recipePlan->getDayName();
            }
        }
        //Sort day name
        usort($daysName, function ($a, $b) {
            return strcmp($a->getDayOrder(), $b->getDayOrder());
        });

        //Get recipe for day
        foreach ($daysName as $dayName) {
            $recipesDay [][$dayName->getDayName()] = $em
                ->getRepository(RecipePlan::class)
                ->findBy(['dayName' => $dayName], ['mealOrder' => 'asc']);
        }

        return $this->render('dashboard/plan/details.html.twig', [
            'plan' => $plan,
            'recipesDay' => $recipesDay
        ]);
    }

    /**
     * @return Response
     * @Route("/plan/list")
     */
    public function listAction(): Response
    {
        $plans = $this->getDoctrine()->getManager()->getRepository(Plan::class)->findAll();
        return $this->render('dashboard/plan/list.html.twig', [
            'plans' => $plans
        ]);
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
     * @Route("/plan/add/details", methods={"GET"}, name="add_plan_details")
     */
    public function addPlanDetails(Request $request)
    {
        //Check is set session plan_id
        $session = $this->get('session');
        if(!$session->get('plan_id')){
            throw new AccessDeniedHttpException('Brak id planu');
        }
        
        return $this->render('dashboard/plan/addRecipe.html.twig', [
            'plan' => $plan
        ]);
    }


}
