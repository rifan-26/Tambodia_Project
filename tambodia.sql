-- --------------------------------------------------------
-- Host:                         10.12.13.166
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tambodia_project
CREATE DATABASE IF NOT EXISTS `tambodia_project` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tambodia_project`;

-- Dumping structure for table tambodia_project.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.cache: ~0 rows (approximately)
DELETE FROM `cache`;

-- Dumping structure for table tambodia_project.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table tambodia_project.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table tambodia_project.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table tambodia_project.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table tambodia_project.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logs_user_id_foreign` (`user_id`),
  CONSTRAINT `logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.logs: ~41 rows (approximately)
DELETE FROM `logs`;
INSERT INTO `logs` (`id`, `user_id`, `action`, `description`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Login', 'User logged in', '2025-08-21 22:21:49', '2025-08-21 22:21:49'),
	(2, 2, 'Login', 'User logged in', '2025-08-21 22:23:14', '2025-08-21 22:23:14'),
	(3, 1, 'Login', 'User logged in', '2025-08-21 22:29:15', '2025-08-21 22:29:15'),
	(4, 2, 'Login', 'User logged in', '2025-08-21 22:38:04', '2025-08-21 22:38:04'),
	(5, 1, 'Login', 'User logged in', '2025-08-21 22:39:39', '2025-08-21 22:39:39'),
	(6, 2, 'Login', 'User logged in', '2025-08-21 22:40:10', '2025-08-21 22:40:10'),
	(7, 2, 'Login', 'User logged in', '2025-08-21 23:45:11', '2025-08-21 23:45:11'),
	(8, 2, 'Login', 'User logged in', '2025-08-22 00:26:50', '2025-08-22 00:26:50'),
	(9, 2, 'Upload Media', 'Uploaded Audio: hidup', '2025-08-22 00:27:50', '2025-08-22 00:27:50'),
	(10, 2, 'Upload Media', 'Uploaded Gambar: kaoru', '2025-08-22 00:28:28', '2025-08-22 00:28:28'),
	(11, 1, 'Login', 'User logged in', '2025-08-22 00:29:28', '2025-08-22 00:29:28'),
	(12, 2, 'Login', 'User logged in', '2025-08-22 00:33:07', '2025-08-22 00:33:07'),
	(13, 2, 'Toggle Landing Status', 'Media kaoru ditampilkan dari landing page', '2025-08-22 00:33:20', '2025-08-22 00:33:20'),
	(14, 2, 'Toggle Landing Status', 'Media kaoru disembunyikan dari landing page', '2025-08-22 00:33:22', '2025-08-22 00:33:22'),
	(15, 2, 'Upload Media', 'Uploaded Gambar file \'hw\' (Original: wallpaperflare.com_wallpaper.jpg, Size: 9.18KB)', '2025-08-22 00:35:26', '2025-08-22 00:35:26'),
	(16, 2, 'Toggle Landing Status', 'Media hw ditampilkan dari landing page', '2025-08-22 00:35:31', '2025-08-22 00:35:31'),
	(17, 2, 'Toggle Landing Status', 'Media hw disembunyikan dari landing page', '2025-08-22 00:35:34', '2025-08-22 00:35:34'),
	(18, 2, 'Delete Media', 'Deleted Audio: hidup', '2025-08-22 00:37:07', '2025-08-22 00:37:07'),
	(19, 2, 'Delete Media', 'Deleted Gambar: kaoru', '2025-08-22 00:37:09', '2025-08-22 00:37:09'),
	(20, 2, 'Delete Media', 'Deleted Gambar: hw', '2025-08-22 00:37:12', '2025-08-22 00:37:12'),
	(21, 2, 'Login', 'User logged in', '2025-08-22 01:00:53', '2025-08-22 01:00:53'),
	(22, 2, 'Login', 'User logged in', '2025-08-22 01:01:42', '2025-08-22 01:01:42'),
	(23, 2, 'Login', 'User logged in', '2025-08-22 01:06:08', '2025-08-22 01:06:08'),
	(24, 7, 'Login', 'User logged in', '2025-08-24 18:12:40', '2025-08-24 18:12:40'),
	(25, 7, 'Upload Media', 'Uploaded Gambar: rr', '2025-08-24 18:13:17', '2025-08-24 18:13:17'),
	(26, 7, 'Set Landing Media', 'Set 1 media to show on landing page', '2025-08-24 18:13:51', '2025-08-24 18:13:51'),
	(27, 6, 'Login', 'User logged in', '2025-08-24 18:15:34', '2025-08-24 18:15:34'),
	(28, 7, 'Login', 'User logged in', '2025-08-24 18:17:06', '2025-08-24 18:17:06'),
	(29, 7, 'Set Landing Media', 'Set 1 media to show on landing page', '2025-08-24 18:17:12', '2025-08-24 18:17:12'),
	(30, 7, 'Delete Media', 'Deleted Gambar: rr', '2025-08-24 18:17:16', '2025-08-24 18:17:16'),
	(31, 7, 'Login', 'User logged in', '2025-08-24 18:19:03', '2025-08-24 18:19:03'),
	(32, 7, 'Login', 'User logged in', '2025-08-24 18:22:34', '2025-08-24 18:22:34'),
	(33, 7, 'Login', 'User logged in', '2025-08-24 18:44:15', '2025-08-24 18:44:15'),
	(34, 7, 'Login', 'User logged in', '2025-08-24 18:57:20', '2025-08-24 18:57:20'),
	(35, 7, 'Login', 'User logged in', '2025-08-24 18:58:37', '2025-08-24 18:58:37'),
	(36, 7, 'Login', 'User logged in', '2025-08-24 19:05:06', '2025-08-24 19:05:06'),
	(37, 7, 'Login', 'User logged in', '2025-08-24 19:12:05', '2025-08-24 19:12:05'),
	(38, 7, 'Login', 'User logged in', '2025-08-24 19:14:52', '2025-08-24 19:14:52'),
	(39, 7, 'Login', 'User logged in', '2025-08-24 19:15:36', '2025-08-24 19:15:36'),
	(40, 7, 'Upload Media', 'Uploaded Gambar: vbcgcvcgvgb', '2025-08-24 19:16:43', '2025-08-24 19:16:43'),
	(41, 7, 'Delete Media', 'Deleted Gambar: vbcgcvcgvgb', '2025-08-24 19:16:52', '2025-08-24 19:16:52');

-- Dumping structure for table tambodia_project.media
CREATE TABLE IF NOT EXISTS `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Gambar','Video','Audio') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `show_on_landing` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_user_id_foreign` (`user_id`),
  CONSTRAINT `media_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.media: ~0 rows (approximately)
DELETE FROM `media`;

-- Dumping structure for table tambodia_project.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.migrations: ~8 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_08_04_021110_create_media_table', 2),
	(5, '2025_08_11_020541_create_schedules_table', 2),
	(7, '2025_08_04_020858_add_role_to_users_table', 3),
	(8, '2025_08_11_020549_create_logs_table', 3),
	(9, '2025_08_13_020525_add_show_on_landing_to_media_table', 4),
	(10, '2025_08_22_051738_create_sessions_table', 4);

-- Dumping structure for table tambodia_project.schedules
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `media_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `day_of_week` enum('senin','selasa','rabu','kamis','jumat','sabtu','minggu') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_media_id_foreign` (`media_id`),
  CONSTRAINT `schedules_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.schedules: ~0 rows (approximately)
