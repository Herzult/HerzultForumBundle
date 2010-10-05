<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;

class NewTopicForm extends Form
{
    public function __construct($name, $object, $validator, array $options = array())
    {
        $this->addOption('categoryRepository');

        parent::__construct($name, $object, $validator, $options);
    }

    public function configure()
    {
        $this->add(new TextField('subject'));
        $categoryField = new CategoryChoiceField('category', array(
            'repository' => $this->getOption('categoryRepository'),
            'required' => false,
            'empty_value' => 'Select a category'
        ));
        $this->add($categoryField);
    } 
}
