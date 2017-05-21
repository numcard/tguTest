<?php
App::uses('AppController', 'Controller');
/**
 * Statistics Controller
 *
 * @property Statistic $Statistic
 * @property PaginatorComponent $Paginator
 */
class StatisticsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $uses = ['Statistic', 'Available'];

/**
 * index method
 *
 * @return void
 */
	public function index($id = null) {
		$request = $this->request->is('post');
		$available = $this->Available->find('all');
		$availableGroup = [];
		$availableList = [];
		foreach($available as $one){
			$availableGroup[] = $one['Available']['group_id'];
		}
		$availableGroup = array_unique($availableGroup);
		foreach($available as $one){
			foreach($availableGroup as $group){
				if($one['Available']['group_id'] == $group){
					$nameGroup = $one['Group']['name'];
					$nameTest = $one['Test']['test'];
					$availableList[$nameGroup][$nameTest] = $one['Available']['id'];
				}
			}
		}
		$this->set(compact('availableList'));

		if($request)
			$this->redirect('/statistics/index/'.$this->request->data['Available'], 200);

		if ($id) {
			$available = $this->Available->find('first', ['conditions' => ['Available.id' => $id]]);
			$this->Statistic->recursive = 0;
			$statistic = $this->Statistic->find('all', [
				'conditions' => [
					'Statistic.test_id' => $available['Available']['test_id'],
					'Statistic.group_id' => $available['Available']['group_id']
				]]);
			$this->set(compact('available', 'statistic', 'id'));
		}
		$title = 'Статистика | Главная';
		$this->set(compact('title'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function _view($id = null) {
		$title = 'Статистика | Показать';
		if (!$this->Statistic->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->Statistic->unbindModel([
			'hasMany' => 'StatisticTest'
		]);
		$options = array('conditions' => array('Statistic.' . $this->Statistic->primaryKey => $id));
		$this->set('statistic', $this->Statistic->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function _add() {
		$title = 'Статистика | Создать';
		if ($this->request->is('post')) {
			$this->Statistic->create();
			if ($this->Statistic->save($this->request->data)) {
				$this->Flash->success(__('Статистика успешно создана.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Статистика не может быть создана.'));
			}
		}
		$tests = $this->Statistic->Test->find('list');
		$users = $this->Statistic->User->find('list');
		$this->set(compact('title', 'tests', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function _edit($id = null) {
		$title = 'Статистика | Редактировать';
		$tests = $this->Statistic->Test->find('list');
		$users = $this->Statistic->User->find('list');
		$groups = $this->Statistic->Group->find('list');
		if (!$this->Statistic->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Statistic->save($this->request->data)) {
				$this->Flash->success(__('Статистика успешно сохранена.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Статистика не может быть сохранена.'));
			}
		} else {
			$this->Statistic->unbindModel([
				'hasMany' => 'StatisticTest'
			]);
			$options = array('conditions' => array('Statistic.' . $this->Statistic->primaryKey => $id));
			$this->request->data = $this->Statistic->find('first', $options);
		}
		$this->set(compact('title', 'tests', 'users', 'groups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function _delete($id = null) {
		$this->Statistic->id = $id;
		if (!$this->Statistic->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Statistic->delete()) {
			$this->Flash->success(__('Статистика успешно удалена.'));
		} else {
			$this->Flash->error(__('Статистика не может быть удалена.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
