<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\DAO\PostRepositoryInterface;

class PostRepository extends ObjectRepository implements PostRepositoryInterface
{

    /**
     * @see PostRepositoryInterface::findOneById
     */
    public function findOneById($id)
    {
        return $this->find($id);
    }

}
