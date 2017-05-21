<?php
App::uses('AppController', 'Controller');
/**
 * Questions Controller
 *
 * @property Question $Question
 * @property PaginatorComponent $Paginator
 */
class QuestionsController extends AppController {

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
		$title = 'Вопросы | Главная';
		$this->Question->recursive = 0;
		$this->set('questions', $this->Paginator->paginate());
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
		$title = 'Вопросы | Показать';
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
		$this->set('question', $this->Question->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'Вопросы | Создать';
		if ($this->request->is('post')) {
			$this->Question->create();
			if ($this->Question->save($this->request->data)) {
				$this->Flash->success(__('Вопрос успешно создан.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Ошибка создания вопроса.'));
			}
		}
		$tests = $this->Question->Test->find('list');
		$subjects = $this->Question->Subject->find('list');
		$this->set(compact('title', 'tests', 'subjects'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$title = 'Вопросы | Редактировать';
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Question->save($this->request->data)) {
				$this->Flash->success(__('Вопрос сохранен.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Вопрос не может быть сохранен.'));
			}
		} else {
			$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
			$this->request->data = $this->Question->find('first', $options);
		}
		$tests = $this->Question->Test->find('list');
		$subjects = $this->Question->Subject->find('list');
		$this->set(compact('title', 'tests', 'subjects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Question->id = $id;
		if (!$this->Question->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Question->delete()) {
			$this->Flash->success(__('Вопрос удален.'));
		} else {
			$this->Flash->error(__('Вопрос не может быть удален.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
