<?php foreach ($posts as $post): ?>

    <entry>
        <author><?php echo $post->getRawValue()->getAuthor() ? : 'Anonymous' ?></author>
        <published><?php echo $post->getCreatedAt()->format('c') ?></published>
        <link rel="alternate"><?php echo $view['forum']->urlForPost($post->getRawValue(), true) ?></link>
    </entry>
<?php endforeach ?>
