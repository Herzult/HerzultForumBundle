<?php

namespace Bundle\ForumBundle\Form;

use Symfony\Component\Form\ChoiceField;
use Bundle\ForumBundle\Form\ValueTransformer\DoctrineObjectTransformer;

/**
 * Lets the user select between different choices
 *
 * @author Bernhard Schussek <bernhard.schussek@symfony-project.com>
 */
class CategoryChoiceField extends ChoiceField
{
    public function __construct($key, array $options = array())
    {
        $this->addOption('repository');

        $this->setValueTransformer(new DoctrineObjectTransformer($options['repository']));

        if(empty($options['choices'])) {
            $options['choices'] = $options['repository']->findAllIndexById();
        }

        parent::__construct($key, $options);
    }
}
