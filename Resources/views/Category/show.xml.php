<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title><?php echo $category->getName() ?> Last Topics</title>
    <?php echo $view['actions']->render('ForumBundle:Topic:list', array('category' => $category)) ?>
</feed>
