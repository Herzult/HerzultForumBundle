<?php

namespace Herzult\Bundle\ForumBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Forum configuration
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('herzult_forum');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray(array('orm', 'odm'))
                        ->thenInvalid('The database driver must be either \'orm\' or \'odm\'.')
                    ->end()
                ->end()
                ->arrayNode('class')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('model')
                            ->isRequired()
                            ->children()
                                ->scalarNode('category')->isRequired()->end()
                                ->scalarNode('topic')->isRequired()->end()
                                ->scalarNode('post')->isRequired()->end()
                            ->end()
                        ->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('new_topic')->defaultValue('Herzult\Bundle\ForumBundle\Form\NewTopicFormType')->end()
                                ->scalarNode('first_post')->defaultValue('Herzult\Bundle\ForumBundle\Form\PostFormType')->end()
                                ->scalarNode('post')->defaultValue('Herzult\Bundle\ForumBundle\Form\PostFormType')->end()
                                ->scalarNode('search')->defaultValue('Herzult\Bundle\ForumBundle\Form\SearchFormType')->end()
                            ->end()
                        ->end()
                        ->arrayNode('controller')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('forum')->defaultValue('Herzult\Bundle\ForumBundle\Controller\ForumController')->end()
                                ->scalarNode('category')->defaultValue('Herzult\Bundle\ForumBundle\Controller\CategoryController')->end()
                                ->scalarNode('topic')->defaultValue('Herzult\Bundle\ForumBundle\Controller\TopicController')->end()
                                ->scalarNode('post')->defaultValue('Herzult\Bundle\ForumBundle\Controller\PostController')->end()
                            ->end()
                        ->end()
                        ->arrayNode('creator')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('topic')->defaultValue('Herzult\Bundle\ForumBundle\Creator\TopicCreator')->end()
                                ->scalarNode('post')->defaultValue('Herzult\Bundle\ForumBundle\Creator\PostCreator')->end()
                            ->end()
                        ->end()
                        ->arrayNode('blamer')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('topic')->defaultValue('Herzult\Bundle\ForumBundle\Blamer\TopicBlamer')->end()
                                ->scalarNode('post')->defaultValue('Herzult\Bundle\ForumBundle\Blamer\PostBlamer')->end()
                            ->end()
                        ->end()
                        ->arrayNode('updater')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('category')->defaultValue('Herzult\Bundle\ForumBundle\Updater\CategoryUpdater')->end()
                                ->scalarNode('topic')->defaultValue('Herzult\Bundle\ForumBundle\Updater\TopicUpdater')->end()
                            ->end()
                        ->end()
                        ->arrayNode('remover')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('topic')->defaultValue('Herzult\Bundle\ForumBundle\Remover\TopicBlamer')->end()
                                ->scalarNode('post')->defaultValue('Herzult\Bundle\ForumBundle\Remover\PostBlamer')->end()
                            ->end()
                        ->end()
                        ->arrayNode('twig')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('extension')->defaultValue('Herzult\Bundle\ForumBundle\Twig\ForumExtension')->end()
                            ->end()
                        ->end()
                        ->arrayNode('router')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('url_generator')->defaultValue('Herzult\Bundle\ForumBundle\Router\ForumUrlGenerator')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('form_name')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('new_topic')->defaultValue('forum_new_topic_form')->end()
                        ->scalarNode('first_post')->defaultValue('firstPost')->end()
                        ->scalarNode('post')->defaultValue('forum_post_form')->end()
                        ->scalarNode('search')->defaultValue('forum_search')->end()
                    ->end()
                ->end()
                ->arrayNode('paginator')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('posts_per_page')->defaultValue(10)->end()
                        ->scalarNode('topics_per_page')->defaultValue(10)->end()
                        ->scalarNode('search_results_per_page')->defaultValue(10)->end()
                    ->end()
                ->end()
                ->arrayNode('templating')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('engine')
                            ->defaultValue('twig')
                            ->validate()
                                ->ifNotInArray(array('twig', 'php'))
                                ->thenInvalid('The templating engine must be either \'twig\' or \'php\'.')
                            ->end()
                        ->end()
                        ->scalarNode('theme')->defaultValue('Twig::form.html.twig')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
