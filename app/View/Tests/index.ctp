<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="tests index">
			<h2><?php echo __('Тесты'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('test', 'Тест'); ?></th>
					<th><?php echo $this->Paginator->sort('subject_id', 'Предмет'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id', 'Редактор'); ?></th>
					<th><?php echo $this->Paginator->sort('created', 'Создан'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($tests as $test): ?>
					<tr>
						<td><?php echo h($test['Test']['test']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($test['Subject']['name'], array('controller' => 'subjects', 'action' => 'view', $test['Subject']['id'])); ?>
						</td>
						<td>
							<?php echo $this->Html->link($test['User']['name'], array('controller' => 'users', 'action' => 'view', $test['User']['id'])); ?>
						</td>
						<td><?php echo h(date("d-m-Y H:i:s", strtotime($test['Test']['created']))); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $test['Test']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $test['Test']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $test['Test']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить # %s?', $test['Test']['test']))); ?>
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
