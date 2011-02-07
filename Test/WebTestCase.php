<?php

namespace Bundle\ForumBundle\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Command\Command;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    protected $kernel;
    protected $categoryClass;
    protected $topicClass;
    protected $postClass;

    /**
     * Prepare entity/document classes for usage in tests
     *
     * @return mixed om
     */
    public function setUp()
    {
        $om = $this->getService('forum.object_manager');
        $this->categoryClass = $this->getService('forum.repository.category')->getObjectClass();
        $this->topicClass = $this->getService('forum.repository.topic')->getObjectClass();
        $this->postClass = $this->getService('forum.repository.post')->getObjectClass();

        return $om;
    }

    protected function runCommand($name, array $params = array())
    {
        \array_unshift($params, $name);

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput($params);
        $input->setInteractive(false);

        $ouput = new NullOutput(0);

        $application->run($input, $ouput);
    }

    protected function getService($name, $kernel = null)
    {
        return $this->getKernel()->getContainer()->get($name);
    }

    protected function hasService($name, $kernel = null)
    {
        return $this->getKernel()->getContainer()->has($name);
    }

    protected function getKernel()
    {
        if(!$this->kernel) {
            $this->kernel = $this->createKernel();
            $this->kernel->boot();
        }

        return $this->kernel;
    }

}
