<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class LandingController extends Controller
{
    /**
     * @return Response
     * @Route("/")
     */
    public function indexAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Recipe');
        $allRecipes = $repository->findAll();
        var_dump($allRecipes);die();

        shuffle($allRecipes);

        return $this->render("landing/index.html.twig", [
         "recipe1" => $allRecipes[0],
         "recipe2" => $allRecipes[1],
         "recipe3" => $allRecipes[2]
        ]);
    }
    
    /**
     * @return Response
     * @Route ("/recipe/list")
     */
    public function recipesAction(Request $request): Response
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT r FROM AppBundle:Recipe r ORDER BY r.votes DESC, r.created ASC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('dashboard/recipe/list.html.twig', ['pagination' => $pagination]);
    }
    
    /**
     * @return Response
     * @Route ("/recipe/{id}", name="recipe_details", methods={"GET"})
     */
    
    public function recipeDetailsAction($id): Response
    {
        $recipe = $this->getDoctrine()->getManager()->getRepository(Recipe::class)->find($id);

        return $this->render('landing/recipeDetails.html.twig', [
            'recipe' => $recipe
        ]);
    }
    
    /**
     * @return Response
     * @Route ("/about")
     */
    public function aboutAction(): Response
    {
        return $this->render('landing/about.html.twig', []);
    }
    
    /**
     * @return Response
     * @Route ("/contact")
     */
    public function contactAction(): Response
    {
        return $this->render('landing/contact.html.twig', []);
    }
}
