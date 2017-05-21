<?php
App::uses('AppController', 'Controller');
/**
 * Tests Controller
 *
 * @property Test $Test
 * @property PaginatorComponent $Paginator
 */
class TestsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = ['Test', 'Question', 'Answer', 'ShortAnswer'];
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$title = 'Тесты | Главная';
		$this->Test->recursive = 0;
		$tests = $this->Paginator->paginate();
		$this->set(compact('title', 'tests'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$title = 'Тесты | Просмотр';
		if (!$this->Test->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->Test->unbindModel([
			'hasMany' => ['Answer', 'Question', 'ShortAnswer', 'Statistic']
		]);
		$options = array('conditions' => array('Test.' . $this->Test->primaryKey => $id));
		$this->set('test', $this->Test->find('first', $options));
		$this->set(compact('title'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$title = 'Тесты | Создание';
		$subjects = $this->Test->Subject->find('list');
		$currentUser = $this->Auth->user();
		if ($this->request->is('post')) {
			$this->Test->create();
			// Если тест записался записываем ответы и вопросы
			if ($this->Test->save($this->request->data)) {
				$test_id = $this->Test->id;
				$subject_id = $this->request->data['Test']['subject_id'];
				$questionFile = $this->request->data['Test']['questionFile']['tmp_name'];
				$answerFile = $this->request->data['Test']['answerFile']['tmp_name'];
				// Обрабатываем файл с вопросами
				$questionData = file_get_contents($questionFile);
				$questionData = htmlspecialchars($questionData, ENT_QUOTES, 'UTF-8');
				$questionData = htmlspecialchars($questionData, ENT_HTML5, 'UTF-8');
				$rows = explode("\n", $questionData);
				$allData = [];
				$counter = 0;
				// Записываем данные из файла в массив
				foreach ($rows as $key => $row) {
					$row = trim($row);
					// Пропускаем пустые строки '\n'
					if (strlen($row) == 0)
						continue;
					// Ищет вопросы
					preg_match('@\d+\.\t@', $row, $found1);
					// Ищет ответы
					preg_match('@\d+\)\t@', $row, $found2);
					// Найден ответ, счетчик++
					if (count($found1) == 1 && count($found2) == 0) {
						$counter++;
					}
					// Записываем строчки из файлов
					$allData[$counter][] = $row;
				}
				//Проверка на валидность файла с ответами
				$temp = file_get_contents($answerFile);
				$rows = explode("\n", $temp);
				$answerData = [];
				$counter = 0;
				foreach ($rows as $key => $row) {
					$counter++;
					// Разбиваем
					$parts = explode("\t", $row);
					// Ищем номер вопроса в строке
					preg_match("@\d+\)@", $parts[0], $found);
					preg_match("@\d+@", $found[0], $found);
					// Записываем в первую часть массива номер вопроса
					$parts[0] = (int)$found[0];
					// Убираем лишнии символы с ответы
					$parts[1] = trim($parts[1]);
					// Записываем строчку
					$answerData[$counter] = $parts;
				}
				// Записываем вопросы и ответы
				foreach ($allData as $firstKey => $data) {
					// Создаем модельки для записи
					$this->Question->create();
					$this->ShortAnswer->create();
					// Цикл для каждого ответа
					foreach ($data as $secondKey => $el) {
						// Сохраняем вопрос и короткий ответ
						if ($secondKey == 0) {
							preg_match("@\d+\.\t@", $el, $found);
							// Получаем чистый вопрос без цифры
							$question = substr($el, strlen($found[0]));
							$question = trim($question);
							// Записываем вопрос
							$query = [
								'IDquestion' => $firstKey,
								'question' => $question,
								'test_id' => $test_id,
								'subject_id' => $subject_id,
							];
							$this->Question->save($query);
							// Записываем короткий ответ
							$query = [
								'question_id' => $this->Question->id,
								'answers' => trim($answerData[$firstKey][1]),
								'test_id' => $test_id
							];
							$this->ShortAnswer->save($query);
							// После записи вопроса и короткого ответа прыгаем на ответы
							continue;
						}
						// Создаем модель для записи ответов
						$this->Answer->create();
						// Сохраняем ответ
						// Получили ответ и его номер из файла с вопросами
						// Ответ
						preg_match("@\d+\)\t@", $el, $found);
						$answer = substr($el, strlen($found[0]));
						// Номер
						preg_match("@\d+@", $el, $found);
						$numberOfAnswer = $found[0];
						// Получаем ответы из файла с ответами
						$answers = $answerData[$firstKey];
						// Если ключи вопросов совпадают из файла с вопросами и ответами
						if($answers[0] === $firstKey){
							$param = "@".$numberOfAnswer."@";
							preg_match($param, $answers[1], $found);
							if(count($found) === 1){
								$query = [
									'question_id' => $this->Question->id,
									'answerID' => $secondKey,
									'answer' => $answer,
									'is_answer' => 1,
									'test_id' => $test_id
								];
							} elseif (count($found) === 0){
								$query = [
									'question_id' => $this->Question->id,
									'answerID' => $secondKey,
									'answer' => $answer,
									'is_answer' => 0,
									'test_id' => $test_id
								];
							} else {
								$this->Flash->error(__('В ответах найдены повторяющиеся значения. Номер ответа: '.$firstKey));
								break 2;
							}
							$this->Answer->save($query);
						} else {
							$this->Flash->error(__('Ошибки при записи теста. В файле с ответами пропущен ответ. Номер ответа: '.$firstKey));
							break 2;
						}
					}
				}
				$this->Flash->success(__('Тест успешно создан.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Тест не может быть сохранен.'));
			}
		}
		$this->set(compact('title', 'subjects', 'currentUser'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$title = 'Тесты | Редактировать';
		if (!$this->Test->exists($id)) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Test->save($this->request->data)) {
				$this->Flash->success(__('Тест сохранен.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Тест не может быть сохранен.'));
			}
		} else {
			$this->Test->unbindModel([
				'hasMany' => ['Answer', 'Question', 'ShortAnswer', 'Statistic']
			]);
			$options = array('conditions' => array('Test.' . $this->Test->primaryKey => $id));
			$this->request->data = $this->Test->find('first', $options);
		}
		$subjects = $this->Test->Subject->find('list');
		$this->set(compact('title', 'subjects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Test->id = $id;
		if (!$this->Test->exists()) {
			throw new NotFoundException(__('Страница не найдена.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Test->delete()) {
			$this->Flash->success(__('Тест удален.'));
		} else {
			$this->Flash->error(__('Тест не может быть удален.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
