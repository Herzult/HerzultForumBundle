<?php

namespace Bundle\ForumBundle\Controller;

use Bundle\ForumBundle\Form\TopicForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TopicController extends Controller
{
    public function newAction()
    {
        $form = $this->createForm('forum_topic_new');

        return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array('form' => $form));
    }

    public function createAction()
    {
        $form = $this->createForm('forum_topic_new');

        $form->bind($this['request']->request->get($form->getName()));

        if ($form->isValid()) {
            $topic = $form->getData();
            $this->saveTopic($topic);

            $this['session']->setFlash('forum_topic_create/success', true);
            $url = $this->generateUrl('forum_topic_show', array('id' => $topic->getId()));

            return $this->redirect($url);
        }

        return $this->render('ForumBundle:Topic:new.'.$this->getRenderer(), array('form' => $form));
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

        return $this->render('ForumBundle:Topic:show.'.$this->getRenderer(), array('topic' => $topic));
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
    protected function createForm($name, $topic = null)
    {
        $formClass = $this->container->getParameter('forum.topic_form.class');
        if (null === $object) {
            $topicClass = $this['forum.topic_repository']->getObjectClass();
            $topic = new $topicClass();
        }

        return new $formClass($name, $topic, $this['validator']);
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
        $objectManager->flush();
    }
}
