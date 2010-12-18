<?php

namespace Bundle\SosForum\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Bundle\SosForum\CoreBundle\Model\Topic;
use Bundle\SosForum\CoreBundle\Model\Post;

class PostController extends Controller
{
    public function newAction(Topic $topic)
    {
        $form = $this->createForm('forum_post_new', $topic);

        return $this->render('SosForumCoreBundle:Post:new.'.$this->getRenderer(), array(
            'form'  => $form,
            'topic' => $topic,
        ));
    }

    public function createAction(Topic $topic)
    {
        $form = $this->createForm('forum_post_new', $topic);
        $form->bind($this->get('request')->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('SosForumCoreBundle:Post:new.'.$this->getRenderer(), array(
                'form'  => $form,
                'topic' => $topic,
            ));
        }

        $post = $form->getData();
        $post->setTopic($topic);
        $this->get('forum.blamer.post')->blame($post);
        $this->savePost($post);

        $this->get('session')->setFlash('forum_post_create/success', true);
        $url = $this->get('forum.templating.helper.forum')->urlForPost($post);

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
     * @return Bundle\SosForum\CoreBundle\Form\PostForm
     */
    protected function createForm($name, Topic $topic)
    {
        $form = $this->get('forum.form.post');

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
        $objectManager = $this->get('forum.object_manager');
        $objectManager->persist($post);
        $objectManager->flush();
    }

}
