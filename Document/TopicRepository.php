<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\DAO\TopicRepositoryInterface;
use Zend\Paginator\Paginator;
use Bundle\DoctrinePaginatorBundle\PaginatorODMAdapter;

class TopicRepository extends ObjectRepository implements TopicRepositoryInterface
{

    /**
     * @see TopicRepositoryInterface::findOneById
     */
    public function findOneById($id)
    {
        return $this->find($id);
    }

    /**
     * @see TopicRepositoryInterface::findAll
     */
    public function findAll($asPaginator = false)
    {
        $query = $this->createQuery()->sort('pulledAt', 'ASC');

        if ($asPaginator) {
            return new Paginator(new PaginatorODMAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }

    /**
     * @see TopicRepositoryInterface::findAllByCategory
     */
    public function findAllByCategory($category, $asPaginator = false)
    {
        $query = $this->createQuery()
            ->sort('pulledAt', 'DESC')
            ->field('category.$id')
            ->equals(new \MongoId($category->getId()));

        if ($asPaginator) {
            return new Paginator(new PaginatorODMAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }

    /**
     * @see TopicRepositoryInterface::findLatestPosted
     */
    public function findLatestPosted($number)
    {
        $query = $this->createQuery();

        return array_values($query->execute()->getResults());
    }

}
