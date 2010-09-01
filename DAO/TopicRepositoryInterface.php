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

    /**
     * Finds all topics ordered by their last pull date
     *
     * @return array An array of Topic objects
     */
    public function findAll($maxResults, $firstResult);

    /**
     * Finds all topics matching to the specified Category ordered by their
     * last pull date
     *
     * @param integer|Category $category
     * @return array An array of Topic objects
     */
    public function findAllByCategory($category, $maxResults, $firstResult);
}