<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Post;

class PostController extends Controller
{
    public function newAction(Topic $topic)
    {
        $form = $this->createForm('forum_post_new', $topic);

        return $this->render('ForumBundle:Post:new.'.$this->getRenderer(), array(
            'form'  => $form,
            'topic' => $topic,
        ));
    }

    public function createAction(Topic $topic)
    {
        $form = $this->createForm('forum_post_new', $topic);
        $form->bind($this['request']->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Post:new.'.$this->getRenderer(), array(
                'form'  => $form,
                'topic' => $topic,
            ));
        }

        $post = $form->getData();
        $this['forum.blamer.post']->blame($post);
        $this->savePost($post);

        $this['session']->setFlash('forum_post_create/success', true);
        $url = $this['forum.templating.helper.forum']->urlForPost($post);

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
        $form = $this['forum.form.post'];
        $form->getData()->setTopic($topic);

        return $form;
    }

    /**
     * Save a post in database
     *
     * @param Post $post
     * @return null
     **/
    public function savePost(Post $post)
    {
        $objectManager = $this['forum.repository.post']->getObjectManager();
        $objectManager->persist($post);
        $objectManager->flush();
    }

}
