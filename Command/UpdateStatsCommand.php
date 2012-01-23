<?php
namespace Herzult\Bundle\ForumBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateStatsCommand extends ContainerAwareCommand
{

    /**
     * Create the command
     */
    protected function configure()
    {
        $this
            ->setName('forum:update:stats')
            ->setDescription('Updates all forum statistics.');
    }

    /**
     * Executes the update.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input  Input
     * @param \Symfony\Component\Console\Output\OutputInterface $output Output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $categoryRepo \Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface */
        $categoryRepo = $this->getContainer()->get('herzult_forum.repository.category');
        /** @var $topicRepo \Herzult\Bundle\ForumBundle\Model\TopicRepositoryInterface */
        $topicRepo    = $this->getContainer()->get('herzult_forum.repository.topic');
        /** @var $postRepo \Herzult\Bundle\ForumBundle\Model\PostRepositoryInterface */
        $postRepo     = $this->getContainer()->get('herzult_forum.repository.post');

        foreach($categoryRepo->findAll() as $category)
        {
            $postNumCategory = 0;
            $topicArray      = $topicRepo->findAllByCategory($category, false);
            $topicNum        = count($topicArray);

            foreach($topicArray as $topic)
            {
                $postNum = count($postRepo->findAllByTopic($topic, false));
                $topic->setNumPosts($postNum);
                $postNumCategory += $postNum;
            }

            $category->setNumPosts($postNumCategory);
            $category->setNumTopics($topicNum);
        }

        // Flush it into our database.
        $this->getContainer()->get('herzult_forum.object_manager')->flush();

    }
}