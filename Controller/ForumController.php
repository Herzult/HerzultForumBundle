<?php

namespace Herzult\Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Herzult\Bundle\ForumBundle\Form\SearchFormType;
use Herzult\Bundle\ForumBundle\Search\Search;

class ForumController extends Controller
{
    public function indexAction()
    {
        return $this->get('templating')->renderResponse('HerzultForumBundle:Forum:index.html.'.$this->getRenderer(), array(
            'page'  => $this->get('request')->query->get('page', 1)
        ));
    }

    public function searchAction()
    {
        $search = new Search();
        $form = $this->get('form.factory')->create(new SearchFormType(), $search);
        $form->bind(array('query' => $this->get('request')->query->get('q')));
        $query = $form->getData()->getQuery();

        $results = null;
        if ($form->isValid()) {
            $page = $this->get('request')->query->get('page', 1);
            $results = $this->get('herzult_forum.repository.post')->search($query, true);
            $results->setCurrentPage($page);
            $results->setMaxPerPage($this->container->getParameter('herzult_forum.paginator.search_results_per_page'));
        }

        return $this->get('templating')->renderResponse('HerzultForumBundle:Forum:search.html.'.$this->getRenderer(), array(
            'form'      => $form->createView(),
            'results'   => $results,
            'query'     => $query
        ));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('herzult_forum.templating.engine');
    }
}
