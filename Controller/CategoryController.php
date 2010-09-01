<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function listAction()
    {
        $categories = $this['forum.category_repository']->findAll();

        return $this->render('ForumBundle:Category:list', array('categories' => $categories));
    }
}