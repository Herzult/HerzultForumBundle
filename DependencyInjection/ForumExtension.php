<?php

namespace Bundle\ForumBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class ForumExtension extends Extension
{

    public function configLoad($config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, __DIR__ . '/../Resources/config');

        if (empty($config['db_driver'])) {
            throw new \Exception('You must choose the database driver to use (ORM or ODM).');
        }

        switch (strtolower($config['db_driver'])) {
            case 'orm':
                $loader->load('orm.xml');
                break;
            case 'odm':
                $loader->load('odm.xml');
                break;
            default:
                throw new \Exception('The "%s" database driver is not supported.', $config['db_driver']);
        }

        $loader->load('services.xml');
        $loader->load('forum.xml');
        $loader->load('controller.xml');
        $loader->load('form.xml');

        if (isset($config['template_renderer'])) {
            $container->setParameter('forum.template.renderer', $config['template_renderer']);
        }

        foreach(array('category', 'topic', 'post', 'user') as $model) {
            $configName = $model.'_class';
            $parameterName = sprintf('forum.%s_object.class', $model);
            if (isset($config[$configName])) {
                $container->setParameter($parameterName, $config[$configName]);
            }
            else {
                throw new \InvalidArgumentException(sprintf('ForumBundle: You must define your %s class', $model));
            }
        }

        if(isset($config['topics_per_page'])) {
            $container->setParameter('forum.topic_list.max_per_page', $config['topics_per_page']);
        }

        if(isset($config['posts_per_page'])) {
            $container->setParameter('forum.post_list.max_per_page', $config['posts_per_page']);
        }

        if(isset($config['search_results_per_page'])) {
            $container->setParameter('forum.search_results.max_per_page', $config['search_results_per_page']);
        }
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return 'http://www.symfony-project.org/shemas/dic/symfony';
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return null;
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'forum';
    }

}
