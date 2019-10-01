<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\DayName;
use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipePlan;
use Bezhanov\Faker\Provider\Food;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\pl_PL\Person;
use Faker\Provider\pl_PL\Text;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class RecipePlanFixtures extends Fixture implements FixtureGroupInterface
{

    protected $faker;

    public function load(ObjectManager $manager)
    {

        $this->faker = Factory::create();
        $this->faker->addProvider(new Food($this->faker));
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Text($this->faker));

        $recipe = $manager->getRepository(Recipe::class)->findAll();
        foreach($recipe as $oneRecipe){

            var_dump($oneRecipe); exit;
            $re = new RecipePlan();
            $re->setRecipe($oneRecipe);
            $re->setMealName('plpl');
            $re->setMealOrder($this->faker->numberBetween(1, 5));

            $manager->persist($re);
        }

        for ($i = 0; $i < 200; $i++) {
            $re = new RecipePlan();
            foreach ($this->referenceRepository->getReferences((object)Recipe::class) as $key => $val) {
                $re->setRecipe($val);
            }
            foreach ($this->referenceRepository->getReferenceNames((object)Plan::class) as $key => $val) {
                $re->setPlan($val);
            }
            foreach ($this->referenceRepository->getReferenceNames((object)DayName::class) as $key => $val) {
                $re->setDayName($val);
            }
            $re->setMealName($this->faker->text(10));
            $re->setMealOrder($this->faker->numberBetween(1, 5));

            $manager->persist($re);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            Recipe::class,
            Plan::class,
            DayName::class,
        );
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
       return ['recipe_plan'];
    }
}