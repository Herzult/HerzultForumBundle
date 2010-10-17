<?php

namespace Bundle\ForumBundle\Doctrine\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ClassMetadataListener
{
    protected $classes;

    public function __construct(array $classes)
    {
        $this->classes = $classes;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        switch($classMetadata->name) {
            case 'Bundle\\ForumBundle\\Entity\\Category':
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'lastTopic', $this->classes['topic']);
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'lastPost', $this->classes['post']);
                break;
            case 'Bundle\\ForumBundle\\Entity\\Topic':
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'category', $this->classes['category']);
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'author', $this->classes['user']);
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'firstPost', $this->classes['post']);
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'lastPost', $this->classes['post']);
                break;
            case 'Bundle\\ForumBundle\\Entity\\Post':
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'topic', $this->classes['topic']);
                $this->replaceClassMetadatadaAssociationMappingTargetEntity($classMetadata, 'author', $this->classes['user']);
                break;
        }
    }

    protected function replaceClassMetadatadaAssociationMappingTargetEntity(ClassMetadata $classMetadata, $field, $targetEntity)
    {
        $associationMapping = $classMetadata->getAssociationMapping($field);
        $associationMapping['targetEntity'] = $targetEntity;
        $classMetadata->addInheritedAssociationMapping($associationMapping);
    }
}
