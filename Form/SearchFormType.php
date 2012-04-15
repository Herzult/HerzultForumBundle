<?php

namespace Herzult\Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('query', 'text', array('translation_domain' => 'HerzultForumBundle_forms'));
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class'        => 'Herzult\Bundle\ForumBundle\Search\Search',
            'csrf_protection'   => false,
            'translation_domain' => 'HerzultForumBundle_forms',
        );
    }

    public function getName()
    {
        return 'Search';
    }
}
