<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\DAO\PostRepositoryInterface;

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
            ->where('post.topic_id = :topic_id')
            ->setParameter('topic_id', $topic->getId());

        if ($asPaginator) {
            return new Paginator(new DoctrineMongoDBAdapter($qb->getQuery()));
        }

        return $qb->getQuery()->execute();
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
}
