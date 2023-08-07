-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `emp_certifications`;
CREATE TABLE `emp_certifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(100) NOT NULL,
  `completion_date` varchar(100) NOT NULL,
  `expiry_date` varchar(100) NOT NULL,
  `status` enum('active','expired') NOT NULL,
  `level` enum('basic','intermediate','advanced') NOT NULL,
  `additional_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `certification_employee_id` (`employee_id`),
  KEY `certification_status` (`status`),
  KEY `certification_name` (`name`),
  CONSTRAINT `emp_certifications_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `emp_employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `emp_companies`;
CREATE TABLE `emp_companies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `company_name` (`name`),
  KEY `company_domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `emp_employees`;
CREATE TABLE `emp_employees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `job_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `qualifications` varchar(100) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `employee_company_id` (`company_id`),
  KEY `employee_job_id` (`job_id`),
  KEY `employee_salary` (`salary`),
  CONSTRAINT `emp_employees_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `emp_companies` (`id`),
  CONSTRAINT `emp_employees_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `emp_jobs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `emp_job_levels`;
CREATE TABLE `emp_job_levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `job_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `job_level_company_id` (`company_id`),
  KEY `job_id` (`job_id`),
  CONSTRAINT `emp_job_levels_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `emp_companies` (`id`),
  CONSTRAINT `emp_job_levels_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `emp_jobs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `emp_job_positions`;
CREATE TABLE `emp_job_positions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `job_level_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `skill` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `salary_range` varchar(255) NOT NULL,
  `status` enum('open','closed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `position_company_id` (`company_id`),
  KEY `position_title` (`title`),
  KEY `position_status` (`status`),
  KEY `job_level_id` (`job_level_id`),
  CONSTRAINT `emp_job_positions_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `emp_companies` (`id`),
  CONSTRAINT `emp_job_positions_ibfk_2` FOREIGN KEY (`job_level_id`) REFERENCES `emp_job_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `emp_jobs`;
CREATE TABLE `emp_jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `job_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `emp_previous_experiences`;
CREATE TABLE `emp_previous_experiences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `job_responsibilites` varchar(100) NOT NULL,
  `employment_location` varchar(255) NOT NULL,
  `employment_type` enum('full_time','part_time','contract_based','internship') DEFAULT NULL,
  `reason_for_leaving` varchar(255) NOT NULL,
  `additional_notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `previous_experience_employee_id` (`employee_id`),
  KEY `previous_experience_name` (`name`),
  KEY `previous_experience_start_date` (`start_date`),
  KEY `previous_experience_end_date` (`end_date`),
  CONSTRAINT `emp_previous_experiences_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `emp_employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `emp_resignations`;
CREATE TABLE `emp_resignations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `company_id` int NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT (now()),
  `updated_at` timestamp NOT NULL DEFAULT (now()),
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `resignation_employee_id` (`employee_id`),
  KEY `resignation_status` (`status`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `emp_resignations_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `emp_employees` (`id`),
  CONSTRAINT `emp_resignations_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `emp_companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2023-08-07 10:30:22