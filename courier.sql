-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 18, 2022 at 03:27 PM
-- Server version: 5.7.33
-- PHP Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courier`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bank_account',
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `merchant_id`, `bank_name`, `branch`, `account_name`, `account_number`, `provider`, `bank_type`, `account_type`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 2, 'AB BANK LIMITED', 'Mirpur', 'Shahadat', '830964337', 'Bkash', 'bank_account', 'Personal', NULL, '2021-10-26 15:09:14', '2021-10-26 15:09:14'),
(2, 2, 'AB BANK LIMITED', NULL, NULL, NULL, 'Bkash', 'mobile_banking', 'Personal', '0183096337', '2021-10-26 15:09:29', '2021-10-26 15:09:29');

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `merchant_balances`
--

CREATE TABLE `merchant_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `debit` double(8,2) NOT NULL DEFAULT '0.00',
  `credit` double(8,2) NOT NULL DEFAULT '0.00',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'parcel_delivery',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchant_balances`
--

INSERT INTO `merchant_balances` (`id`, `merchant_id`, `debit`, `credit`, `note`, `created_at`, `updated_at`) VALUES
(24, 2, 0.00, 792.00, 'parcel_delivery', '2021-10-31 15:16:06', '2021-10-31 15:16:06'),
(25, 2, 792.00, 0.00, 'parcel_delivery', '2021-10-31 15:17:08', '2021-10-31 15:17:08'),
(26, 2, 0.00, 4.95, 'parcel_delivery', '2021-10-31 17:27:25', '2021-10-31 17:27:25'),
(27, 2, 0.00, -71.28, 'parcel_delivery', '2021-10-31 18:34:24', '2021-10-31 18:34:24'),
(28, 2, 0.00, 7.92, 'parcel_delivery', '2021-10-31 18:34:58', '2021-10-31 18:34:58'),
(29, 2, 0.00, -10.89, 'parcel_delivery', '2021-10-31 18:37:05', '2021-10-31 18:37:05'),
(30, 2, 0.00, 50.49, 'parcel_delivery', '2021-10-31 18:37:16', '2021-10-31 18:37:16'),
(31, 2, 0.00, -8.91, 'parcel_delivery', '2021-10-31 18:39:05', '2021-10-31 18:39:05'),
(32, 2, 0.00, -5.94, 'parcel_delivery', '2021-10-31 18:39:18', '2021-10-31 18:39:18'),
(33, 2, 0.00, 15.84, 'parcel_delivery', '2021-10-31 18:44:05', '2021-10-31 18:44:05'),
(34, 2, 0.00, 14.85, 'parcel_delivery', '2021-10-31 18:44:15', '2021-10-31 18:44:15'),
(35, 2, 0.00, -1.98, 'parcel_delivery', '2021-10-31 18:48:52', '2021-10-31 18:48:52'),
(36, 2, 0.00, 46.53, 'parcel_delivery', '2021-10-31 18:49:14', '2021-10-31 18:49:14'),
(37, 2, 0.00, -62.37, 'parcel_delivery', '2021-10-31 18:50:21', '2021-10-31 18:50:21'),
(38, 2, 0.00, -88.11, 'parcel_delivery', '2021-10-31 18:50:38', '2021-10-31 18:50:38'),
(39, 2, 0.00, 1.98, 'parcel_delivery', '2021-10-31 18:52:09', '2021-10-31 18:52:09'),
(40, 2, 0.00, 24.75, 'parcel_delivery', '2021-10-31 18:52:31', '2021-10-31 18:52:31'),
(41, 2, 0.00, 16.83, 'parcel_delivery', '2021-10-31 18:54:04', '2021-10-31 18:54:04'),
(42, 2, 0.00, 9.90, 'parcel_delivery', '2021-10-31 18:54:19', '2021-10-31 18:54:19'),
(43, 2, 0.00, 0.99, 'parcel_delivery', '2021-10-31 18:56:08', '2021-10-31 18:56:08'),
(44, 2, 0.00, 0.00, 'parcel_delivery', '2021-10-31 19:00:21', '2021-10-31 19:00:21');

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
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_09_17_124841_create_payments_table', 1),
(7, '2021_09_17_190939_create_rider_parcels_table', 1),
(8, '2021_10_10_153954_create_parcels_table', 1),
(9, '2021_10_16_134324_create_parcel_trackings_table', 1),
(10, '2021_10_20_182327_create_merchant_balances_table', 1),
(11, '2021_10_24_115613_create_shops_table', 1),
(12, '2021_10_24_115810_create_bank_accounts_table', 1),
(13, '2021_10_24_202904_create_pickup_requests_table', 1),
(15, '2021_10_26_214613_create_withdrow_requests_table', 2),
(16, '2021_10_30_114253_create_settings_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `parcels`
--

CREATE TABLE `parcels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `rider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rider_parcel_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_amount` double(8,2) DEFAULT NULL,
  `charge` double(8,2) DEFAULT NULL,
  `parcel_note` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'On Review',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parcels`
--

INSERT INTO `parcels` (`id`, `merchant_id`, `rider_id`, `rider_parcel_id`, `payment_id`, `customer_name`, `customer_phone`, `customer_address`, `invoice_no`, `collection_amount`, `charge`, `parcel_note`, `status`, `created_at`, `updated_at`) VALUES
(33, 2, 3, 23, 8, 'Shahadat Hossain', '01830964337', 'East Kazipara', '1254', 800.00, NULL, NULL, 'Paid', '2021-10-31 15:13:52', '2021-10-31 15:17:08'),
(34, 2, 3, 24, NULL, 'A occaecat voluptate', '+1 (753) 577-7049', 'Reprehenderit laboru', 'Vero eveniet eos nu', 10.00, 5.00, 'Rerum nisi et esse', 'Delivered', '2021-10-31 17:26:49', '2021-10-31 17:27:25'),
(35, 2, 3, 26, NULL, 'Quia atque adipisci', '+1 (563) 807-7125', 'Consequatur Itaque', 'Officia iste ut ulla', 63.00, 12.00, 'Architecto dolor odi', 'Delivered', '2021-10-31 17:26:54', '2021-10-31 18:37:16'),
(36, 2, 3, 26, NULL, 'Non assumenda sunt n', '+1 (814) 631-2076', 'Voluptate sint anim', 'Ex vel sit ea bland', 24.00, 35.00, 'Maiores eligendi vol', 'Delivered', '2021-10-31 18:32:34', '2021-10-31 18:37:05'),
(37, 2, 3, 25, NULL, 'Porro aute occaecat', '+1 (486) 323-2273', 'Mollit facere sint l', 'Quibusdam rem consec', 49.00, 41.00, 'Accusamus similique', 'Delivered', '2021-10-31 18:32:38', '2021-10-31 18:34:58'),
(38, 2, 3, 25, NULL, 'Quia eos cupiditate', '+1 (504) 342-8151', 'A architecto impedit', 'Voluptatum est volup', 25.00, 97.00, 'Et reiciendis non se', 'Delivered', '2021-10-31 18:32:41', '2021-10-31 18:34:24'),
(39, 2, 3, 28, NULL, 'Maxime sapiente eum', '+1 (659) 685-1732', 'Elit do asperiores', 'Pariatur Error aut', 20.00, 29.00, 'Suscipit nihil animi', 'Delivered', '2021-10-31 18:38:20', '2021-10-31 18:39:05'),
(40, 2, 3, 28, NULL, 'Eu illo est esse u', '+1 (254) 532-3852', 'Labore nesciunt cil', 'Est ab quia harum qu', 91.00, 97.00, 'Exercitationem repre', 'Delivered', '2021-10-31 18:38:23', '2021-10-31 18:39:18'),
(41, 2, 3, 27, NULL, 'Qui molestiae sit a', '+1 (236) 744-9722', 'Ad qui perferendis d', 'Ut voluptate recusan', 81.00, 65.00, 'Quo aliquam corporis', 'Delivered', '2021-10-31 18:38:26', '2021-10-31 18:44:06'),
(42, 2, 3, 27, NULL, 'Cum quis totam iusto', '+1 (459) 419-4953', 'Perferendis rem volu', 'Eveniet Nam ipsum c', 36.00, 21.00, 'In doloremque et fac', 'Delivered', '2021-10-31 18:38:29', '2021-10-31 18:44:16'),
(43, 2, 3, 32, NULL, 'Consequat Laboriosa', '+1 (348) 562-5205', 'Libero sit necessit', 'Culpa dolore libero', 89.00, 72.00, 'Anim vitae fugiat v', 'Delivered', '2021-10-31 18:48:04', '2021-10-31 18:54:04'),
(44, 2, 3, 30, NULL, 'Quisquam distinctio', '+1 (478) 818-1059', 'Quo dolorum eaque no', 'At quia officia elit', 4.00, 93.00, 'Eiusmod reiciendis s', 'Delivered', '2021-10-31 18:48:08', '2021-10-31 18:50:38'),
(45, 2, 3, 30, NULL, 'Velit qui quidem por', '+1 (953) 426-1646', 'Omnis temporibus ali', 'Facere nesciunt ips', 23.00, 86.00, 'Et consequat Quia a', 'Delivered', '2021-10-31 18:48:11', '2021-10-31 18:50:21'),
(46, 2, 3, 29, NULL, 'Quae reiciendis quam', '+1 (526) 141-2348', 'Tempore facere vita', 'Reprehenderit itaqu', 84.00, 37.00, 'Sed quos eum aliquid', 'Delivered', '2021-10-31 18:48:14', '2021-10-31 18:49:15'),
(47, 2, 3, 29, NULL, 'Et provident cupidi', '+1 (195) 595-4936', 'Deserunt commodo ut', 'Itaque fuga Suscipi', 84.00, 86.00, 'Qui rerum enim bland', 'Delivered', '2021-10-31 18:48:18', '2021-10-31 18:48:52'),
(48, 2, 3, 32, NULL, 'Quis itaque voluptat', '+1 (768) 407-7432', 'Non officia enim pro', 'Sed provident conse', 85.00, 75.00, 'Aute veritatis quia', 'Delivered', '2021-10-31 18:51:16', '2021-10-31 18:54:19'),
(49, 2, 3, 31, NULL, 'Delectus dolor inci', '+1 (517) 766-9229', 'Velit obcaecati fug', 'Laborum Perspiciati', 92.00, 67.00, 'Atque aut in incidun', 'Delivered', '2021-10-31 18:51:19', '2021-10-31 18:52:31'),
(50, 2, 3, 31, NULL, 'Id nostrum exercitat', '+1 (721) 948-6163', 'Est occaecat dolor', 'Distinctio Esse in', 88.00, 86.00, 'Sunt ea nostrud est', 'Delivered', '2021-10-31 18:51:22', '2021-10-31 18:52:09'),
(51, 2, 3, 33, NULL, 'Illo officia quis al', '+1 (291) 317-6015', 'Qui quo totam eius d', 'Nemo in nemo aut fug', 52.00, 51.00, 'Ratione minus laudan', 'Delivered', '2021-10-31 18:55:40', '2021-10-31 18:56:08'),
(52, 2, 3, 33, NULL, 'Voluptatem duis tene', '+1 (708) 855-9151', 'Veniam qui proident', 'Obcaecati consequatu', 79.00, 18.00, 'Obcaecati porro modi', 'Return', '2021-10-31 18:55:44', '2021-10-31 18:56:17'),
(53, 2, 3, 33, NULL, 'Cupiditate ut est vo', '+1 (788) 149-1281', 'Rerum quos et sint o', 'Blanditiis natus ill', 43.00, 90.00, 'Qui ea voluptatem e', 'Half Return', '2021-10-31 18:55:46', '2021-10-31 18:58:59'),
(54, 2, NULL, NULL, NULL, 'Illum labore unde q', '+1 (803) 125-8979', 'Quis est fugiat ea', 'Sit quasi veniam qu', 26.00, 40.00, 'Nisi sunt reiciendis', 'Pending', '2021-10-31 18:59:54', '2021-10-31 19:00:36'),
(55, 2, 3, 34, NULL, 'Doloribus id est dol', '+1 (491) 312-3127', 'Provident aspernatu', 'Sapiente sunt ut eu', 75.00, 75.00, 'Ad molestiae recusan', 'Delivered', '2021-10-31 18:59:57', '2021-10-31 19:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `parcel_trackings`
--

CREATE TABLE `parcel_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parcel_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parcel_trackings`
--

INSERT INTO `parcel_trackings` (`id`, `parcel_id`, `status`, `description`, `created_at`, `updated_at`) VALUES
(88, 33, 'Accepted', NULL, '2021-10-31 15:15:12', '2021-10-31 15:15:12'),
(89, 33, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(90, 33, 'Delivered', NULL, NULL, NULL),
(91, 34, 'Accepted', NULL, '2021-10-31 17:26:49', '2021-10-31 17:26:49'),
(92, 35, 'Accepted', NULL, '2021-10-31 17:26:54', '2021-10-31 17:26:54'),
(93, 34, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(94, 35, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(95, 34, 'Delivered', NULL, NULL, NULL),
(96, 35, 'Pending', NULL, NULL, NULL),
(97, 36, 'Accepted', NULL, '2021-10-31 18:32:35', '2021-10-31 18:32:35'),
(98, 37, 'Accepted', NULL, '2021-10-31 18:32:38', '2021-10-31 18:32:38'),
(99, 38, 'Accepted', NULL, '2021-10-31 18:32:41', '2021-10-31 18:32:41'),
(100, 37, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(101, 38, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(102, 38, 'Delivered', NULL, '2021-10-31 18:34:24', '2021-10-31 18:34:24'),
(103, 37, 'Delivered', NULL, '2021-10-31 18:34:58', '2021-10-31 18:34:58'),
(104, 35, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(105, 36, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(106, 38, 'Delivered', NULL, '2021-10-31 18:36:39', '2021-10-31 18:36:39'),
(107, 36, 'Delivered', NULL, '2021-10-31 18:37:05', '2021-10-31 18:37:05'),
(108, 35, 'Delivered', NULL, '2021-10-31 18:37:16', '2021-10-31 18:37:16'),
(109, 39, 'Accepted', NULL, '2021-10-31 18:38:20', '2021-10-31 18:38:20'),
(110, 40, 'Accepted', NULL, '2021-10-31 18:38:23', '2021-10-31 18:38:23'),
(111, 41, 'Accepted', NULL, '2021-10-31 18:38:26', '2021-10-31 18:38:26'),
(112, 42, 'Accepted', NULL, '2021-10-31 18:38:29', '2021-10-31 18:38:29'),
(113, 41, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(114, 42, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(115, 39, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(116, 40, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(117, 39, 'Delivered', NULL, '2021-10-31 18:39:05', '2021-10-31 18:39:05'),
(118, 40, 'Delivered', NULL, '2021-10-31 18:39:18', '2021-10-31 18:39:18'),
(119, 41, 'Delivered', NULL, '2021-10-31 18:44:06', '2021-10-31 18:44:06'),
(120, 42, 'Delivered', NULL, '2021-10-31 18:44:16', '2021-10-31 18:44:16'),
(121, 43, 'Accepted', NULL, '2021-10-31 18:48:04', '2021-10-31 18:48:04'),
(122, 44, 'Accepted', NULL, '2021-10-31 18:48:08', '2021-10-31 18:48:08'),
(123, 45, 'Accepted', NULL, '2021-10-31 18:48:11', '2021-10-31 18:48:11'),
(124, 46, 'Accepted', NULL, '2021-10-31 18:48:14', '2021-10-31 18:48:14'),
(125, 47, 'Accepted', NULL, '2021-10-31 18:48:18', '2021-10-31 18:48:18'),
(126, 46, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(127, 47, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(128, 44, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(129, 45, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(130, 47, 'Delivered', NULL, '2021-10-31 18:48:52', '2021-10-31 18:48:52'),
(131, 46, 'Delivered', NULL, '2021-10-31 18:49:15', '2021-10-31 18:49:15'),
(132, 45, 'Delivered', NULL, '2021-10-31 18:50:21', '2021-10-31 18:50:21'),
(133, 44, 'Delivered', NULL, '2021-10-31 18:50:39', '2021-10-31 18:50:39'),
(134, 48, 'Accepted', NULL, '2021-10-31 18:51:16', '2021-10-31 18:51:16'),
(135, 49, 'Accepted', NULL, '2021-10-31 18:51:19', '2021-10-31 18:51:19'),
(136, 50, 'Accepted', NULL, '2021-10-31 18:51:22', '2021-10-31 18:51:22'),
(137, 49, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(138, 50, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(139, 50, 'Accepted', NULL, '2021-10-31 18:51:47', '2021-10-31 18:51:47'),
(140, 50, 'Delivered', NULL, '2021-10-31 18:52:10', '2021-10-31 18:52:10'),
(141, 49, 'Delivered', NULL, '2021-10-31 18:52:31', '2021-10-31 18:52:31'),
(142, 43, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(143, 48, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(144, 43, 'Delivered', NULL, '2021-10-31 18:54:04', '2021-10-31 18:54:04'),
(145, 48, 'Delivered', NULL, '2021-10-31 18:54:19', '2021-10-31 18:54:19'),
(146, 51, 'Accepted', NULL, '2021-10-31 18:55:40', '2021-10-31 18:55:40'),
(147, 52, 'Accepted', NULL, '2021-10-31 18:55:44', '2021-10-31 18:55:44'),
(148, 53, 'Accepted', NULL, '2021-10-31 18:55:46', '2021-10-31 18:55:46'),
(149, 51, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(150, 52, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(151, 53, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(152, 51, 'Delivered', NULL, '2021-10-31 18:56:08', '2021-10-31 18:56:08'),
(153, 52, 'Return', NULL, '2021-10-31 18:56:17', '2021-10-31 18:56:17'),
(154, 53, 'Half Return', NULL, '2021-10-31 18:56:33', '2021-10-31 18:56:33'),
(155, 53, 'Half Return', NULL, '2021-10-31 18:58:02', '2021-10-31 18:58:02'),
(156, 53, 'Half Return', NULL, '2021-10-31 18:58:59', '2021-10-31 18:58:59'),
(157, 54, 'Accepted', NULL, '2021-10-31 18:59:54', '2021-10-31 18:59:54'),
(158, 55, 'Accepted', NULL, '2021-10-31 18:59:57', '2021-10-31 18:59:57'),
(159, 54, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(160, 55, 'Assigned', 'Assigned to Sabbir Rahman (0183064338)', NULL, NULL),
(161, 55, 'Delivered', NULL, '2021-10-31 19:00:21', '2021-10-31 19:00:21'),
(162, 54, 'Pending', NULL, '2021-10-31 19:00:36', '2021-10-31 19:00:36');

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
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `collection_amount` double(8,2) NOT NULL,
  `total_delivery_charge` double(8,2) NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `surcharge` double(8,2) NOT NULL,
  `total_payable` double(8,2) NOT NULL,
  `total_parcel` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `merchant_id`, `collection_amount`, `total_delivery_charge`, `subtotal`, `surcharge`, `total_payable`, `total_parcel`, `created_at`, `updated_at`) VALUES
(8, 2, 800.00, 0.00, 800.00, 8.00, 792.00, 1, '2021-10-31 15:17:08', '2021-10-31 15:17:08');

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
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickup_requests`
--

