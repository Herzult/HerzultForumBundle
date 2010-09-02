<?php

namespace Bundle\ForumBundle\Tests\DAO;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

class CategoryTest extends WebTestCase
{
    public function testName()
    {
        $category = new Category();
        $this->assertEmpty($category->getName());
        $category->setName('Test category');
        $this->assertEquals('Test category', $category->getName());
    }

    public function testSlugGeneration()
    {
        $category = new Category();
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
        $category = new Category();
        $this->assertEquals(0, $category->getPosition());
        $category->setPosition(4);
        $this->assertEquals(4, $category->getPosition());
    }

    public function testNumTopics()
    {
        $em = $this->getService('Doctrine.ORM.EntityManager');

        $category = new Category();
        $category->setName(\uniqid('Test category '));

        $em->persist($category);
        $em->flush();

        $topic = new Topic($category);
        $topic->setSubject('Test topic');

        $em->persist($topic);
        $em->flush();

        $this->assertEquals(1, $category->getNumTopics());

        $em->remove($topic);
        $em->flush();

        $this->assertEquals(0, $category->getNumTopics());
    }

}
