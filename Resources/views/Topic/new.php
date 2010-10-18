<?php $view->extend('ForumBundle::layout.php') ?>
<?php $view['slots']->set('title', 'New Topic') ?>
<div class="forum forum_topic_new">
    <div class="main">
        <h2>New Topic</h2>
        <?php echo $form->form($view['router']->generate('forum_topic_create')) ?>
            <?php echo $form->render() ?>
            <button type="submit" name="create">Create topic</button>
        </form>
    </div>
    <div class="side">
        <p><a href="<?php echo $view['router']->generate('forum_index') ?>">Cancel</a></p>
    </div>
</div>
