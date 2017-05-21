<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $subject['Subject']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $subject['Subject']['id']), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $subject['Subject']['name']))); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="subjects view">
			<h2><?php echo __('Предмет'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('Предмет'); ?></dt>
				<dd>
					<?php echo h($subject['Subject']['name']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Редактор'); ?></dt>
				<dd>
					<?php echo $this->Html->link($subject['User']['name'], array('controller' => 'users', 'action' => 'view', $subject['User']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Изменен'); ?></dt>
				<dd>
					<?php echo h($subject['Subject']['modified']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Создан'); ?></dt>
				<dd>
					<?php echo h($subject['Subject']['created']); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>