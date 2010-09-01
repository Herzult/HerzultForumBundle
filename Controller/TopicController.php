<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TopicController extends Controller
{

    public function listAction($category = null)
    {
        if (null !== $category) {
            $topics = $this['forum.topic_repository']->findAllByCategory($category);
        } else {
            $topics = $this['forum.topic_repository']->findAll();
        }

        return $this->render('ForumBundle:Topic:list', array('topics' => $topics));
    }

}