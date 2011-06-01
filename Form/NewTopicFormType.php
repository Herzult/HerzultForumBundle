<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Bundle\ForumBundle\Model\CategoryRepositoryInterface;

class NewTopicFormType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->add('subject');
        $builder->add('category');
        $builder->add('firstPost', $options['post_form'], array('data_class' => $options['post_class']));
    }

	public function getDefaultOptions(array $options)
	{
		return array(
			'post_class'	=> '',
			'post_form'		=> '',
			'data_class'	=> '',
		);
	}
}
