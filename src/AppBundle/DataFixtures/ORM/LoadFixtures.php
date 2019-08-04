<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\DayName;
use AppBundle\Entity\Ingredients;
use AppBundle\Entity\Page;
use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;
use Bezhanov\Faker\Provider\Food;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\pl_PL\Person;
use Faker\Provider\pl_PL\Text;

//use Nelmio\Alice\Fixtures;


class LoadFixtures extends Fixture implements ORMFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager)
    {
//        $objects = Fixtures::load(__DIR__ . '/fixtures.yml', $manager);

        $this->faker = Factory::create();
        $this->faker->addProvider(new Food($this->faker));
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Text($this->faker));


        for ($i = 0; $i < 200; $i++) {
            $ingredient = new Ingredients();
            $ingredient->setIngredient($this->faker->ingredient());
            $manager->persist($ingredient);
        }

        for ($i = 0; $i < 200; $i++) {
            $ingredient = new Ingredients();
            $ingredient->setIngredient($this->faker->spice());
            $manager->persist($ingredient);
        }

        for ($i = 0; $i < 200; $i++) {
            $plan = new Plan();
            $plan->setName('Plan - ' . $this->faker->unique()->name());
            $plan->setDescription($this->faker->realText(200, 2));
            $plan->setCreated($this->faker->dateTime);
            $manager->persist($plan);
        }

        for ($i = 0; $i < 200; $i++) {
            $recipe = new Recipe();
            $recipe->setName('Przepis -' . $this->faker->unique()->name());
            $recipe->setDescription($this->faker->realText(200, 2));
            $recipe->setRecipePreparationMethod($this->faker->realText(50, 2));
            $recipe->setPreparationTime($this->faker->numberBetween(1, 300));
            $recipe->setVotes($this->faker->numberBetween(1, 300));
            $recipe->setCreated($this->faker->dateTime());
            $manager->persist($recipe);
        }

        for ($i = 0; $i < 7; $i++) {
            $dayName = new DayName();
            $dayName->setDayName($this->faker->unique()->dayOfWeek());
            $dayName->setDayOrder($this->faker->numberBetween(7, 1));
            $manager->persist($dayName);
        }

        $page = new Page();
        $page->setTitle('O aplikacji');
        $page->setDescription($this->faker->realText(200, 2));
        $page->setSlug('about');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('Kontakt');
        $page->setDescription($this->faker->realText(200, 2));
        $page->setSlug('contact');
        $manager->persist($page);

        $manager->flush();
    }
}