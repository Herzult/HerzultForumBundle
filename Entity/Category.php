<?php

namespace Bundle\ForumBundle\Entity;

use Bundle\ForumBundle\Util\Inflector;
use Doctrine\Common\Collections\ArrayCollection;

class Category
{
    protected $id;
    protected $name;
    protected $description;
    protected $slug;
    protected $position;
    protected $numTopics;
    protected $lastTopic;

    public function __construct()
    {
        $this->position = 0;
        $this->numTopics = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setSlug($slug)
    {
        $this->slug = Inflector::slugify($slug);
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function generateSlug()
    {
        if (empty($this->slug)) {
            $this->setSlug($this->getName());
        }
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setNumTopics($numTopics)
    {
        $this->numTopics = $numTopics;
    }

    public function getNumTopics()
    {
        return $this->numTopics;
    }

    public function incrementNumTopics()
    {
        $this->numTopics++;
    }

    public function decrementNumTopics()
    {
        $this->numTopics--;
    }

    public function setLastTopic(Topic $topic)
    {
        $this->lastTopic = $topic;
    }

    public function getLastTopic()
    {
        return $this->lastTopic;
    }
}