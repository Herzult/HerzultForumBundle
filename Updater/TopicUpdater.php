<?php

namespace Bundle\ForumBundle\Updater;

use Bundle\ForumBundle\Updater\UpdaterInterface;
use Bundle\ForumBundle\Model\PostRepositoryInterface;

class TopicUpdater implements UpdaterInterface
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function update($topic)
    {
        $posts = $this->postRepository->findAllByTopic($topic, false);

        $topic->setNumPosts(count($posts));
        $topic->setFirstPost(reset($posts));
        $lastPost = end($posts);
        $topic->setLastPost($lastPost);
        $topic->setPulledAt($lastPost->getCreatedAt());

        foreach($posts as $index => $post) {
            $post->setNumber($index + 1);
        }
    }
}
