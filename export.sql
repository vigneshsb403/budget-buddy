-- Adminer 4.8.1 MySQL 8.3.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `vignesh_photogram` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `vignesh_photogram`;

DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` tinytext NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `blocked` int NOT NULL DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '0',
  `sec_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `name` (`username`(20)),
  UNIQUE KEY `email` (`email`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `auth` (`id`, `username`, `password`, `phone`, `email`, `blocked`, `active`, `sec_email`) VALUES
(1,	'vignesh',	'$2y$09$m6v.eDJ2ElDBUa7caKDPZOSwYHubIu1KNZDtaF3EuPDLuAfMgy9tK',	'8754059030',	'vignesh@icloud.com',	0,	0,	NULL),
(2,	'hacker',	'$2y$09$Th2seLupCPgI/1o22r3GFeEjX5FptfvPACka0LIB9xiChRGlteLyi',	'9876543210',	'hacker@gmail.com',	0,	0,	NULL);

DROP TABLE IF EXISTS `expenditure_data`;
CREATE TABLE `expenditure_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `expenditure_amount` decimal(10,2) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `expenditure_data` (`id`, `date`, `expenditure_amount`, `user_name`) VALUES
(2,	'2024-03-14',	123.00,	'vignesh'),
(3,	'2024-03-12',	450.00,	'vignesh'),
(4,	'2024-03-06',	1234.00,	'hacker');

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` varchar(32) NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `like` int NOT NULL,
  `timestamp` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `notification_table`;
CREATE TABLE `notification_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bill_title` varchar(255) NOT NULL,
  `bill_cost` decimal(10,2) NOT NULL,
  `note` text,
  `username` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `notification_table` (`id`, `bill_title`, `bill_cost`, `note`, `username`, `created_at`) VALUES
(1,	'haced',	345.00,	'dfefd',	'hacker',	'2024-03-15 16:22:16'),
(2,	'hddddd',	456.00,	'you got hacked',	'hacker',	'2024-03-15 16:24:51'),
(3,	'hddddd',	456.00,	'you got hacked',	'vignesh',	'2024-03-15 16:24:51'),
(4,	'lhfdlfjd',	234.00,	'fdfdsf',	'hacker',	'2024-03-15 16:36:15'),
(5,	'lhfdlfjd',	234.00,	'fdfdsf',	'vignesh',	'2024-03-15 16:36:15'),
(6,	'dfasdfdasf',	500.00,	'sfdsf',	'hacker',	'2024-03-15 16:40:18'),
(7,	'dfasdfdasf',	500.00,	'sfdsf',	'vignesh',	'2024-03-15 16:40:18');

DROP TABLE IF EXISTS `post_images`;
CREATE TABLE `post_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `image_uri` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_text` varchar(160) CHARACTER SET utf32 COLLATE utf32_bin NOT NULL,
  `multiple_images` int NOT NULL DEFAULT '0',
  `image_uri` varchar(1024) CHARACTER SET utf32 COLLATE utf32_bin NOT NULL,
  `like_count` int NOT NULL,
  `uploaded_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `owner` varchar(128) CHARACTER SET utf32 COLLATE utf32_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;


DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `login_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(20) NOT NULL,
  `user_agent` varchar(256) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `fingerprint` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `session_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `auth` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `session` (`id`, `uid`, `token`, `login_time`, `ip`, `user_agent`, `active`, `fingerprint`) VALUES
(4,	2,	'662939d04b237236aeeb6dc90cf3f06f',	'2024-03-15 15:54:41',	'192.168.65.1',	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Safari/605.1.15',	1,	'f86ae69cda320aeffef7555dd8da8dc8'),
(7,	2,	'8551a32d42aad48aa624f8a0eac74fc4',	'2024-03-15 16:01:46',	'192.168.65.1',	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Safari/605.1.15',	1,	'f86ae69cda320aeffef7555dd8da8dc8'),
(8,	2,	'7771ad8588b0319dfeb199f4675a3545',	'2024-03-15 16:02:20',	'192.168.65.1',	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Safari/605.1.15',	1,	'f86ae69cda320aeffef7555dd8da8dc8'),
(9,	2,	'd813450c4b9406b81ec6e61f0cb684ad',	'2024-03-15 16:02:32',	'192.168.65.1',	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Safari/605.1.15',	1,	'f86ae69cda320aeffef7555dd8da8dc8'),
(13,	2,	'50300a7df7ebaeb3f792dd7b68fafcd2',	'2024-03-15 16:03:56',	'192.168.65.1',	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Safari/605.1.15',	1,	'f86ae69cda320aeffef7555dd8da8dc8');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL,
  `bio` longtext NOT NULL,
  `avatar` varchar(1024) NOT NULL,
  `firstname` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastname` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dob` date NOT NULL,
  `instagram` varchar(1024) NOT NULL,
  `twitter` varchar(1024) NOT NULL,
  `facebook` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id`) REFERENCES `auth` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2024-03-15 16:46:57
