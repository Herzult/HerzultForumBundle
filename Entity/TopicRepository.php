<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\DAO\TopicRepositoryInterface;

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
    public function findAll($maxResults = null, $firstResult = null)
    {
        return $this->createQueryBuilder('topic')
                ->orderBy('topic.pulledAt', 'DESC')
                ->setMaxResults($maxResults)
                ->setFirstResult($firstResult)
                ->getQuery()
                ->execute();
    }

    /**
     * @see TopicRepositoryInterface::findAllByCategory
     */
    public function findAllByCategory($category, $maxResults = null, $firstResult = null)
    {
        return $this->createQueryBuilder('topic')
                ->orderBy('topic.pulledAt', 'DESC')
                ->setMaxResults($maxResults)
                ->setFirstResult($firstResult)
                ->where('topic.category = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->execute();
    }

}