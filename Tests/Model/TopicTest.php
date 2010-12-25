<?php

namespace Bundle\ForumBundle\Tests\Model;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Document\Post;

class TopicTest extends WebTestCase
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
        $class = $this->getService('forum.repository.topic')->getClassMetadata();
        $this->assertEquals($this->topicClass, $class->name);
    }

    public function testCategoryClass()
    {
        $class = $this->getService('forum.repository.topic')->getClassMetadata();
        $category = $class->getFieldMapping('category');
        $this->assertNotNull($category);
        $this->assertEquals($this->categoryClass, $category['targetDocument']);
    }

    public function testFirstPostClass()
    {
        $class = $this->getService('forum.repository.topic')->getClassMetadata();
        $firstPost = $class->getFieldMapping('firstPost');
        $this->assertNotNull($firstPost);
        $this->assertEquals($this->postClass, $firstPost['targetDocument']);
    }

    public function testLastPostClass()
    {
        $class = $this->getService('forum.repository.topic')->getClassMetadata();
        $lastPost = $class->getFieldMapping('lastPost');
        $this->assertNotNull($lastPost);
        $this->assertEquals($this->postClass, $lastPost['targetDocument']);
    }

    public function testSubject()
    {
        $topic = new $this->topicClass($this->getMock($this->categoryClass));
        $this->assertAttributeEmpty('subject', $topic, 'the subject is empty during creation');

        $topic->setSubject('A topic sample');
        $this->assertAttributeEquals('A topic sample', 'subject', $topic, '::setSubject() sets the subject');
        $this->assertEquals('A topic sample', $topic->getSubject(), '::getSubject() gets the subject');
    }

    public function testNumViews()
    {
        $topic = new $this->topicClass($this->getMock($this->categoryClass));
        $this->assertAttributeEquals(0, 'numViews', $topic, 'the number of views is set to 0 during creation');

        $topic->setNumViews(4);
        $this->assertAttributeEquals(4, 'numViews', $topic, '::setNumViews() sets the number of views');
        $this->assertEquals(4, $topic->getNumViews(), '::getNumViews() gets the number of views');

        $topic->incrementNumViews();
        $this->assertAttributeEquals(5, 'numViews', $topic, '::incrementNumViews() increases the number of views');

        $topic->decrementNumViews();
        $this->assertAttributeEquals(4, 'numViews', $topic, '::decrementNumViews() decreases the number of views');

        $topic->setNumViews('SomeString');
        $this->assertAttributeInternalType('integer', 'numViews', $topic, 'the number of views is mandatory an integer');
    }

    public function testNumPosts()
    {
        $category = new $this->categoryClass();
        $category->setName('Test Category');

        $topic = new $this->topicClass();
        $this->assertAttributeEquals(0, 'numPosts', $topic, 'the number of posts is set to 0 during creation');

        $topic->setSubject('Testing the number of posts');
        $topic->setCategory($category);

        $topic->setNumPosts(4);
        $this->assertAttributeEquals(4, 'numPosts', $topic, '::setNumPosts() sets the number of posts');
        $this->assertEquals(4, $topic->getNumPosts(), '::getNumPosts() gets the number of posts');

        $topic->incrementNumPosts();
        $this->assertAttributeEquals(5, 'numPosts', $topic, '::incrementNumPosts() increases the number of posts');

        $topic->decrementNumPosts();
        $this->assertAttributeEquals(4, 'numPosts', $topic, '::decrementNumPosts() decreases the number of posts');

        $topic->setNumPosts('SomeString');
        $this->assertAttributeInternalType('integer', 'numPosts', $topic, 'the number of posts is mandatory an integer');

        $topic->setNumPosts(0);

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Some content, foo bar, bla bla...');
    }

    public function testCategory()
    {
        $category = $this->getMock($this->categoryClass);

        $topic = new $this->topicClass();

        $this->assertAttributeEmpty('category', $topic, 'the category is not set during creation');

        $topic->setCategory($category);
        $this->assertAttributeEquals($category, 'category', $topic, '::setCategory() sets the category');

        $this->assertEquals($category, $topic->getCategory(), '::getCategory() gets the category');
    }

    public function testIsClosed()
    {
        $topic = new $this->topicClass($this->getMock($this->categoryClass));

        $this->assertAttributeEquals(false, 'isClosed', $topic, 'the topic is not closed during creation');
        $this->assertAttributeEquals($topic->getIsClosed(), 'isClosed', $topic, '::getIsClosed() gets the closure status');

        $topic->setIsClosed(true);

        $this->assertAttributeEquals(true, 'isClosed', $topic, '::setIsClosed() sets the closure status');

        $topic->setIsClosed('AnyString');

        $this->assertAttributeInternalType('boolean', 'isClosed', $topic, 'the closure status is mandatory a boolean');
    }

    public function testIsPinned()
    {
        $topic = new $this->topicClass($this->getMock($this->categoryClass));

        $this->assertAttributeEquals(false, 'isPinned', $topic, 'the topic is not pinned during creation');
        $this->assertAttributeEquals($topic->getIsPinned(), 'isPinned', $topic, '::getIsPinned() gets the pinning status');

        $topic->setIsPinned(true);

        $this->assertAttributeEquals(true, 'isPinned', $topic, '::setIsPinned() sets the pinning status');

        $topic->setIsPinned('AnyString');

        $this->assertAttributeInternalType('boolean', 'isPinned', $topic, 'the pinning status is mandatory a boolean');
    }

    public function testIsBuried()
    {
        $topic = new $this->topicClass($this->getMock($this->categoryClass));

        $this->assertAttributeEquals(false, 'isBuried', $topic, 'the topic is not buried during creation');
        $this->assertAttributeEquals($topic->getIsBuried(), 'isBuried', $topic, '::getBuried() gets the buring status');

        $topic->setIsBuried(true);

        $this->assertAttributeEquals(true, 'isBuried', $topic, '::setIsBuried() sets the buring status');

        $topic->setIsBuried('AnyString');

        $this->assertAttributeInternalType('boolean', 'isBuried', $topic, 'the buring status is mandatory a boolean');
    }

}
