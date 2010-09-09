<?php

use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

$general = new Category();
$general->setName('General');
$general->setPosition(0);

$documentation = new Category();
$documentation->setName('Documentation');
$documentation->setPosition(1);

$helpAndSupport = new Category();
$helpAndSupport->setName('Help & Support');
$helpAndSupport->setPosition(2);

$development = new Category();
$development->setName('Development');
$development->setPosition(3);

$categories = array(
    $general, $documentation, $helpAndSupport, $development
);


for ($i = 0; $i < 100; $i++)
{
    $topic = new Topic();
    $topic->setCategory($categories[mt_rand(0, count($categories) - 1)]);
    $topic->setSubject('Test topic number '.$i);

    $ii = 0;

    do {

        $post = new Post($topic);
        $post->setMessage('Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est.');

        ${'post_'.$i.'_'.$ii} = $post;

        unset($post);
        $ii++;

    } while( mt_rand(0, 1) === 1 );

    ${'topic_'.$i} = $topic;

    unset($topic);
}
