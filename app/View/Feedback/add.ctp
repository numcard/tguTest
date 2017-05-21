<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="feedback form">
			<?php echo $this->Form->create('Feedback'); ?>
			<fieldset>
				<legend><?php echo __('Создание сообщения'); ?></legend>
			<?php
				echo $this->Form->input('from', ['label' => 'От кого']);
				echo $this->Form->input('to', ['label' => 'Кому']);
				echo $this->Form->input('message', ['label' => 'Сообщение']);
			?>
			</fieldset>
			<?php echo $this->Form->end(__('Создать')); ?>
		</div>
	</div>
</div>