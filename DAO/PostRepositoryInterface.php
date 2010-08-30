<?php

namespace Bundle\ForumBundle\DAO;

interface PostRepositoryInterface extends RepositoryInterface
{

    /**
     * Finds one post by its id
     *
     * @param integer $id
     * @return Post or NULL whether the specified id does not match any post
     */
    public function findOneById($id);
}