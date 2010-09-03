<?php

namespace Bundle\ForumBundle\Tests\Entity;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

class TopicTest extends WebTestCase
{

    public function testFirstPost()
    {
        $em = $this->getService('Doctrine.ORM.EntityManager');

        $category = new Category();
        $category->setName('Tests Entity\Topic::testFirstPost()');

        $topic = new Topic();
        $topic->setSubject('Testing the first post');
        $topic->setCategory($category);

        try {
            $em->persist($topic);
            $this->fail('A topic must have at least the firt post before being persisted');
        } catch (\Exception $e) {
            
        }

        $post = new Post($topic);
        $post->setMessage('Some content, foo bar, bla bla...');

        $em->persist($category);
        $em->persist($topic);
        $em->persist($post);

        $this->assertEquals($post, $topic->getFirstPost(), 'the first post added to a topic is set as ::$firstPost');

        try {
            $em->remove($post);
            $this->fail('The first post of a topic can not be removed');
        } catch (\Exception $e) {

        }
    }
    
    public function testNumReplies()
    {

        $em = $this->getService('Doctrine.ORM.EntityManager');

        $category = new Category();
        $category->setName('Tests Entity\Topic::testNumReplies()');

        $topic = new Topic();
        $topic->setSubject('Testing the number of replies');
        $topic->setCategory($category);

        $post = new Post($topic);
        $post->setMessage('Some content, foo bar, bla bla...');

        $em->persist($category);
        $em->persist($topic);
        $em->persist($post);

        $this->assertEquals(0, $topic->getNumReplies(), 'the first post is not considered as a reply');

        $firstReply = new Post($topic);
        $firstReply->setMessage('First reply post message');
        
        $em->persist($firstReply);

        $this->assertEquals(1, $topic->getNumReplies(), 'the number of replies is automatically increased on post insertion');

        $em->remove($firstReply);

        $this->assertEquals(0, $topic->getNumReplies(), 'the number of  replies is automatically decreased on post deletion');
    }

}