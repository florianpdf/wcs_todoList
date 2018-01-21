<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Priority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PriorityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create priorities. Bam !!
        $priorities = [
            1 => 'High',
            2 => 'Medium',
            3 => 'Low'
        ];

        foreach ($priorities as $numberPriority => $type){
            $priority = new Priority();
            $priority->setType($type);
            $priority->setNumberPriority($numberPriority);
            $manager->persist($priority);

            $this->addReference('priority_' . $numberPriority, $priority);
        }
        $manager->flush();

    }

}