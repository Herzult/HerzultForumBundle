<?php

namespace Bundle\ForumBundle\DAO;

abstract class Post
{
    protected $id;
    protected $topic;
    protected $author;
    /**
     * @Validation({
     *   @NotBlank(),
     *   @MinLength(limit=4, message="Just a little too short.")
     * })
     */
    protected $message;
    protected $createdAt;
    protected $updatedAt;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
        $this->topic->addPost($this);
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
     * Sets the message
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Gets the message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
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
     * Sets the update timestamp as now
     */
    public function setUpdatedNow()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Gets the update timestamp
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * Gets the topic
     *
     * @return Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Increment the topic number of posts on prePersist
     */
    public function incrementTopicNumPosts()
    {
        $this->getTopic()->incrementNumPosts();
    }

    /**
     * Increment the category number of posts on prePersist
     */
    public function incrementCategoryNumPosts()
    {
        $this->getTopic()->getCategory()->incrementNumPosts();
    }

    /**
     * Decrement the topic number of posts on preRemove
     */
    public function decrementTopicNumPosts()
    {
        $this->getTopic()->decrementNumPosts();
    }

    /**
     * Decrement the category number of posts on preRemove
     */
    public function decrementCategoryNumPosts()
    {
        $this->getTopic()->getCategory()->decrementNumPosts();
    }

}
