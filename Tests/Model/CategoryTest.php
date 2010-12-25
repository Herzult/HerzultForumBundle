<?php

namespace Bundle\ForumBundle\Tests\Model;

use Bundle\ForumBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
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
        $class = $this->getService('forum.repository.category')->getClassMetadata();
        $this->assertEquals($this->categoryClass, $class->name);
    }

    public function testLastTopicClass()
    {
        $class = $this->getService('forum.repository.category')->getClassMetadata();
        $lastTopic = $class->getFieldMapping('lastTopic');
        $this->assertNotNull($lastTopic);
        $this->assertEquals($this->topicClass, $lastTopic['targetDocument']);
    }

    public function testName()
    {
        $category = new $this->categoryClass();
        $this->assertAttributeEmpty('name', $category, 'the name is empty during creation');

        $category->setName('Test category');
        $this->assertAttributeEquals('Test category', 'name', $category, '::setName() sets the name');
        $this->assertEquals('Test category', $category->getName(), '::getName() gets the name');
    }

    public function testSlugGeneration()
    {
        $category = new $this->categoryClass();
        $category->setName('Test category');
        $this->assertAttributeEmpty('slug', $category, 'the slug is empty during creation');


        $category->generateSlug();
        $this->assertAttributeEquals('test-category', 'slug', $category, '::generateSlug() generates the slug from the name');
        $this->assertEquals('test-category', $category->getSlug(), '::getSlug() gets the slug');

        $category->setName('Renamed category');
        $category->generateSlug();
        $this->assertAttributeEquals('test-category', 'slug', $category, '::generateSlug() does not replace an existing slug');

        $category->setSlug('custom-slug');
        $this->assertAttributeEquals('custom-slug', 'slug', $category, '::setSlug() sets the slug');

        $category->setSlug('Malformed slug...');
        $this->assertAttributeEquals('malformed-slug', 'slug', $category, 'the slug is always formatted');
    }

    public function testPosition()
    {
        $category = new $this->categoryClass();
        $this->assertAttributeEquals(0, 'position', $category, 'the position is set to 0 during creation');

        $category->setPosition(4);
        $this->assertAttributeEquals(4, 'position', $category, '::setPosition() sets the position');
        $this->assertEquals(4, $category->getPosition(), '::getPosition() gets the slug');

        $category->setPosition('SomeString');
        $this->assertAttributeInternalType('integer', 'position', $category, 'the position is mandatory an integer');
    }

    public function testLastPostClass()
    {
        $class = $this->getService('forum.repository.category')->getClassMetadata();
        $lastPost = $class->getFieldMapping('lastPost');
        $this->assertNotNull($lastPost);
        $this->assertEquals($this->postClass, $lastPost['targetDocument']);
    }
}
