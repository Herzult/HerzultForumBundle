<?php

namespace Herzult\Bundle\ForumBundle\Twig;

use Herzult\Bundle\ForumBundle\Router\ForumUrlGenerator;
use Twig_Extension;
use Twig_Function_Method;
use Herzult\Bundle\ForumBundle\Model\Category;
use Herzult\Bundle\ForumBundle\Model\Topic;
use Herzult\Bundle\ForumBundle\Model\Post;

class ForumExtension extends Twig_Extension
{
    protected $urlGenerator;

    public function __construct(ForumUrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
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
            'forum_topicNumPages' => new \Twig_Function_Method($this, 'topicNumPages', array(
                'is_safe' => array('html')
            )),
            'forum_autoLink' => new \Twig_Function_Method($this, 'autoLink', array(
                'is_safe' => array('html')
            )),
        );
    }

    public function urlForCategory(Category $category, $absolute = false)
    {
        return $this->urlGenerator->urlForCategory($category, $absolute);
    }

    public function urlForCategoryAtomFeed(Category $category, $absolute = false)
    {
        return $this->urlGenerator->urlForCategoryAtomFeed($category, $absolute);
    }

    public function urlForTopic(Topic $topic, $absolute = false)
    {
        return $this->urlGenerator->urlForTopic($topic, $absolute);
    }

    public function urlForTopicAtomFeed(Topic $topic, $absolute = false)
    {
        return $this->urlGenerator->urlForTopicAtomFeed($topic, $absolute);
    }

    public function urlForTopicReply(Topic $topic, $absolute = false)
    {
        return $this->urlGenerator->urlForTopicReply($topic, $absolute);
    }

    public function urlForPost(Post $post, $absolute = false)
    {
        return $this->urlGenerator->urlForPost($post, $absolute);
    }

    public function topicNumPages(Topic $topic)
    {
        return $this->urlGenerator->getTopicNumPages($topic);
    }

    public function autoLink($text)
    {
        return $this->urlGenerator->autoLink($text);
    }

    public function getName()
    {
        return 'herzult_forum';
    }
}
