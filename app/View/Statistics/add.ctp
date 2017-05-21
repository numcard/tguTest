<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="statistics form">
			<?php echo $this->Form->create('Statistic'); ?>
			<fieldset>
				<legend><?php echo __('Создание статистики'); ?></legend>
				<?php
					echo $this->Form->input('user_id', ['label' => 'Пользователь']);
					echo $this->Form->input('test_id', ['label' => 'Тест']);
					echo $this->Form->input('success_answers', ['label' => 'Правильных ответов', 'default' => 5]);
					echo $this->Form->input('no_answers', ['label' => 'Без ответов', 'default' => 5]);
					echo $this->Form->input('fail_answers', ['label' => 'Неправильных ответов', 'default' => 10]);
					echo $this->Form->input('number_of_questions', ['label' => 'Общее число вопросов', 'default' => 20]);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Создать')); ?>
		</div>
	</div>
</div>