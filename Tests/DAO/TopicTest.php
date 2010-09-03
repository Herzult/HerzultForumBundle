<?php

namespace Bundle\ForumBundle\Tests\DAO;

use Bundle\ForumBundle\Test\WebTestCase;

class TopicTest extends WebTestCase
{
    public function testSubject()
    {
        $class = $this->topicClass;
        $topic = new $class($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertEmpty($topic->getSubject());
        $topic->setSubject('A topic sample');
        $this->assertEquals('A topic sample', $topic->getSubject());
    }

    public function testNumViews()
    {
        $class = $this->topicClass;
        $topic = new $class($this->getMock('Bundle\ForumBundle\Entity\Category'));
        $this->assertEquals(0, $topic->getNumViews());
    }

    public function testNumReplies()
    {
        $om = $this->getService('forum.object_manager');

        $categoryClass = $this->categoryClass;
        $category = new $categoryClass();
        $category->setName('Topic test');
        $om->persist($category);
        
        $topicClass = $this->topicClass;
        $topic = new $topicClass($category);
        $topic->setSubject('Testing the number of replies');
        $om->persist($topic);

        $postClass = $this->postClass;
        $firstPost = new $postClass($topic);
        $firstPost->setMessage('First post message');
        $om->persist($firstPost);

        $om->flush();

        $this->assertEquals(0, $topic->getNumReplies());
        
        $secondPost = new $postClass($topic);
        $secondPost->setMessage('Second post (or first reply)');
        $om->persist($secondPost);

        $om->flush();

        $this->assertEquals(1, $topic->getNumReplies());

        $om->remove($secondPost);
        $om->flush();

        $this->assertEquals(0, $topic->getNumReplies());
    }

    public function testIsClosed()
    {
        $class = $this->topicClass;
        $topic = new $class($this->getCategoryMock());
        $this->assertFalse($topic->getIsClosed());
        $topic->setIsClosed(true);
        $this->assertTrue($topic->getIsClosed());
    }

    public function testIsPinned()
    {
        $class = $this->topicClass;
        $topic = new $class($this->getCategoryMock());
        $this->assertFalse($topic->getIsPinned());
        $topic->setIsPinned(true);
        $this->assertTrue($topic->getIsPinned());
    }

    public function testIsBuried()
    {
        $class = $this->topicClass;
        $topic = new $class($this->getCategoryMock());
        $this->assertFalse($topic->getIsBuried());
        $topic->setIsBuried(true);
        $this->assertTrue($topic->getIsBuried());
    }

    public function testCreatedAt()
    {
        $class = $this->topicClass;
        $topic = new $class($this->getCategoryMock());
        $this->assertEmpty($topic->getCreatedAt());
        $topic->setCreatedNow();
        $this->assertInstanceOf('\DateTime', $topic->getCreatedAt());
        $this->assertEquals(new \DateTime('now'), $topic->getCreatedAt());
    }

    public function testPulledAt()
    {
        $class = $this->topicClass;
        $topic = new $class($this->getCategoryMock());
        $this->assertEmpty($topic->getPulledAt());
        $topic->setPulledNow();
        $this->assertInstanceOf('\DateTime', $topic->getPulledAt());
        $this->assertEquals(new \DateTime('now'), $topic->getPulledAt());
    }

    protected function getCategoryMock()
    {
        return $this->getMock($this->categoryClass);
    }

}
