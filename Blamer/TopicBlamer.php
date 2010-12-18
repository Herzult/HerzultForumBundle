<?php

namespace Bundle\SosForum\CoreBundle\Blamer;

class TopicBlamer extends AbstractSecurityBlamer implements BlamerInterface
{
    public function blame($topic)
    {
        // Here, use $this->security to give the topic a user or username
    }
}
