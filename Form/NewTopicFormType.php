<?php

    namespace Herzult\Bundle\ForumBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;
    use Herzult\Bundle\ForumBundle\Form\PostFormType;

    class NewTopicFormType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('subject', 'text', array('label' => 'Sujet :'));
            $builder->add('category');
            $builder->add('firstPost', $options['post_form'], array(
                'data_class' => $options['post_class']
            ));
        }

        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setDefaults(array(
                'post_class'    => 'Herzult\Bundle\ForumBundle\Entity\Post',
                'post_form'     => new PostFormType(),
                'data_class'    => 'Herzult\Bundle\ForumBundle\Entity\Topic',
            ));
        }

        public function getName()
        {
            return 'NewTopic';
        }
    }
