<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class NewTopicForm extends Form
{
    protected $categoryRepository;
    protected $postForm;

    public function __construct($name, $object, $validator, array $options = array(), CategoryRepositoryInterface $categoryRepository, PostForm $postForm)
    {
        $this->addOption('theme');
        $this->addOption('topic_class');
        $this->categoryRepository = $categoryRepository;

        $topic = new $options['topic_class']();
        $postForm->getData()->setTopic($topic);
        $topic->setFirstPost($postForm->getData());

        $this->postForm = $postForm;

        parent::__construct($name, $topic, $validator, $options);
    }

    public function configure()
    {
        $this->add(new TextField('subject'));
        $categoryField = new CategoryChoiceField('category', array(
            'repository' => $this->categoryRepository,
            'required' => true
        ));
        $this->add($categoryField);
        $this->add($this->postForm);
    }
}
