<?php

namespace AppBundle\Form;

use AppBundle\Entity\Ingredients;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipesIngredients;
use AppBundle\Repository\IngredientsRepository;
use AppBundle\Repository\RecipeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipesIngredientsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredient', EntityType::class, [
                'class' => Ingredients::class,
                'choice_label' => 'ingredient',
                'query_builder' => function (IngredientsRepository $repo) {
                    return $repo->findAll();
                }
            ])
//            ->add('ingredient', EntityType::class, [
//
//            ])
            ->add('quantity', TextType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RecipesIngredients::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recipesingredients';
    }


}
