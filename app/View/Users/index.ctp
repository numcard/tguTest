<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="users index">
			<h2><?php echo __('Пользователи'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name', "Имя"); ?></th>
					<th><?php echo $this->Paginator->sort('group_id', 'Группа'); ?></th>
					<th><?php echo $this->Paginator->sort('email', 'Почта'); ?></th>
					<th><?php echo $this->Paginator->sort('modified', 'Заходил'); ?></th>
					<th><?php echo $this->Paginator->sort('flag_id', 'Привилегии'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
						<td><?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
						<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
						<td><?php echo h(date("d-m-Y H:i:s", strtotime($user['User']['modified']))); ?>&nbsp;</td>
						<td><?php echo $this->Html->link($user['Flag']['name'], array('controller' => 'flags', 'action' => 'view', $user['Flag']['id'])); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить пользователя # %s?', $user['User']['name']))); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => __('Страница {:page} из {:pages}, показано {:current} записей, выведено {:count} записей, начиная с {:start}, заканчивая {:end}')
			));
			?>	</p>
		<div class="paging">
			<?php
			echo $this->Paginator->prev('< ' . __('Предыдущая'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('Следующая') . ' >', array(), null, array('class' => 'next disabled'));
		?>
			</div>
		</div>
	</div>
</div>
