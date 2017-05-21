<?php
App::uses('AppController', 'Controller');

class PagesController extends AppController {

    public $helpers = ['Html'];

    public $uses = ['Test', 'Available', 'Subject', 'OnlineUser', 'OnlineTest', 'Question', 'ShortAnswer', 'Statistic', 'StatisticTest'];

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    public function isAuthorized($user = null) {
        // All registered users can add posts
        if (in_array($this->action, ['index', 'listing', 'choice', 'create', 'online', 'finish', 'statistic', 'statistics'])) {
            return true;
        }
        return parent::isAuthorized($user);
    }

/**
 * _cmp method
 * Использьзуется для сравнения 2 величин
 * @return int -1, 1
 */
    function _cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

/**
 * index action
 * Главная страница сайта
 * @var $id - ID из online_users
 * @return true or false
 */
    public function _isFinished($id = null){
        $user = $this->Auth->user();
        $this->OnlineUser->recursive = -1;
        $data = $this->OnlineUser->find('first', ['conditions' => [
            'id' => $id
        ]]);
        $completedTime = strtotime($data['OnlineUser']['completed']);
        if($completedTime < time())
            return true;
        else
            return false;
    }

/**
 * _userAvailableTests method
 * Возвращает доступные пользователю тестовые задания с учетом попыток
 * Таблицы: Available, Test, Subject
 * @return null - Если нету доступных тестов
 * @return array() - Тем у кого нету группы вернет все возможные тесты
 * @return array() - Пользователю с группой вернет его задания
 */
    public function _userAvailableTests() {
        $user = $this->Auth->user();
        // Данные из таблицы Available по группам
        $allAvailableTests = null;
        // Данные из таблицы Statistic по пользователю
        $statisticTests = null;
        // Отфильтрованные по дате
        $availableTests = null;
        // Отифильтрованные по группам
        $userAvailableTests = null;

        // Доступные тесты
        if(empty($user['group_id'])) {
            $this->Available->recursive = -1;
            $allAvailableTests = $this->Available->find('all');
        } else {
            $this->Available->recursive = -1;
            $allAvailableTests = $this->Available->find('all', ['conditions' => [
                'group_id' => $user['group_id']
            ], 'order' => 'Available.test_id'
			]);
        }

        // Если доступных тестов нет
        if(empty($allAvailableTests))
            return null;

        // Статистика по тестам которые уже проходил пользователь
        if($user['Flag']['flag'] == 'regular'){
            $this->Statistic->recursive = -1;
            $statisticTests = $this->Statistic->find('all', ['conditions' => [
                'user_id' => $user['id']
            ]]);
        }

        // Если пользователь уже проходил, то попытка --;
        if(!empty($statisticTests)){
            foreach ($statisticTests as $item) {
                foreach($allAvailableTests as $key => $test){
                    if($item['Statistic']['test_id'] == $test['Available']['test_id'])
                        $allAvailableTests[$key]['Available']['testTries'] -= 1;
                }
            }
        }

        // Удаляем уже пройденные если число попыток == 0
        foreach($allAvailableTests as $key => $test){
            if($test['Available']['testTries'] == 0)
                unset($allAvailableTests[$key]);
        }

        // Смотрим дату и дописываем предмет
        foreach($allAvailableTests as $key => $test){
            $timeBefore = strtotime($test['Available']['before']);
            // Просроченный
            if($timeBefore < time())
                continue;

            $this->Test->recursive = 1;
            $this->Test->unbindModel([
                'belongsTo' => ['User'],
                'hasMany' => ['Answer', 'Question', 'ShortAnswer', 'Statistic']
            ]);
            $availableTest = $this->Test->find('first', ['conditions' => [
                'Test.id' => $test['Available']['test_id']]
            ]);

            $availableTests[] = [
                'Available' => $test['Available'],
                'Test' => $availableTest['Test'],
                'Subject' => $availableTest['Subject']
            ];
        }

        // Если доступных тестов нет
        if(empty($availableTests))
            return null;

        // Если нету группы
        if(empty($user['group_id'])) {
            return $availableTests;
        } else {
            // Сортировка по-группам
            foreach($availableTests as $test){
                if($test['Available']['group_id'] == $user['group_id'])
                    $userAvailableTests[] = $test;
            }
        }

        // Если доступных тестов нет
        if(empty($userAvailableTests))
            return null;

        return $userAvailableTests;
    }

/**
 * _userTest method
 * Возвращает выбранный пользователем тест
 * @variable $id - ID тестового задания
 * Таблицы: Available, Test, Subject
 * @return null - Тест недоступен
 * @return array() - Тем у кого нету группы вернет все возможные тесты
 * @return array() - Пользователю с группой вернет его задания
 */
    public function _userTest($id) {
        $availableTests = $this->_userAvailableTests();

        // Доступных тестов нету
        if(empty($availableTests))
            return null;

        // Проверка что тест присутствует
        foreach($availableTests as $test){
            if($test['Available']['test_id'] == $id){
                return $test;
            }
        }

        // Тест не найден
        return null;
    }

/**
 * _addAnswer method
 * Записываем ответ пользователя и возвращает следующий вопрос
 * @val $request - Данные на добавление
 * @return void
 */
    public function _addAnswer($request){
        $id = $request['Page']['id'];
        $questionID = $request['Page']['questionID'];
        // Один ответ
        $userAnswer = null;
        // Несколько ответов
        $userAnswers = null;
        $isRight = null;

        $this->OnlineTest->recursive = -1;
        $questionData = $this->OnlineTest->find('first', ['conditions' => [
            'questionID' => $questionID,
            'onlineUser_id' => $id
        ]]);
        $question_id = $questionData['OnlineTest']['question_id'];

        // Один ответ
        if(isset($request['answer'])){
            $userAnswer = $request['answer'];
            // По ID вопроса получаем ответ и сам вопрос
            $this->ShortAnswer->recursive = 1;
            $shortAnswer = $this->ShortAnswer->find('first', ['conditions' => ['Question.id' => $question_id]]);

            $isRight = ($userAnswer == $shortAnswer['ShortAnswer']['answers']) ? 1 : 2;
        } else {
            // Несколько ответов
            // По ID вопроса получаем ответ и сам вопрос
            $this->ShortAnswer->recursive = -1;
            $shortAnswer = $this->ShortAnswer->find('first', ['conditions' => ['question_id' => $question_id]]);

            $userAnswers = [];
            // Получаем ответы из текущего вопроса
            foreach($request as $item){
                if(is_array($item))
                    continue;
                // Записываем массив ответов
                $userAnswers[] = $item;
            }
            // Сортируем ответы по порядку
            uasort($userAnswers, [$this, '_cmp']);
            // В строку
            $userAnswers = implode(",", $userAnswers);

            // Проверка на ответы
            $isRight = ($userAnswers == $shortAnswer['ShortAnswer']['answers']) ? 1 : 2;
        }

        $answer = (empty($userAnswer)) ? $userAnswers : $userAnswer;
        if($answer === '')
            $this->redirect('/online/'.$id.'/'.$questionID, 200);
        $answer = "'" . $answer . "'";
        $this->OnlineTest->unbindModel(['belongsTo' => ['Test', 'User', 'Question']]);
        $this->OnlineTest->updateAll([
            'answer' => $answer,
            'is_right' => $isRight
        ], [
            'questionID' => $questionID,
            'onlineUser_id' => $id,
        ]);
        $this->redirect('/online/'.$id, 200);
    }

/**
 * index action
 * Главная страница сайта
 * @return void
 */
    public function index() {
        $this->set(['title'=>'Главная', 'active1'=>'class="active"']);
        $this->render("index");    
    }

/**
 * listing action
 * Список доступных для прохождения тестовых заданий
 * @return void
 */
    public function listing() {
        $title = 'Доступные тесты';
        $userAvailableTests = $this->_userAvailableTests();
        $this->set(compact('title', 'userAvailableTests'));
        $this->set(['active2'=>'class="active"']);
    }

/**
 * choice action
 * Подтверждение выбранного задания пользователем
 * @var $test_id - ID теста
 * @return void
 */
    public function choice($test_id = null) {
        $test_id = ($test_id) ? (int)$test_id : null;
        $title = 'Выбор теста';
        $user = $this->Auth->user();

        // Существование теста
        if (!$this->Test->exists($test_id)) {
            $this->Flash->error(__('Такого теста не существует.'));
            $this->redirect('/test/'.$test_id, 404);
        }

        // Если тест уже проходится перекидываем
        $this->OnlineUser->recursive = -1;
        $onlineTest = $this->OnlineUser->find('first', ['conditions' => [
            'user_id' => $user['id'],
            'test_id' => $test_id
        ]]);

        // Если тест есть перекидываем
        if(!empty($onlineTest)){
            $this->redirect('/online/'.$onlineTest['OnlineUser']['id'], 200);
        }

        // Данные для теста
        $userTest = $this->_userTest($test_id);
        if(empty($userTest)){
            $this->Flash->error(__('Теста не существует.'));
            $this->redirect('/test/'.$test_id, 404);
        }
        $this->set(compact('title', 'userTest'));
        $this->set(['active2'=>'class="active"']);
    }

/**
 * create action
 * Создание тестового задания пользователю
 * @return void
 */
    public function create(){
        $user = $this->Auth->user();
        $available_id = (empty($this->request->data['Page']['available_id'])) ? null : $this->request->data['Page']['available_id'];
        $isAvailable = null;

        // Проверка что был запрос на создание
        if(!$this->request->is('post')){
            throw new NotFoundException(__('Страница не найдена.'));
        }

        // Проверяем доступен ли тест пользователю
        $userAvailableTests = $this->_userAvailableTests();
        foreach ($userAvailableTests as $test) {
            if($test['Available']['id'] == $available_id){
                $isAvailable = true;
                break;
            }
        }
        if (empty($isAvailable)){
            $this->Flash->error(__('Тест недоступен для прохождения.'));
            $this->redirect('/test/', 404);
        }

        // Получили данные
        $this->Available->recursive = 2;
        $this->Available->unbindModel([
            'belongsTo' => ['Group'],
            'hasMany' => ['User']
        ]);
        $this->Test->unbindModel([
            'belongsTo' => ['User'],
            'hasMany' => ['Answer', 'ShortAnswer', 'Statistic']
        ]);
        $availableData = $this->Available->find('first', ['conditions' => [
            'Available.id' => $available_id
        ]]);

        // Объявление переменных
        $questions = $availableData['Test']['Question'];
        $testMinutes = $availableData['Available']['testMinutes'];
        $testQuestions = $availableData['Available']['testQuestions'];
        $test_id = $availableData['Available']['test_id'];
		

        // Записываем в online_users
        $this->OnlineUser->create();
        $created = date('Y-m-d H:i:s', time());
        $completed = time() + $testMinutes * 60;
        $completed = date('Y-m-d H:i:s', $completed);
        $this->OnlineUser->save([
            'user_id' => $user['id'],
            'test_id' => $test_id,
            'created' => $created,
            'completed' => $completed
        ]);

        // Перемешываем
        shuffle($questions);

        // Записываем в online_test
        for($i = 1; $i <= $testQuestions; $i++){
            $this->OnlineTest->create();
            $this->OnlineTest->save([
                'questionID' => $i,
                'question_id' => $questions[$i-1]['id'],
                'onlineUser_id' => $this->OnlineUser->id
            ]);
        }

        $this->redirect('/online/'.$this->OnlineUser->id, 200);
    }

/**
 * online action
 * Отвечает за прохождение тестового задания
 * @var $id - online_ID в таблице online_users
 * @var $questionID - Выбранный пользователем вопрос
 * @return void
 */
    public function online($id = null, $questionID = null){
        $id = ($id) ? (int)$id : null;
        $questionID = ($questionID) ? (int)$questionID : null;
        $user = $this->Auth->user();

        $question_id = null;
        // Вопрос, ответы и многоответный ли вопрос
        $currentData = null;
        // Осталось времени
        $lastTime = null;

        // Запись ответа
        if($this->request->is('post')){
            $this->_addAnswer($this->request->data);
            exit;
        }

        // Валидность $id
        if(empty($id)){
            $this->Flash->error(__('Невалидный идентификатор теста.'));
            $this->redirect('/test/', 404);
        }

        // Существование $id
        $this->OnlineUser->recursive = -1;
        $data = $this->OnlineUser->find('first', ['conditions' => [
            'id' => $id,
            'user_id' => $user['id']
        ]]);
        if(empty($data)){
            $this->Flash->error(__('Тест не создан.'));
            $this->redirect('/test/', 404);
        }

        // Проверка что тест незакончен
        if($this->_isFinished($id)){
            $this->Flash->success(__('Тест закончен.'));
            $this->redirect('/finish/'.$id, 200);
        }

        // Корректность $questionID
        if(!is_null($questionID) && empty($questionID)){
            $this->Flash->error(__('Невалидный номер вопроса.'));
            $this->redirect('/online/'.$id, 404);
        }

        // Существование $questionID
        if(!empty($questionID)){
            $this->OnlineTest->recursive = -1;
            $data = $this->OnlineTest->find('first', ['conditions' => [
                'questionID' => $questionID,
                'onlineUser_id' => $id,
            ]]);
            if(empty($data)){
                $this->Flash->error(__('Такого вопроса не существует.'));
                $this->redirect('/online/'.$id, 404);
            }
        }

        // Получаем данные из OnlineTest по тесту пользователя
        $this->OnlineTest->recursive = -1;
        $onlineTest = $this->OnlineTest->find('all', ['conditions' => [
            'onlineUser_id' => $id
        ], 'order' => ["questionID" => "asc"]]);
        if(empty($onlineTest)){
            $this->Flash->error(__('Тест не создан.'));
            $this->redirect('/test/', 404);
        }

        // Если уже отвечал
        if(!empty($questionID))
            foreach($onlineTest as $key => $item)
                if($questionID == $item['OnlineTest']['questionID'] && !empty($item['OnlineTest']['answer'])){
                    $this->Flash->error(__('На вопрос уже отвечали.'));
                    $this->redirect('/online/' . $id, 404);
                }

        // Если нет текущего вопроса ищем его
        if(empty($questionID)){
            foreach($onlineTest as $key => $item){
                if(empty($item['OnlineTest']['answer'])){
                    $questionID = $item['OnlineTest']['questionID'];
                    break;
                }
            }
        }

        // Если нету текущего questionID заканчиваем тест
        if(empty($questionID)){
            $this->Flash->success(__('Тест закончен.'));
            $this->redirect('/finish/'.$id, 200);
        }

        // Формируем currentData для вопросов и ответов
        $this->OnlineTest->recursive = -1;
        $data = $this->OnlineTest->find('first', ['conditions' => [
            'questionID' => $questionID,
            'onlineUser_id' => $id
        ]]);
        $question_id = $data['OnlineTest']['question_id'];
        $this->Question->recursive = 1;
        $this->Question->unbindModel(['belongsTo' => ['Test', 'Subject'], 'hasMany' => ['OnlineTest', 'StatisticTest']]);
        $currentData = $this->Question->find('first', ['conditions' => ['Question.id' => $question_id]]);

        // isMultiple question
        if(strlen($currentData['ShortAnswer'][0]['answers']) > 2)
            $currentData['isMultiple'] = true;
        elseif(strlen($currentData['ShortAnswer'][0]['answers']) === 1)
            $currentData['isMultiple'] = false;

        // Получаем время окончания
        $this->OnlineUser->recursive = -1;
        $onlineUser = $this->OnlineUser->find('first', ['conditions' => ['id' => $id]]);
        $time = strtotime($onlineUser['OnlineUser']['completed']) - time();
        $this->set(compact('onlineTest', 'questionID', 'id', 'currentData', 'question_id', 'time'));
        $this->set(['active2'=>'class="active"']);
    }

/**
 * finish method
 * Заканчивает пользователю тест
 * @var $id - ID онлайн пользователя (обязателен)
 * @return void
 */
    public function finish($id = null) {
        $id = ($id) ? (int)$id : null;
        $user = $this->Auth->user();

        if(empty($id)){
            $this->Flash->error(__('Ошибка окончания теста. Невалидный идентификатор.'));
            $this->redirect('/test/', 404);
        }

        // OnlineUser
        $this->OnlineUser->recursiove = -1;
        $this->OnlineUser->unbindModel([
            'belongsTo' => ['User', 'Test']
        ]);
        $onlineUser = $this->OnlineUser->find('first', ['conditions' => [
            'id' => $id
        ]]);

        // ID теста который проходил пользователь
        $testId = $onlineUser['OnlineUser']['test_id'];

        if(empty($onlineUser)){
            $this->Flash->error(__('Ошибка окончания теста. Тест не найден.'));
            $this->redirect('/test/', 404);
        }

        //Проверка доступа на окончание теста
        if($user['id'] != $onlineUser['OnlineUser']['user_id'] && $user['Flag']['flag'] == 'regular'){
            $this->Flash->error(__('У вас нет прав на это действие.'));
            $this->redirect('/test/', 404);
        }

        $this->OnlineUser->delete($id);

        // OnlineTest
        $this->OnlineTest->recursiove = -1;
        $this->OnlineTest->unbindModel([
            'belongsTo' => ['User', 'Test', 'Question']
        ]);
        $onlineTest = $this->OnlineTest->find('all', ['conditions' => [
            'onlineUser_id' => $id
        ]]);

        if(empty($onlineTest)){
            $this->Flash->error(__('Ответы не найдены.'));
            $this->redirect('/test/', 404);
        }

        foreach ($onlineTest as $item) {
            $this->OnlineTest->delete($item['OnlineTest']['id']);
        }

        // Данные
        $successAnswers = 0;
        $noAnswers = 0;
        $failAnswers = 0;
        $numberQuestions = 0;
        $this->Available->recursive = -1;
        $testMark = $this->Available->find('first', ['conditions' => ['test_id' => $testId]]); // Оценка за тест в Available
        $testMarks = 0; // Оценка пользователя
        foreach ($onlineTest as $item) {
            $numberQuestions++;
            if($item['OnlineTest']['is_right'] == 1)
                $successAnswers++;
            elseif($item['OnlineTest']['is_right'] == 2)
                $failAnswers++;
            else
                $noAnswers++;
        }
        $testMarks = $testMark['Available']['testMarks'] * $successAnswers / $numberQuestions;
        // Запись статистики
        $this->Statistic->create();
        $this->Statistic->save([
            'test_id' => $onlineUser['OnlineUser']['test_id'],
            'user_id' => $user['id'],
            'group_id' => $user['Group']['id'],
            'testMarks' => $testMarks,
            'successAnswers' => $successAnswers,
            'noAnswers' => $noAnswers,
            'failAnswers' => $failAnswers,
            'numberQuestions' => $numberQuestions
        ]);

        $idStatistic = $this->Statistic->id;

        // Запись полной статистики
        foreach($onlineTest as $item){
            $this->StatisticTest->create();
            $this->StatisticTest->save([
                'statistic_id' => $idStatistic,
                'questionID' => $item['OnlineTest']['questionID'],
                'test_id' => $onlineUser['OnlineUser']['test_id'],
                'user_id' => $user['id'],
                'question_id' => $item['OnlineTest']['question_id'],
                'answer' => $item['OnlineTest']['answer'],
                'is_right' => $item['OnlineTest']['is_right']
            ]);
        }

        $this->redirect('/statistic/'.$idStatistic, 200);
    }

