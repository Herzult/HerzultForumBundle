<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchFormType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->add('query', 'text');
    }

	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class'		=> 'Bundle\ForumBundle\Search\Search',
			'csrf_protection'	=> false,
		);
	}

    public function getName()
    {
        return 'Search';
    }
}
