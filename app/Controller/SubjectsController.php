<?php
App::uses('AppController', 'Controller');
/**
 * Subjects Controller
 *
 * @property Subject $Subject
 * @property PaginatorComponent $Paginator
 */
class SubjectsController extends AppController {

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
		$title = 'Предметы | Главная';
		$this->Subject->recursive = 0;
		$subjects = $this->Paginator->paginate();
		$this->set(compact('title', 'subjects'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$title = 'Предметы | Показать';
		if (!$this->Subject->exists($id)) {
			throw new NotFoundException(__('Предмет не найден.'));
		}
		$this->Subject->unbindModel([
			'hasMany' => ['Test', 'Question']
		]);
		$options = array('conditions' => array('Subject.' . $this->Subject->primaryKey => $id));
		$this->set('subject', $this->Subject->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'Предметы | Создать';
		$user = $this->Auth->user();
		if ($this->request->is('post')) {
			if($user['Flag']['flag'] == 'admin' || $user['Flag']['flag'] == 'teacher'){
				$this->request->data['Subject']['user_id'] = $user['id'];
				if ($this->Subject->save($this->request->data)) {
					$this->Flash->success(__('Предмет создан.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('Предмет не может быть создан.'));
				}
			} else {
				$this->Flash->error(__('У вас недостаточно прав для выполнения операции.'));
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
		$title = 'Предметы | Редактировать';
		if (!$this->Subject->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Subject->save($this->request->data)) {
				$this->Flash->success(__('Предмет сохранен.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Предмет не может быть сохранен.'));
			}
		} else {
			$this->Subject->unbindModel([
				'hasMany' => ['Test', 'Question']
			]);
			$options = array('conditions' => array('Subject.' . $this->Subject->primaryKey => $id));
			$this->request->data = $this->Subject->find('first', $options);
		}
		$users = $this->Subject->User->find('list');
		$this->set(compact('title', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Subject->id = $id;
		if (!$this->Subject->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Subject->delete()) {
			$this->Flash->success(__('Предмет удален.'));
		} else {
			$this->Flash->error(__('Предмет не может быть удален.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
