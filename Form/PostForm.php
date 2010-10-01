<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextareaField;

class PostForm extends Form
{
    public function configure()
    {
        $this->add(new TextareaField('message'));
    } 
}
