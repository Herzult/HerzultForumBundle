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
        if(1 === $post->getTopic()->getNumPosts()) {
            throw new LogicException('You shall not remove the first topic post. Remove the topic instead');
        }

        $this->objectManager->remove($post);

        // Must flush because the topic updater will fetch posts from DB
        $this->objectManager->flush();

        $this->topicUpdater->update($post->getTopic());
    }
}
