-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2026 at 10:47 PM
-- Server version: 10.6.18-MariaDB-cll-lve-log
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tasisat2_tasisataxial`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `cat_id`, `title`, `slug`, `pic`, `content`, `publish`, `created_at`, `updated_at`) VALUES
(1, 3, 'ایمنی مهندسین111', 'ایمنی-مهندسین111', '1012.jpg', '<p>ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین&nbsp;</p><figure class=\"image image_resized\" style=\"width:54.06%;\"><img src=\"http://127.0.0.1:3000/storage/articles/470licensed-image.jpg\" srcset=\"http://127.0.0.1:3000/storage/articles/470licensed-image.jpg 500w\" sizes=\"100vw\" width=\"500\"></figure>', 1, '2025-07-20 14:36:41', '2025-08-09 18:27:05'),
(2, 4, 'مقاله ایمنی جالب', 'مقاله-ایمنی-جالب', '327pxfuel(53).jpg', '<p>تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین&nbsp;</p><figure class=\"image image-style-side\"><img src=\"http://127.0.0.1:3000/storage/articles/606pxfuel(37).jpg\" srcset=\"http://127.0.0.1:3000/storage/articles/606pxfuel(37).jpg 500w\" sizes=\"100vw\" width=\"500\"></figure>', 1, '2025-07-23 14:53:14', '2025-08-09 18:33:58'),
(3, 4, 'ایمنی مهندسین آرمان', 'ایمنی-مهندسین-آرمان', '1012.jpg', '<p>ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین ایمنی مهندسین&nbsp;</p><figure class=\"image image_resized\" style=\"width:54.06%;\"><img src=\"http://127.0.0.1:3000/storage/articles/470licensed-image.jpg\" srcset=\"http://127.0.0.1:3000/storage/articles/470licensed-image.jpg 500w\" sizes=\"100vw\" width=\"500\"></figure>', 1, '2025-07-20 14:36:41', '2025-08-09 18:27:50'),
(4, 3, 'مقاله ایمنی', 'مقاله-ایمنی', '327pxfuel(53).jpg', '<p>تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین تست ایمنی مهندسین&nbsp;</p><figure class=\"image image-style-side\"><img src=\"http://127.0.0.1:3000/storage/articles/606pxfuel(37).jpg\" srcset=\"http://127.0.0.1:3000/storage/articles/606pxfuel(37).jpg 500w\" sizes=\"100vw\" width=\"500\"></figure>', 1, '2025-07-23 14:53:14', '2025-07-23 14:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `article_tag`
--

CREATE TABLE `article_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `maincat_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `pic`, `description`, `parent_id`, `maincat_id`, `created_at`, `updated_at`) VALUES
(1, 'دسته محصول 1', NULL, 'دسته محصول 1 دسته محصول 1 دسته محصول 1 دسته محصول 1 دسته محصول 1 دسته محصول 1 دسته محصول 1 دسته محصول 1 دسته محصول 1 دسته محصول 1', 0, 2, '2025-07-20 14:27:44', '2025-07-20 14:27:44'),
(2, 'مصالح', '5112.jpg', 'مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح مصالح', 1, 2, '2025-07-20 14:28:52', '2025-07-20 14:28:52'),
(3, 'مقالات', NULL, NULL, 0, 1, '2025-07-20 14:30:14', '2025-07-20 14:30:14'),
(4, 'ایمنی مهندسین', NULL, NULL, 0, 1, '2025-07-23 14:51:47', '2025-07-23 14:51:47'),
(5, 'دسته پروژه 1', NULL, 'دسته پروژه 1دسته پروژه 1دسته پروژه 1دسته پروژه 1دسته پروژه 1دسته پروژه 1دسته پروژه 1', 0, 3, '2025-08-09 18:09:45', '2025-08-09 18:09:45'),
(6, 'دسته پروژه 2', NULL, NULL, 0, 3, '2025-08-10 11:40:44', '2025-08-10 11:40:44'),
(7, 'دسته تاسیسات', NULL, 'دسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیساتدسته تاسیسات', 0, 1, '2025-09-01 04:09:31', '2025-09-01 04:09:31'),
(8, 'دسته محصول', NULL, 'دسته محصولدسته محصولدسته محصولدسته محصولدسته محصولدسته محصولدسته محصولدسته محصولدسته محصولدسته محصولدسته محصولدسته محصول', 0, 2, '2025-09-01 04:11:05', '2025-09-01 04:11:05'),
(9, 'فوندانسیون', NULL, NULL, 8, 2, '2025-09-01 04:13:12', '2025-09-01 04:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_11_12_145401_create_views_table', 1),
(6, '2022_12_12_202127_create_articles_table', 1),
(7, '2022_12_15_135532_create_tags_table', 1),
(8, '2022_12_18_195733_create_article_tag_table', 1),
(9, '2023_04_14_153338_create_categories_table', 1),
(10, '2024_08_08_153639_create_products_table', 1),
(11, '2024_08_26_204723_create_product_tag_table', 1),
(12, '2024_11_17_204320_create_orders_table', 1),
(13, '2024_11_17_204342_create_order_details_table', 1),
(14, '2025_07_29_123045_create_pages_table', 2),
(15, '2025_08_07_101315_create_pages_table', 3),
(16, '2025_08_09_183333_create_projects_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `referenceId` varchar(1000) NOT NULL,
  `status` varchar(255) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `count`, `price`, `user_id`, `description`, `referenceId`, `status`, `done`, `created_at`, `updated_at`) VALUES
(33, 1, 340000, 1, NULL, '1642401', 'OK', 0, '2025-07-25 08:29:51', '2025-07-25 08:29:51'),
(34, 1, 14000000, 1, NULL, '1642901', 'OK', 0, '2025-07-25 08:35:36', '2025-07-25 08:35:36'),
(35, 1, 340000, 1, NULL, '1643201', 'OK', 0, '2025-07-25 08:37:17', '2025-07-25 08:37:17'),
(36, 1, 14000000, 2, NULL, '1676001', 'OK', 0, '2025-07-25 14:41:05', '2025-07-25 14:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(33, 36, 1, 1, 14000000, '2025-07-25 14:41:05', '2025-07-25 14:41:05'),
(32, 35, 2, 2, 340000, '2025-07-25 08:37:17', '2025-07-25 08:37:17'),
(31, 34, 1, 1, 14000000, '2025-07-25 08:35:36', '2025-07-25 08:35:36'),
(30, 33, 2, 2, 340000, '2025-07-25 08:29:51', '2025-07-25 08:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` int(11) NOT NULL,
  `sect_id` int(11) NOT NULL,
  `sect_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_id`, `sect_id`, `sect_name`, `title`, `pic`, `desc`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'slider', NULL, '[\"11020250621_173105 (1).jpg\",\"675photo_2025-08-11_16-45-58.jpg\",\"910photo_2025-08-11_16-46-02.jpg\",\"72020250621_173105 (1).jpg\"]', NULL, NULL, '2025-08-30 12:09:44'),
