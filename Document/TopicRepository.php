<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\Model\TopicRepositoryInterface;
use Bundle\ForumBundle\Model\Category;
use Zend\Paginator\Paginator;
use ZendPaginatorAdapter\DoctrineMongoDBAdapter;

class TopicRepository extends ObjectRepository implements TopicRepositoryInterface
{
    /**
     * @see TopicRepositoryInterface::findOneByCategoryAndSlug
     */
    public function findOneByCategoryAndSlug(Category $category, $slug)
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
