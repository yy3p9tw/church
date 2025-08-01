-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-08-01 08:13:32
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `church_db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `bulletins`
--

CREATE TABLE `bulletins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `publish_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `bulletins`
--

INSERT INTO `bulletins` (`id`, `title`, `image_url`, `publish_date`, `created_at`, `updated_at`) VALUES
(1, '週報第1期', 'https://picsum.photos/seed/bulletin5/600/800', '2025-07-16', '2025-07-22 18:20:39', '2025-07-22 18:21:30'),
(2, '週報第2期', 'https://picsum.photos/seed/bulletin1/600/800', '2025-07-09', '2025-07-22 18:20:39', '2025-07-22 18:20:39'),
(6, '週報第6期', 'https://picsum.photos/seed/bulletin5/600/800', '2025-06-11', '2025-07-22 18:20:39', '2025-07-22 18:20:39'),
(7, '週報第7期', 'https://picsum.photos/seed/bulletin1/600/800', '2025-06-04', '2025-07-22 18:20:39', '2025-07-22 18:20:39'),
(10, '週報第10期', 'https://picsum.photos/seed/bulletin5/600/800', '2025-05-15', '2025-07-22 18:20:39', '2025-07-22 18:21:09'),
(14, '週報第3期', 'https://picsum.photos/seed/bulletin3/600/800', '2025-07-03', '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(15, '週報第4期', 'https://picsum.photos/seed/bulletin1/600/800', '2025-06-26', '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(16, '週報第5期', 'https://picsum.photos/seed/bulletin3/600/800', '2025-06-19', '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(19, '週報第8期', 'https://picsum.photos/seed/bulletin2/600/800', '2025-05-29', '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(20, '週報第9期', 'https://picsum.photos/seed/bulletin5/600/800', '2025-05-22', '2025-07-23 21:38:00', '2025-07-23 21:38:00');

-- --------------------------------------------------------

--
-- 資料表結構 `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `events`
--

INSERT INTO `events` (`id`, `title`, `slug`, `start_time`, `end_time`, `location`, `content`, `image_url`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '青年團契聚會', 'event_68803162d0d34', '2025-07-26 00:48:34', '2025-07-26 02:48:34', '教會副堂', '青年團契每月聚會，歡迎參加。', NULL, 'draft', NULL, '2025-07-22 16:48:34', '2025-07-22 16:48:34'),
(5, '聖誕晚會', 'event_688046f70e0e7', '2025-12-23 02:20:39', '2025-12-23 05:20:39', '大禮堂', '年度聖誕晚會，邀請親友共襄盛舉。', NULL, 'draft', NULL, '2025-07-22 18:20:39', '2025-07-22 18:20:39');

-- --------------------------------------------------------

--
-- 資料表結構 `failed_jobs`
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
-- 資料表結構 `jobs`
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
-- 資料表結構 `job_batches`
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
-- 資料表結構 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_23_002334_create_sermons_table', 1),
(5, '2025_07_23_002335_create_news_table', 1),
(6, '2025_07_23_002337_create_events_table', 1),
(7, '2025_07_23_002338_create_small_groups_table', 1),
(8, '2025_07_23_100000_create_bulletins_table', 2),
(9, '2025_07_23_200000_create_sliders_table', 3),
(10, '2025_07_23_210000_create_staff_table', 4);

-- --------------------------------------------------------

--
-- 資料表結構 `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `news_date` date DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `news_date`, `publish_date`, `image_url`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(7, '教會週報', 'news_6881c6b80d205', '本週教會活動公告。', '2025-07-24', NULL, NULL, 'draft', NULL, '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(8, '下週特別聚會', 'news_6881c6b80d21f', '下週將舉辦特別聚會，歡迎參加。', '2025-07-31', NULL, NULL, 'draft', NULL, '2025-07-23 21:38:00', '2025-07-23 21:38:00');

-- --------------------------------------------------------

--
-- 資料表結構 `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `sermons`
--

