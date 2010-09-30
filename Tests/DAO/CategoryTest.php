<?php

namespace Bundle\ForumBundle\Tests\DAO;

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

    public function testNumTopics()
    {
        $category = new $this->categoryClass();
        $category->setName('Test category ');
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

        $category->setNumTopics(0);

        $topic = new $this->topicClass();
        $topic->setSubject('Test topic');
        $topic->setCategory($category);

        $post1 = new $this->postClass($topic);
        $post1->setMessage('Foo bar bla bla...');

        $post2 = new $this->postClass($topic);
        $post2->setMessage('Foo bar bla bla...');

        $om = $this->getService('forum.object_manager');
        $om->persist($category);
        $om->persist($topic);
        $om->persist($post1);
        $om->persist($post2);
        $om->flush();

        $this->assertEquals(2, $category->getNumPosts(), 'the number of posts is automatically increased on persist');

        $om->remove($post2);
        $om->flush();

        $this->assertEquals(1, $category->getNumPosts(), 'the number of posts is automatically decreased on remove');

        $om->remove($topic);
        $om->flush();

        $this->assertEquals(0, $category->getNumPosts(), 'the number of posts is automatically decreased on remove');
    }

    public function testNumPosts()
    {
        $category = new $this->categoryClass();
        $category->setName('Test category ');
        $this->assertAttributeEquals(0, 'numPosts', $category, 'the number of posts is set to 0 during creation');

        $category->setNumPosts(4);
        $this->assertAttributeEquals(4, 'numPosts', $category, '::setNumPosts() sets the number of posts');
        $this->assertEquals(4, $category->getNumPosts(), '::getNumPosts() gets the number of posts');

        $category->incrementNumPosts();
        $this->assertAttributeEquals(5, 'numPosts', $category, '::incrementNumPosts() increases the number of posts');

        $category->decrementNumPosts();
        $this->assertAttributeEquals(4, 'numPosts', $category, '::decrementNumPosts() decreases the number of posts');

        $category->setNumPosts('SomeString');
        $this->assertAttributeInternalType('integer', 'numPosts', $category, 'the number of posts is mandatory an integer');

        $category->setNumPosts(0);

        $topic = new $this->topicClass();
        $topic->setSubject('Test topic');
        $topic->setCategory($category);

        $post = new $this->postClass($topic);
        $post->setMessage('Foo bar bla bla...');

        $om = $this->getService('forum.object_manager');
        $om->persist($category);
        $om->persist($topic);
        $om->persist($post);
        $om->flush();

        $this->assertEquals(1, $category->getNumPosts(), 'the number of topics is automatically increased on persist');

        $om->remove($topic);
        $om->flush();

        $this->assertEquals(0, $category->getNumPosts(), 'the number of topics is automatically decreased on remove');
    }

}
