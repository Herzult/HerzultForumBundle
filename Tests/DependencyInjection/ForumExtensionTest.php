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

        $this->assertParameter('MyCategory', 'forum.model.category.class');
        $this->assertParameter('MyTopic', 'forum.model.topic.class');
        $this->assertParameter('MyPost', 'forum.model.post.class');
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

        $this->assertParameter('Bundle\ForumBundle\Form\NewTopicForm', 'forum.form.new_topic.class');
        $this->assertParameter('Bundle\ForumBundle\Form\PostForm', 'forum.form.post.class');
        $this->assertParameter('Bundle\ForumBundle\Form\PostForm', 'forum.form.first_post.class');
    }

    public function testForumLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('new_topic', 'forum.form.new_topic.class');
        $this->assertParameter('post', 'forum.form.post.class');
        $this->assertParameter('first_post', 'forum.form.first_post.class');
    }

    public function testForumLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('forum_new_topic_form', 'forum.form.new_topic.name');
        $this->assertParameter('forum_post_form', 'forum.form.post.name');
        $this->assertParameter('firstPost', 'forum.form.first_post.name');
    }

    public function testForumLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('new_topic', 'forum.form.new_topic.name');
        $this->assertParameter('post', 'forum.form.post.name');
        $this->assertParameter('first_post', 'forum.form.first_post.name');
    }

    public function testForumLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('forum.form.new_topic');
        $this->assertHasDefinition('forum.form.post');
        $this->assertHasDefinition('forum.form.first_post');
    }

    public function testForumLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('forum.form.new_topic');
        $this->assertHasDefinition('forum.form.post');
    }

    public function testForumLoadControllerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Bundle\ForumBundle\Controller\ForumController', 'forum.controller.forum.class');
        $this->assertParameter('Bundle\ForumBundle\Controller\CategoryController', 'forum.controller.category.class');
        $this->assertParameter('Bundle\ForumBundle\Controller\TopicController', 'forum.controller.topic.class');
        $this->assertParameter('Bundle\ForumBundle\Controller\PostController', 'forum.controller.post.class');
    }

    public function testForumLoadControllerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('forum', 'forum.controller.forum.class');
        $this->assertParameter('category', 'forum.controller.category.class');
        $this->assertParameter('topic', 'forum.controller.topic.class');
        $this->assertParameter('post', 'forum.controller.post.class');
    }

    public function testForumLoadControllerServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('forum.controller.forum');
        $this->assertHasDefinition('forum.controller.category');
        $this->assertHasDefinition('forum.controller.topic');
        $this->assertHasDefinition('forum.controller.post');
    }

    public function testForumLoadBlamerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Bundle\ForumBundle\Blamer\TopicBlamer', 'forum.blamer.topic.class');
        $this->assertParameter('Bundle\ForumBundle\Blamer\PostBlamer', 'forum.blamer.post.class');
    }

    public function testForumLoadBlamerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('topic', 'forum.blamer.topic.class');
        $this->assertParameter('post', 'forum.blamer.post.class');
    }

    public function testForumLoadBlamerServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('forum.blamer.topic');
        $this->assertHasDefinition('forum.blamer.post');
    }

    public function testForumLoadTemplatingHelperClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Bundle\ForumBundle\Templating\Helper\ForumHelper', 'forum.templating.helper.forum.class');
    }

    public function testForumLoadTemplatingHelperClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('forum', 'forum.templating.helper.forum.class');
    }

    public function testForumLoadTemplatingHelperServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('forum.templating.helper.forum');
    }

    public function testForumLoadControllerService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('forum.controller.forum');
        $this->assertHasDefinition('forum.controller.category');
        $this->assertHasDefinition('forum.controller.topic');
        $this->assertHasDefinition('forum.controller.post');
    }

    public function testForumLoadTemplateConfigWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('twig', 'forum.template.renderer');
        $this->assertParameter('TwigBundle::form.twig', 'forum.template.theme');
    }

    public function testForumLoadTemplateConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('renderer', 'forum.template.renderer');
        $this->assertParameter('theme', 'forum.template.theme');
    }

    public function testForumLoadPaginatorConfigWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter(10, 'forum.paginator.posts_per_page');
        $this->assertParameter(10, 'forum.paginator.topics_per_page');
        $this->assertParameter(10, 'forum.paginator.search_results_per_page');
    }

    public function testForumLoadPaginatorConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('posts_per_page', 'forum.paginator.posts_per_page');
        $this->assertParameter('topics_per_page', 'forum.paginator.topics_per_page');
        $this->assertParameter('search_results_per_page', 'forum.paginator.search_results_per_page');
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
        category: MyCategory
        topic: MyTopic
        post: MyPost
    form:
        new_topic: ~
        post: ~
        first_post: ~
    controller:
        forum: ~
        category: ~
        topic: ~
        post: ~
    blamer:
        post: ~
        topic: ~
    helper:
        forum: ~
form_name:
    new_topic: ~
    post: ~
    first_post: ~
template:
    renderer: ~
    theme: ~
paginator:
    topics_per_page: ~
    posts_per_page: ~
    search_results_per_page: ~
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
