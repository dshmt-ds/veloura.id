-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 31, 2026 at 02:35 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `veloura`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending_payment','confirmed','in_progress','completed','cancelled','expired','no_show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_payment',
  `payment_due_at` datetime DEFAULT NULL,
  `customer_notes` text COLLATE utf8mb4_unicode_ci,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `cancelled_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  KEY `bookings_customer_id_index` (`customer_id`),
  KEY `bookings_staff_id_index` (`staff_id`),
  KEY `bookings_status_index` (`status`),
  KEY `bookings_start_at_index` (`start_at`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_code`, `customer_id`, `staff_id`, `start_at`, `end_at`, `total_amount`, `status`, `payment_due_at`, `customer_notes`, `cancellation_reason`, `cancelled_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(6, 'BK-20261006-CVY7', 2, 3, '2026-10-07 09:00:00', '2026-10-07 09:10:00', 1.00, 'pending_payment', NULL, 'UJI COBA', NULL, NULL, NULL, '2026-10-06 08:03:15', '2026-10-06 08:03:15'),
(11, 'BK-20261013-CV4X', 2, 3, '2026-10-13 12:11:00', '2026-10-13 12:21:00', 1.00, 'pending_payment', NULL, 'catatan tambahan', NULL, NULL, NULL, '2026-10-12 22:11:16', '2026-10-12 22:11:16'),
(10, 'BK-20261006-QEVS', 2, 5, '2026-10-07 09:00:00', '2026-10-07 09:10:00', 1.00, 'confirmed', NULL, NULL, NULL, NULL, NULL, '2026-10-06 09:40:33', '2026-10-06 09:47:54'),
(7, 'BK-20261006-0P9F', 2, 9, '2026-10-07 10:00:00', '2026-10-07 10:10:00', 1.00, 'pending_payment', NULL, NULL, NULL, NULL, NULL, '2026-10-06 08:26:47', '2026-10-06 08:26:47'),
(8, 'BK-20261006-AX53', 2, 7, '2026-10-06 21:00:00', '2026-10-06 21:10:00', 1.00, 'pending_payment', NULL, NULL, NULL, NULL, NULL, '2026-10-06 08:34:45', '2026-10-06 08:34:45'),
(9, 'BK-20261006-UTOE', 2, 10, '2026-10-06 09:00:00', '2026-10-06 09:10:00', 1.00, 'confirmed', NULL, NULL, NULL, NULL, NULL, '2026-10-06 09:13:14', '2026-10-06 09:34:39'),
(12, 'BK-20261013-OJ0E', 2, 10, '2026-10-13 12:13:00', '2026-10-13 15:13:00', 400000.00, 'pending_payment', NULL, NULL, NULL, NULL, NULL, '2026-10-12 22:13:54', '2026-10-12 22:13:54'),
(13, 'BK-20261031-GYBC', 2, 15, '2026-11-01 09:00:00', '2026-11-01 10:00:00', 1.00, 'pending_payment', NULL, NULL, NULL, NULL, NULL, '2026-10-31 06:24:28', '2026-10-31 06:24:28'),
(14, 'BK-20261031-NFD4', 2, 15, '2026-11-01 12:00:00', '2026-11-01 13:00:00', 1.00, 'confirmed', NULL, NULL, NULL, NULL, NULL, '2026-10-31 06:44:41', '2026-10-31 06:45:24');

-- --------------------------------------------------------

--
-- Table structure for table `booking_items`
--

DROP TABLE IF EXISTS `booking_items`;
CREATE TABLE IF NOT EXISTS `booking_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `service_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `duration_minutes` smallint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_items_booking_id_service_id_unique` (`booking_id`,`service_id`),
  KEY `booking_items_service_id_foreign` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_items`
--

INSERT INTO `booking_items` (`id`, `booking_id`, `service_id`, `service_name`, `price`, `duration_minutes`, `created_at`, `updated_at`) VALUES
(1, 4, 16, 'Pedicure', 90000.00, 60, '2026-10-05 08:00:33', '2026-10-05 08:00:33'),
(2, 5, 2, 'Hair Wash', 35000.00, 30, '2026-10-06 07:22:03', '2026-10-06 07:22:03'),
(3, 6, 35, 'UJI COBA', 1.00, 10, '2026-10-06 08:03:15', '2026-10-06 08:03:15'),
(4, 7, 36, 'UJI COBA', 1.00, 10, '2026-10-06 08:26:47', '2026-10-06 08:26:47'),
(5, 8, 36, 'UJI COBA', 1.00, 10, '2026-10-06 08:34:45', '2026-10-06 08:34:45'),
(6, 9, 36, 'UJI COBA', 1.00, 10, '2026-10-06 09:13:14', '2026-10-06 09:13:14'),
(7, 10, 36, 'UJI COBA', 1.00, 10, '2026-10-06 09:40:33', '2026-10-06 09:40:33'),
(8, 11, 36, 'UJI COBA', 1.00, 10, '2026-10-12 22:11:16', '2026-10-12 22:11:16'),
(9, 12, 9, 'Ombre Hair', 400000.00, 180, '2026-10-12 22:13:54', '2026-10-12 22:13:54'),
(10, 13, 37, 'UJI COBA', 1.00, 60, '2026-10-31 06:24:28', '2026-10-31 06:24:28'),
(11, 14, 37, 'UJI COBA', 1.00, 60, '2026-10-31 06:44:41', '2026-10-31 06:44:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_03_161227_create_services_table', 2),
(5, '2026_10_04_014224_create_service_categories_table', 3),
(6, '2026_10_04_072350_add_category_id_and_image_to_services_table', 4),
(7, '2026_10_04_145119_add_role_and_phone_to_users_table', 5),
(8, '2026_10_04_153715_create_staffs_table', 6),
(9, '2026_10_04_153718_create_staff_services_table', 6),
(10, '2026_10_04_153719_create_operating_hours_table', 6),
(11, '2026_10_04_153800_create_staff_schedules_table', 6),
(12, '2026_10_05_121530_create_bookings_table', 7),
(13, '2026_10_05_121741_create_booking_items_table', 7),
(14, '2026_10_05_161115_create_payments_and_payment_events_tables', 8),
(15, '2026_10_06_125827_add_snap_token_to_payments_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `operating_hours`
--

DROP TABLE IF EXISTS `operating_hours`;
CREATE TABLE IF NOT EXISTS `operating_hours` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `day_of_week` tinyint UNSIGNED NOT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `operating_hours_day_of_week_unique` (`day_of_week`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` bigint UNSIGNED NOT NULL,
  `payment_reference` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway_transaction_id` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IDR',
  `status` enum('pending','paid','failed','expired','cancelled','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `snap_token` text COLLATE utf8mb4_unicode_ci,
  `checkout_url` text COLLATE utf8mb4_unicode_ci,
  `expires_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_payment_reference_unique` (`payment_reference`),
  UNIQUE KEY `payments_gateway_provider_gateway_transaction_id_unique` (`gateway_provider`,`gateway_transaction_id`),
  KEY `payments_booking_id_foreign` (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_reference`, `gateway_provider`, `gateway_transaction_id`, `payment_method`, `amount`, `currency`, `status`, `snap_token`, `checkout_url`, `expires_at`, `paid_at`, `created_at`, `updated_at`) VALUES
