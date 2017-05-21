<?php
App::uses('AppModel', 'Model');
/**
 * Test Model
 *
 * @property Subject $Subject
 * @property User $User
 * @property Answer $Answer
 * @property Question $Question
 * @property ShortAnswer $ShortAnswer
 * @property Statistic $Statistic
 */
class Test extends AppModel {

	public $displayField = 'test';
	public $order = ["Test.test" => "asc"];

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'test' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Заполните поле.',
				'allowEmpty' => false,
				'required' => false,
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'subject_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Заполните поле.',
				'allowEmpty' => false,
				'required' => false,
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'questionFile' => array(
			'isUploadedFile' => array(
				'rule' => array('isUploadedFile'),
				'message' => 'Файл с вопросами не загружен.'
			)
		),
		'answerFile' => array(
			'isUploadedFile' => array(
				'rule' => array('isUploadedFile'),
				'message' => 'Файл с ответами не загружен.'
			),
			'testValidate' => array(
				'rule' => array('testValidate'),
				'message' => 'Ошибка в фале с ответами.'
			)
		)
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed
	public function isUploadedFile($params){
		$val = array_shift($params);
		if ((isset($val['error']) && $val['error'] == 0) ||
			(!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')
		) {
			return is_uploaded_file($val['tmp_name']);
		}
		return false;
	}

	public function testValidate($params)
	{
		$questionFile = $this->data['Test']['questionFile'];
		$answerFile = $this->data['Test']['answerFile'];
		if (!file_exists($questionFile['tmp_name']))
			return 'Файл с вопросами не загружен.';
		if (!file_exists($answerFile['tmp_name']))
			return 'Файл с ответами не загружен.';
		$questionData = file_get_contents($questionFile['tmp_name']);
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
			// Если ничего не нашел, то это ошибка
			if (count($found1) == 0 && count($found2) == 0) {
				$error = "Не найден ни вопрос, ни ответ в файле с вопросам.	"
					. "Номер строки: " . ($key + 1) . '.';
				$this->invalidate('questionFile', $error);
				return 'Ошибка в файле с вопросами.';
			}
			// Записываем строчки из файлов
			$allData[$counter][] = $row;
		}
		//Проверка на валидность файла с ответами
		$temp = file_get_contents($answerFile['tmp_name']);
		$rows = explode("\n", $temp);
		$answerData = [];
		foreach ($rows as $key => $row) {
			// Разбиваем
			$parts = explode("\t", $row);
			if(count($parts) > 2) {
				$error = "Найден лишний знак табуляции в файле с ответами.	"
					."Номер строки: " . ($key + 1) . ".";
				return $error;
			}
			if(count($parts) == 1) {
				$error = "Не найден знак табуляции в файле с ответами.	"
					."Номер строки: " . ($key + 1) . ".";
				return $error;
			}
			// Ищем номер вопроса в строке
			preg_match("@\d+\)@", $parts[0], $found);
			if (empty($found)) {
				$error = "Не найден номер вопроса с разделителем ')' в файле с ответами.	"
					."Номер строки: " . ($key + 1) . ".";
				return $error;
			}
			preg_match("@\d+@", $found[0], $found);
			if (empty($found)) {
				$error = "Не найден номер вопроса в файле с ответами.	"
					."Номер строки: " . ($key + 1) . ".";
				return $error;
			}
			// Записываем в первую часть массива номер вопроса
			$parts[0] = $found[0];
			// Убираем лишнии символы с ответы
			$parts[1] = trim($parts[1]);
			// Записываем строчку
			$answerData[] = $parts;
		}
		// Проверка
		if (count($allData) <> count($answerData)) {
			$error = "Количество вопросов и ответов разное! " . count($allData) . "/" . count($answerData);
			$this->invalidate('questionFile', $error);
			return $error;
		}
		return true;
	}
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Answer' => array(
			'className' => 'Answer',
			'foreignKey' => 'test_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'test_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShortAnswer' => array(
			'className' => 'ShortAnswer',
			'foreignKey' => 'test_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Statistic' => array(
			'className' => 'Statistic',
			'foreignKey' => 'test_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
