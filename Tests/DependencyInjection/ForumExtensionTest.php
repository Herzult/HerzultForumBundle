<?php

namespace Bundle\ForumBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Bundle\ForumBundle\DependencyInjection\ForumExtension;
use Symfony\Component\Yaml\Parser;

class ForumExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $configuration;

    public function testForumLoadModelClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Bundle\ForumBundle\Document\Category', 'forum.model.category.class');
        $this->assertParameter('Bundle\ForumBundle\Document\Topic', 'forum.model.topic.class');
        $this->assertParameter('Bundle\ForumBundle\Document\Post', 'forum.model.post.class');
    }

    public function testForumLoadModelClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('category', 'forum.model.category.class');
        $this->assertParameter('topic', 'forum.model.topic.class');
        $this->assertParameter('post', 'forum.model.post.class');
    }

    public function testForumLoadRepositoryClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('forum.repository.category');
        $this->assertHasDefinition('forum.repository.topic');
        $this->assertHasDefinition('forum.repository.post');
    }

    public function testForumLoadRepositoryClass()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('forum.repository.category');
        $this->assertHasDefinition('forum.repository.topic');
        $this->assertHasDefinition('forum.repository.post');
    }

    public function testForumLoadFormClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Bundle\ForumBundle\Form\TopicForm', 'forum.form.topic.class');
        $this->assertParameter('Bundle\ForumBundle\Form\PostForm', 'forum.form.post.class');
    }

    public function testForumLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('topic', 'forum.form.topic.class');
        $this->assertParameter('post', 'forum.form.post.class');
    }

    public function testForumLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('forum_topic_form', 'forum.form.topic.name');
        $this->assertParameter('forum_post_form', 'forum.form.post.name');
    }

    public function testForumLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('topic', 'forum.form.topic.name');
        $this->assertParameter('post', 'forum.form.post.name');
    }

    public function testForumLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('forum.form.topic');
        $this->assertHasDefinition('forum.form.post');
    }

    public function testForumLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('forum.form.topic');
        $this->assertHasDefinition('forum.form.post');
    }

    public function testForumLoadControllerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Bundle\ForumBundle\Controller\CategoryController', 'forum.controller.category.class');
        $this->assertParameter('Bundle\ForumBundle\Controller\TopicController', 'forum.controller.topic.class');
        $this->assertParameter('Bundle\ForumBundle\Controller\PostController', 'forum.controller.post.class');
    }

    public function testForumLoadControllerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('category', 'forum.controller.category.class');
        $this->assertParameter('topic', 'forum.controller.topic.class');
        $this->assertParameter('post', 'forum.controller.post.class');
    }

    public function testForumLoadControllerServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('forum.controller.category');
        $this->assertHasDefinition('forum.controller.topic');
        $this->assertHasDefinition('forum.controller.post');
    }

    public function testForumLoadControllerService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('forum.controller.category');
        $this->assertHasDefinition('forum.controller.topic');
        $this->assertHasDefinition('forum.controller.post');
    }

    /**
     * @return ContainerBuilder
     */
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new ForumExtension('testkernel');
        $config = $this->getEmptyConfig();
        $loader->configLoad($config, $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * @return ContainerBuilder
     */
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new ForumExtension('testkernel');
        $config = $this->getFullConfig();
        $loader->configLoad($config, $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
db_driver: odm
class:
    model:
        category: ~
        topic: ~
        post: ~
    form:
        topic: ~
        post: ~
    controller:
        category: ~
        topic: ~
        post: ~
EOF;
        $parser = new Parser();
        return $parser->parse($yaml);
    }

    protected function getFullConfig()
    {
        $config = $this->getEmptyConfig();
        array_walk_recursive($config, function(&$item, $key) {
            if(!is_array($item)) {
                $item = $key;
            }
        });
        $config['db_driver'] = 'orm';

        return $config;
    }

    public function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is correct', $key));
    }

    public function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ? : $this->configuration->hasAlias($id)));
    }

    public function tearDown()
    {
        unset($this->configuration);
    }

}
