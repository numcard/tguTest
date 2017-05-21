<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="feedback index">
			<h2><?php echo __('Обратная связь'); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo h('От кого'); ?></th>
					<th><?php echo h('Кому'); ?></th>
					<th><?php echo h('Сообщение'); ?></th>
					<th><?php echo h('Отправлено'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($feedback as $feed): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($feed['From'], array('controller' => 'users', 'action' => 'view', $feed['Feedback']['from'])); ?>
						</td>
						<td>
							<?php if($feed['To'] == 'Администрация')
								echo h($feed['To']);
							else
								echo $this->Html->link($feed['To'], array('controller' => 'users', 'action' => 'view', $feed['Feedback']['to'])); ?>
						</td>
						<td><?php echo h($feed['Feedback']['message']); ?>&nbsp;</td>
						<td><?php echo h($feed['Feedback']['created']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $feed['Feedback']['id']), ['class' => 'btn btn-success']); ?>
							<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $feed['Feedback']['id']), array('class' => 'btn btn-danger', 'confirm' => __('Удалить # %s?', $feed['Feedback']['id']))); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
