-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 02:59 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petverse`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `entity_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `action_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_requests`
--

CREATE TABLE `admin_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `admin_user_id`, `user_id`, `admin_type`, `permissions`, `is_active`, `description`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 'super_admin', 'all', 1, 'Primary application administrator', '2026-03-15 19:39:40', '2026-03-16 18:21:34'),
(2, '4', 4, 'main_admin', 'all', 1, NULL, '2026-03-16 18:55:41', '2026-03-16 18:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `animal_types`
--

CREATE TABLE `animal_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `animal_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `animal_types`
--

INSERT INTO `animal_types` (`id`, `name`, `status`, `animal_type`, `created_at`, `updated_at`) VALUES
(1, 'Cat', 'Active', 'Cat', NULL, NULL),
(2, 'Dog', 'Active', 'Dog', NULL, NULL),
(3, 'Bird', 'Active', 'Bird', NULL, NULL),
(4, 'Fish', 'Active', 'Fish', NULL, NULL),
(5, 'Rabbit', 'Active', 'Rabbit', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_link_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `valid_from` datetime DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_image_url_escaped` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `view_count` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `published_at` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `website_url`, `logo_path`, `is_active`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Whiskas', NULL, NULL, 'brands/iscQqCK9I29fVfNYeYRyWnwmWMagaAJJ8S1bN8zN.jpg', 1, 1, '2026-03-16 19:07:17', '2026-03-16 19:07:17'),
(2, 'Royal Canin', 'Premium natural dog foods since 1985', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55'),
(3, 'Blue Buffalo', 'Natural ingredients for healthier pets', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55'),
(4, 'Kong', 'Durable toys for active pets', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55'),
(5, 'Fluval', 'Premium aquarium equipment', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55'),
(6, 'Zoo Med', 'Complete reptile care solutions', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55'),
(7, 'Petco', 'Trusted general pet supplies', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55'),
(8, 'Oxbow', 'Nutrition for small pets', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55'),
(9, 'API', 'Aquatic care products', NULL, NULL, 1, 1, '2026-03-22 05:20:55', '2026-03-22 05:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cart_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `cart_id`, `user_status`, `notes`, `cart_status`, `created_at`, `updated_at`) VALUES
(1, 3, '191b086d-94f5-4304-aba2-9b47cd73f73c', 'customer', NULL, 'completed', '2026-03-17 08:51:43', '2026-03-22 04:30:34'),
(2, 4, '06b60b39-2338-4aec-9f60-a6f97711e75b', 'customer', NULL, 'active', '2026-03-17 09:03:31', '2026-03-17 09:03:31'),
(3, 5, 'd805d8b9-52fe-4884-b1d7-a8b4da4e185e', 'customer', NULL, 'active', '2026-03-17 17:05:57', '2026-03-17 17:05:57'),
(4, 6, '14bb434d-4477-43b7-a004-4ad37c39e4c6', 'customer', NULL, 'active', '2026-03-21 07:13:38', '2026-03-21 07:13:38'),
(5, 7, 'ab650bb2-df3e-4f6b-8fde-1c9e136f323b', 'customer', NULL, 'completed', '2026-03-22 02:04:08', '2026-03-22 02:07:48'),
(6, 7, '7c6e2eb2-e784-4f41-bfdf-5589d99fbb55', 'customer', NULL, 'active', '2026-03-22 02:07:50', '2026-03-22 02:07:50'),
(7, 3, '8e5da6a8-b2a7-4481-8598-607fd2951fe1', 'customer', NULL, 'completed', '2026-03-22 04:30:35', '2026-03-22 17:44:07'),
(8, 3, '5e0decab-85f0-44cc-a59f-c6674b2e269b', 'customer', NULL, 'active', '2026-03-22 17:44:09', '2026-03-22 17:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, '450.00', '450.00', '2026-03-17 17:06:15', '2026-03-17 17:06:15'),
(2, 5, 1, 2, '450.00', '900.00', '2026-03-22 02:04:26', '2026-03-22 02:06:51'),
(3, 1, 1, 1, '450.00', '450.00', '2026-03-22 02:33:10', '2026-03-22 03:49:14'),
(4, 6, 1, 2, '450.00', '900.00', '2026-03-22 02:34:02', '2026-03-22 02:36:14'),
(5, 1, 2, 2, '380.00', '760.00', '2026-03-22 04:19:04', '2026-03-22 04:19:07'),
(6, 7, 17, 10, '95.00', '950.00', '2026-03-22 17:29:03', '2026-03-22 17:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `parent_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `store_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_banner_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`, `image_url`, `sort_order`, `is_featured`, `parent_category_id`, `category_description`, `category_image_url`, `display_order`, `store_description`, `store_banner_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Toys', 'test', NULL, 11, 0, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-16 19:08:29', '2026-03-22 05:29:27'),
(2, 'Food and Nutritions', NULL, NULL, 1, 0, 1, NULL, NULL, 0, NULL, NULL, 1, '2026-03-16 19:08:48', '2026-03-22 05:29:27'),
(3, 'Medicine HealthCare', 'Test', NULL, 12, 0, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-18 09:27:09', '2026-03-22 05:29:27'),
(5, 'Habitats & Housing', 'Comfortable homes for every species', NULL, 2, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(6, 'Health & Care', 'Medical supplies and wellness products', NULL, 3, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(7, 'Toys & Enrichment', 'Fun and engaging toys for active pets', NULL, 4, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(8, 'Grooming & Hygiene', 'Keep your pet clean and beautiful', NULL, 5, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(9, 'Travel & Safety', 'Safe adventures with your companion', NULL, 6, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(10, 'Aquatic Supplies', 'Everything for water-loving pets', NULL, 7, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(11, 'Reptile & Exotic Care', 'Specialized supplies for unique pets', NULL, 8, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(12, 'Invertebrate Care', 'Products for insects and invertebrates', NULL, 9, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27'),
(13, 'Training & Behavior', 'Tools for better pet behavior', NULL, 10, 1, NULL, NULL, NULL, 0, NULL, NULL, 1, '2026-03-22 05:23:16', '2026-03-22 05:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `usage_limit_per_user` int(11) DEFAULT NULL,
  `max_usage_limit` int(11) DEFAULT NULL,
  `valid_from` datetime NOT NULL,
  `valid_until` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `applicable_categories` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_order_value` decimal(10,2) DEFAULT NULL,
  `usage_limit_per_user_max` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faq_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_31_132440_create_user_addresses_table', 1),
(6, '2026_01_31_132449_create_sellers_table', 1),
(7, '2026_01_31_132456_create_categories_table', 1),
(8, '2026_01_31_132504_create_animal_types_table', 1),
(9, '2026_01_31_132510_create_products_table', 1),
(10, '2026_01_31_132517_create_product_variants_table', 1),
(11, '2026_01_31_132528_create_product_images_table', 1),
(12, '2026_01_31_132541_create_product_animal_types_table', 1),
(13, '2026_01_31_132552_create_product_magics_table', 1),
(14, '2026_01_31_132626_create_carts_table', 1),
(15, '2026_01_31_132633_create_cart_items_table', 1),
(16, '2026_01_31_132640_create_orders_table', 1),
(17, '2026_01_31_132656_create_order_items_table', 1),
(18, '2026_01_31_132708_create_payments_table', 1),
(19, '2026_01_31_132724_create_shipments_table', 1),
(20, '2026_01_31_132736_create_reviews_table', 1),
(21, '2026_01_31_132745_create_wishlists_table', 1),
(22, '2026_01_31_132809_create_coupons_table', 1),
(23, '2026_01_31_132816_create_coupon_usages_table', 1),
(24, '2026_01_31_132823_create_notifications_table', 1),
(25, '2026_01_31_132830_create_seller_payouts_table', 1),
(26, '2026_01_31_132838_create_return_refunds_table', 1),
(27, '2026_01_31_132845_create_product_questions_table', 1),
(28, '2026_01_31_132852_create_shipping_zones_table', 1),
(29, '2026_01_31_132901_create_admin_users_table', 1),
(30, '2026_01_31_132925_create_activity_logs_table', 1),
(31, '2026_01_31_132932_create_banners_table', 1),
(32, '2026_01_31_132939_create_newsletter_subscribers_table', 1),
(33, '2026_01_31_132947_create_blog_posts_table', 1),
(34, '2026_01_31_132953_create_faqs_table', 1),
(35, '2026_02_01_000000_add_status_to_reviews_table', 1),
(36, '2026_02_01_000001_create_brands_table', 1),
(37, '2026_02_07_000000_add_is_admin_to_users_table', 1),
(38, '2026_02_08_000000_add_is_featured_to_brands_table', 1),
(39, '2026_02_25_000000_make_animal_type_nullable_in_products', 1),
(40, '2026_03_09_142500_replace_animal_type_id_with_text_on_products', 1),
(41, '2026_03_09_143000_drop_seller_foreign_key_from_products', 1),
(42, '2026_03_09_144000_add_logo_path_to_brands', 1),
(43, '2026_03_09_160000_add_pet_preferences_to_users', 1),
(44, '2026_03_09_170000_create_store_settings_table', 1),
(45, '2026_03_09_171000_add_extra_to_store_settings', 1),
(46, '2026_03_12_000001_create_admin_requests_table', 1),
(47, '2026_03_16_032256_add_is_active_to_categories_and_products_table', 1),
(48, '2026_03_17_170417_make_user_id_nullable_in_carts_table', 2),
(50, '2026_03_18_011621_add_details_to_categories_table', 3),
(51, '2026_03_18_014148_add_details_to_brands_table', 4),
(52, '2026_03_22_100000_add_shipping_and_voucher_to_orders', 5),
(53, '2026_03_22_100001_make_seller_id_nullable_on_order_items', 6),
(54, '2026_03_22_200000_create_product_reviews_system', 7),
(56, '2026_03_22_125149_make_order_item_id_nullable_on_reviews_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscriber_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `subscription_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unsubscribed_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notification_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `notification_medium` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_user_notification_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ent_admin` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_time` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `order_amount` decimal(12,2) NOT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipping_address_id` bigint(20) UNSIGNED NOT NULL,
  `billing_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_delivery_date` datetime DEFAULT NULL,
  `actual_delivery_date` datetime DEFAULT NULL,
  `customer_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_instructions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_requests` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_id`, `order_number`, `order_status`, `order_amount`, `tax_amount`, `total_amount`, `discount_amount`, `shipping_fee`, `shipping_method`, `voucher_code`, `payment_method`, `payment_status`, `shipping_address_id`, `billing_address_id`, `tracking_number`, `estimated_delivery_date`, `actual_delivery_date`, `customer_notes`, `delivery_instructions`, `special_requests`, `item_status`, `cancellation_reason`, `created_at`, `updated_at`) VALUES
(2, 7, 'ORD-I7SZTBHOBZ', '728157', 'pending', '900.00', NULL, '959.00', '0.00', '59.00', 'standard', NULL, 'cod', 'pending', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-22 02:07:48', '2026-03-22 02:07:48'),
(3, 3, 'ORD-K0LHDSUGNY', '741155', 'pending', '1210.00', NULL, '1269.00', '0.00', '59.00', 'standard', NULL, 'cod', 'pending', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-22 04:30:34', '2026-03-22 04:30:34'),
(4, 3, 'ORD-HDPNUH0N3L', '458014', 'pending', '950.00', NULL, '1009.00', '0.00', '59.00', 'standard', NULL, 'cod', 'pending', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-22 17:44:07', '2026-03-22 17:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `seller_id`, `quantity`, `unit_price`, `total_amount`, `discount_amount`, `tax_amount`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, 2, '450.00', '900.00', NULL, NULL, 'pending', '2026-03-22 02:07:48', '2026-03-22 02:07:48'),
(2, 3, 1, NULL, 1, '450.00', '450.00', NULL, NULL, 'pending', '2026-03-22 04:30:34', '2026-03-22 04:30:34'),
(3, 3, 2, NULL, 2, '380.00', '760.00', NULL, NULL, 'pending', '2026-03-22 04:30:34', '2026-03-22 04:30:34'),
(4, 4, 17, NULL, 10, '95.00', '950.00', NULL, NULL, 'pending', '2026-03-22 17:44:07', '2026-03-22 17:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_amount` decimal(12,2) NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PHP',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_gateway_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `animal_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `animal_type_id` int(10) UNSIGNED DEFAULT NULL,
  `animal_category_id` bigint(20) UNSIGNED NOT NULL,
  `animal_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `animal_image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `animal_specifications` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` int(11) DEFAULT NULL,
  `cost_plus_price` int(11) DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_reduced` tinyint(1) NOT NULL DEFAULT 0,
  `weight_in_grams` decimal(8,2) DEFAULT NULL,
  `low_stock_threshold` int(11) DEFAULT NULL,
  `product_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `product_name`, `animal_type`, `animal_type_id`, `animal_category_id`, `animal_description`, `animal_image_url`, `animal_specifications`, `price`, `cost_price`, `cost_plus_price`, `sku`, `short_description`, `full_description`, `brand_name`, `is_featured`, `is_active`, `is_reduced`, `weight_in_grams`, `low_stock_threshold`, `product_status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Whiskas Dry Food', 'Cat', 1, 2, NULL, 'products/m3oO31eCsvLcjpAUydJoY0MYDPzJi6Nt9WOGT1Cp.png', NULL, '450.00', NULL, NULL, 'TEST', 'qweqw', 'qweqw', 'Whiskas', 0, 1, 0, NULL, NULL, 'active', '2026-03-16 19:10:33', '2026-03-22 03:52:34'),
(2, 0, 'WHISKAS® 1+ Years Chicken Flavour (Dry)', 'Cat', 1, 2, 'Complete and balanced dry cat food with real chicken for adult cats 1+ years. Crunchy kibble that helps maintain dental health.', 'products/yWVYk7nkEbC8QP4x0hap4i8DdAeSXAEn9YKAJWvl.png', NULL, '380.00', NULL, NULL, 'WHSK-32D5CE', 'Complete and balanced dry cat food with real chicken for adult cats 1+ years. Crunchy kibble that helps maintain dental health.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:52:34'),
(3, 0, 'WHISKAS® 1+ Years Chicken With Salmon Flavour (Wet)', 'Cat', 1, 2, 'Delicious wet cat food with tender chicken and salmon in a savory gravy. Rich in omega fatty acids for a shiny coat.', 'products/m3oO31eCsvLcjpAUydJoY0MYDPzJi6Nt9WOGT1Cp.png', NULL, '45.00', NULL, NULL, 'WHSK-702459', 'Delicious wet cat food with tender chicken and salmon in a savory gravy. Rich in omega fatty acids for a shiny coat.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:52:34'),
(4, 0, 'WHISKAS® 1+ Years Mackerel Flavour (Dry)', 'Cat', 1, 2, 'Premium dry cat food made with real mackerel. Packed with protein, vitamins, and minerals for active adult cats.', 'products/cIpIkk47v46C73QcFsOjtlf0EBWMO7BpVKTqU4oV.png', NULL, '420.00', NULL, NULL, 'WHSK-3D9804', 'Premium dry cat food made with real mackerel. Packed with protein, vitamins, and minerals for active adult cats.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:52:34'),
(5, 0, 'WHISKAS® 1+ Years Ocean Fish Flavour (Wet)', 'Cat', 1, 2, 'Moist and flavorful wet cat food with tender ocean fish pieces in jelly. A perfect meal for fussy eaters.', 'products/ZjgqhiCcjBUo8vdIrb2AY7V9TFh1ljbRpUskD3pS.png', NULL, '48.00', NULL, NULL, 'WHSK-585C1B', 'Moist and flavorful wet cat food with tender ocean fish pieces in jelly. A perfect meal for fussy eaters.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:52:34'),
(6, 0, 'WHISKAS® 1+ Years Tuna Flavour (Wet)', 'Cat', 1, 2, 'Protein-rich wet cat food with real tuna chunks in gravy. Supports strong muscles and healthy skin.', 'products/DQ5LNWDfarhiTIkuaWl9RvbkYCSbw317UObx6Dyf.png', NULL, '50.00', NULL, NULL, 'WHSK-70A514', 'Protein-rich wet cat food with real tuna chunks in gravy. Supports strong muscles and healthy skin.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:52:34'),
(7, 0, 'WHISKAS® Adult 1+ Years Hairball Control', 'Cat', 1, 2, 'Dry cat food specially formulated to help reduce hairballs in adult cats 1+ years.', 'products/bkuUWhhuz5WKvl0lPejKPu7zl9c6DmUdwOe8eESq.png', NULL, '450.00', NULL, NULL, 'WHSK-2AC9965', 'Dry cat food specially formulated to help reduce hairballs in adult cats 1+ years.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:54:13'),
(8, 0, 'WHISKAS® Adult 1+ Years Indoor Formula', 'Cat', 1, 2, 'Complete and balanced dry food tailored for the needs of indoor adult cats.', 'products/atQWKa7xEyw4fubGOU4min7gozlG52rJi3nplnya.png', NULL, '430.00', NULL, NULL, 'WHSK-5887944', 'Complete and balanced dry food tailored for the needs of indoor adult cats.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:54:24'),
(9, 0, 'WHISKAS® Adult 1+ Years Skin & Coat', 'Cat', 1, 2, 'Enriched with essential nutrients to promote healthy skin and a shiny coat for adult cats.', 'products/BYeVsslaNGNRuSdUkLId1p8ZrtVlzyx9lCK76uO3.png', NULL, '460.00', NULL, NULL, 'WHSK-6F474F2', 'Enriched with essential nutrients to promote healthy skin and a shiny coat for adult cats.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:54:34'),
(10, 0, 'WHISKAS® Mackerel Dry Cat Food for Adults', 'Cat', 1, 2, 'Delicious mackerel flavor dry kibble packed with protein and vitamins for adult cats.', 'products/0NqMYZgT0nux8D09v7tMFOMYKyOayPzzJeYAy39w.png', NULL, '390.00', NULL, NULL, 'WHSK-9D49654', 'Delicious mackerel flavor dry kibble packed with protein and vitamins for adult cats.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:54:43'),
(11, 0, 'WHISKAS® Ocean Fish Dry Cat Food', 'Cat', 1, 2, 'Crunchy dry cat food with savory ocean fish flavor to satisfy your cat\'s cravings.', 'products/my98t7y62xmCaru9KExmSYidnWg8XsckrsvN4zmv.png', NULL, '395.00', NULL, NULL, 'WHSK-81DC6EB', 'Crunchy dry cat food with savory ocean fish flavor to satisfy your cat\'s cravings.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:54:54'),
(12, 0, 'WHISKAS® Tuna Dry Cat Food', 'Cat', 1, 2, 'Nutritious dry kibble with real tuna flavor, providing complete and balanced nutrition.', 'products/o3RRtDXKPpJ3dXldagb1L7BIjcMJQXdyYJf2EYG6.png', NULL, '400.00', NULL, NULL, 'WHSK-AD14C39', 'Nutritious dry kibble with real tuna flavor, providing complete and balanced nutrition.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:55:20'),
(13, 0, 'WHISKAS® Junior Ocean Fish Dry Cat Food', 'Cat', 1, 2, 'Specially formulated dry food with extra nutrition for growing kittens. Ocean fish flavor.', 'products/KzrqCH4OuPSoMaLZ8Htbg76M68fQzDjLL2qk3md4.png', NULL, '410.00', NULL, NULL, 'WHSK-65EC8B5', 'Specially formulated dry food with extra nutrition for growing kittens. Ocean fish flavor.', NULL, 'Whiskas', 1, 1, 0, NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:55:43'),
(14, 1, 'Indoor 27', NULL, 1, 2, NULL, NULL, NULL, '1250.00', NULL, NULL, 'RC-Y4ETZW', 'Dry Food For Cat', 'ROYAL CANIN® Indoor 27 is specially formulated with the nutritional needs of your indoor, adult cat in mind. Suitable for cats aged 1 to 7 years old.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'draft', '2026-03-22 05:58:46', '2026-03-22 07:21:30'),
(15, 1, 'Indoor 27', 'Cat', 1, 2, NULL, 'products/vO7wSGrcvNgc6XNpMNMs3BqdlFGcX5O91GHjk6K4.png', NULL, '1250.00', NULL, NULL, 'RC-INS0ZJ', 'Dry Food For Cat', 'ROYAL CANIN® Indoor 27 is specially formulated with the nutritional needs of your indoor, adult cat in mind. Suitable for cats aged 1 to 7 years old.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:15:49'),
(16, 1, 'Intense Beauty Jelly', 'Cat', 1, 2, NULL, 'products/FFzb4TPMl1AN5YGndkKY6Di74basvYJtruekazrz.png', NULL, '85.00', NULL, NULL, 'RC-OVNFDR', 'Wet Food For Cat', 'ROYAL CANIN® Intense Beauty in Jelly contains high levels of omega-3 & omega-6 fatty acids to help your cat maintain a beautiful coat and healthy skin.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:17:01'),
(17, 1, 'Hairball Care Gravy', 'Cat', 1, 2, NULL, 'products/0bBKJ1V9eGbdKvw3yuWgcj0MTAnJWxWGDI5q22Ty.png', NULL, '95.00', NULL, NULL, 'RC-38HBTN', 'Wet Food For Cat', 'ROYAL CANIN® Hairball Care in Gravy is formulated to help your cat eliminate ingested hair by stimulating the intestinal transit passage.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:17:38'),
(18, 1, 'Kitten', NULL, 1, 2, NULL, NULL, NULL, '1350.00', NULL, NULL, 'RC-STZGHN', 'Dry Food For Kitten', 'ROYAL CANIN® Kitten dry cat food is specially formulated to support the nutritional needs of kittens in the \"consolidation phase\" of their growth.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'draft', '2026-03-22 05:59:22', '2026-03-22 07:17:50'),
(19, 1, 'Urinary Care', 'Cat', 1, 2, NULL, 'products/HmIpT9vKQnpRFIPrxEUctSAjJh5II7y79mm34aIa.png', NULL, '1400.00', NULL, NULL, 'RC-4HX13P', 'Dry Food For Cat', 'ROYAL CANIN® Urinary Care is a precisely balanced nutritional formula that helps to maintain a healthy urinary tract in your cat.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:18:05'),
(20, 1, 'Mini Adult', 'Dog', 2, 2, NULL, 'products/sJvCz7nuxJChg8J2mTpvVZ3jEahJhgg8b7fFEPMV.png', NULL, '1100.00', NULL, NULL, 'RC-NQF3ON', 'Dry Food For Dog', 'ROYAL CANIN® Mini Adult is a nutritionally complete and balanced formula specially designed to meet the particular needs of small dogs.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:18:39'),
(21, 1, 'Maxi Puppy', 'Dog', 2, 2, NULL, 'products/VxEzlJ5D3J2q8f9Kn3omaUNEJw9zHJpxW8voKUMK.png', NULL, '200.00', NULL, NULL, 'RC-F9Y4GQ', 'Dry Food For Dog', 'ROYAL CANIN® Maxi Puppy is specially formulated to support the nutritional needs of large breed puppies.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:41:15'),
(22, 1, 'Mother & Babycat', 'Cat', 1, 2, NULL, 'products/bYwcljJNlcvN95Q4WrAcKLNrlxi52cbYwTtnsljC.png', NULL, '1500.00', NULL, NULL, 'RC-BVATJI', 'Dry Food For Cat', 'ROYAL CANIN® Mother & Babycat is specially adapted to meet your cat’s high energy needs at the end of gestation and during lactation.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:19:34'),
(23, 1, 'Pomeranian Adult', 'Dog', 2, 2, NULL, 'products/Xl5nR3zbm6pJ8i39EI9hafo0zimw58wSXkX0gYcK.png', NULL, '1350.00', NULL, NULL, 'RC-IBQZYG', 'Dry Food For Dog', 'ROYAL CANIN® Pomeranian Adult is a tailor-made, breed-exclusive formula specially designed for adult Pomeranian dogs.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:20:05'),
(24, 1, 'Persian Adult', 'Cat', 1, 2, NULL, 'products/0G3luifMBqBEeI9MoOwK35WG41gPsUqnxF4v3r7y.png', NULL, '1650.00', NULL, NULL, 'RC-I76LCT', 'Dry Food For Cat', 'ROYAL CANIN® Persian Adult contains an exclusive complex of nutrients to help the skin’s barrier role to maintain good skin and coat health.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:20:43'),
(25, 1, 'Recovery Liquid', 'Cat', 1, 2, NULL, 'products/kb0upDN1rGXp3a6VqImFrypsN8Fnn5XTCUFDQHbF.png', NULL, '450.00', NULL, NULL, 'RC-UBPSUH', 'Liquid Diet For Dog/Cat', 'ROYAL CANIN® Recovery Liquid is a complete dietetic feed for dogs and cats, formulated to promote nutritional restoration.', 'Royal Canin', 0, 1, 0, NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_animal_types`
--

CREATE TABLE `product_animal_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `animal_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_primary` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_magics`
--

CREATE TABLE `product_magics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_primary` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_questions`
--

CREATE TABLE `product_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variant_quantity` int(11) NOT NULL,
  `uom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_price` decimal(10,2) NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specifications` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `low_stock_threshold` int(11) DEFAULT NULL,
  `product_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `variant_name`, `variant_quantity`, `uom`, `variant_price`, `sku`, `specifications`, `low_stock_threshold`, `product_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Default', 12, NULL, '450.00', 'TEST-VAR', NULL, NULL, 'active', '2026-03-16 19:10:33', '2026-03-16 19:10:33'),
(2, 2, 'Dry Food', 66, NULL, '380.00', 'WHSK-32D5CE-DRY', NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:41:29'),
(3, 3, 'Wet Food', 61, NULL, '45.00', 'WHSK-702459-WET', NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:41:29'),
(4, 4, 'Dry Food', 79, NULL, '420.00', 'WHSK-3D9804-DRY', NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:41:29'),
(5, 5, 'Wet Food', 170, NULL, '48.00', 'WHSK-585C1B-WET', NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:41:29'),
(6, 6, 'Wet Food', 145, NULL, '50.00', 'WHSK-70A514-WET', NULL, NULL, 'active', '2026-03-22 03:41:29', '2026-03-22 03:41:29'),
(7, 7, 'Dry Food', 107, NULL, '450.00', 'WHSK-2AC9965-DRY', NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:50:22'),
(8, 8, 'Dry Food', 112, NULL, '430.00', 'WHSK-5887944-DRY', NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:50:22'),
(9, 9, 'Dry Food', 119, NULL, '460.00', 'WHSK-6F474F2-DRY', NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:50:22'),
(10, 10, 'Dry Food', 133, NULL, '390.00', 'WHSK-9D49654-DRY', NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:50:22'),
(11, 11, 'Dry Food', 120, NULL, '395.00', 'WHSK-81DC6EB-DRY', NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:50:22'),
(12, 12, 'Dry Food', 122, NULL, '400.00', 'WHSK-AD14C39-DRY', NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:50:22'),
(13, 13, 'Dry Food', 129, NULL, '410.00', 'WHSK-65EC8B5-DRY', NULL, NULL, 'active', '2026-03-22 03:50:22', '2026-03-22 03:50:22'),
(14, 15, 'Default', 50, NULL, '1250.00', 'RC-INS0ZJ-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(15, 16, 'Default', 50, NULL, '85.00', 'RC-OVNFDR-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(16, 17, 'Default', 50, NULL, '95.00', 'RC-38HBTN-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(17, 18, 'Default', 50, NULL, '1350.00', 'RC-STZGHN-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(18, 19, 'Default', 50, NULL, '1400.00', 'RC-4HX13P-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(19, 20, 'Default', 50, NULL, '1100.00', 'RC-NQF3ON-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(20, 21, 'Default', 50, NULL, '200.00', 'RC-F9Y4GQ-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 07:41:15'),
(21, 22, 'Default', 50, NULL, '1500.00', 'RC-BVATJI-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(22, 23, 'Default', 50, NULL, '1350.00', 'RC-IBQZYG-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(23, 24, 'Default', 50, NULL, '1650.00', 'RC-I76LCT-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22'),
(24, 25, 'Default', 50, NULL, '450.00', 'RC-UBPSUH-DEF', NULL, NULL, 'active', '2026-03-22 05:59:22', '2026-03-22 05:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `return_refunds`
--

CREATE TABLE `return_refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `return_refund_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_reason_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refund_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refund_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_at` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proof_of_delivery_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_shipping_address_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_response_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `review_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `verified_purchase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `helpful_count` int(11) NOT NULL DEFAULT 0,
  `review_images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_response` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seller_response_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `order_item_id`, `rating`, `comment`, `images`, `review_title`, `review_text`, `status`, `verified_purchase`, `helpful_count`, `review_images`, `seller_response`, `seller_response_date`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 2, 7, NULL, 5, NULL, NULL, NULL, NULL, 'published', 'N', 0, NULL, NULL, NULL, 'N', '2026-03-22 04:59:06', '2026-03-22 04:59:06');

-- --------------------------------------------------------

--
-- Table structure for table `review_likes`
--

CREATE TABLE `review_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_replies`
--

CREATE TABLE `review_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_registration_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_registration_number_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_banner_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `verification_documents_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_average` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_payouts`
--

CREATE TABLE `seller_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `payout_amount` decimal(12,2) NOT NULL,
  `payout_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payout_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `bank_account_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seller_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proof_of_delivery_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `estimated_delivery_date` datetime DEFAULT NULL,
  `actual_delivery_date` datetime DEFAULT NULL,
  `shipping_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zone_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_provinces` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_shipping_fee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barangay_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimated_delivery_days_max` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `free_shipping_threshold` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_settings`
--

CREATE TABLE `store_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Asia/Manila',
  `default_currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PHP',
  `extra` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_settings`
--

INSERT INTO `store_settings` (`id`, `store_name`, `store_email`, `store_phone`, `store_url`, `store_description`, `store_logo_path`, `timezone`, `default_currency`, `extra`, `created_at`, `updated_at`) VALUES
(1, 'Pet Animixon', 'support@petanimixon.com', '0998754684', 'petanimixon.com.ph', 'Your very trusted product for your pets!', 'settings/yiMfbfYvTD0VE2J3cnvEwD7E8l1nIkjVbavMtxJ0.png', 'Asia/Manila', 'PHP', '{\"free_shipping_min\":\"50\",\"handling_fee\":\"0\",\"gateway_cod\":\"0\",\"gateway_bank\":\"0\",\"gateway_online\":\"0\",\"provider_lbc\":\"0\",\"provider_jnt\":\"0\",\"provider_grab\":\"0\",\"provider_own\":\"0\",\"google_analytics\":\"0\",\"facebook_pixel\":\"0\",\"perm_orders\":\"0\",\"perm_products\":\"0\",\"perm_customers\":\"0\",\"perm_settings\":\"0\",\"password_require_upper\":\"0\",\"password_require_number\":\"0\"}', '2026-03-20 11:37:23', '2026-03-22 03:48:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `account_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `pet_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wants_promos` tinyint(1) NOT NULL DEFAULT 0,
  `wants_tips` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `password`, `date_of_birth`, `account_status`, `email_verified_at`, `phone_verified_at`, `user_type`, `pet_type`, `wants_promos`, `wants_tips`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 'Admin', 'User', 'admin@petverse.com', NULL, '$2y$10$qCCI.itg1Hvsto5bxXDP0u3rRSLlqn.HzEwrJLTWN14pF1WtJx/sW', NULL, 'active', '2026-03-16 18:21:33', NULL, 'admin', NULL, 0, 0, '2026-03-15 19:39:40', '2026-03-16 18:21:34', 1),
(2, 'Test', 'User', 'user@petverse.com', NULL, '$2y$10$Rj3IR4EVzwa.NjlWhe5eUOQoDac.iAZuMdG0SJKP5FmevcxvsGIOC', NULL, 'active', '2026-03-16 18:21:33', NULL, 'customer', NULL, 0, 0, '2026-03-15 19:39:40', '2026-03-16 18:21:34', 0),
(3, 'John Carry', 'Dogmoc', 'dogmocjohncarry@gmail.com', NULL, '$2y$10$BoM9E5NGRin4ny7cULy0huIwv4P9Xb6fCzF2qf/JxW1Q9GOHtTxGC', NULL, 'active', '2026-03-15 23:44:02', NULL, 'customer', 'dog', 1, 1, '2026-03-15 23:44:02', '2026-03-15 23:44:02', 0),
(4, 'System', 'Admin', 'admin@admin.com', NULL, '$2y$10$ix0RR8hihSpApBlH/KGId.3tkd43HKmqnuc.jjWSZCIquxE9eE/Zq', NULL, 'active', '2026-03-16 18:55:41', NULL, 'admin', NULL, 0, 0, '2026-03-16 18:55:41', '2026-03-16 18:55:41', 1),
(5, 'John Carry', 'Dogmoc', 'dogmoc@gmail.com', NULL, '$2y$10$zL5abtytGpE21izl9oAtD.Xrk9dW8ZMoxn5IkdZZBl2eGXLU7.GQq', NULL, 'active', '2026-03-17 17:05:55', NULL, 'customer', 'reptile', 1, 1, '2026-03-17 17:05:55', '2026-03-17 17:05:55', 0),
(6, 'Jet', '123', 'jet123@example.com', NULL, '$2y$10$FJXByObJpGF5ctu3IljU1u4Y8EhNXkP5KpA92J6gr8aKD16XjGtXS', NULL, 'active', '2026-03-21 07:13:35', NULL, 'customer', NULL, 0, 0, '2026-03-21 07:13:35', '2026-03-21 07:13:35', 0),
(7, 'Test', 'User', 'testuser@example.com', NULL, '$2y$10$4ouaLaFYefm03di1iN/l.u1x2RaWPGCuAR7kJi9i7.MHyU5Y8QiuK', NULL, 'active', '2026-03-22 02:04:04', NULL, 'customer', NULL, 0, 0, '2026-03-22 02:04:04', '2026-03-22 02:04:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_municipality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `address`, `address_type`, `recipient_name`, `phone_number`, `street_address`, `city_municipality`, `province`, `zip_code`, `region`, `barangay`, `delivery_notes`, `created_at`, `updated_at`) VALUES
(2, 7, '123 Main St, Manila', 'default', 'Test User', '09171234567', '123 Main St', 'Manila', 'Metro Manila', '', '', '', NULL, '2026-03-22 02:07:48', '2026-03-22 02:07:48'),
(3, 3, 'Libertad p-2B, City of Butuan', 'default', 'John Carry Dogmoc', '0997984631', 'Libertad p-2B', 'City of Butuan', 'Agusan Del Norte', '8600', 'Caraga', 'Libertad', NULL, '2026-03-22 04:30:34', '2026-03-22 04:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `wishlist_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `admin_requests`
--
ALTER TABLE `admin_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_requests_email_unique` (`email`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `animal_types`
--
ALTER TABLE `animal_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_post_id_unique` (`post_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_category_id_foreign` (`parent_category_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_coupon_code_unique` (`coupon_code`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_usages_user_id_foreign` (`user_id`),
  ADD KEY `coupon_usages_order_id_foreign` (`order_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletter_subscribers_email_unique` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_id_unique` (`order_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  ADD KEY `orders_billing_address_id_foreign` (`billing_address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

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
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_seller_id_foreign` (`seller_id`),
  ADD KEY `products_animal_category_id_foreign` (`animal_category_id`);

--
-- Indexes for table `product_animal_types`
--
ALTER TABLE `product_animal_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_animal_types_product_id_animal_type_id_unique` (`product_id`,`animal_type_id`),
  ADD KEY `product_animal_types_animal_type_id_foreign` (`animal_type_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_magics`
--
ALTER TABLE `product_magics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_magics_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_questions`
--
ALTER TABLE `product_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_questions_product_id_foreign` (`product_id`),
  ADD KEY `product_questions_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `return_refunds`
--
ALTER TABLE `return_refunds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `return_refunds_return_refund_id_unique` (`return_refund_id`),
  ADD KEY `return_refunds_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `review_likes_review_id_user_id_unique` (`review_id`,`user_id`),
  ADD KEY `review_likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `review_replies`
--
ALTER TABLE `review_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_replies_review_id_foreign` (`review_id`),
  ADD KEY `review_replies_user_id_foreign` (`user_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_payouts`
--
ALTER TABLE `seller_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_payouts_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipments_order_id_foreign` (`order_id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_requests`
--
ALTER TABLE `admin_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `animal_types`
--
ALTER TABLE `animal_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_animal_types`
--
ALTER TABLE `product_animal_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_magics`
--
ALTER TABLE `product_magics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_questions`
--
ALTER TABLE `product_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `return_refunds`
--
ALTER TABLE `return_refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `review_likes`
--
ALTER TABLE `review_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_replies`
--
ALTER TABLE `review_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_payouts`
--
ALTER TABLE `seller_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD CONSTRAINT `admin_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_billing_address_id_foreign` FOREIGN KEY (`billing_address_id`) REFERENCES `user_addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `user_addresses` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_animal_category_id_foreign` FOREIGN KEY (`animal_category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_animal_types`
--
ALTER TABLE `product_animal_types`
  ADD CONSTRAINT `product_animal_types_animal_type_id_foreign` FOREIGN KEY (`animal_type_id`) REFERENCES `animal_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_animal_types_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_magics`
--
ALTER TABLE `product_magics`
  ADD CONSTRAINT `product_magics_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_questions`
--
ALTER TABLE `product_questions`
  ADD CONSTRAINT `product_questions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_refunds`
--
ALTER TABLE `return_refunds`
  ADD CONSTRAINT `return_refunds_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD CONSTRAINT `review_likes_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_replies`
--
ALTER TABLE `review_replies`
  ADD CONSTRAINT `review_replies_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seller_payouts`
--
ALTER TABLE `seller_payouts`
  ADD CONSTRAINT `seller_payouts_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
