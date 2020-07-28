-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 29, 2020 at 12:52 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project360db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `super` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`),
  KEY `admins_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `picture`, `date_of_birth`, `super`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'hamza', 'alaoui', 'hamza@hotmail.be', '036265626', 'Fes, Morocco', 'Fes', NULL, NULL, 1, 3, '2020-06-29 12:48:17', '2020-06-29 12:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `annoncers`
--

DROP TABLE IF EXISTS `annoncers`;
CREATE TABLE IF NOT EXISTS `annoncers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `annoncers_email_unique` (`email`),
  KEY `annoncers_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `annoncers`
--

INSERT INTO `annoncers` (`id`, `last_name`, `first_name`, `phone`, `address`, `city`, `email`, `picture`, `date_of_birth`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'alaoui', 'hamza', '036265626', 'Fes, Morocco', 'Fes', 'hamza_hm@hotmail.be', NULL, NULL, 4, '2020-06-29 12:52:10', '2020-06-29 12:52:10');

-- --------------------------------------------------------

--
-- Table structure for table `annonces`
--

DROP TABLE IF EXISTS `annonces`;
CREATE TABLE IF NOT EXISTS `annonces` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(15,8) DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position_map` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rent` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `premium` tinyint(1) NOT NULL,
  `annoncer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `annonces_annoncer_id_foreign` (`annoncer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `annonces`
--

INSERT INTO `annonces` (`id`, `title`, `type`, `description`, `price`, `address`, `city`, `position_map`, `status`, `rent`, `premium`, `annoncer_id`, `created_at`, `updated_at`) VALUES
(1, 'annonce 1', 'maison', 'annonce 1 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 0, NULL, '2020-06-29 12:49:26', '2020-06-29 12:49:26'),
(2, 'annonce 2', 'maison', 'annonce 2 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 0, NULL, '2020-06-29 12:49:34', '2020-06-29 12:49:34'),
(3, 'annonce 3', 'maison', 'annonce 3 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 0, NULL, '2020-06-29 12:49:39', '2020-06-29 12:49:39'),
(4, 'annonce 4', 'maison', 'annonce 4 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 0, NULL, '2020-06-29 12:49:45', '2020-06-29 12:49:45'),
(5, 'annonce 5', 'maison', 'annonce 5 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 0, NULL, '2020-06-29 12:49:50', '2020-06-29 12:49:50'),
(6, 'annonce 6', 'maison', 'annonce 6 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 1, NULL, '2020-06-29 12:50:30', '2020-06-29 12:50:30'),
(7, 'annonce 7', 'maison', 'annonce 7 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 1, NULL, '2020-06-29 12:50:37', '2020-06-29 12:50:37'),
(8, 'annonce 8', 'maison', 'annonce 8 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 1, NULL, '2020-06-29 12:50:43', '2020-06-29 12:50:43'),
(9, 'annonce 9', 'maison', 'annonce 9 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 1, NULL, '2020-06-29 12:50:47', '2020-06-29 12:50:47'),
(10, 'annonce 10', 'maison', 'annonce 10 ljsqkdsiqqqqqqqqqufhiurfhiffffffffflqjdiqejdiejdiej', NULL, NULL, 'Fes', NULL, '1', '1', 1, NULL, '2020-06-29 12:50:52', '2020-06-29 12:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_06_04_184421_create_users_table', 1),
(2, '2020_06_04_191051_create_annoncers_table', 1),
(3, '2020_06_04_191328_create_annonces_table', 1),
(4, '2020_06_06_092504_create_admins_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2',
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `role`, `active`, `code`, `created_at`, `updated_at`) VALUES
(3, 'hamza6word', 'hamza@hotmail.be', '$2y$10$Lr8Jyh8.B7Ivl660Uhq.9eb0/q6cwWrgvNkTXnXuRIPEa.FmBsFkG', 'VnRLM3pnUHBHeXdiQzRaQTRpeFRYMTV4bzl6VDBpZTZPNnJ2MnZRcw==', '1', 1, NULL, '2020-06-29 12:48:17', '2020-06-29 12:48:17'),
(4, 'hamza5word', 'hamza_hm@hotmail.be', '$2y$10$1tfB/jNUK9AZFduFd7JEs.wO20dJWKAvLcNR.PriZmmJqzse1Yc/G', 'aE9YZkdUdXdlaE5yelhJTnRVRG9JZnQ2Yk9CbmNGcDNZWUg3ZjJDaQ==', '2', 1, '33640', '2020-06-29 12:48:45', '2020-06-29 12:49:03');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
