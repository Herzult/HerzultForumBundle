<?php

namespace Bundle\ForumBundle\Tests\Entity;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

class PostRepositoryTest extends WebTestCase
{
    public function testFindOneById()
    {
        $em = $this->getService('Doctrine.ORM.EntityManager');
        $repository = $em->getRepository('ForumBundle:Post');

        $category = new Category();
        $category->setName('Post repository test');
        $em->persist($category);

        $topic = new Topic($category);
        $topic->setSubject('We are testing the Post entity repository');
        $em->persist($topic);

        $post = new Post($topic);
        $post->setMessage('Hello, I\'ll be deleted after the test...');
        $em->persist($post);

        $em->flush();

        $foundPost = $repository->findOneById($post->getId());

        $this->assertNotEmpty($foundPost, '::findOneById find a post for the specified id');
        $this->assertInstanceOf('Bundle\ForumBundle\Entity\Post', $foundPost, '::findOneById return a Post instance');
        $this->assertEquals($post, $foundPost, '::findOneById find the right post');
    }
}