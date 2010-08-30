<?php

namespace Bundle\ForumBundle\DAO;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * Finds a category by its slug
     *
     * @return Category or NULL whether the specified slug does not match any category
     */
    public function findOneBySlug($slug);

    /**
     * Find all categories ordered by position
     *
     * @return array An array of Category objects
     */
    public function findAll();
}