<?php
namespace Herzult\Bundle\ForumBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateSlugsCommand extends ContainerAwareCommand
{

    /**
     * Create the command
     */
    protected function configure()
    {
        $this
            ->setName('forum:update:slugs')
            ->setDescription('Updates all Slugs for Categories and Topics.');
    }

    /**
     * Executes the update.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input  Input
     * @param \Symfony\Component\Console\Output\OutputInterface $output Output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $categories \Herzult\Bundle\ForumBundle\Model\Category[] */
        $categories = $this->getContainer()->get('herzult_forum.repository.category')->findAll();
        foreach($categories as $val)
        {
            $val->generateSlug();
        }

        $topics = $this->getContainer()->get('herzult_forum.repository.topic')->findAll();
        foreach($topics as $val)
        {
            $val->generateSlug();
        }

        /** @var $objectManager \Doctrine\Common\Persistence\ObjectManager */
        $objectManager = $this->getContainer()->get('herzult_forum.object_manager');
        $objectManager->flush();
    }
}