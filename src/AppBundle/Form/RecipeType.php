<?php

namespace AppBundle\Form;

use AppBundle\Entity\Ingredients;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'error_bubbling' => true
            ])
            ->add('description', TextType::class)
            ->add('recipePreparationMethod', TextType::class)
            ->add('preparationTime', NumberType::class)
            ->add('ingredients', EntityType::class, [
                'class' => Ingredients::class,
                'choice_label' => 'ingredient',
//                'label' => 'Choose an ingredient',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recipe';
    }
}
