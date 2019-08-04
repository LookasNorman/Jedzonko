<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredients;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipesIngredients;
use AppBundle\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class RecipeController extends Controller
{
    /**
     * @return Response
     * @Route("/recipe/add/", name="recipe_add")
     *
     */
    public function addAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipe_list');
        }
        return $this->render('dashboard/recipe/add.html.twig', [
            'addForm' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route("recipe/modify/{id}", name="recipe_modify")
     */
    public function editAction($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Recipe::class);
        $existingRecipe = $repository->find($id);
        if (!$existingRecipe instanceof Recipe) {
            throw new NotFoundHttpException('Brak przepisu');
        }

        $recipe = new Recipe();
        $recipe->setName($existingRecipe->getName());
        $recipe->setDescription($existingRecipe->getDescription());
        $recipe->setPreparationTime($existingRecipe->getPreparationTime());
        $recipe->setRecipePreparationMethod($existingRecipe->getRecipePreparationMethod());
        $recipe->setIngredients($existingRecipe->getIngredients());

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('dashboard/recipe/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route ("/recipe/{id}", name="recipe_detail", methods={"POST"})
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
}