(9, 12, 'VEL-BK-20261013-OJ0E-HEK75B', 'midtrans', NULL, NULL, 400000.00, 'IDR', 'pending', '06b38742-47e9-4311-9a04-7b1ce2d76fa2', NULL, '2026-10-14 05:14:00', NULL, '2026-10-12 22:14:00', '2026-10-12 22:14:00'),
(8, 11, 'VEL-BK-20261013-CV4X-O074AP', 'midtrans', NULL, NULL, 1.00, 'IDR', 'pending', '4b7a15a1-85bf-4d75-a34d-9ebc6526f4c9', NULL, '2026-10-14 05:11:26', NULL, '2026-10-12 22:11:25', '2026-10-12 22:11:26'),
(7, 10, 'VEL-BK-20261006-QEVS-ZL6HI9', 'midtrans', 'A120261006164103Gb9E28PiF7ID', 'dana', 1.00, 'IDR', 'paid', 'e0920ff6-eea8-46cf-b5d2-054acc596125', NULL, '2026-10-07 16:40:40', '2026-10-06 16:47:54', '2026-10-06 09:40:40', '2026-10-06 09:47:54'),
(6, 9, 'VEL-BK-20261006-UTOE-TVH74J', 'midtrans', 'dc025a76-f0d1-4ef7-9b49-273187a0bfa9', 'qris', 1.00, 'IDR', 'paid', 'b4f02b4c-e838-4152-900c-4278d2c99c29', NULL, '2026-10-07 16:32:52', '2026-10-06 16:34:39', '2026-10-06 09:32:51', '2026-10-06 09:34:39'),
(10, 13, 'VEL-BK-20261031-GYBC-OGHJWU', 'midtrans', NULL, NULL, 1.00, 'IDR', 'pending', 'bed76f07-ff2c-4fcf-86ca-0ac410049967', NULL, '2026-11-01 13:33:20', NULL, '2026-10-31 06:33:19', '2026-10-31 06:33:20'),
(11, 14, 'VEL-BK-20261031-NFD4-XAFAQW', 'midtrans', 'a86e4674-1703-4002-a3e2-f549e98a7b39', 'qris', 1.00, 'IDR', 'paid', 'e6f0e276-4742-479e-be00-7d4df69ebf61', NULL, '2026-11-01 13:45:02', '2026-10-31 13:45:24', '2026-10-31 06:45:01', '2026-10-31 06:45:24');

