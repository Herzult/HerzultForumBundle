<?php

namespace Bundle\ForumBundle\Tests\DAO;

class TopicTest extends \PHPUnit_Framework_TestCase
{

    public function testSubject()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEmpty('subject', $topic, 'the subject is empty during creation');

        $topic->setSubject('A topic sample');
        $this->assertAttributeEquals('A topic sample', 'subject', $topic, '::setSubject() sets the subject');
        $this->assertEquals('A topic sample', $topic->getSubject(), '::getSubject() gets the subject');
    }

    public function testNumViews()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEquals(0, 'numViews', $topic, 'the number of views is set to 0 during creation');

        $topic->setNumViews(4);
        $this->assertAttributeEquals(4, 'numViews', $topic, '::setNumViews() sets the number of views');
        $this->assertEquals(4, $topic->getNumViews(), '::getNumViews() gets the number of views');

        $topic->incrementNumViews();
        $this->assertAttributeEquals(5, 'numViews', $topic, '::incrementNumViews() increases the number of views');

        $topic->decrementNumViews();
        $this->assertAttributeEquals(4, 'numViews', $topic, '::decrementNumViews() decreases the number of views');

        $topic->setNumViews('SomeString');
        $this->assertAttributeInternalType('integer', 'numViews', $topic, 'the number of views is mandatory an integer');
    }

    public function testNumReplies()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEquals(0, 'numViews', $topic, 'the number of replies is set to 0 during creation');

        $topic->setNumReplies(4);
        $this->assertAttributeEquals(4, 'numReplies', $topic, '::setNumReplies() sets the number of replies');
        $this->assertEquals(4, $topic->getNumReplies(), '::getNumReplies() gets the number of replies');

        $topic->incrementNumReplies();
        $this->assertAttributeEquals(5, 'numReplies', $topic, '::incrementNumReplies() increases the number of replies');

        $topic->decrementNumReplies();
        $this->assertAttributeEquals(4, 'numReplies', $topic, '::decrementNumReplies() decreases the number of replies');

        $topic->setNumReplies('SomeString');
        $this->assertAttributeInternalType('integer', 'numReplies', $topic, 'the number of replies is mandatory an integer');
    }

    public function testCategory()
    {
        $category = $this->getMock('Bundle\ForumBundle\DAO\Category');

        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEmpty('category', $topic, 'the category is not set during creation');

        $topic->setCategory($category);
        $this->assertAttributeEquals($category, 'category', $topic, '::setCategory() sets the category');
        $this->assertEquals($category, $topic->getCategory(), '::getCategory() gets the category');
    }

    public function testIsClosed()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEquals(false, 'isClosed', $topic, 'the topic is not closed during creation');

        $this->assertAttributeEquals($topic->getIsClosed(), 'isClosed', $topic, '::getIsClosed() gets the closure status');

        $topic->setIsClosed(true);
        $this->assertAttributeEquals(true, 'isClosed', $topic, '::setIsClosed() sets the closure status');

        $topic->setIsClosed('AnyString');
        $this->assertAttributeInternalType('boolean', 'isClosed', $topic, 'the closure status is mandatory a boolean');
    }

    public function testIsPinned()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEquals(false, 'isPinned', $topic, 'the topic is not pinned during creation');

        $this->assertAttributeEquals($topic->getIsPinned(), 'isPinned', $topic, '::getIsPinned() gets the pinning status');

        $topic->setIsPinned(true);
        $this->assertAttributeEquals(true, 'isPinned', $topic, '::setIsPinned() sets the pinning status');

        $topic->setIsPinned('AnyString');
        $this->assertAttributeInternalType('boolean', 'isPinned', $topic, 'the pinning status is mandatory a boolean');
    }

    public function testIsBuried()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEquals(false, 'isBuried', $topic, 'the topic is not buried during creation');

        $this->assertAttributeEquals($topic->getIsBuried(), 'isBuried', $topic, '::getBuried() gets the buring status');

        $topic->setIsBuried(true);
        $this->assertAttributeEquals(true, 'isBuried', $topic, '::setIsBuried() sets the buring status');

        $topic->setIsBuried('AnyString');
        $this->assertAttributeInternalType('boolean', 'isBuried', $topic, 'the buring status is mandatory a boolean');
    }

    public function testCreatedAt()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEmpty('createdAt', $topic, 'the creation timestamp is not set during creation');

        $date = new \DateTime('now');
        $topic->setCreatedNow();
        $this->assertAttributeEquals($date, 'createdAt', $topic, '::setCreatedNow() sets the creation timestamp as now as a DateTime object');
        $this->assertEquals($date, $topic->getCreatedAt(), '::getCreatedAt() gets the creation timestamp as a DateTime object');
    }

    public function testPulledAt()
    {
        $topic = $this->getMock('Bundle\ForumBundle\DAO\Topic', null);
        $this->assertAttributeEmpty('pulledAt', $topic, 'the pull timestamp is not set during creation');

        $date = new \DateTime('now');
        $topic->setPulledNow();
        $this->assertAttributeEquals($date, 'pulledAt', $topic, '::setPulledNow() sets the pull timestamp as now as a DateTime object');
        $this->assertEquals($date, $topic->getPulledAt(), '::getPulledDate() gets the pull timestamp as a DateTime object');
    }

}