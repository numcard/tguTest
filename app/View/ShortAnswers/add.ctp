<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="shortAnswers form">
			<?php echo $this->Form->create('ShortAnswer'); ?>
			<fieldset>
				<legend><?php echo __('Создание короткого ответа'); ?></legend>
				<?php
				echo $this->Form->input('question_id', ['label' => 'ID Вопроса']);
				echo $this->Form->input('answers', ['label' => 'Ответы']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Создать')); ?>
		</div>
	</div>
</div>