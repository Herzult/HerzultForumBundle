<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\ForumBundle\Form\SearchForm;
use Bundle\ForumBundle\Search\Search;

class ForumController extends Controller
{
    public function indexAction()
    {
        return $this->render('ForumBundle:Forum:index.'.$this->getRenderer(), array(
            'page'  => $this->get('request')->query->get('page', 1)
        ));
    }

    public function searchAction()
    {
        $search = new Search();
        $form = new SearchForm('search', $search, $this->get('validator'));

        $results = null;
        if($this->get('request')->query->has('q')) {
            $form->bind(array('query' => $this->get('request')->query->get('q')));
            if($form->isValid()) {
                $page = $this->get('request')->query->get('page', 1);
                $results = $this->get('forum.repository.post')->search($search->query, true);
                $results->setCurrentPageNumber($page);
                $results->setItemCountPerPage($this->container->getParameter('forum.paginator.search_results_per_page'));
                $results->setPageRange(5);
            }
        }

        return $this->render('ForumBundle:Forum:search.'.$this->getRenderer(), array(
            'form' => $form,
            'results' => $results,
            'query' => $search->query
        ));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
