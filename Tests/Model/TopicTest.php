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
        $om = $this->getService('forum.object_manager');

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

        $om->persist($category, $topic, $post);

        $this->assertEquals(0, $topic->getNumPosts(), 'the first post is not considered as a post');

        $firstReply = new $this->postClass();
        $firstReply->setTopic($topic);
        $firstReply->setMessage('First post post message');

        $om->persist($firstReply);

        $this->assertEquals(1, $topic->getNumPosts(), 'the number of posts is automatically increased on post insertion');

        $om->remove($firstReply);

        $this->assertEquals(0, $topic->getNumPosts(), 'the number of  posts is automatically decreased on post deletion');
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

    public function testCreatedAt()
    {
        $topic = new $this->topicClass($this->getMock($this->categoryClass));

        $date = new \DateTime('now');
        $topic->setCreatedNow();
        $this->assertAttributeEquals($date, 'createdAt', $topic, '::setCreatedNow() sets the creation timestamp as now as a DateTime object');

        $this->assertEquals($date, $topic->getCreatedAt(), '::getCreatedAt() gets the creation timestamp as a DateTime object');
    }

    public function testPulledAt()
    {
        $topic = new $this->topicClass($this->getMock($this->categoryClass));
        $this->assertAttributeEmpty('pulledAt', $topic, 'the pull timestamp is not set during creation');

        $date = new \DateTime('-2 day');
        $post = $this->getMock($this->postClass);
        $post->expects($this->once())
                    ->method('getCreatedAt')
                    ->will($this->returnValue($date));
        $topic->addPost($post);
        $topic->updatePulledAt();
        $this->assertAttributeEquals($date, 'pulledAt', $topic, '::updatePulledAt() sets the pull timestamp as the last post creation date');

        $this->assertEquals($date, $topic->getPulledAt(), '::getPulledDate() gets the pull timestamp as a DateTime object');
    }

    public function testFunctionalPulledAt()
    {
        $om = $this->getService('forum.object_manager');

        $category = new $this->categoryClass();
        $category->setName('Tests Category');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing');
        $topic->setCategory($category);

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Some content, foo bar, bla bla...');

        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();
        $om->clear();

        $this->assertNotNull($topic->getPulledAt());
        $topic = $this->getService('forum.repository.topic')->find($topic->getId());
        $this->assertNotNull($topic->getPulledAt());
    }

    public function testFirstPost()
    {
        $om = $this->getService('forum.object_manager');

        $category = new $this->categoryClass();
        $category->setName('Tests Category');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing the first post');
        $topic->setCategory($category);

        try {
            $om->persist($topic);
            $this->fail('A topic must have at least the first post before being persisted');
        } catch (\Exception $e) {
        }

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Some content, foo bar, bla bla...');

        $om->persist($category, $topic, $post);

        $this->assertEquals($post, $topic->getFirstPost(), 'the first post added to a topic is set as ::$firstPost');

        try {
            $om->remove($post);
            $this->fail('The first post of a topic can not be removed');
        } catch (\Exception $e) {
        }
    }

    public function testLastPost()
    {
        $om = $this->getService('forum.object_manager');

        $category = new $this->categoryClass();
        $category->setName('Tests Category');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing the last post');
        $topic->setCategory($category);

        try {
            $om->persist($topic);
            $this->fail('A topic must have at least the last post before being persisted');
        } catch (\Exception $e) {
            $this->assertNull($topic->getLastPost());
        }

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Some content, foo bar, bla bla...');

        $om->persist($category, $topic, $post);
        $om->flush();

        $this->assertEquals($post, $topic->getLastPost(), 'the last post added to a topic is set as ::$lastPost');

        try {
            $om->remove($post);
            $this->fail('The last post of a topic can not be removed');
        } catch (\Exception $e) {
            $this->assertNotNull($topic->getLastPost());
        }
    }

    public function testLastPostIssueWhenPostIsNotPersisted()
    {
        $this->markTestSkipped();
        $om = $this->getService('forum.object_manager');
        $category = new $this->categoryClass();
        $category->setName('Tests Category');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing the first post');
        $topic->setCategory($category);

        $post = new $this->postClass();
        $post->setMessage('blabla');
        $post->setTopic($topic);

        $om->persist($category);
        $om->persist($topic);

        $om->flush();
        $om->clear();

        $topic = $om->getRepository('ForumBundle:Topic')->find($topic->getId());

        $this->assertNotNull($topic->getLastPost());
        $this->assertEquals($post, $topic->getLastPost());
    }

}
