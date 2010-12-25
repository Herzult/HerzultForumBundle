<?php

namespace Bundle\ForumBundle\Remover;

class PostRemoverTest extends \PHPUnit_Framework_TestCase
{
    public function testRemove()
    {
        $category = $this->getMockBuilder('Bundle\ForumBundle\Model\Category')
            ->disableOriginalConstructor()
            ->getMock();

        $topic = $this->getMockBuilder('Bundle\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();
        $topic->expects($this->once())
            ->method('getCategory')
            ->will($this->returnValue($category));
        $topic->expects($this->once())
            ->method('getNumPosts')
            ->will($this->returnValue(5));

        $post = $this->getMockBuilder('Bundle\ForumBundle\Model\Post')
            ->disableOriginalConstructor()
            ->setMethods(array('getTopic', 'getAuthorName'))
            ->getMock();
        $post->expects($this->once())
            ->method('getTopic')
            ->will($this->returnValue($topic));

        $objectManager = $this->getMockBuilder('stdClass')
            ->disableOriginalConstructor()
            ->setMethods(array('remove', 'flush'))
            ->getMock();
        $objectManager->expects($this->once())
            ->method('remove')
            ->with($post);
        $objectManager->expects($this->exactly(2))
            ->method('flush');

        $topicUpdater = $this->getMockBuilder('Bundle\ForumBundle\Updater\TopicUpdater')
            ->disableOriginalConstructor()
            ->setMethods(array('update'))
            ->getMock();
        $topicUpdater->expects($this->once())
            ->method('update')
            ->with($topic);

        $categoryUpdater = $this->getMockBuilder('Bundle\ForumBundle\Updater\CategoryUpdater')
            ->disableOriginalConstructor()
            ->setMethods(array('update'))
            ->getMock();
        $categoryUpdater->expects($this->once())
            ->method('update')
            ->with($category);

        $remover = new PostRemover($objectManager, $topicUpdater, $categoryUpdater);
        $remover->remove($post);
    }
}
