<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $user['User']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $user['User']['id']), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $user['User']['name']))); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="users view">
			<h2><?php echo __('Пользователь'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('Имя'); ?></dt>
				<dd>
					<?php echo h($user['User']['name']); ?>
				</dd>
				<dt><?php echo __('Группа'); ?></dt>
				<dd>
					<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Email'); ?></dt>
				<dd>
					<?php echo h($user['User']['email']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Заходил'); ?></dt>
				<dd>
					<?php echo h(date("d-m-Y H:i:s", strtotime($user['User']['modified']))); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Зарегистрирован'); ?></dt>
				<dd>
					<?php echo h(date("d-m-Y H:i:s", strtotime($user['User']['created']))); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Привилегии'); ?></dt>
				<dd>
					<?php echo $this->Html->link($user['Flag']['name'], array('controller' => 'flags', 'action' => 'view', $user['Flag']['id'])); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>