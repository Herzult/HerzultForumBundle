<?php

namespace Herzult\Bundle\ForumBundle\Creator;

use Herzult\Bundle\ForumBundle\Model\Post;
use DateTime;
use LogicException;

class PostCreator
{
    public function create(Post $post)
    {
        if(!$topic = $post->getTopic()) {
            throw new LogicException('Each post must have a topic');
        }
        if(!$category = $topic->getCategory()) {
            throw new LogicException('Each topic must have a category');
        }

        if(!$topic->getFirstPost()) {
            $topic->setFirstPost($post);
        }
        $topic->incrementNumPosts();
        $topic->setLastPost($post);
        $topic->setPulledAt(new DateTime());

        $category->setLastPost($post);
        $category->incrementNumPosts();

        $post->setNumber($topic->getNumPosts());
    }
}
