<?php

namespace Bundle\ForumBundle\Model;

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
     * Finds all posts matching the specified Topic ordered by their
     * last created date
     *
     * @param Topic $topic
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return array|Paginator
     */
    public function findAllByTopic($topic, $asPaginator);

    /**
     * Finds more recent posts matching the specified Topic
     *
     * @param Topic $topic
     * @param int $number max number of posts to fetch
     * @return array of Post
     */
    public function findRecentByTopic($topic, $number);

    /**
     * Finds all posts matching the specified query ordered by their
     * last created date
     *
     * @param string $query
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return array|Paginator
     */
    public function search($query, $asPaginator);

    /**
     * Creates a new post instance
     *
     * @return Post
     */
    public function createNewPost();
}
