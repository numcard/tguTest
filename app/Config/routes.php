<?php

Router::connect('/', ['controller' => 'pages', 'action' => 'index']);
Router::connect('/reg/', ['controller' => 'users', 'action' => 'registration']);
Router::connect('/login/', ['controller' => 'users', 'action' => 'login']);
Router::connect('/login/', ['controller' => 'users', 'action' => 'login']);
Router::connect('/logout/', ['controller' => 'users', 'action' => 'logout']);
Router::connect('/logout/', ['controller' => 'users', 'action' => 'logout']);
Router::connect('/test/', ['controller' => 'pages', 'action' => 'listing']);
Router::connect('/test/choice/*', ['controller' => 'pages', 'action' => 'choice']);
Router::connect('/online/*', ['controller' => 'pages', 'action' => 'online']);
Router::connect('/finish/*', ['controller' => 'pages', 'action' => 'finish']);
Router::connect('/statistic/*', ['controller' => 'pages', 'action' => 'statistic']);
Router::connect('/statistics/', ['controller' => 'pages', 'action' => 'statistics']);
Router::connect('/feedback/', ['controller' => 'feedback', 'action' => 'send']);
Router::connect('/messages/', ['controller' => 'feedback', 'action' => 'get']);


/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
    CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
    require CAKE . 'Config' . DS . 'routes.php';
