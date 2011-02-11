<?php

namespace Bundle\ForumBundle\Model;

interface RepositoryInterface
{
    /**
     * Get the Entity manager or the Document manager, depending on the db driver
     *
     * @return mixed
     * */
    function getObjectManager();

    /**
     * Get the class of the User Entity or Document, depending on the db driver
     *
     * @return string a model fully qualified class name
     * */
    function getObjectClass();

    /**
     * Get the identifier property of the Permission
     *
     * @return string
     */
    function getObjectIdentifier();

    /**
     * Remove all entities/documents from a table/collection
     *
     * @return null
     */
    function cleanUp();
}
