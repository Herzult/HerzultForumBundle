<?php

namespace Bundle\ForumBundle\Creator;

class TopicCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdate()
    {
        $topic = $this->getMockBuilder('Bundle\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();

        $category = $this->getMockBuilder('Bundle\ForumBundle\Model\Category')
            ->disableOriginalConstructor()
            ->getMock();
        $category->expects($this->once())
            ->method('incrementNumTopics');
        $category->expects($this->once())
            ->method('setLastTopic')
            ->with($topic);

        $topic->expects($this->once())
            ->method('getCategory')
            ->will($this->returnValue($category));

        $creator = new TopicCreator();
        $creator->create($topic);
    }
}
