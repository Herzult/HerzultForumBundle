<?php

namespace Bundle\ForumBundle\Document;

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
     * @see CategoryRepositoryInterface::findAll
     */
    public function findAll()
    {
        return $this->createQuery()->sort('position', 'ASC')->execute();
    }

}
