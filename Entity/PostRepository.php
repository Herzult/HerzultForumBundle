<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\Model\PostRepositoryInterface;
use Zend\Paginator\Paginator;
use ZendPaginatorAdapter\DoctrineORMAdapter;

class PostRepository extends ObjectRepository implements PostRepositoryInterface
{
    /**
     * @see PostRepositoryInterface::findOneById
     */
    public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

    /**
     * @see PostRepositoryInterface::findAllByTopic
     */
    public function findAllByTopic($topic, $asPaginator = false)
    {
        $qb = $this->createQueryBuilder('post')
            ->orderBy('post.createdAt')
            ->where('post.topic = :topic')
            ->setParameter('topic', $topic->getId());

        if ($asPaginator) {
            return new Paginator(new DoctrineORMAdapter($qb->getQuery()));
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @see PostRepositoryInterface::findRecentByTopic
     */
    public function findRecentByTopic($topic, $number)
    {
        return $this->createQueryBuilder('post')
            ->orderBy('post.createdAt', 'DESC')
            ->where('post.topic = :topic')
            ->setMaxResults($number)
            ->setParameter('topic', $topic->getId())
            ->getQuery()
            ->execute();
    }

    /**
     * @see PostRepositoryInterface::search
     */
    public function search($query, $asPaginator = false)
    {
        $qb = $this->createQueryBuilder('post');
        $qb->orderBy('post.createdAt')->where($qb->expr()->like('post.message', '%' . $query . '%'));

        if ($asPaginator) {
            return new Paginator(new DoctrineORMAdapter($qb->getQuery()));
        }

        return $qb->getQuery()->execute();
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
