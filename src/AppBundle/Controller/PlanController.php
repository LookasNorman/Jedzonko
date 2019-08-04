<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RecipePlan;
use AppBundle\Form\PlanType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Plan;
use AppBundle\Form\RecipePlanType;
use Symfony\Component\HttpFoundation\Session\Session;


class PlanController extends Controller
{
    /**
     * @return Response
     * @Route("/plan/add/", name="add_plan")
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
     * @Route("/plan/edit/{id}", name="edit_plan")
     */
    public function editAction($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $plan = $em->getRepository(Plan::class)->find($id);

        $form = $this->createForm(PlanType::class, $plan);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $plan = $form->getData();
            $em->persist($plan);
            $em->flush();

            return $this->redirectToRoute('plan_list');
        }

        return $this->render('dashboard/plan/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/plan/list/{id}", name="plan_details", methods={"GET"})
     */
    public function detailsAction($id, Session $session): Response
    {
        $session->set('plan_id', $id);
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
     * @Route("/plan/list", name="plan_list")
     */
    public function listAction(Request $request, Session $session): Response
    {
        $session->remove('plan_id');
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT u FROM AppBundle:Plan u  ORDER BY u.name ASC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            50 /*limit per page*/
        );

        return $this->render('dashboard/plan/list.html.twig', ['pagination' => $pagination]);
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
                ->findBy(['dayName' => $dayName], ['mealOrder' => 'asc']);
        }

        return array($plan, $recipesDay);
    }
}
