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

        return $this->get('templating')->renderResponse('Forum:Post:new.html.'.$this->getRenderer(), array(
            'form'  => $form,
            'topic' => $topic,
        ));
    }

    public function createAction(Topic $topic)
    {
        $form = $this->get('forum.form.post');
        $post = $this->get('forum.repository.post')->createNewPost();
        $post->setTopic($topic);
        $form->bind($this->get('request'), $post);

        if(!$form->isValid()) {
            return $this->get('templating')->renderResponse('Forum:Post:new.html.'.$this->getRenderer(), array(
                'form'  => $form,
                'topic' => $topic,
            ));
        }

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

        $precedentPost = $this->get('forum.repository.post')->getPostBefore($post);
        $this->get('forum.remover.post')->remove($post);
        $this->get('forum.object_manager')->flush();

        return new RedirectResponse($this->get('forum.router.url_generator')->urlForPost($precedentPost));
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('forum.template.renderer');
    }
}
