-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Feb 2026 pada 15.23
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kawal_diri`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2025_01_01_000001_add_details_to_users_table', 1),
(3, '2026_01_01_000002_create_tasks_table', 1),
(4, '2026_01_01_000003_create_transactions_table', 1),
(5, '2026_01_01_000004_add_budget_to_users_table', 1),
(6, '2026_01_01_120704_create_notifications_table', 1),
(7, '2026_01_04_000001_add_is_active_to_users_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('bd2e1198-539b-449f-bba5-1db9cb04ff46', 'App\\Notifications\\AdminAnnouncement', 'App\\Models\\User', 2, '{\"title\":\"Maintenance Jam 7\",\"message\":\"Ada perbaikan settings\",\"type\":\"announcement\",\"created_at\":\"2026-01-07T04:35:04.663002Z\"}', '2026-01-06 21:35:27', '2026-01-06 21:35:04', '2026-01-06 21:35:27'),
('dbc39704-808c-48c8-aa7a-5651e569bcc9', 'App\\Notifications\\AdminAnnouncement', 'App\\Models\\User', 1, '{\"title\":\"Maintenance Jam 7\",\"message\":\"Ada perbaikan settings\",\"type\":\"announcement\",\"created_at\":\"2026-01-07T04:35:04.556014Z\"}', NULL, '2026-01-06 21:35:04', '2026-01-06 21:35:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `due_date` date NOT NULL,
  `status` enum('pending','completed') NOT NULL DEFAULT 'pending',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `priority`, `due_date`, `status`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Laporan Q3', 'Kerja', 'high', '2026-01-07', 'pending', NULL, '2026-01-06 18:49:23', '2026-01-06 18:49:23'),
(2, 2, 'Belajar', 'Pribadi', 'high', '2026-01-07', 'pending', NULL, '2026-01-06 18:49:48', '2026-01-06 18:49:48'),
(3, 2, 'Nongkrong', 'Pribadi', 'medium', '2026-01-07', 'completed', '2026-01-06 18:50:37', '2026-01-06 18:50:29', '2026-01-06 18:50:37'),
(4, 2, 'Belanja shopee', 'Pribadi', 'medium', '2026-01-08', 'pending', NULL, '2026-01-06 21:27:52', '2026-01-06 21:28:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` enum('income','expense') NOT NULL DEFAULT 'expense',
  `amount` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `status` enum('paid','pending') NOT NULL DEFAULT 'paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `title`, `category`, `type`, `amount`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Gaji', 'Lainnya', 'income', 5000000.00, '2026-01-07', 'paid', '2026-01-06 18:50:58', '2026-01-06 18:51:09'),
(2, 2, 'Nongki', 'Hiburan', 'expense', 50000.00, '2026-01-07', 'paid', '2026-01-06 18:51:34', '2026-01-06 18:51:34'),
(3, 2, 'Listrik', 'Tagihan', 'expense', 100000.00, '2026-01-07', 'paid', '2026-01-06 18:51:56', '2026-01-06 18:51:56'),
(4, 2, 'Makan', 'Makanan', 'expense', 500000.00, '2026-01-07', 'paid', '2026-01-06 18:52:16', '2026-01-06 18:52:16'),
(5, 2, 'Belanja', 'Belanja', 'expense', 800000.00, '2026-01-07', 'paid', '2026-01-06 18:52:31', '2026-01-06 18:52:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` int(11) NOT NULL DEFAULT 1,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `theme_preference` enum('light','dark','system') NOT NULL DEFAULT 'system',
  `accent_color` varchar(255) NOT NULL DEFAULT '#6366f1',
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `weekly_reports` tinyint(1) NOT NULL DEFAULT 1,
  `budget` decimal(15,2) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `phone`, `avatar`, `role`, `is_active`, `theme_preference`, `accent_color`, `email_notifications`, `weekly_reports`, `budget`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', NULL, 'test@example.com', '2026-01-06 13:10:07', '$2y$12$Lc7mEK2swun05Afqgz7ozuw8b/MYveuyZ3ha7BqFTvx.YXnclCx0m', NULL, 1, 'user', 1, 'system', '#6366f1', 1, 1, NULL, 'bTbtsPtcrp', '2026-01-06 13:10:08', '2026-01-06 13:10:08'),
(2, 'Eko', NULL, 'eko@gmail.com', NULL, '$2y$12$LzmQo6lBuG/7cTlQjw0jXO2Pm0nps5TT3VgdP02PjYxlM7iQoHEKK', NULL, 1, 'user', 1, 'light', '#6366f1', 1, 1, 4000000.00, NULL, '2026-01-06 13:13:48', '2026-01-06 21:35:20'),
(3, 'Administrator', 'admin', 'admin@kawaldiri.id', '2026-01-06 20:20:51', '$2y$12$U5SEQQPy9VBlHBvdqIamqe8bc5Rea6MDgqpGili6ihr0shxUF4Oke', NULL, 1, 'admin', 1, 'system', '#6366f1', 1, 1, NULL, NULL, '2026-01-06 20:20:51', '2026-01-06 20:20:51'),
(4, 'iqbal', NULL, 'iqbalaja@gmail.com', NULL, '$2y$12$ONjotsS/JWVs4ApT2Q9bO.05zewGlZcdPpC/m4VP4KJvv5G.VO0VC', NULL, 1, 'user', 1, 'dark', '#10b981', 1, 1, NULL, NULL, '2026-01-16 10:40:37', '2026-01-16 10:41:57');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_status_index` (`user_id`,`status`),
  ADD KEY `tasks_due_date_index` (`due_date`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_type_index` (`user_id`,`type`),
  ADD KEY `transactions_date_index` (`date`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
