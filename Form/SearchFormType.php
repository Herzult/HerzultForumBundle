<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\TextField;

class SearchFormType extends AbstractType
{
    public function configure()
    {
        $this->add(new TextField('query'));
    }
}
