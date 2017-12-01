-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2017 at 06:00 AM
-- Server version: 5.6.21-70.1-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u1701227_tastyigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `ti_activities`
--

CREATE TABLE IF NOT EXISTS `ti_activities` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(10) NOT NULL,
  `context` varchar(128) NOT NULL,
  `user` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(32) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `ti_activities`
--

INSERT INTO `ti_activities` (`activity_id`, `domain`, `context`, `user`, `user_id`, `action`, `message`, `status`, `date_added`) VALUES
(11, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-08-11 10:06:08'),
(12, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-08-11 10:21:22'),
(13, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-08-11 10:22:56'),
(14, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-08-11 12:21:10'),
(15, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-08-12 07:02:34'),
(16, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-08-12 07:04:48'),
(17, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-08-12 07:06:04'),
(18, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-08-12 07:06:42'),
(19, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-08-14 13:00:03'),
(20, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-09-21 09:54:50'),
(21, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-10-03 10:56:25'),
(22, 'main', 'customers', 'staff', 8, 'registered', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=8">Harshul Singhal</a> <b>registered</b> an <b>account.</b>', 0, '2017-10-08 18:50:07'),
(23, 'main', 'customers', 'customer', 8, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=8">Harshul Singhal</a> <b>logged</b> in.', 0, '2017-10-08 18:50:26'),
(24, 'main', 'customers', 'customer', 8, 'logged out', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=8">Harshul Singhal</a> <b>logged</b> out.', 0, '2017-10-08 19:02:46'),
(25, 'main', 'customers', 'customer', 10, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=10">Harshul Singhal</a> <b>logged</b> in.', 0, '2017-10-08 19:38:26'),
(26, 'main', 'customers', 'customer', 10, 'logged out', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=10">Harshul Singhal</a> <b>logged</b> out.', 0, '2017-10-08 19:38:39'),
(27, 'main', 'customers', 'customer', 10, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=10">Harshul Singhal</a> <b>logged</b> in.', 0, '2017-10-08 20:29:49'),
(28, 'main', 'customers', 'customer', 10, 'logged out', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=10">Harshul Singhal</a> <b>logged</b> out.', 0, '2017-10-08 20:29:54'),
(29, 'main', 'customers', 'customer', 10, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=10">Harshul Singhal</a> <b>logged</b> in.', 0, '2017-10-08 20:39:49'),
(30, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-10-08 20:41:57'),
(31, 'admin', 'menus', 'staff', 11, 'updated', 'harshul <b>updated</b> menu item <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/menus/edit?id=110"><b>Pav-Bhaji.</b></a>', 0, '2017-10-08 21:13:25'),
(32, 'admin', 'extensions', 'staff', 11, 'installed', 'harshul <b>installed</b> module extension <b>Banners.</b>', 0, '2017-10-08 21:19:29'),
(33, 'admin', 'extensions', 'staff', 11, 'uninstalled', 'harshul <b>uninstalled</b> module extension <b>Reservation.</b>', 0, '2017-10-08 21:20:06'),
(34, 'admin', 'extensions', 'staff', 11, 'installed', 'harshul <b>installed</b> module extension <b>Reservation.</b>', 0, '2017-10-08 21:20:22'),
(35, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-10-31 16:41:57'),
(36, 'main', 'customers', 'staff', 15, 'registered', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=15">Harshul Singhal</a> <b>registered</b> an <b>account.</b>', 0, '2017-11-16 23:46:55'),
(37, 'main', 'customers', 'customer', 15, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=15">Harshul Singhal</a> <b>logged</b> in.', 0, '2017-11-16 23:47:04'),
(38, 'main', 'reservations', 'customer', 15, 'reserved', 'Harshul Singhal made a new <b>reservation</b> <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/reservations/edit?id=20011"><b>#20011.</b></a>', 0, '2017-11-16 23:48:23'),
(39, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:36:19'),
(40, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:39:11'),
(41, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:39:47'),
(42, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:42:08'),
(43, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:43:30'),
(44, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:43:30'),
(45, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:43:50'),
(46, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:51:00'),
(47, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:51:21'),
(48, 'admin', 'locations', 'staff', 11, 'updated', 'harshul <b>updated</b> location <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/locations/edit?id=11"><b>Annapurna Cafe.</b></a>', 0, '2017-11-21 19:59:19'),
(49, 'main', 'customers', 'customer', 15, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/customers/edit?id=15">Harshul Singhal</a> <b>logged</b> in.', 0, '2017-11-24 22:57:56'),
(50, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-25 00:08:47'),
(51, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-25 13:00:52'),
(52, 'admin', 'orders', 'staff', 11, 'updated', 'harshul <b>updated</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=5920"><b>#5920.</b></a>', 0, '2017-11-25 13:22:16'),
(53, 'admin', 'orders', 'staff', 11, 'assigned', 'harshul <b>assigned</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=5920"><b>#5920</b></a> to <b><a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a>.</b>', 0, '2017-11-25 13:22:16'),
(54, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-25 14:34:14'),
(55, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-26 21:02:49'),
(56, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-26 23:44:53'),
(57, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-27 00:16:43'),
(58, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-27 14:07:41'),
(59, 'admin', 'orders', 'staff', 11, 'updated', 'harshul <b>updated</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=96881"><b>#96881.</b></a>', 0, '2017-11-27 14:08:24'),
(60, 'admin', 'orders', 'staff', 11, 'updated', 'harshul <b>updated</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=96881"><b>#96881.</b></a>', 0, '2017-11-27 14:08:44'),
(61, 'admin', 'orders', 'staff', 11, 'assigned', 'harshul <b>assigned</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=96881"><b>#96881</b></a> to <b><a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a>.</b>', 0, '2017-11-27 14:08:44'),
(62, 'admin', 'orders', 'staff', 11, 'updated', 'harshul <b>updated</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=96881"><b>#96881.</b></a>', 0, '2017-11-27 14:08:57'),
(63, 'admin', 'orders', 'staff', 11, 'updated', 'harshul <b>updated</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=96881"><b>#96881.</b></a>', 0, '2017-11-27 14:09:11'),
(64, 'admin', 'orders', 'staff', 11, 'updated', 'harshul <b>updated</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=96881"><b>#96881.</b></a>', 0, '2017-11-27 14:09:34'),
(65, 'admin', 'orders', 'staff', 11, 'updated', 'harshul <b>updated</b> order <a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/orders/edit?id=16739"><b>#16739.</b></a>', 0, '2017-11-27 14:27:26'),
(66, 'admin', 'staffs', 'staff', 11, 'logged in', '<a href="http://u1701227.nettech.firm.in/TastyIgniter-master/admin/staffs/edit?id=11">harshul</a> <b>logged</b> in.', 0, '2017-11-29 13:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `ti_addresses`
--

CREATE TABLE IF NOT EXISTS `ti_addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(15) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `ti_addresses`
--

INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES
(1, 1, 'jiit', 'abb3', 'Noida', 'UP', '201301', 99),
(2, 2, 'tyjackx', 'tgssjs', 'Ghaziabad', 'UP', '201309', 0),
(3, 3, '', '', '', '', '', 99),
(4, 4, 'ghhh', 'hhh', 'hvb', 'bjn', '999', 99),
(5, 5, 'hhu', 'bjj', 'bj', 'njk', '28639', 99),
(6, 6, 'A-10 ', 'Sector 22', 'Noida', 'Uttar Pradesh', '201301', 99),
(7, 7, 'qwe', 'qwe', 'q', 'q', '1', 99),
(8, 8, 'C5, 404, Avalon Gardens', 'Alwar Bypass Road', 'Bhiwadi', 'Rajasthan', '301019', 99),
(9, 8, 'abb3 room 1148', 'jiit', 'noida', 'Uttar Pradesh', '201301', 99),
(10, 9, 'Jaypee', 'Sector-62', 'Noida', 'UP', '', 99),
(11, 10, 'Jaypee', 'Sector-62', 'Noida', 'UP', '', 99),
(12, 11, 'n', 'b', 'b', 'b', '9', 99),
(13, 12, 'f', 't', 'f', 't', '2', 99),
(14, 13, 'dbdb', 'dbdb', 'dbsb', 'dhdh', '9898', 99),
(15, 14, 'g', 'u', 'y', 'u', '6', 99),
(16, 16, 'E151', 'Raj Nagar', 'Ghaziabad', 'Uttar Pradesh', '201001', 99),
(17, 17, 'v', 'b', 'b', 'b', '2', 99),
(18, 18, '', '', '', '', '', 0),
(19, 19, 'nn', 'n', 'n', 'n', '9', 99),
(20, 20, 'JIIT', 'Sector 62', 'Noida', 'UP', '201307', 99),
(21, 21, 'vssn', 'ndjd', 'nsns', 'dbs', '94', 99),
(22, 22, 'q', 'q', 'Noida', 'UP', '1', 99),
(23, 23, 'b', 'b', 'b', 'b', '9', 99),
(24, 24, 'q', 'q', 'q', 'q', '1', 99),
(25, 25, 'n', 'b', 'bb', 'n', '9', 99),
(26, 26, '395/1, Street No.-11(EXTN.)', 'Rajendra Nagar, Kaulagarh Road', 'Dehradun', 'Uttarakhand', '248001', 99),
(27, 27, 'n', 'n', 'n', 'b', '9', 99),
(28, 28, 'E 151 Sanjay Nagar', 'Sector 23', 'Ghaziabad', 'Uttar Pradesh', '201002', 99),
(29, 29, 'a', 'a', 'a', 'a', '201014', 99),
(30, 30, 'JIIT', 'Sector 62', 'Noida', 'UP', '201307', 99);

-- --------------------------------------------------------

--
-- Table structure for table `ti_banners`
--

CREATE TABLE IF NOT EXISTS `ti_banners` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` char(8) NOT NULL,
  `click_url` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `image_code` text NOT NULL,
  `custom_code` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_categories`
--

CREATE TABLE IF NOT EXISTS `ti_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `french_name` varchar(32) DEFAULT NULL,
  `french_description` text,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `ti_categories`
--

INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `priority`, `image`, `status`, `french_name`, `french_description`) VALUES
(15, 'Snacks', 'Snacks come in a variety of forms including packaged snack foods and other processed foods.', 0, 0, 'data/categories/snacks.png', 1, 'Collations', 'Les collations se présentent sous diverses formes, y compris des collations emballées et d''autres aliments transformés.'),
(18, 'South Indian', 'The use of lentils and spices, dried red chilies and fresh green chilies, coconut, and native fruits and vegetables.', 0, 0, 'data/categories/south_indian.png', 1, 'Indien du Sud', 'L''utilisation de lentilles et d''épices, de piments rouges séchés et de piments verts frais, de noix de coco et de fruits et légumes indigènes.'),
(19, 'North Indian', 'North Indian curries usually have thick, moderately spicy and creamy gravies. The use of dried fruits and nuts is fairly common even in everyday foods.', 0, 0, 'data/categories/north_indian.png', 1, 'Indien du Nord', 'Les currys des Indes du Nord ont généralement des sauces épaisses, modérément épicées et crémeuses. L''utilisation de fruits secs et de noix est assez courante même dans les aliments de tous les jours.'),
(20, 'Chinese', 'Chinese culture, which includes cuisine originating from the diverse regions of China, as well as from Chinese people in other parts of the world', 0, 0, 'data/categories/chinese.png', 1, 'Chinois', 'La culture chinoise, qui inclut la cuisine provenant des diverses régions de la Chine, aussi bien que des personnes chinoises dans d''autres parties du monde'),
(22, 'Packed Items', 'The packed items available at store including Chips , Biscuits or Cake.', 0, 0, 'data/categories/packed_food.png', 1, 'Articles emballés', 'Les articles emballés disponibles au magasin, y compris les puces, biscuits ou gâteaux.'),
(23, 'Beverages', 'Drinks such as soda pop, sparkling water, iced tea, lemonade, root beer, fruit punch, milk, hot chocolate, tea, coffee, milkshakes, and tap water and energy drinks', 0, 0, 'data/categories/beverages.png', 1, 'Boissons', 'Boissons telles que boissons gazeuses, eau pétillante, thé glacé, limonade, bière à base de racines, punch aux fruits, lait, chocolat chaud, thé, café, milkshakes, eau potable et boissons énergisantes.'),
(24, 'Daily Specials', 'Dishes of the day are those dishes which are made only some particular days.', 0, 0, 'data/categories/special.png', 1, 'Les plats du jour', 'Les plats du jour sont ces plats qui sont faits seulement quelques jours particuliers.');

-- --------------------------------------------------------

--
-- Table structure for table `ti_countries`
--

CREATE TABLE IF NOT EXISTS `ti_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `format` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flag` varchar(255) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=241 ;

--
-- Dumping data for table `ti_countries`
--

INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 1, 'data/flags/af.png'),
(2, 'Albania', 'AL', 'ALB', '', 1, 'data/flags/al.png'),
(3, 'Algeria', 'DZ', 'DZA', '', 1, 'data/flags/dz.png'),
(4, 'American Samoa', 'AS', 'ASM', '', 1, 'data/flags/as.png'),
(5, 'Andorra', 'AD', 'AND', '', 1, 'data/flags/ad.png'),
(6, 'Angola', 'AO', 'AGO', '', 1, 'data/flags/ao.png'),
(7, 'Anguilla', 'AI', 'AIA', '', 1, 'data/flags/ai.png'),
(8, 'Antarctica', 'AQ', 'ATA', '', 1, 'data/flags/aq.png'),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 1, 'data/flags/ag.png'),
(10, 'Argentina', 'AR', 'ARG', '', 1, 'data/flags/ar.png'),
(11, 'Armenia', 'AM', 'ARM', '', 1, 'data/flags/am.png'),
(12, 'Aruba', 'AW', 'ABW', '', 1, 'data/flags/aw.png'),
(13, 'Australia', 'AU', 'AUS', '', 1, 'data/flags/au.png'),
(14, 'Austria', 'AT', 'AUT', '', 1, 'data/flags/at.png'),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 1, 'data/flags/az.png'),
(16, 'Bahamas', 'BS', 'BHS', '', 1, 'data/flags/bs.png'),
(17, 'Bahrain', 'BH', 'BHR', '', 1, 'data/flags/bh.png'),
(18, 'Bangladesh', 'BD', 'BGD', '', 1, 'data/flags/bd.png'),
(19, 'Barbados', 'BB', 'BRB', '', 1, 'data/flags/bb.png'),
(20, 'Belarus', 'BY', 'BLR', '', 1, 'data/flags/by.png'),
(21, 'Belgium', 'BE', 'BEL', '', 1, 'data/flags/be.png'),
(22, 'Belize', 'BZ', 'BLZ', '', 1, 'data/flags/bz.png'),
(23, 'Benin', 'BJ', 'BEN', '', 1, 'data/flags/bj.png'),
(24, 'Bermuda', 'BM', 'BMU', '', 1, 'data/flags/bm.png'),
(25, 'Bhutan', 'BT', 'BTN', '', 1, 'data/flags/bt.png'),
(26, 'Bolivia', 'BO', 'BOL', '', 1, 'data/flags/bo.png'),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', '', 1, 'data/flags/ba.png'),
(28, 'Botswana', 'BW', 'BWA', '', 1, 'data/flags/bw.png'),
(29, 'Bouvet Island', 'BV', 'BVT', '', 1, 'data/flags/bv.png'),
(30, 'Brazil', 'BR', 'BRA', '', 1, 'data/flags/br.png'),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 1, 'data/flags/io.png'),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 1, 'data/flags/bn.png'),
(33, 'Bulgaria', 'BG', 'BGR', '', 1, 'data/flags/bg.png'),
(34, 'Burkina Faso', 'BF', 'BFA', '', 1, 'data/flags/bf.png'),
(35, 'Burundi', 'BI', 'BDI', '', 1, 'data/flags/bi.png'),
(36, 'Cambodia', 'KH', 'KHM', '', 1, 'data/flags/kh.png'),
(37, 'Cameroon', 'CM', 'CMR', '', 1, 'data/flags/cm.png'),
(38, 'Canada', 'CA', 'CAN', '', 1, 'data/flags/ca.png'),
(39, 'Cape Verde', 'CV', 'CPV', '', 1, 'data/flags/cv.png'),
(40, 'Cayman Islands', 'KY', 'CYM', '', 1, 'data/flags/ky.png'),
(41, 'Central African Republic', 'CF', 'CAF', '', 1, 'data/flags/cf.png'),
(42, 'Chad', 'TD', 'TCD', '', 1, 'data/flags/td.png'),
(43, 'Chile', 'CL', 'CHL', '', 1, 'data/flags/cl.png'),
(44, 'China', 'CN', 'CHN', '', 1, 'data/flags/cn.png'),
(45, 'Christmas Island', 'CX', 'CXR', '', 1, 'data/flags/cx.png'),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 1, 'data/flags/cc.png'),
(47, 'Colombia', 'CO', 'COL', '', 1, 'data/flags/co.png'),
(48, 'Comoros', 'KM', 'COM', '', 1, 'data/flags/km.png'),
(49, 'Congo', 'CG', 'COG', '', 1, 'data/flags/cg.png'),
(50, 'Cook Islands', 'CK', 'COK', '', 1, 'data/flags/ck.png'),
(51, 'Costa Rica', 'CR', 'CRI', '', 1, 'data/flags/cr.png'),
(52, 'Cote D''Ivoire', 'CI', 'CIV', '', 1, 'data/flags/ci.png'),
(53, 'Croatia', 'HR', 'HRV', '', 1, 'data/flags/hr.png'),
(54, 'Cuba', 'CU', 'CUB', '', 1, 'data/flags/cu.png'),
(55, 'Cyprus', 'CY', 'CYP', '', 1, 'data/flags/cy.png'),
(56, 'Czech Republic', 'CZ', 'CZE', '', 1, 'data/flags/cz.png'),
(57, 'Denmark', 'DK', 'DNK', '', 1, 'data/flags/dk.png'),
(58, 'Djibouti', 'DJ', 'DJI', '', 1, 'data/flags/dj.png'),
(59, 'Dominica', 'DM', 'DMA', '', 1, 'data/flags/dm.png'),
(60, 'Dominican Republic', 'DO', 'DOM', '', 1, 'data/flags/do.png'),
(61, 'East Timor', 'TP', 'TMP', '', 1, 'data/flags/tp.png'),
(62, 'Ecuador', 'EC', 'ECU', '', 1, 'data/flags/ec.png'),
(63, 'Egypt', 'EG', 'EGY', '', 1, 'data/flags/eg.png'),
(64, 'El Salvador', 'SV', 'SLV', '', 1, 'data/flags/sv.png'),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 1, 'data/flags/gq.png'),
(66, 'Eritrea', 'ER', 'ERI', '', 1, 'data/flags/er.png'),
(67, 'Estonia', 'EE', 'EST', '', 1, 'data/flags/ee.png'),
(68, 'Ethiopia', 'ET', 'ETH', '', 1, 'data/flags/et.png'),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 1, 'data/flags/fk.png'),
(70, 'Faroe Islands', 'FO', 'FRO', '', 1, 'data/flags/fo.png'),
(71, 'Fiji', 'FJ', 'FJI', '', 1, 'data/flags/fj.png'),
(72, 'Finland', 'FI', 'FIN', '', 1, 'data/flags/fi.png'),
(73, 'France', 'FR', 'FRA', '', 1, 'data/flags/fr.png'),
(74, 'France, Metropolitan', 'FX', 'FXX', '', 1, 'data/flags/fx.png'),
(75, 'French Guiana', 'GF', 'GUF', '', 1, 'data/flags/gf.png'),
(76, 'French Polynesia', 'PF', 'PYF', '', 1, 'data/flags/pf.png'),
(77, 'French Southern Territories', 'TF', 'ATF', '', 1, 'data/flags/tf.png'),
(78, 'Gabon', 'GA', 'GAB', '', 1, 'data/flags/ga.png'),
(79, 'Gambia', 'GM', 'GMB', '', 1, 'data/flags/gm.png'),
(80, 'Georgia', 'GE', 'GEO', '', 1, 'data/flags/ge.png'),
(81, 'Germany', 'DE', 'DEU', '', 1, 'data/flags/de.png'),
(82, 'Ghana', 'GH', 'GHA', '', 1, 'data/flags/gh.png'),
(83, 'Gibraltar', 'GI', 'GIB', '', 1, 'data/flags/gi.png'),
(84, 'Greece', 'GR', 'GRC', '', 1, 'data/flags/gr.png'),
(85, 'Greenland', 'GL', 'GRL', '', 1, 'data/flags/gl.png'),
(86, 'Grenada', 'GD', 'GRD', '', 1, 'data/flags/gd.png'),
(87, 'Guadeloupe', 'GP', 'GLP', '', 1, 'data/flags/gp.png'),
(88, 'Guam', 'GU', 'GUM', '', 1, 'data/flags/gu.png'),
(89, 'Guatemala', 'GT', 'GTM', '', 1, 'data/flags/gt.png'),
(90, 'Guinea', 'GN', 'GIN', '', 1, 'data/flags/gn.png'),
(91, 'Guinea-bissau', 'GW', 'GNB', '', 1, 'data/flags/gw.png'),
(92, 'Guyana', 'GY', 'GUY', '', 1, 'data/flags/gy.png'),
(93, 'Haiti', 'HT', 'HTI', '', 1, 'data/flags/ht.png'),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 1, 'data/flags/hm.png'),
(95, 'Honduras', 'HN', 'HND', '', 1, 'data/flags/hn.png'),
(96, 'Hong Kong', 'HK', 'HKG', '', 1, 'data/flags/hk.png'),
(97, 'Hungary', 'HU', 'HUN', '', 1, 'data/flags/hu.png'),
(98, 'Iceland', 'IS', 'ISL', '', 1, 'data/flags/is.png'),
(99, 'India', 'IN', 'IND', '', 1, 'data/flags/in.png'),
(100, 'Indonesia', 'ID', 'IDN', '', 1, 'data/flags/id.png'),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', '', 1, 'data/flags/ir.png'),
(102, 'Iraq', 'IQ', 'IRQ', '', 1, 'data/flags/iq.png'),
(103, 'Ireland', 'IE', 'IRL', '', 1, 'data/flags/ie.png'),
(104, 'Israel', 'IL', 'ISR', '', 1, 'data/flags/il.png'),
(105, 'Italy', 'IT', 'ITA', '', 1, 'data/flags/it.png'),
(106, 'Jamaica', 'JM', 'JAM', '', 1, 'data/flags/jm.png'),
(107, 'Japan', 'JP', 'JPN', '', 1, 'data/flags/jp.png'),
(108, 'Jordan', 'JO', 'JOR', '', 1, 'data/flags/jo.png'),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 1, 'data/flags/kz.png'),
(110, 'Kenya', 'KE', 'KEN', '', 1, 'data/flags/ke.png'),
(111, 'Kiribati', 'KI', 'KIR', '', 1, 'data/flags/ki.png'),
(112, 'North Korea', 'KP', 'PRK', '', 1, 'data/flags/kp.png'),
(113, 'Korea, Republic of', 'KR', 'KOR', '', 1, 'data/flags/kr.png'),
(114, 'Kuwait', 'KW', 'KWT', '', 1, 'data/flags/kw.png'),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 1, 'data/flags/kg.png'),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', '', 1, 'data/flags/la.png'),
(117, 'Latvia', 'LV', 'LVA', '', 1, 'data/flags/lv.png'),
(118, 'Lebanon', 'LB', 'LBN', '', 1, 'data/flags/lb.png'),
(119, 'Lesotho', 'LS', 'LSO', '', 1, 'data/flags/ls.png'),
(120, 'Liberia', 'LR', 'LBR', '', 1, 'data/flags/lr.png'),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 1, 'data/flags/ly.png'),
(122, 'Liechtenstein', 'LI', 'LIE', '', 1, 'data/flags/li.png'),
(123, 'Lithuania', 'LT', 'LTU', '', 1, 'data/flags/lt.png'),
(124, 'Luxembourg', 'LU', 'LUX', '', 1, 'data/flags/lu.png'),
(125, 'Macau', 'MO', 'MAC', '', 1, 'data/flags/mo.png'),
(126, 'FYROM', 'MK', 'MKD', '', 1, 'data/flags/mk.png'),
(127, 'Madagascar', 'MG', 'MDG', '', 1, 'data/flags/mg.png'),
(128, 'Malawi', 'MW', 'MWI', '', 1, 'data/flags/mw.png'),
(129, 'Malaysia', 'MY', 'MYS', '', 1, 'data/flags/my.png'),
(130, 'Maldives', 'MV', 'MDV', '', 1, 'data/flags/mv.png'),
(131, 'Mali', 'ML', 'MLI', '', 1, 'data/flags/ml.png'),
(132, 'Malta', 'MT', 'MLT', '', 1, 'data/flags/mt.png'),
(133, 'Marshall Islands', 'MH', 'MHL', '', 1, 'data/flags/mh.png'),
(134, 'Martinique', 'MQ', 'MTQ', '', 1, 'data/flags/mq.png'),
(135, 'Mauritania', 'MR', 'MRT', '', 1, 'data/flags/mr.png'),
(136, 'Mauritius', 'MU', 'MUS', '', 1, 'data/flags/mu.png'),
(137, 'Mayotte', 'YT', 'MYT', '', 1, 'data/flags/yt.png'),
(138, 'Mexico', 'MX', 'MEX', '', 1, 'data/flags/mx.png'),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 1, 'data/flags/fm.png'),
(140, 'Moldova, Republic of', 'MD', 'MDA', '', 1, 'data/flags/md.png'),
(141, 'Monaco', 'MC', 'MCO', '', 1, 'data/flags/mc.png'),
(142, 'Mongolia', 'MN', 'MNG', '', 1, 'data/flags/mn.png'),
(143, 'Montserrat', 'MS', 'MSR', '', 1, 'data/flags/ms.png'),
(144, 'Morocco', 'MA', 'MAR', '', 1, 'data/flags/ma.png'),
(145, 'Mozambique', 'MZ', 'MOZ', '', 1, 'data/flags/mz.png'),
(146, 'Myanmar', 'MM', 'MMR', '', 1, 'data/flags/mm.png'),
(147, 'Namibia', 'NA', 'NAM', '', 1, 'data/flags/na.png'),
(148, 'Nauru', 'NR', 'NRU', '', 1, 'data/flags/nr.png'),
(149, 'Nepal', 'NP', 'NPL', '', 1, 'data/flags/np.png'),
(150, 'Netherlands', 'NL', 'NLD', '', 1, 'data/flags/nl.png'),
(151, 'Netherlands Antilles', 'AN', 'ANT', '', 1, 'data/flags/an.png'),
(152, 'New Caledonia', 'NC', 'NCL', '', 1, 'data/flags/nc.png'),
(153, 'New Zealand', 'NZ', 'NZL', '', 1, 'data/flags/nz.png'),
(154, 'Nicaragua', 'NI', 'NIC', '', 1, 'data/flags/ni.png'),
(155, 'Niger', 'NE', 'NER', '', 1, 'data/flags/ne.png'),
(156, 'Nigeria', 'NG', 'NGA', '', 1, 'data/flags/ng.png'),
(157, 'Niue', 'NU', 'NIU', '', 1, 'data/flags/nu.png'),
(158, 'Norfolk Island', 'NF', 'NFK', '', 1, 'data/flags/nf.png'),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 1, 'data/flags/mp.png'),
(160, 'Norway', 'NO', 'NOR', '', 1, 'data/flags/no.png'),
(161, 'Oman', 'OM', 'OMN', '', 1, 'data/flags/om.png'),
(162, 'Pakistan', 'PK', 'PAK', '', 1, 'data/flags/pk.png'),
(163, 'Palau', 'PW', 'PLW', '', 1, 'data/flags/pw.png'),
(164, 'Panama', 'PA', 'PAN', '', 1, 'data/flags/pa.png'),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 1, 'data/flags/pg.png'),
(166, 'Paraguay', 'PY', 'PRY', '', 1, 'data/flags/py.png'),
(167, 'Peru', 'PE', 'PER', '', 1, 'data/flags/pe.png'),
(168, 'Philippines', 'PH', 'PHL', '', 1, 'data/flags/ph.png'),
(169, 'Pitcairn', 'PN', 'PCN', '', 1, 'data/flags/pn.png'),
(170, 'Poland', 'PL', 'POL', '', 1, 'data/flags/pl.png'),
(171, 'Portugal', 'PT', 'PRT', '', 1, 'data/flags/pt.png'),
(172, 'Puerto Rico', 'PR', 'PRI', '', 1, 'data/flags/pr.png'),
(173, 'Qatar', 'QA', 'QAT', '', 1, 'data/flags/qa.png'),
(174, 'Reunion', 'RE', 'REU', '', 1, 'data/flags/re.png'),
(175, 'Romania', 'RO', 'ROM', '', 1, 'data/flags/ro.png'),
(176, 'Russian Federation', 'RU', 'RUS', '', 1, 'data/flags/ru.png'),
(177, 'Rwanda', 'RW', 'RWA', '', 1, 'data/flags/rw.png'),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 1, 'data/flags/kn.png'),
(179, 'Saint Lucia', 'LC', 'LCA', '', 1, 'data/flags/lc.png'),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 1, 'data/flags/vc.png'),
(181, 'Samoa', 'WS', 'WSM', '', 1, 'data/flags/ws.png'),
(182, 'San Marino', 'SM', 'SMR', '', 1, 'data/flags/sm.png'),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 1, 'data/flags/st.png'),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 1, 'data/flags/sa.png'),
(185, 'Senegal', 'SN', 'SEN', '', 1, 'data/flags/sn.png'),
(186, 'Seychelles', 'SC', 'SYC', '', 1, 'data/flags/sc.png'),
(187, 'Sierra Leone', 'SL', 'SLE', '', 1, 'data/flags/sl.png'),
(188, 'Singapore', 'SG', 'SGP', '', 1, 'data/flags/sg.png'),
(189, 'Slovak Republic', 'SK', 'SVK', '', 1, 'data/flags/sk.png'),
(190, 'Slovenia', 'SI', 'SVN', '', 1, 'data/flags/si.png'),
(191, 'Solomon Islands', 'SB', 'SLB', '', 1, 'data/flags/sb.png'),
(192, 'Somalia', 'SO', 'SOM', '', 1, 'data/flags/so.png'),
(193, 'South Africa', 'ZA', 'ZAF', '', 1, 'data/flags/za.png'),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 1, 'data/flags/gs.png'),
(195, 'Spain', 'ES', 'ESP', '', 1, 'data/flags/es.png'),
(196, 'Sri Lanka', 'LK', 'LKA', '', 1, 'data/flags/lk.png'),
(197, 'St. Helena', 'SH', 'SHN', '', 1, 'data/flags/sh.png'),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 1, 'data/flags/pm.png'),
(199, 'Sudan', 'SD', 'SDN', '', 1, 'data/flags/sd.png'),
(200, 'Suriname', 'SR', 'SUR', '', 1, 'data/flags/sr.png'),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 1, 'data/flags/sj.png'),
(202, 'Swaziland', 'SZ', 'SWZ', '', 1, 'data/flags/sz.png'),
(203, 'Sweden', 'SE', 'SWE', '', 1, 'data/flags/se.png'),
(204, 'Switzerland', 'CH', 'CHE', '', 1, 'data/flags/ch.png'),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 1, 'data/flags/sy.png'),
(206, 'Taiwan', 'TW', 'TWN', '', 1, 'data/flags/tw.png'),
(207, 'Tajikistan', 'TJ', 'TJK', '', 1, 'data/flags/tj.png'),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 1, 'data/flags/tz.png'),
(209, 'Thailand', 'TH', 'THA', '', 1, 'data/flags/th.png'),
(210, 'Togo', 'TG', 'TGO', '', 1, 'data/flags/tg.png'),
(211, 'Tokelau', 'TK', 'TKL', '', 1, 'data/flags/tk.png'),
(212, 'Tonga', 'TO', 'TON', '', 1, 'data/flags/to.png'),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 1, 'data/flags/tt.png'),
(214, 'Tunisia', 'TN', 'TUN', '', 1, 'data/flags/tn.png'),
(215, 'Turkey', 'TR', 'TUR', '', 1, 'data/flags/tr.png'),
(216, 'Turkmenistan', 'TM', 'TKM', '', 1, 'data/flags/tm.png'),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 1, 'data/flags/tc.png'),
(218, 'Tuvalu', 'TV', 'TUV', '', 1, 'data/flags/tv.png'),
(219, 'Uganda', 'UG', 'UGA', '', 1, 'data/flags/ug.png'),
(220, 'Ukraine', 'UA', 'UKR', '', 1, 'data/flags/ua.png'),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 1, 'data/flags/ae.png'),
(222, 'United Kingdom', 'GB', 'GBR', '{address_1}\n{address_2}\n{city} {postcode} {state}\n{country}', 1, 'data/flags/gb.png'),
(223, 'United States', 'US', 'USA', '', 1, 'data/flags/us.png'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 1, 'data/flags/um.png'),
(225, 'Uruguay', 'UY', 'URY', '', 1, 'data/flags/uy.png'),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 1, 'data/flags/uz.png'),
(227, 'Vanuatu', 'VU', 'VUT', '', 1, 'data/flags/vu.png'),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 1, 'data/flags/va.png'),
(229, 'Venezuela', 'VE', 'VEN', '', 1, 'data/flags/ve.png'),
(230, 'Viet Nam', 'VN', 'VNM', '', 1, 'data/flags/vn.png'),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 1, 'data/flags/vg.png'),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 1, 'data/flags/vi.png'),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 1, 'data/flags/wf.png'),
(234, 'Western Sahara', 'EH', 'ESH', '', 1, 'data/flags/eh.png'),
(235, 'Yemen', 'YE', 'YEM', '', 1, 'data/flags/ye.png'),
(236, 'Yugoslavia', 'YU', 'YUG', '', 1, 'data/flags/yu.png'),
(237, 'Democratic Republic of Congo', 'CD', 'COD', '', 1, 'data/flags/cd.png'),
(238, 'Zambia', 'ZM', 'ZMB', '', 1, 'data/flags/zm.png'),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 1, 'data/flags/zw.png');

-- --------------------------------------------------------

--
-- Table structure for table `ti_coupons`
--

CREATE TABLE IF NOT EXISTS `ti_coupons` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` varchar(15) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,4) DEFAULT NULL,
  `min_total` decimal(15,4) DEFAULT NULL,
  `redemptions` int(11) NOT NULL DEFAULT '0',
  `customer_redemptions` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` date NOT NULL,
  `validity` char(15) NOT NULL,
  `fixed_date` date DEFAULT NULL,
  `fixed_from_time` time DEFAULT NULL,
  `fixed_to_time` time DEFAULT NULL,
  `period_start_date` date DEFAULT NULL,
  `period_end_date` date DEFAULT NULL,
  `recurring_every` varchar(35) NOT NULL,
  `recurring_from_time` time DEFAULT NULL,
  `recurring_to_time` time DEFAULT NULL,
  `order_restriction` tinyint(4) NOT NULL,
  PRIMARY KEY (`coupon_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ti_coupons`
--

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `status`, `date_added`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`, `order_restriction`) VALUES
(11, 'Half Sundays', '2222', 'F', '100.0000', '500.0000', 0, 0, '', 1, '0000-00-00', 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0),
(12, 'Half Tuesdays', '3333', 'P', '30.0000', '1000.0000', 0, 0, '', 1, '0000-00-00', 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0),
(13, 'Full Mondays', 'MTo6TuTg', 'P', '50.0000', '0.0000', 0, 1, '', 1, '0000-00-00', 'forever', NULL, '00:00:00', '23:59:00', NULL, NULL, '', '00:00:00', '23:59:00', 0),
(14, 'Full Tuesdays', '4444', 'F', '500.0000', '5000.0000', 0, 0, '', 1, '0000-00-00', 'recurring', NULL, '00:00:00', '23:59:00', NULL, NULL, '0, 2, 4, 5, 6', '00:00:00', '23:59:00', 0),
(15, 'Full Wednesdays', '5555', 'F', '5000.0000', '5000.0000', 0, 0, '', 1, '0000-00-00', 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ti_coupons_history`
--

CREATE TABLE IF NOT EXISTS `ti_coupons_history` (
  `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `min_total` decimal(15,4) DEFAULT NULL,
  `amount` decimal(15,4) DEFAULT NULL,
  `date_used` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`coupon_history_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_currencies`
--

CREATE TABLE IF NOT EXISTS `ti_currencies` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `currency_name` varchar(32) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_symbol` varchar(3) NOT NULL,
  `currency_rate` decimal(15,8) NOT NULL,
  `symbol_position` tinyint(4) NOT NULL,
  `thousand_sign` char(1) NOT NULL,
  `decimal_sign` char(1) NOT NULL,
  `decimal_position` char(1) NOT NULL,
  `iso_alpha2` varchar(2) NOT NULL,
  `iso_alpha3` varchar(3) NOT NULL,
  `iso_numeric` int(11) NOT NULL,
  `flag` varchar(6) NOT NULL,
  `currency_status` int(1) NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `ti_currencies`
--

INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_rate`, `symbol_position`, `thousand_sign`, `decimal_sign`, `decimal_position`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`, `date_modified`) VALUES
(1, 1, 'Afghani', 'AFN', '؋', '1.05240000', 0, ',', '.', '2', 'AF', 'AFG', 4, 'AF.png', 0, '2017-10-31 16:41:58'),
(2, 2, 'Lek', 'ALL', 'Lek', '1.76660000', 0, ',', '.', '2', 'AL', 'ALB', 8, 'AL.png', 0, '2017-10-31 16:41:58'),
(3, 3, 'Dinar', 'DZD', 'د.ج', '1.77490000', 0, ',', '.', '2', 'DZ', 'DZA', 12, 'DZ.png', 0, '2017-10-31 16:41:58'),
(4, 4, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'AS', 'ASM', 16, 'AS.png', 0, '2017-10-31 16:41:58'),
(5, 5, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'AD', 'AND', 20, 'AD.png', 0, '2017-10-31 16:41:58'),
(6, 6, 'Kwanza', 'AOA', 'Kz', '2.54950000', 0, ',', '.', '2', 'AO', 'AGO', 24, 'AO.png', 0, '2017-10-31 16:41:58'),
(7, 7, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'AI', 'AIA', 660, 'AI.png', 0, '2017-10-31 16:41:58'),
(8, 8, 'Antarctican', 'AQD', 'A$', '0.00000000', 0, ',', '.', '2', 'AQ', 'ATA', 10, 'AQ.png', 0, '2017-10-31 16:41:58'),
(9, 9, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'AG', 'ATG', 28, 'AG.png', 0, '2017-10-31 16:41:58'),
(10, 10, 'Peso', 'ARS', '$', '0.27320000', 0, ',', '.', '2', 'AR', 'ARG', 32, 'AR.png', 0, '2017-10-31 16:41:58'),
(11, 11, 'Dram', 'AMD', 'դր.', '7.44100000', 0, ',', '.', '2', 'AM', 'ARM', 51, 'AM.png', 0, '2017-10-31 16:41:58'),
(12, 12, 'Guilder', 'AWG', 'ƒ', '0.02750000', 0, ',', '.', '2', 'AW', 'ABW', 533, 'AW.png', 0, '2017-10-31 16:41:58'),
(13, 13, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'AU', 'AUS', 36, 'AU.png', 0, '2017-10-31 16:41:58'),
(14, 14, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'AT', 'AUT', 40, 'AT.png', 0, '2017-10-31 16:41:58'),
(15, 15, 'Manat', 'AZN', 'ман', '0.02620000', 0, ',', '.', '2', 'AZ', 'AZE', 31, 'AZ.png', 0, '2017-10-31 16:41:58'),
(16, 16, 'Dollar', 'BSD', '$', '0.01540000', 0, ',', '.', '2', 'BS', 'BHS', 44, 'BS.png', 0, '2017-10-31 16:41:58'),
(17, 17, 'Dinar', 'BHD', '.د.', '0.00580000', 0, ',', '.', '2', 'BH', 'BHR', 48, 'BH.png', 0, '2017-10-31 16:41:58'),
(18, 18, 'Taka', 'BDT', '৳', '1.27910000', 0, ',', '.', '2', 'BD', 'BGD', 50, 'BD.png', 0, '2017-10-31 16:41:58'),
(19, 19, 'Dollar', 'BBD', '$', '0.03090000', 0, ',', '.', '2', 'BB', 'BRB', 52, 'BB.png', 0, '2017-10-31 16:41:58'),
(20, 20, 'Ruble', 'BYR', 'p.', '309.15340000', 0, ',', '.', '2', 'BY', 'BLR', 112, 'BY.png', 0, '2017-10-31 16:41:58'),
(21, 21, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'BE', 'BEL', 56, 'BE.png', 0, '2017-10-31 16:41:58'),
(22, 22, 'Dollar', 'BZD', 'BZ$', '0.03090000', 0, ',', '.', '2', 'BZ', 'BLZ', 84, 'BZ.png', 0, '2017-10-31 16:41:58'),
(23, 23, 'Franc', 'XOF', '', '8.70230000', 0, ',', '.', '2', 'BJ', 'BEN', 204, 'BJ.png', 0, '2017-10-31 16:41:58'),
(24, 24, 'Dollar', 'BMD', '$', '0.01540000', 0, ',', '.', '2', 'BM', 'BMU', 60, 'BM.png', 0, '2017-10-31 16:41:58'),
(25, 25, 'Ngultrum', 'BTN', 'Nu.', '1.00030000', 0, ',', '.', '2', 'BT', 'BTN', 64, 'BT.png', 0, '2017-10-31 16:41:58'),
(26, 26, 'Boliviano', 'BOB', '$b', '0.10580000', 0, ',', '.', '2', 'BO', 'BOL', 68, 'BO.png', 0, '2017-10-31 16:41:58'),
(27, 27, 'Marka', 'BAM', 'KM', '0.02600000', 0, ',', '.', '2', 'BA', 'BIH', 70, 'BA.png', 0, '2017-10-31 16:41:58'),
(28, 28, 'Pula', 'BWP', 'P', '0.16210000', 0, ',', '.', '2', 'BW', 'BWA', 72, 'BW.png', 0, '2017-10-31 16:41:58'),
(29, 29, 'Krone', 'NOK', 'kr', '0.12630000', 0, ',', '.', '2', 'BV', 'BVT', 74, 'BV.png', 0, '2017-10-31 16:41:58'),
(30, 30, 'Real', 'BRL', 'R$', '0.05070000', 0, ',', '.', '2', 'BR', 'BRA', 76, 'BR.png', 0, '2017-10-31 16:41:58'),
(31, 31, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'IO', 'IOT', 86, 'IO.png', 0, '2017-10-31 16:41:58'),
(32, 231, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'VG', 'VGB', 92, 'VG.png', 0, '2017-10-31 16:41:58'),
(33, 32, 'Dollar', 'BND', '$', '0.02100000', 0, ',', '.', '2', 'BN', 'BRN', 96, 'BN.png', 0, '2017-10-31 16:41:58'),
(34, 33, 'Lev', 'BGN', 'лв', '0.02600000', 0, ',', '.', '2', 'BG', 'BGR', 100, 'BG.png', 0, '2017-10-31 16:41:58'),
(35, 34, 'Franc', 'XOF', '', '8.70230000', 0, ',', '.', '2', 'BF', 'BFA', 854, 'BF.png', 0, '2017-10-31 16:41:58'),
(36, 35, 'Franc', 'BIF', 'Fr', '26.87800000', 0, ',', '.', '2', 'BI', 'BDI', 108, 'BI.png', 0, '2017-10-31 16:41:58'),
(37, 36, 'Riels', 'KHR', '៛', '62.41750000', 0, ',', '.', '2', 'KH', 'KHM', 116, 'KH.png', 0, '2017-10-31 16:41:58'),
(38, 37, 'Franc', 'XAF', 'FCF', '8.69970000', 0, ',', '.', '2', 'CM', 'CMR', 120, 'CM.png', 0, '2017-10-31 16:41:58'),
(39, 38, 'Dollar', 'CAD', '$', '0.01980000', 0, ',', '.', '2', 'CA', 'CAN', 124, 'CA.png', 0, '2017-10-31 16:41:58'),
(40, 39, 'Escudo', 'CVE', '', '1.46350000', 0, ',', '.', '2', 'CV', 'CPV', 132, 'CV.png', 0, '2017-10-31 16:41:58'),
(41, 40, 'Dollar', 'KYD', '$', '0.01270000', 0, ',', '.', '2', 'KY', 'CYM', 136, 'KY.png', 0, '2017-10-31 16:41:58'),
(42, 41, 'Franc', 'XAF', 'FCF', '8.69970000', 0, ',', '.', '2', 'CF', 'CAF', 140, 'CF.png', 0, '2017-10-31 16:41:58'),
(43, 42, 'Franc', 'XAF', '', '8.69970000', 0, ',', '.', '2', 'TD', 'TCD', 148, 'TD.png', 0, '2017-10-31 16:41:58'),
(44, 43, 'Peso', 'CLP', '', '9.84440000', 0, ',', '.', '2', 'CL', 'CHL', 152, 'CL.png', 0, '2017-10-31 16:41:58'),
(45, 44, 'Yuan Renminbi', 'CNY', '¥', '0.10190000', 0, ',', '.', '2', 'CN', 'CHN', 156, 'CN.png', 0, '2017-10-31 16:41:58'),
(46, 45, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'CX', 'CXR', 162, 'CX.png', 0, '2017-10-31 16:41:58'),
(47, 46, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'CC', 'CCK', 166, 'CC.png', 0, '2017-10-31 16:41:58'),
(48, 47, 'Peso', 'COP', '$', '46.66640000', 0, ',', '.', '2', 'CO', 'COL', 170, 'CO.png', 0, '2017-10-31 16:41:58'),
(49, 48, 'Franc', 'KMF', '', '6.41190000', 0, ',', '.', '2', 'KM', 'COM', 174, 'KM.png', 0, '2017-10-31 16:41:58'),
(50, 50, 'Dollar', 'NZD', '$', '0.02210000', 0, ',', '.', '2', 'CK', 'COK', 184, 'CK.png', 0, '2017-10-31 16:41:58'),
(51, 51, 'Colon', 'CRC', '₡', '8.73770000', 0, ',', '.', '2', 'CR', 'CRI', 188, 'CR.png', 0, '2017-10-31 16:41:58'),
(52, 53, 'Kuna', 'HRK', 'kn', '0.09980000', 0, ',', '.', '2', 'HR', 'HRV', 191, 'HR.png', 0, '2017-10-31 16:41:58'),
(53, 54, 'Peso', 'CUP', '₱', '0.01540000', 0, ',', '.', '2', 'CU', 'CUB', 192, 'CU.png', 0, '2017-10-31 16:41:58'),
(54, 55, 'Pound', 'CYP', '', '0.00800000', 0, ',', '.', '2', 'CY', 'CYP', 196, 'CY.png', 0, '2017-10-31 16:41:58'),
(55, 56, 'Koruna', 'CZK', 'Kč', '0.34050000', 0, ',', '.', '2', 'CZ', 'CZE', 203, 'CZ.png', 0, '2017-10-31 16:41:58'),
(56, 49, 'Franc', 'CDF', 'FC', '24.17480000', 0, ',', '.', '2', 'CD', 'COD', 180, 'CD.png', 0, '2017-10-31 16:41:58'),
(57, 57, 'Krone', 'DKK', 'kr', '0.09870000', 0, ',', '.', '2', 'DK', 'DNK', 208, 'DK.png', 0, '2017-10-31 16:41:58'),
(58, 58, 'Franc', 'DJF', '', '2.73060000', 0, ',', '.', '2', 'DJ', 'DJI', 262, 'DJ.png', 0, '2017-10-31 16:41:58'),
(59, 59, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'DM', 'DMA', 212, 'DM.png', 0, '2017-10-31 16:41:58'),
(60, 60, 'Peso', 'DOP', 'RD$', '0.73970000', 0, ',', '.', '2', 'DO', 'DOM', 214, 'DO.png', 0, '2017-10-31 16:41:58'),
(61, 61, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'TL', 'TLS', 626, 'TL.png', 0, '2017-10-31 16:41:58'),
(62, 62, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'EC', 'ECU', 218, 'EC.png', 0, '2017-10-31 16:41:58'),
(63, 63, 'Pound', 'EGP', '£', '0.27180000', 0, ',', '.', '2', 'EG', 'EGY', 818, 'EG.png', 0, '2017-10-31 16:41:58'),
(64, 64, 'Colone', 'SVC', '$', '0.13510000', 0, ',', '.', '2', 'SV', 'SLV', 222, 'SV.png', 0, '2017-10-31 16:41:58'),
(65, 65, 'Franc', 'XAF', 'FCF', '8.69970000', 0, ',', '.', '2', 'GQ', 'GNQ', 226, 'GQ.png', 0, '2017-10-31 16:41:58'),
(66, 66, 'Nakfa', 'ERN', 'Nfk', '0.23150000', 0, ',', '.', '2', 'ER', 'ERI', 232, 'ER.png', 0, '2017-10-31 16:41:58'),
(67, 67, 'Kroon', 'EEK', 'kr', '0.00000000', 0, ',', '.', '2', 'EE', 'EST', 233, 'EE.png', 0, '2017-10-31 16:41:58'),
(68, 68, 'Birr', 'ETB', '', '0.41690000', 0, ',', '.', '2', 'ET', 'ETH', 231, 'ET.png', 0, '2017-10-31 16:41:58'),
(69, 69, 'Pound', 'FKP', '£', '0.01170000', 0, ',', '.', '2', 'FK', 'FLK', 238, 'FK.png', 0, '2017-10-31 16:41:58'),
(70, 70, 'Krone', 'DKK', 'kr', '0.09870000', 0, ',', '.', '2', 'FO', 'FRO', 234, 'FO.png', 0, '2017-10-31 16:41:58'),
(71, 71, 'Dollar', 'FJD', '$', '0.03210000', 0, ',', '.', '2', 'FJ', 'FJI', 242, 'FJ.png', 0, '2017-10-31 16:41:58'),
(72, 72, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'FI', 'FIN', 246, 'FI.png', 0, '2017-10-31 16:41:58'),
(73, 73, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'FR', 'FRA', 250, 'FR.png', 0, '2017-10-31 16:41:58'),
(74, 75, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'GF', 'GUF', 254, 'GF.png', 0, '2017-10-31 16:41:58'),
(75, 76, 'Franc', 'XPF', '', '1.57850000', 0, ',', '.', '2', 'PF', 'PYF', 258, 'PF.png', 0, '2017-10-31 16:41:58'),
(76, 77, 'Euro  ', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'TF', 'ATF', 260, 'TF.png', 0, '2017-10-31 16:41:58'),
(77, 78, 'Franc', 'XAF', 'FCF', '8.69970000', 0, ',', '.', '2', 'GA', 'GAB', 266, 'GA.png', 0, '2017-10-31 16:41:58'),
(78, 79, 'Dalasi', 'GMD', 'D', '0.72730000', 0, ',', '.', '2', 'GM', 'GMB', 270, 'GM.png', 0, '2017-10-31 16:41:58'),
(79, 80, 'Lari', 'GEL', '', '0.03980000', 0, ',', '.', '2', 'GE', 'GEO', 268, 'GE.png', 0, '2017-10-31 16:41:58'),
(80, 81, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'DE', 'DEU', 276, 'DE.png', 0, '2017-10-31 16:41:58'),
(81, 82, 'Cedi', 'GHC', '¢', '0.00000000', 0, ',', '.', '2', 'GH', 'GHA', 288, 'GH.png', 0, '2017-10-31 16:41:58'),
(82, 83, 'Pound', 'GIP', '£', '0.01170000', 0, ',', '.', '2', 'GI', 'GIB', 292, 'GI.png', 0, '2017-10-31 16:41:58'),
(83, 84, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'GR', 'GRC', 300, 'GR.png', 0, '2017-10-31 16:41:58'),
(84, 85, 'Krone', 'DKK', 'kr', '0.09870000', 0, ',', '.', '2', 'GL', 'GRL', 304, 'GL.png', 0, '2017-10-31 16:41:58'),
(85, 86, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'GD', 'GRD', 308, 'GD.png', 0, '2017-10-31 16:41:58'),
(86, 87, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'GP', 'GLP', 312, 'GP.png', 0, '2017-10-31 16:41:58'),
(87, 88, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'GU', 'GUM', 316, 'GU.png', 0, '2017-10-31 16:41:58'),
(88, 89, 'Quetzal', 'GTQ', 'Q', '0.11340000', 0, ',', '.', '2', 'GT', 'GTM', 320, 'GT.png', 0, '2017-10-31 16:41:58'),
(89, 90, 'Franc', 'GNF', '', '138.94920000', 0, ',', '.', '2', 'GN', 'GIN', 324, 'GN.png', 0, '2017-10-31 16:41:58'),
(90, 91, 'Franc', 'XOF', '', '8.70230000', 0, ',', '.', '2', 'GW', 'GNB', 624, 'GW.png', 0, '2017-10-31 16:41:58'),
(91, 92, 'Dollar', 'GYD', '$', '3.15790000', 0, ',', '.', '2', 'GY', 'GUY', 328, 'GY.png', 0, '2017-10-31 16:41:58'),
(92, 93, 'Gourde', 'HTG', 'G', '0.95480000', 0, ',', '.', '2', 'HT', 'HTI', 332, 'HT.png', 0, '2017-10-31 16:41:58'),
(93, 94, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'HM', 'HMD', 334, 'HM.png', 0, '2017-10-31 16:41:58'),
(94, 95, 'Lempira', 'HNL', 'L', '0.36180000', 0, ',', '.', '2', 'HN', 'HND', 340, 'HN.png', 0, '2017-10-31 16:41:58'),
(95, 96, 'Dollar', 'HKD', '$', '0.12020000', 0, ',', '.', '2', 'HK', 'HKG', 344, 'HK.png', 0, '2017-10-31 16:41:58'),
(96, 97, 'Forint', 'HUF', 'Ft', '4.13030000', 0, ',', '.', '2', 'HU', 'HUN', 348, 'HU.png', 0, '2017-10-31 16:41:58'),
(97, 98, 'Krona', 'ISK', 'kr', '1.61530000', 0, ',', '.', '2', 'IS', 'ISL', 352, 'IS.png', 0, '2017-10-31 16:41:58'),
(98, 99, 'Rupee', 'INR', '₹', '1.00000000', 0, ',', '.', '2', 'IN', 'IND', 356, 'IN.png', 1, '2017-10-31 16:41:58'),
(99, 100, 'Rupiah', 'IDR', 'Rp', '208.90000000', 0, ',', '.', '2', 'ID', 'IDN', 360, 'ID.png', 0, '2017-10-31 16:41:58'),
(100, 101, 'Rial', 'IRR', '﷼', '539.76760000', 0, ',', '.', '2', 'IR', 'IRN', 364, 'IR.png', 0, '2017-10-31 16:41:58'),
(101, 102, 'Dinar', 'IQD', '', '18.00560000', 0, ',', '.', '2', 'IQ', 'IRQ', 368, 'IQ.png', 0, '2017-10-31 16:41:58'),
(102, 103, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'IE', 'IRL', 372, 'IE.png', 0, '2017-10-31 16:41:58'),
(103, 104, 'Shekel', 'ILS', '₪', '0.05440000', 0, ',', '.', '2', 'IL', 'ISR', 376, 'IL.png', 0, '2017-10-31 16:41:58'),
(104, 105, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'IT', 'ITA', 380, 'IT.png', 0, '2017-10-31 16:41:58'),
(105, 52, 'Franc', 'XOF', '', '8.70230000', 0, ',', '.', '2', 'CI', 'CIV', 384, 'CI.png', 0, '2017-10-31 16:41:58'),
(106, 106, 'Dollar', 'JMD', '$', '1.95140000', 0, ',', '.', '2', 'JM', 'JAM', 388, 'JM.png', 0, '2017-10-31 16:41:58'),
(107, 107, 'Yen', 'JPY', '¥', '1.74820000', 0, ',', '.', '2', 'JP', 'JPN', 392, 'JP.png', 0, '2017-10-31 16:41:58'),
(108, 108, 'Dinar', 'JOD', '', '0.01090000', 0, ',', '.', '2', 'JO', 'JOR', 400, 'JO.png', 0, '2017-10-31 16:41:58'),
(109, 109, 'Tenge', 'KZT', 'лв', '5.16880000', 0, ',', '.', '2', 'KZ', 'KAZ', 398, 'KZ.png', 0, '2017-10-31 16:41:58'),
(110, 110, 'Shilling', 'KES', '', '1.59750000', 0, ',', '.', '2', 'KE', 'KEN', 404, 'KE.png', 0, '2017-10-31 16:41:58'),
(111, 111, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'KI', 'KIR', 296, 'KI.png', 0, '2017-10-31 16:41:58'),
(112, 114, 'Dinar', 'KWD', 'د.ك', '0.00470000', 0, ',', '.', '2', 'KW', 'KWT', 414, 'KW.png', 0, '2017-10-31 16:41:58'),
(113, 115, 'Som', 'KGS', 'лв', '1.06120000', 0, ',', '.', '2', 'KG', 'KGZ', 417, 'KG.png', 0, '2017-10-31 16:41:58'),
(114, 116, 'Kip', 'LAK', '₭', '128.17050000', 0, ',', '.', '2', 'LA', 'LAO', 418, 'LA.png', 0, '2017-10-31 16:41:58'),
(115, 117, 'Lat', 'LVL', 'Ls', '0.00960000', 0, ',', '.', '2', 'LV', 'LVA', 428, 'LV.png', 0, '2017-10-31 16:41:58'),
(116, 118, 'Pound', 'LBP', '£', '23.33320000', 0, ',', '.', '2', 'LB', 'LBN', 422, 'LB.png', 0, '2017-10-31 16:41:58'),
(117, 119, 'Loti', 'LSL', 'L', '0.21730000', 0, ',', '.', '2', 'LS', 'LSO', 426, 'LS.png', 0, '2017-10-31 16:41:58'),
(118, 120, 'Dollar', 'LRD', '$', '1.83610000', 0, ',', '.', '2', 'LR', 'LBR', 430, 'LR.png', 0, '2017-10-31 16:41:58'),
(119, 121, 'Dinar', 'LYD', 'ل.د', '0.02100000', 0, ',', '.', '2', 'LY', 'LBY', 434, 'LY.png', 0, '2017-10-31 16:41:58'),
(120, 122, 'Franc', 'CHF', 'CHF', '0.01540000', 0, ',', '.', '2', 'LI', 'LIE', 438, 'LI.png', 0, '2017-10-31 16:41:58'),
(121, 123, 'Litas', 'LTL', 'Lt', '0.04710000', 0, ',', '.', '2', 'LT', 'LTU', 440, 'LT.png', 0, '2017-10-31 16:41:58'),
(122, 124, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'LU', 'LUX', 442, 'LU.png', 0, '2017-10-31 16:41:58'),
(123, 125, 'Pataca', 'MOP', 'MOP', '0.12400000', 0, ',', '.', '2', 'MO', 'MAC', 446, 'MO.png', 0, '2017-10-31 16:41:58'),
(124, 140, 'Denar', 'MKD', 'ден', '0.81260000', 0, ',', '.', '2', 'MK', 'MKD', 807, 'MK.png', 0, '2017-10-31 16:41:58'),
(125, 127, 'Ariary', 'MGA', 'Ar', '48.56580000', 0, ',', '.', '2', 'MG', 'MDG', 450, 'MG.png', 0, '2017-10-31 16:41:58'),
(126, 128, 'Kwacha', 'MWK', 'MK', '11.08750000', 0, ',', '.', '2', 'MW', 'MWI', 454, 'MW.png', 0, '2017-10-31 16:41:58'),
(127, 129, 'Ringgit', 'MYR', 'RM', '0.06490000', 0, ',', '.', '2', 'MY', 'MYS', 458, 'MY.png', 0, '2017-10-31 16:41:58'),
(128, 130, 'Rufiyaa', 'MVR', 'Rf', '0.24040000', 0, ',', '.', '2', 'MV', 'MDV', 462, 'MV.png', 0, '2017-10-31 16:41:58'),
(129, 131, 'Franc', 'XOF', 'MAF', '8.70230000', 0, ',', '.', '2', 'ML', 'MLI', 466, 'ML.png', 0, '2017-10-31 16:41:58'),
(130, 132, 'Lira', 'MTL', 'Lm', '0.00000000', 0, ',', '.', '2', 'MT', 'MLT', 470, 'MT.png', 0, '2017-10-31 16:41:58'),
(131, 133, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'MH', 'MHL', 584, 'MH.png', 0, '2017-10-31 16:41:58'),
(132, 134, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'MQ', 'MTQ', 474, 'MQ.png', 0, '2017-10-31 16:41:58'),
(133, 135, 'Ouguiya', 'MRO', 'UM', '5.42520000', 0, ',', '.', '2', 'MR', 'MRT', 478, 'MR.png', 0, '2017-10-31 16:41:58'),
(134, 136, 'Rupee', 'MUR', '₨', '0.50960000', 0, ',', '.', '2', 'MU', 'MUS', 480, 'MU.png', 0, '2017-10-31 16:41:58'),
(135, 137, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'YT', 'MYT', 175, 'YT.png', 0, '2017-10-31 16:41:58'),
(136, 138, 'Peso', 'MXN', '$', '0.29740000', 0, ',', '.', '2', 'MX', 'MEX', 484, 'MX.png', 0, '2017-10-31 16:41:58'),
(137, 139, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'FM', 'FSM', 583, 'FM.png', 0, '2017-10-31 16:41:58'),
(138, 140, 'Leu', 'MDL', 'MDL', '0.26690000', 0, ',', '.', '2', 'MD', 'MDA', 498, 'MD.png', 0, '2017-10-31 16:41:58'),
(139, 141, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'MC', 'MCO', 492, 'MC.png', 0, '2017-10-31 16:41:58'),
(140, 142, 'Tugrik', 'MNT', '₮', '37.85150000', 0, ',', '.', '2', 'MN', 'MNG', 496, 'MN.png', 0, '2017-10-31 16:41:58'),
(141, 143, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'MS', 'MSR', 500, 'MS.png', 0, '2017-10-31 16:41:58'),
(142, 144, 'Dirham', 'MAD', '', '0.14660000', 0, ',', '.', '2', 'MA', 'MAR', 504, 'MA.png', 0, '2017-10-31 16:41:58'),
(143, 145, 'Meticail', 'MZN', 'MT', '0.92810000', 0, ',', '.', '2', 'MZ', 'MOZ', 508, 'MZ.png', 0, '2017-10-31 16:41:58'),
(144, 146, 'Kyat', 'MMK', 'K', '21.04780000', 0, ',', '.', '2', 'MM', 'MMR', 104, 'MM.png', 0, '2017-10-31 16:41:58'),
(145, 147, 'Dollar', 'NAD', '$', '0.21800000', 0, ',', '.', '2', 'NA', 'NAM', 516, 'NA.png', 0, '2017-10-31 16:41:58'),
(146, 148, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'NR', 'NRU', 520, 'NR.png', 0, '2017-10-31 16:41:58'),
(147, 149, 'Rupee', 'NPR', '₨', '1.59900000', 0, ',', '.', '2', 'NP', 'NPL', 524, 'NP.png', 0, '2017-10-31 16:41:58'),
(148, 150, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'NL', 'NLD', 528, 'NL.png', 0, '2017-10-31 16:41:58'),
(149, 151, 'Guilder', 'ANG', 'ƒ', '0.02750000', 0, ',', '.', '2', 'AN', 'ANT', 530, 'AN.png', 0, '2017-10-31 16:41:58'),
(150, 152, 'Franc', 'XPF', '', '1.57850000', 0, ',', '.', '2', 'NC', 'NCL', 540, 'NC.png', 0, '2017-10-31 16:41:58'),
(151, 153, 'Dollar', 'NZD', '$', '0.02210000', 0, ',', '.', '2', 'NZ', 'NZL', 554, 'NZ.png', 0, '2017-10-31 16:41:58'),
(152, 154, 'Cordoba', 'NIO', 'C$', '0.47160000', 0, ',', '.', '2', 'NI', 'NIC', 558, 'NI.png', 0, '2017-10-31 16:41:58'),
(153, 155, 'Franc', 'XOF', '', '8.70230000', 0, ',', '.', '2', 'NE', 'NER', 562, 'NE.png', 0, '2017-10-31 16:41:58'),
(154, 156, 'Naira', 'NGN', '₦', '5.51290000', 0, ',', '.', '2', 'NG', 'NGA', 566, 'NG.png', 0, '2017-10-31 16:41:58'),
(155, 157, 'Dollar', 'NZD', '$', '0.02210000', 0, ',', '.', '2', 'NU', 'NIU', 570, 'NU.png', 0, '2017-10-31 16:41:58'),
(156, 158, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'NF', 'NFK', 574, 'NF.png', 0, '2017-10-31 16:41:58'),
(157, 112, 'Won', 'KPW', '₩', '13.89800000', 0, ',', '.', '2', 'KP', 'PRK', 408, 'KP.png', 0, '2017-10-31 16:41:58'),
(158, 159, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'MP', 'MNP', 580, 'MP.png', 0, '2017-10-31 16:41:58'),
(159, 160, 'Krone', 'NOK', 'kr', '0.12630000', 0, ',', '.', '2', 'NO', 'NOR', 578, 'NO.png', 0, '2017-10-31 16:41:58'),
(160, 161, 'Rial', 'OMR', '﷼', '0.00590000', 0, ',', '.', '2', 'OM', 'OMN', 512, 'OM.png', 0, '2017-10-31 16:41:58'),
(161, 162, 'Rupee', 'PKR', '₨', '1.62540000', 0, ',', '.', '2', 'PK', 'PAK', 586, 'PK.png', 0, '2017-10-31 16:41:58'),
(162, 163, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'PW', 'PLW', 585, 'PW.png', 0, '2017-10-31 16:41:58'),
(163, 0, 'Shekel', 'ILS', '₪', '0.05440000', 0, ',', '.', '2', 'PS', 'PSE', 275, 'PS.png', 0, '2017-10-31 16:41:58'),
(164, 164, 'Balboa', 'PAB', 'B/.', '0.01540000', 0, ',', '.', '2', 'PA', 'PAN', 591, 'PA.png', 0, '2017-10-31 16:41:58'),
(165, 165, 'Kina', 'PGK', '', '0.04950000', 0, ',', '.', '2', 'PG', 'PNG', 598, 'PG.png', 0, '2017-10-31 16:41:58'),
(166, 166, 'Guarani', 'PYG', 'Gs', '86.98610000', 0, ',', '.', '2', 'PY', 'PRY', 600, 'PY.png', 0, '2017-10-31 16:41:58'),
(167, 167, 'Sol', 'PEN', 'S/.', '0.05010000', 0, ',', '.', '2', 'PE', 'PER', 604, 'PE.png', 0, '2017-10-31 16:41:58'),
(168, 168, 'Peso', 'PHP', 'Php', '0.79690000', 0, ',', '.', '2', 'PH', 'PHL', 608, 'PH.png', 0, '2017-10-31 16:41:58'),
(169, 169, 'Dollar', 'NZD', '$', '0.02210000', 0, ',', '.', '2', 'PN', 'PCN', 612, 'PN.png', 0, '2017-10-31 16:41:58'),
(170, 170, 'Zloty', 'PLN', 'zł', '0.05640000', 0, ',', '.', '2', 'PL', 'POL', 616, 'PL.png', 0, '2017-10-31 16:41:58'),
(171, 171, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'PT', 'PRT', 620, 'PT.png', 0, '2017-10-31 16:41:58'),
(172, 172, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'PR', 'PRI', 630, 'PR.png', 0, '2017-10-31 16:41:58'),
(173, 173, 'Rial', 'QAR', '﷼', '0.05620000', 0, ',', '.', '2', 'QA', 'QAT', 634, 'QA.png', 0, '2017-10-31 16:41:58'),
(174, 49, 'Franc', 'XAF', 'FCF', '8.69970000', 0, ',', '.', '2', 'CG', 'COG', 178, 'CG.png', 0, '2017-10-31 16:41:58'),
(175, 174, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'RE', 'REU', 638, 'RE.png', 0, '2017-10-31 16:41:58'),
(176, 175, 'Leu', 'RON', 'lei', '0.06100000', 0, ',', '.', '2', 'RO', 'ROU', 642, 'RO.png', 0, '2017-10-31 16:41:58'),
(177, 176, 'Ruble', 'RUB', 'руб', '0.90260000', 0, ',', '.', '2', 'RU', 'RUS', 643, 'RU.png', 0, '2017-10-31 16:41:58'),
(178, 177, 'Franc', 'RWF', '', '12.83670000', 0, ',', '.', '2', 'RW', 'RWA', 646, 'RW.png', 0, '2017-10-31 16:41:58'),
(179, 179, 'Pound', 'SHP', '£', '0.01170000', 0, ',', '.', '2', 'SH', 'SHN', 654, 'SH.png', 0, '2017-10-31 16:41:58'),
(180, 178, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'KN', 'KNA', 659, 'KN.png', 0, '2017-10-31 16:41:58'),
(181, 179, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'LC', 'LCA', 662, 'LC.png', 0, '2017-10-31 16:41:58'),
(182, 180, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'PM', 'SPM', 666, 'PM.png', 0, '2017-10-31 16:41:58'),
(183, 180, 'Dollar', 'XCD', '$', '0.04170000', 0, ',', '.', '2', 'VC', 'VCT', 670, 'VC.png', 0, '2017-10-31 16:41:58'),
(184, 181, 'Tala', 'WST', 'WS$', '0.03960000', 0, ',', '.', '2', 'WS', 'WSM', 882, 'WS.png', 0, '2017-10-31 16:41:58'),
(185, 182, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'SM', 'SMR', 674, 'SM.png', 0, '2017-10-31 16:41:58'),
(186, 183, 'Dobra', 'STD', 'Db', '325.16850000', 0, ',', '.', '2', 'ST', 'STP', 678, 'ST.png', 0, '2017-10-31 16:41:58'),
(187, 184, 'Rial', 'SAR', '﷼', '0.05790000', 0, ',', '.', '2', 'SA', 'SAU', 682, 'SA.png', 0, '2017-10-31 16:41:58'),
(188, 185, 'Franc', 'XOF', '', '8.70230000', 0, ',', '.', '2', 'SN', 'SEN', 686, 'SN.png', 0, '2017-10-31 16:41:58'),
(189, 142, 'Dinar', 'RSD', 'Дин', '1.57830000', 0, ',', '.', '2', 'CS', 'SCG', 891, 'CS.png', 0, '2017-10-31 16:41:58'),
(190, 186, 'Rupee', 'SCR', '₨', '0.20600000', 0, ',', '.', '2', 'SC', 'SYC', 690, 'SC.png', 0, '2017-10-31 16:41:58'),
(191, 187, 'Leone', 'SLL', 'Le', '117.66980000', 0, ',', '.', '2', 'SL', 'SLE', 694, 'SL.png', 0, '2017-10-31 16:41:58'),
(192, 188, 'Dollar', 'SGD', '$', '0.02100000', 0, ',', '.', '2', 'SG', 'SGP', 702, 'SG.png', 0, '2017-10-31 16:41:58'),
(193, 189, 'Koruna', 'SKK', 'Sk', '0.00000000', 0, ',', '.', '2', 'SK', 'SVK', 703, 'SK.png', 0, '2017-10-31 16:41:58'),
(194, 190, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'SI', 'SVN', 705, 'SI.png', 0, '2017-10-31 16:41:58'),
(195, 191, 'Dollar', 'SBD', '$', '0.12060000', 0, ',', '.', '2', 'SB', 'SLB', 90, 'SB.png', 0, '2017-10-31 16:41:58'),
(196, 192, 'Shilling', 'SOS', 'S', '8.63220000', 0, ',', '.', '2', 'SO', 'SOM', 706, 'SO.png', 0, '2017-10-31 16:41:58'),
(197, 193, 'Rand', 'ZAR', 'R', '0.21810000', 0, ',', '.', '2', 'ZA', 'ZAF', 710, 'ZA.png', 0, '2017-10-31 16:41:58'),
(198, 113, 'Pound', 'GBP', '£', '0.01170000', 0, ',', '.', '2', 'GS', 'SGS', 239, 'GS.png', 0, '2017-10-31 16:41:58'),
(199, 194, 'Won', 'KRW', '₩', '17.26500000', 0, ',', '.', '2', 'KR', 'KOR', 410, 'KR.png', 0, '2017-10-31 16:41:58'),
(200, 195, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'ES', 'ESP', 724, 'ES.png', 0, '2017-10-31 16:41:58'),
(201, 196, 'Rupee', 'LKR', '₨', '2.37120000', 0, ',', '.', '2', 'LK', 'LKA', 144, 'LK.png', 0, '2017-10-31 16:41:58'),
(202, 199, 'Dinar', 'SDD', '', '0.00000000', 0, ',', '.', '2', 'SD', 'SDN', 736, 'SD.png', 0, '2017-10-31 16:41:58'),
(203, 200, 'Dollar', 'SRD', '$', '0.11440000', 0, ',', '.', '2', 'SR', 'SUR', 740, 'SR.png', 0, '2017-10-31 16:41:58'),
(204, 0, 'Krone', 'NOK', 'kr', '0.12630000', 0, ',', '.', '2', 'SJ', 'SJM', 744, 'SJ.png', 0, '2017-10-31 16:41:58'),
(205, 202, 'Lilangeni', 'SZL', '', '0.21810000', 0, ',', '.', '2', 'SZ', 'SWZ', 748, 'SZ.png', 0, '2017-10-31 16:41:58'),
(206, 203, 'Krona', 'SEK', 'kr', '0.12930000', 0, ',', '.', '2', 'SE', 'SWE', 752, 'SE.png', 0, '2017-10-31 16:41:58'),
(207, 204, 'Franc', 'CHF', 'CHF', '0.01540000', 0, ',', '.', '2', 'CH', 'CHE', 756, 'CH.png', 0, '2017-10-31 16:41:58'),
(208, 205, 'Pound', 'SYP', '£', '7.95240000', 0, ',', '.', '2', 'SY', 'SYR', 760, 'SY.png', 0, '2017-10-31 16:41:58'),
(209, 206, 'Dollar', 'TWD', 'NT$', '0.46590000', 0, ',', '.', '2', 'TW', 'TWN', 158, 'TW.png', 0, '2017-10-31 16:41:58'),
(210, 207, 'Somoni', 'TJS', '', '0.13590000', 0, ',', '.', '2', 'TJ', 'TJK', 762, 'TJ.png', 0, '2017-10-31 16:41:58'),
(211, 208, 'Shilling', 'TZS', '', '34.55970000', 0, ',', '.', '2', 'TZ', 'TZA', 834, 'TZ.png', 0, '2017-10-31 16:41:58'),
(212, 209, 'Baht', 'THB', '฿', '0.51250000', 0, ',', '.', '2', 'TH', 'THA', 764, 'TH.png', 0, '2017-10-31 16:41:58'),
(213, 210, 'Franc', 'XOF', '', '8.70230000', 0, ',', '.', '2', 'TG', 'TGO', 768, 'TG.png', 0, '2017-10-31 16:41:58'),
(214, 211, 'Dollar', 'NZD', '$', '0.02210000', 0, ',', '.', '2', 'TK', 'TKL', 772, 'TK.png', 0, '2017-10-31 16:41:58'),
(215, 212, 'Pa''anga', 'TOP', 'T$', '0.03550000', 0, ',', '.', '2', 'TO', 'TON', 776, 'TO.png', 0, '2017-10-31 16:41:58'),
(216, 213, 'Dollar', 'TTD', 'TT$', '0.10410000', 0, ',', '.', '2', 'TT', 'TTO', 780, 'TT.png', 0, '2017-10-31 16:41:58'),
(217, 214, 'Dinar', 'TND', '', '0.03880000', 0, ',', '.', '2', 'TN', 'TUN', 788, 'TN.png', 0, '2017-10-31 16:41:58'),
(218, 215, 'Lira', 'TRY', 'YTL', '0.05860000', 0, ',', '.', '2', 'TR', 'TUR', 792, 'TR.png', 0, '2017-10-31 16:41:58'),
(219, 216, 'Manat', 'TMM', 'm', '0.00000000', 0, ',', '.', '2', 'TM', 'TKM', 795, 'TM.png', 0, '2017-10-31 16:41:58'),
(220, 217, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'TC', 'TCA', 796, 'TC.png', 0, '2017-10-31 16:41:58'),
(221, 218, 'Dollar', 'AUD', '$', '0.02010000', 0, ',', '.', '2', 'TV', 'TUV', 798, 'TV.png', 0, '2017-10-31 16:41:58'),
(222, 232, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'VI', 'VIR', 850, 'VI.png', 0, '2017-10-31 16:41:58'),
(223, 219, 'Shilling', 'UGX', '', '56.27150000', 0, ',', '.', '2', 'UG', 'UGA', 800, 'UG.png', 0, '2017-10-31 16:41:58'),
(224, 220, 'Hryvnia', 'UAH', '₴', '0.41450000', 0, ',', '.', '2', 'UA', 'UKR', 804, 'UA.png', 0, '2017-10-31 16:41:58'),
(225, 221, 'Dirham', 'AED', '', '0.05670000', 0, ',', '.', '2', 'AE', 'ARE', 784, 'AE.png', 0, '2017-10-31 16:41:58'),
(226, 222, 'Pound', 'GBP', '£', '0.01170000', 0, ',', '.', '2', 'GB', 'GBR', 826, 'GB.png', 0, '2017-10-31 16:41:58'),
(227, 223, 'Dollar', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'US', 'USA', 840, 'US.png', 0, '2017-10-31 16:41:58'),
(228, 224, 'Dollar ', 'USD', '$', '0.01540000', 0, ',', '.', '2', 'UM', 'UMI', 581, 'UM.png', 0, '2017-10-31 16:41:58'),
(229, 225, 'Peso', 'UYU', '$U', '0.45370000', 0, ',', '.', '2', 'UY', 'URY', 858, 'UY.png', 0, '2017-10-31 16:41:58'),
(230, 226, 'Som', 'UZS', 'лв', '124.54160000', 0, ',', '.', '2', 'UZ', 'UZB', 860, 'UZ.png', 0, '2017-10-31 16:41:58'),
(231, 227, 'Vatu', 'VUV', 'Vt', '1.66220000', 0, ',', '.', '2', 'VU', 'VUT', 548, 'VU.png', 0, '2017-10-31 16:41:58'),
(232, 228, 'Euro', 'EUR', '€', '0.01330000', 0, ',', '.', '2', 'VA', 'VAT', 336, 'VA.png', 0, '2017-10-31 16:41:58'),
(233, 229, 'Bolivar', 'VEF', 'Bs', '0.15400000', 0, ',', '.', '2', 'VE', 'VEN', 862, 'VE.png', 0, '2017-10-31 16:41:58'),
(234, 230, 'Dong', 'VND', '₫', '350.70840000', 0, ',', '.', '2', 'VN', 'VNM', 704, 'VN.png', 0, '2017-10-31 16:41:58'),
(235, 233, 'Franc', 'XPF', '', '1.57850000', 0, ',', '.', '2', 'WF', 'WLF', 876, 'WF.png', 0, '2017-10-31 16:41:58'),
(236, 234, 'Dirham', 'MAD', '', '0.14660000', 0, ',', '.', '2', 'EH', 'ESH', 732, 'EH.png', 0, '2017-10-31 16:41:58'),
(237, 235, 'Rial', 'YER', '﷼', '3.85980000', 0, ',', '.', '2', 'YE', 'YEM', 887, 'YE.png', 0, '2017-10-31 16:41:58'),
(238, 238, 'Kwacha', 'ZMK', 'ZK', '0.00000000', 0, ',', '.', '2', 'ZM', 'ZMB', 894, 'ZM.png', 0, '2017-10-31 16:41:58'),
(239, 239, 'Dollar', 'ZWD', 'Z$', '0.00000000', 0, ',', '.', '2', 'ZW', 'ZWE', 716, 'ZW.png', 0, '2017-10-31 16:41:58');

-- --------------------------------------------------------

--
-- Table structure for table `ti_customers`
--

CREATE TABLE IF NOT EXISTS `ti_customers` (
  `customer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `address_id` int(11) NOT NULL,
  `security_question_id` int(11) NOT NULL,
  `security_answer` varchar(32) NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cart` text NOT NULL,
  PRIMARY KEY (`customer_id`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `ti_customers`
--

INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`, `cart`) VALUES
(28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', 'ab311bf8e96c00d9d4f55964711a772baf53f925', '1db625005', '8802986147', 22, 12, 'Harshul', 0, 0, '', '2017-12-01 02:16:39', 1, ''),
(29, 'tatta', 'tatta', 'a@gmail.com', '4d3eef6143c38431906b83a4c542339610074d51', '20bbf803e', '101', 29, 12, 'tatta', 0, 0, '', '2017-12-01 10:56:36', 1, ''),
(25, 'Arpit', 'Saxena', 'a@com', '34b7439a15d997b80f1917fa30c8742d6d31c8cb', 'bc92c9f88', '9', 25, 12, 'harshul', 0, 0, '', '2017-11-30 23:42:50', 1, ''),
(30, 'Nitesh', 'Mittal', 'niteshmittal68@gmail.com', '76653cb4f67a2268fe1ae73f0e5c34a99a341013', 'f62c28954', '9896095084', 23, 12, 'Ron', 0, 0, '', '2017-12-01 10:59:18', 1, ''),
(26, 'Rishabh', 'Gulati', 'risgulati@gmail.com', '47af745592ef6ab26d3e775b680ef9c33a4af3b4', '6ca14daf4', '9650841557', 20, 12, 'Dehradun', 0, 0, '', '2017-11-30 23:48:27', 1, ''),
(24, 'Q', 'W', 'n@g.com', '6da82810a04e78d5a447a4ca6af3c9a25b8ada5a', '8b075995e', '1', 19, 12, 'Harshul', 0, 0, '', '2017-11-30 23:42:28', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ti_customers_image`
--

CREATE TABLE IF NOT EXISTS `ti_customers_image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid_image` varchar(60) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `image_string` varchar(21000) DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `ti_customers_image`
--

INSERT INTO `ti_customers_image` (`image_id`, `uuid_image`, `customer_id`, `image_string`) VALUES
(23, '9d9bd6bc-47fd-45e6-bebb-17111b44c6d2', 30, '../images/customers/30.png'),
(22, 'a17be35b-f52a-4b88-b1f5-28fc557cbac2', 28, '../images/customers/28.png'),
(19, '6752a587-375f-4b58-b5ad-605396a2870c', 24, '../images/customers/24.png'),
(20, 'c9742ee8-dee8-4c87-8d1b-d420ebadf621', 26, '../images/customers/26.png');

-- --------------------------------------------------------

--
-- Table structure for table `ti_customers_online`
--

CREATE TABLE IF NOT EXISTS `ti_customers_online` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `access_type` varchar(128) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `request_uri` text NOT NULL,
  `referrer_uri` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_agent` text NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=170 ;

--
-- Dumping data for table `ti_customers_online`
--

INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES
(11, 0, 'browser', 'Chrome', '217.112.94.235', 'GB', '', 'admin/updates', '2017-08-11 10:06:53', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(12, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-08-11 10:16:48', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(13, 0, '', '', '173.252.123.131', 'US', '', '', '2017-08-11 10:20:33', 0, 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'),
(14, 0, 'mobile', 'Apple iPhone', '122.161.61.163', 'IN', '', 'http://m.facebook.com', '2017-08-11 10:22:54', 0, 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_2 like Mac OS X) AppleWebKit/603.2.4 (KHTML, like Gecko) Mobile/14F89 [FBAN/MessengerForiOS;FBAV/129.0.0.44.91;FBBV/66845013;FBDV/iPhone9,1;FBMD/iPhone;FBSN/iOS;FBSV/10.3.2;FBSS/2;FBCR/Carrier;FBID/phone;FBLC/en_US;FBOP/5;FBRV/0]'),
(15, 0, 'mobile', 'Android', '42.111.87.98', 'IN', '', 'http://m.facebook.com/', '2017-08-11 12:17:43', 0, 'Mozilla/5.0 (Linux; Android 6.0.1; Redmi Note 4 Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/59.0.3071.125 Mobile Safari/537.36 [FB_IAB/MESSENGER;FBAV/127.0.0.18.81;]'),
(16, 0, 'mobile', 'Android', '14.139.238.98', 'IN', '', 'http://m.facebook.com/', '2017-08-11 12:21:45', 0, 'Mozilla/5.0 (Linux; Android 6.0.1; Redmi Note 4 Build/MMB29M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/59.0.3071.125 Mobile Safari/537.36 [FB_IAB/MESSENGER;FBAV/127.0.0.18.81;]'),
(17, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-08-12 06:39:00', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(18, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-08-12 06:50:06', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(19, 0, 'browser', 'Chrome', '125.19.237.34', 'IN', '', '', '2017-08-12 06:50:20', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(20, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-08-12 07:02:23', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(21, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-08-13 11:38:19', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(22, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-08-13 11:40:44', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(23, 0, 'browser', 'Chrome', '103.72.6.141', '0', '', '', '2017-08-14 12:05:29', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(24, 0, 'browser', 'Chrome', '103.72.6.141', '0', '', '', '2017-08-14 12:48:24', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(25, 0, 'browser', 'Chrome', '103.72.6.141', '0', '', '', '2017-08-14 12:59:49', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(26, 0, 'browser', 'Chrome', '103.72.6.141', '0', '', '', '2017-08-14 13:10:02', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(27, 0, 'browser', 'Chrome', '103.72.6.141', '0', '', '', '2017-08-14 13:13:28', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36'),
(28, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-08-14 16:35:22', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(29, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-08-15 17:05:53', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(30, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-08-16 20:42:07', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(31, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-08-17 21:41:48', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(32, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-08-19 11:03:11', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(33, 0, 'browser', 'Chrome', '103.72.6.141', '0', '', '', '2017-08-20 08:52:11', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36'),
(34, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-08-21 06:47:25', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(35, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-08-21 06:48:35', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36'),
(36, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-08-22 08:05:21', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(37, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-08-23 14:16:20', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(38, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-08-24 17:22:14', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(39, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-08-25 06:28:12', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36'),
(40, 0, 'browser', 'Chrome', '66.102.6.194', 'US', '', '', '2017-08-25 17:28:35', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(41, 0, 'browser', 'Chrome', '42.111.74.155', 'IN', '', '', '2017-08-26 22:02:12', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'),
(42, 0, 'browser', 'Chrome', '66.102.6.142', 'US', '', '', '2017-08-27 09:15:51', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(43, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-08-28 09:53:04', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(44, 0, 'browser', 'Chrome', '66.249.93.5', 'FR', '', '', '2017-08-28 15:06:52', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(45, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-08-29 21:54:43', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(46, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-08-31 05:01:19', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(47, 0, 'mobile', 'Android', '47.30.206.238', 'CA', '', 'http://m.facebook.com/', '2017-09-01 07:31:55', 0, 'Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4 Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/60.0.3112.107 Mobile Safari/537.36 [FB_IAB/MESSENGER;FBAV/133.0.0.14.91;]'),
(48, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-09-01 07:33:35', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'),
(49, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-09-01 18:46:20', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(50, 0, 'browser', 'Chrome', '66.249.93.5', 'FR', '', '', '2017-09-02 19:36:22', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(51, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-09-03 21:03:15', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(52, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-09-05 06:33:31', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(53, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-09-06 09:16:24', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(54, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-09-10 17:03:54', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(55, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-09-10 17:03:54', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(56, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-09-21 07:35:23', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'),
(57, 0, 'mobile', 'Android', '47.30.122.92', 'CA', '', '', '2017-09-21 09:53:25', 0, 'Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.116 Mobile Safari/537.36'),
(58, 0, 'mobile', 'Android', '47.30.122.92', 'CA', '', '', '2017-09-21 09:56:16', 0, 'Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.116 Mobile Safari/537.36'),
(59, 0, 'mobile', 'Android', '64.233.173.139', 'US', '', '', '2017-09-24 15:33:59', 0, 'Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.116 Mobile Safari/537.36'),
(60, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-09-28 07:12:52', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(61, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-09-28 07:26:09', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(62, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-09-28 07:34:19', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(63, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-09-28 20:10:59', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(64, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-09-28 20:18:35', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(65, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-09-28 20:46:30', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(66, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', 'login', '', '2017-09-28 20:49:17', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(67, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-09-28 22:43:20', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(68, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', 'login', 'index.php/login', '2017-09-28 22:45:51', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(69, 0, 'mobile', 'Android', '103.243.55.149', 'IN', '', '', '2017-09-30 07:50:06', 0, 'Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36'),
(70, 0, 'browser', 'Chrome', '47.9.129.39', 'CA', '', '', '2017-09-30 19:10:24', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(71, 0, 'browser', 'Chrome', '47.9.129.39', 'CA', '', '', '2017-09-30 19:13:51', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(72, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-09-30 19:43:28', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(73, 0, 'mobile', 'Android', '64.233.173.138', 'US', '', '', '2017-09-30 20:17:11', 0, 'Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.98 Mobile Safari/537.36'),
(74, 0, 'browser', 'Chrome', '47.9.130.201', 'CA', 'login', '', '2017-09-30 20:25:53', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(75, 0, 'browser', 'Chrome', '47.9.130.201', 'CA', '', '', '2017-09-30 20:57:56', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(76, 0, 'browser', 'Chrome', '47.9.130.201', 'CA', '', '', '2017-09-30 21:02:00', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(77, 0, 'browser', 'Chrome', '66.102.6.116', 'US', '', '', '2017-10-02 16:57:12', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(78, 0, 'browser', 'Chrome', '47.30.142.253', 'CA', '', '', '2017-10-03 10:55:18', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(79, 0, 'mobile', 'Android', '47.30.142.253', 'CA', '', '', '2017-10-03 12:25:02', 0, 'Mozilla/5.0 (Linux; U; Android 7.0; en-us; Redmi Note 4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.146 Mobile Safari/537.36 XiaoMi/MiuiBrowser/9.1.3'),
(80, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-10-03 19:43:42', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(81, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-10-05 05:39:14', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(82, 0, 'browser', 'Chrome', '66.102.6.116', 'US', '', '', '2017-10-06 06:35:19', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(83, 0, 'browser', 'Chrome', '66.102.6.16', 'US', '', '', '2017-10-07 15:05:07', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(84, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-10-07 17:55:37', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(85, 0, '', '', '54.89.92.4', 'US', '', '', '2017-10-07 17:58:00', 0, 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)'),
(86, 0, '', '', '52.91.184.228', 'US', 'login', '', '2017-10-07 17:58:01', 0, 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)'),
(87, 0, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-10-07 18:20:08', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(88, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-10-07 18:21:08', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(89, 0, 'browser', 'Chrome', '66.102.6.20', 'US', '', '', '2017-10-08 15:44:05', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(90, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-10-08 18:48:43', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(91, 8, 'browser', 'Chrome', '78.129.190.192', 'GB', 'account/details', 'account', '2017-10-08 18:56:43', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(92, 8, 'browser', 'Chrome', '78.129.190.192', 'GB', 'account/address/edit', 'account/address', '2017-10-08 18:58:44', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(93, 8, 'browser', 'Chrome', '78.129.190.192', 'GB', 'local_module/local_module/search', 'local/lewisham', '2017-10-08 19:00:56', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(94, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-10-08 19:03:25', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(95, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', 'login', 'login', '2017-10-08 19:38:26', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(96, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', 'login', '', '2017-10-08 20:11:10', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(97, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', 'login', 'login', '2017-10-08 20:29:49', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(98, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', 'login', 'login', '2017-10-08 20:39:49', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(99, 10, 'browser', 'Chrome', '14.139.238.98', 'IN', '', 'admin/updates?check=force', '2017-10-08 20:44:24', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(100, 10, 'browser', 'Chrome', '78.129.190.192', 'GB', 'login', '', '2017-10-08 21:16:41', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(101, 10, 'browser', 'Chrome', '78.129.190.192', 'GB', '', 'reservation?action=find_table&location=11&guest_num=2&reserve_date=09-10-2017&reserve_time=09%3A45', '2017-10-08 21:20:10', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'),
(102, 0, 'browser', 'Chrome', '78.129.190.192', 'GB', '', '', '2017-10-31 16:40:50', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.75 Safari/537.36'),
(103, 0, 'browser', 'Chrome', '66.249.93.5', 'FR', '', '', '2017-11-01 03:41:47', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(104, 0, 'browser', 'Chrome', '64.233.172.178', 'US', '', '', '2017-11-02 11:54:38', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(105, 0, 'browser', 'Chrome', '66.249.93.5', 'FR', '', '', '2017-11-03 16:52:51', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(106, 0, 'browser', 'Chrome', '66.249.93.9', 'FR', '', '', '2017-11-04 18:45:26', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(107, 0, 'browser', 'Chrome', '66.102.6.46', 'US', '', 'http://www.google.com/search', '2017-11-16 23:07:20', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko; Google Web Preview) Chrome/41.0.2272.118 Safari/537.36'),
(108, 0, 'browser', 'Chrome', '139.59.3.153', 'AU', '', '', '2017-11-16 23:45:40', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(109, 0, 'browser', 'Firefox', '128.199.124.86', 'SG', 'login', 'login', '2017-11-16 23:47:06', 0, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'),
(110, 15, 'browser', 'Chrome', '139.59.3.153', 'AU', 'reservation?action=find_table&location=11&guest_num=2&reserve_date=17-11-2017&reserve_time=16%3A17', 'reservation?action=find_table&location=11&guest_num=2&reserve_date=17-11-2017&reserve_time=00%3A32', '2017-11-16 23:47:50', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(111, 0, 'browser', 'Firefox', '128.199.124.86', 'SG', 'account/orders', 'reservation/success', '2017-11-16 23:49:31', 0, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'),
(112, 0, 'browser', 'Firefox', '139.59.42.246', 'AU', '^localmenus|reservation|contact|local|cart|checkout|pages)?/lewisham)$', 'account/orders', '2017-11-16 23:49:34', 0, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'),
(113, 15, 'browser', 'Chrome', '139.59.3.153', 'AU', 'local_module/local_module/search', 'local/lewisham', '2017-11-16 23:49:53', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(114, 0, 'browser', 'Chrome', '66.102.6.46', 'US', '', '', '2017-11-17 11:24:05', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(115, 15, 'browser', 'Chrome', '14.139.238.98', 'IN', '', '', '2017-11-17 22:07:25', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(116, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-11-18 11:03:37', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(117, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-11-19 19:41:02', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(118, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-11-21 10:42:37', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(119, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', '', '', '2017-11-21 19:29:13', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(120, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', 'local_module/local_module/search', 'local/lewisham', '2017-11-21 19:32:49', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(121, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', 'cart_module/cart_module/add', 'local/lewisham', '2017-11-21 19:34:50', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(122, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', 'cart_module/cart_module/add', 'local/lewisham', '2017-11-21 19:37:01', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(123, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', '^localmenus|reservation|contact|local|cart|checkout|pages)?/lewisham)$', 'account/orders', '2017-11-21 19:39:09', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(124, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', '^localmenus|reservation|contact|local|cart|checkout|pages)?/lewisham)$', 'local/lewisham', '2017-11-21 19:43:57', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(125, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', 'cart_module/cart_module/add', 'local/lewisham', '2017-11-21 19:46:13', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(126, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', '^localmenus|reservation|contact|local|cart|checkout|pages)?/lewisham)$', '', '2017-11-21 19:51:26', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(127, 15, 'browser', 'Chrome', '49.39.5.157', 'IN', 'account/orders', 'local/lewisham', '2017-11-21 19:59:28', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(128, 15, 'browser', 'Chrome', '14.139.238.98', 'IN', 'cart_module/cart_module/add', 'local/annapurna', '2017-11-22 04:12:42', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36'),
(129, 0, 'browser', 'Chrome', '64.233.172.159', 'US', '', '', '2017-11-22 11:40:48', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(130, 0, 'browser', 'Chrome', '66.102.6.112', 'US', '', '', '2017-11-23 15:44:00', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(131, 0, 'browser', 'Firefox', '103.72.6.248', '0', '', '', '2017-11-24 22:55:38', 0, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0'),
(132, 0, 'browser', 'Firefox', '103.72.6.248', '0', 'login', 'login', '2017-11-24 22:57:56', 0, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0'),
(133, 0, 'browser', 'Firefox', '139.59.42.246', 'AU', 'account/orders', 'account', '2017-11-24 22:58:31', 0, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'),
(134, 0, 'browser', 'Firefox', '128.199.124.86', 'SG', 'locations', 'account/orders', '2017-11-24 22:58:34', 0, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0'),
(135, 15, 'browser', 'Firefox', '103.72.6.248', '0', 'local_module/local_module/search', 'local/annapurna', '2017-11-24 23:02:33', 0, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0'),
(136, 0, 'browser', 'Chrome', '66.102.6.114', 'US', '', '', '2017-11-26 19:11:30', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36 Google Favicon'),
(137, 0, 'browser', 'Firefox', '106.205.126.220', 'IN', 'assets/bills/92508.pdf', '', '2017-11-26 20:27:55', 0, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0'),
(138, 0, 'mobile', 'Android', '103.72.6.248', '0', 'assets/imagesdata/categories/north_indian.png', '', '2017-11-27 20:29:04', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(139, 0, 'mobile', 'Android', '103.72.6.248', '0', 'assets/imagesdata/categories/chinese.png', '', '2017-11-27 20:29:04', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(140, 0, 'mobile', 'Android', '103.72.6.248', '0', 'assets/imagesdata/categories/snacks.png', '', '2017-11-27 20:29:04', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(141, 0, 'mobile', 'Android', '103.72.6.248', '0', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-27 20:36:12', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(142, 0, 'mobile', 'Android', '106.202.251.131', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-28 02:16:57', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(143, 0, 'mobile', 'Android', '106.202.251.131', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-28 02:19:54', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(144, 0, 'mobile', 'Android', '106.202.251.131', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-28 03:05:34', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(145, 0, 'mobile', 'Android', '106.205.20.185', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-28 14:23:50', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(146, 0, 'mobile', 'Android', '106.198.180.106', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-29 13:34:36', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(147, 0, 'mobile', 'Android', '27.60.21.37', 'IN', 'assets/images/data/items/fried_rice.png', '', '2017-11-29 14:43:11', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(148, 0, 'mobile', 'Android', '106.202.54.107', 'IN', 'assets/images/data/items/fried_rice.png', '', '2017-11-29 16:42:55', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.3.0.NCFMIEI)'),
(149, 0, 'mobile', 'Android', '106.222.84.96', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-29 16:43:16', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(150, 0, 'mobile', 'Android', '106.222.84.96', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-29 17:39:35', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(151, 0, 'mobile', 'Android', '106.222.84.96', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-29 17:44:14', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(152, 0, 'mobile', 'Android', '106.222.114.168', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-30 11:33:33', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(153, 0, 'mobile', 'Android', '106.222.191.75', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-30 16:40:29', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(154, 0, 'mobile', 'Android', '106.205.172.46', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-30 18:49:19', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(155, 0, 'mobile', 'Android', '106.205.172.46', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-30 19:43:35', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(156, 0, 'mobile', 'Android', '106.205.172.46', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-30 19:51:22', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(157, 0, 'mobile', 'Android', '106.205.172.46', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-11-30 19:54:16', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(158, 0, 'mobile', 'Android', '106.222.180.120', 'IN', 'assets/images/data/items/fried_rice.png', '', '2017-11-30 23:43:22', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(159, 0, 'mobile', 'Android', '47.30.183.72', 'CA', 'assets/images/data/items/chole_bhature.png', '', '2017-11-30 23:44:26', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.1.1; ONEPLUS A5000 Build/NMF26X)'),
(160, 0, 'mobile', 'Android', '106.222.180.120', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-11-30 23:58:08', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(161, 0, 'mobile', 'Android', '49.39.51.151', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-12-01 00:28:48', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(162, 0, 'mobile', 'Android', '27.60.10.40', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-12-01 00:44:03', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(163, 0, 'mobile', 'Android', '27.60.10.40', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-12-01 00:58:42', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(164, 0, 'mobile', 'Android', '27.60.12.136', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-12-01 04:14:43', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(165, 0, 'mobile', 'Android', '103.77.186.151', '0', 'assets/images/data/items/fried_rice.png', '', '2017-12-01 04:48:25', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(166, 0, 'mobile', 'Android', '106.222.28.100', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-12-01 10:50:58', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(167, 0, 'mobile', 'Android', '106.222.28.100', 'IN', 'assets/images/data/items/chole_bhature.png', '', '2017-12-01 10:55:39', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(168, 0, 'mobile', 'Android', '106.222.28.100', 'IN', 'assets/images/data/items/fried_rice.png', '', '2017-12-01 11:00:54', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)'),
(169, 0, 'mobile', 'Android', '106.222.28.100', 'IN', 'assets/images/data/items/sambhar_vada.png', '', '2017-12-01 11:06:26', 0, 'Dalvik/2.1.0 (Linux; U; Android 7.0; Redmi Note 4 MIUI/V9.0.5.0.NCFMIEI)');

-- --------------------------------------------------------

--
-- Table structure for table `ti_customer_groups`
--

CREATE TABLE IF NOT EXISTS `ti_customer_groups` (
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `approval` tinyint(1) NOT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ti_customer_groups`
--

INSERT INTO `ti_customer_groups` (`customer_group_id`, `group_name`, `description`, `approval`) VALUES
(11, 'Default', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ti_extensions`
--

CREATE TABLE IF NOT EXISTS `ti_extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `version` varchar(11) NOT NULL DEFAULT '1.0.0',
  PRIMARY KEY (`extension_id`),
  UNIQUE KEY `type` (`type`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `ti_extensions`
--

INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`, `version`) VALUES
(11, 'module', 'account_module', 'a:1:{s:7:"layouts";a:1:{i:0;a:4:{s:9:"layout_id";s:2:"11";s:8:"position";s:4:"left";s:8:"priority";s:1:"1";s:6:"status";s:1:"1";}}}', 1, 1, 'Account', '1.0.0'),
(12, 'module', 'local_module', 'a:3:{s:20:"location_search_mode";s:5:"multi";s:12:"use_location";s:1:"0";s:6:"status";s:1:"1";}', 1, 1, 'Local', '1.0.0'),
(13, 'module', 'categories_module', 'a:1:{s:7:"layouts";a:1:{i:0;a:4:{s:9:"layout_id";s:2:"12";s:8:"position";s:4:"left";s:8:"priority";s:1:"1";s:6:"status";s:1:"1";}}}', 1, 1, 'Categories', '1.0.0'),
(14, 'module', 'cart_module', 'a:3:{s:16:"show_cart_images";s:1:"0";s:13:"cart_images_h";s:0:"";s:13:"cart_images_w";s:0:"";}', 1, 1, 'Cart', '1.0.0'),
(15, 'module', 'reservation_module', 'a:1:{s:7:"layouts";a:1:{i:0;a:4:{s:9:"layout_id";s:2:"16";s:8:"position";s:4:"left";s:8:"priority";s:1:"1";s:6:"status";s:1:"1";}}}', 1, 1, 'Reservation', '1.0.0'),
(16, 'module', 'slideshow', 'a:6:{s:11:"dimension_h";s:3:"420";s:11:"dimension_w";s:4:"1170";s:6:"effect";s:4:"fade";s:5:"speed";s:3:"500";s:7:"layouts";a:1:{i:0;a:4:{s:9:"layout_id";s:2:"15";s:8:"position";s:3:"top";s:8:"priority";s:1:"1";s:6:"status";s:1:"1";}}s:6:"slides";a:3:{i:0;a:3:{s:4:"name";s:9:"slide.png";s:9:"image_src";s:14:"data/slide.jpg";s:7:"caption";s:0:"";}i:1;a:3:{s:4:"name";s:10:"slide1.png";s:9:"image_src";s:15:"data/slide1.jpg";s:7:"caption";s:0:"";}i:2;a:3:{s:4:"name";s:10:"slide2.png";s:9:"image_src";s:15:"data/slide2.jpg";s:7:"caption";s:0:"";}}}', 1, 1, 'Slideshow', '1.0.0'),
(18, 'payment', 'cod', 'a:5:{s:4:"name";N;s:11:"order_total";s:4:"0.00";s:12:"order_status";s:2:"11";s:8:"priority";s:1:"1";s:6:"status";s:1:"1";}', 1, 1, 'Cash On Delivery', '1.0.0'),
(20, 'module', 'pages_module', 'a:1:{s:7:"layouts";a:1:{i:0;a:4:{s:9:"layout_id";s:2:"17";s:8:"position";s:5:"right";s:8:"priority";s:1:"1";s:6:"status";s:1:"1";}}}', 1, 1, 'Pages', '1.0.0'),
(21, 'payment', 'paypal_express', 'a:11:{s:8:"priority";s:0:"";s:6:"status";s:1:"0";s:8:"api_mode";s:7:"sandbox";s:8:"api_user";s:0:"";s:8:"api_pass";s:0:"";s:13:"api_signature";s:0:"";s:10:"api_action";s:4:"sale";s:10:"return_uri";s:24:"paypal_express/authorize";s:10:"cancel_uri";s:21:"paypal_express/cancel";s:11:"order_total";s:4:"0.00";s:12:"order_status";s:2:"11";}', 1, 0, 'PayPal Express', '1.0.0'),
(23, 'theme', 'tastyigniter-orange', '', 1, 1, 'TastyIgniter Orange', '1.0.0'),
(24, 'theme', 'tastyigniter-blue', '', 1, 0, 'TastyIgniter Blue', '1.0.0'),
(25, 'module', 'banners_module', 'a:1:{s:7:"banners";a:1:{i:1;a:3:{s:9:"banner_id";s:1:"1";s:5:"width";s:0:"";s:6:"height";s:0:"";}}}', 1, 1, 'Banners', '1.0.0'),
(26, 'cart_total', 'cart_total', 'a:5:{s:8:"priority";s:1:"1";s:4:"name";s:10:"cart_total";s:5:"title";s:9:"Sub Total";s:11:"admin_title";s:9:"Sub Total";s:6:"status";s:1:"1";}', 1, 1, 'Sub Total', '1.0.0'),
(27, 'cart_total', 'coupon', 'a:5:{s:8:"priority";s:1:"3";s:4:"name";s:6:"coupon";s:5:"title";s:15:"Coupon {coupon}";s:11:"admin_title";s:15:"Coupon {coupon}";s:6:"status";s:1:"1";}', 1, 1, 'Coupon', '1.0.0'),
(28, 'cart_total', 'delivery', 'a:5:{s:8:"priority";s:1:"4";s:4:"name";s:8:"delivery";s:5:"title";s:8:"Delivery";s:11:"admin_title";s:8:"Delivery";s:6:"status";s:1:"1";}', 1, 1, 'Delivery', '1.0.0'),
(29, 'cart_total', 'taxes', 'a:5:{s:8:"priority";s:1:"5";s:4:"name";s:5:"taxes";s:5:"title";s:9:"VAT {tax}";s:11:"admin_title";s:9:"VAT {tax}";s:6:"status";s:1:"1";}', 1, 1, 'VAT', '1.0.0'),
(30, 'cart_total', 'order_total', 'a:5:{s:8:"priority";s:1:"6";s:4:"name";s:11:"order_total";s:5:"title";s:11:"Order Total";s:11:"admin_title";s:11:"Order Total";s:6:"status";s:1:"1";}', 1, 1, 'Order Total', '1.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `ti_languages`
--

CREATE TABLE IF NOT EXISTS `ti_languages` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(32) NOT NULL,
  `idiom` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `can_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ti_languages`
--

INSERT INTO `ti_languages` (`language_id`, `code`, `name`, `image`, `idiom`, `status`, `can_delete`) VALUES
(11, 'en', 'English', 'data/flags/gb.png', 'english', 1, 1),
(12, 'fr', 'French', 'data/flags/fr.png', 'french', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ti_layouts`
--

CREATE TABLE IF NOT EXISTS `ti_layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `ti_layouts`
--

INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES
(11, 'Home'),
(12, 'Menus'),
(13, 'Checkout'),
(15, 'Account'),
(16, 'Reservation'),
(17, 'Page'),
(18, 'Local'),
(19, 'Locations');

-- --------------------------------------------------------

--
-- Table structure for table `ti_layout_modules`
--

CREATE TABLE IF NOT EXISTS `ti_layout_modules` (
  `layout_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `module_code` varchar(128) NOT NULL,
  `partial` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL,
  `options` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`layout_module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `ti_layout_modules`
--

INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `partial`, `priority`, `options`, `status`) VALUES
(60, 17, 'pages_module', 'content_right', 1, '', 1),
(65, 11, 'slideshow', 'content_top', 1, '', 1),
(66, 11, 'local_module', 'content_top', 2, '', 1),
(67, 15, 'account_module', 'content_left', 1, '', 1),
(68, 12, 'local_module', 'content_top', 1, '', 1),
(69, 12, 'categories_module', 'content_left', 1, '', 1),
(70, 12, 'cart_module', 'content_right', 1, '', 1),
(71, 13, 'local_module', 'content_top', 1, '', 1),
(72, 13, 'cart_module', 'content_right', 1, '', 1),
(73, 16, 'reservation_module', 'content_top', 1, '', 1),
(74, 18, 'local_module', 'content_top', 1, '', 1),
(75, 18, 'categories_module', 'content_left', 1, '', 1),
(76, 18, 'cart_module', 'content_right', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_layout_routes`
--

CREATE TABLE IF NOT EXISTS `ti_layout_routes` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `uri_route` varchar(128) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `ti_layout_routes`
--

INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES
(19, 13, 'checkout'),
(41, 16, 'reservation'),
(44, 12, 'menus'),
(59, 11, 'home'),
(70, 18, 'local'),
(71, 19, 'locations'),
(72, 17, 'pages'),
(100, 15, 'account/account'),
(101, 15, 'account/details'),
(102, 15, 'account/address'),
(103, 15, 'account/orders'),
(104, 15, 'account/reservations'),
(105, 15, 'account/inbox'),
(106, 15, 'account/reviews');

-- --------------------------------------------------------

--
-- Table structure for table `ti_locations`
--

CREATE TABLE IF NOT EXISTS `ti_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(32) NOT NULL,
  `location_email` varchar(96) NOT NULL,
  `description` text NOT NULL,
  `location_address_1` varchar(128) NOT NULL,
  `location_address_2` varchar(128) NOT NULL,
  `location_city` varchar(128) NOT NULL,
  `location_state` varchar(128) NOT NULL,
  `location_postcode` varchar(10) NOT NULL,
  `location_country_id` int(11) NOT NULL,
  `location_telephone` varchar(32) NOT NULL,
  `location_lat` float(10,6) NOT NULL,
  `location_lng` float(10,6) NOT NULL,
  `location_radius` int(11) NOT NULL,
  `offer_delivery` tinyint(1) NOT NULL,
  `offer_collection` tinyint(1) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `last_order_time` int(11) NOT NULL,
  `reservation_time_interval` int(11) NOT NULL,
  `reservation_stay_time` int(11) NOT NULL,
  `location_status` tinyint(1) NOT NULL,
  `collection_time` int(11) NOT NULL,
  `options` text NOT NULL,
  `location_image` varchar(255) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ti_locations`
--

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_time_interval`, `reservation_stay_time`, `location_status`, `collection_time`, `options`, `location_image`) VALUES
(11, 'Annapurna Cafe', 'harshulsinghal@yahoo.com', 'Annapuna Cafe has all the essential fast food and snacks that you crave for. Come and Check it Out.', 'ABB3, Ground Floor, JIIT', 'A-10, Sector-63, Noida', 'Noida', 'Uttar Pradesh', '201309', 99, '9811553063', 51.544060, -0.053999, 0, 1, 1, 45, 0, 0, 0, 1, 15, 'a:7:{s:12:"auto_lat_lng";s:1:"1";s:13:"opening_hours";a:10:{s:12:"opening_type";s:5:"daily";s:10:"daily_days";a:7:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";i:5;s:1:"5";i:6;s:1:"6";}s:11:"daily_hours";a:2:{s:4:"open";s:7:"9:00 AM";s:5:"close";s:8:"11:00 PM";}s:14:"flexible_hours";a:7:{i:0;a:4:{s:3:"day";s:1:"0";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:1;a:4:{s:3:"day";s:1:"1";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:2;a:4:{s:3:"day";s:1:"2";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:3;a:4:{s:3:"day";s:1:"3";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:4;a:4:{s:3:"day";s:1:"4";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:5;a:4:{s:3:"day";s:1:"5";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:6;a:4:{s:3:"day";s:1:"6";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}}s:13:"delivery_type";s:1:"0";s:13:"delivery_days";a:7:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";i:5;s:1:"5";i:6;s:1:"6";}s:14:"delivery_hours";a:2:{s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";}s:15:"collection_type";s:1:"0";s:15:"collection_days";a:7:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";i:5;s:1:"5";i:6;s:1:"6";}s:16:"collection_hours";a:2:{s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";}}s:13:"future_orders";s:1:"1";s:17:"future_order_days";a:2:{s:8:"delivery";s:1:"1";s:10:"collection";s:1:"1";}s:8:"payments";a:1:{i:0;s:3:"cod";}s:14:"delivery_areas";a:4:{i:1;a:6:{s:5:"shape";s:34:"[{"shape":"_yryHzpHff@??d~@gf@?"}]";s:8:"vertices";s:219:"[{"lat":51.547200000000004,"lng":-0.048940000000000004},{"lat":51.54092000000001,"lng":-0.048940000000000004},{"lat":51.54092000000001,"lng":-0.059050000000000005},{"lat":51.547200000000004,"lng":-0.059050000000000005}]";s:6:"circle";s:71:"[{"center":{"lat":51.54406,"lng":-0.05399899999997615}},{"radius":500}]";s:4:"type";s:5:"shape";s:4:"name";s:6:"Area 1";s:6:"charge";a:1:{i:1;a:3:{s:6:"amount";s:2:"10";s:9:"condition";s:5:"above";s:5:"total";s:3:"100";}}}i:2;a:6:{s:5:"shape";s:34:"[{"shape":"kvtyHrfJrmA??j}BsmA?"}]";s:8:"vertices";s:177:"[{"lat":51.55702,"lng":-0.05754000000000001},{"lat":51.54444,"lng":-0.05754000000000001},{"lat":51.54444,"lng":-0.07776000000000001},{"lat":51.55702,"lng":-0.07776000000000001}]";s:6:"circle";s:72:"[{"center":{"lat":51.54406,"lng":-0.05399899999997615}},{"radius":1000}]";s:4:"type";s:5:"shape";s:4:"name";s:6:"Area 2";s:6:"charge";a:1:{i:1;a:3:{s:6:"amount";s:1:"4";s:9:"condition";s:5:"above";s:5:"total";s:2:"10";}}}i:3;a:6:{s:5:"shape";s:34:"[{"shape":"kvuyH`dBztB??r|D{tB?"}]";s:8:"vertices";s:147:"[{"lat":51.56214000000001,"lng":-0.01617},{"lat":51.54328,"lng":-0.01617},{"lat":51.54328,"lng":-0.04651},{"lat":51.56214000000001,"lng":-0.04651}]";s:6:"circle";s:72:"[{"center":{"lat":51.54406,"lng":-0.05399899999997615}},{"radius":1500}]";s:4:"type";s:5:"shape";s:4:"name";s:6:"Area 3";s:6:"charge";a:1:{i:1;a:3:{s:6:"amount";s:2:"30";s:9:"condition";s:5:"above";s:5:"total";s:3:"300";}}}i:4;a:6:{s:5:"shape";s:34:"[{"shape":"gmqyHlhEf|C??x{Fg|C?"}]";s:8:"vertices";s:193:"[{"lat":51.540200000000006,"lng":-0.03223},{"lat":51.515040000000006,"lng":-0.03223},{"lat":51.515040000000006,"lng":-0.07268000000000001},{"lat":51.540200000000006,"lng":-0.07268000000000001}]";s:6:"circle";s:72:"[{"center":{"lat":51.54406,"lng":-0.05399899999997615}},{"radius":2000}]";s:4:"type";s:5:"shape";s:4:"name";s:6:"Area 4";s:6:"charge";a:1:{i:1;a:3:{s:6:"amount";s:2:"10";s:9:"condition";s:5:"above";s:5:"total";s:3:"200";}}}}s:7:"gallery";a:2:{s:5:"title";s:0:"";s:11:"description";s:0:"";}}', 'data/meat_pie.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ti_location_tables`
--

CREATE TABLE IF NOT EXISTS `ti_location_tables` (
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`table_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ti_location_tables`
--

INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES
(11, 7),
(11, 16);

-- --------------------------------------------------------

--
-- Table structure for table `ti_mail_templates`
--

CREATE TABLE IF NOT EXISTS `ti_mail_templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ti_mail_templates`
--

INSERT INTO `ti_mail_templates` (`template_id`, `name`, `language_id`, `date_added`, `date_updated`, `status`) VALUES
(11, 'Default', 1, '2014-04-16 01:49:52', '2014-06-16 14:44:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_mail_templates_data`
--

CREATE TABLE IF NOT EXISTS `ti_mail_templates_data` (
  `template_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `body` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`template_data_id`,`template_id`,`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `ti_mail_templates_data`
--

INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES
(11, 11, 'registration', 'Welcome to {site_name}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="5"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">Welcome!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Thank you for registrating with {site_name}. Your account has now been created and you can log in using your email address and password by visiting our website or at the following URL: <a href="{account_login_link}">Click Here</a></span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Thank you for using.<br> {signature}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2014-05-15 15:24:56'),
(12, 11, 'password_reset', 'Password reset at {site_name}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="5"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">Reset your password!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your password has been reset successfull! Please <a href="{account_login_link}" target="_blank">login</a> using your new password: {created_password}.</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Please don''t forget to change your password after you login.<br> {signature}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2014-05-15 15:46:30'),
(13, 11, 'order', '{site_name} order confirmation - {order_number}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a title="" data-original-title="" href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font color="#596167" size="3" face="Arial, Helvetica, sans-seri; font-size: 13px;"><img src="{site_logo}" alt="{site_name}" style="display: block;" border="0" width="115" height="19"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font color="#596167" size="2" face="Arial, Helvetica, sans-serif"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font color="#596167" size="2" face="Arial, Helvetica, sans-serif"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font color="#596167" size="2" face="Arial, Helvetica, sans-serif"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" color="#57697e" size="5" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">Thank you for your order!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your order has been received and will be with you shortly. <a title="" data-original-title="" href="{order_view_url}">Click here</a> to view your order progress.</span></font><br></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your order number is {order_number}<br> This is a {order_type} order.</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><br><strong>Order date:</strong> {order_date}<br><strong>Requested {order_type} time</strong> {order_time}<br><strong>Payment Method:</strong> {order_payment}</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td><div style="line-height: 24px;"><font style="font-size: 13px;" color="#57697e" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">Name/Description</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 13px;" color="#57697e" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">Unit Price</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 13px;" color="#57697e" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">Sub Total</span></font></div></td></tr><tr><td>{order_menus}<br></td><td><br></td><td><br></td></tr><tr style="border-top:1px dashed #c3cbd5;"><td><div style="line-height: 24px;"><font style="font-size: 15px;font-weight:bold;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{menu_quantity} x {menu_name}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" color="#96a5b5" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;">{menu_options}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" color="#96a5b5" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;">{menu_comment}</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{menu_price}</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{menu_subtotal}</span></font></div></td></tr><tr><td>{/order_menus}</td><td><br></td><td><br></td></tr><tr><td><br></td><td>{order_totals}</td><td><br></td></tr><tr><td><br></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{order_total_title}</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{order_total_value}</span></font></div></td></tr><tr><td><br></td><td>{/order_totals}<br></td><td><br></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{order_comment}</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{order_address}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span title="" data-original-title="" style="font-weight: bold;">Restaurant:</span> {location_name}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" color="#96a5b5" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2014-07-20 14:29:55'),
(14, 11, 'reservation', 'Your Reservation Confirmation - {reservation_number}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="5"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">Thank you for your reservation!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your reservation {reservation_number} at {location_name} has been booked for {reservation_guest_no} person(s) on {reservation_date} at {reservation_time}.</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Thanks for reserving with us online!</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2014-07-22 20:13:48'),
(15, 11, 'contact', 'Contact on {site_name}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="5"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">Someone just contacted you!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Hello Admin,</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"><br></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">From: {full_name}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Topic: {contact_topic}.</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Telephone: {contact_telephone}.</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><br></span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{contact_message}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><br></span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">This inquiry was sent from {site_name}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{signature}<br></span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2014-05-15 18:00:57'),
(16, 11, 'internal', 'Subject here', 'Body here', '2014-04-16 00:56:00', '2014-04-16 00:59:00'),
(17, 11, 'order_alert', 'New order on {site_name}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a title="" data-original-title="" href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font color="#596167" size="3" face="Arial, Helvetica, sans-seri; font-size: 13px;"><img src="{site_logo}" alt="{site_name}" style="display: block;" border="0" width="115" height="19"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font color="#596167" size="2" face="Arial, Helvetica, sans-serif"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font color="#596167" size="2" face="Arial, Helvetica, sans-serif"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font color="#596167" size="2" face="Arial, Helvetica, sans-serif"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" color="#57697e" size="5" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">You received an order!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">You just received an order from {location_name}.</span></font><br></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">The order number is {order_number}<br> This is a {order_type} order.</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><br><strong>Customer name:</strong> {first_name} {last_name}<br><strong>Order date:</strong> {order_date}<br><strong>Requested {order_type} time</strong> {order_time}<br><strong>Payment Method:</strong> {order_payment}<br><br></span></font></div><!-- padding --><div style="height: 10px; line-height: 10px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"></span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td><div style="line-height: 24px;"><font style="font-size: 13px;" color="#57697e" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">Name/Description</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 13px;" color="#57697e" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">Unit Price</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 13px;" color="#57697e" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">Sub Total</span></font></div></td></tr><tr><td>{order_menus}<br></td><td><br></td><td><br></td></tr><tr style="border-top:1px dashed #c3cbd5;"><td><div style="line-height: 24px;"><font style="font-size: 15px;font-weight:bold;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{menu_quantity} x {menu_name}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" color="#96a5b5" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;">{menu_options}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" color="#96a5b5" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;">{menu_comment}</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{menu_price}</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{menu_subtotal}</span></font></div></td></tr><tr><td>{/order_menus}</td><td><br></td><td><br></td></tr><tr><td><br></td><td>{order_totals}</td><td><br></td></tr><tr><td><br></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{order_total_title}</span></font></div></td><td><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{order_total_value}</span></font></div></td></tr><tr><td><br></td><td>{/order_totals}<br></td><td><br></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" color="#57697e" size="4" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{order_comment}</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" color="#96a5b5" size="3" face="Arial, Helvetica, sans-serif"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2014-04-16 00:59:00');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES
(18, 11, 'reservation_alert', 'New reservation on {site_name}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="5"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">You received a table reservation!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span style="font-weight: bold;">Customer name:</span> {first_name} {last_name}</span></font></div><!-- padding --></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span style="font-weight: bold;">Reservation no:</span> {reservation_number} </span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span style="font-weight: bold;">Restaurant:</span> {location_name} </span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span style="font-weight: bold;">No of guest(s):</span> {reservation_guest_no} person(s) </span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span style="font-weight: bold;">Reservation date:</span> {reservation_date}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span style="font-weight: bold;">Reservation time: </span></span></font>{reservation_time}</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">You received a table reservation from {site_name}<br></span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2014-04-16 00:59:00'),
(19, 11, 'registration_alert', 'New Customer on {site_name}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="5"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">You have a new customer!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><span style="font-weight: bold;">Customer name:</span> {first_name} {last_name}</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2017-08-11 00:00:00', '2017-08-11 00:00:00'),
(20, 11, 'password_reset_alert', 'Password reset at {site_name}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div><div style="line-height: 44px;"><font style="font-size: 34px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="5"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;">Reset your password!</span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Hello {staff_name},</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">You requested that the password be reset for the following account:</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Username: {staff_username}</span></font></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Password: {created_password}</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Please do not forget to change your password after you login.<br> {signature}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2017-08-11 00:00:00', '2017-08-11 00:00:00'),
(21, 11, 'order_update', 'Your Order Update - {order_number}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a title="" data-original-title="" href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your order has been updated to the following status: <span title="" data-original-title="" style="font-weight: bold;">{status_name}</span></span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;"><a title="" data-original-title="" href="{order_view_url}">Click here</a> to view your order progress.</span></font><br></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your order number is: <span title="" data-original-title="" style="font-weight: bold;">{order_number}</span></span></font></div><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><span title="" data-original-title="" style="font-weight: bold;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">The comments for your order are:</span></font></span></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{status_comment}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2017-08-11 00:00:00', '2017-08-11 00:00:00'),
(22, 11, 'reservation_update', 'Your Reservation Update - {reservation_number}', '<div id="mailsub" class="notification" align="center"><table style="min-width: 320px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" bgcolor="#eff3f8"><!--[if gte mso 10]><table width="680" border="0" cellspacing="0" cellpadding="0"><tr><td><![endif]--><table class="table_width_100" style="max-width: 680px; min-width: 300px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr><!--header --><tr><td align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 30px; line-height: 30px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><!-- Item --><div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;"><table class="mob_center" style="border-collapse: collapse;" align="left" border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td align="left" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="115"><tbody><tr><td class="mob_center" align="left" valign="top"><a title="" data-original-title="" href="{site_url}" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;"><font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3"><img src="{site_logo}" alt="{site_name}" style="display: block;" height="19" border="0" width="115"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align="right"><![endif]--><!-- Item --><div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;"><table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88"><tbody><tr><td align="right" valign="middle"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="right"><!--social --><div class="mob_center_bl" style="width: 88px;"><table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td style="line-height: 19px;" align="center" width="30"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="center" width="39"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td><td style="line-height: 19px;" align="right" width="29"><a title="" data-original-title="" href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;"><font face="Arial, Helvetica, sans-serif" color="#596167" size="2"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style="height: 50px; line-height: 50px; font-size: 10px;"></div></td></tr><!--header END--><!--content 1 --><tr><td align="center" bgcolor="#fbfcfd"><table border="0" cellpadding="0" cellspacing="0" width="90%"><tbody><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your reservation has been updated to the following status: <span title="" data-original-title="" style="font-weight: bold;">{status_name}</span></span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">Your reservation number: <span title="" data-original-title="" style="font-weight: bold;">{reservation_number}</span> at <span title="" data-original-title="" style="font-weight: bold;">{location_name}</span>.</span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><span title="" data-original-title="" style="font-weight: bold;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">The comments for your reservation are:</span></font></span></div><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">{status_comment}<br></span></font></div><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><tr><td align="left"><div style="line-height: 24px;"><font style="font-size: 15px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style="height: 40px; line-height: 40px; font-size: 10px;"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class="iage_footer" align="center" bgcolor="#ffffff"><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center"><font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#96a5b5" size="3"><span title="" data-original-title="" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style="height: 80px; line-height: 80px; font-size: 10px;"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2017-08-11 00:00:00', '2017-08-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ti_mealtimes`
--

CREATE TABLE IF NOT EXISTS `ti_mealtimes` (
  `mealtime_id` int(11) NOT NULL AUTO_INCREMENT,
  `mealtime_name` varchar(128) NOT NULL,
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '23:59:59',
  `mealtime_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`mealtime_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `ti_mealtimes`
--

INSERT INTO `ti_mealtimes` (`mealtime_id`, `mealtime_name`, `start_time`, `end_time`, `mealtime_status`) VALUES
(11, 'Breakfast', '09:00:00', '11:30:00', 1),
(12, 'Lunch', '12:30:00', '14:30:00', 1),
(13, 'Dinner', '15:30:00', '23:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_menus`
--

CREATE TABLE IF NOT EXISTS `ti_menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `menu_description` text NOT NULL,
  `menu_price` decimal(15,4) NOT NULL,
  `menu_photo` varchar(255) DEFAULT NULL,
  `menu_category_id` int(11) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `minimum_qty` int(11) NOT NULL,
  `subtract_stock` tinyint(1) NOT NULL,
  `mealtime_id` int(11) NOT NULL,
  `menu_status` tinyint(1) NOT NULL,
  `menu_priority` int(11) NOT NULL,
  `menu_french_name` varchar(32) DEFAULT NULL,
  `menu_french_description` text,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=129 ;

--
-- Dumping data for table `ti_menus`
--

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `mealtime_id`, `menu_status`, `menu_priority`, `menu_french_name`, `menu_french_description`) VALUES
(89, 'Aloo Chaat', 'A delicious snack made of potatoes fried in oil and adding species and chutney!\r\n', '40.0000', 'data/items/aloo_chaat.png', 15, 20, 1, 1, 0, 1, 0, 'Aloo Chaat', 'Une délicieuse collation faite de pommes de terre frites à l''huile et ajoutant des espèces et du chutney!'),
(91, 'Maggi', 'A mouth-watering instant noodle dish from Nestle is the one everbody needs.', '25.0000', 'data/items/maggi.png', 15, 60, 1, 1, 0, 1, 0, 'Nouilles', 'Un plat instantané de nouilles instantanées de Nestlé est celui dont tout le monde a besoin.'),
(92, 'Kachori', 'A round ball made of flour and dough filled with a stuffing of yellow moong dal, black pepper, red chili powder, and ginger paste.', '18.0000', 'data/items/kachori.png', 15, 40, 1, 1, 0, 1, 0, 'Kachori', 'Une boule ronde faite de farine et de pâte remplie d''une farce de moong dal jaune, de poivre noir, de poudre de chili rouge et de pâte de gingembre.'),
(93, 'Gol-Gappe', 'It consists of a round, hollow puri, fried crisp and filled with a mixture of flavored water.', '35.0000', 'data/items/gol_gappe.png', 15, 18, 1, 1, 0, 1, 0, 'Boules d''eau', 'Il se compose d''un puri rond, croustillant, frit et rempli d''un mélange d''eau aromatisée.'),
(94, 'Bhelpuri', 'Bhelpuri has a balance of sweet, salty, tart and spicy flavor including crispy and crunchy from the puffed rice and fried sev.', '30.0000', 'data/items/bhelpuri.png', 15, 40, 1, 1, 0, 1, 0, 'Bhelpuri', 'Bhelpuri a un équilibre de saveur sucrée, salée, acidulée et épicée, y compris croustillant et croquant du riz soufflé et sev frit.'),
(95, 'Patty', 'The veggies are compacted ,shaped , cooked and served!', '14.0000', 'data/items/patties.png', 15, 20, 1, 1, 0, 1, 0, 'Petit pâté', 'Les légumes sont compactés, façonnés, cuits et servis!'),
(96, 'Bread Roll', 'Hot crispy potatoes served in round loaf of bread.', '20.0000', 'data/items/bread_roll.png', 15, 30, 1, 1, 0, 1, 0, 'Pain Pain', 'Pommes de terre croustillantes chaudes servies dans une miche de pain ronde.'),
(97, 'Hot Dog', 'A cooked sausage served in partially sliced bun.', '35.0000', 'data/items/hot_dog.png', 15, 30, 1, 1, 0, 1, 0, 'Chaud chien', 'Une saucisse cuite servie dans un pain partiellement tranché.'),
(98, 'Burger', 'A sandwhich consisting of one or more patties.', '45.0000', 'data/items/burger.png', 15, 40, 1, 1, 0, 1, 0, 'Chignon', 'Un sandwhich composé d''une ou plusieurs galettes.'),
(99, 'Idli', 'A savoury cake made up of lots of household ingredients. ', '60.0000', 'data/items/idli.png', 18, 40, 1, 1, 0, 1, 0, 'Idli', 'Un gâteau savoureux composé de beaucoup d''ingrédients ménagers.'),
(100, 'Dosa', 'A pancake made from fermented batter served with sambhar.', '65.0000', 'data/items/dosa.png', 18, 0, 1, 1, 0, 1, 0, 'Dosa', 'Une crêpe à base de pâte fermentée servie avec du sambhar.'),
(101, 'Sambhar Vada', 'A common dish made from lagumes , sagos or potatoes.', '55.0000', 'data/items/sambhar_vada.png', 18, 35, 1, 1, 0, 1, 0, 'Sambhar Vada', 'Un plat commun à base de lagunes, de sagos ou de pommes de terre.'),
(102, 'Uttpam', 'A dosa like dish but with a thin pancake.', '40.0000', 'data/items/uttpam.png', 18, 20, 1, 1, 0, 1, 0, 'Uttpam', 'Un dosa comme plat mais avec une crêpe fine.'),
(103, 'Upma', 'A thick porridge from rice flour.', '50.0000', 'data/items/upma.png', 18, 0, 1, 1, 0, 1, 0, 'Upma', 'Une bouillie épaisse de farine de riz.'),
(104, 'Chole Bhature', 'Combination of Chana Masala and Fried Bread.', '65.0000', 'data/items/chole_bhature.png', 19, 15, 1, 1, 0, 1, 0, 'Gramme soufflé', 'Combination of Chana Masala and Fried Bread.'),
(105, 'Veg Roll', 'Indo chinese snack crunchy from outside and spiced vegetable filing from inside.', '60.0000', 'data/items/rolls.png', 18, 20, 1, 1, 0, 1, 0, 'Rouleau de légumes', 'Snack chinois indo croustillant de l''extérieur et dépôt de légumes épicé de l''intérieur.'),
(106, 'Biryani', 'Is a one-dish rice-based meal that consists of layering cooked rice.', '80.0000', 'data/items/biryani.png', 18, 30, 1, 1, 0, 1, 0, 'Riz', 'Est-ce un repas à base de riz à un plat qui consiste à superposer du riz cuit.'),
(107, 'Rajma Chawal', 'Red kidney beans i.e Rajma served with boiled rice.', '50.0000', 'data/items/rajma_chawal.png', 18, 30, 1, 1, 0, 1, 0, 'des haricots riz', 'Haricots rouges i.e Rajma servi avec du riz bouilli.'),
(108, 'Aloo Paratha', 'Unleavened dough stuffed with a spiced mixture of mashed potato.', '45.0000', 'data/items/aloo_paratha.png', 18, 50, 1, 1, 0, 1, 0, 'Patate pain', 'Pâte sans levain farcie d''un mélange épicé de purée de pommes de terre'),
(109, 'Bun Omlette', 'Beaten eggs fried with butter and served in bun.', '35.0000', 'data/items/bun_omlette.png', 18, 20, 1, 1, 0, 1, 0, 'Chignon Oeuf', 'Les oeufs battus frits avec du beurre et servis en chignon.'),
(110, 'Pav-Bhaji', 'Thick vegetable curry served with soft bread.', '60.0000', 'data/items/pav_bhaji.png', 18, 40, 1, 1, 0, 1, 0, 'Chignon Bhaaji', 'Curry de légumes épais servi avec du pain mou.'),
(111, 'Tea', 'An aromatic beverage prepared using cured leaves.', '12.0000', 'data/items/tea.png', 23, 60, 1, 1, 0, 1, 0, 'thé', 'Une boisson aromatique préparée en utilisant des feuilles séchées.'),
(112, 'Coffee', 'A brewed drink prepared from roasted coffee beans.', '20.0000', 'data/items/coffee.png', 23, 60, 1, 1, 0, 1, 0, 'café', 'Une boisson brassée préparée à partir de grains de café torréfiés.'),
(113, 'Juice', 'Extraction of natural liquid of fresh fruits and vegetables.', '30.0000', 'data/items/Juice.png', 23, 60, 1, 1, 0, 1, 0, 'jus', 'Extraction de liquide naturel de fruits et légumes frais.'),
(114, 'Milkshakes', 'Sweet flavouring milk such as of Ice-cream or chocolate.', '50.0000', 'data/items/milkshakes.png', 23, 50, 1, 1, 0, 1, 0, 'Lait shakes', 'Lait aromatisé sucré tel que Glace ou chocolat.'),
(115, 'Lassi', 'A blend of yoghurt , water and spices.', '30.0000', 'data/items/lassi.png', 23, 40, 1, 1, 0, 1, 0, 'fromage blanc', 'Un mélange de yaourt, d''eau et d''épices.'),
(116, 'Cold-Drink', 'A sweet serving of carbonated water and artificial flavouring.', '35.0000', 'data/items/cold_drinks.png', 23, 100, 1, 1, 0, 1, 0, 'Boisson froide', 'Une douce portion d''eau gazeuse et d''arômes artificiels.'),
(117, 'Biscuits', 'A primarily flour based packed food.', '25.0000', 'data/items/biscuits.png', 22, 70, 1, 1, 0, 1, 0, 'Des biscuits', 'Un aliment emballé principalement à base de farine.'),
(118, 'Cake', 'Soft and delicious fruit bar cake.', '30.0000', 'data/items/cake.png', 22, 80, 1, 1, 0, 1, 0, 'gâteau', 'Gâteau de fruits doux et délicieux.'),
(119, 'Chips', 'A thin slice of potato that has been deep fried.', '20.0000', 'data/items/chips.png', 22, 70, 1, 1, 0, 1, 0, 'Chips', 'Une fine tranche de pomme de terre qui a été frite.'),
(120, 'Momos', 'A steamed bun with various types of fillings.', '60.0000', 'data/items/momos.png', 20, 40, 1, 1, 0, 1, 0, NULL, NULL),
(121, 'Fried Rice', 'Cooked rice that has been stir-fried in a wok.', '70.0000', 'data/items/fried_rice.png', 20, 30, 1, 1, 0, 1, 0, NULL, NULL),
(122, 'Manchurian', 'A desi chinese or Indian chinese fried vegetable stuffing.', '80.0000', 'data/items/manchurian.png', 20, 40, 1, 1, 0, 1, 0, NULL, NULL),
(123, 'Chowmein', 'A very popular chinese stir-fried noodles.', '55.0000', 'data/items/chowmein.png', 20, 50, 1, 1, 0, 1, 0, NULL, NULL),
(124, 'Spring Roll', 'With a large variety of filled , rolled appetizers and a dim sum dish.', '65.0000', 'data/items/spring_roll.png', 20, 30, 1, 1, 0, 1, 0, NULL, NULL),
(125, 'Chili Garlic Chowmein', 'Refried chowmein with extra chilies and great taste of garlic.', '75.0000', 'data/items/chili_garlic_noodles.jpg', 24, 50, 1, 1, 0, 1, 0, NULL, NULL),
(126, 'Chili Potato', 'An Indo chinese dish served as a starter.', '60.0000', 'data/items/chili_potato.jpg', 24, 15, 1, 1, 0, 1, 0, NULL, NULL),
(127, 'Dal Makhni Naan', 'The awesome combination of Dal-Makhni and flatbread.', '90.0000', 'data/items/dal_makhni_naan.jpg', 24, 25, 1, 1, 0, 1, 0, NULL, NULL),
(128, 'French Fries', 'Allummete cut deep fried potato chips.', '55.0000', 'data/items/french_fries.jpg', 24, 40, 1, 1, 0, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ti_menus_specials`
--

CREATE TABLE IF NOT EXISTS `ti_menus_specials` (
  `special_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `special_price` decimal(15,4) DEFAULT NULL,
  `special_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`special_id`,`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_menu_options`
--

CREATE TABLE IF NOT EXISTS `ti_menu_options` (
  `menu_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `required` tinyint(4) NOT NULL,
  `default_value_id` tinyint(4) NOT NULL,
  `option_values` text NOT NULL,
  PRIMARY KEY (`menu_option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_menu_option_values`
--

CREATE TABLE IF NOT EXISTS `ti_menu_option_values` (
  `menu_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `new_price` decimal(15,4) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subtract_stock` tinyint(4) NOT NULL,
  PRIMARY KEY (`menu_option_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_messages`
--

CREATE TABLE IF NOT EXISTS `ti_messages` (
  `message_id` int(15) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `send_type` varchar(32) NOT NULL,
  `recipient` varchar(32) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_message_meta`
--

CREATE TABLE IF NOT EXISTS `ti_message_meta` (
  `message_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `item` varchar(32) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`message_meta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_migrations`
--

CREATE TABLE IF NOT EXISTS `ti_migrations` (
  `type` varchar(40) DEFAULT NULL,
  `version` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ti_migrations`
--

INSERT INTO `ti_migrations` (`type`, `version`) VALUES
('core', 30),
('cart_module', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_options`
--

CREATE TABLE IF NOT EXISTS `ti_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(32) NOT NULL,
  `display_type` varchar(15) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `ti_options`
--

INSERT INTO `ti_options` (`option_id`, `option_name`, `display_type`, `priority`) VALUES
(22, 'Cooked', 'radio', 1),
(23, 'Toppings', 'checkbox', 2),
(24, 'Dressing', 'select', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ti_option_values`
--

CREATE TABLE IF NOT EXISTS `ti_option_values` (
  `option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `value` varchar(128) NOT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`option_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ti_option_values`
--

INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES
(6, 23, 'Peperoni', '1.9900', 2),
(7, 23, 'Jalapenos', '3.9900', 1),
(8, 22, 'Meat', '4.0000', 1),
(9, 22, 'Chicken', '2.9900', 2),
(10, 22, 'Fish', '3.0000', 3),
(11, 22, 'Beef', '4.9900', 4),
(12, 22, 'Assorted Meat', '5.9900', 5),
(13, 24, 'Dodo', '3.9900', 1),
(14, 24, 'Salad', '2.9900', 2),
(15, 23, 'Sweetcorn', '1.9900', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ti_orders`
--

CREATE TABLE IF NOT EXISTS `ti_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `location_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `cart` text NOT NULL,
  `total_items` int(11) NOT NULL,
  `comment` text NOT NULL,
  `payment` varchar(35) NOT NULL,
  `order_type` varchar(32) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` date NOT NULL,
  `order_time` time NOT NULL,
  `order_date` date NOT NULL,
  `order_total` decimal(15,4) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL,
  `invoice_prefix` varchar(32) NOT NULL,
  `invoice_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96882 ;

--
-- Dumping data for table `ti_orders`
--

INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_date`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`, `invoice_no`, `invoice_prefix`, `invoice_date`) VALUES
(36857, 30, 'Nitesh', 'Mittal', 'niteshmittal68@gmail.com', '9896095084', 0, 23, '8', 8, '', 'cod', '', '2017-12-01 11:01:14', '2017-12-01', '11:01:14', '2017-12-01', '777.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(57632, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '2', 2, '', 'cod', '', '2017-12-01 08:14:29', '2017-12-01', '08:14:29', '2017-12-01', '65.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(4894, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '6', 6, '', 'cod', '', '2017-12-01 04:48:33', '2017-12-01', '04:48:33', '2017-12-01', '317.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(88866, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '1', 1, '', 'cod', '', '2017-12-01 04:14:54', '2017-12-01', '04:14:54', '2017-12-01', '240.0000', 11, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(90052, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '8', 8, '', 'cod', '', '2017-12-01 03:41:11', '2017-12-01', '03:41:11', '2017-12-01', '335.0000', 11, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(18794, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '8', 8, '', 'cod', '', '2017-12-01 03:40:41', '2017-12-01', '03:40:41', '2017-12-01', '335.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(41458, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '4', 4, '', 'cod', '', '2017-12-01 02:28:43', '2017-12-01', '02:28:43', '2017-12-01', '158.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(15633, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '3', 3, '', 'cod', '', '2017-12-01 02:25:36', '2017-12-01', '02:25:36', '2017-12-01', '123.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(93181, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '3', 3, '', 'cod', '', '2017-12-01 02:25:30', '2017-12-01', '02:25:30', '2017-12-01', '123.0000', 11, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(54528, 28, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '8802986147', 0, 22, '2', 2, '', 'cod', '', '2017-12-01 02:17:07', '2017-12-01', '02:17:07', '2017-12-01', '105.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(42460, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '1', 1, '', 'cod', '', '2017-12-01 01:52:30', '2017-12-01', '01:52:30', '2017-12-01', '40.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(39470, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '2', 2, '', 'cod', '', '2017-12-01 01:47:05', '2017-12-01', '01:47:05', '2017-12-01', '58.0000', 11, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(79895, 27, '', '', '', '', 0, 0, '2', 2, '', 'cod', '', '2017-12-01 01:45:12', '2017-12-01', '01:45:12', '2017-12-01', '65.0000', 11, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(72996, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '3', 3, '', 'cod', '', '2017-12-01 01:45:39', '2017-12-01', '01:45:39', '2017-12-01', '83.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(43384, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '3', 3, '', 'cod', '', '2017-12-01 01:42:00', '2017-12-01', '01:42:00', '2017-12-01', '89.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(52668, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '2', 2, '', 'cod', '', '2017-12-01 01:33:06', '2017-12-01', '01:33:06', '2017-12-01', '75.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(13081, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '3', 3, '', 'cod', '', '2017-12-01 01:30:40', '2017-12-01', '01:30:40', '2017-12-01', '95.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(25614, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '9', 9, '', 'cod', '', '2017-12-01 00:59:01', '2017-12-01', '00:59:01', '2017-12-01', '545.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(14321, 27, 's', 'n', 'as@com', '9', 0, 21, '2', 2, '', 'cod', '', '2017-12-01 00:48:20', '2017-12-01', '00:48:20', '2017-12-01', '65.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(20836, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '4', 4, '', 'cod', '', '2017-12-01 00:44:14', '2017-12-01', '00:44:14', '2017-12-01', '275.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(16874, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '2', 2, '', 'cod', '', '2017-12-01 00:39:31', '2017-12-01', '00:39:31', '2017-12-01', '130.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(95094, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '25', 25, '', 'cod', '', '2017-12-01 00:30:10', '2017-12-01', '00:30:10', '2017-12-01', '1197.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(70538, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '1', 1, '', 'cod', '', '2017-11-30 23:59:05', '2017-11-30', '23:59:05', '2017-11-30', '65.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(22983, 26, 'Rishabh', 'Gulati', 'risgulati@gmail.com', '9650841557', 0, 20, '1', 1, '', 'cod', '', '2017-11-30 23:53:10', '2017-11-30', '23:53:10', '2017-11-30', '18.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(73934, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '1', 1, '', 'cod', '', '2017-11-30 23:43:26', '2017-11-30', '23:43:26', '2017-11-30', '60.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(91192, 16, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '9868592224', 0, 16, '2', 2, '', 'cod', '', '2017-11-30 23:19:28', '2017-11-30', '23:19:28', '2017-11-30', '65.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(96871, 16, 'Arpit', 'Saxena', 'arpitsaxena277@gmail.com', '9868592224', 0, 16, '2', 2, '', 'cod', '', '2017-11-30 23:18:48', '2017-11-30', '23:18:48', '2017-11-30', '65.0000', 11, '', '', 0, 0, 0, '', '0000-00-00 00:00:00'),
(47093, 24, 'Q', 'W', 'n@g.com', '1', 0, 19, '18', 18, '', 'cod', '', '2017-12-01 11:06:58', '2017-12-01', '11:06:58', '2017-12-01', '830.0000', 15, '', '', 0, 0, 0, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ti_order_menus`
--

CREATE TABLE IF NOT EXISTS `ti_order_menus` (
  `order_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `subtotal` decimal(15,4) DEFAULT NULL,
  `option_values` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`order_menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=238 ;

--
-- Dumping data for table `ti_order_menus`
--

INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`, `comment`) VALUES
(154, 25614, 107, 'Rajma Chawal', 1, '50.0000', '50.0000', '', ''),
(153, 25614, 109, 'Bun Omlette', 1, '35.0000', '35.0000', '', ''),
(152, 25614, 99, 'Idli', 1, '60.0000', '60.0000', '', ''),
(151, 25614, 105, 'Veg Roll', 1, '60.0000', '60.0000', '', ''),
(150, 25614, 102, 'Uttpam', 1, '40.0000', '40.0000', '', ''),
(149, 14321, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(148, 14321, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(147, 20836, 104, 'Chole Bhature', 1, '65.0000', '65.0000', '', ''),
(146, 20836, 122, 'Manchurian', 1, '80.0000', '80.0000', '', ''),
(145, 20836, 120, 'Momos', 1, '60.0000', '60.0000', '', ''),
(144, 20836, 121, 'Fried Rice', 1, '70.0000', '70.0000', '', ''),
(143, 16874, 91, 'Maggi', 2, '25.0000', '50.0000', '', ''),
(142, 16874, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(141, 95094, 101, 'Sambhar Vada', 1, '55.0000', '55.0000', '', ''),
(140, 95094, 107, 'Rajma Chawal', 1, '50.0000', '50.0000', '', ''),
(139, 95094, 98, 'Burger', 1, '45.0000', '45.0000', '', ''),
(138, 95094, 106, 'Biryani', 1, '80.0000', '80.0000', '', ''),
(137, 95094, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(136, 95094, 101, 'Sambhar Vada', 1, '55.0000', '55.0000', '', ''),
(135, 95094, 120, 'Momos', 1, '60.0000', '60.0000', '', ''),
(134, 95094, 109, 'Bun Omlette', 1, '35.0000', '35.0000', '', ''),
(133, 95094, 123, 'Chowmein', 1, '55.0000', '55.0000', '', ''),
(132, 95094, 95, 'Patty', 1, '14.0000', '14.0000', '', ''),
(131, 95094, 99, 'Idli', 1, '60.0000', '60.0000', '', ''),
(130, 95094, 102, 'Uttpam', 1, '40.0000', '40.0000', '', ''),
(129, 95094, 122, 'Manchurian', 1, '80.0000', '80.0000', '', ''),
(128, 95094, 110, 'Pav-Bhaji', 1, '60.0000', '60.0000', '', ''),
(127, 95094, 94, 'Bhelpuri', 1, '30.0000', '30.0000', '', ''),
(126, 95094, 105, 'Veg Roll', 1, '60.0000', '60.0000', '', ''),
(125, 95094, 97, 'Hot Dog', 1, '35.0000', '35.0000', '', ''),
(124, 95094, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(123, 95094, 124, 'Spring Roll', 1, '65.0000', '65.0000', '', ''),
(122, 95094, 104, 'Chole Bhature', 1, '65.0000', '65.0000', '', ''),
(121, 95094, 108, 'Aloo Paratha', 1, '45.0000', '45.0000', '', ''),
(120, 95094, 96, 'Bread Roll', 1, '20.0000', '20.0000', '', ''),
(119, 95094, 121, 'Fried Rice', 1, '70.0000', '70.0000', '', ''),
(118, 95094, 93, 'Gol-Gappe', 1, '35.0000', '35.0000', '', ''),
(117, 95094, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(116, 70538, 104, 'Chole Bhature', 1, '65.0000', '65.0000', '', ''),
(115, 22983, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(114, 73934, 120, 'Momos', 1, '60.0000', '60.0000', '', ''),
(113, 91192, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(112, 91192, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(111, 96871, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(110, 96871, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(61, 69117, 94, 'Bhelpuri', 1, '30.0000', '30.0000', '', ''),
(62, 69117, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(63, 69117, 121, 'Fried Rice', 1, '70.0000', '70.0000', '', ''),
(64, 69117, 93, 'Gol-Gappe', 1, '35.0000', '35.0000', '', ''),
(65, 16895, 102, 'Uttpam', 1, '40.0000', '40.0000', '', ''),
(66, 16895, 101, 'Sambhar Vada', 3, '55.0000', '165.0000', '', ''),
(67, 16895, 99, 'Idli', 2, '60.0000', '120.0000', '', ''),
(68, 4241, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(69, 4241, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(70, 30827, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(71, 30827, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(72, 92111, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(73, 92111, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(74, 92111, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(75, 53848, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(76, 53848, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(77, 53848, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(78, 91139, 89, 'Aloo Chaat', 20, '40.0000', '800.0000', '', ''),
(79, 91139, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(80, 91139, 104, 'Chole Bhature', 1, '65.0000', '65.0000', '', ''),
(81, 91139, 97, 'Hot Dog', 2, '35.0000', '70.0000', '', ''),
(82, 58724, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(83, 16641, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(84, 35693, 99, 'Idli', 1, '60.0000', '60.0000', '', ''),
(85, 226, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(86, 60990, 102, 'Uttpam', 1, '40.0000', '40.0000', '', ''),
(87, 60990, 99, 'Idli', 2, '60.0000', '120.0000', '', ''),
(88, 20104, 99, 'Idli', 2, '60.0000', '120.0000', '', ''),
(89, 20104, 108, 'Aloo Paratha', 1, '45.0000', '45.0000', '', ''),
(90, 20104, 102, 'Uttpam', 1, '40.0000', '40.0000', '', ''),
(91, 87316, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(92, 87316, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(93, 51368, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(94, 51368, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(95, 51368, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(96, 8823, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(97, 8823, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(98, 8823, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(99, 78954, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(100, 78954, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(101, 78954, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(102, 28853, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(103, 28853, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(104, 28853, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(105, 44450, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(106, 44450, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(107, 44450, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(108, 19956, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(109, 19956, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(155, 25614, 106, 'Biryani', 1, '80.0000', '80.0000', '', ''),
(156, 25614, 104, 'Chole Bhature', 1, '65.0000', '65.0000', '', ''),
(157, 25614, 108, 'Aloo Paratha', 1, '45.0000', '45.0000', '', ''),
(158, 25614, 101, 'Sambhar Vada', 2, '55.0000', '110.0000', '', ''),
(159, 13081, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(160, 13081, 94, 'Bhelpuri', 1, '30.0000', '30.0000', '', ''),
(161, 13081, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(162, 52668, 97, 'Hot Dog', 1, '35.0000', '35.0000', '', ''),
(163, 52668, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(164, 43384, 95, 'Patty', 1, '14.0000', '14.0000', '', ''),
(165, 43384, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(166, 43384, 93, 'Gol-Gappe', 1, '35.0000', '35.0000', '', ''),
(167, 79895, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(168, 79895, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(169, 72996, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(170, 72996, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(171, 72996, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(172, 39470, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(173, 39470, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(174, 42460, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(175, 54528, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(176, 54528, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(177, 93181, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(178, 93181, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(179, 93181, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(180, 15633, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(181, 15633, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(182, 15633, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(183, 41458, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(184, 41458, 93, 'Gol-Gappe', 1, '35.0000', '35.0000', '', ''),
(185, 41458, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(186, 41458, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(187, 18794, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(188, 18794, 94, 'Bhelpuri', 1, '30.0000', '30.0000', '', ''),
(189, 18794, 91, 'Maggi', 2, '25.0000', '50.0000', '', ''),
(190, 18794, 96, 'Bread Roll', 1, '20.0000', '20.0000', '', ''),
(191, 18794, 93, 'Gol-Gappe', 2, '35.0000', '70.0000', '', ''),
(192, 18794, 95, 'Patty', 1, '14.0000', '14.0000', '', ''),
(193, 18794, 92, 'Kachori', 2, '18.0000', '36.0000', '', ''),
(194, 18794, 97, 'Hot Dog', 1, '35.0000', '35.0000', '', ''),
(195, 90052, 92, 'Kachori', 2, '18.0000', '36.0000', '', ''),
(196, 90052, 95, 'Patty', 1, '14.0000', '14.0000', '', ''),
(197, 90052, 97, 'Hot Dog', 1, '35.0000', '35.0000', '', ''),
(198, 90052, 93, 'Gol-Gappe', 2, '35.0000', '70.0000', '', ''),
(199, 90052, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(200, 90052, 91, 'Maggi', 2, '25.0000', '50.0000', '', ''),
(201, 90052, 94, 'Bhelpuri', 1, '30.0000', '30.0000', '', ''),
(202, 90052, 96, 'Bread Roll', 1, '20.0000', '20.0000', '', ''),
(203, 88866, 99, 'Idli', 4, '60.0000', '240.0000', '', ''),
(204, 4894, 95, 'Patty', 3, '14.0000', '42.0000', '', ''),
(205, 4894, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(206, 4894, 122, 'Manchurian', 1, '80.0000', '80.0000', '', ''),
(207, 4894, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(208, 4894, 94, 'Bhelpuri', 1, '30.0000', '30.0000', '', ''),
(209, 4894, 120, 'Momos', 1, '60.0000', '60.0000', '', ''),
(210, 57632, 89, 'Aloo Chaat', 1, '40.0000', '40.0000', '', ''),
(211, 57632, 91, 'Maggi', 1, '25.0000', '25.0000', '', ''),
(212, 36857, 91, 'Maggi', 2, '25.0000', '50.0000', '', ''),
(213, 36857, 93, 'Gol-Gappe', 2, '35.0000', '70.0000', '', ''),
(214, 36857, 98, 'Burger', 5, '45.0000', '225.0000', '', ''),
(215, 36857, 120, 'Momos', 4, '60.0000', '240.0000', '', ''),
(216, 36857, 97, 'Hot Dog', 3, '35.0000', '105.0000', '', ''),
(217, 36857, 95, 'Patty', 1, '14.0000', '14.0000', '', ''),
(218, 36857, 123, 'Chowmein', 1, '55.0000', '55.0000', '', ''),
(219, 36857, 92, 'Kachori', 1, '18.0000', '18.0000', '', ''),
(220, 47093, 91, 'Maggi', 2, '25.0000', '50.0000', '', ''),
(221, 47093, 93, 'Gol-Gappe', 1, '35.0000', '35.0000', '', ''),
(222, 47093, 96, 'Bread Roll', 1, '20.0000', '20.0000', '', ''),
(223, 47093, 97, 'Hot Dog', 1, '35.0000', '35.0000', '', ''),
(224, 47093, 89, 'Aloo Chaat', 2, '40.0000', '80.0000', '', ''),
(225, 47093, 102, 'Uttpam', 1, '40.0000', '40.0000', '', ''),
(226, 47093, 94, 'Bhelpuri', 1, '30.0000', '30.0000', '', ''),
(227, 47093, 99, 'Idli', 1, '60.0000', '60.0000', '', ''),
(228, 47093, 108, 'Aloo Paratha', 1, '45.0000', '45.0000', '', ''),
(229, 47093, 110, 'Pav-Bhaji', 1, '60.0000', '60.0000', '', ''),
(230, 47093, 105, 'Veg Roll', 1, '60.0000', '60.0000', '', ''),
(231, 47093, 109, 'Bun Omlette', 1, '35.0000', '35.0000', '', ''),
(232, 47093, 101, 'Sambhar Vada', 1, '55.0000', '55.0000', '', ''),
(233, 47093, 107, 'Rajma Chawal', 1, '50.0000', '50.0000', '', ''),
(234, 47093, 95, 'Patty', 1, '14.0000', '14.0000', '', ''),
(235, 47093, 98, 'Burger', 1, '45.0000', '45.0000', '', ''),
(236, 47093, 92, 'Kachori', 2, '18.0000', '36.0000', '', ''),
(237, 47093, 106, 'Biryani', 1, '80.0000', '80.0000', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ti_order_options`
--

CREATE TABLE IF NOT EXISTS `ti_order_options` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `order_option_name` varchar(128) NOT NULL,
  `order_option_price` decimal(15,4) DEFAULT NULL,
  `order_menu_id` int(11) NOT NULL,
  `order_menu_option_id` int(11) NOT NULL,
  `menu_option_value_id` int(11) NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_order_totals`
--

CREATE TABLE IF NOT EXISTS `ti_order_totals` (
  `order_total_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_total_id`,`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_pages`
--

CREATE TABLE IF NOT EXISTS `ti_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `navigation` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ti_pages`
--

INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `navigation`, `date_added`, `date_updated`, `status`) VALUES
(11, 11, 'About Us', 'About Us', 'About Us', '<h3 style="text-align: center;"><span style="color: #993300;">Aim</span></h3>\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis massa ac magna sagittis, sit amet gravida metus gravida. Aenean dictum pellentesque erat, vitae adipiscing libero semper sit amet. Vestibulum nec nunc lorem. Duis vitae libero a libero hendrerit tincidunt in eu tellus. Aliquam consequat ultrices felis ut dictum. Nulla euismod felis a sem mattis ornare. Aliquam ut diam sit amet dolor iaculis molestie ac id nisl. Maecenas hendrerit convallis mi feugiat gravida. Quisque tincidunt, leo a posuere imperdiet, metus leo vestibulum orci, vel volutpat justo ligula id quam. Cras placerat tincidunt lorem eu interdum.</p>\n<h3 style="text-align: center;"><span style="color: #993300;">Mission</span></h3>\n<p>Ut eu pretium urna. In sed consectetur neque. In ornare odio erat, id ornare arcu euismod a. Ut dapibus sit amet erat commodo vestibulum. Praesent vitae lacus faucibus, rhoncus tortor et, bibendum justo. Etiam pharetra congue orci, eget aliquam orci. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend justo eros, sit amet fermentum tellus ullamcorper quis. Cras cursus mi at imperdiet faucibus. Proin iaculis, felis vitae luctus venenatis, ante tortor porta nisi, et ornare magna metus sit amet enim. Phasellus et turpis nec metus aliquet adipiscing. Etiam at augue nec odio lacinia tincidunt. Suspendisse commodo commodo ipsum ac sollicitudin. Nunc nec consequat lacus. Donec gravida rhoncus justo sed elementum.</p>\n<h3 style="text-align: center;"><span style="color: #a52a2a;">Vision</span></h3>\n<p>Praesent erat massa, consequat a nulla et, eleifend facilisis risus. Nullam libero mi, bibendum id eleifend vitae, imperdiet a nulla. Fusce congue porta ultricies. Vivamus felis lectus, egestas at pretium vitae, posuere a nibh. Mauris lobortis urna nec rhoncus consectetur. Fusce sed placerat sem. Nulla venenatis elit risus, non auctor arcu lobortis eleifend. Ut aliquet vitae velit a faucibus. Suspendisse quis risus sit amet arcu varius malesuada. Vestibulum vitae massa consequat, euismod lorem a, euismod lacus. Duis sagittis dolor risus, ac vehicula mauris lacinia quis. Nulla facilisi. Duis tristique ipsum nec egestas auctor. Nullam in felis vel ligula dictum tincidunt nec a neque. Praesent in egestas elit.</p>', '', '', 17, 'a:2:{i:0;s:8:"side_bar";i:1;s:6:"footer";}', '2014-04-19 16:57:21', '2015-05-07 12:39:52', 1),
(12, 11, 'Policy', 'Policy', 'Policy', '<div id="lipsum">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ligula eros, semper a lorem et, venenatis volutpat dolor. Pellentesque hendrerit lectus feugiat nulla cursus, quis dapibus dolor porttitor. Donec velit enim, adipiscing ac orci id, congue tincidunt arcu. Proin egestas nulla eget leo scelerisque, et semper diam ornare. Suspendisse potenti. Suspendisse vitae bibendum enim. Duis eu ligula hendrerit, lacinia felis in, mollis nisi. Sed gravida arcu in laoreet dictum. Nulla faucibus lectus a mollis dapibus. Fusce vehicula convallis urna, et congue nulla ultricies in. Nulla magna velit, bibendum eu odio et, euismod rhoncus sem. Nullam quis magna fermentum, ultricies neque nec, blandit neque. Etiam nec congue arcu. Curabitur sed tellus quam. Cras adipiscing odio odio, et porttitor dui suscipit eget. Aliquam non est commodo, elementum turpis at, pellentesque lorem.</p>\r\n<p>Duis nec diam diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate est et lorem sagittis, et mollis libero ultricies. Nunc ultrices tortor vel convallis varius. In dolor dolor, scelerisque ac faucibus ut, aliquet ac sem. Praesent consectetur lacus quis tristique posuere. Nulla sed ultricies odio. Cras tristique vulputate facilisis.</p>\r\n<p>Mauris at metus in magna condimentum gravida eu tincidunt urna. Praesent sodales vel mi eu condimentum. Suspendisse in luctus purus. Vestibulum dignissim, metus non luctus accumsan, odio ligula pharetra massa, in eleifend turpis risus in diam. Sed non lorem nibh. Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci. Nulla eget quam sit amet risus rhoncus lacinia a ut eros. Praesent non libero nisi. Mauris tincidunt at purus sit amet adipiscing. Donec interdum, velit nec dignissim vehicula, libero ipsum imperdiet ligula, lacinia mattis augue dui ac lacus. Aenean molestie sed nunc at pulvinar. Fusce ornare lacus non venenatis rhoncus.</p>\r\n<p>Aenean at enim luctus ante commodo consequat nec ut mi. Sed porta adipiscing tempus. Aliquam sit amet ullamcorper ipsum, id adipiscing quam. Fusce iaculis odio ut nisi convallis hendrerit. Morbi auctor adipiscing ligula, sit amet aliquet ante consectetur at. Donec vulputate neque eleifend libero pellentesque, vitae lacinia enim ornare. Vestibulum fermentum erat blandit, ultricies felis ac, facilisis augue. Nulla facilisis mi porttitor, interdum diam in, lobortis ipsum. In molestie quam nisl, lacinia convallis tellus fermentum ac. Nulla quis velit augue. Fusce accumsan, lacus et lobortis blandit, neque magna gravida enim, dignissim ultricies tortor dui in dolor. Vestibulum vel convallis justo, quis venenatis elit. Aliquam erat volutpat. Nunc quis iaculis ligula. Suspendisse dictum sodales neque vitae faucibus. Fusce id tellus pretium, varius nunc et, placerat metus.</p>\r\n<p>Pellentesque quis facilisis mauris. Phasellus porta, metus a dignissim viverra, est elit luctus erat, nec ultricies ligula lorem eget sapien. Pellentesque ac justo velit. Maecenas semper accumsan nulla eget rhoncus. Aliquam vel urna sed nibh dignissim auctor. Integer volutpat lacus ac purus convallis, at lobortis nisi tincidunt. Vestibulum condimentum elit ac sapien placerat, at ornare libero hendrerit. Cras tincidunt nunc sit amet ante bibendum tempor. Fusce quam orci, suscipit sed eros quis, vulputate molestie metus. Nam hendrerit vitae felis et porttitor. Proin et commodo velit, id porta erat. Donec eu consectetur odio. Fusce porta odio risus. Aliquam vel erat feugiat, vestibulum elit eget, ornare sapien. Sed sed nulla justo. Sed a dolor eu justo lacinia blandit</p>\r\n</div>', '', '', 17, 'a:2:{i:0;s:8:"side_bar";i:1;s:6:"footer";}', '2014-04-19 17:21:23', '2015-05-16 09:18:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_permalinks`
--

CREATE TABLE IF NOT EXISTS `ti_permalinks` (
  `permalink_id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `query` varchar(255) NOT NULL,
  PRIMARY KEY (`permalink_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `ti_permalinks`
--

INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES
(11, 'about-us', 'pages', 'page_id=11'),
(12, 'vegetarian', 'menus', 'category_id=20'),
(14, 'specials', 'menus', 'category_id=24'),
(18, 'appetizer', 'menus', 'category_id=15'),
(20, 'seafoods', 'menus', 'category_id=18'),
(21, 'traditional', 'menus', 'category_id=19'),
(42, 'annapurna', 'local', 'location_id=11');

-- --------------------------------------------------------

--
-- Table structure for table `ti_permissions`
--

CREATE TABLE IF NOT EXISTS `ti_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `ti_permissions`
--

INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES
(11, 'Admin.Banners', 'Ability to access, manage, add and delete banners', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(12, 'Admin.Categories', 'Ability to access, manage, add and delete categories', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(13, 'Site.Countries', 'Ability to manage, add and delete site countries', 'a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}', 1),
(14, 'Admin.Coupons', 'Ability to access, manage, add and delete coupons', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(15, 'Site.Currencies', 'Ability to access, manage, add and delete site currencies', 'a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}', 1),
(16, 'Admin.CustomerGroups', 'Ability to access, manage, add and delete customer groups', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(17, 'Admin.Customers', 'Ability to access, manage, add and delete customers', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(18, 'Admin.CustomersOnline', 'Ability to access online customers', 'a:1:{i:0;s:6:"access";}', 1),
(19, 'Admin.Maintenance', 'Ability to access, backup, restore and migrate database', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(20, 'Admin.ErrorLogs', 'Ability to access and delete error logs file', 'a:2:{i:0;s:6:"access";i:1;s:6:"delete";}', 1),
(21, 'Admin.Extensions', 'Ability to access, manage, add and delete extension', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(22, 'Admin.MediaManager', 'Ability to access, manage, add and delete media items', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(23, 'Site.Languages', 'Ability to manage, add and delete site languages', 'a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}', 1),
(24, 'Site.Layouts', 'Ability to manage, add and delete site layouts', 'a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}', 1),
(25, 'Admin.Locations', 'Ability to access, manage, add and delete locations', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(26, 'Admin.MailTemplates', 'Ability to access, manage, add and delete mail templates', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(27, 'Admin.MenuOptions', 'Ability to access, manage, add and delete menu option items', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(28, 'Admin.Menus', 'Ability to access, manage, add and delete menu items', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(29, 'Admin.Messages', 'Ability to add and delete messages', 'a:2:{i:0;s:3:"add";i:1;s:6:"delete";}', 1),
(30, 'Admin.Orders', 'Ability to access, manage, add and delete orders', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(31, 'Site.Pages', 'Ability to manage, add and delete site pages', 'a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}', 1),
(32, 'Admin.Payments', 'Ability to access, add and delete extension payments', 'a:3:{i:0;s:6:"access";i:1;s:3:"add";i:2;s:6:"delete";}', 1),
(33, 'Admin.Permissions', 'Ability to manage, add and delete staffs permissions', 'a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}', 1),
(34, 'Admin.Ratings', 'Ability to add and delete review ratings', 'a:2:{i:0;s:3:"add";i:1;s:6:"delete";}', 1),
(35, 'Admin.Reservations', 'Ability to access, manage, add and delete reservations', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(36, 'Admin.Reviews', 'Ability to access, manage, add and delete user reviews', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(37, 'Admin.SecurityQuestions', 'Ability to add and delete customer registration security questions', 'a:2:{i:0;s:3:"add";i:1;s:6:"delete";}', 1),
(38, 'Site.Settings', 'Ability to manage system settings', 'a:1:{i:0;s:6:"manage";}', 1),
(39, 'Admin.StaffGroups', 'Ability to access, manage, add and delete staff groups', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(40, 'Admin.Staffs', 'Ability to access, manage, add and delete staffs', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(42, 'Admin.Statuses', 'Ability to access, manage, add and delete orders and reservations statuses', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(43, 'Admin.Tables', 'Ability to access, manage, add and delete reservations tables', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(44, 'Site.Themes', 'Ability to access, manage site themes', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1),
(45, 'Module.AccountModule', 'Ability to manage account module', 'a:1:{i:0;s:6:"manage";}', 1),
(46, 'Module.BannersModule', 'Ability to manage banners module', 'a:1:{i:0;s:6:"manage";}', 1),
(47, 'Module.CartModule', 'Ability to manage cart module', 'a:1:{i:0;s:6:"manage";}', 1),
(48, 'Module.CategoriesModule', 'Ability to manage categories module', 'a:1:{i:0;s:6:"manage";}', 1),
(49, 'Module.LocalModule', 'Ability to manage local module', 'a:1:{i:0;s:6:"manage";}', 1),
(50, 'Module.PagesModule', 'Ability to manage pages module', 'a:1:{i:0;s:6:"manage";}', 1),
(57, 'Module.ReservationModule', 'Ability to manage reservation module', 'a:1:{i:0;s:6:"manage";}', 1),
(52, 'Module.Slideshow', 'Ability to manage slideshow module', 'a:1:{i:0;s:6:"manage";}', 1),
(53, 'Payment.Cod', 'Ability to manage cash on delivery payment', 'a:1:{i:0;s:6:"manage";}', 1),
(54, 'Payment.PaypalExpress', 'Ability to manage paypal express payment', 'a:1:{i:0;s:6:"manage";}', 1),
(55, 'Site.Updates', 'Ability to apply updates when a new version of TastyIgniter is available', 'a:1:{i:0;s:3:"add";}', 1),
(56, 'Admin.Mealtimes', 'Ability to access, manage, add and delete mealtimes', 'a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_pp_payments`
--

CREATE TABLE IF NOT EXISTS `ti_pp_payments` (
  `transaction_id` varchar(19) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `serialized` text NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ti_reservations`
--

CREATE TABLE IF NOT EXISTS `ti_reservations` (
  `reservation_id` int(32) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `guest_num` int(11) NOT NULL,
  `occasion_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(45) NOT NULL,
  `comment` text NOT NULL,
  `reserve_time` time NOT NULL,
  `reserve_date` date NOT NULL,
  `date_added` date NOT NULL,
  `date_modified` date NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`reservation_id`,`location_id`,`table_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20012 ;

--
-- Dumping data for table `ti_reservations`
--

INSERT INTO `ti_reservations` (`reservation_id`, `location_id`, `table_id`, `guest_num`, `occasion_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `comment`, `reserve_time`, `reserve_date`, `date_added`, `date_modified`, `assignee_id`, `notify`, `ip_address`, `user_agent`, `status`) VALUES
(20011, 11, 7, 2, 0, 15, 'Harshul', 'Singhal', 'harshulsinghal@yahoo.com', '9811553063', '', '12:00:00', '2017-11-17', '2017-11-16', '2017-11-16', 0, 0, '139.59.3.153', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36', 18);

-- --------------------------------------------------------

--
-- Table structure for table `ti_reviews`
--

CREATE TABLE IF NOT EXISTS `ti_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `sale_type` varchar(32) NOT NULL DEFAULT '',
  `author` varchar(32) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `delivery` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `date_added` datetime NOT NULL,
  `review_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`review_id`,`sale_type`,`sale_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `ti_security_questions`
--

CREATE TABLE IF NOT EXISTS `ti_security_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `ti_security_questions`
--

INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES
(11, 'Whats your pets name?', 1),
(12, 'What high school did you attend?', 2),
(13, 'What is your father''s middle name?', 7),
(14, 'What is your mother''s name?', 3),
(15, 'What is your place of birth?', 4),
(16, 'Whats your favourite teacher''s name?', 5);

-- --------------------------------------------------------

--
-- Table structure for table `ti_settings`
--

CREATE TABLE IF NOT EXISTS `ti_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` varchar(45) NOT NULL,
  `item` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `item` (`item`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11063 ;

--
-- Dumping data for table `ti_settings`
--

INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES
(10971, 'prefs', 'default_themes', 'a:2:{s:5:"admin";s:18:"tastyigniter-blue/";s:4:"main";s:20:"tastyigniter-orange/";}', 1),
(7870, 'prefs', 'mail_template_id', '11', 0),
(8500, 'ratings', 'ratings', 'a:1:{s:7:"ratings";a:5:{i:1;s:3:"Bad";i:2;s:5:"Worse";i:3;s:4:"Good";i:4;s:7:"Average";i:5;s:9:"Excellent";}}', 1),
(11032, 'config', 'canceled_reservation_status', '17', 0),
(11052, 'prefs', 'default_location_id', '11', 0),
(11031, 'config', 'confirmed_reservation_status', '16', 0),
(11030, 'config', 'default_reservation_status', '18', 0),
(11029, 'config', 'reservation_mode', '1', 0),
(11028, 'config', 'collection_time', '15', 0),
(11027, 'config', 'delivery_time', '45', 0),
(11026, 'config', 'guest_order', '1', 0),
(11025, 'config', 'invoice_prefix', 'INV-{year}-00', 0),
(11024, 'config', 'auto_invoicing', '0', 0),
(11023, 'config', 'canceled_order_status', '19', 0),
(11022, 'config', 'completed_order_status', 'a:1:{i:0;s:2:"15";}', 1),
(11021, 'config', 'processing_order_status', 'a:3:{i:0;s:2:"12";i:1;s:2:"13";i:2;s:2:"14";}', 1),
(11020, 'config', 'default_order_status', '11', 0),
(11017, 'config', 'location_order', '1', 0),
(11018, 'config', 'allow_reviews', '0', 0),
(11019, 'config', 'approve_reviews', '1', 0),
(11016, 'config', 'future_orders', '0', 0),
(11015, 'config', 'distance_unit', 'mi', 0),
(11014, 'config', 'maps_api_key', '', 0),
(11013, 'config', 'checkout_terms', '0', 0),
(11012, 'config', 'registration_terms', '0', 0),
(11011, 'config', 'show_stock_warning', '1', 0),
(11010, 'config', 'stock_checkout', '0', 0),
(11009, 'config', 'tax_delivery_charge', '0', 0),
(11008, 'config', 'tax_menu_price', '0', 0),
(11007, 'config', 'tax_percentage', '', 0),
(11006, 'config', 'tax_mode', '0', 0),
(11005, 'config', 'special_category_id', '15', 0),
(11004, 'config', 'menu_images_w', '95', 0),
(11003, 'config', 'menu_images_h', '80', 0),
(11002, 'config', 'show_menu_images', '1', 0),
(11001, 'config', 'menus_page_limit', '20', 0),
(11000, 'config', 'meta_keywords', '', 0),
(10994, 'config', 'detect_language', '0', 0),
(10995, 'config', 'language_id', 'english', 0),
(10996, 'config', 'admin_language_id', 'english', 0),
(10997, 'config', 'customer_group_id', '11', 0),
(10998, 'config', 'page_limit', '20', 0),
(10999, 'config', 'meta_description', '', 0),
(10993, 'config', 'accepted_currencies', 'a:1:{i:0;s:2:"98";}', 1),
(10992, 'config', 'auto_update_currency_rates', '1', 0),
(10991, 'config', 'currency_id', '98', 0),
(10990, 'config', 'time_format', '%h:%i %A', 0),
(10989, 'config', 'date_format', '%j%S %F %Y', 0),
(10988, 'config', 'timezone', 'Asia/Kolkata', 0),
(10987, 'config', 'country_id', '99', 0),
(10986, 'config', 'site_logo', 'data/no_photo.png', 0),
(10972, 'prefs', 'ti_setup', 'installed', 0),
(10985, 'config', 'site_email', 'harshulsinghal1997@gmail.com', 0),
(10984, 'config', 'site_name', 'Annapurna-ABB3', 0),
(10980, 'prefs', 'ti_version', '2.1.1', 0),
(10983, 'prefs', 'last_version_check', 'a:2:{s:18:"last_version_check";s:19:"08-10-2017 20:44:10";s:4:"core";N;}', 1),
(11033, 'config', 'reservation_time_interval', '45', 0),
(11034, 'config', 'reservation_stay_time', '60', 0),
(11035, 'config', 'image_manager', 'a:11:{s:8:"max_size";s:3:"300";s:11:"thumb_width";s:3:"320";s:12:"thumb_height";s:3:"220";s:7:"uploads";s:1:"1";s:10:"new_folder";s:1:"1";s:4:"copy";s:1:"1";s:4:"move";s:1:"1";s:6:"rename";s:1:"1";s:6:"delete";s:1:"1";s:15:"transliteration";s:1:"0";s:13:"remember_days";s:1:"7";}', 1),
(11036, 'config', 'registration_email', 'a:1:{i:0;s:8:"customer";}', 1),
(11037, 'config', 'order_email', 'a:1:{i:0;s:8:"customer";}', 1),
(11038, 'config', 'reservation_email', 'a:1:{i:0;s:8:"customer";}', 1),
(11039, 'config', 'protocol', 'mail', 0),
(11040, 'config', 'smtp_host', '', 0),
(11041, 'config', 'smtp_port', '', 0),
(11042, 'config', 'smtp_user', '', 0),
(11043, 'config', 'smtp_pass', '', 0),
(11044, 'config', 'customer_online_time_out', '120', 0),
(11045, 'config', 'customer_online_archive_time_out', '0', 0),
(11046, 'config', 'permalink', '1', 0),
(11047, 'config', 'maintenance_mode', '0', 0),
(11048, 'config', 'maintenance_message', 'Site is under maintenance. Please check back later.', 0),
(11049, 'config', 'cache_mode', '0', 0),
(11050, 'config', 'cache_time', '0', 0),
(11062, 'prefs', 'main_address', 'a:14:{s:11:"location_id";s:2:"11";s:13:"location_name";s:14:"Annapurna Cafe";s:9:"address_1";s:24:"ABB3, Ground Floor, JIIT";s:9:"address_2";s:22:"A-10, Sector-63, Noida";s:4:"city";s:5:"Noida";s:5:"state";s:13:"Uttar Pradesh";s:8:"postcode";s:6:"201309";s:10:"country_id";s:2:"99";s:7:"country";s:5:"India";s:10:"iso_code_2";s:2:"IN";s:10:"iso_code_3";s:3:"IND";s:12:"location_lat";s:9:"51.544060";s:12:"location_lng";s:9:"-0.053999";s:6:"format";s:0:"";}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_staffs`
--

CREATE TABLE IF NOT EXISTS `ti_staffs` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(32) NOT NULL,
  `staff_email` varchar(96) NOT NULL,
  `staff_group_id` int(11) NOT NULL,
  `staff_location_id` int(11) NOT NULL,
  `timezone` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `staff_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `staff_email` (`staff_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ti_staffs`
--

INSERT INTO `ti_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_group_id`, `staff_location_id`, `timezone`, `language_id`, `date_added`, `staff_status`) VALUES
(11, 'harshul', 'harshulsinghal1997@gmail.com', 11, 0, '0', 11, '2017-08-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_staff_groups`
--

CREATE TABLE IF NOT EXISTS `ti_staff_groups` (
  `staff_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_group_name` varchar(32) NOT NULL,
  `customer_account_access` tinyint(4) NOT NULL,
  `location_access` tinyint(1) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`staff_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ti_staff_groups`
--

INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `customer_account_access`, `location_access`, `permissions`) VALUES
(11, 'Administrator', 1, 0, 'a:47:{i:11;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:12;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:13;a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}i:14;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:15;a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}i:16;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:17;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:18;a:1:{i:0;s:6:"access";}i:19;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:20;a:2:{i:0;s:6:"access";i:1;s:6:"delete";}i:21;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:22;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:25;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:26;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:27;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:28;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:29;a:2:{i:0;s:3:"add";i:1;s:6:"delete";}i:30;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:32;a:3:{i:0;s:6:"access";i:1;s:3:"add";i:2;s:6:"delete";}i:33;a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}i:34;a:2:{i:0;s:3:"add";i:1;s:6:"delete";}i:35;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:36;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:37;a:2:{i:0;s:3:"add";i:1;s:6:"delete";}i:39;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:40;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:41;a:2:{i:0;s:6:"access";i:1;s:6:"manage";}i:42;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:43;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:23;a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}i:24;a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}i:31;a:3:{i:0;s:6:"manage";i:1;s:3:"add";i:2;s:6:"delete";}i:38;a:1:{i:0;s:6:"manage";}i:44;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:45;a:1:{i:0;s:6:"manage";}i:46;a:1:{i:0;s:6:"manage";}i:47;a:1:{i:0;s:6:"manage";}i:48;a:1:{i:0;s:6:"manage";}i:49;a:1:{i:0;s:6:"manage";}i:50;a:1:{i:0;s:6:"manage";}i:51;a:1:{i:0;s:6:"manage";}i:52;a:1:{i:0;s:6:"manage";}i:53;a:1:{i:0;s:6:"manage";}i:54;a:1:{i:0;s:6:"manage";}i:55;a:1:{i:0;s:3:"add";}i:56;a:4:{i:0;s:6:"access";i:1;s:6:"manage";i:2;s:3:"add";i:3;s:6:"delete";}i:57;a:1:{i:0;s:6:"manage";}}');

-- --------------------------------------------------------

--
-- Table structure for table `ti_statuses`
--

CREATE TABLE IF NOT EXISTS `ti_statuses` (
  `status_id` int(15) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) NOT NULL,
  `status_comment` text NOT NULL,
  `notify_customer` tinyint(1) NOT NULL,
  `status_for` varchar(10) NOT NULL,
  `status_color` varchar(32) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `ti_statuses`
--

INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES
(11, 'Received', 'Your order has been received.', 1, 'order', '#686663'),
(12, 'Pending', 'Your order is pending', 1, 'order', '#f0ad4e'),
(13, 'Preparation', 'Your order is in the kitchen', 1, 'order', '#00c0ef'),
(14, 'Delivery', 'Your order will be with you shortly.', 0, 'order', '#00a65a'),
(15, 'Completed', '', 0, 'order', '#00a65a'),
(16, 'Confirmed', 'Your table reservation has been confirmed.', 0, 'reserve', '#00a65a'),
(17, 'Canceled', 'Your table reservation has been canceled.', 0, 'reserve', '#dd4b39'),
(18, 'Pending', 'Your table reservation is pending.', 0, 'reserve', ''),
(19, 'Canceled', '', 0, 'order', '#ea0b29');

-- --------------------------------------------------------

--
-- Table structure for table `ti_status_history`
--

CREATE TABLE IF NOT EXISTS `ti_status_history` (
  `status_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `status_for` varchar(32) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`status_history_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `ti_status_history`
--

INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES
(11, 20011, 0, 0, 18, 0, 'reserve', 'Your table reservation is pending.', '2017-11-16 23:48:23'),
(12, 5920, 0, 0, 15, 0, 'order', '', '2017-11-25 13:22:16'),
(13, 96881, 0, 0, 15, 0, 'order', '', '2017-11-27 08:47:18'),
(14, 96881, 0, 0, 15, 0, 'order', '', '2017-11-27 08:50:36'),
(15, 96881, 0, 0, 15, 0, 'order', '', '2017-11-27 08:51:56'),
(16, 81293, 0, 0, 15, 0, 'order', '', '2017-11-27 08:55:45'),
(17, 16739, 0, 0, 15, 0, 'order', '', '2017-11-27 14:27:26'),
(18, 16739, 0, 0, 15, 0, 'order', '', '2017-11-27 08:57:33'),
(19, 72265, 0, 0, 15, 0, 'order', '', '2017-11-27 15:38:51'),
(20, 0, 0, 0, 15, 0, 'order', '', '2017-11-27 15:38:52'),
(21, 69117, 0, 0, 15, 0, 'order', '', '2017-11-27 20:47:50'),
(22, 16895, 0, 0, 15, 0, 'order', '', '2017-11-27 20:50:15'),
(23, 86212, 0, 0, 15, 0, 'order', '', '2017-11-27 21:15:51'),
(24, 50813, 0, 0, 15, 0, 'order', '', '2017-11-27 21:17:46'),
(25, 5940, 0, 0, 15, 0, 'order', '', '2017-11-27 21:18:58'),
(26, 86859, 0, 0, 15, 0, 'order', '', '2017-11-27 21:20:56'),
(27, 91838, 0, 0, 15, 0, 'order', '', '2017-11-27 21:21:03'),
(28, 55951, 0, 0, 15, 0, 'order', '', '2017-11-27 21:22:28'),
(29, 30827, 0, 0, 15, 0, 'order', '', '2017-11-29 07:56:57'),
(30, 92111, 0, 0, 15, 0, 'order', '', '2017-11-29 08:05:33'),
(31, 89496, 0, 0, 15, 0, 'order', '', '2017-11-30 13:17:50'),
(32, 53848, 0, 0, 15, 0, 'order', '', '2017-11-30 13:19:35'),
(33, 91139, 0, 0, 15, 0, 'order', '', '2017-11-30 13:22:48'),
(34, 58724, 0, 0, 15, 0, 'order', '', '2017-11-30 13:41:18'),
(35, 0, 0, 0, 15, 0, 'order', '', '2017-11-30 13:41:19'),
(36, 16641, 0, 0, 15, 0, 'order', '', '2017-11-30 13:48:46'),
(37, 66949, 0, 0, 15, 0, 'order', '', '2017-11-30 13:51:00'),
(38, 35693, 0, 0, 15, 0, 'order', '', '2017-11-30 13:51:33'),
(39, 80156, 0, 0, 15, 0, 'order', '', '2017-11-30 13:52:26'),
(40, 226, 0, 0, 15, 0, 'order', '', '2017-11-30 13:52:58'),
(41, 60990, 0, 0, 15, 0, 'order', '', '2017-11-30 14:14:04'),
(42, 20104, 0, 0, 15, 0, 'order', '', '2017-11-30 14:21:35'),
(43, 87316, 0, 0, 15, 0, 'order', '', '2017-11-30 17:07:14'),
(44, 8823, 0, 0, 15, 0, 'order', '', '2017-11-30 17:24:08'),
(45, 78954, 0, 0, 15, 0, 'order', '', '2017-11-30 17:25:53'),
(46, 28853, 0, 0, 15, 0, 'order', '', '2017-11-30 17:28:03'),
(47, 44450, 0, 0, 15, 0, 'order', '', '2017-11-30 17:33:38'),
(48, 44450, 0, 0, 15, 0, 'order', '', '2017-11-30 17:33:38'),
(49, 19956, 0, 0, 15, 0, 'order', '', '2017-11-30 17:35:40'),
(50, 91192, 0, 0, 15, 0, 'order', '', '2017-11-30 17:49:31'),
(51, 73934, 0, 0, 15, 0, 'order', '', '2017-11-30 18:13:29'),
(52, 22983, 0, 0, 15, 0, 'order', '', '2017-11-30 18:23:15'),
(53, 70538, 0, 0, 15, 0, 'order', '', '2017-11-30 18:29:11'),
(54, 95094, 0, 0, 15, 0, 'order', '', '2017-11-30 19:00:23'),
(55, 16874, 0, 0, 15, 0, 'order', '', '2017-11-30 19:09:34'),
(56, 20836, 0, 0, 15, 0, 'order', '', '2017-11-30 19:14:17'),
(57, 14321, 0, 0, 15, 0, 'order', '', '2017-11-30 19:18:22'),
(58, 25614, 0, 0, 15, 0, 'order', '', '2017-11-30 19:29:05'),
(59, 13081, 0, 0, 15, 0, 'order', '', '2017-11-30 20:00:44'),
(60, 52668, 0, 0, 15, 0, 'order', '', '2017-11-30 20:03:10'),
(61, 43384, 0, 0, 15, 0, 'order', '', '2017-11-30 20:12:29'),
(62, 72996, 0, 0, 15, 0, 'order', '', '2017-11-30 20:15:43'),
(63, 42460, 0, 0, 15, 0, 'order', '', '2017-11-30 20:22:32'),
(64, 54528, 0, 0, 15, 0, 'order', '', '2017-11-30 20:47:10'),
(65, 15633, 0, 0, 15, 0, 'order', '', '2017-11-30 20:55:57'),
(66, 41458, 0, 0, 15, 0, 'order', '', '2017-11-30 20:58:45'),
(67, 18794, 0, 0, 15, 0, 'order', '', '2017-11-30 22:10:44'),
(68, 4894, 0, 0, 15, 0, 'order', '', '2017-11-30 23:18:37'),
(69, 57632, 0, 0, 15, 0, 'order', '', '2017-12-01 02:44:32'),
(70, 36857, 0, 0, 15, 0, 'order', '', '2017-12-01 05:31:20'),
(71, 47093, 0, 0, 15, 0, 'order', '', '2017-12-01 05:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `ti_tables`
--

CREATE TABLE IF NOT EXISTS `ti_tables` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(32) NOT NULL,
  `min_capacity` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `table_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `ti_tables`
--

INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES
(1, 'EE10', 2, 10, 1),
(2, 'NN02', 2, 4, 1),
(6, 'SW77', 10, 40, 1),
(7, 'EW77', 2, 8, 1),
(8, 'SE78', 4, 6, 1),
(9, 'NE8', 8, 10, 1),
(10, 'SW55', 9, 10, 1),
(11, 'EW88', 2, 10, 0),
(12, 'EE732', 3, 6, 1),
(14, 'FW79', 4, 10, 0),
(16, 'SSW77', 10, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ti_uri_routes`
--

CREATE TABLE IF NOT EXISTS `ti_uri_routes` (
  `uri_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `uri_route` varchar(255) NOT NULL,
  `controller` varchar(128) NOT NULL,
  `priority` tinyint(11) NOT NULL,
  PRIMARY KEY (`uri_route_id`,`uri_route`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ti_uri_routes`
--

INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES
(1, 'locations', 'local/locations', 1),
(2, 'account', 'account/account', 2),
(3, '(:any)', 'pages', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ti_users`
--

CREATE TABLE IF NOT EXISTS `ti_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  PRIMARY KEY (`user_id`,`staff_id`,`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ti_users`
--

INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES
(11, 11, 'harshul', 'c6551a2e9ae08055613d1309d52a2453cd05bcb1', 'd98d2c719');

-- --------------------------------------------------------

--
-- Table structure for table `ti_working_hours`
--

CREATE TABLE IF NOT EXISTS `ti_working_hours` (
  `location_id` int(11) NOT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time NOT NULL DEFAULT '00:00:00',
  `closing_time` time NOT NULL DEFAULT '00:00:00',
  `status` tinyint(1) NOT NULL,
  `type` varchar(32) NOT NULL,
  PRIMARY KEY (`location_id`,`weekday`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ti_working_hours`
--

INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`, `type`) VALUES
(11, 6, '09:00:00', '23:00:00', 1, 'collection'),
(11, 5, '09:00:00', '23:00:00', 1, 'collection'),
(11, 4, '09:00:00', '23:00:00', 1, 'collection'),
(11, 3, '09:00:00', '23:00:00', 1, 'collection'),
(11, 2, '09:00:00', '23:00:00', 1, 'collection'),
(11, 1, '09:00:00', '23:00:00', 1, 'collection'),
(11, 0, '09:00:00', '23:00:00', 1, 'collection'),
(11, 6, '09:00:00', '23:00:00', 1, 'delivery'),
(11, 5, '09:00:00', '23:00:00', 1, 'delivery'),
(11, 4, '09:00:00', '23:00:00', 1, 'delivery'),
(11, 3, '09:00:00', '23:00:00', 1, 'delivery'),
(11, 2, '09:00:00', '23:00:00', 1, 'delivery'),
(11, 1, '09:00:00', '23:00:00', 1, 'delivery'),
(11, 0, '09:00:00', '23:00:00', 1, 'delivery'),
(11, 6, '09:00:00', '23:00:00', 1, 'opening'),
(11, 5, '09:00:00', '23:00:00', 1, 'opening'),
(11, 4, '09:00:00', '23:00:00', 1, 'opening'),
(11, 3, '09:00:00', '23:00:00', 1, 'opening'),
(11, 2, '09:00:00', '23:00:00', 1, 'opening'),
(11, 1, '09:00:00', '23:00:00', 1, 'opening'),
(11, 0, '09:00:00', '23:00:00', 1, 'opening');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
