<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="subjects index">
			<h2><?php echo __('Предметы'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('subject', 'Предмет'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id', 'Редактор'); ?></th>
					<th><?php echo $this->Paginator->sort('modified', 'Изменен'); ?></th>
					<th><?php echo $this->Paginator->sort('created', 'Создан'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($subjects as $subject): ?>
					<tr>
						<td><?php echo h($subject['Subject']['name']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($subject['User']['name'], array('controller' => 'users', 'action' => 'view', $subject['User']['id'])); ?>
						</td>
						<td><?php echo h(date("d-m-Y H:i:s", strtotime($subject['Subject']['modified']))); ?>&nbsp;</td>
						<td><?php echo h(date("d-m-Y H:i:s", strtotime($subject['Subject']['created']))); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $subject['Subject']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $subject['Subject']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $subject['Subject']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить # %s?', $subject['Subject']['name']))); ?>
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
