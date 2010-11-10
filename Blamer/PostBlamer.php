<?php

namespace Bundle\ForumBundle\Blamer;

use Bundle\ForumBundle\Model\Post;

class PostBlamer extends AbstractSecurityBlamer implements BlamerInterface
{
    public function blame(Post $post)
    {
        // Here, use $this->security to give the post a user or username
    }
}
