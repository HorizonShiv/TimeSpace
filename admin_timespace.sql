-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 20, 2024 at 01:49 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_timespace`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisement_type`
--

CREATE TABLE `advertisement_type` (
  `id` int(11) NOT NULL,
  `category_master_id` int(11) DEFAULT NULL,
  `publisher_master_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `advertisement_type`
--

INSERT INTO `advertisement_type` (`id`, `category_master_id`, `publisher_master_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'FB Feed', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(2, 1, 1, 'FB Video Feed', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(3, 1, 1, 'FB Stories', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(4, 1, 1, 'FB Reels', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(5, 1, 1, 'FB Ads on Reels', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(6, 1, 1, 'Insta Profile Feed', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(7, 1, 1, 'Insta Feed', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(8, 1, 1, 'Insta Stories', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(9, 1, 1, 'Insta Reels', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(10, 1, 1, 'Carousel', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(11, 1, 1, 'Collection', '2024-05-10 01:45:48', '2024-05-10 01:45:48', NULL),
(12, 1, 2, 'Standard Image', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(13, 1, 2, 'Standard Video', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(14, 1, 2, 'Max Video', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(15, 1, 2, 'Carousel Ads', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(16, 1, 2, 'Shopping Ads', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(17, 1, 2, 'Collections Ads', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(18, 1, 2, 'Idea Ads', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(19, 1, 2, 'Showcase Ads', '2024-05-10 01:46:59', '2024-05-10 01:46:59', NULL),
(20, 1, 3, 'Image', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(21, 1, 3, 'Video', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(22, 1, 3, 'Spark', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(23, 1, 3, 'Pangle', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(24, 1, 3, 'Playable', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(25, 1, 3, 'Carousel', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(26, 1, 3, 'TopView', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(27, 1, 3, 'Dynamic Showcase', '2024-05-10 02:33:11', '2024-05-10 02:33:11', NULL),
(28, 1, 6, 'Image', '2024-05-10 02:33:36', '2024-05-10 02:33:36', NULL),
(29, 1, 7, 'Image', '2024-05-10 02:33:51', '2024-05-10 02:33:51', NULL),
(30, 2, 8, 'Newspaper', '2024-05-10 03:43:39', '2024-05-10 03:43:39', NULL),
(31, 2, 8, 'Magazine', '2024-05-10 03:43:39', '2024-05-10 03:43:39', NULL),
(32, 2, 8, 'Newsletter', '2024-05-10 03:43:39', '2024-05-10 03:43:39', NULL),
(33, 2, 8, 'Flyer', '2024-05-10 03:43:39', '2024-05-10 03:43:39', NULL),
(34, 2, 8, 'Catalogue', '2024-05-10 03:43:39', '2024-05-10 03:43:39', NULL),
(35, 3, 9, ':30s', '2024-05-10 03:44:39', '2024-05-10 03:44:39', NULL),
(36, 3, 9, ':15s', '2024-05-10 03:44:39', '2024-05-10 03:44:39', NULL),
(37, 3, 9, ':05s', '2024-05-10 03:44:39', '2024-05-10 03:44:39', NULL),
(38, 3, 9, 'Other', '2024-05-10 03:44:39', '2024-05-10 03:44:39', NULL),
(39, 4, 10, ':30s', '2024-05-10 03:45:45', '2024-05-10 03:45:45', NULL),
(40, 4, 10, ':15s', '2024-05-10 03:45:45', '2024-05-10 03:45:45', NULL),
(41, 4, 10, ':05s', '2024-05-10 03:45:45', '2024-05-10 03:45:45', NULL),
(42, 4, 10, 'Other', '2024-05-10 03:45:45', '2024-05-10 03:45:45', NULL),
(43, 5, 11, 'Posters', '2024-05-10 03:46:22', '2024-05-10 03:46:22', NULL),
(44, 5, 11, 'Large Format', '2024-05-10 03:46:22', '2024-05-10 03:46:22', NULL),
(45, 5, 11, 'Street Furniture', '2024-05-10 03:46:22', '2024-05-10 03:46:22', NULL),
(46, 5, 11, 'Transit', '2024-05-10 03:46:22', '2024-05-10 03:46:22', NULL),
(47, 5, 11, 'Place Based', '2024-05-10 03:46:22', '2024-05-10 03:46:22', NULL),
(48, 6, 12, 'Billboard', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(49, 6, 12, 'Smartphone Banner', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(50, 6, 12, 'Leaderboard', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(51, 6, 12, 'Pushdown', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(52, 6, 12, 'Portrait', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(53, 6, 12, 'Skyscraper', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(54, 6, 12, 'Medium Rectangle', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(55, 6, 12, '120x60', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(56, 6, 12, 'Mobile Interstitial', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(57, 6, 12, 'Feature Phone Small Banner', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(58, 6, 12, 'Feature Phone Med Banner', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(59, 6, 12, 'Feature Phone Lrg Banner', '2024-05-10 03:47:40', '2024-05-10 03:47:40', NULL),
(60, 7, 13, 'TBD', '2024-05-10 03:48:02', '2024-05-10 03:48:02', NULL),
(61, 8, 14, 'TBD', '2024-05-10 03:48:09', '2024-05-10 03:48:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `flight_connection_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `ad_title` varchar(255) DEFAULT NULL,
  `ad_type` bigint(20) DEFAULT NULL,
  `publisher_id` varchar(255) DEFAULT NULL,
  `advertisement_id` int(11) DEFAULT NULL,
  `ad_format` varchar(255) DEFAULT NULL,
  `ad_size` varchar(255) DEFAULT NULL,
  `colour` varchar(255) DEFAULT NULL,
  `resolution` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `technical` varchar(255) DEFAULT NULL,
  `social_spec_1` varchar(255) DEFAULT NULL,
  `social_spec_2` varchar(255) DEFAULT NULL,
  `social_spec_3` varchar(255) DEFAULT NULL,
  `conversion` varchar(255) DEFAULT NULL,
  `due_to_publisher` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assets_parameters`
--

CREATE TABLE `assets_parameters` (
  `id` int(11) NOT NULL,
  `flight_connection_id` int(11) DEFAULT NULL,
  `assets_id` bigint(20) DEFAULT NULL,
  `conversion_location` varchar(255) DEFAULT NULL,
  `cta` varchar(255) DEFAULT NULL,
  `clickthrougn_url` varchar(255) DEFAULT NULL,
  `utm` varchar(255) DEFAULT NULL,
  `primary_text` varchar(255) DEFAULT NULL,
  `link_primary_text` int(11) DEFAULT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `link_headline` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `link_description` int(11) DEFAULT NULL,
  `visuals` varchar(255) DEFAULT NULL,
  `status` enum('briefed','draft','progress','review','approved','trafficking','live') NOT NULL COMMENT '''briefed'',''draft'',''progress'',''review'',''approved'',''trafficking'',''live''',
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `asset_setup`
--

CREATE TABLE `asset_setup` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `flight_connection_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `ad_type` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `advertisement_id` int(11) DEFAULT NULL,
  `ad_format` varchar(255) DEFAULT NULL,
  `ad_size` varchar(255) DEFAULT NULL,
  `ad_bleed` varchar(255) DEFAULT NULL,
  `ad_colour` varchar(255) DEFAULT NULL,
  `ad_kbs` varchar(255) DEFAULT NULL,
  `ad_duration` varchar(255) DEFAULT NULL,
  `ad_filetype` varchar(255) DEFAULT NULL,
  `ad_version` varchar(255) DEFAULT NULL,
  `ad_publisher_specs` varchar(255) DEFAULT NULL,
  `due_to_publisher` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `asset_setup`
--

INSERT INTO `asset_setup` (`id`, `campaign_id`, `flight_id`, `flight_connection_id`, `category_id`, `ad_type`, `publisher_id`, `advertisement_id`, `ad_format`, `ad_size`, `ad_bleed`, `ad_colour`, `ad_kbs`, `ad_duration`, `ad_filetype`, `ad_version`, `ad_publisher_specs`, `due_to_publisher`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 9, 15, 28, 1, NULL, 1, 1, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, NULL, '2024-06-19 05:41:55', '2024-06-19 05:41:55', NULL),
(2, 9, 15, 28, 1, NULL, 1, 3, '9:16', NULL, NULL, NULL, NULL, '2', NULL, '1', NULL, NULL, '2024-06-19 05:41:55', '2024-06-19 05:41:55', NULL),
(3, 4, 19, 33, 1, NULL, 1, 1, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '2', NULL, '2024-06-20', '2024-06-19 05:44:38', '2024-06-20 08:05:18', NULL),
(4, 4, 19, 34, 2, NULL, 1, 30, '1', '1', '1', '1', NULL, NULL, '1', '2', '1', '2024-06-29', '2024-06-19 05:44:38', '2024-06-20 08:05:18', NULL),
(5, 4, 20, 35, 5, NULL, 12, 43, '2', '2', '2', '2', NULL, NULL, '2', '2', '2', '2024-06-21', '2024-06-19 05:44:38', '2024-06-20 08:05:18', NULL),
(6, 4, 20, 36, 6, NULL, 2, 49, NULL, '300x50', NULL, NULL, 'Initial 50', NULL, '1', '1', '1', '2024-06-20', '2024-06-19 05:44:38', '2024-06-20 08:05:18', NULL),
(7, 4, 19, 33, 1, NULL, 1, 2, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, '2024-06-21', '2024-06-19 05:50:09', '2024-06-20 08:05:18', NULL),
(8, 12, 23, 44, 1, NULL, 1, 1, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '2', NULL, NULL, '2024-06-19 07:55:29', '2024-06-19 07:55:29', NULL),
(9, 12, 23, 45, 2, NULL, 1, 30, '1', '1', '1', '1', NULL, NULL, '1', '1', '1', NULL, '2024-06-19 07:55:29', '2024-06-19 07:55:29', NULL),
(10, 12, 23, 46, 4, NULL, 1, 40, NULL, 'metric', NULL, NULL, NULL, NULL, '11', '1', NULL, NULL, '2024-06-19 07:55:29', '2024-06-19 07:55:29', NULL),
(11, 12, 23, 47, 5, NULL, 1, 43, '1', '1', '1', '1', NULL, NULL, '1', '1', '1', NULL, '2024-06-19 07:55:29', '2024-06-19 07:55:29', NULL),
(12, 4, 19, 33, 1, NULL, 1, 2, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, '2024-06-21', '2024-06-20 07:42:38', '2024-06-20 08:05:18', NULL),
(13, 7, 11, 20, 1, NULL, 1, 2, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '12', NULL, NULL, '2024-06-20 07:55:34', '2024-06-20 07:55:34', NULL),
(14, 7, 11, 21, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-20 07:55:34', '2024-06-20 07:55:34', NULL),
(15, 7, 12, 22, 3, NULL, 1, 38, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, '2024-06-20 07:55:34', '2024-06-20 07:55:34', NULL),
(16, 7, 11, 20, 1, NULL, 1, 2, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '12', NULL, NULL, '2024-06-20 07:55:49', '2024-06-20 07:55:49', NULL),
(17, 7, 11, 21, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-20 07:55:49', '2024-06-20 07:55:49', NULL),
(18, 7, 12, 22, 3, NULL, 1, 37, NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, NULL, '2024-06-20 07:55:49', '2024-06-20 07:55:49', NULL),
(19, 8, 13, 23, 1, NULL, 1, 1, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, NULL, '2024-06-20 08:00:02', '2024-06-20 08:00:02', NULL),
(20, 8, 13, 24, 2, NULL, 1, 30, '1', '1', '1', '1', NULL, NULL, '1', '1', '1', NULL, '2024-06-20 08:00:02', '2024-06-20 08:00:02', NULL),
(21, 8, 13, 25, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-20 08:00:02', '2024-06-20 08:00:02', NULL),
(22, 8, 14, 26, 5, NULL, 1, 43, '1', '1', '1', '1', NULL, NULL, '1', '1', '1', NULL, '2024-06-20 08:00:02', '2024-06-20 08:00:02', NULL),
(23, 8, 14, 27, 8, NULL, 1, 61, NULL, NULL, NULL, NULL, NULL, '1', '1', '1', '1', '2024-06-19', '2024-06-20 08:00:02', '2024-06-20 08:00:02', NULL),
(24, 4, 19, 33, 1, NULL, 1, 2, '1:1', NULL, NULL, NULL, NULL, '1', NULL, '1', NULL, '2024-06-21', '2024-06-20 08:01:41', '2024-06-20 08:05:18', NULL),
(25, 4, 20, 35, 5, NULL, 12, 44, '1', '1', '1', '1', NULL, NULL, '1', '1', '1', '2024-06-21', '2024-06-20 08:02:28', '2024-06-20 08:05:18', NULL),
(26, 4, 20, 35, 5, NULL, 1, 44, '1', '1', '1', '1', NULL, NULL, '1', '1', '1', '2024-06-20', '2024-06-20 08:04:10', '2024-06-20 08:05:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `id` int(11) NOT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `campaign_name` varchar(255) DEFAULT NULL,
  `project_code` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `export_name` varchar(255) DEFAULT NULL,
  `budget` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`id`, `client_id`, `campaign_name`, `project_code`, `image`, `export_name`, `budget`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'TEST', 'TEST1', NULL, '', 1200, '2024-06-10 06:35:28', '2024-06-10 06:35:28', NULL),
(2, '1', 'ggggg', 'ggg', NULL, '', 2134, '2024-06-10 06:37:42', '2024-06-10 06:37:42', NULL),
(3, '1', 'ddd', '2323', NULL, '', 234323, '2024-06-10 06:39:49', '2024-06-10 06:39:49', NULL),
(4, '1', 'test 1', 'test1', NULL, '', 100000, '2024-06-10 06:49:20', '2024-06-10 06:49:20', NULL),
(5, '1', 'Tyson - June 11 Test1', NULL, NULL, '', NULL, '2024-06-11 12:21:53', '2024-06-11 12:21:53', NULL),
(6, '1', 'Tyson - June 12 Test1', 'ABC-0001', NULL, '', 10000, '2024-06-12 06:29:14', '2024-06-12 06:29:14', NULL),
(7, '1', 'Tyson - June 15 Test1', NULL, NULL, '', NULL, '2024-06-15 15:14:06', '2024-06-15 15:14:06', NULL),
(8, '1', 'Test 5-17', NULL, NULL, '', NULL, '2024-06-17 06:27:54', '2024-06-17 06:27:54', NULL),
(9, '1', 'Tyson - June 17 Test1', 'ABC-0001', NULL, '', 10000, '2024-06-17 11:29:45', '2024-06-17 11:29:45', NULL),
(10, '1', 'Tyson - June 17 Test2', NULL, NULL, '', NULL, '2024-06-17 12:15:48', '2024-06-17 12:15:48', NULL),
(11, '1', 'FATHER\'S DAY', 'FATHER-1024', NULL, '', 100000, '2024-06-19 07:50:51', '2024-06-19 07:50:51', NULL),
(12, '2', 'FATHER\'S DAY', 'FATHER-1024', NULL, '', 100000, '2024-06-19 07:52:02', '2024-06-19 07:52:02', NULL),
(13, '2', 'SSS', 'SSS123', NULL, '', 10000, '2024-06-20 06:47:29', '2024-06-20 06:47:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_languages`
--

CREATE TABLE `campaign_languages` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `language` enum('EN','FR') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign_languages`
--

INSERT INTO `campaign_languages` (`id`, `campaign_id`, `language`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'EN', '2024-06-10 06:35:28', '2024-06-10 06:35:28', NULL),
(2, 2, 'EN', '2024-06-10 06:37:42', '2024-06-10 06:37:42', NULL),
(3, 2, 'FR', '2024-06-10 06:37:42', '2024-06-10 06:37:42', NULL),
(4, 3, 'EN', '2024-06-10 06:39:49', '2024-06-10 06:39:49', NULL),
(5, 3, 'FR', '2024-06-10 06:39:49', '2024-06-10 06:39:49', NULL),
(6, 4, 'EN', '2024-06-10 06:49:20', '2024-06-10 06:49:20', NULL),
(7, 5, 'EN', '2024-06-11 12:21:53', '2024-06-11 12:21:53', NULL),
(8, 6, 'EN', '2024-06-12 06:29:14', '2024-06-12 06:29:14', NULL),
(9, 7, 'EN', '2024-06-15 15:14:06', '2024-06-15 15:14:06', NULL),
(10, 8, 'FR', '2024-06-17 06:27:54', '2024-06-17 06:27:54', NULL),
(11, 9, 'EN', '2024-06-17 11:29:45', '2024-06-17 11:29:45', NULL),
(12, 10, 'EN', '2024-06-17 12:15:48', '2024-06-17 12:15:48', NULL),
(13, 11, 'EN', '2024-06-19 07:50:51', '2024-06-19 07:50:51', NULL),
(14, 12, 'EN', '2024-06-19 07:52:02', '2024-06-19 07:52:02', NULL),
(15, 13, 'EN', '2024-06-20 06:47:29', '2024-06-20 06:47:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_member`
--

CREATE TABLE `campaign_member` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `campaign_member`
--

INSERT INTO `campaign_member` (`id`, `campaign_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '1', '2024-06-10 06:35:28', '2024-06-10 06:35:28', NULL),
(2, 1, '2', '2024-06-10 06:35:28', '2024-06-10 06:35:28', NULL),
(3, 2, '1', '2024-06-10 06:37:42', '2024-06-10 06:37:42', NULL),
(4, 2, '2', '2024-06-10 06:37:42', '2024-06-10 06:37:42', NULL),
(5, 3, '1', '2024-06-10 06:39:49', '2024-06-10 06:39:49', NULL),
(6, 3, '3', '2024-06-10 06:39:49', '2024-06-10 06:39:49', NULL),
(7, 4, '2', '2024-06-10 06:49:20', '2024-06-10 06:49:20', NULL),
(8, 5, '1', '2024-06-11 12:21:53', '2024-06-11 12:21:53', NULL),
(9, 6, '3', '2024-06-12 06:29:14', '2024-06-12 06:29:14', NULL),
(10, 7, '1', '2024-06-15 15:14:06', '2024-06-15 15:14:06', NULL),
(11, 8, '1', '2024-06-17 06:27:54', '2024-06-17 06:27:54', NULL),
(12, 9, '1', '2024-06-17 11:29:45', '2024-06-17 11:29:45', NULL),
(13, 10, '1', '2024-06-17 12:15:48', '2024-06-17 12:15:48', NULL),
(14, 11, '2', '2024-06-19 07:50:51', '2024-06-19 07:50:51', NULL),
(15, 12, '2', '2024-06-19 07:52:02', '2024-06-19 07:52:02', NULL),
(16, 13, '1', '2024-06-20 06:47:29', '2024-06-20 06:47:29', NULL),
(17, 13, '2', '2024-06-20 06:47:29', '2024-06-20 06:47:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_master`
--

CREATE TABLE `category_master` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_master`
--

INSERT INTO `category_master` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Social', '2024-05-10 01:37:17', '2024-05-10 01:37:17', NULL),
(2, 'Print', '2024-05-10 02:47:51', '2024-05-10 02:47:51', NULL),
(3, 'Radio', '2024-05-10 02:48:12', '2024-05-10 02:48:12', NULL),
(4, 'Television', '2024-05-10 02:48:19', '2024-05-10 02:48:19', NULL),
(5, 'Outdoor', '2024-05-10 02:48:27', '2024-05-10 02:48:27', NULL),
(6, 'Display', '2024-05-10 02:48:35', '2024-05-10 02:48:35', NULL),
(7, 'Podcast', '2024-05-10 02:48:43', '2024-05-10 02:48:43', NULL),
(8, 'Influencer', '2024-05-10 02:48:52', '2024-05-10 02:48:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `number`, `email`, `url`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Horizon', '9714012746', 'horizon@gmail.com', 'horizon.com', '2024-04-09 07:11:16', '2024-04-09 07:11:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_address`
--

CREATE TABLE `company_address` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_address`
--

INSERT INTO `company_address` (`id`, `company_id`, `address1`, `address2`, `country`, `state`, `postal_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Gandhinagar', NULL, 'India', 'Gujarat', '382418', '2024-04-09 07:11:16', '2024-04-09 07:11:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `flight_count` int(11) DEFAULT NULL,
  `in_market_start_date` date DEFAULT NULL,
  `in_market_end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`id`, `campaign_id`, `flight_count`, `in_market_start_date`, `in_market_end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 17, 1, '2024-06-01', '2024-06-10', '2024-06-10 06:35:14', '2024-06-10 06:35:14', NULL),
(2, 1, 1, '2024-06-05', '2024-06-23', '2024-06-10 06:35:49', '2024-06-10 06:36:34', '2024-06-10 06:36:34'),
(3, 1, 1, '2024-06-07', '2024-06-22', '2024-06-10 06:36:42', '2024-06-10 06:36:42', NULL),
(4, 2, 1, '2024-06-01', '2024-06-11', '2024-06-10 06:38:04', '2024-06-10 06:38:04', NULL),
(5, 3, 1, '2024-06-01', '2024-06-20', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(6, 3, 2, '2024-06-01', '2024-06-19', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(7, 4, 1, '2024-06-01', '2024-06-11', '2024-06-10 06:49:46', '2024-06-10 06:51:14', '2024-06-10 06:51:14'),
(8, 5, 1, '2024-06-06', '2024-06-29', '2024-06-11 12:22:16', '2024-06-11 12:22:16', NULL),
(9, 6, 1, '2024-06-01', '2024-06-30', '2024-06-12 06:29:51', '2024-06-12 06:30:32', NULL),
(10, 6, 1, '2024-06-01', '2024-06-30', '2024-06-12 06:30:12', '2024-06-12 06:30:28', '2024-06-12 06:30:28'),
(11, 7, 1, '2024-06-15', '2024-06-30', '2024-06-15 15:14:25', '2024-06-15 15:15:21', NULL),
(12, 7, 2, '2024-06-15', '2024-06-30', '2024-06-15 15:15:21', '2024-06-15 15:15:21', NULL),
(13, 8, 1, '2024-06-17', '2024-06-18', '2024-06-17 06:30:07', '2024-06-17 06:30:07', NULL),
(14, 8, 2, '2024-06-18', '2024-06-19', '2024-06-17 06:30:07', '2024-06-17 06:30:07', NULL),
(15, 9, 1, '2024-06-01', '2024-06-30', '2024-06-17 11:30:55', '2024-06-17 11:30:55', NULL),
(16, 10, 1, '2024-06-17', '2024-06-30', '2024-06-17 12:16:33', '2024-06-17 12:16:33', NULL),
(19, 4, 1, '2024-06-19', '2024-06-29', '2024-06-19 05:43:13', '2024-06-19 07:23:09', NULL),
(20, 4, 2, '2024-06-20', '2024-06-30', '2024-06-19 05:43:13', '2024-06-19 07:23:09', NULL),
(21, 11, 1, '2024-06-20', '2024-06-21', '2024-06-19 07:51:26', '2024-06-19 07:51:26', NULL),
(22, 11, 1, '2024-06-20', '2024-06-21', '2024-06-19 07:51:48', '2024-06-19 07:51:48', NULL),
(23, 12, 1, '2024-06-20', '2024-06-21', '2024-06-19 07:52:24', '2024-06-19 07:52:24', NULL),
(24, 13, 1, '2024-06-18', '2024-06-12', '2024-06-20 06:47:43', '2024-06-20 06:47:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flight_connection`
--

CREATE TABLE `flight_connection` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `language` enum('EN','FR') DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category_id` bigint(11) DEFAULT NULL,
  `ad_type` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `flight_connection`
--

INSERT INTO `flight_connection` (`id`, `campaign_id`, `flight_id`, `language`, `type`, `location`, `category_id`, `ad_type`, `tag`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 17, 1, 'EN', 'Awareness', 'rrrr', 1, NULL, 'F1', '2024-06-10 06:35:14', '2024-06-10 06:35:14', NULL),
(2, 17, 1, 'EN', 'Awareness', 'rrrr', 2, NULL, 'F1', '2024-06-10 06:35:14', '2024-06-10 06:35:14', NULL),
(3, 1, 2, 'EN', 'Awareness', 'test1', 2, NULL, 'F1', '2024-06-10 06:35:49', '2024-06-10 06:36:34', '2024-06-10 06:36:34'),
(4, 1, 2, 'EN', 'Awareness', 'test1', 3, NULL, 'F1', '2024-06-10 06:35:49', '2024-06-10 06:36:34', '2024-06-10 06:36:34'),
(5, 1, 3, 'EN', 'Awareness', 'test1', 1, NULL, 'F1', '2024-06-10 06:36:42', '2024-06-10 06:36:42', NULL),
(6, 2, 4, 'EN', 'Awareness', 'ffff', 1, NULL, 'F1', '2024-06-10 06:38:04', '2024-06-10 06:38:04', NULL),
(7, 2, 4, 'EN', 'Awareness', 'ffff', 2, NULL, 'F1', '2024-06-10 06:38:04', '2024-06-10 06:38:04', NULL),
(8, 3, 5, 'EN', 'Awareness', 'sdsd', 1, NULL, 'F1', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(9, 3, 5, 'EN', 'Awareness', 'sdsd', 2, NULL, 'F1', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(10, 3, 5, 'EN', 'Awareness', 'ggg', 2, NULL, 'F2', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(11, 3, 5, 'EN', 'Awareness', 'ggg', 3, NULL, 'F2', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(12, 3, 6, 'EN', 'Awareness', 'rrrr', 4, NULL, 'F3', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(13, 3, 6, 'EN', 'Awareness', 'rrrr', 5, NULL, 'F3', '2024-06-10 06:40:54', '2024-06-10 06:40:54', NULL),
(14, 4, 7, 'EN', 'Awareness', 'nova', 1, NULL, 'F1', '2024-06-10 06:49:46', '2024-06-10 06:51:14', '2024-06-10 06:51:14'),
(15, 5, 8, 'EN', 'Awareness', 'NS', 1, NULL, 'F1', '2024-06-11 12:22:16', '2024-06-11 12:22:16', NULL),
(16, 6, 9, 'EN', 'Awareness', 'NS', 1, NULL, 'F1', '2024-06-12 06:29:51', '2024-06-12 06:30:32', NULL),
(17, 6, 9, 'EN', 'Awareness', 'NB', 1, NULL, 'F2', '2024-06-12 06:29:51', '2024-06-12 06:30:32', NULL),
(18, 6, 10, 'EN', 'Awareness', 'NS', 1, NULL, 'F1', '2024-06-12 06:30:12', '2024-06-12 06:30:28', '2024-06-12 06:30:28'),
(19, 6, 10, 'EN', 'Awareness', 'NB', 1, NULL, 'F2', '2024-06-12 06:30:12', '2024-06-12 06:30:28', '2024-06-12 06:30:28'),
(20, 7, 11, 'EN', 'Awareness', 'NS', 1, NULL, 'F1', '2024-06-15 15:14:25', '2024-06-15 15:15:21', NULL),
(21, 7, 11, 'EN', 'Awareness', 'NB', 2, NULL, NULL, '2024-06-15 15:15:21', '2024-06-15 15:15:21', NULL),
(22, 7, 12, 'EN', 'Consideration', 'Test', 3, NULL, NULL, '2024-06-15 15:15:21', '2024-06-15 15:15:21', NULL),
(23, 8, 13, 'EN', 'Awareness', 'NS', 1, NULL, 'F1', '2024-06-17 06:30:07', '2024-06-17 06:30:07', NULL),
(24, 8, 13, 'EN', 'Awareness', 'NS', 2, NULL, 'F1', '2024-06-17 06:30:07', '2024-06-17 06:30:07', NULL),
(25, 8, 13, 'EN', 'Awareness', 'NB', 6, NULL, 'F2', '2024-06-17 06:30:07', '2024-06-17 06:30:07', NULL),
(26, 8, 14, 'FR', 'Consideration', 'NS', 5, NULL, 'F3', '2024-06-17 06:30:07', '2024-06-17 06:30:07', NULL),
(27, 8, 14, 'FR', 'Consideration', 'NS', 8, NULL, 'F3', '2024-06-17 06:30:07', '2024-06-17 06:30:07', NULL),
(28, 9, 15, 'EN', 'Awareness', 'NS', 1, NULL, 'F1', '2024-06-17 11:30:55', '2024-06-17 11:30:55', NULL),
(29, 10, 16, 'EN', 'Awareness', 'NS', 1, NULL, 'F1', '2024-06-17 12:16:33', '2024-06-17 12:16:33', NULL),
(30, 10, 16, 'EN', 'Awareness', 'NB', 2, NULL, 'F2', '2024-06-17 12:16:33', '2024-06-17 12:16:33', NULL),
(31, 4, 17, 'EN', 'Awareness', 'Flight 1.1', 1, NULL, 'F1', '2024-06-19 05:42:53', '2024-06-19 05:42:53', NULL),
(32, 4, 17, 'EN', 'Awareness', 'Flight 1.1', 2, NULL, 'F1', '2024-06-19 05:42:53', '2024-06-19 05:42:53', NULL),
(33, 4, 19, 'EN', 'Awareness', 'Flight 1.1', 1, NULL, 'F1', '2024-06-19 05:43:13', '2024-06-19 07:23:09', NULL),
(34, 4, 19, 'EN', 'Awareness', 'Flight 1.1', 2, NULL, 'F1', '2024-06-19 05:43:13', '2024-06-19 07:23:09', NULL),
(35, 4, 20, 'EN', 'Awareness', 'Flight 2.1', 5, NULL, 'F2', '2024-06-19 05:43:13', '2024-06-19 07:23:09', NULL),
(36, 4, 20, 'EN', 'Awareness', 'Flight 2.1', 6, NULL, 'F2', '2024-06-19 05:43:13', '2024-06-19 07:23:09', NULL),
(37, 4, 20, 'EN', 'Awareness', 'FL', 2, NULL, NULL, '2024-06-19 07:23:09', '2024-06-19 07:23:09', NULL),
(38, 11, 21, 'EN', 'Awareness', 'Flight 1.1', 2, NULL, 'F1', '2024-06-19 07:51:26', '2024-06-19 07:51:26', NULL),
(39, 11, 21, 'EN', 'Awareness', 'Flight 1.1', 3, NULL, 'F1', '2024-06-19 07:51:26', '2024-06-19 07:51:26', NULL),
(40, 11, 22, 'EN', 'Awareness', 'Flight 1.1', 2, NULL, 'F1', '2024-06-19 07:51:48', '2024-06-19 07:51:48', NULL),
(41, 11, 22, 'EN', 'Awareness', 'Flight 1.1', 3, NULL, 'F1', '2024-06-19 07:51:48', '2024-06-19 07:51:48', NULL),
(42, 11, 22, 'EN', 'Awareness', 'Flight 1.2', 4, NULL, 'F2', '2024-06-19 07:51:48', '2024-06-19 07:51:48', NULL),
(43, 11, 22, 'EN', 'Awareness', 'Flight 1.2', 5, NULL, 'F2', '2024-06-19 07:51:48', '2024-06-19 07:51:48', NULL),
(44, 12, 23, 'EN', 'Awareness', 'Flight 1.1', 1, NULL, 'F1', '2024-06-19 07:52:24', '2024-06-19 07:52:24', NULL),
(45, 12, 23, 'EN', 'Awareness', 'Flight 1.1', 2, NULL, 'F1', '2024-06-19 07:52:24', '2024-06-19 07:52:24', NULL),
(46, 12, 23, 'EN', 'Consideration', '1', 4, NULL, 'F2', '2024-06-19 07:52:24', '2024-06-19 07:52:24', NULL),
(47, 12, 23, 'EN', 'Consideration', '1', 5, NULL, 'F2', '2024-06-19 07:52:24', '2024-06-19 07:52:24', NULL),
(48, 13, 24, 'EN', 'Awareness', 'TEST1', 1, NULL, 'F1', '2024-06-20 06:47:43', '2024-06-20 06:47:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publisher_master`
--

CREATE TABLE `publisher_master` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `publisher_master`
--

INSERT INTO `publisher_master` (`id`, `category_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Meta', '2024-05-10 01:37:42', '2024-05-10 01:37:42', NULL),
(2, 1, 'Pinterest', '2024-05-10 01:38:41', '2024-05-10 01:38:41', NULL),
(3, 1, 'TikTok', '2024-05-10 01:43:55', '2024-05-10 01:43:55', NULL),
(4, 1, 'SnapChat', '2024-05-10 01:44:07', '2024-05-10 01:44:07', NULL),
(5, 1, 'X/Twitter', '2024-05-10 01:44:16', '2024-05-10 01:44:16', NULL),
(6, 1, 'Podcast', '2024-05-10 01:44:24', '2024-05-10 01:44:24', NULL),
(7, 1, 'Influencer', '2024-05-10 01:44:33', '2024-05-10 01:44:33', NULL),
(8, 2, 'NA', '2024-05-10 03:17:13', '2024-05-10 03:17:13', NULL),
(9, 3, 'NA', '2024-05-10 03:34:31', '2024-05-10 03:34:31', NULL),
(10, 4, 'NA', '2024-05-10 03:34:53', '2024-05-10 03:34:53', NULL),
(11, 5, 'NA', '2024-05-10 03:35:07', '2024-05-10 03:35:07', NULL),
(12, 6, 'NA', '2024-05-10 03:35:12', '2024-05-10 03:35:12', NULL),
(13, 7, 'NA', '2024-05-10 03:35:18', '2024-05-10 03:35:18', NULL),
(14, 8, 'NA', '2024-05-10 03:35:27', '2024-05-10 03:35:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `team_type` enum('Client','Creative','Media') NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `team_type`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Client', 'Client Team 1', '2024-04-24 07:50:56', '2024-04-24 07:50:56', NULL),
(2, 'Client', 'Client Team 2', '2024-04-24 07:51:00', '2024-04-24 07:51:00', NULL),
(3, 'Creative', 'Creative Team 1', '2024-04-24 07:51:07', '2024-04-24 07:51:07', NULL),
(4, 'Creative', 'Creative Team 3', '2024-04-24 07:51:11', '2024-04-24 07:51:11', NULL),
(5, 'Creative', 'Creative Team 2', '2024-04-24 07:51:20', '2024-04-24 07:51:20', NULL),
(6, 'Media', 'd', '2024-05-01 00:41:29', '2024-05-01 00:41:29', NULL),
(7, 'Creative', 'asf', '2024-05-01 00:42:17', '2024-05-01 00:42:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_member`
--

CREATE TABLE `team_member` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `type` enum('Creative','Client','User','Coworker') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `team_member`
--

INSERT INTO `team_member` (`id`, `user_id`, `team_id`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 9, 1, 'Client', '2024-04-24 08:02:30', '2024-04-24 08:02:30', NULL),
(2, 10, 5, 'Creative', '2024-04-24 08:02:40', '2024-04-24 08:02:40', NULL),
(3, 11, 3, 'Coworker', '2024-04-25 00:24:49', '2024-04-25 00:24:49', NULL),
(4, 12, 3, 'Coworker', '2024-04-25 00:31:29', '2024-04-25 00:31:29', NULL),
(5, 13, 1, 'Creative', '2024-04-25 00:32:00', '2024-04-25 00:32:00', NULL),
(6, 14, 5, 'Client', '2024-05-13 05:25:04', '2024-05-13 05:25:04', NULL),
(7, 15, 4, 'Client', '2024-05-13 05:25:56', '2024-05-13 05:25:56', NULL),
(8, 16, NULL, NULL, '2024-06-03 11:39:20', '2024-06-03 11:39:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Thumbnails`
--

CREATE TABLE `Thumbnails` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `language` enum('EN','FR') NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Thumbnails`
--

INSERT INTO `Thumbnails` (`id`, `campaign_id`, `language`, `type`, `thumbnail`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'EN', 'Awareness', 'card2.png', '2024-06-03 05:47:12', '2024-06-03 05:47:12', NULL),
(2, 15, 'EN', 'Awareness', '03af2ef50d0cbf54a43bbd4447601fb2.jpg', '2024-06-07 07:25:12', '2024-06-07 07:25:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('Admin','User','Media','Creative','Client') NOT NULL COMMENT '''Admin'',''User'',''Media'',''Creative'',''Client''',
  `team_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` enum('Creative','Client','User','Coworker') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `team_id`, `name`, `email`, `number`, `password`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 1, 'John', 'example@gmail.com', '989897218', '$2y$12$BW2hl9UNOXNf51zXp9FPweAZNHDeoph2RlE39TUPsXMpdGpfA87H2', 'Client', '2024-04-08 21:11:44', '2024-04-08 21:11:44', NULL),
(2, 'Admin', 1, 'Karan', 'karna@gmail.com', '8866868822', '$2y$12$4N7ViK06TyPj0Mjowee3QOLLp3sw4x01/T.w5zFpVwDh64KNlxEr2', 'Client', '2024-04-09 01:19:50', '2024-04-09 01:19:50', NULL),
(3, 'Admin', 3, 'Shiv', 'Shiv@gmail.com', '9714012746', '$2y$12$b2byJ5hRm/Xy9nd.z8XyBugeF8VlLwB7ig0CIKRlBI94.H6S6ZCsK', 'User', '2024-04-09 08:39:42', '2024-04-09 08:39:42', NULL),
(6, 'Admin', 2, 'SHIVPATEL', 'SHIVPATEL@gmail.com', NULL, '$2y$12$QmVyEIg0XwfOkCA1WEgqFu25dhYUHrrhWgIHuJWekouSlLSdC4zem', 'Client', '2024-04-24 07:46:41', '2024-04-24 07:46:41', NULL),
(7, 'Admin', 3, 'SHIV', 'horizon@gmail.com', NULL, '$2y$10$0KGrboi6VhcxJxqUpuo8xe9G8fBX5gCYyy3uAhxmrYTjrppeHhtfS', 'Creative', '2024-04-24 07:46:50', '2024-04-24 07:46:50', NULL),
(8, 'Admin', 2, 'SHAMSHAD', 'SHAMSHAD@gmail.com', NULL, '$2y$12$FhFUXp0BxCxaHY4aTweQ5eijHo8PBaaas4BatmHpKH3fkOvKyuNQ2', 'User', '2024-04-24 07:49:13', '2024-04-24 07:49:13', NULL),
(9, 'Admin', 1, 'SHIVPATEL', 'SHIVPATEL@gmail.com', NULL, '$2y$12$6KIq5/JiqAvsPzp1pYtLq.n8avp1auC/MIH0WN4QyOwsAY/TwdVhG', 'Client', '2024-04-24 08:02:30', '2024-04-24 08:02:30', NULL),
(10, 'Admin', 4, 'SHAMSHAD', 'SHAMSHAD@gmail.com', NULL, '$2y$12$dO1tTBqm6zgbYFNRNMz0aOfuYIu0XLdpu9U9q1LO12sP9euCmmIWW', 'Creative', '2024-04-24 08:02:40', '2024-04-24 08:02:40', NULL),
(11, 'Admin', 4, 'HORIZON', '14HORIZON@gmail.com', NULL, '$2y$12$RQes45udvoPoTo9yNfOXRe3D8E3ebf/IjEpCpDeFbuEOMCWXIrV9W', 'User', '2024-04-25 00:24:49', '2024-04-25 00:24:49', NULL),
(12, 'Admin', 4, 'XYZ', 'XYZ@gmail.com', NULL, '$2y$12$U.t1PuRZvKVitLIOEoJj0e0DAwnRJ9JNF8HehLXKFAhGehpYgHQGu', 'User', '2024-04-25 00:31:29', '2024-04-25 00:31:29', NULL),
(13, 'Admin', 4, 'DHRUVIL', 'DHRUVIL@gmail.com', NULL, '$2y$12$1A.jQwxajx67Jvi0/Ml4Jut3si/PRpTSTn1gXTITdOSZmjbNuPYsy', 'User', '2024-04-25 00:32:00', '2024-04-25 00:32:00', NULL),
(14, 'Admin', 4, 'SVHI', 'shivpatel3035@gmail.com', NULL, '$2y$12$rUM4nRbahZMjJNlYqcWxcOvf5blQMHW7.JYlrCs7dd8.9YlBzmeNK', 'Client', '2024-05-13 05:25:04', '2024-05-13 05:25:04', NULL),
(15, 'Admin', 4, 'SHIV', 'shivpatel3035@gmail.com', NULL, '$2y$12$7R0Zc.yw5GQgI9/o.oYj..YVneAYZD8tfP2ap4Y8VYtHqURT9f6VK', 'Client', '2024-05-13 05:25:56', '2024-05-13 05:25:56', NULL),
(16, 'Admin', NULL, NULL, NULL, NULL, '$2y$12$crQtWYq6VXKXx8bEy/oWM.RQM7294bZnEeo32s.OE26pyRl.gfDne', NULL, '2024-06-03 11:39:20', '2024-06-03 11:39:20', NULL),
(17, 'Media', NULL, 'TEST', 'patel@gmail.com', NULL, '$2y$12$89GMfy1OMtWyhHN.4C8UtuOjH6rh3OCuw.r.z3jMh/yh0r6bdhZOW', NULL, '2024-06-19 05:40:40', '2024-06-19 05:40:40', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisement_type`
--
ALTER TABLE `advertisement_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_parameters`
--
ALTER TABLE `assets_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_setup`
--
ALTER TABLE `asset_setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_languages`
--
ALTER TABLE `campaign_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_member`
--
ALTER TABLE `campaign_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_master`
--
ALTER TABLE `category_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_address`
--
ALTER TABLE `company_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight_connection`
--
ALTER TABLE `flight_connection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publisher_master`
--
ALTER TABLE `publisher_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_member`
--
ALTER TABLE `team_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Thumbnails`
--
ALTER TABLE `Thumbnails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisement_type`
--
ALTER TABLE `advertisement_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_parameters`
--
ALTER TABLE `assets_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_setup`
--
ALTER TABLE `asset_setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `campaign_languages`
--
ALTER TABLE `campaign_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `campaign_member`
--
ALTER TABLE `campaign_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `category_master`
--
ALTER TABLE `category_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_address`
--
ALTER TABLE `company_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `flight_connection`
--
ALTER TABLE `flight_connection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `publisher_master`
--
ALTER TABLE `publisher_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `team_member`
--
ALTER TABLE `team_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Thumbnails`
--
ALTER TABLE `Thumbnails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
