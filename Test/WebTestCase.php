<?php

namespace Bundle\ForumBundle\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Command\Command;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
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
        if (null === $kernel) {
            $kernel = $this->createKernel();
        }

        if (!$kernel->isBooted()) {
            $kernel->boot();
        }

        return $kernel->getContainer()->get($name);
    }

}
