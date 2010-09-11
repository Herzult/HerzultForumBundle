<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\DAO\TopicRepositoryInterface;
use Bundle\DoctrinePaginatorBundle\Paginator;
use Bundle\DoctrinePaginatorBundle\PaginatorORMAdapter;

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
            return new Paginator(new PaginatorORMAdapter($query));
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
            return new Paginator(new PaginatorORMAdapter($query));
        } else {
            return $query->execute();
        }
    }

}