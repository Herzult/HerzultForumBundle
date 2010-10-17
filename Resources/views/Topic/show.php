<?php $view->extend('ForumBundle::layout.php') ?>
<?php $view['slots']->set('title', $topic->getSubject()) ?>
<div class="forum forum_topic">

    <ul class="crumbs">
        <li><a href="<?php echo $view['forum']->urlFor() ?>">Forum</a></li>
        <li><a href="<?php echo $view['forum']->urlForCategory($topic->getCategory()->getRawValue()) ?>"><?php echo $topic->getCategory()->getName() ?></a></li>
        <li><?php echo $topic->getSubject() ?></li>
    </ul>

    <div class="main topic">
        <h2><?php echo $topic->getSubject() ?></h2>
        <?php echo $view->render('ForumBundle:Post:list.php', array('posts' => $posts)) ?>
    </div>

    <div class="side menu">
        <a href="<?php echo $view['router']->generate('forum_post_new', array('topicId' => $topic->getId())) ?>">Add a New Reply</a>
    </div>

</div>
