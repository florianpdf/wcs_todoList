<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $priority = $this->getReference('priority_1');
        $category = $this->getReference('categ_1');

        $task = new Task();

        $task->setPicture(null);
        $task->setPriority($priority);
        $task->setCategory($category);
        $task->setStatus(false);
        $task->setDescription('Ma première task perso');
        $task->setTitle('First task');
        $task->setDateCreate(new \DateTime());
        $task->setDateEnd(new \DateTime("+1 day"));

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            PriorityFixtures::class
        );
    }

    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}