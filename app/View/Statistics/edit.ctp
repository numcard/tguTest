<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $this->Form->value('Statistic.id')), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $this->Form->value('Statistic.id')))); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="statistics form">
			<?php echo $this->Form->create('Statistic'); ?>
			<fieldset>
				<legend><?php echo __('Редактирование статистики'); ?></legend>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('Test.test', ['label' => 'Тест', 'type' => 'text', 'disabled' => 'disabled']);
					echo $this->Form->input('User.name', ['label' => 'Пользователь', 'type' => 'text', 'disabled' => 'disabled']);
					echo $this->Form->input('Group.name', ['label' => 'Группа', 'type' => 'text', 'disabled' => 'disabled']);
					echo $this->Form->input('successAnswers', ['label' => 'Правильных ответов']);
					echo $this->Form->input('noAnswers', ['label' => 'Без ответов']);
					echo $this->Form->input('failAnswers', ['label' => 'Неправильных ответов']);
					echo $this->Form->input('numberQuestions', ['label' => 'Общее число вопросов']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Сохранить')); ?>
		</div>
	</div>
</div>