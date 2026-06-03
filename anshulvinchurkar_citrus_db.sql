-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2022 at 06:03 AM
-- Server version: 5.7.38-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anshulvinchurkar_citrus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `address_type` enum('billing','shipping') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address_type`, `alias`, `address_1`, `address_2`, `first_name`, `last_name`, `email`, `company_name`, `zip`, `state_code`, `city`, `province_id`, `country_id`, `customer_id`, `status`, `phone`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'billing', 'Home', 'delhi', 'delhi', 'Mikael', 'Brown', 'user@example.com', 'Adelbert Keeling', '123344', NULL, 'Alberta', 1, 110, 1, 1, '0987654321', NULL, '2021-06-20 09:17:53', '2021-09-29 08:09:50'),
(2, 'billing', 'Office', '8619 Nolan Junctions Suite 933', NULL, 'Gerard', 'Kemmer', 'chagenes@baumbach.com', 'Aaliyah Nicolas', '10001', NULL, 'British', 1, 38, 1, 1, '866.273.2137', NULL, '2021-06-20 09:17:54', '2021-06-20 09:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Size', '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(2, 'Color', '2021-06-20 09:17:54', '2021-06-20 09:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `value`, `attribute_id`, `created_at`, `updated_at`) VALUES
(1, 'small', 1, '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(2, 'medium', 1, '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(3, 'large', 1, '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(4, 'red', 2, '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(5, 'yellow', 2, '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(6, 'blue', 2, '2021-06-20 09:17:54', '2021-06-20 09:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_value_product_attribute`
--

