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

    /**
     * Finds all posts matching to the specified Topic ordered by their
     * last created date
     *
     * @param Topic $topic
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return array|Paginator
     */
    public function findAllByTopic($topic, $asPaginator);
}
