<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактровать'), array('action' => 'edit', $group['Group']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $group['Group']['id']), array('confirm' => __('Удалить # %s?', $group['Group']['name']), 'class' => 'list-group-item')); ?> </li>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="availables index">
			<h2><?php echo __('Группа'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('ID'); ?></dt>
				<dd>
					<?php echo h($group['Group']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Группа'); ?></dt>
				<dd>
					<?php echo h($group['Group']['name']); ?>
					&nbsp;
				</dd>
			</dl>
	</div>
</div>
