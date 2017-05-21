<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $statistic['Statistic']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="statistics view">
			<h2><?php echo __('Статистика'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('Тест'); ?></dt>
				<dd>
					<?php echo $this->Html->link($statistic['Test']['test'], array('controller' => 'tests', 'action' => 'view', $statistic['Test']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Пользователь'); ?></dt>
				<dd>
					<?php echo $this->Html->link($statistic['User']['name'], array('controller' => 'users', 'action' => 'view', $statistic['User']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Группа'); ?></dt>
				<dd>
					<?php echo $this->Html->link($statistic['Group']['name'], array('controller' => 'groups', 'action' => 'view', $statistic['Group']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Правильных'); ?></dt>
				<dd>
					<?php echo h($statistic['Statistic']['successAnswers']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Без ответа'); ?></dt>
				<dd>
					<?php echo h($statistic['Statistic']['noAnswers']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Неправильных'); ?></dt>
				<dd>
					<?php echo h($statistic['Statistic']['failAnswers']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Всего'); ?></dt>
				<dd>
					<?php echo h($statistic['Statistic']['numberQuestions']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Проходил'); ?></dt>
				<dd>
					<?php echo h(date("d-m-Y H:i:s", strtotime($statistic['Statistic']['created']))); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>
