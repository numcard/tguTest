<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $this->Form->value('Feedback.id')), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $this->Form->value('Feedback.id')))); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="feedback form">
			<?php echo $this->Form->create('Feedback'); ?>
			<fieldset>
				<legend><?php echo __('Редактировать сообщение'); ?></legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->hidden('from', ['label' => 'От кого']);
					echo $this->Form->hidden('to', ['label' => 'Кому']);
					echo $this->Form->input('message', ['label' => 'Сообщение']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Сохранить')); ?>
		</div>
	</div>
</div>
