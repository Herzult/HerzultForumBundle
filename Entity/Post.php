<?php

namespace Bundle\ForumBundle\Entity;

class Post
{
    protected $id;
    protected $topic;
    protected $author;
    protected $message;
    protected $createdAt;
    protected $updatedAt;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
        $this->topic->addPost($this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setCreatedNow()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedNow()
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setAuthor(\Bundle\DoctrineUserBundle\Entity\User $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Decrement the topic number of replies on preRemove
     */
    public function decrementTopicNumRepliesOnPreRemove()
    {
        $this->topic->decrementNumReplies();
    }
}