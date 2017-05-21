<div class="row">
	<div class="col-sm-2 col-md-2">
		<h3>Действия</h3>
		<div class="list-group center-block text-center">
			<?php echo $this->Html->link(__('Список'), array('action' => 'index'), ['class' => 'list-group-item']); ?>
		</div>
	</div>
	<div class="col-sm-10 col-md-10">
		<div class="users form">
			<?php echo $this->Form->create('User'); ?>
			<fieldset>
				<legend><?php echo __('Создание пользователя'); ?></legend>
				<?php
				echo $this->Form->input('name', ['label' => 'Имя']);
				echo $this->Form->input('email', ['label' => 'Почта']);
				echo $this->Form->input('password', ['label' => 'Пароль']);
				echo $this->Form->input('passwordConfirm', ['type' => 'password', 'label' => 'Подтверждение пароля', ]);
				echo $this->Form->input('flag_id', ['label' => 'Привилегии', 'empty' => false]);
				echo $this->Form->input('group_id', ['label' => 'Группа', 'empty' => true]);
				?>
			</fieldset>
			<?php echo $this->Form->end(__('Создать')); ?>
		</div>
	</div>
</div>