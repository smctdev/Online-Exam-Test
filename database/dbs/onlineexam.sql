-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 09:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineexam`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_answer` char(255) DEFAULT NULL,
  `answer_exp` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profile_color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `user_id`, `profile_color`, `created_at`, `updated_at`) VALUES
(2, 3, '#9451f', '2025-11-23 21:27:20', '2025-11-23 21:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(10) UNSIGNED NOT NULL,
  `MAIL_FROM_NAME` varchar(255) NOT NULL,
  `MAIL_DRIVER` varchar(255) NOT NULL,
  `MAIL_HOST` varchar(255) NOT NULL,
  `MAIL_PORT` varchar(255) NOT NULL,
  `MAIL_USERNAME` varchar(255) NOT NULL,
  `MAIL_FROM_ADDRESS` varchar(255) NOT NULL,
  `MAIL_PASSWORD` varchar(255) NOT NULL,
  `MAIL_ENCRYPTION` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `copyrighttexts`
--

CREATE TABLE `copyrighttexts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `copyrighttexts`
--

INSERT INTO `copyrighttexts` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '&copy; 2019 Quick Quiz. All Rights Reserved', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `essay`
--

CREATE TABLE `essay` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic_id` smallint(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `situation` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `mark` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `exam` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `started_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `sent_by` varchar(255) DEFAULT NULL,
  `violation` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`id`, `user_id`, `exam`, `created_at`, `updated_at`, `started_at`, `end_at`, `sent_by`, `violation`) VALUES
(6, 6, '1', '2025-11-23 22:59:19', '2025-11-25 16:47:44', '2025-11-24 07:00:13', '2025-11-26 00:47:44', 'Administrator', 0),
(9, 8, '1,2', '2025-11-24 18:48:32', '2025-11-25 16:49:27', '2025-11-25 02:49:23', '2025-11-26 00:49:27', 'Administrator', 0),
(10, 9, '1,2', '2025-11-24 18:58:29', '2025-11-25 01:50:10', '2025-11-25 02:59:03', '2025-11-25 09:50:10', 'Administrator', 0),
(14, 7, '1', '2025-11-25 16:55:34', '2025-11-25 17:16:51', '2025-11-26 00:55:40', '2025-11-26 01:16:51', 'Administrator', 0),
(15, 10, '1,2,3', '2025-11-25 17:20:58', '2025-11-25 23:57:58', NULL, NULL, 'Administrator', 0),
(17, 12, '1,2,3', '2025-11-26 00:03:09', '2025-11-26 00:09:43', '2025-11-26 08:09:43', NULL, 'Administrator', 0),
(18, 14, '1,2,3', '2025-11-26 00:41:34', '2025-11-26 09:40:47', NULL, NULL, 'Administrator', 7);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2017_11_25_133229_create_settings_table', 1),
(5, '2017_12_03_080242_create_topics_table', 1),
(6, '2017_12_03_091845_create_questions_table', 1),
(7, '2017_12_03_110511_create_answers_table', 1),
(8, '2017_12_21_085915_add_image_video_column_to_questions', 1),
(9, '2019_02_12_065327_create_copyrighttexts_table', 1),
(10, '2019_02_15_072716_create_config_table', 1),
(11, '2021_01_15_071919_create_temp_answers_table', 1),
(12, '2021_01_16_071457_add_index_to_temp_answers', 1),
(13, '2021_02_10_014724_add_token_to_users', 1),
(14, '2021_03_04_044213_add_notfiy_to_users', 1),
(15, '2021_03_24_071059_drop_columns_questions', 1),
(16, '2021_03_31_052403_drop_column_tempquestion', 1),
(17, '2021_04_08_025812_create_result_table', 1),
(18, '2021_04_14_014844_add_column_position', 1),
(19, '2021_04_16_024250_add_column_status', 1),
(20, '2021_04_24_022536_add_column_set', 1),
(21, '2021_05_12_004221_add_column_type', 1),
(22, '2021_05_12_010059_add_column_types', 1),
(23, '2021_05_14_030849_create_table_essay', 1),
(24, '2021_05_17_061852_column_answer_exp', 1),
(25, '2021_05_20_010201_add_column_answer_exp', 1),
(26, '2021_05_26_065553_create_color_table', 1),
(27, '2021_06_21_061103_create_verifications_table', 1),
(28, '2021_07_15_083036_add_slug_column_to_topics', 1),
(29, '2021_07_21_070815_create_exam_table', 1),
(30, '2021_08_28_005617_add_set_to_temp_table', 1),
(31, '2022_06_09_055520_add_time_exam_table', 1),
(32, '2022_06_10_024734_add_sent_user_table', 1),
(33, '2022_06_10_024922_add_started_exam_table', 1),
(34, '2022_06_21_032433_add_status_answers_table', 1),
(35, '2025_11_24_012644_create_personal_access_tokens_table', 1),
(36, '2025_11_26_164743_add_violation_to_exam', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `choices` text DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `code_snippet` text DEFAULT NULL,
  `underline` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `answer_exp` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `question_img` varchar(255) DEFAULT NULL,
  `question_video_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `topic_id`, `question`, `choices`, `answer`, `code_snippet`, `underline`, `type`, `answer_exp`, `created_at`, `updated_at`, `question_img`, `question_video_link`) VALUES
(1, 1, 'Kinsa si lapu-lapu', '[\"Matibay\",\" Bungi\",\" Mahina\",\" Pungkol\"]', 'Bungi', NULL, 'Kinsa si, lapu-lapu', 'multiple', NULL, '2025-11-23 21:33:47', '2025-11-23 21:33:47', '1763962427-Screenshot 2025-11-06 085843.png', NULL),
(2, 1, 'Kinsa si Jose P. Rizal?', '[\"Hambugero\",\" Hero\",\" Talawan\",\" Bayot\"]', 'Hero', NULL, 'Kinsa si, Jose P. Rizal,?', 'multiple', NULL, '2025-11-23 21:36:39', '2025-11-23 21:36:39', NULL, NULL),
(3, 2, 'Kinsa si the kraken?', '[\"Jonmar\",\" Jenecil\",\" Dexter\",\" Allan\"]', 'Jonmar', NULL, NULL, 'multiple', NULL, '2025-11-23 23:05:33', '2025-11-23 23:05:33', '1763967933-pikamiddlefinger-removebg-preview.png', NULL),
(4, 2, 'Kinsa si G?', '[\"Mozarto\",\" Kologo\",\" Karala\",\" Taktak\"]', 'Mozarto', NULL, NULL, 'multiple', NULL, '2025-11-23 23:14:26', '2025-11-23 23:14:26', NULL, NULL),
(5, 2, 'Ako o siya?', '[\"Ako\",\" Siya\"]', 'Ako', NULL, NULL, 'multiple', NULL, '2025-11-23 23:29:21', '2025-11-23 23:29:21', NULL, NULL),
(6, 2, 'Ano si Kalbo Wala ba oh meron?', '[\"\"]', NULL, NULL, NULL, 'essay', NULL, '2025-11-24 18:57:00', '2025-11-24 18:57:00', NULL, NULL),
(7, 2, 'adsfasdfsadf', '[\"\"]', NULL, NULL, NULL, 'essay', NULL, '2025-11-24 23:33:44', '2025-11-24 23:33:44', NULL, NULL),
(8, 2, 'C. Aray ko', '[\"\"]', NULL, NULL, NULL, 'essay', NULL, '2025-11-24 23:58:02', '2025-11-24 23:58:02', NULL, NULL),
(9, 1, 'What the sheshhhh', '[\"Toplok\",\" Dile\",\" Karga\",\" Bungi\",\" Saksak\",\" Kardo\"]', 'Kardo', NULL, NULL, 'multiple', NULL, '2025-11-25 16:56:24', '2025-11-25 16:56:24', NULL, NULL),
(10, 3, '1 + 1 = \r\nAlam kong mali pero ikaw parin ang pinili bebe!', '[\"1\",\" 2\",\" 5\",\" 3\",\" 10\",\" 124\",\" 11\"]', ' 3', NULL, '1 + 1 =, \r\nAlam kong mali pero ikaw parin ang pinili bebe!', 'multiple', NULL, '2025-11-25 17:22:27', '2025-11-25 17:22:46', NULL, NULL),
(11, 3, 'Sige lang babay!', '[\"\"]', NULL, NULL, NULL, 'essay', NULL, '2025-11-25 17:23:21', '2025-11-25 17:23:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `score` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`id`, `user_id`, `score`, `created_at`, `updated_at`) VALUES
(42, 6, '{\"Unsa siya nganu Nganu!\":{\"score\":0,\"max\":2}}', NULL, NULL),
(43, 8, '{\"Unsa siya nganu Nganu!\":{\"score\":0,\"max\":2},\"Dexter The Kraken\":{\"score\":2,\"max\":6}}', NULL, NULL),
(44, 7, '{\"Unsa siya nganu Nganu!\":{\"score\":0,\"max\":3}}', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AbscukHMDQ8cPCbTwngJ8rLi7expKE0WzY2k0gHg', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMjhiamJlODdWeGNOcjJtbmR4ZEVabE9SUWpKbTljWEZiZkd2YzZmbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9leGFtaW5lZXMiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzY0MTE2MTIwO319', 1764150679),
('uSZs0UJkI2ICt49QO5gSdeyhcEdULhXQ3sBZibco', 14, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiVjlNVVBZM3ozemxkSzJxbEpBUFp1SFF6NUE3QXVteHB3d3RlTTI4ayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9ob21lIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NjQxNDYxNTA7fXM6NToiZm5hbWUiO3M6NzoiTXlkdW1teSI7czo2OiJ1dG9rZW4iO3M6NDA6IjU5OWU4YTUzMjlhNThkZTRkYjNiYzczYmE1NTk4NWU3YWJlNTNlNWMiO3M6NjoidXNlcklEIjtzOjI4OiJjMGYyMGFlMzgzMzhjM2Y5N2EzYjlmZDVjYWU5IjtzOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTQ7fQ==', 1764150680);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT 'logo.png',
  `favicon` varchar(255) NOT NULL DEFAULT 'favicon.ico',
  `welcome_txt` varchar(255) NOT NULL DEFAULT 'SMCT Group',
  `right_setting` int(11) NOT NULL DEFAULT 0,
  `element_setting` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `favicon`, `welcome_txt`, `right_setting`, `element_setting`, `created_at`, `updated_at`) VALUES
(1, 'logo.png', 'favicon.ico', 'SMCT Exam', 0, 0, NULL, '2025-11-25 01:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `temp_answers`
--

CREATE TABLE `temp_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `choices` text DEFAULT NULL,
  `set` varchar(255) NOT NULL,
  `question_img` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_answer` char(255) DEFAULT NULL,
  `answer_exp` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `index` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_answers`
--

INSERT INTO `temp_answers` (`id`, `topic_id`, `question_id`, `question`, `choices`, `set`, `question_img`, `user_id`, `user_answer`, `answer_exp`, `created_at`, `updated_at`, `index`, `type`, `status`) VALUES
(1221, 1, 1, '<span class=\'underline\'>Kinsa si</span><span class=\'underline\'> lapu-lapu</span>', '[\"Matibay\",\" Bungi\",\" Mahina\",\" Pungkol\"]', '0', '1763962427-Screenshot 2025-11-06 085843.png', 14, NULL, NULL, NULL, '2025-11-26 09:40:42', 0, 'multiple', 'blank'),
(1222, 1, 2, '<span class=\'underline\'>Kinsa si</span><span class=\'underline\'> Jose P. Rizal</span><span class=\'underline\'>?</span>', '[\"Hambugero\",\" Hero\",\" Talawan\",\" Bayot\"]', '0', NULL, 14, NULL, NULL, NULL, '2025-11-26 09:40:42', 1, 'multiple', 'blank'),
(1223, 1, 9, 'What the sheshhhh', '[\"Toplok\",\" Dile\",\" Karga\",\" Bungi\",\" Saksak\",\" Kardo\"]', '0', NULL, 14, NULL, NULL, NULL, '2025-11-26 09:40:42', 2, 'multiple', 'blank');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `timer` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `set` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `title`, `slug`, `description`, `timer`, `created_at`, `updated_at`, `set`) VALUES
(1, 'Unsa siya nganu Nganu!', 'unsa-siya-nganu-nganu', 'wala ragud testingwala ragud testingwala ragud testing wala ragud testing wala ragud testing wala ragud testing wala ragud testing wala ragud testing wala ragud testing', 20, '2025-11-23 21:30:32', '2025-11-23 21:31:50', 5),
(2, 'Dexter The Kraken', 'dexter-the-kraken', 'test', 1, '2025-11-23 23:04:39', '2025-11-23 23:04:39', 2),
(3, 'Aray Mo pakak', 'aray-mo-pakak', 'Tara Jay!', 60, '2025-11-25 17:20:19', '2025-11-25 17:20:19', 100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` char(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `applied_position` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notify` smallint(6) NOT NULL DEFAULT 0,
  `status` varchar(255) DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `address`, `role`, `remember_token`, `email_verified_at`, `token`, `applied_position`, `created_at`, `updated_at`, `notify`, `status`, `added_by`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$12$V.S3Lzil00ecOkqGhnAIY.328F86TQMoyp3CdQK.hRtoqKyBZsg/.', NULL, NULL, 'S', NULL, '2025-11-24 03:39:12', '72fb23f38a188c6acfea035c170754fb8f8adbcd', NULL, '2025-11-23 18:23:35', '2025-11-25 16:16:49', 1, NULL, NULL),
(3, 'Tukyo', 'barabay@gmail.com', '$2y$12$XNwAKCBsk0qJ1BXSjYIuE.C3FU3L61oS498N/OvvVzdXDp8V.qXie', NULL, NULL, 'S', NULL, NULL, NULL, NULL, '2025-11-23 21:26:21', '2025-11-25 16:16:49', 1, NULL, NULL),
(4, 'Tukyo', 'barabay1@gmail.com', '$2y$12$EKPr4fyvueXwW1gMwWemJ.C7sfVMJSGj4Z5iIliw8wJHt0aMxhLjS', NULL, NULL, 'S', NULL, NULL, NULL, NULL, '2025-11-23 21:27:20', '2025-11-25 16:16:49', 1, NULL, NULL),
(6, 'Jenecil Patac', 'smctjen@gmail.com', '$2y$12$Q533Tf0ftyXid8mjmNujbubFynA26oeHL7jUSaR2kbdcQu.UpqEzu', '09123456789', 'Balilihan', 'E', NULL, NULL, '10dbb21ec459c6da2c6175e18a44ab6acbfc8f13', 'Web Developer', '2025-11-23 22:58:29', '2025-11-25 16:47:44', 1, 'finish', 'Administrator'),
(7, 'Allan Justine Mascarinas', 'allan@gmail.com', '$2y$12$5BHcevjY1hBVlr7Fx/gesONw8XhwQ3gG/yzbDq8CGMl5NRJqnXXbe', '09123356789', NULL, 'E', NULL, NULL, 'e38711885947594b06a178e087b3a18388038efa', 'Web Developer', '2025-11-23 23:30:16', '2025-11-25 17:16:51', 1, 'finish', 'Administrator'),
(8, 'Dexter Toledo', 'dexter@gmail.com', '$2y$12$UdOP56vsoARO.RJxExYqBeeZfIVvBs47T8ldijq7/lgD4mmjPYpiK', '09122356789', NULL, 'E', NULL, NULL, '30ab957b2e1d440399e7d39bdf1ab41f97c8297d', 'IT Staff', '2025-11-24 18:47:37', '2025-11-25 16:49:27', 1, 'finish', 'Administrator'),
(9, 'Jonmar', 'jonmar@gmail.com', '$2y$12$5XlcldBG539xfaeezQW1geUXltit775CGRkRw1M8zp4eO8JVTNuYi', '0912345467', NULL, 'E', NULL, NULL, '3cfcc3eed3ef68445e01b16aa06eb009a52d7a91', 'IT Staff', '2025-11-24 18:57:37', '2025-11-25 23:22:35', 0, 'retry', 'Administrator'),
(10, 'Mark Anothy Bulala', 'macmac@gmail.com', '$2y$12$TSG4aGMAdsvprY.M2FRkn.0XOfgONSWSQCYi41k0KG.Fyzr0Nm87q', '090934567899', 'asd', 'E', NULL, NULL, '37c6d03eec265cb2ab1a3dace48bc9600ade0843', 'IT Supervisor', '2025-11-25 17:19:28', '2025-11-25 23:57:58', 0, 'sent', 'Administrator'),
(12, 'Nabigip Taga', 'nabigip540@gamepec.com', '$2y$12$rGIwatdv9hWUsFlj804jhusAURfv5GCraMFBigxotonnFQj/sSAtu', '09123446789', NULL, 'E', NULL, NULL, 'de45c9e41ca26dcac1c74846e79c27fae257b1eb', 'Gr...', '2025-11-26 00:00:07', '2025-11-26 00:32:20', 0, 'sent', 'Administrator'),
(13, 'Tatak IFM', 'allanjustinemascarinas.smct@gmail.com', '$2y$12$336ZnUxbjmAL34nATFZWzeOZcujTmEBq3CHbesxsYUxDYa0EtOxue', '09123456799', NULL, 'E', NULL, NULL, '05f04ca617054c46ec276acac300a0b671a10372', 'Tokmok', '2025-11-26 00:32:12', '2025-11-26 00:32:12', 0, NULL, 'Administrator'),
(14, 'Mydummy', 'mydummy.2022.2023@gmail.com', '$2y$12$RAr5/q.LREY3mrCv7g9DjO1YKDq6Lk0R/xDYbV.bTjv8YOLdKH7X2', '09512346789', NULL, 'E', NULL, NULL, '599e8a5329a58de4db3bc73ba55985e7abe53e5c', 'Gr.. Lala', '2025-11-26 00:35:38', '2025-11-26 09:40:48', 0, 'violator', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_token` text NOT NULL,
  `code` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verifications`
--

INSERT INTO `verifications` (`id`, `user_token`, `code`, `created_at`, `updated_at`) VALUES
(1, '1', 'LP28VY', '2025-11-23 18:33:02', '2025-11-24 22:00:03'),
(2, '2', '89c21a0d', '2025-11-23 21:40:36', '2025-11-23 21:40:36'),
(3, '6', '6CE3CG', '2025-11-23 23:01:23', '2025-11-24 18:35:17'),
(4, '12', 'ZQTUNJ', '2025-11-26 00:00:27', '2025-11-26 00:00:27'),
(5, '13', 'IKDL4R', '2025-11-26 00:32:38', '2025-11-26 00:32:38'),
(6, '14', 'LXGVBI', '2025-11-26 00:35:56', '2025-11-26 00:38:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_topic_id_foreign` (`topic_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `color_user_id_foreign` (`user_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `copyrighttexts`
--
ALTER TABLE `copyrighttexts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `essay`
--
ALTER TABLE `essay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_topic_id_foreign` (`topic_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `result_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_answers`
--
ALTER TABLE `temp_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temp_answers_topic_id_foreign` (`topic_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `topics_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `copyrighttexts`
--
ALTER TABLE `copyrighttexts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `essay`
--
ALTER TABLE `essay`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temp_answers`
--
ALTER TABLE `temp_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1224;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `color`
--
ALTER TABLE `color`
  ADD CONSTRAINT `color_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temp_answers`
--
ALTER TABLE `temp_answers`
  ADD CONSTRAINT `temp_answers_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
