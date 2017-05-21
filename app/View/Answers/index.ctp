<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="answers index">
			<h2><?php echo __('Ответы'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('test_id', 'Тест'); ?></th>
					<th><?php echo $this->Paginator->sort('question_id', 'ID'); ?></th>
					<th><?php echo $this->Paginator->sort('answerID', '№'); ?></th>
					<th><?php echo $this->Paginator->sort('answer', 'Ответ'); ?></th>
					<th><?php echo $this->Paginator->sort('is_answer', 'IS answer'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($answers as $answer): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($answer['Test']['test'], array('controller' => 'tests', 'action' => 'view', $answer['Test']['id'])); ?>
						</td>
						<td>
							<?php echo $this->Html->link($answer['Question']['id'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
						</td>
						<td><?php echo h($answer['Answer']['answerID']); ?>&nbsp;</td>
						<td><?php echo h($answer['Answer']['answer']); ?>&nbsp;</td>
						<td><?php echo ($answer['Answer']['is_answer'] == 1) ? 'Да' : 'Нет'; ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $answer['Answer']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $answer['Answer']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $answer['Answer']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить # %s?', $answer['Answer']['answerID']))); ?>
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
