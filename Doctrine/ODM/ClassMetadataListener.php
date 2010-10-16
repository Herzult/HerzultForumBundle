<?php

namespace Bundle\ForumBundle\Doctrine\ODM;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Event\LoadClassMetadataEventArgs;

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
            case 'Bundle\\ForumBundle\\Document\\Category':
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'lastTopic', $this->classes['topic']);
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'lastPost', $this->classes['post']);
                break;
            case 'Bundle\\ForumBundle\\Document\\Topic':
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'category', $this->classes['category']);
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'author', $this->classes['user']);
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'firstPost', $this->classes['post']);
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'lastPost', $this->classes['post']);
                break;
            case 'Bundle\\ForumBundle\\Document\\Post':
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'topic', $this->classes['topic']);
                $this->replaceClassMetadatadaFieldMappingTargetDocument($classMetadata, 'author', $this->classes['user']);
                break;
        }
    }

    protected function replaceClassMetadatadaFieldMappingTargetDocument(ClassMetadata $classMetadata, $field, $targetDocument)
    {
        $fieldMapping = $classMetadata->getFieldMapping($field);
        $fieldMapping['targetDocument'] = $targetDocument;
        $classMetadata->addInheritedFieldMapping($fieldMapping);
    }
}
