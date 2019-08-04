<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__ . '/fixtures.yml', $manager);
    }
}