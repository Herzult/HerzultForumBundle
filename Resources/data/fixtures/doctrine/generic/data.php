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
$general->setDescription('Hierdie is ïn kort maar baie goeie deskripsie van die seksie. Dit kan nie langer us dit wees nie. Die borrel luik nie te sleg nie.');
$general->setPosition(0);
$categories[] = $general;

$documentation = new $categoryClass();
$documentation->setName('Documentation');
$documentation->setDescription('Hierdie is ïn kort maar baie goeie deskripsie van die seksie. Dit kan nie langer us dit wees nie. Die borrel luik nie te sleg nie.');
$documentation->setPosition(1);
$categories[] = $documentation;

$helpAndSupport = new $categoryClass();
$helpAndSupport->setName('Help & Support');
$helpAndSupport->setDescription('Hierdie is ïn kort maar baie goeie deskripsie van die seksie. Dit kan nie langer us dit wees nie. Die borrel luik nie te sleg nie.');
$helpAndSupport->setPosition(2);
$categories[] = $helpAndSupport;

$development = new $categoryClass();
$development->setName('Development');
$development->setDescription('Hierdie is ïn kort maar baie goeie deskripsie van die seksie. Dit kan nie langer us dit wees nie. Die borrel luik nie te sleg nie.');
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

        ${'post_' . $i . '_' . $itPost} = $post;
    }

    ${'topic_' . $i} = $topic;

    unset($post, $topic, $user);
}
