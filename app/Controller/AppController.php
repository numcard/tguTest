<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = [
        //'DebugKit.Toolbar',
        'Session',
        'Auth' => [
            'loginAction' => [
                'controller' => 'users',
                'action' => 'login/',
                //'plugin' => 'users'
            ],
            'loginRedirect' => ['controller' => 'pages', 'action' => 'index'],
            'logoutRedirect' => ['controller' => 'pages', 'action' => 'index'],
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => [
                'Form' => [
                    'passwordHasher' => [
                        'className' => 'Simple',
                        'hashType' => 'sha256'
                    ],
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ],
            'authorize' => 'Controller'
        ],
        'Flash'];

    public $helpers = ['Html', 'Form', 'Flash'];

    public $uses = ['User', 'Feedback'];

    public function isAuthorized($user = null){
        // Admin can access every action
        $flag = $user['Flag']['flag'];
        if($flag === 'admin' || $flag === 'teacher')
            return true;
        // Default deny
        $this->Flash->error(__('У вас недостаточно прав, для выполнения этого действия.'));
        return false;
    }

    public function beforeRender()
    {
        // Счетчик сообщений
        $user = $this->Auth->user();
        if(!empty($user)){
            $flag = $user['Flag']['flag'];
            $this->User->recursive = -1;
            if($flag === 'admin' || $flag === 'teacher') {
                $userCount = $this->Feedback->find('count', ['conditions' => [
                    'OR' => [
                        ['from' => $user['id']],
                        ['to' => $user['id']],
                        'to' => null
                    ]
                ]]);
            } else {
                $userCount = $this->Feedback->find('count', ['conditions' => [
                    'OR' => [
                        'from' => $user['id'],
                        'to' => $user['id']
                    ]
                ]]);
            }
            $this->set(compact('userCount'));
        }

        $this->set([
            'currentUser' => $this->Auth->user(),
            'loggedIn' => (bool) $this->Auth->user()
        ]);
    }

}
