<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends Controller
{
    /**
     * @return Response
     * @Route("/recipe/add/")
     *
     */
    public function addAction(): Response
    {
        return $this->render('dashboard/recipe/add.html.twig', []);
    }
    
    /**
     * @return Response
     * @Route("recipe/modify/{id}")
     */
    public function editAction(): Response
    {
        return $this->render('dashboard/recipe/edit.html.twig', []);
    }
    
    
    /**
     * @return Response
     * @Route ("/recipe/{id}")
     */
    public function detailsAction(): Response
    {
        return $this->render('dashboard/recipe/details.html.twig', []);
    }
   
    /**
     * @return Response
     * @Route ("/recipe/list")
     */
    public function listAction(): Response
    {
        return $this->render('dashboard/recipe/list.html.twig', []);
    }
}
