<?php

namespace Bundle\ForumBundle\Tests\DAO;

use Bundle\ForumBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
{
    protected $categoryClass;

    public function setUp()
    {
        parent::setUp();
        if(null === $this->categoryClass) {
            $this->categoryClass = $this->getService('forum.object_manager')->getRepository('ForumBundle:Category')->getObjectClass();
        }
    }

    public function testName()
    {
        $class = $this->categoryClass;
        $category = new $class();
        $this->assertEmpty($category->getName());
        $category->setName('Test category');
        $this->assertEquals('Test category', $category->getName());
    }

    public function testSlugGeneration()
    {
        $class = $this->categoryClass;
        $category = new $class();
        $this->assertEmpty($category->getSlug());
        $category->generateSlug();
        $this->assertEmpty($category->getSlug());
        $category->setName('Test category');
        $this->assertEmpty($category->getSlug());
        $category->generateSlug();
        $this->assertEquals('test-category', $category->getSlug());
        $category->setName('Renamed category');
        $category->generateSlug();
        $this->assertEquals('test-category', $category->getSlug());
        $category->setSlug('');
        $category->generateSlug();
        $this->assertEquals('renamed-category', $category->getSlug());
        $category->setSlug('custom-slug');
        $category->generateSlug();
        $this->assertEquals('custom-slug', $category->getSlug());
        $category->setSlug('Malformed slug...');
        $this->assertEquals('malformed-slug', $category->getSlug());
    }

    public function testPosition()
    {
        $class = $this->categoryClass;
        $category = new $class();
        $this->assertEquals(0, $category->getPosition());
        $category->setPosition(4);
        $this->assertEquals(4, $category->getPosition());
    }

    public function testNumTopics()
    {
        $om = $this->getService('forum.object_manager');

        $class = $this->categoryClass;
        $category = new $class();
        $category->setName(\uniqid('Test category '));

        $om->persist($category);
        $om->flush();

        $topicClass = $om->getRepository('ForumBundle:Topic')->getObjectClass();
        $topic = new $topicClass($category);
        $topic->setSubject('Test topic');

        $om->persist($topic);
        $om->flush();

        $this->assertEquals(1, $category->getNumTopics());

        $om->remove($topic);
        $om->flush();

        $this->assertEquals(0, $category->getNumTopics());
    }

}
