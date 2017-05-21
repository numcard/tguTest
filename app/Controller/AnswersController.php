<?php
App::uses('AppController', 'Controller');
/**
 * Answers Controller
 *
 * @property Answer $Answer
 * @property PaginatorComponent $Paginator
 */
class AnswersController extends AppController {

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
		$title = 'Ответы | Главная';
		$this->Answer->recursive = 0;
		$this->set('answers', $this->Paginator->paginate());
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
		$title = 'Ответы | Просмотр';
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
		$this->set('answer', $this->Answer->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'Ответы | Создать';
		if ($this->request->is('post')) {
			$this->Answer->create();
			if ($this->Answer->save($this->request->data)) {
				$this->Flash->success(__('Ответ создан.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Ответ не может быть создан.'));
			}
		}
		$questions = $this->Answer->Question->find('list');
		$tests = $this->Answer->Test->find('list');
		$this->set(compact('title', 'questions', 'tests'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$title = 'Ответы | Редактировать';
		if (!$this->Answer->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Answer->save($this->request->data)) {
				$this->Flash->success(__('Ответ сохранен.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Ответ не может быть сохранен.'));
			}
		} else {
			$options = array('conditions' => array('Answer.' . $this->Answer->primaryKey => $id));
			$this->request->data = $this->Answer->find('first', $options);
		}
		$questions = $this->Answer->Question->find('list');
		$tests = $this->Answer->Test->find('list');
		$this->set(compact('title', 'questions', 'tests'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Answer->id = $id;
		if (!$this->Answer->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Answer->delete()) {
			$this->Flash->success(__('Ответ удален.'));
		} else {
			$this->Flash->error(__('Ответ не может быть удален.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
