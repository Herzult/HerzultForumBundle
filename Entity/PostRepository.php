<?php

namespace Herzult\Bundle\ForumBundle\Entity;

use Herzult\Bundle\ForumBundle\Model\PostRepositoryInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

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
            return new Pagerfanta(new DoctrineORMAdapter($qb->getQuery()));
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
        $qb
			->where($qb->expr()->like('post.message', $qb->expr()->literal('%' . $query . '%')))
			->orderBy('post.createdAt')
		;

        if ($asPaginator) {
            return new Pagerfanta(new DoctrineORMAdapter($qb->getQuery()));
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
            if($p !== $post) {
                if ($p->getNumber() > $post->getNumber()) {
                    break;
                }
                $candidate = $p;
            }
        }

        return $candidate;
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
