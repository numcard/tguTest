<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $feedback['Feedback']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $feedback['Feedback']['id']), array('class' => 'list-group-item', 'confirm' => __('Удалить # %s?', $feedback['Feedback']['id']))); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="feedback view">
			<h2><?php echo __('Обратная связь'); ?></h2>
			<dl>
				<dt><?php echo __('ID'); ?></dt>
				<dd>
					<?php echo h($feedback['Feedback']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('От кого'); ?></dt>
				<dd>
					<?php echo h($feedback['Feedback']['from']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Кому'); ?></dt>
				<dd>
					<?php echo h($feedback['Feedback']['to']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Сообщение'); ?></dt>
				<dd>
					<?php echo h($feedback['Feedback']['message']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Отправлено'); ?></dt>
				<dd>
					<?php echo h($feedback['Feedback']['created']); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
</div>