DELETE FROM `schedules`;

-- Dumping structure for table tambodia_project.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.sessions: ~2 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('385kXn8G0XzqZXmpapC0ESYqODmTtZIWCIfFtc6a', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRzNEb3pocG5yeGx4dk9EeFRuSnFJbVVjU01NOHI4QXdHcmFoMGNGTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnB1dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1756088097),
	('zAaD0exS629ZpZXaapSTqvX8yk9A06n5TSeUnomK', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVzFPS2NHWk9ZQ3lZY2Q1MjFKRFlad0lBYTFJVUFFbkFZOFdkU0o1WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnB1dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1756088214);

-- Dumping structure for table tambodia_project.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pegawai',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tambodia_project.users: ~6 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'superadmin@tambodia.com', '2025-08-21 22:13:27', '$2y$12$q5JOR.CzzFa9KDc2rr.zyeoNAnzvN6rDYR5X5TiwTZCNgJ6ygnkPO', 'superadmin', NULL, '2025-08-21 22:13:27', '2025-08-21 22:13:27'),
	(2, 'Employee One', 'employee1@tambodia.com', '2025-08-21 22:13:27', '$2y$12$27ge7Moui0mZnPOBD5VaP.JQKfGv1D3dxQ0qgWfyNDndP19qWgUfS', 'pegawai', NULL, '2025-08-21 22:13:27', '2025-08-21 22:13:27'),
	(3, 'Employee Two', 'employee2@tambodia.com', '2025-08-21 22:13:27', '$2y$12$6adY/eV.OE8aX3NAeBrAyO6bTwthYn8Sg8WrN/do2FQP2gkv0p95y', 'pegawai', NULL, '2025-08-21 22:13:27', '2025-08-21 22:13:27'),
	(4, 'Employee Three', 'employee3@tambodia.com', '2025-08-21 22:13:28', '$2y$12$E8aTizhjY8hcjeksJc0cg.WKyYXcvCNydV7U8No7F6jzubTcMP7C2', 'pegawai', NULL, '2025-08-21 22:13:28', '2025-08-21 22:13:28'),
	(6, 'Super Admin', 'superadmin@admin.com', NULL, '$2y$12$l1do/KiGLpsBCkcsQw7ICu/UZ8yfiI9UApmqyiOqIMPL5WmhhY796', 'superadmin', NULL, '2025-08-24 18:10:00', '2025-08-24 18:10:00'),
	(7, 'Employee User', 'employee@admin.com', NULL, '$2y$12$7lSf35YvK/5FUzYgieTS3.KzzEtq5GZPJX.0MG4AWBuwro55hQAwm', 'pegawai', NULL, '2025-08-24 18:10:01', '2025-08-24 18:10:01');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
