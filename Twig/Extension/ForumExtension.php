<?php

namespace Bundle\ForumBundle\Twig\Extension;
use Bundle\ForumBundle\Templating\Helper\ForumHelper;

class ForumExtension extends \Twig_Extension
{
    protected $helper;

    public function __construct(ForumHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            'forum_post_route' => new \Twig_Function_Method($this, 'postRoute')
        );
    }

    public function postRoute($post)
    {
        return $this->helper->urlForPost($post);
    }

    public function getName()
    {
        return 'forum';
    }
}
