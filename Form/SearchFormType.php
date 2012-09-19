<?php

namespace Herzult\Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('query', 'text');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class'        => 'Herzult\Bundle\ForumBundle\Search\Search',
            'csrf_protection'   => false,
        );
    }

    public function getName()
    {
        return 'Search';
    }
}
