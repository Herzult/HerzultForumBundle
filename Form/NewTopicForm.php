<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Form\ChoiceField;

class NewTopicForm extends Form
{
    public function __construct($name, $object, $validator, array $options = array())
    {
        $this->addOption('categoryChoices');

        parent::__construct($name, $object, $validator, $options);
    }

    public function configure()
    {
        $this->add(new TextField('subject'));
        $categoryField = new ChoiceField('category', array(
            'choices' => $this->getOption('categoryChoices'),
            'required' => false,
            'empty_value' => 'Select a category'
        ));
        $this->add($categoryField);
    } 
}
