<?php

namespace Bundle\ForumBundle\Remover;

class PostRemoverTest extends \PHPUnit_Framework_TestCase
{
    public function testRemove()
    {
        $topic = $this->getMockBuilder('Bundle\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();

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
        $objectManager->expects($this->once())
            ->method('flush');

        $topicUpdater = $this->getMockBuilder('Bundle\ForumBundle\Updater\TopicUpdater')
            ->disableOriginalConstructor()
            ->setMethods(array('update'))
            ->getMock();
        $topicUpdater->expects($this->once())
            ->method('update')
            ->with($topic);

        $remover = new PostRemover($objectManager, $topicUpdater);
        $remover->remove($post);
    }
}
