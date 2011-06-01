<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\TextareaField;

class PostFormType extends AbstractType
{
    public function configure()
    {
        $this->setDataClass($this->getOption('post_class'));

        $this->add(new TextareaField('message'));
    }
}
