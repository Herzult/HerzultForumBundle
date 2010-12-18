<?php

namespace Bundle\SosForum\CoreBundle\Model;

interface TopicRepositoryInterface extends RepositoryInterface
{
    /**
     * Finds one topic by its category and its slug
     *
     * @param Category $category
     * @paral string $slug
     * @return Topic or NULL
     **/
    public function findOneByCategoryAndSlug($category, $slug);

    /**
     * Finds one topic by its id
     *
     * @param integer $id
     * @return Topic or NULL whether the specified id does not match any topic
     */
    public function findOneById($id);

    /**
     * Finds all topics ordered by their last pull date
     *
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return array|Paginator
     */
    public function findAll($asPaginator);

    /**
     * Finds all topics matching to the specified Category ordered by their
     * last pull date
     *
     * @param integer|Category $category
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return array|Paginator
     */
    public function findAllByCategory($category, $asPaginator);

    /**
     * Get topics which have the more recent last post
     *
     * @param int $number
     * @return array of Topics
     */
    public function findLatestPosted($number);

    /**
     * Finds all topics matching the specified query ordered by their
     * last pulled date
     *
     * @param string $query
     * @param boolean $asPaginator Will return a Paginator instance if true
     * @return array|Paginator
     */
    public function search($query, $asPaginator);

    /**
     * Increment the number of views of a topic
     *
     * @param Topic $topic
     * @return void
     */
    public function incrementTopicNumViews($topic);
}
