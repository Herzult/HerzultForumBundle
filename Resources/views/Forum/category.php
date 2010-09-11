<?php $view->extend('ForumBundle::layout') ?>
<?php $view['slots']->set('title', 'Topics List') ?>
<div class="forum forum_index">
    <ul class="crumbs">
        <li><a href="<?php echo $view['forum']->urlFor() ?>">Forum</a></li>
        <li><?php echo $category->getName() ?></li>
    </ul>
    <div class="main topics">
        <h2><?php echo $category->getName() ?></h2>
        <?php echo $view['actions']->render('ForumBundle:Topic:list', array('category' => $category)) ?>
    </div>
    <div class="side categories">
        <h2>Categories</h2>
        <?php echo $view['actions']->render('ForumBundle:Category:list') ?>
    </div>
</div>