<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RecipePlan;
use Faker\Provider\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Plan;
use AppBundle\Form\RecipePlanType;
use Symfony\Component\HttpFoundation\Session\Session;


class PlanController extends Controller
{
    /**
     * @return Response
     * @Route("/plan/add/")
     */
    public function addAction(Request $request, Session $session): Response
    {
        if($request->isMethod('post') !== true) {
            return $this->render('dashboard/plan/add.html.twig', []);
        }

        if($request->isMethod('post')) {
            if($request->get('planName') !== NULL){
                $planName = $request->get('planName');
            }

            if($request->get('planDescription') !== NULL){
                $planDescription = $request->get('planDescription');
            }

            $em = $this->getDoctrine()->getManager();
            $newPlan = new Plan();
            $newPlan->setName($planName);
            $newPlan->setDescription($planDescription);
            $dateTime = new \DateTime();
            $newPlan->setCreated($dateTime);

            $em->persist($newPlan);
            $em->flush();

            $session->set('plan_id', $newPlan->getId());

            return $this->redirectToRoute('add_plan_details');
        }
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
        $planDetails = $this->planDetails($id);
        $plan = $planDetails[0];
        $recipesDay = $planDetails[1];


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
        $session = $this->get('session');
        $session->remove('plan_id');
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
     * @Route("/plan/add/details", methods={"GET", "POST"}, name="add_plan_details")
     */
    public function addPlanDetails(Request $request)
    {
        $session = $this->get('session');
        //Check is set session plan_id
        if($request->isMethod('GET')){
            if (!$session->get('plan_id')) {
                throw new AccessDeniedHttpException('Brak id planu');
            }
        }
        $planId = $session->get('plan_id');
        //Get plan
        $plan = $this->getDoctrine()->getManager()->getRepository(Plan::class)->find($planId);
        $recipePlan = new RecipePlan();
        //Add plan to recipePlan
        $recipePlan->setPlan($plan);

        $form = $this->createForm(RecipePlanType::class, $recipePlan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipePlan = $form->getData();
            if($planId <> $recipePlan->getplan()->getid()) {
                throw new NotFoundHttpException('Zły plan');
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipePlan);
            $em->flush();

            return $this->redirectToRoute('new_plan_details', [
                'id' => $planId
            ]);
        }

        return $this->render('dashboard/plan/addRecipe.html.twig', [
            'plan' => $plan,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/newPlanDetails/{id}", name="new_plan_details", methods={"GET"})
     */
    public function newPlanDetails($id)
    {
        $planDetails = $this->planDetails($id);
        $plan = $planDetails[0];
        $recipesDay = $planDetails[1];

        return $this->render('dashboard/plan/newPlanDetails.html.twig', [
            'plan' => $plan,
            'recipesDay' => $recipesDay
        ]);
    }

    private function planDetails($id)
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

        return array($plan, $recipesDay);
    }
}
