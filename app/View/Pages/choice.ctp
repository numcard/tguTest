<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="col-md-offset-1 col-md-10">
    <?php echo $this->Form->create('Page', ['action' => 'create', 'class' => 'form-horizontal']); ?>
    <?php echo $this->Form->hidden('available_id', ['default' => $userTest['Available']['id']]) ?>
    <div style="margin-bottom: 5px" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Информация о тесте</h3>
    </div>
    <div class="panel-body">
            <input type="hidden" name="id_test" value="1">
            <div class="form-group">
                <label class="col-md-4 control-label">Предмет</label>
                <div class="col-md-7">
                    <pre><?php echo h($userTest['Subject']['name']); ?></pre>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Тест</label>
                <div class="col-md-7">
                    <pre><?php echo h($userTest['Test']['test']); ?></pre>
                </div>
            </div>
        <div class="form-group">
                <label class="col-md-4 control-label">Баллы</label>
                <div class="col-md-7">
                    <pre><?php echo h($userTest['Available']['testMarks']); ?> баллов</pre>
                </div>
            </div>
            <div class="form-group">
                <label for="number_of_questions" class="col-md-4 control-label">Кол-во вопросов</label>
                <div class="col-md-7">
                    <pre><?php echo h($userTest['Available']['testQuestions']); ?> вопросов</pre>
                </div>
            </div>
            <div class="form-group">
                <label for="number_of_questions" class="col-md-4 control-label">Время на прохождение</label>
                <div class="col-md-7">
                    <pre><?php echo h($userTest['Available']['testMinutes']); ?> минут</pre>
                </div>
            </div>
            </div>
    </div>
    <div class="text-center">
        <?php echo $this->Form->end(__('Начать тест'), ['class' => 'center-block']); ?>
    </div>
</div>