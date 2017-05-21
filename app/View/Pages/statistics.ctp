<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="col-md-12">
    <?php if(empty($statistics)): ?>
    <h2>Вы еще не проходили тестирование.</h2>
    <?php else: ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Информация о тесте</h3>
        </div>
        <div class="panel-body">
            <table class="table" style="margin: 0">
                <thead>
                <tr>
                    <th>Пользователь</th>
                    <th>Предмет</th>
                    <th>Название</th>
                    <th>Дата прохождения</th>
                    <th>Баллы</th>
                    <th>Вопросы</th>
                    <th>Результат</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($statistics as $statistic): ?>
                <tr>
                    <td><?php echo h($statistic['User']['name']); ?></td>
                    <td><?php echo h($statistic['Subject']['name']); ?></td>
                    <td><?php echo h($statistic['Test']['test']); ?></td>
                    <td><?php echo h(date("d-m-Y H:i:s", strtotime($statistic['Statistic']['created']))); ?></td>
                    <td><span class="label label-info" title="Баллы"><?php echo h($statistic['Statistic']['testMarks']); ?></span></td>
                    <td style="width: 120px">
                        <span class="label label-success" title="Правильных ответов"><?php echo h($statistic['Statistic']['successAnswers']); ?></span>
                        <span class="label label-warning" title="Вопросы без ответа"><?php echo h($statistic['Statistic']['noAnswers']); ?></span>
                        <span class="label label-danger" title="Неправильных ответов"><?php echo h($statistic['Statistic']['failAnswers']); ?></span>
                    </td>
                    <td style="width: 200px">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped active" style="width:<?php echo h(round($statistic['percents']['success'], 2)); ?>%" title="Правильных ответов"><?php if($statistic['percents']['isSuccess']) echo h(round($statistic['percents']['success'], 2)) . '%';?></div>
                            <div class="progress-bar progress-bar-warning progress-bar-striped active" style="width:<?php echo h(round($statistic['percents']['no'], 2)); ?>%" title="Вопросы без ответа"><?php if($statistic['percents']['isNo']) echo h(round($statistic['percents']['no'], 2)) . '%';?></div>
                            <div class="progress-bar progress-bar-danger progress-bar-striped active" style="width:<?php echo h(round($statistic['percents']['fail'], 2)); ?>%" title="Неправильных ответов"><?php if($statistic['percents']['isFail']) echo h(round($statistic['percents']['fail'], 2)) . '%'?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>