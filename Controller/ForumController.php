<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ForumController extends Controller
{

    public function indexAction()
    {
        return $this->render('ForumBundle:Forum:index');
    }

    public function categoryAction($category_slug)
    {
        $category = $this['forum.category_repository']->findOneBySlug($category_slug);

        if (!$category) {
            throw new NotFoundHttpException('The topic does not exist.');
        }

        return $this->render('ForumBundle:Forum:category', array(
            'category' => $category
        ));
    }

    public function topicAction($topic_id)
    {
        $topic = $this['forum.topic_repository']->findOneById($topic_id);

        if (!$topic) {
            throw new NotFoundHttpException('The topic does not exist.');
        }

        return $this->render('ForumBundle:Forum:topic', array('topic' => $topic));
    }

}