<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<script>
    function countDown(second,endMinute,endHour,endDay,endMonth,endYear) {
        var now = new Date();
        second = (arguments.length == 1) ? second + now.getSeconds() : second;
        endYear =  typeof(endYear) != 'undefined' ?  endYear : now.getFullYear();
        endMonth = endMonth ? endMonth - 1 : now.getMonth();  //номер месяца начинается с 0
        endDay = typeof(endDay) != 'undefined' ? endDay :  now.getDate();
        endHour = typeof(endHour) != 'undefined' ?  endHour : now.getHours();
        endMinute = typeof(endMinute) != 'undefined' ? endMinute : now.getMinutes();
//добавляем секунду к конечной дате (таймер показывает время уже спустя 1с.)
        var endDate = new Date(endYear,endMonth,endDay,endHour,endMinute,second+1);
        var interval = setInterval(function() { //запускаем таймер с интервалом 1 секунду
            var time = endDate.getTime() - now.getTime();
            if (time < 0) {                      //если конечная дата меньше текущей
                clearInterval(interval);
                alert("Неверная дата!");
            } else {
                var minutes = Math.floor(time / 6e4) % 60;
                var seconds = Math.floor(time / 1e3) % 60;
                document.getElementById('timer').innerHTML = "Осталось: <span class=\"label label-info\">" + minutes
                    + " Минут " + seconds + " Секунд</span>";
                if (!seconds && !minutes) {
                    clearInterval(interval);
                    alert("Время вышло!");
                }
            }
            now.setSeconds(now.getSeconds() + 1); //увеличиваем текущее время на 1 секунду
        }, 1000);
    }
    countDown(<?php echo $time - 1 ?>); //устанавливаем таймер на 30 секунд
</script>
<div class="col-md-12">
    <?php echo $this->Form->create('Page', ['class' => 'form-horizontal']); ?>
    <?php echo $this->Form->hidden('id', ['default' => $id]) ?>
    <?php echo $this->Form->hidden('question_id', ['default' => $question_id]) ?>
    <?php echo $this->Form->hidden('questionID', ['default' => $questionID]) ?>
    <ul class="pagination">
        <?php foreach ($onlineTest as $test): ?>
            <?php if ($questionID == $test['OnlineTest']['questionID']): ?>
                <li class="active"><a
                        href="/online/<?php echo $id . '/' . $test['OnlineTest']['questionID']; ?>"><?php echo $test['OnlineTest']['questionID']; ?>
                        <span class="sr-only">(current)</span></a></li>
            <?php elseif (is_null($test['OnlineTest']['answer'])): ?>
                <li>
                    <a href="/online/<?php echo $id . '/' . $test['OnlineTest']['questionID']; ?>"><?php echo $test['OnlineTest']['questionID']; ?></a>
                </li>
            <?php else: ?>
                <li class="disabled"><a class="label-default"><?php echo $test['OnlineTest']['questionID']; ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <div class="bs-callout bs-callout-info" id="callout-alerts-no-default">
        <h4><?php echo htmlspecialchars_decode(htmlspecialchars_decode($currentData['Question']['question'])); ?></h4>
        <?php foreach ($currentData['Answer'] as $answer): ?>
            <?php if ($currentData['isMultiple'] === true): ?>
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" id="inlineCheckbox<?php echo $answer['answerID']; ?>"
                           name="answer<?php echo $answer['answerID']; ?>" value="<?php echo $answer['answerID'] ?>">
                    <label
                        for="inlineCheckbox<?php echo $answer['answerID']; ?>"> <?php echo htmlspecialchars_decode($answer['answer']); ?> </label>
                </div>
            <?php else: ?>
                <div class="radio radio-primary">
                    <input type="radio" id="inlineRadio<?php echo $answer['answerID']; ?>" name="answer"
                           value="<?php echo $answer['answerID'] ?>">
                    <label
                        for="inlineRadio<?php echo $answer['answerID']; ?>"> <?php echo htmlspecialchars_decode($answer['answer']); ?> </label>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="row online">
        <div class="col-md-6"><?php echo $this->Form->end(['label' => 'Ответить', 'div' => 'submit super-button']); ?></div>
        <div class="col-md-6"><div id="timer" class="text-right"></div></div>

    </div>

</div>
