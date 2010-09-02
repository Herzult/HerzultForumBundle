<?php

namespace Bundle\ForumBundle\Tests\DAO;

use Bundle\ForumBundle\Test\WebTestCase;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

class TopicTest extends WebTestCase
{

    public function testSubject()
    {
        $topic = new Topic($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertEmpty($topic->getSubject());
        $topic->setSubject('A topic sample');
        $this->assertEquals('A topic sample', $topic->getSubject());
    }

    public function testNumViews()
    {
        $topic = new Topic($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertEquals(0, $topic->getNumViews());
    }

    public function testNumReplies()
    {
        $em = $this->getService('Doctrine.ORM.EntityManager');

        $category = new Category();
        $category->setName('Topic test');
        $em->persist($category);
        
        $topic = new Topic($category);
        $topic->setSubject('Testing the number of replies');
        $em->persist($topic);

        $firstPost = new Post($topic);
        $firstPost->setMessage('First post message');
        $em->persist($firstPost);

        $em->flush();

        $this->assertEquals(0, $topic->getNumReplies());
        
        $secondPost = new Post($topic);
        $secondPost->setMessage('Second post (or first reply)');
        $em->persist($secondPost);

        $em->flush();

        $this->assertEquals(1, $topic->getNumReplies());

        $em->remove($secondPost);
        $em->flush();

        $this->assertEquals(0, $topic->getNumReplies());
    }

    public function testIsClosed()
    {
        $topic = new Topic($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertFalse($topic->getIsClosed());
        $topic->setIsClosed(true);
        $this->assertTrue($topic->getIsClosed());
    }

    public function testIsPinned()
    {
        $topic = new Topic($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertFalse($topic->getIsPinned());
        $topic->setIsPinned(true);
        $this->assertTrue($topic->getIsPinned());
    }

    public function testIsBuried()
    {
        $topic = new Topic($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertFalse($topic->getIsBuried());
        $topic->setIsBuried(true);
        $this->assertTrue($topic->getIsBuried());
    }

    public function testCreatedAt()
    {
        $topic = new Topic($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertEmpty($topic->getCreatedAt());
        $topic->setCreatedNow();
        $this->assertInstanceOf('\DateTime', $topic->getCreatedAt());
        $this->assertEquals(new \DateTime('now'), $topic->getCreatedAt());
    }

    public function testPulledAt()
    {
        $topic = new Topic($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertEmpty($topic->getPulledAt());
        $topic->setPulledNow();
        $this->assertInstanceOf('\DateTime', $topic->getPulledAt());
        $this->assertEquals(new \DateTime('now'), $topic->getPulledAt());
    }

}
