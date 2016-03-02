-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.9-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.5051
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for sms_prijava
DROP DATABASE IF EXISTS `sms_prijava`;
CREATE DATABASE IF NOT EXISTS `sms_prijava` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sms_prijava`;

-- Dumping structure for table sms_prijava.admin_credential
CREATE TABLE IF NOT EXISTS `admin_credential` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(30) NOT NULL,
  `sequence` int(4) unsigned DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_adcd_nm` (`name`),
  KEY `fk_adcd_adcdgp` (`group_id`),
  CONSTRAINT `fk_adcd_adcdgp` FOREIGN KEY (`group_id`) REFERENCES `admin_credential_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.admin_credential: ~13 rows (approximately)
DELETE FROM `admin_credential`;
/*!40000 ALTER TABLE `admin_credential` DISABLE KEYS */;
INSERT INTO `admin_credential` (`id`, `group_id`, `name`, `title`, `sequence`, `created_at`, `updated_at`) VALUES
	(1, 1, 'ac_manage', 'USERS', 10, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(2, 1, 'translation', 'TRANSLATIONS', 20, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(3, 4, 'application', 'APPLICATIONS', 30, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(4, 2, 'subject', 'SUBJECT', 40, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(5, 2, 'course', 'COURSE', 50, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(6, 2, 'period', 'PERIOD', 60, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(7, 2, 'student', 'STUDENT', 70, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(8, 2, 'professor', 'PROFESSOR', 80, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(9, 3, 'engagement', 'ENGAGEMENT', 90, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(10, 2, 'school_year', 'SCHOOL_YEAR', 100, '2015-11-30 21:06:07', '2015-11-30 21:06:07'),
	(11, 2, 'study_program', 'STUDY_PROGRAM', 110, '2016-02-16 11:19:52', '2016-02-16 11:19:53'),
	(13, 5, 'application_request', 'APPLICATION_REQUEST', 120, '2016-02-16 11:19:52', '2016-02-16 11:19:53'),
	(14, 5, 'application_by_subject', 'APPLICATION_BY_SUBJECT', 130, '2016-02-16 11:19:52', '2016-02-16 11:19:53');
/*!40000 ALTER TABLE `admin_credential` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.admin_credential_group
CREATE TABLE IF NOT EXISTS `admin_credential_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `sequence` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_adcdgp_nm` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.admin_credential_group: ~5 rows (approximately)
DELETE FROM `admin_credential_group`;
/*!40000 ALTER TABLE `admin_credential_group` DISABLE KEYS */;
INSERT INTO `admin_credential_group` (`id`, `name`, `title`, `sequence`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'ADMIN', 10, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(2, 'basic', 'BASIC', 20, '2015-11-30 21:02:43', '2015-11-30 21:02:43'),
	(3, 'engagement', 'ENGAGEMENT', 30, '2015-11-30 21:02:43', '2015-11-30 21:02:43'),
	(4, 'application', 'APPLICATIONS', 40, '2015-11-30 21:02:43', '2015-11-30 21:02:43'),
	(5, 'additional_info', 'ADDITIONAL_INFO', 50, '2015-11-30 21:02:43', '2015-11-30 21:02:43');
/*!40000 ALTER TABLE `admin_credential_group` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.admin_user
CREATE TABLE IF NOT EXISTS `admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) unsigned NOT NULL,
  `professor_id` int(11) unsigned DEFAULT NULL,
  `student_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` enum('NEW','super_admin','admin','professor','student') NOT NULL DEFAULT 'NEW',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_adus_lg` (`login`),
  KEY `fk_adus_trln` (`language_id`),
  KEY `fk_adus_pf` (`professor_id`),
  KEY `fk_adus_st` (`student_id`),
  CONSTRAINT `fk_adus_pf` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_adus_st` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_adus_trln` FOREIGN KEY (`language_id`) REFERENCES `translation_language` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.admin_user: ~3 rows (approximately)
DELETE FROM `admin_user`;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` (`id`, `language_id`, `professor_id`, `student_id`, `name`, `login`, `password`, `email`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 10, NULL, NULL, 'Nikola Stojanovic', 'nstojanovic', '$2y$10$iGcY3rqDwS/g2mi1wn26zOA3WjiGGQrKPwcxAtvRdCzyDIxgtXobK', 'nikola.stojanovic.kg@gmail.com', 'super_admin', 'v7xE32ZpluUkuZQkDUaCLGdXqEGdmjdXDZznDw6vC3Gt6UH5kb4d1tbbm4V3', '2015-11-18 16:46:40', '2016-02-20 19:34:28'),
	(2, 1, 1, NULL, 'Miladin Stefanovic', 'mstefanovic', '$2y$10$Px0B6k55U3/FRKQp87n65OoNYDGtrCEmjsH976FqhBCnDX1IfBjgS', 'miladin@kg.ac.rs', 'professor', 'bzPrSqzYcLWdrAZihTDhDATPNo9G6aMZ1jzsZ9vNExDyHWOFQRxDabYUxSlT', '2015-11-29 17:34:09', '2016-02-10 08:29:01'),
	(3, 1, NULL, 1, 'Nikola', 'nstojanovic2', '$2y$10$Px0B6k55U3/FRKQp87n65OoNYDGtrCEmjsH976FqhBCnDX1IfBjgS', 'test@test.com', 'student', 'Aefy5WdHk9lsvNKmD7IV2EtaZGGf13kprPO26M6NM9DxV1L9e858KIebvYcO', '2015-12-08 09:23:51', '2016-02-15 07:28:59');
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.admin_user_credential
CREATE TABLE IF NOT EXISTS `admin_user_credential` (
  `admin_user_id` int(11) unsigned NOT NULL,
  `admin_credential_id` int(11) unsigned NOT NULL,
  `perm_read` int(4) unsigned DEFAULT '0',
  `perm_write` int(4) unsigned DEFAULT '0',
  `perm_exec` int(4) unsigned DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`admin_user_id`,`admin_credential_id`),
  KEY `fk_aduscd_adus` (`admin_user_id`),
  KEY `fk_aduscd_adcd` (`admin_credential_id`),
  CONSTRAINT `fk_aduscd_adcd` FOREIGN KEY (`admin_credential_id`) REFERENCES `admin_credential` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_aduscd_adus` FOREIGN KEY (`admin_user_id`) REFERENCES `admin_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.admin_user_credential: ~16 rows (approximately)
DELETE FROM `admin_user_credential`;
/*!40000 ALTER TABLE `admin_user_credential` DISABLE KEYS */;
INSERT INTO `admin_user_credential` (`admin_user_id`, `admin_credential_id`, `perm_read`, `perm_write`, `perm_exec`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, 0, '2015-11-30 20:06:29', '2016-03-02 08:27:27'),
	(1, 2, 1, 1, 0, '2015-11-30 20:06:29', '2016-03-02 08:27:27'),
	(1, 3, 1, 1, 0, '2015-11-30 20:06:29', '2016-03-02 08:27:27'),
	(1, 4, 1, 1, 0, '2015-12-04 10:28:02', '2016-03-02 08:27:27'),
	(1, 5, 1, 1, 0, '2015-12-04 10:28:02', '2016-03-02 08:27:27'),
	(1, 6, 1, 1, 0, '2015-12-04 10:28:02', '2016-03-02 08:27:27'),
	(1, 7, 1, 1, 0, '2015-12-04 10:28:02', '2016-03-02 08:27:27'),
	(1, 8, 1, 1, 0, '2015-12-04 10:28:02', '2016-03-02 08:27:27'),
	(1, 9, 1, 1, 0, '2015-12-04 10:28:02', '2016-03-02 08:27:27'),
	(1, 10, 1, 1, 0, '2016-02-07 18:35:29', '2016-03-02 08:27:27'),
	(1, 11, 1, 1, 0, '2016-02-16 10:20:14', '2016-03-02 08:27:27'),
	(1, 13, 1, 1, 0, '2016-02-17 23:24:09', '2016-03-02 08:27:27'),
	(1, 14, 1, 1, 0, '2016-02-17 23:24:09', '2016-03-02 08:27:27'),
	(2, 3, 1, 1, 0, '2016-02-03 09:40:26', '2016-02-03 09:40:32'),
	(2, 9, 1, 0, 0, '2016-02-03 09:40:26', '2016-02-03 09:40:32'),
	(3, 3, 1, 0, 0, '2015-12-08 09:24:25', '2016-03-02 08:48:16');
