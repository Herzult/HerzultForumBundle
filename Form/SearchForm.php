<?php

namespace Bundle\ForumBundle\Form;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class SearchForm extends Form
{
    public function configure()
    {
        $this->add(new TextField('query'));
    }
}
