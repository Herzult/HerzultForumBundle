<?php

$categoryClass = $this->container->getParameter('forum.category_object.class');
$topicClass = $this->container->getParameter('forum.topic_object.class');
$postClass = $this->container->getParameter('forum.post_object.class');
$userClass = $this->container->get('doctrine_user.user_repository')->getObjectClass();

/**
 * Create some users
 */
$users = array();

$john = new $userClass();
$john->setUsername('John');
$john->setEmail('john@doe.com');
$john->setPassword('changeme');
$users[] = $john;

$tom = new $userClass();
$tom->setUsername('Tom');
$tom->setEmail('tom@doe.com');
$tom->setPassword('changeme');
$users[] = $tom;

$max = new $userClass();
$max->setUsername('Max');
$max->setEmail('max@doe.com');
$max->setPassword('changeme');
$users[] = $max;

$marie = new $userClass();
$marie->setUsername('Marie');
$marie->setEmail('marie@doe.com');
$marie->setPassword('changeme');
$users[] = $marie;

$thomas = new $userClass();
$thomas->setUsername('Thomas');
$thomas->setEmail('thomas@doe.com');
$thomas->setPassword('changeme');
$users[] = $thomas;

$julie = new $userClass();
$julie->setUsername('Julie');
$julie->setEmail('julie@doe.com');
$julie->setPassword('changeme');
$users[] = $julie;

$marc = new $userClass();
$marc->setUsername('Marc');
$marc->setEmail('marc@doe.com');
$marc->setPassword('changeme');
$users[] = $marc;

$paul = new $userClass();
$paul->setUsername('Paul');
$paul->setEmail('paul@doe.com');
$paul->setPassword('changeme');
$users[] = $paul;

$martin = new $userClass();
$martin->setUsername('Martin');
$martin->setEmail('martin@doe.com');
$martin->setPassword('changeme');
$users[] = $martin;

$kate = new $userClass();
$kate->setUsername('Kate');
$kate->setEmail('kate@doe.com');
$kate->setPassword('changeme');
$users[] = $kate;


/*
 * Create some categories
 */

$categories = array();

$general = new $categoryClass();
$general->setName('General');
$general->setDescription('Built with performance in mind, Symfony2 is one of the fastest PHP frameworks. It is up to 3 times faster than symfony 1.4 or Zend Framework 1.10 and consumes half the memory.');
$general->setPosition(0);
$categories[] = $general;

$documentation = new $categoryClass();
$documentation->setName('Documentation');
$documentation->setDescription('Learning a framework shouldn\'t be hard. Take an hour to read the Quick Tour and start using Symfony2 today.');
$documentation->setPosition(1);
$categories[] = $documentation;

$helpAndSupport = new $categoryClass();
$helpAndSupport->setName('Help & Support');
$helpAndSupport->setDescription("Thanks to a simple and cohesive API, Symfony gets out of your way and lets you enjoy coding again. We put a strong emphasis on ease of use without sacrificing extensibility.");
$helpAndSupport->setPosition(2);
$categories[] = $helpAndSupport;

$development = new $categoryClass();
$development->setName('Development');
$development->setDescription("Thanks to an innovative micro-kernel based on a Dependency Injection Container and an Event Dispatcher, Symfony is configurable at will.");
$development->setPosition(3);
$categories[] = $development;


/*
 * Create some topics
 */

for ($i = 0; $i < 50; $i++) {
    $topic = new $topicClass();
    $topic->setCategory($categories[$i%(count($categories)-2) + 1]);
    $topic->setSubject('Test topic number ' . $i);
    $topic->setAuthor($users[$i%(count($users)-1) + 1]);

    for($itPost = 0; $itPost < ($i%10)+1; $itPost++) {

        if(0 === $itPost) {
            $user = $topic->getAuthor();
        }
        else {
            $user = $users[$itPost%(count($users)-1) + 1];
        }

        $post = new $postClass();
        $post->setTopic($topic);
        $post->setMessage('Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est.');
        $post->setAuthor($user);
        $post->setNumber($itPost+1);

        ${'post_' . $i . '_' . $itPost} = $post;
    }

    ${'topic_' . $i} = $topic;

    unset($post, $topic, $user);
}
