<?php

namespace Herzult\Bundle\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Herzult\Bundle\ForumBundle\Model\Topic;
use Herzult\Bundle\ForumBundle\Model\Post;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller
{
    public function newAction($categorySlug, $slug)
    {
        $topic    = $this->findTopicOr404($categorySlug, $slug);
        $form     = $this->get('herzult_forum.form.post');
        $template = sprintf(
            '%s:new.html.%s',
            $this->container->getParameter('herzult_forum.templating.location.post'),
            $this->getRenderer()
        );

        return $this->render(
            $template,
            array(
                'form'  => $form->createView(),
                'topic' => $topic,
            )
        );
    }

    public function createAction($categorySlug, $slug)
    {
        $topic = $this->findTopicOr404($categorySlug, $slug);
        $form  = $this->get('herzult_forum.form.post');
        $post  = $this->get('herzult_forum.repository.post')->createNewPost();
        $post->setTopic($topic);
        $form->bindRequest($this->get('request'));

        if (!$form->isValid()) {
            $template = sprintf('%s:new.html.%s', $this->container->getParameter('herzult_forum.templating.location.post'), $this->getRenderer());
            return $this->get('templating')->renderResponse($template, array(
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

    protected function findTopicOr404($categorySlug, $slug)
    {
        $category = $this
            ->get('herzult_forum.repository.category')
            ->findOneBySlug($categorySlug)
        ;

        if (null === $category) {
            throw new NotFoundHttpException(sprintf(
                'The category with slug "%s" was not found.',
                $categorySlug
            ));
        }

        $topic = $this
            ->get('herzult_forum.repository.topic')
            ->findOneByCategoryAndSlug($category, $slug)
        ;

        if (null === $topic) {
            throw new NotFoundHttpException(sprintf(
                'The topic with slug "%s" was not found in category with slug "%s".',
                $slug,
                $categorySlug
            ));
        }

        return $topic;
    }

    protected function getRenderer()
    {
        return $this->container->getParameter('herzult_forum.templating.engine');
    }
}
