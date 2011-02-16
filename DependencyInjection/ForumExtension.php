<?php

namespace Bundle\ForumBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\Config\FileLocator;

class ForumExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = array();
        foreach ($configs as $c) {
            $config = array_merge($config, $c);
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('model.xml');
        $loader->load('controller.xml');
        $loader->load('form.xml');
        $loader->load('blamer.xml');
        $loader->load('creator.xml');
        $loader->load('updater.xml');
        $loader->load('remover.xml');
        $loader->load('templating.xml');
        $loader->load('twig.xml');
        $loader->load('paginator.xml');
        $loader->load('router.xml');

        if (!isset($config['db_driver'])) {
            throw new \InvalidArgumentException('You must provide the forum.db_driver configuration');
        }

        try {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(sprintf('The db_driver "%s" is not supported by forum', $config['db_driver']));
        }

        foreach(array('category', 'topic', 'post') as $model) {
            if (!isset($config['class']['model'][$model])) {
                throw new \InvalidArgumentException(sprintf('You must define your %s model class', $model));
            }
        }

        $namespaces = array(
            'form_name' => 'forum.form.%s.name',
            'template' => 'forum.template.%s',
            'paginator' => 'forum.paginator.%s'
        );
        $this->remapParametersNamespaces($config, $container, $namespaces);

        $namespaces = array(
            'model'      => 'forum.model.%s.class',
            'form'       => 'forum.form.%s.class',
            'controller' => 'forum.controller.%s.class',
            'blamer'     => 'forum.blamer.%s.class',
            'creator'    => 'forum.creator.%s.class',
            'updater'    => 'forum.updater.%s.class',
            'remover'    => 'forum.remover.%s.class',
            'twig'       => 'forum.twig.%s.class'
        );
        $this->remapParametersNamespaces($config['class'], $container, $namespaces);
    }

    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (isset($config[$name])) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!isset($config[$ns])) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    if(null !== $value) {
                        $container->setParameter(sprintf($map, $name), $value);
                    }
                }
            }
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
