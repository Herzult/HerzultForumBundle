<?php

namespace Bundle\ForumBundle\Tests\DAO;

use Bundle\ForumBundle\Test\WebTestCase;

class PostRepositoryTest extends WebTestCase
{

    public function setUp()
    {
        $om = parent::setUp();

        $om->getRepository('ForumBundle:Category')->cleanUp();
        $om->getRepository('ForumBundle:Topic')->cleanUp();
        $om->getRepository('ForumBundle:Post')->cleanUp();
    }

    public function testFindOneById()
    {
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('ForumBundle:Post');

        $categoryClass = $this->categoryClass;
        $category = new $categoryClass();
        $category->setName('Post repository test');
        $om->persist($category);

        $topicClass = $this->topicClass;
        $topic = new $topicClass($category);
        $topic->setSubject('We are testing the Post entity repository');
        $om->persist($topic);

        $postClass = $this->postClass;
        $post = new $postClass($topic);
        $post->setMessage('Hello, I\'ll be deleted after the test...');
        $om->persist($post);

        $om->flush();

        $foundPost = $repository->findOneById($post->getId());

        $this->assertNotEmpty($foundPost, '::findOneById find a post for the specified id');
        $this->assertInstanceOf($postClass, $foundPost, '::findOneById return a Post instance');
        $this->assertEquals($post, $foundPost, '::findOneById find the right post');
    }

}
