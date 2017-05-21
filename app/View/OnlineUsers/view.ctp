<div class="onlineUsers view">
<h2><?php echo __('Online User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($onlineUser['OnlineUser']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($onlineUser['User']['name'], array('controller' => 'users', 'action' => 'view', $onlineUser['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Test'); ?></dt>
		<dd>
			<?php echo $this->Html->link($onlineUser['Test']['test'], array('controller' => 'tests', 'action' => 'view', $onlineUser['Test']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($onlineUser['OnlineUser']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Completed'); ?></dt>
		<dd>
			<?php echo h($onlineUser['OnlineUser']['completed']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Online User'), array('action' => 'edit', $onlineUser['OnlineUser']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Online User'), array('action' => 'delete', $onlineUser['OnlineUser']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $onlineUser['OnlineUser']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Online Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Online User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tests'), array('controller' => 'tests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Test'), array('controller' => 'tests', 'action' => 'add')); ?> </li>
	</ul>
</div>
