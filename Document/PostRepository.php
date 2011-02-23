<?php

namespace Bundle\ForumBundle\Document;

use Bundle\ForumBundle\Model\PostRepositoryInterface;
use Zend\Paginator\Paginator;
use ZendPaginatorAdapter\DoctrineMongoDBAdapter;

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
        $query = $this->createQueryBuilder()
            ->sort('createdAt', 'ASC')
            ->field('topic.$id')
            ->equals(new \MongoId($topic->getId()));

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($query));
        }

        return array_values($query->getQuery()->execute()->toArray());
    }

    /**
     * @see PostRepositoryInterface::findRecentByTopic
     */
    public function findRecentByTopic($topic, $number)
    {
        $query = $this->createQueryBuilder()
            ->field('topic.$id')
            ->equals(new \MongoId($topic->getId()))
            ->sort('createdAt', 'DESC')
            ->limit((int) $number);

        return array_values($query->getQuery()->execute()->toArray());
    }

    /**
     * @see PostRepositoryInterface::search
     */
    public function search($query, $asPaginator = false)
    {
        $regexp = new \MongoRegex('/' . $query . '/i');
        $query = $this->createQueryBuilder()
            ->sort('createdAt', 'ASC')
            ->field('message')->equals($regexp)
        ;

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($query));
        }

        return array_values($query->getQuery()->execute()->toArray());
    }

    /**
     * Gets the post that preceds this one
     *
     * @return Post or null
     **/
    public function getPostBefore($post)
    {
        $candidate = null;
        foreach ($this->findAllByTopic($post->getTopic()) as $p) {
            if ($p->getNumber() > $post->getNumber()) {
                return $candidate;
            }
            $candidate = $p;
        }
    }

    /**
     * @see PostRepositoryInterface::createNewPost
     */
    public function createNewPost()
    {
        $class = $this->getObjectClass();

        return new $class();
    }
}
