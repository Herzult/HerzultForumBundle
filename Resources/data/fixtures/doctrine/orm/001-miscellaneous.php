<?php

use Bundle\DoctrineUserBundle\Entity\User;
use Bundle\ForumBundle\Entity\Category;
use Bundle\ForumBundle\Entity\Topic;
use Bundle\ForumBundle\Entity\Post;

/**
 * Create some users
 */
$users = array();

$john = new User();
$john->setUsername('John');
$john->setEmail('john@doe.com');
$john->setPassword('changeme');
$users[] = $john;

$tom = new User();
$tom->setUsername('Tom');
$tom->setEmail('tom@doe.com');
$tom->setPassword('changeme');
$users[] = $tom;

$max = new User();
$max->setUsername('Max');
$max->setEmail('max@doe.com');
$max->setPassword('changeme');
$users[] = $max;

$marie = new User();
$marie->setUsername('Marie');
$marie->setEmail('marie@doe.com');
$marie->setPassword('changeme');
$users[] = $marie;

$thomas = new User();
$thomas->setUsername('Thomas');
$thomas->setEmail('thomas@doe.com');
$thomas->setPassword('changeme');
$users[] = $thomas;

$julie = new User();
$julie->setUsername('Julie');
$julie->setEmail('julie@doe.com');
$julie->setPassword('changeme');
$users[] = $julie;

$marc = new User();
$marc->setUsername('Marc');
$marc->setEmail('marc@doe.com');
$marc->setPassword('changeme');
$users[] = $marc;

$paul = new User();
$paul->setUsername('Paul');
$paul->setEmail('paul@doe.com');
$paul->setPassword('changeme');
$users[] = $paul;

$martin = new User();
$martin->setUsername('Martin');
$martin->setEmail('martin@doe.com');
$martin->setPassword('changeme');
$users[] = $martin;

$kate = new User();
$kate->setUsername('Kate');
$kate->setEmail('kate@doe.com');
$kate->setPassword('changeme');
$users[] = $kate;


/*
 * Create some categories
 */

$categories = array();

$general = new Category();
$general->setName('General');
$general->setPosition(0);
$categories[] = $general;

$documentation = new Category();
$documentation->setName('Documentation');
$documentation->setPosition(1);
$categories[] = $documentation;

$helpAndSupport = new Category();
$helpAndSupport->setName('Help & Support');
$helpAndSupport->setPosition(2);
$categories[] = $helpAndSupport;

$development = new Category();
$development->setName('Development');
$development->setPosition(3);
$categories[] = $development;



/*
 * Create some topics
 */

for ($i = 0; $i < 100; $i++) {
    $topic = new Topic();
    $topic->setCategory($categories[mt_rand(0, count($categories) - 1)]);
    $topic->setSubject('Test topic number ' . $i);
    $topic->setAuthor($user = $users[mt_rand(0, count($users) - 1)]);

    $ii = 0;

    do {

        if ($ii > 0) {
            $user = $users[mt_rand(0, count($users) - 1)];
        }

        $post = new Post($topic);
        $post->setMessage('Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est.');
        $post->setAuthor($user);

        ${'post_' . $i . '_' . $ii} = $post;

        unset($post);
        $ii++;
    } while (mt_rand(0, 1) === 1);

    ${'topic_' . $i} = $topic;

    unset($topic, $user);
}
