<?php

namespace Bundle\ForumBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(array('slug' => $slug));
    }

    public function findAll()
    {
        return $this->createQueryBuilder('c')
                ->select('c')
                ->orderBy('c.position')
                ->getQuery()
                ->execute();
    }
}