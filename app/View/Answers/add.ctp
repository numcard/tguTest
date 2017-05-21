<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="answers form">
			<?php echo $this->Form->create('Answer'); ?>
			<fieldset>
				<legend><?php echo __('Создать ответ'); ?></legend>
				<h4>Так же не забудьте добавить ответ в <?php echo $this->Html->link('КороткиеОтветы', ['controller' => 'shortAnswers', 'action' => 'index']); ?></h4>
				<?php
					echo $this->Form->input('question_id', ['label' => 'ID вопроса']);
					echo $this->Form->input('answerID', ['label' => 'Номер ответа в вопросе']);
					echo $this->Form->input('answer', ['label' => 'Ответ']);
					echo $this->Form->input('is_answer', ['type' => 'select', 'label' => 'Является ли ответом ?', 'options' => [
						1 => 'Да',
						0 => 'Нет']]);
					echo $this->Form->input('test_id', ['label' => 'Тест']);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Создать')); ?>
		</div>
	</div>
</div>