CREATE TABLE `sermons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `speaker` varchar(255) NOT NULL,
  `sermon_date` date NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `sermons`
--

INSERT INTO `sermons` (`id`, `title`, `slug`, `speaker`, `sermon_date`, `video_url`, `audio_url`, `content`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(2, '愛的真諦', 'sermon_68803162cff97', '李傳道', '2025-07-09', NULL, NULL, '這是一篇關於愛的講道內容。', 'draft', NULL, '2025-07-22 16:48:34', '2025-07-22 16:48:34'),
(5, '信心的力量', 'sermon_688046f70c339', '王牧師', '2025-07-16', NULL, NULL, '這是一篇關於信心的講道內容。', 'draft', NULL, '2025-07-22 18:20:39', '2025-07-22 18:20:39'),
(8, '信心的力量', 'sermon_6881c6b80bef2', '王牧師', '2025-07-17', NULL, NULL, '這是一篇關於信心的講道內容。', 'draft', NULL, '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(9, '愛的真諦', 'sermon_6881c6b80c0c9', '李傳道', '2025-07-10', NULL, NULL, '這是一篇關於愛的講道內容。', 'draft', NULL, '2025-07-23 21:38:00', '2025-07-23 21:38:00');

-- --------------------------------------------------------

--
-- 資料表結構 `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `image_url`, `link_url`, `sort_order`, `created_at`, `updated_at`) VALUES
(5, '輪播圖 1', 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80', 'https://example.com/1', 0, '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(6, '輪播圖 2', 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=1200&q=80', 'https://example.com/2', 1, '2025-07-23 21:38:00', '2025-07-23 21:38:00'),
(7, '輪播圖 3', 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=1200&q=80', 'https://example.com/3', 2, '2025-07-23 21:38:00', '2025-07-23 21:38:00');

-- --------------------------------------------------------

--
-- 資料表結構 `small_groups`
--

CREATE TABLE `small_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meeting_time` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `small_groups`
--

INSERT INTO `small_groups` (`id`, `name`, `slug`, `type`, `description`, `meeting_time`, `contact_person`, `image_url`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '約書亞小組', 'group_68803162d1367', '查經', '每週五晚上查經聚會。', NULL, '陳弟兄', NULL, 1, NULL, '2025-07-22 16:48:34', '2025-07-22 17:50:36'),
(2, '以斯帖小組', 'group_68803162d1373', '禱告', '每週三早上禱告會。', NULL, '林姊妹', NULL, 1, NULL, '2025-07-22 16:48:34', '2025-07-22 16:48:34');

-- --------------------------------------------------------

--
-- 資料表結構 `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `staff`
--

INSERT INTO `staff` (`id`, `name`, `title`, `photo`, `bio`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, '王大衛', '主任牧師', 'staff/uFeHYUIuFnQZdoGvrFrvlnXmEpnGwHIDbeHoWlsG.jpg', '負責教會異象、講道與牧養。', 1, 1, '2025-07-22 18:56:01', '2025-07-22 18:59:48'),
(2, '李以諾', '行政同工', NULL, '協助行政、活動與關懷事工。', 2, 1, '2025-07-22 18:56:01', '2025-07-22 18:56:01'),
(3, '張恩慈', '敬拜主領', NULL, '帶領敬拜團隊，服事主日聚會。', 3, 1, '2025-07-22 18:56:01', '2025-07-22 18:56:01');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user' COMMENT '角色：user, admin, editor',
  `status` varchar(255) NOT NULL DEFAULT 'active' COMMENT '狀態：active, inactive, banned',
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `phone`, `avatar`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-07-22 16:48:34', '$2y$12$usQrsqg3cphzWTBerb1Az.Fk9R5IxjHFo8wrx4Qr8cXRzIVyXihEe', 'user', 'active', NULL, NULL, NULL, 'rlB90Pw8NX', '2025-07-22 16:48:34', '2025-07-22 16:48:34');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `bulletins`
--
ALTER TABLE `bulletins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bulletins_publish_date_index` (`publish_date`);

--
-- 資料表索引 `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- 資料表索引 `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- 資料表索引 `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_created_by_foreign` (`created_by`),
  ADD KEY `events_start_time_index` (`start_time`);

--
-- 資料表索引 `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- 資料表索引 `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- 資料表索引 `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_created_by_foreign` (`created_by`),
  ADD KEY `news_news_date_index` (`news_date`),
  ADD KEY `news_publish_date_index` (`publish_date`);

--
-- 資料表索引 `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- 資料表索引 `sermons`
--
ALTER TABLE `sermons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sermons_slug_unique` (`slug`),
  ADD KEY `sermons_created_by_foreign` (`created_by`),
  ADD KEY `sermons_sermon_date_index` (`sermon_date`);

--
-- 資料表索引 `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- 資料表索引 `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `small_groups`
--
ALTER TABLE `small_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `small_groups_slug_unique` (`slug`),
  ADD KEY `small_groups_created_by_foreign` (`created_by`);

--
-- 資料表索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `bulletins`
--
ALTER TABLE `bulletins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sermons`
--
ALTER TABLE `sermons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `small_groups`
--
ALTER TABLE `small_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- 資料表的限制式 `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- 資料表的限制式 `sermons`
--
ALTER TABLE `sermons`
  ADD CONSTRAINT `sermons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- 資料表的限制式 `small_groups`
--
ALTER TABLE `small_groups`
  ADD CONSTRAINT `small_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
