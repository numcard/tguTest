<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $shortAnswer['ShortAnswer']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $shortAnswer['ShortAnswer']['id']), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $shortAnswer['ShortAnswer']['question_id']))); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="shortAnswers view">
			<h2><?php echo __('Короткий ответ'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('ID вопроса'); ?></dt>
				<dd>
					<?php echo $this->Html->link($shortAnswer['Question']['id'], array('controller' => 'questions', 'action' => 'view', $shortAnswer['Question']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Ответы'); ?></dt>
				<dd>
					<?php echo h($shortAnswer['ShortAnswer']['answers']); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>