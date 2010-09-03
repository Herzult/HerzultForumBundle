<?php

namespace Bundle\ForumBundle\Test\Entity;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

class TopicRepositoryTest extends WebTestCase
{

    public function testFindOneById()
    {
        $em = $this->getService('Doctrine.ORM.EntityManager');
        $repository = $em->getRepository('ForumBundle:Topic');

        $category = new Category();
        $category->setName('Topic repository test');

        $topic = new Topic();
        $topic->setSubject('Testing the ::findOneById method');
        $topic->setCategory($category);

        $post = new Post($topic);
        $post->setMessage('Foo bar...');

        $em->persist($category);
        $em->persist($topic);
        $em->persist($post);
        $em->flush();

        $foundTopic = $repository->findOneById($topic->getId());

        $this->assertNotEmpty($foundTopic, '::findOneById find a topic for the specified id');
        $this->assertInstanceOf('Bundle\ForumBundle\Entity\Topic', $foundTopic, '::findOneById return a Topic instance');
        $this->assertEquals($topic, $foundTopic, '::findOneById find the right topic');
    }

}