<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\Model\PostRepositoryInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DoctrineMongoDBAdapter;

class PostRepository extends ObjectRepository implements PostRepositoryInterface
{

    /**
     * @see PostRepositoryInterface::findOneById
     */
    public function findOneById($id)
    {
        return $this->find($id);
    }

    /**
     * @see PostRepositoryInterface::findAllByTopic
     */
    public function findAllByTopic($topic, $asPaginator = false)
    {
        $query = $this->createQuery()
            ->sort('createdAt', 'ASC')
            ->field('topic.$id')
            ->equals(new \MongoId($topic->getId()));

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }

    /**
     * @see PostRepositoryInterface::search
     */
    public function search($query, $asPaginator = false)
    {
        $regexp = new \MongoRegex('/' . $query . '/i');
        $query = $this->createQuery()
            ->sort('createdAt', 'ASC')
            ->field('message')->equals($regexp)
        ;

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }
}
