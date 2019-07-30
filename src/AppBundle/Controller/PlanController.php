<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PlanController extends Controller
{
    public function addAction(): Response
    {
        return $this->render('dashboard/plan/add.html.twig', []);
    }

    public function editAction(): Response
    {
        return $this->render('dashboard/plan/edit.html.twig', []);
    }

    public function detailsAction(): Response
    {
        return $this->render('dashboard/plan/details.html.twig', []);
    }

    public function listAction(): Response
    {
        return $this->render('dashboard/plan/list.html.twig', []);
    }

    public function addRecipeAction(): Response
    {
        return $this->render('dashboard/plan/addRecipe.html.twig', []);
    }
}
