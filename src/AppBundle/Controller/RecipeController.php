<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route ("/recipe/{id}", methods={"POST"})
     */
    public function detailsAction(Request $request): Response
    {
        $plus = $request->request->get('plus');
        $minus = $request->request->get('minus');
        $recipeId = $request->request->get('recipeId');
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository(Recipe::class)->find($recipeId);

        if ($plus) {
            $recipe->setVotes($recipe->getVotes() + 1);
        }
        if ($minus) {
            $recipe->setVotes($recipe->getVotes() - 1);
        }
        $em->persist($recipe);
        $em->flush();

        return $this->redirectToRoute('recipe_details', [
            'id' => $recipeId
        ]);
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
