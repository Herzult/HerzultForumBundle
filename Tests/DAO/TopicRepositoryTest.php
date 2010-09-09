<?php

namespace Bundle\ForumBundle\Test\DAO;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;

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

        $post1 = new $this->postClass($topic1);
        $post1->setMessage('Foo bar...');

        $om->persist($topic1);
        $om->persist($post1);

        $topic3 = new $this->topicClass();
        $topic3->setSubject('Category 3');
        $topic3->setCategory($category);

        $post3 = new $this->postClass($topic3);
        $post3->setMessage('Foo bar...');

        $om->persist($topic3);
        $om->persist($post3);

        $topic2 = new $this->topicClass();
        $topic2->setSubject('Category 2');
        $topic2->setCategory($category);

        $post2 = new $this->postClass($topic2);
        $post2->setMessage('Foo bar...');

        $om->persist($topic2);
        $om->persist($post2);
        $om->flush();

        $topics = $repository->findAll();

        $this->assertInternalType('array', $topics, '::findAll return an array even if there is no topic');
        $this->assertEquals(3, count($topics), '::findAll find ALL topics');

        $this->assertEquals($topic1, $topics[0], '::findAll return topics in the right order');
        $this->assertEquals($topic3, $topics[1], '::findAll return topics in the right order');
        $this->assertEquals($topic2, $topics[2], '::findAll return topics in the right order');
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

        $post = new $this->postClass($topic);
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
