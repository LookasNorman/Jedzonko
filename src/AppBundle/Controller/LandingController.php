<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LandingController extends Controller
{
    public function indexAction(): Response
    {
        return $this->render('landing/index.html.twig', []);
    }

    public function recipesAction(): Response
    {
        return $this->render('landing/recipes.html.twig', []);
    }

    public function recipeDetailsAction(): Response
    {
        return $this->render('landing/recipeDetails.html.twig', []);
    }
}
