<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Recipe;



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
    public function recipesAction(): Response
    {
        return $this->render('dashboard/recipe/list.html.twig', []);
    }
    
    /**
     * @return Response
     * @Route ("/recipe/list/{id}")
     */
    
    public function recipeDetailsAction(): Response
    {
        return $this->render('landing/recipeDetails.html.twig', []);
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
