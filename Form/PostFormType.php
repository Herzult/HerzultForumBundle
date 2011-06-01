<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostFormType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->add('message', 'textarea');
    }
}
