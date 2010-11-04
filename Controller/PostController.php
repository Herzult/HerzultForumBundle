<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Exception\InsufficientAuthenticationException;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Post;

class PostController extends Controller
{
    public function newAction(Topic $topic)
    {
        if (!$this['security.context']->isAuthenticated()) {
            throw new InsufficientAuthenticationException('User must be authenticated to create a topic.');
        }

        $form = $this->createForm('forum_post_new', $topic);

        return $this->render('ForumBundle:Post:new.'.$this->getRenderer(), array(
            'form'  => $form,
            'topic' => $topic,
            'user'  => $this['security.context']->getUser()
        ));
    }

    public function createAction(Topic $topic)
    {
        if (!$this['security.context']->isAuthenticated()) {
            throw new InsufficientAuthenticationException('User must be authenticated to create a topic.');
        }

        $form = $this->createForm('forum_post_new', $topic);
        $form->bind($this['request']->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Post:new.'.$this->getRenderer(), array(
                'form'  => $form,
                'topic' => $topic,
                'user'  => $this['security.context']->getUser()
            ));
        }

        $post = $form->getData();
        $post->setAuthor($this['security.context']->getUser());
        $this->savePost($post);

        $this['session']->setFlash('forum_post_create/success', true);
        $url = $this['templating.helper.forum']->urlForPost($post);

        return $this->redirect($url);
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }

    /**
     * Create a PostForm instance and returns it
     *
     * @param string $name
     * @param Topic $topic
     * @return Bundle\ForumBundle\Form\PostForm
     */
    protected function createForm($name, Topic $topic)
    {
        $formClass = $this->container->getParameter('forum.post_form.class');
        $postClass = $this['forum.post_repository']->getObjectClass();
        $post = new $postClass();
        $post->setTopic($topic);

        return new $formClass($name, $post, $this['validator']);
    }

    /**
     * Save a post in database
     *
     * @param Post $post
     * @return null
     **/
    public function savePost(Post $post)
    {
        $objectManager = $this['forum.post_repository']->getObjectManager();
        $objectManager->persist($post);
        $objectManager->flush();
    }

}
