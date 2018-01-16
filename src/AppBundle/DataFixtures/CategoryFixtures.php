<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Priority;
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
            $priority = new Priority();
            $priority->setType($type);
            $priority->setNumberPriority($numberPriority);
            $manager->persist($priority);

            $this->addReference('categ_' . $numberPriority, $priority);

        }
        $manager->flush();

    }

    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}