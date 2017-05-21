

<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Редактировать'), array('action' => 'edit', $flag['Flag']['id']), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
			<?php echo $this->Html->link(__('Создать'), array('action' => 'add'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="flags view">
			<h2><?php echo __('Привилегия'); ?></h2>
			<dl class="dl-horizontal">
				<dt><?php echo __('ID'); ?></dt>
				<dd>
					<?php echo h($flag['Flag']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Флаг'); ?></dt>
				<dd>
					<?php echo h($flag['Flag']['flag']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Привилегия'); ?></dt>
				<dd>
					<?php echo h($flag['Flag']['name']); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>