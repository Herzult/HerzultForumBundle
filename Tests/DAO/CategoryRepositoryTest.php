<?php

namespace Bundle\ForumBundle\Tests\DAO;

use Bundle\ForumBundle\Test\WebTestCase;

class CategoryRepositoryTest extends WebTestCase
{

    public function setUp()
    {
        // remove all categories before each test
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('ForumBundle:Category');

        $categories = $repository->findAll();
        foreach ($categories as $category) {
            $om->remove($category);
        }
        $om->flush();
    }

    public function testFindAll()
    {
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('ForumBundle:Category');

        // there is no category
        $categories = $repository->findAll();
        
        $this->assertInternalType('array', $categories, '::findAll return an array even if there is no category');
        $this->assertEquals(0, count($categories), '::findAll return an empty array if there is no category');

        $categoryClass = $repository->getObjectClass();

        // add some categories
        $category1 = new $categoryClass();
        $category1->setName('Category 1');
        $category1->setPosition(1);
        $om->persist($category1);

        $category3 = new $categoryClass();
        $category3->setName('Category 3');
        $category3->setPosition(3);
        $om->persist($category3);

        $category2 = new $categoryClass();
        $category2->setName('Category 2');
        $category2->setPosition(2);
        $om->persist($category2);

        $om->flush();

        $categories = $repository->findAll();

        $this->assertInternalType('array', $categories, '::findAll return an array even if there is no category');
        $this->assertEquals(3, count($categories), '::findAll find ALL categories');
        
        $this->assertEquals($category1, $categories[0], '::findAll return categories in the right order');
        $this->assertEquals($category2, $categories[1], '::findAll return categories in the right order');
        $this->assertEquals($category3, $categories[2], '::findAll return categories in the right order');
    }

    public function testFindOneBySlug()
    {
        $om = $this->getService('forum.object_manager');
        $repository = $om->getRepository('ForumBundle:Category');

        $this->assertEquals(null, $repository->findOneBySlug('there-is-no-category-matching-to-this-slug'), '::findOneBySlug returns NULL if the specified slug does not match any category');

        $categoryClass = $repository->getObjectClass();
        $category = new $categoryClass();
        $category->setName('Foo bar');

        $om->persist($category);
        $om->flush();

        $foundCategory = $repository->findOneBySlug($category->getSlug());

        $this->assertNotEmpty($foundCategory, '::findOneBySlug find a category for the specified slug');
        $this->assertInstanceOf($categoryClass, $foundCategory, '::findOneBySlug returns a Category instance');
        $this->assertEquals($category, $foundCategory, '::findOneBySlug find the good category for the specified slug');
    }
}
