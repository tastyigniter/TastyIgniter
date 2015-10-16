# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.42)
# Database: tastyigniter_2_0
# Generation Time: 2015-07-24 8:52:17 am +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ti_activities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_activities`;

CREATE TABLE `ti_activities` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_activities` WRITE;
/*!40000 ALTER TABLE `ti_activities` DISABLE KEYS */;

INSERT INTO `ti_activities` (`activity_id`, `domain`, `context`, `user`, `user_id`, `action`, `message`, `status`, `date_added`)
VALUES
	(11,'admin','customers','11',0,'updated','Admin updated <a href=\"http://tastyigniter.remote/admin/customers/edit\">1</a>details',0,'2015-06-04 23:25:12'),
	(12,'admin','customers','11',0,'updated','Admin updated <a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam</a>details',0,'2015-06-04 23:30:05'),
	(13,'admin','customers','11',0,'updated','Admin updated customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam</a>details',0,'2015-06-04 23:31:04'),
	(14,'admin','customers','11',0,'updated','Admin updated customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam</a>',0,'2015-06-04 23:34:19'),
	(15,'admin','customers','staff',11,'updated','Admin updated customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam</a>',0,'2015-06-04 23:35:58'),
	(16,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/customers/edit?id=1\">Sam Poyigi</a> updated their account details ',0,'2015-06-05 00:08:42'),
	(17,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> updated their account details ',0,'2015-06-05 00:48:13'),
	(18,'main','customers','staff',3,'registered','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=3\">Samuel</a> registered an account.',0,'2015-06-05 01:53:02'),
	(19,'main','customers','staff',4,'registered','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=4\">Samuel Adepoyigi</a> registered an account.',0,'2015-06-05 01:54:44'),
	(20,'admin','customers','staff',11,'added','Admin added customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla</a>',0,'2015-06-05 02:40:48'),
	(21,'admin','customers','staff',11,'updated','Admin updated customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a>',0,'2015-06-05 02:42:56'),
	(22,'admin','customers','staff',11,'registered','Admin updated coupon <a href=\"http://tastyigniter.remote/admin/coupons/edit?id=14\">Full Tuesdays</a>.',0,'2015-06-05 02:44:00'),
	(23,'admin','customers','staff',11,'updated','<b>Admin</b> updated customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=4\"><b>Samuel Adepoyigi</b></a>.',0,'2015-06-05 14:03:38'),
	(24,'admin','customers','staff',11,'updated','Admin <b>updated</b> customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=4\"><b>Samuel Adepoyigi</b></a>.',0,'2015-06-05 14:50:45'),
	(25,'admin','coupons','staff',11,'updated','Admin <b>updated</b> coupon <a href=\"http://tastyigniter.remote/admin/coupons/edit?id=14\"><b>Full Tuesdays</b></a>.',0,'2015-06-05 14:50:55'),
	(26,'admin','coupons','staff',11,'added','Admin <b>added</b> coupon <a href=\"http://tastyigniter.remote/admin/coupons/edit?id=16\"><b>Full Tuesdays</b></a>.',0,'2015-06-05 14:51:09'),
	(27,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\"><b>Sam Poyigi</b></a> updated their account details.',0,'2015-06-05 14:53:37'),
	(28,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\"><b>Sam Poyigi</b></a> changed their account password.',0,'2015-06-05 14:53:37'),
	(29,'admin','staffs','staff',12,'updated their','Iana <b>updated their</b> staff <b>details.</b>',0,'2015-06-05 16:37:45'),
	(30,'admin','staffs','staff',12,'updated their','Iana <b>updated their</b> staff <b>details.</b>',0,'2015-06-05 16:37:58'),
	(31,'admin','staffs','staff',11,'updated','Admin <b>updated</b> staff <a href=\"http://tastyigniter.remote/admin/staffs/edit?id=13\"><b>sam.</b></a>',0,'2015-06-05 16:39:55'),
	(32,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-05 21:00:08'),
	(33,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\"> </a> <b>logged</b> in.',0,'2015-06-05 21:00:31'),
	(34,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-05 21:05:30'),
	(35,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-05 21:05:40'),
	(36,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>updated</b> their <b>account details.</b>',0,'2015-06-05 21:16:14'),
	(37,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>changed</b> their <b>account password.</b>',0,'2015-06-05 21:16:14'),
	(38,'admin','staffs','staff',12,'logged in','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=12\">Iana</a> <b>logged</b> in.',0,'2015-06-05 21:48:43'),
	(39,'admin','staffs','staff',12,'logged out','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=12\">Iana</a> <b>logged</b> out.',0,'2015-06-05 21:48:43'),
	(40,'admin','staffs','staff',12,'logged in','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=12\">Iana</a> <b>logged</b> in.',0,'2015-06-05 21:48:47'),
	(41,'admin','staffs','staff',12,'logged out','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=12\">Iana</a> <b>logged</b> out.',0,'2015-06-05 21:48:55'),
	(42,'admin','staffs','staff',12,'logged in','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=12\">Iana</a> <b>logged</b> in.',0,'2015-06-05 21:48:58'),
	(43,'admin','coupons','staff',12,'updated','Iana <b>updated</b> coupon <a href=\"http://tastyigniter.remote/admin/coupons/edit?id=16\"><b>Full Tuesdays.</b></a>',0,'2015-06-05 23:58:53'),
	(44,'admin','customers','staff',12,'updated','Iana <b>updated</b> customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=3\"><b>Samuel Adepoyigi.</b></a>',0,'2015-06-06 00:00:08'),
	(45,'admin','extensions','staff',12,'uninstalled','Iana <b>uninstalled</b> extension module <b>reservation_module.</b>',0,'2015-06-06 00:01:50'),
	(46,'admin','extensions','staff',12,'installed','Iana <b>installed</b> extension module <b>reservation_module.</b>',0,'2015-06-06 00:07:13'),
	(47,'admin','extensions','staff',12,'uploaded','Iana <b>uploaded</b> extension <b>slideevent.zip.</b>',0,'2015-06-06 00:09:09'),
	(48,'admin','extensions','staff',12,'installed','Iana <b>installed</b> extension module <b>slideevent.</b>',0,'2015-06-06 00:25:39'),
	(49,'admin','extensions','staff',12,'uninstalled','Iana <b>uninstalled</b> extension module <b>slideevent.</b>',0,'2015-06-06 00:26:26'),
	(50,'admin','locations','staff',12,'updated','Iana <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-06 00:43:24'),
	(51,'admin','locations','staff',12,'added','Iana <b>added</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=12\"><b>Lewisham.</b></a>',0,'2015-06-06 00:43:35'),
	(52,'admin','menus','staff',12,'updated','Iana <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=76\"><b>PUFF-PUFF.</b></a>',0,'2015-06-06 00:45:00'),
	(53,'admin','menus','staff',12,'added','Iana <b>added</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=88\"><b>PUFF-PUFF.</b></a>',0,'2015-06-06 00:45:14'),
	(54,'admin','orders','staff',12,'updated','Iana <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>20002.</b></a>',0,'2015-06-06 00:45:49'),
	(55,'admin','orders','staff',12,'assigned','Iana <b>assigned</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>20002.</b></a> to <b>11.</b>',0,'2015-06-06 00:45:49'),
	(56,'admin','orders','staff',12,'updated','Iana <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-06 00:47:09'),
	(57,'admin','orders','staff',12,'assigned','Iana <b>assigned</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>20002</b></a> to <b>#13.</b>',0,'2015-06-06 00:47:09'),
	(58,'admin','coupons','staff',11,'updated','Admin <b>updated</b> coupon <a href=\"http://tastyigniter.remote/admin/coupons/edit?id=14\"><b>Full Tuesdays.</b></a>',0,'2015-06-06 00:47:57'),
	(59,'admin','extensions','staff',12,'uninstalled','Iana <b>uninstalled</b> extension payment <b>paypal_express.</b>',0,'2015-06-06 00:48:59'),
	(60,'admin','extensions','staff',12,'installed','Iana <b>installed</b> extension payment <b>paypal_express.</b>',0,'2015-06-06 00:51:47'),
	(61,'admin','permissions','staff',12,'updated','Iana <b>updated</b> permission <b>Admin.Categories.</b>',0,'2015-06-06 00:52:18'),
	(62,'admin','reviews','staff',12,'updated','Iana <b>updated</b> review <a href=\"http://tastyigniter.remote/admin/reviews/edit?id=1\"><b>1.</b></a>',0,'2015-06-06 00:53:10'),
	(63,'admin','staffs','staff',12,'updated','Iana <b>updated</b> staff <a href=\"http://tastyigniter.remote/admin/staffs/edit?id=13\"><b>Sam.</b></a>',0,'2015-06-06 00:53:50'),
	(64,'admin','staffs','staff',12,'updated their','Iana <b>updated their</b> staff <b>details.</b>',0,'2015-06-06 00:54:06'),
	(65,'admin','menus','staff',11,'updated','Admin <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=76\"><b>PUFF-PUFF.</b></a>',0,'2015-06-08 20:20:41'),
	(66,'admin','menus','staff',11,'updated','Admin <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=76\"><b>PUFF-PUFF.</b></a>',0,'2015-06-08 20:21:37'),
	(67,'admin','tables','staff',11,'added','Admin <b>added</b> table <a href=\"http://tastyigniter.remote/admin/tables/edit\"><b>EE10.</b></a>',0,'2015-06-09 00:38:06'),
	(68,'admin','tables','staff',11,'updated','Admin <b>updated</b> table <a href=\"http://tastyigniter.remote/admin/tables/edit?id=1\"><b>EE10.</b></a>',0,'2015-06-09 00:38:09'),
	(69,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:41:40'),
	(70,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:41:46'),
	(71,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:42:11'),
	(72,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:54:19'),
	(73,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:54:34'),
	(74,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:56:12'),
	(75,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:56:21'),
	(76,'admin','orders','staff',11,'updated','Admin <b>updated</b> order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20002\"><b>#20002.</b></a>',0,'2015-06-09 09:56:28'),
	(77,'admin','reservations','staff',11,'updated','Admin <b>updated</b> reservation <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2446\"><b>2446.</b></a>',0,'2015-06-09 10:57:16'),
	(78,'admin','reservations','staff',11,'updated','Admin <b>updated</b> reservation <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2446\"><b>2446.</b></a>',0,'2015-06-09 10:57:23'),
	(79,'admin','reservations','staff',11,'updated','Admin <b>updated</b> reservation <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2446\"><b>2446.</b></a>',0,'2015-06-09 11:00:52'),
	(80,'admin','coupons','staff',11,'Updated','Admin <b>Updated</b> coupon <a href=\"http://tastyigniter.remote/admin/coupons/edit?id=15\"><b>Full Wednesdays.</b></a>',0,'2015-06-09 11:56:32'),
	(81,'admin','reviews','staff',11,'Updated','Admin <b>Updated</b> review <a href=\"http://tastyigniter.remote/admin/reviews/edit?id=1\"><b>1.</b></a>',0,'2015-06-09 13:15:46'),
	(82,'admin','customers','staff',11,'Updated','Admin <b>Updated</b> customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=2\"><b>Samuel Adepoyigi.</b></a>',0,'2015-06-09 14:26:09'),
	(83,'admin','permissions','staff',11,'updated','Admin <b>updated</b> permission <b>Admin.Banners.</b>',0,'2015-06-10 17:44:46'),
	(84,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-11 10:50:10'),
	(85,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-11 15:04:21'),
	(86,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-12 01:46:29'),
	(87,'admin','staffs','staff',12,'logged in','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=12\">Iana</a> <b>logged</b> in.',0,'2015-06-12 11:46:12'),
	(88,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 00:50:01'),
	(89,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 01:22:58'),
	(90,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 01:37:28'),
	(91,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 01:37:45'),
	(92,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 01:40:40'),
	(93,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 01:43:20'),
	(94,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 02:02:28'),
	(95,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-13 02:03:39'),
	(96,'admin','extensions','staff',11,'uninstalled','Admin <b>uninstalled</b> extension payment <b>cod.</b>',0,'2015-06-13 02:07:27'),
	(97,'admin','extensions','staff',11,'installed','Admin <b>installed</b> extension payment <b>cod.</b>',0,'2015-06-13 02:07:38'),
	(98,'admin','menus','staff',11,'updated','Admin <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=81\"><b>Whole catfish with rice and vegetables.</b></a>',0,'2015-06-13 21:08:30'),
	(99,'admin','menus','staff',11,'updated','Admin <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=81\"><b>Whole catfish with rice and vegetables.</b></a>',0,'2015-06-13 21:35:24'),
	(100,'admin','menus','staff',11,'updated','Admin <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=77\"><b>SCOTCH EGG.</b></a>',0,'2015-06-13 22:41:48'),
	(101,'admin','menus','staff',11,'updated','Admin <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=77\"><b>SCOTCH EGG.</b></a>',0,'2015-06-13 22:45:03'),
	(102,'admin','menus','staff',11,'updated','Admin <b>updated</b> menu item <a href=\"http://tastyigniter.remote/admin/menus/edit?id=77\"><b>SCOTCH EGG.</b></a>',0,'2015-06-13 22:54:44'),
	(103,'admin','locations','staff',11,'added','Admin <b>added</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=12\"><b>Hackney\'s Branch.</b></a>',0,'2015-06-14 01:08:30'),
	(104,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=12\"><b>Hackney\'s Branch.</b></a>',0,'2015-06-14 01:59:15'),
	(105,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-14 02:00:56'),
	(106,'module','extensions','customer',11,'updated','Admin <b>updated</b> extension payment <b>Cash On Delivery.</b>',0,'2015-06-15 01:17:04'),
	(107,'main','orders','customer',1,'created','Sam Poyigi <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20004\"><b>#20004.</b></a>',0,'2015-06-15 01:33:12'),
	(108,'main','orders','customer',1,'created','Sam Poyigi <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20005\"><b>#20005.</b></a>',0,'2015-06-15 01:59:22'),
	(109,'main','orders','customer',1,'created','Sam Poyigi <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20006\"><b>#20006.</b></a>',0,'2015-06-15 02:09:07'),
	(110,'main','orders','customer',1,'created','Sam Poyigi <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20007\"><b>#20007.</b></a>',0,'2015-06-15 02:15:46'),
	(111,'main','orders','customer',1,'created','Sam Poyigi <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20008\"><b>#20008.</b></a>',0,'2015-06-15 02:22:06'),
	(112,'module','extensions','customer',11,'updated','Admin <b>updated</b> extension payment <b>Cash On Delivery.</b>',0,'2015-06-15 14:28:36'),
	(113,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-06-15 15:57:18'),
	(114,'main','orders','customer',5,'created','Nulla Ipsum <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20011\"><b>#20011.</b></a>',0,'2015-06-15 15:57:54'),
	(115,'admin','locations','staff',11,'added','Admin <b>added</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 16:01:27'),
	(116,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 16:03:23'),
	(117,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 16:23:18'),
	(118,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 16:24:08'),
	(119,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 16:24:32'),
	(120,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:38:17'),
	(121,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:40:02'),
	(122,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:42:14'),
	(123,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:42:41'),
	(124,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:42:58'),
	(125,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:45:32'),
	(126,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:51:18'),
	(127,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:51:34'),
	(128,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 17:59:50'),
	(129,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-15 18:04:44'),
	(130,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=12\"><b>Hackney\'s Branch.</b></a>',0,'2015-06-15 18:04:50'),
	(131,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=12\"><b>Hackney\'s Branch.</b></a>',0,'2015-06-15 18:09:26'),
	(132,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=12\"><b>Hackney\'s Branch.</b></a>',0,'2015-06-15 18:09:46'),
	(133,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=12\"><b>Hackney\'s Branch.</b></a>',0,'2015-06-15 18:30:52'),
	(134,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=13\"><b>Earling Closed.</b></a>',0,'2015-06-15 21:06:36'),
	(135,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-16 19:44:09'),
	(136,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-16 19:47:46'),
	(137,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-16 19:47:50'),
	(138,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-16 21:19:27'),
	(139,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>updated</b> their <b>account details.</b>',0,'2015-06-16 21:31:04'),
	(140,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>updated</b> their <b>account details.</b>',0,'2015-06-16 21:31:43'),
	(141,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>updated</b> their <b>account details.</b>',0,'2015-06-16 21:32:28'),
	(142,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>updated</b> their <b>account details.</b>',0,'2015-06-16 21:32:49'),
	(143,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>updated</b> their <b>account details.</b>',0,'2015-06-16 21:33:09'),
	(144,'main','customers','customer',1,'updated','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>updated</b> their <b>account details.</b>',0,'2015-06-16 21:33:40'),
	(145,'admin','reviews','staff',11,'updated','Admin <b>updated</b> review <a href=\"http://tastyigniter.remote/admin/reviews/edit?id=2\"><b>2.</b></a>',0,'2015-06-16 22:36:25'),
	(146,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-16 22:42:32'),
	(147,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-17 10:08:13'),
	(148,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-18 22:15:09'),
	(149,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-22 11:55:43'),
	(150,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-23 00:01:56'),
	(151,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-06-23 00:02:04'),
	(152,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-23 19:10:13'),
	(153,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-23 19:11:16'),
	(154,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-23 19:43:32'),
	(155,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-23 19:43:37'),
	(156,'main','customers','customer',1,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> in.',0,'2015-06-24 00:26:28'),
	(157,'main','reservations','customer',1,'reserved','Sam Poyigi made a new <b>reservation</b> <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2447\"><b>#2447.</b></a>',0,'2015-06-24 00:45:07'),
	(158,'main','reservations','customer',1,'reserved','Sam Poyigi made a new <b>reservation</b> <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2448\"><b>#2448.</b></a>',0,'2015-06-24 00:51:00'),
	(159,'main','reservations','customer',1,'reserved','Sam Poyigi made a new <b>reservation</b> <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2449\"><b>#2449.</b></a>',0,'2015-06-24 01:27:52'),
	(160,'main','reservations','customer',1,'reserved','Sam Poyigi made a new <b>reservation</b> <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2450\"><b>#2450.</b></a>',0,'2015-06-24 01:56:29'),
	(161,'main','reservations','customer',1,'reserved','Sam Poyigi made a new <b>reservation</b> <a href=\"http://tastyigniter.remote/admin/reservations/edit?id=2451\"><b>#2451.</b></a>',0,'2015-06-24 01:58:24'),
	(162,'main','customers','customer',1,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=1\">Sam Poyigi</a> <b>logged</b> out.',0,'2015-06-24 19:58:39'),
	(163,'admin','staffs','staff',13,'logged in','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=13\">Sam</a> <b>logged</b> in.',0,'2015-06-30 09:48:58'),
	(164,'admin','staffs','staff',11,'logged in','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=11\">Admin</a> <b>logged</b> in.',0,'2015-06-30 11:23:49'),
	(165,'admin','staffs','staff',11,'logged in','<a href=\"http://tastyigniter.remote/admin/staffs/edit?id=11\">Admin</a> <b>logged</b> in.',0,'2015-07-12 11:02:07'),
	(166,'admin','customers','staff',11,'updated','Admin <b>updated</b> customer <a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\"><b>Nulla Ipsum.</b></a>',0,'2015-07-12 13:34:43'),
	(167,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-12 13:35:38'),
	(168,'main','orders','customer',5,'created','Nulla Ipsum <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20012\"><b>#20012.</b></a>',0,'2015-07-12 23:03:10'),
	(169,'admin','locations','staff',11,'updated','Admin <b>updated</b> location <a href=\"http://tastyigniter.remote/admin/locations/edit?id=11\"><b>Lewisham.</b></a>',0,'2015-07-14 10:48:45'),
	(170,'main','orders','customer',5,'created','Nulla Ipsum <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20013\"><b>#20013.</b></a>',0,'2015-07-14 15:51:38'),
	(171,'main','orders','customer',5,'created','Nulla Ipsum <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20014\"><b>#20014.</b></a>',0,'2015-07-15 15:47:37'),
	(172,'main','orders','customer',5,'created','Nulla Ipsum <b>created</b> a new order <a href=\"http://tastyigniter.remote/admin/orders/edit?id=20015\"><b>#20015.</b></a>',0,'2015-07-15 16:19:19'),
	(173,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 18:57:40'),
	(174,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 18:57:52'),
	(175,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:04:28'),
	(176,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 19:04:48'),
	(177,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:25:57'),
	(178,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:48:21'),
	(179,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:48:21'),
	(180,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:48:59'),
	(181,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:49:00'),
	(182,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:57:44'),
	(183,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 19:57:45'),
	(184,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:14:33'),
	(185,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:14:34'),
	(186,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:16:38'),
	(187,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:16:39'),
	(188,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:17:15'),
	(189,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:17:15'),
	(190,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:18:15'),
	(191,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:18:16'),
	(192,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:18:16'),
	(193,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:21:26'),
	(194,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:21:26'),
	(195,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:21:27'),
	(196,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:33:23'),
	(197,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:36:15'),
	(198,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:36:16'),
	(199,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:36:16'),
	(200,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:37:26'),
	(201,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:37:27'),
	(202,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:37:27'),
	(203,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:42:05'),
	(204,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:42:05'),
	(205,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:42:05'),
	(206,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:42:27'),
	(207,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:42:28'),
	(208,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:42:28'),
	(209,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:42:29'),
	(210,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:42:29'),
	(211,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:42:30'),
	(212,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:44:53'),
	(213,'main','customers','customer',5,'logged out','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> out.',0,'2015-07-23 21:44:53'),
	(214,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-23 21:44:54'),
	(215,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-24 09:44:51'),
	(216,'main','customers','customer',5,'logged in','<a href=\"http://tastyigniter.remote/admin/customers/edit?id=5\">Nulla Ipsum</a> <b>logged</b> in.',0,'2015-07-24 09:45:53');

/*!40000 ALTER TABLE `ti_activities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_addresses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_addresses`;

CREATE TABLE `ti_addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(15) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_addresses` WRITE;
/*!40000 ALTER TABLE `ti_addresses` DISABLE KEYS */;

INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`)
VALUES
	(1,5,'5 Paragon Rd','','London','','E9 7AE',222),
	(2,1,'5 Paragon Rd','','London','','E9 7AE',222);

/*!40000 ALTER TABLE `ti_addresses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_banners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_banners`;

CREATE TABLE `ti_banners` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_banners` WRITE;
/*!40000 ALTER TABLE `ti_banners` DISABLE KEYS */;

INSERT INTO `ti_banners` (`banner_id`, `name`, `type`, `click_url`, `language_id`, `alt_text`, `image_code`, `custom_code`, `status`)
VALUES
	(1,'jbottega veneta','custom','menus',11,'I love cheesecake','a:1:{s:5:\"paths\";a:3:{i:0;s:14:\"data/pesto.jpg\";i:1;s:20:\"data/pounded_yam.jpg\";i:2;s:18:\"data/puff_puff.jpg\";}}','<img src=\"http://tastyigniter.remote/assets/images/thumbs/pesto-200x200.jpg\" alt=\"I love cheesecake\" class=\"img-responsive\">',1);

/*!40000 ALTER TABLE `ti_banners` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_categories`;

CREATE TABLE `ti_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_categories` WRITE;
/*!40000 ALTER TABLE `ti_categories` DISABLE KEYS */;

INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`, `priority`)
VALUES
	(15,'Appetizer','Sed efficitur velit ut ullamcorper aliquet. Quisque vitae nulla in velit finibus mollis. Donec sed porta tortor. Mauris suscipit tellus vel blandit blandit. Nam ac quam mi. In commodo nec est consequat posuere.',0,'data/akara.jpg',1),
	(16,'Main Course','Mauris maximus tempor ligula vitae placerat. Proin at orci fermentum, aliquam turpis sit amet, ultrices risus. Donec pellentesque justo in pharetra rutrum. Cras ac dui eu orci lacinia consequat vitae quis sapien.',0,'data/Seared_Ahi_Spinach_Salad.jpg',12),
	(17,'Salads','Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada. Mauris iaculis ac nisi at euismod. Nunc sit amet luctus ipsum. Pellentesque eget lobortis turpis. Vivamus mattis, massa ac vulputate vulputate, risus purus tincidunt nibh, vitae pellentesque ex nibh at mi.',0,'data/slide2.jpg',3),
	(18,'Seafoods','Donec placerat, urna quis interdum tempus, tellus nulla commodo leo, vitae auctor orci est congue eros. In vel ex quis orci blandit porttitor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus tincidunt risus non mattis semper.',0,'data/DSC_0149-2.jpg',4),
	(19,'Traditional','',0,'',5),
	(20,'Vegetarian','',0,'',6),
	(21,'Soups','',0,'',7),
	(22,'Desserts','',0,'',8),
	(23,'Drinks','',0,'',9),
	(24,'Specials','',0,'',10),
	(26,'Rice Dishes','',16,'data/vegetable-fried-rice.jpg',11);

/*!40000 ALTER TABLE `ti_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_countries`;

CREATE TABLE `ti_countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `format` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flag` varchar(255) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_countries` WRITE;
/*!40000 ALTER TABLE `ti_countries` DISABLE KEYS */;

INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`)
VALUES
	(1,'Afghanistan','AF','AFG','',1,'data/flags/af.png'),
	(2,'Albania','AL','ALB','',1,'data/flags/al.png'),
	(3,'Algeria','DZ','DZA','',1,'data/flags/dz.png'),
	(4,'American Samoa','AS','ASM','',1,'data/flags/as.png'),
	(5,'Andorra','AD','AND','',1,'data/flags/ad.png'),
	(6,'Angola','AO','AGO','',1,'data/flags/ao.png'),
	(7,'Anguilla','AI','AIA','',1,'data/flags/ai.png'),
	(8,'Antarctica','AQ','ATA','',1,'data/flags/aq.png'),
	(9,'Antigua and Barbuda','AG','ATG','',1,'data/flags/ag.png'),
	(10,'Argentina','AR','ARG','',1,'data/flags/ar.png'),
	(11,'Armenia','AM','ARM','',1,'data/flags/am.png'),
	(12,'Aruba','AW','ABW','',1,'data/flags/aw.png'),
	(13,'Australia','AU','AUS','',1,'data/flags/au.png'),
	(14,'Austria','AT','AUT','',1,'data/flags/at.png'),
	(15,'Azerbaijan','AZ','AZE','',1,'data/flags/az.png'),
	(16,'Bahamas','BS','BHS','',1,'data/flags/bs.png'),
	(17,'Bahrain','BH','BHR','',1,'data/flags/bh.png'),
	(18,'Bangladesh','BD','BGD','',1,'data/flags/bd.png'),
	(19,'Barbados','BB','BRB','',1,'data/flags/bb.png'),
	(20,'Belarus','BY','BLR','',1,'data/flags/by.png'),
	(21,'Belgium','BE','BEL','',1,'data/flags/be.png'),
	(22,'Belize','BZ','BLZ','',1,'data/flags/bz.png'),
	(23,'Benin','BJ','BEN','',1,'data/flags/bj.png'),
	(24,'Bermuda','BM','BMU','',1,'data/flags/bm.png'),
	(25,'Bhutan','BT','BTN','',1,'data/flags/bt.png'),
	(26,'Bolivia','BO','BOL','',1,'data/flags/bo.png'),
	(27,'Bosnia and Herzegowina','BA','BIH','',1,'data/flags/ba.png'),
	(28,'Botswana','BW','BWA','',1,'data/flags/bw.png'),
	(29,'Bouvet Island','BV','BVT','',1,'data/flags/bv.png'),
	(30,'Brazil','BR','BRA','',1,'data/flags/br.png'),
	(31,'British Indian Ocean Territory','IO','IOT','',1,'data/flags/io.png'),
	(32,'Brunei Darussalam','BN','BRN','',1,'data/flags/bn.png'),
	(33,'Bulgaria','BG','BGR','',1,'data/flags/bg.png'),
	(34,'Burkina Faso','BF','BFA','',1,'data/flags/bf.png'),
	(35,'Burundi','BI','BDI','',1,'data/flags/bi.png'),
	(36,'Cambodia','KH','KHM','',1,'data/flags/kh.png'),
	(37,'Cameroon','CM','CMR','',1,'data/flags/cm.png'),
	(38,'Canada','CA','CAN','',1,'data/flags/ca.png'),
	(39,'Cape Verde','CV','CPV','',1,'data/flags/cv.png'),
	(40,'Cayman Islands','KY','CYM','',1,'data/flags/ky.png'),
	(41,'Central African Republic','CF','CAF','',1,'data/flags/cf.png'),
	(42,'Chad','TD','TCD','',1,'data/flags/td.png'),
	(43,'Chile','CL','CHL','',1,'data/flags/cl.png'),
	(44,'China','CN','CHN','',1,'data/flags/cn.png'),
	(45,'Christmas Island','CX','CXR','',1,'data/flags/cx.png'),
	(46,'Cocos (Keeling) Islands','CC','CCK','',1,'data/flags/cc.png'),
	(47,'Colombia','CO','COL','',1,'data/flags/co.png'),
	(48,'Comoros','KM','COM','',1,'data/flags/km.png'),
	(49,'Congo','CG','COG','',1,'data/flags/cg.png'),
	(50,'Cook Islands','CK','COK','',1,'data/flags/ck.png'),
	(51,'Costa Rica','CR','CRI','',1,'data/flags/cr.png'),
	(52,'Cote D\'Ivoire','CI','CIV','',1,'data/flags/ci.png'),
	(53,'Croatia','HR','HRV','',1,'data/flags/hr.png'),
	(54,'Cuba','CU','CUB','',1,'data/flags/cu.png'),
	(55,'Cyprus','CY','CYP','',1,'data/flags/cy.png'),
	(56,'Czech Republic','CZ','CZE','',1,'data/flags/cz.png'),
	(57,'Denmark','DK','DNK','',1,'data/flags/dk.png'),
	(58,'Djibouti','DJ','DJI','',1,'data/flags/dj.png'),
	(59,'Dominica','DM','DMA','',1,'data/flags/dm.png'),
	(60,'Dominican Republic','DO','DOM','',1,'data/flags/do.png'),
	(61,'East Timor','TP','TMP','',1,'data/flags/tp.png'),
	(62,'Ecuador','EC','ECU','',1,'data/flags/ec.png'),
	(63,'Egypt','EG','EGY','',1,'data/flags/eg.png'),
	(64,'El Salvador','SV','SLV','',1,'data/flags/sv.png'),
	(65,'Equatorial Guinea','GQ','GNQ','',1,'data/flags/gq.png'),
	(66,'Eritrea','ER','ERI','',1,'data/flags/er.png'),
	(67,'Estonia','EE','EST','',1,'data/flags/ee.png'),
	(68,'Ethiopia','ET','ETH','',1,'data/flags/et.png'),
	(69,'Falkland Islands (Malvinas)','FK','FLK','',1,'data/flags/fk.png'),
	(70,'Faroe Islands','FO','FRO','',1,'data/flags/fo.png'),
	(71,'Fiji','FJ','FJI','',1,'data/flags/fj.png'),
	(72,'Finland','FI','FIN','',1,'data/flags/fi.png'),
	(73,'France','FR','FRA','',1,'data/flags/fr.png'),
	(74,'France, Metropolitan','FX','FXX','',1,'data/flags/fx.png'),
	(75,'French Guiana','GF','GUF','',1,'data/flags/gf.png'),
	(76,'French Polynesia','PF','PYF','',1,'data/flags/pf.png'),
	(77,'French Southern Territories','TF','ATF','',1,'data/flags/tf.png'),
	(78,'Gabon','GA','GAB','',1,'data/flags/ga.png'),
	(79,'Gambia','GM','GMB','',1,'data/flags/gm.png'),
	(80,'Georgia','GE','GEO','',1,'data/flags/ge.png'),
	(81,'Germany','DE','DEU','',1,'data/flags/de.png'),
	(82,'Ghana','GH','GHA','',1,'data/flags/gh.png'),
	(83,'Gibraltar','GI','GIB','',1,'data/flags/gi.png'),
	(84,'Greece','GR','GRC','',1,'data/flags/gr.png'),
	(85,'Greenland','GL','GRL','',1,'data/flags/gl.png'),
	(86,'Grenada','GD','GRD','',1,'data/flags/gd.png'),
	(87,'Guadeloupe','GP','GLP','',1,'data/flags/gp.png'),
	(88,'Guam','GU','GUM','',1,'data/flags/gu.png'),
	(89,'Guatemala','GT','GTM','',1,'data/flags/gt.png'),
	(90,'Guinea','GN','GIN','',1,'data/flags/gn.png'),
	(91,'Guinea-bissau','GW','GNB','',1,'data/flags/gw.png'),
	(92,'Guyana','GY','GUY','',1,'data/flags/gy.png'),
	(93,'Haiti','HT','HTI','',1,'data/flags/ht.png'),
	(94,'Heard and Mc Donald Islands','HM','HMD','',1,'data/flags/hm.png'),
	(95,'Honduras','HN','HND','',1,'data/flags/hn.png'),
	(96,'Hong Kong','HK','HKG','',1,'data/flags/hk.png'),
	(97,'Hungary','HU','HUN','',1,'data/flags/hu.png'),
	(98,'Iceland','IS','ISL','',1,'data/flags/is.png'),
	(99,'India','IN','IND','',1,'data/flags/in.png'),
	(100,'Indonesia','ID','IDN','',1,'data/flags/id.png'),
	(101,'Iran (Islamic Republic of)','IR','IRN','',1,'data/flags/ir.png'),
	(102,'Iraq','IQ','IRQ','',1,'data/flags/iq.png'),
	(103,'Ireland','IE','IRL','',1,'data/flags/ie.png'),
	(104,'Israel','IL','ISR','',1,'data/flags/il.png'),
	(105,'Italy','IT','ITA','',1,'data/flags/it.png'),
	(106,'Jamaica','JM','JAM','',1,'data/flags/jm.png'),
	(107,'Japan','JP','JPN','',1,'data/flags/jp.png'),
	(108,'Jordan','JO','JOR','',1,'data/flags/jo.png'),
	(109,'Kazakhstan','KZ','KAZ','',1,'data/flags/kz.png'),
	(110,'Kenya','KE','KEN','',1,'data/flags/ke.png'),
	(111,'Kiribati','KI','KIR','',1,'data/flags/ki.png'),
	(112,'North Korea','KP','PRK','',1,'data/flags/kp.png'),
	(113,'Korea, Republic of','KR','KOR','',1,'data/flags/kr.png'),
	(114,'Kuwait','KW','KWT','',1,'data/flags/kw.png'),
	(115,'Kyrgyzstan','KG','KGZ','',1,'data/flags/kg.png'),
	(116,'Lao People\'s Democratic Republic','LA','LAO','',1,'data/flags/la.png'),
	(117,'Latvia','LV','LVA','',1,'data/flags/lv.png'),
	(118,'Lebanon','LB','LBN','',1,'data/flags/lb.png'),
	(119,'Lesotho','LS','LSO','',1,'data/flags/ls.png'),
	(120,'Liberia','LR','LBR','',1,'data/flags/lr.png'),
	(121,'Libyan Arab Jamahiriya','LY','LBY','',1,'data/flags/ly.png'),
	(122,'Liechtenstein','LI','LIE','',1,'data/flags/li.png'),
	(123,'Lithuania','LT','LTU','',1,'data/flags/lt.png'),
	(124,'Luxembourg','LU','LUX','',1,'data/flags/lu.png'),
	(125,'Macau','MO','MAC','',1,'data/flags/mo.png'),
	(126,'FYROM','MK','MKD','',1,'data/flags/mk.png'),
	(127,'Madagascar','MG','MDG','',1,'data/flags/mg.png'),
	(128,'Malawi','MW','MWI','',1,'data/flags/mw.png'),
	(129,'Malaysia','MY','MYS','',1,'data/flags/my.png'),
	(130,'Maldives','MV','MDV','',1,'data/flags/mv.png'),
	(131,'Mali','ML','MLI','',1,'data/flags/ml.png'),
	(132,'Malta','MT','MLT','',1,'data/flags/mt.png'),
	(133,'Marshall Islands','MH','MHL','',1,'data/flags/mh.png'),
	(134,'Martinique','MQ','MTQ','',1,'data/flags/mq.png'),
	(135,'Mauritania','MR','MRT','',1,'data/flags/mr.png'),
	(136,'Mauritius','MU','MUS','',1,'data/flags/mu.png'),
	(137,'Mayotte','YT','MYT','',1,'data/flags/yt.png'),
	(138,'Mexico','MX','MEX','',1,'data/flags/mx.png'),
	(139,'Micronesia, Federated States of','FM','FSM','',1,'data/flags/fm.png'),
	(140,'Moldova, Republic of','MD','MDA','',1,'data/flags/md.png'),
	(141,'Monaco','MC','MCO','',1,'data/flags/mc.png'),
	(142,'Mongolia','MN','MNG','',1,'data/flags/mn.png'),
	(143,'Montserrat','MS','MSR','',1,'data/flags/ms.png'),
	(144,'Morocco','MA','MAR','',1,'data/flags/ma.png'),
	(145,'Mozambique','MZ','MOZ','',1,'data/flags/mz.png'),
	(146,'Myanmar','MM','MMR','',1,'data/flags/mm.png'),
	(147,'Namibia','NA','NAM','',1,'data/flags/na.png'),
	(148,'Nauru','NR','NRU','',1,'data/flags/nr.png'),
	(149,'Nepal','NP','NPL','',1,'data/flags/np.png'),
	(150,'Netherlands','NL','NLD','',1,'data/flags/nl.png'),
	(151,'Netherlands Antilles','AN','ANT','',1,'data/flags/an.png'),
	(152,'New Caledonia','NC','NCL','',1,'data/flags/nc.png'),
	(153,'New Zealand','NZ','NZL','',1,'data/flags/nz.png'),
	(154,'Nicaragua','NI','NIC','',1,'data/flags/ni.png'),
	(155,'Niger','NE','NER','',1,'data/flags/ne.png'),
	(156,'Nigeria','NG','NGA','',1,'data/flags/ng.png'),
	(157,'Niue','NU','NIU','',1,'data/flags/nu.png'),
	(158,'Norfolk Island','NF','NFK','',1,'data/flags/nf.png'),
	(159,'Northern Mariana Islands','MP','MNP','',1,'data/flags/mp.png'),
	(160,'Norway','NO','NOR','',1,'data/flags/no.png'),
	(161,'Oman','OM','OMN','',1,'data/flags/om.png'),
	(162,'Pakistan','PK','PAK','',1,'data/flags/pk.png'),
	(163,'Palau','PW','PLW','',1,'data/flags/pw.png'),
	(164,'Panama','PA','PAN','',1,'data/flags/pa.png'),
	(165,'Papua New Guinea','PG','PNG','',1,'data/flags/pg.png'),
	(166,'Paraguay','PY','PRY','',1,'data/flags/py.png'),
	(167,'Peru','PE','PER','',1,'data/flags/pe.png'),
	(168,'Philippines','PH','PHL','',1,'data/flags/ph.png'),
	(169,'Pitcairn','PN','PCN','',1,'data/flags/pn.png'),
	(170,'Poland','PL','POL','',1,'data/flags/pl.png'),
	(171,'Portugal','PT','PRT','',1,'data/flags/pt.png'),
	(172,'Puerto Rico','PR','PRI','',1,'data/flags/pr.png'),
	(173,'Qatar','QA','QAT','',1,'data/flags/qa.png'),
	(174,'Reunion','RE','REU','',1,'data/flags/re.png'),
	(175,'Romania','RO','ROM','',1,'data/flags/ro.png'),
	(176,'Russian Federation','RU','RUS','',1,'data/flags/ru.png'),
	(177,'Rwanda','RW','RWA','',1,'data/flags/rw.png'),
	(178,'Saint Kitts and Nevis','KN','KNA','',1,'data/flags/kn.png'),
	(179,'Saint Lucia','LC','LCA','',1,'data/flags/lc.png'),
	(180,'Saint Vincent and the Grenadines','VC','VCT','',1,'data/flags/vc.png'),
	(181,'Samoa','WS','WSM','',1,'data/flags/ws.png'),
	(182,'San Marino','SM','SMR','',1,'data/flags/sm.png'),
	(183,'Sao Tome and Principe','ST','STP','',1,'data/flags/st.png'),
	(184,'Saudi Arabia','SA','SAU','',1,'data/flags/sa.png'),
	(185,'Senegal','SN','SEN','',1,'data/flags/sn.png'),
	(186,'Seychelles','SC','SYC','',1,'data/flags/sc.png'),
	(187,'Sierra Leone','SL','SLE','',1,'data/flags/sl.png'),
	(188,'Singapore','SG','SGP','',1,'data/flags/sg.png'),
	(189,'Slovak Republic','SK','SVK','',1,'data/flags/sk.png'),
	(190,'Slovenia','SI','SVN','',1,'data/flags/si.png'),
	(191,'Solomon Islands','SB','SLB','',1,'data/flags/sb.png'),
	(192,'Somalia','SO','SOM','',1,'data/flags/so.png'),
	(193,'South Africa','ZA','ZAF','',1,'data/flags/za.png'),
	(194,'South Georgia &amp; South Sandwich Islands','GS','SGS','',1,'data/flags/gs.png'),
	(195,'Spain','ES','ESP','',1,'data/flags/es.png'),
	(196,'Sri Lanka','LK','LKA','',1,'data/flags/lk.png'),
	(197,'St. Helena','SH','SHN','',1,'data/flags/sh.png'),
	(198,'St. Pierre and Miquelon','PM','SPM','',1,'data/flags/pm.png'),
	(199,'Sudan','SD','SDN','',1,'data/flags/sd.png'),
	(200,'Suriname','SR','SUR','',1,'data/flags/sr.png'),
	(201,'Svalbard and Jan Mayen Islands','SJ','SJM','',1,'data/flags/sj.png'),
	(202,'Swaziland','SZ','SWZ','',1,'data/flags/sz.png'),
	(203,'Sweden','SE','SWE','',1,'data/flags/se.png'),
	(204,'Switzerland','CH','CHE','',1,'data/flags/ch.png'),
	(205,'Syrian Arab Republic','SY','SYR','',1,'data/flags/sy.png'),
	(206,'Taiwan','TW','TWN','',1,'data/flags/tw.png'),
	(207,'Tajikistan','TJ','TJK','',1,'data/flags/tj.png'),
	(208,'Tanzania, United Republic of','TZ','TZA','',1,'data/flags/tz.png'),
	(209,'Thailand','TH','THA','',1,'data/flags/th.png'),
	(210,'Togo','TG','TGO','',1,'data/flags/tg.png'),
	(211,'Tokelau','TK','TKL','',1,'data/flags/tk.png'),
	(212,'Tonga','TO','TON','',1,'data/flags/to.png'),
	(213,'Trinidad and Tobago','TT','TTO','',1,'data/flags/tt.png'),
	(214,'Tunisia','TN','TUN','',1,'data/flags/tn.png'),
	(215,'Turkey','TR','TUR','',1,'data/flags/tr.png'),
	(216,'Turkmenistan','TM','TKM','',1,'data/flags/tm.png'),
	(217,'Turks and Caicos Islands','TC','TCA','',1,'data/flags/tc.png'),
	(218,'Tuvalu','TV','TUV','',1,'data/flags/tv.png'),
	(219,'Uganda','UG','UGA','',1,'data/flags/ug.png'),
	(220,'Ukraine','UA','UKR','',1,'data/flags/ua.png'),
	(221,'United Arab Emirates','AE','ARE','',1,'data/flags/ae.png'),
	(222,'United Kingdom','GB','GBR','{address_1}\n{address_2}\n{city} {postcode} {state}\n{country}',1,'data/flags/gb.png'),
	(223,'United States','US','USA','',1,'data/flags/us.png'),
	(224,'United States Minor Outlying Islands','UM','UMI','',1,'data/flags/um.png'),
	(225,'Uruguay','UY','URY','',1,'data/flags/uy.png'),
	(226,'Uzbekistan','UZ','UZB','',1,'data/flags/uz.png'),
	(227,'Vanuatu','VU','VUT','',1,'data/flags/vu.png'),
	(228,'Vatican City State (Holy See)','VA','VAT','',1,'data/flags/va.png'),
	(229,'Venezuela','VE','VEN','',1,'data/flags/ve.png'),
	(230,'Viet Nam','VN','VNM','',1,'data/flags/vn.png'),
	(231,'Virgin Islands (British)','VG','VGB','',1,'data/flags/vg.png'),
	(232,'Virgin Islands (U.S.)','VI','VIR','',1,'data/flags/vi.png'),
	(233,'Wallis and Futuna Islands','WF','WLF','',1,'data/flags/wf.png'),
	(234,'Western Sahara','EH','ESH','',1,'data/flags/eh.png'),
	(235,'Yemen','YE','YEM','',1,'data/flags/ye.png'),
	(236,'Yugoslavia','YU','YUG','',1,'data/flags/yu.png'),
	(237,'Democratic Republic of Congo','CD','COD','',1,'data/flags/cd.png'),
	(238,'Zambia','ZM','ZMB','',1,'data/flags/zm.png'),
	(239,'Zimbabwe','ZW','ZWE','',1,'data/flags/zw.png');

/*!40000 ALTER TABLE `ti_countries` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_coupons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_coupons`;

CREATE TABLE `ti_coupons` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` varchar(15) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,2) NOT NULL,
  `min_total` decimal(15,2) NOT NULL,
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
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_coupons` WRITE;
/*!40000 ALTER TABLE `ti_coupons` DISABLE KEYS */;

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `status`, `date_added`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`)
VALUES
	(11,'Half Sundays','2222','F',100.00,500.00,0,0,'',1,'0000-00-00','forever',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL),
	(12,'Half Tuesdays','3333','P',30.00,1000.00,0,0,'',1,'0000-00-00','forever',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL),
	(13,'Full Mondays','MTo6TuTg','P',50.00,0.00,0,1,'',1,'0000-00-00','forever',NULL,'00:00:00','23:59:00',NULL,NULL,'','00:00:00','23:59:00'),
	(14,'Full Tuesdays','4444','F',500.00,5000.00,0,0,'',1,'0000-00-00','recurring',NULL,'00:00:00','23:59:00',NULL,NULL,'0, 2, 4, 5, 6','00:00:00','23:59:00'),
	(15,'Full Wednesdays','5555','F',5000.00,5000.00,0,0,'',1,'0000-00-00','forever',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL),
	(16,'Full Tuesdays','4444','F',500.00,5000.00,0,0,'',1,'2015-06-05','recurring',NULL,NULL,NULL,NULL,NULL,'0, 2, 4, 5, 6','00:00:00','23:59:00');

/*!40000 ALTER TABLE `ti_coupons` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_coupons_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_coupons_history`;

