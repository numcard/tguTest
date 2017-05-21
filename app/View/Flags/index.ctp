<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="flags index">
			<h2><?php echo __('Привилегии'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('flag', 'Флаг'); ?></th>
					<th><?php echo $this->Paginator->sort('name', 'Привилегия'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($flags as $flag): ?>
					<tr>
						<td><?php echo h($flag['Flag']['flag']); ?>&nbsp;</td>
						<td><?php echo h($flag['Flag']['name']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('Посмотреть'), array('action' => 'view', $flag['Flag']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $flag['Flag']['id']), ['class' => 'btn btn-success']); ?>
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

