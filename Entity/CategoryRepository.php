<?php

namespace Herzult\Bundle\ForumBundle\Entity;

use Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class CategoryRepository extends ObjectRepository implements CategoryRepositoryInterface
{
    /**
     * @see CategoryRepositoryInterface::findOneBySlug
     */
    public function findOneBySlug($slug)
    {
        return $this->findOneBy(array('slug' => $slug));
    }

    /**
     * @see CategoryRepositoryInteface::findAll
     */
    public function findAll()
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->orderBy('c.position')
            ->getQuery()
            ->execute();
    }

    /**
     * @see CategoryRepositoryInteface::findAllRootCategories
     */
    public function findAllRootCategories()
    {
        return $this->createQueryBuilder('c')
                    ->select('c')
                    ->orderBy('c.position')
                    ->where('c.parentCategory is NULL')
                    ->getQuery()
                    ->execute();
    }

    /**
     * @see CategoryRepositoryInteface::findAllSubCategories
     */
    public function findAllSubCategories($id)
    {
        return $this->createQueryBuilder('c')
                    ->select('c')
                    ->where('c.parentCategory = ?1')
                    ->orderBy('c.position')
                    ->setParameter(1, $id)
                    ->getQuery()
                    ->execute();
    }

    /**
     * @see CategoryRepositoryInterface::findAllIndexById
     */
    public function findAllIndexById()
    {
        return $this->getObjectManager()
            ->createQuery(sprintf('SELECT category FROM %s category INDEX BY category.id ORDER BY category.position', $this->getObjectClass()))
            ->execute();
    }
}
