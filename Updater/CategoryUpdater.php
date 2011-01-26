<?php

namespace Bundle\ForumBundle\Updater;

use Bundle\ForumBundle\Updater\UpdaterInterface;
use Bundle\ForumBundle\Model\TopicRepositoryInterface;

class CategoryUpdater implements UpdaterInterface
{
    protected $topicRepository;

    public function __construct(TopicRepositoryInterface $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function update($category)
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
    }
}
