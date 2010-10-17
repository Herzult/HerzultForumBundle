<?php

namespace Bundle\ForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\ODM\MongoDB\ODMEvents;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\Events as ORMEvents;
use Doctrine\ORM\EntityManager;

class ForumBundle extends Bundle
{

    /**
     * Get a EntityRepository or a DocumentRepository, based on db driver configuration
     *
     * @param mixed $objectManager a EntityManager or a DocumentManager
     * @param mixed $objectClass the class of the entity or document
     * @return mixed a EntityRepository or DocumentRepository
     */
    public static function getRepository($objectManager, $objectClass)
    {
        return $objectManager->getRepository($objectClass);
    }

    public function boot()
    {
        $om = $this->container->get('forum.object_manager');
        $eventManager = $om->getEventManager();
        if($om instanceof DocumentManager) {
            $eventManager->addEventListener(array(ODMEvents::loadClassMetadata), $this->container->get('forum.class_metadata_listener'));
        }
        elseif($om instanceof EntityManager) {
            $eventManager->addEventListener(array(ORMEvents::loadClassMetadata), $this->container->get('forum.class_metadata_listener'));
        }
    }

}
