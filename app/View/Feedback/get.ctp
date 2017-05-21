<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>

<div class="col-md-10 col-md-offset-1">
    <?php if(empty($isMessage)): ?>
    <h2>Сообщений нету</h2>
    <?php else: ?>
    <h2>Сообщения</h2>
    <div class="list-group">
        <?php foreach($messages as $message): ?>
                <a class="list-group-item">
                    <h4 style="display:inline-block" class="list-group-item-heading text-left"><?php echo h($message['Feedback']['from']); ?> -> <?php echo h($message['Feedback']['to']); ?></h4>
                    <h4 style="display:inline-block; position:absolute; right: 10px;" class="list-group-item-heading text-right"><?php echo date("H:i:s d-m-Y", strtotime($message['Feedback']['created'])); ?></h4>
                    <blockquote><?php echo h($message['Feedback']['message']); ?></blockquote>
                </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>