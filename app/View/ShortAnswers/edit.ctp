<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $this->Form->value('ShortAnswer.id')), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $this->Form->value('ShortAnswer.question_id')))); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="shortAnswers form">
			<?php echo $this->Form->create('ShortAnswer'); ?>
			<fieldset>
				<legend><?php echo __('Редактировать короткий ответ'); ?></legend>
				<?php
				echo $this->Form->input('id');
				echo $this->Form->input('question_id', ['label' => 'ID вопроса']);
				echo $this->Form->input('answers', ['label' => 'Ответы']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Сохранить')); ?>
		</div>
	</div>
</div>