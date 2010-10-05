<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\ForumBundle\Form\SearchForm;

class ForumController extends Controller
{
    public function indexAction()
    {
        return $this->render('ForumBundle:Forum:index.'.$this->getRenderer());
    }

    public function searchAction()
    {
        $form = new SearchForm('search', array(), $this['validator']);
        return $this->render('ForumBundle:Forum:search.'.$this->getRenderer(), array('form' => $form));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
