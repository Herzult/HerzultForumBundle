<?php

namespace Bundle\ForumBundle\Tests\DAO;

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
        $class = $this->getService('forum.post_repository')->getClassMetadata();
        $this->assertEquals($this->postClass, $class->name);
    }

    public function testTopicClass()
    {
        $class = $this->getService('forum.post_repository')->getClassMetadata();
        $topic = $class->getFieldMapping('topic');
        $this->assertNotNull($topic);
        $this->assertEquals($this->topicClass, $topic['targetDocument']);
    }

    public function testAuthorClass()
    {
        $userClass = $this->getService('doctrine_user.user_repository')->getObjectClass();
        $class = $this->getService('forum.post_repository')->getClassMetadata();
        $author = $class->getFieldMapping('author');
        $this->assertNotNull($author);
        $this->assertEquals($userClass, $author['targetDocument']);
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

    public function testCreatedAt()
    {
        $class = $this->postClass;
        $post = new $class();
        $post->setTopic($this->getMock($this->topicClass));

        $date = new \DateTime('now');
        $post->setCreatedNow();
        $this->assertAttributeInstanceOf('DateTime', 'createdAt', $post, '::setCreatedNow() sets the creation timestamp as a DateTime object');
        $this->assertAttributeEquals($date, 'createdAt', $post, '::setCreatedNow() sets the creation timestamp as now');
        $this->assertEquals($date, $post->getCreatedAt(), '::getCreatedAt() gets the creation timestamp');
    }

    public function testUpdatedAt()
    {
        $class = $this->postClass;
        $post = new $class();
        $post->setTopic($this->getMock($this->topicClass));
        $this->assertAttributeEmpty('updatedAt', $post, 'the update timestamp is empty during creation');

        $date = new \DateTime('now');
        $post->setUpdatedNow();
        $this->assertAttributeInstanceOf('DateTime', 'updatedAt', $post, '::setUpdatedNow() sets the update timestamp as a DateTime object');
        $this->assertAttributeEquals($date, 'updatedAt', $post, '::setUpdatedNow() sets the update timestamp as now');
        $this->assertEquals($date, $post->getUpdatedAt(), '::getUpdatedAt() gets the update timestamp');
    }

    public function testTimestamps()
    {
        $om = $this->getService('forum.object_manager');

        $category = new $this->categoryClass();
        $category->setName('Test Category');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing timestampable functionality');
        $topic->setCategory($category);

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Foo bar bla bla...');

        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();

        $this->assertAttributeInstanceOf('DateTime', 'createdAt', $post, 'the creation timestamp is automatically set on insert');
        $this->assertAttributeEmpty('updatedAt', $post, 'the update timestamp is not set on insert');

        $post->setMessage('Updated foo bar bla bla...');

        $om->flush();

        $this->assertAttributeInstanceOf('DateTime', 'updatedAt', $post, 'the update timestamp is automatically set on update');
    }

    public function testGetTopic()
    {
        $om = $this->getService('forum.object_manager');

        $category = new $this->categoryClass();
        $category->setName('Test Category');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing category getter');
        $topic->setCategory($category);

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Foo bar bla bla...');

        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();
        $om->clear();

        $post = $om->getRepository('ForumBundle:Post')->findOneById($post->getId());
        $postTopic = $post->getTopic();
        $this->assertInstanceOf('Bundle\ForumBundle\DAO\Topic', $postTopic);
        $this->assertEquals($topic->getId(), $postTopic->getId());
    }

    public function getSetNumber()
    {
        $post = new $this->postClass();
        $this->assertEmpty($post->getNumber());

        $post->setNumber(5);
        $this->assertEquals(5, $post->getNumber());
    }

    public function testNumberIsIncremented()
    {
        $om = $this->getService('forum.object_manager');

        $category = new $this->categoryClass();
        $category->setName('Test Category');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing category getter');
        $topic->setCategory($category);

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Foo bar bla bla...');

        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();

        $this->assertEquals(1, $post->getNumber());

        $post2 = new $this->postClass();
        $post2->setTopic($topic);
        $post2->setMessage('Foo bar bla bla...');

        $om->persist($post2);
        $om->flush();

        $this->assertEquals(1, $post->getNumber());
        $this->assertEquals(2, $post2->getNumber());
    }

}