    public function statistic($id = null){
        if (!$this->Statistic->exists($id)) {
            throw new NotFoundException(__('Страница не найдена.'));
        }
        $this->Statistic->recursive = 1;
        $this->Test->unbindModel([
            'belongsTo' => ['User'],
            'hasMany' => ['Answer', 'Question', 'ShortAnswer', 'Statistic']
        ]);
        $statistic = $this->Statistic->find('first', ['conditions' => [
            'Statistic.id' => $id
        ]]);
        $this->Subject->recursive = -1;
        $subject = $this->Subject->find('first', ['conditions' => [
            'id' => $statistic['Test']['subject_id']
        ]]);

        $success = ($statistic['Statistic']['successAnswers'] / $statistic['Statistic']['numberQuestions']) * 100;
        $isSuccess = ($success > 20) ? true : false;
        $no = ($statistic['Statistic']['noAnswers'] / $statistic['Statistic']['numberQuestions']) * 100;
        $isNo = ($no > 20) ? true : false;
        $fail = ($statistic['Statistic']['failAnswers'] / $statistic['Statistic']['numberQuestions']) * 100;
        $isFail = ($fail > 20) ? true : false;
        $percents = [
            'success' => $success,
            'isSuccess' => $isSuccess,
            'no' => $no,
            'isNo' => $isNo,
            'fail' => $fail,
            'isFail' => $isFail
        ];
        $this->set(compact('statistic', 'subject', 'percents'));
    }

