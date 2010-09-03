<?php

namespace Bundle\ForumBundle\DAO;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Topic
{
    protected $id;
    protected $subject;
    protected $numViews;
    protected $numReplies;
    protected $isClosed;
    protected $isPinned;
    protected $isBuried;
    protected $createdAt;
    protected $pulledAt;
    protected $category;
    protected $author;
    protected $firstPost;
    protected $lastPost;
    protected $posts;

    public function __construct()
    {
        $this->numViews = $this->numReplies = 0;
        $this->isClosed = $this->isPinned = $this->isBuried = false;
        $this->posts = new ArrayCollection();
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
     * Sets the subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Gets the subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the number of views
     *
     * @param string $numViews
     */
    public function setNumViews($numViews)
    {
        $this->numViews = \intval($numViews);
    }

    /**
     * Gets the number of views
     *
     * @return integer
     */
    public function getNumViews()
    {
        return $this->numViews;
    }

    /**
     * Increments the number of views
     */
    public function incrementNumViews()
    {
        $this->numViews++;
    }

    /**
     * Decrement the number of views
     */
    public function decrementNumViews()
    {
        $this->numViews--;
    }

    /**
     * Sets the number of replies
     *
     * @param integer $numReplies
     */
    public function setNumReplies($numReplies)
    {
        $this->numReplies = \intval($numReplies);
    }

    /**
     * Gets the number of replies
     *
     * @return integer
     */
    public function getNumReplies()
    {
        return $this->numReplies;
    }

    /**
     * Increments the number of replies
     */
    public function incrementNumReplies()
    {
        $this->numReplies++;
    }

    /**
     * Decrements the number of replies
     */
    public function decrementNumReplies()
    {
        $this->numReplies--;
    }

    /**
     * Defines whether the topic is closed or not
     *
     * @param boolean $isClosed
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = (bool) $isClosed;
    }

    /**
     * Indicates whether the topic is closed or not
     *
     * @return boolean
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * Defines whether the topic is pinned or not
     *
     * @param boolean $isPinned
     */
    public function setIsPinned($isPinned)
    {
        $this->isPinned = (bool) $isPinned;
    }

    /**
     * Indicates whether the topic is pinned or not
     *
     * @return booelan
     */
    public function getIsPinned()
    {
        return $this->isPinned;
    }

    /**
     * Defines whether the topoc is burried or not
     *
     * @param boolean $isBuried
     */
    public function setIsBuried($isBuried)
    {
        $this->isBuried = (bool) $isBuried;
    }

    /**
     * Indicates whether the topoc is burried or not
     *
     * @return <type>
     */
    public function getIsBuried()
    {
        return $this->isBuried;
    }

    /**
     * Sets the creation timestamp as now
     */
    public function setCreatedNow()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Gets the creation timestamp
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the pull timestamp as now
     */
    public function setPulledNow()
    {
        $this->pulledAt = new \DateTime('now');
    }

    /**
     * Gets the pull timestamp
     *
     * @return \DateTime
     */
    public function getPulledAt()
    {
        return $this->pulledAt;
    }

    /**
     * Sets the author
     *
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Gets the author
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Gets the first post
     *
     * @return Post
     */
    public function getFirstPost()
    {
        return $this->firstPost;
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
     * Adds a post
     *
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;

        if (count($this->posts) === 1) {
            $this->firstPost = $post;
        } else {
            $this->incrementNumReplies();
        }

        $this->lastPost = $post;
    }

    /**
     * Gets all posts
     *
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Sets the category
     *
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Gets the category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function incrementCategoryNumTopicsOnPrePersist()
    {
        if (empty($this->firstPost)) {
            throw new \Exception('You must add at least one post as first post to persist the topic.');
        }

        if (empty($this->category)) {
            throw new \Exception('You must set a category to persist the topic.');
        }

        $this->category->setLastTopic($this);
        $this->category->incrementNumTopics();
    }

    public function decrementCategoryNumTopicsOnPreRemove()
    {
        $this->category->decrementNumtopics();
    }

}