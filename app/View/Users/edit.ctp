<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $this->Form->value('User.id')), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $this->Form->value('User.name')))); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="users form">
			<?php echo $this->Form->create('User'); ?>
			<fieldset>
				<legend><?php echo __('Редактирование пользователя'); ?></legend>
				<?php
				echo $this->Form->input('id');
				echo $this->Form->input('name', ['label' => 'Имя']);
				echo $this->Form->input('group_id', ['empty' => true, 'label' => 'Группа']);
				echo $this->Form->input('flag_id', ['label' => 'Привилегии']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Сохранить')); ?>
		</div>
	</div>
</div>