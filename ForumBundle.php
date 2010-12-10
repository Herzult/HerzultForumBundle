<?php

namespace Bundle\ForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DoctrineExtensions\Sluggable\SluggableListener;

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
        $eventManager = $this->container->get('forum.object_manager')->getEventManager();

        $sluggableListener = new SluggableListener($eventManager);
    }

}
