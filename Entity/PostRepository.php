<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\DAO\PostRepositoryInterface;

class PostRepository extends ObjectRepository implements PostRepositoryInterface
{

    /**
     * @see PostRepositoryInterface::findOneById
     */
    public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }
}
