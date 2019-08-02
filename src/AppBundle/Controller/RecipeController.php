<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RecipeController extends Controller
{
    /**
     * @return Response
     * @Route("/recipe/add/")
     *
     */
    public function addAction(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createFormBuilder($recipe)
            ->setAction($this->generateUrl('app_recipe_add'))
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('preparationTime', NumberType::class)
            ->add('recipePreparationMethod', TextareaType::class)
            ->add('ingredients', TextareaType::class)
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
