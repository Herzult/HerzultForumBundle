<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextareaField;

class PostForm extends Form
{
    public function __construct($title, array $options = array())
    {
        $this->addOption('theme');
        $this->addOption('post_class');

        parent::__construct($title, $options);
    }

    public function configure()
    {
        $this->setDataClass($this->getOption('post_class'));

        $this->add(new TextareaField('message'));
    }
}
