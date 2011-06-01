<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\ForumBundle\Form\SearchFormType;
use Bundle\ForumBundle\Search\Search;

class ForumController extends Controller
{
    public function indexAction()
    {
        return $this->get('templating')->renderResponse('ForumBundle:Forum:index.html.'.$this->getRenderer(), array(
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
		if($form->isValid()) {
			$page = $this->get('request')->query->get('page', 1);
			$results = $this->get('forum.repository.post')->search($query, true);
			$results->setCurrentPageNumber($page);
			$results->setItemCountPerPage($this->container->getParameter('forum.paginator.search_results_per_page'));
			$results->setPageRange(5);
		}

        return $this->get('templating')->renderResponse('ForumBundle:Forum:search.html.'.$this->getRenderer(), array(
            'form'		=> $form->createView(),
            'results'	=> $results,
            'query'		=> $query
        ));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
