<?php

namespace Bundle\ForumBundle\Updater;

use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\PostRepositoryInterface;

class TopicUpdater
{
    protected $objectManager;
    protected $postRepository;
    protected $categoryUpdater;

    public function __construct($objectManager, PostRepositoryInterface $postRepository, CategoryUpdater $categoryUpdater)
    {
        $this->objectManager = $objectManager;
        $this->postRepository = $postRepository;
        $this->categoryUpdater = $categoryUpdater;
    }

    public function update(Topic $topic)
    {
        $posts = $this->postRepository->findAllByTopic($topic, false);

        $topic->setNumPosts(count($posts));
        $topic->setFirstPost(reset($posts));
        $topic->setLastPost(end($posts));

        foreach($posts as $index => $post) {
            $post->setNumber($index + 1);
        }

        // Must flush because the category updater will fetch topics from DB
        $this->objectManager->flush();

        $this->categoryUpdater->update($topic->getCategory());
    }
}