CREATE TABLE `ti_coupons_history` (
  `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `min_total` decimal(15,2) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `date_used` datetime NOT NULL,
  PRIMARY KEY (`coupon_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_coupons_history` WRITE;
/*!40000 ALTER TABLE `ti_coupons_history` DISABLE KEYS */;

INSERT INTO `ti_coupons_history` (`coupon_history_id`, `coupon_id`, `order_id`, `customer_id`, `code`, `min_total`, `amount`, `date_used`)
VALUES
	(1,15,20003,1,'5555',0.00,-5000.00,'2015-05-26 14:06:01'),
	(2,15,20005,1,'5555',0.00,-5000.00,'2015-06-15 01:59:22'),
	(3,11,20010,0,'2222',0.00,-100.00,'2015-06-15 15:09:40'),
	(4,11,20011,5,'2222',0.00,-100.00,'2015-06-15 15:57:54');

/*!40000 ALTER TABLE `ti_coupons_history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_currencies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_currencies`;

CREATE TABLE `ti_currencies` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `currency_name` varchar(32) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_symbol` varchar(3) NOT NULL,
  `iso_alpha2` varchar(2) NOT NULL,
  `iso_alpha3` varchar(3) NOT NULL,
  `iso_numeric` int(11) NOT NULL,
  `flag` varchar(6) NOT NULL,
  `currency_status` int(1) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_currencies` WRITE;
/*!40000 ALTER TABLE `ti_currencies` DISABLE KEYS */;

INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`)
VALUES
	(2,2,'Lek','ALL','Lek','AL','ALB',8,'AL.png',0),
	(3,3,'Dinar','DZD','د.ج','DZ','DZA',12,'DZ.png',0),
	(4,4,'Dollar','USD','$','AS','ASM',16,'AS.png',0),
	(5,5,'Euro','EUR','€','AD','AND',20,'AD.png',0),
	(6,6,'Kwanza','AOA','Kz','AO','AGO',24,'AO.png',0),
	(7,7,'Dollar','XCD','$','AI','AIA',660,'AI.png',0),
	(8,8,'Antarctican','AQD','A$','AQ','ATA',10,'AQ.png',0),
	(9,9,'Dollar','XCD','$','AG','ATG',28,'AG.png',0),
	(10,10,'Peso','ARS','$','AR','ARG',32,'AR.png',0),
	(11,11,'Dram','AMD','դր.','AM','ARM',51,'AM.png',0),
	(12,12,'Guilder','AWG','ƒ','AW','ABW',533,'AW.png',0),
	(13,13,'Dollar','AUD','$','AU','AUS',36,'AU.png',1),
	(14,14,'Euro','EUR','€','AT','AUT',40,'AT.png',0),
	(15,15,'Manat','AZN','ман','AZ','AZE',31,'AZ.png',0),
	(16,16,'Dollar','BSD','$','BS','BHS',44,'BS.png',0),
	(17,17,'Dinar','BHD','.د.','BH','BHR',48,'BH.png',0),
	(18,18,'Taka','BDT','৳','BD','BGD',50,'BD.png',0),
	(19,19,'Dollar','BBD','$','BB','BRB',52,'BB.png',0),
	(20,20,'Ruble','BYR','p.','BY','BLR',112,'BY.png',0),
	(21,21,'Euro','EUR','€','BE','BEL',56,'BE.png',0),
	(22,22,'Dollar','BZD','BZ$','BZ','BLZ',84,'BZ.png',0),
	(23,23,'Franc','XOF','','BJ','BEN',204,'BJ.png',0),
	(24,24,'Dollar','BMD','$','BM','BMU',60,'BM.png',0),
	(25,25,'Ngultrum','BTN','Nu.','BT','BTN',64,'BT.png',0),
	(26,26,'Boliviano','BOB','$b','BO','BOL',68,'BO.png',0),
	(27,27,'Marka','BAM','KM','BA','BIH',70,'BA.png',0),
	(28,28,'Pula','BWP','P','BW','BWA',72,'BW.png',0),
	(29,29,'Krone','NOK','kr','BV','BVT',74,'BV.png',0),
	(30,30,'Real','BRL','R$','BR','BRA',76,'BR.png',0),
	(31,31,'Dollar','USD','$','IO','IOT',86,'IO.png',0),
	(32,231,'Dollar','USD','$','VG','VGB',92,'VG.png',0),
	(33,32,'Dollar','BND','$','BN','BRN',96,'BN.png',0),
	(34,33,'Lev','BGN','лв','BG','BGR',100,'BG.png',0),
	(35,34,'Franc','XOF','','BF','BFA',854,'BF.png',0),
	(36,35,'Franc','BIF','Fr','BI','BDI',108,'BI.png',0),
	(37,36,'Riels','KHR','៛','KH','KHM',116,'KH.png',0),
	(38,37,'Franc','XAF','FCF','CM','CMR',120,'CM.png',0),
	(39,38,'Dollar','CAD','$','CA','CAN',124,'CA.png',0),
	(40,39,'Escudo','CVE','','CV','CPV',132,'CV.png',0),
	(41,40,'Dollar','KYD','$','KY','CYM',136,'KY.png',0),
	(42,41,'Franc','XAF','FCF','CF','CAF',140,'CF.png',0),
	(43,42,'Franc','XAF','','TD','TCD',148,'TD.png',0),
	(44,43,'Peso','CLP','','CL','CHL',152,'CL.png',0),
	(45,44,'Yuan Renminbi','CNY','¥','CN','CHN',156,'CN.png',0),
	(46,45,'Dollar','AUD','$','CX','CXR',162,'CX.png',0),
	(47,46,'Dollar','AUD','$','CC','CCK',166,'CC.png',0),
	(48,47,'Peso','COP','$','CO','COL',170,'CO.png',0),
	(49,48,'Franc','KMF','','KM','COM',174,'KM.png',0),
	(50,50,'Dollar','NZD','$','CK','COK',184,'CK.png',0),
	(51,51,'Colon','CRC','₡','CR','CRI',188,'CR.png',0),
	(52,53,'Kuna','HRK','kn','HR','HRV',191,'HR.png',0),
	(53,54,'Peso','CUP','₱','CU','CUB',192,'CU.png',0),
	(54,55,'Pound','CYP','','CY','CYP',196,'CY.png',0),
	(55,56,'Koruna','CZK','Kč','CZ','CZE',203,'CZ.png',0),
	(56,49,'Franc','CDF','FC','CD','COD',180,'CD.png',0),
	(57,57,'Krone','DKK','kr','DK','DNK',208,'DK.png',0),
	(58,58,'Franc','DJF','','DJ','DJI',262,'DJ.png',0),
	(59,59,'Dollar','XCD','$','DM','DMA',212,'DM.png',0),
	(60,60,'Peso','DOP','RD$','DO','DOM',214,'DO.png',0),
	(61,61,'Dollar','USD','$','TL','TLS',626,'TL.png',0),
	(62,62,'Dollar','USD','$','EC','ECU',218,'EC.png',0),
	(63,63,'Pound','EGP','£','EG','EGY',818,'EG.png',0),
	(64,64,'Colone','SVC','$','SV','SLV',222,'SV.png',0),
	(65,65,'Franc','XAF','FCF','GQ','GNQ',226,'GQ.png',0),
	(66,66,'Nakfa','ERN','Nfk','ER','ERI',232,'ER.png',0),
	(67,67,'Kroon','EEK','kr','EE','EST',233,'EE.png',0),
	(68,68,'Birr','ETB','','ET','ETH',231,'ET.png',0),
	(69,69,'Pound','FKP','£','FK','FLK',238,'FK.png',0),
	(70,70,'Krone','DKK','kr','FO','FRO',234,'FO.png',0),
	(71,71,'Dollar','FJD','$','FJ','FJI',242,'FJ.png',0),
	(72,72,'Euro','EUR','€','FI','FIN',246,'FI.png',0),
	(73,73,'Euro','EUR','€','FR','FRA',250,'FR.png',0),
	(74,75,'Euro','EUR','€','GF','GUF',254,'GF.png',0),
	(75,76,'Franc','XPF','','PF','PYF',258,'PF.png',0),
	(76,77,'Euro  ','EUR','€','TF','ATF',260,'TF.png',0),
	(77,78,'Franc','XAF','FCF','GA','GAB',266,'GA.png',0),
	(78,79,'Dalasi','GMD','D','GM','GMB',270,'GM.png',0),
	(79,80,'Lari','GEL','','GE','GEO',268,'GE.png',0),
	(80,81,'Euro','EUR','€','DE','DEU',276,'DE.png',0),
	(81,82,'Cedi','GHC','¢','GH','GHA',288,'GH.png',0),
	(82,83,'Pound','GIP','£','GI','GIB',292,'GI.png',0),
	(83,84,'Euro','EUR','€','GR','GRC',300,'GR.png',0),
	(84,85,'Krone','DKK','kr','GL','GRL',304,'GL.png',0),
	(85,86,'Dollar','XCD','$','GD','GRD',308,'GD.png',0),
	(86,87,'Euro','EUR','€','GP','GLP',312,'GP.png',0),
	(87,88,'Dollar','USD','$','GU','GUM',316,'GU.png',0),
	(88,89,'Quetzal','GTQ','Q','GT','GTM',320,'GT.png',0),
	(89,90,'Franc','GNF','','GN','GIN',324,'GN.png',0),
	(90,91,'Franc','XOF','','GW','GNB',624,'GW.png',0),
	(91,92,'Dollar','GYD','$','GY','GUY',328,'GY.png',0),
	(92,93,'Gourde','HTG','G','HT','HTI',332,'HT.png',0),
	(93,94,'Dollar','AUD','$','HM','HMD',334,'HM.png',0),
	(94,95,'Lempira','HNL','L','HN','HND',340,'HN.png',0),
	(95,96,'Dollar','HKD','$','HK','HKG',344,'HK.png',0),
	(96,97,'Forint','HUF','Ft','HU','HUN',348,'HU.png',0),
	(97,98,'Krona','ISK','kr','IS','ISL',352,'IS.png',0),
	(98,99,'Rupee','INR','₹','IN','IND',356,'IN.png',0),
	(99,100,'Rupiah','IDR','Rp','ID','IDN',360,'ID.png',0),
	(100,101,'Rial','IRR','﷼','IR','IRN',364,'IR.png',0),
	(101,102,'Dinar','IQD','','IQ','IRQ',368,'IQ.png',0),
	(102,103,'Euro','EUR','€','IE','IRL',372,'IE.png',0),
	(103,104,'Shekel','ILS','₪','IL','ISR',376,'IL.png',0),
	(104,105,'Euro','EUR','€','IT','ITA',380,'IT.png',0),
	(105,52,'Franc','XOF','','CI','CIV',384,'CI.png',0),
	(106,106,'Dollar','JMD','$','JM','JAM',388,'JM.png',0),
	(107,107,'Yen','JPY','¥','JP','JPN',392,'JP.png',0),
	(108,108,'Dinar','JOD','','JO','JOR',400,'JO.png',0),
	(109,109,'Tenge','KZT','лв','KZ','KAZ',398,'KZ.png',0),
	(110,110,'Shilling','KES','','KE','KEN',404,'KE.png',0),
	(111,111,'Dollar','AUD','$','KI','KIR',296,'KI.png',0),
	(112,114,'Dinar','KWD','د.ك','KW','KWT',414,'KW.png',0),
	(113,115,'Som','KGS','лв','KG','KGZ',417,'KG.png',0),
	(114,116,'Kip','LAK','₭','LA','LAO',418,'LA.png',0),
	(115,117,'Lat','LVL','Ls','LV','LVA',428,'LV.png',0),
	(116,118,'Pound','LBP','£','LB','LBN',422,'LB.png',0),
	(117,119,'Loti','LSL','L','LS','LSO',426,'LS.png',0),
	(118,120,'Dollar','LRD','$','LR','LBR',430,'LR.png',0),
	(119,121,'Dinar','LYD','ل.د','LY','LBY',434,'LY.png',0),
	(120,122,'Franc','CHF','CHF','LI','LIE',438,'LI.png',0),
	(121,123,'Litas','LTL','Lt','LT','LTU',440,'LT.png',0),
	(122,124,'Euro','EUR','€','LU','LUX',442,'LU.png',0),
	(123,125,'Pataca','MOP','MOP','MO','MAC',446,'MO.png',0),
	(124,140,'Denar','MKD','ден','MK','MKD',807,'MK.png',0),
	(125,127,'Ariary','MGA','Ar','MG','MDG',450,'MG.png',0),
	(126,128,'Kwacha','MWK','MK','MW','MWI',454,'MW.png',0),
	(127,129,'Ringgit','MYR','RM','MY','MYS',458,'MY.png',0),
	(128,130,'Rufiyaa','MVR','Rf','MV','MDV',462,'MV.png',0),
	(129,131,'Franc','XOF','MAF','ML','MLI',466,'ML.png',0),
	(130,132,'Lira','MTL','Lm','MT','MLT',470,'MT.png',0),
	(131,133,'Dollar','USD','$','MH','MHL',584,'MH.png',0),
	(132,134,'Euro','EUR','€','MQ','MTQ',474,'MQ.png',0),
	(133,135,'Ouguiya','MRO','UM','MR','MRT',478,'MR.png',0),
	(134,136,'Rupee','MUR','₨','MU','MUS',480,'MU.png',0),
	(135,137,'Euro','EUR','€','YT','MYT',175,'YT.png',0),
	(136,138,'Peso','MXN','$','MX','MEX',484,'MX.png',0),
	(137,139,'Dollar','USD','$','FM','FSM',583,'FM.png',0),
	(138,140,'Leu','MDL','MDL','MD','MDA',498,'MD.png',0),
	(139,141,'Euro','EUR','€','MC','MCO',492,'MC.png',0),
	(140,142,'Tugrik','MNT','₮','MN','MNG',496,'MN.png',0),
	(141,143,'Dollar','XCD','$','MS','MSR',500,'MS.png',0),
	(142,144,'Dirham','MAD','','MA','MAR',504,'MA.png',0),
	(143,145,'Meticail','MZN','MT','MZ','MOZ',508,'MZ.png',0),
	(144,146,'Kyat','MMK','K','MM','MMR',104,'MM.png',0),
	(145,147,'Dollar','NAD','$','NA','NAM',516,'NA.png',0),
	(146,148,'Dollar','AUD','$','NR','NRU',520,'NR.png',0),
	(147,149,'Rupee','NPR','₨','NP','NPL',524,'NP.png',0),
	(148,150,'Euro','EUR','€','NL','NLD',528,'NL.png',0),
	(149,151,'Guilder','ANG','ƒ','AN','ANT',530,'AN.png',0),
	(150,152,'Franc','XPF','','NC','NCL',540,'NC.png',0),
	(151,153,'Dollar','NZD','$','NZ','NZL',554,'NZ.png',0),
	(152,154,'Cordoba','NIO','C$','NI','NIC',558,'NI.png',0),
	(153,155,'Franc','XOF','','NE','NER',562,'NE.png',0),
	(154,156,'Naira','NGN','₦','NG','NGA',566,'NG.png',1),
	(155,157,'Dollar','NZD','$','NU','NIU',570,'NU.png',0),
	(156,158,'Dollar','AUD','$','NF','NFK',574,'NF.png',0),
	(157,112,'Won','KPW','₩','KP','PRK',408,'KP.png',0),
	(158,159,'Dollar','USD','$','MP','MNP',580,'MP.png',0),
	(159,160,'Krone','NOK','kr','NO','NOR',578,'NO.png',0),
	(160,161,'Rial','OMR','﷼','OM','OMN',512,'OM.png',0),
	(161,162,'Rupee','PKR','₨','PK','PAK',586,'PK.png',0),
	(162,163,'Dollar','USD','$','PW','PLW',585,'PW.png',0),
	(163,0,'Shekel','ILS','₪','PS','PSE',275,'PS.png',0),
	(164,164,'Balboa','PAB','B/.','PA','PAN',591,'PA.png',0),
	(165,165,'Kina','PGK','','PG','PNG',598,'PG.png',0),
	(166,166,'Guarani','PYG','Gs','PY','PRY',600,'PY.png',0),
	(167,167,'Sol','PEN','S/.','PE','PER',604,'PE.png',0),
	(168,168,'Peso','PHP','Php','PH','PHL',608,'PH.png',0),
	(169,169,'Dollar','NZD','$','PN','PCN',612,'PN.png',0),
	(170,170,'Zloty','PLN','zł','PL','POL',616,'PL.png',0),
	(171,171,'Euro','EUR','€','PT','PRT',620,'PT.png',0),
	(172,172,'Dollar','USD','$','PR','PRI',630,'PR.png',0),
	(173,173,'Rial','QAR','﷼','QA','QAT',634,'QA.png',0),
	(174,49,'Franc','XAF','FCF','CG','COG',178,'CG.png',0),
	(175,174,'Euro','EUR','€','RE','REU',638,'RE.png',0),
	(176,175,'Leu','RON','lei','RO','ROU',642,'RO.png',0),
	(177,176,'Ruble','RUB','руб','RU','RUS',643,'RU.png',0),
	(178,177,'Franc','RWF','','RW','RWA',646,'RW.png',0),
	(179,179,'Pound','SHP','£','SH','SHN',654,'SH.png',0),
	(180,178,'Dollar','XCD','$','KN','KNA',659,'KN.png',0),
	(181,179,'Dollar','XCD','$','LC','LCA',662,'LC.png',0),
	(182,180,'Euro','EUR','€','PM','SPM',666,'PM.png',0),
	(183,180,'Dollar','XCD','$','VC','VCT',670,'VC.png',0),
	(184,181,'Tala','WST','WS$','WS','WSM',882,'WS.png',0),
	(185,182,'Euro','EUR','€','SM','SMR',674,'SM.png',0),
	(186,183,'Dobra','STD','Db','ST','STP',678,'ST.png',0),
	(187,184,'Rial','SAR','﷼','SA','SAU',682,'SA.png',0),
	(188,185,'Franc','XOF','','SN','SEN',686,'SN.png',0),
	(189,142,'Dinar','RSD','Дин','CS','SCG',891,'CS.png',0),
	(190,186,'Rupee','SCR','₨','SC','SYC',690,'SC.png',0),
	(191,187,'Leone','SLL','Le','SL','SLE',694,'SL.png',0),
	(192,188,'Dollar','SGD','$','SG','SGP',702,'SG.png',0),
	(193,189,'Koruna','SKK','Sk','SK','SVK',703,'SK.png',0),
	(194,190,'Euro','EUR','€','SI','SVN',705,'SI.png',0),
	(195,191,'Dollar','SBD','$','SB','SLB',90,'SB.png',0),
	(196,192,'Shilling','SOS','S','SO','SOM',706,'SO.png',0),
	(197,193,'Rand','ZAR','R','ZA','ZAF',710,'ZA.png',0),
	(198,113,'Pound','GBP','£','GS','SGS',239,'GS.png',0),
	(199,194,'Won','KRW','₩','KR','KOR',410,'KR.png',0),
	(200,195,'Euro','EUR','€','ES','ESP',724,'ES.png',0),
	(201,196,'Rupee','LKR','₨','LK','LKA',144,'LK.png',0),
	(202,199,'Dinar','SDD','','SD','SDN',736,'SD.png',0),
	(203,200,'Dollar','SRD','$','SR','SUR',740,'SR.png',0),
	(204,0,'Krone','NOK','kr','SJ','SJM',744,'SJ.png',0),
	(205,202,'Lilangeni','SZL','','SZ','SWZ',748,'SZ.png',0),
	(206,203,'Krona','SEK','kr','SE','SWE',752,'SE.png',0),
	(207,204,'Franc','CHF','CHF','CH','CHE',756,'CH.png',0),
	(208,205,'Pound','SYP','£','SY','SYR',760,'SY.png',0),
	(209,206,'Dollar','TWD','NT$','TW','TWN',158,'TW.png',0),
	(210,207,'Somoni','TJS','','TJ','TJK',762,'TJ.png',0),
	(211,208,'Shilling','TZS','','TZ','TZA',834,'TZ.png',0),
	(212,209,'Baht','THB','฿','TH','THA',764,'TH.png',0),
	(213,210,'Franc','XOF','','TG','TGO',768,'TG.png',0),
	(214,211,'Dollar','NZD','$','TK','TKL',772,'TK.png',0),
	(215,212,'Pa\'anga','TOP','T$','TO','TON',776,'TO.png',0),
	(216,213,'Dollar','TTD','TT$','TT','TTO',780,'TT.png',0),
	(217,214,'Dinar','TND','','TN','TUN',788,'TN.png',0),
	(218,215,'Lira','TRY','YTL','TR','TUR',792,'TR.png',0),
	(219,216,'Manat','TMM','m','TM','TKM',795,'TM.png',0),
	(220,217,'Dollar','USD','$','TC','TCA',796,'TC.png',0),
	(221,218,'Dollar','AUD','$','TV','TUV',798,'TV.png',0),
	(222,232,'Dollar','USD','$','VI','VIR',850,'VI.png',0),
	(223,219,'Shilling','UGX','','UG','UGA',800,'UG.png',0),
	(224,220,'Hryvnia','UAH','₴','UA','UKR',804,'UA.png',0),
	(225,221,'Dirham','AED','','AE','ARE',784,'AE.png',0),
	(226,222,'Pound','GBP','£','GB','GBR',826,'GB.png',1),
	(227,223,'Dollar','USD','$','US','USA',840,'US.png',0),
	(228,224,'Dollar ','USD','$','UM','UMI',581,'UM.png',0),
	(229,225,'Peso','UYU','$U','UY','URY',858,'UY.png',0),
	(230,226,'Som','UZS','лв','UZ','UZB',860,'UZ.png',0),
	(231,227,'Vatu','VUV','Vt','VU','VUT',548,'VU.png',0),
	(232,228,'Euro','EUR','€','VA','VAT',336,'VA.png',0),
	(233,229,'Bolivar','VEF','Bs','VE','VEN',862,'VE.png',0),
	(234,230,'Dong','VND','₫','VN','VNM',704,'VN.png',0),
	(235,233,'Franc','XPF','','WF','WLF',876,'WF.png',0),
	(236,234,'Dirham','MAD','','EH','ESH',732,'EH.png',0),
	(237,235,'Rial','YER','﷼','YE','YEM',887,'YE.png',0),
	(238,238,'Kwacha','ZMK','ZK','ZM','ZMB',894,'ZM.png',0),
	(239,239,'Dollar','ZWD','Z$','ZW','ZWE',716,'ZW.png',0);

/*!40000 ALTER TABLE `ti_currencies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_customer_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_customer_groups`;

CREATE TABLE `ti_customer_groups` (
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `approval` tinyint(1) NOT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_customer_groups` WRITE;
/*!40000 ALTER TABLE `ti_customer_groups` DISABLE KEYS */;

INSERT INTO `ti_customer_groups` (`customer_group_id`, `group_name`, `description`, `approval`)
VALUES
	(11,'Default','',0);

/*!40000 ALTER TABLE `ti_customer_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_customers`;

CREATE TABLE `ti_customers` (
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
  PRIMARY KEY (`customer_id`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_customers` WRITE;
/*!40000 ALTER TABLE `ti_customers` DISABLE KEYS */;

INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`)
VALUES
	(1,'Sam','Poyigi','sampoyigi@gmail.com','ca60119bc18bbcc9269f261fe0663795c182de9d','1abadfa3b','4883930902',2,16,'Shokenu',0,11,'127.0.0.1','2015-05-24 00:00:00',1),
	(2,'Samuel','Adepoyigi','samadepoyigi@gmail.com','00f95b5d7d14e5645c8df46de81bbe54968111a6','e62daffe5','3847585930',0,11,'Spike',1,11,'','2015-06-05 00:00:00',1),
	(3,'Samuel','Adepoyigi','samadepyigi@gmail.com','14b256b100ff1ea4117182917592e7a727a6fc35','eaa49bcbc','3847585930',0,11,'Spike',1,11,'','2015-06-05 00:00:00',1),
	(4,'Samuel','Adepoyigi','samadeoyigi@gmail.com','77744736aa7d83c1b47a2501e74ea3f873a4ea7a','ac0ab8d99','3847585930',0,11,'Spike',1,11,'','2015-06-05 00:00:00',1),
	(5,'Nulla','Ipsum','demo@demo.com','553eed138976c9c3cc57f6d74edc976a6be1302b','ee9c4c289','43434343',1,11,'Spike',1,11,'::1','2015-06-05 00:00:00',1);

/*!40000 ALTER TABLE `ti_customers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_customers_online
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_customers_online`;

CREATE TABLE `ti_customers_online` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_customers_online` WRITE;
/*!40000 ALTER TABLE `ti_customers_online` DISABLE KEYS */;

INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`)
VALUES
	(11,0,'browser','Firefox','127.0.0.1','0','','admin/customers_online?filter_type=all','2015-05-24 11:56:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(12,0,'browser','Firefox','127.0.0.1','0','menus','','2015-05-24 11:59:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(13,0,'browser','Firefox','127.0.0.1','0','menus','','2015-05-24 12:01:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(14,0,'browser','Firefox','127.0.0.1','0','reserve','menus','2015-05-24 12:05:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(15,0,'browser','Firefox','127.0.0.1','0','menus','reserve','2015-05-24 12:10:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(16,0,'browser','Firefox','127.0.0.1','0','local','menus','2015-05-24 12:13:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(17,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 12:17:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(18,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 12:20:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(19,0,'browser','Firefox','127.0.0.1','0','favicon.ico','','2015-05-24 13:42:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(20,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 14:33:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(21,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 14:43:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(22,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 15:22:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(23,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 16:30:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(24,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 16:38:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(25,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 16:40:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(26,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 17:13:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(27,0,'browser','Firefox','127.0.0.1','0','menus','checkout','2015-05-24 17:17:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(28,0,'browser','Firefox','127.0.0.1','0','menus','checkout','2015-05-24 17:22:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(29,0,'browser','Firefox','127.0.0.1','0','menus','checkout','2015-05-24 17:28:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(30,0,'browser','Firefox','127.0.0.1','0','menus','checkout','2015-05-24 17:37:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(31,0,'browser','Firefox','127.0.0.1','0','menus','checkout','2015-05-24 17:42:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(32,0,'browser','Firefox','127.0.0.1','0','menus','checkout','2015-05-24 17:53:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(33,0,'browser','Firefox','127.0.0.1','0','menus','','2015-05-24 17:56:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(34,0,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-05-24 17:59:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(35,0,'browser','Firefox','127.0.0.1','0','menus','account/login','2015-05-24 18:05:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(36,0,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-24 18:12:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(37,0,'browser','Firefox','127.0.0.1','0','checkout','','2015-05-24 18:22:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(38,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-05-24 18:27:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(39,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-05-24 18:29:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(40,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-05-24 18:33:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(41,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-05-24 18:35:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(42,1,'browser','Firefox','127.0.0.1','0','checkout','','2015-05-24 18:40:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(43,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-05-24 18:45:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(44,1,'browser','Firefox','127.0.0.1','0','menus','checkout/success','2015-05-24 18:54:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(45,1,'browser','Firefox','127.0.0.1','0','menus','checkout/success','2015-05-24 19:05:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(46,1,'browser','Firefox','127.0.0.1','0','','about-us','2015-05-24 19:14:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(47,1,'browser','Firefox','127.0.0.1','0','contact','','2015-05-24 19:34:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(48,1,'browser','Firefox','127.0.0.1','0','menus','contact','2015-05-25 02:21:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(49,1,'browser','Firefox','127.0.0.1','0','','menus','2015-05-25 11:38:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(50,1,'browser','Firefox','127.0.0.1','0','','','2015-05-25 11:41:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(51,1,'browser','Firefox','127.0.0.1','0','','','2015-05-25 11:52:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(52,1,'browser','Firefox','127.0.0.1','0','reserve','menus','2015-05-25 12:17:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(53,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-05-25 17:23:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(54,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-05-25 17:38:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(55,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-05-25 19:07:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(56,1,'browser','Firefox','127.0.0.1','0','account','reserve','2015-05-25 20:27:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(57,1,'browser','Firefox','127.0.0.1','0','account/inbox','account','2015-05-26 13:35:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(58,1,'browser','Firefox','127.0.0.1','0','account/inbox','account/inbox','2015-05-26 13:37:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(59,1,'browser','Firefox','127.0.0.1','0','account/inbox/view/43','account/inbox','2015-05-26 13:40:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(60,1,'browser','Firefox','127.0.0.1','0','account/inbox/view/44','account/inbox','2015-05-26 13:42:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(61,1,'browser','Firefox','127.0.0.1','0','account/inbox','account/inbox/view/44','2015-05-26 13:44:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(62,1,'browser','Firefox','127.0.0.1','0','account/inbox','account/inbox/view/44','2015-05-26 13:47:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(63,1,'browser','Firefox','127.0.0.1','0','account/reviews','account/reviews/add/order/20002/11','2015-05-26 13:52:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(64,1,'browser','Firefox','127.0.0.1','0','account/orders','account/reviews','2015-05-26 14:05:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(65,1,'browser','Firefox','127.0.0.1','0','account/reservations','account/reviews','2015-05-26 14:07:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(66,1,'browser','Firefox','127.0.0.1','0','checkout','menus','2015-05-26 15:58:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(67,1,'browser','Firefox','127.0.0.1','0','locations','local/reviews','2015-05-26 16:07:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(68,1,'browser','Firefox','127.0.0.1','0','','locations','2015-05-27 21:33:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(69,1,'browser','Firefox','127.0.0.1','0','','locations','2015-05-28 22:28:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(70,1,'browser','Firefox','127.0.0.1','0','favicon.ico','','2015-05-28 22:42:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(71,1,'browser','Firefox','127.0.0.1','0','','setup/setup','2015-05-31 13:02:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(72,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 01:03:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(73,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 01:46:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(74,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 01:49:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(75,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 01:51:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(76,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 02:15:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(77,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 02:20:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(78,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 02:24:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(79,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 02:31:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(80,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 02:34:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(81,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 02:36:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(82,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 11:37:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(83,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 11:59:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(84,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 12:08:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(85,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 12:12:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(86,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 12:28:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(87,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 12:32:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(88,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 14:13:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(89,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 14:34:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(90,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 14:41:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(91,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 15:26:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(92,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 15:32:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(93,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-02 15:57:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(94,0,'browser','Chrome','127.0.0.1','0','','','2015-06-02 15:59:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(95,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/customers_online','2015-06-02 16:07:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(96,0,'browser','Firefox','127.0.0.1','0','categories_module/categories_module','','2015-06-02 18:07:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(97,0,'browser','Firefox','127.0.0.1','0','','','2015-06-02 19:45:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(98,0,'browser','Firefox','127.0.0.1','0','','','2015-06-02 19:50:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(99,0,'browser','Firefox','127.0.0.1','0','','','2015-06-02 20:01:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(100,0,'browser','Firefox','127.0.0.1','0','','','2015-06-02 20:35:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(101,0,'browser','Firefox','127.0.0.1','0','','','2015-06-02 21:14:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(102,0,'browser','Firefox','127.0.0.1','0','','','2015-06-02 21:38:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(103,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-02 21:50:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(104,1,'browser','Firefox','127.0.0.1','0','account/inbox','','2015-06-02 21:52:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(105,1,'browser','Firefox','127.0.0.1','0','account/inbox','','2015-06-02 22:18:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(106,1,'browser','Firefox','127.0.0.1','0','account/inbox','','2015-06-02 23:34:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(107,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-03 00:11:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(108,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/extensions/edit?action=edit&name=account_module','2015-06-03 00:38:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(109,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/extensions/edit?action=edit&name=slideshow','2015-06-03 01:10:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(110,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/extensions/edit?action=edit&name=account_module','2015-06-03 01:14:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(111,0,'browser','Chrome','127.0.0.1','0','','admin/tables','2015-06-03 03:30:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(112,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/currencies','2015-06-03 11:18:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(113,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/currencies','2015-06-03 11:21:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(114,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/database','2015-06-03 13:20:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(115,0,'browser','Chrome','127.0.0.1','0','reserve','menus','2015-06-03 20:58:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(116,0,'browser','Firefox','127.0.0.1','0','','admin/notifications','2015-06-04 01:34:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(117,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/database','2015-06-04 19:48:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(118,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/maintenance/migrate','2015-06-04 19:52:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(119,0,'browser','Chrome','127.0.0.1','0','favicon.ico','admin/maintenance/migrate','2015-06-04 19:55:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(120,0,'browser','Chrome','127.0.0.1','0','','admin/dashboard','2015-06-05 00:07:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(121,0,'browser','Chrome','127.0.0.1','0','login','admin/error_logs','2015-06-05 00:43:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(122,1,'browser','Chrome','127.0.0.1','0','account/details','account/details','2015-06-05 00:48:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(123,0,'browser','Chrome','127.0.0.1','0','account/login','','2015-06-05 01:50:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(124,0,'browser','Chrome','127.0.0.1','0','account/register','account/register','2015-06-05 01:52:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(125,0,'browser','Chrome','127.0.0.1','0','account/register','account/register','2015-06-05 01:54:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(126,0,'browser','Chrome','127.0.0.1','0','','','2015-06-05 14:52:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(127,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-05 16:37:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(128,1,'browser','Chrome','127.0.0.1','0','account/inbox','account/details','2015-06-05 18:49:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(129,1,'browser','Chrome','127.0.0.1','0','account/inbox','account/details','2015-06-05 21:00:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(130,1,'browser','Chrome','127.0.0.1','0','account/logout','account','2015-06-05 21:05:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(131,1,'browser','Chrome','127.0.0.1','0','account/details','account','2015-06-05 21:15:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36'),
	(132,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-06 00:01:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(133,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-06 00:05:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(134,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-06 00:22:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(135,0,'browser','Chrome','127.0.0.1','0','favicon.ico','','2015-06-06 00:49:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(136,0,'browser','Chrome','127.0.0.1','0','account/details','','2015-06-06 20:27:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.30 Safari/537.36'),
	(137,0,'browser','Firefox','127.0.0.1','0','favicon.ico','','2015-06-07 13:25:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(138,0,'browser','Firefox','127.0.0.1','0','','admin/error_logs','2015-06-08 21:48:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(139,0,'browser','Chrome','127.0.0.1','0','account/login','','2015-06-10 00:13:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.30 Safari/537.36'),
	(140,0,'browser','Firefox','127.0.0.1','0','','admin/extensions/edit?action=edit&name=account_module&id=11','2015-06-10 09:35:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(141,0,'browser','Firefox','127.0.0.1','0','','admin/locations/edit?id=11','2015-06-11 11:15:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(142,0,'browser','Firefox','127.0.0.1','0','','admin/locations/edit?id=11','2015-06-11 11:34:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(143,0,'browser','Firefox','127.0.0.1','0','','admin/locations/edit?id=11','2015-06-11 12:02:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(144,0,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','','2015-06-11 12:07:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(145,0,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 12:21:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(146,0,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 12:28:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(147,0,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 12:40:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(148,0,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 12:43:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(149,0,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','','2015-06-11 12:53:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(150,0,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 12:57:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(151,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:05:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(152,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:07:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(153,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:14:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(154,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:16:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(155,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:20:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(156,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:23:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(157,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:25:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(158,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:30:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(159,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:32:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(160,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:36:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(161,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:38:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(162,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:41:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(163,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:43:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(164,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:46:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(165,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:48:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(166,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:51:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(167,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:53:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(168,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 13:57:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(169,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:01:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(170,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:07:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(171,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:09:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(172,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:13:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(173,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:16:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(174,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:22:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(175,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:26:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(176,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:28:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(177,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:30:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(178,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:34:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(179,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:37:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(180,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:39:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(181,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:46:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(182,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 14:55:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(183,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 15:00:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(184,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 15:02:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(185,1,'browser','Firefox','127.0.0.1','0','account','menus','2015-06-11 15:04:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(186,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 15:54:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(187,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 15:57:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(188,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 16:06:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(189,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 16:09:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(190,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 16:19:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(191,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','menus','2015-06-11 16:37:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(192,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-11 16:39:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(193,1,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 16:47:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(194,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 16:53:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(195,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 16:55:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(196,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 16:58:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(197,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:01:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(198,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:04:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(199,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:20:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(200,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:27:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(201,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:30:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(202,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:38:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(203,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:41:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(204,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:44:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(205,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:48:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(206,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:50:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(207,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:52:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(208,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:55:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(209,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 17:59:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(210,1,'browser','Firefox','127.0.0.1','0','','','2015-06-11 18:01:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(211,1,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 18:03:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(212,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','menus','2015-06-11 18:06:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(213,1,'browser','Firefox','127.0.0.1','0','menus','menus','2015-06-11 18:09:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(214,1,'browser','Firefox','127.0.0.1','0','menus','menus','2015-06-11 18:14:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(215,1,'browser','Firefox','127.0.0.1','0','menus','menus','2015-06-11 18:20:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(216,1,'browser','Firefox','127.0.0.1','0','','reserve','2015-06-11 18:22:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(217,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 18:26:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(218,1,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 18:28:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(219,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 18:32:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(220,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-11 18:34:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(221,1,'browser','Firefox','127.0.0.1','0','menus','menus','2015-06-11 18:37:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(222,1,'browser','Firefox','127.0.0.1','0','','menus','2015-06-11 18:40:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(223,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','menus','2015-06-11 18:56:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(224,1,'browser','Firefox','127.0.0.1','0','locations','menus','2015-06-11 19:10:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(225,1,'browser','Firefox','127.0.0.1','0','local','','2015-06-11 19:19:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(226,1,'browser','Firefox','127.0.0.1','0','local','','2015-06-11 19:24:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(227,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 19:27:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(228,1,'browser','Firefox','127.0.0.1','0','local/jj/lll/ljjj','','2015-06-11 19:30:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(229,1,'browser','Firefox','127.0.0.1','0','local/jj/lll/ljjj','','2015-06-11 19:32:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(230,1,'browser','Firefox','127.0.0.1','0','menus','local/jj/lll/ljjj','2015-06-11 19:42:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(231,1,'browser','Firefox','127.0.0.1','0','menus','local/jj/lll/ljjj','2015-06-11 19:47:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(232,1,'browser','Firefox','127.0.0.1','0','menus','local/jj/lll/ljjj','2015-06-11 19:57:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(233,1,'browser','Firefox','127.0.0.1','0','local/jj/lll/ljjj','','2015-06-11 20:09:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(234,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:12:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(235,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:15:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(236,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:19:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(237,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:22:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(238,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:25:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(239,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:29:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(240,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:31:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(241,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:33:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(242,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 20:35:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(243,1,'browser','Firefox','127.0.0.1','0','menus','local/lewisham','2015-06-11 20:38:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(244,1,'browser','Firefox','127.0.0.1','0','local/locations','menus','2015-06-11 20:41:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(245,1,'browser','Firefox','127.0.0.1','0','locations','','2015-06-11 20:47:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(246,1,'browser','Firefox','127.0.0.1','0','local','','2015-06-11 21:09:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(247,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 21:13:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(248,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 21:18:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(249,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 21:21:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(250,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 21:24:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(251,1,'browser','Firefox','127.0.0.1','0','local','','2015-06-11 21:27:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(252,1,'browser','Firefox','127.0.0.1','0','local','','2015-06-11 21:29:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(253,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 21:31:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(254,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 21:34:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(255,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 21:37:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(256,1,'browser','Firefox','127.0.0.1','0','local','','2015-06-11 23:27:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(257,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:31:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(258,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:33:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(259,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:37:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(260,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:40:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(261,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:43:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(262,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:46:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(263,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:48:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(264,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:51:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(265,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-11 23:55:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(266,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:00:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(267,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:06:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(268,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:12:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(269,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:19:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(270,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:24:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(271,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:26:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(272,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:29:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(273,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:33:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(274,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:36:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(275,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:39:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(276,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:41:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(277,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:45:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(278,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:47:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(279,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:51:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(280,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:53:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(281,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:55:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(282,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 00:57:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(283,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:01:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(284,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:04:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(285,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:10:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(286,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:13:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(287,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:17:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(288,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:21:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(289,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:24:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(290,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:26:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(291,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:29:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(292,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:31:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(293,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:35:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(294,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:38:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(295,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:42:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(296,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:48:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(297,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:51:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(298,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:54:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(299,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 01:59:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(300,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 02:02:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(301,1,'browser','Firefox','127.0.0.1','0','local/reviews','','2015-06-12 02:30:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(302,1,'browser','Firefox','127.0.0.1','0','local/reviews','','2015-06-12 02:34:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(303,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 02:38:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(304,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-12 02:41:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(305,1,'browser','Firefox','127.0.0.1','0','locations','menus','2015-06-12 02:45:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(306,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 02:48:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(307,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 02:51:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(308,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 02:54:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(309,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 02:57:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(310,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 03:00:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(311,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-12 03:02:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(312,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-12 11:22:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(313,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-12 11:32:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(314,1,'browser','Firefox','127.0.0.1','0','','local/lewisham','2015-06-12 11:36:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(315,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 11:57:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(316,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 12:11:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(317,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-12 12:14:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(318,0,'browser','Chrome','127.0.0.1','0','','','2015-06-12 13:19:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(319,0,'browser','Chrome','127.0.0.1','0','','local?location_id=','2015-06-12 13:22:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(320,0,'browser','Chrome','127.0.0.1','0','','local?location_id=','2015-06-12 13:24:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(321,0,'browser','Chrome','127.0.0.1','0','local_module/local_module/search','local?location_id=','2015-06-12 13:26:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(322,0,'browser','Chrome','127.0.0.1','0','','local?location_id=','2015-06-12 13:33:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(323,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 13:35:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(324,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 13:38:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(325,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 13:41:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(326,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 13:52:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(327,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 13:55:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(328,0,'browser','Chrome','127.0.0.1','0','','local?location_id=','2015-06-12 13:59:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(329,0,'browser','Chrome','127.0.0.1','0','','local?location_id=','2015-06-12 14:03:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(330,0,'browser','Chrome','127.0.0.1','0','','local?location_id=','2015-06-12 14:05:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(331,0,'browser','Chrome','127.0.0.1','0','local','','2015-06-12 14:12:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(332,0,'browser','Chrome','127.0.0.1','0','local','','2015-06-12 14:17:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(333,0,'browser','Chrome','127.0.0.1','0','local','','2015-06-12 14:21:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(334,0,'browser','Chrome','127.0.0.1','0','local','','2015-06-12 14:26:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(335,0,'browser','Chrome','127.0.0.1','0','local','','2015-06-12 14:30:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(336,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-12 14:36:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(337,0,'browser','Chrome','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 14:38:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(338,0,'browser','Chrome','127.0.0.1','0','local/lewishamm','','2015-06-12 14:42:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(339,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-12 15:15:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(340,0,'browser','Chrome','127.0.0.1','0','menus','','2015-06-12 15:18:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(341,1,'browser','Firefox','127.0.0.1','0','locations','','2015-06-12 15:25:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(342,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-12 15:29:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(343,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 15:32:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(344,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-12 15:34:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(345,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','local/lewisham','2015-06-12 16:22:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(346,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 16:25:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(347,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 16:50:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(348,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 16:54:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(349,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 16:57:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(350,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:01:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(351,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:04:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(352,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:06:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(353,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:10:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(354,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:13:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(355,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:15:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(356,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:17:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(357,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:19:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(358,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 17:25:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(359,1,'browser','Firefox','127.0.0.1','0','','local/lewisham','2015-06-12 17:28:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(360,1,'browser','Firefox','127.0.0.1','0','','local/lewisham','2015-06-12 17:31:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(361,1,'browser','Firefox','127.0.0.1','0','','local/lewisham','2015-06-12 17:35:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(362,1,'browser','Firefox','127.0.0.1','0','','','2015-06-12 17:40:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(363,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-12 17:42:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(364,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 17:46:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(365,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 17:51:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(366,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 17:53:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(367,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','local/lewisham','2015-06-12 17:55:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(368,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:00:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(369,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:03:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(370,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-12 18:05:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(371,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:08:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(372,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:10:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(373,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:13:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(374,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:16:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(375,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','local/lewisham','2015-06-12 18:18:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(376,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:21:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(377,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-12 18:23:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(378,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:25:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(379,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:29:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(380,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:31:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(381,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 18:33:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(382,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:36:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(383,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 18:49:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(384,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:51:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(385,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 18:54:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(386,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 19:07:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(387,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:09:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(388,0,'browser','Chrome','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:16:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(389,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:18:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(390,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:20:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(391,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:22:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(392,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-12 19:25:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(393,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 19:29:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(394,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:34:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(395,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 19:36:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(396,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 19:41:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(397,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 19:44:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(398,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 19:47:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(399,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-12 19:50:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(400,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:52:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(401,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:56:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(402,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 19:58:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(403,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-12 20:03:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(404,0,'browser','Chrome','127.0.0.1','0','menus','','2015-06-12 20:06:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(405,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 20:08:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(406,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-12 20:11:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(407,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 20:14:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(408,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 20:17:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(409,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 20:20:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(410,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-12 20:25:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(411,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-12 20:31:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(412,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-12 20:36:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(413,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 20:38:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(414,0,'browser','Chrome','127.0.0.1','0','checkout','','2015-06-12 20:40:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(415,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 20:45:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(416,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 20:49:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(417,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 20:51:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(418,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-12 20:53:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(419,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 21:05:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(420,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 21:09:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(421,1,'browser','Firefox','127.0.0.1','0','local/info','','2015-06-12 21:11:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(422,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 21:34:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(423,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 21:40:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(424,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-12 21:47:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(425,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 21:49:32',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(426,1,'browser','Firefox','127.0.0.1','0','','local/lewisham','2015-06-12 21:52:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(427,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','','2015-06-12 21:57:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(428,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 22:05:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(429,1,'browser','Firefox','127.0.0.1','0','','local/lewisham','2015-06-12 22:12:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(430,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham','2015-06-12 22:14:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(431,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 22:21:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(432,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 22:24:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(433,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 22:29:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(434,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-12 22:32:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(435,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 22:36:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(436,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 22:51:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(437,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 22:54:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(438,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 22:57:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(439,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:05:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(440,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:07:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(441,1,'browser','Firefox','127.0.0.1','0','local_module/local_module','','2015-06-12 23:10:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(442,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:14:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(443,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:16:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(444,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:25:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(445,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:28:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(446,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:30:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(447,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','local/lewisham','2015-06-12 23:32:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(448,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:34:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(449,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:38:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(450,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','local/lewisham','2015-06-12 23:40:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(451,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:43:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(452,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-12 23:49:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(453,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-13 00:01:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(454,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-13 00:28:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(455,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-13 00:31:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(456,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-13 00:35:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(457,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-13 00:38:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(458,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 00:40:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(459,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/coupon','local/lewisham','2015-06-13 00:44:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(460,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 00:47:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(461,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-13 00:49:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(462,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-13 00:56:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(463,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-13 00:58:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(464,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-13 01:01:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(465,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-13 01:05:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(466,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-13 01:10:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(467,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','checkout','2015-06-13 01:12:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(468,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-13 01:14:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(469,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-13 01:17:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(470,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-13 01:19:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(471,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-13 01:22:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(472,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:26:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(473,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:31:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(474,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:37:32',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(475,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:41:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(476,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:47:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(477,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:50:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(478,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:54:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(479,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 01:59:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(480,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 02:02:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(481,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','local/lewisham','2015-06-13 02:04:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(482,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 02:06:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(483,0,'browser','Chrome','127.0.0.1','0','checkout','local/lewisham','2015-06-13 02:15:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(484,0,'browser','Chrome','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 02:17:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(485,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 02:26:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(486,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 02:36:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(487,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 02:39:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(488,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-13 02:42:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(489,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','local/lewisham','2015-06-13 10:21:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(490,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:24:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(491,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:27:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(492,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:32:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(493,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:36:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(494,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:38:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(495,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:43:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(496,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:50:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(497,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:52:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(498,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:54:32',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(499,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 10:57:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(500,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 11:01:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(501,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 11:05:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(502,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 11:07:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(503,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 19:15:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(504,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 19:18:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(505,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 19:27:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(506,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 19:35:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(507,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 19:37:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(508,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 19:49:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(509,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 19:52:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(510,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 20:00:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(511,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 20:07:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(512,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 20:09:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(513,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 20:12:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(514,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 20:14:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(515,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 20:17:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(516,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 20:20:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(517,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:00:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(518,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:02:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(519,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:05:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(520,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 21:07:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(521,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 21:20:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(522,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 21:25:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(523,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 21:30:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(524,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:32:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(525,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 21:35:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(526,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 21:37:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(527,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-13 21:43:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(528,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 21:46:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(529,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:49:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(530,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:51:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(531,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:54:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(532,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:57:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(533,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 21:59:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(534,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:02:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(535,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:07:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(536,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:10:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(537,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:14:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(538,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 22:16:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(539,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:19:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(540,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:22:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(541,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 22:24:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(542,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:27:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(543,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 22:30:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(544,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:33:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(545,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 22:37:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(546,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:39:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(547,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 22:41:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(548,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 22:45:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(549,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:50:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(550,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 22:52:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(551,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 22:54:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(552,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-13 22:58:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(553,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 23:00:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(554,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:02:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(555,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 23:04:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(556,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:10:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(557,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:13:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(558,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 23:16:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(559,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 23:18:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(560,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:21:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(561,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:23:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(562,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:27:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(563,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:31:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(564,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:34:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(565,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:38:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(566,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:46:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(567,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:54:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(568,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/add','local/lewisham','2015-06-13 23:56:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(569,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-13 23:59:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(570,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-14 00:02:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(571,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-14 00:08:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(572,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-14 00:17:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(573,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-14 00:22:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(574,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-14 00:31:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(575,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','local/lewisham','2015-06-14 00:34:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(576,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-14 00:36:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(577,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-14 01:05:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(578,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 01:08:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(579,1,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-14 01:10:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(580,1,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-14 01:12:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(581,1,'browser','Firefox','127.0.0.1','0','checkout','local/hackney','2015-06-14 01:15:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(582,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','local/hackney','2015-06-14 01:17:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(583,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/hackney','2015-06-14 01:21:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(584,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/hackney','2015-06-14 01:25:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(585,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/hackney','2015-06-14 01:27:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(586,1,'browser','Firefox','127.0.0.1','0','local/hackney','local/hackney','2015-06-14 01:30:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(587,1,'browser','Firefox','127.0.0.1','0','local/hackney','local/hackney','2015-06-14 01:32:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(588,1,'browser','Firefox','127.0.0.1','0','local/hackney','local/hackney','2015-06-14 01:35:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(589,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/hackney','2015-06-14 01:37:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(590,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/hackney','2015-06-14 02:09:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(591,1,'browser','Firefox','127.0.0.1','0','local/lewisham','local/hackney','2015-06-14 02:12:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(592,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-14 02:14:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(593,1,'browser','Firefox','127.0.0.1','0','locations','local/hackney','2015-06-14 02:17:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(594,1,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-14 02:19:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(595,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/order_type','local/lewisham','2015-06-14 02:22:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(596,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-14 02:25:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(597,0,'browser','Chrome','127.0.0.1','0','account/login','','2015-06-14 11:05:55',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.30 Safari/537.36'),
	(598,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-14 11:08:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(599,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-06-14 11:14:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(600,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-06-14 11:22:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(601,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 11:32:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(602,0,'browser','Chrome','127.0.0.1','0','','account/login','2015-06-14 12:58:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.30 Safari/537.36'),
	(603,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-14 14:02:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(604,0,'browser','Chrome','127.0.0.1','0','','','2015-06-14 14:18:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(605,1,'browser','Firefox','127.0.0.1','0','checkout','local/hackney','2015-06-14 14:23:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(606,0,'browser','Chrome','127.0.0.1','0','','account/register','2015-06-14 14:32:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(607,0,'browser','Chrome','127.0.0.1','0','','account/register','2015-06-14 14:37:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(608,1,'browser','Firefox','127.0.0.1','0','','checkout','2015-06-14 14:43:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(609,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 14:55:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(610,1,'browser','Firefox','127.0.0.1','0','reserve','reserve','2015-06-14 15:06:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(611,1,'browser','Firefox','127.0.0.1','0','locations','reserve','2015-06-14 15:11:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(612,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-14 15:16:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(613,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/order_type','local/hackney','2015-06-14 15:21:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(614,1,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-14 15:27:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(615,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','local/hackney','2015-06-14 15:44:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(616,1,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-14 15:52:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(617,1,'browser','Firefox','127.0.0.1','0','checkout','local/hackney','2015-06-14 15:58:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(618,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 16:04:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(619,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 16:24:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(620,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 16:30:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(621,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 16:40:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(622,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 16:52:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(623,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 17:00:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(624,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 17:07:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(625,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 17:12:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(626,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 17:19:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(627,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 17:29:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(628,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 17:37:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(629,1,'browser','Firefox','127.0.0.1','0','cart_module/cart_module','','2015-06-14 18:15:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(630,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 18:22:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(631,1,'browser','Firefox','127.0.0.1','0','menus','local/lewisham','2015-06-14 18:43:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(632,1,'browser','Firefox','127.0.0.1','0','menus','local/lewisham','2015-06-14 18:50:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(633,1,'browser','Firefox','127.0.0.1','0','menus','local/lewisham','2015-06-14 19:06:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(634,1,'browser','Firefox','127.0.0.1','0','menus','local/lewisham','2015-06-14 19:11:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(635,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 19:19:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(636,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-14 19:24:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(637,1,'browser','Firefox','127.0.0.1','0','','','2015-06-14 19:30:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(638,1,'browser','Firefox','127.0.0.1','0','account/inbox','account','2015-06-14 19:36:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(639,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-14 20:05:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(640,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 20:12:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(641,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 20:30:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(642,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 20:38:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(643,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 20:43:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(644,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 20:49:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(645,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 20:56:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(646,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 21:02:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(647,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 21:08:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(648,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 21:35:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(649,1,'browser','Firefox','127.0.0.1','0','local/reviews','locations','2015-06-14 21:40:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(650,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 21:52:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(651,1,'browser','Firefox','127.0.0.1','0','locations','local/lewisham','2015-06-14 21:58:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(652,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-14 22:04:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(653,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham/','2015-06-15 00:54:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(654,1,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham/','2015-06-15 01:02:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(655,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-06-15 01:08:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(656,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-06-15 01:14:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(657,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-15 01:31:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(658,1,'browser','Firefox','127.0.0.1','0','checkout/success','checkout','2015-06-15 01:37:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(659,1,'browser','Firefox','127.0.0.1','0','checkout/success','checkout','2015-06-15 01:57:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(660,1,'browser','Firefox','127.0.0.1','0','checkout/success','checkout','2015-06-15 02:07:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(661,1,'browser','Firefox','127.0.0.1','0','checkout/success','checkout','2015-06-15 02:14:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(662,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-06-15 02:19:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(663,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-06-15 02:24:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(664,1,'browser','Firefox','127.0.0.1','0','checkout','checkout','2015-06-15 02:29:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(665,1,'browser','Firefox','127.0.0.1','0','checkout/success','checkout','2015-06-15 14:09:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(666,0,'browser','Chrome','127.0.0.1','0','cart_module/cart_module/options','menus','2015-06-15 14:14:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(667,0,'browser','Chrome','127.0.0.1','0','local/lewisham','menus','2015-06-15 14:19:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(668,0,'browser','Chrome','127.0.0.1','0','local/lewisham','menus','2015-06-15 14:27:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(669,0,'browser','Chrome','127.0.0.1','0','cart_module/cart_module/options','local/lewisham','2015-06-15 14:32:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(670,0,'browser','Chrome','127.0.0.1','0','checkout','checkout','2015-06-15 14:40:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(671,0,'browser','Chrome','127.0.0.1','0','cart_module/cart_module','local/lewisham','2015-06-15 14:45:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(672,0,'browser','Chrome','127.0.0.1','0','locations','','2015-06-15 15:06:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.39 Safari/537.36'),
	(673,0,'browser','Chrome','127.0.0.1','0','checkout/success','checkout','2015-06-15 15:15:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(674,0,'browser','Chrome','127.0.0.1','0','checkout/success','checkout','2015-06-15 15:20:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(675,1,'browser','Firefox','127.0.0.1','0','checkout/success','checkout','2015-06-15 15:26:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(676,1,'browser','Firefox','127.0.0.1','0','checkout/success','','2015-06-15 15:32:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(677,0,'browser','Chrome','127.0.0.1','0','checkout','checkout','2015-06-15 15:37:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(678,0,'browser','Chrome','127.0.0.1','0','checkout','checkout','2015-06-15 15:53:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(679,1,'browser','Firefox','127.0.0.1','0','locations','','2015-06-15 16:01:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(680,1,'browser','Firefox','127.0.0.1','0','locations','','2015-06-15 17:00:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(681,1,'browser','Firefox','127.0.0.1','0','local/earling','locations','2015-06-15 17:55:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(682,1,'browser','Firefox','127.0.0.1','0','locations','local/earling','2015-06-15 18:00:32',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(683,1,'browser','Firefox','127.0.0.1','0','locations','local/earling','2015-06-15 18:07:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(684,1,'browser','Firefox','127.0.0.1','0','locations','local/earling','2015-06-15 18:16:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(685,1,'browser','Firefox','127.0.0.1','0','local/earling','locations','2015-06-15 18:25:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(686,1,'browser','Firefox','127.0.0.1','0','locations','local/earling','2015-06-15 18:30:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(687,1,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-15 18:37:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(688,1,'browser','Firefox','127.0.0.1','0','locations','local/hackney','2015-06-15 18:43:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(689,0,'browser','Chrome','127.0.0.1','0','checkout/success','checkout','2015-06-15 20:42:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(690,0,'browser','Chrome','127.0.0.1','0','local/hackney','local/hackney','2015-06-15 20:48:07',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(691,0,'browser','Chrome','127.0.0.1','0','local/hackney','local/hackney','2015-06-15 20:53:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(692,0,'browser','Chrome','127.0.0.1','0','local/earling','locations','2015-06-15 21:00:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(693,0,'browser','Chrome','127.0.0.1','0','local/earling','locations','2015-06-15 21:05:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(694,0,'browser','Chrome','127.0.0.1','0','local/earling','local/earling','2015-06-15 21:12:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(695,1,'browser','Firefox','127.0.0.1','0','locations','locations','2015-06-15 21:18:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(696,1,'browser','Firefox','127.0.0.1','0','locations','','2015-06-15 21:23:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(697,1,'browser','Firefox','127.0.0.1','0','locations','','2015-06-15 23:09:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(698,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-16 01:24:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(699,1,'browser','Firefox','127.0.0.1','0','contact','local/lewisham','2015-06-16 01:37:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(700,0,'browser','Chrome','127.0.0.1','0','account/login','checkout/success','2015-06-16 02:17:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(701,1,'browser','Firefox','127.0.0.1','0','','contact','2015-06-16 12:03:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(702,1,'browser','Firefox','127.0.0.1','0','account','locations','2015-06-16 13:56:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(703,1,'browser','Firefox','127.0.0.1','0','account','locations','2015-06-16 14:11:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(704,1,'browser','Firefox','127.0.0.1','0','account','account/details','2015-06-16 14:18:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(705,1,'browser','Firefox','127.0.0.1','0','account/address/edit/2','account','2015-06-16 14:33:32',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(706,1,'browser','Firefox','127.0.0.1','0','account','local/lewisham','2015-06-16 14:43:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(707,1,'browser','Firefox','127.0.0.1','0','account/details','account','2015-06-16 15:03:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(708,1,'browser','Firefox','127.0.0.1','0','account/details','account','2015-06-16 15:55:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(709,1,'browser','Firefox','127.0.0.1','0','account/address','account/details','2015-06-16 16:14:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(710,1,'browser','Firefox','127.0.0.1','0','account/orders','account/address/edit/2','2015-06-16 16:19:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(711,1,'browser','Firefox','127.0.0.1','0','account/orders','account/orders','2015-06-16 16:28:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(712,1,'browser','Firefox','127.0.0.1','0','account/address','account/orders','2015-06-16 16:35:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(713,1,'browser','Firefox','127.0.0.1','0','account/orders','account/address','2015-06-16 16:59:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(714,1,'browser','Firefox','127.0.0.1','0','account/orders','account/address','2015-06-16 17:07:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(715,1,'browser','Firefox','127.0.0.1','0','account/orders','account/address','2015-06-16 18:41:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(716,1,'browser','Firefox','127.0.0.1','0','account/orders/view/20007','account/orders','2015-06-16 18:49:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(717,1,'browser','Firefox','127.0.0.1','0','account/reviews','account/reservations','2015-06-16 19:10:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(718,1,'browser','Firefox','127.0.0.1','0','account/reviews','account/orders','2015-06-16 19:19:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(719,1,'browser','Firefox','127.0.0.1','0','account/inbox','account/reviews','2015-06-16 19:25:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(720,1,'browser','Firefox','127.0.0.1','0','account/reviews','account/reservations','2015-06-16 19:35:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(721,1,'browser','Firefox','127.0.0.1','0','account/logout','account/inbox','2015-06-16 19:44:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(722,0,'browser','Firefox','127.0.0.1','0','account/register','account/register','2015-06-16 19:50:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(723,0,'browser','Firefox','127.0.0.1','0','local/lewisham','menus','2015-06-16 19:56:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(724,0,'browser','Firefox','127.0.0.1','0','locations','local/hackney','2015-06-16 20:03:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(725,0,'browser','Firefox','127.0.0.1','0','account/login','reserve','2015-06-16 21:18:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(726,1,'browser','Firefox','127.0.0.1','0','account/details','account','2015-06-16 21:24:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(727,1,'browser','Firefox','127.0.0.1','0','account/details','account','2015-06-16 21:29:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(728,1,'browser','Firefox','127.0.0.1','0','account/address/edit/2','account/address','2015-06-16 21:34:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(729,1,'browser','Firefox','127.0.0.1','0','account/orders','account','2015-06-16 21:44:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(730,1,'browser','Firefox','127.0.0.1','0','local/lewisham','account/orders','2015-06-16 21:49:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(731,1,'browser','Firefox','127.0.0.1','0','account/orders/view/20008','account/orders','2015-06-16 21:56:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(732,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-16 22:04:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(733,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-16 22:10:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(734,1,'browser','Firefox','127.0.0.1','0','local/lewisham','account/orders/view/20006','2015-06-16 22:19:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(735,1,'browser','Firefox','127.0.0.1','0','local/lewisham','account/orders/view/20006','2015-06-16 22:24:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(736,1,'browser','Firefox','127.0.0.1','0','local/lewisham','account/orders/view/20006','2015-06-16 22:30:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(737,1,'browser','Firefox','127.0.0.1','0','local/lewisham','account/orders/view/20006','2015-06-16 22:35:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(738,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-16 22:41:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(739,0,'browser','Firefox','127.0.0.1','0','account/reset','account/login','2015-06-17 07:50:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(740,0,'browser','Firefox','127.0.0.1','0','account/reset','account/login','2015-06-17 07:56:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(741,0,'browser','Firefox','127.0.0.1','0','account/login','account/reset','2015-06-17 08:03:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(742,0,'browser','Firefox','127.0.0.1','0','account/login','','2015-06-17 08:08:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(743,0,'browser','Firefox','127.0.0.1','0','account/login','','2015-06-17 08:14:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(744,0,'browser','Firefox','127.0.0.1','0','cart_module/cart_module/options','admin/customers_online/all?page=4','2015-06-17 08:24:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(745,0,'browser','Firefox','127.0.0.1','0','account/reset','account/login','2015-06-17 09:57:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(746,0,'browser','Firefox','127.0.0.1','0','account/reset','account/reset','2015-06-17 10:04:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(747,1,'browser','Firefox','127.0.0.1','0','account','account/orders','2015-06-17 10:10:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(748,1,'browser','Firefox','127.0.0.1','0','locations','account','2015-06-17 12:08:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(749,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-17 12:13:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(750,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-17 12:25:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(751,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-17 12:33:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(752,1,'browser','Firefox','127.0.0.1','0','local/lewisham','locations','2015-06-17 12:40:42',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(753,1,'browser','Firefox','127.0.0.1','0','about-us','local/hackney','2015-06-17 12:46:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(754,1,'browser','Firefox','127.0.0.1','0','about-us','local/hackney','2015-06-17 12:52:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(755,0,'browser','Chrome','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-17 17:06:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(756,0,'browser','Chrome','127.0.0.1','0','local/lewisham','local/lewisham','2015-06-17 17:16:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(757,1,'browser','Firefox','127.0.0.1','0','account/orders','account/address','2015-06-17 17:24:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(758,1,'browser','Firefox','127.0.0.1','0','account','account/orders/view/20005','2015-06-17 17:31:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(759,1,'browser','Firefox','127.0.0.1','0','account','account/orders/view/20005','2015-06-17 17:43:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(760,1,'browser','Firefox','127.0.0.1','0','account/orders','account/address/edit/2','2015-06-17 17:57:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(761,1,'browser','Firefox','127.0.0.1','0','reserve','local/lewisham','2015-06-17 18:02:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(762,1,'browser','Firefox','127.0.0.1','0','account/details','account','2015-06-17 18:08:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(763,1,'browser','Firefox','127.0.0.1','0','account','account/address/edit','2015-06-17 18:15:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(764,1,'browser','Firefox','127.0.0.1','0','account/orders','account/reviews/view/1','2015-06-17 18:25:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(765,1,'browser','Firefox','127.0.0.1','0','about-us','pages?page_id=12','2015-06-17 18:31:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(766,1,'browser','Firefox','127.0.0.1','0','about-us','pages?page_id=12','2015-06-17 18:50:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(767,1,'browser','Firefox','127.0.0.1','0','contact','about-us','2015-06-17 19:08:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(768,1,'browser','Firefox','127.0.0.1','0','contact','about-us','2015-06-17 19:13:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(769,1,'browser','Firefox','127.0.0.1','0','contact','about-us','2015-06-17 19:18:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(770,0,'browser','Chrome','127.0.0.1','0','contact','locations','2015-06-17 19:26:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(771,1,'browser','Firefox','127.0.0.1','0','','contact','2015-06-18 08:15:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(772,1,'browser','Firefox','127.0.0.1','0','menus','','2015-06-18 18:20:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(773,1,'browser','Firefox','127.0.0.1','0','contact','menus','2015-06-18 18:49:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(774,1,'browser','Firefox','127.0.0.1','0','reserve','reserve','2015-06-18 19:33:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(775,1,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-18 19:53:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(776,1,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-18 19:58:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(777,1,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-18 20:06:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(778,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=25-06-2015&occasion=3','2015-06-18 20:12:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(779,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=25-06-2015&occasion=3','2015-06-18 20:18:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(780,1,'browser','Firefox','127.0.0.1','0','local_module/local_module/order_type','checkout','2015-06-18 20:23:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(781,1,'browser','Firefox','127.0.0.1','0','local/lewisham','checkout','2015-06-18 20:40:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(782,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 20:49:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(783,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:06:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(784,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:11:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(785,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:18:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(786,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:27:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(787,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:34:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(788,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:41:31',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(789,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:48:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(790,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 21:54:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(791,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 22:00:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(792,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 22:05:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(793,1,'browser','Firefox','127.0.0.1','0','','local/lewisham/','2015-06-18 22:12:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(794,0,'browser','Firefox','127.0.0.1','0','','account/login','2015-06-18 22:17:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(795,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-18 22:23:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(796,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-18 22:28:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(797,0,'browser','Firefox','127.0.0.1','0','','locations','2015-06-18 22:35:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(798,0,'browser','Firefox','127.0.0.1','0','','locations','2015-06-18 23:56:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(799,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 00:03:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(800,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 00:08:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(801,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-19 00:16:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(802,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-19 00:22:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(803,0,'browser','Chrome','127.0.0.1','0','local/lewisham','locations','2015-06-19 00:28:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(804,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 00:34:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(805,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 00:44:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(806,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 00:50:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(807,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 00:56:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(808,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 01:02:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(809,0,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-19 01:07:32',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(810,0,'browser','Firefox','127.0.0.1','0','checkout','local/lewisham','2015-06-19 01:14:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(811,0,'browser','Firefox','127.0.0.1','0','local_module/local_module/search','local/lewisham/','2015-06-19 01:19:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(812,0,'browser','Firefox','127.0.0.1','0','reservation','local/lewisham','2015-06-19 13:14:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(813,0,'browser','Firefox','127.0.0.1','0','reservation','local/lewisham','2015-06-19 13:20:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(814,0,'browser','Firefox','127.0.0.1','0','menus','','2015-06-20 21:37:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(815,0,'browser','Firefox','127.0.0.1','0','reservation','menus','2015-06-21 13:11:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(816,0,'browser','Firefox','127.0.0.1','0','reservation','menus','2015-06-21 13:16:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(817,0,'browser','Firefox','127.0.0.1','0','reservation','menus','2015-06-21 19:32:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(818,0,'browser','Firefox','127.0.0.1','0','reservation','menus','2015-06-21 20:27:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(819,0,'browser','Firefox','127.0.0.1','0','reservation','menus','2015-06-21 20:33:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(820,0,'browser','Firefox','127.0.0.1','0','reservation','menus','2015-06-21 20:50:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(821,0,'browser','Firefox','127.0.0.1','0','reservation','menus','2015-06-21 20:58:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(822,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=&occasion=0','2015-06-21 21:04:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(823,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=24-06-2015&occasion=0','2015-06-21 22:16:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(824,0,'browser','Firefox','127.0.0.1','0','reservation','reservation','2015-06-22 09:47:22',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(825,0,'browser','Firefox','127.0.0.1','0','reservation','reservation','2015-06-22 11:30:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(826,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=&occasion=0','2015-06-22 11:38:30',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(827,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=&occasion=0','2015-06-22 11:44:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(828,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=25-06-2015&occasion=1','2015-06-22 11:49:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(829,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=25-06-2015&occasion=1','2015-06-22 11:57:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(830,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-22 12:02:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(831,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?','2015-06-22 12:07:40',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(832,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=24-06-2015&reserve_time=12%3A15+PM','2015-06-22 12:15:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(833,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=24-06-2015&reserve_time=12%3A15+PM','2015-06-22 12:20:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(834,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=24-06-2015&reserve_time=12%3A15+PM','2015-06-22 12:30:14',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(835,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?','2015-06-22 12:35:19',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(836,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=13&guest_num=2&reserve_date=24-06-2015&reserve_time=12%3A45+PM','2015-06-22 15:08:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(837,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-22 15:15:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(838,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A30+PM','2015-06-22 15:52:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(839,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A00+AM','2015-06-22 15:57:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(840,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=1%3A00+AM','2015-06-22 16:21:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(841,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=1%3A00+AM','2015-06-22 16:26:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(842,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=13&guest_num=2&reserve_date=30-06-2015&reserve_time=2%3A00+AM','2015-06-22 16:31:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(843,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=2%3A00+AM','2015-06-22 16:46:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(844,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=2%3A00+AM','2015-06-22 17:28:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(845,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=1%3A45+AM','2015-06-22 17:40:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(846,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+AM','2015-06-22 17:48:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(847,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 17:54:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(848,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 17:59:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(849,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 18:04:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(850,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 18:10:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(851,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 18:52:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(852,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 19:01:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(853,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 19:07:04',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(854,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 20:46:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(855,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 20:57:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(856,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-22 21:03:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(857,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=3%3A45+PM','2015-06-23 00:02:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(858,0,'browser','Firefox','127.0.0.1','0','reservation','local/hackney','2015-06-23 00:07:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(859,0,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-23 00:12:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(860,0,'browser','Firefox','127.0.0.1','0','reservation','local/hackney','2015-06-23 00:18:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(861,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=&reserve_time=12%3A30+AM','2015-06-23 00:25:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(862,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=12%3A30+AM','2015-06-23 09:27:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(863,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 11:03:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(864,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 11:17:39',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(865,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 11:33:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(866,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 11:40:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(867,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 11:46:52',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(868,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=12&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 11:57:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(869,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 12:03:21',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(870,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 12:32:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(871,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 13:13:34',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(872,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 13:19:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(873,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 13:47:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(874,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 13:53:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(875,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 13:58:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(876,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 14:04:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(877,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 14:11:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(878,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 14:16:58',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(879,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 14:26:09',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(880,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 14:40:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(881,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 14:48:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(882,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 14:55:48',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(883,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A30+PM','2015-06-23 15:08:46',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(884,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 15:13:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(885,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 15:19:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(886,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A00+PM','2015-06-23 15:36:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(887,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A00+PM','2015-06-23 15:42:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(888,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A00+PM','2015-06-23 15:47:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(889,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A00+PM','2015-06-23 16:48:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(890,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A00+PM','2015-06-23 16:54:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(891,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=4%3A00+PM','2015-06-23 17:00:13',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(892,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 17:13:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(893,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 17:21:00',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(894,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 17:33:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(895,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 17:38:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(896,0,'browser','Firefox','127.0.0.1','0','reservation','','2015-06-23 17:44:16',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(897,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=24-06-2015&reserve_time=5%3A45+PM','2015-06-23 17:49:32',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(898,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=24-06-2015&reserve_time=5%3A45+PM','2015-06-23 17:57:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(899,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=24-06-2015&reserve_time=6%3A15+PM&selected_time=6%3A15+PM','2015-06-23 18:02:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(900,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=25-06-2015&reserve_time=6%3A15+PM','2015-06-23 18:09:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(901,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=25-06-2015&reserve_time=6%3A15+PM','2015-06-23 18:14:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(902,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=25-06-2015&reserve_time=6%3A15+PM','2015-06-23 18:19:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(903,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A30+PM','2015-06-23 18:25:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(904,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A30+PM','2015-06-23 18:31:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(905,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 18:36:27',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(906,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 18:41:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(907,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM','2015-06-23 18:47:05',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(908,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 18:52:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(909,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 18:57:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(910,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 19:02:49',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(911,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 19:09:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(912,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 19:18:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(913,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 19:23:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(914,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 19:32:10',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(915,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 19:40:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(916,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 19:46:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(917,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 20:50:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(918,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 20:57:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(919,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 21:35:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(920,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 21:42:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(921,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 22:26:08',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(922,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A45+PM&selected_time=6%3A45+PM','2015-06-23 22:45:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(923,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=11%3A00+PM&selected_time=11%3A00+PM','2015-06-23 22:57:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(924,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=11%3A00+PM&selected_time=11%3A00+PM','2015-06-23 23:06:06',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(925,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=11%3A00+PM&selected_time=11%3A00+PM','2015-06-23 23:12:18',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(926,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=11%3A00+PM&selected_time=11%3A00+PM','2015-06-23 23:40:47',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(927,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=11%3A00+PM&selected_time=11%3A00+PM','2015-06-23 23:54:44',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(928,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=11%3A00+PM&selected_time=11%3A00+PM','2015-06-24 00:04:02',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(929,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=&reserve_time=12%3A15+AM','2015-06-24 00:11:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(930,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A15+PM&selected_time=6%3A15+PM','2015-06-24 00:17:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(931,0,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A15+PM','2015-06-24 00:23:11',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(932,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A15+PM&selected_time=6%3A15+PM','2015-06-24 00:30:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(933,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A15+PM&selected_time=6%3A15+PM','2015-06-24 00:36:41',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(934,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=6%3A15+PM&selected_time=6%3A15+PM','2015-06-24 00:44:50',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(935,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=5%3A00+PM&selected_time=5%3A15+PM','2015-06-24 00:50:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(936,1,'browser','Firefox','127.0.0.1','0','reservation/success','reservation?action=select_time&location=11&guest_num=2&reserve_date=30-06-2015&reserve_time=5%3A00+PM&selected_time=5%3A15+PM','2015-06-24 00:57:53',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(937,1,'browser','Firefox','127.0.0.1','0','reservation','reservation','2015-06-24 01:26:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(938,1,'browser','Firefox','127.0.0.1','0','reservation/success','reservation?action=select_time&location=11&guest_num=6&reserve_date=30-06-2015&reserve_time=6%3A00+PM&selected_time=6%3A15+PM','2015-06-24 01:31:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(939,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=6&reserve_date=30-06-2015&reserve_time=6%3A00+PM','2015-06-24 01:44:56',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(940,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=select_time&location=11&guest_num=6&reserve_date=30-06-2015&reserve_time=6%3A00+PM&selected_time=6%3A15+PM','2015-06-24 01:51:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(941,1,'browser','Firefox','127.0.0.1','0','reservation','reservation?action=find_table&location=11&guest_num=6&reserve_date=30-06-2015&reserve_time=6%3A30+PM','2015-06-24 01:56:17',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(942,1,'browser','Firefox','127.0.0.1','0','reservation/success','reservation?action=select_time&location=11&guest_num=6&reserve_date=30-06-2015&reserve_time=7%3A00+PM&selected_time=7%3A00+PM','2015-06-24 02:01:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(943,1,'browser','Firefox','127.0.0.1','0','locations','reservation?action=find_table&location=11&guest_num=2&reserve_date=&reserve_time=2%3A15+AM','2015-06-24 02:07:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(944,1,'browser','Firefox','127.0.0.1','0','local/hackney','locations','2015-06-24 02:15:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(945,1,'browser','Firefox','127.0.0.1','0','local/lewisham','','2015-06-24 02:25:03',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(946,0,'browser','Chrome','127.0.0.1','0','contact','local/lewisham','2015-06-24 09:38:12',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.52 Safari/537.36'),
	(947,0,'browser','Chrome','127.0.0.1','0','contact','local/lewisham','2015-06-24 10:16:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.52 Safari/537.36'),
	(948,1,'browser','Firefox','127.0.0.1','0','','contact','2015-06-24 12:37:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(949,1,'browser','Firefox','127.0.0.1','0','','contact','2015-06-24 15:13:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(950,1,'browser','Firefox','127.0.0.1','0','account/orders','','2015-06-24 15:31:59',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(951,1,'browser','Firefox','127.0.0.1','0','','account/reviews','2015-06-24 19:58:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(952,0,'browser','Chrome','127.0.0.1','0','account/login','checkout/success','2015-06-25 14:25:54',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36'),
	(953,0,'browser','Chrome','::1','0','contact','local/lewisham','2015-06-26 14:02:25',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.61 Safari/537.36'),
	(954,0,'browser','Firefox','::1','0','','','2015-06-27 16:23:35',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(955,0,'browser','Firefox','::1','0','','','2015-06-27 16:31:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(956,0,'browser','Firefox','::1','0','','','2015-06-27 20:05:15',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(957,0,'browser','Firefox','::1','0','','','2015-06-27 22:31:43',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(958,0,'browser','Firefox','::1','0','','','2015-06-27 22:37:29',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(959,0,'browser','Firefox','::1','0','','','2015-06-27 22:45:51',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(960,0,'browser','Firefox','::1','0','locations','','2015-06-27 22:53:57',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(961,0,'browser','Firefox','::1','0','about-us','local/lewisham','2015-06-27 23:01:26',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(962,0,'browser','Firefox','::1','0','','account/register','2015-06-27 23:09:37',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(963,0,'browser','Firefox','::1','0','','','2015-06-27 23:27:24',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(964,0,'browser','Firefox','::1','0','reservation','reservation','2015-06-27 23:36:33',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(965,0,'browser','Firefox','::1','0','','','2015-06-28 00:02:38',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0'),
	(966,0,'browser','Opera','::1','0','','','2015-06-30 08:32:20',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.132 Safari/537.36 OPR/21.0.1432.57'),
	(967,0,'browser','Chrome','::1','0','','','2015-06-30 09:47:45',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.61 Safari/537.36'),
	(968,0,'browser','Firefox','::1','0','','','2015-06-30 11:23:10',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(969,0,'browser','Firefox','::1','0','','','2015-07-05 22:34:32',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(970,0,'browser','Firefox','::1','0','','','2015-07-12 09:57:19',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(971,0,'browser','Firefox','::1','0','local_module/local_module/search','local_module/local_module/search','2015-07-12 11:00:45',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(972,0,'browser','Firefox','::1','0','','','2015-07-12 13:27:51',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(973,0,'browser','Firefox','::1','0','cart_module/cart_module/add','cart_module/cart_module/add','2015-07-12 13:33:41',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(974,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 13:40:07',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(975,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 14:18:13',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(976,5,'browser','Firefox','::1','0','checkout','','2015-07-12 14:33:14',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(977,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 14:39:05',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(978,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 14:47:11',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(979,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 21:25:25',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(980,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 21:32:30',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(981,5,'browser','Firefox','::1','0','checkout','','2015-07-12 21:37:35',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(982,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 21:48:18',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(983,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 22:17:45',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(984,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 22:24:39',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(985,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 22:41:18',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(986,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 22:48:08',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(987,5,'browser','Firefox','::1','0','local/lewisham','local/lewisham/','2015-07-12 22:57:53',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(988,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-12 23:03:10',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(989,5,'browser','Firefox','::1','0','','','2015-07-13 17:19:58',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(990,5,'browser','Firefox','::1','0','local/lewisham','local/lewisham','2015-07-13 17:35:40',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(991,5,'browser','Firefox','::1','0','local/lewisham','local/lewisham','2015-07-13 17:43:09',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(992,5,'browser','Firefox','::1','0','','','2015-07-13 17:51:55',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(993,5,'browser','Firefox','::1','0','local_module/local_module/search','local_module/local_module/search','2015-07-13 17:58:04',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(994,5,'browser','Firefox','::1','0','local_module/local_module/search','local_module/local_module/search','2015-07-13 18:03:29',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(995,5,'browser','Firefox','::1','0','','','2015-07-13 18:08:56',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(996,5,'browser','Firefox','::1','0','local/lewisham','','2015-07-13 19:58:02',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(997,5,'browser','Firefox','::1','0','','','2015-07-13 20:03:13',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(998,5,'browser','Firefox','::1','0','local/lewisham','','2015-07-13 21:32:17',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(999,5,'browser','Firefox','::1','0','account','account','2015-07-13 23:01:16',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1000,0,'browser','Firefox','::1','0','checkout','','2015-07-14 09:52:28',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1001,5,'browser','Firefox','::1','0','','','2015-07-14 10:48:28',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1002,5,'browser','Firefox','::1','0','checkout','','2015-07-14 10:55:51',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1003,5,'browser','Firefox','::1','0','checkout','','2015-07-14 15:51:33',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1004,5,'browser','Firefox','::1','0','checkout/success','','2015-07-14 15:57:44',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1005,5,'browser','Firefox','::1','0','account/orders','account/orders','2015-07-14 16:03:01',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1006,0,'browser','Firefox','::1','0','favicon.ico','','2015-07-14 16:29:27',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1007,5,'browser','Firefox','::1','0','account/reservations','account/reservations','2015-07-14 19:47:01',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1008,5,'browser','Firefox','::1','0','account','account','2015-07-15 15:46:28',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1009,5,'browser','Firefox','::1','0','checkout','','2015-07-15 15:53:22',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1010,5,'browser','Firefox','::1','0','checkout','','2015-07-15 15:58:34',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1011,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-15 16:04:45',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1012,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-15 16:11:37',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1013,5,'browser','Firefox','::1','0','checkout','checkout','2015-07-15 16:17:39',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1014,5,'browser','Firefox','::1','0','account/orders','account/orders','2015-07-15 16:26:03',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1015,5,'browser','Firefox','::1','0','local/lewisham','local/lewisham/','2015-07-22 19:52:00',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1016,0,'browser','Firefox','::1','0','local/lewisham','','2015-07-23 13:02:33',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1017,5,'browser','Firefox','::1','0','account/orders/view/20014','account/orders/view/20014','2015-07-23 18:56:12',0,'Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0'),
	(1018,0,'browser','Chrome','::1','0','login','login','2015-07-23 19:04:28',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'),
	(1019,0,'','','::1','0','login','','2015-07-23 19:16:29',0,'Symfony2 BrowserKit'),
	(1020,0,'','','::1','0','login','','2015-07-23 19:25:57',0,'Symfony2 BrowserKit'),
	(1021,0,'','','::1','0','login','','2015-07-23 19:48:21',0,'Symfony2 BrowserKit'),
	(1022,0,'','','::1','0','login','','2015-07-23 19:57:44',0,'Symfony2 BrowserKit'),
	(1023,0,'browser','Chrome','::1','0','login','login','2015-07-23 21:12:36',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'),
	(1024,0,'','','::1','0','login','','2015-07-23 21:18:15',0,'Symfony2 BrowserKit'),
	(1025,0,'browser','Chrome','::1','0','login','login','2015-07-23 21:33:23',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'),
	(1026,0,'','','::1','0','login','','2015-07-23 21:42:04',0,'Symfony2 BrowserKit'),
	(1027,5,'browser','Chrome','::1','0','','','2015-07-24 09:39:01',0,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36'),
	(1028,0,'','','::1','0','login','','2015-07-24 09:44:51',0,'Symfony2 BrowserKit');

/*!40000 ALTER TABLE `ti_customers_online` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_extensions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_extensions`;

