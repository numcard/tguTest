<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $components = ['Paginator'];
	public $uses = ['User', 'Group', 'Flag'];

	public function beforeFilter(){
		$this->Auth->allow('registration', 'login', 'logout');
	}

	public function index() {
		$title = 'Пользователи | Главная';
		$this->User->recursive = 0;
		$users = $this->Paginator->paginate();
		$this->set(compact('title', 'users'));
	}

	public function registration(){
		$title = 'Регистрация';
		$groups = $this->User->Group->find('list');
		if ($this->request->is('post'))
		{
			$this->User->create();
			if ($this->User->save($this->request->data))
			{
				$this->Flash->success(__('Вы успешно зарегистрированны.'));
				$this->redirect('/login/');
			} else
			{
				$this->Flash->error(__('Ошибка регистрации.'));
			}
		}
		$this->set(compact('title', 'groups'));
	}

	public function login(){
		$title = 'Авторизация';
		if ($this->request->is('post')) {
			if($this->Auth->login()){
				$this->redirect($this->Auth->redirectUrl());
				unset($this->request->data['User']['password']);
			} else {
				$this->Flash->error(__('Неверная почта или пароль.'));
			}
		}
		$this->set(['title' => $title, 'active-1' => 'class="active"']);
	}

	public function logout(){
		$this->redirect($this->Auth->logout());
	}

	public function view($id = null) {
		$title = 'Пользователи | Просмотр';

		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->User->unbindModel([
			'hasMany' => ['Feedback', 'OnlineTest', 'StatisticTest', 'Statistic', 'Subject', 'Test']
		]);
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$user = $this->User->find('first', $options);
		$this->set(compact('title', 'user'));
	}

	public function add() {
		$title = 'Пользователи | Добавление';
		$flags = $this->User->Flag->find('list');
		$groups = $this->User->Group->find('list');
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('Пользователь создан.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Пользователь не может быть создан.'));
			}
		}
		$this->set(compact('title','flags', 'groups'));
	}

	public function edit($id = null) { 
		$title = 'Пользователи | Редактирование';
		$flags = $this->User->Flag->find('list');
		$groups = $this->User->Group->find('list');
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Пользователь не найден.'));
		}
		if ($this->request->is(array('post', 'put'))) { 
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('Пользователь сохранен.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Пользователь не может быть сохранен.'));
			}
		} else {
			$this->User->recursive = -1;
			$this->request->data = $this->User->find('first', ['conditions' => [
				'User.id' => $id
			]]);
		}
		$this->set(compact('title','flags', 'groups'));
	}

	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Пользователь не найден.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Flash->success(__('Пользователь удален.'));
		} else {
			$this->Flash->error(__('Пользователь не может быть удален.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
