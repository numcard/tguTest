<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="flags form">
			<?php echo $this->Form->create('Flag'); ?>
			<fieldset>
				<legend><?php echo __('Редактирование привилегий'); ?></legend>
				<?php
				echo $this->Form->input('id');
				echo $this->Form->input('flag', ['label' => 'Флаг']);
				echo $this->Form->input('name', ['label' => 'Привилегия']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Сохранить')); ?>
		</div>
	</div>
</div>