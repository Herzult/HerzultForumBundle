<?php

namespace Bundle\ForumBundle\Tests\Model;

use Bundle\ForumBundle\Test\WebTestCase;

class PostTest extends WebTestCase
{

    public function setUp()
    {
        $om = parent::setUp();

        $om->getRepository('ForumBundle:Category')->cleanUp();
        $om->getRepository('ForumBundle:Topic')->cleanUp();
        $om->getRepository('ForumBundle:Post')->cleanUp();
    }

    public function testObjectClass()
    {
        $class = $this->getService('forum.repository.post')->getClassMetadata();
        $this->assertEquals($this->postClass, $class->name);
    }

    public function testTopicClass()
    {
        $class = $this->getService('forum.repository.post')->getClassMetadata();
        $topic = $class->getFieldMapping('topic');
        $this->assertNotNull($topic);
        $this->assertEquals($this->topicClass, $topic['targetDocument']);
    }

    public function testMessage()
    {
        $class = $this->postClass;
        $post = new $class();
        $post->setTopic($this->getMock($this->topicClass));
        $this->assertAttributeEmpty('message', $post, 'the message is empty during creation');

        $post->setMessage('Foo bar bla bla...');
        $this->assertAttributeEquals('Foo bar bla bla...', 'message', $post, '::setMessage() sets the message');
        $this->assertEquals('Foo bar bla bla...', $post->getMessage(), '::getMessage() gets the message');
    }

    public function getSetNumber()
    {
        $post = new $this->postClass();
        $this->assertEmpty($post->getNumber());

        $post->setNumber(5);
        $this->assertEquals(5, $post->getNumber());
    }

}
