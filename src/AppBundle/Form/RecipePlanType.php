<?php

namespace AppBundle\Form;

use AppBundle\Entity\DayName;
use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipePlanType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mealName', TextType::class)
            ->add('mealOrder', NumberType::class)
            ->add('recipe', EntityType::class, [
                'class' => Recipe::class,
                'choice_label' => 'name',
                'placeholder' => 'Wybierz przepis'
            ])
            ->add('dayName', EntityType::class, [
                'class' => DayName::class,
                'choice_label' => 'dayName',
                'placeholder' => 'Wybierz dzień'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RecipePlan'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recipeplan';
    }


}
