<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\TextareaField;
use Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class NewTopicFormType extends AbstractType
{
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
