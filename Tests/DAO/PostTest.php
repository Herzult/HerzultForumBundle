<?php

namespace Bundle\ForumBundle\Tests\DAO;

class PostTest extends \PHPUnit_Framework_TestCase
{

    public function testMessage()
    {
        $post = $this->getMock('Bundle\ForumBundle\DAO\Post', null, array($this->getMock('Bundle\ForumBundle\DAO\Topic')));
        $this->assertAttributeEmpty('message', $post, 'the message is empty during creation');

        $post->setMessage('Foo bar bla bla...');
        $this->assertAttributeEquals('Foo bar bla bla...', 'message', $post, '::setMessage() sets the message');
        $this->assertEquals('Foo bar bla bla...', $post->getMessage(), '::getMessage() gets the message');
    }

    public function testCreatedAt()
    {
        $post = $this->getMock('Bundle\ForumBundle\DAO\Post', null, array($this->getMock('Bundle\ForumBundle\DAO\Topic')));
        $this->assertAttributeEmpty('createdAt', $post, 'the creation timestamp is empty during creation');

        $date = new \DateTime('now');
        $post->setCreatedNow();
        $this->assertAttributeInstanceOf('DateTime', 'createdAt', $post, '::setCreatedNow() sets the creation timestamp as a DateTime object');
        $this->assertAttributeEquals($date, 'createdAt', $post, '::setCreatedNow() sets the creation timestamp as now');
        $this->assertEquals($date, $post->getCreatedAt(), '::getCreatedAt() gets the creation timestamp');
    }
    
    public function testUpdatedAt()
    {
        $post = $this->getMock('Bundle\ForumBundle\DAO\Post', null, array($this->getMock('Bundle\ForumBundle\DAO\Topic')));
        $this->assertAttributeEmpty('updatedAt', $post, 'the update timestamp is empty during creation');

        $date = new \DateTime('now');
        $post->setUpdatedNow();
        $this->assertAttributeInstanceOf('DateTime', 'updatedAt', $post, '::setUpdatedNow() sets the update timestamp as a DateTime object');
        $this->assertAttributeEquals($date, 'updatedAt', $post, '::setUpdatedNow() sets the update timestamp as now');
        $this->assertEquals($date, $post->getUpdatedAt(), '::getUpdatedAt() gets the update timestamp');
    }

}