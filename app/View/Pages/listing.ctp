<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="col-md-12">
    <?php if($userAvailableTests === null): ?>
        <h3>Доступных тестов нет.</h3>
    <?php else: ?>
        <table cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th>Название теста</th>
                <th>Предмет</th>
                <th>Баллы</th>
                <th>Доступен до</th>
                <th class="actions">Ссылка</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($userAvailableTests as $test): ?>
            <tr>
                <td> <?php echo h($test['Test']['test']); ?> </td>
                <td> <?php echo h($test['Subject']['name']); ?> </td>
                <td> <?php echo h($test['Available']['testMarks']); ?> </td>
                <td> <?php echo h(date("d-m-Y H:i:s", strtotime($test['Available']['before']))); ?> </td>
                <td> <?php echo $this->Html->link(__('Пройти тест'), [
                        'controller' => 'test',
                        'action' => 'choice',
                        'full_base' => true,
                        $test['Test']['id']]);?> </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
