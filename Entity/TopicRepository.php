<?php

namespace Bundle\SosForum\CoreBundle\Entity;

use Bundle\SosForum\CoreBundle\Model\TopicRepositoryInterface;
use Zend\Paginator\Paginator;
use ZendPaginatorAdapter\DoctrineORMAdapter;

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
        $qb = $this->createQueryBuilder('topic');
        $qb->orderBy('topic.pulledAt', 'DESC')
            ->where($qb->expr()->eq('topic.category', $category->getId()));

        if ($asPaginator) {
            return new Paginator(new DoctrineORMAdapter($qb->getQuery()));
        } else {
            return $qb->getQuery()->execute();
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
        $this->createQueryBuilder('topic')
            ->update()
            ->set('topic.numViews', 'topic.numViews + 1')
            ->where('topic.id = :topic_id')
            ->setParameter('topic_id', $topic->getId())
            ->getQuery()
            ->execute();
    }
}
