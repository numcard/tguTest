<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="col-md-10 col-md-offset-1">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Вход'); ?></legend>
        <?php
        echo $this->Form->input('email', ['label'=>'Почта']);
        echo $this->Form->input('password', ['label'=>'Пароль']);
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Войти')); ?>
</div>