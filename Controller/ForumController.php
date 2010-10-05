<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\ForumBundle\Form\SearchForm;
use Bundle\ForumBundle\Search\Search;

class ForumController extends Controller
{
    public function indexAction()
    {
        return $this->render('ForumBundle:Forum:index.'.$this->getRenderer());
    }

    public function searchAction()
    {
        $search = new Search();
        $form = new SearchForm('search', $search, $this['validator']);

        if($this['request']->query->has($form->getName())) {
            $form->bind($this['request']->query->get($form->getName()));
            if($form->isValid()) {
            }
        }

        return $this->render('ForumBundle:Forum:search.'.$this->getRenderer(), array('form' => $form));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
