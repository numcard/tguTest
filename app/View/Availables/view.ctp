<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $available['Available']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Form->postLink(__('Удалить'), array('action' => 'delete', $available['Available']['id']), array('confirm' => __('Удалить доступ к тесту для группы # %s?', $available['Group']['name']), 'class' => 'list-group-item')); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="availables view">
			<h2><?php echo __('Доступ к тесту'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('Группа'); ?></dt>
				<dd>
					<?php echo $this->Html->link($available['Group']['name'], array('controller' => 'groups', 'action' => 'view', $available['Group']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Тест'); ?></dt>
				<dd>
					<?php echo $this->Html->link($available['Test']['test'], array('controller' => 'tests', 'action' => 'view', $available['Test']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Баллы'); ?></dt>
				<dd>
					<?php echo h($available['Available']['testMarks']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Вопросов'); ?></dt>
				<dd>
					<?php echo h($available['Available']['testQuestions']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Минут'); ?></dt>
				<dd>
					<?php echo h($available['Available']['testMinutes']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Попыток'); ?></dt>
				<dd>
					<?php echo h($available['Available']['testTries']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Дата окончания'); ?></dt>
				<dd>
					<?php echo h(date("d-m-Y H:i:s", strtotime($available['Available']['before']))); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>
