<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\DAO\PostRepositoryInterface;
use Zend\Paginator\Paginator;
use Bundle\DoctrinePaginatorBundle\PaginatorODMAdapter;

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
     * @see TopicRepositoryInterface::findAllByTopic
     */
    public function findAllByTopic($topic, $asPaginator = false)
    {
        $query = $this->createQuery()
            ->sort('createdAt', 'DESC')
            ->field('topic.$id')
            ->equals(new \MongoId($topic->getId()));

        if ($asPaginator) {
            return new Paginator(new PaginatorODMAdapter($query));
        }

        return array_values($query->execute()->getResults());
    }

}
