<?php

namespace Bundle\ForumBundle\Blamer;

use Bundle\ForumBundle\Model\Topic;

class TopicBlamer extends AbstractSecurityBlamer implements BlamerInterface
{
    public function blame(Topic $post)
    {
        // Here, use $this->security to give the topic a user or username
    }
}
