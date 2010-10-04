<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\InputField;
use Symfony\Component\Form\TextareaField;

class NewTopicForm extends Form
{
    public function configure()
    {
        $this->add(new InputField('category'));
        $this->add(new InputField('subject'));
        $this->add(new TextareaField('post'));
    } 
}
