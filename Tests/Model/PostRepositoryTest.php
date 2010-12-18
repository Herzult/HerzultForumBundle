<?php

namespace Bundle\SosForum\CoreBundle\Tests\Model;

use Bundle\SosForum\CoreBundle\Test\WebTestCase;

class PostRepositoryTest extends WebTestCase
{
    protected $om;

    public function setUp()
    {
        $this->om = $om = parent::setUp();

        $om->getRepository('SosForumCoreBundle:Category')->cleanUp();
        $om->getRepository('SosForumCoreBundle:Topic')->cleanUp();
        $om->getRepository('SosForumCoreBundle:Post')->cleanUp();
    }

    public function testFindOneById()
    {
        $category = new $this->categoryClass();
        $category->setName('Post repository test');

        $topic = new $this->topicClass();
        $topic->setSubject('We are testing the Post entity repository');
        $topic->setCategory($category);

        $post = new $this->postClass();
        $post->setTopic($topic);
        $post->setMessage('Hello, I\'ll be deleted after the test...');

        $om = $this->getService('forum.object_manager');
        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();

        $repository = $om->getRepository('SosForumCoreBundle:Post');
        $foundPost = $repository->findOneById($post->getId());

        $this->assertNotEmpty($foundPost, '::findOneById find a post for the specified id');
        $this->assertInstanceOf($this->postClass, $foundPost, '::findOneById return a Post instance');
        $this->assertEquals($post, $foundPost, '::findOneById find the right post');
    }

}
