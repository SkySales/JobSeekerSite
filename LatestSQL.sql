-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for food_delivery
CREATE DATABASE IF NOT EXISTS `food_delivery` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `food_delivery`;

-- Dumping structure for table food_delivery.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table food_delivery.admins: ~1 rows (approximately)
INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
	(3, 'asd', '$2y$10$X0361xKqkUd/ZzgrBvBldev.Uh0iju9JTaBJO/cp8rkaF82K/q.0.');

-- Dumping structure for table food_delivery.job_applications
CREATE TABLE IF NOT EXISTS `job_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `cover_letter` text NOT NULL,
  `resume` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `job_title` varchar(255) NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table food_delivery.job_applications: ~1 rows (approximately)
INSERT INTO `job_applications` (`id`, `firstname`, `lastname`, `email`, `phone`, `cover_letter`, `resume`, `created_at`, `job_title`, `status`, `username`) VALUES
	(32, 'Sky', 'Sales', 'skysales0321@gmail.com', '9561459834', 'asdasd', 'Netcom_Presentation (4).pdf', '2024-12-09 04:41:49', 'Full Stack Developer', 'Accepted', 'asd');

-- Dumping structure for table food_delivery.job_postings
CREATE TABLE IF NOT EXISTS `job_postings` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table food_delivery.job_postings: ~3 rows (approximately)
INSERT INTO `job_postings` (`job_id`, `job_title`, `job_description`, `location`, `salary`, `image_path`, `last_updated`) VALUES
	(22, 'Full Stack Developer', 'We are seeking a skilled Full Stack Developer to join our team. The ideal candidate will be responsible for designing, developing, and maintaining web applications, ensuring they are user-friendly, efficient, and scalable. This role requires proficiency in both front-end and back-end technologies.', 'Dasmarinas, Cavite', '-', '/uploads/images.jpg', '2024-12-07 19:15:57'),
	(23, 'Web Developer', 'We are seeking a skilled Full Stack Developer to join our team. The ideal candidate will be responsible for designing, developing, and maintaining web applications, ensuring they are user-friendly, efficient, and scalable. This role requires proficiency in both front-end and back-end technologies.', 'Dasmarinas, Cavite', '-', '/uploads/images.jpg', '2024-12-09 04:29:49'),
	(24, 'Software Development', 'We are seeking a skilled Full Stack Developer to join our team. The ideal candidate will be responsible for designing, developing, and maintaining web applications, ensuring they are user-friendly, efficient, and scalable. This role requires proficiency in both front-end and back-end technologies.', 'Dasmarinas, Cavite', '-', '/uploads/images.jpg', '2024-12-09 04:30:15');

-- Dumping structure for table food_delivery.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table food_delivery.messages: ~1 rows (approximately)
INSERT INTO `messages` (`id`, `username`, `message`, `created_at`, `email`) VALUES
	(4, 'asd', 'asdasdasd', '2024-12-09 05:31:29', 'skysales0321@gmail.com');

-- Dumping structure for table food_delivery.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table food_delivery.password_resets: ~1 rows (approximately)
INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
	(1, 'mabs3271@gmail.com', 'd8f17212595764bdbdd9c4633df81d47ddbe9cd434bec7e63e8c217e9e1f1ee7acc2813720a845b93f19e9ba1d69048fe35c', '2024-10-26 00:00:48');

-- Dumping structure for table food_delivery.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table food_delivery.users: ~2 rows (approximately)
INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `created_at`, `profile_picture`) VALUES
	(7, 'Marc', '$2y$10$.llJXd5J6gkAmpIBgL./5.VzHttaZSCHAdrj/xvFiWkr2f.mfcIIa', 'mabs3271@gmail.com', '0956145976', '2024-10-23 03:16:01', NULL),
	(9, 'asd', '$2y$10$INcYhudStmXBvFsxQxyVwOZku8GkosrOKaHri3.hj0tk/19ExopXO', 'skysalesss0321@gmail.com', '09561459834', '2024-12-03 17:37:18', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
