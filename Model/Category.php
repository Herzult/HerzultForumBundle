<?php

namespace Herzult\Bundle\ForumBundle\Model;

use Herzult\Bundle\ForumBundle\Util\Inflector;

abstract class Category
{
    protected $id;
    protected $name;
    protected $description;
    protected $slug;
    protected $position;
    protected $numTopics;
    protected $numPosts;
    protected $lastTopic;
    protected $lastPost;

    public function __construct()
    {
        $this->position = 0;
        $this->numTopics = 0;
        $this->numPosts = 0;
    }

    /**
     * Gets the id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Gets the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = Inflector::slugify($slug);
    }

    /**
     * Gets the slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Generates the slug whether it is empty
     */
    public function generateSlug()
    {
        if (empty($this->slug)) {
            $this->setSlug($this->getName());
        }
    }

    /**
     * Sets the position
     *
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = \intval($position);
    }

    /**
     * Gets the position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the number of topics
     *
     * @param integer $numTopics
     */
    public function setNumTopics($numTopics)
    {
        $this->numTopics = \intval($numTopics);
    }

    /**
     * Gets the number of topics
     *
     * @return integer
     */
    public function getNumTopics()
    {
        return $this->numTopics;
    }

    /**
     * Increments the number of topics
     */
    public function incrementNumTopics()
    {
        $this->numTopics++;
    }

    /**
     * Decrements the number of topics
     */
    public function decrementNumTopics()
    {
        $this->numTopics--;
    }

    /**
     * Gets the number of posts
     *
     * @return integer
     */
    public function getNumPosts()
    {
        return $this->numPosts;
    }

    /**
     * Sets the number of posts
     *
     * @param integer $numPosts
     */
    public function setNumPosts($numPosts)
    {
        $this->numPosts = \intval($numPosts);
    }

    /**
     * Increments the number of posts
     */
    public function incrementNumPosts()
    {
        $this->numPosts++;
    }

    /**
     * Decrements the number of posts
     */
    public function decrementNumPosts()
    {
        $this->numPosts--;
    }

    /**
     * Sets the last topic
     *
     * Sets the last topic, null for empty category
     *
     * @param Topic|null $topic
     */
    public function setLastTopic($topic)
    {
        $this->lastTopic = $topic;
    }

    /**
     * Gets the last topic
     *
     * @return Topic
     */
    public function getLastTopic()
    {
        return $this->lastTopic;
    }

    /**
     * Gets the last post
     *
     * @return Post
     */
    public function getLastPost()
    {
        return $this->lastPost;
    }

    /**
     * Sets the last post
     *
     * Sets the last post, null for empty category
     *
     * @param Post|null $post
     */
    public function setLastPost($post)
    {
        $this->lastPost = $post;
    }

    public function __toString()
    {
        return $this->name;
    }
}
