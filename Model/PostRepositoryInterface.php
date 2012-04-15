<?php

namespace Herzult\Bundle\ForumBundle\Model;

interface PostRepositoryInterface extends RepositoryInterface
{
    /**
     * Finds one post by its id
     *
     * @param integer $id
     * @return Post or NULL whether the specified id does not match any post
     */
    function findOneById($id);

    /**
     * Finds all posts matching the specified Topic ordered by their
     * last created date
     *
     * @param Topic $topic
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return Post[]|Paginator
     */
    function findAllByTopic($topic, $asPaginator);

    /**
     * Finds more recent posts matching the specified Topic
     *
     * @param Topic $topic
     * @param int $number max number of posts to fetch
     * @return Post[] of Post
     */
    function findRecentByTopic($topic, $number);

    /**
     * Finds all posts matching the specified query ordered by their
     * last created date
     *
     * @param string $query
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return Post[]|Paginator
     */
    function search($query, $asPaginator);

    /**
     * Gets the post that preceds this one
     *
     * @return Post or null
     **/
    public function getPostBefore($post);

    /**
     * Creates a new post instance
     *
     * @return Post
     */
    function createNewPost();
}
