<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Поле не должно быть пустым.',
				'allowEmpty' => false,
				'required' => true,
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Поле не должно быть пустым.',
				'allowEmpty' => false,
				'required' => true,
				'last' => true,
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Введите email.',
				'allowEmpty' => false,
				'required' => true,
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'emailValidate' => array(
				'rule' => 'emailValidate',
				'message' => 'Email уже существует.'
			)
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Поле не должно быть пустым.',
				'allowEmpty' => false,
				'required' => true,
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'passwordValidate' => array(
				'rule' => 'passwordValidate',
				'message' => 'Пароли не совпадают.'
			)
		),
		'passwordConfirm' => array(
			'rule' => array('notBlank'),
			'message' => 'Поле не должно быть пустым.',
			'allowEmpty' => false,
			'required' => true,
			'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'group_id' => array(
			'rule' => array('notBlank'),
			'message' => 'Поле не должно быть пустым.',
			'allowEmpty' => true,
			'required' => false,
			'on' => 'create', // Limit validation to 'create' or 'update' operations
		)
	);

	public function passwordValidate($data){
		if($data['password'] == $this->data['User']['passwordConfirm']){
			return true;
		}
		$this->invalidate('passwordConfirm', 'Пароли не совпадают.');
		return false;
	}

	public function emailValidate($data){
		$result = $this->find('all', ['conditions' => [
			'User.email' => $data['email']
		]]);
		if(count($result) != 0)
			return false;
		return true;
	}

	public function beforeSave($options = array()) {
		if (!empty($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
		),
		'Flag' => array(
			'className' => 'Flag',
			'foreignKey' => 'flag_id',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Feedback' => array(
			'className' => 'Feedback',
			'foreignKey' => '',
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
		'OnlineTest' => array(
			'className' => 'OnlineTest',
			'foreignKey' => 'id',
			'dependent' => false,
		),
		'StatisticTest' => array(
			'className' => 'StatisticTest',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Statistic' => array(
			'className' => 'Statistic',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Subject' => array(
			'className' => 'Subject',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Test' => array(
			'className' => 'Test',
			'foreignKey' => 'user_id',
			'dependent' => false,
		)
	);

}