CREATE TABLE `ti_extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`extension_id`),
  UNIQUE KEY `type` (`type`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_extensions` WRITE;
/*!40000 ALTER TABLE `ti_extensions` DISABLE KEYS */;

INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`)
VALUES
	(11,'module','account_module','a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"11\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}',1,1,'Account'),
	(12,'module','local_module','a:1:{s:7:\"layouts\";N;}',1,1,'Local'),
	(13,'module','categories_module','a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}',1,1,'Categories'),
	(14,'module','cart_module','a:3:{s:16:\"show_cart_images\";s:1:\"0\";s:13:\"cart_images_h\";s:3:\"120\";s:13:\"cart_images_w\";s:3:\"120\";}',1,1,'Cart'),
	(15,'module','reservation_module','a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"16\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}',1,1,'Reservation'),
	(16,'module','slideshow','a:6:{s:11:\"dimension_h\";s:3:\"420\";s:11:\"dimension_w\";s:4:\"1170\";s:6:\"effect\";s:4:\"fade\";s:5:\"speed\";s:3:\"500\";s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"15\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}s:6:\"slides\";a:3:{i:0;a:3:{s:4:\"name\";s:9:\"slide.png\";s:9:\"image_src\";s:14:\"data/slide.jpg\";s:7:\"caption\";s:0:\"\";}i:1;a:3:{s:4:\"name\";s:10:\"slide1.png\";s:9:\"image_src\";s:15:\"data/slide1.jpg\";s:7:\"caption\";s:0:\"\";}i:2;a:3:{s:4:\"name\";s:10:\"slide2.png\";s:9:\"image_src\";s:15:\"data/slide2.jpg\";s:7:\"caption\";s:0:\"\";}}}',1,1,'Slideshow'),
	(18,'payment','cod','a:5:{s:4:\"name\";N;s:11:\"order_total\";s:6:\"100.00\";s:12:\"order_status\";s:2:\"11\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}',1,1,'Cash On Delivery'),
	(20,'module','pages_module','a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"17\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}',1,1,'Pages'),
	(21,'payment','paypal_express','a:11:{s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:8:\"api_mode\";s:7:\"sandbox\";s:8:\"api_user\";s:39:\"samadepoyigi-facilitator_api1.gmail.com\";s:8:\"api_pass\";s:10:\"1381080165\";s:13:\"api_signature\";s:56:\"AFcWxV21C7fd0v3bYYYRCpSSRl31AYzY6RzJVWuquyjw.VYZbV7LatXv\";s:10:\"api_action\";s:4:\"sale\";s:10:\"return_uri\";s:24:\"paypal_express/authorize\";s:10:\"cancel_uri\";s:21:\"paypal_express/cancel\";s:11:\"order_total\";s:4:\"0.00\";s:12:\"order_status\";s:2:\"11\";}',1,1,'PayPal Express'),
	(23,'theme','tastyigniter-orange','a:13:{s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"25\";s:19:\"logo_padding_bottom\";s:2:\"25\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#fdeae2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#333333\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#ffffff\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#11a2dc\";s:5:\"hover\";s:7:\"#0d7fad\";}s:6:\"button\";a:4:{s:7:\"default\";a:2:{s:10:\"background\";s:7:\"#e7e7e7\";s:6:\"border\";s:7:\"#e7e7e7\";}s:7:\"primary\";a:2:{s:10:\"background\";s:7:\"#11a2dc\";s:6:\"border\";s:7:\"#11a2dc\";}s:7:\"success\";a:2:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";}s:6:\"danger\";a:2:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";}}s:10:\"custom_css\";s:0:\"\";}',1,1,'TastyIgniter Orange'),
	(24,'theme','tastyigniter-blue','',1,0,'TastyIgniter Blue'),
	(25,'module','banners_module','a:1:{s:7:\"banners\";a:1:{i:1;a:3:{s:9:\"banner_id\";s:1:\"1\";s:5:\"width\";s:3:\"200\";s:6:\"height\";s:3:\"200\";}}}',1,1,'Banners'),
	(31,'module','slideevent','',0,0,'');

/*!40000 ALTER TABLE `ti_extensions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_languages`;

CREATE TABLE `ti_languages` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(32) NOT NULL,
  `idiom` varchar(32) NOT NULL,
  `can_delete` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_languages` WRITE;
/*!40000 ALTER TABLE `ti_languages` DISABLE KEYS */;

INSERT INTO `ti_languages` (`language_id`, `code`, `name`, `image`, `idiom`, `can_delete`, `status`)
VALUES
	(11,'en','English','data/flags/gb.png','english',1,1);

/*!40000 ALTER TABLE `ti_languages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_layout_modules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_layout_modules`;

CREATE TABLE `ti_layout_modules` (
  `layout_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `module_code` varchar(128) NOT NULL,
  `partial` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`layout_module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_layout_modules` WRITE;
/*!40000 ALTER TABLE `ti_layout_modules` DISABLE KEYS */;

INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `partial`, `priority`, `status`)
VALUES
	(60,17,'pages_module','right',1,1),
	(65,11,'slideshow','top',1,1),
	(66,11,'local_module','top',2,1),
	(67,15,'account_module','left',1,1),
	(71,13,'local_module','top',1,1),
	(72,13,'cart_module','right',1,1),
	(74,18,'local_module','content_top',1,1),
	(75,18,'categories_module','content_left',1,1),
	(76,18,'cart_module','content_right',1,1),
	(77,18,'newsletter','content_footer',1,1),
	(78,16,'reservation_module','top',1,1),
	(83,12,'local_module','top',1,1),
	(84,12,'categories_module','left',1,1),
	(85,12,'cart_module','right',1,1);

/*!40000 ALTER TABLE `ti_layout_modules` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_layout_routes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_layout_routes`;

CREATE TABLE `ti_layout_routes` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `uri_route` varchar(128) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_layout_routes` WRITE;
/*!40000 ALTER TABLE `ti_layout_routes` DISABLE KEYS */;

INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`)
VALUES
	(59,11,'home'),
	(71,19,'locations'),
	(72,17,'pages'),
	(100,15,'account/account'),
	(101,15,'account/details'),
	(102,15,'account/address'),
	(103,15,'account/orders'),
	(104,15,'account/reservations'),
	(105,15,'account/inbox'),
	(106,15,'account/reviews'),
	(108,13,'checkout'),
	(110,18,'local'),
	(112,16,'reservation'),
	(114,12,'menus');

/*!40000 ALTER TABLE `ti_layout_routes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_layouts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_layouts`;

CREATE TABLE `ti_layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_layouts` WRITE;
/*!40000 ALTER TABLE `ti_layouts` DISABLE KEYS */;

INSERT INTO `ti_layouts` (`layout_id`, `name`)
VALUES
	(11,'Home'),
	(12,'Menus'),
	(13,'Checkout'),
	(15,'Account'),
	(16,'Reservation'),
	(17,'Page'),
	(18,'Local'),
	(19,'Locations');

/*!40000 ALTER TABLE `ti_layouts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_location_tables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_location_tables`;

CREATE TABLE `ti_location_tables` (
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`table_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_location_tables` WRITE;
/*!40000 ALTER TABLE `ti_location_tables` DISABLE KEYS */;

INSERT INTO `ti_location_tables` (`location_id`, `table_id`)
VALUES
	(11,7),
	(11,16),
	(11,17),
	(11,18),
	(11,19),
	(11,20),
	(11,22);

/*!40000 ALTER TABLE `ti_location_tables` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_locations`;

