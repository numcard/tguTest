<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP');
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $this->get('title'); ?>
    </title>
    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('bootstrap-theme.min');
    echo $this->Html->css('awesome-bootstrap-checkbox');
    echo $this->Html->css('cake.generic');
    echo $this->Html->css('docs.min');
    echo $this->Html->script('jquery-2.1.4.min');
    echo $this->Html->script('bootstrap');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body>
<div class="container">
    <div id="header">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-8" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php echo $this->Html->link('PHP.test', '/', ['class' => 'navbar-brand']); ?>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-8">
                    <ul class="nav navbar-nav">
                        <li <?php echo $this->get('active1'); ?>>
                            <?php echo $this->Html->link('Главная', '/'); ?>
                        </li>
                        <?php if($loggedIn): ?>
                            <li <?php echo $this->get('active2'); ?>>
                                <?php echo $this->Html->link('Тестирование', '/test/'); ?>
                            </li>
                            <li <?php echo $this->get('active3'); ?>>
                                <?php echo $this->Html->link('Статистика', '/statistics/'); ?>
                            </li>
                            <li <?php echo $this->get('active4'); ?>>
                                <?php echo $this->Html->link('Обратная связь', '/feedback/'); ?>
                            </li>
                            <li role="presentation">
                                <?php
                                echo $this->Html->link('Сообщения ' .
                                    $this->Html->tag('span', null, ['class' => 'badge badge-info']) . $userCount,
                                    '/messages/', ['escape' => false]
                                );
                                ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if($loggedIn && ($currentUser['Flag']['flag'] == 'admin' || $currentUser['Flag']['flag'] == 'teacher')): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Админка
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li> <?php echo $this->Html->link('Пользователи', ['controller'=>'users', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Группы', ['controller'=>'groups', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Статистика', ['controller'=>'statistics', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Обратная связь', ['controller'=>'feedback', 'action' => 'index']) ?> </li>
                                <li role="separator" class="divider"></li>
                                <li> <?php echo $this->Html->link('Предметы', ['controller'=>'subjects', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Тесты', ['controller'=>'tests', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Доступ к тестам', ['controller'=>'availables', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Вопросы', ['controller'=>'questions', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Ответы', ['controller'=>'answers', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('КороткиеОтветы', ['controller'=>'shortAnswers', 'action' => 'index']) ?> </li>
                                <li role="separator" class="divider"></li>
                                <li> <?php echo $this->Html->link('Привилегии', ['controller'=>'flags', 'action' => 'index']) ?> </li>
                                <li> <?php echo $this->Html->link('Онлайн пользователи', ['controller'=>'onlineUsers', 'action' => 'index']) ?> </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <li <?php echo $this->get('active-1'); ?>>
                            <?php if($loggedIn): ?>
                                <?php echo $this->Html->link('Выход', '/logout/'); ?>
                            <?php else: ?>
                                <?php echo $this->Html->link('Вход', '/login/'); ?>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="content">
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>
    <div id="footer">
        <?php echo $this->Html->link(
            $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
            'http://cakephp.org/',
            array('escape' => false, 'id' => 'cake-powered')
        );
        ?>
    </div>
</div>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>
