<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $test['Test']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $test['Test']['id']), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $test['Test']['test']))); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="tests view">
			<h2><?php echo __('Тест'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('Название теста'); ?></dt>
				<dd>
					<?php echo h($test['Test']['test']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Предмет'); ?></dt>
				<dd>
					<?php echo $this->Html->link($test['Subject']['name'], array('controller' => 'subjects', 'action' => 'view', $test['Subject']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Редактор'); ?></dt>
				<dd>
					<?php echo $this->Html->link($test['User']['name'], array('controller' => 'users', 'action' => 'view', $test['User']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Изменен'); ?></dt>
				<dd>
					<?php echo h(date("d-m-Y H:i:s", strtotime($test['Test']['modified']))); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Создан'); ?></dt>
				<dd>
					<?php echo h(date("d-m-Y H:i:s", strtotime($test['Test']['created']))); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>