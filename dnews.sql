-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2022 at 04:22 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dnews`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_status`
--

CREATE TABLE `log_status` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `logInOut` int(11) NOT NULL,
  `ipAddress` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_recovery`
--

CREATE TABLE `password_recovery` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `ipaddress` varchar(250) COLLATE utf8_bin NOT NULL,
  `request_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00:00',
  `method` varchar(10) COLLATE utf8_bin NOT NULL COMMENT 'phone or email',
  `status` int(11) NOT NULL COMMENT '0 = failed, 1 = mail sent, 2 = sucess'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='password will recover using sms only through verified phone number.' ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_divission`
--

CREATE TABLE `tbl_divission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_divission`
--

INSERT INTO `tbl_divission` (`id`, `name`) VALUES
(1, 'ঢাকা'),
(2, 'রাজশাহী'),
(3, 'চট্টগ্রাম'),
(4, 'সিলেট'),
(5, 'খুলনা'),
(6, 'বরিশাল'),
(7, 'রংপুর'),
(8, 'ময়মনসিংহ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_footer_address`
--

CREATE TABLE `tbl_footer_address` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_bin DEFAULT NULL,
  `details` text COLLATE utf8_bin DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1 COMMENT 'min to max',
  `icon` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_footer_address`
--

INSERT INTO `tbl_footer_address` (`id`, `title`, `details`, `priority`, `icon`, `insert_by`, `insert_time`) VALUES
(3, 'Additionally, lorem ipsum closely resembles actual text.', 'Additionally, lorem ipsum closely resembles actual text.', 5, 'assets/footerAddress/_20221128171737.jpg', 1, '2022-11-23 17:34:15'),
(4, 'You might wonder why a designer of, say', 'You might wonder why a designer of, say', 1, 'assets/footerAddress/feceypdp_20221128171713.jpg', 1, '2022-11-28 17:16:53'),
(5, 'However, the common lorem ipsum text we use today is not proper Latin', 'However, the common lorem ipsum text we use today is not proper Latin', 20, 'assets/footerAddress/original_20221128171819.jpeg', 1, '2022-11-28 17:18:19'),
(6, 'changed that result in a mutation far from its initial form.', 'changed that result in a mutation far from its initial form.', 2, 'assets/footerAddress/istockphotoa_20221128171841.jpg', 1, '2022-11-28 17:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_footer_authorty`
--

CREATE TABLE `tbl_footer_authorty` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_bin DEFAULT NULL,
  `details` text COLLATE utf8_bin DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1 COMMENT 'min to max',
  `icon` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_footer_authorty`
--

INSERT INTO `tbl_footer_authorty` (`id`, `title`, `details`, `priority`, `icon`, `insert_by`, `insert_time`) VALUES
(1, 'the 1980s, the now-defunct company Adlus also used lorem ipsum placeholder text in its PageMaker desktop publishing software.', 'the 1980s, the now-defunct company Adlus also used lorem ipsum placeholder text in its PageMaker desktop publishing software.', 1, 'assets/footerAuthority/_20221123172417.jpg', 1, '2022-11-23 17:24:17'),
(3, 'However, it\'s unknown who made these modifications to the text, or exactly when they did this, to turn it into the mess of words we know today. Sometime in the 1500s, an unknown printer scrambled words that have survived into the digital age.', 'However, it\'s unknown who made these modifications to the text, or exactly when they did this, to turn it into the mess of words we know today. Sometime in the 1500s, an unknown printer scrambled words that have survived into the digital age.', 2, 'assets/footerAuthority/feceypdp_20221123173202.jpg', 1, '2022-11-23 17:27:10'),
(4, 'Dr. Richard McClintock discovered the source of the', 'Dr. Richard McClintock discovered the source of the', 2, 'assets/footerAuthority/feceypdp_20221128171905.jpg', 1, '2022-11-28 17:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `id` int(11) NOT NULL,
  `news_date` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00',
  `title` text COLLATE utf8_bin DEFAULT NULL,
  `subtitle` text COLLATE utf8_bin DEFAULT NULL,
  `tags` text COLLATE utf8_bin DEFAULT NULL COMMENT '** separeted',
  `news_body` text COLLATE utf8_bin DEFAULT NULL,
  `thumb_photo` text COLLATE utf8_bin DEFAULT NULL,
  `is_published` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = yes, 2 = not',
  `approve_status` int(11) NOT NULL DEFAULT 2 COMMENT '1 = yes, 2 = not',
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`id`, `news_date`, `title`, `subtitle`, `tags`, `news_body`, `thumb_photo`, `is_published`, `approve_status`, `insert_by`, `insert_time`) VALUES
(5, '2022-11-30', 'Test Title upate', 'Test Sub Title', 'Test1**Test2**Test3**Test4', '<p>This is the best test</p>\r\n', 'assets/newsPhoto/istockphotoa_20221122123831.jpg', 1, 1, 1, '2022-11-22 12:34:03'),
(6, '2022-11-23', 'News Title', 'News Sub Title', 'Tags1**test2**asdf', '<p>This is the best </p>\r\n', 'assets/newsPhoto/original_20221123112508.jpeg', 2, 2, 1, '2022-11-23 11:25:08'),
(7, '2022-11-29', 'Chances are that you\'', 'Chances are that you\'', 'Test**Test1**test2**asdf', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', 'assets/newsPhoto/feceypdp_20221128170136.jpg', 2, 2, 1, '2022-11-28 17:01:36'),
(8, '2022-11-30', 'The main reason', 'for using lorem ipsum', 'for using** lorem ipsum**test2', '<p>lorem ipsum text instead of a few paragraphs in English or their native language. Why not just copy and paste a page from an old book or lyrics from a famous song?</p>\r\n\r\n<p>The main reason for using lorem ipsum text is that it keeps people from focusing on the actual text. When someone creates a template and asks for feedback on it, they don&#39;t want the people reviewing it to get distracted by what the text says. Instead of focusing on the layout of the text, people might read the words to look for typos or sing along to the song lyrics.</p>\r\n\r\n<p>Additionally, lorem ipsum closely resembles actual text. Copying and pasting the same few words would result in an uneven distribution of letters. With lorem ipsum text, you can focus on how the font and page layout looks with copy that&#39;s almost fully realistic.</p>\r\n', 'assets/newsPhoto/istockphotoa_20221128170311.jpg', 1, 1, 1, '2022-11-28 17:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_category`
--

