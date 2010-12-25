<?php

namespace Bundle\ForumBundle\Updater;

use Bundle\ForumBundle\Model\Category;
use Bundle\ForumBundle\Model\TopicRepositoryInterface;

class CategoryUpdater
{
    protected $objectManager;
    protected $topicRepository;

    public function __construct($objectManager, TopicRepositoryInterface $topicRepository)
    {
        $this->objectManager = $objectManager;
        $this->topicRepository = $topicRepository;
    }

    public function update(Category $category)
    {
        $topics = $this->topicRepository->findAllByCategory($category, false);
        $category->setNumTopics(count($topics));
        $numPosts = 0;
        $lastPost = $lastTopic = null;
        foreach($topics as $topic) {
            $numPosts += $topic->getNumPosts();
            $topicLastPost = $topic->getLastPost();
            if($topicLastPost->isPosteriorTo($lastPost)) {
                $lastPost = $topicLastPost;
                $lastTopic = $topic;
            }
        }
        $category->setNumPosts($numPosts);
        $category->setLastPost($lastPost);
        $category->setLastTopic($lastTopic);

        // Must flush to be consistent with topic updater
        $this->objectManager->flush();
    }
}
