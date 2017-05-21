<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="questions index">
			<h2><?php echo __('Вопросы'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('IDquestion', '№'); ?></th>
					<th><?php echo $this->Paginator->sort('question', 'Вопрос'); ?></th>
					<th><?php echo $this->Paginator->sort('test_id', 'Тест'); ?></th>
					<th><?php echo $this->Paginator->sort('subject_id', 'Предмет'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($questions as $question): ?>
					<tr>
						<td><?php echo h($question['Question']['IDquestion']); ?>&nbsp;</td>
						<td><?php echo h($question['Question']['question']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($question['Test']['test'], array('controller' => 'tests', 'action' => 'view', $question['Test']['id'])); ?>
						</td>
						<td>
							<?php echo $this->Html->link($question['Subject']['name'], array('controller' => 'subjects', 'action' => 'view', $question['Subject']['id'])); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $question['Question']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $question['Question']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $question['Question']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить # %s?', $question['Question']['id']))); ?>
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
