<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextareaField;

class PostForm extends Form
{
    public function __construct($title, array $options = array())
    {
        $this->addOption('theme');

        parent::__construct($title, $options);
    }

    public function configure()
    {
        $this->add(new TextareaField('message'));
    }
}
