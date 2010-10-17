<?php echo $form->renderErrors() ?>
<?php echo $form->renderHiddenFields() ?>
<div class="field message">
    <?php echo $form['message']->renderErrors() ?>
    <label for="<?php echo $form['message']->getId() ?>">Message</label>
    <?php echo $form['message']->render() ?>
</div>
