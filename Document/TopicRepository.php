<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\DAO\TopicRepositoryInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DoctrineMongoDBAdapter;

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
        $query = $this->createQuery()->sort('pulledAt', 'DESC');

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }

    /**
     * @see TopicRepositoryInterface::findAllByCategory
     */
    public function findAllByCategory($category, $asPaginator = false)
    {
        $query = $this->createQuery('t')
            ->field('category.$id')->equals(new \MongoId($category->getId()))
            ->sort('pulledAt', 'DESC')
        ;

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }

    /**
     * @see TopicRepositoryInterface::findLatestPosted
     */
    public function findLatestPosted($number)
    {
        $query = $this->createQuery()->sort('pulledAt', 'DESC')->limit($number);

        return array_values($query->execute()->getResults());
    }

    /**
     * @see TopicRepositoryInterface::search
     */
    public function search($query, $asPaginator = false)
    {
        $regexp = new \MongoRegex('/' . $query . '/i');
        $query = $this->createQuery()
            ->sort('pulledAt', 'DESC')
            ->field('subject')->equals($regexp)
        ;

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }

    /**
     * @see TopicRepositoryInterface::incrementTopicNumViews
     */
    public function incrementTopicNumViews($topic)
    {
        $this->getDocumentManager()
            ->getDocumentCollection($this->getDocumentName())
            ->getMongoCollection()
            ->update(array('_id' => new \MongoId($topic->getId())), array('$inc' => array('numViews' => 1)));
    }
}
