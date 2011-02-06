<?php

namespace Bundle\ForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DoctrineExtensions\Sluggable\SluggableListener;

class ForumBundle extends Bundle
{

    public function boot()
    {
        $eventManager = $this->container->get('forum.object_manager')->getEventManager();

        $sluggableListener = new SluggableListener($eventManager);
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return __DIR__;
    }
}
