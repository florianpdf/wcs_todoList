<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Priority
 *
 * @ORM\Table(name="priority")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriorityRepository")
 */
class Priority
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="numberPriority", type="integer")
     */
    private $numberPriority;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Priority
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set numberPriority
     *
     * @param integer $numberPriority
     *
     * @return Priority
     */
    public function setNumberPriority($numberPriority)
    {
        $this->numberPriority = $numberPriority;

        return $this;
    }

    /**
     * Get numberPriority
     *
     * @return int
     */
    public function getNumberPriority()
    {
        return $this->numberPriority;
    }
}

