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
            'categorySlug' => $topic->getCategory()->getSlug(),
            'id' => $topic->getId()
        ));
    }

    public function urlForTopicReply(Topic $topic)
    {
        $topicUrl = $this->urlForTopic($topic);
        $topicPage = ceil($topic->getNumPosts() / $this->nbPostsPerPage);

        return sprintf('%s?page=%d#reply', $topicUrl, $topicPage);
    }

    public function urlForPost(Post $post)
    {
        $topicUrl = $this->urlForTopic($post->getTopic());
        $topicPage = ceil($post->getNumber() / $this->nbPostsPerPage);

        return sprintf('%s?page=%d#%d', $topicUrl, $topicPage, $post->getNumber());
    }

    public function urlForUser(User $user)
    {
        return $this->router->generate('doctrine_user_user_show', array(
           'username' => $user->getUsername()
        ));
    }

    public function getTopicNumPages(Topic $topic)
    {
        return ceil($topic->getNumPosts() / $this->nbPostsPerPage);
    }

    public function autoLink($text)
    {
        return preg_replace_callback('~
            (                       # leading text
                <\w+.*?>|             #   leading HTML tag, or
                [^=!:\'"/]|           #   leading punctuation, or
                ^                     #   beginning of line
            )
            (
                (?:https?://)|        # protocol spec, or
                (?:www\.)             # www.*
            )
            (
                [-\w]+                   # subdomain or domain
                (?:\.[-\w]+)*            # remaining subdomains or domain
                (?::\d+)?                # port
                (?:/(?:(?:[\~\w\+%-]|(?:[,.;:][^\s$]))+)?)* # path
                (?:\?[\w\+%&=.;-]+)?     # query string
                (?:\#[\w\-]*)?           # trailing anchor
            )
            ([[:punct:]]|\s|<|$)    # trailing text
            ~x',
            function($matches)
            {
                if (preg_match("/<a\s/i", $matches[1])) {
                    return $matches[0];
                } else {
                    return $matches[1].'<a href="'.($matches[2] == 'www.' ? 'http://www.' : $matches[2]).$matches[3].'" target="_blank">'.$matches[2].$matches[3].'</a>'.$matches[4];
                }
            },
            $text
        );
    }

    public function getName()
    {
        return 'forum';
    }

}
