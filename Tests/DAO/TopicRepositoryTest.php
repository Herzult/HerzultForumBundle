<?php

namespace Bundle\ForumBundle\Test\DAO;

use Bundle\ForumBundle\Test\WebTestCase;

class TopicRepositoryTest extends WebTestCase
{

    public function setUp()
    {
        $om = parent::setUp();

        $om->getRepository('ForumBundle:Category')->cleanUp();
        $om->getRepository('ForumBundle:Topic')->cleanUp();
        $om->getRepository('ForumBundle:Post')->cleanUp();
    }

    public function testFindAll()
    {
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('ForumBundle:Topic');

        // there is no topic
        $topics = $repository->findAll();
        $this->assertInternalType('array', $topics, '::findAll return an array even if there is no topic');
        $this->assertEquals(0, count($topics), '::findAll return an empty array if there is no topic');

        $category = new $this->categoryClass();
        $category->setName('Test category');

        $om->persist($category);

        $topic1 = new $this->topicClass($category);
        $topic1->setSubject('Topic 1');
        $topic1->setCategory($category);

        $post1 = new $this->postClass();
        $post1->setTopic($topic1);
        $post1->setMessage('Foo bar...');

        $om->persist($topic1);
        $om->persist($post1);

        $topic3 = new $this->topicClass();
        $topic3->setSubject('Topic 3');
        $topic3->setCategory($category);

        $post3 = new $this->postClass();
        $post3->setTopic($topic3);
        $post3->setMessage('Foo bar...');

        $om->persist($topic3);
        $om->persist($post3);

        $topic2 = new $this->topicClass();
        $topic2->setSubject('Topic 2');
        $topic2->setCategory($category);

        $post2 = new $this->postClass();
        $post2->setTopic($topic2);
        $post2->setMessage('Foo bar...');

        $om->persist($topic2);
        $om->persist($post2);
        $om->flush();

        $topics = $repository->findAll();

        $this->assertInternalType('array', $topics, '::findAll return an array even if there is no topic');
        $this->assertEquals(3, count($topics), '::findAll find ALL topics');

        $this->assertEquals($topic1->getSubject(), $topics[0]->getSubject(), '::findAll return topics in the right order');
        $this->assertEquals($topic3->getSubject(), $topics[1]->getSubject(), '::findAll return topics in the right order');
        $this->assertEquals($topic2->getSubject(), $topics[2]->getSubject(), '::findAll return topics in the right order');
    }

    public function testFindOneById()
    {
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('ForumBundle:Topic');

        $category = new $this->categoryClass();
        $category->setName('Topic repository test');

        $topic = new $this->topicClass();
        $topic->setSubject('Testing the ::findOneById method');
        $topic->setCategory($category);

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Foo bar...');

        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();

        $foundTopic = $repository->findOneById($topic->getId());

        $this->assertNotEmpty($foundTopic, '::findOneById find a topic for the specified id');
        $this->assertInstanceOf($this->topicClass, $foundTopic, '::findOneById return a Topic instance');
        $this->assertEquals($topic, $foundTopic, '::findOneById find the right topic');
    }

}
