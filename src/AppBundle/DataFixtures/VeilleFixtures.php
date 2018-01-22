<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Veille;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class VeilleFixtures extends  Fixture{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 100; $i++){
            $veille = new Veille();
            $veille->setName($faker->company);
            $veille->setLink($faker->url);
            $veille->setDescription($faker->realText(200));
            $manager->persist($veille);
        }

        $manager->flush();
    }
}