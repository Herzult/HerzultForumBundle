<?php

namespace Bundle\ForumBundle\Updater;

class CategoryUpdaterTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdate()
    {
        $lastPost1 = $this->createPost();
        $lastPost1->expects($this->once())
            ->method('isPosteriorTo')
            ->will($this->returnValue(true));
        $topic1 = $this->createTopic($lastPost1);

        $lastPost2 = $this->createPost();
        $lastPost2->expects($this->once())
            ->method('isPosteriorTo')
            ->with($lastPost1)
            ->will($this->returnValue(true));
        $topic2 = $this->createTopic($lastPost2);

        $topics = array($topic1, $topic2);

        $category = $this->getMockBuilder('Bundle\ForumBundle\Model\Category')
            ->disableOriginalConstructor()
            ->getMock();

        $category->expects($this->once())
            ->method('setNumTopics')
            ->with(2);
        $category->expects($this->once())
            ->method('setNumPosts')
            ->with(8);
        $category->expects($this->once())
            ->method('setLastTopic')
            ->with($topic2);
        $category->expects($this->once())
            ->method('setLastPost')
            ->with($lastPost2);

        $topicRepository = $this->getMockBuilder('Bundle\ForumBundle\Model\TopicRepositoryInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $topicRepository->expects($this->once())
            ->method('findAllByCategory')
            ->with($category)
            ->will($this->returnValue($topics));

        $objectManager = $this->getMockBuilder('stdClass')
            ->disableOriginalConstructor()
            ->setMethods(array('flush'))
            ->getMock();
        $objectManager->expects($this->exactly(1))
            ->method('flush');

        $updater = new CategoryUpdater($objectManager, $topicRepository);
        $updater->update($category);
    }

    public function createPost()
    {
        return $this->getMockBuilder('Bundle\ForumBundle\Model\Post')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function createTopic($lastPost)
    {
        $topic = $this->getMockBuilder('Bundle\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();
        $topic->expects($this->once())
            ->method('getNumPosts')
            ->will($this->returnValue(4));
        $topic->expects($this->once())
            ->method('getLastPost')
            ->will($this->returnValue($lastPost));

        return $topic;
    }
}
