<?php

namespace Herzult\Bundle\ForumBundle\Document;

use Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface;

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
     * @see CategoryRepositoryInterface::findAll
     */
    public function findAll()
    {
        return array_values($this->createQueryBuilder()->sort('position', 'ASC')->getQuery()->execute()->toArray());
    }

    /**
     * @see CategoryRepositoryInterface::findAllIndexById
     */
    public function findAllIndexById()
    {
        return $this->createQueryBuilder()->sort('position', 'ASC')->getQuery()->execute()->toArray();
    }

}
