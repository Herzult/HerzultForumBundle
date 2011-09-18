<?php

namespace Herzult\Bundle\ForumBundle\Remover;

use Herzult\Bundle\ForumBundle\Model\Topic;
use Herzult\Bundle\ForumBundle\Model\PostRepositoryInterface;
use Herzult\Bundle\ForumBundle\Updater\CategoryUpdater;
use LogicException;

class TopicRemover
{
    protected $objectManager;
    protected $postRepository;
    protected $categoryUpdater;

    public function __construct($objectManager, PostRepositoryInterface $postRepository, CategoryUpdater $categoryUpdater)
    {
        $this->objectManager   = $objectManager;
        $this->postRepository  = $postRepository;
        $this->categoryUpdater = $categoryUpdater;
    }

    public function remove(Topic $topic)
    {
        $category = $topic->getCategory();

        if(1 === $category->getNumTopics()) {
            throw new LogicException('You shall not remove the first category topic. Remove the category instead');
        }

        foreach ($this->getTopicPosts($topic) as $post) {
            $this->objectManager->remove($post);
        }
        $this->objectManager->remove($topic);

        // Must flush because the category updater will fetch topics from DB
        $this->objectManager->flush();

        $this->categoryUpdater->update($category);
    }

    protected function getTopicPosts(Topic $topic)
    {
        return $this->postRepository->findAllByTopic($topic);
    }
}
