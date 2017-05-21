-- MySQL dump 10.15  Distrib 10.0.28-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.0.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `question_id` int(11) NOT NULL COMMENT 'Ключ вопроса',
  `answerID` int(11) NOT NULL COMMENT 'Номер ответа',
  `answer` varchar(250) NOT NULL COMMENT 'Ответ',
  `is_answer` int(11) NOT NULL COMMENT 'Является ответом',
  `test_id` int(11) NOT NULL COMMENT 'Ключ теста',
  PRIMARY KEY (`id`),
  KEY `FK_answers_questions` (`question_id`),
  KEY `FK_answers_tests` (`test_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4175 DEFAULT CHARSET=utf8 COMMENT='Таблица для хранения ответов на вопросы';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `availables`
--

DROP TABLE IF EXISTS `availables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availables` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `group_id` int(11) NOT NULL COMMENT 'Ключ группы',
  `test_id` int(11) NOT NULL COMMENT 'Ключ теста',
  `testQuestions` int(3) NOT NULL DEFAULT '20' COMMENT 'Количество вопросов в тесте',
  `testMinutes` int(3) NOT NULL DEFAULT '20' COMMENT 'Время на прохождение',
  `testMarks` float NOT NULL COMMENT 'Кол-во баллов за тест',
  `testTries` int(3) NOT NULL DEFAULT '1' COMMENT 'Количество попыток',
  `before` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Доступен до',
  PRIMARY KEY (`id`),
  KEY `FK_availables_groups` (`group_id`),
  KEY `FK_availables_tests` (`test_id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='Доступные для прохождения тесты';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `from` int(11) NOT NULL COMMENT 'Ключ пользователя',
  `to` int(11) DEFAULT NULL COMMENT 'Ключ пользователя',
  `message` text NOT NULL COMMENT 'Сообщение',
  `created` datetime NOT NULL COMMENT 'Дата отправки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COMMENT='Таблица обратной связи';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `flags`
--

DROP TABLE IF EXISTS `flags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `flag` char(50) NOT NULL COMMENT 'Флаг',
  `name` char(50) NOT NULL COMMENT 'Привилегия',
  PRIMARY KEY (`id`),
  UNIQUE KEY `flag` (`flag`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Права доступа';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `name` char(50) NOT NULL DEFAULT '0' COMMENT 'Группа',
  `user_id` int(11) NOT NULL COMMENT 'Ключ пользователя',
  `modified` datetime NOT NULL COMMENT 'Дата изменения',
  `created` datetime NOT NULL COMMENT 'Дата создания',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_groups_users` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='Группы пользователей';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `online_tests`
--

DROP TABLE IF EXISTS `online_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `questionID` int(11) NOT NULL COMMENT 'Номер вопроса пользователя',
  `question_id` int(11) NOT NULL COMMENT 'Ключ вопроса',
  `onlineUser_id` int(11) NOT NULL COMMENT 'Ключ онлайн пользователя',
  `answer` varchar(50) DEFAULT NULL COMMENT 'Ответ пользователя',
  `is_right` int(11) DEFAULT NULL COMMENT 'Верный ответ',
  PRIMARY KEY (`id`),
  KEY `FK_online_tests_questions` (`question_id`),
  KEY `FK_online_tests_online_users` (`onlineUser_id`)
) ENGINE=MyISAM AUTO_INCREMENT=68077 DEFAULT CHARSET=utf8 COMMENT='Временная таблица для хранения тестов которые проходят';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `online_users`
--

DROP TABLE IF EXISTS `online_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `user_id` int(11) NOT NULL COMMENT 'Ключ пользователя',
  `test_id` int(11) NOT NULL COMMENT 'Ключ теста',
  `created` datetime NOT NULL COMMENT 'Время начала теста',
  `completed` datetime NOT NULL COMMENT 'Время завершения теста',
  PRIMARY KEY (`id`),
  KEY `FK_online_users_users` (`user_id`),
  KEY `FK_online_users_tests` (`test_id`)
) ENGINE=MyISAM AUTO_INCREMENT=947 DEFAULT CHARSET=utf8 COMMENT='Временная таблица для хранения тестирующихся пользователей';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `IDquestion` int(10) NOT NULL COMMENT 'Номер вопроса',
  `question` varchar(250) NOT NULL COMMENT 'Вопрос',
  `test_id` int(11) NOT NULL COMMENT 'Ключ теста',
  `subject_id` int(10) NOT NULL COMMENT 'Ключ предмета',
  PRIMARY KEY (`id`),
  KEY `FK_questions_tests` (`test_id`),
  KEY `FK_questions_subjects` (`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1044 DEFAULT CHARSET=utf8 COMMENT='Таблица для хранения вопросов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `short_answers`
--

DROP TABLE IF EXISTS `short_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `short_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `question_id` int(11) NOT NULL COMMENT 'Ключ вопроса',
  `answers` char(50) NOT NULL COMMENT 'Ответы',
  `test_id` int(11) NOT NULL COMMENT 'Ключ теста',
  PRIMARY KEY (`id`),
  KEY `FK_short_answers_questions` (`question_id`),
  KEY `FK_short_answers_tests` (`test_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1044 DEFAULT CHARSET=utf8 COMMENT='Ответы на вопроса теста в коротком виде';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statistic_tests`
--

DROP TABLE IF EXISTS `statistic_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `statistic_id` int(11) NOT NULL COMMENT 'Ключ статистика',
  `questionID` int(11) NOT NULL COMMENT 'Номер вопроса у пользователя',
  `test_id` int(11) NOT NULL COMMENT 'Ключ теста',
  `user_id` int(11) NOT NULL COMMENT 'Ключ пользователя',
  `question_id` int(11) NOT NULL COMMENT 'Ключ вопроса',
  `answer` char(50) NOT NULL COMMENT 'Ответ пользователя',
  `is_right` int(11) NOT NULL COMMENT 'Верный ответ',
  PRIMARY KEY (`id`),
  KEY `FK_statistic_tests_statistics` (`statistic_id`),
  KEY `FK_statistic_tests_tests` (`test_id`),
  KEY `FK_statistic_tests_users` (`user_id`),
  KEY `FK_statistic_tests_questions` (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=61880 DEFAULT CHARSET=utf8 COMMENT='Таблица для хранения пройденных тестов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statistics`
--

DROP TABLE IF EXISTS `statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `test_id` int(11) NOT NULL COMMENT 'Ключ теста',
  `user_id` int(11) NOT NULL COMMENT 'Ключ пользователя',
  `group_id` int(11) DEFAULT NULL COMMENT 'Ключ группы',
  `testMarks` float NOT NULL,
  `successAnswers` int(11) NOT NULL COMMENT 'Число успешных ответов',
  `noAnswers` int(11) NOT NULL COMMENT 'Число вопросов без ответа',
  `failAnswers` int(11) NOT NULL COMMENT 'Число неправильных ответов',
  `numberQuestions` int(11) NOT NULL COMMENT 'Общее число вопросов',
  `created` datetime NOT NULL COMMENT 'Дата прохождения',
  PRIMARY KEY (`id`),
  KEY `FK_statistics_tests` (`test_id`),
  KEY `FK_statistics_users` (`user_id`),
  KEY `FK_statistics_groups` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=837 DEFAULT CHARSET=utf8 COMMENT='Статистика';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `name` varchar(50) NOT NULL COMMENT 'Предмет',
  `user_id` int(11) NOT NULL COMMENT 'Ключ пользователя',
  `modified` datetime NOT NULL COMMENT 'Дата изменения',
  `created` datetime NOT NULL COMMENT 'Дата создания',
  PRIMARY KEY (`id`),
  UNIQUE KEY `subject` (`name`),
  KEY `FK_subjects_users` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Таблица для хранения предметов или тем тестов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Ключ',
  `test` char(50) NOT NULL COMMENT 'Тест',
  `subject_id` int(11) NOT NULL COMMENT 'Ключ предмета',
  `user_id` int(11) NOT NULL COMMENT 'Ключ пользователя',
  `modified` datetime NOT NULL COMMENT 'Дата изменения',
  `created` datetime NOT NULL COMMENT 'Дата создания',
  PRIMARY KEY (`id`),
  KEY `FK_tests_subjects` (`subject_id`),
  KEY `FK_tests_users` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='Таблица для хранения тестов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID Пользователя',
  `name` varchar(60) NOT NULL COMMENT 'ФИО',
  `group_id` int(11) DEFAULT NULL COMMENT 'Ключ группа',
  `email` varchar(60) NOT NULL COMMENT 'Почта',
  `password` varchar(100) NOT NULL COMMENT 'Пароль',
  `modified` datetime NOT NULL COMMENT 'Последний вход',
  `created` datetime NOT NULL COMMENT 'Время регистрации',
  `flag_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Флаг привилегий',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_users_flags` (`flag_id`),
  KEY `FK_users_groups` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=188 DEFAULT CHARSET=utf8 COMMENT='Пользователи';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-21  7:49:47