CREATE TABLE `tbl_news_category` (
  `id` int(11) NOT NULL,
  `category_name` text COLLATE utf8_bin DEFAULT NULL,
  `category_photo` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_news_category`
--

INSERT INTO `tbl_news_category` (`id`, `category_name`, `category_photo`, `insert_by`, `insert_time`) VALUES
(3, 'Test', 'assets/newsCategory/_20221122173401.jpg', 2022, '1'),
(5, 'Test1', 'assets/newsCategory/feceypdp_20221123095317.jpg', 2022, '1'),
(6, 'Test3', 'assets/newsCategory/istockphotoa_20221123095338.jpg', 2022, '1'),
(7, 'Test4', 'assets/newsCategory/istockphotox_20221123095354.jpg', 2022, '1'),
(8, 'In that way, it\'s a bit like the sentence', 'assets/newsCategory/demo_20221128170432.png', 2022, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_category_set`
--

CREATE TABLE `tbl_news_category_set` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL DEFAULT 0,
  `news_category_id` int(11) NOT NULL DEFAULT 0,
  `news_sub_category_id` int(11) NOT NULL DEFAULT 0,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_news_category_set`
--

INSERT INTO `tbl_news_category_set` (`id`, `news_id`, `news_category_id`, `news_sub_category_id`, `insert_by`, `insert_time`) VALUES
(2, 5, 3, 3, 1, '2022-11-23 14:15:37'),
(3, 7, 8, 6, 1, '2022-11-28 17:11:37'),
(4, 8, 6, 4, 1, '2022-11-28 17:11:53'),
(5, 7, 6, 3, 1, '2022-11-28 17:12:05'),
(6, 5, 7, 6, 1, '2022-11-28 17:12:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_photos`
--

CREATE TABLE `tbl_news_photos` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `news_photo` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_news_photos`
--

INSERT INTO `tbl_news_photos` (`id`, `news_id`, `news_photo`, `insert_by`, `insert_time`) VALUES
(1, 6, 'assets/newsPhoto/feceypdp_20221123111947.jpg', 2022, '1'),
(3, 5, 'assets/newsPhoto/istockphotoa_20221123112925.jpg', 2022, '1'),
(4, 7, 'assets/newsPhoto/_20221128170823.jpg', 1, '2022-11-28 17:08:13'),
(5, 7, 'assets/newsPhoto/JFLR_20221128170909.jpg', 1, '2022-11-28 17:09:09'),
(6, 6, 'assets/newsPhoto/HDwallpapersaipallaviactressmalayalamsaipallavitelugu_20221128170930.jpg', 1, '2022-11-28 17:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_sub_category`
--

CREATE TABLE `tbl_news_sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `sub_category_name` text COLLATE utf8_bin DEFAULT NULL,
  `category_photo` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_news_sub_category`
--

INSERT INTO `tbl_news_sub_category` (`id`, `category_id`, `sub_category_name`, `category_photo`, `insert_by`, `insert_time`) VALUES
(3, 6, 'PHP', 'assets/newsSubCategory/feceypdp_20221123103558.jpg', 2022, '1'),
(4, 8, 'However, the common', 'assets/newsSubCategory/istockphotoa_20221128170655.jpg', 1, '2022-11-28 17:06:39'),
(5, 5, 'HTML', 'assets/newsSubCategory/_20221128170717.jpg', 1, '2022-11-28 17:07:17'),
(6, 5, 'CSS', 'assets/newsSubCategory/default_20221128170729.png', 1, '2022-11-28 17:07:29'),
(7, 6, 'JAVA', 'assets/newsSubCategory/original_20221128170749.jpeg', 1, '2022-11-28 17:07:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news_videos`
--

CREATE TABLE `tbl_news_videos` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `youtube_video_link` text COLLATE utf8_bin DEFAULT NULL,
  `facebook_video_link` text COLLATE utf8_bin DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_news_videos`
--

INSERT INTO `tbl_news_videos` (`id`, `news_id`, `youtube_video_link`, `facebook_video_link`, `insert_by`, `insert_time`) VALUES
(2, 6, 'https://translate.google.com/', 'https://translate.google.com/', 1, '2022-11-23 12:57:53'),
(3, 8, 'https://translate.google.com/', 'https://translate.google.com/', 1, '2022-11-28 17:10:02'),
(4, 7, 'https://translate.google.com/', 'https://translate.google.com/', 1, '2022-11-28 17:10:24'),
(5, 6, 'https://translate.google.com/', 'https://translate.google.com/', 1, '2022-11-28 17:11:20'),
(6, 6, 'https://translate.google.com/', 'https://translate.google.com/', 1, '2022-11-28 17:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_online_poll`
--

CREATE TABLE `tbl_online_poll` (
  `id` int(11) NOT NULL,
  `poll_date` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00',
  `poll_title` text COLLATE utf8_bin DEFAULT NULL,
  `is_published` int(11) NOT NULL DEFAULT 1 COMMENT '1 = yes, 2 = no',
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00',
  `insert_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_online_poll`
--

INSERT INTO `tbl_online_poll` (`id`, `poll_date`, `poll_title`, `is_published`, `insert_time`, `insert_by`) VALUES
(4, '2022-11-30', 'Another Test', 1, '2022-11-24 12:34:16', 1),
(5, '2022-11-28', 'However, the common', 1, '2022-11-28 17:12:45', 1),
(6, '2022-11-17', 'As far as its modern ', 2, '2022-11-28 17:12:59', 1),
(7, '2022-11-18', 'Neque porro quisquam', 1, '2022-11-28 17:13:28', 1),
(8, '2022-11-16', 'because it is pain', 2, '2022-11-28 17:13:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_setting`
--

CREATE TABLE `tbl_page_setting` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `subtitle` text DEFAULT NULL,
  `youtube_video_link` text DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_page_setting`
--

INSERT INTO `tbl_page_setting` (`id`, `title`, `body`, `subtitle`, `youtube_video_link`, `photo`, `insert_by`, `insert_time`) VALUES
(5, 'ABOUT US', '<h2 style=\"font-style:italic; text-align:justify\"><strong><small><big><span style=\"font-size:14px\">Sulaimansupplies, Country first ever service provider of procurement tracking.Our prime focus is to simplify the supply hassles of procurement service the best of product quality,quantity management and time saving.We bring all that you need for your hotel supplies under one roof.&nbsp;&nbsp;</span></big></small></strong></h2>\r\n\r\n<h2 style=\"font-style:italic; text-align:justify\"><strong><small><big><span style=\"font-size:14px\">We are providing highest transparency with genuine products to pick from one open platfrom with gets door-step delivery.Everyday our website&#39;s(www.sulaimansupplies.com) retain service and skilled support team providing a-z hotel supply solution to clients within just one phone call.</span></big></small></strong></h2>\r\n', NULL, NULL, NULL, 0, '0000-00-00 00:00'),
(35, 'History', '<p>To facilitate global trade between worldwide buyers and Chinese suppliers.To provide accurate and dependable information on Chinese products and suppliers to global buyers.To help buyers and suppliers communicate and do business with each other effectively and efficiently</p>\r\n', NULL, NULL, NULL, 0, '0000-00-00 00:00'),
(36, 'Mission', '<p>To facilitate global trade between worldwide buyers and Chinese suppliers.To provide accurate and dependable information on Chinese products and suppliers to global buyers.To help buyers and suppliers communicate and do business with each other effectively and efficiently</p>\r\n', NULL, NULL, NULL, 0, '0000-00-00 00:00'),
(37, 'Vision', '<p>To facilitate global trade between worldwide buyers and Chinese suppliers.To provide accurate and dependable information on Chinese products and suppliers to global buyers.To help buyers and suppliers communicate and do business with each other effectively and efficiently</p>\r\n', NULL, NULL, NULL, 0, '0000-00-00 00:00'),
(38, 'Conference Room & Decoration ', '<p>Lorem ipsum dolor gtsitrty amet, consectetur adipisicing elit, sed do eiusm tempor &nbsp;incidid</p>\r\n', NULL, NULL, NULL, 0, '0000-00-00 00:00'),
(39, 'Room Decoration', '<p>Lorem ipsum dolor rtysittg amet, consectetur adipisicing elit, sed do eiusm tempor incididunt</p>\r\n', NULL, NULL, NULL, 0, '0000-00-00 00:00'),
(40, 'Table and  Chair', '<p>Lorem ipsum dolor frsit frtgamet, consectetur adipisicing elit, sed do eiusm tempor doloreut</p>\r\n', NULL, NULL, NULL, 0, '0000-00-00 00:00'),
(41, 'Waiting Room Decoration', '<p>Lorem ipsum dolor frsit frtramet, consectetur adipisicing elit, sed do eiusm tempordoloreut</p>\r\n', '', '', 'assets/pageSettings/feceypdp_20221128172559.jpg', 0, '0000-00-00 00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo_album`
--

CREATE TABLE `tbl_photo_album` (
  `id` int(11) NOT NULL,
  `album_title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1 COMMENT 'max are top',
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_photo_album`
--

INSERT INTO `tbl_photo_album` (`id`, `album_title`, `priority`, `insert_by`, `insert_time`) VALUES
(3, 'The standard ', 5, 1, '2022-11-28 16:55:19'),
(4, 'Ipsum passage', 3, 1, '2022-11-28 16:55:35'),
(5, 'Dolor sit amet', 3, 1, '2022-11-28 16:55:58'),
(6, 'Sed ut perspiciatis', 5, 1, '2022-11-28 16:56:16'),
(7, 'Translation by ', 10, 1, '2022-11-28 16:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo_gallery`
--

CREATE TABLE `tbl_photo_gallery` (
  `id` int(11) NOT NULL,
  `photo_album_id` int(11) DEFAULT 0,
  `photo_file` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_photo_gallery`
--

INSERT INTO `tbl_photo_gallery` (`id`, `photo_album_id`, `photo_file`, `title`, `insert_by`, `insert_time`) VALUES
(3, 7, 'assets/photoGallery/photodeca_20221128165719.jpg', ' Translation by', 1, '2022-11-28 16:57:19'),
(4, 6, 'assets/photoGallery/original_20221128165743.jpeg', 'On the other hand', 1, '2022-11-28 16:57:43'),
(5, 4, 'assets/photoGallery/istockphotoa_20221128165821.jpg', 'This principle of selection', 1, '2022-11-28 16:58:21'),
(6, 6, 'assets/photoGallery/JFLR_20221128165849.jpg', 'H. Rackham', 1, '2022-11-28 16:58:49'),
(7, 4, 'assets/photoGallery/feceypdp_20221128165927.jpg', 'So beguiled and demoralized', 1, '2022-11-28 16:59:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_poll_options`
--

CREATE TABLE `tbl_poll_options` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `option_1` text COLLATE utf8_bin DEFAULT NULL,
  `option_2` text COLLATE utf8_bin DEFAULT NULL,
  `option_3` text COLLATE utf8_bin DEFAULT NULL,
  `option_4` text COLLATE utf8_bin DEFAULT NULL,
  `option_5` text COLLATE utf8_bin DEFAULT NULL,
  `correct_option` text COLLATE utf8_bin NOT NULL DEFAULT '0',
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_poll_options`
--

INSERT INTO `tbl_poll_options` (`id`, `poll_id`, `option_1`, `option_2`, `option_3`, `option_4`, `option_5`, `correct_option`, `insert_by`, `insert_time`) VALUES
(2, 4, 'Test Update', 'Test1 Update', 'Test1  Update', 'Test1 Update', 'Test1', 'This is the best testasfgasdfasdf', 1, '2022-11-27 12:10:40'),
(3, 6, 'This site gives you ', 'a few more options ', 'to generate ', 'lorem ipsum text', 'Test1', 'This is the best test', 1, '2022-11-28 17:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_poll_voting`
--

CREATE TABLE `tbl_poll_voting` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `ip_address` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `selected_option_id` int(11) NOT NULL DEFAULT 0,
  `insert_time` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tbl_poll_voting`
--

INSERT INTO `tbl_poll_voting` (`id`, `poll_id`, `ip_address`, `selected_option_id`, `insert_time`) VALUES
(1, 4, 'Test', 1, '2022-11-24 13:22:02'),
(2, 4, '1510101', 1, '2022-11-24 13:31:12'),
(3, 6, '192.168.3.21', 4, '2022-11-28 14:15:07'),
(4, 6, '192.168.3.201', 1, '2022-11-28 17:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_send_list`
--

CREATE TABLE `tbl_sms_send_list` (
  `id` int(11) NOT NULL,
  `send_date_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `receiver_numbers` text COLLATE utf8_unicode_ci NOT NULL,
  `total_receiver` int(11) NOT NULL DEFAULT 0,
  `sms_part` int(11) NOT NULL DEFAULT 0,
  `total_sms_cost` int(11) NOT NULL DEFAULT 0,
  `insert_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_sms_send_list`
--

INSERT INTO `tbl_sms_send_list` (`id`, `send_date_time`, `message`, `receiver_numbers`, `total_receiver`, `sms_part`, `total_sms_cost`, `insert_by`) VALUES
(1, '2022-01-02 15:11:57', 'asd asd asdasd asd   sdf sdf dsf', '01709372481,01834014071', 2, 1, 2, 1),
(2, '2022-01-02 16:13:20', 'hi', '01736328444', 1, 1, 1, 1),
(3, '2022-01-02 16:13:47', 'hiii', '01736328444,01709372481', 2, 1, 2, 1),
(4, '2022-01-03 11:35:51', 'f sdfdsf sdf sdfsdf', '01709372481,01834014071', 2, 1, 2, 1),
(5, '2022-01-03 11:38:10', '11111111 2222222 dsj fskdjf hsdkjfhksdjfhdksjf', '01709372481,01834014071', 2, 1, 2, 1),
(6, '2022-02-28 19:56:41', 'test sms', '01709372481', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_send_setting`
--

CREATE TABLE `tbl_sms_send_setting` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_sms_send_setting`
--

INSERT INTO `tbl_sms_send_setting` (`id`, `username`, `password`, `last_update`) VALUES
(1, 'Nahid Hasan Update', '123456', '2022-11-28 11:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_upozilla`
--

CREATE TABLE `tbl_upozilla` (
  `id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `zilla_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_upozilla`
--

INSERT INTO `tbl_upozilla` (`id`, `division_id`, `zilla_id`, `name`) VALUES
(1, 1, 1, 'সাভার'),
(2, 1, 1, 'ধামরাই'),
(3, 1, 1, 'কেরাণীগঞ্জ'),
(4, 1, 1, 'নবাবগঞ্জ'),
(5, 1, 1, 'দোহার'),
(6, 1, 1, 'তেজগাঁও উন্নয়ন সার্কেল'),
(7, 1, 2, 'কালীগঞ্জ'),
(8, 1, 2, 'কালিয়াকৈর'),
(9, 1, 2, 'কাপাসিয়া'),
(10, 1, 2, 'গাজীপুর সদর'),
(11, 1, 2, 'শ্রীপুর'),
(12, 1, 3, 'বাসাইল'),
(13, 1, 3, 'ভুয়াপুর'),
(14, 1, 3, 'ঘাটাইল'),
(15, 1, 3, 'দেলদুয়ার'),
(16, 1, 3, 'গোপালপুর'),
(17, 1, 3, 'মধুপুর'),
(18, 1, 3, 'মির্জাপুর'),
(19, 1, 3, 'নাগরপুর'),
(20, 1, 3, 'সখিপুর'),
(21, 1, 3, 'টাঙ্গাইল সদর'),
(22, 1, 3, 'কালিহাতী'),
(23, 1, 3, 'ধনবাড়ি'),
(24, 1, 4, 'আড়াইহাজার'),
(25, 1, 4, 'বন্দর'),
(26, 1, 4, 'নারায়ণগঞ্জ সদর'),
(27, 1, 4, 'রূপগঞ্জ'),
(28, 1, 4, 'সোনারগাঁ'),
(29, 1, 5, 'ইটনা'),
(30, 1, 5, 'কটিয়াদি'),
(31, 1, 5, 'ভৈরব'),
(32, 1, 5, 'হোসেনপুর'),
(33, 1, 5, 'তাড়াইল'),
(34, 1, 5, 'পাকুন্দিয়া'),
(35, 1, 5, 'কুলিয়ারচর'),
(36, 1, 5, 'কিশোরগঞ্জ সদর'),
(37, 1, 5, 'করিমগঞ্জ'),
(38, 1, 5, 'বাজিতপুর'),
(39, 1, 5, 'অষ্টগ্রাম'),
(40, 1, 5, 'মিঠামইন'),
(41, 1, 5, 'নিকলী'),
(42, 1, 6, 'বেলাবো'),
(43, 1, 6, 'মনোহরদী'),
(44, 1, 6, 'নরসিংদী সদর'),
(45, 1, 6, 'পলাশ'),
(46, 1, 6, 'রায়পুরা'),
(47, 1, 6, 'শিবপুর'),
(48, 1, 7, 'রাজবাড়ী সদর'),
(49, 1, 7, 'গোয়ালন্দ'),
(50, 1, 7, 'পাংশা'),
(51, 1, 7, 'বালিয়াকান্দি'),
(52, 1, 7, 'কালুখালী'),
(53, 1, 8, 'ফরিদপুর সদর'),
(54, 1, 8, 'আলফাডাঙ্গা'),
(55, 1, 8, 'বোয়ালমারী'),
(56, 1, 8, 'সদরপুর'),
(57, 1, 8, 'নগরকান্দা'),
(58, 1, 8, 'ভাঙ্গা'),
(59, 1, 8, 'চরভদ্রাসন'),
(60, 1, 8, 'মধুখালী'),
(61, 1, 8, 'সালথা'),
(62, 1, 9, 'মাদারীপুর সদর'),
(63, 1, 9, 'শিবচর'),
(64, 1, 9, 'কালকিনি'),
(65, 1, 9, 'রাজৈর'),
(66, 1, 10, 'গোপালগঞ্জ সদর'),
(67, 1, 10, 'কাশিয়ানী'),
(68, 1, 10, 'টুংগীপাড়া'),
(69, 1, 10, 'কোটালীপাড়া'),
(70, 1, 10, 'মুকসুদপুর'),
(71, 1, 11, 'মুন্সিগঞ্জ সদর'),
(72, 1, 11, 'শ্রীনগর'),
(73, 1, 11, 'সিরাজদিখান'),
(74, 1, 11, 'লৌহজং '),
(75, 1, 11, 'গজারিয়া'),
(76, 1, 11, 'টংগিবাড়ী'),
(77, 1, 12, 'হরিরামপুর'),
(78, 1, 12, 'সাটুরিয়া'),
(79, 1, 12, 'মানিকগঞ্জ সদর'),
(80, 1, 12, 'ঘিওর'),
(81, 1, 12, 'শিবালয়'),
(82, 1, 12, 'দৌলতপুর'),
(83, 1, 12, 'সিংগাইর'),
(84, 1, 13, 'শরিয়তপুর সদর'),
(85, 1, 13, 'নড়িয়া'),
(86, 1, 13, 'জাজিরা'),
(87, 1, 13, 'গোসাইরহাট'),
(88, 1, 13, 'ভেদরগঞ্জ'),
(89, 1, 13, 'ডামুড্যা'),
(90, 2, 14, 'পবা'),
(91, 2, 14, 'দুর্গাপুর'),
(92, 2, 14, 'মোহনপুর'),
(93, 2, 14, 'চারঘাট'),
(94, 2, 14, 'পুঠিয়া'),
(95, 2, 14, 'বাঘা'),
(96, 2, 14, 'গোদাগাড়ী'),
(97, 2, 14, 'তানোর'),
(98, 2, 14, 'বাঘমারা'),
(99, 2, 15, 'বেলকুচি'),
(100, 2, 15, 'চৌহালি'),
(101, 2, 15, 'কামারখন্দ'),
(102, 2, 15, 'কাজীপুর'),
(103, 2, 15, 'রায়গঞ্জ'),
(104, 2, 15, 'শাহজাদপুর'),
(105, 2, 15, 'সিরাজগঞ্জ সদর'),
(106, 2, 15, 'তাড়াশ'),
(107, 2, 15, 'উল্লাপাড়া'),
(108, 2, 16, 'সুজানগর'),
(109, 2, 16, 'ঈশ্বরদী'),
(110, 2, 16, 'ভাঙ্গুরা'),
(111, 2, 16, 'পাবনা সদর'),
(112, 2, 16, 'বেড়া'),
(113, 2, 16, 'আটঘরিয়া'),
(114, 2, 16, 'চাটমোহর'),
(115, 2, 16, 'সাঁথিয়া'),
(116, 2, 16, 'ফরিদপুর'),
(117, 2, 17, 'কাহালু'),
(118, 2, 17, 'বগুড়া সদর'),
(119, 2, 17, 'সারিয়াকান্দি'),
(120, 2, 17, 'শাজাহানপুর'),
(121, 2, 17, 'দুপচাঁচিয়া'),
(122, 2, 17, 'আদমদিঘি'),
(123, 2, 17, 'নন্দিগ্রাম'),
(124, 2, 17, 'সোনাতলা'),
(125, 2, 17, 'ধুনট'),
(126, 2, 17, 'গাবতলী'),
(127, 2, 17, 'শেরপুর'),
(128, 2, 17, 'শিবগঞ্জ'),
(129, 2, 18, 'চাঁপাইনবাবগঞ্জ সদর'),
(130, 2, 18, 'গোমস্তাপুর'),
(131, 2, 18, 'নাচোল'),
(132, 2, 18, 'ভোলাহাট'),
(133, 2, 18, 'শিবগঞ্জ'),
(134, 2, 19, 'আক্কেলপুর'),
(135, 2, 19, 'কালাই'),
(136, 2, 19, 'ক্ষেতলাল'),
(137, 2, 19, 'পাঁচবিবি'),
(138, 2, 19, 'জয়পুরহাট সদর'),
(139, 2, 20, 'মহাদেবপুর'),
(140, 2, 20, 'বদলগাছী'),
(141, 2, 20, 'পত্নিতলা'),
(142, 2, 20, 'ধামইরহাট'),
(143, 2, 20, 'নিয়ামতপুর'),
(144, 2, 20, 'মান্দা'),
(145, 2, 20, 'আত্রাই'),
(146, 2, 20, 'রাণীনগর'),
(147, 2, 20, 'নওগাঁ সদর'),
(148, 2, 20, 'সাপাহার'),
(149, 2, 20, 'পোরশা'),
(150, 2, 21, 'নাটোর সদর'),
(151, 2, 21, 'সিংড়া'),
(152, 2, 21, 'বড়াইগ্রাম'),
(153, 2, 21, 'বাগাতিপাড়া'),
(154, 2, 21, 'গুরুদাসপুর'),
(155, 2, 21, 'লালপুর'),
(156, 2, 21, 'নলডাঙ্গা'),
(157, 3, 22, 'রাঙ্গুনিয়া'),
(158, 3, 22, 'সীতাকুণ্ড'),
(159, 3, 22, 'মীরসরাই'),
(160, 3, 22, 'পটিয়া'),
(161, 3, 22, 'সন্দ্বীপ'),
(162, 3, 22, 'বাঁশখালী'),
(163, 3, 22, 'বোয়ালখালী'),
(164, 3, 22, 'আনোয়ারা'),
(165, 3, 22, 'সাতকানিয়া'),
(166, 3, 22, 'লোহাগাড়া'),
(167, 3, 22, 'হাটহাজারী'),
(168, 3, 22, 'ফটিকছড়ি'),
(169, 3, 22, 'রাঊজান'),
(170, 3, 22, 'চন্দনাইশ'),
(171, 3, 23, 'দেবিদ্বার'),
(172, 3, 23, 'বরুড়া'),
(173, 3, 23, 'ব্রাহ্মণপাড়া'),
(174, 3, 23, 'চান্দিনা'),
(175, 3, 23, 'চৌদ্দগ্রাম'),
(176, 3, 23, 'দাউদকান্দি'),
(177, 3, 23, 'হোমনা'),
(178, 3, 23, 'লাকসাম'),
(179, 3, 23, 'মুরাদনগর'),
(180, 3, 23, 'নাঙ্গলকোট'),
(181, 3, 23, 'কুমিল্লা সদর'),
(182, 3, 23, 'মেঘনা'),
(183, 3, 23, 'মনোহরগঞ্জ'),
(184, 3, 23, 'সদর দক্ষিণ'),
(185, 3, 23, 'তিতাস'),
(186, 3, 23, 'বুড়িচং'),
(187, 3, 24, 'ছাগলনাইয়া'),
(188, 3, 24, 'ফেনী সদর'),
(189, 3, 24, 'সোনাগাজী'),
(190, 3, 24, 'ফুলগাজী'),
(191, 3, 24, 'পরশুরাম'),
(192, 3, 24, 'দাগনভুঞা'),
(193, 3, 25, 'ব্রাহ্মণবাড়িয়া সদর'),
(194, 3, 25, 'কসবা'),
(195, 3, 25, 'নাসিরনগর'),
(196, 3, 25, 'সরাইল'),
(197, 3, 25, 'আশুগঞ্জ'),
(198, 3, 25, 'আখাউরা'),
(199, 3, 25, 'নবীনগর'),
(200, 3, 25, 'বাঞ্ছারামপুর'),
(201, 3, 25, 'বিজয়নগর'),
(202, 3, 26, 'রাঙ্গামাটি সদর'),
(203, 3, 26, 'কাপ্তাই'),
(204, 3, 26, 'কাউখালী'),
(205, 3, 26, 'বাঘাইছড়ি'),
(206, 3, 26, 'বরকল'),
(207, 3, 26, 'লংগদু'),
(208, 3, 26, 'রাজস্থলী'),
(209, 3, 26, 'বিলাইছড়ি'),
(210, 3, 26, 'জুরাছড়ি'),
(211, 3, 26, 'নানিয়ারচর'),
(212, 3, 27, 'হাইমচর'),
(213, 3, 27, 'কচুয়া'),
(214, 3, 27, 'শহরাস্তি'),
(215, 3, 27, 'চাঁদপুর সদর'),
(216, 3, 27, 'মতলব উত্তর'),
(217, 3, 27, 'ফরিদ্গঞ্জ'),
(218, 3, 27, 'মতলব দক্ষিণ'),
(219, 3, 27, 'হাজীগঞ্জ'),
(220, 3, 28, 'নোয়াখালী সদর'),
(221, 3, 28, 'কোম্পানীগঞ্জ'),
(222, 3, 28, 'বেগমগঞ্জ'),
(223, 3, 28, 'হাতিয়া'),
(224, 3, 28, 'সুবর্ণচর'),
(225, 3, 28, 'কবিরহাট'),
(226, 3, 28, 'সেনবাগ'),
(227, 3, 28, 'চাটখিল'),
(228, 3, 28, 'সোনাইমুড়ী'),
(229, 3, 29, 'লক্ষ্মীপুর সদর'),
(230, 3, 29, 'কমলনগর'),
(231, 3, 29, 'রায়পুর'),
(232, 3, 29, 'রামগতি'),
(233, 3, 29, 'রামগঞ্জ'),
(234, 3, 30, 'কক্সবাজার সদর'),
(235, 3, 30, 'চকরিয়া'),
(236, 3, 30, 'কুতুবদিয়া'),
(237, 3, 30, 'উখিয়া'),
(238, 3, 30, 'মহেশখালী'),
(239, 3, 30, 'পেকুয়া'),
(240, 3, 30, 'রামু'),
(241, 3, 30, 'টেকনাফ'),
(242, 3, 31, 'খাগড়াছড়ি সদর'),
(243, 3, 31, 'দিঘীনালা'),
(244, 3, 31, 'পানছড়ি'),
(245, 3, 31, 'লক্ষীছড়ি'),
(246, 3, 31, 'মহালছড়ি'),
(247, 3, 31, 'মানিকছড়ি'),
(248, 3, 31, 'রামগড়'),
(249, 3, 31, 'মাটিরাঙ্গা'),
(250, 3, 31, 'গুইমারা'),
(251, 3, 32, 'বান্দরবান সদর'),
(252, 3, 32, 'আলীকদম'),
(253, 3, 32, 'নাইক্ষ্যংছড়ি'),
(254, 3, 32, 'রোয়াংছড়ি'),
(255, 3, 32, 'লামা'),
(256, 3, 32, 'রুমা'),
(257, 3, 32, 'থানচি'),
(258, 4, 33, 'বালাগঞ্জ'),
(259, 4, 33, 'বিয়ানীবাজার'),
(260, 4, 33, 'বিশ্বনাথ'),
(261, 4, 33, 'কোম্পানীগঞ্জ'),
(262, 4, 33, 'ফেঞ্চুগঞ্জ'),
(263, 4, 33, 'গোলাপগঞ্জ'),
(264, 4, 33, 'গোয়াইনঘাট'),
(265, 4, 33, 'জৈন্তাপুর'),
(266, 4, 33, 'কানাইঘাট'),
(267, 4, 33, 'সিলেট সদর'),
(268, 4, 33, 'জকিগঞ্জ'),
(269, 4, 33, 'দক্ষিণ সুরমা'),
(270, 4, 33, 'ওসমানী নগর'),
(271, 4, 34, 'বড়লেখা'),
(272, 4, 34, 'কমলগঞ্জ'),
(273, 4, 34, 'কুলাউরা'),
(274, 4, 34, 'মৌলভীবাজার সদর '),
(275, 4, 34, 'রাজনগর'),
(276, 4, 34, 'শ্রীমঙ্গল'),
(277, 4, 34, 'জুড়ী'),
(278, 4, 35, 'নবীগঞ্জ'),
(279, 4, 35, 'বাহুবল'),
(280, 4, 35, 'আজমিরীগঞ্জ'),
(281, 4, 35, 'বানিয়াচং'),
(282, 4, 35, 'লাখাই'),
(283, 4, 35, 'চুনারুঘাট'),
(284, 4, 35, 'হবিগঞ্জ সদর'),
(285, 4, 35, 'মাধবপুর'),
(286, 4, 36, 'সুনামগঞ্জ সদর'),
(287, 4, 36, 'দক্ষিণ সুনামগঞ্জ'),
(288, 4, 36, 'বিশ্বম্ভরপুর'),
(289, 4, 36, 'ছাতক'),
(290, 4, 36, 'জগন্নাথপুর'),
(291, 4, 36, 'তাহিরপুর'),
(292, 4, 36, 'ধর্মপাশা'),
(293, 4, 36, 'জামালগঞ্জ'),
(294, 4, 36, 'শাল্লা'),
(295, 4, 36, 'দিরাই'),
(296, 4, 36, 'দোয়ারাবাজার'),
(297, 5, 37, 'পাইকগাছা'),
(298, 5, 37, 'ফুলতলা'),
(299, 5, 37, 'দিঘলিয়া'),
(300, 5, 37, 'রূপসা'),
(301, 5, 37, 'তেরখাদা'),
(302, 5, 37, 'ডুমুরিয়া'),
(303, 5, 37, 'বটিয়াঘাটা'),
(304, 5, 37, 'দাকোপ'),
(305, 5, 37, 'কয়রা'),
(306, 5, 38, 'মণিরামপুর'),
(307, 5, 38, 'অভয়নগর'),
(308, 5, 38, 'বাঘারপাড়া'),
(309, 5, 38, 'চৌগাছা'),
(310, 5, 38, 'ঝিকরগাছা'),
(311, 5, 38, 'কেশবপুর'),
(312, 5, 38, 'যশোর সদর'),
(313, 5, 38, 'শার্শা'),
(314, 5, 39, 'আশাশুনি'),
(315, 5, 39, 'দেবহাটা'),
(316, 5, 39, 'কলারোয়া'),
(317, 5, 39, 'সাতক্ষীরা সদর'),
(318, 5, 39, 'শ্যামনগর'),
(319, 5, 39, 'তালা'),
(320, 5, 39, 'কালিগঞ্জ'),
(321, 5, 40, 'মুজিবনগর'),
(322, 5, 40, 'মেহেরপুর সদর'),
(323, 5, 40, 'গাংনী'),
(324, 5, 41, 'নড়াইল সদর'),
(325, 5, 41, 'লোহাগড়া'),
(326, 5, 41, 'কালিয়া'),
(327, 5, 42, 'চুয়াডাঙ্গা সদর'),
(328, 5, 42, 'আলমডাঙ্গা'),
(329, 5, 42, 'দামুড়হুদা'),
(330, 5, 42, 'জীবননগর'),
(331, 5, 43, 'শালিখা'),
(332, 5, 43, 'শ্রীপুর'),
(333, 5, 43, 'মাগুরা সদর'),
(334, 5, 43, 'মহম্মদপুর'),
(335, 5, 44, 'ফকিরহাট'),
(336, 5, 44, 'বাগেরহাট সদর'),
(337, 5, 44, 'মোল্লাহাট'),
(338, 5, 44, 'শরণখোলা'),
(339, 5, 44, 'রামপাল'),
(340, 5, 44, 'মোড়েলগঞ্জ'),
(341, 5, 44, 'কচুয়া'),
(342, 5, 44, 'মোংলা'),
(343, 5, 44, 'চিতলমারী'),
(344, 5, 45, 'ঝিনাইদহ সদর'),
(345, 5, 45, 'শৈলকুপা'),
(346, 5, 45, 'হরিণাকুণ্ডু '),
(347, 5, 45, 'কালীগঞ্জ'),
(348, 5, 45, 'কোটচাঁদপুর'),
(349, 5, 45, 'মহেশপুর'),
(350, 5, 46, 'কুষ্টিয়া সদর'),
(351, 5, 46, 'কুমারখালী'),
(352, 5, 46, 'খোকসা'),
(353, 5, 46, 'মিরপুর'),
(354, 5, 46, 'দৌলতপুর'),
(355, 5, 46, 'ভেড়ামারা'),
(356, 6, 47, 'বরিশাল সদর'),
(357, 6, 47, 'বাকেরগঞ্জ'),
(358, 6, 47, 'বাবুগঞ্জ'),
(359, 6, 47, 'উজিরপুর'),
(360, 6, 47, 'বানারীপাড়া'),
(361, 6, 47, 'গৌরনদী'),
(362, 6, 47, 'আগৈলঝাড়া'),
(363, 6, 47, 'মেহেন্দিগঞ্জ'),
(364, 6, 47, 'মুলাদী'),
(365, 6, 47, 'হিজলা'),
(366, 6, 48, 'ঝালকাঠি সদর'),
(367, 6, 48, 'কাঠালিয়া'),
(368, 6, 48, 'নলছিটি'),
(369, 6, 48, 'রাজাপুর'),
(370, 6, 49, 'বাউফল'),
(371, 6, 49, 'পটুয়াখালী সদর'),
(372, 6, 49, 'দুমকি'),
(373, 6, 49, 'দশমিনা'),
(374, 6, 49, 'কলাপাড়া'),
(375, 6, 49, 'মির্জাগঞ্জ'),
(376, 6, 49, 'গলাচিপা'),
(377, 6, 49, 'রাঙ্গাবালী'),
(378, 6, 50, 'পিরোজপুর সদর'),
(379, 6, 50, 'নাজিরপুর'),
(380, 6, 50, 'কাউখালী'),
(381, 6, 50, 'জিয়ানগর'),
(382, 6, 50, 'ভান্ডারিয়া'),
(383, 6, 50, 'মঠবাড়ীয়া'),
(384, 6, 50, 'নেছারাবাদ'),
(385, 6, 51, 'ভোলা সদর'),
(386, 6, 51, 'বোরহানউদ্দিন'),
(387, 6, 51, 'চরফ্যাশন'),
(388, 6, 51, 'দৌলতখান'),
(389, 6, 51, 'মনপুরা'),
(390, 6, 51, 'তজুমদ্দিন'),
(391, 6, 51, 'লালমোহন'),
(392, 6, 52, 'আমতলী'),
(393, 6, 52, 'বরগুনা সদর'),
(394, 6, 52, 'বেতাগী'),
(395, 6, 52, 'বামনা'),
(396, 6, 52, 'পাথরঘাটা'),
(397, 6, 52, 'তালতলি'),
(398, 7, 53, 'রংপুর সদর'),
(399, 7, 53, 'গঙ্গাচড়া'),
(400, 7, 53, 'তারাগঞ্জ'),
(401, 7, 53, 'বদরগঞ্জ'),
(402, 7, 53, 'মিঠাপুকুর'),
(403, 7, 53, 'কাউনিয়া'),
(404, 7, 53, 'পীরগঞ্জ'),
(405, 7, 53, 'পীরগাছা'),
(406, 7, 54, 'লালমনিরহাট সদর'),
(407, 7, 54, 'আদিতমারী'),
(408, 7, 54, 'কালীগঞ্জ'),
(409, 7, 54, 'হাতীবান্ধা'),
(410, 7, 54, 'পাটগ্রাম'),
(411, 7, 55, 'পঞ্চগড় সদর'),
(412, 7, 55, 'দেবীগঞ্জ'),
(413, 7, 55, 'বোদা'),
(414, 7, 55, 'আটোয়ারী'),
(415, 7, 55, 'তেতুলিয়া'),
(416, 7, 56, 'কুড়িগ্রাম সদর'),
(417, 7, 56, 'নাগেশ্বরী'),
(418, 7, 56, 'ভুরুঙ্গামারী'),
(419, 7, 56, 'ফুলবাড়ী'),
(420, 7, 56, 'রাজারহাট'),
(421, 7, 56, 'উলিপুর'),
(422, 7, 56, 'চিলমারী'),
(423, 7, 56, 'রৌমারী'),
(424, 7, 56, 'চর রাজিবপুর'),
(425, 7, 57, 'নবাবগঞ্জ'),
(426, 7, 57, 'বীরগঞ্জ'),
(427, 7, 57, 'ঘোড়াঘাট'),
(428, 7, 57, 'বিরামপুর'),
(429, 7, 57, 'পার্বতীপুর'),
(430, 7, 57, 'বোচাগঞ্জ'),
(431, 7, 57, 'কাহারোল'),
(432, 7, 57, 'ফুলবাড়ী'),
(433, 7, 57, 'দিনাজপুর সদর'),
(434, 7, 57, 'হাকিমপুর'),
(435, 7, 57, 'খানসামা'),
(436, 7, 57, 'বিরল'),
(437, 7, 57, 'চিরিরবন্দর'),
(438, 7, 58, 'ঠাকুরগাঁও সদর'),
(439, 7, 58, 'পীরগঞ্জ'),
(440, 7, 58, 'রাণীশংকৈল'),
(441, 7, 58, 'হরিপুর'),
(442, 7, 58, 'বালিয়াডাঙ্গী'),
(443, 7, 59, 'সাদুল্লাপুর'),
(444, 7, 59, 'গাইবান্ধা সদর'),
(445, 7, 59, 'পলাশবাড়ী'),
(446, 7, 59, 'সাঘাটা'),
(447, 7, 59, 'গোবিন্দগঞ্জ'),
(448, 7, 59, 'সুন্দরগঞ্জ'),
(449, 7, 59, 'ফুলছড়ি'),
(450, 7, 60, 'সৈয়দপুর'),
(451, 7, 60, 'ডোমার'),
(452, 7, 60, 'ডিমলা'),
(453, 7, 60, 'জলঢাকা'),
(454, 7, 60, 'কিশোরগঞ্জ'),
(455, 7, 60, 'নীলফামারী সদর'),
(456, 8, 61, 'ফুলবাড়ীয়া '),
(457, 8, 61, 'ত্রিশাল'),
(458, 8, 61, 'ভালুকা'),
(459, 8, 61, 'মুক্তাগাছা'),
(460, 8, 61, 'ময়মনসিংহ সদর'),
(461, 8, 61, 'ধোবাউরা'),
(462, 8, 61, 'ফুলপুর'),
(463, 8, 61, 'হালুয়াঘাট'),
(464, 8, 61, 'গৌরীপুর'),
(465, 8, 61, 'গফরগাঁও'),
(466, 8, 61, 'ঈশ্বরগঞ্জ'),
(467, 8, 61, 'নান্দাইল'),
(468, 8, 61, 'তারাকান্দা'),
(469, 8, 62, 'জামালপুর সদর'),
(470, 8, 62, 'মেলান্দহ'),
(471, 8, 62, 'ইসলামপুর'),
(472, 8, 62, 'দেওয়ানগঞ্জ'),
(473, 8, 62, 'সরিষাবাড়ী'),
(474, 8, 62, 'মাদারগঞ্জ'),
(475, 8, 62, 'বকশীগঞ্জ'),
(476, 8, 63, 'বারহাট্টা'),
(477, 8, 63, 'দুর্গাপুর'),
(478, 8, 63, 'কেন্দুয়া'),
(479, 8, 63, 'আটপাড়া'),
(480, 8, 63, 'মদন'),
(481, 8, 63, 'খালিয়াজুরী'),
(482, 8, 63, 'কলমাকান্দা'),
(483, 8, 63, 'মোহনগঞ্জ'),
(484, 8, 63, 'পূর্বধলা'),
(485, 8, 63, 'নেত্রকোনা সদর'),
(486, 8, 64, 'শেরপুর সদর'),
(487, 8, 64, 'নালিতাবাড়ী'),
(488, 8, 64, 'শ্রীবরদী'),
(489, 8, 64, 'নকলা'),
(490, 8, 64, 'ঝিনাইগাতী'),
(491, 1, 1, 'ঢাকা মহানগর');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video_album`
--

CREATE TABLE `tbl_video_album` (
  `id` int(11) NOT NULL,
  `album_title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1 COMMENT 'max are top',
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_video_album`
--

INSERT INTO `tbl_video_album` (`id`, `album_title`, `priority`, `insert_by`, `insert_time`) VALUES
(1, 'Lorem Ipsum', 1, 1, '2022-11-28 16:47:15'),
(2, 'Is simply dummy', 5, 1, '2022-11-28 16:47:38'),
(3, 'The printing', 2, 1, '2022-11-28 16:49:07'),
(4, 'Aldus PageMaker ', 6, 1, '2022-11-28 16:49:54'),
(5, 'There are many', 2, 1, '2022-11-28 16:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video_gallery`
--

CREATE TABLE `tbl_video_gallery` (
  `id` int(11) NOT NULL,
  `video_album_id` int(11) NOT NULL DEFAULT 0,
  `youtube_video_link` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_video_gallery`
--

INSERT INTO `tbl_video_gallery` (`id`, `video_album_id`, `youtube_video_link`, `title`, `insert_by`, `insert_time`) VALUES
(1, 4, 'https://translate.google.com/', 'Contrary to popular belief', 1, '2022-11-28 16:50:45'),
(2, 2, 'https://translate.google.com/', 'literature from', 1, '2022-11-28 16:51:09'),
(3, 2, 'https://translate.google.com/', 'many variations ', 1, '2022-11-28 16:51:32'),
(4, 3, 'https://translate.google.com/', 'Lorem Ipsum is ', 1, '2022-11-28 16:51:57'),
(5, 5, 'https://translate.google.com/', 'the word in classical ', 1, '2022-11-28 16:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_zilla`
--

CREATE TABLE `tbl_zilla` (
  `id` int(11) NOT NULL,
  `divission_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_zilla`
--

INSERT INTO `tbl_zilla` (`id`, `divission_id`, `name`) VALUES
(1, 1, 'ঢাকা'),
(2, 1, 'গাজীপুর'),
(3, 1, 'টাঙ্গাইল'),
(4, 1, 'নারায়ণগঞ্জ'),
(5, 1, 'কিশোরগঞ্জ'),
(6, 1, 'নরসিংদী'),
(7, 1, 'রাজবাড়ী'),
(8, 1, 'ফরিদপুর'),
(9, 1, 'মাদারীপুর'),
(10, 1, 'গোপালগঞ্জ'),
(11, 1, 'মুন্সিগঞ্জ'),
(12, 1, 'মানিকগঞ্জ'),
(13, 1, 'শরীয়তপুর'),
(14, 2, 'রাজশাহী'),
(15, 2, 'সিরাজগঞ্জ'),
(16, 2, 'পাবনা'),
(17, 2, 'বগুড়া'),
(18, 2, 'চাঁপাইনবাবগঞ্জ'),
(19, 2, 'জয়পুরহাট'),
(20, 2, 'নওগাঁ'),
(21, 2, 'নাটোর'),
(22, 3, 'চট্টগ্রাম'),
(23, 3, 'কুমিল্লা'),
(24, 3, 'ফেনী'),
(25, 3, 'ব্রাহ্মণবাড়িয়া'),
(26, 3, 'রাঙ্গামাটি'),
(27, 3, 'চাঁদপুর'),
(28, 3, 'নোয়াখালী'),
(29, 3, 'লক্ষ্মীপুর'),
(30, 3, 'কক্সবাজার'),
(31, 3, 'খাগড়াছড়ি'),
(32, 3, 'বান্দরবান'),
(33, 4, 'সিলেট'),
(34, 4, 'মৌলভীবাজার'),
(35, 4, 'হবিগঞ্জ'),
(36, 4, 'সুনামগঞ্জ'),
(37, 5, 'খুলনা'),
(38, 5, 'যশোর'),
(39, 5, 'সাতক্ষীরা'),
(40, 5, 'মেহেরপুর'),
(41, 5, 'নড়াইল'),
(42, 5, 'চুয়াডাঙ্গা'),
(43, 5, 'মাগুড়া'),
(44, 5, 'বাগেরহাট'),
(45, 5, 'ঝিনাইদহ'),
(46, 5, 'কুষ্টিয়া'),
(47, 6, 'বরিশাল'),
(48, 6, 'ঝালকাঠি'),
(49, 6, 'পটুয়াখালী'),
(50, 6, 'পিরোজপুর'),
(51, 6, 'ভোলা'),
(52, 6, 'বরগুনা'),
(53, 7, 'রংপুর'),
(54, 7, 'লালমনিরহাট'),
(55, 7, 'পঞ্চগড়'),
(56, 7, 'কুড়িগ্রাম'),
(57, 7, 'দিনাজপুর'),
(58, 7, 'ঠাকুরগাঁও'),
(59, 7, 'গাইবান্ধা'),
(60, 7, 'নীলফামারী'),
(61, 8, 'ময়মনসিংহ'),
(62, 8, 'জামালপুর'),
(63, 8, 'নেত্রকোনা'),
(64, 8, 'শেরপুর');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `address` int(11) NOT NULL COMMENT 'thana id',
  `district` varchar(30) NOT NULL,
  `division` varchar(30) NOT NULL,
  `roadHouse` text NOT NULL,
  `postcode` varchar(100) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `phone` text NOT NULL,
  `userType` text NOT NULL,
  `photo` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `birthdate` varchar(10) NOT NULL DEFAULT '0000-00-00',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 for active user, 0 for not active user',
  `emailVerified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 for verify, 0 for not verify',
  `mobileVerified` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 for verify, 0 for not verify'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `address`, `district`, `division`, `roadHouse`, `postcode`, `blood_group`, `phone`, `userType`, `photo`, `birthdate`, `status`, `emailVerified`, `mobileVerified`) VALUES
(1, 'MD. Rayhanuzzaman', 'Roky', 'rzroky', 'rzroky1@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, '', '', '12/6 solimullah road', '', '', '01709372481', 'admin', 'assets/userPhoto/_20200902145306.jpg', '0000-00-00', 1, 0, 0),
(3, 'Abul', 'Mia', 'abul', 'abul@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, '', '', 'Dhaka Bangladesh', '', '', '01712725161', 'user', 'assets/userPhoto/feceypdp_20221121154723.jpg', '0000-00-00', 1, 0, 0),
(4, 'Rahim', 'Mia', 'rahim', 'rahim@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 90, '', '', 'Dhaka Bangladesh', '', '', '01743699072', 'user', 'assets/userPhoto/TiagoNascimentohalfbody_20221121155522.png', '0000-00-00', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='types of user, each type has single controller';

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `value`, `name`) VALUES
(1, 'user', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_status`
--
ALTER TABLE `log_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_recovery`
--
ALTER TABLE `password_recovery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_divission`
--
ALTER TABLE `tbl_divission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_footer_address`
--
ALTER TABLE `tbl_footer_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_footer_authorty`
--
ALTER TABLE `tbl_footer_authorty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news_category`
--
ALTER TABLE `tbl_news_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news_category_set`
--
ALTER TABLE `tbl_news_category_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news_photos`
--
ALTER TABLE `tbl_news_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news_sub_category`
--
ALTER TABLE `tbl_news_sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_news_videos`
--
ALTER TABLE `tbl_news_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_online_poll`
--
ALTER TABLE `tbl_online_poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page_setting`
--
ALTER TABLE `tbl_page_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_photo_album`
--
ALTER TABLE `tbl_photo_album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_photo_gallery`
--
ALTER TABLE `tbl_photo_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_poll_options`
--
ALTER TABLE `tbl_poll_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_poll_voting`
--
ALTER TABLE `tbl_poll_voting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sms_send_list`
--
ALTER TABLE `tbl_sms_send_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sms_send_setting`
--
ALTER TABLE `tbl_sms_send_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_upozilla`
--
ALTER TABLE `tbl_upozilla`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video_album`
--
ALTER TABLE `tbl_video_album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video_gallery`
--
ALTER TABLE `tbl_video_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_zilla`
--
ALTER TABLE `tbl_zilla`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_status`
--
ALTER TABLE `log_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_recovery`
--
ALTER TABLE `password_recovery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_divission`
--
ALTER TABLE `tbl_divission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_footer_address`
--
ALTER TABLE `tbl_footer_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_footer_authorty`
--
ALTER TABLE `tbl_footer_authorty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_news_category`
--
ALTER TABLE `tbl_news_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_news_category_set`
--
ALTER TABLE `tbl_news_category_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_news_photos`
--
ALTER TABLE `tbl_news_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_news_sub_category`
--
ALTER TABLE `tbl_news_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_news_videos`
--
ALTER TABLE `tbl_news_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_online_poll`
--
ALTER TABLE `tbl_online_poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_page_setting`
--
ALTER TABLE `tbl_page_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_photo_album`
--
ALTER TABLE `tbl_photo_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_photo_gallery`
--
ALTER TABLE `tbl_photo_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_poll_options`
--
ALTER TABLE `tbl_poll_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_poll_voting`
--
ALTER TABLE `tbl_poll_voting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_sms_send_list`
--
ALTER TABLE `tbl_sms_send_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_sms_send_setting`
--
ALTER TABLE `tbl_sms_send_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_upozilla`
--
ALTER TABLE `tbl_upozilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=492;

--
-- AUTO_INCREMENT for table `tbl_video_album`
--
ALTER TABLE `tbl_video_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_video_gallery`
--
ALTER TABLE `tbl_video_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_zilla`
--
ALTER TABLE `tbl_zilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
