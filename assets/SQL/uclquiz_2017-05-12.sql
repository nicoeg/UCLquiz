# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.2.4-MariaDB)
# Database: uclquiz
# Generation Time: 2017-05-12 08:48:57 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) unsigned NOT NULL,
  `answer` varchar(200) NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;

INSERT INTO `answers` (`id`, `question_id`, `answer`, `correct`)
VALUES
	(1,1,'Brystbenet',1),
	(2,1,'Knæet',0),
	(3,1,'Panden',0),
	(4,2,'Rds3nIlLRdY',0),
	(5,2,'Jeiu7y-a220',0),
	(6,2,'w_q56nyIqiI',1),
	(7,2,'_RIQm3Ogkmk',0),
	(8,3,'Ja',1),
	(9,3,'Nej',0),
	(10,4,'Ja',0),
	(11,4,'Nej',1),
	(12,5,'Bruge sæbe',0),
	(13,5,'Gå til tandlæge',0),
	(14,5,'Gå i bad',0),
	(15,5,'Alle overstående',1),
	(16,6,'Skubber dem ud af sengen',0),
	(17,6,'Tager fat om kroppen, og løfter med ryggen',0),
	(18,6,'Bruger en kran ',1),
	(19,7,'r9um2fkGBvQ',0),
	(20,7,'DShxSpmR7Fs',0),
	(21,7,'MmRF5hP97sQ',0),
	(22,7,'6FKC6gj-AMY',1),
	(23,8,'Sprit',1),
	(24,8,'Jord',0),
	(25,8,'Eddike',0),
	(26,8,'Nellikker',0),
	(27,9,'4 ton',0),
	(28,9,'93m',1),
	(29,9,'94m',0),
	(30,9,'2cm',0);

/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;

INSERT INTO `courses` (`id`, `name`, `image`)
VALUES
	(1,'Biologi','http://eucnord.sonar.pil.dk/typo3temp/_processed_/csm_htx_pic_undervisning_a82e5b71c3.png'),
	(2,'Anatomy','https://innowell.net/wp-content/uploads/2015/01/anatomi_og_fysiologi_-kursus_-innnowell.jpg'),
	(3,'Psykologi','https://www.ug.dk/sites/default/files/styles/ug3_large/public/cand-hum-paedagogisk-psykologi-l.jpeg?itok=qVfs24dS');

/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) unsigned NOT NULL,
  `question` text NOT NULL,
  `type` int(11) DEFAULT 1,
  `hint` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`id`, `quiz_id`, `question`, `type`, `hint`)
VALUES
	(1,1,'Hvor sidder sternum?',1,NULL),
	(2,1,'Hvordan løfter man en baby?',2,NULL),
	(3,2,'Falafel?',1,NULL),
	(4,2,'Grønsager?',1,NULL),
	(5,3,'De ansatte skal sikre de ældres personlig hygiejne. Hvad indgår under dette?',1,NULL),
	(6,3,'Ved mødetid om morgenen skal personalet sørge for at vække de ældre, og få dem op af sengen. Hvordan håndtere de de overvægtige?',1,NULL),
	(7,3,'Når personalet har været på toilettet skal de vaske hænderne. Hvordan gøres dette?',2,NULL),
	(8,3,'Hvad kan anvendes som supplement til håndvask?',1,NULL),
	(9,3,'Hvor høj er frihedsgudinden?',1,NULL);

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table quizzes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `quizzes`;

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `level` int(2) NOT NULL,
  `uID` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `quizzes` WRITE;
/*!40000 ALTER TABLE `quizzes` DISABLE KEYS */;

INSERT INTO `quizzes` (`id`, `course_id`, `level`, `uID`, `title`)
VALUES
	(1,1,1,1,'Quiz 1'),
	(2,1,2,4,'Second quiz'),
	(3,1,1,4,'Plejehjemmet Solhjem');

/*!40000 ALTER TABLE `quizzes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_answer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_answer`;

CREATE TABLE `user_answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_quiz_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_answer` WRITE;
/*!40000 ALTER TABLE `user_answer` DISABLE KEYS */;

INSERT INTO `user_answer` (`id`, `user_quiz_id`, `user_id`, `answer_id`)
VALUES
	(1,23,1,1),
	(2,23,1,6),
	(3,23,1,9),
	(25,24,1,1),
	(26,24,1,7),
	(27,24,1,8),
	(98,NULL,1,12),
	(99,NULL,1,18),
	(100,NULL,1,19),
	(101,NULL,1,25),
	(102,NULL,1,30),
	(103,NULL,1,14),
	(104,NULL,1,16),
	(105,NULL,1,19),
	(106,NULL,1,25),
	(107,NULL,1,28),
	(108,NULL,1,3),
	(109,NULL,1,5);

