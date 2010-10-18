<?php

namespace Bundle\ForumBundle\DAO;

abstract class Post
{
    protected $id;
    /**
     * Topic the post belongs to
     *
     * @var Topic
     */
    protected $topic;
    /**
     * Author who wrote the post
     *
     * @var mixed
     */
    protected $author;
    /**
     * @validation:NotBlank(message="Please write a message")
     * @validation:MinLength(limit=4, message="Just a little too short.")
     *
     * @var string
     */
    protected $message;
    /**
     * Post number relative to its topic
     *
     * @var int
     */
    protected $number = null;

    protected $createdAt;
    protected $updatedAt;

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function __construct()
    {
        $this->setCreatedNow();
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
     * Get number
     * @return int
     */
    public function getNumber()
    {
      return $this->number;
    }

    /**
     * Set number
     * @param  int
     * @return null
     */
    public function setNumber($number)
    {
      $this->number = $number;
    }

    /**
     * Sets the creation timestamp as now
     */
    public function setCreatedNow()
    {
        if(!$this->createdAt) {
            $this->createdAt = new \DateTime('now');
        }
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
     * Sets the creation date
     *
     * @return null
     **/
    public function setCreatedAt(\DateTime $date)
    {
        $this->createdAt = $date;
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
     * Sets the topic
     *
     * @return null
     **/
    public function setTopic($topic)
    {
        $this->topic = $topic;
        $this->topic->addPost($this);
    }

    /**
     * Increment the topic number of posts on prePersist
     */
    public function incrementTopicNumPosts()
    {
        $this->getTopic()->incrementNumPosts();
    }

    /**
     * Update post number according to number of posts in its topic
     *
     * @return null
     **/
    public function updateNumber()
    {
        if(!$this->getNumber()) {
            $this->setNumber($this->getTopic()->getNumPosts());
        }
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
