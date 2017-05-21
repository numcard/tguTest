<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends AppController {

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
		$title = 'Группы | Главная';
		$this->Group->recursive = 0;
		$groups = $this->Paginator->paginate();
		$this->set(compact('title', 'groups'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function _view($id = null) {
		$title = 'Группы | Просмотр';
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->Group->recursive = -1;
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$group = $this->Group->find('first', $options);
		$this->set(compact('title', 'group'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'Группы | Добавление';
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Flash->success(__('Группа создана.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Группа не может быть создана.'));
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
		$title = 'Группы | Редакитрование';
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Flash->success(__('Группа сохранена.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Группа не может быть сохранена.'));
			}
		} else {
			$this->Group->recursive = -1;
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Group->delete()) {
			$this->Flash->success(__('Группа удалена.'));
		} else {
			$this->Flash->error(__('Группа не может быть удалена.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
