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

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
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

    public function urlForCategory(Category $category)
    {
        return $this->router->generate('forum_category', array(
            'category_slug' => $category->getSlug()
        ));
    }

    public function urlForTopic(Topic $topic)
    {
        return $this->router->generate('forum_topic', array(
            'topic_id' => $topic->getId()
        ));
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