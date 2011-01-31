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
            'forum_urlForPost' => new \Twig_Function_Method($this, 'urlForPost', array(
                'is_safe' => array('html')
            )),
            'forum_urlForCategory' => new \Twig_Function_Method($this, 'urlForCategory', array(
                'is_safe' => array('html')
            )),
            'forum_urlForCategoryAtomFeed' => new \Twig_Function_Method($this, 'urlForCategoryAtomFeed', array(
                'is_safe' => array('html')
            )),
            'forum_urlForTopic' => new \Twig_Function_Method($this, 'urlForTopic', array(
                'is_safe' => array('html')
            )),
            'forum_urlForTopicAtomFeed' => new \Twig_Function_Method($this, 'urlForTopicAtomFeed', array(
                'is_safe' => array('html')
            )),
            'forum_urlForTopicReply' => new \Twig_Function_Method($this, 'urlForTopicReply', array(
                'is_safe' => array('html')
            )),
            'forum_autoLink' => new \Twig_Function_Method($this, 'autoLink', array(
                'is_safe' => array('html')
            ))
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
