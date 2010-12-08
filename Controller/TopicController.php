<?php

namespace Bundle\ForumBundle\Controller;

use Bundle\ForumBundle\Form\TopicForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Category;

class TopicController extends Controller
{
    public function newAction(Category $category = null)
    {
        $form = $this->createForm('forum_topic_new', $category);

        return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
            'form'      => $form,
            'category'  => $category
        ));
    }

    public function createAction(Category $category = null)
    {
        $form = $this->createForm('forum_topic_new', $category);
        $form->bind($this->get('request')->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
                'form'      => $form,
                'category'  => $category
            ));
        }

        $topic = $form->getData();
        $this->get('forum.blamer.topic')->blame($topic);
        $this->get('forum.blamer.post')->blame($topic->getFirstPost());
        $this->saveTopic($topic);

        $this->get('session')->setFlash('forum_topic_create/success', true);
        $url = $this->get('forum.templating.helper.forum')->urlForTopic($topic);

        return $this->redirect($url);
    }

    public function listAction(Category $category = null, $page = 1)
    {
        if (null !== $category) {
            $topics = $this->get('forum.repository.topic')->findAllByCategory($category, true);
        } else {
            $topics = $this->get('forum.repository.topic')->findAll(true);
        }

        $topics->setCurrentPageNumber($page);
        $topics->setItemCountPerPage($this->container->getParameter('forum.paginator.topics_per_page'));
        $topics->setPageRange(5);

        return $this->render('ForumBundle:Topic:list.'.$this->getRenderer(), array(
            'topics'    => $topics,
            'category'  => $category
        ));
    }

    public function showAction($categorySlug, $slug)
    {
        $topic = $this->findTopic($categorySlug, $slug);
        $this->get('forum.repository.topic')->incrementTopicNumViews($topic);

        if('html' === $this->get('request')->getRequestFormat()) {
            $page = $this->get('request')->query->get('page', 1);
            $posts = $this->get('forum.repository.post')->findAllByTopic($topic, true);
            $posts->setCurrentPageNumber($page);
            $posts->setItemCountPerPage($this->container->getParameter('forum.paginator.posts_per_page'));
            $posts->setPageRange(5);
        }
        else {
            $posts = $this->get('forum.repository.post')->findRecentByTopic($topic, 30);
        }

        return $this->render('ForumBundle:Topic:show.'.$this->getRenderer(), array('topic' => $topic, 'posts' => $posts));
    }

    public function postNewAction($categorySlug, $slug)
    {
        $topic = $this->findTopic($categorySlug, $slug);

        return $this->forward('ForumBundle:Post:new', array('topic' => $topic));
    }

    public function postCreateAction($categorySlug, $slug, $id)
    {
        $topic = $this->findTopic($categorySlug, $slug);

        return $this->forward('ForumBundle:Post:create', array('topic' => $topic));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }

    /**
     * Create a TopicForm instance and returns it
     *
     * @param string $name
     * @param Topic $topic
     * @return Bundle\ForumBundle\Form\TopicForm
     */
    protected function createForm($name, Category $category = null)
    {
        $form = $this->get('forum.form.new_topic');
        $form->getData()->setCategory($category);

        return $form;
    }

    /**
     * Find a topic by its category slug and topic slug
     *
     * @return Topic
     **/
    public function findTopic($categorySlug, $topicSlug)
    {
        $category = $this->get('forum.repository.category')->findOneBySlug($categorySlug);
        if(!$category) {
            throw new NotFoundHttpException(sprintf('The category with slug "%s" does not exist', $categorySlug));
        }
        $topic = $this->get('forum.repository.topic')->findOneByCategoryAndSlug($category, $topicSlug);
        if(!$topic) {
            throw new NotFoundHttpException(sprintf('The topic with slug "%s" does not exist', $topicSlug));
        }

        return $topic;
    }

    /**
     * Save a topic in database
     *
     * @param Topic $topic
     * @return null
     **/
    public function saveTopic(Topic $topic)
    {
        $topic->getCategory()->setLastPost($topic->getLastPost());
        $objectManager = $this->get('forum.repository.topic')->getObjectManager();
        $objectManager->persist($topic);
        $objectManager->persist($topic->getFirstPost());
        $objectManager->flush();
    }
}
