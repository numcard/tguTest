<?php
App::uses('AppController', 'Controller');
/**
 * Flags Controller
 *
 * @property Flag $Flag
 * @property PaginatorComponent $Paginator
 */
class FlagsController extends AppController {

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
		$title = 'Привилегии | Главная';
		$flags = $this->Paginator->paginate();
		$this->Flag->recursive = 0;
		$this->set(compact('title', 'flags'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$title = 'Привилегии | Просмотр';
		if (!$this->Flag->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$options = array('conditions' => array('Flag.' . $this->Flag->primaryKey => $id));
		$flag = $this->Flag->find('first', $options);
		$this->set(compact('title', 'flag'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'Привилегии | Создание';
		if ($this->request->is('post')) {
			$this->Flag->create();
			if ($this->Flag->save($this->request->data)) {
				$this->Flash->success(__('Привилегия создана.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Привилегия не может быть создана.'));
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
		$title = 'Привилегии | Редактирование';
		if (!$this->Flag->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Flag->save($this->request->data)) {
				$this->Flash->success(__('Привилегия сохранена.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Ошибка сохранения привилегии.'));
			}
		} else {
			$options = array('conditions' => array('Flag.' . $this->Flag->primaryKey => $id));
			$this->request->data = $this->Flag->find('first', $options);
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
	public function _delete($id = null) {
		$this->Flag->id = $id;
		if (!$this->Flag->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Flag->delete()) {
			$this->Flash->success(__('Привилегия удалена.'));
		} else {
			$this->Flash->error(__('Ошибка удаления привилегии.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
