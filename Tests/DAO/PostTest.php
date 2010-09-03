<?php

namespace Bundle\ForumBundle\Tests\DAO;
use Bundle\ForumBundle\Test\WebTestCase;

class PostTest extends WebTestCase
{
    public function testMessage()
    {
        $class = $this->postClass;
        $post = new $class($this->getMock($this->topicClass, array(), array(), '', false));
        $this->assertEmpty($post->getMessage());
        $post->setMessage('Foo bar bla bla...');
        $this->assertEquals('Foo bar bla bla...', $post->getMessage());
    }

    public function testCreatedAt()
    {
        $class = $this->postClass;
        $post = new $class($this->getMock($this->topicClass, array(), array(), '', false));
        $this->assertEmpty($post->getCreatedAt());
        $post->setCreatedNow();
        $this->assertInstanceOf('\DateTime', $post->getCreatedAt());
        $this->assertEquals(new \DateTime('now'), $post->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $class = $this->postClass;
        $post = new $class($this->getMock($this->topicClass, array(), array(), '', false));
        $this->assertEmpty($post->getUpdatedAt());
        $post->setUpdatedNow();
        $this->assertInstanceOf('\DateTime', $post->getUpdatedAt());
        $this->assertEquals(new \DateTime('now'), $post->getUpdatedAt());
    }

}
