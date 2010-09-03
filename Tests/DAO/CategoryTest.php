<?php

namespace Bundle\ForumBundle\Tests\DAO;

class CategoryTest extends \PHPUnit_Framework_TestCase
{

    public function testName()
    {
        $category = $this->getMock('Bundle\ForumBundle\DAO\Category', null);
        $this->assertAttributeEmpty('name', $category, 'the name is empty during creation');

        $category->setName('Test category');
        $this->assertAttributeEquals('Test category', 'name', $category, '::setName() sets the name');
        $this->assertEquals('Test category', $category->getName(), '::getName() gets the name');
    }

    public function testSlugGeneration()
    {
        $category = $this->getMock('Bundle\ForumBundle\DAO\Category', null);
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
        $category = $this->getMock('Bundle\ForumBundle\DAO\Category', null);
        $this->assertAttributeEquals(0, 'position', $category, 'the position is set to 0 during creation');
        
        $category->setPosition(4);
        $this->assertAttributeEquals(4, 'position', $category, '::setPosition() sets the position');
        $this->assertEquals(4, $category->getPosition(), '::getPosition() gets the slug');

        $category->setPosition('SomeString');
        $this->assertAttributeInternalType('integer', 'position', $category, 'the position is mandatory an integer');
    }

    public function testNumTopics()
    {
        $category = $this->getMock('Bundle\ForumBundle\DAO\Category', null);
        $this->assertAttributeEquals(0, 'numTopics', $category, 'the number of topics is set to 0 during creation');

        $category->setNumTopics(4);
        $this->assertAttributeEquals(4, 'numTopics', $category, '::setNumTopics() sets the number of topics');
        $this->assertEquals(4, $category->getNumTopics(), '::getNumTopics() gets the number of topics');

        $category->incrementNumTopics();
        $this->assertAttributeEquals(5, 'numTopics', $category, '::incrementNumTopics() increases the number of topics');

        $category->decrementNumTopics();
        $this->assertAttributeEquals(4, 'numTopics', $category, '::decrementNumTopics() decreases the number of topics');

        $category->setNumTopics('SomeString');
        $this->assertAttributeInternalType('integer', 'numTopics', $category, 'the number of topics is mandatory an integer');
    }

}