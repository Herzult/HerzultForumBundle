<?php

namespace Herzult\Bundle\ForumBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Herzult\Bundle\ForumBundle\DependencyInjection\HerzultForumExtension;

class HerzultForumExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getDataToTestDefinedParameter
     */
    public function testDefinedParameter($parameter, $expected)
    {
        $container = $this->createContainer($this->getMinimalConfigs());

        $this->assertTrue($container->hasParameter($parameter), sprintf('The parameter \'%s\' is defined.', $parameter));
        $this->assertEquals($expected, $container->getParameter($parameter), sprintf('The parameter \'%s\' has the right value.', $parameter));
    }

    /**
     * @dataProvider getDataToTestDefinedService
     */
    public function testDefinedService($id)
    {
        $container = $this->createContainer($this->getMinimalConfigs());

        $this->assertTrue(($container->has($id) || $container->get($id)), sprintf('The service (or alias) \'%s\' is defined.', $id));
    }

    public function getDataToTestDefinedParameter()
    {
        return array(
            array(
                'herzult_forum.form.new_topic.class',
                'Herzult\Bundle\ForumBundle\Form\NewTopicFormType'
            ),
            array(
                'herzult_forum.form.post.class',
                'Herzult\Bundle\ForumBundle\Form\PostFormType'
            ),
            array(
                'herzult_forum.form.first_post.class',
                'Herzult\Bundle\ForumBundle\Form\PostFormType'
            ),
            array(
                'herzult_forum.form.search.class',
                'Herzult\Bundle\ForumBundle\Form\SearchFormType'
            ),
            array(
                'herzult_forum.controller.forum.class',
                'Herzult\Bundle\ForumBundle\Controller\ForumController'
            ),
            array(
                'herzult_forum.controller.category.class',
                'Herzult\Bundle\ForumBundle\Controller\CategoryController'
            ),
            array(
                'herzult_forum.controller.topic.class',
                'Herzult\Bundle\ForumBundle\Controller\TopicController'
            ),
            array(
                'herzult_forum.controller.post.class',
                'Herzult\Bundle\ForumBundle\Controller\PostController'
            ),
            array(
                'herzult_forum.blamer.topic.class',
                'Herzult\Bundle\ForumBundle\Blamer\TopicBlamer'
            ),
            array(
                'herzult_forum.blamer.post.class',
                'Herzult\Bundle\ForumBundle\Blamer\PostBlamer'
            ),
            array(
                'herzult_forum.twig.extension.class',
                'Herzult\Bundle\ForumBundle\Twig\ForumExtension'
            ),
            array(
                'herzult_forum.templating.engine',
                'twig'
            ),
            array(
                'herzult_forum.templating.theme',
                'Twig::form.html.twig'
            ),
            array(
                'herzult_forum.paginator.posts_per_page',
                10
            ),
            array(
                'herzult_forum.paginator.topics_per_page',
                10
            ),
            array(
                'herzult_forum.paginator.search_results_per_page',
                10
            ),
            array(
                'herzult_forum.form.new_topic.name',
                'forum_new_topic_form'
            ),
            array(
                'herzult_forum.form.post.name',
                'forum_post_form'
            ),
            array(
                'herzult_forum.form.first_post.name',
                'firstPost'
            ),
        );
    }

    public function getDataToTestDefinedService()
    {
        return array(
            array('herzult_forum.object_manager'),
            array('herzult_forum.repository.category'),
            array('herzult_forum.repository.topic'),
            array('herzult_forum.repository.post'),
            array('herzult_forum.repository.category'),
            array('herzult_forum.repository.topic'),
            array('herzult_forum.repository.post'),
            array('herzult_forum.form.new_topic'),
            array('herzult_forum.form.post'),
            array('herzult_forum.form.first_post'),
            array('herzult_forum.form.new_topic'),
            array('herzult_forum.form.post'),
            array('herzult_forum.controller.forum'),
            array('herzult_forum.controller.category'),
            array('herzult_forum.controller.topic'),
            array('herzult_forum.controller.post'),
            array('herzult_forum.blamer.topic'),
            array('herzult_forum.blamer.post'),
            array('herzult_forum.twig.extension'),
            array('herzult_forum.controller.forum'),
            array('herzult_forum.controller.category'),
            array('herzult_forum.controller.topic'),
            array('herzult_forum.controller.post'),
            array('herzult_forum.creator.topic'),
            array('herzult_forum.creator.post'),
        );
    }

    public function getMinimalConfigs()
    {
        return array(
            array(
                'db_driver' => 'orm',
                'class'     => array(
                    'model' => array(
                        'category'  => 'MyCategory',
                        'topic'     => 'MyTopic',
                        'post'      => 'MyPost',
                    ),
                ),
            ),
        );
    }

    public function createContainer(array $configs)
    {
        $container = new ContainerBuilder();
        $extension = new HerzultForumExtension('testkernel');
        $extension->load($configs, $container);

        return $container;
    }
}
