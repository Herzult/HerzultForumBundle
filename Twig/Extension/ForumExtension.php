<?php

namespace Bundle\ForumBundle\Twig\Extension;
use Bundle\ForumBundle\Templating\Helper\ForumHelper;
use Bundle\ForumBundle\Model\Category;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Post;

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
            'forum_urlForPost' => new \Twig_Function_Method($this, 'urlForPost'),
            'forum_urlForCategory' => new \Twig_Function_Method($this, 'urlForCategory'),
            'forum_urlForCategoryAtomFeed' => new \Twig_Function_Method($this, 'urlForCategoryAtomFeed'),
            'forum_urlForTopic' => new \Twig_Function_Method($this, 'urlForTopic'),
            'forum_urlForTopicAtomFeed' => new \Twig_Function_Method($this, 'urlForTopicAtomFeed'),
            'forum_urlForTopicReply' => new \Twig_Function_Method($this, 'urlForTopicReply'),
            'forum_autoLink' => new \Twig_Function_Method($this, 'autoLink')
        );
    }

    public function urlForCategory(Category $category, $absolute = false)
    {
        return $this->helper->urlForCategory($category, $absolute);
    }

    public function urlForCategoryAtomFeed(Category $category, $absolute = false)
    {
        return $this->helper->urlForCategoryAtomFeed($category, $absolute);
    }

    public function urlForTopic(Topic $topic, $absolute = false)
    {
        return $this->helper->urlForTopic($topic, $absolute);
    }

    public function urlForTopicAtomFeed(Topic $topic, $absolute = false)
    {
        return $this->helper->urlForTopicAtomFeed($topic, $absolute);
    }

    public function urlForTopicReply(Topic $topic, $absolute = false)
    {
        return $this->helper->urlForTopicReply($topic, $absolute);
    }

    public function urlForPost($post, $absolute = false)
    {
        return $this->helper->urlForPost($post);
    }

    public function autoLink($text)
    {
        return $this->helper->autoLink($text);
    }

    public function getName()
    {
        return 'forum';
    }
}
