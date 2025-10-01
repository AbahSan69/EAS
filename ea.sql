-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 06:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ea`
--

-- --------------------------------------------------------

--
-- Table structure for table `architecture_aplikasi_comments`
--

CREATE TABLE `architecture_aplikasi_comments` (
  `id` int(11) NOT NULL,
  `user_id` bigint(29) UNSIGNED NOT NULL,
  `sp_aplikasi_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('Belum Review','Revisi','Disetujui') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `architecture_bisnis`
--

CREATE TABLE `architecture_bisnis` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `architecture_bisnis`
--

INSERT INTO `architecture_bisnis` (`id`, `judul`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Digital Organisasi', 'Ini adalah digital organisasi', '2025-09-25 08:35:45', '2025-09-25 08:35:45'),
(2, 'Bisnis Inovasi', 'Ini adalah bisnis inovasi', '2025-09-25 08:36:48', '2025-09-25 08:36:48'),
(3, 'Accountability', 'Ini adalah accountability', '2025-09-25 08:38:05', '2025-09-25 08:38:05'),
(4, 'Produk', 'Ini adalah produk', '2025-09-25 08:38:05', '2025-09-25 08:38:05'),
(5, 'Constrain', 'Ini adalah constrains', '2025-09-25 08:38:49', '2025-09-25 08:38:49'),
(6, 'Risk', 'Ini adalah risk', '2025-09-25 08:38:49', '2025-09-25 08:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `architecture_bisnis_comments`
--

CREATE TABLE `architecture_bisnis_comments` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sp_bisnis_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('Belum Review','Revisi','Disetujui') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `architecture_informasi_comments`
--

CREATE TABLE `architecture_informasi_comments` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sp_informasi_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('Belum Review','Revisi','Disetujui') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `architecture_keamanan_comments`
--

CREATE TABLE `architecture_keamanan_comments` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sp_keamanan_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('Belum Review','Revisi','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `architecture_teknologi_comments`
--

CREATE TABLE `architecture_teknologi_comments` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sp_teknologi_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('Belum Review','Revisi','Disetujui') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `architecture_visions`
--

CREATE TABLE `architecture_visions` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `architecture_visions`
--

INSERT INTO `architecture_visions` (`id`, `judul`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Visi & Misi', 'Ini adalah visi misi', '2025-09-24 13:17:15', '2025-09-24 13:19:22'),
(2, 'Principles', 'Ini adalah principles', '2025-09-24 13:18:12', '2025-09-24 13:18:12'),
(3, 'Bisnis Strategi', 'Ini adalah bisnis strategi', '2025-09-24 13:18:12', '2025-09-24 13:18:12'),
(4, 'Objective & Drivers', 'Ini adalah Objective & Drivers', '2025-09-24 13:18:59', '2025-09-24 13:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `architecture_vision_comments`
--

CREATE TABLE `architecture_vision_comments` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sp_vision_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `status_review` enum('Belum Review','Revisi','Disetujui') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `architecture_vision_details`
--

CREATE TABLE `architecture_vision_details` (
  `id` int(11) NOT NULL,
  `vision_id` int(11) NOT NULL,
  `konten` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, '0001_01_01_000002_create_jobs_table', 1);

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
-- Table structure for table `pts`
--

CREATE TABLE `pts` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pts`
--

INSERT INTO `pts` (`id`, `user_id`, `nama`, `jenis`, `created_at`, `updated_at`) VALUES
(4, 1, 'Universitas Komputer Indonesia', 'Universitas', '2025-09-24 00:49:58', '2025-09-24 13:01:19'),
(5, 2, 'Universitas Pajajaran', 'Universitas', '2025-09-24 05:56:41', '2025-09-24 13:01:29'),
(18, 2, 'UIN', 'Universitas', '2025-09-25 23:43:42', '2025-09-25 23:43:42'),
(19, 2, 'UNJANI', 'Universitas', '2025-09-26 02:20:33', '2025-09-26 02:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-09-24 06:16:03', '2025-09-24 06:16:03'),
(2, 'Stakeholder PTS', '2025-09-24 06:16:03', '2025-09-24 06:16:03'),
(3, 'Yayasan', '2025-09-24 06:16:14', '2025-09-24 06:16:14');

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
('etTS5FA47VqWGnuRe7HadKHq3ApKbPzApkjNLRuv', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRXN5M2kydVo0NWR5ZnY4OXhnbThOcTVFQXR6T0RNb3MxalJycUZZVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC95YXlhc2FuL3Zpc2lvbi92aXNpbWlzaS9zaG93LzUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTozMDp7aTowO3M6MTg6ImFsZXJ0LmNvbmZpZy50aXRsZSI7aToxO3M6MTc6ImFsZXJ0LmNvbmZpZy50ZXh0IjtpOjI7czoxODoiYWxlcnQuY29uZmlnLnRpbWVyIjtpOjM7czoyMzoiYWxlcnQuY29uZmlnLmJhY2tncm91bmQiO2k6NDtzOjE4OiJhbGVydC5jb25maWcud2lkdGgiO2k6NTtzOjIzOiJhbGVydC5jb25maWcuaGVpZ2h0QXV0byI7aTo2O3M6MjA6ImFsZXJ0LmNvbmZpZy5wYWRkaW5nIjtpOjc7czozMDoiYWxlcnQuY29uZmlnLnNob3dDb25maXJtQnV0dG9uIjtpOjg7czoyODoiYWxlcnQuY29uZmlnLnNob3dDbG9zZUJ1dHRvbiI7aTo5O3M6MzA6ImFsZXJ0LmNvbmZpZy5jb25maXJtQnV0dG9uVGV4dCI7aToxMDtzOjI5OiJhbGVydC5jb25maWcuY2FuY2VsQnV0dG9uVGV4dCI7aToxMTtzOjI5OiJhbGVydC5jb25maWcudGltZXJQcm9ncmVzc0JhciI7aToxMjtzOjI0OiJhbGVydC5jb25maWcuY3VzdG9tQ2xhc3MiO2k6MTM7czoxNzoiYWxlcnQuY29uZmlnLmljb24iO2k6MTQ7czoxMjoiYWxlcnQuY29uZmlnIjtpOjE1O3M6MTg6ImFsZXJ0LmNvbmZpZy50aXRsZSI7aToxNjtzOjE3OiJhbGVydC5jb25maWcudGV4dCI7aToxNztzOjE4OiJhbGVydC5jb25maWcudGltZXIiO2k6MTg7czoyMzoiYWxlcnQuY29uZmlnLmJhY2tncm91bmQiO2k6MTk7czoxODoiYWxlcnQuY29uZmlnLndpZHRoIjtpOjIwO3M6MjM6ImFsZXJ0LmNvbmZpZy5oZWlnaHRBdXRvIjtpOjIxO3M6MjA6ImFsZXJ0LmNvbmZpZy5wYWRkaW5nIjtpOjIyO3M6MzA6ImFsZXJ0LmNvbmZpZy5zaG93Q29uZmlybUJ1dHRvbiI7aToyMztzOjI4OiJhbGVydC5jb25maWcuc2hvd0Nsb3NlQnV0dG9uIjtpOjI0O3M6MzA6ImFsZXJ0LmNvbmZpZy5jb25maXJtQnV0dG9uVGV4dCI7aToyNTtzOjI5OiJhbGVydC5jb25maWcuY2FuY2VsQnV0dG9uVGV4dCI7aToyNjtzOjI5OiJhbGVydC5jb25maWcudGltZXJQcm9ncmVzc0JhciI7aToyNztzOjI0OiJhbGVydC5jb25maWcuY3VzdG9tQ2xhc3MiO2k6Mjg7czoxNzoiYWxlcnQuY29uZmlnLmljb24iO2k6Mjk7czoxMjoiYWxlcnQuY29uZmlnIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6NToiYWxlcnQiO2E6MDp7fX0=', 1758866747),
('LCzHKymjhRL8Pu6WkB5xcuL0rLW4skVhOErDp1Hh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRXhqY24wZ2I1a3A0aHBtaHdabGdtaUU3a0JUU2RTMkM0VFc3dFFiQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjQ0OntpOjA7czoxODoiYWxlcnQuY29uZmlnLnRpdGxlIjtpOjE7czoxNzoiYWxlcnQuY29uZmlnLnRleHQiO2k6MjtzOjE4OiJhbGVydC5jb25maWcudGltZXIiO2k6MztzOjIzOiJhbGVydC5jb25maWcuYmFja2dyb3VuZCI7aTo0O3M6MTg6ImFsZXJ0LmNvbmZpZy53aWR0aCI7aTo1O3M6MjM6ImFsZXJ0LmNvbmZpZy5oZWlnaHRBdXRvIjtpOjY7czoyMDoiYWxlcnQuY29uZmlnLnBhZGRpbmciO2k6NztzOjMwOiJhbGVydC5jb25maWcuc2hvd0NvbmZpcm1CdXR0b24iO2k6ODtzOjI4OiJhbGVydC5jb25maWcuc2hvd0Nsb3NlQnV0dG9uIjtpOjk7czozMDoiYWxlcnQuY29uZmlnLmNvbmZpcm1CdXR0b25UZXh0IjtpOjEwO3M6Mjk6ImFsZXJ0LmNvbmZpZy5jYW5jZWxCdXR0b25UZXh0IjtpOjExO3M6Mjk6ImFsZXJ0LmNvbmZpZy50aW1lclByb2dyZXNzQmFyIjtpOjEyO3M6MjQ6ImFsZXJ0LmNvbmZpZy5jdXN0b21DbGFzcyI7aToxMztzOjE3OiJhbGVydC5jb25maWcuaWNvbiI7aToxNDtzOjEyOiJhbGVydC5jb25maWciO2k6MTU7czoxODoiYWxlcnQuY29uZmlnLnRpdGxlIjtpOjE2O3M6MTc6ImFsZXJ0LmNvbmZpZy50ZXh0IjtpOjE3O3M6MTg6ImFsZXJ0LmNvbmZpZy50aW1lciI7aToxODtzOjIzOiJhbGVydC5jb25maWcuYmFja2dyb3VuZCI7aToxOTtzOjE4OiJhbGVydC5jb25maWcud2lkdGgiO2k6MjA7czoyMDoiYWxlcnQuY29uZmlnLnBhZGRpbmciO2k6MjE7czozMDoiYWxlcnQuY29uZmlnLnNob3dDb25maXJtQnV0dG9uIjtpOjIyO3M6Mjg6ImFsZXJ0LmNvbmZpZy5zaG93Q2xvc2VCdXR0b24iO2k6MjM7czozMDoiYWxlcnQuY29uZmlnLmNvbmZpcm1CdXR0b25UZXh0IjtpOjI0O3M6Mjk6ImFsZXJ0LmNvbmZpZy5jYW5jZWxCdXR0b25UZXh0IjtpOjI1O3M6Mjk6ImFsZXJ0LmNvbmZpZy50aW1lclByb2dyZXNzQmFyIjtpOjI2O3M6MjQ6ImFsZXJ0LmNvbmZpZy5jdXN0b21DbGFzcyI7aToyNztzOjE3OiJhbGVydC5jb25maWcuaWNvbiI7aToyODtzOjE4OiJhbGVydC5jb25maWcudG9hc3QiO2k6Mjk7czoyMToiYWxlcnQuY29uZmlnLnBvc2l0aW9uIjtpOjMwO3M6MTI6ImFsZXJ0LmNvbmZpZyI7aTozMTtzOjE4OiJhbGVydC5jb25maWcudGl0bGUiO2k6MzI7czoxNzoiYWxlcnQuY29uZmlnLnRleHQiO2k6MzM7czoyMzoiYWxlcnQuY29uZmlnLmJhY2tncm91bmQiO2k6MzQ7czozMDoiYWxlcnQuY29uZmlnLnNob3dDb25maXJtQnV0dG9uIjtpOjM1O3M6MzA6ImFsZXJ0LmNvbmZpZy5jb25maXJtQnV0dG9uVGV4dCI7aTozNjtzOjI5OiJhbGVydC5jb25maWcuY2FuY2VsQnV0dG9uVGV4dCI7aTozNztzOjI5OiJhbGVydC5jb25maWcudGltZXJQcm9ncmVzc0JhciI7aTozODtzOjI0OiJhbGVydC5jb25maWcuY3VzdG9tQ2xhc3MiO2k6Mzk7czoxNzoiYWxlcnQuY29uZmlnLmljb24iO2k6NDA7czoxODoiYWxlcnQuY29uZmlnLnRvYXN0IjtpOjQxO3M6MjE6ImFsZXJ0LmNvbmZpZy5wb3NpdGlvbiI7aTo0MjtzOjI4OiJhbGVydC5jb25maWcuc2hvd0Nsb3NlQnV0dG9uIjtpOjQzO3M6MTI6ImFsZXJ0LmNvbmZpZyI7fX1zOjU6ImFsZXJ0IjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9fQ==', 1758869034);

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_aplikasi`
--

CREATE TABLE `sp_architecture_aplikasi` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pts_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_aplikasi_histories`
--

CREATE TABLE `sp_architecture_aplikasi_histories` (
  `id` int(11) NOT NULL,
  `sp_aplikasi_id` int(11) NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_bisnis`
--

CREATE TABLE `sp_architecture_bisnis` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pts_id` int(11) NOT NULL,
  `bisnis_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_bisnis_histories`
--

CREATE TABLE `sp_architecture_bisnis_histories` (
  `id` int(11) NOT NULL,
  `sp_bisnis_id` int(11) NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_informasi`
--

CREATE TABLE `sp_architecture_informasi` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pts_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_informasi_histories`
--

CREATE TABLE `sp_architecture_informasi_histories` (
  `id` int(11) NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `sp_informasi_id` int(20) NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_keamanan`
--

CREATE TABLE `sp_architecture_keamanan` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pts_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_keamanan_histories`
--

CREATE TABLE `sp_architecture_keamanan_histories` (
  `id` int(11) NOT NULL,
  `sp_keamanan_id` int(11) NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_teknologi`
--

CREATE TABLE `sp_architecture_teknologi` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pts_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_teknologi_histories`
--

CREATE TABLE `sp_architecture_teknologi_histories` (
  `id` int(11) NOT NULL,
  `sp_teknologi_id` int(11) NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_visions`
--

CREATE TABLE `sp_architecture_visions` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pts_id` int(11) NOT NULL,
  `vision_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sp_architecture_vision_histories`
--

CREATE TABLE `sp_architecture_vision_histories` (
  `id` int(11) NOT NULL,
  `sp_vision_id` int(11) NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sandi Komara', 'sandikomara01@gmail.com', NULL, '$2y$10$qrqTFnvISs5IY.Fe04cfRetKho6uoVNzohJQPytcE5BYLxkxuqIOq', NULL, NULL, NULL),
(2, 2, 'Universitas Pajajaran (UNPAD)', 'sandi.10119099@mahasiswa.unikom.ac.id', NULL, '$2y$12$HPWNuuBkDhI.D3PLQD8q2.9hGu8bPMov/FOsMUk33qEnpzlYuxwSK', NULL, '2025-09-24 05:30:52', '2025-09-24 05:31:05'),
(3, 3, 'Yayasan UNPAD', 'disandi0069@gmail.com', NULL, '$2y$12$gA3rkJInSEeNwFWy2wBA4uV6MH2F4Go/pRv7HcBN1ELh6gVYluzse', NULL, '2025-09-24 08:07:56', '2025-09-24 08:07:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `architecture_aplikasi_comments`
--
ALTER TABLE `architecture_aplikasi_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sp_aplikasi_id` (`sp_aplikasi_id`);

--
-- Indexes for table `architecture_bisnis`
--
ALTER TABLE `architecture_bisnis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `architecture_bisnis_comments`
--
ALTER TABLE `architecture_bisnis_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sp_bisnis_id` (`sp_bisnis_id`);

--
-- Indexes for table `architecture_informasi_comments`
--
ALTER TABLE `architecture_informasi_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sp_informasi_id` (`sp_informasi_id`);

--
-- Indexes for table `architecture_keamanan_comments`
--
ALTER TABLE `architecture_keamanan_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_keamanan_id` (`sp_keamanan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `architecture_teknologi_comments`
--
ALTER TABLE `architecture_teknologi_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sp_teknologi_id` (`sp_teknologi_id`);

--
-- Indexes for table `architecture_visions`
--
ALTER TABLE `architecture_visions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `architecture_vision_comments`
--
ALTER TABLE `architecture_vision_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sp_vision_id` (`sp_vision_id`);

--
-- Indexes for table `architecture_vision_details`
--
ALTER TABLE `architecture_vision_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vision_id` (`vision_id`);

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
-- Indexes for table `pts`
--
ALTER TABLE `pts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sp_architecture_aplikasi`
--
ALTER TABLE `sp_architecture_aplikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pts_id` (`pts_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sp_architecture_aplikasi_histories`
--
ALTER TABLE `sp_architecture_aplikasi_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `sp_aplikasi_id` (`sp_aplikasi_id`);

--
-- Indexes for table `sp_architecture_bisnis`
--
ALTER TABLE `sp_architecture_bisnis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pts_id` (`pts_id`),
  ADD KEY `bisnis_id` (`bisnis_id`);

--
-- Indexes for table `sp_architecture_bisnis_histories`
--
ALTER TABLE `sp_architecture_bisnis_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `sp_bisnis_id` (`sp_bisnis_id`);

--
-- Indexes for table `sp_architecture_informasi`
--
ALTER TABLE `sp_architecture_informasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pts_id` (`pts_id`);

--
-- Indexes for table `sp_architecture_informasi_histories`
--
ALTER TABLE `sp_architecture_informasi_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `sp_informasi_id` (`sp_informasi_id`);

--
-- Indexes for table `sp_architecture_keamanan`
--
ALTER TABLE `sp_architecture_keamanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pts_id` (`pts_id`);

--
-- Indexes for table `sp_architecture_keamanan_histories`
--
ALTER TABLE `sp_architecture_keamanan_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `sp_keamanan_id` (`sp_keamanan_id`);

--
-- Indexes for table `sp_architecture_teknologi`
--
ALTER TABLE `sp_architecture_teknologi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pts_id` (`pts_id`);

--
-- Indexes for table `sp_architecture_teknologi_histories`
--
ALTER TABLE `sp_architecture_teknologi_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_teknologi_id` (`sp_teknologi_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `sp_architecture_visions`
--
ALTER TABLE `sp_architecture_visions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pts_id` (`pts_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vision_id` (`vision_id`);

--
-- Indexes for table `sp_architecture_vision_histories`
--
ALTER TABLE `sp_architecture_vision_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_vision_id` (`sp_vision_id`),
  ADD KEY `created_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `architecture_aplikasi_comments`
--
ALTER TABLE `architecture_aplikasi_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `architecture_bisnis`
--
ALTER TABLE `architecture_bisnis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `architecture_bisnis_comments`
--
ALTER TABLE `architecture_bisnis_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `architecture_informasi_comments`
--
ALTER TABLE `architecture_informasi_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `architecture_keamanan_comments`
--
ALTER TABLE `architecture_keamanan_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `architecture_teknologi_comments`
--
ALTER TABLE `architecture_teknologi_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `architecture_visions`
--
ALTER TABLE `architecture_visions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `architecture_vision_comments`
--
ALTER TABLE `architecture_vision_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `architecture_vision_details`
--
ALTER TABLE `architecture_vision_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pts`
--
ALTER TABLE `pts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sp_architecture_aplikasi`
--
ALTER TABLE `sp_architecture_aplikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sp_architecture_aplikasi_histories`
--
ALTER TABLE `sp_architecture_aplikasi_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sp_architecture_bisnis`
--
ALTER TABLE `sp_architecture_bisnis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sp_architecture_bisnis_histories`
--
ALTER TABLE `sp_architecture_bisnis_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sp_architecture_informasi`
--
ALTER TABLE `sp_architecture_informasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sp_architecture_informasi_histories`
--
ALTER TABLE `sp_architecture_informasi_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sp_architecture_keamanan`
--
ALTER TABLE `sp_architecture_keamanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sp_architecture_keamanan_histories`
--
ALTER TABLE `sp_architecture_keamanan_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sp_architecture_teknologi`
--
ALTER TABLE `sp_architecture_teknologi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sp_architecture_teknologi_histories`
--
ALTER TABLE `sp_architecture_teknologi_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sp_architecture_visions`
--
ALTER TABLE `sp_architecture_visions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sp_architecture_vision_histories`
--
ALTER TABLE `sp_architecture_vision_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `architecture_aplikasi_comments`
--
ALTER TABLE `architecture_aplikasi_comments`
  ADD CONSTRAINT `architecture_aplikasi_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `architecture_aplikasi_comments_ibfk_2` FOREIGN KEY (`sp_aplikasi_id`) REFERENCES `sp_architecture_aplikasi` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `architecture_bisnis_comments`
--
ALTER TABLE `architecture_bisnis_comments`
  ADD CONSTRAINT `architecture_bisnis_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `architecture_bisnis_comments_ibfk_2` FOREIGN KEY (`sp_bisnis_id`) REFERENCES `sp_architecture_bisnis` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `architecture_informasi_comments`
--
ALTER TABLE `architecture_informasi_comments`
  ADD CONSTRAINT `architecture_informasi_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `architecture_informasi_comments_ibfk_2` FOREIGN KEY (`sp_informasi_id`) REFERENCES `sp_architecture_informasi` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `architecture_keamanan_comments`
--
ALTER TABLE `architecture_keamanan_comments`
  ADD CONSTRAINT `architecture_keamanan_comments_ibfk_1` FOREIGN KEY (`sp_keamanan_id`) REFERENCES `sp_architecture_keamanan` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `architecture_keamanan_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `architecture_teknologi_comments`
--
ALTER TABLE `architecture_teknologi_comments`
  ADD CONSTRAINT `architecture_teknologi_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `architecture_teknologi_comments_ibfk_2` FOREIGN KEY (`sp_teknologi_id`) REFERENCES `sp_architecture_teknologi` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `architecture_vision_comments`
--
ALTER TABLE `architecture_vision_comments`
  ADD CONSTRAINT `architecture_vision_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `architecture_vision_comments_ibfk_2` FOREIGN KEY (`sp_vision_id`) REFERENCES `sp_architecture_visions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `architecture_vision_details`
--
ALTER TABLE `architecture_vision_details`
  ADD CONSTRAINT `architecture_vision_details_ibfk_1` FOREIGN KEY (`vision_id`) REFERENCES `architecture_visions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `pts`
--
ALTER TABLE `pts`
  ADD CONSTRAINT `pts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_aplikasi`
--
ALTER TABLE `sp_architecture_aplikasi`
  ADD CONSTRAINT `sp_architecture_aplikasi_ibfk_1` FOREIGN KEY (`pts_id`) REFERENCES `pts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_aplikasi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_aplikasi_histories`
--
ALTER TABLE `sp_architecture_aplikasi_histories`
  ADD CONSTRAINT `sp_architecture_aplikasi_histories_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_aplikasi_histories_ibfk_2` FOREIGN KEY (`sp_aplikasi_id`) REFERENCES `sp_architecture_aplikasi` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_bisnis`
--
ALTER TABLE `sp_architecture_bisnis`
  ADD CONSTRAINT `sp_architecture_bisnis_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_bisnis_ibfk_2` FOREIGN KEY (`pts_id`) REFERENCES `pts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_bisnis_ibfk_3` FOREIGN KEY (`bisnis_id`) REFERENCES `architecture_bisnis` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_bisnis_histories`
--
ALTER TABLE `sp_architecture_bisnis_histories`
  ADD CONSTRAINT `sp_architecture_bisnis_histories_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_bisnis_histories_ibfk_2` FOREIGN KEY (`sp_bisnis_id`) REFERENCES `sp_architecture_bisnis` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_informasi`
--
ALTER TABLE `sp_architecture_informasi`
  ADD CONSTRAINT `sp_architecture_informasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_informasi_ibfk_2` FOREIGN KEY (`pts_id`) REFERENCES `pts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_informasi_histories`
--
ALTER TABLE `sp_architecture_informasi_histories`
  ADD CONSTRAINT `sp_architecture_informasi_histories_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_informasi_histories_ibfk_2` FOREIGN KEY (`sp_informasi_id`) REFERENCES `sp_architecture_informasi` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_keamanan`
--
ALTER TABLE `sp_architecture_keamanan`
  ADD CONSTRAINT `sp_architecture_keamanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_keamanan_ibfk_2` FOREIGN KEY (`pts_id`) REFERENCES `pts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_keamanan_histories`
--
ALTER TABLE `sp_architecture_keamanan_histories`
  ADD CONSTRAINT `sp_architecture_keamanan_histories_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_keamanan_histories_ibfk_2` FOREIGN KEY (`sp_keamanan_id`) REFERENCES `sp_architecture_keamanan` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_teknologi`
--
ALTER TABLE `sp_architecture_teknologi`
  ADD CONSTRAINT `sp_architecture_teknologi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_teknologi_ibfk_2` FOREIGN KEY (`pts_id`) REFERENCES `pts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_teknologi_histories`
--
ALTER TABLE `sp_architecture_teknologi_histories`
  ADD CONSTRAINT `sp_architecture_teknologi_histories_ibfk_1` FOREIGN KEY (`sp_teknologi_id`) REFERENCES `sp_architecture_teknologi` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_teknologi_histories_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_visions`
--
ALTER TABLE `sp_architecture_visions`
  ADD CONSTRAINT `sp_architecture_visions_ibfk_1` FOREIGN KEY (`pts_id`) REFERENCES `pts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_visions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_visions_ibfk_3` FOREIGN KEY (`vision_id`) REFERENCES `architecture_visions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `sp_architecture_vision_histories`
--
ALTER TABLE `sp_architecture_vision_histories`
  ADD CONSTRAINT `sp_architecture_vision_histories_ibfk_1` FOREIGN KEY (`sp_vision_id`) REFERENCES `sp_architecture_visions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `sp_architecture_vision_histories_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
