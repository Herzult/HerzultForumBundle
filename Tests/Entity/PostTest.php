<?php

namespace Bundle\ForumBundle\Tests\Entity;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

class PostTest extends WebTestCase
{

    public function testTimestamps()
    {
        $em = $this->getService('Doctrine.ORM.EntityManager');

        $category = new Category();
        $category->setName('Categoty Unit Test : Entity\PostTest');
        $em->persist($category);

        $topic = new Topic();
        $topic->setSubject('Testing timestampable functionality');
        $topic->setCategory($category);

        $post = new Post($topic);
        $post->setMessage('Foo bar bla bla...');

        $em->persist($topic);
        $em->persist($post);
        $em->flush();

        $this->assertAttributeInstanceOf('DateTime', 'createdAt', $post, 'the creation timestamp is automatically set on insert');
        $this->assertAttributeEmpty('updatedAt', $post, 'the update timestamp is not set on insert');

        $post->setMessage('Updated foo bar bla bla...');

        $em->flush();

        $this->assertAttributeInstanceOf('DateTime', 'updatedAt', $post, 'the update timestamp is automatically set on update');
    }

}