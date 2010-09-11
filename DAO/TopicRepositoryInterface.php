<?php

namespace Bundle\ForumBundle\DAO;

use Zend\Paginator\Paginator;

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
}