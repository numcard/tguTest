<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="availables form">
			<?php echo $this->Form->create('Available'); ?>
			<fieldset>
				<legend><?php echo __('Создать доступ к тесту'); ?></legend>
				<?php
				echo $this->Form->input('test_id', ['label' => 'Тест']);
				echo $this->Form->input('group_id', ['label' => 'Группа']);
				echo $this->Form->input('testMarks', ['label' => 'Баллы', 'type' => 'text']);
				echo $this->Form->input('testQuestions', ['label' => 'Вопросов', 'default' => '20']);
				echo $this->Form->input('testMinutes', ['label' => 'Минут', 'default' => '20']);
				echo $this->Form->input('testTries', ['label' => 'Попыток', 'default' => '1']);
				echo $this->Form->input('before', ['label' => 'Дата окончания доступа к тесту']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Создать')); ?>
		</div>
	</div>
</div>