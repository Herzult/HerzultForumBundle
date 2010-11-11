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

    public function __construct($name, $object, $validator, array $options = array(), CategoryRepositoryInterface $categoryRepository, PostForm $postForm, array $classes)
    {
        $this->addOption('theme');
        $this->categoryRepository = $categoryRepository;

        $topic = new $classes['topic']();
        $post = new $classes['post']();
        $post->setTopic($topic);
        $topic->setFirstPost($post);

        $postForm->setData($post);
        $postForm->disableCSRFProtection();
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
