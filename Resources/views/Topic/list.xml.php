<?php foreach ($topics as $topic): ?>
    <entry>
        <title><?php echo $topic->getSubject() ?></title>
        <author><?php echo $topic->getAuthor() ? : 'Anonymous' ?></author>
        <updated><?php echo $topic->getPulledAt()->format('c') ?></updated>
        <id><?php echo $view['forum']->urlForTopic($topic, true) ?></id>
        <link rel="alternate"><?php echo $view['forum']->urlForTopic($topic, true) ?></link>
    </entry>
<?php endforeach ?>
