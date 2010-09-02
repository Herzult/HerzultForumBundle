<?php

namespace Bundle\ForumBundle\Tests\Entity;

use Bundle\ForumBundle\Entity\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{

    public function testMessage()
    {
        $post = new Post($this->getMock('Bundle\ForumBundle\Entity\Topic', array(), array(), '', false));
        $this->assertEmpty($post->getMessage());
        $post->setMessage('Foo bar bla bla...');
        $this->assertEquals('Foo bar bla bla...', $post->getMessage());
    }

    public function testCreatedAt()
    {
        $post = new Post($this->getMock('Bundle\ForumBundle\Entity\Topic', array(), array(), '', false));
        $this->assertEmpty($post->getCreatedAt());
        $post->setCreatedNow();
        $this->assertInstanceOf('\DateTime', $post->getCreatedAt());
        $this->assertEquals(new \DateTime('now'), $post->getCreatedAt());
    }

    public function testUpdatedAt()
    {
        $post = new Post($this->getMock('Bundle\ForumBundle\Entity\Topic', array(), array(), '', false));
        $this->assertEmpty($post->getUpdatedAt());
        $post->setUpdatedNow();
        $this->assertInstanceOf('\DateTime', $post->getUpdatedAt());
        $this->assertEquals(new \DateTime('now'), $post->getUpdatedAt());
    }

}