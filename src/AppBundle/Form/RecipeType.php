<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'w-100 p-1',
                    'rows' => 5
                ]
            ])
            ->add('recipePreparationMethod', TextareaType::class, [
                'attr' => [
                    'class' => 'w-100 p-1',
                    'rows' => 10
                ]
            ])
            ->add('preparationTime', NumberType::class, [
                'attr' => [
                    'class' => 'p-1'
                ]
            ]);
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
