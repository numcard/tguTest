<div class="text-center">
	<?php echo $this->Form->create('Statistic'); ?>
	<select style="margin-left: 5px; margin-bottom: 5px;" name="Available">
		<?php foreach($availableList as $key => $group): ?>
			<optgroup label="<?php echo $key ?>">
				<?php foreach($group as $keyGroup => $one): ?>
					<option value="<?php echo $one ?>"><?php echo $keyGroup ?></option>
				<?php endforeach; ?>
			</optgroup>
		<?php endforeach; ?>
	</select>
	<?php echo $this->Form->end(__('Показать')); ?>
</div>

<?php if(isset($id)): ?>
<div class="row">
	<div class="col-sm-12col-md-12">
		<div class="statistics index">
			<h2><?php echo __('Статистика > ' . $available['Group']['name'] . ' > ' . $available['Test']['test']); ?></h2>
			<table cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<th><?php echo h('Пользователь') ?></th>
					<th><?php echo h('Баллы'); ?></th>
					<th><?php echo h('Прошел'); ?></th>
					<th class="actions"><?php echo __('Действия'); ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($statistic as $one): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($one['User']['name'], array('controller' => 'users', 'action' => 'view', $one['User']['id'])); ?>
						</td>
						<td>
							<span class="label label-info" title="Баллы"><?php echo h($one['Statistic']['testMarks']); ?></span>
						</td>
						<td><?php echo h(date("d-m-Y H:i:s", strtotime($one['Statistic']['created']))); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('Подробнее'), '/statistic/' . $one['Statistic']['id'], ['class' => 'btn btn-info']); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<p>
		</div>
	</div>
</div>
<?php endif; ?>