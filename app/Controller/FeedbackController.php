<?php
App::uses('AppController', 'Controller');
/**
 * Feedback Controller
 *
 * @property Feedback $Feedback
 * @property PaginatorComponent $Paginator
 */
class FeedbackController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $uses = ['Feedback', 'User'];

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('send', 'get');
	}

/**
 * index method
 * @var $id - Из User
 * @return array() - Данные пользователя
 */
	public function _whoIs($id = null){
		$this->User->recursive = -1;
		$user = $this->User->find('first', ['conditions' => [
			'id' => $id
		]]);
		if(empty($user))
			return null;
		else
			return $user['User'];
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$title = 'Обратная связь';
		$this->Feedback->recursive = 0;
		$feedback = $this->Feedback->find('all');
		foreach ($feedback as $key => $one) {
			$this->User->recursive = -1;
			$temp = $this->User->find('first', ['conditions' => ['id' => $one['Feedback']['from']]]);
			$feedback[$key]['From'] = $temp['User']['name'];
			if($one['Feedback']['to']){
				$temp = $this->User->find('first', ['conditions' => ['id' => $one['Feedback']['to']]]);
				$feedback[$key]['To'] = $temp['User']['name'];
			} else {
				$feedback[$key]['To'] = 'Администрация';
			}
		}
		$this->set(compact('title', 'feedback'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function _view($id = null) {
		$title = 'Обратная связь';
		//$data = $this->User->find('all');
		if (!$this->Feedback->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$options = array('conditions' => array('Feedback.' . $this->Feedback->primaryKey => $id));
		$this->set('feedback', $this->Feedback->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function _add() {
		$title = 'Обратная связь';
		if ($this->request->is('post')) {
			$this->Feedback->create();
			if ($this->Feedback->save($this->request->data)) {
				$this->Flash->success(__('Сообщение создано.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Сообщение не может быть создано.'));
			}
		}
		$this->set(compact('title'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$title = 'Обратная связь';
		if (!$this->Feedback->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Feedback->save($this->request->data)) {
				$this->Flash->success(__('Сообщение сохранено.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Сообщение не может быть сохранено.'));
			}
		} else {
			$options = array('conditions' => array('Feedback.' . $this->Feedback->primaryKey => $id));
			$this->request->data = $this->Feedback->find('first', $options);
		}
		$this->set(compact('title'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Feedback->id = $id;
		if (!$this->Feedback->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Feedback->delete()) {
			$this->Flash->success(__('Сообщение удалено.'));
		} else {
			$this->Flash->error(__('Сообщение не может быть удалено.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function send(){
		$title = 'Обратная связь';
		$user = $this->Auth->user();
		$data = $this->request->data;
		$flag = $user['Flag']['flag'];
		$anyone = null;
		if($flag === 'admin' || $flag === 'teacher'){
			$anyone = true;

			$this->User->recursive = -1;
			$allUsers = $this->User->find('all');
			$users = null;
			foreach($allUsers as $theUser){
				$id = $theUser['User']['id'];
				$name = $theUser['User']['name'];
				$users[$id] = $name;
			}
		}

		// Очищаем
		$this->request->data = null;

		if ($this->request->is('post')) {
			// Проверка на кол-во уже отправленных
			$count = $this->Feedback->find('count', ['conditions' => [
				'from' => $user['id']
			]]);

			// Отправка
			if($count >= 100){
				$this->Flash->error(__('Вы достигли лимита по отправке сообщений.'));
			} else {
				$data['Feedback']['from'] = $user['id'];
				//Записываем
				$this->Feedback->create();
				$this->Feedback->save($data);
			}
		}
		$this->set(compact('title', 'anyone', 'users'));
	}

	public function get(){
		$title = 'Сообщения';
		$user = $this->Auth->user();
		$isMessage = null;
		$flag = $user['Flag']['flag'];

		// Проверяем что есть сообщения
		if($flag === 'admin' || $flag === 'teacher') {
			$this->Feedback->recursive = -1;
			$messages = $this->Feedback->find('all', ['conditions' => [
				'OR' => [
					['from' => $user['id']],
					['to' => $user['id']],
					'to' => null
				]
			]]);
		} else {
			$this->Feedback->recursive = -1;
			$messages = $this->Feedback->find('all', ['conditions' => [
				'OR' => [
					'from' => $user['id'],
					'to' => $user['id']
				]
			]]);
		}

		if(empty($messages))
			$isMessage = false;
		else
			$isMessage = true;

		// Расшифровка !!!
		if(!empty($isMessage)){
			foreach($messages as $key => $message){
				$userTo = $this->_whoIs($message['Feedback']['to']);
				$userFrom = $this->_whoIs($message['Feedback']['from']);
				// От кого
				if($message['Feedback']['from'] == $user['id'])
					$messages[$key]['Feedback']['from'] = 'Я';
				else
					$messages[$key]['Feedback']['from'] = $userFrom['name'];
				// Кому
				if(empty($message['Feedback']['to']))
					$messages[$key]['Feedback']['to'] = 'Администрация';
				elseif($message['Feedback']['to'] == $user['id'])
					$messages[$key]['Feedback']['to'] = 'Мне';
				else
					$messages[$key]['Feedback']['to'] = $userTo['name'];
			}
		}
		$this->set(compact('title', 'isMessage', 'messages', 'user'));
	}
}
