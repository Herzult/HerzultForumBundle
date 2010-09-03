<?php

namespace Bundle\ForumBundle\Tests\Entity;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

class CategoryTest extends WebTestCase
{

    public function testNumTopics()
    {
        $em = $this->getService('Doctrine.ORM.EntityManager');

        $category = new Category();
        $category->setName('Unit Test : Entity\CategoryTest::testNumTopics()');

        $topic = new Topic();
        $topic->setCategory($category);
        $topic->setSubject('Testing number of topics');

        $post = new Post($topic);
        $post->setMessage('Foo bar');

        $em->persist($category);
        $em->persist($topic);
        $em->persist($post);

        $this->assertEquals(1, $category->getNumTopics(), 'the number of topics is automatically increased on persist');

        $em->remove($topic);

        $this->assertEquals(0, $category->getNumTopics(), 'the number of topics is automatically decreased on remove');
    }

}
