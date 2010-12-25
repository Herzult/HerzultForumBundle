<?php

namespace Bundle\ForumBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Bundle\ForumBundle\Util\Inflector;
use DoctrineExtensions\Sluggable\Sluggable;

abstract class Topic implements Sluggable
{
    protected $id;
    /**
     * @validation:NotBlank()
     * @validation:MinLength(limit=4, message="Just a little too short.")
     */
    protected $subject;
    protected $slug;
    protected $numViews;
    protected $numPosts;
    protected $isClosed;
    protected $isPinned;
    protected $isBuried;
    protected $createdAt;
    protected $pulledAt;
    /**
     * @validation:NotBlank
     * @validation:Valid
     */
    protected $category;
    protected $firstPost;
    protected $lastPost;

    public function __construct()
    {
        $this->setCreatedNow();
        $this->numViews = $this->numPosts = 0;
        $this->isClosed = $this->isPinned = $this->isBuried = false;
    }

    /**
     * Return the name of this topic author
     *
     * @return string
     **/
    abstract public function getAuthorName();

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
     * Retrieves the slug field name
     *
     * @return string
     */
    public function getSlugFieldName()
    {
        return 'slug';
    }

    /**
     * Retrieves the slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Retrieves the Entity fields used to generate the slug value
     *
     * @return array
     */
    public function getSlugGeneratorFields()
    {
        return array('subject');
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
     * Sets the number of posts
     *
     * @param integer $numPosts
     */
    public function setNumPosts($numPosts)
    {
        $this->numPosts = \intval($numPosts);
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
     * Get the number of replies
     *
     * @return integer
     **/
    public function getNumReplies()
    {
        return $this->getNumPosts() - 1;
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
     * Updates the pull timestamp to the latest post creation date
     */
    public function updatePulledAt()
    {
        $this->pulledAt = $this->getLastPost()->getCreatedAt();
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
     * Gets the first post
     *
     * @return Post
     */
    public function getFirstPost()
    {
        return $this->firstPost;
    }

    /**
     * Sets the first post
     *
     * @param Post
     * @return null
     */
    public function setFirstPost(Post $post)
    {
        $this->firstPost = $post;
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
     * @param Post
     * @return null
     */
    public function setLastPost(Post $post)
    {
        $this->lastPost = $post;
        $this->updatePullAt();
    }

    /**
     * Adds a post
     *
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        if (!$this->firstPost) {
            $this->firstPost = $post;
        }

        $this->lastPost = $post;

        if($category = $this->getCategory()) {
            $category->setLastPost($post);
        }
    }

    /**
     * Sets the category
     *
     * @param Category $category
     */
    public function setCategory(Category $category = null)
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

    public function validateBeforePersist()
    {
        if (empty($this->firstPost)) {
            throw new \RuntimeException('You must add at least one post as first post to persist the topic.');
        }
        if (empty($this->lastPost)) {
            throw new \RuntimeException('You must add at least one post as last post to persist the topic.');
        }
        if (empty($this->category)) {
            throw new \RuntimeException('You must set a category to persist the topic.');
        }
    }

    public function setAsCategoryLastTopic()
    {
        $this->getCategory()->setLastTopic($this);
    }

    public function incrementCategoryNumTopics()
    {
        $this->getCategory()->incrementNumTopics();
    }

    public function decrementCategoryNumTopics()
    {
        $this->category->decrementNumTopics();
    }

    public function decrementCategoryNumPosts()
    {
        $this->category->decrementNumPosts($this->getNumPosts());
    }

    public function __toString()
    {
        return (string) $this->getSubject();
    }

}
