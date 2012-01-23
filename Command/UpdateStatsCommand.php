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
     * Updates the Topic count and returns the summarized count of posts.
     *
     * @param Topic[] $topicArray The array of topics which should be updated.
     *
     * @return int The count of Posts over all given Topics.
     */
    protected function updateTopicStatsAndReturnPostCount($topicArray)
    {
        /** @var $postRepo \Herzult\Bundle\ForumBundle\Model\PostRepositoryInterface */
        $postRepo      = $this->getContainer()->get('herzult_forum.repository.post');
        $postNumReturn = 0;

        foreach($topicArray as $topic)
        {
            $postNum = count($postRepo->findAllByTopic($topic, false));
            $topic->setNumPosts($postNum);

            $postNumReturn += $postNum;
        }

        return $postNumReturn;
    }

    /**
     * Updates the Categories.
     *
     * @param Category $category A root category
     *
     * @return array The count of topics and posts contained in the given category.
     */
    protected function updateCategoryStats(\Herzult\Bundle\ForumBundle\Model\Category $category)
    {
        /** @var $topicRepo \Herzult\Bundle\ForumBundle\Model\TopicRepositoryInterface */
        $topicRepo    = $this->getContainer()->get('herzult_forum.repository.topic');

        /** @var $categoryRepo \Herzult\Bundle\ForumBundle\Model\CategoryRepositoryInterface */
        $categoryRepo = $this->getContainer()->get('herzult_forum.repository.category');

        $topicArray      = $topicRepo->findAllByCategory($category, false);
        $topicNum        = count($topicArray);
        $postNumCategory = $this->updateTopicStatsAndReturnPostCount($topicArray);

        // Update all sub categories
        foreach($categoryRepo->findAllSubCategories($category->getId()) as $subcategory)
        {
            $statArray = $this->updateCategoryStats($subcategory);

            // We add the topic and thread count of the sub forums to the category.
            $topicNum        += $statArray['topics'];
            $postNumCategory += $statArray['posts'];
        }

        $category->setNumPosts($postNumCategory);
        $category->setNumTopics($topicNum);

        return array(
            'topics' => $topicNum,
            'posts'  => $postNumCategory,
        );
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

        foreach($categoryRepo->findAllRootCategories() as $category)
        {
            $this->updateCategoryStats($category);
        }

        // Flush it into our database.
        $this->getContainer()->get('herzult_forum.object_manager')->flush();

    }
}