CREATE TABLE `ti_locations` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_locations` WRITE;
/*!40000 ALTER TABLE `ti_locations` DISABLE KEYS */;

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_time_interval`, `reservation_stay_time`, `location_status`, `collection_time`, `options`, `location_image`)
VALUES
	(11,'Lewisham','lewisham@tastyigniter.com','Mauris maximus tempor ligula vitae placerat. Proin at orci fermentum, aliquam turpis sit amet, ultrices risus. Donec pellentesque justo in pharetra rutrum. Cras ac dui eu orci lacinia consequat vitae quis sapien. Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada. Mauris iaculis ac nisi at euismod. Nunc sit amet luctus ipsum. Pellentesque eget lobortis turpis. Vivamus mattis, massa ac vulputate vulputate, risus purus tincidunt nibh, vitae pellentesque ex nibh at mi. Donec placerat, urna quis interdum tempus, tellus nulla commodo leo, vitae auctor orci est congue eros. In vel ex quis orci blandit porttitor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus tincidunt risus non mattis semper.','44 Darnley Road','','Greater London','','E9 6QH',222,'1203392202',51.544060,-0.053999,0,1,1,20,0,0,0,1,10,'a:3:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}}}s:8:\"payments\";a:2:{i:0;s:3:\"cod\";i:1;s:14:\"paypal_express\";}s:14:\"delivery_areas\";a:4:{i:1;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"_yryHzpHff@??d~@gf@?\"}]\";s:8:\"vertices\";s:219:\"[{\"lat\":51.547200000000004,\"lng\":-0.048940000000000004},{\"lat\":51.54092000000001,\"lng\":-0.048940000000000004},{\"lat\":51.54092000000001,\"lng\":-0.059050000000000005},{\"lat\":51.547200000000004,\"lng\":-0.059050000000000005}]\";s:6:\"circle\";s:71:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}i:2;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"kvtyHrfJrmA??j}BsmA?\"}]\";s:8:\"vertices\";s:177:\"[{\"lat\":51.55702,\"lng\":-0.05754000000000001},{\"lat\":51.54444,\"lng\":-0.05754000000000001},{\"lat\":51.54444,\"lng\":-0.07776000000000001},{\"lat\":51.55702,\"lng\":-0.07776000000000001}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":1000}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 2\";s:6:\"charge\";s:1:\"4\";s:10:\"min_amount\";s:2:\"10\";}i:3;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"kvuyH`dBztB??r|D{tB?\"}]\";s:8:\"vertices\";s:147:\"[{\"lat\":51.56214000000001,\"lng\":-0.01617},{\"lat\":51.54328,\"lng\":-0.01617},{\"lat\":51.54328,\"lng\":-0.04651},{\"lat\":51.56214000000001,\"lng\":-0.04651}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":1500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 3\";s:6:\"charge\";s:2:\"30\";s:10:\"min_amount\";s:3:\"300\";}i:4;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"gmqyHlhEf|C??x{Fg|C?\"}]\";s:8:\"vertices\";s:193:\"[{\"lat\":51.540200000000006,\"lng\":-0.03223},{\"lat\":51.515040000000006,\"lng\":-0.03223},{\"lat\":51.515040000000006,\"lng\":-0.07268000000000001},{\"lat\":51.540200000000006,\"lng\":-0.07268000000000001}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":2000}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 4\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"200\";}}}','data/meat_pie.jpg'),
	(12,'Hackney\'s Branch','hackney@tastyigniter.com','Vestibulum mattis elementum justo quis vehicula. Fusce a elementum tellus, non tincidunt felis. Maecenas a dui dictum, dictum risus id, tempor enim. Curabitur fermentum elit eu iaculis tristique. Sed lobortis purus sed dui rhoncus fringilla. Integer orci ante, placerat a purus vel, commodo convallis nisi. Maecenas tristique, dui in ullamcorper hendrerit, dui odio pellentesque erat, rutrum vulputate enim ante vel nulla.','400 Lewisham Way','','Lewisham','','SE10 9HF',222,'949200202',51.469627,-0.008745,0,1,1,0,0,0,0,1,0,'a:1:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:5:\"daily\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:7:\"2:00 AM\";s:5:\"close\";s:7:\"5:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}}','data/steamed_rice.jpg'),
	(13,'Earling Closed','earling@tastyigniter.com','','14 Lime Close','','London','','HA3 7JG',222,'949200202',51.600262,-0.325915,0,0,1,0,0,0,0,1,0,'a:2:{s:13:\"opening_hours\";a:3:{s:12:\"opening_type\";s:5:\"daily\";s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}s:14:\"delivery_areas\";a:3:{i:1;a:7:{s:5:\"shape\";s:35:\"[{\"shape\":\"ix}yHht}@hf@??h~@if@?\"}]\";s:8:\"vertices\";s:211:\"[{\"lat\":51.60340610349442,\"lng\":-0.32085320675355433},{\"lat\":51.59711789650558,\"lng\":-0.32085320675355433},{\"lat\":51.59711789650558,\"lng\":-0.3309767932464638},{\"lat\":51.60340610349442,\"lng\":-0.3309767932464638}]\";s:6:\"circle\";s:94:\"[{\"center\":{\"lat\":51.62179581812303,\"lng\":-0.37947844769109906}},{\"radius\":2327.919015915706}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:1:\"0\";s:10:\"min_amount\";s:1:\"0\";}i:2;a:7:{s:5:\"shape\";s:35:\"[{\"shape\":\"}k~yHtt|@rmA??p}BsmA?\"}]\";s:8:\"vertices\";s:215:\"[{\"lat\":51.606550206988835,\"lng\":-0.31579141345764583},{\"lat\":51.593973793011166,\"lng\":-0.31579141345764583},{\"lat\":51.593973793011166,\"lng\":-0.3360385865423723},{\"lat\":51.606550206988835,\"lng\":-0.3360385865423723}]\";s:6:\"circle\";s:93:\"[{\"center\":{\"lat\":51.5834115850791,\"lng\":-0.3441036832577993}},{\"radius\":1997.0467357168989}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 2\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}i:3;a:7:{s:5:\"shape\";s:41:\"[{\"shape\":\"osbzHxjr@xhFfiHjdCxiQogJ}x@\"}]\";s:8:\"vertices\";s:212:\"[{\"lat\":51.62823967264574,\"lng\":-0.26300775726963366},{\"lat\":51.590829689516745,\"lng\":-0.3107296200626024},{\"lat\":51.56949495892793,\"lng\":-0.40461508941007196},{\"lat\":51.62717405249217,\"lng\":-0.3953453750546032}]\";s:6:\"circle\";s:73:\"[{\"center\":{\"lat\":51.600262,\"lng\":-0.32591500000000906}},{\"radius\":1500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 3\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:1:\"0\";}}}','data/pesto.jpg');

/*!40000 ALTER TABLE `ti_locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_mail_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_mail_templates`;

CREATE TABLE `ti_mail_templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_mail_templates` WRITE;
/*!40000 ALTER TABLE `ti_mail_templates` DISABLE KEYS */;

INSERT INTO `ti_mail_templates` (`template_id`, `name`, `language_id`, `date_added`, `date_updated`, `status`)
VALUES
	(11,'Default',1,'2014-04-16 01:49:52','2015-06-10 15:32:15',1);

/*!40000 ALTER TABLE `ti_mail_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_mail_templates_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_mail_templates_data`;

CREATE TABLE `ti_mail_templates_data` (
  `template_data_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `body` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`template_data_id`,`template_id`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_mail_templates_data` WRITE;
/*!40000 ALTER TABLE `ti_mail_templates_data` DISABLE KEYS */;

INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`)
VALUES
	(11,11,'registration','Account Created at {site_name}','<p>Hello {first_name} {last_name},</p><p>Your account has now been created and you can log in using your email address and password by visiting our website or at the following URL: <a href=\"{login_link}\">Click Here</a></p><p>Thank you for using.<br /> {signature}</p>','2014-04-16 00:56:00','2015-06-10 15:32:15'),
	(12,11,'password_reset','Password Reset at {site_name}','<p>Dear {first_name} {last_name},</p><p>Your password has been reset successfull! Please <a href=\"{login_link}\" target=\"_blank\">login</a> using your new password: {created_password}.</p><p>Thank you for using.<br /> {signature}</p>','2014-04-16 00:56:00','2015-06-10 15:32:15'),
	(13,11,'order','Order Successful - {order_number}','<div><div class=\"text-align\"><p>Hello {first_name} {last_name},</p><p>Your order has been received and will be with you shortly.<br /><a href=\"{order_link}\">Click here</a> to view your order progress.<br /> Thanks for shopping with us online! &nbsp;</p><h3>Order Details</h3><p>Your order number is {order_number}<br /> This is a {order_type} order.<br /><strong>Order Date:</strong> {order_date}<br /><strong>Delivery Time</strong> {order_time}</p><h3>What you\'ve ordered:</h3></div></div><table border=\"1\" cellspacing=\"1\" cellpadding=\"1\"><tbody><tr><td><div><div class=\"text-align\">{menus}</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td></tr><tr><td><div><div class=\"text-align\">{quantity}x</div></div></td><td><div><div class=\"text-align\"><p>{name}</p><p>{options}</p></div></div></td><td><div><div class=\"text-align\">{price}</div></div></td><td><div><div class=\"text-align\">{subtotal}</div></div></td></tr><tr><td><div><div class=\"text-align\">{/menus}</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td></tr></tbody></table><div><div class=\"text-align\"><p>&nbsp;</p><p>{order_totals}<br /><strong>{title}:</strong> {value}<br /> {/order_totals}</p><p>Your delivery address {order_address}</p><p>Your local restaurant {location_name}</p><p>We hope to see you again soon.</p><p>{signature}</p></div></div>','2014-04-16 00:56:00','2015-06-10 15:32:15'),
	(14,11,'reservation','Table Reserved - {reserve_number}','<p>Hello {first_name} {last_name},<br /><br /> Your reservation at {location_name} has been booked for {reserve_guest} person(s) on {reserve_date} at {reserve_time}.</p><p>Thanks for reserving with us online!<br /><br /> We hope to see you again soon.<br /> {signature}</p>','2014-04-16 00:56:00','2015-06-10 15:32:15'),
	(15,11,'contact','Thanks for contacting us','<h3><strong>Dear {full_name},</strong></h3><div><div>Topic: {contact_topic}.</div><div>Telephone: {contact_telephone}.</div></div><p>{contact_message}</p><p>Your {site_name} Team,</p><div>{signature}</div>','2014-04-16 00:56:00','2015-06-10 15:32:15'),
	(16,11,'internal','Subject here','<p>Body here</p>','2014-04-16 00:56:00','2015-06-10 15:32:15'),
	(17,11,'order_alert','Subject here','<p>Body here</p>','2014-04-16 00:56:00','2015-06-10 15:32:15'),
	(18,11,'reservation_alert','Subject here','<p>Body here</p>','2014-04-16 00:56:00','2015-06-10 15:32:15');

/*!40000 ALTER TABLE `ti_mail_templates_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_menu_option_values
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_menu_option_values`;

CREATE TABLE `ti_menu_option_values` (
  `menu_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `new_price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtract_stock` tinyint(4) NOT NULL,
  PRIMARY KEY (`menu_option_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_menu_option_values` WRITE;
/*!40000 ALTER TABLE `ti_menu_option_values` DISABLE KEYS */;

INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`)
VALUES
	(52,25,84,22,8,0.00,0,0),
	(53,25,84,22,9,0.00,0,0),
	(54,25,84,22,11,0.00,0,0),
	(55,26,79,22,8,0.00,0,0),
	(56,26,79,22,9,0.00,0,0),
	(57,26,79,22,10,0.00,0,0),
	(58,26,79,22,11,0.00,0,0),
	(59,26,79,22,12,0.00,0,0),
	(60,27,79,24,13,0.00,0,0),
	(61,27,79,24,14,0.00,0,0),
	(62,28,78,22,8,0.00,0,0),
	(63,28,78,22,9,0.00,0,0),
	(64,28,78,22,10,0.00,0,0),
	(65,28,78,22,11,0.00,0,0),
	(66,28,78,22,12,0.00,0,0),
	(67,22,85,22,8,0.00,0,0),
	(68,22,85,22,9,0.00,0,0),
	(69,22,85,22,10,0.00,0,0),
	(70,24,85,24,13,0.00,0,0),
	(71,24,85,24,14,0.00,0,0),
	(72,23,81,23,7,0.00,0,0),
	(73,23,81,23,6,0.00,0,0),
	(74,23,81,23,15,0.00,0,0),
	(75,29,81,22,8,3.00,0,1),
	(76,29,81,22,9,4.00,0,1),
	(77,29,81,22,10,4.00,0,1);

/*!40000 ALTER TABLE `ti_menu_option_values` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_menu_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_menu_options`;

CREATE TABLE `ti_menu_options` (
  `menu_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `required` tinyint(4) NOT NULL,
  `option_values` text NOT NULL,
  PRIMARY KEY (`menu_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_menu_options` WRITE;
/*!40000 ALTER TABLE `ti_menu_options` DISABLE KEYS */;

INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`)
VALUES
	(22,22,85,1,'a:3:{i:3;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:4;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:5;a:3:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}}'),
	(23,23,81,0,'a:3:{i:4;a:5:{s:15:\"option_value_id\";s:1:\"7\";s:5:\"price\";s:0:\"\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"72\";}i:5;a:5:{s:15:\"option_value_id\";s:1:\"6\";s:5:\"price\";s:0:\"\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"73\";}i:6;a:5:{s:15:\"option_value_id\";s:2:\"15\";s:5:\"price\";s:0:\"\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"74\";}}'),
	(24,24,85,1,'a:2:{i:1;a:3:{s:15:\"option_value_id\";s:2:\"13\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:2;a:3:{s:15:\"option_value_id\";s:2:\"14\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}}'),
	(25,22,84,0,'a:3:{i:1;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"52\";}i:2;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"53\";}i:3;a:3:{s:15:\"option_value_id\";s:2:\"11\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"54\";}}'),
	(26,22,79,0,'a:5:{i:1;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"55\";}i:2;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"56\";}i:3;a:3:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"57\";}i:4;a:3:{s:15:\"option_value_id\";s:2:\"11\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"58\";}i:5;a:3:{s:15:\"option_value_id\";s:2:\"12\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"59\";}}'),
	(27,24,79,1,'a:2:{i:6;a:3:{s:15:\"option_value_id\";s:2:\"13\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"60\";}i:7;a:3:{s:15:\"option_value_id\";s:2:\"14\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"61\";}}'),
	(28,22,78,1,'a:5:{i:1;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"62\";}i:2;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"63\";}i:3;a:3:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"64\";}i:4;a:3:{s:15:\"option_value_id\";s:2:\"11\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"65\";}i:5;a:3:{s:15:\"option_value_id\";s:2:\"12\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"66\";}}'),
	(29,22,81,1,'a:3:{i:1;a:5:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:4:\"3.00\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"1\";s:20:\"menu_option_value_id\";s:2:\"75\";}i:2;a:5:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:4:\"4.00\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"1\";s:20:\"menu_option_value_id\";s:2:\"76\";}i:3;a:5:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:4:\"4.00\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"1\";s:20:\"menu_option_value_id\";s:2:\"77\";}}');

/*!40000 ALTER TABLE `ti_menu_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_menus`;

CREATE TABLE `ti_menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `menu_description` text NOT NULL,
  `menu_price` decimal(15,2) NOT NULL,
  `menu_photo` varchar(255) NOT NULL,
  `menu_category_id` int(11) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `minimum_qty` int(11) NOT NULL,
  `subtract_stock` tinyint(1) NOT NULL,
  `menu_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_menus` WRITE;
/*!40000 ALTER TABLE `ti_menus` DISABLE KEYS */;

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`)
VALUES
	(76,'PUFF-PUFF','Traditional Nigerian donut ball, rolled in sugar',4.99,'data/puff_puff.jpg',15,352,3,1,1),
	(77,'SCOTCH EGG','Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.',2.00,'data/scotch_egg.jpg',15,9992,1,1,1),
	(78,'ATA RICE','Small pieces of beef, goat, stipe, and tendon sautéed in crushed green Jamaican pepper.',12.00,'data/Seared_Ahi_Spinach_Salad.jpg',16,1000,1,0,1),
	(79,'RICE AND DODO','(plantains) w/chicken, fish, beef or goat',11.99,'data/rice_and_dodo.jpg',16,1709,1,1,1),
	(80,'Special Shrimp Deluxe','Fresh shrimp sautéed in blended mixture of tomatoes, onion, peppers over choice of rice',12.99,'data/deluxe_bbq_shrimp-1.jpg',18,254,1,1,1),
	(81,'Whole catfish with rice and vegetables','Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste',13.99,'data/FriedWholeCatfishPlate_lg.jpg',15,19590,1,1,1),
	(82,'African Salad','With baked beans, egg, tuna, onion, tomatoes , green peas and carrot with your choice of dressing.',8.99,'',17,500,1,0,1),
	(83,'Seafood Salad','With shrimp, egg and imitation crab meat',5.99,'data/seafoods_salad.JPG',17,489,1,1,1),
	(84,'EBA','Grated cassava',11.99,'data/eba.jpg',16,11093,1,1,1),
	(85,'AMALA','Yam flour',11.99,'data/DSCF3711.JPG',19,470,1,1,1),
	(86,'YAM PORRIDGE','in tomatoes sauce',9.99,'data/yam_porridge.jpg',20,457,1,1,1),
	(87,'Boiled Plantain','w/spinach soup',9.99,'data/pesto.jpg',19,434,1,1,1),
	(88,'PUFF-PUFF','Traditional Nigerian donut ball, rolled in sugar',4.99,'data/puff_puff.jpg',15,685,3,1,1);

/*!40000 ALTER TABLE `ti_menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_menus_specials
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_menus_specials`;

CREATE TABLE `ti_menus_specials` (
  `special_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `special_price` decimal(15,2) NOT NULL,
  `special_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`special_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_menus_specials` WRITE;
/*!40000 ALTER TABLE `ti_menus_specials` DISABLE KEYS */;

INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`)
VALUES
	(51,81,'2014-04-10','2014-04-30',6.99,1),
	(52,76,'2014-04-23','2014-07-31',10.00,1),
	(53,86,'0000-00-00','0000-00-00',0.00,0),
	(54,87,'0000-00-00','0000-00-00',0.00,0),
	(57,84,'0000-00-00','0000-00-00',0.00,0),
	(58,77,'0000-00-00','0000-00-00',0.00,0),
	(59,78,'0000-00-00','0000-00-00',0.00,0),
	(60,79,'0000-00-00','0000-00-00',0.00,0),
	(61,85,'0000-00-00','0000-00-00',0.00,0);

/*!40000 ALTER TABLE `ti_menus_specials` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_message_recipients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_message_recipients`;

CREATE TABLE `ti_message_recipients` (
  `message_recipient_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `item` varchar(32) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`message_recipient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_message_recipients` WRITE;
/*!40000 ALTER TABLE `ti_message_recipients` DISABLE KEYS */;

INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `item`, `value`)
VALUES
	(28,41,0,1,'customer_email','sampoyigi@gmail.com'),
	(29,39,1,0,'staff_id','12'),
	(30,40,0,1,'staff_id','11'),
	(31,40,1,0,'staff_id','12'),
	(32,43,1,1,'customer_id','1'),
	(33,44,1,1,'customer_id','1'),
	(34,45,0,1,'customer_email','sampoyigi@gmail.com'),
	(35,46,0,1,'staff_email','info@tastyigniter.com'),
	(36,46,0,1,'staff_email','iana@iana.com'),
	(37,47,0,1,'staff_email','info@tastyigniter.com'),
	(38,47,0,1,'staff_email','iana@iana.com'),
	(39,48,0,1,'staff_email','info@tastyigniter.com'),
	(40,49,0,1,'staff_email','info@tastyigniter.com'),
	(41,49,0,1,'staff_email','iana@iana.com'),
	(42,50,0,1,'staff_email','info@tastyigniter.com'),
	(43,50,0,1,'staff_email','iana@iana.com'),
	(44,51,0,1,'staff_email','info@tastyigniter.com'),
	(45,51,0,1,'staff_email','iana@iana.com'),
	(46,52,0,1,'staff_email','info@tastyigniter.com'),
	(47,52,0,1,'staff_email','iana@iana.com'),
	(48,53,0,1,'staff_email','info@tastyigniter.com'),
	(49,53,0,1,'staff_email','iana@iana.com'),
	(50,54,1,0,'staff_id','11'),
	(51,54,0,1,'staff_id','12'),
	(52,55,0,1,'staff_id','11'),
	(53,56,1,0,'staff_id','11'),
	(54,56,0,1,'staff_id','12'),
	(55,57,0,1,'staff_id','11'),
	(56,57,1,0,'staff_id','12'),
	(57,58,0,1,'staff_id','11'),
	(58,58,0,1,'staff_id','12'),
	(59,59,1,1,'staff_id','11'),
	(60,59,0,1,'staff_id','12'),
	(61,60,1,1,'customer_id','1'),
	(62,61,1,1,'staff_id','13'),
	(63,62,0,1,'customer_id','2'),
	(64,62,0,1,'customer_id','3'),
	(65,62,0,1,'customer_id','4'),
	(66,62,1,1,'customer_id','5'),
	(67,63,0,1,'staff_id','11'),
	(68,63,0,1,'staff_id','12'),
	(69,63,1,1,'staff_id','13'),
	(70,64,0,1,'customer_email','sampoyigi@gmail.com');

/*!40000 ALTER TABLE `ti_message_recipients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_messages`;

CREATE TABLE `ti_messages` (
  `message_id` int(15) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `send_type` varchar(32) NOT NULL,
  `recipient` varchar(32) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_messages` WRITE;
/*!40000 ALTER TABLE `ti_messages` DISABLE KEYS */;

INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`)
VALUES
	(28,11,'2015-05-25 17:15:59','email','customer_group','Aliquam erat volutpat.','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>',1),
	(29,11,'2015-05-25 17:18:09','email','customer_group','Aliquam erat volutpat.','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>',1),
	(30,11,'2015-05-25 17:19:30','email','customer_group','Aliquam erat volutpat.','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>',1),
	(31,11,'2015-05-25 17:20:49','email','all_staffs','Aliquam erat volutpat.','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>',1),
	(32,11,'2015-05-25 17:21:00','email','all_staffs','Nullam at hendrerit orci','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>',1),
	(33,11,'2015-05-25 17:21:10','email','all_staffs','Fusce quis condimentum quam','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>',1),
	(34,11,'2015-05-25 18:18:31','account','all_staffs','Aenean quis consequat erat.','<p>Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec quis sem ac leo ultrices bibendum. Donec gravida, massa sed condimentum imperdiet, nisi turpis lobortis nunc, nec rhoncus metus nunc et magna. Aliquam at leo sit amet leo ullamcorper ullamcorper vel a urna. Sed quis pulvinar metus, feugiat suscipit lorem. Donec sodales nunc sit amet efficitur hendrerit. Quisque nunc est, tempor a viverra ac, eleifend vitae nisl. Proin libero nibh, auctor vitae magna eget, ornare lacinia arcu. Phasellus ultricies blandit urna, vitae tincidunt ante imperdiet non. Ut eget ornare neque. Duis feugiat dictum facilisis. Vivamus tristique tellus sit amet nunc tempus mattis. Suspendisse aliquam odio justo, in posuere sapien cursus ac.</p>',1),
	(35,11,'2015-05-25 18:21:07','account','all_staffs','Quisque molestie fringilla porta.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(36,11,'2015-05-25 18:22:35','account','all_staffs','Quisque molestie fringilla porta.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',0),
	(37,11,'2015-05-28 23:01:56','email','staffs','Quisque molestie fringilla porta.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',0),
	(38,11,'2015-05-25 18:51:27','account','all_newsletters','Quisque molestie fringilla porta.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(39,11,'2015-05-25 19:16:43','account','staff_group','Aenean quis consequat erat.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(40,11,'2015-05-25 19:34:52','account','all_staffs','Vivamus quis turpis pharetra','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(41,11,'2015-05-25 19:16:12','email','all_newsletters','Aenean quis consequat erat.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(42,11,'2015-05-25 19:09:54','account','all_newsletters','Aenean quis consequat erat.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(43,11,'2015-05-25 21:42:44','account','all_customers','In convallis ac nibh eu varius.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(44,11,'2015-05-25 21:42:56','account','all_customers','Phasellus pharetra','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(45,11,'2015-05-25 21:43:09','email','all_customers','Generated 5 paragraphs,','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(46,11,'2015-05-25 21:43:21','email','all_staffs','Sed pharetra leo eget','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(47,11,'2015-05-25 21:43:31','email','all_staffs','Fusce non rhoncus dolor.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(48,11,'2015-05-25 21:43:50','email','staff_group','Pellentesque et ipsum nisl.','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(49,11,'2015-05-25 21:44:17','email','all_staffs','Aenean eget euismod massa','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(50,11,'2015-05-25 21:44:26','email','all_staffs','Aenean eget euismod massa','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(51,11,'2015-05-25 21:44:48','email','all_staffs','Aenean eget euismod massa','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(52,11,'2015-05-25 21:48:08','email','all_staffs','Aenean eget euismod massa','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(53,11,'2015-05-25 21:48:22','email','all_staffs','Aenean eget euismod massa','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(54,11,'2015-05-25 21:48:33','account','all_staffs','Aenean eget euismod massa','<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>',1),
	(55,11,'2015-05-25 21:49:09','account','staff_group','Etiam mollis mauris eu magna','<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>',1),
	(56,11,'2015-05-25 21:49:30','account','all_staffs','Praesent dapibus','<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>',1),
	(57,11,'2015-05-25 21:49:47','account','all_staffs','Curabitur iaculis mattis magna','<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>',1),
	(58,11,'2015-05-25 21:49:57','account','all_staffs','Vivamus luctus tincidunt','<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>',1),
	(59,11,'2015-05-25 21:50:20','account','all_staffs','Donec sodales ante et leo','<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>',1),
	(60,11,'2015-05-25 21:50:52','account','all_newsletters','Donec sodales ante et leo','<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>',1),
	(61,11,'2015-06-03 21:13:52','account','staffs','Hey Buddy','<p>Supppie</p>',1),
	(62,11,'2015-06-06 01:26:12','account','all_newsletters','Aenean eget euismod massa','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum volutpat enim in tellus tristique facilisis. Etiam vulputate et nisi tristique venenatis. Suspendisse hendrerit mi ac aliquam tincidunt. In maximus consequat lectus, vitae bibendum ipsum suscipit mattis. Donec mi magna, fringilla sed orci eget, scelerisque lobortis nunc. Donec commodo tristique commodo. Curabitur pellentesque dui libero. Suspendisse id nisl quis nulla pharetra malesuada. Integer eget nibh tristique, commodo arcu sed, sagittis tellus. Aliquam pharetra cursus nisi quis porta. Donec bibendum sem ipsum, quis eleifend est iaculis quis. Integer suscipit enim sit amet gravida lobortis. Sed fermentum lorem et mauris pharetra, nec dignissim felis finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent ut mi tellus. Vestibulum varius, lectus ac scelerisque blandit, odio urna accumsan diam, in pulvinar est dolor non quam.</p>\r\n<p>Nunc lorem velit, vehicula sed ligula in, feugiat aliquet nisi. Ut posuere pretium egestas. Nunc tincidunt risus lectus, vel posuere tellus convallis sed. Aliquam pharetra auctor vestibulum. Duis vitae nunc luctus, faucibus turpis efficitur, aliquet arcu. Mauris tincidunt venenatis velit sed lobortis. Phasellus vel massa at neque faucibus lobortis et vel arcu. Donec ultrices ullamcorper lacus in posuere. Aenean eu volutpat justo. Nam commodo purus libero, consequat faucibus velit condimentum non. Nam lobortis sem ut dictum faucibus. Aliquam quis commodo felis. Sed pharetra molestie elementum. Aenean est libero, molestie a bibendum non, mattis ut magna. Ut aliquet, lectus et consequat volutpat, elit mauris iaculis ante, sed fermentum orci mi sodales erat. Donec at mi ac nunc egestas fermentum.</p>',1),
	(63,12,'2015-06-06 01:26:47','account','all_staffs','Nam lobortis sem ut dictum faucibus.','<p>&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum volutpat enim in tellus tristique facilisis. Etiam vulputate et nisi tristique venenatis. Suspendisse hendrerit mi ac aliquam tincidunt. In maximus consequat lectus, vitae bibendum ipsum suscipit mattis. Donec mi magna, fringilla sed orci eget, scelerisque lobortis nunc. Donec commodo tristique commodo. Curabitur pellentesque dui libero. Suspendisse id nisl quis nulla pharetra malesuada. Integer eget nibh tristique, commodo arcu sed, sagittis tellus. Aliquam pharetra cursus nisi quis porta. Donec bibendum sem ipsum, quis eleifend est iaculis quis. Integer suscipit enim sit amet gravida lobortis. Sed fermentum lorem et mauris pharetra, nec dignissim felis finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent ut mi tellus. Vestibulum varius, lectus ac scelerisque blandit, odio urna accumsan diam, in pulvinar est dolor non quam.</p>\r\n<p>&nbsp;</p>\r\n<p>Nunc lorem velit, vehicula sed ligula in, feugiat aliquet nisi. Ut posuere pretium egestas. Nunc tincidunt risus lectus, vel posuere tellus convallis sed. Aliquam pharetra auctor vestibulum. Duis vitae nunc luctus, faucibus turpis efficitur, aliquet arcu. Mauris tincidunt venenatis velit sed lobortis. Phasellus vel massa at neque faucibus lobortis et vel arcu. Donec ultrices ullamcorper lacus in posuere. Aenean eu volutpat justo. Nam commodo purus libero, consequat faucibus velit condimentum non. Nam lobortis sem ut dictum faucibus. Aliquam quis commodo felis. Sed pharetra molestie elementum. Aenean est libero, molestie a bibendum non, mattis ut magna. Ut aliquet, lectus et consequat volutpat, elit mauris iaculis ante, sed fermentum orci mi sodales erat. Donec at mi ac nunc egestas fermentum.&nbsp;</p>',1),
	(64,11,'2015-06-12 11:54:53','email','customers','Fusce non rhoncus dolor.','<p>Etiam et ligula lectus. Quisque a semper velit. Aenean tincidunt, mauris ac pharetra gravida, eros lectus egestas dolor, ac sagittis odio nunc eu ipsum. Donec laoreet aliquet eros, ac laoreet erat vulputate eget. Quisque pharetra vel magna quis hendrerit. Mauris at sapien viverra, consequat metus vitae, bibendum metus. Etiam fermentum urna cursus, rhoncus turpis vel, commodo tortor. Maecenas porta ac est sed sagittis. Sed convallis tincidunt rhoncus. Nunc dignissim dui a velit tincidunt consequat. Phasellus vel molestie ipsum. Morbi vel tellus eu mauris tempus efficitur a in arcu. Quisque non sem est. Etiam pulvinar facilisis purus, eget pharetra ante pellentesque sed. Mauris urna magna, rutrum luctus condimentum quis, sollicitudin id odio. Pellentesque volutpat odio ut purus lacinia, id rhoncus nisl efficitur.</p>',1);

/*!40000 ALTER TABLE `ti_messages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_migrations`;

CREATE TABLE `ti_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_migrations` WRITE;
/*!40000 ALTER TABLE `ti_migrations` DISABLE KEYS */;

INSERT INTO `ti_migrations` (`version`)
VALUES
	(12);

/*!40000 ALTER TABLE `ti_migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_option_values
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_option_values`;

CREATE TABLE `ti_option_values` (
  `option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `value` varchar(128) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`option_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_option_values` WRITE;