/*!40000 ALTER TABLE `user_answer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_course
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_course`;

CREATE TABLE `user_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_course` WRITE;
/*!40000 ALTER TABLE `user_course` DISABLE KEYS */;

INSERT INTO `user_course` (`id`, `user_id`, `course_id`)
VALUES
	(1,1,1);

/*!40000 ALTER TABLE `user_course` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_quiz
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_quiz`;

CREATE TABLE `user_quiz` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `quiz_id` int(10) unsigned NOT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_quiz` WRITE;
/*!40000 ALTER TABLE `user_quiz` DISABLE KEYS */;

INSERT INTO `user_quiz` (`id`, `user_id`, `quiz_id`, `time`)
VALUES
	(23,1,1,NULL),
	(24,1,1,NULL),
	(25,1,1,NULL),
	(26,1,1,NULL),
	(27,1,1,NULL),
	(28,1,1,NULL),
	(29,1,1,NULL),
	(30,1,1,NULL),
	(31,1,1,NULL),
	(32,1,1,NULL),
	(33,1,1,NULL),
	(34,1,1,NULL),
	(35,1,1,NULL),
	(36,1,1,NULL),
	(37,1,1,NULL),
	(38,1,1,NULL),
	(39,1,1,NULL),
	(40,1,1,NULL),
	(41,1,1,NULL),
	(42,1,2,NULL),
	(43,1,1,NULL),
	(44,1,1,NULL),
	(45,1,1,NULL),
	(46,1,2,NULL),
	(47,1,1,NULL),
	(48,1,1,NULL),
	(49,1,2,NULL),
	(50,1,1,NULL),
	(51,1,1,NULL),
	(52,1,1,NULL),
	(53,1,1,NULL),
	(54,1,1,NULL),
	(55,1,1,NULL),
	(56,1,1,NULL),
	(57,1,1,NULL),
	(58,1,1,NULL),
	(59,1,1,NULL),
	(60,1,1,NULL),
	(61,1,1,NULL),
	(62,1,1,NULL),
	(63,1,1,NULL),
	(64,1,1,NULL),
	(65,1,1,NULL),
	(66,1,1,NULL),
	(67,1,1,NULL),
	(68,1,1,NULL),
	(69,1,1,NULL),
	(70,1,1,NULL),
	(71,1,1,NULL),
	(72,1,1,NULL),
	(73,1,1,NULL),
	(74,1,1,NULL),
	(75,1,1,NULL),
	(76,1,1,NULL),
	(77,1,1,NULL),
	(78,1,1,NULL),
	(79,1,1,NULL),
	(80,1,1,NULL),
	(81,1,1,NULL),
	(82,1,1,NULL),
	(83,1,1,NULL),
	(84,1,1,NULL),
	(85,1,1,NULL),
	(86,1,1,NULL),
	(87,1,1,NULL),
	(88,1,1,NULL),
	(89,1,1,NULL),
	(90,1,1,NULL),
	(91,1,1,NULL),
	(92,1,1,NULL),
	(93,1,1,NULL),
	(94,1,1,NULL),
	(95,1,1,NULL),
	(96,1,1,NULL),
	(97,1,1,NULL),
	(98,1,1,NULL),
	(99,1,1,NULL),
	(100,1,1,NULL),
	(101,1,1,NULL),
	(102,1,1,NULL),
	(103,1,1,NULL),
	(104,1,1,NULL),
	(105,1,1,NULL),
	(106,1,1,NULL),
	(107,1,1,NULL),
	(108,1,3,NULL),
	(109,1,3,NULL),
	(110,1,3,NULL),
	(111,1,3,NULL),
	(112,1,1,NULL),
	(113,1,2,NULL),
	(114,1,3,NULL),
	(115,1,3,NULL),
	(116,1,3,NULL),
	(117,1,1,NULL),
	(118,1,1,NULL),
	(119,1,1,NULL),
	(120,1,1,NULL),
	(121,1,1,NULL),
	(122,1,1,NULL),
	(123,1,1,NULL),
	(124,1,3,NULL);

/*!40000 ALTER TABLE `user_quiz` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(70) NOT NULL,
  `userType` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `username`, `password`, `userType`)
VALUES
	(1,'nicomanden@gmail.com','nico9699','$2y$10$XskxvGLFjGeJpQHR1t0RS.rJRmMdZL5gWjIg/BrBqqRVWuX3VqktK',0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
