<?php

namespace AppBundle\Form;

use AppBundle\Entity\Ingredients;
use AppBundle\Entity\RecipesIngredients;
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
                'label' => 'Choose an ingredient',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false
            ])
            ->add('quantity', TextType::class)
        ;
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