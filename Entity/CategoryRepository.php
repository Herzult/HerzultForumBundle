<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\DAO\CategoryRepositoryInterface;

class CategoryRepository extends ObjectRepository implements CategoryRepositoryInterface
{
    /**
     * @see CategoryRepositoryInterface::findOneBySlug
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(array('slug' => $slug));
    }

    /**
     * @see CategoryRepositoryInteface::findAll
     */
    public function findAll()
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->orderBy('c.position')
            ->getQuery()
            ->execute();
    }

    /**
     * @see CategoryRepositoryInterface::findAllIndexById
     */
    public function findAllIndexById()
    {
        return $this->createQueryBuilder('category')
            ->select('category')
            ->orderBY('category.position')
            ->getQuery()
            ->execute();
    }
}
