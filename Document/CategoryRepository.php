<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\Model\CategoryRepositoryInterface;

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
        return array_values($this->createQuery()->sort('position', 'ASC')->execute()->getResults());
    }

    /**
     * @see CategoryRepositoryInterface::findAllIndexById
     */
    public function findAllIndexById()
    {
        return $this->createQuery()->sort('position', 'ASC')->execute()->getResults();
    }

}
