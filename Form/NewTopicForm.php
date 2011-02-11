<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class NewTopicForm extends Form
{
    public function __construct($title, array $options)
    {
        $this->addOption('theme');
        $this->addOption('topic_class');
        $this->addOption('category_repository');
        $this->addOption('post_form');

        parent::__construct($title, $options);
    }

    public function configure()
    {
        $this->setDataClass($this->getOption('topic_class'));

        $this->add(new TextField('subject'));
        $categoryField = new CategoryChoiceField('category', array(
            'repository' => $this->getOption('category_repository'),
            'required' => true
        ));
        $this->add($categoryField);
        $this->add($this->getOption('post_form'));
    }
}
