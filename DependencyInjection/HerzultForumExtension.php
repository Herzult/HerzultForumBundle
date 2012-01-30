<?php

namespace Herzult\Bundle\ForumBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\Config\FileLocator;

class HerzultForumExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('model.xml');
        $loader->load('controller.xml');
        $loader->load('form.xml');
        $loader->load('blamer.xml');
        $loader->load('creator.xml');
        $loader->load('updater.xml');
        $loader->load('remover.xml');
        $loader->load('twig.xml');
        $loader->load('router.xml');
        $loader->load('util.xml');

        $loader->load(sprintf('%s.xml', $config['db_driver']));

        $this->loadParameters($config, $container);
    }

    private function loadParameters(array $config, ContainerBuilder $container)
    {
        foreach ($config['class'] as $groupName => $group) {
            foreach ($group as $name => $value) {
                $container->setParameter(sprintf('herzult_forum.%s.%s.class', $groupName, $name), $value);
            }
        }

        foreach ($config['form_name'] as $name => $value) {
            $container->setParameter(sprintf('herzult_forum.form.%s.name', $name), $value);
        }

        unset($config['class'], $config['form_name']);

        foreach ($config as $groupName => $group) {
            if (is_array($group)) {
                foreach ($group as $name => $value) {
                    if (is_array($value)) {
                        foreach ($value as $subname => $subvalue) {
                            $container->setParameter(sprintf('herzult_forum.%s.%s.%s', $groupName, $name, $subname), $subvalue);                    
                        }
                    }else{
                        $container->setParameter(sprintf('herzult_forum.%s.%s', $groupName, $name), $value);                    
                    }
                }
            } else {
                $container->setParameter(sprintf('herzult_forum.%s', $groupName), $group);
            }
        }
    }
}
