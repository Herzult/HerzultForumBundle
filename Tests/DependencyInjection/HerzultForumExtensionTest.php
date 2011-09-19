<?php

namespace Herzult\Bundle\ForumBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Herzult\Bundle\ForumBundle\DependencyInjection\HerzultForumExtension;

class HerzultForumExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getDataToTestDefinedService
     */
    public function testDefinedService($id)
    {
        $container = new ContainerBuilder();

        $this->loadExtension($this->getConfigs(), $container);

        $this->assertTrue($container->hasDefinition($id), sprintf('The service \'%s\' is defined.', $id));
    }

    /**
     * @dataProvider getDataToTestReplacedService
     */
    public function testReplacedService($id, $config, $replacementId)
    {
        $container = new ContainerBuilder();
        $container->setDefinition($replacementId, $this->getDefinitionMock());

        $this->loadExtension($this->getConfigs($config), $container);

        $this->assertTrue($container->hasAlias($id), sprintf('The alias \'%s\' is defined.', $id));
        $this->assertEquals($replacementId, (string) $container->getAlias($id), sprintf('The id \'%s\' is an alias of \'%s\'.', $id, $replacementId));
    }

    public function getDataToTestDefinedService()
    {
        $data = array();
        foreach ($this->getDefinedServices() as $id) {
            $data[] = array($id);
        }

        return $data;
    }

    public function getDataToTestReplacedService()
    {
        $data = array();
        foreach ($this->getDefinedServices() as $id) {
            $replacementId = str_replace('herzult_forum', 'my_forum', $id);
            list(, $group, $name) = explode('.', $id);
            $config = array('service' => array($group => array($name => $replacementId)));

            $data[] = array($id, $config, $replacementId);
        }

        return $data;
    }

    public function getDefinedServices()
    {
        return array(
            // creator services
            'herzult_forum.creator.topic',
            'herzult_forum.creator.post',

            // updater services
            'herzult_forum.creator.topic',
            'herzult_forum.creator.post',

            // remover services
            'herzult_forum.remover.topic',
            'herzult_forum.remover.post',

            // blamer services
            'herzult_forum.blamer.topic',
            'herzult_forum.blamer.post',
        );
    }

    public function getConfigs(array $config = array())
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
            $config,
        );
    }

    public function loadExtension(array $configs, ContainerBuilder $container)
    {
        $extension = new HerzultForumExtension('testkernel');
        $extension->load($configs, $container);
    }

    public function getDefinitionMock()
    {
        return $this->getMock('Symfony\Component\DependencyInjection\Definition');
    }
}
