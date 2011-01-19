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

        return $this->render('ForumBundle:Post:new.',$this->getRenderer().'html', array(
            'form'  => $form,
            'topic' => $topic,
        ));
    }

    public function createAction(Topic $topic)
    {
        $form = $this->createForm('forum_post_new', $topic);
        $form->bind($this->get('request')->request->get($form->getName()));

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Post:new.',$this->getRenderer().'html', array(
                'form'  => $form,
                'topic' => $topic,
            ));
        }

        $post = $form->getData();
        $post->setTopic($topic);

        $this->get('forum.creator.post')->create($post);
        $this->get('forum.blamer.post')->blame($post);

        $objectManager = $this->get('forum.object_manager');
        $objectManager->persist($post);
        $objectManager->flush();

        $this->get('session')->setFlash('forum_post_create/success', true);
        $url = $this->get('forum.templating.helper.forum')->urlForPost($post);

        return $this->redirect($url);
    }

    public function deleteAction($id)
    {
        $post = $this->get('forum.repository.post')->find($id);
        if(!$post) {
            throw new NotFoundHttpException(sprintf('No post found with id "%s"', $id));
        }

        $this->get('forum.remover.post')->remove($post);
        $this->get('forum.object_manager')->flush();

        return $this->redirect($this->generateUrl('forum_topic_show', array(
            'categorySlug' => $post->getTopic()->getCategory()->getSlug(),
            'slug' => $post->getTopic()->getSlug()
        )));
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
        $form = $this->get('forum.form.post');

        return $form;
    }
}
