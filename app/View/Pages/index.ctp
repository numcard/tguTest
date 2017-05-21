<?php echo $this->Flash->render(); ?>
<?php echo $this->Session->flash(); ?>
<div class="col-md-12">
    <?php if($loggedIn): ?>
        <h1>Добро пожаловать, <?php echo $currentUser['name'] ?>.</h1>
        <p>Доступные тесты - <?php echo $this->Html->link('Пройти', '/test/', ['class' => 'btn btn-primary']); ?>
        <?php else: ?>
        <h1>Добро пожаловать на PHP.test</h1>
        <p>Для прохождения
            тестов <?php echo $this->Html->link('Зарегистрируйтесь', '/reg/', ['class' => 'btn btn-primary btn-xs']); ?>
            или <?php echo $this->Html->link('Войдите', '/login/', ['class' => 'btn btn-primary btn-xs']); ?></p>
    <?php endif; ?>
</div>
