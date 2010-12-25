<?php

namespace Bundle\ForumBundle\Updater;

class TopicUpdaterTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdate()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();
        $post3 = $this->createPost();
        $posts = array($post1, $post2, $post3);

        $category = $this->getMockBuilder('Bundle\ForumBundle\Model\Category')
            ->disableOriginalConstructor()
            ->getMock();

        $topic = $this->getMockBuilder('Bundle\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();
        $topic->expects($this->once())
            ->method('setNumPosts')
            ->with(3);
        $topic->expects($this->once())
            ->method('setFirstPost')
            ->with($post1);
        $topic->expects($this->once())
            ->method('setLastPost')
            ->with($post3);
        $topic->expects($this->once())
            ->method('getCategory')
            ->will($this->returnValue($category));

        $objectManager = $this->getMockBuilder('stdClass')
            ->disableOriginalConstructor()
            ->setMethods(array('flush'))
            ->getMock();
        $objectManager->expects($this->exactly(2))
            ->method('flush');

        $postRepository = $this->getMockBuilder('Bundle\ForumBundle\Model\PostRepositoryInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $postRepository->expects($this->once())
            ->method('findAllByTopic')
            ->with($topic)
            ->will($this->returnValue($posts));

        $categoryUpdater = $this->getMockBuilder('Bundle\ForumBundle\Updater\CategoryUpdater')
            ->disableOriginalConstructor()
            ->getMock();
        $categoryUpdater->expects($this->once())
            ->method('update')
            ->with($category);

        $updater = new TopicUpdater($objectManager, $postRepository, $categoryUpdater);
        $updater->update($topic);
    }

    public function createPost()
    {
        return $this->getMockBuilder('Bundle\ForumBundle\Model\Post')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