CREATE TABLE `attribute_value_product_attribute` (
  `attribute_value_id` int(10) UNSIGNED NOT NULL,
  `product_attribute_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner_settings`
--

CREATE TABLE `banner_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_settings`
--

INSERT INTO `banner_settings` (`id`, `banner_image`, `title`, `subtitle`, `description`, `created_at`, `updated_at`) VALUES
(1, 'slide.png', 'Buying & Selling Has Changed', 'The World Has Changed', 'Supports Businesses so they can grow, expand, and reach a far wider audience\n                                Serves Customers by making shopping as quick and simple as it was always meant to', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, 'slide.png', 'Buying & Selling Has Changed', 'The World Has Changed', 'Supports Businesses so they can grow, expand, and reach a far wider audience\n                                Serves Customers by making shopping as quick and simple as it was always meant to', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(3, 'slide.png', 'Buying & Selling Has Changed', 'The World Has Changed', 'Supports Businesses so they can grow, expand, and reach a far wider audience\n                                Serves Customers by making shopping as quick and simple as it was always meant to', '2021-06-20 14:47:54', '2021-06-20 14:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Blog-1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 'blog1.jpg', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, 'Blog-2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 'blog2.jpg', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(3, 'Blog-3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 'blog3.jpg', '2021-06-20 14:47:54', '2021-06-20 14:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 'apple', NULL, '2021-06-20 09:17:54', '2021-06-20 09:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `business_type`
--

CREATE TABLE `business_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_type`
--

INSERT INTO `business_type` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Dry Cleaner', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, 'Restaurant and Fast Foods', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(3, 'Kiosk', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(4, 'Boutique', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(5, 'Bar + Wines and Spirits', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(6, 'Supermarket', '2021-09-22 10:36:23', '2021-09-22 10:36:23'),
(7, 'Information Technology Services', '2021-09-22 10:37:25', '2021-09-22 10:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_visible_main` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_lft` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `_rgt` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `is_visible_main`, `name`, `slug`, `description`, `cover`, `status`, `created_at`, `updated_at`, `_lft`, `_rgt`, `parent_id`, `created_by`, `updated_by`) VALUES
(1, 0, 'Men', 'men', 'Great Savings. Every Day. Shop from our Deal of the Day, Lightning Deals and avail other great offers', NULL, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53', 0, 0, 1, NULL, NULL),
(2, 0, 'Women', 'women', 'You will be able to find a wide selection of electronics from top brands. Shop for Mobile Phones, Tablets, Cameras, Televisions, Headphones, Speakers, Laptops, Computers & Accessories, Wearables, Office Products, Data Storage, Gaming accessories, Musical Instruments and much more at the best prices.', NULL, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53', 0, 0, 1, NULL, NULL),
(3, 0, 'Breakfast', 'breakfast', 'Given how powerful social media has become these days, everyone around the world wants to look their best at 0 times. Thus, the right clothing and accessories are almost always in demand. Good-quality shirts, T-shirts, trousers, jeans, shorts, tops, sarees, kurtis, lehenga, dresses, skirts, bra, innerwear, and more are some of the examples that people love and need to wear. Watches, earrings, rings, bracelets, chains, etc can accentuate the look of every outfit. Thus, it’s important to wear complementing accessories when you dress up in your finest.', NULL, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53', 0, 0, 2, NULL, NULL),
(4, 0, 'Drinks', 'drinks', 'Given how powerful social media has become these days, everyone around the world wants to look their best at 0 times. Thus, the right clothing and accessories are almost always in demand. Good-quality shirts, T-shirts, trousers, jeans, shorts, tops, sarees, kurtis, lehenga, dresses, skirts, bra, innerwear, and more are some of the examples that people love and need to wear. Watches, earrings, rings, bracelets, chains, etc can accentuate the look of every outfit. Thus, it’s important to wear complementing accessories when you dress up in your finest.', NULL, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53', 0, 0, 3, NULL, NULL),
(5, 0, 'Babies', 'babies', 'Given how powerful social media has become these days, everyone around the world wants to look their best at 0 times. Thus, the right clothing and accessories are almost always in demand. Good-quality shirts, T-shirts, trousers, jeans, shorts, tops, sarees, kurtis, lehenga, dresses, skirts, bra, innerwear, and more are some of the examples that people love and need to wear. Watches, earrings, rings, bracelets, chains, etc can accentuate the look of every outfit. Thus, it’s important to wear complementing accessories when you dress up in your finest.', NULL, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53', 0, 0, 4, NULL, NULL),
(6, 0, 'Lunch', 'lunch', NULL, NULL, 1, '2021-09-22 11:19:13', '2021-09-22 11:19:13', 0, 0, 2, 1, 1),
(7, 0, 'Dinner', 'dinner', NULL, NULL, 1, '2021-09-22 11:19:23', '2021-09-22 11:19:23', 0, 0, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `category_id`, `product_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 1, 3),
(4, 5, 4),
(5, 5, 5),
(6, 2, 6),
(7, 1, 7),
(8, 1, 8),
(9, 2, 9),
(10, 3, 10),
(11, 4, 11),
(12, 5, 12),
(13, 2, 13),
(14, 1, 14),
(15, 5, 16),
(16, 3, 17),
(17, 6, 18),
(18, 1, 19),
(19, 3, 20),
(20, 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `subject` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `subject`, `created_at`, `updated_at`) VALUES
(1, 'SEO X Press Digital Agency', 'no-replyMespere@gmail.com', 'Hello \r\n \r\nWe all know the importance that dofollow link have on any website`s ranks. \r\nHaving most of your linkbase filled with nofollow ones is of no good for your ranks and SEO metrics. \r\n \r\nBuy quality dofollow links from us, that will impact your ranks in a positive way \r\nhttps://www.digital-x-press.com/product/150-dofollow-backlinks/ \r\n \r\nBest regards \r\nMike Hoggarth\r\n \r\nsupport@digital-x-press.com', 'Get more dofollow backlinks for citrus.ke', '2021-08-27 23:11:06', '2021-08-27 23:11:06'),
(2, 'Gabriel Angelo', 'gafinan.cier@gmail.com', 'Dear Entrepreneur, \r\n \r\nI\'m Gabriel Angelo, My company can bridge funds for your new or ongoing business. do let me know when you receive this message for further procedure. \r\n \r\nWe also pay 1% commission to brokers and friends who introduce project owners for finance or other opportunities. \r\n \r\nYou can reach me directly using this email address: gabriel_angelo@nestalconsultants.com \r\n \r\nRegards, \r\nGabriel Angelo', 'Project/Business financing', '2021-08-28 04:25:50', '2021-08-28 04:25:50'),
(3, 'Mike Farmer', 'robertangeles7162@gmail.com', 'Hi there \r\n \r\nDo you want a quick boost in ranks and sales for your citrus.ke website? \r\nHaving a high DA score, always helps \r\n \r\nGet your citrus.ke to have a DA between 50 to 60 points in Moz with us today and rip the benefits of such a great feat. \r\n \r\nSee our offers here: \r\nhttps://www.monkeydigital.co/product/moz-da50-seo-plan/ \r\n \r\nNEW: \r\nhttps://www.monkeydigital.co/product/ahrefs-dr60/ \r\n \r\n \r\nthank you \r\nMike Farmer\r\n \r\nsupport@monkeydigital.co', 'Increase sales for citrus.ke', '2021-08-28 15:50:17', '2021-08-28 15:50:17'),
(4, 'ViciseTheaw', 'revers@o5o5.ru', '<a href=https://videnie.org/services/porcha/>снять порчу</a> \r\nTegs: таролог https://videnie.org/services/taro-videnie/ \r\n \r\n<u>гипнотерапевт</u> \r\n<i>гипнотерапевт москва</i> \r\n<b>денежная магия</b>', 'курсы астральной магии', '2021-08-29 10:26:47', '2021-08-29 10:26:47'),
(5, 'Mike Hoggarth', 'no-replyOxist@gmail.com', 'Hi \r\n \r\nWe will enhance your Local Ranks organically and safely, using only whitehat methods, while providing Google maps and website offsite work at the same time. \r\n \r\nPlease check our services below, we offer Local SEO at cheap rates. \r\nhttps://speed-seo.net/product/local-seo-package/ \r\n \r\nNEW: \r\nhttps://www.speed-seo.net/product/zip-codes-gmaps-citations/ \r\n \r\nregards \r\nMike Hoggarth\r\n \r\nSpeed SEO Digital Agency', 'Local SEO for more business', '2021-09-03 08:47:26', '2021-09-03 08:47:26'),
(6, 'TBcassTheaw', 'revers@o5o5.ru', '<a href=https://www.tc-bus.ru/autobusi/turisticheskie>купить туристический автобус</a> \r\nTegs: лиаз https://www.tc-bus.ru/liaz \r\n \r\n<u>паз автобус цена</u> \r\n<i>паз вектор</i> \r\n<b>паз вектор next</b>', 'паз вектор некст', '2021-09-05 14:28:12', '2021-09-05 14:28:12'),
(7, 'Mike Sykes', 'no-replyOxist@gmail.com', 'Hello \r\n \r\nI have just took a look on your SEO for  citrus.ke for its SEO Trend and saw that your website could use a push. \r\n \r\nWe will improve your SEO metrics and ranks organically and safely, using only whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nPlease check our plans here, we offer SEO at cheap rates. \r\nhttps://www.hilkom-digital.de/cheap-seo-packages/ \r\n \r\nStart increasing your sales and leads with us, today! \r\n \r\nregards \r\nMike Sykes\r\n \r\nHilkom Digital Team \r\nsupport@hilkom-digital.de', 'cheap monthly SEO plans', '2021-09-09 22:07:09', '2021-09-09 22:07:09'),
(8, 'WtcissTheaw', 'revers@o5o5.ru', '<a href=https://wtlan.ru/catalog/SHkafyWT/>шкаф напольный 19-дюймовый 42u ttb-4268-as-ral9004</a> \r\nTegs: серверный шкаф 19 напольный купить саратов https://wtlan.ru/catalog/SHkafyWT/ \r\n \r\n<u>шкаф телекоммуникационный 19 настенный купить</u> \r\n<i>шкаф 19 12u настенный стеклянная дверь</i> \r\n<b>шкаф настенный 19 15u 600x600 дверь металл серый ral 7035 cabeus sh-05f-15u60 60m</b>', 'шкаф настенный 19 6 юнитов 600х450 дверь металл lwr3-06u64-mf', '2021-09-10 15:03:32', '2021-09-10 15:03:32'),
(9, 'Advokatv4216', 'advokatvozvrat@rambler.ru', 'Проиграли деньги в казино? \r\nМы поможем их вернуть! Обращайтесь. \r\n \r\nhttps://is.gd/wvTsq6', 'Вернеи деньги проиграные в казино', '2021-09-23 04:38:08', '2021-09-23 04:38:08'),
(10, 'Mike Quincy', 'no-replyOxist@gmail.com', 'Hi there \r\n \r\nDo you want a quick boost in ranks and sales for your citrus.ke website? \r\nHaving a high DA score, always helps \r\n \r\nGet your citrus.ke to have a DA between 50 to 60 points in Moz with us today and reap the benefits of such a great feat. \r\n \r\nSee our offers here: \r\nhttps://www.monkeydigital.co/product/moz-da50-seo-plan/ \r\n \r\nNEW: \r\nhttps://www.monkeydigital.co/product/ahrefs-dr60/ \r\n \r\n \r\nthank you \r\nMike Quincy\r\n \r\nsupport@monkeydigital.co', 'Increase sales for citrus.ke', '2021-09-25 11:23:16', '2021-09-25 11:23:16'),
(11, 'TBcassTheaw', 'revers@o5o5.ru', '<a href=https://www.tc-bus.ru/liaz>купить автобус лиаз</a> \r\nTegs: купить автобус нефаз https://www.tc-bus.ru/nefaz \r\n \r\n<u>автобус лиаз 5292</u> \r\n<i>автобус нефаз</i> \r\n<b>автобус паз</b>', 'автобус ютонг', '2021-09-28 00:35:41', '2021-09-28 00:35:41'),
(12, 'Louisdug', 'hillameliavbnx84062@gmail.com', 'skdrlbsdjk37909453 \r\n \r\nmicrosoft word 2016 office product key free downloadwindows 10 keyboard and mouse not working at login screen free downloaddownload music windows 10download windows xp sp3 ptbr freemicrosoft windows 10 enterprise build 1809 free downloaddownload free drivers update for windows 10aerofly fs 2 free download pcmicrosoft office 2010 free download full version for windows 10 with crack free downloadasus lifeframe3 download windows 8 freewindows 10 bluetooth driver download for pc \r\nhttps://bit.ly/3jIFqmz\r\nhttps://bit.ly/3AtjxhY\r\nhttps://bit.ly/3CJabAP\r\nhttps://bit.ly/3izzEo9\r\nhttps://bit.ly/3Av85Cr\r\n \r\nwindows 8 download crack serial free\r\ndesktop wallpapers free download for windows 8 free\r\nintel hd graphics 630 driver download windows 10 64 bit\r\nlego island download windows 10\r\nfree online multiplayer shooting games for pc no download required', 'pci ven_14e4&dev_1692', '2021-09-28 13:26:21', '2021-09-28 13:26:21'),
(13, 'Hdcffflano', 'revers@o5o5.ru', '<a href=https://pomestie-park.com/bankety/timbilding/>организация тимбилдинга в москве</a> \r\nTegs: организация тимбилдинга на корпоративе https://pomestie-park.com/bankety/timbilding/ \r\n \r\n<u>свадебные банкеты москва</u> \r\n<i>корпоратив в ресторане</i> \r\n<b>банкет на свадьбу недорого</b>', 'банкет на свадьбу недорого в москве', '2021-09-29 00:30:27', '2021-09-29 00:30:27'),
(14, 'WtcissTheaw', 'revers@o5o5.ru', '<a href=https://wtlan.ru/catalog/SHkafyWT/Napolnyeshkafy/42U/1407/>шкаф 19 дюймов 42u сборка</a> \r\nTegs: шкаф 19 дюймов 42u цена https://wtlan.ru/catalog/SHkafyWT/Napolnyeshkafy/42U/shkaf-19-dyuymov-telekommunikatsionnyy-42u-servernyy-600kh600-seryy/ \r\n \r\n<u>шкаф 19 дюймов размер</u> \r\n<i>шкаф 19 дюймов размеры</i> \r\n<b>шкаф 19 дюймов размеры креплений</b>', 'шкаф 19 дюймов размеры юнита', '2021-09-29 07:31:34', '2021-09-29 07:31:34'),
(15, 'Mike Nathan', 'no-replyOxist@gmail.com', 'Good Day \r\n \r\nWe will enhance your Local Ranks organically and safely, using only whitehat methods, while providing Google maps and website offsite work at the same time. \r\n \r\nPlease check our pricelist here, we offer Local SEO at cheap rates. \r\nhttps://speed-seo.net/product/local-seo-package/ \r\n \r\nNEW: \r\nhttps://www.speed-seo.net/product/zip-codes-gmaps-citations/ \r\n \r\nregards \r\nMike Nathan\r\n \r\nSpeed SEO Digital Agency', 'Local SEO for more business', '2021-09-30 22:03:59', '2021-09-30 22:03:59'),
(16, 'GtcismTheaw', 'revers@o5o5.ru', '<a href=https://gmclinica.ru/uslugi/ginekologiya/>женская консультация гинеколог</a> \r\nTegs: женский гинеколог москва https://gmclinica.ru/uslugi/ginekologiya/ \r\n \r\n<u>плазмолифтинг для лица</u> \r\n<i>плазмолифтинг для лица в москве</i> \r\n<b>плазмолифтинг для лица цена</b>', 'плазмолифтинг для лица цена москва', '2021-10-04 05:07:16', '2021-10-04 05:07:16'),
(17, 'OifiszTheaw', 'revers@o5o5.ru', '<a href=https://office-dedamoroza.ru/>подарки от деда мороза</a> \r\nTegs: сладкие новогодние подарки https://office-dedamoroza.ru/ \r\n \r\n<u>новогодние подарки в сад</u> \r\n<i>новогодние подарки в школу</i> \r\n<b>новогодние сладкие подарки для детей</b>', 'новогодняя упаковка', '2021-10-05 16:04:33', '2021-10-05 16:04:33'),
(18, 'SdvillelinC', 'revers@o5o5.ru', '<a href=https://chimmed.ru/>дрг диагностицс </a> \r\nTegs: др маисч  https://chimmed.ru/  \r\n \r\n<u>Pharmaffiliates </u> \r\n<i>Phenomenex </i> \r\n<b>Phytoplant </b>', 'Pickering Laboratories', '2021-10-06 15:04:34', '2021-10-06 15:04:34'),
(19, 'Mike Forman', 'no-replyOxist@gmail.com', 'Hello \r\n \r\nWe all know the importance that dofollow link have on any website`s ranks. \r\nHaving most of your linkbase filled with nofollow ones is of no good for your ranks and SEO metrics. \r\n \r\nBuy quality dofollow links from us, that will impact your ranks in a positive way \r\nhttps://www.digital-x-press.com/product/150-dofollow-backlinks/ \r\n \r\nBest regards \r\nMike Forman\r\n \r\nsupport@digital-x-press.com', 'Get more dofollow backlinks for citrus.ke', '2021-10-07 17:41:06', '2021-10-07 17:41:06'),
(20, 'Mike Charlson', 'no-replyOxist@gmail.com', 'Hi \r\n \r\nI have just analyzed  citrus.ke for the ranking keywords and saw that your website could use an upgrade. \r\n \r\nWe will improve your SEO metrics and ranks organically and safely, using only whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nPlease check our pricelist here, we offer SEO at cheap rates. \r\nhttps://www.hilkom-digital.de/cheap-seo-packages/ \r\n \r\nStart enhancing your sales and leads with us, today! \r\n \r\nregards \r\nMike Charlson\r\n \r\nHilkom Digital Team \r\nsupport@hilkom-digital.de', 'cheap monthly SEO plans', '2021-10-07 21:47:55', '2021-10-07 21:47:55'),
(21, 'Ruggiero Len', 'stevenrobert261@gmail.com', 'We are a private financial management firm that specializes in securing financial assistance for start-up and large-sized businesses. \r\n \r\nWe are interested to provide you with financial funding for your business/project real estate and debt consolidation, The interest rate is moderate. \r\n \r\nKindly get back to me for more information if you are interested. (lending@epsglobal-llc.com) \r\n \r\nRegards. \r\nRuggiero Len \r\nEPS GLOBAL LLC', 'loan offer', '2021-10-11 22:06:06', '2021-10-11 22:06:06'),
(22, 'TecihnTheaw', 'revers@o5o5.ru', '<a href=https://xn--80aahhrmritp2ag.xn--p1ai/catalog/oborudovanie/frezerno_gravirovalnye_stanki_s_chpu/>фрезерно гравировальный станок</a> \r\nTegs: планшетный принтер https://xn--80aahhrmritp2ag.xn--p1ai/catalog/oborudovanie/shirokoformatnye_uv_uf_printery/planshetnye_uf_printery/ \r\n \r\n<u>фрезерно гравировальный станок</u> \r\n<i>планшетный принтер</i> \r\n<b>уф принтеры</b>', 'уф принтер', '2021-10-12 14:51:49', '2021-10-12 14:51:49'),
(23, 'Carlos Sano', 'sanocarlos96@gmail.com', 'Dear Business Owner \r\nI’m Carlos Sano \r\nI’m a business owner & Bitcoin enthusiast. \r\nI live in N. Y. city with my family. This is my \r\nFacebook: https://www.facebook.com/sano.bitcoin/ \r\nI am not a salesperson, I’m a problem solver. \r\nThe problem I seek to solve is double: \r\n1- The lack of cash flow caused by the Covid-19 \r\nrestrictions, and \r\n2- The broken financial system that we were born \r\ninto. \r\nBoth problems can be solved with what I want to share \r\nwith you today. \r\nYou see, now we have 2 financial systems on the planet: \r\n1- The legacy Financial System (inflationary) \r\n2- The Bitcoin & Blockchain Financial System (Deflationary) \r\nDid you hear that El Salvador adopted Bitcoin as legal tender? \r\nNext in line are: Panama, Brazil, Paraguay, Mexico, Argentina. \r\nI’m contacting you because I’m part of a blockchain Alliance \r\nwhere we can learn about bitcoin and blockchain and also get \r\ndaily crypto rewards that we can exchange for any crypto. \r\nI’d like to invite you to a Zoom presentation where you’ll \r\nbe able see with your own eyes how you can earn daily rewards \r\nand turn them into dollars. \r\nFor connecting with me you can call me or text me \r\nCarlos Sano \r\n917 six50 792five \r\nNew York City', 'If you\'re looking for a way to create more income, there\'s great news inside!', '2021-10-13 11:06:07', '2021-10-13 11:06:07'),
(24, 'Mike Galbraith', 'no-replyOxist@gmail.com', 'Hi there \r\n \r\nDo you want a quick boost in ranks and sales for your website? \r\nHaving a high DA score, always helps \r\n \r\nGet your citrus.ke to have a DA between 50 to 60 points in Moz with us today and reap the benefits of such a great feat. \r\n \r\nSee our offers here: \r\nhttps://www.strictlydigital.net/product/moz-da50-seo-plan/ \r\n \r\nOn SALE: \r\nhttps://www.strictlydigital.net/product/ahrefs-dr60/ \r\n \r\n \r\nThank you \r\nMike Galbraith', 'Strengthen your Domain Authority', '2021-10-23 04:27:33', '2021-10-23 04:27:33'),
(25, 'Miguel Angel', 'carlosalfredo0805@gmail.com', 'Hello: \r\nI am the founder of Miguel Angel Foundation and 2021 American power-ball winner. We wish to donate our bitcoin wallet containing 90.844 bitcoin, so that you can use it to develop yourself and your community. \r\ncontact: miguelangelfoundation@gmail.com', 'A mail for you', '2021-10-25 16:10:52', '2021-10-25 16:10:52'),
(26, 'Jason Ward', 'jasonward9681@gmail.com', 'Hello, \r\n \r\nOur company, RatingsKing, specializes in posting 5-star testimonials on all major review sites. This way people can find you much easier and get a good impression of your business. \r\nJust go on our website and choose the package that best fits your needs at https://ratingsking.com/packages.php \r\n \r\nOur packages start from $49/month. \r\nDepending on your package you will have a number of positive reviews that we will do for you. You will have reports monthly with the work that has been done in your account. \r\n \r\nUsually, we are posting on all major reviews sites or other listings you may have.', 'Posting positive reviews', '2021-10-26 18:35:53', '2021-10-26 18:35:53'),
(27, 'Mike Salomon', 'no-replyOxist@gmail.com', 'Good Day \r\n \r\nWe will enhance your Local Ranks organically and safely, using only whitehat methods, while providing Google maps and website offsite work at the same time. \r\n \r\nPlease check our services below, we offer Local SEO at cheap rates. \r\nhttps://speed-seo.net/product/local-seo-package/ \r\n \r\nNEW: \r\nhttps://www.speed-seo.net/product/zip-codes-gmaps-citations/ \r\n \r\nregards \r\nMike Salomon\r\n \r\nSpeed SEO Digital Agency', 'Local SEO for more business', '2021-10-27 00:35:54', '2021-10-27 00:35:54'),
(28, 'Jamesjax', 'no-replyMespere@gmail.com', 'Hi!  citrus.ke \r\n \r\nWe advance \r\n \r\nSending your business proposition through the Contact us form which can be found on the sites in the contact partition. Contact form are filled in by our software and the captcha is solved. The profit of this method is that messages sent through feedback forms are whitelisted. This method increases the chances that your message will be open. \r\n \r\nOur database contains more than 27 million sites around the world to which we can send your message. \r\n \r\nThe cost of one million messages 49 USD \r\n \r\nFREE TEST mailing Up to 50,000 messages. \r\n \r\n \r\nThis message is created automatically.  Use our contacts for communication. \r\n \r\nContact us. \r\nTelegram - @FeedbackMessages \r\nSkype  live:contactform_18 \r\nWhatsApp - +375259112693 \r\nWe only use chat.', 'The best advertising of your products and services!', '2021-11-03 04:13:52', '2021-11-03 04:13:52'),
(29, 'Mike Vaughan', 'no-replyOxist@gmail.com', 'Good Day \r\n \r\nI have just took an in depth look on your  citrus.ke for the ranking keywords and saw that your website could use a push. \r\n \r\nWe will enhance your SEO metrics and ranks organically and safely, using only whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nPlease check our services below, we offer SEO at cheap rates. \r\nhttps://www.hilkom-digital.de/cheap-seo-packages/ \r\n \r\nStart enhancing your sales and leads with us, today! \r\n \r\nregards \r\nMike Vaughan\r\n \r\nHilkom Digital Team \r\nsupport@hilkom-digital.de', 'quality monthly SEO plans', '2021-11-03 19:01:47', '2021-11-03 19:01:47'),
(30, 'David Song', 'noreply@googlemail.com', 'Hello, \r\nThis is a consultancy and brokerage Firm specializing in Growth Financial Loan and Equity Funding Investments. We specialize in investments in all Private and public sectors in a broad range of areas within our Financial Investment Services. We are experts in financial and operational management, due diligence and capital planning in all markets and industries. \r\nOur Investors wish to invest in any viable Project presented by your Management after reviews on your Business Project Presentation Plan. We look forward to your Swift response. \r\n \r\nRegards, \r\nMr. David Song \r\nEmail:davidsong2030@gmail.com', 'PROJECT FUNDING', '2021-11-07 00:31:51', '2021-11-07 00:31:51'),
(31, 'Mike King', 'no-replyOxist@gmail.com', 'Hello \r\n \r\nWe all know the importance that dofollow link have on any website`s ranks. \r\nHaving most of your linkbase filled with nofollow ones is of no good for your ranks and SEO metrics. \r\n \r\nBuy quality dofollow links from us, that will impact your ranks in a positive way \r\nhttps://www.digital-x-press.com/product/150-dofollow-backlinks/ \r\n \r\nBest regards \r\nMike King\r\n \r\nsupport@digital-x-press.com', 'Get more dofollow backlinks for citrus.ke', '2021-11-10 23:22:40', '2021-11-10 23:22:40'),
(32, 'David Holman', 'davidholman200@gmail.com', 'We are a Team of IT Experts specialized in the production of Real and Novelty Documents such as Passport, Driving License , IELTS Certificate,  NCLEX Certificate, ID Cards, Diplomas, SS Cards, University Certificates, Green Cards, Death Certificate, Working Permits, Visa\'s etc. Contact us on WhatsApp for more information +49 1590 2969018. or Email us at... documentsservicesexperts@gmail.com', 'Express Documents Services', '2021-11-13 06:27:41', '2021-11-13 06:27:41'),
(33, 'CharlesBug', 'georgiyfrolov1999364yfi+ak@bk.ru', 'citrus.ke gbuihswdiwyfuwhdiwfbujdaodhwifwjdaqidhwufwudjqvbcnxsiwdui \r\nFuckYouNigger - MyProfile: https://www.youtube.com/channel/UCu6eeygUz2BY0xLDSlMKK-Q/featured', 'Test, just a test', '2021-11-14 07:08:52', '2021-11-14 07:08:52'),
(34, 'RobertKib', 'phdnegroid@thephdfiles.com', 'Wordpress comes with default permalink structures which are set to Plain. These default \r\nstructures are not SEO friendly that\'s why there is need to customize your website permalinks to \r\nPosttype. \r\nThe reason why these Plain permalink structures are not good for SEO is because this links don\'t \r\nhave the post or page text directed to them. \r\nA Plain WordPress permalink looks like this \r\n \r\nhttp://example.com/?p=58 \r\n \r\nThough search engines like Google understand the language structured to these plain permalinks and can still index \r\nthem,   Posttype permalinks give the best results to Search Engines.', 'The safest method to clear broken and dead links for your website', '2021-11-15 10:07:48', '2021-11-15 10:07:48'),
(35, 'Mike Dean', 'no-replyOxist@gmail.com', 'Hi there \r\n \r\nDo you want a quick boost in ranks and sales for your website? \r\nHaving a high DA score, always helps \r\n \r\nGet your citrus.ke to have a DA between 50 to 60 points in Moz with us today and reap the benefits of such a great feat. \r\n \r\nSee our offers here: \r\nhttps://www.strictlydigital.net/product/moz-da50-seo-plan/ \r\n \r\nOn SALE: \r\nhttps://www.strictlydigital.net/product/ahrefs-dr60/ \r\n \r\n \r\nThank you \r\nMike Dean', 'Strengthen your Domain Authority', '2021-11-20 08:25:13', '2021-11-20 08:25:13'),
(36, 'Mike Oldridge', 'no-replyOxist@gmail.com', 'Hello \r\n \r\nWe will improve your Local Ranks organically and safely, using only whitehat methods, while providing Google maps and website offsite work at the same time. \r\n \r\nPlease check our plans here, we offer Local SEO at cheap rates. \r\nhttps://speed-seo.net/product/local-seo-package/ \r\n \r\nNEW: \r\nhttps://www.speed-seo.net/product/zip-codes-gmaps-citations/ \r\n \r\nregards \r\nMike Oldridge\r\n \r\nSpeed SEO Digital Agency', 'Local SEO for more business', '2021-11-26 16:10:12', '2021-11-26 16:10:12'),
(37, 'Roberts Zuluf', 'rfzuluf@gmail.com', 'Hi \r\nHow are you? I wanted to reach out to you and verify that email was a good way to reach you or We can discuss this via the telephone,WhatsApp only. +90 555 140 8097 or contact@frzuluf.com \r\nI count in your honor for a quick response for a good deal. \r\nRegards, \r\nRoberts Zuluf', 'Trying to Reach you', '2021-11-27 00:47:43', '2021-11-27 00:47:43'),
(38, 'Marcusbab', 'dominik12-mueller@web.de', 'Blockchain recommends to all people who are interested in additional permanent passive income of $ 5000 per day with a cryptocurrency trading robot. \r\nhttps://www.google.com/url?q=https%3A%2F%2Fvk.cc%2Fc8qvzi&sa=D&60=39&usg=AFQjCNH2QAwQV6sbS1u0SgHiVXKZSKhcKQ \r\nA trading robot is capable of making from 750% to 15000% profit per day !*** \r\nhttps://www.google.com/url?q=https%3A%2F%2Fvk.cc%2Fc8qvzi&sa=D&70=94&usg=AFQjCNH2QAwQV6sbS1u0SgHiVXKZSKhcKQ \r\nThis success was achieved thanks to the advanced developments in the field of artificial intelligence №(%+ \r\nTens of thousands of people around the world are already using this trading robot, so start you :$!$ \r\nhttps://www.google.com/url?q=https%3A%2F%2Fvk.cc%2Fc8qvzi&sa=D&18=77&usg=AFQjCNH2QAwQV6sbS1u0SgHiVXKZSKhcKQ \r\nTo start, you need to do just three things: \r\n1. Make a deposit to your brokerage account from $ 500 \"@%) \r\n2. Launch the trading robot \"&:% \r\n3. Receive passive income from $ 5000 per day :=%_ \r\nhttps://www.google.com/url?q=https%3A%2F%2Fvk.cc%2Fc8qvzi&sa=D&30=66&usg=AFQjCNH2QAwQV6sbS1u0SgHiVXKZSKhcKQ', 'Blockchain: The most profitable trading robot or income from $ 5000 per day )=%$', '2021-12-01 19:00:46', '2021-12-01 19:00:46'),
(39, 'Susan Johnson', 'fairwaypaymarketing@gmail.com', 'Hello \r\n \r\nMy main objective here, is to help you increase revenue for your business by providing Social Media Marketing for 1 WEEK FREE, then just $67 a month. \r\n \r\nTo learn more: WATCH OUR VIDEO https://bit.ly/lsh67offer \r\n \r\nOur specialist in Facebook, Instagram, LinkedIn and Twitter has a singular purpose and that is to drive more sales for your business, so that you will be our customer for life. \r\n \r\nThis 1 WEEK FREE promotion is for this week only. So, if you want to get this deal before the deadline, click the link below. \r\n \r\nTo learn more: WATCH OUR VIDEO https://bit.ly/lsh67offer \r\n \r\nBest, \r\n \r\nSusan Johnson', 'I have a quick question', '2021-12-02 01:08:32', '2021-12-02 01:08:32'),
(40, 'anil', 'test@gmail.com', 'testuimng', 'tewst', '2021-12-02 04:41:57', '2021-12-02 04:41:57'),
(41, 'anil', 'anlsharma424@gmail.com', 'testuimng', 'tewst', '2021-12-02 04:42:53', '2021-12-02 04:42:53'),
(42, 'Anil', 'anlsharma424@gmail.com', 'jgfhgvhj', 'TGHtresthj', '2021-12-02 04:43:47', '2021-12-02 04:43:47'),
(43, 'Mike Bush', 'no-replyOxist@gmail.com', 'Good Day \r\n \r\nI have just analyzed  citrus.ke for its SEO metrics and saw that your website could use an upgrade. \r\n \r\nWe will enhance your SEO metrics and ranks organically and safely, using only whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nPlease check our services below, we offer SEO at cheap rates. \r\nhttps://www.hilkom-digital.de/cheap-seo-packages/ \r\n \r\nStart increasing your sales and leads with us, today! \r\n \r\n \r\nregards \r\nMike Bush\r\n \r\nHilkom Digital Team \r\nsupport@hilkom-digital.de', 'quality monthly SEO plans', '2021-12-03 02:48:47', '2021-12-03 02:48:47'),
(44, 'Jason Vanell', 'alittlebitcrypto@gmail.com', 'I had a look through your site and notice there are no crypto options for your business... \r\n \r\nCryptocurrency is now mainstream. Websites and businesses that accept crypto will have more success in the future. \r\n \r\nI help businesses turn their website crypto-friendly, and help guide new businesses entering the crypto-sphere, including payments. \r\n \r\nWe have just several spots available for free, and I would love for you to join, for tips and guides on everything crypto-related. \r\n \r\nVisit BitsYield.com \r\n \r\nBelow are two picks for interesting crypto projects that we like (NFA/DYOR): \r\n \r\nLarge Cap Pick - https://cosmos.network/ \r\nThis is an awesome, undervalued project. Leagues above Ethereum when it comes to technical sophistication. \r\n \r\nSmall Cap Pick - https://metabit.gentokens.com/ \r\nTitled \"Bitcoin for the Metaverse-era\". Have you wanted to get into a project super early? This one is a small-cap project with a lot of ambition. Buy MetaBit on Pancakeswap: https://bit.ly/3rCYtUV \r\n \r\nJason Vanell', 'Your website and crypto.', '2021-12-07 01:28:30', '2021-12-07 01:28:30'),
(45, 'Mike Carrington', 'no-replyOxist@gmail.com', 'Hello \r\n \r\nWe all know the importance that dofollow link have on any website`s ranks. \r\nHaving most of your linkbase filled with nofollow ones is of no good for your ranks and SEO metrics. \r\n \r\nBuy quality dofollow links from us, that will impact your ranks in a positive way \r\nhttps://www.digital-x-press.com/product/150-dofollow-backlinks/ \r\n \r\nBest regards \r\nMike Carrington\r\n \r\nsupport@digital-x-press.com', 'Get more dofollow backlinks for citrus.ke', '2021-12-08 22:43:29', '2021-12-08 22:43:29'),
(46, 'Seymourunoda', 'm.a.kempeneers@kpnplanet.nl', 'Passive income from $ 5969 per day >>>>>>>>>>>>>>>>>>>>>>>>>>> https://www.google.com/url?q=https%3A%2F%2Fvk.cc%2Fc8Prmu&sa=D&58=88&usg=AFQjCNH_EGwAiiB8MpWHxZlE1C27oj3Rvw <<<<<<<<<<<<<<<<<<<<<<<<', 'Register, press one button and get passive income from $ 9596 in a day', '2021-12-13 01:51:14', '2021-12-13 01:51:14'),
(47, 'navdeep sen', 'senavdeep89@outlook.com', 'Test', 'test', '2021-12-14 06:56:32', '2021-12-14 06:56:32'),
(48, 'DaltonLASER', 'mooregracehgvl36530@gmail.com', 'Hello. And Bye. \r\nhttps://zootovaryvsem.org/ \r\nhttps://sites.google.com/view/dsj1alsy7d', 'dfdg234dsfsd', '2021-12-15 17:16:49', '2021-12-15 17:16:49'),
(49, 'Mike White', 'no-replyOxist@gmail.com', 'Howdy \r\n \r\nDo you want a quick boost in ranks and sales for your website? \r\nHaving a high DA score, always helps \r\n \r\nApply this -35% code ( MEGAPROMOTER ) while getting your citrus.ke to have a DA above 60 points in Moz with us today and reap the benefits of such a great feat at an affordable rate. \r\n \r\n \r\n \r\nSee our offers here: \r\nhttps://www.strictlydigital.net/product/moz-da50-seo-plan/ \r\nhttps://www.strictlydigital.net/product/moz-da60-seo-plan/ \r\n \r\nNEW: ahrefs DR70 is now possible: \r\nhttps://www.strictlydigital.net/product/ahrefs-seo-plan/ \r\n \r\n \r\nThank you \r\nMike White\r\n \r\nmike@strictlydigital.net', 'DA60+ for citrus.ke with -35%', '2021-12-15 23:48:10', '2021-12-15 23:48:10'),
(50, 'JAMES COOK', 'james_cook78@yahoo.com', 'Dear sir/ma \r\nWe are a finance and investment company offering loans at 3% interest rate. We will be happy to make a loan available to your organisation for your project. Our terms and conditions will apply. Our term sheet/loan agreement will be sent to you for review, when we hear from you. Please reply to this email ONLY cookj5939@gmail.com \r\n \r\nRegards. \r\nJames Cook \r\nChairman & CEO Euro Finance & Commercial Ltd', 'Loan @ 3%', '2021-12-21 11:23:37', '2021-12-21 11:23:37'),
(51, 'Mike Morrison', 'no-replyOxist@gmail.com', 'Good Day \r\n \r\nWe will increase your Local Ranks organically and safely, using only whitehat methods, while providing Google maps and website offsite work at the same time. \r\n \r\nPlease check our pricelist here, we offer Local SEO at cheap rates. \r\nhttps://speed-seo.net/product/local-seo-package/ \r\n \r\nNEW: \r\nhttps://www.speed-seo.net/product/zip-codes-gmaps-citations/ \r\n \r\nregards \r\nMike Morrison\r\n \r\nSpeed SEO Digital Agency', 'Local SEO for more business', '2021-12-23 17:55:22', '2021-12-23 17:55:22'),
(52, 'Marc Rouxson', 'no-replyMespere@gmail.com', 'Good day!  citrus.ke \r\n \r\nWe make offer for you \r\n \r\nSending your message through the feedback form which can be found on the sites in the Communication partition. Feedback forms are filled in by our application and the captcha is solved. The profit of this method is that messages sent through feedback forms are whitelisted. This method improve the probability that your message will be read. \r\n \r\nOur database contains more than 27 million sites around the world to which we can send your message. \r\n \r\nThe cost of one million messages 49 USD \r\n \r\nFREE TEST mailing Up to 50,000 messages. \r\n \r\n \r\nThis offer is created automatically.  Use our contacts for communication. \r\n \r\nContact us. \r\nTelegram - @FeedbackMessages \r\nSkype  live:contactform_18 \r\nWhatsApp - +375259112693 \r\nWe only use chat.', 'Do you want cheap and innovative advertising for little money?', '2021-12-26 23:40:13', '2021-12-26 23:40:13'),
(53, 'Natapleax', 'woodthighgire1988@gmail.com', 'Hello handsome! Mature brunette Arina extremely sweet cum, write to her https://localchicks3.com/?u=41nkd08&o=8dhpkzk', 'Hello Admin!', '2021-12-30 09:41:34', '2021-12-30 09:41:34'),
(54, 'Lucas Persson', 'linkedbusiness65@gmail.com', 'We are glad to introduce you to LinkusBiz LLC. Our services support and grow Businesses. We\'re the  Business Lead Generation Company. Across continents, we link Interest that makes Businesses go Borderless, Pandemic free and  always active. \r\n \r\nWe merge Corporate  leads for Business Partnerships and Trade development. Increase your Business revenue and contacts in 2022 through our network. \r\n \r\nLet\'s onboard your Business into a Global network by signing up for any of our services at http://www.linkusbiz.com/ Follow us on Instagram @linkusbiz \r\n \r\nThe Network Team, \r\nLinkusbiz LLC.', 'Collaborate your Business goals in 2022.', '2021-12-30 16:46:13', '2021-12-30 16:46:13'),
(55, 'Mike Russel', 'no-replyOxist@gmail.com', 'Greetings \r\n \r\nI have just checked  citrus.ke for  the current search visibility and saw that your website could use a push. \r\n \r\nWe will enhance your SEO metrics and ranks organically and safely, using only whitehat methods, while providing monthly reports and outstanding support. \r\n \r\nPlease check our services below, we offer SEO at cheap rates. \r\nhttps://www.hilkom-digital.de/cheap-seo-packages/ \r\n \r\nStart enhancing your sales and leads with us, today! \r\n \r\n \r\nregards \r\nMike Russel\r\n \r\nHilkom Digital Team \r\nsupport@hilkom-digital.de', 'cheap monthly SEO plans', '2022-01-01 03:28:33', '2022-01-01 03:28:33'),
(56, 'Mike Flannagan', 'no-replyOxist@gmail.com', 'Hello \r\n \r\nWe all know the importance that dofollow link have on any website`s ranks. \r\nHaving most of your linkbase filled with nofollow ones is of no good for your ranks and SEO metrics. \r\n \r\nBuy quality dofollow links from us, that will impact your ranks in a positive way \r\nhttps://www.digital-x-press.com/product/150-dofollow-backlinks/ \r\n \r\nBest regards \r\nMike Flannagan\r\n \r\nsupport@digital-x-press.com', 'Get more dofollow backlinks for citrus.ke', '2022-01-03 11:10:39', '2022-01-03 11:10:39'),
(57, 'Marty Tierney', 'livestaffinghub@gmail.com', 'Hello \r\n \r\nHello, My name is Marty and I’m a video marketing expert.  My main objective here, is to help increase revenue for you by producing 2D Animated Videos to generate leads and sales for your business 24/7, for just $499. \r\n \r\nThe offer is only good for this week, so get your video before the deadline. \r\n \r\nWatch Our Video Now!  https://bit.ly/499VideoOffer \r\n \r\nImagine, for 1 Low Affordable rate you get 2 CUSTOM VIDEOS that will bring home the bacon for the New Year! \r\n \r\nI know this is crazy, so Don’t Miss Out!!! \r\n \r\nI’m in, show me THE DETAILS!   https://bit.ly/499VideoOffer \r\n \r\nBest, \r\n \r\nMarty Tierney \r\nDigital Expert & Video Producer', 'Here you go', '2022-01-04 21:15:31', '2022-01-04 21:15:31'),
(58, 'Mike Taft', 'no-replyOxist@gmail.com', 'Hi \r\n \r\nIf you\'ll ever need a permanent increase in your website\'s Domain Authority score, We can help. \r\n \r\nMore info: \r\nhttps://www.strictlydigital.net/product/moz-da50-seo-plan/ \r\n \r\n \r\nThank you \r\nMike Taft\r\n \r\nmike@strictlydigital.net', 'Increase sales for citrus.ke', '2022-01-12 08:25:49', '2022-01-12 08:25:49'),
(59, 'Kevin Johnson', 'tbformleads@gmail.com', 'Hello \r\n \r\nMy main objective here, is to help increase revenue for you by producing an animated video that will generate leads and sales for your business 24/7, for just $97. \r\n \r\nBut this offer is only good this week, so get your video before the deadline. \r\n \r\nWatch Our Video Now!  https://bit.ly/Xpress97offer \r\n \r\nFor less than you spend on coffee each month you get an American Owned Video company that can write your script, create your story board, lay-in a good soundtrack and produce an awesome video that brings home the bacon. \r\n \r\nAgain, this $97 promotion is for this week only. Don’t miss out!!! \r\n \r\nI’m in, show me what you got.  https://bit.ly/Xpress97offer \r\n \r\nBest, \r\n \r\nKevin Johnson \r\nBusiness Development Manager', 'Hope your open to this', '2022-01-18 04:48:51', '2022-01-18 04:48:51'),
(60, 'Mike Barnes', 'no-replyOxist@gmail.com', 'Hello, \r\n \r\nThere is a new Boss in town. Semrush started dominating the SEO tools for some time already. So, why not get yourself backlinks that Semrush says are good, right? \r\n \r\nIn this plan, get backlinks that Semrush says are coming from quality domains, Domains which are having 5000+ ranking keywords \r\n \r\nMore info: \r\nhttps://www.seo-treff.de/product/semrush-backlinks/ \r\n \r\n \r\nThank you \r\nMike Barnes\r\n \r\nsupport@seo-treff.de', 'SEMRUSH', '2022-01-19 01:46:28', '2022-01-19 01:46:28'),
(61, 'Anil', 'info@clubcodetechnology.com', 'testing', 'test', '2022-02-11 15:55:56', '2022-02-11 15:55:56'),
(62, 'Thomas Kraynik', 'autoreply@ddmmarketing.ro', 'Hi there, \r\nAfter analyzing your business\'s online presence, we identified some key growth opportunities. \r\nWe can develop these points and provide you our data and market intelligence report analysis on your specific niche. \r\nMy company helps businesses like yours to grow and disrupt the market. \r\nBest of all, we handle all the IT and marketing implementations, making it extremely simple for you. \r\nSo, if you are interested in learning more about how we can help you get more clients and grow your brand let me know what your calendar looks like. \r\nBest, \r\nThomas Kraynik | SVP \r\nDigital Disruptive Marketing \r\nThe new way of outsourced marketing \r\nEmail: thomas@ddm.marketing \r\nhttps://ddm.marketing', 'Hoping to help you out | Digital Disruptive Marketing', '2022-02-12 08:23:13', '2022-02-12 08:23:13'),
(63, 'Mike Ward', 'no-replyOxist@gmail.com', 'Howdy \r\n \r\nIf you\'ll ever need a permanent increase in your website\'s Domain Authority score, We can help. \r\n \r\nMore info: \r\nhttps://www.strictlydigital.net/product/moz-da50-seo-plan/ \r\n \r\nNEW: Ahrefs DR70 plan: \r\nhttps://www.strictlydigital.net/product/ahrefs-seo-plan/ \r\n \r\n \r\nThank you \r\nMike Ward\r\n \r\nmike@strictlydigital.net', 'Increase sales for citrus.ke', '2022-02-12 09:44:44', '2022-02-12 09:44:44'),
(64, 'Mike Clapton', 'no-replyOxist@gmail.com', 'Negative SEO attack Services. Deindex bad competitors from Google. It works with any Website, video, blog, product or service. \r\nhttps://www.seo-treff.de/product/derank-seo-service/', 'Competitors not playing the SEO game fair?', '2022-02-14 11:12:16', '2022-02-14 11:12:16'),
(65, 'Kevin Johnson', 'tbformleads@gmail.com', 'Hello \r\n \r\nI just wanted to reach out to you and see if you would be open to getting an animated explainer video that can generate leads and sales for your business 24/7, for just $97. \r\n \r\nBut this offer is only good this week, for the first 20 clients, so you need to order now, before you miss out.  Our normal cost for this video is $497 so get your video before the deadline. \r\n \r\nWatch Our Video Now That Explains Our Great Offer  (  https://bit.ly/Xpress97offer  ). \r\n \r\nFor less than you spend on coffee each month, you get an American Owned Video company that can write your script, create your story board, lay-in a good soundtrack and produce an awesome video that brings home the bacon. \r\n \r\nAgain, this $97 promotion is for this week only. Don’t miss out!!! The normal price is $497, so today you are saving $400. \r\n \r\n \r\nI’m in, show me how I can increase sales  (  https://bit.ly/Xpress97offer  ) \r\n \r\nBest, \r\n \r\nKevin Johnson \r\nBusiness Development Manager', 'Quick question', '2022-02-16 19:27:10', '2022-02-16 19:27:10'),
(66, 'SdvillelinC', 'revers@o5o5.ru', '<a href=https://dezstation.com/dezinfekciya-kvartiry/>дезинфекция насекомых dezstation </a> \r\nTegs: дезинфекция квартиры от клопов dezstation  https://dezstation.com/dezinfekciya-ot-klopov/  \r\n \r\n<u>обработка от короеда dezstation.com </u> \r\n<i>уничтожение борщевика dezstation.com </i> \r\n<b>дезинфекция москва dezstation.com </b>', 'акарицидная обработка dezstation.com', '2022-02-18 02:58:21', '2022-02-18 02:58:21'),
(67, 'Mike Saunder', 'no-replyOxist@gmail.com', 'Hi there \r\n \r\nWe will increase your Local Ranks organically and safely, using only whitehat methods, while providing Google maps and website offsite work at the same time. \r\n \r\nPlease check our pricelist here, we offer Local SEO at cheap rates. \r\nhttps://speed-seo.net/product/local-seo-package/ \r\n \r\nNEW: \r\nhttps://www.speed-seo.net/product/zip-codes-gmaps-citations/ \r\n \r\nregards \r\nMike Saunder\r\n \r\nSpeed SEO Digital Agency', 'Local SEO for more business', '2022-02-18 14:19:44', '2022-02-18 14:19:44'),
(68, 'Aariz Yaseen', 'greytownfl@gmail.com', 'Dear Sir/Madam, \r\n \r\nWe have an investor for medium and large scale projects financing from \r\nUSD 5 Billions and above. \r\n \r\nRepayment plan: Choose between 15 to 20 years. \r\nInterest rates: 2% per year. \r\nMoratorium period: 4 years. \r\n \r\nWe are ready to help you resolve all your financial needs. \r\nReply: aarilyaseen@gmail.com \r\n \r\nYours Sincerely. \r\nAariz Yaseen.', 'Funds for long term lease.', '2022-02-21 20:40:36', '2022-02-21 20:40:36'),
(69, 'Zlatinanop', 'elegantiamarketing1@gmail.com', 'Hello, \r\nI came across your website and I fell in love with your brand! My name is Zlatina and I am blogger & social media expert based in Miami. I noticed that your brand has the potential to attract much more engagement and new customers through social media platforms. Thanks to the effective strategy I have developed, I have helped more than 150 brands to increase their sales, followers, and brand awareness. I would love to manage your social media accounts and grow your presence on the platforms, if interested. The packages I currently offer are: 1) Instagram account management (25 posts; 25 stories) – $600 per month. 2) Management of 3 social media accounts (Pinterest, Instagram, Facebook, Tiktok or Twitter - 25 posts on each account) - $950 per month. If you are interested, please email me at laelegantiacollab@hotmail.com, and I will send you my media kit, where you can find a ‘before’ and ‘after’ of accounts I manage and the results you can expect from the service. \r\nBest wishes, Zlatina', 'Social Media Account Management For Your Brand', '2022-02-21 22:55:37', '2022-02-21 22:55:37'),
(70, 'Daniel Todercan', 'support@newlightdigital.com.hubspot-inbox.com', 'Hi there, \r\n \r\nI am reaching out to see if you\'re interested in starting an ad campaign or improving the performance of an existing campaign on platforms like Google Ads, Bing Ads, Facebook Ads, and more by using PPC (Pay-Per-Click)? \r\n \r\nI am an expert in online advertising, and I will provide guaranteed traffic to your site, which can have a huge impact on your sales. Let me know if you\'re interested. \r\n \r\nThanks, \r\nDaniel \r\n \r\n \r\n-- \r\n \r\nDaniel Todercan \r\nOwner, New Light Digital \r\nOur website: https://bit.ly/3tjh2N4 \r\nMy phone number: 917-744-9170', 'Triple your sales in 6 months using Google Ads', '2022-02-28 21:30:23', '2022-02-28 21:30:23'),
(71, 'Marty Tierney', 'livestaffinghub@gmail.com', 'Hello, My name is Marty.  I want to help you get more leads and traffic to your website by sending out TWO Million B2B emails for your company, so you can increase your revenues! \r\n \r\nMy current offer is $799 per month for 2 Million Emails, SEO and Social Media Activities, worth over $1800.00. \r\n \r\nThe offer is only good for this week, so check this offer out before the deadline expires. \r\n \r\nWATCH OUR VIDEO FOR DETAILS HERE (  https://bit.ly/799TrafficPackage  ) \r\n \r\nBest, \r\n \r\nMarty Tierney \r\nDigital Marketing Expert', 'Your Best Year Ever Is Here', '2022-03-05 16:32:47', '2022-03-05 16:32:47'),
(72, 'Kevin Johnson', 'tbformleads@gmail.com', 'Hello \r\n \r\nDo you want to increase sales for your business 24/7? \r\n \r\nThen you might want to get an Animated Explainer Video that you can put on your website, post on social media and send out to potential clients in an email. \r\n \r\nAnd today we have slashed our price from $497 to just $97. So, you are saving $400 when you order this week. \r\n \r\nBut this offer is only good this week, for the first 20 clients, so you need to order now, before you miss out. \r\n \r\nClick Here Now To Watch Our Video About Our Great Offer (  https://bit.ly/Xpress97offer  ) \r\n \r\nFor less than you spend on coffee each month, you get an American Owned Video company that can write your script, create your story board, lay-in a good soundtrack and produce an awesome video that brings home the bacon. \r\n \r\nDid you know: \r\n \r\n•	64% of customers are more likely to buy a product online after watching a video about it... \r\n•	Putting videos on landing pages and websites can increase conversion rates by 80%... \r\n•	92% of people who watch videos share them with other people... \r\nAgain, this $97 promotion is for this week only. Don’t miss out!!! The normal price is $497, so today you are saving $400. Get your video today before the 20 discounted video slots are gone. \r\n \r\nClick Here Now And Claim Your $97 Video  (  https://bit.ly/Xpress97offer  ) \r\n \r\nBest, \r\n \r\nKevin Johnson \r\nBusiness Development Manager', 'Quick question', '2022-03-06 00:58:53', '2022-03-06 00:58:53'),
(73, 'Kevin Johnson', 'tbformleads@gmail.com', 'Hello \r\nDo you want to increase sales for your business 24/7? \r\nThen you might want to get an Animated Explainer Video that you can put on your website, post on social media and send out to potential clients in an email. \r\nAnd today we have slashed our price from $497 to just $97. So, you are saving $400 when you order this week. \r\nBut this offer is only good this week, for the first 20 clients, so you need to order now, before you miss out. \r\nClick Here Now To Watch Our Video About Our Great Offer  (  https://bit.ly/Xpress97offer  ) \r\nFor less than you spend on coffee each month, you get an American Owned Video company that can write your script, create your story board, lay-in a good soundtrack and produce an awesome video that brings home the bacon. \r\nDid you know: \r\n \r\n•	64% of customers are more likely to buy a product online after watching a video about it... \r\n•	Putting videos on landing pages and websites can increase conversion rates by 80%... \r\n•	92% of people who watch videos share them with other people... \r\nAgain, this $97 promotion is for this week only. Don’t miss out!!! The normal price is $497, so today you are saving $400. Get your video today before the 20 discounted video slots are gone. \r\nClick Here Now And Claim Your $97 Video (  https://bit.ly/Xpress97offer  ) \r\nBest, \r\nKevin Johnson \r\nBusiness Development Manager', 'Quick question', '2022-03-14 17:31:30', '2022-03-14 17:31:30'),
(74, 'Christian Djurit', 'zummkke@icloud.com', 'We provide funding  through our venture company to both startups and existing businesses either looking for expansion or to accelerate their company growth. \r\nWe have a structured joint venture investment plan in which we are interested in an annual return on investment not more than 10% ROI. We are also currently structuring a convertible debt and loan financing of 3% interest repayable annually with no early prepayment penalties. \r\nEmail:chris.djurit@alconmcl.com \r\nChristian Djurit \r\nDirector/Investment Head \r\nAlcon Management Company LTD UK.', 'Business Reply', '2022-03-17 07:38:48', '2022-03-17 07:38:48'),
(75, 'ElenaOwern', 'leve.juli12@gmail.com', 'Install the application and enjoy life: https://2track.info/gdQJ', 'Help the Ukrainians', '2022-03-23 22:10:25', '2022-03-23 22:10:25'),
(76, 'Duncan Smith', '5rdhp2fe29yb@beconfidential.com', 'Dear Sir/Madam \r\n \r\nYou can only achieve financial freedom when you create multiple streams of income. \r\n \r\nI have an investment portfolio that will benefit both of us and I hope it will be appealing to you. \r\n \r\nIf interested contact me for more information via my E-mail: smithduncan610@gmail.com \r\n \r\nI look forward to your quick reply. \r\n \r\nRegards \r\nDuncan Smith', 'Investment Portfolio', '2022-04-09 03:49:47', '2022-04-09 03:49:47'),
(77, 'MichaelFleta', 'beeonthetop.com@gmail.com', 'Buy Followers, Likes and Views \r\n \r\nGet Thousands of Followers, Likes, Views and more for all you social media channels. \r\nInstagram, Facebook, Tiktok and more.. \r\n \r\nBoost your sales, and get more leads. \r\nhttps://www.beeonthetop.com', 'Buy Followers, Likes and Views', '2022-04-11 15:28:51', '2022-04-11 15:28:51'),
(78, 'Henrysog', 'lovjanea@aol.com', 'The fastest way to make you wallet thick is here. \r\nhttps://profit-gold-strategy.life/?u=bdlkd0x&o=x7t8nng', 'Only one click can grow up your money really fast.', '2022-04-17 20:13:49', '2022-04-17 20:13:49'),
(79, 'Daniel', 'support@newlightdigital.com.hubspot-inbox.com', 'Hi there, \r\n \r\nI am reaching out to see if you\'re interested in starting an ad campaign or improving the performance of an existing campaign on platforms like Google Ads, Bing Ads, Facebook Ads, and more by using PPC (Pay-Per-Click)? \r\n \r\nI am an expert in online advertising, and I will provide guaranteed traffic to your site, which can have a huge impact on your sales. Let me know if you\'re interested. \r\n \r\nThanks, \r\nDaniel \r\n \r\n \r\n-- \r\n \r\nDaniel Todercan \r\nOwner, New Light Digital \r\nOur website: https://bit.ly/3tjh2N4 \r\nMy phone number: 917-744-9170', 'Triple your sales in 6 months using Google Ads', '2022-04-20 19:56:35', '2022-04-20 19:56:35'),
(80, 'Henrysog', 'privatept89@gmail.com', 'Check out the new financial tool, which can make you rich. \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'Need cash? Launch this robot and see what it can.', '2022-04-21 14:12:49', '2022-04-21 14:12:49'),
(81, 'Henrysog', 'robertborjal@yahoo.com', 'Watch your money grow while you invest with the Robot. \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'Trust the financial Bot to become rich.', '2022-04-21 19:34:15', '2022-04-21 19:34:15'),
(82, 'Henrysog', 'iwanismail@yahoo.com', 'Financial Robot is #1 investment tool ever. Launch it! \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'Wow! This is a fastest way for a financial independence.', '2022-04-22 00:55:15', '2022-04-22 00:55:15'),
(83, 'Henrysog', '6y24rg185@good007.net', 'Online job can be really effective if you use this Robot. \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'We know how to make our future rich and do you?', '2022-04-22 06:35:15', '2022-04-22 06:35:15'),
(84, 'Henrysog', 'pink_jen@hotmail.com', 'Make thousands every week working online here. \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'Trust your dollar to the Robot and see how it grows to $100.', '2022-04-22 12:50:08', '2022-04-22 12:50:08'),
(85, 'Henrysog', 'alouloudakis@gmail.com', 'Making money can be extremely easy if you use this Robot. \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'Attention! Financial robot may bring you millions!', '2022-04-22 20:07:47', '2022-04-22 20:07:47'),
(86, 'Henrysog', 'bubbly2539@yahoo.com', 'Try out the automatic robot to keep earning all day long. \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'Everyone can earn as much as he wants now.', '2022-04-23 01:50:23', '2022-04-23 01:50:23'),
(87, 'Henrysog', 'kaciyoungblood@yahoo.com', 'Online Bot will bring you wealth and satisfaction. \r\nhttps://get-profitshere.life/?u=bdlkd0x&o=x7t8nng', 'Financial independence is what this robot guarantees.', '2022-04-23 07:42:09', '2022-04-23 07:42:09'),
(88, 'Henrysog', 'bestintheworld8473@gmail.com', 'The success formula is found. Learn more about it. https://take-profitnow.life/?u=bdlkd0x&o=x7t8nng', 'Looking for additional money? Try out the best financial instrument.', '2022-04-23 19:21:37', '2022-04-23 19:21:37'),
(89, 'Henrysog', 'saw_kan_149@hotmail.com', 'Start making thousands of dollars every week just using this robot. https://take-profitnow.life/?u=bdlkd0x&o=x7t8nng', 'Try out the best financial robot in the Internet.', '2022-04-24 00:55:10', '2022-04-24 00:55:10');
INSERT INTO `contact` (`id`, `name`, `email`, `message`, `subject`, `created_at`, `updated_at`) VALUES
(90, 'Henrysog', 'menababi@yahoo.com', 'Wow! This is a fastest way for a financial independence. https://take-profitnow.life/?u=bdlkd0x&o=x7t8nng', 'Let the financial Robot be your companion in the financial market.', '2022-04-24 06:24:02', '2022-04-24 06:24:02'),
(91, 'Henrysog', 'tj8744@yahoo.com', 'Making money can be extremely easy if you use this Robot. https://take-profitnow.life/?u=bdlkd0x&o=x7t8nng', 'No need to work anymore while you have the Robot launched!', '2022-04-24 12:17:36', '2022-04-24 12:17:36'),
(92, 'Henrysog', 'alr13jdk@aol.com', '# 1 financial expert in the net! Check out the new Robot. https://take-profitnow.life/?u=bdlkd0x&o=x7t8nng', 'One dollar is nothing, but it can grow into $100 here.', '2022-04-24 18:07:20', '2022-04-24 18:07:20'),
(93, 'Henrysog', 'soaringboy455@hotmail.com', 'Looking for additional money? Try out the best financial instrument. https://take-profitnow.life/?u=bdlkd0x&o=x7t8nng', 'Most successful people already use Robot. Do you?', '2022-04-25 10:51:05', '2022-04-25 10:51:05'),
(94, 'Henrysog', 'adlinlatina@hotmail.com', 'The online income is your key to success. https://breweriana.it/gotodate/promo', 'Most successful people already use Robot. Do you?', '2022-04-25 17:04:44', '2022-04-25 17:04:44'),
(95, 'Henrysog', 'gemma323@hotmail.com', 'Even a child knows how to make $100 today. https://breweriana.it/gotodate/promo', 'Everyone can earn as much as he wants suing this Bot.', '2022-04-25 23:13:26', '2022-04-25 23:13:26'),
(96, 'Henrysog', 'jhmonseur@comcast.net', 'Need money? The financial robot is your solution. https://breweriana.it/gotodate/promo', 'Learn how to make hundreds of backs each day.', '2022-04-26 05:16:48', '2022-04-26 05:16:48'),
(97, 'Henrysog', 'amanda91977@yahoo.com', 'We know how to increase your financial stability. https://breweriana.it/gotodate/promo', 'Online Bot will bring you wealth and satisfaction.', '2022-04-26 11:07:18', '2022-04-26 11:07:18'),
(98, 'Henrysog', 'marco.gogg@gmail.com', 'Join the society of successful people who make money here. https://breweriana.it/gotodate/promo', 'Make your money work for you all day long.', '2022-04-26 17:08:01', '2022-04-26 17:08:01'),
(99, 'Henrysog', 'rhodeislandmale@hotmail.com', 'Only one click can grow up your money really fast. https://breweriana.it/gotodate/promo', 'Robot is the best way for everyone who looks for financial independence.', '2022-04-26 22:57:00', '2022-04-26 22:57:00'),
(100, 'Henrysog', 'jacknjinx@hotmail.com', 'Your computer can bring you additional income if you use this Robot. https://breweriana.it/gotodate/promo', 'We know how to become rich and do you?', '2022-04-27 04:34:13', '2022-04-27 04:34:13'),
(101, 'Henrysog', 'meganhall5@aol.com', 'This robot can bring you money 24/7. https://2f-2f.de/gotodate/promo', 'Launch the robot and let it bring you money.', '2022-04-27 10:16:06', '2022-04-27 10:16:06'),
(102, 'Henrysog', 'mustang3669@yahoo.com', 'The financial Robot works for you even when you sleep. https://2f-2f.de/gotodate/promo', 'The financial Robot is your # 1 expert of making money.', '2022-04-27 16:22:01', '2022-04-27 16:22:01'),
(103, 'Henrysog', 'ali.eljerrari14@outlook.com', 'Launch the best investment instrument to start making money today. https://2f-2f.de/gotodate/promo', 'One dollar is nothing, but it can grow into $100 here.', '2022-04-27 22:07:56', '2022-04-27 22:07:56'),
(104, 'Henrysog', 'iyjire903663@hotmail.com', 'The best online job for retirees. Make your old ages rich. https://2f-2f.de/gotodate/promo', 'Launch the financial Robot and do your business.', '2022-04-28 04:18:28', '2022-04-28 04:18:28'),
(105, 'Henrysog', 'johnvasanth36@yahoo.com', 'Online earnings are the easiest way for financial independence. https://2f-2f.de/gotodate/promo', 'Have no financial skills? Let Robot make money for you.', '2022-04-28 10:27:59', '2022-04-28 10:27:59'),
(106, 'Duncan Smith', '5rdhp2fe29yb@beconfidential.com', 'Dear Sir/Madam \r\n \r\nYou can only achieve financial freedom when you create multiple streams of income. \r\n \r\nI have an investment portfolio that will benefit both of us and I hope it will be appealing to you. \r\n \r\nIf interested contact me for more information via my E-mail: smithduncan610@gmail.com \r\n \r\nI look forward to your quick reply. \r\n \r\nRegards \r\nDuncan Smith', 'Investment Portfolio', '2022-04-28 12:04:17', '2022-04-28 12:04:17'),
(107, 'Henrysog', 'vassil.sabev@gmail.com', 'Everyone can earn as much as he wants now. https://2f-2f.de/gotodate/promo', 'Launch the robot and let it bring you money.', '2022-04-28 16:30:44', '2022-04-28 16:30:44'),
(108, 'Henrysog', 'kalpeshsakunde05@gmail.com', 'Make your computer to be you earning instrument. https://2f-2f.de/gotodate/promo', 'Invest $1 today to make $1000 tomorrow.', '2022-04-28 22:24:15', '2022-04-28 22:24:15'),
(109, 'Henrysog', 'iburise@yahoo.com', 'Even a child knows how to make money. Do you? https://2f-2f.de/gotodate/promo', 'Buy everything you want earning money online.', '2022-04-29 04:22:38', '2022-04-29 04:22:38'),
(110, 'Henrysog', 'sabinou@gmail.com', 'Everyone can earn as much as he wants suing this Bot. https://2f-2f.de/gotodate/promo', 'Make thousands of bucks. Financial robot will help you to do it!', '2022-04-29 10:30:44', '2022-04-29 10:30:44'),
(111, 'Henrysog', 'egtecdbyexd@thisisnotmyrealemail.com', 'Launch the financial Robot and do your business. https://2f-2f.de/gotodate/promo', 'Financial robot is a great way to manage and increase your income.', '2022-04-29 16:33:53', '2022-04-29 16:33:53'),
(112, 'Henrysog', 'opadwi@mannbdinfo.org', 'Earning money in the Internet is easy if you use Robot. https://2f-2f.de/gotodate/promo', 'The online income is the easiest ways to make you dream come true.', '2022-04-29 22:12:20', '2022-04-29 22:12:20'),
(113, 'SdvillelinC', 'revers@o5o5.ru', '<a href=https://chimmed.ru/>nomura chemical co., ltd </a> \r\nTegs: nordmann global  https://chimmed.ru/  \r\n \r\n<u>aristabiologicals </u> \r\n<i>aristabiologicals com </i> \r\n<b>aristabiologicals.com </b>', 'ashland', '2022-04-30 00:33:03', '2022-04-30 00:33:03'),
(114, 'Henrysog', 'peterlindecke@hotmail.com', 'Make dollars staying at home and launched this Bot. https://2f-2f.de/gotodate/promo', 'Have no money? It’s easy to earn them online here.', '2022-04-30 03:55:34', '2022-04-30 03:55:34'),
(115, 'Henrysog', 'tenmobasabad2@sunsetbayland.com', '# 1 financial expert in the net! Check out the new Robot. https://2f-2f.de/gotodate/promo', 'Make money in the internet using this Bot. It really works!', '2022-04-30 09:53:28', '2022-04-30 09:53:28'),
(116, 'Henrysog', 'sushilganpati@gmail.com', 'Automatic robot is the best start for financial independence. https://2f-2f.de/gotodate/promo', 'Try out the best financial robot in the Internet.', '2022-04-30 16:14:16', '2022-04-30 16:14:16'),
(117, 'Henrysog', 'misslauren13@yahoo.com', 'Make dollars staying at home and launched this Bot. https://2f-2f.de/gotodate/promo', 'Small investments can bring tons of dollars fast.', '2022-04-30 22:06:01', '2022-04-30 22:06:01'),
(118, 'Henrysog', 'kngonzo@yahoo.com', 'One dollar is nothing, but it can grow into $100 here. https://2f-2f.de/gotodate/promo', 'Financial robot keeps bringing you money while you sleep.', '2022-05-01 03:54:20', '2022-05-01 03:54:20'),
(119, 'Henrysog', 'pralipolane@yahoo.com', 'Make money in the internet using this Bot. It really works! https://2f-2f.de/gotodate/promo', 'Let the Robot bring you money while you rest.', '2022-05-01 09:40:46', '2022-05-01 09:40:46'),
(120, 'Henrysog', 'karenansel@comcast.net', 'Start making thousands of dollars every week just using this robot. https://2f-2f.de/gotodate/promo', 'Financial Robot is #1 investment tool ever. Launch it!', '2022-05-01 15:53:24', '2022-05-01 15:53:24'),
(121, 'Henrysog', 'liljazzie12@yahoo.com', 'This robot will help you to make hundreds of dollars each day. https://2f-2f.de/gotodate/promo', 'Launch the best investment instrument to start making money today.', '2022-05-01 21:59:38', '2022-05-01 21:59:38'),
(122, 'Henrysog', 'sarasafdari@yahoo.com', 'Try out the best financial robot in the Internet. https://2f-2f.de/gotodate/promo', 'Financial robot guarantees everyone stability and income.', '2022-05-02 04:02:18', '2022-05-02 04:02:18'),
(123, 'Henrysog', 'warlocklichking@yahoo.com', 'Turn $1 into $100 instantly. Use the financial Robot. https://2f-2f.de/gotodate/promo', 'Everyone who needs money should try this Robot out.', '2022-05-02 09:59:25', '2022-05-02 09:59:25'),
(124, 'Henrysog', 'shinodarely@yahoo.com', 'Make your money work for you all day long. https://2f-2f.de/gotodate/promo', 'Financial independence is what everyone needs.', '2022-05-02 16:03:47', '2022-05-02 16:03:47'),
(125, 'Henrysog', 'ktlotter@comcast.net', 'Make your computer to be you earning instrument. https://2f-2f.de/gotodate/promo', 'Turn $1 into $100 instantly. Use the financial Robot.', '2022-05-02 22:07:10', '2022-05-02 22:07:10'),
(126, 'Henrysog', 'ljohnson1@satx.rr.com', 'Feel free to buy everything you want with the additional income. https://2f-2f.de/gotodate/promo', 'Trust your dollar to the Robot and see how it grows to $100.', '2022-05-03 04:10:30', '2022-05-03 04:10:30'),
(127, 'Ryan Hart', 'ryanhartvideos@gmail.com', 'Hey… \r\n \r\nDo you want to increase sales for your business 24/7? \r\n \r\nIf so, you have to grab people’s attention quickly. And there’s nothing like a catchy explainer video to do the trick! \r\n \r\nI have an exclusive offer available for the first 20 people that act on this message today, but you must act fast. \r\n \r\nWhile you would normally pay as much as $600, or probably even $1,000, for a single 60-second video, I am providing the same service and giving you TWO VIDEOS for only $147. That’s right, less than $75 per video, which is unheard of! \r\n \r\nYou can order now at: https://bit.ly/two-video-promo-1    (  https://bit.ly/two-video-promo-1   ) \r\n \r\nNot sure if you caught it, but this offer is only good this week, for the first 20 clients, so you need to order now, before you miss out. \r\n \r\nAgain, this $147 promotion is for TWO VIDEOS and is for this week only. Don’t miss out!!! The normal price of this exclusive package is $1,135, so you are saving $938. \r\n \r\nClick Here Now To Watch The Animated Video That We Created To Explain It All \r\n---> https://bit.ly/two-video-promo-1  (   https://bit.ly/two-video-promo-1   ) \r\n \r\nSee you at the movies, \r\n \r\nRyan Hart \r\nXpress Animation', 'Quick question', '2022-05-03 05:12:47', '2022-05-03 05:12:47'),
(128, 'Henrysog', 'kristin088@gmail.com', 'Have no money? It’s easy to earn them online here. https://2f-2f.de/gotodate/promo', 'Launch the robot and let it bring you money.', '2022-05-03 10:45:00', '2022-05-03 10:45:00'),
(129, 'Henrysog', 'melrose3434@yahoo.com', 'Financial robot is the best companion of rich people. https://2f-2f.de/gotodate/promo', 'The online income is your key to success.', '2022-05-03 17:06:50', '2022-05-03 17:06:50'),
(130, 'Henrysog', 'jonatan.lundevall@hotmail.com', 'Make money, not war! Financial Robot is what you need. https://2f-2f.de/gotodate/promo', 'No need to work anymore. Just launch the robot.', '2022-05-03 23:17:33', '2022-05-03 23:17:33'),
(131, 'Henrysog', 'hannielee.tejada@yahoo.com', 'The financial Robot is your # 1 expert of making money. https://2f-2f.de/gotodate/promo', 'Small investments can bring tons of dollars fast.', '2022-05-04 04:57:30', '2022-05-04 04:57:30'),
(132, 'Henrysog', 'traditionshc@sbcglobal.net', 'No need to work anymore. Just launch the robot. https://sog.187sued.de/gotodate/promo', 'Everyone can earn as much as he wants suing this Bot.', '2022-05-04 10:52:13', '2022-05-04 10:52:13'),
(133, 'Henrysog', 'mxzlxmq@aol.com', 'We have found the fastest way to be rich. Find it out here. https://sog.187sued.de/gotodate/promo', 'One click of the robot can bring you thousands of bucks.', '2022-05-04 17:05:17', '2022-05-04 17:05:17'),
(134, 'Henrysog', 'misz.fresh@yahoo.com', 'Even a child knows how to make $100 today. https://sog.187sued.de/gotodate/promo', 'There is no need to look for a job anymore. Work online.', '2022-05-04 22:44:59', '2022-05-04 22:44:59'),
(135, 'Henrysog', 'sparkyhm@aol.com', 'Have no money? Earn it online. https://sog.187sued.de/gotodate/promo', 'Find out about the fastest way for a financial independence.', '2022-05-05 04:22:52', '2022-05-05 04:22:52'),
(136, 'Henrysog', 'minjeongkang77@hotmail.com', 'The online income is the easiest ways to make you dream come true. https://sog.187sued.de/gotodate/promo', 'One dollar is nothing, but it can grow into $100 here.', '2022-05-05 10:25:48', '2022-05-05 10:25:48'),
(137, 'Henrysog', 'steventran58@gmail.com', 'Buy everything you want earning money online. https://sog.187sued.de/gotodate/promo', 'Launch the robot and let it bring you money.', '2022-05-05 16:42:32', '2022-05-05 16:42:32'),
(138, 'Henrysog', 'marristl7777@gmail.com', 'Rich people are rich because they use this robot. https://sog.187sued.de/gotodate/promo', 'Financial independence is what this robot guarantees.', '2022-05-05 22:52:10', '2022-05-05 22:52:10'),
(139, 'Henrysog', 'deeabahmed@yahoo.com', 'Thousands of bucks are guaranteed if you use this robot. https://sog.187sued.de/gotodate/promo', 'Invest $1 today to make $1000 tomorrow.', '2022-05-06 04:48:24', '2022-05-06 04:48:24'),
(140, 'Henrysog', 'rogergrenier@comcast.net', 'The financial Robot works for you even when you sleep. https://sog.187sued.de/gotodate/promo', 'The financial Robot is your # 1 expert of making money.', '2022-05-06 10:55:31', '2022-05-06 10:55:31'),
(141, 'Henrysog', 'labattisti@live.com', 'Make your money work for you all day long. https://sog.187sued.de/gotodate/promo', 'We know how to increase your financial stability.', '2022-05-06 16:39:04', '2022-05-06 16:39:04'),
(142, 'Henrysog', 'savanahfenley@gmail.com', 'Find out about the fastest way for a financial independence. https://sog.187sued.de/gotodate/promo', 'Watch your money grow while you invest with the Robot.', '2022-05-06 22:08:19', '2022-05-06 22:08:19'),
(143, 'Henrysog', 'zamier0708@yahoo.com', 'Additional income is now available for anyone all around the world. https://sog.187sued.de/gotodate/promo', 'See how Robot makes $1000 from $1 of investment.', '2022-05-07 03:41:53', '2022-05-07 03:41:53'),
(144, 'Henrysog', 'keturahmckenzie2013@comcast.net', 'Financial robot guarantees everyone stability and income. https://sog.187sued.de/gotodate/promo', 'No worries if you are fired. Work online.', '2022-05-07 09:29:42', '2022-05-07 09:29:42'),
(145, 'Henrysog', 'kadigakoutaine@gmail.com', 'The financial Robot works for you even when you sleep. https://sog.187sued.de/gotodate/promo', 'Attention! Financial robot may bring you millions!', '2022-05-07 15:26:22', '2022-05-07 15:26:22'),
(146, 'Henrysog', 'ephemeralrandomk@yahoo.com', 'No need to work anymore while you have the Robot launched! https://sog.187sued.de/gotodate/promo', 'Money, money! Make more money with financial robot!', '2022-05-07 21:04:15', '2022-05-07 21:04:15'),
(147, 'Henrysog', 'zlxkexuoq@xe2g.com', 'Join the society of successful people who make money here. https://sog.187sued.de/gotodate/promo', 'Automatic robot is the best start for financial independence.', '2022-05-08 02:42:00', '2022-05-08 02:42:00'),
(148, 'Henrysog', 'ubvautie@sina.com', 'Try out the best financial robot in the Internet. https://sog.187sued.de/gotodate/promo', 'Financial robot keeps bringing you money while you sleep.', '2022-05-08 08:11:16', '2022-05-08 08:11:16'),
(149, 'Henrysog', 'mic.01884@us.stores.mcd.com', 'Everyone can earn as much as he wants now. https://sog.187sued.de/gotodate/promo', 'Even a child knows how to make $100 today.', '2022-05-08 19:28:22', '2022-05-08 19:28:22'),
(150, 'Henrysog', 'irgustafsonribrakafq@dew.com', 'Financial robot is your success formula is found. Learn more about it. https://sog.187sued.de/gotodate/promo', 'One dollar is nothing, but it can grow into $100 here.', '2022-05-09 01:19:40', '2022-05-09 01:19:40'),
(151, 'Henrysog', 'jenhorsmon@gmail.com', '# 1 financial expert in the net! Check out the new Robot. https://sog.187sued.de/gotodate/promo', 'Try out the best financial robot in the Internet.', '2022-05-09 07:09:52', '2022-05-09 07:09:52'),
(152, 'Henrysog', 'jkass314-kk@yahoo.com', 'Robot is the best way for everyone who looks for financial independence. https://sog.187sued.de/gotodate/promo', 'The financial Robot is the most effective financial tool in the net!', '2022-05-09 13:06:11', '2022-05-09 13:06:11'),
(153, 'Henrysog', 'tonyt1000+vuqriawcd29298@gmail.com', 'Your money work even when you sleep. https://sog.187sued.de/gotodate/promo', 'Make dollars just sitting home.', '2022-05-09 18:57:18', '2022-05-09 18:57:18'),
(154, 'Henrysog', 'ptown222@yahoo.com', 'No need to worry about the future if your use this financial robot. https://sog.187sued.de/gotodate/promo', 'Even a child knows how to make $100 today.', '2022-05-10 00:39:13', '2022-05-10 00:39:13'),
(155, 'Henrysog', 'jasmina.blantin@raymondjames.com', 'Let the financial Robot be your companion in the financial market. https://sog.187sued.de/gotodate/promo', 'Make dollars staying at home and launched this Bot.', '2022-05-10 06:09:33', '2022-05-10 06:09:33'),
(156, 'Henrysog', 'darkidronor@gmail.com', 'This robot will help you to make hundreds of dollars each day. https://sog.187sued.de/gotodate/promo', 'Financial robot keeps bringing you money while you sleep.', '2022-05-10 12:16:21', '2022-05-10 12:16:21'),
(157, 'Henrysog', 'staci.beitle@yahoo.com', 'Wow! This is a fastest way for a financial independence. https://sog.187sued.de/gotodate/promo', 'The online financial Robot is your key to success.', '2022-05-10 18:08:02', '2022-05-10 18:08:02'),
(158, 'Henrysog', 'lozmoslove@gmail.com', 'Need money? Get it here easily! Just press this to launch the robot. https://sog.187sued.de/gotodate/promo', 'Looking for additional money? Try out the best financial instrument.', '2022-05-10 23:40:50', '2022-05-10 23:40:50'),
(159, 'Henrysog', 'ragh3321@gmail.com', 'We have found the fastest way to be rich. Find it out here. https://sog.187sued.de/gotodate/promo', 'Looking forward for income? Get it online.', '2022-05-11 05:29:50', '2022-05-11 05:29:50'),
(160, 'Henrysog', 'jfwfbyiz@anonemailbox.com', 'Money, money! Make more money with financial robot! https://sog.187sued.de/gotodate/promo', 'Check out the automatic Bot, which works for you 24/7.', '2022-05-11 10:38:22', '2022-05-11 10:38:22'),
(161, 'Henrysog', 'beckymorrone@aol.com', 'Join the society of successful people who make money here. https://sog.187sued.de/gotodate/promo', 'The online financial Robot is your key to success.', '2022-05-11 15:45:09', '2022-05-11 15:45:09'),
(162, 'Henrysog', 'bkanarick@sapient.com', 'Make thousands every week working online here. https://sog.187sued.de/gotodate/promo', 'Launch the best investment instrument to start making money today.', '2022-05-11 17:35:20', '2022-05-11 17:35:20'),
(163, 'Henrysog', 'raneea@hotmail.com', 'Make dollars staying at home and launched this Bot. https://sog.187sued.de/gotodate/promo', 'Launch the best investment instrument to start making money today.', '2022-05-11 22:45:21', '2022-05-11 22:45:21'),
(164, 'Henrysog', 'Edijah_Fulcher@yahoo.com', 'Need money? Get it here easily? https://sog.187sued.de/gotodate/promo', 'Need money? Get it here easily! Just press this to launch the robot.', '2022-05-12 03:53:07', '2022-05-12 03:53:07'),
(165, 'Henrysog', 'nikola_irishstory@yahoo.com', 'See how Robot makes $1000 from $1 of investment. https://sog.187sued.de/gotodate/promo', 'Online Bot will bring you wealth and satisfaction.', '2022-05-12 09:02:12', '2022-05-12 09:02:12'),
(166, 'Henrysog', 'gregory_poynter@yahoo.com', 'Thousands of bucks are guaranteed if you use this robot. https://sog.187sued.de/gotodate/promo', 'Financial robot is your success formula is found. Learn more about it.', '2022-05-12 14:28:45', '2022-05-12 14:28:45'),
(167, 'Henrysog', 'sunadda_12@hotmil.com', 'One dollar is nothing, but it can grow into $100 here. https://sog.187sued.de/gotodate/promo', 'Find out about the fastest way for a financial independence.', '2022-05-12 19:35:12', '2022-05-12 19:35:12'),
(168, 'Henrysog', 'mmjones1021@gmail.com', 'Attention! Here you can earn money online! https://sog.187sued.de/gotodate/promo', 'Robot is the best solution for everyone who wants to earn.', '2022-05-13 00:48:59', '2022-05-13 00:48:59'),
(169, 'Henrysog', 'happyfather_1231@yahoo.com', 'Every your dollar can turn into $100 after you lunch this Robot. https://sog.187sued.de/gotodate/promo', 'No need to work anymore while you have the Robot launched!', '2022-05-13 05:59:30', '2022-05-13 05:59:30'),
(170, 'Henrysog', 'lily_onakurama@yahoo.com', 'Making money in the net is easier now. https://sog.187sued.de/gotodate/promo', 'Trust your dollar to the Robot and see how it grows to $100.', '2022-05-13 11:08:36', '2022-05-13 11:08:36'),
(171, 'Henrysog', 'ichiemeka@yahoo.com', 'Have no money? It’s easy to earn them online here. https://sog.187sued.de/gotodate/promo', 'Join the society of successful people who make money here.', '2022-05-13 16:20:04', '2022-05-13 16:20:04'),
(172, 'Henrysog', 'rebbecca110@hotmail.com', 'Launch the financial Bot now to start earning. https://sog.187sued.de/gotodate/promo', 'Financial independence is what this robot guarantees.', '2022-05-13 21:27:29', '2022-05-13 21:27:29'),
(173, 'Henrysog', 'krystalknndy@yahoo.com', 'Robot is the best way for everyone who looks for financial independence. https://sog.187sued.de/gotodate/promo', 'Make your money work for you all day long.', '2022-05-14 02:37:27', '2022-05-14 02:37:27'),
(174, 'Henrysog', 'madelynkoch@gmail.com', 'Make $1000 from $1 in a few minutes. Launch the financial robot now. https://sog.187sued.de/gotodate/promo', 'Financial robot guarantees everyone stability and income.', '2022-05-14 07:46:13', '2022-05-14 07:46:13'),
(175, 'Henrysog', 'menegazzo.luigir@gmail.com', 'Learn how to make hundreds of backs each day. https://sog.187sued.de/gotodate/promo', 'We know how to make our future rich and do you?', '2022-05-14 13:17:51', '2022-05-14 13:17:51'),
(176, 'Henrysog', 'joy235derljordan@gmail.com', 'No need to work anymore while you have the Robot launched! https://sog.187sued.de/gotodate/promo', 'Provide your family with the money in age. Launch the Robot!', '2022-05-14 18:45:07', '2022-05-14 18:45:07'),
(177, 'Henrysog', 'hirschihuskies97@gmail.com', 'The financial Robot is your future wealth and independence. https://sog.187sued.de/gotodate/promo', 'Financial robot keeps bringing you money while you sleep.', '2022-05-14 23:53:21', '2022-05-14 23:53:21'),
(178, 'Henrysog', 'reghouse63@yahoo.com', 'Wow! This is a fastest way for a financial independence. https://sog.187sued.de/gotodate/promo', 'Even a child knows how to make $100 today with the help of this robot.', '2022-05-15 05:00:21', '2022-05-15 05:00:21'),
(179, 'Henrysog', 'salehgafsa@hotmail.com', 'The success formula is found. Learn more about it. https://sog.187sued.de/gotodate/promo', 'Financial robot guarantees everyone stability and income.', '2022-05-15 10:15:57', '2022-05-15 10:15:57'),
(180, 'Henrysog', 'claire_meyer_b@hotmail.com', 'No need to stay awake all night long to earn money. Launch the robot. https://sog.187sued.de/gotodate/promo', 'We have found the fastest way to be rich. Find it out here.', '2022-05-15 15:24:30', '2022-05-15 15:24:30'),
(181, 'Henrysog', 'star7194@aol.com', 'Make dollars just sitting home. https://sog.187sued.de/gotodate/promo', 'We have found the fastest way to be rich. Find it out here.', '2022-05-15 20:48:49', '2022-05-15 20:48:49'),
(182, 'Henrysog', 'G.COHN1@COMCAST.NET', 'The financial Robot is your # 1 expert of making money. https://sog.187sued.de/gotodate/promo', 'Trust the financial Bot to become rich.', '2022-05-16 02:32:59', '2022-05-16 02:32:59'),
(183, 'Henrysog', 'vlo527@yahoo.com', 'One dollar is nothing, but it can grow into $100 here. https://sog.187sued.de/gotodate/promo', 'The financial Robot works for you even when you sleep.', '2022-05-16 08:18:50', '2022-05-16 08:18:50'),
(184, 'Henrysog', 'creatormundilittleton@gmail.com', 'Need money? Earn it without leaving your home. https://sog.187sued.de/gotodate/promo', 'Your money work even when you sleep.', '2022-05-16 13:44:02', '2022-05-16 13:44:02'),
(185, 'Henrysog', 'caseydalthorp@yahoo.com', 'Your computer can bring you additional income if you use this Robot. https://sog.187sued.de/gotodate/promo', 'Trust your dollar to the Robot and see how it grows to $100.', '2022-05-16 18:52:19', '2022-05-16 18:52:19'),
(186, 'Henrysog', 'cinden22@gmail.com', 'Have no financial skills? Let Robot make money for you. https://sog.187sued.de/gotodate/promo', 'Just one click can turn you dollar into $1000.', '2022-05-16 23:57:42', '2022-05-16 23:57:42'),
(187, 'Henrysog', 'immacatbytchyeh@rocketmail.com', 'Even a child knows how to make $100 today. https://sog.187sued.de/gotodate/promo', 'Looking for an easy way to make money? Check out the financial robot.', '2022-05-17 05:07:08', '2022-05-17 05:07:08'),
(188, 'Henrysog', 'vram77@gmail.com', 'Your money work even when you sleep. https://sog.187sued.de/gotodate/promo', 'The financial Robot is your future wealth and independence.', '2022-05-17 10:32:37', '2022-05-17 10:32:37'),
(189, 'Henrysog', 'alguieneneldia11@gmail.com', 'Start your online work using the financial Robot. https://sog.187sued.de/gotodate/promo', 'The online financial Robot is your key to success.', '2022-05-17 16:09:50', '2022-05-17 16:09:50'),
(190, 'Henrysog', 'cliffmiller_2000@yahoo.com', 'We know how to increase your financial stability. https://sog.187sued.de/gotodate/link', 'Need money? Get it here easily?', '2022-05-17 21:56:17', '2022-05-17 21:56:17'),
(191, 'Henrysog', 'Pedro.Cervantespimp@gmail.com', 'There is no need to look for a job anymore. Work online. https://sog.187sued.de/gotodate/link', 'Start making thousands of dollars every week just using this robot.', '2022-05-18 03:31:59', '2022-05-18 03:31:59'),
(192, 'Henrysog', 'jdube91@yahoo.com', 'Earning $1000 a day is easy if you use this financial Robot. https://sog.187sued.de/gotodate/link', 'Check out the newest way to make a fantastic profit.', '2022-05-18 09:11:57', '2022-05-18 09:11:57'),
(193, 'Henrysog', 'EBettano@comcast.net', 'Earning $1000 a day is easy if you use this financial Robot. https://sog.187sued.de/gotodate/link', 'Everyone can earn as much as he wants now.', '2022-05-18 14:20:20', '2022-05-18 14:20:20'),
(194, 'Henrysog', 'andimuhamadraf@yahoo.com', 'Find out about the easiest way of money earning. https://sog.187sued.de/gotodate/link', 'Rich people are rich because they use this robot.', '2022-05-18 19:28:30', '2022-05-18 19:28:30'),
(195, 'Henrysog', 'sophia.taylor2320@gmail.com', 'Find out about the fastest way for a financial independence. https://sog.187sued.de/gotodate/link', 'Need money? Get it here easily?', '2022-05-19 00:39:00', '2022-05-19 00:39:00'),
(196, 'Henrysog', 'trappor26@yahoo.com', 'Start making thousands of dollars every week. https://sog.187sued.de/gotodate/link', 'The fastest way to make you wallet thick is here.', '2022-05-19 06:04:45', '2022-05-19 06:04:45'),
(197, 'Henrysog', 'fine_fine15@yahoo.com', 'Wow! This Robot is a great start for an online career. https://sog.bookeat.es/gotodate/promo', 'Launch the robot and let it bring you money.', '2022-05-19 11:11:03', '2022-05-19 11:11:03'),
(198, 'Henrysog', 'hykehezetiva@gmx.com', 'Make yourself rich in future using this financial robot. https://sog.bookeat.es/gotodate/promo', 'Launch the financial Bot now to start earning.', '2022-05-19 16:18:11', '2022-05-19 16:18:11'),
(199, 'Henrysog', 'kilburnr@ntiogasd.org', 'Financial robot is your success formula is found. Learn more about it. https://sog.bookeat.es/gotodate/promo', 'Wow! This Robot is a great start for an online career.', '2022-05-19 21:26:47', '2022-05-19 21:26:47'),
(200, 'Henrysog', 'rcman25@verizon.net', 'Make your computer to be you earning instrument. https://sog.bookeat.es/gotodate/promo', 'Financial robot is your success formula is found. Learn more about it.', '2022-05-20 02:34:09', '2022-05-20 02:34:09'),
(201, 'Henrysog', 'peitingtiow@hotmail.com', 'The fastest way to make you wallet thick is here. https://sog.bookeat.es/gotodate/promo', 'Your money work even when you sleep.', '2022-05-20 07:42:22', '2022-05-20 07:42:22'),
(202, 'Henrysog', 'ncap8910@verizon.net', 'Need money? Get it here easily? https://sog.bookeat.es/gotodate/promo', 'Invest $1 today to make $1000 tomorrow.', '2022-05-20 12:46:59', '2022-05-20 12:46:59'),
(203, 'Henrysog', 'albertasteele09@yahoo.com', 'Robot is the best solution for everyone who wants to earn. https://sog.bookeat.es/gotodate/promo', 'Financial robot is a great way to manage and increase your income.', '2022-05-20 17:54:46', '2022-05-20 17:54:46'),
(204, 'Henrysog', 'cmikeau80@aol.com', 'No need to stay awake all night long to earn money. Launch the robot. https://sog.bookeat.es/gotodate/promo', 'Check out the new financial tool, which can make you rich.', '2022-05-20 23:01:48', '2022-05-20 23:01:48'),
(205, 'Henrysog', 'alex.peter3423+4@gmail.com', 'The huge income without investments is available. https://sog.bookeat.es/gotodate/promo', 'The best online investment tool is found. Learn more!', '2022-05-21 04:10:08', '2022-05-21 04:10:08'),
(206, 'Henrysog', 'camp15@yahoo.com', 'Financial robot is your success formula is found. Learn more about it. https://sog.bookeat.es/gotodate/promo', 'No worries if you are fired. Work online.', '2022-05-21 09:18:56', '2022-05-21 09:18:56'),
(207, 'Henrysog', 'hkbrownlie@gmail.com', 'Financial robot keeps bringing you money while you sleep. https://sog.bookeat.es/gotodate/promo', 'Robot is the best way for everyone who looks for financial independence.', '2022-05-21 14:32:24', '2022-05-21 14:32:24'),
(208, 'Henrysog', 'morejosh24@gmail.com', 'No need to worry about the future if your use this financial robot. https://sog.bookeat.es/gotodate/promo', 'Invest $1 today to make $1000 tomorrow.', '2022-05-21 19:40:15', '2022-05-21 19:40:15'),
(209, 'Henrysog', 'ahzk9863@naver.com', 'Check out the automatic Bot, which works for you 24/7. https://sog.bookeat.es/gotodate/promo', 'Find out about the fastest way for a financial independence.', '2022-05-22 00:48:12', '2022-05-22 00:48:12'),
(210, 'Henrysog', 'choc_lab1234@yahoo.com', 'Check out the automatic Bot, which works for you 24/7. https://sog.bookeat.es/gotodate/promo', 'Financial robot is your success formula is found. Learn more about it.', '2022-05-22 06:30:40', '2022-05-22 06:30:40'),
(211, 'Henrysog', 'kaitlin.blevins@iamaram.com', 'No need to work anymore. Just launch the robot. https://sog.bookeat.es/gotodate/promo', 'Your money keep grow 24/7 if you use the financial Robot.', '2022-05-22 11:36:08', '2022-05-22 11:36:08'),
(212, 'Henrysog', 'diablo22288@yahoo.com', 'Start making thousands of dollars every week. https://sog.bookeat.es/gotodate/promo', 'Provide your family with the money in age. Launch the Robot!', '2022-05-22 16:46:17', '2022-05-22 16:46:17'),
(213, 'Henrysog', 'callepi37@hotmail.com', 'Your computer can bring you additional income if you use this Robot. https://sog.bookeat.es/gotodate/promo', 'Online job can be really effective if you use this Robot.', '2022-05-22 22:14:33', '2022-05-22 22:14:33'),
(214, 'Henrysog', 'tr.i.bu.tarylxns@gmail.com', 'Provide your family with the money in age. Launch the Robot! https://sog.bookeat.es/gotodate/promo', 'Start making thousands of dollars every week just using this robot.', '2022-05-23 03:27:11', '2022-05-23 03:27:11'),
(215, 'Henrysog', 'balijavajolie@yahoo.com', 'Need money? Earn it without leaving your home. https://sog.bookeat.es/gotodate/promo', 'Online earnings are the easiest way for financial independence.', '2022-05-23 08:36:28', '2022-05-23 08:36:28'),
(216, 'Henrysog', 'praw1ra@yahoo.com', 'Need some more money? Robot will earn them really fast. https://sog.bookeat.es/gotodate/promo', 'Need some more money? Robot will earn them really fast.', '2022-05-23 14:09:12', '2022-05-23 14:09:12'),
(217, 'Zuki Chang', 'info.meiwa@via.tokyo.jp', 'Hello, \r\n \r\nIf you are based in the United States of America, Meiwa Corporation Co, Ltd urgently needs you to serve as her Spokesperson/Financial Coordinator for its clients in the United States. It\'s a part-time job with a good pay and will only take a few minutes of your time daily, and it will not bring any conflict of interest in case you are working with another company. If interested, contact email: info@meiwacorporations.com \r\n \r\n \r\nBest Regards \r\nZuki Chang \r\nMeiwa Corporation co.Ltd. \r\n3-chome, Chiyoda-ku, \r\nTokyo 100-8311, Japan', 'Company Representative Agent Request', '2022-05-23 15:01:47', '2022-05-23 15:01:47'),
(218, 'Henrysog', 'chiki_boo2@yahoo.com', 'Make thousands every week working online here. https://sog.bookeat.es/gotodate/promotion', 'Even a child knows how to make money. Do you?', '2022-05-23 18:35:04', '2022-05-23 18:35:04'),
(219, 'Henrysog', 'fletcher625@yahoo.com', 'The financial Robot works for you even when you sleep. https://sog.bookeat.es/gotodate/promotion', 'The best online investment tool is found. Learn more!', '2022-05-23 18:50:22', '2022-05-23 18:50:22'),
(220, 'Henrysog', 'OROZCO224@yahoo.com', 'We know how to increase your financial stability. https://sog.bookeat.es/gotodate/promotion', 'Attention! Here you can earn money online!', '2022-05-23 19:17:47', '2022-05-23 19:17:47'),
(221, 'Henrysog', 'taefun.lol@yahoo.com', 'There is no need to look for a job anymore. Work online. https://sog.bookeat.es/gotodate/promotion', 'Invest $1 today to make $1000 tomorrow.', '2022-05-23 20:36:21', '2022-05-23 20:36:21'),
(222, 'Henrysog', 'Jessielovesdogs@yahoo.com', 'Robot is the best solution for everyone who wants to earn. https://sog.bookeat.es/gotodate/promotion', 'Feel free to buy everything you want with the additional income.', '2022-05-24 00:28:36', '2022-05-24 00:28:36'),
(223, 'Henrysog', 'cpoetzinger@aol.com', 'Every your dollar can turn into $100 after you lunch this Robot. https://sog.bookeat.es/gotodate/promotion', 'The online job can bring you a fantastic profit.', '2022-05-24 05:57:14', '2022-05-24 05:57:14'),
(224, 'Henrysog', 'a_ba_00@hotmail.com', 'Earn additional money without efforts and skills. https://sog.bookeat.es/gotodate/promotion', 'Have no financial skills? Let Robot make money for you.', '2022-05-24 09:01:54', '2022-05-24 09:01:54'),
(225, 'Henrysog', 'tujqdl@borsebvrberry.com', 'This robot can bring you money 24/7. https://sog.bookeat.es/gotodate/promotion', 'Even a child knows how to make $100 today.', '2022-05-24 09:09:41', '2022-05-24 09:09:41'),
(226, 'Henrysog', 'mark.oconnor@evergreenps.org', 'One click of the robot can bring you thousands of bucks. https://sog.bookeat.es/gotodate/promotion', 'Feel free to buy everything you want with the additional income.', '2022-05-24 11:04:54', '2022-05-24 11:04:54'),
(227, 'Henrysog', 'hannah121177@hotmail.com', 'Check out the automatic Bot, which works for you 24/7. https://sog.bookeat.es/gotodate/promotion', 'Need money? Get it here easily?', '2022-05-24 14:12:30', '2022-05-24 14:12:30'),
(228, 'Henrysog', 'adefunke002@yahoo.com', 'Let your money grow into the capital with this Robot. https://sog.bookeat.es/gotodate/promotion', 'Check out the automatic Bot, which works for you 24/7.', '2022-05-24 14:43:27', '2022-05-24 14:43:27'),
(229, 'Henrysog', 'r.us.u.g.e.or.gica.25@gmail.com', 'Find out about the easiest way of money earning. https://sog.bookeat.es/gotodate/promotion', 'Robot is the best solution for everyone who wants to earn.', '2022-05-24 16:41:56', '2022-05-24 16:41:56'),
(230, 'Henrysog', 'eticmimarlik@yahoo.com', 'Your computer can bring you additional income if you use this Robot. https://sog.bookeat.es/gotodate/promotion', 'Make money online, staying at home this cold winter.', '2022-05-24 19:07:11', '2022-05-24 19:07:11'),
(231, 'Henrysog', 'roshnibharati@gmail.com', 'Even a child knows how to make money. This robot is what you need! https://sog.bookeat.es/gotodate/promotion', 'Have no financial skills? Let Robot make money for you.', '2022-05-24 20:08:28', '2022-05-24 20:08:28'),
(232, 'Henrysog', 'RoxyTabitha@aol.com', 'Wow! This is a fastest way for a financial independence. https://sog.bookeat.es/gotodate/promotion', 'The best online job for retirees. Make your old ages rich.', '2022-05-24 21:50:00', '2022-05-24 21:50:00'),
(233, 'Henrysog', 'qolacyynbqeowyer@hotmail.com', 'Launch the best investment instrument to start making money today. https://sog.bookeat.es/gotodate/promotion', 'No need to work anymore. Just launch the robot.', '2022-05-25 00:06:25', '2022-05-25 00:06:25'),
(234, 'Henrysog', 'cambrian.strong@yahoo.com', 'Automatic robot is the best start for financial independence. https://sog.bookeat.es/gotodate/promotion', 'No need to work anymore while you have the Robot launched!', '2022-05-25 01:30:38', '2022-05-25 01:30:38'),
(235, 'Henrysog', 'desmallon@hotmail.com', 'See how Robot makes $1000 from $1 of investment. https://sog.bookeat.es/gotodate/promotion', 'The best way for everyone who rushes for financial independence.', '2022-05-25 02:58:09', '2022-05-25 02:58:09'),
(236, 'Henrysog', 'exroxl@gmail.com', 'We have found the fastest way to be rich. Find it out here. https://sog.bookeat.es/gotodate/promotion', 'Provide your family with the money in age. Launch the Robot!', '2022-05-25 05:03:31', '2022-05-25 05:03:31'),
(237, 'Henrysog', 'samar_nageib@yahoo.com', 'Making money can be extremely easy if you use this Robot. https://sog.bookeat.es/gotodate/promotion', 'Earn additional money without efforts and skills.', '2022-05-25 06:52:52', '2022-05-25 06:52:52'),
(238, 'Henrysog', 'maudelmundo@yahoo.com', 'Thousands of bucks are guaranteed if you use this robot. https://sog.bookeat.es/gotodate/promotion', 'Looking for additional money? Try out the best financial instrument.', '2022-05-25 08:04:37', '2022-05-25 08:04:37'),
(239, 'Henrysog', 'dbug97@aol.com', 'Financial Robot is #1 investment tool ever. Launch it! https://sog.bookeat.es/gotodate/promotion', 'Launch the robot and let it bring you money.', '2022-05-25 08:35:13', '2022-05-25 08:35:13'),
(240, 'Henrysog', 'stephanieburton@yahoo.com', 'Earning $1000 a day is easy if you use this financial Robot. https://sog.bookeat.es/gotodate/promotion', 'Check out the newest way to make a fantastic profit.', '2022-05-25 12:17:58', '2022-05-25 12:17:58'),
(241, 'Henrysog', 'juditmatula53@gmail.com', 'One click of the robot can bring you thousands of bucks. https://sog.bookeat.es/gotodate/promotion', 'The online income is your key to success.', '2022-05-25 13:14:00', '2022-05-25 13:14:00'),
(242, 'Henrysog', 'novakedith@gmail.com', 'Online earnings are the easiest way for financial independence. https://sog.bookeat.es/gotodate/promotion', 'Have no financial skills? Let Robot make money for you.', '2022-05-25 13:35:39', '2022-05-25 13:35:39'),
(243, 'Henrysog', 'carrie.calico@yahoo.com', 'This robot will help you to make hundreds of dollars each day. https://sog.bookeat.es/gotodate/promotion', 'Start your online work using the financial Robot.', '2022-05-25 17:44:03', '2022-05-25 17:44:03'),
(244, 'Henrysog', 'niranjaniduvva@gmail.com', 'Need money? The financial robot is your solution. https://sog.bookeat.es/gotodate/promotion', 'The fastest way to make you wallet thick is here.', '2022-05-25 18:27:42', '2022-05-25 18:27:42'),
(245, 'Henrysog', 'bernrgorki81@hotmail.com', 'Watch your money grow while you invest with the Robot. https://sog.bookeat.es/gotodate/promotion', 'The huge income without investments is available.', '2022-05-25 18:32:02', '2022-05-25 18:32:02'),
(246, 'Henrysog', 'rodney_din@orangeinbox.org', 'Try out the automatic robot to keep earning all day long. https://sog.bookeat.es/gotodate/promotion', 'Even a child knows how to make $100 today.', '2022-05-25 23:09:22', '2022-05-25 23:09:22'),
(247, 'Henrysog', 'x-stormer@hotmail.com', 'The best way for everyone who rushes for financial independence. https://sog.bookeat.es/gotodate/promotion', 'Launch the financial Robot and do your business.', '2022-05-25 23:25:43', '2022-05-25 23:25:43'),
(248, 'Henrysog', 'hoacomay1207@gmail.com', 'Thousands of bucks are guaranteed if you use this robot. https://sog.bookeat.es/gotodate/promotion', 'Your money work even when you sleep.', '2022-05-25 23:56:37', '2022-05-25 23:56:37'),
(249, 'Henrysog', 'prestiav@leonschools.net', 'Even a child knows how to make money. Do you? https://sog.bookeat.es/gotodate/promotion', 'Need money? Earn it without leaving your home.', '2022-05-26 04:21:04', '2022-05-26 04:21:04'),
(250, 'Henrysog', 'ceci_forever22@yahoo.com', 'Let the Robot bring you money while you rest. https://sog.bookeat.es/gotodate/promotion', 'Try out the best financial robot in the Internet.', '2022-05-26 04:31:57', '2022-05-26 04:31:57'),
(251, 'Henrysog', 'jaxrick64@comcast.net', 'Have no money? It’s easy to earn them online here. https://sog.bookeat.es/gotodate/promotion', 'The best online investment tool is found. Learn more!', '2022-05-26 05:07:21', '2022-05-26 05:07:21'),
(252, 'Henrysog', 'mr_untouchable77@hotmail.com', 'Even a child knows how to make $100 today with the help of this robot. https://sog.bookeat.es/gotodate/promotion', 'There is no need to look for a job anymore. Work online.', '2022-05-26 09:18:04', '2022-05-26 09:18:04'),
(253, 'Henrysog', 'scollman19@Gmail.com', 'Robot never sleeps. It makes money for you 24/7. https://sog.bookeat.es/gotodate/promotion', 'Even a child knows how to make money. Do you?', '2022-05-26 10:21:38', '2022-05-26 10:21:38'),
(254, 'Henrysog', 'emilybrookhouse@aol.com', 'Automatic robot is the best start for financial independence. https://sog.bookeat.es/gotodate/promotion', 'Earn additional money without efforts and skills.', '2022-05-26 10:23:22', '2022-05-26 10:23:22'),
(255, 'Henrysog', 'racqueltotherescue@yahoo.com', 'The additional income is available for everyone using this robot. https://sog.bookeat.es/gotodate/promotion', 'Attention! Here you can earn money online!', '2022-05-26 14:15:02', '2022-05-26 14:15:02'),
(256, 'Henrysog', 'mika.c.mitsui@gmail.com', 'The additional income is available for everyone using this robot. https://sog.battletech-newsletter.de/gotodate/promo', 'The additional income is available for everyone using this robot.', '2022-05-26 15:46:41', '2022-05-26 15:46:41'),
(257, 'Henrysog', 'mpearl.wilson@yahoo.com', '# 1 financial expert in the net! Check out the new Robot. https://sog.battletech-newsletter.de/gotodate/promo', 'Trust the financial Bot to become rich.', '2022-05-26 16:03:36', '2022-05-26 16:03:36'),
(258, 'Henrysog', 'ocula.dev@gmail.com', 'The online financial Robot is your key to success. https://sog.battletech-newsletter.de/gotodate/promo', 'Attention! Here you can earn money online!', '2022-05-26 19:09:12', '2022-05-26 19:09:12'),
(259, 'Henrysog', 'sammiemarie@gmail.com', 'The additional income for everyone. https://sog.battletech-newsletter.de/gotodate/promo', 'Wow! This is a fastest way for a financial independence.', '2022-05-26 21:11:41', '2022-05-26 21:11:41'),
(260, 'Henrysog', 'phildogg1997@yahoo.com', 'Automatic robot is the best start for financial independence. https://sog.battletech-newsletter.de/gotodate/promo', 'Online Bot will bring you wealth and satisfaction.', '2022-05-26 21:19:42', '2022-05-26 21:19:42'),
(261, 'Henrysog', 'conniel@lakecitycc.org', 'Make money 24/7 without any efforts and skills. https://sog.battletech-newsletter.de/gotodate/promo', 'Launch the robot and let it bring you money.', '2022-05-27 00:05:21', '2022-05-27 00:05:21'),
(262, 'Henrysog', 'muffinrain@hotmail.com', 'Need money? The financial robot is your solution. https://sog.battletech-newsletter.de/gotodate/promo', 'Have no money? Earn it online.', '2022-05-27 02:30:48', '2022-05-27 02:30:48'),
(263, 'Henrysog', 'jogelica@gmail.com', 'Still not a millionaire? The financial robot will make you him! https://sog.battletech-newsletter.de/gotodate/promo', 'Financial robot is the best companion of rich people.', '2022-05-27 02:41:29', '2022-05-27 02:41:29'),
(264, 'Henrysog', 'leeji1440@naver.com', 'Need some more money? Robot will earn them really fast. https://sog.battletech-newsletter.de/gotodate/promo', 'Attention! Financial robot may bring you millions!', '2022-05-27 05:06:22', '2022-05-27 05:06:22'),
(265, 'Henrysog', 'mirehaferrer@gmail.com', 'Looking for additional money? Try out the best financial instrument. https://sog.battletech-newsletter.de/gotodate/promo', 'The additional income for everyone.', '2022-05-27 07:38:05', '2022-05-27 07:38:05'),
(266, 'Henrysog', '1f8ozx@gmail.com', 'Start making thousands of dollars every week just using this robot. https://sog.battletech-newsletter.de/gotodate/promo', 'Your money work even when you sleep.', '2022-05-27 08:06:22', '2022-05-27 08:06:22'),
(267, 'Henrysog', 'amp.l.i.t.ud.e.euh.ql.n@gmail.com', 'Need money? Get it here easily? https://sog.battletech-newsletter.de/gotodate/promo', 'This robot will help you to make hundreds of dollars each day.', '2022-05-27 09:57:31', '2022-05-27 09:57:31'),
(268, 'Henrysog', 'sujaychandru30@gmail.com', 'Most successful people already use Robot. Do you? https://sog.battletech-newsletter.de/gotodate/promo', 'Robot is the best way for everyone who looks for financial independence.', '2022-05-27 13:02:45', '2022-05-27 13:02:45'),
(269, 'Henrysog', 'youngsoo8517@gmail.com', 'Earn additional money without efforts and skills. https://sog.battletech-newsletter.de/gotodate/promo', 'Trust the financial Bot to become rich.', '2022-05-27 14:06:50', '2022-05-27 14:06:50'),
(270, 'Henrysog', 'ck@gmail.com', 'Still not a millionaire? Fix it now! https://sog.battletech-newsletter.de/sog', 'Have no money? It’s easy to earn them online here.', '2022-05-27 15:33:13', '2022-05-27 15:33:13'),
(271, 'SdvillelinC', 'revers@o5o5.ru', '<a href=https://chimmed.ru/manufactors/catalog?name=JUN-AIR>JUN-AIR </a> \r\nTegs: Jackson ImmunoResearch  https://chimmed.ru/manufactors/catalog?name=Jackson+ImmunoResearch  \r\n \r\n<u>агилент </u> \r\n<i>адвбиоматериалс </i> \r\n<b>адрона </b>', 'акронбиотеч', '2022-05-27 17:11:24', '2022-05-27 17:11:24'),
(272, 'Henrysog', 'shiri02.ba@gmail.com', 'Launch the financial Bot now to start earning. https://sog.battletech-newsletter.de/sog', 'No need to work anymore while you have the Robot launched!', '2022-05-27 18:49:13', '2022-05-27 18:49:13'),
(273, 'Henrysog', 'jfkrrb@aol.com', 'Financial robot is a great way to manage and increase your income. https://sog.battletech-newsletter.de/sog', 'Let your money grow into the capital with this Robot.', '2022-05-27 19:49:48', '2022-05-27 19:49:48'),
(274, 'Henrysog', 'elizabeth_lopez455@yahoo.com', 'The financial Robot is your # 1 expert of making money. https://sog.battletech-newsletter.de/sog', 'Join the society of successful people who make money here.', '2022-05-27 22:30:35', '2022-05-27 22:30:35'),
(275, 'Henrysog', 'seni_seven_taner@hotmail.com', 'Earn additional money without efforts and skills. https://sog.battletech-newsletter.de/sog', 'The huge income without investments is available.', '2022-05-28 00:09:29', '2022-05-28 00:09:29'),
(276, 'Henrysog', 'stephen.falk@hilton.com', 'Automatic robot is the best start for financial independence. https://sog.battletech-newsletter.de/sog', 'Make dollars just sitting home.', '2022-05-28 01:19:54', '2022-05-28 01:19:54'),
(277, 'Henrysog', 'fox2k1@gmail.com', 'Let the Robot bring you money while you rest. https://sog.battletech-newsletter.de/sog', 'The financial Robot is your future wealth and independence.', '2022-05-28 05:20:00', '2022-05-28 05:20:00'),
(278, 'Henrysog', 'gfpchurch@verizon.net', 'Have no money? Earn it online. https://sog.battletech-newsletter.de/sog', 'Wow! This Robot is a great start for an online career.', '2022-05-28 05:40:08', '2022-05-28 05:40:08'),
(279, 'Henrysog', 'shuyan1988@gmail.com', 'It is the best time to launch the Robot to get more money. https://sog.battletech-newsletter.de/sog', 'Make dollars just sitting home.', '2022-05-28 06:54:47', '2022-05-28 06:54:47'),
(280, 'Henrysog', 'sheilagg222@aol.com', 'Trust your dollar to the Robot and see how it grows to $100. https://sog.battletech-newsletter.de/sog', 'Let your money grow into the capital with this Robot.', '2022-05-28 10:32:47', '2022-05-28 10:32:47'),
(281, 'Charlotte Gabriel', 'charlottegabriel@stayhome.li', 'Hello, \r\n \r\nI\'m Charlotte Gabriel, An online trading Coash. I want you to know that online trading (Crypto, Forex and Binary option) is a good thing if you have a good trading strategy, I use to lose a lot of funds in online trading before I got to where I am today. If you need assistance on how to trade and recover back all the money you have lost to your broker and want to be a successful online trader like me, write to me via email below to get an amazing strategy. \r\n \r\nIf you are having problems withdrawing your profit from your Crypto, Forex or Binary option trading account even when you were given a bonus, just contact me, I have worked with some Trade, Regulatory Agencies for 9years, and I have helped a lot of people get back their lost funds from their stubborn brokers successfully and I won\'t stop until I have helped as many as possible. For more info you can contact me via my email address: charlgabriel05@gmail.com \r\n \r\nKind Regards, \r\nCharlotte Gabriel. \r\nTrading Consultant.', 'Lost Profit Recovery Strategy', '2022-05-28 10:58:57', '2022-05-28 10:58:57'),
(282, 'Henrysog', 'cynnfolc@gmail.com', 'The online job can bring you a fantastic profit. https://sog.battletech-newsletter.de/sog', 'The financial Robot works for you even when you sleep.', '2022-05-28 12:22:07', '2022-05-28 12:22:07');
INSERT INTO `contact` (`id`, `name`, `email`, `message`, `subject`, `created_at`, `updated_at`) VALUES
(283, 'Henrysog', 'minh_vi88@hotmail.com', 'Make thousands of bucks. Financial robot will help you to do it! https://sog.battletech-newsletter.de/sog', 'Money, money! Make more money with financial robot!', '2022-05-28 12:59:45', '2022-05-28 12:59:45'),
(284, 'Henrysog', 'fann7545@sina.com', 'The fastest way to make you wallet thick is here. https://sog.battletech-newsletter.de/sog', 'Financial robot guarantees everyone stability and income.', '2022-05-28 16:27:39', '2022-05-28 16:27:39'),
(285, 'Henrysog', 'ringjam238@thebest4ever.com', 'Looking for an easy way to make money? Check out the financial robot. https://sog.battletech-newsletter.de/sog', 'Launch the robot and let it bring you money.', '2022-05-28 17:59:14', '2022-05-28 17:59:14'),
(286, 'Henrysog', 'dingdangdoo@yahoo.com', 'Trust your dollar to the Robot and see how it grows to $100. https://sog.battletech-newsletter.de/sog', 'Trust the financial Bot to become rich.', '2022-05-28 20:14:25', '2022-05-28 20:14:25'),
(287, 'Henrysog', 'lovepinkrose@aol.com', 'We know how to increase your financial stability. https://sog.battletech-newsletter.de/sog', 'Online earnings are the easiest way for financial independence.', '2022-05-28 21:37:41', '2022-05-28 21:37:41'),
(288, 'Henrysog', 'jpaintball@comcast.net', 'The financial Robot works for you even when you sleep. https://sog.battletech-newsletter.de/sog', 'The online income is the easiest ways to make you dream come true.', '2022-05-28 23:29:48', '2022-05-28 23:29:48'),
(289, 'Henrysog', 'phillipsharbarger@me.com', 'Make dollars staying at home and launched this Bot. https://sog.battletech-newsletter.de/sog', 'Rich people are rich because they use this robot.', '2022-05-29 02:52:24', '2022-05-29 02:52:24'),
(290, 'Henrysog', 'tonya.copeland@mercer.com', 'Robot is the best way for everyone who looks for financial independence. https://sog.battletech-newsletter.de/sog', 'Invest $1 today to make $1000 tomorrow.', '2022-05-29 03:06:45', '2022-05-29 03:06:45'),
(291, 'Henrysog', 'mto_mexican@yahoo.com', 'Attention! Financial robot may bring you millions! https://sog.battletech-newsletter.de/sog', 'Make money in the internet using this Bot. It really works!', '2022-05-29 04:57:45', '2022-05-29 04:57:45'),
(292, 'Henrysog', 'giorgiasoerti@gmail.com', 'Online Bot will bring you wealth and satisfaction. https://sog.battletech-newsletter.de/sog', 'Make $1000 from $1 in a few minutes. Launch the financial robot now.', '2022-05-29 08:00:38', '2022-05-29 08:00:38'),
(293, 'Henrysog', 'kirkeherbst@aol.com', 'One dollar is nothing, but it can grow into $100 here. https://sog.battletech-newsletter.de/sog', 'Every your dollar can turn into $100 after you lunch this Robot.', '2022-05-29 10:26:53', '2022-05-29 10:26:53'),
(294, 'Henrysog', 'wangbaosh123@yahoo.com', 'One dollar is nothing, but it can grow into $100 here. https://sog.battletech-newsletter.de/sog', 'Feel free to buy everything you want with the additional income.', '2022-05-29 10:31:18', '2022-05-29 10:31:18'),
(295, 'Henrysog', 'Smithdd201@yahoo.com', 'The online income is the easiest ways to make you dream come true. https://sog.battletech-newsletter.de/sog', 'The financial Robot is the most effective financial tool in the net!', '2022-05-29 13:13:42', '2022-05-29 13:13:42'),
(296, 'FindFastBusinessFunds', 'noreply@findfastbusinessfunds.pro', 'Hi, do you know that http://FindFastBusinessFunds.pro can help your business get funding for $2,000 - $350K Without high credit or collateral. \r\n \r\nFind Out how much you can get by clicking here: \r\n \r\nhttp://FindFastBusinessFunds.pro \r\n \r\nRequirements include your company being established for at least a year and with current gross revenue of at least 120K. Eligibility and funding can be completed in as fast as 48hrs. Terms are personalized for each business so I suggest applying to find out exactly how much you can get on various terms. \r\n \r\nThis is a completely free service from a qualified funder and the approval will be based on the annual revenue of your business. These funds are completely Non-Restrictive, allowing you to spend the full amount in any way you require including business debt consolidation, hiring, marketing, or Absolutely Any Other expense. \r\n \r\nIf you need fast and easy business funding take a look at these programs now as there is limited availability: \r\n \r\nhttp://FindFastBusinessFunds.pro \r\n \r\nHave a good day, \r\nThe Find Fast Business Funds Team \r\n \r\nunsubscribe/remove - http://FindFastBusinessFunds.pro/r.php?url=citrus.ke&id=109', 'Funding for Your Business, Now', '2022-05-29 13:26:34', '2022-05-29 13:26:34'),
(297, 'Henrysog', 'sukhybbir@wdxgc.com', 'Only one click can grow up your money really fast. https://sog.battletech-newsletter.de/sog', 'Financial independence is what this robot guarantees.', '2022-05-29 16:15:45', '2022-05-29 16:15:45'),
(298, 'Henrysog', 'shabab.imam4@gmail.com', 'We know how to become rich and do you? https://sog.battletech-newsletter.de/sog', 'We have found the fastest way to be rich. Find it out here.', '2022-05-29 17:44:28', '2022-05-29 17:44:28'),
(299, 'Henrysog', 'herringlatara@yahoo.com', 'Start making thousands of dollars every week just using this robot. https://sog.battletech-newsletter.de/sog', 'The fastest way to make you wallet thick is here.', '2022-05-29 18:23:45', '2022-05-29 18:23:45'),
(300, 'Henrysog', 'HunBunny89@aol.com', 'The fastest way to make your wallet thick is found. https://sog.battletech-newsletter.de/sog', 'The additional income is available for everyone using this robot.', '2022-05-29 21:46:31', '2022-05-29 21:46:31'),
(301, 'Ryan Hart', 'ryanhartvideos@gmail.com', 'The world’s gone completely nuts lately! And it seems like things are going to get worse before they get better. \r\n \r\nMost companies are struggling to keep their head above water and essentially finding the old way of doing stuff no longer works like it used to. \r\n \r\nIf you can relate, I have an idea that costs very little and can really have a big impact. \r\n \r\nThis simple idea will work for any company that needs to get more sales and increase leads but doesn\'t have a lot of time to waste or money to spend. \r\n \r\nI am talking about a new animated explainer video to freshen up your website and social media. Some recent clients have seen it increase sales by 20, 30 and 40%. \r\n \r\nIf this sounds good, we have a special offer right now where you can get an epic 60-second high-quality animated explainer video (from an American company) for only $147. In fact, you get TWO COPIES (a standard HD format and one made for your social media). \r\n \r\nReady? Go to https://bit.ly/two-video-promo-r1 to get started or for more info. \r\n \r\nCheers! \r\nRyan Hart \r\nXpress Animation', 'This ain’t it, chief.', '2022-05-29 22:17:42', '2022-05-29 22:17:42'),
(302, 'Henrysog', 'newportsconcierge@yahoo.com', 'Start your online work using the financial Robot. https://sog.battletech-newsletter.de/sog', 'Your money work even when you sleep.', '2022-05-29 23:39:51', '2022-05-29 23:39:51'),
(303, 'Henrysog', 'Reteena@Netscape.Net', 'Earning $1000 a day is easy if you use this financial Robot. https://sog.battletech-newsletter.de/sog', 'Feel free to buy everything you want with the additional income.', '2022-05-30 00:41:05', '2022-05-30 00:41:05'),
(304, 'Van Gurt', 'vangurt@wadejcollc.com', 'Good Morning. \r\n \r\nWe provide international loans for corporate and private entities all over the world. \r\n \r\nOur interest rate for secured and unsecured loans ranges between 2.5-6.7% PA, with a 12 months grace period and private investment fund are also available depending on the project to be executed. Do acknowledge receipt of my email by replying to van.gurt111@gmail.com for further assistance. \r\n \r\nWe look forward to bringing you on board - a new way of achieving financial stability. \r\n \r\nVan Gurt \r\nvan.gurt111@gmail.com', 'Corporate Loans Offer', '2022-05-30 01:40:49', '2022-05-30 01:40:49'),
(305, 'Henrysog', 'jtjordan11@gmail.com', 'Make yourself rich in future using this financial robot. https://sog.battletech-newsletter.de/sog', 'Launch the financial Bot now to start earning.', '2022-05-30 03:17:53', '2022-05-30 03:17:53'),
(306, 'Henrysog', 'marcelodiaz123@outlook.com', 'Attention! Here you can earn money online! https://sog.battletech-newsletter.de/sog', 'Financial independence is what everyone needs.', '2022-05-30 05:13:02', '2022-05-30 05:13:02'),
(307, 'Henrysog', 'seeu57@hotmail.com', 'Automatic robot is the best start for financial independence. https://sog.battletech-newsletter.de/sog', 'The success formula is found. Learn more about it.', '2022-05-30 07:59:20', '2022-05-30 07:59:20'),
(308, 'Henrysog', 'mukizz@yahoo.com', 'Wow! This Robot is a great start for an online career. https://sog.battletech-newsletter.de/sog', 'The success formula is found. Learn more about it.', '2022-05-30 09:09:21', '2022-05-30 09:09:21'),
(309, 'Henrysog', 'garrett_ma2212@yahoo.com', 'Launch the financial Robot and do your business. https://sog.battletech-newsletter.de/sog', 'Make money in the internet using this Bot. It really works!', '2022-05-30 10:25:44', '2022-05-30 10:25:44'),
(310, 'Henrysog', 'texadan@yahoo.com', 'Looking for additional money? Try out the best financial instrument. https://sog.battletech-newsletter.de/sog', 'Every your dollar can turn into $100 after you lunch this Robot.', '2022-05-30 14:35:41', '2022-05-30 14:35:41'),
(311, 'Henrysog', 'pagie322@hotmail.com', 'Start making thousands of dollars every week. https://sog.battletech-newsletter.de/sog', 'Making money in the net is easier now.', '2022-05-30 15:05:18', '2022-05-30 15:05:18'),
(312, 'Henrysog', 'protowsu@yahoo.com', 'Automatic robot is the best start for financial independence. https://sog.battletech-newsletter.de/sog', 'Robot never sleeps. It makes money for you 24/7.', '2022-05-30 15:44:48', '2022-05-30 15:44:48'),
(313, 'Ghodratollah Ahmadvand', 'rp9123765@wadejcollc.com', 'Hello \r\n \r\nMy Name is Mr. Ghodratollah Ahmadvand. International outsource personnel. We recommend credible entrepreneur/viable projects for silent investors that are seeking a good business plan/entrepreneur to invest and manage funds on a short and long term. I am consulting for a client looking for a lucrative business to invest in your country. \r\n \r\nHe is interested in investing in the Economic and Commercial sectors. I am contacting you for partnership as my client will need your help in actualizing his investment plans in your country. \r\n \r\nKindly indicate your interest by sending your response via email: projectadviser.financier@outlook.com with your contact such as (Number, Company Name/Organization, Position) and I will open communication with more vital details about the plan. Feel Free to acknowledge this message. \r\n \r\nThanks \r\n \r\nMr. Ghodratollah Ahmadvand \r\nWhatsApp +44 7862 208584 \r\nprojectadviser.financier@outlook.com', 'Investment Collaboration', '2022-05-30 19:32:34', '2022-05-30 19:32:34'),
(314, 'Henrysog', 'reneholly@yahoo.com', 'Let your money grow into the capital with this Robot. https://sog.battletech-newsletter.de/sog', 'Online job can be really effective if you use this Robot.', '2022-05-30 19:55:49', '2022-05-30 19:55:49'),
(315, 'Henrysog', 'homehelpcomp@gmail.com', 'Make thousands of bucks. Pay nothing. https://sog.battletech-newsletter.de/sog', 'Turn $1 into $100 instantly. Use the financial Robot.', '2022-05-30 20:59:51', '2022-05-30 20:59:51'),
(316, 'Henrysog', 'betterdays36512@yahoo.com', 'The best online investment tool is found. Learn more! https://sog.battletech-newsletter.de/sog', 'No need to stay awake all night long to earn money. Launch the robot.', '2022-05-30 21:44:38', '2022-05-30 21:44:38'),
(317, 'Henrysog', 'SCUBAGIRL1982@HOTMAIL.COM', 'Even a child knows how to make $100 today with the help of this robot. https://sog.battletech-newsletter.de/sog', 'Launch the financial Bot now to start earning.', '2022-05-31 01:26:23', '2022-05-31 01:26:23'),
(318, 'Henrysog', 'ash9550@yahoo.com', 'We have found the fastest way to be rich. Find it out here. https://sog.battletech-newsletter.de/sog', 'Find out about the fastest way for a financial independence.', '2022-05-31 02:08:49', '2022-05-31 02:08:49'),
(319, 'Henrysog', 'purpledomestic@yahoo.com', 'Financial robot is the best companion of rich people. https://sog.battletech-newsletter.de/sog', '# 1 financial expert in the net! Check out the new Robot.', '2022-05-31 04:38:50', '2022-05-31 04:38:50'),
(320, 'Henrysog', 'kelchxnk@hotmail.com', 'This robot can bring you money 24/7. https://sog.battletech-newsletter.de/sog', 'Looking for an easy way to make money? Check out the financial robot.', '2022-05-31 06:55:35', '2022-05-31 06:55:35'),
(321, 'Henrysog', 'vic0427@bellsouth.net', 'Launch the best investment instrument to start making money today. https://sog.battletech-newsletter.de/sog', 'The huge income without investments is available, now!', '2022-05-31 07:33:50', '2022-05-31 07:33:50'),
(322, 'Henrysog', 'rodrigoguanhaes@hotmail.com', 'Start making thousands of dollars every week just using this robot. https://sog.battletech-newsletter.de/sog', 'Make thousands of bucks. Financial robot will help you to do it!', '2022-05-31 08:08:45', '2022-05-31 08:08:45'),
(323, 'Henrysog', 'cata24_cs@yahoo.com', 'The financial Robot is the most effective financial tool in the net! https://sog.battletech-newsletter.de/sog', 'No need to stay awake all night long to earn money. Launch the robot.', '2022-05-31 11:57:50', '2022-05-31 11:57:50'),
(324, 'Henrysog', 'dds1010@hotmail.com', 'Buy everything you want earning money online. https://sog.battletech-newsletter.de/sog', 'We have found the fastest way to be rich. Find it out here.', '2022-05-31 13:02:40', '2022-05-31 13:02:40'),
(325, 'Henrysog', 'www.clooner_ghitza@yahoo.com', 'Thousands of bucks are guaranteed if you use this robot. https://sog.battletech-newsletter.de/sog', 'The best online job for retirees. Make your old ages rich.', '2022-05-31 13:41:53', '2022-05-31 13:41:53'),
(326, 'Henrysog', 'terrfj@gmail.com', 'Have no money? It’s easy to earn them online here. https://sog.battletech-newsletter.de/sog', 'Additional income is now available for anyone all around the world.', '2022-05-31 18:39:09', '2022-05-31 18:39:09'),
(327, 'Henrysog', 'sommer_l_sorenson@yahoo.com', 'Financial robot is your success formula is found. Learn more about it. https://sog.battletech-newsletter.de/sog', 'Thousands of bucks are guaranteed if you use this robot.', '2022-05-31 19:08:38', '2022-05-31 19:08:38'),
(328, 'Henrysog', 'fakeittt@yahoo.com', 'Let your money grow into the capital with this Robot. https://sog.battletech-newsletter.de/sog', 'Robot is the best solution for everyone who wants to earn.', '2022-05-31 19:09:27', '2022-05-31 19:09:27'),
(329, 'Henrysog', 'ManOfPeaceMK@aol.com', 'Making money is very easy if you use the financial Robot. https://sog.battletech-newsletter.de/sog', 'Everyone can earn as much as he wants suing this Bot.', '2022-05-31 23:56:45', '2022-05-31 23:56:45'),
(330, 'Henrysog', 'gkhkhhjn@emailonlinefree.com', 'The additional income is available for everyone using this robot. https://sog.battletech-newsletter.de/sog', 'Online Bot will bring you wealth and satisfaction.', '2022-06-01 00:31:56', '2022-06-01 00:31:56'),
(331, 'Henrysog', 'puertorico682000@yahoo.com', 'Additional income is now available for anyone all around the world. https://sog.battletech-newsletter.de/sog', 'The online financial Robot is your key to success.', '2022-06-01 02:11:53', '2022-06-01 02:11:53'),
(332, 'Henrysog', 'ruleraul@hotmail.com', 'One dollar is nothing, but it can grow into $100 here. https://sog.battletech-newsletter.de/sog', 'The online income is your key to success.', '2022-06-01 05:22:25', '2022-06-01 05:22:25'),
(333, 'Henrysog', 'billbush2@aol.com', 'Launch the financial Bot now to start earning. https://sog.battletech-newsletter.de/sog', 'There is no need to look for a job anymore. Work online.', '2022-06-01 05:52:17', '2022-06-01 05:52:17'),
(334, 'Henrysog', 'erne500@gmail.com', 'We have found the fastest way to be rich. Find it out here. https://sog.battletech-newsletter.de/sog', 'Watch your money grow while you invest with the Robot.', '2022-06-01 09:22:42', '2022-06-01 09:22:42'),
(335, 'Henrysog', 'angiepembleton@comcast.net', 'The additional income is available for everyone using this robot. https://sog.battletech-newsletter.de/sog', 'Financial robot guarantees everyone stability and income.', '2022-06-01 11:27:54', '2022-06-01 11:27:54'),
(336, 'Henrysog', 'milleld0262@yahoo.com', 'The online financial Robot is your key to success. https://sog.battletech-newsletter.de/sog', 'Wow! This Robot is a great start for an online career.', '2022-06-01 11:31:03', '2022-06-01 11:31:03'),
(337, 'Henrysog', 'Jayjay2590@aol.com', 'Attention! Here you can earn money online! https://sog.battletech-newsletter.de/sog', 'Earning $1000 a day is easy if you use this financial Robot.', '2022-06-01 15:21:48', '2022-06-01 15:21:48'),
(338, 'Henrysog', 'nurserew@yahoo.com', 'Attention! Here you can earn money online! https://sog.battletech-newsletter.de/sog', 'Financial robot keeps bringing you money while you sleep.', '2022-06-01 16:55:54', '2022-06-01 16:55:54'),
(339, 'Henrysog', 'panicatdfan21@aim.com', 'Even a child knows how to make $100 today with the help of this robot. https://sog.battletech-newsletter.de/sog', 'Start your online work using the financial Robot.', '2022-06-01 17:04:05', '2022-06-01 17:04:05'),
(340, 'Henrysog', 'gomezbobby77@yahoo.com', 'Your money work even when you sleep. https://sog.battletech-newsletter.de/sog', 'Learn how to make hundreds of backs each day.', '2022-06-01 22:13:56', '2022-06-01 22:13:56'),
(341, 'Henrysog', 'jenonthe1s@gmail.com', 'Still not a millionaire? Fix it now! https://sog.battletech-newsletter.de/sog', 'Every your dollar can turn into $100 after you lunch this Robot.', '2022-06-01 22:40:16', '2022-06-01 22:40:16'),
(342, 'Henrysog', 'chikenlittle715@hotmail.com', 'Need some more money? Robot will earn them really fast. https://sog.battletech-newsletter.de/sog', 'The success formula is found. Learn more about it.', '2022-06-01 22:49:23', '2022-06-01 22:49:23'),
(343, 'Henrysog', 'RookTessa9292@o2.pl', 'Make dollars staying at home and launched this Bot. https://sog.bode-roesch.de/sog', 'Financial independence is what this robot guarantees.', '2022-06-02 19:15:58', '2022-06-02 19:15:58'),
(344, 'Christian Djurit', '5rdhp2fe29yb@beconfidential.com', 'We provide funding  through our venture company to both startups and existing businesses either looking for expansion or to accelerate their company growth. \r\nWe have a structured joint venture investment plan in which we are interested in an annual return on investment not more than 10% ROI. We are also currently structuring a convertible debt and loan financing of 3% interest repayable annually with no early prepayment penalties. \r\nEmail: Chris.djurit@alconmcl.com \r\ndjuritchris@gmail.com \r\n \r\nChristian Djurit \r\nDirector/Investment Head \r\nAlcon Management Company LTD UK.', 'Business partnership', '2022-06-03 06:22:11', '2022-06-03 06:22:11'),
(345, 'Henrysog', 'RookTessa9292@o2.pl', 'Earning $1000 a day is easy if you use this financial Robot. https://sog.bode-roesch.de/sog', 'Even a child knows how to make $100 today with the help of this robot.', '2022-06-03 08:01:41', '2022-06-03 08:01:41'),
(346, 'Henrysog', 'RookTessa9292@o2.pl', 'We know how to make our future rich and do you? https://sog.bode-roesch.de/sog', 'Financial independence is what this robot guarantees.', '2022-06-04 14:20:36', '2022-06-04 14:20:36'),
(347, 'AlenaKa', 'alenaKa@hotmail.com', 'Ηello аll, guуѕ! I knоw, mу mеѕsage may be tоо specifіc,\r\nBut my siѕtеr fоund nіcе mаn hеre аnd thеу married, ѕo hоw аbоut mе?ǃ :)\r\nI аm 23 уеаrs оld, Аlena, from Rоmaniа, I knоw Englіsh аnd Gеrman lаnguаgеs alѕо\r\nАnd... Ι have ѕpecific dіѕеаse, namеd nуmphomаniа. Ԝho knоw what іs this, саn undеrstаnd mе (bеtter to saу іt immеdіatelу)\r\nΑh уeѕ, Ι coоk verу tastуǃ and I lоve not only coоk ;))\r\nΙm rеаl gіrl, nоt рrоstіtutе, аnd loоkіng for sеrіоuѕ аnd hot rеlationѕhіp...\r\nΑnуwау, уоu сan fіnd my profіlе here: http://tunarendongdu.ml/user/21573/', 'Ι\'m lоoking fоr ѕеrious manǃ..', '2022-06-05 02:03:07', '2022-06-05 02:03:07'),
(348, 'Henrysog', 'funnyboy1@forum.dk', 'The online job can bring you a fantastic profit. https://sog.bode-roesch.de/sog', 'Most successful people already use Robot. Do you?', '2022-06-05 22:44:24', '2022-06-05 22:44:24'),
(349, 'Henrysog', 'clausogstella@forum.dk', 'Make your laptop a financial instrument with this program. https://sog.bode-roesch.de/sog', 'Even a child knows how to make $100 today.', '2022-06-06 02:04:47', '2022-06-06 02:04:47'),
(350, 'Henrysog', 'jesperqwe@forum.dk', 'Earning $1000 a day is easy if you use this financial Robot. https://sog.bode-roesch.de/sog', 'It is the best time to launch the Robot to get more money.', '2022-06-06 05:23:06', '2022-06-06 05:23:06'),
(351, 'Henrysog', 'jonas.m.o@forum.dk', 'No need to work anymore. Just launch the robot. https://sog.bode-roesch.de/sog', 'Find out about the easiest way of money earning.', '2022-06-06 08:45:16', '2022-06-06 08:45:16'),
(352, 'Henrysog', 'bjarkebro@forum.dk', 'The financial Robot works for you even when you sleep. https://sog.bode-roesch.de/sog', 'Robot is the best solution for everyone who wants to earn.', '2022-06-06 12:10:03', '2022-06-06 12:10:03'),
(353, 'Henrysog', 'oevad@jubiipost.dk', 'Making money is very easy if you use the financial Robot. https://sog.bode-roesch.de/sog', 'Make your money work for you all day long.', '2022-06-06 15:31:49', '2022-06-06 15:31:49'),
(354, 'Henrysog', 'lottecs@jubiipost.dk', 'Everyone can earn as much as he wants suing this Bot. https://sog.bode-roesch.de/sog', 'Thousands of bucks are guaranteed if you use this robot.', '2022-06-06 18:44:32', '2022-06-06 18:44:32'),
(355, 'Henrysog', 'hdama@forum.dk', 'Making money can be extremely easy if you use this Robot. https://sog.bode-roesch.de/sog', 'Make thousands of bucks. Financial robot will help you to do it!', '2022-06-06 22:04:55', '2022-06-06 22:04:55'),
(356, 'Henrysog', 'bijoslag@mailme.dk', 'The financial Robot is your future wealth and independence. https://sog.bode-roesch.de/sog', 'The additional income for everyone.', '2022-06-07 01:19:54', '2022-06-07 01:19:54'),
(357, 'Henrysog', 'sotrudnik.iulia2@mailme.dk', 'Check out the newest way to make a fantastic profit. https://sog.bode-roesch.de/sog', 'Have no financial skills? Let Robot make money for you.', '2022-06-07 04:29:40', '2022-06-07 04:29:40'),
(358, 'Henrysog', 'steffenbang@mail-online.dk', 'Have no money? Earn it online. https://sog.bode-roesch.de/sog', 'The additional income is available for everyone using this robot.', '2022-06-07 07:44:09', '2022-06-07 07:44:09'),
(359, 'Henrysog', 'jwfiwf@forum.dk', 'Everyone can earn as much as he wants now. https://sog.bode-roesch.de/sog', 'Provide your family with the money in age. Launch the Robot!', '2022-06-07 10:52:28', '2022-06-07 10:52:28'),
(360, 'Henrysog', 'ziegland@forum.dk', 'Still not a millionaire? Fix it now! https://sog.bode-roesch.de/sog', 'Just one click can turn you dollar into $1000.', '2022-06-07 14:41:39', '2022-06-07 14:41:39'),
(361, 'Henrysog', 'camillaknudsen@forum.dk', 'Launch the financial Bot now to start earning. https://sog.bode-roesch.de/sog', 'The online job can bring you a fantastic profit.', '2022-06-07 17:58:34', '2022-06-07 17:58:34'),
(362, 'Henrysog', 'betriciabrandt@forum.dk', 'Every your dollar can turn into $100 after you lunch this Robot. https://sog.bode-roesch.de/sog', 'Make dollars just sitting home.', '2022-06-07 21:13:13', '2022-06-07 21:13:13'),
(363, 'Henrysog', 'dalsgaard@forum.dk', 'Still not a millionaire? The financial robot will make you him! https://sog.blueliners07.de/sog', 'Launch the robot and let it bring you money.', '2022-06-08 00:26:23', '2022-06-08 00:26:23'),
(364, 'Henrysog', 'irina19111@mailme.dk', 'Robot is the best way for everyone who looks for financial independence. https://sog.blueliners07.de/sog', 'Still not a millionaire? Fix it now!', '2022-06-08 03:43:46', '2022-06-08 03:43:46'),
(365, 'Henrysog', 'locco@mail-online.dk', 'Need cash? Launch this robot and see what it can. https://sog.blueliners07.de/sog', 'Need money? Earn it without leaving your home.', '2022-06-08 06:57:17', '2022-06-08 06:57:17'),
(366, 'Henrysog', 'dik-hansen@forum.dk', 'Earn additional money without efforts and skills. https://sog.blueliners07.de/sog', 'We have found the fastest way to be rich. Find it out here.', '2022-06-08 10:14:13', '2022-06-08 10:14:13'),
(367, 'Henrysog', 'm_r_c_h@forum.dk', 'Attention! Financial robot may bring you millions! https://sog.blueliners07.de/sog', 'Everyone can earn as much as he wants now.', '2022-06-08 13:31:36', '2022-06-08 13:31:36'),
(368, 'Henrysog', 'honto@forum.dk', 'Join the society of successful people who make money here. https://sog.blueliners07.de/sog', 'The financial Robot is your future wealth and independence.', '2022-06-08 16:50:30', '2022-06-08 16:50:30'),
(369, 'Henrysog', 'askkk20@mailme.dk', 'This robot can bring you money 24/7. https://sog.blueliners07.de/sog', 'The online income is your key to success.', '2022-06-08 20:09:38', '2022-06-08 20:09:38'),
(370, 'Henrysog', '1d112cb3e5df690adea7@mail-online.dk', 'Financial independence is what this robot guarantees. https://sog.blueliners07.de/sog', 'Need money? The financial robot is your solution.', '2022-06-08 22:20:45', '2022-06-08 22:20:45'),
(371, 'Henrysog', 'sjalen@forum.dk', 'The financial Robot works for you even when you sleep. https://sog.blueliners07.de/sog', 'Launch the robot and let it bring you money.', '2022-06-09 01:38:09', '2022-06-09 01:38:09'),
(372, 'Henrysog', 'ir.cost2011@mailme.dk', 'Robot is the best way for everyone who looks for financial independence. https://sog.blueliners07.de/sog', 'The online job can bring you a fantastic profit.', '2022-06-09 04:58:34', '2022-06-09 04:58:34'),
(373, 'Henrysog', 'd_laursen@mail-online.dk', 'Make money online, staying at home this cold winter. https://sog.blueliners07.de/sog', 'One dollar is nothing, but it can grow into $100 here.', '2022-06-09 08:25:57', '2022-06-09 08:25:57'),
(374, 'Henrysog', 'rhea.43@mailme.dk', 'No need to work anymore while you have the Robot launched! https://sog.blueliners07.de/sog', 'Watch your money grow while you invest with the Robot.', '2022-06-09 11:40:50', '2022-06-09 11:40:50'),
(375, 'Henrysog', 'tinorichard@jubiipost.dk', 'Make money, not war! Financial Robot is what you need. https://sog.blueliners07.de/sog', 'Earning money in the Internet is easy if you use Robot.', '2022-06-09 15:00:50', '2022-06-09 15:00:50'),
(376, 'Henrysog', 'morgan@forum.dk', 'Online earnings are the easiest way for financial independence. https://sog.blueliners07.de/sog', 'Need money? Get it here easily?', '2022-06-09 18:14:31', '2022-06-09 18:14:31'),
(377, 'Kevin Johnson', 'funneldeals360@gmail.com', 'Hello \r\n \r\nDo you want to get more leads for your business or increase sales within days? \r\n \r\nThen you might want to get a Sales Funnel Landing Page that will motivate prospects to take action immediately and drive more sales for your business. \r\n \r\nAnd today, we have slashed our price from $997 to just $497. So, you are saving $500 when you order a Sales Funnel this week. \r\n \r\nBut this offer is only good this week, for the first 10 clients, so you need to order now, before you miss out. \r\n \r\nTo Book A 10 Minute Call With Me, Click Here: https://bit.ly/gb360-funnel-appointment \r\n \r\nYou can get an American owned and operated professional Sales Funnel building marketing company to create a high-quality Sales Funnel for your business. \r\n \r\nDid you know: \r\n \r\n•	Sales Funnels are much more powerful than websites when it comes to conversions \r\n•	Sales Funnels average sales per visitor is 2-3 times higher per order than a standard website \r\n•	Sales Funnels are one of the most inexpensive tools to use to obtain prospect contact info \r\nAgain, this $497 promotion is for this week only. Don’t miss out!!! The normal price is $997, so today you are saving $500. Get a sales funnel today before the 10 discounted funnel slots are gone. \r\n \r\nClick Here Now To Book A 10 Minute Call With Me: https://bit.ly/gb360-funnel-appointment', 'Just a quick question', '2022-06-09 18:24:55', '2022-06-09 18:24:55'),
(378, 'Henrysog', 'arikvejs@mail-online.dk', 'Your money work even when you sleep. https://sog.blueliners07.de/sog', 'We have found the fastest way to be rich. Find it out here.', '2022-06-09 21:59:43', '2022-06-09 21:59:43'),
(379, 'Henrysog', 'duriell@mailme.dk', 'Robot never sleeps. It makes money for you 24/7. https://sog.blueliners07.de/sog', 'Thousands of bucks are guaranteed if you use this robot.', '2022-06-09 23:12:31', '2022-06-09 23:12:31'),
(380, 'Henrysog', 'jfp@mail-online.dk', 'The online job can bring you a fantastic profit. https://sog.blueliners07.de/sog', 'Need some more money? Robot will earn them really fast.', '2022-06-10 02:04:07', '2022-06-10 02:04:07'),
(381, 'Henrysog', 'finn-dinn@forum.dk', 'Wow! This Robot is a great start for an online career. https://sog.blueliners07.de/sog', 'Using this Robot is the best way to make you rich.', '2022-06-10 05:33:58', '2022-06-10 05:33:58'),
(382, 'Henrysog', 'pioner479@mailme.dk', 'The huge income without investments is available. https://sog.blueliners07.de/sog', 'Rich people are rich because they use this robot.', '2022-06-10 14:39:42', '2022-06-10 14:39:42'),
(383, 'Henrysog', 'nitten@forum.dk', 'Feel free to buy everything you want with the additional income. https://sog.blueliners07.de/sog', 'There is no need to look for a job anymore. Work online.', '2022-06-10 17:09:10', '2022-06-10 17:09:10'),
(384, 'Henrysog', 'angeli@forum.dk', 'Financial robot is a great way to manage and increase your income. https://sog.coronect.de/sog', 'Robot is the best solution for everyone who wants to earn.', '2022-06-10 19:55:10', '2022-06-10 19:55:10'),
(385, 'Henrysog', 'lundebi@forum.dk', 'Earn additional money without efforts. https://sog.coronect.de/sog', 'Make money 24/7 without any efforts and skills.', '2022-06-10 22:46:39', '2022-06-10 22:46:39'),
(386, 'FindFastBusinessFunds', 'noreply@findfastbusinessfunds.pro', 'Hi, do you know that http://FindFastBusinessFunds.pro can help your business get funding for $2,000 - $350K Without high credit or collateral. \r\n \r\nFind Out how much you can get by clicking here: \r\n \r\nhttp://FindFastBusinessFunds.pro \r\n \r\nRequirements include your company being established for at least a year and with current gross revenue of at least 120K. Eligibility and funding can be completed in as fast as 48hrs. Terms are personalized for each business so I suggest applying to find out exactly how much you can get on various terms. \r\n \r\nThis is a completely free service from a qualified funder and the approval will be based on the annual revenue of your business. These funds are completely Non-Restrictive, allowing you to spend the full amount in any way you require including business debt consolidation, hiring, marketing, or Absolutely Any Other expense. \r\n \r\nIf you need fast and easy business funding take a look at these programs now as there is limited availability: \r\n \r\nhttp://FindFastBusinessFunds.pro \r\n \r\nHave a good day, \r\nThe Find Fast Business Funds Team \r\n \r\nunsubscribe/remove - http://FindFastBusinessFunds.pro/r.php?url=citrus.ke&id=111', 'Additional Capital for Your Business, Fast', '2022-06-10 23:55:19', '2022-06-10 23:55:19'),
(387, 'Michael', 'tbformleads@gmail.com', 'Hello, \r\n \r\nI would like to schedule a quick call to discuss our marketing system that can bring you leads daily. \r\n \r\nWe use a robust email application that mimics real people sending emails, so we get a huge delivery rate. \r\n \r\nSTART GETTING HOT LEADS NOW: \r\n \r\n- We create the content for the email(s). \r\n- We forward leads to you daily. \r\n- We send to 500 new contacts a day M-F (10k monthly), then we send 5 follow up emails (that is 50k emails a month). \r\n \r\nPlus!! Monthly, we provide the 10,000 targeted new email addresses that we will email to. That email list is worth over $2,000 a month, but you get that free with our service. \r\n \r\nJust imagine, you will start getting hot leads within days of getting started with us. Get started now for a $47.00 setup fee and just $997 per month (month-to-month/no long-term contract). \r\n \r\nBook a 10 min call with me now: Click Here  (   http://www.erpgoldgroup.com/appointments/   ) \r\n \r\nNOTE: To hire a person to send one-to-one emails (like our system does) would cost around $2,500 a month, but with us, you pay just $997. \r\n \r\nOffer good for the first 20 clients, start getting quality leads now, don’t miss out.  Book appointment now: Click Here  (   http://www.erpgoldgroup.com/appointments/   ) \r\n \r\nSincerely, \r\n \r\n-	Michael', 'I have a question', '2022-06-11 01:26:10', '2022-06-11 01:26:10'),
(388, 'Henrysog', 'enur@mailme.dk', 'Check out the automatic Bot, which works for you 24/7. https://sog.coronect.de/sog', 'Feel free to buy everything you want with the additional income.', '2022-06-11 01:30:00', '2022-06-11 01:30:00'),
(389, 'Henrysog', 'ahmh@forum.dk', 'Earning $1000 a day is easy if you use this financial Robot. https://sog.coronect.de/sog', 'Financial independence is what everyone needs.', '2022-06-11 04:20:25', '2022-06-11 04:20:25'),
(390, 'Henrysog', 'martinkynde@forum.dk', 'Earning money in the Internet is easy if you use Robot. https://sog.coronect.de/sog', 'Financial independence is what everyone needs.', '2022-06-11 07:04:38', '2022-06-11 07:04:38'),
(391, 'Henrysog', 'shushpanchiki@mailme.dk', 'Your money work even when you sleep. https://sog.coronect.de/sog', 'The online job can bring you a fantastic profit.', '2022-06-11 09:56:07', '2022-06-11 09:56:07'),
(392, 'Henrysog', 'only4fun@forum.dk', 'Make money in the internet using this Bot. It really works! https://sog.coronect.de/sog', 'Only one click can grow up your money really fast.', '2022-06-11 12:47:48', '2022-06-11 12:47:48'),
(393, 'Henrysog', 'mickeydelgren@forum.dk', 'There is no need to look for a job anymore. Work online. https://sog.coronect.de/sog', 'Most successful people already use Robot. Do you?', '2022-06-11 15:36:28', '2022-06-11 15:36:28'),
(394, 'Henrysog', 'sims74@mail-online.dk', 'Thousands of bucks are guaranteed if you use this robot. https://sog.coronect.de/sog', 'Financial robot guarantees everyone stability and income.', '2022-06-11 18:24:56', '2022-06-11 18:24:56'),
(395, 'Henrysog', 'rbirkelund2@forum.dk', 'Start making thousands of dollars every week just using this robot. https://sog.coronect.de/sog', 'Everyone can earn as much as he wants now.', '2022-06-11 21:15:30', '2022-06-11 21:15:30'),
(396, 'Henrysog', 'lange@forum.dk', 'Watch your money grow while you invest with the Robot. https://sog.coronect.de/sog', 'Invest $1 today to make $1000 tomorrow.', '2022-06-11 23:56:01', '2022-06-11 23:56:01'),
(397, 'Henrysog', 'maria.c.henriksen@forum.dk', 'Trust your dollar to the Robot and see how it grows to $100. https://sog.coronect.de/sog', 'We have found the fastest way to be rich. Find it out here.', '2022-06-12 02:42:59', '2022-06-12 02:42:59'),
(398, 'Henrysog', 'brandonwong110@mailme.dk', 'Robot never sleeps. It makes money for you 24/7. https://sog.coronect.de/sog', 'Make money, not war! Financial Robot is what you need.', '2022-06-12 05:30:21', '2022-06-12 05:30:21'),
(399, 'Henrysog', 'lars9900@forum.dk', 'Need money? The financial robot is your solution. https://sog.coronect.de/sog', 'Thousands of bucks are guaranteed if you use this robot.', '2022-06-12 08:19:14', '2022-06-12 08:19:14'),
(400, 'Henrysog', 'noellie@forum.dk', 'Have no financial skills? Let Robot make money for you. https://sog.coronect.de/sog', 'Financial robot is the best companion of rich people.', '2022-06-12 11:13:00', '2022-06-12 11:13:00'),
(401, 'Henrysog', 'haier@mailme.dk', 'Financial robot is your success formula is found. Learn more about it. https://sog.coronect.de/sog', 'Let the financial Robot be your companion in the financial market.', '2022-06-12 13:58:52', '2022-06-12 13:58:52'),
(402, 'Henrysog', 'arcada083@mailme.dk', 'The online job can bring you a fantastic profit. https://sog.coronect.de/sog', 'Earning money in the Internet is easy if you use Robot.', '2022-06-12 19:35:14', '2022-06-12 19:35:14'),
(403, 'Henrysog', 'skedesvamp@forum.dk', 'Make your computer to be you earning instrument. https://sog.coronect.de/sog', 'Join the society of successful people who make money here.', '2022-06-12 22:21:10', '2022-06-12 22:21:10'),
(404, 'SdvillelinC', 'revers@o5o5.ru', '<a href=https://chimmed.ru/manufactors/catalog?name=%D0%90%D0%9E+%22%D0%A2%D0%97%D0%9C%D0%9E%D0%98%22>АО ТЗМОИ </a> \r\nTegs: Аквилон  https://chimmed.ru/manufactors/catalog?name=%D0%90%D0%BA%D0%B2%D0%B8%D0%BB%D0%BE%D0%BD  \r\n \r\n<u>Градиент-техно </u> \r\n<i>Гусевский стекольный завод им Ф Э Дзержинского </i> \r\n<b>Гусевский стекольный завод им. Ф.Э. Дзержинского </b>', 'Дастан', '2022-06-12 22:29:42', '2022-06-12 22:29:42'),
(405, 'Henrysog', 'thomaski@forum.dk', 'This robot can bring you money 24/7. https://sog.coronect.de/sog', 'Online Bot will bring you wealth and satisfaction.', '2022-06-13 01:08:07', '2022-06-13 01:08:07'),
(406, 'Henrysog', 'robertfranklin324@mailme.dk', 'Turn $1 into $100 instantly. Use the financial Robot. https://sog.coronect.de/sog', 'Only one click can grow up your money really fast.', '2022-06-13 03:54:05', '2022-06-13 03:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numcode` int(11) DEFAULT NULL,
  `phonecode` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `iso`, `iso3`, `numcode`, `phonecode`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AFGHANISTAN', 'AF', 'AFG', 4, 93, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(2, 'ALBANIA', 'AL', 'ALB', 8, 355, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(3, 'ALGERIA', 'DZ', 'DZA', 12, 213, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(4, 'AMERICAN SAMOA', 'AS', 'ASM', 16, 1684, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(5, 'ANDORRA', 'AD', 'AND', 20, 376, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(6, 'ANGOLA', 'AO', 'AGO', 24, 244, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(7, 'ANGUILLA', 'AI', 'AIA', 660, 1264, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(8, 'ANTARCTICA', 'AQ', NULL, NULL, 0, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(9, 'ANTIGUA AND BARBUDA', 'AG', 'ATG', 28, 1268, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(10, 'ARGENTINA', 'AR', 'ARG', 32, 54, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(11, 'ARMENIA', 'AM', 'ARM', 51, 374, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(12, 'ARUBA', 'AW', 'ABW', 533, 297, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(13, 'AUSTRALIA', 'AU', 'AUS', 36, 61, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(14, 'AUSTRIA', 'AT', 'AUT', 40, 43, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(15, 'AZERBAIJAN', 'AZ', 'AZE', 31, 994, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(16, 'BAHAMAS', 'BS', 'BHS', 44, 1242, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(17, 'BAHRAIN', 'BH', 'BHR', 48, 973, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(18, 'BANGLADESH', 'BD', 'BGD', 50, 880, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(19, 'BARBADOS', 'BB', 'BRB', 52, 1246, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(20, 'BELARUS', 'BY', 'BLR', 112, 375, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(21, 'BELGIUM', 'BE', 'BEL', 56, 32, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(22, 'BELIZE', 'BZ', 'BLZ', 84, 501, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(23, 'BENIN', 'BJ', 'BEN', 204, 229, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(24, 'BERMUDA', 'BM', 'BMU', 60, 1441, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(25, 'BHUTAN', 'BT', 'BTN', 64, 975, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(26, 'BOLIVIA', 'BO', 'BOL', 68, 591, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(27, 'BOSNIA AND HERZEGOVINA', 'BA', 'BIH', 70, 387, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(28, 'BOTSWANA', 'BW', 'BWA', 72, 267, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(29, 'BOUVET ISLAND', 'BV', NULL, NULL, 0, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(30, 'BRAZIL', 'BR', 'BRA', 76, 55, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(31, 'BRITISH INDIAN OCEAN TERRITORY', 'IO', NULL, NULL, 246, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(32, 'BRUNEI DARUSSALAM', 'BN', 'BRN', 96, 673, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(33, 'BULGARIA', 'BG', 'BGR', 100, 359, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(34, 'BURKINA FASO', 'BF', 'BFA', 854, 226, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(35, 'BURUNDI', 'BI', 'BDI', 108, 257, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(36, 'CAMBODIA', 'KH', 'KHM', 116, 855, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(37, 'CAMEROON', 'CM', 'CMR', 120, 237, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(38, 'CANADA', 'CA', 'CAN', 124, 1, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(39, 'CAPE VERDE', 'CV', 'CPV', 132, 238, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(40, 'CAYMAN ISLANDS', 'KY', 'CYM', 136, 1345, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(41, 'CENTRAL AFRICAN REPUBLIC', 'CF', 'CAF', 140, 236, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(42, 'CHAD', 'TD', 'TCD', 148, 235, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(43, 'CHILE', 'CL', 'CHL', 152, 56, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(44, 'CHINA', 'CN', 'CHN', 156, 86, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(45, 'CHRISTMAS ISLAND', 'CX', NULL, NULL, 61, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(46, 'COCOS (KEELING) ISLANDS', 'CC', NULL, NULL, 672, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(47, 'COLOMBIA', 'CO', 'COL', 170, 57, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(48, 'COMOROS', 'KM', 'COM', 174, 269, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(49, 'CONGO', 'CG', 'COG', 178, 242, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(50, 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'CD', 'COD', 180, 242, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(51, 'COOK ISLANDS', 'CK', 'COK', 184, 682, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(52, 'COSTA RICA', 'CR', 'CRI', 188, 506, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(53, 'COTE D\'IVOIRE', 'CI', 'CIV', 384, 225, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(54, 'CROATIA', 'HR', 'HRV', 191, 385, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(55, 'CUBA', 'CU', 'CUB', 192, 53, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(56, 'CYPRUS', 'CY', 'CYP', 196, 357, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(57, 'CZECH REPUBLIC', 'CZ', 'CZE', 203, 420, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(58, 'DENMARK', 'DK', 'DNK', 208, 45, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(59, 'DJIBOUTI', 'DJ', 'DJI', 262, 253, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(60, 'DOMINICA', 'DM', 'DMA', 212, 1767, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(61, 'DOMINICAN REPUBLIC', 'DO', 'DOM', 214, 1809, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(62, 'ECUADOR', 'EC', 'ECU', 218, 593, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(63, 'EGYPT', 'EG', 'EGY', 818, 20, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(64, 'EL SALVADOR', 'SV', 'SLV', 222, 503, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(65, 'EQUATORIAL GUINEA', 'GQ', 'GNQ', 226, 240, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(66, 'ERITREA', 'ER', 'ERI', 232, 291, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(67, 'ESTONIA', 'EE', 'EST', 233, 372, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(68, 'ETHIOPIA', 'ET', 'ETH', 231, 251, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(69, 'FALKLAND ISLANDS (MALVINAS)', 'FK', 'FLK', 238, 500, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(70, 'FAROE ISLANDS', 'FO', 'FRO', 234, 298, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(71, 'FIJI', 'FJ', 'FJI', 242, 679, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(72, 'FINLAND', 'FI', 'FIN', 246, 358, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(73, 'FRANCE', 'FR', 'FRA', 250, 33, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(74, 'FRENCH GUIANA', 'GF', 'GUF', 254, 594, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(75, 'FRENCH POLYNESIA', 'PF', 'PYF', 258, 689, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(76, 'FRENCH SOUTHERN TERRITORIES', 'TF', NULL, NULL, 0, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(77, 'GABON', 'GA', 'GAB', 266, 241, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(78, 'GAMBIA', 'GM', 'GMB', 270, 220, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(79, 'GEORGIA', 'GE', 'GEO', 268, 995, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(80, 'GERMANY', 'DE', 'DEU', 276, 49, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(81, 'GHANA', 'GH', 'GHA', 288, 233, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(82, 'GIBRALTAR', 'GI', 'GIB', 292, 350, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(83, 'GREECE', 'GR', 'GRC', 300, 30, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(84, 'GREENLAND', 'GL', 'GRL', 304, 299, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(85, 'GRENADA', 'GD', 'GRD', 308, 1473, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(86, 'GUADELOUPE', 'GP', 'GLP', 312, 590, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(87, 'GUAM', 'GU', 'GUM', 316, 1671, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(88, 'GUATEMALA', 'GT', 'GTM', 320, 502, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(89, 'GUINEA', 'GN', 'GIN', 324, 224, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(90, 'GUINEA-BISSAU', 'GW', 'GNB', 624, 245, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(91, 'GUYANA', 'GY', 'GUY', 328, 592, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(92, 'HAITI', 'HT', 'HTI', 332, 509, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(93, 'HEARD ISLAND AND MCDONALD ISLANDS', 'HM', NULL, NULL, 0, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(94, 'HOLY SEE (VATICAN CITY STATE)', 'VA', 'VAT', 336, 39, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(95, 'HONDURAS', 'HN', 'HND', 340, 504, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(96, 'HONG KONG', 'HK', 'HKG', 344, 852, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(97, 'HUNGARY', 'HU', 'HUN', 348, 36, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(98, 'ICELAND', 'IS', 'ISL', 352, 354, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(99, 'INDIA', 'IN', 'IND', 356, 91, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(100, 'INDONESIA', 'ID', 'IDN', 360, 62, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(101, 'IRAN, ISLAMIC REPUBLIC OF', 'IR', 'IRN', 364, 98, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(102, 'IRAQ', 'IQ', 'IRQ', 368, 964, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(103, 'IRELAND', 'IE', 'IRL', 372, 353, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(104, 'ISRAEL', 'IL', 'ISR', 376, 972, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(105, 'ITALY', 'IT', 'ITA', 380, 39, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(106, 'JAMAICA', 'JM', 'JAM', 388, 1876, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(107, 'JAPAN', 'JP', 'JPN', 392, 81, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(108, 'JORDAN', 'JO', 'JOR', 400, 962, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(109, 'KAZAKHSTAN', 'KZ', 'KAZ', 398, 7, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(110, 'KENYA', 'KE', 'KEN', 404, 254, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(111, 'KIRIBATI', 'KI', 'KIR', 296, 686, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(112, 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'KP', 'PRK', 408, 850, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(113, 'KOREA, REPUBLIC OF', 'KR', 'KOR', 410, 82, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(114, 'KUWAIT', 'KW', 'KWT', 414, 965, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(115, 'KYRGYZSTAN', 'KG', 'KGZ', 417, 996, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(116, 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'LA', 'LAO', 418, 856, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(117, 'LATVIA', 'LV', 'LVA', 428, 371, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(118, 'LEBANON', 'LB', 'LBN', 422, 961, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(119, 'LESOTHO', 'LS', 'LSO', 426, 266, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(120, 'LIBERIA', 'LR', 'LBR', 430, 231, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(121, 'LIBYAN ARAB JAMAHIRIYA', 'LY', 'LBY', 434, 218, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(122, 'LIECHTENSTEIN', 'LI', 'LIE', 438, 423, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(123, 'LITHUANIA', 'LT', 'LTU', 440, 370, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(124, 'LUXEMBOURG', 'LU', 'LUX', 442, 352, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(125, 'MACAO', 'MO', 'MAC', 446, 853, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(126, 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'MK', 'MKD', 807, 389, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(127, 'MADAGASCAR', 'MG', 'MDG', 450, 261, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(128, 'MALAWI', 'MW', 'MWI', 454, 265, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(129, 'MALAYSIA', 'MY', 'MYS', 458, 60, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(130, 'MALDIVES', 'MV', 'MDV', 462, 960, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(131, 'MALI', 'ML', 'MLI', 466, 223, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(132, 'MALTA', 'MT', 'MLT', 470, 356, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(133, 'MARSHALL ISLANDS', 'MH', 'MHL', 584, 692, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(134, 'MARTINIQUE', 'MQ', 'MTQ', 474, 596, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(135, 'MAURITANIA', 'MR', 'MRT', 478, 222, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(136, 'MAURITIUS', 'MU', 'MUS', 480, 230, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(137, 'MAYOTTE', 'YT', NULL, NULL, 269, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(138, 'MEXICO', 'MX', 'MEX', 484, 52, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(139, 'MICRONESIA, FEDERATED STATES OF', 'FM', 'FSM', 583, 691, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(140, 'MOLDOVA, REPUBLIC OF', 'MD', 'MDA', 498, 373, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(141, 'MONACO', 'MC', 'MCO', 492, 377, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(142, 'MONGOLIA', 'MN', 'MNG', 496, 976, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(143, 'MONTSERRAT', 'MS', 'MSR', 500, 1664, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(144, 'MOROCCO', 'MA', 'MAR', 504, 212, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(145, 'MOZAMBIQUE', 'MZ', 'MOZ', 508, 258, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(146, 'MYANMAR', 'MM', 'MMR', 104, 95, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(147, 'NAMIBIA', 'NA', 'NAM', 516, 264, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(148, 'NAURU', 'NR', 'NRU', 520, 674, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(149, 'NEPAL', 'NP', 'NPL', 524, 977, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(150, 'NETHERLANDS', 'NL', 'NLD', 528, 31, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(151, 'NETHERLANDS ANTILLES', 'AN', 'ANT', 530, 599, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(152, 'NEW CALEDONIA', 'NC', 'NCL', 540, 687, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(153, 'NEW ZEALAND', 'NZ', 'NZL', 554, 64, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(154, 'NICARAGUA', 'NI', 'NIC', 558, 505, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(155, 'NIGER', 'NE', 'NER', 562, 227, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(156, 'NIGERIA', 'NG', 'NGA', 566, 234, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(157, 'NIUE', 'NU', 'NIU', 570, 683, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(158, 'NORFOLK ISLAND', 'NF', 'NFK', 574, 672, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(159, 'NORTHERN MARIANA ISLANDS', 'MP', 'MNP', 580, 1670, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(160, 'NORWAY', 'NO', 'NOR', 578, 47, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(161, 'OMAN', 'OM', 'OMN', 512, 968, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(162, 'PAKISTAN', 'PK', 'PAK', 586, 92, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(163, 'PALAU', 'PW', 'PLW', 585, 680, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(164, 'PALESTINIAN TERRITORY, OCCUPIED', 'PS', NULL, NULL, 970, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(165, 'PANAMA', 'PA', 'PAN', 591, 507, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(166, 'PAPUA NEW GUINEA', 'PG', 'PNG', 598, 675, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(167, 'PARAGUAY', 'PY', 'PRY', 600, 595, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(168, 'PERU', 'PE', 'PER', 604, 51, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(169, 'PHILIPPINES', 'PH', 'PHL', 608, 63, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(170, 'PITCAIRN', 'PN', 'PCN', 612, 0, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(171, 'POLAND', 'PL', 'POL', 616, 48, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(172, 'PORTUGAL', 'PT', 'PRT', 620, 351, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(173, 'PUERTO RICO', 'PR', 'PRI', 630, 1787, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(174, 'QATAR', 'QA', 'QAT', 634, 974, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(175, 'REUNION', 'RE', 'REU', 638, 262, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(176, 'ROMANIA', 'RO', 'ROM', 642, 40, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(177, 'RUSSIAN FEDERATION', 'RU', 'RUS', 643, 70, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(178, 'RWANDA', 'RW', 'RWA', 646, 250, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(179, 'SAINT HELENA', 'SH', 'SHN', 654, 290, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(180, 'SAINT KITTS AND NEVIS', 'KN', 'KNA', 659, 1869, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(181, 'SAINT LUCIA', 'LC', 'LCA', 662, 1758, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(182, 'SAINT PIERRE AND MIQUELON', 'PM', 'SPM', 666, 508, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(183, 'SAINT VINCENT AND THE GRENADINES', 'VC', 'VCT', 670, 1784, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(184, 'SAMOA', 'WS', 'WSM', 882, 684, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(185, 'SAN MARINO', 'SM', 'SMR', 674, 378, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(186, 'SAO TOME AND PRINCIPE', 'ST', 'STP', 678, 239, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(187, 'SAUDI ARABIA', 'SA', 'SAU', 682, 966, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(188, 'SENEGAL', 'SN', 'SEN', 686, 221, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(189, 'SERBIA AND MONTENEGRO', 'CS', NULL, NULL, 381, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(190, 'SEYCHELLES', 'SC', 'SYC', 690, 248, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(191, 'SIERRA LEONE', 'SL', 'SLE', 694, 232, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(192, 'SINGAPORE', 'SG', 'SGP', 702, 65, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(193, 'SLOVAKIA', 'SK', 'SVK', 703, 421, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(194, 'SLOVENIA', 'SI', 'SVN', 705, 386, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(195, 'SOLOMON ISLANDS', 'SB', 'SLB', 90, 677, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(196, 'SOMALIA', 'SO', 'SOM', 706, 252, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(197, 'SOUTH AFRICA', 'ZA', 'ZAF', 710, 27, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(198, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'GS', NULL, NULL, 0, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(199, 'SPAIN', 'ES', 'ESP', 724, 34, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(200, 'SRI LANKA', 'LK', 'LKA', 144, 94, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(201, 'SUDAN', 'SD', 'SDN', 736, 249, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(202, 'SURINAME', 'SR', 'SUR', 740, 597, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(203, 'SVALBARD AND JAN MAYEN', 'SJ', 'SJM', 744, 47, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(204, 'SWAZILAND', 'SZ', 'SWZ', 748, 268, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(205, 'SWEDEN', 'SE', 'SWE', 752, 46, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(206, 'SWITZERLAND', 'CH', 'CHE', 756, 41, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(207, 'SYRIAN ARAB REPUBLIC', 'SY', 'SYR', 760, 963, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(208, 'TAIWAN, PROVINCE OF CHINA', 'TW', 'TWN', 158, 886, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(209, 'TAJIKISTAN', 'TJ', 'TJK', 762, 992, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(210, 'TANZANIA, UNITED REPUBLIC OF', 'TZ', 'TZA', 834, 255, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(211, 'THAILAND', 'TH', 'THA', 764, 66, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(212, 'TIMOR-LESTE', 'TL', NULL, NULL, 670, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(213, 'TOGO', 'TG', 'TGO', 768, 228, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(214, 'TOKELAU', 'TK', 'TKL', 772, 690, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(215, 'TONGA', 'TO', 'TON', 776, 676, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(216, 'TRINIDAD AND TOBAGO', 'TT', 'TTO', 780, 1868, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(217, 'TUNISIA', 'TN', 'TUN', 788, 216, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(218, 'TURKEY', 'TR', 'TUR', 792, 90, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(219, 'TURKMENISTAN', 'TM', 'TKM', 795, 7370, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(220, 'TURKS AND CAICOS ISLANDS', 'TC', 'TCA', 796, 1649, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(221, 'TUVALU', 'TV', 'TUV', 798, 688, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(222, 'UGANDA', 'UG', 'UGA', 800, 256, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(223, 'UKRAINE', 'UA', 'UKR', 804, 380, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(224, 'UNITED ARAB EMIRATES', 'AE', 'ARE', 784, 971, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(225, 'UNITED KINGDOM', 'GB', 'GBR', 826, 44, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(226, 'UNITED STATES OF AMERICA', 'US', 'USA', 840, 1, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(227, 'UNITED STATES MINOR OUTLYING ISLANDS', 'UM', NULL, NULL, 1, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(228, 'URUGUAY', 'UY', 'URY', 858, 598, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(229, 'UZBEKISTAN', 'UZ', 'UZB', 860, 998, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(230, 'VANUATU', 'VU', 'VUT', 548, 678, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(231, 'VENEZUELA', 'VE', 'VEN', 862, 58, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(232, 'VIET NAM', 'VN', 'VNM', 704, 84, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(233, 'VIRGIN ISLANDS, BRITISH', 'VG', 'VGB', 92, 1284, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(234, 'VIRGIN ISLANDS, U.S.', 'VI', 'VIR', 850, 1340, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(235, 'WALLIS AND FUTUNA', 'WF', 'WLF', 876, 681, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(236, 'WESTERN SAHARA', 'EH', 'ESH', 732, 212, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(237, 'YEMEN', 'YE', 'YEM', 887, 967, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(238, 'ZAMBIA', 'ZM', 'ZMB', 894, 260, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(239, 'ZIMBABWE', 'ZW', 'ZWE', 716, 263, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_free` int(11) NOT NULL,
  `cost` decimal(8,2) DEFAULT '0.00',
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `description`, `url`, `is_free`, `cost`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Free Shipping', 'Free Shipping', 'https://dietrich.com/odit-totam-iusto-vel-consequatur-omnis-eligendi-et.html', 1, '0.00', 1, '2021-06-20 09:17:54', '2021-06-20 09:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `merchant_id` int(11) DEFAULT NULL,
  `citrus_merchant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `shop_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `status`, `merchant_id`, `citrus_merchant_id`, `role`, `deleted_at`, `remember_token`, `type`, `shop_id`, `created_at`, `updated_at`, `avatar`, `phone`, `bio`) VALUES
(1, 'Paul Nderitu', 'superadmin@example.com', '$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.', 1, NULL, NULL, '0', NULL, 'MpSkiYGlVP', 0, NULL, '2021-06-20 09:17:53', '2021-09-22 10:39:07', 'Logo 2 JPG.jpg', '0712400000', 'Lorum ipsum dolor sit amet, lorum ipsum dolor sit amet, Lorum ipsum dolor sit amet'),
(2, 'Junior', 'staff@example.com', '$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.', 1, 1, NULL, '1', NULL, 'lKNQq8e3Lw', 1, NULL, '2021-06-20 09:17:53', '2021-06-20 09:17:53', NULL, '1234567690', 'Lorum ipsum dolor sit amet, lorum ipsum dolor sit amet, Lorum ipsum dolor sit amet'),
(3, 'Subadmin', 'subadmin@example.com', '$2y$10$6ELo3zxz3Owxj.srf2hdNe21jyeLho7LpN7VngCXSmsvXcHrtV4O.', 1, NULL, NULL, '2', NULL, 'lKNQq8e3Lw', 2, NULL, '2021-06-20 09:17:53', '2021-07-20 10:53:15', 'musclemorphapp_logo.png', '1232567290', 'Lorum ipsum dolor sit amet, lorum ipsum dolor sit amet, Lorum ipsum dolor sit amet'),
(11, 'Gallery.php', 'usecxr@example.com', '$2y$10$kTnTqyE8IaLpQooR0b7HrOusGYfKe8akR1mI9Sm5er9P3/sJQ5KiG', 1, NULL, NULL, '2', NULL, NULL, 2, NULL, '2021-07-20 10:59:14', '2021-07-20 10:59:14', 'sup2.jpg', '5638658633', 'xvcv'),
(12, 'tester', 'subhashj255@gmail.com', '$2y$10$qEvgrNu9YkngvbUk5/qa6.Zg7BiIQwCfR7OgpiVXKGO6zR9iaZERe', 1, 17, 'SK038417', '0', NULL, NULL, 1, NULL, '2021-09-24 07:31:00', '2021-09-24 07:31:00', NULL, '7763050951', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feature_settings`
--

CREATE TABLE `feature_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feature_settings`
--

INSERT INTO `feature_settings` (`id`, `banner_image`, `title`, `subtitle`, `order`, `button_link`, `button_text`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Victoria Products & Services', 'on sale up to', 1, 'category/services', 'Shop Now', 1, NULL, NULL),
(2, NULL, 'Comox Valley Products & Services', 'on sale up to', 2, 'category/services', 'Shop Now', 1, NULL, NULL),
(3, NULL, 'Nanaimo Products & Services', 'on sale up to', 3, 'category/services', 'Shop Now', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `footers`
--

CREATE TABLE `footers` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footers`
--

INSERT INTO `footers` (`id`, `type`, `title`, `link`, `created_at`, `updated_at`) VALUES
(1, 0, 'Orders & Returns', 'accounts?tab=v-pills-my-order', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, 0, 'Account Settings', 'accounts?tab=v-pills-account-details', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(3, 0, 'Vendor Login', 'vendor/login', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(4, 0, 'Staff Login', 'admin/login', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(5, 1, 'Customer Care', 'contact-us', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(6, 1, 'Shipping Information', 'shipping_info', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(7, 1, 'Return Policy', 'return_policy', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(8, 1, 'International Help', 'internat_help', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(9, 1, 'Accessibility', 'accessibility', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(10, 2, 'Contact Us', 'contact-us', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(11, 2, 'Buyvi.ca Mission', 'mission', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(12, 2, 'Terms and Conditions', 'http://127.0.0.1:8000/pdf/BuyVi_Terms_and_Conditions.pdf', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(13, 2, 'Become a Vendor', 'vendor/register', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(14, 2, 'Start Shopping', 'http://127.0.0.1:8000', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(15, 2, 'All Vendors', 'allvendors', '2021-06-20 14:47:54', '2021-06-20 14:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image`, `merchant_id`, `created_at`, `updated_at`) VALUES
(8, '162662316110.jpg', 1, '2021-07-18 15:46:01', '0000-00-00 00:00:00'),
(12, '162662495326.jpg', 1, '2021-07-18 16:15:54', '0000-00-00 00:00:00'),
(13, '162662495455.jpg', 1, '2021-07-18 16:15:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) DEFAULT NULL,
  `package_expire` text COLLATE utf8mb4_unicode_ci,
  `monthly_initial_price` decimal(8,2) DEFAULT NULL,
  `monthly_recurring_price` decimal(8,2) DEFAULT NULL,
  `yearly_initial_price` decimal(8,2) DEFAULT NULL,
  `yearly_recurring_price` decimal(8,2) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `quantity` text COLLATE utf8mb4_unicode_ci,
  `display_product` int(11) DEFAULT NULL,
  `purchase_product` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `feature_list` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `name`, `price`, `package_expire`, `monthly_initial_price`, `monthly_recurring_price`, `yearly_initial_price`, `yearly_recurring_price`, `tax_id`, `quantity`, `display_product`, `purchase_product`, `description`, `feature_list`, `created_at`, `updated_at`) VALUES
(1, 'Silver', '1000.00', '1 Month', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Promote your brand and unlimited products through Citrus', NULL, '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, 'Gold', '5000.00', '6 Month', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Full Ecommerce capabilities to promote your brand and Sell Unlimited Products through Citrus.', NULL, '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(3, 'Diamond', '10000.00', '1 Year', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Full Ecommerce capabilities to promote your brand and Sell Unlimited Products through Citrus.', NULL, '2021-06-20 14:47:54', '2021-06-20 14:47:54');

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
(1, '2014_10_12_000000_create_customers_table', 1),
(2, '2014_10_12_000010_create_employees_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2016_05_26_020731_create_country_table', 1),
(5, '2016_05_26_035202_create_provinces_table', 1),
(6, '2016_05_26_051502_create_cities_table', 1),
(7, '2017_06_10_225235_create_products_table', 1),
(8, '2017_06_11_015526_create_categories_table', 1),
(9, '2017_06_11_033553_create_category_product_table', 1),
(10, '2017_06_11_073305_create_address_table', 1),
(11, '2017_06_12_225546_create_order_status_table', 1),
(12, '2017_06_13_044714_create_couriers_table', 1),
(13, '2017_06_13_053346_create_orders_table', 1),
(14, '2017_06_13_091740_create_order_products_table', 1),
(15, '2017_06_17_011245_create_shoppingcart_table', 1),
(16, '2018_01_18_163143_create_product_images_table', 1),
(17, '2018_02_19_151228_create_cost_column', 1),
(18, '2018_03_10_024148_laratrust_setup_tables', 1),
(19, '2018_03_10_110530_create_attributes_table', 1),
(20, '2018_03_10_150920_create_attribute_values_table', 1),
(21, '2018_03_11_014046_create_product_attributes_table', 1),
(22, '2018_03_11_090249_create_attribute_value_product_attribute_table', 1),
(23, '2018_03_15_232344_create_customer_subscription_table', 1),
(24, '2018_06_16_000410_add_fields_on_order_product_table', 1),
(25, '2018_06_16_102641_create_brands_table', 1),
(26, '2018_06_17_175657_add_brand_id_in_products_table', 1),
(27, '2018_06_18_135142_add_columns_in_product_attributes_table', 1),
(28, '2018_06_30_041523_add_product_attributes', 1),
(29, '2018_07_03_023925_create_states_table', 1),
(30, '2018_07_16_184224_add_phone_number_in_address_table', 1),
(31, '2018_07_16_190024_add_tracking_number_and_label_url_to_orders_table', 1),
(32, '2018_07_17_184437_add_sale_price_in_products_table', 1),
(33, '2018_11_06_031246_add_product_attribute_id_column_in_order_product_table', 1),
(34, '2018_11_06_123452_add_total_shipping_in_orders_table', 1),
(35, '2020_09_24_102333_avatar', 1),
(36, '2020_09_24_104427_add_avatar_to_employees', 1),
(37, '2020_09_25_064316_add_avatar_to_customers_table', 1),
(38, '2020_09_25_130421_create_product_ratings_table', 1),
(39, '2020_09_25_130840_add_phone_to_customers_table', 1),
(40, '2020_09_30_125046_add_phone_to_employees_table', 1),
(41, '2020_10_01_072110_create_vendors_table', 1),
(42, '2020_10_05_054029_create_contact_table', 1),
(43, '2020_10_06_092340_create_vendor_business_details_table', 1),
(44, '2020_10_10_045135_create_tax_rates_table', 1),
(45, '2020_10_14_052412_add_created_by_to_categories', 1),
(46, '2020_10_15_090146_add_bio_to_employees_table', 1),
(47, '2020_10_21_042510_add_extra_fields_to_products_table', 1),
(48, '2020_10_22_074746_add_display_name_to_customers_table', 1),
(49, '2020_11_09_070345_create_banner_settings_table', 1),
(50, '2020_11_09_071349_create_feature_settings_table', 1),
(51, '2020_11_20_070922_create_memberships_table', 1),
(52, '2020_11_23_064753_create_vendor_msg_table', 1),
(53, '2020_12_02_044042_create_users_table', 1),
(54, '2020_12_02_044259_create_plan_in', 1),
(55, '2020_12_09_103852_create_vendorplan_info_table', 1),
(56, '2020_12_15_045105_create_order_payment_table', 1),
(57, '2020_12_21_124644_drop_brands_table', 1),
(58, '2020_12_28_083422_create_wishlist_table', 1),
(59, '2020_12_31_132121_create_vendor_canadian_posts_table', 1),
(60, '2021_01_19_071219_create_footers_table', 1),
(61, '2021_05_04_121451_create_business_type_table', 1),
(62, '2021_05_20_101410_create_shops_table', 1),
(63, '2021_05_25_052143_create_sociallinks_table', 1),
(64, '2021_06_20_085335_create_blogs_table', 1),
(65, '2021_06_20_114415_create_testimonials_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_id` int(10) UNSIGNED NOT NULL,
  `courier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `address_id` int(10) UNSIGNED NOT NULL,
  `delivery_address` int(10) UNSIGNED DEFAULT NULL,
  `order_status_id` int(10) UNSIGNED NOT NULL,
  `payouts` int(11) NOT NULL DEFAULT '0',
  `release_date` date DEFAULT NULL,
  `vendor_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discounts` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_products` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_shipping` decimal(8,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total` decimal(8,2) NOT NULL,
  `total_paid` decimal(8,2) NOT NULL DEFAULT '0.00',
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `reference`, `courier_id`, `courier`, `customer_id`, `address_id`, `delivery_address`, `order_status_id`, `payouts`, `release_date`, `vendor_id`, `payment`, `discounts`, `total_products`, `total_shipping`, `tax`, `total`, `total_paid`, `invoice`, `label_url`, `tracking_number`, `add_info`, `date`, `token`, `created_at`, `updated_at`) VALUES
(1, '59638', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '44.00', '0.00', NULL, NULL, NULL, NULL, '2021-06-26', 'ORD0', '2021-06-26 16:34:27', '2021-06-26 16:34:27'),
(2, '38776', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[9]', '20.00', '0.00', '80.00', '0.00', NULL, NULL, NULL, NULL, '2021-06-28', 'ORD1', '2021-06-28 16:52:56', '2021-06-28 16:52:56'),
(3, '77302', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[10]', '20.00', '0.00', '42.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-02', 'ORD2', '2021-07-02 09:58:45', '2021-07-02 09:58:45'),
(4, '59814', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[13]', '20.00', '0.00', '42.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-02', 'ORD3', '2021-07-02 11:28:39', '2021-07-02 11:28:39'),
(5, '96702', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1,2]', 'stripe', '0.00', '[13,11]', '40.00', '0.00', '75.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-05', 'ORD4', '2021-07-05 08:18:11', '2021-07-05 08:18:11'),
(6, '70560', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[14]', '20.00', '0.00', '43.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-07', 'ORD5', '2021-07-07 04:56:49', '2021-07-07 04:56:49'),
(7, '36518', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[10]', '20.00', '0.00', '42.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-10', 'ORD6', '2021-07-09 18:56:03', '2021-07-09 18:56:03'),
(8, '41817', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2,1]', 'stripe', '0.00', '[11,10,13]', '60.00', '0.00', '117.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-10', 'ORD7', '2021-07-10 08:41:23', '2021-07-10 08:41:23'),
(9, '18534', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '68.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-11', 'ORD8', '2021-07-11 17:58:36', '2021-07-11 17:58:36'),
(10, '17174', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '44.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-11', 'ORD9', '2021-07-11 18:20:16', '2021-07-11 18:20:16'),
(11, '18707', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '44.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-11', 'ORD10', '2021-07-11 18:22:31', '2021-07-11 18:22:31'),
(12, '22033', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '44.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-11', 'ORD11', '2021-07-11 18:26:08', '2021-07-11 18:26:08'),
(13, '90197', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[12]', '20.00', '0.00', '37.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-13', 'ORD12', '2021-07-13 14:44:24', '2021-07-13 14:44:24'),
(14, '34431', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[9]', '20.00', '0.00', '40.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-14', 'ORD13', '2021-07-14 13:41:35', '2021-07-14 13:41:35'),
(15, '87264', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[1]', '0.00', '0.00', '100.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-15', 'ORD14', '2021-07-15 10:40:43', '2021-07-15 10:40:43'),
(16, '96427', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '44.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-15', 'ORD15', '2021-07-15 14:08:04', '2021-07-15 14:08:04'),
(17, '93892', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[8]', '20.00', '0.00', '41.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-20', 'ORD16', '2021-07-20 10:48:04', '2021-07-20 10:48:04'),
(18, '61525', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[8]', '20.00', '0.00', '41.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-20', 'ORD17', '2021-07-20 18:14:12', '2021-07-20 18:14:12'),
(19, '86854', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '116.00', '0.00', NULL, NULL, NULL, NULL, '2021-07-24', 'ORD18', '2021-07-24 12:19:58', '2021-07-24 12:19:58'),
(20, '71873', 1, NULL, 1, 1, 1, 3, 0, NULL, '[2]', 'stripe', '0.00', '[11]', '20.00', '0.00', '44.00', '0.00', NULL, NULL, NULL, NULL, '2021-08-07', 'ORD19', '2021-08-07 11:09:55', '2021-08-07 11:09:55'),
(21, '97745', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[1]', '0.00', '0.00', '100.00', '0.00', NULL, NULL, NULL, NULL, '2021-08-17', 'ORD20', '2021-08-17 05:57:03', '2021-08-17 05:57:03'),
(22, '96108', 1, NULL, 1, 1, 1, 3, 0, NULL, '[17]', 'stripe', '0.00', '[20]', '0.00', '0.00', '120.00', '0.00', NULL, NULL, NULL, NULL, '2021-09-24', 'ORD21', '2021-09-24 21:41:56', '2021-09-24 21:41:56'),
(26, '13483', 1, NULL, 1, 1, 1, 3, 0, NULL, '[17]', 'stripe', '0.00', '[20]', '0.00', '0.00', '120.00', '0.00', NULL, NULL, NULL, NULL, '2021-09-25', 'ORD22', '2021-09-25 22:43:15', '2021-09-25 22:43:15'),
(32, '59432', 1, NULL, 1, 1, 1, 3, 0, NULL, '[1]', 'stripe', '0.00', '[16]', '11.00', '0.00', '156.00', '0.00', NULL, NULL, NULL, NULL, '2021-09-29', 'ORD23', '2021-09-29 13:39:53', '2021-09-29 13:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_payment`
--

CREATE TABLE `order_payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `stripe_response` text COLLATE utf8mb4_unicode_ci,
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_payment`
--

INSERT INTO `order_payment` (`id`, `user_id`, `order_id`, `name`, `card_brand`, `stripe_id`, `amount`, `stripe_response`, `token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, '44.00', NULL, 'ORD0', '2021-06-26 16:34:27', '2021-06-26 16:34:27'),
(2, 1, 2, NULL, NULL, NULL, '80.00', NULL, 'ORD1', '2021-06-28 16:52:56', '2021-06-28 16:52:56'),
(3, 1, 3, NULL, NULL, NULL, '42.00', NULL, 'ORD2', '2021-07-02 09:58:45', '2021-07-02 09:58:45'),
(4, 1, 4, NULL, NULL, NULL, '42.00', NULL, 'ORD3', '2021-07-02 11:28:39', '2021-07-02 11:28:39'),
(5, 1, 5, NULL, NULL, NULL, '75.00', NULL, 'ORD4', '2021-07-05 08:18:11', '2021-07-05 08:18:11'),
(6, 1, 6, NULL, NULL, NULL, '43.00', NULL, 'ORD5', '2021-07-07 04:56:49', '2021-07-07 04:56:49'),
(7, 1, 7, NULL, NULL, NULL, '42.00', NULL, 'ORD6', '2021-07-09 18:56:03', '2021-07-09 18:56:03'),
(8, 1, 8, NULL, NULL, NULL, '117.00', NULL, 'ORD7', '2021-07-10 08:41:23', '2021-07-10 08:41:23'),
(9, 1, 9, NULL, NULL, NULL, '68.00', NULL, 'ORD8', '2021-07-11 17:58:36', '2021-07-11 17:58:36'),
(10, 1, 10, NULL, NULL, NULL, '44.00', NULL, 'ORD9', '2021-07-11 18:20:16', '2021-07-11 18:20:16'),
(11, 1, 11, NULL, NULL, NULL, '44.00', NULL, 'ORD10', '2021-07-11 18:22:31', '2021-07-11 18:22:31'),
(12, 1, 12, NULL, NULL, NULL, '44.00', NULL, 'ORD11', '2021-07-11 18:26:08', '2021-07-11 18:26:08'),
(13, 1, 13, NULL, NULL, NULL, '37.00', NULL, 'ORD12', '2021-07-13 14:44:24', '2021-07-13 14:44:24'),
(14, 1, 14, NULL, NULL, NULL, '40.00', NULL, 'ORD13', '2021-07-14 13:41:35', '2021-07-14 13:41:35'),
(15, 1, 15, NULL, NULL, NULL, '100.00', NULL, 'ORD14', '2021-07-15 10:40:43', '2021-07-15 10:40:43'),
(16, 1, 16, NULL, NULL, NULL, '44.00', NULL, 'ORD15', '2021-07-15 14:08:04', '2021-07-15 14:08:04'),
(17, 1, 17, NULL, NULL, NULL, '41.00', NULL, 'ORD16', '2021-07-20 10:48:04', '2021-07-20 10:48:04'),
(18, 1, 18, NULL, NULL, NULL, '41.00', NULL, 'ORD17', '2021-07-20 18:14:12', '2021-07-20 18:14:12'),
(19, 1, 19, NULL, NULL, NULL, '116.00', NULL, 'ORD18', '2021-07-24 12:19:58', '2021-07-24 12:19:58'),
(20, 1, 20, NULL, NULL, NULL, '44.00', NULL, 'ORD19', '2021-08-07 11:09:55', '2021-08-07 11:09:55'),
(21, 1, 21, NULL, NULL, NULL, '100.00', NULL, 'ORD20', '2021-08-17 05:57:04', '2021-08-17 05:57:04'),
(22, 1, 22, NULL, NULL, NULL, '120.00', NULL, 'ORD21', '2021-09-24 21:41:56', '2021-09-24 21:41:56'),
(23, 1, 26, NULL, NULL, NULL, '120.00', NULL, 'ORD22', '2021-09-25 22:43:15', '2021-09-25 22:43:15'),
(24, 1, 32, NULL, NULL, NULL, '156.00', NULL, 'ORD23', '2021-09-29 13:39:53', '2021-09-29 13:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_attribute_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `shipping` int(11) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_description` text COLLATE utf8mb4_unicode_ci,
  `product_price` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `product_attribute_id`, `quantity`, `vendor_id`, `shop_id`, `shipping`, `order_status`, `date`, `product_name`, `product_sku`, `product_description`, `product_price`) VALUES
(1, 1, 11, 1, 1, 2, 2, 20, 3, '2021-06-26', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(2, 2, 9, 1, 3, 1, 1, 20, 3, '2021-06-28', 'SOFTSPUN Microfiber Vehicle Washing Cloth  (Pack Of 4, 340 GSM)', '1038267', 'SOFTSPUN MICROFIBER CLEANING CLOTH Ultra Soft-Excellent Absorption-Quick Dry-No Odor-Bacteria Free-Wrinkle Free-Light Weight-Lasts Hundreds Of Washes-Very Economical SOFTSPUN Microfiber is the fastest growing Microfiber Products company in India having a extensive range of products, sizes and colors to suit all needs', '20.00'),
(3, 3, 10, 1, 1, 2, 2, 20, 3, '2021-07-02', 'Happilo 100% Natural Premium Californian Almonds', '1097655', 'Happilo 100% Natural Premium Californian Almonds Descriptions', '22.00'),
(4, 4, 13, 1, 2, 1, 1, 20, 3, '2021-07-02', 'Happy walls Nature Wallpaper ', '1042288', 'Happy walls Nature Wallpaper description', '11.00'),
(5, 5, 13, 1, 1, 1, 1, 20, 3, '2021-07-05', 'Happy walls Nature Wallpaper ', '1042288', 'Happy walls Nature Wallpaper description', '11.00'),
(6, 5, 11, 1, 1, 2, 2, 20, 3, '2021-07-05', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(7, 6, 14, 1, 1, 1, 1, 20, 3, '2021-07-07', 'Mi XXQ02HM Runtime: 60 min Trimmer for Men ', '1013294', 'Mi XXQ02HM Runtime: 60 min Trimmer for Men description', '23.00'),
(8, 7, 10, 1, 1, 2, 2, 20, 3, '2021-07-10', 'Happilo 100% Natural Premium Californian Almonds', '1097655', 'Happilo 100% Natural Premium Californian Almonds Descriptions', '22.00'),
(9, 8, 11, 1, 1, 2, 2, 20, 3, '2021-07-10', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(10, 8, 10, 1, 1, 2, 2, 20, 3, '2021-07-10', 'Happilo 100% Natural Premium Californian Almonds', '1097655', 'Happilo 100% Natural Premium Californian Almonds Descriptions', '22.00'),
(11, 8, 13, 1, 1, 1, 1, 20, 3, '2021-07-10', 'Happy walls Nature Wallpaper ', '1042288', 'Happy walls Nature Wallpaper description', '11.00'),
(12, 9, 11, 1, 2, 2, 2, 20, 3, '2021-07-11', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(13, 10, 11, 1, 1, 2, 2, 20, 3, '2021-07-11', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(14, 11, 11, 1, 1, 2, 2, 20, 3, '2021-07-11', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(15, 12, 11, 1, 1, 2, 2, 20, 3, '2021-07-11', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(16, 13, 12, 1, 1, 2, 2, 20, 3, '2021-07-13', 'Craftastique Forever Love Designer', '1032419', 'Kwality Choco Flakes Descriptions', '17.00'),
(17, 14, 9, 1, 1, 1, 1, 20, 3, '2021-07-14', 'SOFTSPUN Microfiber Vehicle Washing Cloth  (Pack Of 4, 340 GSM)', '1038267', 'SOFTSPUN MICROFIBER CLEANING CLOTH Ultra Soft-Excellent Absorption-Quick Dry-No Odor-Bacteria Free-Wrinkle Free-Light Weight-Lasts Hundreds Of Washes-Very Economical SOFTSPUN Microfiber is the fastest growing Microfiber Products company in India having a extensive range of products, sizes and colors to suit all needs', '20.00'),
(18, 15, 1, 1, 1, 1, 1, 0, 3, '2021-07-15', 'Redmi 8A Dual (Midnight Grey, 32 GB)  (2 GB RAM)', '1073979', '<ul><li>13+2MP dual rear AI camera with PDAF | 8MP front camera</li> <li>15.7988 centimeters (6.22-inch) HD+ Dot notch display with 1520 x 720 pixels resolution and 19:9 aspect ratio | 2.5D curved glass</li> <li>Memory, Storage &amp; SIM: 2GB | 32GB internal memory expandable up to 512GB with dedicated memory card slot | Dual SIM (nano+nano) dual-standby (4G+4G)</li> <li>Android Pie v9.0 operating system with 1.95GHz Snapdragon 439 octa core processor</li> <li>5000mAH lithium-polymer battery</li> <li>1 year manufacturer warranty for device and 6 months manufacturer warranty for in-box accessories including batteries from the date of purchase</li> <li>Box also includes: Power adapter, USB cable, SIM eject tool, warranty card and user guide. The box does not include earphones</li> </ul>', '100.00'),
(19, 16, 11, 1, 1, 2, 2, 20, 3, '2021-07-15', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(20, 17, 8, 1, 1, 1, 1, 20, 3, '2021-07-20', 'boAt BassHeads 172 Wired Headset  (Active Black, In the Ear)', '1057037', 'Surrender to your senses as you enter the gates of Nirvana with the boAt Bassheads 172. Slick with a cool metallic finish, these eye-catching earphones bring out that Super Extraaa Bass via the encased 10mm Drivers. Slip into the sound. A secure braided cable emphasises the colour and makes it hard to get tangled up. Set with a 120cm cable and 3.5 mm jack, connect into your music and movies anytime and anyplace. Its HD Sound, on demand and is perfect for you to tune out and go within, to place where you keep your good vibes. Turn up the atmosphere with the Bassheads 172.', '21.00'),
(21, 18, 8, 1, 1, 1, 1, 20, 3, '2021-07-20', 'boAt BassHeads 172 Wired Headset  (Active Black, In the Ear)', '1057037', 'Surrender to your senses as you enter the gates of Nirvana with the boAt Bassheads 172. Slick with a cool metallic finish, these eye-catching earphones bring out that Super Extraaa Bass via the encased 10mm Drivers. Slip into the sound. A secure braided cable emphasises the colour and makes it hard to get tangled up. Set with a 120cm cable and 3.5 mm jack, connect into your music and movies anytime and anyplace. Its HD Sound, on demand and is perfect for you to tune out and go within, to place where you keep your good vibes. Turn up the atmosphere with the Bassheads 172.', '21.00'),
(22, 19, 11, 1, 4, 2, 2, 20, 3, '2021-07-24', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(23, 20, 11, 1, 1, 2, 2, 20, 3, '2021-08-07', 'Kwality Choco Flakes', '1089768', 'Kwality Choco Flakes Descriptions', '24.00'),
(24, 21, 1, 1, 1, 1, 1, 0, 3, '2021-08-17', 'Redmi 8A Dual (Midnight Grey, 32 GB)  (2 GB RAM)', '1073979', '<ul><li>13+2MP dual rear AI camera with PDAF | 8MP front camera</li> <li>15.7988 centimeters (6.22-inch) HD+ Dot notch display with 1520 x 720 pixels resolution and 19:9 aspect ratio | 2.5D curved glass</li> <li>Memory, Storage &amp; SIM: 2GB | 32GB internal memory expandable up to 512GB with dedicated memory card slot | Dual SIM (nano+nano) dual-standby (4G+4G)</li> <li>Android Pie v9.0 operating system with 1.95GHz Snapdragon 439 octa core processor</li> <li>5000mAH lithium-polymer battery</li> <li>1 year manufacturer warranty for device and 6 months manufacturer warranty for in-box accessories including batteries from the date of purchase</li> <li>Box also includes: Power adapter, USB cable, SIM eject tool, warranty card and user guide. The box does not include earphones</li> </ul>', '100.00'),
(25, 22, 20, 1, 1, 17, 18, NULL, 3, '2021-09-24', 'fast food', 'ct123', '<p>testing</p>', '120.00'),
(26, 26, 20, 1, 1, 17, 18, NULL, 3, '2021-09-25', 'fast food', 'ct123', '<p>testing</p>', '120.00'),
(27, 32, 16, 1, 1, 1, 4, 11, 3, '2021-09-29', 'test author', 'ITSSEMPLE', '<p>lorem&nbsp;</p>', '145.00');

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Pending', '#E0A800', '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(2, 'Processing', '#307BFF', '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(3, 'Delivered', '#2A8838', '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(4, 'Cancelled', '#C82433', '2021-06-20 09:17:54', '2021-06-20 09:17:54');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'create-product', 'Create product', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(2, 'view-product', 'View product', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(3, 'update-product', 'Update product', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(4, 'delete-product', 'Delete product', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(5, 'update-order', 'Update order', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(1, 2),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_in`
--

CREATE TABLE `plan_in` (
  `id` int(10) UNSIGNED NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `staff_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `expiry_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plan_in`
--

INSERT INTO `plan_in` (`id`, `plan_id`, `vendor_id`, `staff_id`, `price`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, '5000.00', '2021-12-20 09:59:38', '2021-06-20 15:29:38', '2021-06-20 15:29:38'),
(2, 3, 3, NULL, '10000.00', '2022-06-26 11:06:04', '2021-06-26 16:36:04', '2021-06-26 16:36:04'),
(3, 1, 2, NULL, '1000.00', '2021-08-18 05:41:38', '2021-07-18 11:11:38', '2021-07-18 11:11:38'),
(4, 2, 11, NULL, '5000.00', '2022-03-04 11:23:39', '2021-09-04 11:23:39', '2021-09-04 11:23:39'),
(5, 1, 14, NULL, '1000.00', '2021-10-18 06:13:16', '2021-09-18 06:13:16', '2021-09-18 06:13:16'),
(6, 2, 15, NULL, '5000.00', '2022-03-22 11:06:42', '2021-09-22 11:06:42', '2021-09-22 11:06:42'),
(7, 1, 17, NULL, '1000.00', '2021-10-24 07:26:43', '2021-09-24 07:26:43', '2021-09-24 07:26:43'),
(8, 1, 5, NULL, '1000.00', '2021-10-28 10:28:47', '2021-09-28 10:28:47', '2021-09-28 10:28:47'),
(9, 1, 17, NULL, '1000.00', '2022-03-15 15:33:28', '2022-02-15 15:33:28', '2022-02-15 15:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `sale_price` decimal(8,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `length` decimal(8,2) DEFAULT NULL,
  `width` decimal(8,2) DEFAULT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `distance_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT '0.00',
  `mass_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` decimal(8,2) DEFAULT NULL,
  `tax_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxable` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `sku`, `name`, `slug`, `description`, `short_description`, `cover`, `quantity`, `price`, `sale_price`, `status`, `length`, `width`, `height`, `distance_unit`, `weight`, `mass_unit`, `tax`, `tax_id`, `shop_id`, `created_at`, `updated_at`, `product_type`, `taxable`, `flat_rate`, `flat_amount`, `vendor_id`, `created_by`, `updated_by`) VALUES
(1, NULL, '1073979', 'Redmi 8A Dual (Midnight Grey, 32 GB)  (2 GB RAM)', 'redmi-8a-dual-midnight-grey-32-gb-2-gb-ram', '<ul><li>13+2MP dual rear AI camera with PDAF | 8MP front camera</li> <li>15.7988 centimeters (6.22-inch) HD+ Dot notch display with 1520 x 720 pixels resolution and 19:9 aspect ratio | 2.5D curved glass</li> <li>Memory, Storage &amp; SIM: 2GB | 32GB internal memory expandable up to 512GB with dedicated memory card slot | Dual SIM (nano+nano) dual-standby (4G+4G)</li> <li>Android Pie v9.0 operating system with 1.95GHz Snapdragon 439 octa core processor</li> <li>5000mAH lithium-polymer battery</li> <li>1 year manufacturer warranty for device and 6 months manufacturer warranty for in-box accessories including batteries from the date of purchase</li> <li>Box also includes: Power adapter, USB cable, SIM eject tool, warranty card and user guide. The box does not include earphones</li> </ul>', '13+2MP dual rear AI camera with PDAF | 8MP front camera. 15.7988 centimeters (6.22-inch) HD+', 'products/mi-redmi-8a-dual.jpeg', 98, '115.00', '100.00', 1, '12.00', '50.00', '30.00', NULL, '5.00', 'lbs', NULL, 0, 1, '2021-06-20 14:47:54', '2021-08-17 05:57:04', 'virtual', NULL, '0', '0', 1, 1, NULL),
(2, NULL, '1015333', 'Glamcci Women Two Piece Dress', 'glamcci-women-two-piece-dress', '<ul class=\"a-unordered-list a-vertical a-spacing-mini\"> <li>Department: women</li> <li>Excellent gift item</li> <li>Comfortable to wear</li> </ul>', '<ul class=\"a-unordered-list a-vertical a-spacing-mini\"> <li>Department: women</li> <li>Excellent gift item</li> <li>Comfortable to wear</li> </ul>', 'products/women-dress.jpeg', 100, '15.77', '12.99', 1, '0.00', '0.00', '0.00', NULL, '5.00', 'lbs', NULL, 0, 1, '2021-06-20 14:47:54', '2021-06-20 14:47:54', 'virtual', NULL, '0', '0', 1, 1, NULL),
(3, NULL, '1078487', 'Solid Men Polo Neck Multicolor T-Shirt', 'solid-men-polo-neck-multicolor-t-shirt', '<ul class=\"a-unordered-list a-vertical a-spacing-mini\"> <li>Care Instructions: Machine Wash</li> <li>Fit Type: Regular Fit</li> <li>Fabric : Cotton Blend</li> <li>Pattern : Solid, Logo Embroidery</li> <li>Occasion : Casual</li> <li>Sleeve : Half Sleeve</li> </ul>', '<ul> <li>Care Instructions: Machine Wash</li> <li>Fit Type: Regular Fit</li> <li>Fabric : Cotton Blend</li> <li>Pattern : Solid, Logo Embroidery</li> <li>Occasion : Casual</li> <li>Sleeve : Half Sleeve</li> </ul>', 'products/mens-t-shirts-solid-color.jpeg', 100, '10.77', '8.00', 1, '0.00', '0.00', '0.00', NULL, '5.00', 'lbs', NULL, 0, 1, '2021-06-20 14:47:54', '2021-06-20 14:47:54', 'virtual', NULL, '1', '10', 1, 1, NULL),
(4, NULL, '1063185', 'Mattel Scrabble Original - Brand Crossword Board Game', 'mattel-scrabble-original-brand-crossword-board-game', 'Includes letter tiles and board The set includes 100 letter tiles, 1 playing board, 4 racks, cotton tile bag and rules sheet. 2 - 4 players can play the game and it is a perfect party game. Improves vocabulary and strategy skills Word games help develop vocabulary. It stimulates the brain and improves strategic skill, all the while encouraging group play.', 'Test your vocabulary and word skills with this Scrabble Original – Brand Crossword Game from Mattel. Every word counts in this game and you are in for an enriching experience when you play to make random words from alphabets.', 'products/scrabble-latest-board-game-multi-color-board-game.jpeg', 100, '20.00', '14.99', 1, '0.00', '0.00', '0.00', NULL, '5.00', 'lbs', NULL, 0, 2, '2021-06-20 14:47:54', '2021-06-20 14:47:54', 'virtual', NULL, '1', '10', 2, 1, NULL),
(5, NULL, '1077655', 'Aquire Large PVC Vinyl Sticker  (Pack of 1)', 'aquire-large-pvc-vinyl-sticker-pack-of-1', 'wall stickers for bedroom,wall stickers for bedroom love,wall stickers in home decoration,wall decor stickers for bedroom,sticker for living room', 'wall stickers for bedroom,wall stickers for bedroom love,wall stickers in home decoration,wall decor stickers for bedroom,sticker for living room', 'products/wall-stickers-hanging-birds-cage-with-flowers-large.jpeg', 100, '5.00', '4.50', 1, '0.00', '0.00', '0.00', NULL, '5.00', 'lbs', NULL, 0, 2, '2021-06-20 14:47:54', '2021-06-20 14:47:54', 'virtual', NULL, '1', '20', 2, 1, NULL),
(6, NULL, '1057343', 'Sehaz Artworks NM-Adventure_Book Album  (Photo Size Supported: 6 x 4 Inch)', 'sehaz-artworks-nm-adventure-book-album-photo-size-supported-6-x-4-inch', 'KEEP THE BEST MEMORY! You can record all your wonderful moments that with friends or family in this photo album. And it will be a special DIY gifts for Anniversary, valentine’s day, mother\'s day, father\'s day, birthday, Christmas day, thanksgiving day, etc Our premium scrapbook photo album can be carried when you are traveling on a cruise, hiking, camping, fishing, and much more. The book can hold perfectly photos, postcards and can even be used for crafting projects. It also can be used as a wedding memory book. Record all your or with your family / friends special memories on the pages! What’s In The Box? • 1 Scrapbook We offer a lifetime guarantee on this scrapbook photo album, your satisfaction is guaranteed! for some reason if you are not satisfied, please contact us and let us know how to make it better.', 'KEEP THE BEST MEMORY! You can record all your wonderful moments that with friends or family in this photo album. And it will be a special DIY gifts for Anniversary, valentine’s day, mother\'s day, father\'s day, birthday, Christmas day, thanksgiving day, etc', 'products/nm-adventure-book.jpeg', 100, '16.00', '15.00', 1, '0.00', '0.00', '0.00', NULL, '5.00', 'lbs', NULL, 0, 1, '2021-06-20 14:47:54', '2021-06-20 14:47:54', 'virtual', NULL, '1', '30', 1, 1, NULL),
(7, NULL, '1021622', 'Gloss Hair Salon', 'gloss-hair-salon', 'Gloss Hair Salon', 'Gloss Hair Salon', 'products/hairsaloon.jpg', 100, '25.00', '19.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 1, '2021-06-20 14:47:54', '2021-06-20 14:47:54', 'virtual', NULL, '1', '20', 1, 1, NULL),
(8, NULL, '1057037', 'boAt BassHeads 172 Wired Headset  (Active Black, In the Ear)', 'boat-bassheads-172-wired-headset-active-black-in-the-ear', 'Surrender to your senses as you enter the gates of Nirvana with the boAt Bassheads 172. Slick with a cool metallic finish, these eye-catching earphones bring out that Super Extraaa Bass via the encased 10mm Drivers. Slip into the sound. A secure braided cable emphasises the colour and makes it hard to get tangled up. Set with a 120cm cable and 3.5 mm jack, connect into your music and movies anytime and anyplace. Its HD Sound, on demand and is perfect for you to tune out and go within, to place where you keep your good vibes. Turn up the atmosphere with the Bassheads 172.', 'Surrender to your senses as you enter the gates of Nirvana with the boAt Bassheads 172. Slick with a cool metallic finish, these eye-catching earphones bring out that Super Extraaa Bass via the encased 10mm Drivers. Slip into the sound.', 'products/earphone.jpeg', 98, '25.00', '21.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 1, '2021-06-20 14:47:54', '2021-07-20 18:14:12', 'virtual', NULL, '1', '20', 1, 1, NULL),
(9, NULL, '1038267', 'SOFTSPUN Microfiber Vehicle Washing Cloth  (Pack Of 4, 340 GSM)', 'softspun-microfiber-vehicle-washing-cloth-pack-of-4-340-gsm', 'SOFTSPUN MICROFIBER CLEANING CLOTH Ultra Soft-Excellent Absorption-Quick Dry-No Odor-Bacteria Free-Wrinkle Free-Light Weight-Lasts Hundreds Of Washes-Very Economical SOFTSPUN Microfiber is the fastest growing Microfiber Products company in India having a extensive range of products, sizes and colors to suit all needs', 'SOFTSPUN MICROFIBER CLEANING CLOTH Ultra Soft-Excellent Absorption-Quick Dry-No', 'products/soft.jpeg', 96, '25.00', '20.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 1, '2021-06-20 14:47:54', '2021-07-14 13:41:35', 'virtual', NULL, '1', '20', 1, 1, NULL),
(10, NULL, '1097655', 'Happilo 100% Natural Premium Californian Almonds', 'happilo-100-natural-premium-californian-almonds', 'Happilo 100% Natural Premium Californian Almonds Descriptions', 'Happilo 100% Natural Premium Californian Almonds Descriptions', 'products/foodLEVELS-10023-1000x800.jpg', 97, '25.00', '22.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 2, '2021-06-20 14:47:54', '2021-07-10 08:41:23', 'virtual', NULL, '1', '20', 2, 1, NULL),
(11, NULL, '1089768', 'Kwality Choco Flakes', 'kwality-choco-flakes', 'Kwality Choco Flakes Descriptions', 'Kwality Choco Flakes Descriptions', 'products/food2.jpg', 86, '25.00', '24.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 2, '2021-06-20 14:47:54', '2021-08-07 11:09:55', 'virtual', NULL, '1', '20', 2, 1, NULL),
(12, NULL, '1032419', 'Craftastique Forever Love Designer', 'craftastique-forever-love-designer', 'Kwality Choco Flakes Descriptions', 'Craftastique Forever Love Designer', 'products/DIY-Art-and-Craft.jpg', 99, '25.00', '17.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 2, '2021-06-20 14:47:54', '2021-07-13 14:44:24', 'virtual', NULL, '1', '20', 2, 1, NULL),
(13, NULL, '1042288', 'Happy walls Nature Wallpaper ', 'happy-walls-nature-wallpaper', 'Happy walls Nature Wallpaper description', 'Happy walls Nature Wallpaper description', 'products/download.jpeg', 96, '25.00', '11.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 1, '2021-06-20 14:47:54', '2021-07-10 08:41:23', 'virtual', NULL, '1', '20', 1, 1, NULL),
(14, NULL, '1013294', 'Mi XXQ02HM Runtime: 60 min Trimmer for Men ', 'mi-xxq02hm-runtime-60-min-trimmer-for-men', 'Mi XXQ02HM Runtime: 60 min Trimmer for Men description', 'HMi XXQ02HM Runtime: 60 min Trimmer for Men description', 'products/download (1).jpeg', 99, '25.00', '23.00', 1, '0.00', '0.00', '0.00', NULL, NULL, '', NULL, 0, 1, '2021-06-20 14:47:54', '2021-07-07 04:56:49', 'virtual', NULL, '1', '20', 1, 1, NULL),
(15, NULL, 'S12', 'Soap', 'soap', '<p>Soap</p>', 'Soap', 'products/u7r0PYbbcNk49sVtggvLbCEayPybntkdZnPdcWrc.png', 100, '100.00', '50.00', 1, NULL, NULL, NULL, NULL, '0.00', 'Lbs', NULL, 0, 12, '2021-09-04 11:31:38', '2021-09-04 11:31:38', 'virtual', '0', '1', '1', 11, 1, NULL),
(16, NULL, 'ITSSEMPLE', 'test author', 'test-author', '<p>lorem&nbsp;</p>', 'lorem ipsum', 'products/wiQSvt3w5NQnkVaVVbD25Celnun1kHLhGIXmpFb7.png', 99, '8000.00', '145.00', 1, NULL, NULL, NULL, NULL, '0.00', 'Lbs', NULL, 0, 4, '2021-09-17 15:00:14', '2021-09-29 13:39:53', 'virtual', '0', '1', '11', 1, 1, NULL),
(17, NULL, 'CT123', 'chips', 'chips', '<p>Good to test</p>', 'Good to test', 'products/Su6ncydbFkj2Iv1yRMLiMaBRIcp6xRVAPqeAPOlS.jpg', 10, '55.00', '50.00', 1, NULL, NULL, NULL, NULL, '0.00', 'Lbs', NULL, 0, 15, '2021-09-18 06:18:27', '2021-09-18 06:18:27', 'virtual', '0', '1', NULL, 14, 1, NULL),
(18, NULL, 'CRU-3PI', 'Buffalo Stew.', 'buffalo-stew', '<p>A food dish that combines buffalo meat with a variety of other ingredients, such as potatoes, vegetables, herbs, spices, and broth to create a savory dish, rich in flavor and often served as the main dish.</p>', 'Braised Buffalo, Vegetables, Rich Brown Sauce, Roasted Red Potato.', 'products/DcbZLyRBpm5aPcZVL8B36GPsPC7E2Ca3FV136azA.jpg', 1000, '3500.00', '3350.00', 1, NULL, NULL, NULL, NULL, '0.00', 'Lbs', NULL, 0, 16, '2021-09-22 11:28:20', '2021-09-22 11:28:20', 'virtual', '0', '0', '3500', 15, 1, NULL),
(19, NULL, 'awda', 'new1', 'new1', '<p>test</p>', 'test', 'products/i1uPvi7x2BMcMsjdVncapmWlZNEeZpvGaWC3QMF6.png', 12, '12.00', '12.00', 1, NULL, NULL, NULL, NULL, '0.00', 'Lbs', NULL, 0, 1, '2021-09-22 15:33:48', '2021-09-22 15:33:48', 'virtual', '0', '1', '12', 1, 1, NULL),
(20, NULL, 'ct123', 'fast food', 'fast-food', '<p>testing</p>', 'testing', 'products/lt28oClqezA9FckwTiNl7t8QnbHhTWWR3AlbP83b.png', 11, '123.00', '120.00', 1, NULL, NULL, NULL, NULL, '0.00', 'Lbs', NULL, 0, 18, '2021-09-24 07:29:47', '2021-09-25 22:43:15', 'virtual', '0', '1', NULL, 17, 1, NULL),
(21, NULL, '12345', 'trimmer', 'trimmer', '<p>testing</p>', 'testing', 'products/xE5BWPOoiKstDhGmPfZKBWaIVRCaw3LMnbdv4my2.png', 6, '123.00', '115.00', 1, NULL, NULL, NULL, NULL, '0.00', 'Lbs', NULL, 0, 6, '2021-09-28 11:26:07', '2021-09-28 11:26:07', 'virtual', '0', '1', NULL, 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `sale_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` tinyint(4) NOT NULL DEFAULT '0',
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `src` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `src`) VALUES
(1, 1, 'products/mi-redmi-8a-dual-2.jpeg'),
(2, 1, 'products/mi-redmi-8a-dual-3.jpeg'),
(3, 1, 'products/mi-redmi-8a-dual-4.jpeg'),
(4, 1, 'products/mi-redmi-8a-dual-5.jpeg'),
(5, 18, 'products/XZV4gwx611BF63s00Dj36oWrVCe1TH65kY9lszzs.jpg'),
(6, 18, 'products/gxEQMstYOTi4llhqCOFC5sUETooG3WUWCNFbcFwJ.jpg'),
(7, 18, 'products/kWBTnQshGRt02BGJE4JcLzleZmj3CvFy8RaIWUun.jpg'),
(8, 21, 'products/bFADAD8RSydGYvuXIWnrVhAnDPvVfF2zMptKbWPF.png'),
(9, 21, 'products/7ds4gdHx1hsvNDBKuOzfDxPOxIqxXOREg8tiycqs.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `vendor_id` int(10) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `country_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Abra', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(2, 'Agusan del Norte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(3, 'Agusan del Sur', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(4, 'Aklan', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(5, 'Albay', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(6, 'Antique', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(7, 'Apayao', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(8, 'Aurora', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(9, 'Basilan', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(10, 'Bataan', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(11, 'Batanes', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(12, 'Batangas', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(13, 'Benguet', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(14, 'Biliran', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(15, 'Bohol', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(16, 'Bukidnon', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(17, 'Bulacan', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(18, 'Cagayan', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(19, 'Camarines Norte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(20, 'Camarines Sur', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(21, 'Camiguin', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(22, 'Capiz', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(23, 'Catanduanes', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(24, 'Cavite', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(25, 'Cebu', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(26, 'Compostela Valley', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(27, 'Cotabato', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(28, 'Davao del Norte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(29, 'Davao del Sur', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(30, 'Davao Oriental', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(31, 'Eastern Samar', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(32, 'Guimaras', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(33, 'Ifugao', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(34, 'Ilocos Norte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(35, 'Ilocos Sur', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(36, 'Iloilo', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(37, 'Isabela', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(38, 'Kalinga', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(39, 'La Union', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(40, 'Laguna', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(41, 'Lanao del Norte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(42, 'Lanao del Sur', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(43, 'Leyte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(44, 'Maguindanao', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(45, 'Marinduque', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(46, 'Masbate', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(47, 'Metro Manila', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(48, 'Misamis Occidental', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(49, 'Misamis Oriental', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(50, 'Mountain Province', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(51, 'Negros Occidental', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(52, 'Negros Oriental', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(53, 'Northern Samar', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(54, 'Nueva Ecija', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(55, 'Nueva Vizcaya', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(56, 'Occidental Mindoro', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(57, 'Oriental Mindoro', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(58, 'Palawan', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(59, 'Pampanga', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(60, 'Pangasinan', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(61, 'Quezon', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(62, 'Quirino', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(63, 'Rizal', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(64, 'Romblon', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(65, 'Samar', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(66, 'Sarangani', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(67, 'Siquijor', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(68, 'Sorsogon', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(69, 'South Cotabato', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(70, 'Southern Leyte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(71, 'Sultan Kudarat', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(72, 'Sulu', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(73, 'Surigao del Norte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(74, 'Surigao del Sur', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(75, 'Tarlac', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(76, 'Tawi-Tawi', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(77, 'Zambales', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(78, 'Zamboanga del Norte', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(79, 'Zamboanga del Sur', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(80, 'Zamboanga Sibugay', 169, 1, '2021-06-20 09:17:53', '2021-06-20 09:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'Super Admin', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(2, 'staff', 'Staff', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53'),
(3, 'subadmin', 'Subadmin', '', '2021-06-20 09:17:53', '2021-06-20 09:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\Shop\\Employees\\Employee'),
(2, 2, 'App\\Shop\\Employees\\Employee'),
(2, 4, 'App\\Shop\\Employees\\Employee'),
(2, 5, 'App\\Shop\\Employees\\Employee');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8mb4_unicode_ci,
  `citrus_shop_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merchant_id` int(10) UNSIGNED NOT NULL,
  `shop_image` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `title`, `location`, `citrus_shop_id`, `merchant_id`, `shop_image`, `type`, `created_at`, `updated_at`) VALUES
(1, '1', 'xyz', 'TR000011', 1, NULL, 'default', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, '2', 'xyz', 'FA000012', 2, NULL, 'default', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(3, '2', 'xyz', 'EX000012', 3, NULL, 'default', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(4, '4', 'ABC XYZ', 'BO000069', 1, 'banner.png', NULL, '2021-06-29 05:19:24', '2021-06-29 05:19:24'),
(5, '1', 'Janakpuri A block', 'DR000015', 4, NULL, 'default', '2021-08-30 05:59:44', '2021-08-30 05:59:44'),
(6, '1', 'Janakpuri A block', 'DR000081', 5, NULL, 'default', '2021-08-30 06:27:01', '2021-08-30 06:27:01'),
(7, '1', '#323a abc colony ynr skjsds', 'DR000013', 6, NULL, 'default', '2021-08-30 06:35:35', '2021-08-30 06:35:35'),
(8, '1', 'ghbjn', 'DR000076', 7, NULL, 'default', '2021-09-02 17:54:11', '2021-09-02 17:54:11'),
(9, '1', 'ghbjn', 'DR000082', 8, NULL, 'default', '2021-09-02 18:49:52', '2021-09-02 18:49:52'),
(10, '1', 'ghbjn', 'DR000035', 9, NULL, 'default', '2021-09-02 19:01:01', '2021-09-02 19:01:01'),
(11, '1', 'GHH', 'DR000057', 10, NULL, 'default', '2021-09-02 19:45:08', '2021-09-02 19:45:08'),
(12, '5', 'Na', 'BA000098', 11, NULL, 'default', '2021-09-04 11:21:05', '2021-09-04 11:21:05'),
(13, '1', 'Madhubani, Bihar', 'DR000017', 12, NULL, 'default', '2021-09-04 15:49:17', '2021-09-04 15:49:17'),
(14, '1', 'Cronos Inc', 'DR000045', 13, NULL, 'default', '2021-09-06 08:03:35', '2021-09-06 08:03:35'),
(15, '2', 'Delhi, Saket', 'RE000090', 14, NULL, 'default', '2021-09-18 06:11:37', '2021-09-18 06:11:37'),
(16, '2', 'along City Hall way, CBD, Nairobi', 'RE000040', 15, NULL, 'default', '2021-09-22 11:05:17', '2021-09-22 11:05:17'),
(17, '7', 'yetsdhf', 'IN000067', 16, NULL, 'default', '2021-09-22 15:18:17', '2021-09-22 15:18:17'),
(18, '2', 'Delhi', 'RE000034', 17, NULL, 'default', '2021-09-24 07:23:56', '2021-09-24 07:23:56'),
(19, '6', 'Indore', 'SU000094', 1, 'adoption_avatar_image.png', NULL, '2021-09-24 16:14:02', '2021-09-24 16:14:02'),
(20, '6', 'Delhi', 'SU000071', 17, 'IMG-20210924-WA0005.jpg', NULL, '2021-09-24 16:21:32', '2021-09-24 16:21:32'),
(21, '6', 'delhi', 'SU000075', 5, 'Terminal_1_Logo_with_red_wings_updated.png', NULL, '2021-09-28 10:30:05', '2021-09-28 10:30:05'),
(22, '7', 'vijaynagar', 'IN000035', 1, 'adoption_avatar_image.png', NULL, '2021-09-28 13:17:06', '2021-09-28 13:17:06'),
(23, '4', 'Abc', 'BO000078', 18, NULL, 'default', '2021-11-21 14:12:59', '2021-11-21 14:12:59'),
(24, '1', 'Delhi, Uttam nagar', 'DR000092', 19, NULL, 'default', '2021-12-21 08:26:19', '2021-12-21 08:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `sociallinks`
--

CREATE TABLE `sociallinks` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `merchant_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sociallinks`
--

INSERT INTO `sociallinks` (`id`, `title`, `link`, `merchant_id`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'www.facebook.com', 1, '2021-06-29 05:05:03', '2021-06-29 05:05:03');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state`, `state_code`, `country_id`) VALUES
('Alaska', 'AK', 226),
('Alabama', 'AL', 226),
('Arkansas', 'AR', 226),
('Arizona', 'AZ', 226),
('California', 'CA', 226),
('Colorado', 'CO', 226),
('Connecticut', 'CT', 226),
('District of Columbia', 'DC', 226),
('Delaware', 'DE', 226),
('Florida', 'FL', 226),
('Georgia', 'GA', 226),
('Hawaii', 'HI', 226),
('Iowa', 'IA', 226),
('Idaho', 'ID', 226),
('Illinois', 'IL', 226),
('Indiana', 'IN', 226),
('Kansas', 'KS', 226),
('Kentucky', 'KY', 226),
('Louisiana', 'LA', 226),
('Massachusetts', 'MA', 226),
('Maryland', 'MD', 226),
('Maine', 'ME', 226),
('Michigan', 'MI', 226),
('Minnesota', 'MN', 226),
('Missouri', 'MO', 226),
('Mississippi', 'MS', 226),
('Montana', 'MT', 226),
('North Carolina', 'NC', 226),
('North Dakota', 'ND', 226),
('Nebraska', 'NE', 226),
('New Hampshire', 'NH', 226),
('New Jersey', 'NJ', 226),
('New Mexico', 'NM', 226),
('Nevada', 'NV', 226),
('New York', 'NY', 226),
('Ohio', 'OH', 226),
('Oklahoma', 'OK', 226),
('Oregon', 'OR', 226),
('Pennsylvania', 'PA', 226),
('Rhode Island', 'RI', 226),
('South Carolina', 'SC', 226),
('South Dakota', 'SD', 226),
('Tennessee', 'TN', 226),
('Texas', 'TX', 226),
('Utah', 'UT', 226),
('Virginia', 'VA', 226),
('Vermont', 'VT', 226),
('Washington', 'WA', 226),
('Wisconsin', 'WI', 226),
('West Virginia', 'WV', 226),
('Wyoming', 'WY', 226);

-- --------------------------------------------------------

--
-- Table structure for table `subadmin`
--

CREATE TABLE `subadmin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_code` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `rate_percentage` text COLLATE utf8mb4_unicode_ci,
  `tax_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_rates`
--

INSERT INTO `tax_rates` (`id`, `state_code`, `description`, `rate_percentage`, `tax_name`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, '74466', 'lorum ipsum dolor sit amet', '2', 'est', NULL, '2021-06-20 09:17:54', '2021-06-20 09:17:54'),
(2, '44319', 'lorum ipsum dolor sit amet', '9', 'quia', NULL, '2021-06-20 09:17:54', '2021-06-20 09:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Rav Nordan', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 'testi1.jpg', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, 'Harry Potter', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 'testi2.jpeg', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(3, 'Lousi Mark', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', 'testi3.jpg', '2021-06-20 14:47:54', '2021-06-20 14:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendorplan_info`
--

CREATE TABLE `vendorplan_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `plan_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendorplan_info`
--

INSERT INTO `vendorplan_info` (`id`, `plan_id`, `plan_name`, `vendor_id`, `staff_id`, `price`, `date`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'BUSINESS PROMOTION', 1, 1, '10.00', '2020-11-10', '2021-11-10', '2021-06-20 14:47:54', '2021-06-20 14:47:54'),
(2, 2, 'BUSINESS SALES', 2, 1, '200.00', '2020-11-12', '2021-11-10', '2021-06-20 14:47:54', '2021-06-20 14:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_business_details`
--

CREATE TABLE `vendor_business_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(10) UNSIGNED NOT NULL,
  `gst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cell_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `same_office_add` int(11) NOT NULL DEFAULT '0',
  `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_office_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_cell_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `own_by_vancouver` int(11) NOT NULL DEFAULT '0',
  `head_office_vancouver` int(11) NOT NULL DEFAULT '0',
  `local_community` int(11) NOT NULL DEFAULT '0',
  `account_no` int(11) DEFAULT NULL,
  `ifsc_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_canadian_posts`
--

CREATE TABLE `vendor_canadian_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_msg`
--

CREATE TABLE `vendor_msg` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `msg_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_msg`
--

INSERT INTO `vendor_msg` (`id`, `vendor_id`, `reply_id`, `msg_id`, `subject`, `category`, `msg`, `read_status`, `status`, `replied_at`, `created_at`, `updated_at`) VALUES
(1, ' 1', '1', 'Okay.. Got it', 'Testing', NULL, 'test msg from merchant', '2', 'replied', '2021-06-29 10:59:33', '2021-07-20 09:36:36', '2021-06-29 05:27:55'),
(2, '  1', '1', NULL, NULL, NULL, 'Okay.. Got it', '0', NULL, NULL, '2021-07-20 10:04:12', '2021-06-29 05:29:33'),
(3, ' 1', NULL, 'Hello,\r\n\r\nClick on the Orders page,\r\n\r\nFrom there you can through the following as per your choice:\r\n\r\n1. All\r\n2. Pending\r\n3. Processing\r\n4. Delivered\r\n5. Cancelled\r\n\r\nAs per your choice of selection', 'Cant View Orders', NULL, 'Hi\r\n\r\nKindly help.\r\nI\'m not  able to view my last weeks orders, how do i access them?', '2', 'replied', '2021-07-07 01:06:18', '2021-07-20 09:40:08', '2021-07-07 07:33:17'),
(4, '  1', ' 3', NULL, NULL, NULL, 'Hello,\r\n\r\nClick on the Orders page,\r\n\r\nFrom there you can through the following as per your choice:\r\n\r\n1. All\r\n2. Pending\r\n3. Processing\r\n4. Delivered\r\n5. Cancelled\r\n\r\nAs per your choice of selection', '0', NULL, NULL, '2021-07-07 07:33:17', '2021-07-07 07:36:18'),
(5, ' 1', NULL, 'Hi there!!!!!!!!!!!!!!!1', 'here is my subject', NULL, 'help!!!!!!!!!!!!!!!!', '2', 'replied', '2021-07-20 10:19:17', '2021-07-20 10:03:31', '2021-07-20 04:48:41'),
(6, '  1', ' 5', NULL, NULL, NULL, 'Hi there!!!!!!!!!!!!!!!1', '0', NULL, NULL, '2021-07-20 04:48:51', '2021-07-20 04:49:17'),
(7, ' 1', NULL, 'ccxvxc', 'xcxc', NULL, 'xcxc', '2', 'replied', '2021-07-20 01:25:05', '2021-07-20 10:19:50', '2021-07-20 07:48:42'),
(8, '  1', ' 7', NULL, NULL, NULL, 'ccxvxc', '0', NULL, NULL, '2021-07-20 07:48:42', '2021-07-20 07:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(6, 1, 13, '2021-07-18 04:03:37', '2021-07-18 04:03:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_country_id_index` (`country_id`),
  ADD KEY `addresses_customer_id_index` (`customer_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attributes_name_unique` (`name`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_values_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `attribute_value_product_attribute`
--
ALTER TABLE `attribute_value_product_attribute`
  ADD KEY `attribute_value_product_attribute_attribute_value_id_foreign` (`attribute_value_id`),
  ADD KEY `attribute_value_product_attribute_product_attribute_id_foreign` (`product_attribute_id`);

--
-- Indexes for table `banner_settings`
--
ALTER TABLE `banner_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_type`
--
ALTER TABLE `business_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD KEY `categories__lft__rgt_parent_id_index` (`_lft`,`_rgt`,`parent_id`),
  ADD KEY `categories_created_by_foreign` (`created_by`),
  ADD KEY `categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD KEY `cities_province_id_foreign` (`province_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`),
  ADD UNIQUE KEY `countries_iso_unique` (`iso`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

--
-- Indexes for table `feature_settings`
--
ALTER TABLE `feature_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footers`
--
ALTER TABLE `footers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `orders_reference_unique` (`reference`),
  ADD KEY `orders_address_id_foreign` (`address_id`),
  ADD KEY `orders_courier_id_index` (`courier_id`),
  ADD KEY `orders_customer_id_index` (`customer_id`),
  ADD KEY `orders_order_status_id_index` (`order_status_id`);

--
-- Indexes for table `order_payment`
--
ALTER TABLE `order_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_order_id_index` (`order_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `plan_in`
--
ALTER TABLE `plan_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_vendor_id_foreign` (`vendor_id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_index` (`product_id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ratings_user_id_index` (`user_id`),
  ADD KEY `product_ratings_product_id_index` (`product_id`),
  ADD KEY `product_ratings_vendor_id_index` (`vendor_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provinces_country_id_index` (`country_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`identifier`,`instance`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shops_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `sociallinks`
--
ALTER TABLE `sociallinks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sociallinks_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `subadmin`
--
ALTER TABLE `subadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendorplan_info`
--
ALTER TABLE `vendorplan_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_business_details`
--
ALTER TABLE `vendor_business_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_business_details_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `vendor_canadian_posts`
--
ALTER TABLE `vendor_canadian_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_msg`
--
ALTER TABLE `vendor_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `banner_settings`
--
ALTER TABLE `banner_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `business_type`
--
ALTER TABLE `business_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=407;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `feature_settings`
--
ALTER TABLE `feature_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `footers`
--
ALTER TABLE `footers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `order_payment`
--
ALTER TABLE `order_payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `plan_in`
--
ALTER TABLE `plan_in`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `sociallinks`
--
ALTER TABLE `sociallinks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subadmin`
--
ALTER TABLE `subadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendorplan_info`
--
ALTER TABLE `vendorplan_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vendor_business_details`
--
ALTER TABLE `vendor_business_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendor_canadian_posts`
--
ALTER TABLE `vendor_canadian_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendor_msg`
--
ALTER TABLE `vendor_msg`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`);

--
-- Constraints for table `attribute_value_product_attribute`
--
ALTER TABLE `attribute_value_product_attribute`
  ADD CONSTRAINT `attribute_value_product_attribute_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`),
  ADD CONSTRAINT `attribute_value_product_attribute_product_attribute_id_foreign` FOREIGN KEY (`product_attribute_id`) REFERENCES `product_attributes` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `orders_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`id`),
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_order_status_id_foreign` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `products_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `provinces`
--
ALTER TABLE `provinces`
  ADD CONSTRAINT `provinces_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `sociallinks`
--
ALTER TABLE `sociallinks`
  ADD CONSTRAINT `sociallinks_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `vendor_business_details`
--
ALTER TABLE `vendor_business_details`
  ADD CONSTRAINT `vendor_business_details_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
