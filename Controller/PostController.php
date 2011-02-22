<?php

namespace Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Bundle\ForumBundle\Model\Topic;
use Bundle\ForumBundle\Model\Post;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller
{
    public function newAction(Topic $topic)
    {
        $form = $this->get('forum.form.post');

        return $this->render('ForumBundle:Post:new.html.'.$this->getRenderer(), array(
            'form'  => $form,
            'topic' => $topic,
        ));
    }

    public function createAction(Topic $topic)
    {
        $form = $this->get('forum.form.post');
        $post = new Post();
        $post->setTopic($topic);
        $form->bind($this->get('request'), $post);

        if(!$form->isValid()) {
            return $this->render('ForumBundle:Post:new.html.'.$this->getRenderer(), array(
                'form'  => $form,
                'topic' => $topic,
            ));
        }

        $post->setTopic($topic);

        $this->get('forum.creator.post')->create($post);
        $this->get('forum.blamer.post')->blame($post);

        $objectManager = $this->get('forum.object_manager');
        $objectManager->persist($post);
        $objectManager->flush();

        $this->get('session')->setFlash('forum_post_create/success', true);
        $url = $this->get('forum.router.url_generator')->urlForPost($post);

        return new RedirectResponse($url);
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
}
