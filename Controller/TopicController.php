<?php

namespace Bundle\ForumBundle\Controller;

use Bundle\ForumBundle\Form\TopicForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Category;

class TopicController extends Controller
{
    public function newAction($categorySlug = null)
    {
        $user = $this['doctrine_user.auth']->getUser();
        if (!$user) {
            throw new NotFoundHttpException('A user must be logged in.');
        }

        if($categorySlug) {
            $category = $this['forum.category_repository']->findOneBySlug($categorySlug);
        } else {
            $category = null;
        }

        $form = $this->createForm('forum_topic_new', $category);

        return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
            'form'      => $this['templating.form']->get($form),
            'user'      => $user,
            'category'  => $category
        ));
    }

    public function createAction($categorySlug = null)
    {
        $user = $this['doctrine_user.auth']->getUser();
        if (!$user) {
            throw new NotFoundHttpException('A user must be logged in.');
        }

        if($categorySlug) {
            $category = $this['forum.category_repository']->findOneBySlug($categorySlug);
        } else {
            $category = null;
        }

        $form = $this->createForm('forum_topic_new', $category);
        $form->bind($this['request']->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
                'form'      => $this['templating.form']->get($form),
                'user'      => $user,
                'category'  => $category
            ));
        }

        $topic = $form->getData();
        $topic->setAuthor($user);
        $topic->getFirstPost()->setAuthor($user);
        $this->saveTopic($topic);

        $this['session']->setFlash('forum_topic_create/success', true);
        $url = $this['templating.helper.forum']->urlForTopic($topic);

        return $this->redirect($url);
    }

    public function listAction($category = null)
    {
        if (null !== $category) {
            $topics = $this['forum.topic_repository']->findAllByCategory($category, true);
        } else {
            $topics = $this['forum.topic_repository']->findAll(true);
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

    public function showAction($categorySlug, $id)
    {
        $topicRepository = $this['forum.topic_repository'];
        $topic = $topicRepository->findOneById($id);

        if (!$topic) {
            throw new NotFoundHttpException('The topic does not exist.');
        }
        $topicRepository->incrementTopicNumViews($topic);

        if('html' === $this['request']->getRequestFormat()) {
            $page = $this['request']->query->get('page', 1);
            $posts = $this['forum.post_repository']->findAllByTopic($topic, true);
            $posts->setCurrentPageNumber($page);
            $posts->setItemCountPerPage($this->container->getParameter('forum.post_list.max_per_page'));
            $posts->setPageRange(5);
        }
        else {
            $posts = $this['forum.post_repository']->findRecentByTopic($topic, 30);
        }

        return $this->render('ForumBundle:Topic:show.'.$this->getRenderer(), array('topic' => $topic, 'posts' => $posts));
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
        $topicClass = $this['forum.topic_repository']->getObjectClass();
        $postFormClass = $this->container->getParameter('forum.post_form.class');
        $postClass = $this['forum.post_repository']->getObjectClass();
        $topic = new $topicClass();
        if($category) {
            $topic->setCategory($category);
        }
        $post = new $postClass();
        $post->setTopic($topic);
        $topic->setFirstPost($post);

        $form = new $topicFormClass($name, $topic, $this['validator'], array('categoryRepository' => $this['forum.category_repository']));
        $form->add(new $postFormClass('firstPost', $post, $this['validator']));

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
        $objectManager = $this['forum.topic_repository']->getObjectManager();
        $objectManager->persist($topic);
        $objectManager->persist($topic->getFirstPost());
        $objectManager->flush();
    }
}
