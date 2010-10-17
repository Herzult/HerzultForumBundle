<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\DAO\TopicRepositoryInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DoctrineORMAdapter;

class TopicRepository extends ObjectRepository implements TopicRepositoryInterface
{

    /**
     * @see TopicRepositoryInterface::findOneById
     */
    public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

    /**
     * @see TopicRepositoryInterface::findAll
     */
    public function findAll($asPaginator = false)
    {
        $query = $this->createQueryBuilder('topic')
                        ->orderBy('topic.pulledAt', 'DESC')
                        ->getQuery();

        if ($asPaginator) {
            return new Paginator(new DoctrineORMAdapter($query));
        } else {
            return $query->execute();
        }
    }

    /**
     * @see TopicRepositoryInterface::findAllByCategory
     */
    public function findAllByCategory($category, $asPaginator = false)
    {
        $query = $this->createQueryBuilder('topic')
                        ->orderBy('topic.pulledAt', 'DESC')
                        ->where('topic.category = :category')
                        ->setParameter('category', $category)
                        ->getQuery();

        if ($asPaginator) {
            return new Paginator(new DoctrineORMAdapter($query));
        } else {
            return $query->execute();
        }
    }

    /**
     * @see TopicRepositoryInterface::findLatestPosted
     */
    public function findLatestPosted($number)
    {
        return $this->createQueryBuilder('topic')
            ->orderBy('topic.pulledAt', 'DESC')
            ->setMaxResults($number)
            ->getQuery()
            ->execute();
    }

    /**
     * @see TopicRepositoryInterface::search
     */
    public function search($query, $asPaginator = false)
    {
        $qb = $this->createQueryBuilder('topic');
        $qb->orderBy('topic.pulledAt DESC')->where($db->expr()->like('topic.subject', '%' . $query . '%'));

        if ($asPaginator) {
            return new Paginator(new DoctrineORMAdapter($qb->getQuery()));
        }

        return $qb->getQuery->execute();
    }

    /**
     * @see TopicRepositoryInterface::incrementTopicNumViews
     */
    public function incrementTopicNumViews($topic)
    {
        $this->createQueryBuilder('topict')
            ->update()
            ->set('topic.numViews', 'topic.numViews + 1')
            ->where('topic.id = :topic_id')
            ->setParameter('topic_id', $topic->id)
            ->getQuery()
            ->execute();
    }
}
