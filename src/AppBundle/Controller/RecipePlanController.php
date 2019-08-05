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
//        $recipesPlans = $em->getRepository(RecipePlan::class)->findBy(['recipe' => null]);
        $plans = $em->getRepository(Plan::class)->findAll();
        $daysName = $em->getRepository(DayName::class)->findAll();
        $recipes = $em->getRepository(Recipe::class)->findAll();
        $mealsName = ['śniadanie', 'obiad', 'kolacja'];
        foreach ($plans as $plan) {
            foreach ($daysName as $dayName) {
                foreach ($mealsName as $mealName) {
                    $recipePlan = new RecipePlan();
                    $recipePlan->setPlan($plan);
                    $recipePlan->setDayName($dayName);
                    $recipePlan->setMealName($mealName);
                    if($mealName == 'śniadanie') {
                        $recipePlan->setMealOrder(1);
                    } elseif ($mealName == 'obiad') {
                        $recipePlan->setMealOrder(2);
                    } else {
                        $recipePlan->setMealOrder(3);
                    }
                    $recipeIndex = array_rand($recipes);
                    $recipePlan->setRecipe($recipes[$recipeIndex]);
                    $em->persist($recipePlan);
                    $em->flush();
                }

            }


            var_dump($recipePlan);
            $em->persist($recipePlan);
            $em->flush();
        }
    }
}
