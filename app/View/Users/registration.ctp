<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="col-md-10 col-md-offset-1">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Регистрация'); ?></legend>
        <?php
        echo $this->Form->input('name', ['label' => 'Имя']);
        echo $this->Form->input('email', ['label' => 'Почта']);
        echo $this->Form->input('password', ['label' => 'Пароль']);
        echo $this->Form->input('passwordConfirm', ['type' => 'password', 'label' => 'Подтверждение пароля']);
        echo $this->Form->input('group_id', ['label' => 'Группа', 'empty' => false]);
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Зарегистрироваться')); ?>
</div>