(16, 1, 3, 'نمایندگی فروش', 'تهویه مطبوع میتسوبیشی ژاپن', '184unnamed.jpg', NULL, '2025-08-10 10:15:10', '2025-08-12 07:13:13'),
(17, 1, 2, 'ارائه خدمات مهندسی', 'مهندسین مشاور آکسیال', NULL, 'از شناسایی دقیق نیازهای پروژه تا انتخاب سیستم های بهینه ، تهیه نقشه های اجرایی دقیق ، برآورد شفاف و مرحله به مرحله متریال و همچنین نظارت کامل بر اجرای کار ، در تمام مسیر کنار شما هستیم تا بهترین تعادل بین کیفیت ، هزینه و زمان حاصل شود .', '2025-08-10 10:59:58', '2025-08-12 06:23:56'),
(33, 2, 0, 'خدمات', 'اجرای خدمات طراحی', '946pexels-photo-269077.jpeg', 'اجرای انجام خدمات طراحی ساختمان', '2025-08-30 10:58:41', '2025-08-30 10:58:41'),
(20, 3, 1, 'تماس با ما', 'با ما آشنا شوید', NULL, 'با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید با ما آشنا شوید', '2025-08-10 15:36:47', '2025-08-10 16:20:02'),
(21, 3, 2, 'تماس با ما', 'تست 2222', NULL, NULL, '2025-08-10 15:44:01', '2025-08-10 15:44:01'),
(22, 3, 2, 'تماس با ما', 'تست 3333', NULL, NULL, '2025-08-10 15:44:07', '2025-08-10 15:44:07'),
(23, 3, 2, 'تماس با ما', 'تست 4444', NULL, NULL, '2025-08-10 15:44:15', '2025-08-10 15:44:15'),
(24, 3, 2, 'تماس با ما', 'تست 33333', NULL, NULL, '2025-08-10 15:44:21', '2025-08-10 15:44:21'),
(25, 3, 3, 'تماس با ما', 'اهداف و ماموریت', NULL, 'اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت اهداف و ماموریت', '2025-08-10 15:45:08', '2025-08-10 15:45:08'),
(26, 3, 4, 'تماس با ما', 'هدف 1', NULL, 'هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1هدف 1', '2025-08-10 15:46:00', '2025-08-10 15:46:00'),
(27, 3, 4, 'تماس با ما', 'هدف 2', NULL, 'هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2', '2025-08-10 15:46:08', '2025-08-10 15:46:08'),
(28, 3, 4, 'تماس با ما', 'هدف 3', NULL, 'هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2هدف 2', '2025-08-10 15:46:15', '2025-08-10 15:46:15'),
(29, 1, 2, 'ارائه خدمات مهندسی', 'پیمانکاری تاسیسات', NULL, 'با بهره گیری از تیم اجرایی متخصص، پروژه های تاسیسات مکانیکی و برقی شامل سیستم های تهویه مطبوع سرمایش و گرمایش، استخر، آتشنشانی،  کلیه سیستم برق و هوشمند سازی را با رعایت کامل استاندارد ها، کیفیت بالا، زمانبندی دقیق و هزینه بهینه اجرا می کنیم .', '2025-08-11 09:57:17', '2025-08-12 06:35:46'),
(30, 1, 2, 'ارائه خدمات مهندسی', 'هم‌افزایی معماری و تاسیسات', NULL, 'ما با همکاری نزدیک با تیم معماری و استفاده از تجربه و دانش تخصصی، به صورت خلاقانه و کارآمد، چالش های معماری مانند محدودیت فضا، هماهنگی سیستم های تاسیسات با طرح معماری راهکارهای عملی ارائه نموده تا پروژه هماهنگ، زیبا و کارآمد خلق شود .', '2025-08-11 09:58:14', '2025-08-12 06:49:18'),
(31, 1, 3, 'نمایندگی فروش', 'دیگ های چگالشی فرولی ایتالیا', '766majuldig.jpg', NULL, '2025-08-12 07:12:39', '2025-08-12 07:12:39'),
(32, 1, 3, 'نمایندگی فروش', 'خانه هوشمند TIS', '230fa_banner8.jpg', NULL, '2025-08-12 07:28:10', '2025-08-12 07:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT 0,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `pic`, `price`, `content`, `publish`, `cat_id`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', '[\"902majuldig.jpg\",\"684unnamed.jpg\",\"479fa_banner8.jpg\",\"243majuldig.jpg\"]', 14000000, 'تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست تست2', 1, 2, '2025-07-20 15:25:10', '2025-08-27 05:07:29'),
(3, 'موتورخانه', 'موتورخانه', '[\"687photo_2025-08-11_16-45-55.jpg\",\"56photo_2025-08-11_16-45-51.jpg\"]', 1000, 'موتورخانه گرمایش ساختمان', 0, 2, '2025-08-30 10:34:45', '2025-08-30 10:34:45'),
(2, 'دسر شکلاتی', 'دسر-شکلاتی', '[\"741pxfuel(5).jpg\",\"642pxfuel(3).jpg\",\"332pxfuel(29).jpg\"]', 170000, 'دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی دسر شکلاتی', 0, 2, '2025-07-21 12:39:56', '2025-08-27 05:27:59'),
(4, 'موتورخانه', 'موتورخانه', '[\"685photo_2025-08-11_16-45-51.jpg\",\"712photo_2025-08-11_16-45-55.jpg\",\"327photo_2025-08-11_16-45-24.jpg\"]', 10000, 'موتورخانه گرمایش ساختمان', 0, 2, '2025-08-30 10:37:34', '2025-08-30 10:37:34'),
(5, 'اگزاست فن', 'اگزاست-فن', '[\"593architecture-buildings-city-5k-bl-3440x1440.jpg\",\"218building_mirror_sky_1163710_3840x2160.jpg\"]', 1000, 'دستگاه اگزاست فن', 0, 2, '2025-08-30 10:51:59', '2025-08-30 10:51:59'),
(6, 'تیتر', 'تیتر', '[\"891licensed-image.jpg\",\"79Untitled.jpg\",\"46images.jpg\"]', 5000000, 'تیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیترتیتر', 0, 9, '2025-09-01 14:04:31', '2025-09-01 14:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

CREATE TABLE `product_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `cat_id`, `title`, `slug`, `pic`, `content`, `publish`, `created_at`, `updated_at`) VALUES
(1, 5, 'رستوران آستارا', 'رستوران-آستارا', '764360_F_305165781_MLLUnw5VvmVDCpS3AVsK8lvrAX8Ydgeq.jpg', '<p>تهویه مطبوع</p>', 1, '2025-08-09 18:12:51', '2025-08-27 06:30:16'),
(4, 5, 'پروژه من', 'پروژه-من', '708Background.png', '<p>پروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه منپروژه من</p>', 1, '2025-09-01 04:14:55', '2025-09-01 04:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'آکسیال', '2025-08-30 10:53:12', '2025-08-30 10:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `role_as` int(11) NOT NULL,
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `email_verified_at`, `username`, `phone_number`, `password`, `gender`, `role_as`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'آرمان', 'dabir', 'dabirmoghadam.a.com', NULL, 'armandabir', '09361811998', '$2y$10$yrjNbhnJ/yApNpUMQn.WYOru5/A8TusiwTKiW6iC1eZAAT4yNobRm', 1, 0, NULL, 'PwDPZ9EdYAFadq8UJ4edNP0To69Yv2OTfGeADmFc4gb2vf4EtWoLyH2QIC3y', '2025-07-19 15:29:37', '2025-08-07 06:17:35'),
(2, 'مصطفی', 'قربانی', 'dabirmoghadam.a2@gmail.com', NULL, 'mostafa', '09113847982', '$2y$10$QUvISI6LYicyKSNz708WX.a.tYNA7pMP9DuesGztY61xTz6xM5TS.', NULL, 1, 'رشت رشت رشت', 'UySn8Vxrd80cMMmAxg705gyZWgIovv8ra4y2X1IQcJFS6bkwWrYoBZRUR4F1', '2025-07-20 14:24:05', '2025-08-11 02:30:40'),
(3, 'کاربر', 'کاربر', 'karbar.a2@gmail.com', NULL, 'user', '09361811999', '$2y$10$kAj0vF8THUlJCHwLrVG6y.dUL2zdLNdDVDZP1bw4HXFfRUN/yYhUa', NULL, 4, 'رشت رشت رشت', '2MKFFNES7aBVEJL6NtgSUnx5xa3Q8fwRF8l8iba0WXdBZoK9aqUB8TXoBOs9', '2025-07-20 14:24:05', '2025-07-25 14:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `ip`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', '2025-07-19 13:57:50', '2025-07-19 13:57:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_tag`
--
ALTER TABLE `article_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_tag_article_id_foreign` (`article_id`),
  ADD KEY `article_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_maincat_id_foreign` (`maincat_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_tag_product_id_foreign` (`product_id`),
  ADD KEY `product_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `article_tag`
--
ALTER TABLE `article_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
