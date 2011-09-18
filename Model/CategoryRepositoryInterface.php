<?php

namespace Herzult\Bundle\ForumBundle\Model;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * Finds a category by its slug
     *
     * @return Category or NULL whether the specified slug does not match any category
     */
    function findOneBySlug($slug);

    /**
     * Find all categories
     *
     * @return array An array of Category objects
     */
    function findAll();

    /**
     * Find all categories indexed by id
     *
     * @return array An array of Category objects
     */
    function findAllIndexById();
}
