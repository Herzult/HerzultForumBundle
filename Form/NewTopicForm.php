<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class NewTopicForm extends Form
{
    protected $categoryRepository;

    public function __construct($name, $object, $validator, array $options = array(), CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

        parent::__construct($name, $object, $validator, $options);
    }

    public function configure()
    {
        $this->add(new TextField('subject'));
        $categoryField = new CategoryChoiceField('category', array(
            'repository' => $this->categoryRepository,
            'required' => true
        ));
        $this->add($categoryField);
    }
}
