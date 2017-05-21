<?php
App::uses('AppController', 'Controller');
/**
 * ShortAnswers Controller
 *
 * @property ShortAnswer $ShortAnswer
 * @property PaginatorComponent $Paginator
 */
class ShortAnswersController extends AppController {

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
		$title = 'КороткиеОтветы | Главная';
		$this->ShortAnswer->recursive = 0;
		$this->set('shortAnswers', $this->Paginator->paginate());
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
		$title = 'КороткиеОтветы | Просмотр';
		if (!$this->ShortAnswer->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$options = array('conditions' => array('ShortAnswer.' . $this->ShortAnswer->primaryKey => $id));
		$this->set('shortAnswer', $this->ShortAnswer->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'КороткиеОтветы | Создать';
		if ($this->request->is('post')) {
			$this->ShortAnswer->create();
			if ($this->ShortAnswer->save($this->request->data)) {
				$this->Flash->success(__('Ответы созданы.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Ответы не могут быть созданы.'));
			}
		}
		$questions = $this->ShortAnswer->Question->find('list');
		$this->set(compact('title', 'questions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$title = 'КороткиеОтветы | Редактировать';
		if (!$this->ShortAnswer->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ShortAnswer->save($this->request->data)) {
				$this->Flash->success(__('Ответы успешно сохранены.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Ответы не могут быть сохранены.'));
			}
		} else {
			$options = array('conditions' => array('ShortAnswer.' . $this->ShortAnswer->primaryKey => $id));
			$this->request->data = $this->ShortAnswer->find('first', $options);
		}
		$questions = $this->ShortAnswer->Question->find('list');
		$this->set(compact('title', 'questions'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ShortAnswer->id = $id;
		if (!$this->ShortAnswer->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ShortAnswer->delete()) {
			$this->Flash->success(__('Ответы успешно удалены.'));
		} else {
			$this->Flash->error(__('Ответы не могут быть удалены.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
