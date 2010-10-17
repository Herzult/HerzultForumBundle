<?php $view->extend('ForumBundle::layout.php') ?>
<h2>New Reply</h2>

<?php echo $form->form($view['router']->generate('forum_post_create', array('topicId' => $topic->getId()))) ?>
    <?php echo $form->render() ?>
    <div>
        <button type="submit" name="reply">Add post</button>
    </div>
</form>
