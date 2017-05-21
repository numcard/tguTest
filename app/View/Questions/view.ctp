<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $question['Question']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $question['Question']['id']), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $question['Question']['question']))); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="questions view">
			<h2><?php echo __('Вопрос'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('ID вопроса'); ?></dt>
				<dd>
					<?php echo h($question['Question']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('№ ответа'); ?></dt>
				<dd>
					<?php echo h($question['Question']['IDquestion']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Вопрос'); ?></dt>
				<dd>
					<?php echo h($question['Question']['question']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Тест'); ?></dt>
				<dd>
					<?php echo $this->Html->link($question['Test']['test'], array('controller' => 'tests', 'action' => 'view', $question['Test']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Предмет'); ?></dt>
				<dd>
					<?php echo $this->Html->link($question['Subject']['name'], array('controller' => 'subjects', 'action' => 'view', $question['Subject']['id'])); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>
<div class="related col-sm-12 col-md-12">
	<h3><?php echo __('Связанные ответы'); ?></h3>
	<?php if (!empty($question['Answer'])): ?>
	<table>
	<tr>
		<th><?php echo __('ID вопроса'); ?></th>
		<th><?php echo __('Номер ответа'); ?></th>
		<th><?php echo __('Ответ'); ?></th>
		<th><?php echo __('Is Answer'); ?></th>
		<th><?php echo __('Тест'); ?></th>
		<th class="actions"><?php echo __('Действия'); ?></th>
	</tr>
	<?php foreach ($question['Answer'] as $answer): ?>
		<tr>
			<td><?php echo h($question['Question']['id']) ?></td>
			<td><?php echo $answer['answerID']; ?></td>
			<td><?php echo $answer['answer']; ?></td>
			<td><?php echo ($answer['is_answer'] == 1) ? 'Да' : 'Нет'; ?></td>
			<td><?php echo $question['Test']['test']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'answers', 'action' => 'view', $answer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'answers', 'action' => 'edit', $answer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'answers', 'action' => 'delete', $answer['id']), array('confirm' => __('Удалить # %s?', $answer['answer']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('Создать ответ'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<div class="related col-sm-12 col-md-12">
	<h3><?php echo __('Связанные короткие ответы'); ?></h3>
	<?php if (!empty($question['ShortAnswer'])): ?>
	<table>
	<tr>
		<th><?php echo __('ID вопроса'); ?></th>
		<th><?php echo __('Номера ответов'); ?></th>
		<th class="actions"><?php echo __('Действия'); ?></th>
	</tr>
	<?php foreach ($question['ShortAnswer'] as $shortAnswer): ?>
		<tr>
			<td><?php echo $shortAnswer['question_id']; ?></td>
			<td><?php echo $shortAnswer['answers']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'short_answers', 'action' => 'view', $shortAnswer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'short_answers', 'action' => 'edit', $shortAnswer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'short_answers', 'action' => 'delete', $shortAnswer['id']), array('confirm' => __('Удалить # %s?', $shortAnswer['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>