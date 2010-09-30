<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function listAction()
    {
        $categories = $this['forum.category_repository']->findAll();

        return $this->render('ForumBundle:Category:list.'.$this->getRenderer(), array('categories' => $categories));
    }

    public function showAction($slug)
    {
        $category = $this['forum.category_repository']->findOneBySlug($slug);

        if (!$category) {
            throw new NotFoundHttpException('The topic does not exist.');
        }

        $topics = $this['forum.topic_repository']->findAllByCategory($category, true);

        return $this->render('ForumBundle:Category:show.'.$this->getRenderer(), array(
            'category' => $category,
            'topics' => $topics
        ));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