/*!40000 ALTER TABLE `admin_user_credential` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.application
CREATE TABLE IF NOT EXISTS `application` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `subject_id` int(11) unsigned NOT NULL,
  `period_id` int(11) unsigned NOT NULL,
  `school_year_id` int(11) unsigned NOT NULL,
  `application_date` date NOT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_time` time DEFAULT '09:00:00',
  `exam_score` int(2) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_st` (`student_id`),
  KEY `fk_app_sb` (`subject_id`),
  KEY `fk_app_pe` (`period_id`),
  KEY `fk_app_sy` (`school_year_id`),
  CONSTRAINT `fk_app_pe` FOREIGN KEY (`period_id`) REFERENCES `period` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_app_sb` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_app_st` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_app_sy` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.application: ~60 rows (approximately)
DELETE FROM `application`;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` (`id`, `student_id`, `subject_id`, `period_id`, `school_year_id`, `application_date`, `exam_date`, `exam_time`, `exam_score`, `created_at`, `updated_at`) VALUES
	(8, 1, 1, 1, 1, '2009-01-14', '2009-01-30', NULL, 0, '2016-02-08 12:25:42', '2016-02-12 07:56:54'),
	(11, 1, 4, 1, 3, '2011-01-20', '2011-02-02', NULL, 0, '2016-02-08 12:30:13', '2016-02-12 07:57:19'),
	(12, 1, 3, 3, 3, '2011-06-24', '2011-06-29', NULL, 8, '2016-02-10 08:58:08', '2016-02-10 08:58:08'),
	(13, 2, 3, 1, 4, '2012-01-21', '2012-02-02', NULL, 7, '2016-02-10 12:09:21', '2016-02-10 12:11:27'),
	(14, 1, 7, 1, 7, '2015-01-19', '2015-02-11', NULL, 0, '2016-02-13 12:50:37', '2016-02-13 12:50:46'),
	(16, 1, 32, 4, 7, '2015-07-06', '2015-08-20', NULL, 0, '2016-02-13 18:07:43', '2016-02-13 18:07:43'),
	(17, 1, 33, 1, 7, '2015-04-01', '2015-04-16', NULL, 0, '2016-02-13 18:08:19', '2016-02-13 18:08:19'),
	(18, 1, 34, 3, 7, '2015-06-15', '2015-06-26', NULL, 0, '2016-02-13 18:11:18', '2016-02-13 18:11:18'),
	(19, 1, 37, 3, 7, '2015-06-15', '2015-07-01', NULL, 8, '2016-02-13 18:12:04', '2016-02-14 14:23:30'),
	(20, 1, 38, 1, 7, '2015-06-15', '2015-07-03', NULL, 0, '2016-02-13 18:12:38', '2016-02-13 18:12:38'),
	(21, 1, 39, 1, 7, '2015-06-15', '2015-06-25', NULL, 0, '2016-02-13 18:13:06', '2016-02-13 18:13:06'),
	(22, 1, 40, 6, 7, '2015-09-14', '2015-09-25', NULL, 0, '2016-02-13 18:13:38', '2016-02-13 18:13:38'),
	(23, 2, 7, 1, 7, '2015-01-19', '2015-02-11', NULL, 0, '2016-02-13 12:50:37', '2016-02-13 12:50:46'),
	(24, 2, 31, 6, 7, '2015-09-15', '2015-09-25', NULL, 0, '2016-02-13 18:07:04', '2016-02-13 18:07:04'),
	(25, 2, 32, 4, 7, '2015-07-06', '2015-08-20', NULL, 0, '2016-02-13 18:07:43', '2016-02-13 18:07:43'),
	(26, 2, 33, 1, 7, '2015-04-01', '2015-04-16', NULL, 0, '2016-02-13 18:08:19', '2016-02-13 18:08:19'),
	(27, 2, 34, 3, 7, '2015-06-15', '2015-06-26', NULL, 0, '2016-02-13 18:11:18', '2016-02-13 18:11:18'),
	(28, 2, 37, 3, 7, '2015-06-15', '2015-07-01', NULL, 7, '2016-02-13 18:12:04', '2016-02-14 14:24:06'),
	(29, 2, 38, 1, 7, '2015-06-15', '2015-07-03', NULL, 0, '2016-02-13 18:12:38', '2016-02-13 18:12:38'),
	(30, 2, 39, 1, 7, '2015-06-15', '2015-06-25', NULL, 0, '2016-02-13 18:13:06', '2016-02-13 18:13:06'),
	(31, 2, 40, 6, 7, '2015-09-14', '2015-09-25', NULL, 0, '2016-02-13 18:13:38', '2016-02-13 18:13:38'),
	(32, 3, 7, 1, 7, '2015-01-19', '2015-02-11', NULL, 0, '2016-02-13 12:50:37', '2016-02-13 12:50:46'),
	(33, 3, 31, 6, 7, '2015-09-15', '2015-09-25', NULL, 0, '2016-02-13 18:07:04', '2016-02-13 18:07:04'),
	(34, 3, 32, 4, 7, '2015-07-06', '2015-08-20', NULL, 0, '2016-02-13 18:07:43', '2016-02-13 18:07:43'),
	(35, 3, 33, 1, 7, '2015-04-01', '2015-04-16', NULL, 0, '2016-02-13 18:08:19', '2016-02-13 18:08:19'),
	(36, 3, 34, 3, 7, '2015-06-15', '2015-06-26', NULL, 0, '2016-02-13 18:11:18', '2016-02-13 18:11:18'),
	(37, 3, 37, 3, 7, '2015-06-15', '2015-07-01', NULL, 9, '2016-02-13 18:12:04', '2016-02-14 14:23:58'),
	(38, 3, 38, 1, 7, '2015-06-15', '2015-07-03', NULL, 0, '2016-02-13 18:12:38', '2016-02-13 18:12:38'),
	(39, 3, 39, 1, 7, '2015-06-15', '2015-06-25', NULL, 0, '2016-02-13 18:13:06', '2016-02-13 18:13:06'),
	(40, 3, 40, 6, 7, '2015-09-14', '2015-09-25', NULL, 0, '2016-02-13 18:13:38', '2016-02-13 18:13:38'),
	(41, 4, 7, 1, 7, '2015-01-19', '2015-02-11', NULL, 0, '2016-02-13 12:50:37', '2016-02-13 12:50:46'),
	(42, 4, 31, 6, 7, '2015-09-15', '2015-09-25', NULL, 0, '2016-02-13 18:07:04', '2016-02-13 18:07:04'),
	(43, 4, 32, 4, 7, '2015-07-06', '2015-08-20', NULL, 0, '2016-02-13 18:07:43', '2016-02-13 18:07:43'),
	(44, 4, 33, 1, 7, '2015-04-01', '2015-04-16', NULL, 0, '2016-02-13 18:08:19', '2016-02-13 18:08:19'),
	(45, 4, 34, 3, 7, '2015-06-15', '2015-06-26', NULL, 0, '2016-02-13 18:11:18', '2016-02-13 18:11:18'),
	(46, 4, 37, 3, 7, '2015-06-15', '2015-07-01', NULL, 7, '2016-02-13 18:12:04', '2016-02-14 14:23:50'),
	(47, 4, 38, 1, 7, '2015-06-15', '2015-07-03', NULL, 0, '2016-02-13 18:12:38', '2016-02-13 18:12:38'),
	(48, 4, 39, 1, 7, '2015-06-15', '2015-06-25', NULL, 0, '2016-02-13 18:13:06', '2016-02-13 18:13:06'),
	(49, 4, 40, 6, 7, '2015-09-14', '2015-09-25', NULL, 0, '2016-02-13 18:13:38', '2016-02-13 18:13:38'),
	(50, 5, 7, 1, 7, '2015-01-19', '2015-02-11', NULL, 0, '2016-02-13 12:50:37', '2016-02-13 12:50:46'),
	(51, 5, 31, 6, 7, '2015-09-15', '2015-09-25', NULL, 0, '2016-02-13 18:07:04', '2016-02-13 18:07:04'),
	(52, 5, 32, 4, 7, '2015-07-06', '2015-08-20', NULL, 0, '2016-02-13 18:07:43', '2016-02-13 18:07:43'),
	(53, 5, 33, 1, 7, '2015-04-01', '2015-04-16', NULL, 0, '2016-02-13 18:08:19', '2016-02-13 18:08:19'),
	(54, 5, 34, 3, 7, '2015-06-15', '2015-06-26', NULL, 0, '2016-02-13 18:11:18', '2016-02-13 18:11:18'),
	(55, 5, 37, 3, 7, '2015-06-15', '2015-07-01', NULL, 8, '2016-02-13 18:12:04', '2016-02-14 14:23:38'),
	(56, 5, 38, 1, 7, '2015-06-15', '2015-07-03', NULL, 0, '2016-02-13 18:12:38', '2016-02-13 18:12:38'),
	(57, 5, 39, 1, 7, '2015-06-15', '2015-06-25', NULL, 0, '2016-02-13 18:13:06', '2016-02-13 18:13:06'),
	(58, 5, 40, 6, 7, '2015-09-14', '2015-09-25', NULL, 0, '2016-02-13 18:13:38', '2016-02-13 18:13:38'),
	(59, 6, 7, 1, 7, '2015-01-19', '2015-02-11', NULL, 0, '2016-02-13 12:50:37', '2016-02-13 12:50:46'),
	(60, 6, 31, 6, 7, '2015-09-15', '2015-09-25', NULL, 0, '2016-02-13 18:07:04', '2016-02-13 18:07:04'),
	(61, 6, 32, 4, 7, '2015-07-06', '2015-08-20', NULL, 0, '2016-02-13 18:07:43', '2016-02-13 18:07:43'),
	(62, 6, 33, 1, 7, '2015-04-01', '2015-04-16', NULL, 0, '2016-02-13 18:08:19', '2016-02-13 18:08:19'),
	(63, 6, 34, 3, 7, '2015-06-15', '2015-06-26', NULL, 0, '2016-02-13 18:11:18', '2016-02-13 18:11:18'),
	(64, 6, 37, 3, 7, '2015-06-15', '2015-07-01', NULL, 8, '2016-02-13 18:12:04', '2016-02-14 14:24:17'),
	(65, 6, 38, 1, 7, '2015-06-15', '2015-07-03', NULL, 0, '2016-02-13 18:12:38', '2016-02-13 18:12:38'),
	(66, 6, 39, 1, 7, '2015-06-15', '2015-06-25', NULL, 0, '2016-02-13 18:13:06', '2016-02-13 18:13:06'),
	(67, 6, 40, 6, 7, '2015-09-14', '2015-09-25', NULL, 0, '2016-02-13 18:13:38', '2016-02-13 18:13:38'),
	(68, 1, 19, 3, 3, '2011-06-20', '2011-06-27', NULL, 8, '2016-02-14 15:10:11', '2016-02-14 15:10:11'),
	(69, 1, 31, 2, 7, '2015-09-03', '2015-09-21', '14:00:00', 7, '2016-02-16 11:33:38', '2016-03-01 21:06:30'),
	(70, 6, 27, 1, 8, '2016-01-25', '2016-02-12', NULL, 7, '2016-02-18 07:42:24', '2016-03-02 10:03:36'),
	(71, 1, 4, 8, 8, '2016-03-01', NULL, '09:00:00', 7, '2016-03-01 22:13:24', '2016-03-01 22:15:32'),
	(72, 1, 27, 8, 8, '2016-03-01', '2016-02-29', '09:00:00', 0, '2016-03-01 23:01:48', '2016-03-02 08:50:32');
/*!40000 ALTER TABLE `application` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.application_request
CREATE TABLE IF NOT EXISTS `application_request` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int(11) unsigned DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `response` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_apprq_app` (`application_id`),
  CONSTRAINT `fk_apprq_app` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.application_request: ~10 rows (approximately)
DELETE FROM `application_request`;
/*!40000 ALTER TABLE `application_request` DISABLE KEYS */;
INSERT INTO `application_request` (`id`, `application_id`, `description`, `response`, `created_at`, `updated_at`) VALUES
	(24, NULL, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA M182 mart"}', 'Ispitni rok ne postoji', '2016-03-01 21:56:39', '2016-03-01 21:56:39'),
	(26, 71, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA M251 mart"}', 'Uspesno ste prijavili ispit.', '2016-03-01 22:13:24', '2016-03-01 22:13:24'),
	(28, NULL, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA M251 mart"}', 'Vec ste prijavili ispit iz predmeta Numerička matematika i simboličko programiranje', '2016-03-01 22:26:09', '2016-03-01 22:26:09'),
	(29, NULL, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA M251 mart"}', 'Vec ste prijavili ispit iz predmeta Numerička matematika i simboličko programiranje', '2016-03-01 22:42:28', '2016-03-01 22:42:28'),
	(30, NULL, '{"sender":"+381643820970","sms_prefix":"Test","fullsms":"Test nepostojeca komanda"}', 'Nepostojeca komanda! Za prijavu ispita poslati: ‘PRIJAVA_ISPITA <šifra_predmeta> <ispitni_rok>\'', '2016-03-01 22:43:53', '2016-03-01 22:43:53'),
	(31, NULL, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA"}', 'Doslo je do greske, proverite unete podatke.', '2016-03-01 22:47:55', '2016-03-01 22:47:55'),
	(36, NULL, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA test test"}', 'Nepostojeca šifra predmeta.', '2016-03-01 22:57:23', '2016-03-01 22:57:23'),
	(37, NULL, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA M101 test"}', 'Ispitni rok ne postoji', '2016-03-01 22:58:13', '2016-03-01 22:58:13'),
	(38, NULL, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA M101 mart"}', 'Ovaj predmet nije u vašem studijskom programu.', '2016-03-01 23:00:03', '2016-03-01 23:00:03'),
	(39, 72, '{"sender":"+381643820970","sms_prefix":"PRIJAVA_ISPITA","fullsms":"PRIJAVA_ISPITA M172 mart"}', 'Uspesno ste prijavili ispit.', '2016-03-01 23:01:48', '2016-03-01 23:01:48');
/*!40000 ALTER TABLE `application_request` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.course
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_co_nm` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.course: ~3 rows (approximately)
DELETE FROM `course`;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Informatika', '2015-11-30 22:01:59', '2016-02-05 08:59:26'),
	(4, 'Matematika', '2015-12-04 11:49:37', '2016-03-02 08:14:00'),
	(5, 'Biologija', '2016-02-05 08:59:34', '2016-02-05 08:59:34');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.engagement
CREATE TABLE IF NOT EXISTS `engagement` (
  `professor_id` int(11) unsigned NOT NULL,
  `subject_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `school_year_id` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`subject_id`,`course_id`,`school_year_id`),
  KEY `fk_en_pf` (`professor_id`),
  KEY `fk_en_sb` (`subject_id`),
  KEY `fk_en_co` (`course_id`),
  KEY `fk_en_sy` (`school_year_id`),
  CONSTRAINT `fk_en_co` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_en_pf` FOREIGN KEY (`professor_id`) REFERENCES `professor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_en_sb` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_en_sy` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.engagement: ~16 rows (approximately)
DELETE FROM `engagement`;
/*!40000 ALTER TABLE `engagement` DISABLE KEYS */;
INSERT INTO `engagement` (`professor_id`, `subject_id`, `course_id`, `school_year_id`, `created_at`, `updated_at`) VALUES
	(4, 1, 1, 1, '2016-02-13 13:14:06', '2016-02-13 13:14:06'),
	(1, 3, 1, 3, '2016-02-08 11:09:44', '2016-02-08 11:09:44'),
	(1, 3, 1, 7, '2016-02-08 11:09:44', '2016-02-08 11:09:44'),
	(3, 4, 1, 3, '2016-02-13 13:12:45', '2016-02-13 13:12:45'),
	(5, 5, 1, 1, '2016-02-13 17:53:17', '2016-02-13 17:53:17'),
	(6, 7, 1, 7, '2016-02-13 12:49:42', '2016-02-13 12:49:42'),
	(10, 16, 1, 2, '2016-02-14 09:14:20', '2016-02-14 09:14:20'),
	(11, 27, 1, 8, '2016-02-18 07:46:42', '2016-02-18 07:46:42'),
	(2, 31, 1, 7, '2016-03-02 08:55:02', '2016-03-02 08:55:02'),
	(1, 31, 1, 8, '2016-02-13 17:59:11', '2016-02-13 17:59:11'),
	(7, 32, 1, 7, '2016-02-13 18:00:54', '2016-02-13 18:00:54'),
	(2, 33, 1, 7, '2016-02-13 18:01:22', '2016-02-13 18:01:22'),
	(8, 34, 1, 7, '2016-02-13 18:01:54', '2016-02-13 18:01:54'),
	(1, 37, 1, 7, '2016-02-13 18:02:58', '2016-02-13 18:02:58'),
	(9, 38, 1, 7, '2016-02-13 18:03:28', '2016-02-13 18:03:28'),
	(10, 39, 1, 7, '2016-02-13 18:03:56', '2016-02-13 18:03:56'),
	(2, 40, 1, 7, '2016-02-13 18:04:40', '2016-02-13 18:04:40');
/*!40000 ALTER TABLE `engagement` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.period
CREATE TABLE IF NOT EXISTS `period` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sequence` int(4) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pe_nm` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.period: ~8 rows (approximately)
DELETE FROM `period`;
/*!40000 ALTER TABLE `period` DISABLE KEYS */;
INSERT INTO `period` (`id`, `name`, `sequence`, `created_at`, `updated_at`) VALUES
	(1, 'Januar', 10, '2015-11-30 21:57:22', '2016-02-01 08:20:10'),
	(2, 'April', 30, '2015-11-30 21:57:22', '2016-02-01 08:19:41'),
	(3, 'Jun', 40, '2015-11-30 21:57:22', '2016-02-04 11:50:03'),
	(4, 'Avgust', 50, '2015-11-30 21:57:22', '2015-11-30 21:57:22'),
	(5, 'Septembar', 60, '2015-11-30 21:57:22', '2015-11-30 21:57:22'),
	(6, 'Oktobar', 70, '2015-11-30 21:57:22', '2015-11-30 21:57:22'),
	(7, 'Oktobar 2', 80, '2016-02-13 18:26:25', '2016-02-13 18:26:26'),
	(8, 'Mart', 20, '2016-02-13 18:26:25', '2016-02-13 18:26:26');
/*!40000 ALTER TABLE `period` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.period_school_year
CREATE TABLE IF NOT EXISTS `period_school_year` (
  `period_id` int(11) unsigned NOT NULL,
  `school_year_id` int(11) unsigned NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`period_id`,`school_year_id`),
  KEY `fk_psy_pd` (`period_id`),
  KEY `fk_psy_sy` (`school_year_id`),
  CONSTRAINT `fk_psy_pd` FOREIGN KEY (`period_id`) REFERENCES `period` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_psy_sy` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.period_school_year: ~51 rows (approximately)
DELETE FROM `period_school_year`;
/*!40000 ALTER TABLE `period_school_year` DISABLE KEYS */;
INSERT INTO `period_school_year` (`period_id`, `school_year_id`, `date_start`, `date_end`, `created_at`, `updated_at`) VALUES
	(1, 1, '2009-01-27', '2009-02-20', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(1, 2, '2009-04-13', '2009-04-17', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(1, 3, '2009-06-22', '2009-07-03', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(1, 4, '2009-08-24', '2009-09-04', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(1, 5, '2009-09-07', '2009-09-18', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(1, 6, '2009-09-21', '2009-10-02', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(1, 7, '2009-10-05', '2009-10-09', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(1, 8, '2016-01-25', '2016-02-12', '2016-02-15 11:51:13', '2016-02-15 11:51:13'),
	(2, 1, '2010-01-27', '2010-02-14', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(2, 2, '2010-04-13', '2010-04-17', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(2, 3, '2010-06-22', '2010-07-03', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(2, 4, '2010-08-24', '2010-09-04', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(2, 5, '2010-09-07', '2010-09-18', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(2, 6, '2010-09-21', '2010-10-02', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(2, 7, '2010-10-05', '2010-10-09', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(2, 8, '2016-04-11', '2016-04-15', '2016-02-15 11:51:39', '2016-02-15 11:51:39'),
	(3, 1, '2011-01-27', '2011-02-14', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(3, 2, '2011-04-13', '2011-04-17', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(3, 3, '2011-06-22', '2011-07-03', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(3, 4, '2011-08-24', '2011-09-04', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(3, 5, '2011-09-07', '2011-09-18', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(3, 6, '2011-09-21', '2011-10-02', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(3, 7, '2011-10-05', '2011-10-09', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(4, 1, '2012-01-27', '2012-02-14', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(4, 2, '2012-04-13', '2012-04-17', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(4, 3, '2012-06-22', '2012-07-03', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(4, 4, '2012-08-24', '2012-09-04', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(4, 5, '2012-09-07', '2012-09-18', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(4, 6, '2012-09-21', '2012-10-02', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(4, 7, '2012-10-05', '2012-10-09', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(5, 1, '2013-01-27', '2013-02-14', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(5, 2, '2013-04-13', '2013-04-17', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(5, 3, '2013-06-22', '2013-07-03', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(5, 4, '2013-08-24', '2013-09-04', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(5, 5, '2013-09-07', '2013-09-18', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(5, 6, '2013-09-21', '2013-10-02', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(5, 7, '2013-10-05', '2013-10-09', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(6, 1, '2014-01-27', '2014-02-14', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(6, 2, '2014-04-13', '2014-04-17', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(6, 3, '2014-06-22', '2014-07-03', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(6, 4, '2014-08-24', '2014-09-04', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(6, 5, '2014-09-07', '2014-09-18', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(6, 6, '2014-09-21', '2014-10-02', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(6, 7, '2014-10-05', '2014-10-09', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(7, 1, '2015-01-27', '2015-02-14', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(7, 2, '2015-04-13', '2015-04-17', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(7, 3, '2015-06-22', '2015-07-03', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(7, 4, '2015-08-24', '2015-09-04', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(7, 5, '2015-09-07', '2015-09-18', '2016-02-13 18:45:38', '2016-02-13 18:45:38'),
	(7, 6, '2015-09-21', '2015-10-02', '2016-02-13 18:45:39', '2016-02-13 18:45:39'),
	(7, 7, '2015-10-05', '2015-10-09', '2016-02-13 18:45:39', '2016-02-13 18:45:39'),
	(8, 8, '2016-02-29', '2016-03-04', '2016-03-01 22:07:19', '2016-03-01 22:07:19');
/*!40000 ALTER TABLE `period_school_year` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.professor
CREATE TABLE IF NOT EXISTS `professor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.professor: ~11 rows (approximately)
DELETE FROM `professor`;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` (`id`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
	(1, 'Miladin', 'Stefanović', '2015-12-06 13:27:57', '2016-03-01 20:58:34'),
	(2, 'Miloš', 'Ivanović', '2016-02-13 12:49:15', '2016-03-01 20:59:05'),
	(3, 'Tatjana', 'Stojanović', '2016-02-13 13:12:29', '2016-03-01 20:58:18'),
	(4, 'Boban', 'Stojanović', '2016-02-13 13:13:24', '2016-03-01 20:58:23'),
	(5, 'Silvana', 'Marinković', '2016-02-13 17:52:29', '2016-03-01 20:58:53'),
	(6, 'Mirjana', 'Lazić', '2016-02-13 17:59:46', '2016-03-01 20:58:59'),
	(7, 'Nebojša', 'Ikodinović', '2016-02-13 18:00:36', '2016-03-01 20:58:13'),
	(8, 'Aleksandar', 'Cvetković', '2016-02-13 18:01:40', '2016-03-01 20:57:58'),
	(9, 'Milan', 'Matijević', '2016-02-13 18:03:14', '2016-03-01 20:58:44'),
	(10, 'Nenad', 'Stefanović', '2016-02-13 18:03:45', '2016-03-01 20:58:29'),
	(11, 'Vladimir', 'Cvjetković', '2016-02-18 07:45:22', '2016-03-01 20:58:07');
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.propel_migration
CREATE TABLE IF NOT EXISTS `propel_migration` (
  `version` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.propel_migration: ~0 rows (approximately)
DELETE FROM `propel_migration`;
/*!40000 ALTER TABLE `propel_migration` DISABLE KEYS */;
INSERT INTO `propel_migration` (`version`) VALUES
	(1456821680),
	(1456853361);
/*!40000 ALTER TABLE `propel_migration` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.school_year
CREATE TABLE IF NOT EXISTS `school_year` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year` int(4) unsigned NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.school_year: ~8 rows (approximately)
DELETE FROM `school_year`;
/*!40000 ALTER TABLE `school_year` DISABLE KEYS */;
INSERT INTO `school_year` (`id`, `year`, `date_start`, `date_end`, `description`, `created_at`, `updated_at`) VALUES
	(1, 2008, '2008-10-01', '2009-09-30', 'school year 2008/2009', '2016-02-07 18:40:52', '2016-02-07 18:40:52'),
	(2, 2009, '2009-10-01', '2010-09-30', 'school year 2009/2010', '2016-02-07 18:40:52', '2016-02-07 18:40:52'),
	(3, 2010, '2010-10-01', '2011-09-30', 'School year 2010/2011', '2016-02-07 19:08:05', '2016-02-07 19:08:53'),
	(4, 2011, '2011-10-03', '2012-09-28', 'school year 2011/2012', '2016-02-09 07:51:27', '2016-02-09 07:52:01'),
	(5, 2012, '2012-10-01', '2013-09-30', 'school year 2012/2013', '2016-02-09 07:52:35', '2016-02-09 07:52:35'),
	(6, 2013, '2013-10-01', '2014-09-30', 'school year 2013/2014', '2016-02-09 07:53:03', '2016-02-09 07:53:03'),
	(7, 2014, '2014-10-01', '2015-09-30', 'school year 2014/2015', '2016-02-09 07:53:38', '2016-02-09 07:53:38'),
	(8, 2015, '2015-10-01', '2016-09-30', 'school year 2015/2016', '2016-02-09 07:54:13', '2016-02-09 07:54:13');
/*!40000 ALTER TABLE `school_year` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.student
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identification_number` int(11) unsigned NOT NULL,
  `school_year_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `birthday` date DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_st_idney` (`identification_number`,`school_year_id`),
  KEY `fk_st_co` (`course_id`),
  KEY `fk_st_sy` (`school_year_id`),
  CONSTRAINT `fk_st_co` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_st_sy` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.student: ~6 rows (approximately)
DELETE FROM `student`;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` (`id`, `identification_number`, `school_year_id`, `course_id`, `first_name`, `last_name`, `birth_place`, `birthday`, `phone_number`, `created_at`, `updated_at`) VALUES
	(1, 69, 1, 1, 'Nikola', 'Stojanovic', 'Kragujevac', '1989-01-14', '+381643820970', '2016-02-08 10:39:12', '2016-02-14 19:40:14'),
	(2, 55, 1, 1, 'Petar', 'Petrovic', 'Kragujevac', '1989-01-14', '', '2016-02-08 10:39:12', '2016-02-08 10:39:12'),
	(3, 64, 1, 1, 'Jovan', 'Jovanovic', 'Kragujevac', '1989-01-14', '', '2016-02-08 10:39:12', '2016-02-08 10:39:12'),
	(4, 71, 1, 1, 'Pera', 'Peric', 'Kragujevac', '1989-01-14', '', '2016-02-08 10:39:12', '2016-02-08 10:39:12'),
	(5, 23, 1, 1, 'Nikola', 'Nikolic', 'Kragujevac', '1989-01-14', '', '2016-02-08 10:39:12', '2016-02-08 10:39:12'),
	(6, 35, 1, 1, 'Milos', 'Milosevic', 'Kragujevac', '1989-01-14', '', '2016-02-08 10:39:12', '2016-02-08 10:39:12');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.study_program
CREATE TABLE IF NOT EXISTS `study_program` (
  `subject_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `year` int(1) unsigned NOT NULL,
  `semester` int(1) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`subject_id`,`course_id`),
  KEY `fk_sp_su` (`subject_id`),
  KEY `fk_sp_co` (`course_id`),
  CONSTRAINT `fk_sp_co` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sp_su` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.study_program: ~39 rows (approximately)
DELETE FROM `study_program`;
/*!40000 ALTER TABLE `study_program` DISABLE KEYS */;
INSERT INTO `study_program` (`subject_id`, `course_id`, `year`, `semester`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(3, 1, 3, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(4, 1, 3, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(5, 1, 1, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(6, 1, 1, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(7, 1, 1, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(8, 1, 1, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(9, 1, 1, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(10, 1, 1, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(11, 1, 1, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(12, 1, 1, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(13, 1, 1, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(14, 1, 2, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(15, 1, 2, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(16, 1, 2, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(17, 1, 2, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(18, 1, 2, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(19, 1, 2, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(20, 1, 2, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(21, 1, 2, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(22, 1, 2, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(23, 1, 2, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(24, 1, 3, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(25, 1, 3, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(26, 1, 3, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(27, 1, 3, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(28, 1, 3, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(29, 1, 3, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(30, 1, 3, 2, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(31, 1, 4, 1, '2016-02-16 08:30:42', '2016-02-16 08:30:42'),
	(32, 1, 4, 1, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(33, 1, 4, 1, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(34, 1, 4, 2, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(35, 1, 4, 2, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(36, 1, 4, 2, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(37, 1, 4, 1, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(38, 1, 4, 1, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(39, 1, 4, 2, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(40, 1, 4, 2, '2016-02-16 08:30:43', '2016-02-16 08:30:43'),
	(41, 4, 1, 1, '2016-03-02 08:13:42', '2016-03-02 08:13:42');
/*!40000 ALTER TABLE `study_program` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_sb_nm` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.subject: ~40 rows (approximately)
DELETE FROM `subject`;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
	(1, 'Osnovi programiranja', 'M151', '2015-11-30 22:00:11', '2016-02-14 17:25:17'),
	(3, 'Web programiranje', 'M175', '2016-02-05 10:52:36', '2016-02-14 17:27:06'),
	(4, 'Numerička matematika i simboličko programiranje', 'M251', '2016-02-06 17:25:38', '2016-03-01 20:56:31'),
	(5, 'Teorijske osnove informatike 1', 'M152', '2016-02-09 08:07:34', '2016-03-01 20:51:04'),
	(6, 'Linearna algebra i analitička geometrija', 'M153', '2016-02-09 08:08:13', '2016-03-01 20:51:25'),
	(7, 'Računarski sistemi', 'M154', '2016-02-09 08:08:19', '2016-03-01 20:51:41'),
	(8, 'Strukture podataka i algoritmi 1', 'M155', '2016-02-09 08:08:47', '2016-03-01 20:51:55'),
	(9, 'Matematička analiza', 'M156', '2016-02-09 08:09:01', '2016-03-01 20:52:09'),
	(10, 'Teorijske osnove informatike 2', 'M157', '2016-02-09 08:09:15', '2016-03-01 20:52:33'),
	(11, 'Arhitektura računara 1', 'M158', '2016-02-09 08:10:26', '2016-03-01 20:52:22'),
	(12, 'Engleski jezik 1', 'K102', '2016-02-09 08:10:41', '2016-02-09 08:10:41'),
	(13, 'Softverski alati 1', 'M159', '2016-02-13 17:18:24', '2016-03-01 20:52:44'),
	(14, 'Strukture podataka i algoritmi 2', 'M160', '2016-02-13 17:18:47', '2016-03-01 20:52:56'),
	(15, 'Teorijske osnove informatike 3', 'M161', '2016-02-13 17:19:05', '2016-03-01 20:54:05'),
	(16, 'Baze podataka 1', 'M162', '2016-02-13 17:19:28', '2016-03-01 20:53:56'),
	(17, 'Operativni sistemi 1', 'M163', '2016-02-13 17:19:43', '2016-03-01 20:53:46'),
	(18, 'Objektno-orijentisano programiranje', 'M164', '2016-02-13 17:19:59', '2016-03-01 20:53:38'),
	(19, 'Klijentske Web tehnologije', 'M165', '2016-02-13 17:20:18', '2016-02-13 17:20:18'),
	(20, 'Računarske mreže i mrežne tehnologije', 'M166', '2016-02-13 17:20:24', '2016-03-01 20:53:08'),
	(21, 'Softverski alati 2', 'M181', '2016-02-13 17:20:43', '2016-03-01 20:56:49'),
	(22, 'Bioetika', 'B125', '2016-02-13 17:20:56', '2016-03-01 20:49:59'),
	(23, 'Engleski jezik 2', 'K106', '2016-02-13 17:21:08', '2016-02-13 17:21:08'),
	(24, 'Vizuelno programiranje', 'M167', '2016-02-13 17:21:20', '2016-03-01 20:54:22'),
	(25, 'Informacioni sistemi 1', 'M168', '2016-02-13 17:21:34', '2016-03-01 20:54:28'),
	(26, 'Algoritamske strategije', 'M169', '2016-02-13 17:21:39', '2016-03-01 20:54:37'),
	(27, 'Inteligentni sistemi 1', 'M172', '2016-02-13 17:21:52', '2016-02-13 17:21:52'),
	(28, 'Softverski inženjering 1', 'M173', '2016-02-13 17:22:06', '2016-02-13 17:22:06'),
	(29, 'Stručna praksa', 'M267', '2016-02-13 17:22:19', '2016-03-01 20:55:09'),
	(30, 'Elektronsko poslovanje', 'M174', '2016-02-13 17:22:34', '2016-03-01 20:54:45'),
	(31, 'Operativni sistemi 2', 'M252', '2016-02-13 17:22:45', '2016-03-01 20:56:07'),
	(32, 'Formalni jezici, automati i jezički procesori', 'M253', '2016-02-13 17:23:01', '2016-03-01 20:55:58'),
	(33, 'Baze podataka 2', 'M255', '2016-02-13 17:23:07', '2016-03-01 20:55:46'),
	(34, 'Programiranje složenih softverskih sistema', 'M176', '2016-02-13 17:23:26', '2016-03-01 20:54:56'),
	(35, 'Projektni zadatak', 'M177', '2016-02-13 17:23:36', '2016-03-01 20:57:11'),
	(36, 'Završni rad', 'M182', '2016-02-13 17:23:49', '2016-03-01 20:56:40'),
	(37, 'Primenjena informatika', 'M259', '2016-02-13 17:24:03', '2016-03-01 20:55:26'),
	(38, 'Izborni seminar', 'M257', '2016-02-13 17:24:13', '2016-03-01 20:55:33'),
	(39, 'Informacioni sistemi 2', 'M263', '2016-02-13 17:24:37', '2016-03-01 20:55:16'),
	(40, 'Paralelno programiranje', 'M180', '2016-02-13 17:24:45', '2016-03-01 20:57:02'),
	(41, 'Matematička logika i teorija skupova', 'M101', '2016-02-16 10:44:45', '2016-03-01 20:50:53');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.translation_application
CREATE TABLE IF NOT EXISTS `translation_application` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.translation_application: ~0 rows (approximately)
DELETE FROM `translation_application`;
/*!40000 ALTER TABLE `translation_application` DISABLE KEYS */;
INSERT INTO `translation_application` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'backend', '2015-11-18 16:46:40', '2015-11-18 16:46:40');
/*!40000 ALTER TABLE `translation_application` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.translation_catalog
CREATE TABLE IF NOT EXISTS `translation_catalog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `application_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'messages',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_tnct_an` (`application_id`,`name`),
  KEY `fk_tnct_tnap` (`application_id`),
  CONSTRAINT `fk_tnct_tnap` FOREIGN KEY (`application_id`) REFERENCES `translation_application` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.translation_catalog: ~0 rows (approximately)
DELETE FROM `translation_catalog`;
/*!40000 ALTER TABLE `translation_catalog` DISABLE KEYS */;
INSERT INTO `translation_catalog` (`id`, `application_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 1, 'general', '2015-11-18 16:46:40', '2015-11-18 16:46:40');
/*!40000 ALTER TABLE `translation_catalog` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.translation_keyword
CREATE TABLE IF NOT EXISTS `translation_keyword` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) unsigned NOT NULL,
  `keyword` mediumtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tnkw_tnct` (`catalog_id`),
  CONSTRAINT `fk_tnkw_tnct` FOREIGN KEY (`catalog_id`) REFERENCES `translation_catalog` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.translation_keyword: ~52 rows (approximately)
DELETE FROM `translation_keyword`;
/*!40000 ALTER TABLE `translation_keyword` DISABLE KEYS */;
INSERT INTO `translation_keyword` (`id`, `catalog_id`, `keyword`, `created_at`, `updated_at`) VALUES
	(7, 1, 'SET_LANGUAGE', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(8, 1, 'LOGOUT', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(9, 1, 'ADMIN', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(10, 1, 'USERS', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(11, 1, 'TRANSLATIONS', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(19, 1, 'LOGIN', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(20, 1, 'REGISTER', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(21, 1, 'PASSWORD', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(22, 1, 'TRANSLATION', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(23, 1, 'USER', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(24, 1, 'CANCEL', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(25, 1, 'ADD_OBJ', '2015-11-18 16:46:40', '2016-03-01 21:15:25'),
	(26, 1, 'EDIT_OBJ', '2015-11-18 16:46:40', '2016-03-01 21:15:12'),
	(32, 1, 'LOGIN_SUCCESS', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(33, 1, 'REGISTER_SUCCESS_TITLE', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(34, 1, 'REGISTER_SUCCESS_MESSAGE', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(50, 1, 'BACK', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(77, 1, 'PLEASE_LOGIN', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(78, 1, 'LOGIN_FAILED', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(79, 1, 'WOOPS_PROBLEM', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(80, 1, 'NAME', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(81, 1, 'EMAIL_ADDRESS', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(82, 1, 'PASSWORD_CONFIRM', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(83, 1, 'RESET', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(84, 1, 'SEARCH', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(85, 1, 'APP_TITLE', '2015-11-30 09:41:26', '2015-11-30 09:43:31'),
	(86, 1, 'ADVANCED', '2015-11-30 20:07:24', '2015-11-30 20:07:24'),
	(87, 1, 'APPLICATIONS', '2015-11-30 20:08:13', '2015-11-30 20:08:13'),
	(89, 1, 'APPLICATION', '2015-11-30 22:53:22', '2015-11-30 22:53:22'),
	(90, 1, 'BASIC', '2015-12-04 10:28:40', '2015-12-04 10:28:40'),
	(91, 1, 'ENGAGEMENT', '2015-12-04 10:29:20', '2015-12-04 10:29:20'),
	(92, 1, 'SUBJECT', '2015-12-04 10:30:14', '2015-12-04 10:30:14'),
	(93, 1, 'COURSE', '2015-12-04 10:30:32', '2015-12-04 10:30:32'),
	(94, 1, 'PERIOD', '2015-12-04 10:30:47', '2015-12-04 10:30:47'),
	(95, 1, 'STUDENT', '2015-12-04 10:31:01', '2015-12-04 10:31:01'),
	(96, 1, 'PROFESSOR', '2015-12-04 10:31:18', '2015-12-04 10:31:18'),
	(103, 1, 'DELETED', '2015-12-04 11:41:56', '2015-12-04 11:41:56'),
	(104, 1, 'UPDATED', '2015-12-04 11:48:13', '2015-12-04 11:48:13'),
	(105, 1, 'ADDED', '2015-12-04 11:49:17', '2015-12-04 11:49:17'),
	(106, 1, 'LIST', '2015-12-07 11:47:47', '2015-12-07 11:47:47'),
	(107, 1, 'SUBJECTS', '2015-12-10 18:48:54', '2015-12-10 18:48:54'),
	(108, 1, 'DELETE_OBJ', '2015-12-10 18:53:20', '2016-03-01 21:16:52'),
	(109, 1, 'ENGAGEMENTS', '2015-12-10 19:05:10', '2015-12-10 19:05:10'),
	(110, 1, 'COURSES', '2015-12-10 19:06:40', '2015-12-10 19:06:40'),
	(111, 1, 'PERIODS', '2015-12-10 19:06:55', '2015-12-10 19:06:55'),
	(112, 1, 'STUDENTS', '2015-12-10 19:07:08', '2015-12-10 19:07:08'),
	(113, 1, 'PROFESSORS', '2015-12-10 19:07:26', '2015-12-10 19:07:26'),
	(114, 1, 'SCHOOL_YEAR', '2016-02-07 18:36:14', '2016-02-07 18:36:14'),
	(115, 1, 'DASHBOARD', '2016-02-10 07:54:20', '2016-02-10 07:54:20'),
	(116, 1, 'SELECT_YEAR', '2016-02-13 09:42:43', '2016-02-13 09:42:43'),
	(117, 1, 'STUDY_PROGRAM', '2016-02-18 09:49:15', '2016-02-18 09:49:15'),
	(118, 1, 'APPLICATION_BY_SUBJECT', '2016-02-19 11:19:11', '2016-02-19 11:19:11'),
	(119, 1, 'APPLICATION_OBJ', '2016-03-01 21:16:10', '2016-03-01 21:16:10'),
	(120, 1, 'ADDITIONAL_INFO', '2016-03-01 21:17:48', '2016-03-01 21:17:48'),
	(121, 1, 'APPLICATION_REQUEST', '2016-03-01 21:18:20', '2016-03-01 21:19:41'),
	(122, 1, 'USER_OBJ', '2016-03-01 21:22:20', '2016-03-01 21:22:20');
/*!40000 ALTER TABLE `translation_keyword` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.translation_language
CREATE TABLE IF NOT EXISTS `translation_language` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `culture` varchar(7) NOT NULL,
  `locale` varchar(7) NOT NULL,
  `is_active` int(4) unsigned DEFAULT '0',
  `is_default` int(4) unsigned DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.translation_language: ~13 rows (approximately)
DELETE FROM `translation_language`;
/*!40000 ALTER TABLE `translation_language` DISABLE KEYS */;
INSERT INTO `translation_language` (`id`, `name`, `culture`, `locale`, `is_active`, `is_default`, `created_at`, `updated_at`) VALUES
	(1, 'English', 'en', 'en_US', 1, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(2, 'Deutsch', 'de', 'de_DE', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(3, 'Français', 'fr', 'fr_FR', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(4, 'Español', 'es', 'es_ES', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(5, 'Italiano', 'it', 'it_IT', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(6, 'Ελληνικά', 'el', 'el_GR', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(7, '简体中文', 'zh', 'zh_CN', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(8, '日本語', 'ja', 'ja_JP', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(9, 'dansk', 'dk', 'da_DK', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(10, 'Српски', 'sr', 'sr_RS', 1, 1, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(11, 'česky', 'cs', 'cs_CZ', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(12, 'русский', 'ru', 'ru_RU', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(13, 'العربية', 'ar', 'ar_SA', 0, 0, '2015-11-18 16:46:40', '2015-11-18 16:46:40');
/*!40000 ALTER TABLE `translation_language` ENABLE KEYS */;

-- Dumping structure for table sms_prijava.translation_language_keyword
CREATE TABLE IF NOT EXISTS `translation_language_keyword` (
  `language_id` int(11) unsigned NOT NULL,
  `keyword_id` int(11) unsigned NOT NULL,
  `translation` mediumtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`language_id`,`keyword_id`),
  KEY `fk_tnlnkw_tnln` (`language_id`),
  KEY `fk_tnlnkw_tnkw` (`keyword_id`),
  CONSTRAINT `fk_tnlnkw_tnkw` FOREIGN KEY (`language_id`) REFERENCES `translation_language` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tnlnkw_tnln` FOREIGN KEY (`keyword_id`) REFERENCES `translation_keyword` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sms_prijava.translation_language_keyword: ~104 rows (approximately)
DELETE FROM `translation_language_keyword`;
/*!40000 ALTER TABLE `translation_language_keyword` DISABLE KEYS */;
INSERT INTO `translation_language_keyword` (`language_id`, `keyword_id`, `translation`, `created_at`, `updated_at`) VALUES
	(1, 7, 'Set languagee', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 8, 'Logout', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 9, 'Admin', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 10, 'Users', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 11, 'Translations', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 19, 'Login', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 20, 'Register', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 21, 'Password', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 22, 'Translation', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 23, 'User', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 24, 'Cancel', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 25, 'Add :attribute', '2015-11-18 16:46:40', '2015-12-07 12:10:07'),
	(1, 26, 'Edit :attribute', '2015-11-18 16:46:40', '2015-12-10 18:51:06'),
	(1, 32, 'You are successfully logged in.', '2015-11-18 16:46:40', '2015-11-30 12:02:55'),
	(1, 33, 'Successfully registered', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 34, 'Please wait till admin does not approve your account.', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 50, 'Back', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 77, 'Please login', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 78, 'These credentials do not match our records.', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 79, 'Whoops! There were some problems with your input.', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 80, 'Name', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 81, 'E-Mail Address', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 82, 'Confirm password', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 83, 'Reset', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 84, 'Search', '2015-11-18 16:46:40', '2015-11-18 16:46:40'),
	(1, 85, 'SMS APPLICATION', '2015-11-30 09:41:26', '2015-11-30 09:41:26'),
	(1, 86, 'Advanced settings', '2015-11-30 20:07:24', '2015-11-30 20:07:24'),
	(1, 87, 'Applications', '2015-11-30 20:08:13', '2015-11-30 20:08:13'),
	(1, 89, 'Application', '2015-11-30 22:53:22', '2015-11-30 22:53:22'),
	(1, 90, 'Basic settings', '2015-12-04 10:28:40', '2015-12-04 10:28:40'),
	(1, 91, 'Engagement', '2015-12-04 10:29:20', '2015-12-04 10:29:20'),
	(1, 92, 'Subject', '2015-12-04 10:30:14', '2015-12-04 10:30:14'),
	(1, 93, 'Course', '2015-12-04 10:30:32', '2015-12-04 10:30:32'),
	(1, 94, 'Period', '2015-12-04 10:30:47', '2015-12-04 10:30:47'),
	(1, 95, 'Student', '2015-12-04 10:31:01', '2015-12-04 10:31:01'),
	(1, 96, 'Professor', '2015-12-04 10:31:18', '2015-12-04 10:31:18'),
	(1, 103, ':attribute is successfully deleted.', '2015-12-04 11:41:56', '2015-12-04 11:41:56'),
	(1, 104, ':attribute is successfully updated.', '2015-12-04 11:48:13', '2015-12-04 11:48:13'),
	(1, 105, ':attribute is successfully added.', '2015-12-04 11:49:17', '2015-12-04 11:49:17'),
	(1, 106, ':attribute List', '2015-12-07 11:47:47', '2015-12-07 11:47:47'),
	(1, 107, 'Subjects', '2015-12-10 18:48:54', '2015-12-10 18:48:54'),
	(1, 108, 'Delete :attribute', '2015-12-10 18:53:20', '2015-12-10 18:53:20'),
	(1, 109, 'Engagements', '2015-12-10 19:05:10', '2015-12-10 19:05:10'),
	(1, 110, 'Courses', '2015-12-10 19:06:40', '2015-12-10 19:06:40'),
	(1, 111, 'Periods', '2015-12-10 19:06:55', '2015-12-10 19:06:55'),
	(1, 112, 'Students', '2015-12-10 19:07:08', '2015-12-10 19:07:08'),
	(1, 113, 'Professores', '2015-12-10 19:07:26', '2015-12-10 19:07:26'),
	(1, 114, 'School year', '2016-02-07 18:36:14', '2016-02-07 18:36:14'),
	(1, 115, 'Dashboard', '2016-02-10 07:54:20', '2016-02-10 07:54:20'),
	(1, 116, 'Select year', '2016-02-13 09:42:43', '2016-02-13 09:42:43'),
	(1, 117, 'Study program', '2016-02-18 09:49:15', '2016-02-18 09:49:15'),
	(1, 118, 'Application by subject', '2016-02-19 11:19:11', '2016-02-19 11:19:11'),
	(1, 119, 'Application', '2016-03-01 21:16:10', '2016-03-01 21:16:10'),
	(1, 120, 'Additional info', '2016-03-01 21:17:48', '2016-03-01 21:17:48'),
	(1, 121, 'Application request', '2016-03-01 21:18:20', '2016-03-01 21:18:20'),
	(1, 122, 'User', '2016-03-01 21:22:20', '2016-03-01 21:22:20'),
	(10, 7, 'Podesi jezik', '2015-11-30 09:00:09', '2015-11-30 09:00:09'),
	(10, 8, 'Izloguj se', '2015-11-30 09:00:53', '2015-11-30 09:00:53'),
	(10, 9, 'Admin', '2015-11-30 09:01:01', '2015-11-30 09:01:01'),
	(10, 10, 'Korisnici', '2015-11-30 09:01:13', '2015-11-30 09:01:13'),
	(10, 11, 'Prevodi', '2015-11-30 09:02:07', '2015-12-10 18:45:02'),
	(10, 19, 'Prijava', '2015-11-30 09:08:30', '2015-11-30 09:08:30'),
	(10, 20, 'Registruj se', '2015-11-30 09:08:58', '2015-11-30 09:08:58'),
	(10, 21, 'Šifra', '2015-11-30 09:09:14', '2015-11-30 09:09:14'),
	(10, 22, 'Prevod', '2015-11-30 09:09:28', '2015-11-30 09:09:28'),
	(10, 23, 'Korisnik', '2015-11-30 09:09:38', '2015-12-11 08:30:20'),
	(10, 24, 'Otkaži', '2015-11-30 09:09:56', '2015-11-30 09:09:56'),
	(10, 25, 'Dodaj :attribute', '2015-11-30 09:10:03', '2015-12-07 12:10:07'),
	(10, 26, 'Izmeni :attribute', '2015-11-30 09:10:12', '2015-12-10 18:51:06'),
	(10, 32, 'Uspešno ste prijavljeni.', '2015-11-30 09:19:36', '2015-11-30 09:19:36'),
	(10, 33, 'Uspešna registracija', '2015-11-30 09:19:12', '2015-11-30 09:19:12'),
	(10, 34, 'Molimo sa?ekajte dok administrator ne odobri vaš nalog.', '2015-11-30 09:18:45', '2015-11-30 09:18:45'),
	(10, 50, 'Nazad', '2015-11-30 09:18:05', '2015-11-30 09:18:05'),
	(10, 77, 'Molim vas prijavite se', '2015-11-30 09:17:53', '2015-11-30 09:17:53'),
	(10, 78, 'Podaci se ne podudaraju.', '2015-11-30 09:17:14', '2015-11-30 09:17:14'),
	(10, 79, 'Ups! Postoji problem sa unetim podacima.', '2015-11-30 09:16:44', '2015-11-30 09:16:44'),
	(10, 80, 'Ime', '2015-11-30 09:15:24', '2015-11-30 09:15:24'),
	(10, 81, 'E-Mail Adresa', '2015-11-30 09:15:16', '2015-11-30 09:15:16'),
	(10, 82, 'Potvrdi šifru', '2015-11-30 09:14:55', '2015-11-30 09:14:55'),
	(10, 83, 'Resetuj', '2015-11-30 09:14:21', '2015-11-30 09:14:21'),
	(10, 84, 'Pretraga', '2015-11-30 09:13:36', '2015-11-30 09:13:36'),
	(10, 85, 'SMS PRIJAVE', '2015-11-30 09:41:26', '2015-11-30 09:41:26'),
	(10, 86, 'Napredna podešavanja', '2015-11-30 20:07:24', '2015-11-30 20:07:24'),
	(10, 87, 'Prijave', '2015-11-30 20:08:13', '2015-11-30 20:08:13'),
	(10, 89, 'Prijavu', '2015-11-30 22:53:22', '2015-12-11 08:28:48'),
	(10, 90, 'Osnovna podešavanja', '2015-12-04 10:28:40', '2015-12-04 10:29:59'),
	(10, 91, 'Angažovanje', '2015-12-04 10:29:20', '2015-12-04 10:29:20'),
	(10, 92, 'Predmet', '2015-12-04 10:30:14', '2015-12-04 10:30:14'),
	(10, 93, 'Smer', '2015-12-04 10:30:32', '2015-12-04 10:30:32'),
	(10, 94, 'Rok', '2015-12-04 10:30:47', '2015-12-04 10:30:47'),
	(10, 95, 'Student', '2015-12-04 10:31:01', '2015-12-11 08:30:09'),
	(10, 96, 'Profesor', '2015-12-04 10:31:18', '2015-12-11 08:30:03'),
	(10, 103, ':attribute je uspešno obrisan.', '2015-12-04 11:41:56', '2015-12-04 11:41:56'),
	(10, 104, ':attribute je uspešno ažuriran.', '2015-12-04 11:48:13', '2015-12-04 11:48:13'),
	(10, 105, ':attribute je uspešno dodat.', '2015-12-04 11:49:17', '2015-12-04 11:49:17'),
	(10, 106, 'Lista :attribute', '2015-12-07 11:47:47', '2015-12-07 11:47:47'),
	(10, 107, 'Predmeti', '2015-12-10 18:48:54', '2015-12-10 18:48:54'),
	(10, 108, 'Obriši :attribute', '2015-12-10 18:53:20', '2015-12-10 18:53:20'),
	(10, 109, 'Angažovanja', '2015-12-10 19:05:10', '2015-12-10 19:05:10'),
	(10, 110, 'Smerovi', '2015-12-10 19:06:40', '2015-12-10 19:06:40'),
	(10, 111, 'Rokovi', '2015-12-10 19:06:55', '2015-12-10 19:06:55'),
	(10, 112, 'Studenti', '2015-12-10 19:07:08', '2015-12-10 19:07:08'),
	(10, 113, 'Profesori', '2015-12-10 19:07:26', '2015-12-10 19:07:26'),
	(10, 114, 'Školska godina', '2016-02-07 18:36:14', '2016-02-07 18:36:14'),
	(10, 115, 'Oglasna tabla', '2016-02-10 07:54:20', '2016-02-10 07:54:20'),
	(10, 116, 'Odaberi godinu', '2016-02-13 09:42:43', '2016-02-13 09:42:43'),
	(10, 117, 'Studijski program', '2016-02-18 09:49:15', '2016-02-18 09:49:15'),
	(10, 118, 'Prijave po predmetima', '2016-02-19 11:19:11', '2016-02-19 11:19:11'),
	(10, 119, 'Prijavu', '2016-03-01 21:16:10', '2016-03-01 21:16:10'),
	(10, 120, 'Dodatne informacije', '2016-03-01 21:17:48', '2016-03-01 21:17:48'),
	(10, 121, 'Zahtevi za prijave', '2016-03-01 21:18:20', '2016-03-01 21:18:20'),
	(10, 122, 'Korisnika', '2016-03-01 21:22:20', '2016-03-01 21:22:20');
/*!40000 ALTER TABLE `translation_language_keyword` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
