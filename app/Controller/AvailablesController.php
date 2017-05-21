<?php
App::uses('AppController', 'Controller');
/**
 * Availables Controller
 *
 * @property Available $Available
 * @property PaginatorComponent $Paginator
 */
class AvailablesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index methodК
 *
 * @return void
 */
	public function index() {
		$title = 'Доступ к тестам | Главная';
		$this->Available->recursive = 0;
		$this->set('availables', $this->Paginator->paginate());
		$this->set(compact('title'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$title = 'Доступ к тестам | Просмотр';
		if (!$this->Available->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$options = array('conditions' => array('Available.' . $this->Available->primaryKey => $id));
		$this->set('available', $this->Available->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'Доступ к тестам | Создать';
		if ($this->request->is('post')) {
			$this->Available->create();
			if ($this->Available->save($this->request->data)) {
				$this->Flash->success(__('Доступ к тесту успешно создан.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Доступ к тесту не может быть создан.'));
			}
		}
		$groups = $this->Available->Group->find('list');
		$tests = $this->Available->Test->find('list');
		$this->set(compact('title', 'groups', 'tests'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$title = 'Доступ к тестам | Редактировать';
		if (!$this->Available->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Available->save($this->request->data)) {
				$this->Flash->success(__('Доступ к тесту успешно сохранен.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Доступ к тесту не может быть сохранен.'));
			}
		} else {
			$options = array('conditions' => array('Available.' . $this->Available->primaryKey => $id));
			$this->request->data = $this->Available->find('first', $options);
		}
		$groups = $this->Available->Group->find('list');
		$tests = $this->Available->Test->find('list');
		$this->set(compact('title', 'groups', 'tests'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Available->id = $id;
		if (!$this->Available->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Available->delete()) {
			$this->Flash->success(__('Доступ к тесту удален.'));
		} else {
			$this->Flash->error(__('Доступ к тесту не может быть удален.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
