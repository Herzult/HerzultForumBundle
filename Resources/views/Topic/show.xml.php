<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title><?php echo $topic->getSubject() ?></title>
    <id><?php echo $view['forum']->urlForTopic($topic->getRawValue()) ?></id>
    <updated><?php echo $topic->getPulledAt()->format('c') ?></updated>
    <?php echo $view->render('ForumBundle:Post:list.php', array('posts' => $posts)) ?>
</feed>