CREATE TABLE `pickup_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` bigint(20) UNSIGNED NOT NULL,
  `total_parcel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rider_parcels`
--

CREATE TABLE `rider_parcels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rider_id` bigint(20) UNSIGNED NOT NULL,
  `collection_amount` double(8,2) NOT NULL,
  `total_parcel` int(11) NOT NULL,
  `delivered_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `returned_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `half_returned_amount` double(8,2) NOT NULL DEFAULT '0.00',
  `total_delivered` int(11) NOT NULL DEFAULT '0',
  `total_returned` int(11) NOT NULL DEFAULT '0',
  `total_half_returned` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rider_parcels`
--

INSERT INTO `rider_parcels` (`id`, `rider_id`, `collection_amount`, `total_parcel`, `delivered_amount`, `returned_amount`, `half_returned_amount`, `total_delivered`, `total_returned`, `total_half_returned`, `status`, `created_at`, `updated_at`) VALUES
(23, 3, 800.00, 1, 800.00, 0.00, 0.00, 1, 0, 0, 'Completed', '2021-10-31 15:15:38', '2021-10-31 15:16:06'),
(24, 3, 10.00, 1, 10.00, 0.00, 0.00, 1, 0, 0, 'Completed', '2021-10-31 17:27:05', '2021-10-31 17:27:25'),
(25, 3, 74.00, 2, 74.00, 0.00, 0.00, 2, 0, 0, 'Pending', '2021-10-31 18:33:01', '2021-10-31 18:34:58'),
(26, 3, 87.00, 2, 87.00, 0.00, 0.00, 2, 0, 0, 'Pending', '2021-10-31 18:36:24', '2021-10-31 18:37:16'),
(27, 3, 117.00, 2, 117.00, 0.00, 0.00, 2, 0, 0, 'Pending', '2021-10-31 18:38:40', '2021-10-31 18:44:16'),
(28, 3, 111.00, 2, 111.00, 0.00, 0.00, 2, 0, 0, 'Pending', '2021-10-31 18:38:53', '2021-10-31 18:39:18'),
(29, 3, 168.00, 2, 168.00, 0.00, 0.00, 2, 0, 0, 'Completed', '2021-10-31 18:48:31', '2021-10-31 18:49:15'),
(30, 3, 27.00, 2, 27.00, 0.00, 0.00, 2, 0, 0, 'Completed', '2021-10-31 18:48:40', '2021-10-31 18:50:39'),
(31, 3, 180.00, 2, 180.00, 0.00, 0.00, 2, 0, 0, 'Completed', '2021-10-31 18:51:34', '2021-10-31 18:52:31'),
(32, 3, 174.00, 2, 174.00, 0.00, 0.00, 2, 0, 0, 'Completed', '2021-10-31 18:53:36', '2021-10-31 18:54:19'),
(33, 3, 174.00, 3, 52.00, 79.00, 43.00, 1, 1, 1, 'Completed', '2021-10-31 18:55:57', '2021-10-31 18:58:59'),
(34, 3, 75.00, 1, 75.00, 0.00, 0.00, 1, 0, 0, 'Completed', '2021-10-31 19:00:06', '2021-10-31 19:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `business_name`, `title`, `email`, `phone`, `address`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Haor Courier', 'Best courier service in Bangladesh', NULL, '01767700090', 'Khilkhet, Dhaka-1229', 'logo/SXgBNtQmBwr9U88hLRsCyRuBEpZUCMLYlfHJvW0k.png', NULL, '2021-10-31 15:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `merchant_id`, `business_name`, `phone`, `pickup_location`, `created_at`, `updated_at`) VALUES
(1, 2, 'Rayn\'s', '01830964337', 'Mirpur', '2021-10-26 13:14:48', '2021-10-26 13:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'merchant',
  `balance` double(8,2) NOT NULL DEFAULT '0.00',
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `balance`, `business_name`, `pickup_location`, `present_address`, `permanent_address`, `image`, `status`, `reference`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '01830964337', 'admin', 0.00, '', '', NULL, NULL, 'user/kIt6pCdX2XiekPnPvvLaj038xbxIrjwQHQiYAVXG.jpg', 'active', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'ZNdIxsnnAjcx3pKnfHTWs4P7k5euZhOjqozfoboq5WRHSXoBtfmBG2t6XqLJ', NULL, '2021-10-31 15:08:14'),
(2, 'Merchant', 'merchant@gmail.com', '01928312500', 'merchant', -54.45, 'Merchant\'s Shop', 'East Kazipara, Mirpur, Dhaka', NULL, NULL, 'user/7T21pPVMHrAsS39ZOdSJg1VdJaoce5DsvJOTkLaU.jpg', 'active', NULL, NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'njUwf1r2WryIfg3QoZuDOjrrZsCBe9N2ZsZaE0cVUNYi2rPmPtpqIpD43Thj', NULL, '2021-10-31 19:00:21'),
(3, 'Sabbir Rahman', NULL, '0183064338', 'rider', 0.00, NULL, NULL, 'East Kazipara', 'Chatkhil, Noakhali', NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-27 15:27:31', '2021-10-31 04:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `withdrow_requests`
--

CREATE TABLE `withdrow_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `bank_account_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `merchant_balances`
--
ALTER TABLE `merchant_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merchant_balances_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcels`
--
ALTER TABLE `parcels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcels_merchant_id_foreign` (`merchant_id`),
  ADD KEY `parcels_rider_id_foreign` (`rider_id`),
  ADD KEY `parcels_payment_id_foreign` (`payment_id`),
  ADD KEY `parcels_rider_parcel_id_foreign` (`rider_parcel_id`);

--
-- Indexes for table `parcel_trackings`
--
ALTER TABLE `parcel_trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcel_trackings_parcel_id_foreign` (`parcel_id`);

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
  ADD KEY `payments_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pickup_requests`
--
ALTER TABLE `pickup_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pickup_requests_merchant_id_foreign` (`merchant_id`),
  ADD KEY `pickup_requests_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `rider_parcels`
