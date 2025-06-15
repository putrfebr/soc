/*
 Navicat Premium Data Transfer

 Source Server         : db_dev_lokal_mysql
 Source Server Type    : MySQL
 Source Server Version : 80031
 Source Host           : localhost:3306
 Source Schema         : pelaporan-hse

 Target Server Type    : MySQL
 Target Server Version : 80031
 File Encoding         : 65001

 Date: 02/06/2025 21:23:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for history_resis
-- ----------------------------
DROP TABLE IF EXISTS `history_resis`;
CREATE TABLE `history_resis`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_resi` bigint UNSIGNED NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `history_resis_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `history_resis_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `history_resis_deleted_by_foreign`(`deleted_by`) USING BTREE,
  CONSTRAINT `history_resis_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `history_resis_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `history_resis_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of history_resis
-- ----------------------------

-- ----------------------------
-- Table structure for kepala_perwakilans
-- ----------------------------
DROP TABLE IF EXISTS `kepala_perwakilans`;
CREATE TABLE `kepala_perwakilans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kepala_perwakilans_id_nasabah_foreign`(`id_nasabah`) USING BTREE,
  INDEX `kepala_perwakilans_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `kepala_perwakilans_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `kepala_perwakilans_deleted_by_foreign`(`deleted_by`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kepala_perwakilans
-- ----------------------------

-- ----------------------------
-- Table structure for keuangan_umums
-- ----------------------------
DROP TABLE IF EXISTS `keuangan_umums`;
CREATE TABLE `keuangan_umums`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_rekening` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nominal_pengajuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `keuangan_umums_id_nasabah_foreign`(`id_nasabah`) USING BTREE,
  INDEX `keuangan_umums_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `keuangan_umums_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `keuangan_umums_deleted_by_foreign`(`deleted_by`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of keuangan_umums
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2023_02_12_060924_create_data_nasabahs_table', 1);
INSERT INTO `migrations` VALUES (6, '2023_02_12_080054_create_resis_table', 1);
INSERT INTO `migrations` VALUES (7, '2023_02_12_081503_create_history_resis_table', 1);
INSERT INTO `migrations` VALUES (8, '2023_02_14_102312_create_mobile_services_table', 1);
INSERT INTO `migrations` VALUES (9, '2023_02_15_005529_create_pj_pelayanans_table', 1);
INSERT INTO `migrations` VALUES (10, '2023_02_16_003435_create_kepala_perwakilans_table', 1);
INSERT INTO `migrations` VALUES (11, '2023_02_16_010914_create_keuangan_umums_table', 1);
INSERT INTO `migrations` VALUES (12, '2023_02_18_085436_create_pembayaran_klaims_table', 1);

-- ----------------------------
-- Table structure for mobile_services
-- ----------------------------
DROP TABLE IF EXISTS `mobile_services`;
CREATE TABLE `mobile_services`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `rumah_sakit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `mobile_services_id_nasabah_foreign`(`id_nasabah`) USING BTREE,
  INDEX `mobile_services_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `mobile_services_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `mobile_services_deleted_by_foreign`(`deleted_by`) USING BTREE,
  CONSTRAINT `mobile_services_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mobile_services_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mobile_services_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of mobile_services
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for pembayaran_klaims
-- ----------------------------
DROP TABLE IF EXISTS `pembayaran_klaims`;
CREATE TABLE `pembayaran_klaims`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pembayaran_klaims_id_nasabah_foreign`(`id_nasabah`) USING BTREE,
  INDEX `pembayaran_klaims_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `pembayaran_klaims_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `pembayaran_klaims_deleted_by_foreign`(`deleted_by`) USING BTREE,
  CONSTRAINT `pembayaran_klaims_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pembayaran_klaims_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pembayaran_klaims_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pembayaran_klaims
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for pj_pelayanans
-- ----------------------------
DROP TABLE IF EXISTS `pj_pelayanans`;
CREATE TABLE `pj_pelayanans`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nasabah` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pj_pelayanans_id_nasabah_foreign`(`id_nasabah`) USING BTREE,
  INDEX `pj_pelayanans_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `pj_pelayanans_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `pj_pelayanans_deleted_by_foreign`(`deleted_by`) USING BTREE,
  CONSTRAINT `pj_pelayanans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pj_pelayanans_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pj_pelayanans_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pj_pelayanans
-- ----------------------------

-- ----------------------------
-- Table structure for resi
-- ----------------------------
DROP TABLE IF EXISTS `resi`;
CREATE TABLE `resi`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_registrasi_klaim` bigint UNSIGNED NOT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `resi_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `resi_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `resi_deleted_by_foreign`(`deleted_by`) USING BTREE,
  CONSTRAINT `resi_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `resi_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `resi_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of resi
-- ----------------------------

-- ----------------------------
-- Table structure for soc
-- ----------------------------
DROP TABLE IF EXISTS `soc`;
CREATE TABLE `soc`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `divisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `tanggal_waktu` timestamp NULL DEFAULT NULL,
  `golden_rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `unsafe_action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `safe_behaviour` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cuaca` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `nominal` int NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `suhu` float NULL DEFAULT NULL,
  `freq` int NULL DEFAULT NULL,
  `risk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `photos` json NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `data_nasabahs_created_by_foreign`(`created_by`) USING BTREE,
  INDEX `data_nasabahs_updated_by_foreign`(`updated_by`) USING BTREE,
  INDEX `data_nasabahs_deleted_by_foreign`(`deleted_by`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of soc
-- ----------------------------
INSERT INTO `soc` VALUES (2, 'supri', 'rajin orangnya dan aware terhadap masalah keselamaatan', 'IT', 'Site A', '2025-05-29 13:01:00', NULL, NULL, 'Cepat Tanggap Dalam Menangani Masalah Keselamatan', NULL, NULL, 1, 1, 3, '2025-05-29 12:03:49', '2025-06-02 18:24:06', '2025-06-02 18:24:06', 'SOC250500001', NULL, NULL, 'Rendah', 'Berikan apresiasi atau teruskan pengawasan rutin.', '[\"/storage/uploads/photos/YjRxsVLsqnbXSdSR0ZqeGC2KdIMENOq96DOGB1cC.jpg\"]');
INSERT INTO `soc` VALUES (3, 'supriyadi', 'rajin', 'HSE', 'Site A', '2025-05-29 20:38:00', '0', NULL, 'Meningkatkan Kesadaran Melalui Pelatihan dan Sosialisasi', NULL, NULL, 1, 1, NULL, '2025-05-29 19:38:36', '2025-05-29 20:26:10', NULL, 'SOC250550001', NULL, NULL, 'Rendah', 'Berikan apresiasi atau teruskan pengawasan rutin.', '[\"/storage/uploads/photos/xldOqY9NyvDiNV2kFsBqNu3EMFeP3mkHLcfNncUU.jpg\"]');
INSERT INTO `soc` VALUES (4, 'Yadi', NULL, 'HSE', 'Site A', '2025-05-31 21:31:00', '1', 'tidak menggunakan Alat Pelindung Diri (APD) dengan benar', NULL, '3', NULL, 3, 3, NULL, '2025-05-31 20:32:50', '2025-05-31 20:32:50', NULL, 'SOC250555001', NULL, NULL, 'Tinggi', 'Investigasi segera dan hentikan pekerjaan jika perlu.', '[\"/storage/uploads/photos/KfvSzbfZT81BcqCbUemtKfY0Gk7zdeQzSgQlMLh4.jpg\"]');
INSERT INTO `soc` VALUES (5, 'Yadirin', NULL, 'HSE', 'Site A', '2025-05-31 21:43:00', NULL, NULL, NULL, NULL, NULL, 3, 3, 3, '2025-05-31 20:43:34', '2025-05-31 20:54:30', '2025-05-31 20:54:30', 'SOC250555501', NULL, NULL, 'Tinggi', 'Investigasi segera dan hentikan pekerjaan jika perlu.', '[]');
INSERT INTO `soc` VALUES (6, 'Yadi', '-', 'HSE', 'Site A', '2025-05-01 08:00:00', '1', 'Tidak menggunakan Sepatu Safety', NULL, NULL, NULL, 3, 3, NULL, '2025-06-02 18:22:40', '2025-06-02 18:23:34', NULL, 'SOC250600001', NULL, NULL, 'Tinggi', 'Investigasi segera dan hentikan pekerjaan jika perlu.', '[\"/storage/uploads/photos/y1sPOGixdk83rtXlbBBalk1Dd2OKwN0XMYbMd3xp.jpg\"]');
INSERT INTO `soc` VALUES (7, 'Mahfuz', 'sudah lama saya melihat orang gila tersebut masuk terus menerus di area kerja dan merusak alat', 'HSE', 'Site A', '2025-06-02 20:58:00', '1', 'Orang gila memasuki lapangan secara paksa dan tidak menggunakan apd', NULL, NULL, NULL, 3, 3, NULL, '2025-06-02 20:02:41', '2025-06-02 20:02:41', NULL, 'SOC250660001', NULL, NULL, 'Tinggi', 'Investigasi segera dan hentikan pekerjaan jika perlu.', '[]');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'superadmin', 'superadmin', 'superadmin@gmail.com', NULL, '$2y$10$Q/vJPaIdKlFn1e1mXntrYezNJuDYThih.31dW9eXoHFf5IdL9Vs1e', 'superadmin', NULL, '2023-02-19 21:20:11', '2023-02-19 21:20:11');
INSERT INTO `users` VALUES (2, 'manager', 'Manager', 'manager@gmail.com', NULL, '$2a$12$NS6XiFsxtUurpm0.rHwi..imxpKj4tCxrjMeqDpD.wCkGSLsUcdH2', 'manager', NULL, '2023-02-19 21:20:11', '2023-02-19 21:20:11');
INSERT INTO `users` VALUES (3, 'pengawas', 'pengawas', 'pengawas@gmail.com', NULL, '$2a$12$XQh90tpzvTaMUU4.FwX/f.qmUIt/kcnE.V3F/a9iTEmwvj33cyrPO', 'superadmin', NULL, '2023-02-19 21:20:11', '2023-02-19 21:20:11');

SET FOREIGN_KEY_CHECKS = 1;
