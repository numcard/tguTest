<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $this->Form->value('Question.id')), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $this->Form->value('Question.IDquestion')))); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="questions form">
			<?php echo $this->Form->create('Question'); ?>
			<fieldset>
				<legend><?php echo __('Редактировать вопрос'); ?></legend>
				<?php
				echo $this->Form->input('id');
				echo $this->Form->input('IDquestion', ['label' => 'Номер вопроса']);
				echo $this->Form->input('question', ['label' => 'Вопрос']);
				echo $this->Form->input('test_id', ['label' => 'Тест']);
				echo $this->Form->input('subject_id', ['label' => 'Предмет']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Сохранить')); ?>
		</div>
	</div>
</div>