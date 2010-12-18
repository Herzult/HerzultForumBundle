<?php

namespace Bundle\SosForum\CoreBundle\Twig\Extension;

use Symfony\Bundle\TwigBundle\TokenParser\HelperTokenParser;

class ForumExtension extends \Twig_Extension
{
    /**
     * Returns the token parser instance to add to the existing list.
     *
     * @return array An array of Twig_TokenParser instances
     */
    public function getTokenParsers()
    {
        return array(
            // {% forum_post_route post %}
            new HelperTokenParser('forum_post_route', '<post>', 'forum.templating.helper.forum', 'urlForPost')
        );
    }

    public function getName()
    {
        return 'forum';
    }
}
