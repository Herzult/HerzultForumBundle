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
        
        $om->getRepository('ForumBundle:Topic')->cleanUp();
        $om->getRepository('ForumBundle:Category')->cleanUp();
    }

    public function testFindAll()
    {
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('ForumBundle:Topic');

        // there is no topic
        $topics = $repository->findAll();
        
        $this->assertInternalType('array', $topics, '::findAll return an array even if there is no topic');
        $this->assertEquals(0, count($topics), '::findAll return an empty array if there is no topic');

        $categoryClass = $this->categoryClass;
        $category = new $categoryClass();
        $category->setName('Test category');
        $om->persist($category);

        $topicClass = $this->topicClass;
        $topic1 = new $topicClass($category);
        $topic1->setSubject('Category 1');
        $om->persist($topic1);

        $topic3 = new $topicClass($category);
        $topic3->setSubject('Category 3');
        $om->persist($topic3);

        $topic2 = new $topicClass($category);
        $topic2->setSubject('Category 2');
        $om->persist($topic2);

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

        $categoryClass = $this->categoryClass;
        $category = new $categoryClass();
        $category->setName('Topic repository test');
        $om->persist($category);

        $topicClass = $this->topicClass;
        $topic = new $topicClass($category);
        $topic->setSubject('Testing the ::findOneById method');
        $om->persist($topic);

        $om->flush();

        $foundTopic = $repository->findOneById($topic->getId());

        $this->assertNotEmpty($foundTopic, '::findOneById find a topic for the specified id');
        $this->assertInstanceOf($this->topicClass, $foundTopic, '::findOneById return a Topic instance');
        $this->assertEquals($topic, $foundTopic, '::findOneById find the right topic');
    }
}