    public function statistics(){
        $title = 'Статистика';
        $user = $this->Auth->user();

        $this->Statistic->recursive = 1;
        $statistics = $this->Statistic->find('all', ['conditions' => [
            'Statistic.user_id' => $user['id']
        ]]);
        foreach($statistics as $key => $statistic){
            $this->Subject->recursive = -1;
            $subject = $this->Subject->find('first', ['conditions' => [
                'id' => $statistic['Test']['subject_id']
            ]]);
            $success = ($statistic['Statistic']['successAnswers'] / $statistic['Statistic']['numberQuestions']) * 100;
            $isSuccess = ($success > 20) ? true : false;
            $no = ($statistic['Statistic']['noAnswers'] / $statistic['Statistic']['numberQuestions']) * 100;
            $isNo = ($no > 20) ? true : false;
            $fail = ($statistic['Statistic']['failAnswers'] / $statistic['Statistic']['numberQuestions']) * 100;
            $isFail = ($fail > 20) ? true : false;
            $percents = [
                'success' => $success,
                'isSuccess' => $isSuccess,
                'no' => $no,
                'isNo' => $isNo,
                'fail' => $fail,
                'isFail' => $isFail
            ];
            $statistics[$key]['percents'] = $percents;
            $statistics[$key]['Subject'] = $subject['Subject'];
        }
        $this->set(compact('title', 'statistics'));
        $this->set(['active3'=>'class="active"']);
    }
}
