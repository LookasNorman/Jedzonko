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
