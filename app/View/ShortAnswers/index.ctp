<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="shortAnswers index">
			<h2><?php echo __('Короткие ответы'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('question_id', 'ID вопроса'); ?></th>
					<th><?php echo $this->Paginator->sort('answers', 'Ответы'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($shortAnswers as $shortAnswer): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($shortAnswer['Question']['id'], array('controller' => 'questions', 'action' => 'view', $shortAnswer['Question']['id'])); ?>
						</td>
						<td><?php echo h($shortAnswer['ShortAnswer']['answers']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $shortAnswer['ShortAnswer']['id']), ['class' => 'btn btn-info']); ?>
							<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $shortAnswer['ShortAnswer']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $shortAnswer['ShortAnswer']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить # %s?', $shortAnswer['ShortAnswer']['id']))); ?>
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
