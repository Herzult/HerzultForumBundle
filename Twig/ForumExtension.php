<?php

namespace Bundle\ForumBundle\Twig;

use Bundle\ForumBundle\Router\ForumUrlGenerator;
use Twig_Extension;
use Twig_Function_Method;
use Bundle\ForumBundle\Model\Category;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Post;

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
            'forum_route_category'      => new Twig_Function_Method($this, 'urlForCategory'),
            'forum_route_category_feed' => new Twig_Function_Method($this, 'urlForCategoryAtomFeed'),
            'forum_route_topic'         => new Twig_Function_Method($this, 'urlForTopic'),
            'forum_route_topic_feed'    => new Twig_Function_Method($this, 'urlForTopicAtomFeed'),
            'forum_route_topic_reply'   => new Twig_Function_Method($this, 'urlForTopicReply'),
            'forum_route_post'          => new Twig_Function_Method($this, 'urlForPost'),
            'forum_topic_num_pages'     => new Twig_Function_Method($this, 'getTopicNumPages'),
            'forum_auto_link'           => new Twig_Function_Method($this, 'autoLink')
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

    public function getTopicNumPages(Topic $topic)
    {
        return $this->urlGenerator->getTopicNumPages($topic);
    }

    public function autoLink($text)
    {
        return $this->urlGenerator->autoLink($text);
    }

    public function getName()
    {
        return 'forum';
    }
}
