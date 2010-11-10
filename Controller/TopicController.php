<?php

namespace Bundle\ForumBundle\Controller;

use Bundle\ForumBundle\Form\TopicForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Exception\InsufficientAuthenticationException;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Category;

class TopicController extends Controller
{
    public function newAction(Category $category = null)
    {
        if (!$this['security.context']->isAuthenticated()) {
            throw new InsufficientAuthenticationException('User must be authenticated to create a topic.');
        }

        $form = $this->createForm('forum_topic_new', $category);

        return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
            'form'      => $form,
            'user'      => $this['security.context']->getUser(),
            'category'  => $category
        ));
    }

    public function createAction(Category $category = null)
    {
        if (!$this['security.context']->isAuthenticated()) {
            throw new InsufficientAuthenticationException('User must be authenticated to create a topic.');
        }

        $form = $this->createForm('forum_topic_new', $category);
        $form->bind($this['request']->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
                'form'      => $form,
                'user'      => $this['security.context']->getUser(),
                'category'  => $category
            ));
        }

        $topic = $form->getData();
        $topic->setAuthor($this['security.context']->getUser());
        $topic->getFirstPost()->setAuthor($this['security.context']->getUser());
        $this->saveTopic($topic);

        $this['session']->setFlash('forum_topic_create/success', true);
        $url = $this['templating.helper.forum']->urlForTopic($topic);

        return $this->redirect($url);
    }

    public function listAction(Category $category = null)
    {
        if (null !== $category) {
            $topics = $this['forum.repository.topic']->findAllByCategory($category, true);
        } else {
            $topics = $this['forum.repository.topic']->findAll(true);
        }

        $page = $this['request']->query->get('page', 1);

        $topics->setCurrentPageNumber($page);
        $topics->setItemCountPerPage($this->container->getParameter('forum.topic_list.max_per_page'));
        $topics->setPageRange(5);

        return $this->render('ForumBundle:Topic:list.'.$this->getRenderer(), array(
            'topics'    => $topics,
            'category'  => $category
        ));
    }

    public function showAction($id)
    {
        $topicRepository = $this['forum.repository.topic'];
        $topic = $topicRepository->findOneById($id);

        if (!$topic) {
            throw new NotFoundHttpException('The topic does not exist.');
        }
        $topicRepository->incrementTopicNumViews($topic);

        if('html' === $this['request']->getRequestFormat()) {
            $page = $this['request']->query->get('page', 1);
            $posts = $this['forum.repository.post']->findAllByTopic($topic, true);
            $posts->setCurrentPageNumber($page);
            $posts->setItemCountPerPage($this->container->getParameter('forum.post_list.max_per_page'));
            $posts->setPageRange(5);
        }
        else {
            $posts = $this['forum.repository.post']->findRecentByTopic($topic, 30);
        }

        return $this->render('ForumBundle:Topic:show.'.$this->getRenderer(), array('topic' => $topic, 'posts' => $posts));
    }

    public function postNewAction($categorySlug, $slug, $id)
    {
        $topic = $this['forum.repository.topic']->findOneById($id);

        if (!$topic) {
            throw new NotFoundHttpException('The topic does not exist.');
        }

        return $this->forward('ForumBundle:Post:new', array('topic' => $topic));
    }

    public function postCreateAction($categorySlug, $slug, $id)
    {
        $topic = $this['forum.repository.topic']->findOneById($id);

        if (!$topic) {
            throw new NotFoundHttpException('The topic does not exist.');
        }

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
        $topicFormClass = $this->container->getParameter('forum.topic_form.class');
        $topicClass = $this['forum.repository.topic']->getObjectClass();
        $postFormClass = $this->container->getParameter('forum.post_form.class');
        $postClass = $this['forum.repository.post']->getObjectClass();
        $topic = new $topicClass();
        if($category) {
            $topic->setCategory($category);
        }
        $post = new $postClass();
        $post->setTopic($topic);
        $topic->setFirstPost($post);

        $form = new $topicFormClass($name, $topic, $this['validator'], array('categoryRepository' => $this['forum.repository.category']));
        $form->add(new $postFormClass('firstPost', $post, $this['validator']));
        $form['firstPost']->disableCSRFProtection();

        return $form;
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
        $objectManager = $this['forum.repository.topic']->getObjectManager();
        $objectManager->persist($topic);
        $objectManager->persist($topic->getFirstPost());
        $objectManager->flush();
    }
}
