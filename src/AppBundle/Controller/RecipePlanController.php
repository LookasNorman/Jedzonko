<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DayName;
use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipePlan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class RecipePlanController extends Controller
{
    /**
     * @Route("/test")
     */
    public function setRecipePlan()
    {

        $em = $this->getDoctrine()->getManager();
        $recipesPlans = $em->getRepository(RecipePlan::class)->findBy(['recipe' => null]);
        foreach ($recipesPlans as $recipePlan) {
            $planNumber = rand(201, 400);
            $recipeNumber = rand(201, 400);
            $dayNumber = rand(8, 14);
            $plan = $em->getRepository(Plan::class)->find($planNumber);
            $recipe = $em->getRepository(Recipe::class)->find($recipeNumber);
            $dayName = $em->getRepository(DayName::class)->find($dayNumber);
            $recipePlan->setRecipe($recipe);
            $recipePlan->setPlan($plan);
            $recipePlan->setDayName($dayName);
            var_dump($recipePlan);
            $em->persist($recipePlan);
            $em->flush();
        }
    }
}
