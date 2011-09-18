<?php

namespace Herzult\Bundle\ForumBundle\Document;

use Herzult\Bundle\ForumBundle\Model\TopicRepositoryInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;

class TopicRepository extends ObjectRepository implements TopicRepositoryInterface
{
    /**
     * @see TopicRepositoryInterface::findOneByCategoryAndSlug
     */
    public function findOneByCategoryAndSlug($category, $slug)
    {
        return $this->findOneBy(array(
            'slug' => $slug,
            'category.$id' => new \MongoId($category->getId())
        ));
    }

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
        $query = $this->createQueryBuilder()->sort('pulledAt', 'DESC');

        if ($asPaginator) {
            return new Pagerfanta(new DoctrineODMMongoDBAdapter($query));
        }

        return array_values($query->getQuery()->execute()->toArray());
    }

    /**
     * @see TopicRepositoryInterface::findAllByCategory
     */
    public function findAllByCategory($category, $asPaginator = false)
    {
        $query = $this->createQueryBuilder('t')
            ->field('category.$id')->equals(new \MongoId($category->getId()))
            ->sort('pulledAt', 'DESC')
        ;

        if ($asPaginator) {
            return new Pagerfanta(new DoctrineODMMongoDBAdapter($query));
        }

        return array_values($query->getQuery()->execute()->toArray());
    }

    /**
     * @see TopicRepositoryInterface::findLatestPosted
     */
    public function findLatestPosted($number)
    {
        $query = $this->createQueryBuilder()->sort('pulledAt', 'DESC')->limit($number);

        return array_values($query->getQuery()->execute()->toArray());
    }

    /**
     * @see TopicRepositoryInterface::search
     */
    public function search($query, $asPaginator = false)
    {
        $regexp = new \MongoRegex('/' . $query . '/i');
        $query = $this->createQueryBuilder()
            ->sort('pulledAt', 'DESC')
            ->field('subject')->equals($regexp)
        ;

        if ($asPaginator) {
            return new Pagerfanta(new DoctrineODMMongoDBAdapter($query));
        }

        return array_values($query->getQuery()->execute()->toArray());
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

    /**
     * @see TopicRepositoryInterface::createNewTopic
     */
    public function createNewTopic()
    {
        $class = $this->getObjectClass();

        return new $class();
    }
}
