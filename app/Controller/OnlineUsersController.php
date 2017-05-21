<?php
App::uses('AppController', 'Controller');
/**
 * OnlineUsers Controller
 *
 * @property OnlineUser $OnlineUser
 * @property PaginatorComponent $Paginator
 */
class OnlineUsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->OnlineUser->recursive = 0;
		$this->set('onlineUsers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OnlineUser->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$options = array('conditions' => array('OnlineUser.' . $this->OnlineUser->primaryKey => $id));
		$this->set('onlineUser', $this->OnlineUser->find('first', $options));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OnlineUser->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OnlineUser->save($this->request->data)) {
				$this->Flash->success(__('The online user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The online user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OnlineUser.' . $this->OnlineUser->primaryKey => $id));
			$this->request->data = $this->OnlineUser->find('first', $options);
		}
		$users = $this->OnlineUser->User->find('list');
		$tests = $this->OnlineUser->Test->find('list');
		$this->set(compact('users', 'tests'));
	}
}