-- --------------------------------------------------------

--
-- Table structure for table `payment_events`
--

DROP TABLE IF EXISTS `payment_events`;
CREATE TABLE IF NOT EXISTS `payment_events` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_id` bigint UNSIGNED DEFAULT NULL,
  `gateway_provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json NOT NULL,
  `processing_status` enum('received','processed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'received',
  `processed_at` datetime DEFAULT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_events_event_key_unique` (`event_key`),
  KEY `payment_events_payment_id_foreign` (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_events`
--

INSERT INTO `payment_events` (`id`, `payment_id`, `gateway_provider`, `event_key`, `payload`, `processing_status`, `processed_at`, `error_message`, `created_at`) VALUES
(1, 6, 'midtrans', 'midtrans:VEL-BK-20261006-UTOE-TVH74J:dc025a76-f0d1-4ef7-9b49-273187a0bfa9:pending', '{\"currency\": \"IDR\", \"order_id\": \"VEL-BK-20261006-UTOE-TVH74J\", \"expiry_time\": \"2026-10-07 23:32:51\", \"merchant_id\": \"M374374536\", \"status_code\": \"201\", \"fraud_status\": \"accept\", \"gross_amount\": \"1.00\", \"payment_type\": \"qris\", \"signature_key\": \"a9e659e82a3b63bcf9cc832b231c29f1c22be87971a2582b6b0170d872f4b0c0c07e50274e092287a110461f26d7589ae2c63bc4671c2e1af7d97e08aee3ec40\", \"status_message\": \"midtrans payment notification\", \"transaction_id\": \"dc025a76-f0d1-4ef7-9b49-273187a0bfa9\", \"customer_details\": {\"email\": \"desi@gmail.com\", \"phone\": \"82297490771\", \"full_name\": \"Desi Sihamita\"}, \"transaction_time\": \"2026-10-06 23:32:59\", \"transaction_type\": \"off-us\", \"transaction_status\": \"pending\"}', 'processed', '2026-10-06 16:33:00', NULL, '2026-10-06 16:33:00'),
(2, 6, 'midtrans', 'midtrans:VEL-BK-20261006-UTOE-TVH74J:dc025a76-f0d1-4ef7-9b49-273187a0bfa9:settlement', '{\"issuer\": \"gopay\", \"pop_id\": \"1f67b053-1577-4d0f-b6e4-940287042163\", \"acquirer\": \"gopay\", \"currency\": \"IDR\", \"order_id\": \"VEL-BK-20261006-UTOE-TVH74J\", \"expiry_time\": \"2026-10-07 23:32:51\", \"merchant_id\": \"M374374536\", \"status_code\": \"200\", \"fraud_status\": \"accept\", \"gross_amount\": \"1.00\", \"payment_type\": \"qris\", \"signature_key\": \"8f00e0fd792e4a78f71326eccd257136566d3e665a05c14fd2a470349bf78ca93afffab580db9f32f857088a9a576b9ccb8d801d9c22b82b2020b343e6036830\", \"status_message\": \"midtrans payment notification\", \"transaction_id\": \"dc025a76-f0d1-4ef7-9b49-273187a0bfa9\", \"settlement_time\": \"2026-10-06 23:34:38\", \"customer_details\": {\"email\": \"desi@gmail.com\", \"phone\": \"82297490771\", \"full_name\": \"Desi Sihamita\"}, \"transaction_time\": \"2026-10-06 23:32:59\", \"transaction_type\": \"on-us\", \"transaction_status\": \"settlement\", \"merchant_cross_reference_id\": \"5721a59e-5e49-4930-8957-327e46ce5b90\"}', 'processed', '2026-10-06 16:34:39', NULL, '2026-10-06 16:34:39'),
(3, 7, 'midtrans', 'midtrans:VEL-BK-20261006-QEVS-ZL6HI9:A120261006164103Gb9E28PiF7ID:pending', '{\"currency\": \"IDR\", \"order_id\": \"VEL-BK-20261006-QEVS-ZL6HI9\", \"expiry_time\": \"2026-10-07 23:40:40\", \"merchant_id\": \"M374374536\", \"status_code\": \"201\", \"fraud_status\": \"accept\", \"gross_amount\": \"1.00\", \"payment_type\": \"dana\", \"signature_key\": \"faf8061b0cdec30a81eac5feb25a39f8f1fe7861b666ed4f5f44a378ad069cb9109eccb02b3654d8e391cbdfaa6facd72ce85ae5cba7444476a639fe55addf69\", \"status_message\": \"midtrans payment notification\", \"transaction_id\": \"A120261006164103Gb9E28PiF7ID\", \"customer_details\": {\"email\": \"desi@gmail.com\", \"phone\": \"82297490771\", \"full_name\": \"Desi Sihamita\"}, \"transaction_time\": \"2026-10-06 23:41:03\", \"transaction_status\": \"pending\"}', 'processed', '2026-10-06 16:41:04', NULL, '2026-10-06 16:41:04'),
(4, 7, 'midtrans', 'midtrans:VEL-BK-20261006-QEVS-ZL6HI9:A120261006164103Gb9E28PiF7ID:settlement', '{\"currency\": \"IDR\", \"order_id\": \"VEL-BK-20261006-QEVS-ZL6HI9\", \"expiry_time\": \"2026-10-07 23:40:40\", \"merchant_id\": \"M374374536\", \"status_code\": \"200\", \"fraud_status\": \"accept\", \"gross_amount\": \"1.00\", \"payment_type\": \"dana\", \"signature_key\": \"914355361e5548d3e38f747b3d358f960461565a4d37f546ed656dbc17122cbc3ba7d3a3303679502134ba182e1f6a4005c04abc5b57a3d5cbe2fc8990a9a967\", \"status_message\": \"midtrans payment notification\", \"transaction_id\": \"A120261006164103Gb9E28PiF7ID\", \"settlement_time\": \"2026-10-06 23:47:54\", \"customer_details\": {\"email\": \"desi@gmail.com\", \"phone\": \"82297490771\", \"full_name\": \"Desi Sihamita\"}, \"transaction_time\": \"2026-10-06 23:41:03\", \"transaction_status\": \"settlement\"}', 'processed', '2026-10-06 16:47:54', NULL, '2026-10-06 16:47:54'),
(5, 11, 'midtrans', 'midtrans:VEL-BK-20261031-NFD4-XAFAQW:a86e4674-1703-4002-a3e2-f549e98a7b39:pending', '{\"currency\": \"IDR\", \"order_id\": \"VEL-BK-20261031-NFD4-XAFAQW\", \"expiry_time\": \"2026-11-01 20:45:01\", \"merchant_id\": \"M374374536\", \"status_code\": \"201\", \"fraud_status\": \"accept\", \"gross_amount\": \"1.00\", \"payment_type\": \"qris\", \"signature_key\": \"8df18fd6d55faf80ddf114a98a55b4c1dff681b2588c6d6354cde5c3a4c7e50db94faff1f72611303ad12e558e32251d44b249c30eb54268f07301329ca2a038\", \"status_message\": \"midtrans payment notification\", \"transaction_id\": \"a86e4674-1703-4002-a3e2-f549e98a7b39\", \"customer_details\": {\"email\": \"desi@gmail.com\", \"phone\": \"82297490771\", \"full_name\": \"Desi Sihamita\"}, \"transaction_time\": \"2026-10-31 20:45:03\", \"transaction_type\": \"off-us\", \"transaction_status\": \"pending\"}', 'processed', '2026-10-31 13:45:06', NULL, '2026-10-31 13:45:06'),
(6, 11, 'midtrans', 'midtrans:VEL-BK-20261031-NFD4-XAFAQW:a86e4674-1703-4002-a3e2-f549e98a7b39:settlement', '{\"issuer\": \"gopay\", \"pop_id\": \"1f67b053-1577-4d0f-b6e4-940287042163\", \"acquirer\": \"gopay\", \"currency\": \"IDR\", \"order_id\": \"VEL-BK-20261031-NFD4-XAFAQW\", \"expiry_time\": \"2026-11-01 20:45:01\", \"merchant_id\": \"M374374536\", \"status_code\": \"200\", \"fraud_status\": \"accept\", \"gross_amount\": \"1.00\", \"payment_type\": \"qris\", \"signature_key\": \"f7e5f8bbab7e5c03f9daf3fd14f5130dfbd4e01c06eb705a9ad1b8a227ca23dd979d93efe77a29b2359581430dcc8706bba3bd4172e13bc06a86315bfb70fae0\", \"status_message\": \"midtrans payment notification\", \"transaction_id\": \"a86e4674-1703-4002-a3e2-f549e98a7b39\", \"settlement_time\": \"2026-10-31 20:45:22\", \"customer_details\": {\"email\": \"desi@gmail.com\", \"phone\": \"82297490771\", \"full_name\": \"Desi Sihamita\"}, \"transaction_time\": \"2026-10-31 20:45:03\", \"transaction_type\": \"on-us\", \"transaction_status\": \"settlement\", \"merchant_cross_reference_id\": \"e05f70f8-ceb0-40e8-8079-4b7e9794d2e6\"}', 'processed', '2026-10-31 13:45:24', NULL, '2026-10-31 13:45:24');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `duration` int UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_service_category_id_foreign` (`service_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_category_id`, `name`, `category`, `price`, `duration`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Haircut', 'Hair', 75000.00, 45, 'Potong rambut dengan styling sederhana sesuai bentuk wajah.', NULL, 'active', '2026-10-03 21:54:45', '2026-10-03 21:54:45'),
(2, 1, 'Hair Wash', 'Hair', 35000.00, 30, 'Keramas dan perawatan ringan untuk membersihkan rambut dan kulit kepala.', NULL, 'active', '2026-10-03 21:44:48', '2026-10-03 21:47:17'),
(4, 1, 'Blow Dry', 'Hair', 50000.00, 30, 'Pengeringan dan penataan rambut agar terlihat lebih rapi dan bervolume.', NULL, 'active', '2026-10-03 22:02:57', '2026-10-03 22:02:57'),
(5, 1, 'Hair Styling', 'Hair', 85000.00, 60, 'Penataan rambut untuk acara santai maupun spesial.', NULL, 'active', '2026-10-03 22:04:18', '2026-10-03 22:04:18'),
(6, 2, 'Basic Hair Coloring', 'Hair Coloring', 250000.00, 120, 'Pewarnaan rambut dengan satu pilihan warna sesuai keinginan.', NULL, 'active', '2026-10-03 22:05:19', '2026-10-03 22:05:19'),
(7, 2, 'Highlight', 'Hair Coloring', 300000.00, 150, 'Pewarnaan sebagian rambut untuk memberikan efek dimensi dan highlight.', NULL, 'active', '2026-10-03 22:06:09', '2026-10-03 22:06:09'),
(8, 2, 'Balayage', 'Hair Coloring', 450000.00, 180, 'Teknik pewarnaan dengan gradasi natural untuk tampilan modern.', NULL, 'active', '2026-10-03 22:07:17', '2026-10-03 22:07:17'),
(9, 2, 'Ombre Hair', 'Hair Coloring', 400000.00, 180, 'Pewarnaan rambut dengan efek gradasi dari warna gelap ke terang.', NULL, 'active', '2026-10-03 22:09:36', '2026-10-03 22:09:36'),
(10, 3, 'Creambath', 'Hair Treatment', 100000.00, 60, 'Perawatan rambut dengan krim dan pijatan kulit kepala yang menenangkan.', NULL, 'active', '2026-10-03 22:11:16', '2026-10-03 22:39:26'),
(11, 3, 'Hair Spa', 'Hair Treatment', 150000.00, 75, 'Perawatan intensif untuk membantu menjaga kelembutan dan kesehatan rambut.', NULL, 'active', '2026-10-03 22:43:17', '2026-10-03 22:43:17'),
(12, 3, 'Keratin Treatment', 'Hair Treatment', 350000.00, 150, 'Perawatan keratin untuk membantu membuat rambut lebih halus dan mudah diatur.', NULL, 'active', '2026-10-03 22:44:25', '2026-10-03 22:44:25'),
(13, 3, 'Hair Mask', 'Hair Treatment', 100000.00, 45, 'Masker rambut untuk membantu memberikan kelembapan dan nutrisi pada rambut.', NULL, 'active', '2026-10-03 22:45:25', '2026-10-03 22:45:25'),
(14, 3, 'Smoothing', 'Hair Treatment', 400000.00, 180, 'Perawatan untuk membantu membuat rambut terlihat lebih lurus, halus, dan rapi.', NULL, 'active', '2026-10-03 22:46:12', '2026-10-03 22:46:12'),
(15, 4, 'Manicure', 'Hair', 75000.00, 45, 'Perawatan kuku dan tangan agar terlihat bersih dan terawat.', NULL, 'active', '2026-10-03 22:47:05', '2026-10-03 22:47:05'),
(16, 4, 'Pedicure', 'Nail', 90000.00, 60, 'Perawatan kuku dan kaki dengan proses pembersihan dan perawatan dasar.', NULL, 'active', '2026-10-03 22:47:32', '2026-10-03 22:47:32'),
(17, 4, 'Gel Polish', 'Nail', 120000.00, 60, 'Pewarnaan kuku menggunakan gel polish dengan hasil mengilap dan tahan lama.', NULL, 'active', '2026-10-03 22:48:05', '2026-10-03 22:48:05'),
(18, 4, 'Nail Art', 'Nail', 150000.00, 90, 'Dekorasi kuku dengan desain cantik sesuai pilihan pelanggan.', NULL, 'active', '2026-10-03 22:48:45', '2026-10-03 22:48:45'),
(19, 5, 'Basic Facial', 'Facial', 120000.00, 60, 'Perawatan dasar wajah untuk membersihkan dan menyegarkan kulit.', NULL, 'active', '2026-10-03 22:49:34', '2026-10-03 22:49:34'),
(20, 5, 'Acne Facial', 'Facial', 150000.00, 75, 'Perawatan wajah yang ditujukan untuk kulit dengan masalah jerawat.', NULL, 'active', '2026-10-03 22:50:19', '2026-10-03 22:50:19'),
(21, 5, 'Brightening Facial', 'Facial', 175000.00, 75, 'Perawatan untuk membantu membuat kulit terlihat lebih cerah dan segar.', NULL, 'active', '2026-10-03 22:50:52', '2026-10-03 22:50:52'),
(22, 5, 'Glow Facial', 'Facial', 200000.00, 90, 'Perawatan wajah untuk memberikan tampilan kulit yang lebih fresh dan glowing.', NULL, 'active', '2026-10-03 22:51:17', '2026-10-03 22:51:17'),
(23, 6, 'Body Scrub', 'Body Treatment', 150000.00, 60, 'Perawatan tubuh menggunakan scrub untuk membantu mengangkat sel kulit mati.', NULL, 'active', '2026-10-03 22:52:13', '2026-10-03 22:52:13'),
(24, 6, 'Body Spa', 'Body Treatment', 200000.00, 90, 'Perawatan tubuh untuk membantu memberikan rasa rileks dan nyaman.', NULL, 'active', '2026-10-03 22:52:58', '2026-10-03 22:52:58'),
(25, 6, 'Body Mask', 'Body Treatment', 175000.00, 75, 'Perawatan tubuh menggunakan masker untuk membantu menjaga kelembapan kulit.', NULL, 'active', '2026-10-03 22:54:20', '2026-10-03 22:54:20'),
(26, 6, 'Relaxing Massage', 'Body Treatment', 175000.00, 60, 'Pijat relaksasi untuk membantu mengurangi rasa lelah dan memberikan kenyamanan.', NULL, 'active', '2026-10-03 22:55:23', '2026-10-03 22:55:23'),
(27, 7, 'Eyelash Extension', 'Eyelash & Brow', 250000.00, 120, 'Pemasangan extension untuk memberikan tampilan bulu mata yang lebih bervolume.', NULL, 'active', '2026-10-03 22:56:47', '2026-10-03 22:56:47'),
(28, 7, 'Lash Lift', 'Eyelash & Brow', 175000.00, 75, 'Perawatan untuk membuat bulu mata terlihat lebih lentik secara natural.', NULL, 'active', '2026-10-03 22:57:30', '2026-10-03 22:57:30'),
(29, 7, 'Brow Treatment', 'Eyelash & Brow', 100000.00, 45, 'Perawatan dan penataan alis agar terlihat lebih rapi dan proporsional.', NULL, 'active', '2026-10-03 22:58:04', '2026-10-03 22:58:04'),
(30, 7, 'Brow Shaping', 'Eyelash & Brow', 75000.00, 30, 'Pembentukan alis sesuai bentuk wajah dan preferensi pelanggan.', NULL, 'active', '2026-10-03 22:59:03', '2026-10-03 22:59:03'),
(31, 9, 'Daily Makeup', 'Makeup', 150000.00, 60, 'Tata rias natural untuk aktivitas sehari-hari.', NULL, 'active', '2026-10-03 23:00:30', '2026-10-03 23:00:30'),
(32, 9, 'Party Makeup', 'Makeup', 300000.00, 90, 'Tata rias untuk menghadiri pesta atau acara spesial.', NULL, 'active', '2026-10-03 23:00:58', '2026-10-03 23:00:58'),
(33, 9, 'Graduation Makeup', 'Makeup', 300000.00, 120, 'Tata rias khusus untuk acara wisuda dengan hasil elegan dan tahan lama.', NULL, 'active', '2026-10-03 23:01:46', '2026-10-03 23:01:46'),
(34, 9, 'Event Makeup', 'Makeup', 350000.00, 120, 'Tata rias untuk berbagai acara formal dan momen spesial.', NULL, 'active', '2026-10-03 23:02:19', '2026-10-03 23:02:19'),
(37, 10, 'UJI COBA', 'UJI COBA', 1.00, 60, 'UJI coba layanan', NULL, 'active', '2026-10-31 05:32:45', '2026-10-31 06:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE IF NOT EXISTS `service_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_categories_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hair', 'hair', 'Kategori layanan perawatan dan penataan rambut seperti potong rambut, hair wash, blow dry, dan hair styling.', 1, '2026-10-03 20:11:39', '2026-10-03 20:11:39'),
(2, 'Hair Coloring', 'hair-coloring', 'Kategori layanan pewarnaan rambut seperti basic coloring, highlight, balayage, dan ombre.', 1, '2026-10-03 20:13:59', '2026-10-03 20:13:59'),
(3, 'Hair Treatment', 'hair-treatment', 'Kategori layanan perawatan rambut untuk menjaga kesehatan, kelembutan, dan kilau rambut.', 1, '2026-10-03 20:14:26', '2026-10-03 20:14:26'),
(4, 'Nail', 'nail', 'Kategori layanan perawatan dan kecantikan kuku seperti manicure, pedicure, gel polish, dan nail art.', 1, '2026-10-03 20:14:52', '2026-10-03 20:14:52'),
(5, 'Facial', 'facial', 'Kategori layanan perawatan wajah untuk membantu membersihkan, merawat, dan menjaga kesehatan kulit.', 1, '2026-10-03 20:15:41', '2026-10-03 20:15:41'),
(6, 'Body Treatment', 'body-treatment', 'Kategori layanan perawatan tubuh seperti body scrub, body spa, dan body mask.', 1, '2026-10-03 20:16:46', '2026-10-03 20:16:46'),
(7, 'Eyelash & Brow', 'eyelash-brow', 'Kategori layanan kecantikan untuk bulu mata dan alis seperti lash lift, eyelash extension, dan brow treatment.', 1, '2026-10-03 20:17:45', '2026-10-03 20:17:45'),
(9, 'Makeup', 'makeup', 'Kategori layanan tata rias untuk berbagai kebutuhan seperti daily makeup, party makeup, dan graduation makeup.', 1, '2026-10-03 21:01:51', '2026-10-03 22:39:02'),
(10, 'UJI COBA', 'uji-coba', 'uji coba', 1, '2026-10-06 07:59:00', '2026-10-06 07:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9Au3LPMIwb3eBExHEKHDV1tV6I8R4hvTgfQa7VVO', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT0pGVk1QM0tuYW8zU0ZvY1RmaU0zZFRiUUVkdUpqTldyUVVGOXUzaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlIjtzOjU6InJvdXRlIjtzOjEyOiJwcm9maWxlLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIxNjJiOWVkZDZhNGRhOGI0MTY2MjAxNzQwYjBmNWIxMjM0ZjViMDUyNjI0NjdhMzAwZWYyOTNkNDIxYzkyMjAxIjt9', 1793451673),
('T1eSWBlCw9r27tkXloXE3zkFXHA4fDKyoivQWMJO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibk5MZGc4TWpaVHhYNkVxanhYZFdzZWdOZEJRUUxxellGSHBhSjc5OCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1793457017),
('FEnNWMBdY6OevFkWeOjUlqtnObb1lqcIPQWVYkda', NULL, '127.0.0.1', 'Veritrans', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTXdIVjhuY1Jpc0o1c2ZlTDhRcHhJWnNxSnJtM1psTlpJNkFVYm9JeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1793454306),
('TqQ1R9jal4yWtBCjHaPb6UuJGghX1jMOoAPf2Heb', NULL, '127.0.0.1', 'Veritrans', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiM2FySm1hV3JJT2RJbE05Sm1RVnM1b2FHbUxGV25lczF5eW5va3F4ciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1793454324);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
CREATE TABLE IF NOT EXISTS `staffs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `name`, `phone`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Siti Rahmawati', '081234567890', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(2, 'Budi Santoso', '082198765432', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(3, 'Dewi Lestari', '085712345678', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(4, 'Ahmad Fauzi', '081311223344', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(5, 'Rina Rose', '087855667788', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(6, 'Andi Pratama', '089611224466', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(7, 'Maya Putri', '081299887766', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(8, 'Reza Rahadian', '081278671289', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(9, 'Nia Ramadhani', '085644332211', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(10, 'Fajar Nugraha', '082233445566', 1, '2026-10-04 16:16:09', '2026-10-04 16:16:09'),
(15, 'uji coba staff  update', '098765432145', 1, '2026-10-31 05:40:28', '2026-10-31 05:40:39');

-- --------------------------------------------------------

--
-- Table structure for table `staff_schedules`
--

DROP TABLE IF EXISTS `staff_schedules`;
CREATE TABLE IF NOT EXISTS `staff_schedules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_id` bigint UNSIGNED NOT NULL,
  `schedule_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_schedules_staff_id_schedule_date_index` (`staff_id`,`schedule_date`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_schedules`
--

INSERT INTO `staff_schedules` (`id`, `staff_id`, `schedule_date`, `start_time`, `end_time`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-10-06', '09:00:00', '17:00:00', 'Shift pagi', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(2, 2, '2026-10-06', '09:00:00', '17:00:00', 'Shift pagi', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(3, 3, '2026-10-06', '10:00:00', '18:00:00', 'Shift normal', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(4, 4, '2026-10-06', '10:00:00', '18:00:00', 'Shift normal', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(5, 5, '2026-10-06', '11:00:00', '19:00:00', 'Shift siang', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(6, 6, '2026-10-06', '11:00:00', '19:00:00', 'Shift siang', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(7, 7, '2026-10-06', '12:00:00', '20:00:00', 'Shift siang', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(8, 8, '2026-10-06', '13:00:00', '21:00:00', 'Shift sore', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(9, 9, '2026-10-06', '13:00:00', '21:00:00', 'Shift sore', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(10, 10, '2026-10-06', '09:00:00', '17:00:00', 'Shift pagi', '2026-10-05 09:28:40', '2026-10-05 09:28:40'),
(11, 4, '2026-10-05', '08:00:00', '12:00:00', 'Shiff pagi', '2026-10-05 02:30:01', '2026-10-05 02:40:53'),
(12, 6, '2026-10-06', '12:00:00', '17:00:00', 'Shift Sore', '2026-10-05 02:30:43', '2026-10-05 02:30:43'),
(17, 15, '2026-10-30', '12:00:00', '21:00:00', 'shif malam', '2026-10-31 05:45:45', '2026-10-31 05:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `staff_services`
--

DROP TABLE IF EXISTS `staff_services`;
CREATE TABLE IF NOT EXISTS `staff_services` (
  `staff_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`staff_id`,`service_id`),
  KEY `staff_services_service_id_foreign` (`service_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff_services`
--

INSERT INTO `staff_services` (`staff_id`, `service_id`) VALUES
(1, 7),
(1, 19),
(1, 20),
(2, 4),
(2, 12),
(2, 23),
(3, 6),
(3, 8),
(3, 28),
(4, 15),
(4, 24),
(4, 25),
(5, 18),
(5, 21),
(5, 29),
(6, 9),
(6, 10),
(6, 30),
(7, 27),
(7, 31),
(7, 32),
(8, 16),
(8, 17),
(8, 34),
(9, 22),
(9, 26),
(9, 27),
(10, 3),
(10, 11),
(10, 14),
(10, 33),
(11, 9),
(11, 15),
(11, 16),
(12, 8),
(12, 20),
(13, 8),
(13, 20),
(14, 8),
(14, 20),
(15, 19),
(15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Veloura', 'admin@veloura.com', '081234567890', 'admin', NULL, '$2y$12$ey7RVGYpWQ5P5TfS/OHo0./nnZvFbWcL/eSjZSNUrnwUq4/A5U4Ci', NULL, '2026-10-03 08:07:36', '2026-10-04 09:04:02'),
(2, 'Desi Sihamita', 'desi@gmail.com', '82297490771', 'customer', NULL, '$2y$12$jEaqBimc/JHfBYpGc1VZQu3n4crLDOTsQXq0hnb2mxyo2hFPN21Om', NULL, '2026-10-04 08:07:24', '2026-10-31 06:44:41');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
