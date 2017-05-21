<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="col-md-10 col-md-offset-1">
    <?php echo $this->Form->create('Feedback'); ?>
    <fieldset>
        <legend><?php echo __('Обратная связь'); ?></legend>
        <?php
            if($anyone)
                echo $this->Form->input('to', ['label' => 'Кому', 'options' => $users]);
            echo $this->Form->input('message', ['label' => 'Сообщение', 'type' => 'textarea', 'rows' => '5', 'cols' => '5']);
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Отправить')); ?>
</div>