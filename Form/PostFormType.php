<?php

namespace Herzult\Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('message', 'textarea', array('translation_domain' => 'HerzultForumBundle_forms'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'translation_domain' => 'HerzultForumBundle_forms',
        );
    }

    public function getName()
    {
        return 'Post';
    }
}
