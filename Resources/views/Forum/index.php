<?php $view->extend('ForumBundle::layout') ?>
<?php $view['slots']->set('title', 'All Topics List') ?>
<div class="forum forum_index">
    <div class="main topics">
        <h2>All Topics</h2>
        <?php echo $view['actions']->render('ForumBundle:Topic:list') ?>
    </div>
    <div class="side categories">
        <h2>Categories</h2>
        <?php echo $view['actions']->render('ForumBundle:Category:list') ?>
    </div>
</div>