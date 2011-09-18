<?php

namespace Herzult\Bundle\ForumBundle\Creator;

class PostCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdate()
    {
        $post = $this->getMockBuilder('Herzult\Bundle\ForumBundle\Model\Post')
            ->disableOriginalConstructor()
            ->getMock();

        $category = $this->getMockBuilder('Herzult\Bundle\ForumBundle\Model\Category')
            ->disableOriginalConstructor()
            ->getMock();
        $category->expects($this->once())
            ->method('setLastPost')
            ->with($post);
        $category->expects($this->once())
            ->method('incrementNumPosts');

        $topic = $this->getMockBuilder('Herzult\Bundle\ForumBundle\Model\Topic')
            ->disableOriginalConstructor()
            ->getMock();
        $topic->expects($this->once())
            ->method('getCategory')
            ->will($this->returnValue($category));
        $topic->expects($this->once())
            ->method('getFirstPost')
            ->will($this->returnValue(null));
        $topic->expects($this->once())
            ->method('setFirstPost')
            ->with($post);
        $topic->expects($this->once())
            ->method('incrementNumPosts');
        $topic->expects($this->once())
            ->method('setLastPost')
            ->with($post);
        $topic->expects($this->once())
            ->method('setPulledAt');
        $topic->expects($this->once())
            ->method('getNumPosts')
            ->will($this->returnValue(10));

        $post->expects($this->once())
            ->method('getTopic')
            ->will($this->returnValue($topic));
        $post->expects($this->once())
            ->method('setNumber')
            ->with(10);

        $creator = new PostCreator();
        $creator->create($post);
    }
}
