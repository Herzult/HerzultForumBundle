<?php

namespace Bundle\SosForum\CoreBundle\Test\Model;

use Bundle\SosForum\CoreBundle\Test\WebTestCase;

class TopicRepositoryTest extends WebTestCase
{
    protected $om;

    public function setUp()
    {
        $this->om = $om = parent::setUp();

        $om->getRepository('SosForumCoreBundle:Category')->cleanUp();
        $om->getRepository('SosForumCoreBundle:Topic')->cleanUp();
        $om->getRepository('SosForumCoreBundle:Post')->cleanUp();
    }

    public function testFindLatestPosted()
    {
        $number = 3;

        $before = array_keys(get_defined_vars());
        $c1 = $this->createCategory('c1');
        $c2 = $this->createCategory('c2');
        $t1 = $this->createTopic('t1', $c1);
        $t2 = $this->createTopic('t2', $c1);
        $t3 = $this->createTopic('t3', $c1);
        $t4 = $this->createTopic('t4', $c2);
        $p1 = $this->createPost('p1', $t1, 8);
        $p2 = $this->createPost('p2', $t1, 7);
        $p3 = $this->createPost('p3', $t2, 6);
        $p4 = $this->createPost('p4', $t2, 5);
        $p5 = $this->createPost('p5', $t3, 4);
        $p6 = $this->createPost('p6', $t3, 3);
        $p7 = $this->createPost('p7', $t4, 2);
        $p8 = $this->createPost('p8', $t4, 1);
        $after = array_keys(get_defined_vars());
        $vars = array_values(array_diff($after, $before));
        foreach($vars as $var) {
            $document = ${$var};
            if(is_object($document)) $this->om->persist($document);
        }
        $this->om->flush();

        $lastTopics = $this->om->getRepository('SosForumCoreBundle:Topic')->findLatestPosted($number);
        $this->assertSame($this->objectsToStrings(array($t4, $t3, $t2)), $this->objectsToStrings($lastTopics));
    }

    protected function objectsToStrings(array $objects)
    {
        $strings = array();
        foreach($objects as $object) {
            $strings[] = (string) $object;
        }

        return $strings;
    }
    protected function createCategory($name)
    {
        $category = new $this->categoryClass();
        $category->setName($name);

        return $category;
    }

    protected function createTopic($name, $category)
    {
        $topic = new $this->topicClass();
        $topic->setSubject($name);
        $topic->setCategory($category);

        return $topic;
    }

    protected function createPost($name, $topic, $days)
    {
        $post = new $this->postClass();
        $post->setMessage($name);
        $post->setTopic($topic);
        $date = new \DateTime(sprintf('-%s day', $days));
        $post->setCreatedAt($date);

        return $post;
    }

    public function testFindAll()
    {
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('SosForumCoreBundle:Topic');

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
        $post1->setCreatedAt(date_create('-1 day'));

        $om->persist($topic1);
        $om->persist($post1);

        $topic3 = new $this->topicClass();
        $topic3->setSubject('Topic 3');
        $topic3->setCategory($category);

        $post3 = new $this->postClass();
        $post3->setTopic($topic3);
        $post3->setMessage('Foo bar...');
        $post3->setCreatedAt(date_create('-2 day'));

        $om->persist($topic3);
        $om->persist($post3);

        $topic2 = new $this->topicClass();
        $topic2->setSubject('Topic 2');
        $topic2->setCategory($category);

        $post2 = new $this->postClass();
        $post2->setTopic($topic2);
        $post2->setMessage('Foo bar...');
        $post2->setCreatedAt(date_create('-3 day'));

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
        $repository = $om->getRepository('SosForumCoreBundle:Topic');

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
