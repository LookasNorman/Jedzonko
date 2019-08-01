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

        for ($i = 1; $i <= count($allRecipes); $i++) {
            $allRecipesLengthArray[] = $i;
        }
        shuffle($allRecipesLengthArray);

        $firstRandomRecipeName = ($allRecipes[$allRecipesLengthArray[0]])->getName();
        $firstRandomRecipeDesc = ($allRecipes[$allRecipesLengthArray[0]])->getDescription();
        $secondRandomRecipeName = ($allRecipes[$allRecipesLengthArray[1]])->getName();
        $secondRandomRecipeDesc = ($allRecipes[$allRecipesLengthArray[1]])->getDescription();
        $thirdRandomRecipeName = ($allRecipes[$allRecipesLengthArray[2]])->getName();
        $thirdRandomRecipeDesc = ($allRecipes[$allRecipesLengthArray[2]])->getDescription();

        return $this->render("landing/index.html.twig", [
            "firstRecipeName" => $firstRandomRecipeName,
            "firstRecipeDesc" => $firstRandomRecipeDesc,
            "secondRecipeName" => $secondRandomRecipeName,
            "secondRecipeDesc" => $secondRandomRecipeDesc,
            "thirdRecipeName" => $thirdRandomRecipeName,
            "thirdRecipeDesc" => $thirdRandomRecipeDesc
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
     * @Route ("/recipe/list/{id}", name="recipe_details", methods={"GET"})
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
