<?php

namespace Bundle\ForumBundle\Search;
use Zend\Paginator\Paginator;
use Symfony\Component\Router\Router;
use Bundle\DoctrinePaginatorBundle\PaginatorODMAdapter;

class Engine
{
    protected $postRepository;
    protected $urlGenerator;

    public function __construct(PostRepositoryInterface $postRepository, Router $router)
    {
        $this->postRepository = $postRepository;
        $this->urlGenerator = $router->getGenerator();
    }

    public function search($query)
    {
    }
}
