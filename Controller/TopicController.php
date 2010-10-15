<?php

namespace Bundle\ForumBundle\Controller;

use Bundle\ForumBundle\Form\TopicForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Bundle\ForumBundle\DAO\Topic;
use Bundle\ForumBundle\DAO\Category;

class TopicController extends Controller
{
    public function newAction($categorySlug)
    {
        $category = $this['forum.category_repository']->findOneBySlug($categorySlug);
        if (!$category) {
            throw new NotFoundHttpException('The category does not exist.');
        }

        $user = $this['doctrine_user.auth']->getUser();
        if (!$user) {
            throw new NotFoundHttpException('A user must be logged in.');
        }

        $form = $this->createForm('forum_topic_new', $category);

        return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
            'form' => $form,
            'category' => $category,
            'user' => $user
        ));
    }

    public function createAction($categorySlug)
    {
        $category = $this['forum.category_repository']->findOneBySlug($categorySlug);
        if (!$category) {
            throw new NotFoundHttpException('The category does not exist.');
        }

        $user = $this['doctrine_user.auth']->getUser();
        if (!$user) {
            throw new NotFoundHttpException('A user must be logged in.');
        }

        $form = $this->createForm('forum_topic_new');
        $form->bind($this['request']->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array(
                'form' => $form,
                'category' => $category,
                'user' => $user
            ));
        }

        $topic = $form->getData();
        $topic->setAuthor($user);
        $topic->getFirstPost()->setAuthor($user);
        $this->saveTopic($topic);

        $this['session']->setFlash('forum_topic_create/success', true);
        $url = $this->generateUrl('forum_topic_show', array('id' => $topic->getId()));

        return $this->redirect($url);
    }

    public function listAction($category = null)
    {
        if (null !== $category) {
            $topics = $this['forum.topic_repository']->findAllByCategory($category);
        } else {
            $topics = $this['forum.topic_repository']->findAll();
        }

        return $this->render('ForumBundle:Topic:list.'.$this->getRenderer(), array('topics' => $topics));
    }

    public function showAction($id)
    {
        $topic = $this['forum.topic_repository']->findOneById($id);

        if (!$topic) {
            throw new NotFoundHttpException('The topic does not exist.');
        }

        $page = $this['request']->query->get('page', 1);
        $posts = $this['forum.post_repository']->findAllByTopic($topic, true);
        $posts->setCurrentPageNumber($page);
        $posts->setItemCountPerPage($this->container->getParameter('forum.post_list.max_per_page'));
        $posts->setPageRange(5);

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
        $objectManager = $this['forum.topic_repository']->getObjectManager();
        $objectManager->persist($topic);
        $objectManager->persist($topic->getFirstPost());
        $objectManager->flush();
    }
}
