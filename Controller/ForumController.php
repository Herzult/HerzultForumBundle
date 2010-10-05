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

        $results = null;
        if($this['request']->query->has($form->getName())) {
            $form->bind($this['request']->query->get($form->getName()));
            if($form->isValid()) {
                $page = $this['request']->query->get('page', 1);
                $results = $this['forum.post_repository']->search($search->query, true);
                $results->setCurrentPageNumber($page);
                $results->setItemCountPerPage($this->container->getParameter('forum.search_results.max_per_page'));
                $results->setPageRange(5);
            }
        }

        return $this->render('ForumBundle:Forum:search.'.$this->getRenderer(), array(
            'form' => $form,
            'results' => $results
        ));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
