<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipesIngredients;
use AppBundle\Form\RecipesIngredientsType;
use AppBundle\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RecipeController extends Controller
{
    /**
     * @return Response
     * @Route("/recipe/add/", name="recipe_add")
     *
     */
    public function addAction(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createFormBuilder($recipe)
            ->setAction($this->generateUrl('recipe_add'))
            ->add('name', TextType::class, ['label' => 'Nazwa Przepisu'])
            ->add('description', TextType::class, ['label' => 'Opis przepisu'])
            ->add('preparationTime', NumberType::class, ['label' => 'Przygotowanie(minuty)'])
            ->add('recipePreparationMethod', TextareaType::class, ['label' => 'Sposób przygotowania'])
            ->add('ingredients', TextareaType::class, ['label' => 'Składniki'])
            ->add('save', SubmitType::class, ['label' => 'wyślij'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
            return $this->redirectToRoute('app_recipe_add');
        }
        return $this->render('dashboard/recipe/add.html.twig', ['addForm' => $form->createView()]);
    }

    /**
     * @return Response
     * @Route("recipe/modify/{id}")
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

        $recipesIngredients = $em->getRepository(RecipesIngredients::class)->findAll();
        foreach ($recipesIngredients as $recipesIngredient) {
            $recipe->addRecipesIngredient($recipesIngredient);
        }

        $form = $this->createForm(RecipeType::class, $recipe);
//        $recipe = new RecipesIngredients();
//        $form = $this->createForm(RecipesIngredientsType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('dashboard/recipe/edit.html.twig', [
            'form' => $form->createView()
        ]);
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
