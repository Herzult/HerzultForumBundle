<?php

namespace Bundle\ForumBundle\Remover;

use Bundle\ForumBundle\Model\Post;
use Bundle\ForumBundle\Updater\TopicUpdater;

class PostRemover
{
    protected $objectManager;
    protected $topicUpdater;

    public function __construct($objectManager, TopicUpdater $topicUpdater)
    {
        $this->objectManager = $objectManager;
        $this->topicUpdater = $topicUpdater;
    }

    public function remove(Post $post)
    {
        $this->objectManager->remove($post);
        $this->topicUpdater->update($post->getTopic());
    }
}
