<?php

namespace Herzult\Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Herzult\Bundle\ForumBundle\Model\Topic;
use Herzult\Bundle\ForumBundle\Model\Post;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller
{
    public function newAction(Topic $topic)
    {
        $form = $this->get('herzult_forum.form.post');
        return $this->get('templating')->renderResponse('HerzultForumBundle:Post:new.html.'.$this->getRenderer(), array(
            'form'  => $form->createView(),
            'topic' => $topic,
        ));
    }

    public function createAction(Topic $topic)
    {
        $form = $this->get('herzult_forum.form.post');
        $post = $this->get('herzult_forum.repository.post')->createNewPost();
        $post->setTopic($topic);
        $form->bindRequest($this->get('request'));

        if (!$form->isValid()) {
            return $this->get('templating')->renderResponse('HerzultForumBundle:Post:new.html.'.$this->getRenderer(), array(
                'form'  => $form->createView(),
                'topic' => $topic,
            ));
        }

        $post = $form->getData();
        $post->setTopic($topic);
        $this->get('herzult_forum.creator.post')->create($post);
        $this->get('herzult_forum.blamer.post')->blame($post);

        $objectManager = $this->get('herzult_forum.object_manager');
        $objectManager->persist($post);
        $objectManager->flush();

        $this->get('session')->setFlash('herzult_forum_post_create/success', true);
        $url = $this->get('herzult_forum.router.url_generator')->urlForPost($post);

        return new RedirectResponse($url);
    }

    public function deleteAction($id)
    {
        $post = $this->get('herzult_forum.repository.post')->find($id);
        if (!$post) {
            throw new NotFoundHttpException(sprintf('No post found with id "%s"', $id));
        }

        $precedentPost = $this->get('herzult_forum.repository.post')->getPostBefore($post);
        $this->get('herzult_forum.remover.post')->remove($post);
        $this->get('herzult_forum.object_manager')->flush();

        return new RedirectResponse($this->get('herzult_forum.router.url_generator')->urlForPost($precedentPost));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('herzult_forum.templating.engine');
    }
}
