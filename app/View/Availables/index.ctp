<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="availables index">
			<h2><?php echo __('Доступ к тестам'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('group_id', 'Группа'); ?></th>
					<th><?php echo $this->Paginator->sort('test_id', 'Тест'); ?></th>
					<th><?php echo $this->Paginator->sort('testMarks', 'Баллы'); ?></th>
					<th><?php echo $this->Paginator->sort('testQuestions', 'Вопросов'); ?></th>
					<th><?php echo $this->Paginator->sort('testMinutes', 'Минут'); ?></th>
					<th><?php echo $this->Paginator->sort('testTries', 'Попыток'); ?></th>
					<th><?php echo $this->Paginator->sort('before', 'Дата окончания'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($availables as $available): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($available['Group']['name'], array('controller' => 'groups', 'action' => 'view', $available['Group']['id'])); ?>
						</td>
						<td>
							<?php echo $this->Html->link($available['Test']['test'], array('controller' => 'tests', 'action' => 'view', $available['Test']['id'])); ?>
						</td>
						<td><?php echo h($available['Available']['testMarks']); ?>&nbsp;</td>
						<td><?php echo h($available['Available']['testQuestions']); ?>&nbsp;</td>
						<td><?php echo h($available['Available']['testMinutes']); ?>&nbsp;</td>
						<td><?php echo h($available['Available']['testTries']); ?>&nbsp;</td>
						<td><?php echo h(date("d-m-Y H:i:s", strtotime($available['Available']['before']))); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $available['Available']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $available['Available']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $available['Available']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить доступ к тесту для группы # %s?', $available['Group']['name']))); ?>
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
