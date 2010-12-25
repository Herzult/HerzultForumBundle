<?php

namespace Bundle\ForumBundle\Creator;

use Bundle\ForumBundle\Model\Topic;
use DateTime;
use LogicException;

class TopicCreator
{
    public function create(Topic $topic)
    {
        if(!$category = $topic->getCategory()) {
            throw new LogicException('Each topic must have a category');
        }

        $category->incrementNumTopics();
        $category->setLastTopic($topic);
    }
}
