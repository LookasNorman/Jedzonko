<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    public function addAction(): Response
    {
        return $this->render('dashboard/recipe/add.html.twig', []);
    }

    public function editAction(): Response
    {
        return $this->render('dashboard/recipe/edit.html.twig', []);
    }

    public function detailsAction(): Response
    {
        return $this->render('dashboard/recipe/details.html.twig', []);
    }

    public function listAction(): Response
    {
        return $this->render('dashboard/recipe/list.html.twig', []);
    }
}
