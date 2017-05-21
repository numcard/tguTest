<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="tests form">
			<?php echo $this->Form->create('Test', ['enctype' => 'multipart/form-data']); ?>
			<fieldset>
				<legend><?php echo __('Создать тест'); ?></legend>
				<?php
				echo $this->Form->input('test', ['label' => 'Название теста']);
				echo $this->Form->input('Test.questionFile', ['label' => 'Вопросы',
					'type' => 'file']);
				echo $this->Form->input('Test.answerFile', ['label' => 'Ответы',
					'type' => 'file']);
				echo $this->Form->input('subject_id', ['label' => 'Предмет']);
				echo $this->Form->hidden('user_id', ['default' => $currentUser['id']])
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Создать')); ?>
		</div>
	</div>
</div>