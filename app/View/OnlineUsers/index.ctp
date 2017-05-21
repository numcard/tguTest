<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="onlineUsers index">
			<h2><?php echo __('Пользователи проходящие тест'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('user_id', 'Пользователь'); ?></th>
					<th><?php echo $this->Paginator->sort('test_id', 'Тест'); ?></th>
					<th><?php echo $this->Paginator->sort('created', 'Создан'); ?></th>
					<th><?php echo $this->Paginator->sort('completed', 'Заканчивается'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($onlineUsers as $onlineUser): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($onlineUser['User']['name'], array('controller' => 'users', 'action' => 'view', $onlineUser['User']['id'])); ?>
						</td>
						<td>
							<?php echo $this->Html->link($onlineUser['Test']['test'], array('controller' => 'tests', 'action' => 'view', $onlineUser['Test']['id'])); ?>
						</td>
						<td><?php echo h($onlineUser['OnlineUser']['created']); ?>&nbsp;</td>
						<td><?php echo h($onlineUser['OnlineUser']['completed']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $onlineUser['OnlineUser']['id'])); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $onlineUser['OnlineUser']['id'])); ?>
							<?php echo $this->Form->postLink(__('Закончить тест'), array('action' => 'delete', $onlineUser['OnlineUser']['id']), array('confirm' => __('Вы уверены что хотите закончить тест # %s ?', $onlineUser['User']['name']))); ?>
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

