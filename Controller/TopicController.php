<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TopicController extends Controller
{

    public function listAction($category = null)
    {
        if (null !== $category) {
            $topics = $this['forum.topic_repository']->findAllByCategory($category);
        } else {
            $topics = $this['forum.topic_repository']->findAll();
        }

        return $this->render('ForumBundle:Topic:list:'.$this->getRenderer(), array('topics' => $topics));
    }

    public function showAction($id)
    {
        $topic = $this['forum.topic_repository']->findOneById($id);

        if (!$topic) {
            throw new NotFoundHttpException('The topic does not exist.');
        }

        return $this->render('ForumBundle:Topic:show:'.$this->getRenderer(), array('topic' => $topic));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
