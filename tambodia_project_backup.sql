-- Database Export: tambodia_project
-- Generated: 2025-11-13 04:56:30

SET FOREIGN_KEY_CHECKS=0;

-- Table: cache
DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cache_locks
DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
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

-- Table: job_batches
DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
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

-- Table: jobs
DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
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

-- Table: layout_settings
DROP TABLE IF EXISTS `layout_settings`;

CREATE TABLE `layout_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `background_image_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `layout_settings_user_id_unique` (`user_id`),
  KEY `layout_settings_background_image_id_foreign` (`background_image_id`),
  CONSTRAINT `layout_settings_background_image_id_foreign` FOREIGN KEY (`background_image_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `layout_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: layout_settings
INSERT INTO `layout_settings` VALUES ('1', '4', '', NULL, '2025-10-19 19:20:44', '2025-10-30 10:00:12');
INSERT INTO `layout_settings` VALUES ('2', '1', '', NULL, '2025-10-20 11:52:05', '2025-10-20 11:52:05');
INSERT INTO `layout_settings` VALUES ('3', '3', '', NULL, '2025-11-11 13:41:37', '2025-11-11 13:41:37');

-- Table: layout_templates
DROP TABLE IF EXISTS `layout_templates`;

CREATE TABLE `layout_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `background_media_id` bigint unsigned DEFAULT NULL,
  `grid_positions` json DEFAULT NULL,
  `layout_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `layout_templates_is_active_index` (`is_active`),
  KEY `layout_templates_created_by_index` (`created_by`),
  KEY `layout_templates_background_media_id_foreign` (`background_media_id`),
  CONSTRAINT `layout_templates_background_media_id_foreign` FOREIGN KEY (`background_media_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `layout_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: layout_templates
INSERT INTO `layout_templates` VALUES ('1', 'Template Default BPS', 'Template default untuk halaman landing BPS dengan grid 2x2', NULL, NULL, NULL, '0', '1', '2025-11-09 14:27:49', '2025-11-09 14:27:49', NULL);
INSERT INTO `layout_templates` VALUES ('2', 'Template 3 Kolom', 'Template dengan 3 kolom untuk menampilkan informasi side by side', NULL, NULL, NULL, '0', '1', '2025-11-09 14:27:49', '2025-11-09 17:12:29', '2025-11-09 17:12:29');
INSERT INTO `layout_templates` VALUES ('3', 'Template Grid Besar', 'Template dengan grid 3x3 untuk banyak konten', NULL, NULL, NULL, '0', '1', '2025-11-09 14:27:49', '2025-11-09 17:12:31', '2025-11-09 17:12:31');

-- Table: logs
DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logs_user_id_foreign` (`user_id`),
  CONSTRAINT `logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: logs
INSERT INTO `logs` VALUES ('1', '4', 'Login', 'User logged in', '2025-10-19 19:19:58', '2025-10-19 19:19:58');
INSERT INTO `logs` VALUES ('2', '4', 'Update Admin', 'Updated admin account: samuel@tambodia.com', '2025-10-19 19:20:25', '2025-10-19 19:20:25');
INSERT INTO `logs` VALUES ('3', '4', 'Update Admin', 'Updated admin account: nadiah@tambodia.com', '2025-10-19 19:20:30', '2025-10-19 19:20:30');
INSERT INTO `logs` VALUES ('4', '4', 'Update Admin', 'Updated admin account: galuh@tambodia.com', '2025-10-19 19:20:35', '2025-10-19 19:20:35');
INSERT INTO `logs` VALUES ('5', '4', 'Upload Media', 'Uploaded Gambar: image 10', '2025-10-19 19:41:32', '2025-10-19 19:41:32');
INSERT INTO `logs` VALUES ('6', '4', 'Upload Media', 'Uploaded Video: Llaa', '2025-10-19 19:42:05', '2025-10-19 19:42:05');
INSERT INTO `logs` VALUES ('7', '4', 'Upload Media', 'Uploaded Audio: ssstik.io_1760882452101', '2025-10-19 21:01:39', '2025-10-19 21:01:39');
INSERT INTO `logs` VALUES ('8', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760882452101 (duration: s)', '2025-10-19 21:02:08', '2025-10-19 21:02:08');
INSERT INTO `logs` VALUES ('9', '4', 'Login', 'User logged in', '2025-10-20 07:59:54', '2025-10-20 07:59:54');
INSERT INTO `logs` VALUES ('10', '4', 'Update Schedule', 'Updated schedule for media: ssstik.io_1760882452101', '2025-10-20 08:01:09', '2025-10-20 08:01:09');
INSERT INTO `logs` VALUES ('11', '4', 'Upload Media', 'Uploaded Audio: ssstik.io_1760923414618', '2025-10-20 08:23:40', '2025-10-20 08:23:40');
INSERT INTO `logs` VALUES ('12', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760923414618 (duration: s)', '2025-10-20 08:23:51', '2025-10-20 08:23:51');
INSERT INTO `logs` VALUES ('13', '4', 'Update Schedule', 'Updated schedule for media: ssstik.io_1760923414618', '2025-10-20 10:00:36', '2025-10-20 10:00:36');
INSERT INTO `logs` VALUES ('14', '4', 'Update Schedule', 'Updated schedule for media: ssstik.io_1760923414618', '2025-10-20 10:02:26', '2025-10-20 10:02:26');
INSERT INTO `logs` VALUES ('15', '4', 'Login', 'User logged in', '2025-10-20 10:29:35', '2025-10-20 10:29:35');
INSERT INTO `logs` VALUES ('16', '4', 'Update Admin', 'Updated admin account: rifan@tambodia.com', '2025-10-20 10:33:22', '2025-10-20 10:33:22');
INSERT INTO `logs` VALUES ('17', '4', 'Logout', 'User logged out', '2025-10-20 10:33:39', '2025-10-20 10:33:39');
INSERT INTO `logs` VALUES ('18', '4', 'Login', 'User logged in', '2025-10-20 10:33:55', '2025-10-20 10:33:55');
INSERT INTO `logs` VALUES ('19', '4', 'Update Schedule', 'Updated schedule for media: ssstik.io_1760923414618', '2025-10-20 10:34:40', '2025-10-20 10:34:40');
INSERT INTO `logs` VALUES ('20', '4', 'Upload Media', 'Uploaded Audio: KEBANGKITAN KING MU', '2025-10-20 10:45:32', '2025-10-20 10:45:32');
INSERT INTO `logs` VALUES ('21', '4', 'Create Audio Schedule', 'Created audio schedule for: KEBANGKITAN KING MU (duration: s)', '2025-10-20 10:47:20', '2025-10-20 10:47:20');
INSERT INTO `logs` VALUES ('22', '4', 'Update Schedule', 'Updated schedule for media: KEBANGKITAN KING MU', '2025-10-20 10:58:23', '2025-10-20 10:58:23');
INSERT INTO `logs` VALUES ('23', '4', 'Logout', 'User logged out', '2025-10-20 11:07:38', '2025-10-20 11:07:38');
INSERT INTO `logs` VALUES ('24', '4', 'Login', 'User logged in', '2025-10-20 11:14:51', '2025-10-20 11:14:51');
INSERT INTO `logs` VALUES ('25', '4', 'Delete Media', 'Deleted Video: Llaa', '2025-10-20 11:14:52', '2025-10-20 11:14:52');
INSERT INTO `logs` VALUES ('26', '1', 'Login', 'User logged in', '2025-10-20 11:50:31', '2025-10-20 11:50:31');
INSERT INTO `logs` VALUES ('27', '1', 'Upload Media', 'Uploaded Gambar: Chainsaw man (1)', '2025-10-20 11:56:13', '2025-10-20 11:56:13');
INSERT INTO `logs` VALUES ('28', '4', 'Login', 'User logged in', '2025-10-21 09:12:26', '2025-10-21 09:12:26');
INSERT INTO `logs` VALUES ('29', '4', 'Logout', 'User logged out', '2025-10-21 09:13:19', '2025-10-21 09:13:19');
INSERT INTO `logs` VALUES ('30', '4', 'Login', 'User logged in', '2025-10-21 09:13:35', '2025-10-21 09:13:35');
INSERT INTO `logs` VALUES ('31', '4', 'Upload Media', 'Uploaded Gambar: danau toba', '2025-10-21 09:15:15', '2025-10-21 09:15:15');
INSERT INTO `logs` VALUES ('32', '4', 'Upload Media', 'Uploaded Gambar: img potrait 2 1', '2025-10-21 09:15:35', '2025-10-21 09:15:35');
INSERT INTO `logs` VALUES ('33', '4', 'Upload Media', 'Uploaded Gambar: img 1.1 4', '2025-10-21 09:15:57', '2025-10-21 09:15:57');
INSERT INTO `logs` VALUES ('34', '2', 'Login', 'User logged in', '2025-10-21 09:20:52', '2025-10-21 09:20:52');
INSERT INTO `logs` VALUES ('35', '4', 'Create Visual Schedule', 'Created visual schedule for: img potrait 2 1 at position: 2', '2025-10-21 10:17:50', '2025-10-21 10:17:50');
INSERT INTO `logs` VALUES ('36', '4', 'Logout', 'User logged out', '2025-10-21 10:36:31', '2025-10-21 10:36:31');
INSERT INTO `logs` VALUES ('37', '4', 'Login', 'User logged in', '2025-10-22 09:36:49', '2025-10-22 09:36:49');
INSERT INTO `logs` VALUES ('38', '4', 'Logout', 'User logged out', '2025-10-22 10:22:09', '2025-10-22 10:22:09');
INSERT INTO `logs` VALUES ('39', '4', 'Login', 'User logged in', '2025-10-22 21:34:29', '2025-10-22 21:34:29');
INSERT INTO `logs` VALUES ('40', '4', 'Logout', 'User logged out', '2025-10-22 21:56:10', '2025-10-22 21:56:10');
INSERT INTO `logs` VALUES ('41', '4', 'Login', 'User logged in', '2025-10-22 21:56:20', '2025-10-22 21:56:20');
INSERT INTO `logs` VALUES ('42', '4', 'Login', 'User logged in', '2025-10-23 08:22:32', '2025-10-23 08:22:32');
INSERT INTO `logs` VALUES ('43', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760882452101 and removed from landing page', '2025-10-23 08:29:11', '2025-10-23 08:29:11');
INSERT INTO `logs` VALUES ('44', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760923414618 and removed from landing page', '2025-10-23 08:29:14', '2025-10-23 08:29:14');
INSERT INTO `logs` VALUES ('45', '4', 'Delete Schedule', 'Deleted schedule for media: KEBANGKITAN KING MU and removed from landing page', '2025-10-23 08:29:17', '2025-10-23 08:29:17');
INSERT INTO `logs` VALUES ('46', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760923414618 (duration: s)', '2025-10-23 08:35:50', '2025-10-23 08:35:50');
INSERT INTO `logs` VALUES ('47', '4', 'Update Schedule', 'Updated schedule for media: ssstik.io_1760923414618', '2025-10-23 08:39:33', '2025-10-23 08:39:33');
INSERT INTO `logs` VALUES ('48', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760882452101 (duration: s)', '2025-10-23 08:39:52', '2025-10-23 08:39:52');
INSERT INTO `logs` VALUES ('49', '4', 'Logout', 'User logged out', '2025-10-23 08:41:16', '2025-10-23 08:41:16');
INSERT INTO `logs` VALUES ('50', '4', 'Login', 'User logged in', '2025-10-23 08:56:54', '2025-10-23 08:56:54');
INSERT INTO `logs` VALUES ('51', '4', 'Delete Schedule', 'Deleted schedule for media: img potrait 2 1 and removed from landing page', '2025-10-23 08:57:16', '2025-10-23 08:57:16');
INSERT INTO `logs` VALUES ('52', '4', 'Create Audio Schedule', 'Created audio schedule for: KEBANGKITAN KING MU (duration: s)', '2025-10-23 09:01:14', '2025-10-23 09:01:14');
INSERT INTO `logs` VALUES ('53', '4', 'Delete Schedule', 'Deleted schedule for media: KEBANGKITAN KING MU and removed from landing page', '2025-10-23 09:04:45', '2025-10-23 09:04:45');
INSERT INTO `logs` VALUES ('54', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760923414618 and removed from landing page', '2025-10-23 09:04:48', '2025-10-23 09:04:48');
INSERT INTO `logs` VALUES ('55', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760882452101 and removed from landing page', '2025-10-23 09:04:50', '2025-10-23 09:04:50');
INSERT INTO `logs` VALUES ('56', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760923414618 (duration: s)', '2025-10-23 09:05:00', '2025-10-23 09:05:00');
INSERT INTO `logs` VALUES ('57', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760923414618 and removed from landing page', '2025-10-23 09:05:15', '2025-10-23 09:05:15');
INSERT INTO `logs` VALUES ('58', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760882452101 (duration: s)', '2025-10-23 09:05:53', '2025-10-23 09:05:53');
INSERT INTO `logs` VALUES ('59', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760882452101 and removed from landing page', '2025-10-23 09:07:41', '2025-10-23 09:07:41');
INSERT INTO `logs` VALUES ('60', '2', 'Login', 'User logged in', '2025-10-23 09:22:55', '2025-10-23 09:22:55');
INSERT INTO `logs` VALUES ('61', '4', 'Upload Media', 'Uploaded Video: CONTOH', '2025-10-23 09:44:45', '2025-10-23 09:44:45');
INSERT INTO `logs` VALUES ('62', '4', 'Create Visual Schedule', 'Created visual schedule for: CONTOH at position: 2', '2025-10-23 09:44:58', '2025-10-23 09:44:58');
INSERT INTO `logs` VALUES ('63', '4', 'Delete Schedule', 'Deleted schedule for media: CONTOH and removed from landing page', '2025-10-23 11:13:00', '2025-10-23 11:13:00');
INSERT INTO `logs` VALUES ('64', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760923414618 (duration: s)', '2025-10-23 11:13:10', '2025-10-23 11:13:10');
INSERT INTO `logs` VALUES ('65', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760923414618 and removed from landing page', '2025-10-23 11:17:24', '2025-10-23 11:17:24');
INSERT INTO `logs` VALUES ('66', '4', 'Create Visual Schedule', 'Created visual schedule for: CONTOH at position: 2', '2025-10-23 11:17:42', '2025-10-23 11:17:42');
INSERT INTO `logs` VALUES ('67', '4', 'Delete Schedule', 'Deleted schedule for media: CONTOH and removed from landing page', '2025-10-23 11:22:22', '2025-10-23 11:22:22');
INSERT INTO `logs` VALUES ('68', '4', 'Create Visual Schedule', 'Created visual schedule for: CONTOH at position: 2', '2025-10-23 11:34:04', '2025-10-23 11:34:04');
INSERT INTO `logs` VALUES ('69', '4', 'Delete Schedule', 'Deleted schedule for media: CONTOH and removed from landing page', '2025-10-23 11:53:44', '2025-10-23 11:53:44');
INSERT INTO `logs` VALUES ('70', '4', 'Create Visual Schedule', 'Created visual schedule for: CONTOH at position: 2', '2025-10-23 11:54:14', '2025-10-23 11:54:14');
INSERT INTO `logs` VALUES ('71', '4', 'Create Visual Schedule', 'Created visual schedule for: danau toba at position: 2', '2025-10-23 12:01:27', '2025-10-23 12:01:27');
INSERT INTO `logs` VALUES ('72', '4', 'Delete Schedule', 'Deleted schedule for media: CONTOH and removed from landing page', '2025-10-23 12:01:38', '2025-10-23 12:01:38');
INSERT INTO `logs` VALUES ('73', '4', 'Delete Schedule', 'Deleted schedule for media: danau toba and removed from landing page', '2025-10-23 12:13:30', '2025-10-23 12:13:30');
INSERT INTO `logs` VALUES ('74', '4', 'Create Visual Schedule', 'Created visual schedule for: CONTOH at position: 2', '2025-10-23 12:55:42', '2025-10-23 12:55:42');
INSERT INTO `logs` VALUES ('75', '4', 'Delete Media', 'Deleted Video: CONTOH', '2025-10-23 12:58:51', '2025-10-23 12:58:51');
INSERT INTO `logs` VALUES ('76', '4', 'Upload Media', 'Uploaded Video: BOM', '2025-10-23 13:01:09', '2025-10-23 13:01:09');
INSERT INTO `logs` VALUES ('77', '4', 'Delete Media', 'Deleted Video: BOM', '2025-10-23 13:01:11', '2025-10-23 13:01:11');
INSERT INTO `logs` VALUES ('78', '4', 'Create Visual Schedule', 'Created visual schedule for: danau toba at position: 2', '2025-10-23 13:03:51', '2025-10-23 13:03:51');
INSERT INTO `logs` VALUES ('79', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760923414618 (duration: s)', '2025-10-23 13:15:55', '2025-10-23 13:15:55');
INSERT INTO `logs` VALUES ('80', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1760923414618 and removed from landing page', '2025-10-23 13:16:13', '2025-10-23 13:16:13');
INSERT INTO `logs` VALUES ('81', '1', 'Login', 'User logged in', '2025-10-23 13:18:23', '2025-10-23 13:18:23');
INSERT INTO `logs` VALUES ('82', '4', 'Upload Media', 'Uploaded Audio: ssstik.io_1761200266647', '2025-10-23 13:18:37', '2025-10-23 13:18:37');
INSERT INTO `logs` VALUES ('83', '1', 'Delete Media', 'Deleted Gambar: Chainsaw man (1)', '2025-10-23 13:18:52', '2025-10-23 13:18:52');
INSERT INTO `logs` VALUES ('84', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761200266647 (duration: s)', '2025-10-23 13:19:11', '2025-10-23 13:19:11');
INSERT INTO `logs` VALUES ('85', '1', 'Upload Media', 'Uploaded Gambar: ⭒!🐈_⬛', '2025-10-23 13:19:15', '2025-10-23 13:19:15');
INSERT INTO `logs` VALUES ('86', '1', 'Upload Media', 'Uploaded Video: Group 18', '2025-10-23 13:20:16', '2025-10-23 13:20:16');
INSERT INTO `logs` VALUES ('87', '4', 'Delete Media', 'Deleted Audio: ssstik.io_1761200266647', '2025-10-23 13:21:30', '2025-10-23 13:21:30');
INSERT INTO `logs` VALUES ('88', '4', 'Delete Media', 'Deleted Gambar: img 1.1 4', '2025-10-23 13:21:32', '2025-10-23 13:21:32');
INSERT INTO `logs` VALUES ('89', '4', 'Delete Media', 'Deleted Gambar: img potrait 2 1', '2025-10-23 13:21:34', '2025-10-23 13:21:34');
INSERT INTO `logs` VALUES ('90', '4', 'Delete Media', 'Deleted Gambar: danau toba', '2025-10-23 13:21:35', '2025-10-23 13:21:35');
INSERT INTO `logs` VALUES ('91', '4', 'Delete Media', 'Deleted Audio: KEBANGKITAN KING MU', '2025-10-23 13:21:37', '2025-10-23 13:21:37');
INSERT INTO `logs` VALUES ('92', '4', 'Delete Media', 'Deleted Audio: ssstik.io_1760923414618', '2025-10-23 13:21:39', '2025-10-23 13:21:39');
INSERT INTO `logs` VALUES ('93', '4', 'Delete Media', 'Deleted Audio: ssstik.io_1760882452101', '2025-10-23 13:21:41', '2025-10-23 13:21:41');
INSERT INTO `logs` VALUES ('94', '4', 'Delete Media', 'Deleted Gambar: image 10', '2025-10-23 13:21:42', '2025-10-23 13:21:42');
INSERT INTO `logs` VALUES ('95', '1', 'Login', 'User logged in', '2025-10-23 13:30:51', '2025-10-23 13:30:51');
INSERT INTO `logs` VALUES ('96', '1', 'Delete Media', 'Deleted Video: Group 18', '2025-10-23 13:31:00', '2025-10-23 13:31:00');
INSERT INTO `logs` VALUES ('97', '1', 'Delete Media', 'Deleted Gambar: ⭒!🐈_⬛', '2025-10-23 13:31:01', '2025-10-23 13:31:01');
INSERT INTO `logs` VALUES ('98', '1', 'Login', 'User logged in', '2025-10-23 13:31:23', '2025-10-23 13:31:23');
INSERT INTO `logs` VALUES ('99', '1', 'Upload Media', 'Uploaded Gambar: download (4)', '2025-10-23 13:32:13', '2025-10-23 13:32:13');
INSERT INTO `logs` VALUES ('100', '1', 'Upload Media', 'Uploaded Gambar: download (4)', '2025-10-23 13:32:50', '2025-10-23 13:32:50');
INSERT INTO `logs` VALUES ('101', '1', 'Delete Media', 'Deleted Gambar: download (4)', '2025-10-23 13:35:31', '2025-10-23 13:35:31');
INSERT INTO `logs` VALUES ('102', '4', 'Upload Media', 'Uploaded Audio: ssstik.io_1760930824517', '2025-10-23 13:35:41', '2025-10-23 13:35:41');
INSERT INTO `logs` VALUES ('103', '4', 'Upload Media', 'Uploaded Audio: ssstik.io_1761200266647', '2025-10-23 13:37:17', '2025-10-23 13:37:17');
INSERT INTO `logs` VALUES ('104', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761200266647 (duration: s)', '2025-10-23 13:37:35', '2025-10-23 13:37:35');
INSERT INTO `logs` VALUES ('105', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1761200266647 and removed from landing page', '2025-10-23 13:44:06', '2025-10-23 13:44:06');
INSERT INTO `logs` VALUES ('106', '4', 'Create Visual Schedule', 'Created visual schedule for: download (4) at position: 3', '2025-10-23 13:45:50', '2025-10-23 13:45:50');
INSERT INTO `logs` VALUES ('107', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761200266647 (duration: s)', '2025-10-23 14:00:32', '2025-10-23 14:00:32');
INSERT INTO `logs` VALUES ('108', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1761200266647 and removed from landing page', '2025-10-23 14:03:37', '2025-10-23 14:03:37');
INSERT INTO `logs` VALUES ('109', '4', 'Delete Schedule', 'Deleted schedule for media: download (4) and removed from landing page', '2025-10-23 14:03:41', '2025-10-23 14:03:41');
INSERT INTO `logs` VALUES ('110', '4', 'Upload Media', 'Uploaded Audio: ssstik.io_1761203282618', '2025-10-23 14:08:29', '2025-10-23 14:08:29');
INSERT INTO `logs` VALUES ('111', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761200266647 (duration: s)', '2025-10-23 14:12:56', '2025-10-23 14:12:56');
INSERT INTO `logs` VALUES ('112', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1761200266647 and removed from landing page', '2025-10-23 14:13:11', '2025-10-23 14:13:11');
INSERT INTO `logs` VALUES ('113', '4', 'Upload Media', 'Uploaded Audio: ssstik.io_1761203636152', '2025-10-23 14:14:25', '2025-10-23 14:14:25');
INSERT INTO `logs` VALUES ('114', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761203636152 (duration: s)', '2025-10-23 14:14:35', '2025-10-23 14:14:35');
INSERT INTO `logs` VALUES ('115', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1761203636152 and removed from landing page', '2025-10-23 14:15:28', '2025-10-23 14:15:28');
INSERT INTO `logs` VALUES ('116', '4', 'Upload Media', 'Uploaded Gambar: danau toba img1 1', '2025-10-23 14:17:58', '2025-10-23 14:17:58');
INSERT INTO `logs` VALUES ('117', '4', 'Upload Media', 'Uploaded Gambar: image 10', '2025-10-23 14:18:10', '2025-10-23 14:18:10');
INSERT INTO `logs` VALUES ('118', '4', 'Logout', 'User logged out', '2025-10-23 14:27:26', '2025-10-23 14:27:26');
INSERT INTO `logs` VALUES ('119', '1', 'Login', 'User logged in', '2025-10-23 14:27:54', '2025-10-23 14:27:54');
INSERT INTO `logs` VALUES ('120', '1', 'Create Admin', 'Created admin account: Bps@tambodia.com', '2025-10-23 14:29:44', '2025-10-23 14:29:44');
INSERT INTO `logs` VALUES ('121', '1', 'Update Admin', 'Updated admin account: Bps@tambodia.com', '2025-10-23 14:30:08', '2025-10-23 14:30:08');
INSERT INTO `logs` VALUES ('122', '1', 'Delete Admin', 'Deleted admin account: Bps@tambodia.com', '2025-10-23 14:30:20', '2025-10-23 14:30:20');
INSERT INTO `logs` VALUES ('123', '1', 'Logout', 'User logged out', '2025-10-23 14:30:28', '2025-10-23 14:30:28');
INSERT INTO `logs` VALUES ('124', '4', 'Login', 'User logged in', '2025-10-23 14:30:48', '2025-10-23 14:30:48');
INSERT INTO `logs` VALUES ('125', '4', 'Upload Media', 'Uploaded Gambar: Lompat Batu', '2025-10-23 14:32:18', '2025-10-23 14:32:18');
INSERT INTO `logs` VALUES ('126', '4', 'Upload Media', 'Uploaded Video: Video', '2025-10-23 14:35:22', '2025-10-23 14:35:22');
INSERT INTO `logs` VALUES ('127', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761203282618 (duration: s)', '2025-10-23 14:35:52', '2025-10-23 14:35:52');
INSERT INTO `logs` VALUES ('128', '4', 'Create Visual Schedule', 'Created visual schedule for: image 10 at position: 1', '2025-10-23 14:36:53', '2025-10-23 14:36:53');
INSERT INTO `logs` VALUES ('129', '4', 'Upload Media', 'Uploaded Video: gh', '2025-10-23 15:22:19', '2025-10-23 15:22:19');
INSERT INTO `logs` VALUES ('130', '4', 'Upload Media', 'Uploaded Video: ig', '2025-10-23 15:23:55', '2025-10-23 15:23:55');
INSERT INTO `logs` VALUES ('131', '4', 'Login', 'User logged in', '2025-10-29 08:43:19', '2025-10-29 08:43:19');
INSERT INTO `logs` VALUES ('132', '4', 'Upload Media', 'Uploaded Video: tiktok', '2025-10-29 09:40:19', '2025-10-29 09:40:19');
INSERT INTO `logs` VALUES ('133', '4', 'Delete Media', 'Deleted Video: ig', '2025-10-29 09:40:32', '2025-10-29 09:40:32');
INSERT INTO `logs` VALUES ('134', '4', 'Delete Media', 'Deleted Video: Video', '2025-10-29 09:40:52', '2025-10-29 09:40:52');
INSERT INTO `logs` VALUES ('135', '4', 'Upload Media', 'Uploaded Video: ig', '2025-10-29 09:43:34', '2025-10-29 09:43:34');
INSERT INTO `logs` VALUES ('136', '4', 'Upload Media', 'Uploaded Video: yt', '2025-10-29 09:44:15', '2025-10-29 09:44:15');
INSERT INTO `logs` VALUES ('137', '4', 'Delete Media', 'Deleted Video: ig', '2025-10-29 10:11:45', '2025-10-29 10:11:45');
INSERT INTO `logs` VALUES ('138', '4', 'Delete Media', 'Deleted Video: tiktok', '2025-10-29 10:11:49', '2025-10-29 10:11:49');
INSERT INTO `logs` VALUES ('139', '4', 'Delete Media', 'Deleted Video: gh', '2025-10-29 10:17:39', '2025-10-29 10:17:39');
INSERT INTO `logs` VALUES ('140', '4', 'Logout', 'User logged out', '2025-10-29 13:40:51', '2025-10-29 13:40:51');
INSERT INTO `logs` VALUES ('141', '4', 'Login', 'User logged in', '2025-10-29 13:41:04', '2025-10-29 13:41:04');
INSERT INTO `logs` VALUES ('142', '1', 'Login', 'User logged in', '2025-10-29 14:47:26', '2025-10-29 14:47:26');
INSERT INTO `logs` VALUES ('143', '4', 'Create Visual Schedule', 'Created visual schedule for: yt at position: 2', '2025-10-29 15:14:38', '2025-10-29 15:14:38');
INSERT INTO `logs` VALUES ('144', '4', 'Update Schedule', 'Updated schedule for media: yt', '2025-10-29 15:14:55', '2025-10-29 15:14:55');
INSERT INTO `logs` VALUES ('145', '4', 'Delete Schedule', 'Deleted schedule for media: yt and removed from landing page', '2025-10-29 15:15:15', '2025-10-29 15:15:15');
INSERT INTO `logs` VALUES ('146', '4', 'Delete Schedule', 'Deleted schedule for media: image 10 and removed from landing page', '2025-10-29 15:15:20', '2025-10-29 15:15:20');
INSERT INTO `logs` VALUES ('147', '4', 'Delete Schedule', 'Deleted schedule for media: ssstik.io_1761203282618 and removed from landing page', '2025-10-29 15:15:25', '2025-10-29 15:15:25');
INSERT INTO `logs` VALUES ('148', '4', 'Create Visual Schedule', 'Created visual schedule for: image 10 at position: 4', '2025-10-29 15:17:09', '2025-10-29 15:17:09');
INSERT INTO `logs` VALUES ('149', '4', 'Delete Schedule', 'Deleted schedule for media: image 10 and removed from landing page', '2025-10-29 15:17:15', '2025-10-29 15:17:15');
INSERT INTO `logs` VALUES ('150', '4', 'Create Visual Schedule', 'Created visual schedule for: Lompat Batu at position: 3', '2025-10-29 15:28:12', '2025-10-29 15:28:12');
INSERT INTO `logs` VALUES ('151', '4', 'Delete Schedule', 'Deleted schedule for media: Lompat Batu and removed from landing page', '2025-10-29 15:28:24', '2025-10-29 15:28:24');
INSERT INTO `logs` VALUES ('152', '4', 'Logout', 'User logged out', '2025-10-29 15:32:17', '2025-10-29 15:32:17');
INSERT INTO `logs` VALUES ('153', '4', 'Login', 'User logged in', '2025-10-29 15:32:28', '2025-10-29 15:32:28');
INSERT INTO `logs` VALUES ('154', '4', 'Create Visual Schedule', 'Created visual schedule for: image 10 at position: 2', '2025-10-29 15:36:11', '2025-10-29 15:36:11');
INSERT INTO `logs` VALUES ('155', '4', 'Delete Media', 'Deleted Video: yt', '2025-10-29 15:51:06', '2025-10-29 15:51:06');
INSERT INTO `logs` VALUES ('156', '4', 'Login', 'User logged in', '2025-10-30 09:35:57', '2025-10-30 09:35:57');
INSERT INTO `logs` VALUES ('157', '4', 'Delete Schedule', 'Deleted schedule for media: image 10 and removed from landing page', '2025-10-30 10:36:06', '2025-10-30 10:36:06');
INSERT INTO `logs` VALUES ('158', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761203636152 (duration: s)', '2025-10-30 10:36:33', '2025-10-30 10:36:33');
INSERT INTO `logs` VALUES ('159', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761203282618 (duration: s)', '2025-10-30 10:38:14', '2025-10-30 10:38:14');
INSERT INTO `logs` VALUES ('160', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1761200266647 (duration: s)', '2025-10-30 10:40:57', '2025-10-30 10:40:57');
INSERT INTO `logs` VALUES ('161', '4', 'Create Audio Schedule', 'Created audio schedule for: ssstik.io_1760930824517 (duration: s)', '2025-10-30 10:43:55', '2025-10-30 10:43:55');
INSERT INTO `logs` VALUES ('162', '4', 'Login', 'User logged in', '2025-11-09 13:58:10', '2025-11-09 13:58:10');
INSERT INTO `logs` VALUES ('163', '4', 'Login', 'User logged in', '2025-11-09 22:06:52', '2025-11-09 22:06:52');
INSERT INTO `logs` VALUES ('164', '4', 'Login', 'User logged in', '2025-11-10 08:51:14', '2025-11-10 08:51:14');
INSERT INTO `logs` VALUES ('165', '3', 'Login', 'User logged in', '2025-11-11 13:31:28', '2025-11-11 13:31:28');
INSERT INTO `logs` VALUES ('166', '3', 'Update Admin', 'Updated admin account: rifan@tambodia.com', '2025-11-11 13:32:07', '2025-11-11 13:32:07');
INSERT INTO `logs` VALUES ('167', '4', 'Login', 'User logged in', '2025-11-11 13:39:23', '2025-11-11 13:39:23');
INSERT INTO `logs` VALUES ('168', '3', 'Login', 'User logged in', '2025-11-11 13:39:32', '2025-11-11 13:39:32');
INSERT INTO `logs` VALUES ('169', '4', 'Login', 'User logged in', '2025-11-12 08:47:17', '2025-11-12 08:47:17');
INSERT INTO `logs` VALUES ('170', '4', 'Create Visual Schedule', 'Created visual schedule for: Lompat Batu at position: 1', '2025-11-12 11:18:03', '2025-11-12 11:18:03');
INSERT INTO `logs` VALUES ('171', '4', 'Create Visual Schedule', 'Created visual schedule for: download (4) at position: 3', '2025-11-12 11:18:20', '2025-11-12 11:18:20');
INSERT INTO `logs` VALUES ('172', '4', 'Login', 'User logged in', '2025-11-13 08:54:34', '2025-11-13 08:54:34');
INSERT INTO `logs` VALUES ('173', '3', 'Login', 'User logged in', '2025-11-13 10:48:19', '2025-11-13 10:48:19');

-- Table: media
DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Gambar','Video','Audio') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_platform` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `show_on_landing` tinyint(1) NOT NULL DEFAULT '0',
  `layout_order` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_user_id_foreign` (`user_id`),
  CONSTRAINT `media_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: media
INSERT INTO `media` VALUES ('15', '1', 'download (4)', 'Gambar', 'media/1761201133_download (4).jpeg', NULL, 'download (4).jpeg', '2025-10-23', '0', NULL, '2025-10-23 13:32:13', '2025-11-12 11:19:41');
INSERT INTO `media` VALUES ('17', '4', 'ssstik.io_1760930824517', 'Audio', 'media/1761201341_ssstik.io_1760930824517.mp3', NULL, 'ssstik.io_1760930824517.mp3', '2025-10-23', '0', NULL, '2025-10-23 13:35:41', '2025-11-12 11:19:41');
INSERT INTO `media` VALUES ('18', '4', 'ssstik.io_1761200266647', 'Audio', 'media/1761201437_ssstik.io_1761200266647.mp3', NULL, 'ssstik.io_1761200266647.mp3', '2025-10-23', '0', NULL, '2025-10-23 13:37:17', '2025-11-12 11:19:41');
INSERT INTO `media` VALUES ('19', '4', 'ssstik.io_1761203282618', 'Audio', 'media/1761203308_ssstik.io_1761203282618.mp3', NULL, 'ssstik.io_1761203282618.mp3', '2025-10-23', '0', NULL, '2025-10-23 14:08:29', '2025-11-12 11:19:41');
INSERT INTO `media` VALUES ('20', '4', 'ssstik.io_1761203636152', 'Audio', 'media/1761203665_ssstik.io_1761203636152.mp3', NULL, 'ssstik.io_1761203636152.mp3', '2025-10-23', '0', NULL, '2025-10-23 14:14:25', '2025-11-12 11:19:41');
INSERT INTO `media` VALUES ('21', '4', 'danau toba img1 1', 'Gambar', 'media/1761203878_danau toba img1 1.svg', NULL, 'danau toba img1 1.svg', '2025-10-23', '1', '2', '2025-10-23 14:17:58', '2025-11-12 11:19:41');
INSERT INTO `media` VALUES ('22', '4', 'image 10', 'Gambar', 'media/1761203890_image 10.png', NULL, 'image 10.png', '2025-10-23', '1', '4', '2025-10-23 14:18:10', '2025-11-12 11:19:41');
INSERT INTO `media` VALUES ('23', '4', 'Lompat Batu', 'Gambar', 'media/1761204738_img 1.1 4.svg', NULL, 'img 1.1 4.svg', '2025-10-23', '1', '1', '2025-10-23 14:32:18', '2025-11-12 11:19:41');

-- Table: migrations
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: migrations
INSERT INTO `migrations` VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` VALUES ('4', '2025_01_22_000001_create_schedule_descriptions_table', '1');
INSERT INTO `migrations` VALUES ('5', '2025_08_04_021110_create_media_table', '1');
INSERT INTO `migrations` VALUES ('6', '2025_08_11_020541_create_schedules_table', '1');
INSERT INTO `migrations` VALUES ('7', '2025_08_11_020549_create_logs_table', '1');
INSERT INTO `migrations` VALUES ('8', '2025_08_12_000000_add_layout_options_to_schedules_table', '1');
INSERT INTO `migrations` VALUES ('9', '2025_08_13_000000_add_background_description_to_schedules_table', '1');
INSERT INTO `migrations` VALUES ('10', '2025_08_13_020525_add_show_on_landing_to_media_table', '1');
INSERT INTO `migrations` VALUES ('11', '2025_08_14_000000_remove_end_date_from_schedules_table', '1');
INSERT INTO `migrations` VALUES ('12', '2025_08_25_002502_create_sessions_table', '1');
INSERT INTO `migrations` VALUES ('13', '2025_08_25_100000_add_last_login_at_to_users_table', '1');
INSERT INTO `migrations` VALUES ('14', '2025_08_26_093600_create_layout_settings_table', '1');
INSERT INTO `migrations` VALUES ('15', '2025_08_26_101100_add_layout_order_to_media_table', '1');
INSERT INTO `migrations` VALUES ('16', '2025_08_26_115352_add_background_image_to_layout_settings_table', '1');
INSERT INTO `migrations` VALUES ('17', '2025_08_27_093327_create_permission_tables', '1');
INSERT INTO `migrations` VALUES ('18', '2025_08_29_102020_ensure_layout_order_column_exists', '1');
INSERT INTO `migrations` VALUES ('19', '2025_08_29_102142_ensure_user_id_in_layout_settings', '1');
INSERT INTO `migrations` VALUES ('20', '2025_09_03_110557_create_layout_templates_table', '1');
INSERT INTO `migrations` VALUES ('21', '2025_09_10_000000_create_scheduled_backgrounds_table', '1');
INSERT INTO `migrations` VALUES ('22', '2025_09_15_000000_add_end_date_to_schedules_table', '1');
INSERT INTO `migrations` VALUES ('23', '2025_09_15_114409_add_layout_position_to_schedules_table', '1');
INSERT INTO `migrations` VALUES ('24', '2025_09_15_124458_add_is_active_to_schedules_table', '1');
INSERT INTO `migrations` VALUES ('25', '2025_10_17_161558_create_staff_table', '1');
INSERT INTO `migrations` VALUES ('26', '2025_10_29_085709_add_video_platform_to_media_table', '2');
INSERT INTO `migrations` VALUES ('27', '2025_10_29_145109_create_staff_names_table', '3');
INSERT INTO `migrations` VALUES ('28', '2025_11_09_141940_update_layout_templates_table_for_builder', '4');
INSERT INTO `migrations` VALUES ('29', '2025_11_09_160323_simplify_layout_templates_for_master_layout', '5');

-- Table: model_has_permissions
DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: model_has_roles
DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: permissions
DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: role_has_permissions
DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: roles
DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: schedule_descriptions
DROP TABLE IF EXISTS `schedule_descriptions`;

CREATE TABLE `schedule_descriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_descriptions_user_id_foreign` (`user_id`),
  CONSTRAINT `schedule_descriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: scheduled_backgrounds
DROP TABLE IF EXISTS `scheduled_backgrounds`;

CREATE TABLE `scheduled_backgrounds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `media_id` bigint unsigned DEFAULT NULL,
  `start_date` date NOT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scheduled_backgrounds_user_id_foreign` (`user_id`),
  KEY `scheduled_backgrounds_media_id_foreign` (`media_id`),
  KEY `scheduled_backgrounds_start_date_day_of_week_time_index` (`start_date`,`day_of_week`,`time`),
  CONSTRAINT `scheduled_backgrounds_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `scheduled_backgrounds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: schedules
DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `media_id` bigint unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `day_of_week` enum('senin','selasa','rabu','kamis','jumat','sabtu','minggu') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `layout_position` int DEFAULT NULL,
  `layout_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'grid',
  `layout_positions` json DEFAULT NULL,
  `background_image_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `display_duration` int NOT NULL DEFAULT '10',
  `auto_rotate` tinyint(1) NOT NULL DEFAULT '1',
  `layout_settings` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_media_id_foreign` (`media_id`),
  KEY `schedules_background_image_id_foreign` (`background_image_id`),
  CONSTRAINT `schedules_background_image_id_foreign` FOREIGN KEY (`background_image_id`) REFERENCES `media` (`id`) ON DELETE SET NULL,
  CONSTRAINT `schedules_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: schedules
INSERT INTO `schedules` VALUES ('31', '20', '2025-10-30', '2025-10-30', NULL, '10:37:00', NULL, 'grid', NULL, NULL, NULL, '10', '1', NULL, '1', '2025-10-30 10:36:33', '2025-10-30 10:36:33');
INSERT INTO `schedules` VALUES ('32', '19', '2025-10-30', '2025-10-30', NULL, '10:39:00', NULL, 'grid', NULL, NULL, NULL, '10', '1', NULL, '1', '2025-10-30 10:38:14', '2025-10-30 10:38:14');
INSERT INTO `schedules` VALUES ('33', '18', '2025-10-30', '2025-10-30', NULL, '10:41:00', NULL, 'grid', NULL, NULL, NULL, '10', '1', NULL, '1', '2025-10-30 10:40:57', '2025-10-30 10:40:57');
INSERT INTO `schedules` VALUES ('34', '17', '2025-10-30', '2025-10-30', NULL, '10:44:00', NULL, 'grid', NULL, NULL, NULL, '10', '1', NULL, '1', '2025-10-30 10:43:55', '2025-10-30 10:43:55');
INSERT INTO `schedules` VALUES ('35', '23', '2025-11-12', '2025-11-12', NULL, '11:20:00', '1', 'grid', NULL, NULL, NULL, '10', '1', NULL, '1', '2025-11-12 11:18:03', '2025-11-12 11:18:03');
INSERT INTO `schedules` VALUES ('36', '15', '2025-11-12', '2025-11-12', NULL, '11:20:00', '3', 'grid', NULL, NULL, NULL, '10', '1', NULL, '1', '2025-11-12 11:18:20', '2025-11-12 11:18:20');

-- Table: sessions
DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
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

-- Table: staff
DROP TABLE IF EXISTS `staff`;

CREATE TABLE `staff` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: staff
INSERT INTO `staff` VALUES ('21', 'Citra Dewi', 'staff/staff_1762923035_6914121b0ad6e.png', '1', '1', '2025-11-12 11:50:35', '2025-11-12 14:17:36');
INSERT INTO `staff` VALUES ('22', 'Budi Santoso', 'staff/staff_1762923047_69141227ba387.png', '2', '1', '2025-11-12 11:50:47', '2025-11-12 14:17:37');

-- Table: staff_names
DROP TABLE IF EXISTS `staff_names`;

CREATE TABLE `staff_names` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_names_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: staff_names
INSERT INTO `staff_names` VALUES ('1', 'Rifan Al Fahri', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('2', 'Budi Santoso', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('3', 'Citra Dewi', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('4', 'Dian Pratama', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('5', 'Eka Putri', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('6', 'Fajar Ramadhan', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('7', 'Gita Sari', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('8', 'Hendra Wijaya', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('9', 'Indah Permata', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('10', 'Joko Susilo', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('11', 'Kartika Sari', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('12', 'Lestari Wulandari', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('13', 'Muhammad Rizki', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('14', 'Nur Azizah', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('15', 'Oki Setiawan', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('16', 'Putri Ayu', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('17', 'Qori Hidayat', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('18', 'Rina Marlina', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('19', 'Siti Nurhaliza', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('20', 'Taufik Hidayat', '1', '2025-10-29 14:53:56', '2025-10-29 14:53:56');
INSERT INTO `staff_names` VALUES ('21', 'Galuh', '0', '2025-10-29 15:10:15', '2025-10-29 15:10:15');

-- Table: users
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superadmin','pegawai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pegawai',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for table: users
INSERT INTO `users` VALUES ('1', 'Galuh', 'galuh@tambodia.com', NULL, '$2y$12$0.XMZkLUGizwDM6rO0QW4OgGEgGASDGab3e22DooyY1CCYIw9Oj9G', 'superadmin', '2025-10-29 14:47:26', NULL, '2025-10-19 19:16:17', '2025-10-29 14:47:26');
INSERT INTO `users` VALUES ('2', 'Nadiah', 'nadiah@tambodia.com', NULL, '$2y$12$tRH7P810TNmXYUqvS7obo.r9fpHCyTnsuzXzmg5UmYQ.HOCbS8Vrm', 'superadmin', '2025-10-23 09:22:55', NULL, '2025-10-19 19:16:18', '2025-10-23 09:22:55');
INSERT INTO `users` VALUES ('3', 'Samuel', 'samuel@tambodia.com', NULL, '$2y$12$VyTcZsaEH2kgk1kQhcQAleVXU0E9pZ3rT9BnOyYGBwK1vitMv6H2S', 'superadmin', '2025-11-13 10:48:19', NULL, '2025-10-19 19:16:18', '2025-11-13 10:48:19');
INSERT INTO `users` VALUES ('4', 'Rifan', 'rifan@tambodia.com', NULL, '$2y$12$5YaIZHCCT4kn0x3hUmxtc.AktZr2fkCFLEpfHKmtaGmeShPYEN.fG', 'superadmin', '2025-11-13 08:54:34', NULL, '2025-10-19 19:16:18', '2025-11-13 08:54:34');

SET FOREIGN_KEY_CHECKS=1;