--
ALTER TABLE `rider_parcels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rider_parcels_rider_id_foreign` (`rider_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shops_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `withdrow_requests`
--
ALTER TABLE `withdrow_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrow_requests_merchant_id_foreign` (`merchant_id`),
  ADD KEY `withdrow_requests_bank_account_id_foreign` (`bank_account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchant_balances`
--
ALTER TABLE `merchant_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `parcels`
--
ALTER TABLE `parcels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `parcel_trackings`
--
ALTER TABLE `parcel_trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pickup_requests`
--
ALTER TABLE `pickup_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rider_parcels`
--
ALTER TABLE `rider_parcels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `withdrow_requests`
--
ALTER TABLE `withdrow_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `bank_accounts_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `merchant_balances`
--
ALTER TABLE `merchant_balances`
  ADD CONSTRAINT `merchant_balances_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parcels`
--
ALTER TABLE `parcels`
  ADD CONSTRAINT `parcels_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parcels_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  ADD CONSTRAINT `parcels_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `parcels_rider_parcel_id_foreign` FOREIGN KEY (`rider_parcel_id`) REFERENCES `rider_parcels` (`id`);

--
-- Constraints for table `parcel_trackings`
--
ALTER TABLE `parcel_trackings`
  ADD CONSTRAINT `parcel_trackings_parcel_id_foreign` FOREIGN KEY (`parcel_id`) REFERENCES `parcels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pickup_requests`
--
ALTER TABLE `pickup_requests`
  ADD CONSTRAINT `pickup_requests_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pickup_requests_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rider_parcels`
--
ALTER TABLE `rider_parcels`
  ADD CONSTRAINT `rider_parcels_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrow_requests`
--
ALTER TABLE `withdrow_requests`
  ADD CONSTRAINT `withdrow_requests_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `withdrow_requests_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
