-- Adminer 4.8.1 MySQL 8.3.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `apis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `apis`;

DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(512) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `active` int DEFAULT NULL,
  `token` varchar(512) DEFAULT NULL,
  `signup_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `folders`;
CREATE TABLE `folders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `owner` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `body` longtext NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `owner` varchar(45) NOT NULL,
  `folder_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `access_token` varchar(128) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `valid` int DEFAULT '1',
  `refresh_token` varchar(128) DEFAULT NULL,
  `valid_for` int DEFAULT '7200',
  `reference_token` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token_UNIQUE` (`access_token`),
  UNIQUE KEY `refresh_token_UNIQUE` (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `shares`;
CREATE TABLE `shares` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(54) NOT NULL COMMENT 'Can be ‘note’ or ‘folder’',
  `share_with` varchar(45) NOT NULL,
  `object_id` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE DATABASE `budget-buddies` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `budget-buddies`;

DROP TABLE IF EXISTS `bills`;
CREATE TABLE `bills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `splitter_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `splitter_id` (`splitter_id`),
  CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`splitter_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `expenditure_data`;
CREATE TABLE `expenditure_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `expenditure_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `expenditure_data` (`id`, `date`, `expenditure_amount`) VALUES
(1,	'2024-03-01',	100.00),
(2,	'2024-03-02',	150.50),
(3,	'2024-03-03',	200.25),
(4,	'2024-03-04',	180.75),
(5,	'2024-03-05',	190.80),
(6,	'2024-03-06',	220.40),
(7,	'2024-03-07',	120.60),
(8,	'2024-03-08',	130.00),
(9,	'2024-03-09',	170.25),
(10,	'2024-03-10',	185.50),
(11,	'2024-03-11',	160.75),
(12,	'2024-03-12',	210.80),
(13,	'2024-03-13',	240.40),
(14,	'2024-03-14',	130.60),
(15,	'2024-02-01',	110.00),
(16,	'2024-02-02',	120.50),
(17,	'2024-02-03',	130.25),
(18,	'2024-02-04',	140.75),
(19,	'2024-02-05',	150.80),
(20,	'2024-02-06',	160.40),
(21,	'2024-02-07',	170.60),
(22,	'2024-01-01',	90.00),
(23,	'2024-01-02',	95.50),
(24,	'2024-01-03',	100.25),
(25,	'2024-01-04',	105.75),
(26,	'2024-01-05',	110.80),
(27,	'2024-01-06',	115.40),
(28,	'2024-01-07',	120.60),
(29,	'2022-03-01',	123.00),
(31,	'2024-03-13',	340.98);

DROP TABLE IF EXISTS `sample_table`;
CREATE TABLE `sample_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `column1` varchar(255) DEFAULT NULL,
  `column2` varchar(255) DEFAULT NULL,
  `column3` varchar(255) DEFAULT NULL,
  `column4` varchar(255) DEFAULT NULL,
  `column5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `sample_table` (`id`, `column1`, `column2`, `column3`, `column4`, `column5`) VALUES
(1,	'value1',	'value2',	'value3',	'value4',	'value5'),
(2,	'value1',	'value2',	'value3',	'value4',	'value5'),
(3,	'value2',	'value2',	'value3',	'value4',	'value5'),
(4,	'value2',	'value3',	'value3',	'value4',	'value5'),
(5,	'value3',	'value4',	'value5',	'value6',	'value7'),
(6,	'value4',	'value5',	'value6',	'value7',	'value8'),
(7,	'value5',	'value6',	'value7',	'value8',	'value9'),
(8,	'value6',	'value7',	'value8',	'value9',	'value10'),
(9,	'value7',	'value8',	'value9',	'value10',	'value11'),
(10,	'value8',	'value9',	'value10',	'value11',	'value12');

DROP TABLE IF EXISTS `user_bills`;
CREATE TABLE `user_bills` (
  `user_id` int DEFAULT NULL,
  `bill_id` int DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `bill_id` (`bill_id`),
  CONSTRAINT `user_bills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_bills_ibfk_2` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2024-03-14 13:22:55
