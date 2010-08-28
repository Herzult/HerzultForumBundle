<?php

namespace Bundle\ForumBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }
}