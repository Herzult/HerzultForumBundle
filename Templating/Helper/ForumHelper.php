<?php

namespace Bundle\ForumBundle\Templating\Helper;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\Helper\Helper;
use Bundle\ForumBundle\DAO\Category;
use Bundle\ForumBundle\DAO\Topic;
use Bundle\ForumBundle\DAO\Post;
use Bundle\DoctrineUserBundle\DAO\User;

class ForumHelper extends Helper
{
    protected $router;
    protected $nbPostsPerPage;

    public function __construct(RouterInterface $router, $nbPostsPerPage)
    {
        $this->router = $router;
        $this->nbPostsPerPage = $nbPostsPerPage;
    }

    public function urlFor($object = null)
    {
        if (null === $object) {
            return $this->urlForIndex();
        } elseif ($object instanceof Category) {
            return $this->urlForCategory($object);
        } elseif ($object instanceof Topic) {
            return $this->urlForTopic($object);
        } elseif ($object instanceof User) {

        } else {
            throw new \Exception(sprintf('Could not generate url for object "%s".', \get_class($object)));
        }
    }

    public function urlForIndex()
    {
        return $this->router->generate('forum_index');
    }

    public function urlForCategory(Category $category)
    {
        return $this->router->generate('forum_category_show', array(
            'slug' => $category->getSlug()
        ));
    }

    public function urlForTopic(Topic $topic)
    {
        return $this->router->generate('forum_topic_show', array(
            'id' => $topic->getId()
        ));
    }

    public function urlForPost(Post $post)
    {
        $topicUrl = $this->urlForTopic($post->getTopic());
        $topicPage = 1 + floor($post->getNumber() / $this->nbPostsPerPage);

        return sprintf('%s?page=%d#%d', $topicUrl, $topicPage, $post->getNumber());
    }

    public function urlForUser(User $user)
    {
        return $this->router->generate('doctrine_user_user_show', array(
           'username' => $user->getUsername()
        ));
    }

    public function getName()
    {
        return 'forum';
    }

}
