<?php

namespace Herzult\Bundle\ForumBundle\Model;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * Finds a category by its slug
     *
     * @param string $slug The slug of the category which should be found.
     *
     * @return Category or NULL whether the specified slug does not match any category
     */
    function findOneBySlug($slug);

    /**
     * Find all categories
     *
     * @return Category[] An array of Category objects
     */
    function findAll();

    /**
     * Find all sub categories for the given id
     *
     * @param integer $id
     *
     * @return Category[] An array of Category objects
     */
    function findAllSubCategories($id);

    /**
     * Find all categories without a parent - so called root categories.
     *
     * @return Category[] An array of Category objects
     */
    function findAllRootCategories();



    /**
     * Find all categories indexed by id
     *
     * @return Category[] An array of Category objects
     */
    function findAllIndexById();
}
