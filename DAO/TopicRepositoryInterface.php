<?php

namespace Bundle\ForumBundle\DAO;

interface TopicRepositoryInterface extends RepositoryInterface
{

    /**
     * Finds one topic by its id
     *
     * @param integer $id
     * @return Topic or NULL whether the specified id does not match any topic
     */
    public function findOneById($id);
}