<?php

namespace AppBundle\Repository;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get all task content
     */
    public function myFindAll(){

        $qb = $this->createQueryBuilder('task');
        $qb->select('task.id', 'task.title', 'task.description', 'task.dateCreate', 'task.dateEnd', 'category.name as category_name')
            ->join('task.category', 'category')
            ->leftJoin('task.picture', 'picture')
            ->addSelect('picture.name as picture_name');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $id
     *
     * Get one elemen by id
     *
     * @return mixed
     */
    public function myFindOneById($id){
        $qb = $this->createQueryBuilder('t');
        $qb->select('picture.name as picture_name', 't.id', 't.title', 't.description', 't.dateCreate', 't.dateEnd', 'category.name as category_name')
            ->join('t.category', 'category')
            ->leftJoin('t.picture', 'picture')
            ->where('t.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @param $pattern
     *
     * @return mixed
     */
    public function findAutocompleteTitle($pattern){
        $qb = $this->createQueryBuilder('t');
        $qb->select('t.title')
            ->where('t.title LIKE :pattern')
            ->setParameter('pattern', '%' . $pattern . '%');

        return $qb->getQuery()->getResult();
    }
}
