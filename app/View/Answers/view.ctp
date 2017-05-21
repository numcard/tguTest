<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $answer['Answer']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $answer['Answer']['id']), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $answer['Answer']['answerID']))); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="answers view">
			<h2><?php echo __('Ответ'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('ID вопроса'); ?></dt>
				<dd>
					<?php echo $this->Html->link($answer['Question']['id'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('№ ответа'); ?></dt>
				<dd>
					<?php echo h($answer['Answer']['answerID']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Ответ'); ?></dt>
				<dd>
					<?php echo h($answer['Answer']['answer']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Является ответом'); ?></dt>
				<dd>
					<?php echo ($answer['Answer']['is_answer'] == 1) ? 'Да' : 'Нет'; ?>
				</dd>
				<dt><?php echo __('Тест'); ?></dt>
				<dd>
					<?php echo $this->Html->link($answer['Test']['test'], array('controller' => 'tests', 'action' => 'view', $answer['Test']['id'])); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>