/*!40000 ALTER TABLE `ti_option_values` DISABLE KEYS */;

INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`)
VALUES
	(6,23,'Peperoni',1.99,2),
	(7,23,'Jalapenos',3.99,1),
	(8,22,'Meat',4.00,1),
	(9,22,'Chicken',2.99,2),
	(10,22,'Fish',3.00,3),
	(11,22,'Beef',4.99,4),
	(12,22,'Assorted Meat',5.99,5),
	(13,24,'Dodo',3.99,1),
	(14,24,'Salad',2.99,2),
	(15,23,'Sweetcorn',1.99,3);

/*!40000 ALTER TABLE `ti_option_values` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_options`;

CREATE TABLE `ti_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(32) NOT NULL,
  `display_type` varchar(15) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_options` WRITE;
/*!40000 ALTER TABLE `ti_options` DISABLE KEYS */;

INSERT INTO `ti_options` (`option_id`, `option_name`, `display_type`, `priority`)
VALUES
	(22,'Cooked','radio',1),
	(23,'Toppings','checkbox',2),
	(24,'Dressing','select',3);

/*!40000 ALTER TABLE `ti_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_order_menus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_order_menus`;

CREATE TABLE `ti_order_menus` (
  `order_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `option_values` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`order_menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_order_menus` WRITE;
/*!40000 ALTER TABLE `ti_order_menus` DISABLE KEYS */;

INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`, `comment`)
VALUES
	(1,1,76,'PUFF-PUFF',60,4.99,299.40,'',''),
	(2,1,79,'RICE AND DODO',4,21.97,87.88,'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|60\";s:4:\"name\";s:18:\"Assorted Meat|Dodo\";s:5:\"price\";s:9:\"5.99|3.99\";}',''),
	(3,1,78,'ATA RICE',100,15.00,1500.00,'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}',''),
	(4,20002,78,'ATA RICE',1000,16.99,16990.00,'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}',''),
	(5,20003,78,'ATA RICE',1000,16.99,16990.00,'',''),
	(6,20004,81,'Whole catfish with rice and vegetables',130,21.97,2856.10,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:2:{i:0;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}i:1;a:3:{s:8:\"value_id\";s:2:\"74\";s:10:\"value_name\";s:9:\"Sweetcorn\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(7,20004,78,'ATA RICE',100,15.00,1500.00,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"64\";s:10:\"value_name\";s:4:\"Fish\";s:11:\"value_price\";s:4:\"3.00\";}}}',''),
	(8,20004,78,'ATA RICE',10,14.99,149.90,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"63\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"2.99\";}}}',''),
	(9,20004,88,'PUFF-PUFF',11,4.99,54.89,'',''),
	(10,20004,77,'SCOTCH EGG',7,2.00,14.00,'',''),
	(11,20004,84,'EBA',100,16.98,1698.00,'a:1:{i:25;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"54\";s:10:\"value_name\";s:4:\"Beef\";s:11:\"value_price\";s:4:\"4.99\";}}}',''),
	(12,20005,78,'ATA RICE',1000,16.99,16990.00,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"65\";s:10:\"value_name\";s:4:\"Beef\";s:11:\"value_price\";s:4:\"4.99\";}}}',''),
	(13,20005,77,'SCOTCH EGG',1,2.00,2.00,'',''),
	(14,20005,81,'Whole catfish with rice and vegetables',5,25.96,129.80,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:3:{i:0;a:3:{s:8:\"value_id\";s:2:\"72\";s:10:\"value_name\";s:9:\"Jalapenos\";s:11:\"value_price\";s:4:\"3.99\";}i:1;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}i:2;a:3:{s:8:\"value_id\";s:2:\"74\";s:10:\"value_name\";s:9:\"Sweetcorn\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(15,20006,81,'Whole catfish with rice and vegetables',5,25.96,129.80,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"77\";s:10:\"value_name\";s:4:\"Fish\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:3:{i:0;a:3:{s:8:\"value_id\";s:2:\"72\";s:10:\"value_name\";s:9:\"Jalapenos\";s:11:\"value_price\";s:4:\"3.99\";}i:1;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}i:2;a:3:{s:8:\"value_id\";s:2:\"74\";s:10:\"value_name\";s:9:\"Sweetcorn\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(16,20006,77,'SCOTCH EGG',1,2.00,2.00,'',''),
	(17,20006,76,'PUFF-PUFF',30,4.99,149.70,'',''),
	(18,20006,88,'PUFF-PUFF',100,4.99,499.00,'',''),
	(19,20006,82,'African Salad',1,8.99,8.99,'',''),
	(20,20006,83,'Seafood Salad',1,5.99,5.99,'',''),
	(21,20006,79,'RICE AND DODO',10,20.97,209.70,'a:2:{i:26;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"59\";s:10:\"value_name\";s:13:\"Assorted Meat\";s:11:\"value_price\";s:4:\"5.99\";}}i:27;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"61\";s:10:\"value_name\";s:5:\"Salad\";s:11:\"value_price\";s:4:\"2.99\";}}}',''),
	(29,20007,78,'ATA RICE',100,17.99,1799.00,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"66\";s:10:\"value_name\";s:13:\"Assorted Meat\";s:11:\"value_price\";s:4:\"5.99\";}}}',''),
	(30,20007,79,'RICE AND DODO',100,14.98,1498.00,'a:1:{i:26;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"56\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"2.99\";}}}',''),
	(31,20007,84,'EBA',100,14.98,1498.00,'a:1:{i:25;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"53\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"2.99\";}}}',''),
	(62,20008,78,'ATA RICE',100,17.99,1799.00,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"66\";s:10:\"value_name\";s:13:\"Assorted Meat\";s:11:\"value_price\";s:4:\"5.99\";}}}',''),
	(63,20008,79,'RICE AND DODO',100,14.98,1498.00,'a:1:{i:26;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"56\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"2.99\";}}}',''),
	(64,20008,84,'EBA',100,14.98,1498.00,'a:1:{i:25;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"53\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"2.99\";}}}',''),
	(65,20008,78,'ATA RICE',100,15.00,1500.00,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"64\";s:10:\"value_name\";s:4:\"Fish\";s:11:\"value_price\";s:4:\"3.00\";}}}',''),
	(66,20008,78,'ATA RICE',200,16.99,3398.00,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"65\";s:10:\"value_name\";s:4:\"Beef\";s:11:\"value_price\";s:4:\"4.99\";}}}',''),
	(67,20009,76,'PUFF-PUFF',12,4.99,59.88,'',''),
	(68,20009,81,'Whole catfish with rice and vegetables',3,25.96,77.88,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:3:{i:0;a:3:{s:8:\"value_id\";s:2:\"72\";s:10:\"value_name\";s:9:\"Jalapenos\";s:11:\"value_price\";s:4:\"3.99\";}i:1;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}i:2;a:3:{s:8:\"value_id\";s:2:\"74\";s:10:\"value_name\";s:9:\"Sweetcorn\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(69,20009,80,'Special Shrimp Deluxe',11,12.99,142.89,'',''),
	(70,20009,78,'ATA RICE',10,17.99,179.90,'a:1:{i:28;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"66\";s:10:\"value_name\";s:13:\"Assorted Meat\";s:11:\"value_price\";s:4:\"5.99\";}}}',''),
	(71,20010,76,'PUFF-PUFF',300,4.99,1497.00,'',''),
	(72,20011,76,'PUFF-PUFF',30,4.99,149.70,'',''),
	(73,20011,79,'RICE AND DODO',50,17.98,899.00,'a:2:{i:26;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"57\";s:10:\"value_name\";s:4:\"Fish\";s:11:\"value_price\";s:4:\"3.00\";}}i:27;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"61\";s:10:\"value_name\";s:5:\"Salad\";s:11:\"value_price\";s:4:\"2.99\";}}}',''),
	(74,20011,81,'Whole catfish with rice and vegetables',10,25.96,259.60,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:3:{i:0;a:3:{s:8:\"value_id\";s:2:\"72\";s:10:\"value_name\";s:9:\"Jalapenos\";s:11:\"value_price\";s:4:\"3.99\";}i:1;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}i:2;a:3:{s:8:\"value_id\";s:2:\"74\";s:10:\"value_name\";s:9:\"Sweetcorn\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(75,20012,76,'PUFF-PUFF',3,4.99,14.97,'',''),
	(76,20012,77,'SCOTCH EGG',8,2.00,16.00,'',''),
	(77,20012,81,'Whole catfish with rice and vegetables',100,19.98,1998.00,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(78,20013,76,'PUFF-PUFF',3,4.99,14.97,'',''),
	(79,20013,81,'Whole catfish with rice and vegetables',100,19.98,1998.00,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(80,20014,76,'PUFF-PUFF',33,4.99,164.67,'',''),
	(81,20014,81,'Whole catfish with rice and vegetables',100,25.96,2596.00,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:3:{i:0;a:3:{s:8:\"value_id\";s:2:\"72\";s:10:\"value_name\";s:9:\"Jalapenos\";s:11:\"value_price\";s:4:\"3.99\";}i:1;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}i:2;a:3:{s:8:\"value_id\";s:2:\"74\";s:10:\"value_name\";s:9:\"Sweetcorn\";s:11:\"value_price\";s:4:\"1.99\";}}}',''),
	(82,20015,76,'PUFF-PUFF',33,4.99,164.67,'',''),
	(83,20015,81,'Whole catfish with rice and vegetables',100,25.96,2596.00,'a:2:{i:29;a:1:{i:0;a:3:{s:8:\"value_id\";s:2:\"76\";s:10:\"value_name\";s:7:\"Chicken\";s:11:\"value_price\";s:4:\"4.00\";}}i:23;a:3:{i:0;a:3:{s:8:\"value_id\";s:2:\"72\";s:10:\"value_name\";s:9:\"Jalapenos\";s:11:\"value_price\";s:4:\"3.99\";}i:1;a:3:{s:8:\"value_id\";s:2:\"73\";s:10:\"value_name\";s:8:\"Peperoni\";s:11:\"value_price\";s:4:\"1.99\";}i:2;a:3:{s:8:\"value_id\";s:2:\"74\";s:10:\"value_name\";s:9:\"Sweetcorn\";s:11:\"value_price\";s:4:\"1.99\";}}}','');

/*!40000 ALTER TABLE `ti_order_menus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_order_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_order_options`;

CREATE TABLE `ti_order_options` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `order_option_name` varchar(128) NOT NULL,
  `order_option_price` decimal(15,2) NOT NULL,
  `order_menu_id` int(11) NOT NULL,
  `menu_option_value_id` int(11) NOT NULL,
  `order_menu_option_id` int(11) NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_order_options` WRITE;
/*!40000 ALTER TABLE `ti_order_options` DISABLE KEYS */;

INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`, `order_menu_option_id`)
VALUES
	(3,1,78,'Fish',3.00,3,64,0),
	(4,20002,78,'Beef',4.99,4,65,0),
	(6,20005,81,'Chicken',4.00,14,76,0),
	(7,20005,81,'Jalapenos',3.99,14,72,0),
	(8,20005,81,'Peperoni',1.99,14,73,0),
	(9,20005,81,'Sweetcorn',1.99,14,74,0),
	(14,20006,79,'Assorted Meat',5.99,21,59,26),
	(15,20006,79,'Salad',2.99,21,61,27),
	(25,20007,84,'Chicken',2.99,31,53,25),
	(55,20008,84,'Chicken',2.99,61,53,25),
	(56,20008,78,'Assorted Meat',5.99,62,66,28),
	(57,20008,79,'Chicken',2.99,63,56,26),
	(58,20008,84,'Chicken',2.99,64,53,25),
	(59,20008,78,'Fish',3.00,65,64,28),
	(60,20008,78,'Beef',4.99,66,65,28),
	(61,20009,81,'Chicken',4.00,68,76,29),
	(62,20009,81,'Jalapenos',3.99,68,72,23),
	(63,20009,81,'Peperoni',1.99,68,73,23),
	(64,20009,81,'Sweetcorn',1.99,68,74,23),
	(65,20009,78,'Assorted Meat',5.99,70,66,28),
	(66,20011,79,'Fish',3.00,73,57,26),
	(67,20011,79,'Salad',2.99,73,61,27),
	(68,20011,81,'Chicken',4.00,74,76,29),
	(69,20011,81,'Jalapenos',3.99,74,72,23),
	(70,20011,81,'Peperoni',1.99,74,73,23),
	(71,20011,81,'Sweetcorn',1.99,74,74,23),
	(72,20012,81,'Chicken',4.00,77,76,29),
	(73,20012,81,'Peperoni',1.99,77,73,23),
	(74,20013,81,'Chicken',4.00,79,76,29),
	(75,20013,81,'Peperoni',1.99,79,73,23),
	(76,20014,81,'Chicken',4.00,81,76,29),
	(77,20014,81,'Jalapenos',3.99,81,72,23),
	(78,20014,81,'Peperoni',1.99,81,73,23),
	(79,20014,81,'Sweetcorn',1.99,81,74,23),
	(80,20015,81,'Chicken',4.00,83,76,29),
	(81,20015,81,'Jalapenos',3.99,83,72,23),
	(82,20015,81,'Peperoni',1.99,83,73,23),
	(83,20015,81,'Sweetcorn',1.99,83,74,23);

/*!40000 ALTER TABLE `ti_order_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_order_totals
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_order_totals`;

CREATE TABLE `ti_order_totals` (
  `order_total_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_total_id`,`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_order_totals` WRITE;
/*!40000 ALTER TABLE `ti_order_totals` DISABLE KEYS */;

INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`)
VALUES
	(1,1,'cart_total','Sub Total',1887.28,0),
	(2,1,'delivery','Delivery',10.00,0),
	(3,20002,'cart_total','Sub Total',16990.00,0),
	(4,20002,'delivery','Delivery',10.00,0),
	(5,20003,'cart_total','Sub Total',16990.00,0),
	(6,20003,'delivery','Delivery',10.00,0),
	(7,20003,'coupon','Coupon (5555) ',5000.00,0),
	(8,20004,'cart_total','Sub Total',6272.89,0),
	(9,20004,'delivery','Delivery',10.00,0),
	(10,20005,'cart_total','Sub Total',17121.80,0),
	(11,20005,'delivery','Delivery',10.00,0),
	(12,20005,'coupon','Coupon (5555) ',5000.00,0),
	(13,20006,'cart_total','Sub Total',1005.18,0),
	(14,20006,'delivery','Delivery',10.00,0),
	(15,20007,'cart_total','Sub Total',5094.00,0),
	(16,20007,'delivery','Delivery',10.00,0),
	(19,20008,'cart_total','Sub Total',4898.00,0),
	(20,20008,'delivery','Delivery',10.00,0),
	(21,20009,'cart_total','Sub Total',460.55,0),
	(22,20009,'order_total','Order Total',460.55,0),
	(23,20009,'delivery','Delivery',0.00,0),
	(24,20010,'cart_total','Sub Total',1497.00,0),
	(25,20010,'order_total','Order Total',1397.00,0),
	(26,20010,'delivery','Delivery',0.00,0),
	(27,20010,'coupon','Coupon (2222) ',-100.00,0),
	(28,20011,'cart_total','Sub Total',1308.30,0),
	(29,20011,'order_total','Order Total',1238.30,0),
	(30,20011,'delivery','Delivery',30.00,0),
	(31,20011,'coupon','Coupon (2222) ',-100.00,0),
	(32,20012,'cart_total','Sub Total',2028.97,0),
	(33,20012,'order_total','Order Total',2038.97,0),
	(34,20012,'delivery','Delivery',10.00,0),
	(35,20013,'cart_total','Sub Total',2012.97,0),
	(36,20013,'order_total','Order Total',2022.97,0),
	(37,20013,'delivery','Delivery',10.00,0),
	(38,20014,'cart_total','Sub Total',2760.67,0),
	(39,20014,'order_total','Order Total',2770.67,0),
	(40,20014,'delivery','Delivery',10.00,0),
	(41,20015,'cart_total','Sub Total',2760.67,0),
	(42,20015,'order_total','Order Total',2770.67,0),
	(43,20015,'delivery','Delivery',10.00,0);

/*!40000 ALTER TABLE `ti_order_totals` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_orders`;

CREATE TABLE `ti_orders` (
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
  `order_total` decimal(15,2) NOT NULL,
  `status_id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_orders` WRITE;
/*!40000 ALTER TABLE `ti_orders` DISABLE KEYS */;

INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`)
VALUES
	(1,0,'Nulla','Ipsum','nulla@lpsum.com','3829029289',11,1,'',164,'','cod','1','2015-05-24 17:59:54','2015-05-25','14:32:00',1897.28,12,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',0,11),
	(20002,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902',11,2,'',1000,'','cod','1','2015-05-24 18:45:13','2015-06-09','14:32:00',17000.00,13,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',0,13),
	(20003,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902',11,2,'',1000,'','cod','1','2015-05-26 14:06:01','2015-05-26','14:50:00',12000.00,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',0,0),
	(20004,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902',11,2,'',358,'','cod','2','2015-06-15 01:33:12','2015-06-15','01:52:00',6282.89,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',1,0),
	(20005,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902',11,2,'',1006,'','cod','1','2015-06-15 01:59:22','2015-06-15','02:19:00',12131.80,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',1,0),
	(20006,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902',11,2,'',148,'','cod','1','2015-06-15 02:09:07','2015-06-15','02:29:00',1015.18,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',1,0),
	(20007,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902',11,2,'',300,'','cod','1','2015-06-15 02:20:24','2015-06-15','02:37:00',4805.00,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',1,0),
	(20008,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902',11,2,'',300,'','cod','1','2015-06-15 02:32:58','2015-06-15','02:52:00',4908.00,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',1,0),
	(20009,0,'Vivamus','Suscipit','samjjj@gmal.com','02088279103',11,0,'',36,'','cod','2','2015-06-15 14:42:06','2015-06-15','14:34:00',460.55,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36',1,0),
	(20010,0,'Vivamus','Suscipit','samjjj@gmail.com','02088279103',11,0,'',300,'','cod','2','2015-06-15 15:09:40','2015-06-15','14:34:00',1397.00,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36',1,0),
	(20011,5,'Nulla','Ipsum','demo@demo.com','43434343',11,1,'',90,'','cod','1','2015-06-15 15:57:54','2015-06-15','16:17:00',1238.30,11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36',1,0),
	(20012,5,'Nulla','Ipsum','demo@demo.com','43434343',11,1,'',111,'','cod','1','2015-07-12 23:03:10','2015-07-12','23:21:00',2038.97,11,'::1','Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0',1,0),
	(20013,5,'Nulla','Ipsum','demo@demo.com','43434343',11,1,'',103,'','cod','1','2015-07-14 15:51:38','2015-07-14','17:00:00',2022.97,11,'::1','Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0',1,0),
	(20014,5,'Nulla','Ipsum','demo@demo.com','43434343',11,1,'',133,'','cod','1','2015-07-15 15:47:37','2015-07-15','16:07:00',2770.67,11,'::1','Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0',1,0),
	(20015,5,'Nulla','Ipsum','demo@demo.com','43434343',11,1,'',133,'I want it now','cod','1','2015-07-15 16:19:19','2015-07-15','16:39:00',2770.67,11,'::1','Mozilla/5.0 (Windows NT 6.1; rv:31.0) Gecko/20100101 Firefox/31.0',1,0);

/*!40000 ALTER TABLE `ti_orders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_pages`;

CREATE TABLE `ti_pages` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_pages` WRITE;
/*!40000 ALTER TABLE `ti_pages` DISABLE KEYS */;

INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `navigation`, `date_added`, `date_updated`, `status`)
VALUES
	(11,11,'About Us','About Us','About Us','<h3 style=\"text-align: center;\"><span style=\"color: #993300;\"><img src=\"http://tastyigniter.remote/assets/images/thumbs/Eba-(1)-250x221.jpg\" alt=\"\" width=\"250\" height=\"221\" /></span></h3>\r\n<h3 style=\"text-align: center;\"><span style=\"color: #993300;\">Aim</span></h3>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis massa ac magna sagittis, sit amet gravida metus gravida. Aenean dictum pellentesque erat, vitae adipiscing libero semper sit amet. Vestibulum nec nunc lorem. Duis vitae libero a libero hendrerit tincidunt in eu tellus. Aliquam consequat ultrices felis ut dictum. Nulla euismod felis a sem mattis ornare. Aliquam ut diam sit amet dolor iaculis molestie ac id nisl. Maecenas hendrerit convallis mi feugiat gravida. Quisque tincidunt, leo a posuere imperdiet, metus leo vestibulum orci, vel volutpat justo ligula id quam. Cras placerat tincidunt lorem eu interdum.</p>\r\n<h3 style=\"text-align: center;\">&nbsp;</h3>\r\n<h3 style=\"text-align: center;\"><span style=\"color: #993300;\">Mission</span></h3>\r\n<p>Ut eu pretium urna. In sed consectetur neque. In ornare odio erat, id ornare arcu euismod a. Ut dapibus sit amet erat commodo vestibulum. Praesent vitae lacus faucibus, rhoncus tortor et, bibendum justo. Etiam pharetra congue orci, eget aliquam orci. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend justo eros, sit amet fermentum tellus ullamcorper quis. Cras cursus mi at imperdiet faucibus. Proin iaculis, felis vitae luctus venenatis, ante tortor porta nisi, et ornare magna metus sit amet enim. Phasellus et turpis nec metus aliquet adipiscing. Etiam at augue nec odio lacinia tincidunt. Suspendisse commodo commodo ipsum ac sollicitudin. Nunc nec consequat lacus. Donec gravida rhoncus justo sed elementum.</p>\r\n<h3 style=\"text-align: center;\"><span style=\"color: #a52a2a;\">Vision</span></h3>\r\n<p>Praesent erat massa, consequat a nulla et, eleifend facilisis risus. Nullam libero mi, bibendum id eleifend vitae, imperdiet a nulla. Fusce congue porta ultricies. Vivamus felis lectus, egestas at pretium vitae, posuere a nibh. Mauris lobortis urna nec rhoncus consectetur. Fusce sed placerat sem. Nulla venenatis elit risus, non auctor arcu lobortis eleifend. Ut aliquet vitae velit a faucibus. Suspendisse quis risus sit amet arcu varius malesuada. Vestibulum vitae massa consequat, euismod lorem a, euismod lacus. Duis sagittis dolor risus, ac vehicula mauris lacinia quis. Nulla facilisi. Duis tristique ipsum nec egestas auctor. Nullam in felis vel ligula dictum tincidunt nec a neque. Praesent in egestas elit.</p>','','',17,'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}','2014-04-19 16:57:21','2015-06-17 18:33:07',1),
	(12,11,'Policy','Policy','Policy','<div id=\"lipsum\">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ligula eros, semper a lorem et, venenatis volutpat dolor. Pellentesque hendrerit lectus feugiat nulla cursus, quis dapibus dolor porttitor. Donec velit enim, adipiscing ac orci id, congue tincidunt arcu. Proin egestas nulla eget leo scelerisque, et semper diam ornare. Suspendisse potenti. Suspendisse vitae bibendum enim. Duis eu ligula hendrerit, lacinia felis in, mollis nisi. Sed gravida arcu in laoreet dictum. Nulla faucibus lectus a mollis dapibus. Fusce vehicula convallis urna, et congue nulla ultricies in. Nulla magna velit, bibendum eu odio et, euismod rhoncus sem. Nullam quis magna fermentum, ultricies neque nec, blandit neque. Etiam nec congue arcu. Curabitur sed tellus quam. Cras adipiscing odio odio, et porttitor dui suscipit eget. Aliquam non est commodo, elementum turpis at, pellentesque lorem.</p>\r\n<p>Duis nec diam diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate est et lorem sagittis, et mollis libero ultricies. Nunc ultrices tortor vel convallis varius. In dolor dolor, scelerisque ac faucibus ut, aliquet ac sem. Praesent consectetur lacus quis tristique posuere. Nulla sed ultricies odio. Cras tristique vulputate facilisis.</p>\r\n<p>Mauris at metus in magna condimentum gravida eu tincidunt urna. Praesent sodales vel mi eu condimentum. Suspendisse in luctus purus. Vestibulum dignissim, metus non luctus accumsan, odio ligula pharetra massa, in eleifend turpis risus in diam. Sed non lorem nibh. Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci. Nulla eget quam sit amet risus rhoncus lacinia a ut eros. Praesent non libero nisi. Mauris tincidunt at purus sit amet adipiscing. Donec interdum, velit nec dignissim vehicula, libero ipsum imperdiet ligula, lacinia mattis augue dui ac lacus. Aenean molestie sed nunc at pulvinar. Fusce ornare lacus non venenatis rhoncus.</p>\r\n<p>Aenean at enim luctus ante commodo consequat nec ut mi. Sed porta adipiscing tempus. Aliquam sit amet ullamcorper ipsum, id adipiscing quam. Fusce iaculis odio ut nisi convallis hendrerit. Morbi auctor adipiscing ligula, sit amet aliquet ante consectetur at. Donec vulputate neque eleifend libero pellentesque, vitae lacinia enim ornare. Vestibulum fermentum erat blandit, ultricies felis ac, facilisis augue. Nulla facilisis mi porttitor, interdum diam in, lobortis ipsum. In molestie quam nisl, lacinia convallis tellus fermentum ac. Nulla quis velit augue. Fusce accumsan, lacus et lobortis blandit, neque magna gravida enim, dignissim ultricies tortor dui in dolor. Vestibulum vel convallis justo, quis venenatis elit. Aliquam erat volutpat. Nunc quis iaculis ligula. Suspendisse dictum sodales neque vitae faucibus. Fusce id tellus pretium, varius nunc et, placerat metus.</p>\r\n<p>Pellentesque quis facilisis mauris. Phasellus porta, metus a dignissim viverra, est elit luctus erat, nec ultricies ligula lorem eget sapien. Pellentesque ac justo velit. Maecenas semper accumsan nulla eget rhoncus. Aliquam vel urna sed nibh dignissim auctor. Integer volutpat lacus ac purus convallis, at lobortis nisi tincidunt. Vestibulum condimentum elit ac sapien placerat, at ornare libero hendrerit. Cras tincidunt nunc sit amet ante bibendum tempor. Fusce quam orci, suscipit sed eros quis, vulputate molestie metus. Nam hendrerit vitae felis et porttitor. Proin et commodo velit, id porta erat. Donec eu consectetur odio. Fusce porta odio risus. Aliquam vel erat feugiat, vestibulum elit eget, ornare sapien. Sed sed nulla justo. Sed a dolor eu justo lacinia blandit</p>\r\n</div>','','',17,'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}','2014-04-19 17:21:23','2015-05-16 09:18:39',1);

