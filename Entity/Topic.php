<?php

namespace Bundle\ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Bundle\ForumBundle\Entity\Topic
 */
class Topic
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

    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->numViews = $this->numReplies = 0;
        $this->isClosed = $this->isPinned = $this->isBuried = false;
        $this->posts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setNumViews($numViews)
    {
        $this->numViews = $numViews;
    }

    public function getNumViews()
    {
        return $this->numViews;
    }

    public function setNumReplies($numReplies)
    {
        $this->numReplies = $numReplies;
    }

    public function getNumReplies()
    {
        return $this->numReplies;
    }

    public function incrementNumReplies()
    {
        $this->numReplies++;
    }

    public function decrementNumReplies()
    {
        $this->numReplies--;
    }

    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;
    }

    public function getIsClosed()
    {
        return $this->isClosed;
    }

    public function setIsPinned($isPinned)
    {
        $this->isPinned = $isPinned;
    }

    public function getIsPinned()
    {
        return $this->isPinned;
    }

    public function setIsBuried($isBuried)
    {
        $this->isBuried = $isBuried;
    }

    public function getIsBuried()
    {
        return $this->isBuried;
    }

    public function setCreatedNow()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setPulledNow()
    {
        $this->pulledAt = new \DateTime('now');
    }

    public function getPulledAt()
    {
        return $this->pulledAt;
    }

    public function setAuthor(\Bundle\DoctrineUserBundle\Entity\User $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getFirstPost()
    {
        return $this->firstPost;
    }

    public function getLastPost()
    {
        return $this->lastPost;
    }

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

    public function getPosts()
    {
        return $this->posts;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function incrementCategoryNumTopicsOnPrePersist()
    {
        $this->category->setLastTopic($this);
        $this->category->incrementNumTopics();
    }

    public function decrementCategoryNumTopicsOnPreRemove()
    {
        $this->category->decrementNumtopics();
    }
}