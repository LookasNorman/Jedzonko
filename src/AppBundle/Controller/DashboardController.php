<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\ChoiceList\ORMQueryBuilderLoader;
use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipePlan;

/**
 * @Route("/main")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard_index")
     */
    public function indexAction(Session $session): Response
    {

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Plan');
        $plan = $repository->findAll();
        $noPlans = count($plan);

        $repository2 = $em->getRepository('AppBundle:Recipe');
        $recipe = $repository2->findAll();
        $noRecipes = count($recipe);

        //last Plan Name
        $query = $em->createQuery('SELECT p FROM AppBundle\Entity\Plan p ORDER BY p.created DESC');
        $plans = $query->getResult();
        $plan = $plans[0];
        $lastPlanId = $plan->getId();
//        $lastPlanName = $plans[0]->getName();

        //Last plan details
        $session->set('plan_id', $lastPlanId);
        $planDetails = $this->planDetails($lastPlanId);
        $plan = $planDetails[0];
        $recipesDay = $planDetails[1];

        //last plan details
//        $query = $em->createQuery
//        ('SELECT rp FROM AppBundle\Entity\RecipePlan rp  JOIN rp.plan p WHERE p.id=4 order by rp.mealOrder,rp.dayName');
//        $rp = $query->getResult();
//
//        $query2 = $em->createQuery
//        ('SELECT  (rp.dayName), count(rp.dayName) FROM AppBundle\Entity\RecipePlan rp  JOIN rp.plan p
//        WHERE p.id=4 group by rp.dayName');
//
//        $res = $query2->getResult();

        return $this->render('dashboard/index.html.twig', [
            'noPlans' => $noPlans,
            'noRecipes' => $noRecipes,
            'plan' => $plan,
            'recipesDay' => $recipesDay
        ]);
    }

    private function planDetails($id)
    {
        $daysName = [];
        $recipesDay = [];
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
                ->findBy(['dayName' => $dayName, 'plan' => $id], ['mealOrder' => 'asc']);
        }
        return array($plan, $recipesDay);
    }
}