/*!40000 ALTER TABLE `ti_pages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_permalinks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_permalinks`;

CREATE TABLE `ti_permalinks` (
  `permalink_id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `query` varchar(255) NOT NULL,
  PRIMARY KEY (`permalink_id`),
  UNIQUE KEY `uniqueSlug` (`slug`,`controller`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_permalinks` WRITE;
/*!40000 ALTER TABLE `ti_permalinks` DISABLE KEYS */;

INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`)
VALUES
	(11,'traditional','menus','category_id=19'),
	(12,'vegetarian','menus','category_id=20'),
	(13,'soups','menus','category_id=21'),
	(14,'specials','menus','category_id=24'),
	(16,'salads','menus','category_id=17'),
	(18,'appetizer','menus','category_id=15'),
	(19,'main-course','menus','category_id=16'),
	(20,'seafoods','menus','category_id=18'),
	(37,'about-us','pages','page_id=11'),
	(41,'rice-dishes','menus','category_id=26'),
	(42,'lewisham','local','location_id=11'),
	(43,'hackney','local','location_id=12'),
	(44,'earling','local','location_id=13');

/*!40000 ALTER TABLE `ti_permalinks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_permissions`;

CREATE TABLE `ti_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_permissions` WRITE;
/*!40000 ALTER TABLE `ti_permissions` DISABLE KEYS */;

INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`)
VALUES
	(11,'Admin.Banners','Ability to access, manage, add and delete banners','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(12,'Admin.Categories','Ability to access, manage, add and delete categories','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(13,'Site.Countries','Ability to manage, add and delete site countries','a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}',1),
	(14,'Admin.Coupons','Ability to access, manage, add and delete coupons','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(15,'Site.Currencies','Ability to access, manage, add and delete site currencies','a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}',1),
	(16,'Admin.CustomerGroups','Ability to access, manage, add and delete customer groups','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(17,'Admin.Customers','Ability to access, manage, add and delete customers','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(18,'Admin.CustomersOnline','Ability to access online customers','a:1:{i:0;s:6:\"access\";}',1),
	(19,'Admin.Maintenance','Ability to access, backup, restore and migrate database','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(20,'Admin.ErrorLogs','Ability to access and delete error logs file','a:2:{i:0;s:6:\"access\";i:1;s:6:\"delete\";}',1),
	(21,'Admin.Extensions','Ability to access, manage, add and delete extension','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(22,'Admin.MediaManager','Ability to access, manage, add and delete media items','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(23,'Site.Languages','Ability to manage, add and delete site languages','a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}',1),
	(24,'Site.Layouts','Ability to manage, add and delete site layouts','a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}',1),
	(25,'Admin.Locations','Ability to access, manage, add and delete locations','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(26,'Admin.MailTemplates','Ability to access, manage, add and delete mail templates','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(27,'Admin.MenuOptions','Ability to access, manage, add and delete menu option items','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(28,'Admin.Menus','Ability to access, manage, add and delete menu items','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(29,'Admin.Messages','Ability to add and delete messages','a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}',1),
	(30,'Admin.Orders','Ability to access, manage, add and delete orders','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(31,'Site.Pages','Ability to manage, add and delete site pages','a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}',1),
	(32,'Admin.Payments','Ability to access, add and delete extension payments','a:3:{i:0;s:6:\"access\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}',1),
	(33,'Admin.Permissions','Ability to manage, add and delete staffs permissions','a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}',1),
	(34,'Admin.Ratings','Ability to add and delete review ratings','a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}',1),
	(35,'Admin.Reservations','Ability to access, manage, add and delete reservations','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(36,'Admin.Reviews','Ability to access, manage, add and delete user reviews','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(37,'Admin.SecurityQuestions','Ability to add and delete customer registration security questions','a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}',1),
	(38,'Site.Settings','Ability to manage system settings','a:1:{i:0;s:6:\"manage\";}',1),
	(39,'Admin.StaffGroups','Ability to access, manage, add and delete staff groups','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(40,'Admin.Staffs','Ability to access, manage, add and delete staffs','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(42,'Admin.Statuses','Ability to access, manage, add and delete orders and reservations statuses','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(43,'Admin.Tables','Ability to access, manage, add and delete reservations tables','a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}',1),
	(44,'Site.Themes','Ability to access, manage site themes','a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}',1),
	(45,'Module.AccountModule','Ability to manage account module','a:1:{i:0;s:6:\"manage\";}',1),
	(46,'Module.BannersModule','Ability to manage banners module','a:1:{i:0;s:6:\"manage\";}',1),
	(47,'Module.CartModule','Ability to manage cart module','a:1:{i:0;s:6:\"manage\";}',1),
	(48,'Module.CategoriesModule','Ability to manage categories module','a:1:{i:0;s:6:\"manage\";}',1),
	(49,'Module.LocalModule','Ability to manage local module','a:1:{i:0;s:6:\"manage\";}',1),
	(50,'Module.PagesModule','Ability to manage pages module','a:1:{i:0;s:6:\"manage\";}',1),
	(51,'Module.ReservationModule','Ability to manage reservation module','a:1:{i:0;s:6:\"manage\";}',1),
	(52,'Module.Slideshow','Ability to manage slideshow module','a:1:{i:0;s:6:\"manage\";}',1),
	(53,'Payment.Cod','Ability to manage cash on delivery payment','a:1:{i:0;s:6:\"manage\";}',1),
	(54,'Payment.PaypalExpress','Ability to manage paypal express payment','a:1:{i:0;s:6:\"manage\";}',1);

/*!40000 ALTER TABLE `ti_permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_pp_payments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_pp_payments`;

CREATE TABLE `ti_pp_payments` (
  `transaction_id` varchar(19) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `serialized` text NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table ti_reservations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_reservations`;

CREATE TABLE `ti_reservations` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_reservations` WRITE;
/*!40000 ALTER TABLE `ti_reservations` DISABLE KEYS */;

INSERT INTO `ti_reservations` (`reservation_id`, `location_id`, `table_id`, `guest_num`, `occasion_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `comment`, `reserve_time`, `reserve_date`, `date_added`, `date_modified`, `assignee_id`, `notify`, `ip_address`, `user_agent`, `status`)
VALUES
	(2446,11,22,7,4,1,'Sam','Poyigi','temi@temi.com','100000000','','16:00:00','2015-06-24','2015-02-21','2015-05-07',11,1,'192.168.1.124','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0',16),
	(2447,11,7,2,0,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902','','18:45:00','2015-06-30','2015-06-24','2015-06-24',0,0,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',18),
	(2448,11,7,2,0,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902','','17:15:00','2015-06-30','2015-06-24','2015-06-24',0,0,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',18),
	(2449,11,7,6,0,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902','','18:15:00','2015-06-30','2015-06-24','2015-06-24',0,0,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',18),
	(2450,11,22,6,0,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902','','18:30:00','2015-06-30','2015-06-24','2015-06-24',0,0,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',18),
	(2451,11,18,6,0,1,'Sam','Poyigi','sampoyigi@gmail.com','4883930902','','19:00:00','2015-06-30','2015-06-24','2015-06-24',0,0,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0',18);

/*!40000 ALTER TABLE `ti_reservations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_reviews`;

CREATE TABLE `ti_reviews` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_reviews` WRITE;
/*!40000 ALTER TABLE `ti_reviews` DISABLE KEYS */;

INSERT INTO `ti_reviews` (`review_id`, `customer_id`, `sale_id`, `sale_type`, `author`, `location_id`, `quality`, `delivery`, `service`, `review_text`, `date_added`, `review_status`)
VALUES
	(1,1,20002,'order','Sam Poyigi',11,5,4,3,'Curabitur molestie augue nec laoreet gravida. Ut consequat id ipsum id porttitor. In vel ante vel risus dapibus tempor sit amet quis tellus. In placerat hendrerit tellus, ac dapibus nulla congue quis. Sed ac suscipit sem. Suspendisse eget molestie libero, non rutrum felis. Phasellus eu varius augue, nec viverra massa. In vel lacus id diam laoreet pellentesque id et velit.','2015-05-26 13:49:43',1),
	(2,1,20008,'order','Sam Poyigi',11,1,4,2,'Mauris maximus tempor ligula vitae placerat. Proin at orci fermentum, aliquam turpis sit amet, ultrices risus. Donec pellentesque justo in pharetra rutrum. Cras ac dui eu orci lacinia consequat vitae quis sapien. Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada. Mauris iaculis ac nisi at euismod. Nunc sit amet luctus ipsum. Pellentesque eget lobortis turpis.','2015-06-16 19:14:31',1),
	(3,1,20007,'order','Sam Poyigi',11,4,3,3,'Mauris maximus tempor ligula vitae placerat. Proin at orci fermentum, aliquam turpis sit amet, ultrices risus. Donec pellentesque justo in pharetra rutrum. Cras ac dui eu orci lacinia consequat vitae quis sapien. Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada. Mauris iaculis ac nisi at euismod. Nunc sit amet luctus ipsum. Pellentesque eget lobortis turpis.','2015-06-24 15:33:13',0);

/*!40000 ALTER TABLE `ti_reviews` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_security_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_security_questions`;

CREATE TABLE `ti_security_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_security_questions` WRITE;
/*!40000 ALTER TABLE `ti_security_questions` DISABLE KEYS */;

INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`)
VALUES
	(11,'Whats your pets name?',1),
	(12,'What high school did you attend?',2),
	(13,'What is your father\'s middle name?',7),
	(14,'What is your mother\'s name?',3),
	(15,'What is your place of birth?',4),
	(16,'Whats your favourite teacher\'s name?',5);

/*!40000 ALTER TABLE `ti_security_questions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_settings`;

CREATE TABLE `ti_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` varchar(45) NOT NULL,
  `item` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `item` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_settings` WRITE;
/*!40000 ALTER TABLE `ti_settings` DISABLE KEYS */;

INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`)
VALUES
	(7870,'prefs','mail_template_id','11',0),
	(8500,'ratings','ratings','a:1:{s:7:\"ratings\";a:5:{i:1;s:3:\"Bad\";i:2;s:5:\"Worse\";i:3;s:4:\"Good\";i:4;s:7:\"Average\";i:5;s:9:\"Excellent\";}}',1),
	(9225,'config','site_desc','',0),
	(9241,'config','search_radius','20',0),
	(9249,'config','ready_time','45',0),
	(10855,'config','stock_warning','0',0),
	(10856,'config','stock_qty_warning','0',0),
	(10889,'config','log_threshold','1',0),
	(10894,'config','index_file_url','0',0),
	(10971,'prefs','default_themes','a:2:{s:5:\"admin\";s:18:\"tastyigniter-blue/\";s:4:\"main\";s:20:\"tastyigniter-orange/\";}',1),
	(14357,'config','	canceled_reservation_status','17',0),
	(14397,'config','	confirmed_reservation_status','16',0),
	(14400,'prefs','ti_setup','installed',0),
	(14401,'prefs','ti_version','v1.4.2-beta',0),
	(15434,'config','search_by','address',0),
	(15512,'config','reservation_interval','15',0),
	(15513,'config','reservation_turn','60',0),
	(15587,'prefs','customizer_active_style','a:1:{s:4:\"main\";a:2:{i:0;s:19:\"tastyigniter-orange\";i:1;a:13:{s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"25\";s:19:\"logo_padding_bottom\";s:2:\"25\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#fdeae2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#333333\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#ffffff\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#11a2dc\";s:5:\"hover\";s:7:\"#0d7fad\";}s:6:\"button\";a:4:{s:7:\"default\";a:2:{s:10:\"background\";s:7:\"#e7e7e7\";s:6:\"border\";s:7:\"#e7e7e7\";}s:7:\"primary\";a:2:{s:10:\"background\";s:7:\"#11a2dc\";s:6:\"border\";s:7:\"#11a2dc\";}s:7:\"success\";a:2:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";}s:6:\"danger\";a:2:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";}}s:10:\"custom_css\";s:0:\"\";}}}',1),
	(15589,'prefs','default_location_id','12',0),
	(15590,'config','site_name','TastyIgniter',0),
	(15591,'config','site_email','info@tastyigniter.com',0),
	(15592,'config','site_logo','data/tastyigniter-logo-white.png',0),
	(15593,'config','country_id','222',0),
	(15594,'config','timezone','Europe/London',0),
	(15595,'config','currency_id','226',0),
	(15596,'config','language_id','11',0),
	(15597,'config','customer_group_id','11',0),
	(15598,'config','page_limit','50',0),
	(15599,'config','meta_description','',0),
	(15600,'config','meta_keywords','',0),
	(15601,'config','menus_page_limit','20',0),
	(15602,'config','show_menu_images','1',0),
	(15603,'config','menu_images_h','70',0),
	(15604,'config','menu_images_w','70',0),
	(15605,'config','special_category_id','15',0),
	(15606,'config','registration_terms','1',0),
	(15607,'config','checkout_terms','0',0),
	(15608,'config','registration_email','1',0),
	(15609,'config','customer_order_email','1',0),
	(15610,'config','customer_reserve_email','1',0),
	(15611,'config','main_address','a:6:{s:9:\"address_1\";s:16:\"400 Lewisham Way\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:8:\"Lewisham\";s:8:\"postcode\";s:8:\"SE10 9HF\";s:11:\"location_id\";s:2:\"12\";s:10:\"country_id\";s:3:\"222\";}',1),
	(15612,'config','maps_api_key','',0),
	(15613,'config','distance_unit','mi',0),
	(15614,'config','future_orders','0',0),
	(15615,'config','location_order','1',0),
	(15616,'config','location_order_email','1',0),
	(15617,'config','location_reserve_email','1',0),
	(15618,'config','approve_reviews','1',0),
	(15619,'config','new_order_status','11',0),
	(15620,'config','complete_order_status','15',0),
	(15621,'config','canceled_order_status','19',0),
	(15622,'config','guest_order','1',0),
	(15623,'config','delivery_time','45',0),
	(15624,'config','collection_time','15',0),
	(15625,'config','reservation_mode','1',0),
	(15626,'config','new_reservation_status','18',0),
	(15627,'config','confirmed_reservation_status','16',0),
	(15628,'config','canceled_reservation_status','17',0),
	(15629,'config','reservation_time_interval','15',0),
	(15630,'config','reservation_stay_time','60',0),
	(15631,'config','image_manager','a:11:{s:8:\"max_size\";s:3:\"300\";s:11:\"thumb_width\";s:3:\"320\";s:12:\"thumb_height\";s:3:\"220\";s:7:\"uploads\";s:1:\"0\";s:10:\"new_folder\";s:1:\"0\";s:4:\"copy\";s:1:\"0\";s:4:\"move\";s:1:\"0\";s:6:\"rename\";s:1:\"0\";s:6:\"delete\";s:1:\"0\";s:15:\"transliteration\";s:1:\"0\";s:13:\"remember_days\";s:1:\"7\";}',1),
	(15632,'config','protocol','mail',0),
	(15633,'config','mailtype','html',0),
	(15634,'config','smtp_host','',0),
	(15635,'config','smtp_port','',0),
	(15636,'config','smtp_user','tastyadmin',0),
	(15637,'config','smtp_pass','demoadmin',0),
	(15638,'config','customer_online_time_out','300',0),
	(15639,'config','customer_online_archive_time_out','0',0),
	(15640,'config','permalink','1',0),
	(15641,'config','maintenance_mode','0',0),
	(15642,'config','maintenance_message','Site is under maintenance. Please check back later.',0),
	(15643,'config','cache_mode','0',0),
	(15644,'config','cache_time','60',0);

/*!40000 ALTER TABLE `ti_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_staff_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_staff_groups`;

CREATE TABLE `ti_staff_groups` (
  `staff_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_group_name` varchar(32) NOT NULL,
  `location_access` tinyint(1) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`staff_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_staff_groups` WRITE;
/*!40000 ALTER TABLE `ti_staff_groups` DISABLE KEYS */;

INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permissions`)
VALUES
	(11,'Administrator',0,'a:44:{i:11;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:12;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:13;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:14;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:15;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:16;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:17;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:18;a:1:{i:0;s:6:\"access\";}i:19;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:20;a:2:{i:0;s:6:\"access\";i:1;s:6:\"delete\";}i:21;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:22;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:25;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:26;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:27;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:28;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:29;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:30;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:32;a:3:{i:0;s:6:\"access\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:33;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:34;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:35;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:36;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:37;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:39;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:40;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:41;a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}i:42;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:43;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:23;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:24;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:31;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:38;a:1:{i:0;s:6:\"manage\";}i:44;a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}i:45;a:1:{i:0;s:6:\"manage\";}i:46;a:1:{i:0;s:6:\"manage\";}i:47;a:1:{i:0;s:6:\"manage\";}i:48;a:1:{i:0;s:6:\"manage\";}i:49;a:1:{i:0;s:6:\"manage\";}i:50;a:1:{i:0;s:6:\"manage\";}i:51;a:1:{i:0;s:6:\"manage\";}i:52;a:1:{i:0;s:6:\"manage\";}i:53;a:1:{i:0;s:6:\"manage\";}i:54;a:1:{i:0;s:6:\"manage\";}}'),
	(12,'Delivery',0,'a:23:{i:11;a:1:{i:0;s:6:\"access\";}i:12;a:1:{i:0;s:6:\"access\";}i:14;a:1:{i:0;s:6:\"access\";}i:16;a:1:{i:0;s:6:\"access\";}i:17;a:1:{i:0;s:6:\"access\";}i:18;a:1:{i:0;s:6:\"access\";}i:19;a:1:{i:0;s:6:\"access\";}i:20;a:1:{i:0;s:6:\"access\";}i:21;a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}i:22;a:1:{i:0;s:6:\"access\";}i:25;a:1:{i:0;s:6:\"access\";}i:26;a:1:{i:0;s:6:\"access\";}i:27;a:1:{i:0;s:6:\"access\";}i:28;a:1:{i:0;s:6:\"access\";}i:30;a:1:{i:0;s:6:\"access\";}i:32;a:1:{i:0;s:6:\"access\";}i:35;a:1:{i:0;s:6:\"access\";}i:36;a:1:{i:0;s:6:\"access\";}i:39;a:1:{i:0;s:6:\"access\";}i:40;a:1:{i:0;s:6:\"access\";}i:42;a:1:{i:0;s:6:\"access\";}i:43;a:1:{i:0;s:6:\"access\";}i:44;a:1:{i:0;s:6:\"access\";}}'),
	(13,'Manager',0,'a:41:{i:11;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:12;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:14;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:16;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:17;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:18;a:1:{i:0;s:6:\"access\";}i:21;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:22;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:25;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:26;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:27;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:28;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:29;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:30;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:32;a:3:{i:0;s:6:\"access\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:33;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:34;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:35;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:36;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:37;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:39;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:40;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:42;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:43;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:13;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:15;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:23;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:24;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:31;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:38;a:1:{i:0;s:6:\"manage\";}i:44;a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}i:45;a:1:{i:0;s:6:\"manage\";}i:46;a:1:{i:0;s:6:\"manage\";}i:47;a:1:{i:0;s:6:\"manage\";}i:48;a:1:{i:0;s:6:\"manage\";}i:49;a:1:{i:0;s:6:\"manage\";}i:50;a:1:{i:0;s:6:\"manage\";}i:51;a:1:{i:0;s:6:\"manage\";}i:52;a:1:{i:0;s:6:\"manage\";}i:53;a:1:{i:0;s:6:\"manage\";}i:54;a:1:{i:0;s:6:\"manage\";}}');

/*!40000 ALTER TABLE `ti_staff_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_staffs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_staffs`;

CREATE TABLE `ti_staffs` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_staffs` WRITE;
/*!40000 ALTER TABLE `ti_staffs` DISABLE KEYS */;

INSERT INTO `ti_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_group_id`, `staff_location_id`, `timezone`, `language_id`, `date_added`, `staff_status`)
VALUES
	(11,'Admin','info@tastyigniter.com',11,0,'0',0,'2015-05-24',1),
	(12,'Iana','iana@iana.com',13,0,'0',0,'2015-05-25',1),
	(13,'Kitchen Staff','sampoyigi@gmail.com',12,0,'0',0,'2015-06-02',1);

/*!40000 ALTER TABLE `ti_staffs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_status_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_status_history`;

CREATE TABLE `ti_status_history` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_status_history` WRITE;
/*!40000 ALTER TABLE `ti_status_history` DISABLE KEYS */;

INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`)
VALUES
	(1,1,0,0,11,0,'order','Your order has been received.','2015-05-24 17:59:54'),
	(2,20002,0,0,11,0,'order','Your order has been received.','2015-05-24 18:45:13'),
	(3,1,11,11,12,1,'order','Your order is pending','2015-05-25 14:22:40'),
	(4,20003,0,0,11,0,'order','Your order has been received.','2015-05-26 14:06:01'),
	(5,0,12,13,12,0,'order','Your order is pending','2015-06-06 00:47:09'),
	(6,0,11,13,13,0,'order','Your order is in the kitchen','2015-06-09 09:42:11'),
	(7,20002,11,13,12,0,'order','Your order is pending','2015-06-09 09:54:34'),
	(8,20002,11,13,12,0,'order','Your order is pending','2015-06-09 09:56:12'),
	(9,20002,11,13,13,0,'order','Your order is in the kitchen','2015-06-09 09:56:28'),
	(10,2446,11,11,16,1,'reserve','Your table reservation has been confirmed.','2015-06-09 10:57:23'),
	(11,20004,0,0,11,1,'order','Your order has been received.','2015-06-15 01:33:12'),
	(12,20005,0,0,11,1,'order','Your order has been received.','2015-06-15 01:59:22'),
	(13,20006,0,0,11,1,'order','Your order has been received.','2015-06-15 02:09:07'),
	(14,20007,0,0,11,1,'order','Your order has been received.','2015-06-15 02:15:46'),
	(15,20008,0,0,11,1,'order','Your order has been received.','2015-06-15 02:29:40'),
	(16,20008,0,0,11,1,'order','Your order has been received.','2015-06-15 02:32:58'),
	(17,20009,0,0,11,1,'order','Your order has been received.','2015-06-15 14:42:06'),
	(18,20010,0,0,11,1,'order','Your order has been received.','2015-06-15 15:09:40'),
	(19,20011,0,0,11,1,'order','Your order has been received.','2015-06-15 15:57:54'),
	(20,2447,0,0,18,0,'reserve','','2015-06-24 00:45:07'),
	(21,2448,0,0,18,0,'reserve','Your table reservation is pending.','2015-06-24 00:51:01'),
	(22,2449,0,0,18,0,'reserve','Your table reservation is pending.','2015-06-24 01:27:52'),
	(23,2450,0,0,18,0,'reserve','Your table reservation is pending.','2015-06-24 01:56:29'),
	(24,2451,0,0,18,0,'reserve','Your table reservation is pending.','2015-06-24 01:58:24'),
	(25,20012,0,0,11,1,'order','Your order has been received.','2015-07-12 23:03:10'),
	(26,20013,0,0,11,1,'order','Your order has been received.','2015-07-14 15:51:38'),
	(27,20014,0,0,11,1,'order','Your order has been received.','2015-07-15 15:47:37'),
	(28,20015,0,0,11,1,'order','Your order has been received.','2015-07-15 16:19:19');

/*!40000 ALTER TABLE `ti_status_history` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_statuses`;

CREATE TABLE `ti_statuses` (
  `status_id` int(15) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) NOT NULL,
  `status_comment` text NOT NULL,
  `notify_customer` tinyint(1) NOT NULL,
  `status_for` varchar(10) NOT NULL,
  `status_color` varchar(32) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_statuses` WRITE;
/*!40000 ALTER TABLE `ti_statuses` DISABLE KEYS */;

INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`)
VALUES
	(11,'Received','Your order has been received.',1,'order','#686663'),
	(12,'Pending','Your order is pending',1,'order','#f0ad4e'),
	(13,'Preparation','Your order is in the kitchen',1,'order','#00c0ef'),
	(14,'Delivery','Your order will be with you shortly.',0,'order','#00a65a'),
	(15,'Completed','',0,'order','#00a65a'),
	(16,'Confirmed','Your table reservation has been confirmed.',0,'reserve','#00a65a'),
	(17,'Canceled','Your table reservation has been canceled.',0,'reserve','#dd4b39'),
	(18,'Pending','Your table reservation is pending.',0,'reserve',''),
	(19,'Canceled','',0,'order','#ea0b29');

/*!40000 ALTER TABLE `ti_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_tables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_tables`;

CREATE TABLE `ti_tables` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(32) NOT NULL,
  `min_capacity` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `table_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_tables` WRITE;
/*!40000 ALTER TABLE `ti_tables` DISABLE KEYS */;

INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`)
VALUES
	(1,'EE10',2,10,1),
	(2,'NN02',2,4,1),
	(6,'SW77',10,40,1),
	(7,'EW77',2,8,1),
	(8,'SE78',4,6,1),
	(9,'NE8',8,10,1),
	(10,'SW55',9,10,1),
	(11,'EW88',2,10,0),
	(12,'EE732',3,6,1),
	(14,'FW79',4,10,0),
	(16,'SSW77',10,40,1),
	(17,'EEW77',6,8,1),
	(18,'SSE78',4,6,1),
	(19,'NNE8',8,10,1),
	(20,'SSW55',9,10,1),
	(21,'EEW88',2,10,0),
	(22,'EEE732',2,8,1),
	(24,'FFW79',4,10,0);

/*!40000 ALTER TABLE `ti_tables` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_uri_routes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_uri_routes`;

CREATE TABLE `ti_uri_routes` (
  `uri_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `uri_route` varchar(255) NOT NULL,
  `controller` varchar(128) NOT NULL,
  `priority` tinyint(11) NOT NULL,
  PRIMARY KEY (`uri_route_id`,`uri_route`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_uri_routes` WRITE;
/*!40000 ALTER TABLE `ti_uri_routes` DISABLE KEYS */;

INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`)
VALUES
	(1,'locations','local/locations',1),
	(2,'account','account/account',2),
	(3,'(:any)','pages',3);

/*!40000 ALTER TABLE `ti_uri_routes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_users`;

CREATE TABLE `ti_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  PRIMARY KEY (`user_id`,`staff_id`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_users` WRITE;
/*!40000 ALTER TABLE `ti_users` DISABLE KEYS */;

INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`)
VALUES
	(11,11,'tastyadmin','3d6a9de5c72bd6dc71bcf99dc4e201ab73727bee','a995e5198'),
	(12,12,'iana','ae43b2b9482171182960abb86d82235725820d3f','a349c4be7'),
	(13,13,'sam','33aaf35fd6e44430381c4d9d73ba251a5946655e','7ccb62dc5');

/*!40000 ALTER TABLE `ti_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ti_working_hours
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ti_working_hours`;

CREATE TABLE `ti_working_hours` (
  `location_id` int(11) NOT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time NOT NULL DEFAULT '00:00:00',
  `closing_time` time NOT NULL DEFAULT '00:00:00',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`location_id`,`weekday`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ti_working_hours` WRITE;
/*!40000 ALTER TABLE `ti_working_hours` DISABLE KEYS */;

INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`)
VALUES
	(11,0,'00:00:00','23:59:00',1),
	(11,1,'00:00:00','23:59:00',1),
	(11,2,'00:00:00','23:59:00',1),
	(11,3,'00:00:00','23:59:00',1),
	(11,4,'00:00:00','23:59:00',1),
	(11,5,'00:00:00','23:59:00',1),
	(11,6,'00:00:00','23:59:00',1),
	(12,0,'02:00:00','17:59:00',1),
	(12,1,'02:00:00','17:59:00',1),
	(12,2,'02:00:00','17:59:00',1),
	(12,3,'02:00:00','17:59:00',1),
	(12,4,'02:00:00','17:59:00',1),
	(12,5,'02:00:00','17:59:00',1),
	(12,6,'02:00:00','17:59:00',1),
	(13,0,'00:00:00','23:59:00',0),
	(13,1,'00:00:00','23:59:00',0),
	(13,2,'00:00:00','23:59:00',0),
	(13,3,'00:00:00','23:59:00',0),
	(13,4,'00:00:00','23:59:00',0),
	(13,5,'00:00:00','23:59:00',0),
	(13,6,'00:00:00','23:59:00',0);

/*!40000 ALTER TABLE `ti_working_hours` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
