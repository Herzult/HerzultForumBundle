<?php

namespace Herzult\Bundle\ForumBundle\Model;

class PostTest extends \PHPUnit_Framework_TestCase
{
    protected $topicClass = 'Herzult\Bundle\ForumBundle\Model\Topic';

    public function testMessage()
    {
        $post = new TestPost();
        $post->setTopic($this->getMock($this->topicClass));
        $this->assertAttributeEmpty('message', $post, 'the message is empty during creation');

        $post->setMessage('Foo bar bla bla...');
        $this->assertAttributeEquals('Foo bar bla bla...', 'message', $post, '::setMessage() sets the message');
        $this->assertEquals('Foo bar bla bla...', $post->getMessage(), '::getMessage() gets the message');
    }

    public function getSetNumber()
    {
        $post = new TestPost();
        $this->assertEmpty($post->getNumber());

        $post->setNumber(5);
        $this->assertEquals(5, $post->getNumber());
    }

}

class TestPost extends Post
{
    public function getAuthorName()
    {
    }
}
