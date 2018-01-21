<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            1 => 'Perso',
            2 => 'Pro'
        ];

        foreach ($categories as $numberPriority => $type){
            $priority = new Category();
            $priority->setName($type);
            $manager->persist($priority);

            $this->addReference('categ_' . $numberPriority, $priority);

        }
        $manager->flush();

    }
}