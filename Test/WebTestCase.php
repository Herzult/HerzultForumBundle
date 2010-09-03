<?php

namespace Bundle\ForumBundle\Test;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Command\Command;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
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
        $this->categoryClass = $om->getRepository('ForumBundle:Category')->getObjectClass();
        $this->topicClass = $om->getRepository('ForumBundle:Topic')->getObjectClass();
        $this->postClass = $om->getRepository('ForumBundle:Post')->getObjectClass();

        return $om;
    }

    /**
     * Remove all entities/documents from a table/collection 
     * 
     * @param string $className something like 'ForumBundle:Category'
     * @param mixed $om 
     * @return void
     */
    protected function cleanUpRepository($className, $om = null)
    {
        $om = $om ?: $this->getService('forum.object_manager');
        $repository = $om->getRepository($className);

        $documents = $repository->findAll();
        foreach ($documents as $document) {
            $om->remove($document);
        }

        $om->flush();
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
        if (null === $kernel) {
            $kernel = $this->createKernel();
        }

        if (!$kernel->isBooted()) {
            $kernel->boot();
        }

        return $kernel->getContainer()->get($name);
    }

}
