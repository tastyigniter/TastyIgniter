#
# TABLE STRUCTURE FOR: ti_addresses
#

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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('40', '39', '5 Salamotu', '', 'Lagos', '', '23401', '156');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('41', '39', '5 Sofuye Street', '', 'Lagos', '', '23401', '156');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('42', '39', '5 Lee Road', '', 'London', '', 'SE120AP', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('43', '39', '44 Darnley Road', '', 'London', '', 'E96QH', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('44', '40', '24 Meynell Rd', '', 'London', '', 'E9 7AP', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('45', '40', '175A Wick Rd', '', 'London', '', 'E9 5AF', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('46', '0', '5 Poole Rd', '', 'Londndo', '', 'E9 7AE', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('47', '0', '5 Poole Rd', '', 'Londndo', '', 'E9 7AE', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('48', '0', '5 Poole Rd', '', 'Londndo', '', 'E9 7AE', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('49', '0', '5 Poole Rd', '', 'Londndo', '', 'E9 7AE', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('50', '0', '5 Poole Rd', '', 'Londndo', '', 'E9 7AE', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('51', '0', '5 Poole Rd', '', 'Londndo', '', 'E9 7AE', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('52', '0', '9 Burnt Lane', '', 'London', '', 'Se120AP', '222');


#
# TABLE STRUCTURE FOR: ti_banners
#

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `ti_banners` (`banner_id`, `name`, `type`, `click_url`, `language_id`, `alt_text`, `image_code`, `custom_code`, `status`) VALUES ('1', 'jbottega veneta', 'image', 'about-us', '11', 'I love rice', 'a:1:{s:4:\"path\";s:21:\"data/coconut_rice.jpg\";}', '', '1');
INSERT INTO `ti_banners` (`banner_id`, `name`, `type`, `click_url`, `language_id`, `alt_text`, `image_code`, `custom_code`, `status`) VALUES ('2', 'Demo', 'carousel', 'menus', '11', 'I love cheesecake', 'a:1:{s:5:\"paths\";a:3:{i:0;s:20:\"data/cheeasecake.jpg\";i:1;s:14:\"data/akara.jpg\";i:2;s:20:\"data/cheeasecake.jpg\";}}', '', '1');


#
# TABLE STRUCTURE FOR: ti_categories
#

DROP TABLE IF EXISTS `ti_categories`;

CREATE TABLE `ti_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('15', 'Appetizer', '', '0', 'data/no_photo.png');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('16', 'Main Course', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('17', 'Salads', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('18', 'Seafoods', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('19', 'Traditional', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('20', 'Vegetarian', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('21', 'Soups', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('22', 'Desserts', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('23', 'Drinks', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('24', 'Specials', '', '0', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`) VALUES ('26', 'Rice Dishes', '', '16', 'data/vegetable-fried-rice.jpg');


#
# TABLE STRUCTURE FOR: ti_countries
#

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
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('1', 'Afghanistan', 'AF', 'AFG', '', '1', 'data/flags/af.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('2', 'Albania', 'AL', 'ALB', '', '1', 'data/flags/al.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('3', 'Algeria', 'DZ', 'DZA', '', '1', 'data/flags/dz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('4', 'American Samoa', 'AS', 'ASM', '', '1', 'data/flags/as.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('5', 'Andorra', 'AD', 'AND', '', '1', 'data/flags/ad.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('6', 'Angola', 'AO', 'AGO', '', '1', 'data/flags/ao.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('7', 'Anguilla', 'AI', 'AIA', '', '1', 'data/flags/ai.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('8', 'Antarctica', 'AQ', 'ATA', '', '1', 'data/flags/aq.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('9', 'Antigua and Barbuda', 'AG', 'ATG', '', '1', 'data/flags/ag.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('10', 'Argentina', 'AR', 'ARG', '', '1', 'data/flags/ar.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('11', 'Armenia', 'AM', 'ARM', '', '1', 'data/flags/am.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('12', 'Aruba', 'AW', 'ABW', '', '1', 'data/flags/aw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('13', 'Australia', 'AU', 'AUS', '', '1', 'data/flags/au.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('14', 'Austria', 'AT', 'AUT', '', '1', 'data/flags/at.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('15', 'Azerbaijan', 'AZ', 'AZE', '', '1', 'data/flags/az.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('16', 'Bahamas', 'BS', 'BHS', '', '1', 'data/flags/bs.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('17', 'Bahrain', 'BH', 'BHR', '', '1', 'data/flags/bh.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('18', 'Bangladesh', 'BD', 'BGD', '', '1', 'data/flags/bd.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('19', 'Barbados', 'BB', 'BRB', '', '1', 'data/flags/bb.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('20', 'Belarus', 'BY', 'BLR', '', '1', 'data/flags/by.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('21', 'Belgium', 'BE', 'BEL', '', '1', 'data/flags/be.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('22', 'Belize', 'BZ', 'BLZ', '', '1', 'data/flags/bz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('23', 'Benin', 'BJ', 'BEN', '', '1', 'data/flags/bj.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('24', 'Bermuda', 'BM', 'BMU', '', '1', 'data/flags/bm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('25', 'Bhutan', 'BT', 'BTN', '', '1', 'data/flags/bt.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('26', 'Bolivia', 'BO', 'BOL', '', '1', 'data/flags/bo.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('27', 'Bosnia and Herzegowina', 'BA', 'BIH', '', '1', 'data/flags/ba.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('28', 'Botswana', 'BW', 'BWA', '', '1', 'data/flags/bw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('29', 'Bouvet Island', 'BV', 'BVT', '', '1', 'data/flags/bv.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('30', 'Brazil', 'BR', 'BRA', '', '1', 'data/flags/br.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('31', 'British Indian Ocean Territory', 'IO', 'IOT', '', '1', 'data/flags/io.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('32', 'Brunei Darussalam', 'BN', 'BRN', '', '1', 'data/flags/bn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('33', 'Bulgaria', 'BG', 'BGR', '', '1', 'data/flags/bg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('34', 'Burkina Faso', 'BF', 'BFA', '', '1', 'data/flags/bf.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('35', 'Burundi', 'BI', 'BDI', '', '1', 'data/flags/bi.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('36', 'Cambodia', 'KH', 'KHM', '', '1', 'data/flags/kh.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('37', 'Cameroon', 'CM', 'CMR', '', '1', 'data/flags/cm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('38', 'Canada', 'CA', 'CAN', '', '1', 'data/flags/ca.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('39', 'Cape Verde', 'CV', 'CPV', '', '1', 'data/flags/cv.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('40', 'Cayman Islands', 'KY', 'CYM', '', '1', 'data/flags/ky.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('41', 'Central African Republic', 'CF', 'CAF', '', '1', 'data/flags/cf.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('42', 'Chad', 'TD', 'TCD', '', '1', 'data/flags/td.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('43', 'Chile', 'CL', 'CHL', '', '1', 'data/flags/cl.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('44', 'China', 'CN', 'CHN', '', '1', 'data/flags/cn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('45', 'Christmas Island', 'CX', 'CXR', '', '1', 'data/flags/cx.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('46', 'Cocos (Keeling) Islands', 'CC', 'CCK', '', '1', 'data/flags/cc.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('47', 'Colombia', 'CO', 'COL', '', '1', 'data/flags/co.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('48', 'Comoros', 'KM', 'COM', '', '1', 'data/flags/km.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('49', 'Congo', 'CG', 'COG', '', '1', 'data/flags/cg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('50', 'Cook Islands', 'CK', 'COK', '', '1', 'data/flags/ck.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('51', 'Costa Rica', 'CR', 'CRI', '', '1', 'data/flags/cr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('52', 'Cote D\'Ivoire', 'CI', 'CIV', '', '1', 'data/flags/ci.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('53', 'Croatia', 'HR', 'HRV', '', '1', 'data/flags/hr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('54', 'Cuba', 'CU', 'CUB', '', '1', 'data/flags/cu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('55', 'Cyprus', 'CY', 'CYP', '', '1', 'data/flags/cy.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('56', 'Czech Republic', 'CZ', 'CZE', '', '1', 'data/flags/cz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('57', 'Denmark', 'DK', 'DNK', '', '1', 'data/flags/dk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('58', 'Djibouti', 'DJ', 'DJI', '', '1', 'data/flags/dj.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('59', 'Dominica', 'DM', 'DMA', '', '1', 'data/flags/dm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('60', 'Dominican Republic', 'DO', 'DOM', '', '1', 'data/flags/do.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('61', 'East Timor', 'TP', 'TMP', '', '1', 'data/flags/tp.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('62', 'Ecuador', 'EC', 'ECU', '', '1', 'data/flags/ec.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('63', 'Egypt', 'EG', 'EGY', '', '1', 'data/flags/eg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('64', 'El Salvador', 'SV', 'SLV', '', '1', 'data/flags/sv.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('65', 'Equatorial Guinea', 'GQ', 'GNQ', '', '1', 'data/flags/gq.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('66', 'Eritrea', 'ER', 'ERI', '', '1', 'data/flags/er.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('67', 'Estonia', 'EE', 'EST', '', '1', 'data/flags/ee.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('68', 'Ethiopia', 'ET', 'ETH', '', '1', 'data/flags/et.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('69', 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', '1', 'data/flags/fk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('70', 'Faroe Islands', 'FO', 'FRO', '', '1', 'data/flags/fo.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('71', 'Fiji', 'FJ', 'FJI', '', '1', 'data/flags/fj.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('72', 'Finland', 'FI', 'FIN', '', '1', 'data/flags/fi.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('73', 'France', 'FR', 'FRA', '', '1', 'data/flags/fr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('74', 'France, Metropolitan', 'FX', 'FXX', '', '1', 'data/flags/fx.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('75', 'French Guiana', 'GF', 'GUF', '', '1', 'data/flags/gf.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('76', 'French Polynesia', 'PF', 'PYF', '', '1', 'data/flags/pf.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('77', 'French Southern Territories', 'TF', 'ATF', '', '1', 'data/flags/tf.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('78', 'Gabon', 'GA', 'GAB', '', '1', 'data/flags/ga.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('79', 'Gambia', 'GM', 'GMB', '', '1', 'data/flags/gm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('80', 'Georgia', 'GE', 'GEO', '', '1', 'data/flags/ge.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('81', 'Germany', 'DE', 'DEU', '', '1', 'data/flags/de.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('82', 'Ghana', 'GH', 'GHA', '', '1', 'data/flags/gh.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('83', 'Gibraltar', 'GI', 'GIB', '', '1', 'data/flags/gi.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('84', 'Greece', 'GR', 'GRC', '', '1', 'data/flags/gr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('85', 'Greenland', 'GL', 'GRL', '', '1', 'data/flags/gl.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('86', 'Grenada', 'GD', 'GRD', '', '1', 'data/flags/gd.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('87', 'Guadeloupe', 'GP', 'GLP', '', '1', 'data/flags/gp.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('88', 'Guam', 'GU', 'GUM', '', '1', 'data/flags/gu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('89', 'Guatemala', 'GT', 'GTM', '', '1', 'data/flags/gt.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('90', 'Guinea', 'GN', 'GIN', '', '1', 'data/flags/gn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('91', 'Guinea-bissau', 'GW', 'GNB', '', '1', 'data/flags/gw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('92', 'Guyana', 'GY', 'GUY', '', '1', 'data/flags/gy.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('93', 'Haiti', 'HT', 'HTI', '', '1', 'data/flags/ht.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('94', 'Heard and Mc Donald Islands', 'HM', 'HMD', '', '1', 'data/flags/hm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('95', 'Honduras', 'HN', 'HND', '', '1', 'data/flags/hn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('96', 'Hong Kong', 'HK', 'HKG', '', '1', 'data/flags/hk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('97', 'Hungary', 'HU', 'HUN', '', '1', 'data/flags/hu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('98', 'Iceland', 'IS', 'ISL', '', '1', 'data/flags/is.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('99', 'India', 'IN', 'IND', '', '1', 'data/flags/in.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('100', 'Indonesia', 'ID', 'IDN', '', '1', 'data/flags/id.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('101', 'Iran (Islamic Republic of)', 'IR', 'IRN', '', '1', 'data/flags/ir.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('102', 'Iraq', 'IQ', 'IRQ', '', '1', 'data/flags/iq.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('103', 'Ireland', 'IE', 'IRL', '', '1', 'data/flags/ie.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('104', 'Israel', 'IL', 'ISR', '', '1', 'data/flags/il.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('105', 'Italy', 'IT', 'ITA', '', '1', 'data/flags/it.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('106', 'Jamaica', 'JM', 'JAM', '', '1', 'data/flags/jm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('107', 'Japan', 'JP', 'JPN', '', '1', 'data/flags/jp.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('108', 'Jordan', 'JO', 'JOR', '', '1', 'data/flags/jo.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('109', 'Kazakhstan', 'KZ', 'KAZ', '', '1', 'data/flags/kz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('110', 'Kenya', 'KE', 'KEN', '', '1', 'data/flags/ke.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('111', 'Kiribati', 'KI', 'KIR', '', '1', 'data/flags/ki.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('112', 'North Korea', 'KP', 'PRK', '', '1', 'data/flags/kp.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('113', 'Korea, Republic of', 'KR', 'KOR', '', '1', 'data/flags/kr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('114', 'Kuwait', 'KW', 'KWT', '', '1', 'data/flags/kw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('115', 'Kyrgyzstan', 'KG', 'KGZ', '', '1', 'data/flags/kg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('116', 'Lao People\'s Democratic Republic', 'LA', 'LAO', '', '1', 'data/flags/la.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('117', 'Latvia', 'LV', 'LVA', '', '1', 'data/flags/lv.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('118', 'Lebanon', 'LB', 'LBN', '', '1', 'data/flags/lb.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('119', 'Lesotho', 'LS', 'LSO', '', '1', 'data/flags/ls.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('120', 'Liberia', 'LR', 'LBR', '', '1', 'data/flags/lr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('121', 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', '1', 'data/flags/ly.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('122', 'Liechtenstein', 'LI', 'LIE', '', '1', 'data/flags/li.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('123', 'Lithuania', 'LT', 'LTU', '', '1', 'data/flags/lt.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('124', 'Luxembourg', 'LU', 'LUX', '', '1', 'data/flags/lu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('125', 'Macau', 'MO', 'MAC', '', '1', 'data/flags/mo.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('126', 'FYROM', 'MK', 'MKD', '', '1', 'data/flags/mk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('127', 'Madagascar', 'MG', 'MDG', '', '1', 'data/flags/mg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('128', 'Malawi', 'MW', 'MWI', '', '1', 'data/flags/mw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('129', 'Malaysia', 'MY', 'MYS', '', '1', 'data/flags/my.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('130', 'Maldives', 'MV', 'MDV', '', '1', 'data/flags/mv.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('131', 'Mali', 'ML', 'MLI', '', '1', 'data/flags/ml.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('132', 'Malta', 'MT', 'MLT', '', '1', 'data/flags/mt.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('133', 'Marshall Islands', 'MH', 'MHL', '', '1', 'data/flags/mh.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('134', 'Martinique', 'MQ', 'MTQ', '', '1', 'data/flags/mq.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('135', 'Mauritania', 'MR', 'MRT', '', '1', 'data/flags/mr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('136', 'Mauritius', 'MU', 'MUS', '', '1', 'data/flags/mu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('137', 'Mayotte', 'YT', 'MYT', '', '1', 'data/flags/yt.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('138', 'Mexico', 'MX', 'MEX', '', '1', 'data/flags/mx.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('139', 'Micronesia, Federated States of', 'FM', 'FSM', '', '1', 'data/flags/fm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('140', 'Moldova, Republic of', 'MD', 'MDA', '', '1', 'data/flags/md.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('141', 'Monaco', 'MC', 'MCO', '', '1', 'data/flags/mc.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('142', 'Mongolia', 'MN', 'MNG', '', '1', 'data/flags/mn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('143', 'Montserrat', 'MS', 'MSR', '', '1', 'data/flags/ms.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('144', 'Morocco', 'MA', 'MAR', '', '1', 'data/flags/ma.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('145', 'Mozambique', 'MZ', 'MOZ', '', '1', 'data/flags/mz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('146', 'Myanmar', 'MM', 'MMR', '', '1', 'data/flags/mm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('147', 'Namibia', 'NA', 'NAM', '', '1', 'data/flags/na.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('148', 'Nauru', 'NR', 'NRU', '', '1', 'data/flags/nr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('149', 'Nepal', 'NP', 'NPL', '', '1', 'data/flags/np.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('150', 'Netherlands', 'NL', 'NLD', '', '1', 'data/flags/nl.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('151', 'Netherlands Antilles', 'AN', 'ANT', '', '1', 'data/flags/an.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('152', 'New Caledonia', 'NC', 'NCL', '', '1', 'data/flags/nc.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('153', 'New Zealand', 'NZ', 'NZL', '', '1', 'data/flags/nz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('154', 'Nicaragua', 'NI', 'NIC', '', '1', 'data/flags/ni.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('155', 'Niger', 'NE', 'NER', '', '1', 'data/flags/ne.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('156', 'Nigeria', 'NG', 'NGA', '', '1', 'data/flags/ng.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('157', 'Niue', 'NU', 'NIU', '', '1', 'data/flags/nu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('158', 'Norfolk Island', 'NF', 'NFK', '', '1', 'data/flags/nf.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('159', 'Northern Mariana Islands', 'MP', 'MNP', '', '1', 'data/flags/mp.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('160', 'Norway', 'NO', 'NOR', '', '1', 'data/flags/no.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('161', 'Oman', 'OM', 'OMN', '', '1', 'data/flags/om.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('162', 'Pakistan', 'PK', 'PAK', '', '1', 'data/flags/pk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('163', 'Palau', 'PW', 'PLW', '', '1', 'data/flags/pw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('164', 'Panama', 'PA', 'PAN', '', '1', 'data/flags/pa.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('165', 'Papua New Guinea', 'PG', 'PNG', '', '1', 'data/flags/pg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('166', 'Paraguay', 'PY', 'PRY', '', '1', 'data/flags/py.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('167', 'Peru', 'PE', 'PER', '', '1', 'data/flags/pe.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('168', 'Philippines', 'PH', 'PHL', '', '1', 'data/flags/ph.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('169', 'Pitcairn', 'PN', 'PCN', '', '1', 'data/flags/pn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('170', 'Poland', 'PL', 'POL', '', '1', 'data/flags/pl.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('171', 'Portugal', 'PT', 'PRT', '', '1', 'data/flags/pt.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('172', 'Puerto Rico', 'PR', 'PRI', '', '1', 'data/flags/pr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('173', 'Qatar', 'QA', 'QAT', '', '1', 'data/flags/qa.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('174', 'Reunion', 'RE', 'REU', '', '1', 'data/flags/re.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('175', 'Romania', 'RO', 'ROM', '', '1', 'data/flags/ro.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('176', 'Russian Federation', 'RU', 'RUS', '', '1', 'data/flags/ru.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('177', 'Rwanda', 'RW', 'RWA', '', '1', 'data/flags/rw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('178', 'Saint Kitts and Nevis', 'KN', 'KNA', '', '1', 'data/flags/kn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('179', 'Saint Lucia', 'LC', 'LCA', '', '1', 'data/flags/lc.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('180', 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', '1', 'data/flags/vc.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('181', 'Samoa', 'WS', 'WSM', '', '1', 'data/flags/ws.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('182', 'San Marino', 'SM', 'SMR', '', '1', 'data/flags/sm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('183', 'Sao Tome and Principe', 'ST', 'STP', '', '1', 'data/flags/st.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('184', 'Saudi Arabia', 'SA', 'SAU', '', '1', 'data/flags/sa.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('185', 'Senegal', 'SN', 'SEN', '', '1', 'data/flags/sn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('186', 'Seychelles', 'SC', 'SYC', '', '1', 'data/flags/sc.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('187', 'Sierra Leone', 'SL', 'SLE', '', '1', 'data/flags/sl.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('188', 'Singapore', 'SG', 'SGP', '', '1', 'data/flags/sg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('189', 'Slovak Republic', 'SK', 'SVK', '', '1', 'data/flags/sk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('190', 'Slovenia', 'SI', 'SVN', '', '1', 'data/flags/si.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('191', 'Solomon Islands', 'SB', 'SLB', '', '1', 'data/flags/sb.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('192', 'Somalia', 'SO', 'SOM', '', '1', 'data/flags/so.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('193', 'South Africa', 'ZA', 'ZAF', '', '1', 'data/flags/za.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('194', 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', '1', 'data/flags/gs.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('195', 'Spain', 'ES', 'ESP', '', '1', 'data/flags/es.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('196', 'Sri Lanka', 'LK', 'LKA', '', '1', 'data/flags/lk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('197', 'St. Helena', 'SH', 'SHN', '', '1', 'data/flags/sh.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('198', 'St. Pierre and Miquelon', 'PM', 'SPM', '', '1', 'data/flags/pm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('199', 'Sudan', 'SD', 'SDN', '', '1', 'data/flags/sd.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('200', 'Suriname', 'SR', 'SUR', '', '1', 'data/flags/sr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('201', 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', '1', 'data/flags/sj.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('202', 'Swaziland', 'SZ', 'SWZ', '', '1', 'data/flags/sz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('203', 'Sweden', 'SE', 'SWE', '', '1', 'data/flags/se.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('204', 'Switzerland', 'CH', 'CHE', '', '1', 'data/flags/ch.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('205', 'Syrian Arab Republic', 'SY', 'SYR', '', '1', 'data/flags/sy.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('206', 'Taiwan', 'TW', 'TWN', '', '1', 'data/flags/tw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('207', 'Tajikistan', 'TJ', 'TJK', '', '1', 'data/flags/tj.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('208', 'Tanzania, United Republic of', 'TZ', 'TZA', '', '1', 'data/flags/tz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('209', 'Thailand', 'TH', 'THA', '', '1', 'data/flags/th.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('210', 'Togo', 'TG', 'TGO', '', '1', 'data/flags/tg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('211', 'Tokelau', 'TK', 'TKL', '', '1', 'data/flags/tk.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('212', 'Tonga', 'TO', 'TON', '', '1', 'data/flags/to.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('213', 'Trinidad and Tobago', 'TT', 'TTO', '', '1', 'data/flags/tt.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('214', 'Tunisia', 'TN', 'TUN', '', '1', 'data/flags/tn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('215', 'Turkey', 'TR', 'TUR', '', '1', 'data/flags/tr.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('216', 'Turkmenistan', 'TM', 'TKM', '', '1', 'data/flags/tm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('217', 'Turks and Caicos Islands', 'TC', 'TCA', '', '1', 'data/flags/tc.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('218', 'Tuvalu', 'TV', 'TUV', '', '1', 'data/flags/tv.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('219', 'Uganda', 'UG', 'UGA', '', '1', 'data/flags/ug.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('220', 'Ukraine', 'UA', 'UKR', '', '1', 'data/flags/ua.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('221', 'United Arab Emirates', 'AE', 'ARE', '', '1', 'data/flags/ae.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('222', 'United Kingdom', 'GB', 'GBR', '{address_1}\n{address_2}\n{city} {postcode} {state}\n{country}', '1', 'data/flags/gb.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('223', 'United States', 'US', 'USA', '', '1', 'data/flags/us.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('224', 'United States Minor Outlying Islands', 'UM', 'UMI', '', '1', 'data/flags/um.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('225', 'Uruguay', 'UY', 'URY', '', '1', 'data/flags/uy.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('226', 'Uzbekistan', 'UZ', 'UZB', '', '1', 'data/flags/uz.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('227', 'Vanuatu', 'VU', 'VUT', '', '1', 'data/flags/vu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('228', 'Vatican City State (Holy See)', 'VA', 'VAT', '', '1', 'data/flags/va.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('229', 'Venezuela', 'VE', 'VEN', '', '1', 'data/flags/ve.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('230', 'Viet Nam', 'VN', 'VNM', '', '1', 'data/flags/vn.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('231', 'Virgin Islands (British)', 'VG', 'VGB', '', '1', 'data/flags/vg.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('232', 'Virgin Islands (U.S.)', 'VI', 'VIR', '', '1', 'data/flags/vi.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('233', 'Wallis and Futuna Islands', 'WF', 'WLF', '', '1', 'data/flags/wf.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('234', 'Western Sahara', 'EH', 'ESH', '', '1', 'data/flags/eh.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('235', 'Yemen', 'YE', 'YEM', '', '1', 'data/flags/ye.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('236', 'Yugoslavia', 'YU', 'YUG', '', '1', 'data/flags/yu.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('237', 'Democratic Republic of Congo', 'CD', 'COD', '', '1', 'data/flags/cd.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('238', 'Zambia', 'ZM', 'ZMB', '', '1', 'data/flags/zm.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('239', 'Zimbabwe', 'ZW', 'ZWE', '', '1', 'data/flags/zw.png');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES ('241', 'Iana Island', 'SA', 'GAA', '', '1', 'data/flags/sa.png');


#
# TABLE STRUCTURE FOR: ti_coupons
#

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `status`, `date_added`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`) VALUES ('11', 'Half Sundays', '2222', 'F', '100.00', '500.00', '0', '0', '', '1', '0000-00-00', 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL);
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `status`, `date_added`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`) VALUES ('12', 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', '0', '0', '', '1', '0000-00-00', 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL);
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `status`, `date_added`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`) VALUES ('13', 'Full Mondays', 'MTo6TuTg', 'P', '50.00', '0.00', '0', '1', '', '1', '0000-00-00', 'forever', NULL, '00:00:00', '23:59:00', NULL, NULL, '', '00:00:00', '23:59:00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `status`, `date_added`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`) VALUES ('14', 'Full Tuesdays', '4444', 'F', '500.00', '5000.00', '0', '0', '', '1', '0000-00-00', 'recurring', NULL, '00:00:00', '23:59:00', NULL, NULL, '0, 2, 4, 5, 6', '00:00:00', '23:59:00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `status`, `date_added`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`) VALUES ('15', 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', '0', '0', '', '1', '0000-00-00', 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL);


#
# TABLE STRUCTURE FOR: ti_coupons_history
#

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `ti_coupons_history` (`coupon_history_id`, `coupon_id`, `order_id`, `customer_id`, `code`, `min_total`, `amount`, `date_used`) VALUES ('1', '11', '2656', '39', '2222', '0.00', '-100.00', '2015-04-12 22:32:23');
INSERT INTO `ti_coupons_history` (`coupon_history_id`, `coupon_id`, `order_id`, `customer_id`, `code`, `min_total`, `amount`, `date_used`) VALUES ('2', '12', '2697', '40', '3333', '0.00', '-30.00', '2015-05-09 22:51:32');


#
# TABLE STRUCTURE FOR: ti_currencies
#

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
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;

INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('1', '1', 'Afghani', 'AFN', '؋', 'AF', 'AFG', '4', 'AF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('2', '2', 'Lek', 'ALL', 'Lek', 'AL', 'ALB', '8', 'AL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('3', '3', 'Dinar', 'DZD', 'د.ج', 'DZ', 'DZA', '12', 'DZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('4', '4', 'Dollar', 'USD', '$', 'AS', 'ASM', '16', 'AS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('5', '5', 'Euro', 'EUR', '€', 'AD', 'AND', '20', 'AD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('6', '6', 'Kwanza', 'AOA', 'Kz', 'AO', 'AGO', '24', 'AO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('7', '7', 'Dollar', 'XCD', '$', 'AI', 'AIA', '660', 'AI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('8', '8', 'Antarctican', 'AQD', 'A$', 'AQ', 'ATA', '10', 'AQ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('9', '9', 'Dollar', 'XCD', '$', 'AG', 'ATG', '28', 'AG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('10', '10', 'Peso', 'ARS', '$', 'AR', 'ARG', '32', 'AR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('11', '11', 'Dram', 'AMD', 'դր.', 'AM', 'ARM', '51', 'AM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('12', '12', 'Guilder', 'AWG', 'ƒ', 'AW', 'ABW', '533', 'AW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('13', '13', 'Dollar', 'AUD', '$', 'AU', 'AUS', '36', 'AU.png', '1');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('14', '14', 'Euro', 'EUR', '€', 'AT', 'AUT', '40', 'AT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('15', '15', 'Manat', 'AZN', 'ман', 'AZ', 'AZE', '31', 'AZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('16', '16', 'Dollar', 'BSD', '$', 'BS', 'BHS', '44', 'BS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('17', '17', 'Dinar', 'BHD', '.د.', 'BH', 'BHR', '48', 'BH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('18', '18', 'Taka', 'BDT', '৳', 'BD', 'BGD', '50', 'BD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('19', '19', 'Dollar', 'BBD', '$', 'BB', 'BRB', '52', 'BB.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('20', '20', 'Ruble', 'BYR', 'p.', 'BY', 'BLR', '112', 'BY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('21', '21', 'Euro', 'EUR', '€', 'BE', 'BEL', '56', 'BE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('22', '22', 'Dollar', 'BZD', 'BZ$', 'BZ', 'BLZ', '84', 'BZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('23', '23', 'Franc', 'XOF', '', 'BJ', 'BEN', '204', 'BJ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('24', '24', 'Dollar', 'BMD', '$', 'BM', 'BMU', '60', 'BM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('25', '25', 'Ngultrum', 'BTN', 'Nu.', 'BT', 'BTN', '64', 'BT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('26', '26', 'Boliviano', 'BOB', '$b', 'BO', 'BOL', '68', 'BO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('27', '27', 'Marka', 'BAM', 'KM', 'BA', 'BIH', '70', 'BA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('28', '28', 'Pula', 'BWP', 'P', 'BW', 'BWA', '72', 'BW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('29', '29', 'Krone', 'NOK', 'kr', 'BV', 'BVT', '74', 'BV.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('30', '30', 'Real', 'BRL', 'R$', 'BR', 'BRA', '76', 'BR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('31', '31', 'Dollar', 'USD', '$', 'IO', 'IOT', '86', 'IO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('32', '231', 'Dollar', 'USD', '$', 'VG', 'VGB', '92', 'VG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('33', '32', 'Dollar', 'BND', '$', 'BN', 'BRN', '96', 'BN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('34', '33', 'Lev', 'BGN', 'лв', 'BG', 'BGR', '100', 'BG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('35', '34', 'Franc', 'XOF', '', 'BF', 'BFA', '854', 'BF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('36', '35', 'Franc', 'BIF', 'Fr', 'BI', 'BDI', '108', 'BI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('37', '36', 'Riels', 'KHR', '៛', 'KH', 'KHM', '116', 'KH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('38', '37', 'Franc', 'XAF', 'FCF', 'CM', 'CMR', '120', 'CM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('39', '38', 'Dollar', 'CAD', '$', 'CA', 'CAN', '124', 'CA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('40', '39', 'Escudo', 'CVE', '', 'CV', 'CPV', '132', 'CV.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('41', '40', 'Dollar', 'KYD', '$', 'KY', 'CYM', '136', 'KY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('42', '41', 'Franc', 'XAF', 'FCF', 'CF', 'CAF', '140', 'CF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('43', '42', 'Franc', 'XAF', '', 'TD', 'TCD', '148', 'TD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('44', '43', 'Peso', 'CLP', '', 'CL', 'CHL', '152', 'CL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('45', '44', 'Yuan Renminbi', 'CNY', '¥', 'CN', 'CHN', '156', 'CN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('46', '45', 'Dollar', 'AUD', '$', 'CX', 'CXR', '162', 'CX.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('47', '46', 'Dollar', 'AUD', '$', 'CC', 'CCK', '166', 'CC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('48', '47', 'Peso', 'COP', '$', 'CO', 'COL', '170', 'CO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('49', '48', 'Franc', 'KMF', '', 'KM', 'COM', '174', 'KM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('50', '50', 'Dollar', 'NZD', '$', 'CK', 'COK', '184', 'CK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('51', '51', 'Colon', 'CRC', '₡', 'CR', 'CRI', '188', 'CR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('52', '53', 'Kuna', 'HRK', 'kn', 'HR', 'HRV', '191', 'HR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('53', '54', 'Peso', 'CUP', '₱', 'CU', 'CUB', '192', 'CU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('54', '55', 'Pound', 'CYP', '', 'CY', 'CYP', '196', 'CY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('55', '56', 'Koruna', 'CZK', 'Kč', 'CZ', 'CZE', '203', 'CZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('56', '49', 'Franc', 'CDF', 'FC', 'CD', 'COD', '180', 'CD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('57', '57', 'Krone', 'DKK', 'kr', 'DK', 'DNK', '208', 'DK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('58', '58', 'Franc', 'DJF', '', 'DJ', 'DJI', '262', 'DJ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('59', '59', 'Dollar', 'XCD', '$', 'DM', 'DMA', '212', 'DM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('60', '60', 'Peso', 'DOP', 'RD$', 'DO', 'DOM', '214', 'DO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('61', '61', 'Dollar', 'USD', '$', 'TL', 'TLS', '626', 'TL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('62', '62', 'Dollar', 'USD', '$', 'EC', 'ECU', '218', 'EC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('63', '63', 'Pound', 'EGP', '£', 'EG', 'EGY', '818', 'EG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('64', '64', 'Colone', 'SVC', '$', 'SV', 'SLV', '222', 'SV.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('65', '65', 'Franc', 'XAF', 'FCF', 'GQ', 'GNQ', '226', 'GQ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('66', '66', 'Nakfa', 'ERN', 'Nfk', 'ER', 'ERI', '232', 'ER.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('67', '67', 'Kroon', 'EEK', 'kr', 'EE', 'EST', '233', 'EE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('68', '68', 'Birr', 'ETB', '', 'ET', 'ETH', '231', 'ET.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('69', '69', 'Pound', 'FKP', '£', 'FK', 'FLK', '238', 'FK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('70', '70', 'Krone', 'DKK', 'kr', 'FO', 'FRO', '234', 'FO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('71', '71', 'Dollar', 'FJD', '$', 'FJ', 'FJI', '242', 'FJ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('72', '72', 'Euro', 'EUR', '€', 'FI', 'FIN', '246', 'FI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('73', '73', 'Euro', 'EUR', '€', 'FR', 'FRA', '250', 'FR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('74', '75', 'Euro', 'EUR', '€', 'GF', 'GUF', '254', 'GF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('75', '76', 'Franc', 'XPF', '', 'PF', 'PYF', '258', 'PF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('76', '77', 'Euro  ', 'EUR', '€', 'TF', 'ATF', '260', 'TF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('77', '78', 'Franc', 'XAF', 'FCF', 'GA', 'GAB', '266', 'GA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('78', '79', 'Dalasi', 'GMD', 'D', 'GM', 'GMB', '270', 'GM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('79', '80', 'Lari', 'GEL', '', 'GE', 'GEO', '268', 'GE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('80', '81', 'Euro', 'EUR', '€', 'DE', 'DEU', '276', 'DE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('81', '82', 'Cedi', 'GHC', '¢', 'GH', 'GHA', '288', 'GH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('82', '83', 'Pound', 'GIP', '£', 'GI', 'GIB', '292', 'GI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('83', '84', 'Euro', 'EUR', '€', 'GR', 'GRC', '300', 'GR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('84', '85', 'Krone', 'DKK', 'kr', 'GL', 'GRL', '304', 'GL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('85', '86', 'Dollar', 'XCD', '$', 'GD', 'GRD', '308', 'GD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('86', '87', 'Euro', 'EUR', '€', 'GP', 'GLP', '312', 'GP.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('87', '88', 'Dollar', 'USD', '$', 'GU', 'GUM', '316', 'GU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('88', '89', 'Quetzal', 'GTQ', 'Q', 'GT', 'GTM', '320', 'GT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('89', '90', 'Franc', 'GNF', '', 'GN', 'GIN', '324', 'GN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('90', '91', 'Franc', 'XOF', '', 'GW', 'GNB', '624', 'GW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('91', '92', 'Dollar', 'GYD', '$', 'GY', 'GUY', '328', 'GY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('92', '93', 'Gourde', 'HTG', 'G', 'HT', 'HTI', '332', 'HT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('93', '94', 'Dollar', 'AUD', '$', 'HM', 'HMD', '334', 'HM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('94', '95', 'Lempira', 'HNL', 'L', 'HN', 'HND', '340', 'HN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('95', '96', 'Dollar', 'HKD', '$', 'HK', 'HKG', '344', 'HK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('96', '97', 'Forint', 'HUF', 'Ft', 'HU', 'HUN', '348', 'HU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('97', '98', 'Krona', 'ISK', 'kr', 'IS', 'ISL', '352', 'IS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('98', '99', 'Rupee', 'INR', '₹', 'IN', 'IND', '356', 'IN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('99', '100', 'Rupiah', 'IDR', 'Rp', 'ID', 'IDN', '360', 'ID.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('100', '101', 'Rial', 'IRR', '﷼', 'IR', 'IRN', '364', 'IR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('101', '102', 'Dinar', 'IQD', '', 'IQ', 'IRQ', '368', 'IQ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('102', '103', 'Euro', 'EUR', '€', 'IE', 'IRL', '372', 'IE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('103', '104', 'Shekel', 'ILS', '₪', 'IL', 'ISR', '376', 'IL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('104', '105', 'Euro', 'EUR', '€', 'IT', 'ITA', '380', 'IT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('105', '52', 'Franc', 'XOF', '', 'CI', 'CIV', '384', 'CI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('106', '106', 'Dollar', 'JMD', '$', 'JM', 'JAM', '388', 'JM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('107', '107', 'Yen', 'JPY', '¥', 'JP', 'JPN', '392', 'JP.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('108', '108', 'Dinar', 'JOD', '', 'JO', 'JOR', '400', 'JO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('109', '109', 'Tenge', 'KZT', 'лв', 'KZ', 'KAZ', '398', 'KZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('110', '110', 'Shilling', 'KES', '', 'KE', 'KEN', '404', 'KE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('111', '111', 'Dollar', 'AUD', '$', 'KI', 'KIR', '296', 'KI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('112', '114', 'Dinar', 'KWD', 'د.ك', 'KW', 'KWT', '414', 'KW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('113', '115', 'Som', 'KGS', 'лв', 'KG', 'KGZ', '417', 'KG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('114', '116', 'Kip', 'LAK', '₭', 'LA', 'LAO', '418', 'LA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('115', '117', 'Lat', 'LVL', 'Ls', 'LV', 'LVA', '428', 'LV.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('116', '118', 'Pound', 'LBP', '£', 'LB', 'LBN', '422', 'LB.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('117', '119', 'Loti', 'LSL', 'L', 'LS', 'LSO', '426', 'LS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('118', '120', 'Dollar', 'LRD', '$', 'LR', 'LBR', '430', 'LR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('119', '121', 'Dinar', 'LYD', 'ل.د', 'LY', 'LBY', '434', 'LY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('120', '122', 'Franc', 'CHF', 'CHF', 'LI', 'LIE', '438', 'LI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('121', '123', 'Litas', 'LTL', 'Lt', 'LT', 'LTU', '440', 'LT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('122', '124', 'Euro', 'EUR', '€', 'LU', 'LUX', '442', 'LU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('123', '125', 'Pataca', 'MOP', 'MOP', 'MO', 'MAC', '446', 'MO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('124', '140', 'Denar', 'MKD', 'ден', 'MK', 'MKD', '807', 'MK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('125', '127', 'Ariary', 'MGA', 'Ar', 'MG', 'MDG', '450', 'MG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('126', '128', 'Kwacha', 'MWK', 'MK', 'MW', 'MWI', '454', 'MW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('127', '129', 'Ringgit', 'MYR', 'RM', 'MY', 'MYS', '458', 'MY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('128', '130', 'Rufiyaa', 'MVR', 'Rf', 'MV', 'MDV', '462', 'MV.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('129', '131', 'Franc', 'XOF', 'MAF', 'ML', 'MLI', '466', 'ML.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('130', '132', 'Lira', 'MTL', 'Lm', 'MT', 'MLT', '470', 'MT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('131', '133', 'Dollar', 'USD', '$', 'MH', 'MHL', '584', 'MH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('132', '134', 'Euro', 'EUR', '€', 'MQ', 'MTQ', '474', 'MQ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('133', '135', 'Ouguiya', 'MRO', 'UM', 'MR', 'MRT', '478', 'MR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('134', '136', 'Rupee', 'MUR', '₨', 'MU', 'MUS', '480', 'MU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('135', '137', 'Euro', 'EUR', '€', 'YT', 'MYT', '175', 'YT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('136', '138', 'Peso', 'MXN', '$', 'MX', 'MEX', '484', 'MX.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('137', '139', 'Dollar', 'USD', '$', 'FM', 'FSM', '583', 'FM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('138', '140', 'Leu', 'MDL', 'MDL', 'MD', 'MDA', '498', 'MD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('139', '141', 'Euro', 'EUR', '€', 'MC', 'MCO', '492', 'MC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('140', '142', 'Tugrik', 'MNT', '₮', 'MN', 'MNG', '496', 'MN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('141', '143', 'Dollar', 'XCD', '$', 'MS', 'MSR', '500', 'MS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('142', '144', 'Dirham', 'MAD', '', 'MA', 'MAR', '504', 'MA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('143', '145', 'Meticail', 'MZN', 'MT', 'MZ', 'MOZ', '508', 'MZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('144', '146', 'Kyat', 'MMK', 'K', 'MM', 'MMR', '104', 'MM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('145', '147', 'Dollar', 'NAD', '$', 'NA', 'NAM', '516', 'NA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('146', '148', 'Dollar', 'AUD', '$', 'NR', 'NRU', '520', 'NR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('147', '149', 'Rupee', 'NPR', '₨', 'NP', 'NPL', '524', 'NP.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('148', '150', 'Euro', 'EUR', '€', 'NL', 'NLD', '528', 'NL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('149', '151', 'Guilder', 'ANG', 'ƒ', 'AN', 'ANT', '530', 'AN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('150', '152', 'Franc', 'XPF', '', 'NC', 'NCL', '540', 'NC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('151', '153', 'Dollar', 'NZD', '$', 'NZ', 'NZL', '554', 'NZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('152', '154', 'Cordoba', 'NIO', 'C$', 'NI', 'NIC', '558', 'NI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('153', '155', 'Franc', 'XOF', '', 'NE', 'NER', '562', 'NE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('154', '156', 'Naira', 'NGN', '₦', 'NG', 'NGA', '566', 'NG.png', '1');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('155', '157', 'Dollar', 'NZD', '$', 'NU', 'NIU', '570', 'NU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('156', '158', 'Dollar', 'AUD', '$', 'NF', 'NFK', '574', 'NF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('157', '112', 'Won', 'KPW', '₩', 'KP', 'PRK', '408', 'KP.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('158', '159', 'Dollar', 'USD', '$', 'MP', 'MNP', '580', 'MP.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('159', '160', 'Krone', 'NOK', 'kr', 'NO', 'NOR', '578', 'NO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('160', '161', 'Rial', 'OMR', '﷼', 'OM', 'OMN', '512', 'OM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('161', '162', 'Rupee', 'PKR', '₨', 'PK', 'PAK', '586', 'PK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('162', '163', 'Dollar', 'USD', '$', 'PW', 'PLW', '585', 'PW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('163', '0', 'Shekel', 'ILS', '₪', 'PS', 'PSE', '275', 'PS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('164', '164', 'Balboa', 'PAB', 'B/.', 'PA', 'PAN', '591', 'PA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('165', '165', 'Kina', 'PGK', '', 'PG', 'PNG', '598', 'PG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('166', '166', 'Guarani', 'PYG', 'Gs', 'PY', 'PRY', '600', 'PY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('167', '167', 'Sol', 'PEN', 'S/.', 'PE', 'PER', '604', 'PE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('168', '168', 'Peso', 'PHP', 'Php', 'PH', 'PHL', '608', 'PH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('169', '169', 'Dollar', 'NZD', '$', 'PN', 'PCN', '612', 'PN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('170', '170', 'Zloty', 'PLN', 'zł', 'PL', 'POL', '616', 'PL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('171', '171', 'Euro', 'EUR', '€', 'PT', 'PRT', '620', 'PT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('172', '172', 'Dollar', 'USD', '$', 'PR', 'PRI', '630', 'PR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('173', '173', 'Rial', 'QAR', '﷼', 'QA', 'QAT', '634', 'QA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('174', '49', 'Franc', 'XAF', 'FCF', 'CG', 'COG', '178', 'CG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('175', '174', 'Euro', 'EUR', '€', 'RE', 'REU', '638', 'RE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('176', '175', 'Leu', 'RON', 'lei', 'RO', 'ROU', '642', 'RO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('177', '176', 'Ruble', 'RUB', 'руб', 'RU', 'RUS', '643', 'RU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('178', '177', 'Franc', 'RWF', '', 'RW', 'RWA', '646', 'RW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('179', '179', 'Pound', 'SHP', '£', 'SH', 'SHN', '654', 'SH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('180', '178', 'Dollar', 'XCD', '$', 'KN', 'KNA', '659', 'KN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('181', '179', 'Dollar', 'XCD', '$', 'LC', 'LCA', '662', 'LC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('182', '180', 'Euro', 'EUR', '€', 'PM', 'SPM', '666', 'PM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('183', '180', 'Dollar', 'XCD', '$', 'VC', 'VCT', '670', 'VC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('184', '181', 'Tala', 'WST', 'WS$', 'WS', 'WSM', '882', 'WS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('185', '182', 'Euro', 'EUR', '€', 'SM', 'SMR', '674', 'SM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('186', '183', 'Dobra', 'STD', 'Db', 'ST', 'STP', '678', 'ST.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('187', '184', 'Rial', 'SAR', '﷼', 'SA', 'SAU', '682', 'SA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('188', '185', 'Franc', 'XOF', '', 'SN', 'SEN', '686', 'SN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('189', '142', 'Dinar', 'RSD', 'Дин', 'CS', 'SCG', '891', 'CS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('190', '186', 'Rupee', 'SCR', '₨', 'SC', 'SYC', '690', 'SC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('191', '187', 'Leone', 'SLL', 'Le', 'SL', 'SLE', '694', 'SL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('192', '188', 'Dollar', 'SGD', '$', 'SG', 'SGP', '702', 'SG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('193', '189', 'Koruna', 'SKK', 'Sk', 'SK', 'SVK', '703', 'SK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('194', '190', 'Euro', 'EUR', '€', 'SI', 'SVN', '705', 'SI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('195', '191', 'Dollar', 'SBD', '$', 'SB', 'SLB', '90', 'SB.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('196', '192', 'Shilling', 'SOS', 'S', 'SO', 'SOM', '706', 'SO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('197', '193', 'Rand', 'ZAR', 'R', 'ZA', 'ZAF', '710', 'ZA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('198', '113', 'Pound', 'GBP', '£', 'GS', 'SGS', '239', 'GS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('199', '194', 'Won', 'KRW', '₩', 'KR', 'KOR', '410', 'KR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('200', '195', 'Euro', 'EUR', '€', 'ES', 'ESP', '724', 'ES.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('201', '196', 'Rupee', 'LKR', '₨', 'LK', 'LKA', '144', 'LK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('202', '199', 'Dinar', 'SDD', '', 'SD', 'SDN', '736', 'SD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('203', '200', 'Dollar', 'SRD', '$', 'SR', 'SUR', '740', 'SR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('204', '0', 'Krone', 'NOK', 'kr', 'SJ', 'SJM', '744', 'SJ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('205', '202', 'Lilangeni', 'SZL', '', 'SZ', 'SWZ', '748', 'SZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('206', '203', 'Krona', 'SEK', 'kr', 'SE', 'SWE', '752', 'SE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('207', '204', 'Franc', 'CHF', 'CHF', 'CH', 'CHE', '756', 'CH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('208', '205', 'Pound', 'SYP', '£', 'SY', 'SYR', '760', 'SY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('209', '206', 'Dollar', 'TWD', 'NT$', 'TW', 'TWN', '158', 'TW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('210', '207', 'Somoni', 'TJS', '', 'TJ', 'TJK', '762', 'TJ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('211', '208', 'Shilling', 'TZS', '', 'TZ', 'TZA', '834', 'TZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('212', '209', 'Baht', 'THB', '฿', 'TH', 'THA', '764', 'TH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('213', '210', 'Franc', 'XOF', '', 'TG', 'TGO', '768', 'TG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('214', '211', 'Dollar', 'NZD', '$', 'TK', 'TKL', '772', 'TK.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('215', '212', 'Pa\'anga', 'TOP', 'T$', 'TO', 'TON', '776', 'TO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('216', '213', 'Dollar', 'TTD', 'TT$', 'TT', 'TTO', '780', 'TT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('217', '214', 'Dinar', 'TND', '', 'TN', 'TUN', '788', 'TN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('218', '215', 'Lira', 'TRY', 'YTL', 'TR', 'TUR', '792', 'TR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('219', '216', 'Manat', 'TMM', 'm', 'TM', 'TKM', '795', 'TM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('220', '217', 'Dollar', 'USD', '$', 'TC', 'TCA', '796', 'TC.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('221', '218', 'Dollar', 'AUD', '$', 'TV', 'TUV', '798', 'TV.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('222', '232', 'Dollar', 'USD', '$', 'VI', 'VIR', '850', 'VI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('223', '219', 'Shilling', 'UGX', '', 'UG', 'UGA', '800', 'UG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('224', '220', 'Hryvnia', 'UAH', '₴', 'UA', 'UKR', '804', 'UA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('225', '221', 'Dirham', 'AED', '', 'AE', 'ARE', '784', 'AE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('226', '222', 'Pound', 'GBP', '£', 'GB', 'GBR', '826', 'GB.png', '1');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('227', '223', 'Dollar', 'USD', '$', 'US', 'USA', '840', 'US.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('228', '224', 'Dollar ', 'USD', '$', 'UM', 'UMI', '581', 'UM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('229', '225', 'Peso', 'UYU', '$U', 'UY', 'URY', '858', 'UY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('230', '226', 'Som', 'UZS', 'лв', 'UZ', 'UZB', '860', 'UZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('231', '227', 'Vatu', 'VUV', 'Vt', 'VU', 'VUT', '548', 'VU.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('232', '228', 'Euro', 'EUR', '€', 'VA', 'VAT', '336', 'VA.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('233', '229', 'Bolivar', 'VEF', 'Bs', 'VE', 'VEN', '862', 'VE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('234', '230', 'Dong', 'VND', '₫', 'VN', 'VNM', '704', 'VN.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('235', '233', 'Franc', 'XPF', '', 'WF', 'WLF', '876', 'WF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('236', '234', 'Dirham', 'MAD', '', 'EH', 'ESH', '732', 'EH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('237', '235', 'Rial', 'YER', '﷼', 'YE', 'YEM', '887', 'YE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('238', '238', 'Kwacha', 'ZMK', 'ZK', 'ZM', 'ZMB', '894', 'ZM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('239', '239', 'Dollar', 'ZWD', 'Z$', 'ZW', 'ZWE', '716', 'ZW.png', '0');


#
# TABLE STRUCTURE FOR: ti_customer_groups
#

DROP TABLE IF EXISTS `ti_customer_groups`;

CREATE TABLE `ti_customer_groups` (
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `approval` tinyint(1) NOT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `ti_customer_groups` (`customer_group_id`, `group_name`, `description`, `approval`) VALUES ('11', 'Default', '', '0');


#
# TABLE STRUCTURE FOR: ti_customers
#

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`) VALUES ('39', 'Sam', 'Poyigi', 'demo@demo.com', 'a610f82a8ff7235182c8b5f5d65d783100611e7f', '69502ee1e', '100000000', '42', '11', 'Pike', '1', '11', '127.0.0.1', '2014-02-04 00:00:00', '1');
INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`) VALUES ('40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', 'e4b4cc9bd539ef7cf45bc9b7c574289cc6122686', '0f67d74a2', '7777050444', '45', '11', 'Spike', '1', '11', '127.0.0.1', '2015-05-07 00:00:00', '1');
INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`) VALUES ('42', 'Vivamus', 'Suscipit', 'sam@sampoyigi.com', '99869d5e05d26e19737a7c3e4814b36a5c22e548', '0e14c111d', '02088279103', '0', '11', 'Spike', '1', '11', '', '2015-05-11 00:00:00', '1');


#
# TABLE STRUCTURE FOR: ti_customers_activity
#

DROP TABLE IF EXISTS `ti_customers_activity`;

CREATE TABLE `ti_customers_activity` (
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
  `page_views` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

INSERT INTO `ti_customers_activity` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `page_views`) VALUES ('31', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-05-18 14:05:40', '0', '6910');


#
# TABLE STRUCTURE FOR: ti_extensions
#

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('11', 'module', 'account_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"11\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Account');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('12', 'module', 'local_module', 'a:1:{s:7:\"layouts\";N;}', '1', '1', 'Local');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('13', 'module', 'categories_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Categories');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('14', 'module', 'cart_module', 'a:3:{s:16:\"show_cart_images\";s:1:\"0\";s:13:\"cart_images_h\";s:0:\"\";s:13:\"cart_images_w\";s:0:\"\";}', '1', '1', 'Cart');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('15', 'module', 'reservation_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"16\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Reservation');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('16', 'module', 'slideshow', 'a:6:{s:11:\"dimension_h\";s:3:\"420\";s:11:\"dimension_w\";s:4:\"1170\";s:6:\"effect\";s:4:\"fade\";s:5:\"speed\";s:3:\"500\";s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"15\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}s:6:\"slides\";a:3:{i:0;a:3:{s:4:\"name\";s:9:\"slide.png\";s:9:\"image_src\";s:14:\"data/slide.jpg\";s:7:\"caption\";s:0:\"\";}i:1;a:3:{s:4:\"name\";s:10:\"slide1.png\";s:9:\"image_src\";s:15:\"data/slide1.jpg\";s:7:\"caption\";s:0:\"\";}i:2;a:3:{s:4:\"name\";s:10:\"slide2.png\";s:9:\"image_src\";s:15:\"data/slide2.jpg\";s:7:\"caption\";s:0:\"\";}}}', '1', '1', 'Slideshow');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('18', 'payment', 'cod', 'a:5:{s:4:\"name\";N;s:11:\"order_total\";s:7:\"1000.00\";s:12:\"order_status\";s:2:\"11\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}', '1', '1', 'Cash On Delivery');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('20', 'module', 'pages_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"17\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Pages');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('21', 'payment', 'paypal_express', 'a:11:{s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:8:\"api_mode\";s:7:\"sandbox\";s:8:\"api_user\";s:39:\"samadepoyigi-facilitator_api1.gmail.com\";s:8:\"api_pass\";s:10:\"1381080165\";s:13:\"api_signature\";s:56:\"AFcWxV21C7fd0v3bYYYRCpSSRl31AYzY6RzJVWuquyjw.VYZbV7LatXv\";s:10:\"api_action\";s:4:\"sale\";s:10:\"return_uri\";s:24:\"paypal_express/authorize\";s:10:\"cancel_uri\";s:21:\"paypal_express/cancel\";s:11:\"order_total\";s:4:\"0.00\";s:12:\"order_status\";s:2:\"11\";}', '1', '1', 'PayPal Express');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('23', 'theme', 'tastyigniter-orange', 'a:13:{s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"25\";s:19:\"logo_padding_bottom\";s:2:\"25\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#fdeae2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#333333\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#ffffff\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#428bca\";s:5:\"hover\";s:7:\"#2a6496\";}s:6:\"button\";a:4:{s:7:\"default\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:6:\"border\";s:7:\"#cccccc\";}s:7:\"primary\";a:2:{s:10:\"background\";s:7:\"#428bca\";s:6:\"border\";s:7:\"#357ebd\";}s:7:\"success\";a:2:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";}s:6:\"danger\";a:2:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";}}s:10:\"custom_css\";s:0:\"\";}', '1', '1', 'TastyIgniter Orange');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('24', 'theme', 'tastyigniter-blue', '', '1', '0', 'TastyIgniter Blue');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('25', 'module', 'banners_module', 'a:1:{s:7:\"banners\";a:1:{i:1;a:3:{s:9:\"banner_id\";s:1:\"1\";s:5:\"width\";s:0:\"\";s:6:\"height\";s:0:\"\";}}}', '1', '1', 'Banners');


#
# TABLE STRUCTURE FOR: ti_languages
#

DROP TABLE IF EXISTS `ti_languages`;

CREATE TABLE `ti_languages` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(32) NOT NULL,
  `directory` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `ti_languages` (`language_id`, `code`, `name`, `image`, `directory`, `status`) VALUES ('11', 'en', 'English', 'data/flags/gb.png', 'english', '1');


#
# TABLE STRUCTURE FOR: ti_layout_modules
#

DROP TABLE IF EXISTS `ti_layout_modules`;

CREATE TABLE `ti_layout_modules` (
  `layout_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `module_code` varchar(128) NOT NULL DEFAULT '',
  `position` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`layout_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('9', '13', 'local_module', 'top', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('10', '13', 'cart_module', 'right', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('11', '15', 'slideshow', 'top', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('14', '18', 'local_module', 'top', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('15', '16', 'reservation_module', 'left', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('19', '17', 'pages_module', 'right', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('20', '12', 'local_module', 'top', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('21', '12', 'categories_module', 'left', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('22', '12', 'cart_module', 'right', '2', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('23', '12', 'banners_module', 'left', '2', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('24', '11', 'account_module', 'left', '1', '1');


#
# TABLE STRUCTURE FOR: ti_layout_routes
#

DROP TABLE IF EXISTS `ti_layout_routes`;

CREATE TABLE `ti_layout_routes` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `uri_route` varchar(128) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('50', '13', 'checkout');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('51', '15', 'home');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('55', '18', 'local');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('56', '18', 'local/reviews');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('57', '16', 'reserve');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('59', '17', 'pages/(:num)');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('60', '17', 'pages');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('61', '12', 'menus');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('62', '11', 'account/inbox');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('63', '11', 'account/orders');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('64', '11', 'account/address');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('65', '11', 'account/details');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('66', '11', 'account');


#
# TABLE STRUCTURE FOR: ti_layouts
#

DROP TABLE IF EXISTS `ti_layouts`;

CREATE TABLE `ti_layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('11', 'Account');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('12', 'Menus');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('13', 'Checkout');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('15', 'Home');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('16', 'Reservation');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('17', 'Page');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('18', 'Local');


#
# TABLE STRUCTURE FOR: ti_location_tables
#

DROP TABLE IF EXISTS `ti_location_tables`;

CREATE TABLE `ti_location_tables` (
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`table_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '2');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '6');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '7');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '8');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '9');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '10');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '11');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '12');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('116', '2');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('116', '7');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('116', '9');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('116', '10');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('117', '2');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('117', '7');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('117', '8');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('117', '12');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('122', '13');


#
# TABLE STRUCTURE FOR: ti_locations
#

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
  `reservation_interval` int(11) NOT NULL,
  `reservation_turn` int(11) NOT NULL,
  `location_status` tinyint(1) NOT NULL,
  `collection_time` int(11) NOT NULL,
  `options` text NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_interval`, `reservation_turn`, `location_status`, `collection_time`, `options`) VALUES ('115', 'Harrow', 'harrow@tastyigniter.com', '', '14 Lime Close', '', 'Greater London', '', 'HA3 7JG', '222', '02088279101', '51.600262', '-0.325915', '0', '1', '1', '45', '0', '45', '0', '1', '0', 'a:3:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:5:\"daily\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:7:\"9:00 AM\";s:5:\"close\";s:7:\"5:00 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}s:8:\"payments\";N;s:14:\"delivery_areas\";a:1:{i:1;a:7:{s:5:\"shape\";s:35:\"[{\"shape\":\"ix}yHht}@hf@??h~@if@?\"}]\";s:8:\"vertices\";s:211:\"[{\"lat\":51.60340610349442,\"lng\":-0.32085320675355433},{\"lat\":51.59711789650558,\"lng\":-0.32085320675355433},{\"lat\":51.59711789650558,\"lng\":-0.3309767932464638},{\"lat\":51.60340610349442,\"lng\":-0.3309767932464638}]\";s:6:\"circle\";s:86:\"[{\"center\":{\"lat\":51.600262,\"lng\":-0.32591500000000906}},{\"radius\":2114.266146704626}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}}}');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_interval`, `reservation_turn`, `location_status`, `collection_time`, `options`) VALUES ('116', 'Earling', 'ealing@tastyIgniter.com', 'Donec a velit est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce fringilla vestibulum faucibus. Mauris vestibulum eu erat sit amet bibendum. Suspendisse ornare tellus et varius rutrum.', '8 Brookfield Avenue', '', 'Greater London', '', 'W5 1LA', '222', '02088279102', '51.526852', '-0.301442', '5', '0', '0', '0', '0', '0', '0', '1', '0', 'a:3:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:3:{s:4:\"open\";s:5:\"09:00\";s:5:\"close\";s:5:\"17:00\";s:6:\"status\";s:1:\"0\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:5:\"00:00\";s:5:\"close\";s:5:\"23:59\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:5:\"00:00\";s:5:\"close\";s:5:\"23:59\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:5:\"00:00\";s:5:\"close\";s:5:\"23:59\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:5:\"00:00\";s:5:\"close\";s:5:\"23:59\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:5:\"00:00\";s:5:\"close\";s:5:\"23:59\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:5:\"00:00\";s:5:\"close\";s:5:\"23:59\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:5:\"00:00\";s:5:\"close\";s:5:\"23:59\";s:6:\"status\";s:1:\"0\";}}}s:8:\"payments\";a:2:{i:0;s:3:\"cod\";i:1;s:14:\"paypal_express\";}s:14:\"delivery_areas\";b:0;}');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_interval`, `reservation_turn`, `location_status`, `collection_time`, `options`) VALUES ('117', 'Hackney', 'hackney@tastyigniter.com', 'Nunc vestibulum quis tortor placerat fermentum. Vivamus et justo purus. Fusce rutrum erat eu mattis consectetur. Quisque felis lorem, imperdiet sed urna et, volutpat bibendum lacus. Phasellus euismod sem quis est semper, vel porttitor magna aliquam. Nullam sed erat sed erat semper mollis ac id dolor. Sed quis felis ipsum. Aliquam dolor est, iaculis eget libero sit amet, hendrerit cursus sapien.', '44 Darnley Road', '', 'Greater London', '', 'E9 6QH', '222', '02088279103', '51.544060', '-0.053999', '0', '1', '1', '45', '0', '45', '0', '1', '0', 'a:3:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:5:\"daily\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:7:\"9:00 AM\";s:5:\"close\";s:8:\"11:45 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:7:\"6:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}s:8:\"payments\";N;s:14:\"delivery_areas\";a:2:{i:1;a:7:{s:5:\"shape\";s:40:\"[{\"shape\":\"_yryHzpHff@??d~@}OflAiUglA\"}]\";s:8:\"vertices\";s:260:\"[{\"lat\":51.547200000000004,\"lng\":-0.048940000000000004},{\"lat\":51.54092000000001,\"lng\":-0.048940000000000004},{\"lat\":51.54092000000001,\"lng\":-0.059050000000000005},{\"lat\":51.54363000000001,\"lng\":-0.07141},{\"lat\":51.547200000000004,\"lng\":-0.059050000000000005}]\";s:6:\"circle\";s:85:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":4207.897854749147}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}i:2;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"ulsyHhqGrmA??j}BsmA?\"}]\";s:8:\"vertices\";s:155:\"[{\"lat\":51.55035,\"lng\":-0.043890000000000005},{\"lat\":51.53777,\"lng\":-0.043890000000000005},{\"lat\":51.53777,\"lng\":-0.06411},{\"lat\":51.55035,\"lng\":-0.06411}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":1000}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"London\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:4:\"1000\";}}}');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_interval`, `reservation_turn`, `location_status`, `collection_time`, `options`) VALUES ('118', 'Nigeria', 'lagos@tastyigniter.com', '', '5 Salamotu', '', 'Lagos', '', '23401', '222', '3829029289', '6.518536', '3.332988', '0', '1', '0', '0', '0', '0', '0', '1', '0', 'a:3:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}s:8:\"payments\";N;s:14:\"delivery_areas\";a:1:{i:1;a:7:{s:5:\"shape\";s:35:\"[{\"shape\":\"owxf@}qjShf@??pf@if@?\"}]\";s:8:\"vertices\";s:205:\"[{\"lat\":6.521680000000001,\"lng\":3.3361500000000004},{\"lat\":6.515390000000001,\"lng\":3.3361500000000004},{\"lat\":6.515390000000001,\"lng\":3.3298200000000002},{\"lat\":6.521680000000001,\"lng\":3.3298200000000002}]\";s:6:\"circle\";s:69:\"[{\"center\":{\"lat\":6.518536,\"lng\":3.3329880000000003}},{\"radius\":500}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}}}');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_interval`, `reservation_turn`, `location_status`, `collection_time`, `options`) VALUES ('120', 'Lewisham', 'lewisham@tastyigniter.com', '', '400 Lewisham Way', '', 'London', '', 'SE10 9HF', '222', '4883930902', '51.490368', '0.017939', '0', '1', '1', '0', '0', '0', '0', '1', '0', 'a:3:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:7:\"8:00 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}s:8:\"payments\";a:1:{i:0;s:3:\"cod\";}s:14:\"delivery_areas\";a:1:{i:1;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"mihyHunChf@??b~@if@?\"}]\";s:8:\"vertices\";s:187:\"[{\"lat\":51.49351000000001,\"lng\":0.022990000000000003},{\"lat\":51.48722000000001,\"lng\":0.022990000000000003},{\"lat\":51.48722000000001,\"lng\":0.01289},{\"lat\":51.49351000000001,\"lng\":0.01289}]\";s:6:\"circle\";s:92:\"[{\"center\":{\"lat\":51.468665305417,\"lng\":0.013817910302350356}},{\"radius\":3845.274029664779}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}}}');


#
# TABLE STRUCTURE FOR: ti_mail_templates
#

DROP TABLE IF EXISTS `ti_mail_templates`;

CREATE TABLE `ti_mail_templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `ti_mail_templates` (`template_id`, `name`, `language_id`, `date_added`, `date_updated`, `status`) VALUES ('11', 'Default', '1', '2014-04-16 01:49:52', '2015-05-07 12:36:37', '1');


#
# TABLE STRUCTURE FOR: ti_mail_templates_data
#

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('11', '11', 'registration', 'Account Created at {site_name}', '<p>Hello {first_name} {last_name},</p><p>Your account has now been created and you can log in using your email address and password by visiting our website or at the following URL: <a href=\"{login_link}\">Click Here</a></p><p>Thank you for using.<br /> {signature}</p>', '2014-04-16 00:56:00', '2014-05-15 15:24:56');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('12', '11', 'password_reset', 'Password Reset at {site_name}', '<p>Dear {first_name} {last_name},</p><p>Your password has been reset successfull! Please <a href=\"{login_link}\" target=\"_blank\">login</a> using your new password: {created_password}.</p><p>Thank you for using.<br /> {signature}</p>', '2014-04-16 00:56:00', '2014-05-15 15:46:30');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('13', '11', 'order', 'Order Successful - {order_number}', '<div><div class=\"text-align\"><p>Hello {first_name} {last_name},</p><p>Your order has been received and will be with you shortly.<br /><a href=\"{order_link}\">Click here</a> to view your order progress.<br /> Thanks for shopping with us online! &nbsp;</p><h3>Order Details</h3><p>Your order number is {order_number}<br /> This is a {order_type} order.<br /><strong>Order Date:</strong> {order_date}<br /><strong>Delivery Time</strong> {order_time}</p><h3>What you\'ve ordered:</h3></div></div><table border=\"1\" cellspacing=\"1\" cellpadding=\"1\"><tbody><tr><td><div><div class=\"text-align\">{menus}</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td></tr><tr><td><div><div class=\"text-align\">{quantity}x</div></div></td><td><div><div class=\"text-align\"><p>{name}</p><p>{options}</p></div></div></td><td><div><div class=\"text-align\">{price}</div></div></td><td><div><div class=\"text-align\">{subtotal}</div></div></td></tr><tr><td><div><div class=\"text-align\">{/menus}</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td></tr></tbody></table><div><div class=\"text-align\"><p>&nbsp;</p><p>{order_totals}<br /><strong>{title}:</strong> {value}<br /> {/order_totals}</p><p>Your delivery address {order_address}</p><p>Your local restaurant {location_name}</p><p>We hope to see you again soon.</p><p>{signature}</p></div></div>', '2014-04-16 00:56:00', '2014-07-20 14:29:55');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('14', '11', 'reservation', 'Table Reserved - {reserve_number}', '<p>Hello {first_name} {last_name},<br /><br /> Your reservation at {location_name} has been booked for {reserve_guest} person(s) on {reserve_date} at {reserve_time}.</p><p>Thanks for reserving with us online!<br /><br /> We hope to see you again soon.<br /> {signature}</p>', '2014-04-16 00:56:00', '2014-07-22 20:13:48');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('15', '11', 'contact', 'Thanks for contacting us', '<h3><strong>Dear {full_name},</strong></h3><div><div>Topic: {contact_topic}.</div><div>Telephone: {contact_telephone}.</div></div><p>{contact_message}</p><p>Your {site_name} Team,</p><div>{signature}</div>', '2014-04-16 00:56:00', '2014-05-15 18:00:57');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('16', '11', 'internal', 'Subject here', '<p>Body here</p>', '2014-04-16 00:56:00', '2014-04-16 00:59:00');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('17', '11', 'order_alert', 'Subject here', '<p>Body here</p>', '2014-04-16 00:56:00', '2014-04-16 00:59:00');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('18', '11', 'reservation_alert', 'Subject here', '<p>Body here</p>', '2014-04-16 00:56:00', '2014-04-16 00:59:00');


#
# TABLE STRUCTURE FOR: ti_menu_option_values
#

DROP TABLE IF EXISTS `ti_menu_option_values`;

CREATE TABLE `ti_menu_option_values` (
  `menu_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `new_price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `substract_stock` tinyint(4) NOT NULL,
  PRIMARY KEY (`menu_option_value_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('52', '25', '84', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('53', '25', '84', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('54', '25', '84', '22', '11', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('55', '26', '79', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('56', '26', '79', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('57', '26', '79', '22', '10', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('58', '26', '79', '22', '11', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('59', '26', '79', '22', '12', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('60', '27', '79', '24', '13', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('61', '27', '79', '24', '14', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('62', '28', '78', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('63', '28', '78', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('64', '28', '78', '22', '10', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('65', '28', '78', '22', '11', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('66', '28', '78', '22', '12', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('67', '22', '85', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('68', '22', '85', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('69', '22', '85', '22', '10', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('70', '24', '85', '24', '13', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('71', '24', '85', '24', '14', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('72', '23', '81', '23', '7', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('73', '23', '81', '23', '6', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES ('74', '23', '81', '23', '15', '0.00', '0', '0');


#
# TABLE STRUCTURE FOR: ti_menu_options
#

DROP TABLE IF EXISTS `ti_menu_options`;

CREATE TABLE `ti_menu_options` (
  `menu_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `required` tinyint(4) NOT NULL,
  `option_values` text NOT NULL,
  PRIMARY KEY (`menu_option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('22', '22', '85', '1', 'a:3:{i:3;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:4;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:5;a:3:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}}');
INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('23', '23', '81', '0', 'a:3:{i:1;a:5:{s:15:\"option_value_id\";s:1:\"7\";s:5:\"price\";s:0:\"\";s:8:\"quantity\";s:1:\"0\";s:15:\"substract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"72\";}i:2;a:5:{s:15:\"option_value_id\";s:1:\"6\";s:5:\"price\";s:0:\"\";s:8:\"quantity\";s:1:\"0\";s:15:\"substract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"73\";}i:3;a:5:{s:15:\"option_value_id\";s:2:\"15\";s:5:\"price\";s:0:\"\";s:8:\"quantity\";s:1:\"0\";s:15:\"substract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"74\";}}');
INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('24', '24', '85', '1', 'a:2:{i:1;a:3:{s:15:\"option_value_id\";s:2:\"13\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:2;a:3:{s:15:\"option_value_id\";s:2:\"14\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}}');
INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('25', '22', '84', '0', 'a:3:{i:1;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"52\";}i:2;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"53\";}i:3;a:3:{s:15:\"option_value_id\";s:2:\"11\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"54\";}}');
INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('26', '22', '79', '0', 'a:5:{i:1;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"55\";}i:2;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"56\";}i:3;a:3:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"57\";}i:4;a:3:{s:15:\"option_value_id\";s:2:\"11\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"58\";}i:5;a:3:{s:15:\"option_value_id\";s:2:\"12\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"59\";}}');
INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('27', '24', '79', '1', 'a:2:{i:6;a:3:{s:15:\"option_value_id\";s:2:\"13\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"60\";}i:7;a:3:{s:15:\"option_value_id\";s:2:\"14\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"61\";}}');
INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('28', '22', '78', '1', 'a:5:{i:1;a:3:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"62\";}i:2;a:3:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"63\";}i:3;a:3:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"64\";}i:4;a:3:{s:15:\"option_value_id\";s:2:\"11\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"65\";}i:5;a:3:{s:15:\"option_value_id\";s:2:\"12\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:2:\"66\";}}');


#
# TABLE STRUCTURE FOR: ti_menus
#

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
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('76', 'PUFF-PUFF', 'Traditional Nigerian donut ball, rolled in sugar', '4.99', 'data/puff_puff.jpg', '24', '844', '3', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('77', 'SCOTCH EGG', 'Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.', '2.00', 'data/scotch_egg.jpg', '15', '0', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('78', 'ATA RICE', 'Small pieces of beef, goat, stipe, and tendon sautéed in crushed green Jamaican pepper.', '12.00', 'data/Seared_Ahi_Spinach_Salad.jpg', '16', '1000', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('79', 'RICE AND DODO', '(plantains) w/chicken, fish, beef or goat', '11.99', 'data/rice_and_dodo.jpg', '16', '302', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('80', 'Special Shrimp Deluxe', 'Fresh shrimp sautéed in blended mixture of tomatoes, onion, peppers over choice of rice', '12.99', 'data/deluxe_bbq_shrimp-1.jpg', '18', '263', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('81', 'Whole catfish with rice and vegetables', 'Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste', '13.99', 'data/FriedWholeCatfishPlate_lg.jpg', '24', '0', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('82', 'African Salad', 'With baked beans, egg, tuna, onion, tomatoes , green peas and carrot with your choice of dressing.', '8.99', '', '17', '500', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('83', 'Seafood Salad', 'With shrimp, egg and imitation crab meat', '5.99', 'data/seafoods_salad.JPG', '17', '490', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('84', 'EBA', 'Grated cassava', '11.99', 'data/eba.jpg', '16', '107', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('85', 'AMALA', 'Yam flour', '11.99', 'data/DSCF3711.JPG', '19', '397', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('86', 'YAM PORRIDGE', 'in tomatoes sauce', '9.99', 'data/yam_porridge.jpg', '20', '457', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('87', 'Boiled Plantain', 'w/spinach soup', '9.99', 'data/pesto.jpg', '19', '422', '1', '1', '1');


#
# TABLE STRUCTURE FOR: ti_menus_specials
#

DROP TABLE IF EXISTS `ti_menus_specials`;

CREATE TABLE `ti_menus_specials` (
  `special_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `special_price` decimal(15,2) NOT NULL,
  `special_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`special_id`,`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('51', '81', '2014-04-10', '2014-04-30', '6.99', '1');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('52', '76', '2014-04-23', '2014-07-31', '10.00', '1');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('53', '86', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('54', '87', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('57', '84', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('58', '77', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('59', '78', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('60', '79', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('61', '85', '0000-00-00', '0000-00-00', '0.00', '0');


#
# TABLE STRUCTURE FOR: ti_menus_to_options
#

DROP TABLE IF EXISTS `ti_menus_to_options`;

CREATE TABLE `ti_menus_to_options` (
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: ti_message_recipients
#

DROP TABLE IF EXISTS `ti_message_recipients`;

CREATE TABLE `ti_message_recipients` (
  `message_recipient_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `staff_email` varchar(96) NOT NULL,
  `customer_email` varchar(96) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`message_recipient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `staff_id`, `customer_id`, `staff_email`, `customer_email`, `state`, `status`) VALUES ('1', '2', '11', '0', '', '', '0', '1');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `staff_id`, `customer_id`, `staff_email`, `customer_email`, `state`, `status`) VALUES ('2', '3', '0', '39', '', '', '0', '1');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `staff_id`, `customer_id`, `staff_email`, `customer_email`, `state`, `status`) VALUES ('3', '4', '11', '0', '', '', '1', '1');


#
# TABLE STRUCTURE FOR: ti_messages
#

DROP TABLE IF EXISTS `ti_messages`;

CREATE TABLE `ti_messages` (
  `message_id` int(15) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `staff_id_from` int(11) NOT NULL,
  `staff_id_to` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `send_type` varchar(32) NOT NULL,
  `recipient` varchar(32) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `ti_messages` (`message_id`, `location_id`, `staff_id_from`, `staff_id_to`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('1', '0', '11', '0', '2015-04-01 19:28:47', 'account', 'all_newsletters', 'Aliquam erat volutpat.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras porta augue eget efficitur viverra. In scelerisque nec orci ac scelerisque. Sed fermentum luctus arcu, in ultrices justo faucibus blandit. Nam semper, felis ut aliquet blandit, tortor nisi luctus orci, at eleifend eros augue et ante. Maecenas vel dolor id nisi finibus iaculis. Vivamus eros turpis, sodales pretium dictum ac, eleifend nec tortor. Aenean fringilla odio vel venenatis volutpat. Nulla luctus, mauris sit amet aliquet elementum, enim dolor euismod felis, scelerisque mattis sem tortor in ante. Vivamus elit magna, eleifend id libero nec, convallis facilisis dui. Cras massa nunc, placerat sit amet sodales in, venenatis vehicula quam. Etiam ornare et lacus id venenatis.</p>\r\n<p>Aenean tempor nisi a eros pellentesque, et vehicula ex scelerisque. In ut odio sit amet purus porta finibus at ultricies nulla. Mauris accumsan nisl nec consectetur congue. Sed nec velit vitae sapien bibendum lobortis. Morbi aliquam malesuada risus eu interdum. Maecenas condimentum lacus sed egestas sodales. Vestibulum sodales eros velit, non egestas velit dignissim sit amet. Integer commodo massa et turpis facilisis, et ultricies nisl consectetur. Nullam hendrerit id dolor eu vehicula. Curabitur posuere venenatis neque vel posuere. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur condimentum urna ut cursus aliquam. Pellentesque sit amet porttitor metus. Quisque eu nisl placerat, interdum tortor sodales, semper sapien.</p>\r\n<p>Nulla gravida tortor hendrerit, tempus mauris vel, mollis ligula. Suspendisse non risus vitae leo pretium venenatis eget sed tellus. Morbi ac dapibus dui. Donec non eros aliquam, euismod turpis in, venenatis ante. Donec id ligula orci. Duis vehicula convallis elit, ac lacinia ipsum pretium sed. Aliquam ac odio ac nisi scelerisque semper non ac diam.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `location_id`, `staff_id_from`, `staff_id_to`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('2', '0', '11', '0', '2015-04-01 19:32:14', 'account', 'all_staffs', 'Vivamus quis turpis pharetra', '<p><span style=\"color: #ff0000;\"> Nulla gravida tortor hendrerit, tempus mauris vel, mollis ligula. Suspendisse non risus vitae leo pretium venenatis eget sed tellus. Morbi ac dapibus dui. Donec non eros aliquam, euismod turpis in, venenatis ante. Donec id ligula orci. Duis vehicula convallis elit, ac lacinia ipsum pretium sed. Aliquam ac odio ac nisi scelerisque semper non ac diam. </span></p>\r\n<p><span style=\"color: #008000;\"> Quisque et purus sed eros mattis varius nec ut magna. Proin sed lacinia ex, vel feugiat enim. Sed augue arcu, lobortis vitae lorem quis, aliquam bibendum arcu. Morbi a mauris ultrices ligula volutpat pharetra. Proin sed elit eget risus aliquet malesuada. Cras odio neque, venenatis et ex vitae, malesuada pharetra sem. Curabitur rhoncus consequat tincidunt. Proin feugiat mollis tortor, in tincidunt quam consectetur vitae. Fusce luctus varius nulla eget gravida. Mauris consectetur eleifend elit sed finibus. Maecenas porttitor dapibus leo. Cras tempus elit non lorem lobortis, eget aliquam justo malesuada. Mauris faucibus, elit rutrum fermentum venenatis, nibh velit tempus felis, ut molestie lacus erat vel ligula. Praesent finibus ante eu lacus volutpat, eu rhoncus sem convallis. </span></p>\r\n<p><span style=\"color: #0000ff;\"> Proin a est felis. Nullam condimentum ultrices augue sagittis fringilla. Quisque sed porttitor magna, sit amet lobortis magna. Sed pharetra cursus ante, et vestibulum mi ultricies ac. Donec sollicitudin magna sit amet orci sagittis, id iaculis mi blandit. Proin at condimentum erat, vitae suscipit enim. Vestibulum massa lorem, condimentum id congue blandit, condimentum sit amet dui. Nam et augue feugiat, bibendum ipsum in, ullamcorper velit. Donec dolor lorem, tincidunt eu fringilla non, suscipit eget nulla. Suspendisse potenti. Nunc sagittis quam nec metus pulvinar, id pulvinar turpis finibus. </span></p>', '1');
INSERT INTO `ti_messages` (`message_id`, `location_id`, `staff_id_from`, `staff_id_to`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('3', '0', '11', '0', '2015-04-02 00:10:47', 'account', 'all_customers', 'Pellentesque habitant morbi tristique', '<p>Aliquam finibus sed erat sed semper. Phasellus tempor, turpis at lobortis laoreet, lectus est interdum sapien, vitae egestas ligula sem accumsan ipsum. Vestibulum blandit in lacus euismod eleifend. Mauris accumsan, mi nec egestas rutrum, lorem dolor finibus est, vitae fermentum justo orci id tortor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut dictum nisl sed ultricies efficitur. Curabitur in augue eu quam auctor mattis eget vitae purus.</p>\r\n<p>Nunc consectetur, metus sed luctus porta, nisl ante vulputate dui, nec vestibulum ligula nibh a risus. Quisque quis ex vel purus laoreet sagittis. Nunc tincidunt turpis non neque cursus sollicitudin. Vestibulum nec leo lacus. Suspendisse in leo sapien. Nulla odio diam, tincidunt non pharetra ut, fringilla non leo. Sed laoreet venenatis dapibus. Proin nulla ipsum, pretium sit amet cursus id, rhoncus eu massa. Suspendisse potenti. Vivamus ex ex, malesuada dictum massa non, dapibus volutpat diam. Etiam tristique quam at felis suscipit tincidunt in vitae risus. Vivamus id erat id nisl ultricies rhoncus. Duis laoreet nibh vitae ex tempus posuere. Suspendisse vestibulum dui euismod nibh vestibulum porta.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `location_id`, `staff_id_from`, `staff_id_to`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('4', '0', '11', '0', '2015-04-07 10:03:14', 'account', 'all_staffs', 'Pellentesque egestas risus eget laoreet consectetur.', '<p>Praesent in semper libero. Nunc vitae interdum arcu. Proin eget orci metus. Pellentesque at erat dapibus, venenatis eros eget, ornare tortor. Maecenas accumsan dapibus gravida. Morbi facilisis erat nunc, eu pretium odio congue eu. Aliquam vitae lacinia massa, eu hendrerit augue. Nulla sit amet dui ac sem sollicitudin pharetra. Mauris malesuada odio ac facilisis molestie. Donec eleifend efficitur felis ac facilisis. Sed at purus dolor. Sed porta eget massa ut tincidunt. Quisque laoreet fermentum porttitor. Phasellus neque orci, vestibulum nec quam sit amet, placerat rutrum magna. Curabitur nec nisi posuere, porta nunc a, commodo felis.</p>\r\n<p>Pellentesque egestas risus eget laoreet consectetur. Cras malesuada ex lobortis, condimentum quam id, rhoncus ligula. Morbi varius lorem in lacus facilisis, vehicula fringilla odio vulputate. Etiam vehicula sollicitudin fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ultrices arcu blandit libero fringilla feugiat. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed egestas leo eu nisl semper fermentum. Mauris lobortis sodales dolor eu pharetra. Sed tristique, diam id aliquet congue, neque nunc faucibus quam, sed semper leo lectus ac urna.</p>\r\n<p>Aliquam tincidunt fermentum ipsum ut bibendum. Ut congue pretium erat, et ultrices odio fringilla sed. Praesent fermentum id leo vitae tempus. Ut eu placerat eros, non cursus ex. Suspendisse elit nisi, convallis vel efficitur sed, condimentum eu elit. Vivamus suscipit, nisl vitae hendrerit tempus, erat tortor porttitor urna, ut scelerisque dui quam quis justo. Nulla consectetur molestie pellentesque. Sed eu sollicitudin felis. Cras pulvinar vel libero sit amet varius. Vestibulum in cursus neque, ut pharetra nisi. Vivamus molestie, ex ac elementum lobortis, augue elit congue libero, non egestas massa arcu sit amet metus.</p>', '1');


#
# TABLE STRUCTURE FOR: ti_migrations
#

DROP TABLE IF EXISTS `ti_migrations`;

CREATE TABLE `ti_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ti_migrations` (`version`) VALUES ('4');


#
# TABLE STRUCTURE FOR: ti_notifications
#

DROP TABLE IF EXISTS `ti_notifications`;

CREATE TABLE `ti_notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `object_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('1', 'updated', 'location', '', '117', '11', '0', '0', '2015-03-29 17:05:05');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('2', 'updated', 'location', '', '117', '11', '0', '0', '2015-03-29 17:06:09');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('3', 'updated', 'location', '', '115', '11', '0', '0', '2015-03-29 17:07:06');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('4', 'updated', 'location', '', '115', '11', '0', '0', '2015-03-29 17:07:30');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('5', 'changed', 'reservation', '', '2446', '11', '17', '0', '2015-03-29 19:59:21');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('6', 'assigned', 'reservation', '', '2446', '11', '11', '0', '2015-03-29 19:59:21');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('7', 'updated', 'customer', '', '39', '11', '0', '0', '2015-03-29 20:32:35');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('8', 'changed', 'reservation', '', '2446', '11', '18', '0', '2015-04-01 15:41:22');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('9', 'changed', 'reservation', '', '2445', '11', '18', '0', '2015-04-01 15:41:40');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('10', 'changed', 'order', '', '2650', '11', '13', '0', '2015-04-05 23:19:43');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('11', 'assigned', 'order', '', '2650', '11', '11', '0', '2015-04-05 23:19:43');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('12', 'approved', 'review', '', '103', '11', '39', '0', '2015-04-07 00:36:12');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('13', 'added', 'review', '', '104', '11', '0', '0', '2015-04-07 00:43:54');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('14', 'approved', 'review', '', '100', '11', '39', '0', '2015-04-07 00:44:35');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('15', 'changed', 'order', '', '2650', '11', '19', '0', '2015-04-08 23:17:46');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('16', 'added', 'location', '', '118', '11', '0', '0', '2015-04-09 00:56:06');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('17', 'updated', 'location', '', '118', '11', '0', '0', '2015-04-09 01:01:56');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('18', 'updated', 'location', '', '118', '11', '0', '0', '2015-04-09 01:04:13');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('19', 'updated', 'location', '', '118', '11', '0', '0', '2015-04-09 01:04:53');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('20', 'updated', 'location', '', '118', '11', '0', '0', '2015-04-09 01:04:59');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('21', 'updated', 'location', '', '118', '11', '0', '0', '2015-04-09 01:14:11');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('22', 'updated', 'location', '', '118', '11', '0', '0', '2015-04-12 21:02:01');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('23', 'updated', 'extension', '', '15', '11', '0', '0', '2015-04-12 23:16:41');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('24', 'added', 'staff', '', '12', '11', '0', '0', '2015-04-22 10:16:59');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('25', 'updated', 'staff', '', '12', '11', '0', '0', '2015-04-22 10:17:45');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('26', 'updated', 'table', '', '6', '11', '0', '0', '2015-04-22 10:18:34');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('27', 'updated', 'extension', '', '14', '11', '0', '0', '2015-04-30 16:30:41');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('28', 'updated', 'customer', '', '39', '0', '0', '0', '2015-04-30 22:12:29');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('29', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-01 01:17:49');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('30', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-01 01:18:23');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('31', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-01 01:18:35');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('32', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-01 01:22:27');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('33', 'updated', 'customer', '', '39', '0', '0', '0', '2015-05-01 02:57:42');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('34', 'updated', 'customer', '', '39', '39', '0', '0', '2015-05-01 02:59:39');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('35', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-01 11:48:19');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('36', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-02 01:32:49');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('37', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-02 01:33:26');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('38', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-02 01:33:39');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('39', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-02 01:47:23');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('40', 'uninstalled', 'extension', '', '11', '0', '0', '0', '2015-05-02 21:00:05');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('41', 'installed', 'extension', '', '11', '0', '0', '0', '2015-05-02 21:10:02');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('42', 'uninstalled', 'extension', '', '11', '0', '0', '0', '2015-05-02 21:13:45');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('43', 'installed', 'extension', '', '11', '0', '0', '0', '2015-05-02 21:14:28');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('44', 'installed', 'extension', '', '18', '0', '0', '0', '2015-05-02 21:25:11');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('45', 'uninstalled', 'extension', '', '18', '0', '0', '0', '2015-05-02 21:31:54');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('46', 'installed', 'extension', '', '18', '0', '0', '0', '2015-05-02 21:37:06');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('47', 'installed', 'extension', '', '25', '0', '0', '0', '2015-05-03 16:26:00');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('48', 'uninstalled', 'extension', '', '25', '0', '0', '0', '2015-05-03 16:27:12');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('49', 'uninstalled', 'extension', '', '25', '0', '0', '0', '2015-05-03 16:57:17');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('50', 'uninstalled', 'extension', '', '25', '0', '0', '0', '2015-05-03 16:57:21');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('51', 'uninstalled', 'extension', '', '25', '0', '0', '0', '2015-05-03 16:59:12');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('52', 'uninstalled', 'extension', '', '25', '0', '0', '0', '2015-05-03 16:59:45');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('53', 'uninstalled', 'extension', '', '25', '0', '0', '0', '2015-05-03 16:59:54');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('54', 'uninstalled', 'extension', '', '25', '0', '0', '0', '2015-05-03 17:00:19');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('55', 'removed', 'extension', '', '25', '0', '0', '0', '2015-05-03 17:08:20');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('56', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-03 22:29:57');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('57', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-03 23:57:10');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('58', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-03 23:57:52');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('59', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-04 00:35:27');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('60', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-04 00:39:54');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('61', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-04 00:50:33');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('62', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-04 00:53:29');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('63', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-04 00:56:21');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('64', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-04 01:01:23');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('65', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 01:34:08');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('66', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-04 01:36:27');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('67', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 01:36:38');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('68', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:15:56');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('69', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:18:02');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('70', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:25:58');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('71', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:28:38');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('72', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:30:33');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('73', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:40:56');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('74', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:44:44');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('75', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:44:57');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('76', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-04 09:45:17');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('77', 'updated', 'extension', '', '14', '0', '0', '0', '2015-05-04 13:52:13');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('78', 'updated', 'extension', '', '22', '0', '0', '0', '2015-05-04 13:52:27');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('79', 'updated', 'extension', '', '22', '0', '0', '0', '2015-05-04 13:52:56');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('80', 'updated', 'extension', '', '12', '0', '0', '0', '2015-05-06 01:07:33');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('81', 'updated', 'extension', '', '18', '0', '0', '0', '2015-05-06 01:28:28');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('82', 'updated', 'extension', '', '14', '0', '0', '0', '2015-05-06 19:50:10');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('83', 'updated', 'extension', '', '11', '0', '0', '0', '2015-05-06 19:53:33');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('84', 'updated', 'extension', '', '11', '0', '0', '0', '2015-05-06 19:53:58');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('85', 'updated', 'extension', '', '22', '0', '0', '0', '2015-05-06 19:54:04');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('86', 'updated', 'extension', '', '22', '0', '0', '0', '2015-05-06 19:54:06');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('87', 'updated', 'extension', '', '25', '0', '0', '0', '2015-05-06 20:37:27');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('88', 'updated', 'extension', '', '25', '0', '0', '0', '2015-05-06 21:12:34');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('89', 'updated', 'extension', '', '25', '0', '0', '0', '2015-05-06 23:20:48');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('90', 'updated', 'extension', '', '25', '0', '0', '0', '2015-05-06 23:23:19');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('91', 'updated', 'menu', '', '76', '0', '0', '0', '2015-05-07 12:11:46');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('92', 'updated', 'table', '', '2', '0', '0', '0', '2015-05-07 12:12:02');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('93', 'assigned', 'reservation', '', '2446', '14', '0', '0', '2015-05-07 12:12:15');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('94', 'updated', 'coupon', '', '15', '0', '0', '0', '2015-05-07 12:12:33');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('95', 'updated', 'coupon', '', '15', '0', '0', '0', '2015-05-07 12:14:26');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('96', 'approved', 'review', '', '104', '0', '39', '0', '2015-05-07 12:14:40');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('97', 'updated', 'customer', '', '39', '0', '0', '0', '2015-05-07 12:16:01');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('98', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-07 12:20:01');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('99', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-07 12:22:53');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('100', 'updated', 'location', '', '118', '0', '0', '0', '2015-05-07 12:26:26');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('101', 'updated', 'extension', '', '11', '0', '0', '0', '2015-05-07 12:34:51');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('102', 'updated', 'extension', '', '18', '0', '0', '0', '2015-05-07 12:35:23');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('103', 'updated', 'location', '', '117', '0', '0', '0', '2015-05-07 20:49:39');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('104', 'added', 'customer', '', '40', '0', '0', '0', '2015-05-07 22:24:20');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('105', 'updated', 'location', '', '117', '0', '0', '0', '2015-05-07 22:26:05');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('106', 'updated', 'extension', '', '18', '0', '0', '0', '2015-05-09 23:27:54');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('107', 'updated', 'extension', '', '21', '0', '0', '0', '2015-05-10 00:16:20');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('108', 'updated', 'extension', '', '21', '0', '0', '0', '2015-05-10 00:26:36');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('109', 'updated', 'customer', '', '39', '0', '0', '0', '2015-05-10 15:35:00');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('110', 'added', 'location', '', '119', '0', '0', '0', '2015-05-10 18:00:13');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('111', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:00:25');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('112', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:22:20');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('113', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:23:05');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('114', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:25:04');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('115', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:25:48');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('116', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:26:35');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('117', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:26:45');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('118', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:26:51');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('119', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:27:02');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('120', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:27:17');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('121', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:27:30');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('122', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:27:40');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('123', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:29:16');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('124', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:29:22');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('125', 'updated', 'location', '', '119', '0', '0', '0', '2015-05-10 18:30:12');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('126', 'added', 'location', '', '120', '0', '0', '0', '2015-05-10 19:03:25');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('127', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 19:06:36');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('128', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 19:06:52');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('129', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 19:07:10');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('130', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 19:07:20');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('131', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 19:14:52');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('132', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 19:40:15');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('133', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:01:00');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('134', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:14:21');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('135', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:14:46');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('136', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:15:11');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('137', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:18:27');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('138', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:18:43');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('139', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:42:12');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('140', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-10 20:42:28');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('141', 'added', 'customer', '', '41', '0', '0', '0', '2015-05-11 13:05:41');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('142', 'added', 'customer', '', '42', '0', '0', '0', '2015-05-11 13:10:17');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('143', 'updated', 'location', '', '120', '0', '0', '0', '2015-05-11 15:15:18');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('144', 'updated', 'menu', '', '76', '0', '0', '0', '2015-05-11 18:18:47');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('145', 'updated', 'location', '', '117', '0', '0', '0', '2015-05-11 18:30:31');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('146', 'updated', 'menu', '', '81', '0', '0', '0', '2015-05-11 21:12:29');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('147', 'updated', 'menu', '', '81', '0', '0', '0', '2015-05-11 21:12:58');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('148', 'updated', 'menu', '', '76', '0', '0', '0', '2015-05-13 09:27:24');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('149', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-18 13:52:54');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('150', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-18 14:06:58');


#
# TABLE STRUCTURE FOR: ti_option_values
#

DROP TABLE IF EXISTS `ti_option_values`;

CREATE TABLE `ti_option_values` (
  `option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `value` varchar(128) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`option_value_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('6', '23', 'Peperoni', '1.99', '2');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('7', '23', 'Jalapenos', '3.99', '1');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('8', '22', 'Meat', '4.00', '1');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('9', '22', 'Chicken', '2.99', '2');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('10', '22', 'Fish', '3.00', '3');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('11', '22', 'Beef', '4.99', '4');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('12', '22', 'Assorted Meat', '5.99', '5');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('13', '24', 'Dodo', '3.99', '1');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('14', '24', 'Salad', '2.99', '2');
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES ('15', '23', 'Sweetcorn', '1.99', '3');


#
# TABLE STRUCTURE FOR: ti_options
#

DROP TABLE IF EXISTS `ti_options`;

CREATE TABLE `ti_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(32) NOT NULL,
  `display_type` varchar(15) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO `ti_options` (`option_id`, `option_name`, `display_type`, `priority`) VALUES ('22', 'Cooked', 'radio', '1');
INSERT INTO `ti_options` (`option_id`, `option_name`, `display_type`, `priority`) VALUES ('23', 'Toppings', 'checkbox', '2');
INSERT INTO `ti_options` (`option_id`, `option_name`, `display_type`, `priority`) VALUES ('24', 'Dressing', 'select', '3');


#
# TABLE STRUCTURE FOR: ti_order_menus
#

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
  PRIMARY KEY (`order_menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('78', '2649', '76', 'PUFF-PUFF', '39', '10.00', '390.00', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('79', '2649', '79', 'RICE AND DODO', '10', '19.97', '199.70', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('80', '2650', '78', 'ATA RICE', '8', '16.99', '135.92', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('81', '2650', '76', 'PUFF-PUFF', '9', '10.00', '90.00', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('82', '2650', '79', 'RICE AND DODO', '11', '17.97', '197.67', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('83', '2650', '87', 'Boiled Plantain', '1', '9.99', '9.99', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('84', '2651', '78', 'ATA RICE', '10', '16.99', '169.90', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('85', '2651', '79', 'RICE AND DODO', '22', '20.97', '461.34', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|61\";s:4:\"name\";s:19:\"Assorted Meat|Salad\";s:5:\"price\";s:9:\"5.99|2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('86', '2651', '80', 'Special Shrimp Deluxe', '15', '12.99', '194.85', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('87', '2652', '78', 'ATA RICE', '15', '16.00', '240.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"62\";s:4:\"name\";s:4:\"Meat\";s:5:\"price\";s:4:\"4.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('88', '2652', '79', 'RICE AND DODO', '16', '19.97', '319.52', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"58|61\";s:4:\"name\";s:10:\"Beef|Salad\";s:5:\"price\";s:9:\"4.99|2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('89', '2652', '80', 'Special Shrimp Deluxe', '15', '12.99', '194.85', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('90', '2653', '79', 'RICE AND DODO', '19', '21.97', '417.43', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|60\";s:4:\"name\";s:18:\"Assorted Meat|Dodo\";s:5:\"price\";s:9:\"5.99|3.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('91', '2653', '81', 'Whole Catfish with rice and vegetables', '100', '13.99', '1399.00', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('92', '2654', '81', 'Whole catfish with rice and vegetables', '221', '21.96', '4853.16', 'a:3:{s:20:\"menu_option_value_id\";s:8:\"72|73|74\";s:4:\"name\";s:28:\"Jalapenos|Peperoni|Sweetcorn\";s:5:\"price\";s:14:\"3.99|1.99|1.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('93', '2654', '80', 'Special Shrimp Deluxe', '13', '12.99', '168.87', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('94', '2654', '78', 'ATA RICE', '100', '17.99', '1799.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"66\";s:4:\"name\";s:13:\"Assorted Meat\";s:5:\"price\";s:4:\"5.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('95', '2654', '82', 'African Salad', '100', '8.99', '899.00', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('96', '2654', '79', 'RICE AND DODO', '38', '21.97', '834.86', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('97', '2655', '78', 'ATA RICE', '5', '17.99', '89.95', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"66\";s:4:\"name\";s:13:\"Assorted Meat\";s:5:\"price\";s:4:\"5.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('98', '2656', '76', 'PUFF-PUFF', '3', '4.99', '14.97', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('99', '2656', '79', 'RICE AND DODO', '100', '18.97', '1897.00', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"56|60\";s:4:\"name\";s:12:\"Chicken|Dodo\";s:5:\"price\";s:9:\"2.99|3.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('100', '2656', '80', 'Special Shrimp Deluxe', '1', '12.99', '12.99', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('101', '2656', '81', 'Whole catfish with rice and vegetables', '3', '15.98', '47.94', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"74\";s:4:\"name\";s:9:\"Sweetcorn\";s:5:\"price\";s:4:\"1.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('102', '2657', '87', 'Boiled Plantain', '2', '9.99', '19.98', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('103', '2657', '85', 'AMALA', '1', '17.97', '17.97', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"68|71\";s:4:\"name\";s:13:\"Chicken|Salad\";s:5:\"price\";s:9:\"2.99|2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('104', '2657', '78', 'ATA RICE', '8', '16.99', '135.92', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('105', '2657', '76', 'PUFF-PUFF', '9', '10.00', '90.00', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('106', '2657', '79', 'RICE AND DODO', '11', '17.97', '197.67', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('107', '2666', '78', 'ATA RICE', '100', '16.99', '1699.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('108', '2668', '78', 'ATA RICE', '100', '16.99', '1699.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('109', '2669', '78', 'ATA RICE', '100', '16.99', '1699.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('110', '2670', '78', 'ATA RICE', '100', '16.99', '1699.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('111', '2671', '78', 'ATA RICE', '100', '16.99', '1699.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('112', '2672', '78', 'ATA RICE', '100', '14.99', '1499.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"63\";s:4:\"name\";s:7:\"Chicken\";s:5:\"price\";s:4:\"2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('113', '2681', '78', 'ATA RICE', '100', '14.99', '1499.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"63\";s:4:\"name\";s:7:\"Chicken\";s:5:\"price\";s:4:\"2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('114', '2682', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('115', '2686', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('116', '2687', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('117', '2688', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('118', '2689', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('119', '2690', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('120', '2691', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('121', '2692', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('122', '2693', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('123', '2694', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('124', '2695', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('125', '2696', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('126', '2697', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('127', '2698', '85', 'AMALA', '27', '17.97', '485.19', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"68|71\";s:4:\"name\";s:13:\"Chicken|Salad\";s:5:\"price\";s:9:\"2.99|2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('128', '2698', '84', 'EBA', '100', '14.98', '1498.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"53\";s:4:\"name\";s:7:\"Chicken\";s:5:\"price\";s:4:\"2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('129', '2706', '78', 'ATA RICE', '20', '16.99', '339.80', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('130', '2706', '79', 'RICE AND DODO', '35', '20.97', '733.95', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|61\";s:4:\"name\";s:19:\"Assorted Meat|Salad\";s:5:\"price\";s:9:\"5.99|2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('131', '2712', '78', 'ATA RICE', '80', '14.99', '1199.20', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"63\";s:4:\"name\";s:7:\"Chicken\";s:5:\"price\";s:4:\"2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('132', '2716', '78', 'ATA RICE', '80', '14.99', '1199.20', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('133', '2716', '79', 'RICE AND DODO', '19', '20.97', '398.43', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|61\";s:4:\"name\";s:19:\"Assorted Meat|Salad\";s:5:\"price\";s:9:\"5.99|2.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('134', '2717', '78', 'ATA RICE', '100', '17.99', '1799.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"66\";s:4:\"name\";s:13:\"Assorted Meat\";s:5:\"price\";s:4:\"5.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('135', '2718', '78', 'ATA RICE', '50', '17.99', '899.50', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"66\";s:4:\"name\";s:13:\"Assorted Meat\";s:5:\"price\";s:4:\"5.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('136', '2719', '80', 'Special Shrimp Deluxe', '1', '12.99', '12.99', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('137', '2719', '79', 'RICE AND DODO', '100', '21.97', '2197.00', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|60\";s:4:\"name\";s:18:\"Assorted Meat|Dodo\";s:5:\"price\";s:9:\"5.99|3.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('138', '2720', '84', 'EBA', '100', '16.98', '1698.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"54\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('139', '2722', '87', 'Boiled Plantain', '10', '9.99', '99.90', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('140', '2722', '85', 'AMALA', '45', '19.98', '899.10', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"67|70\";s:4:\"name\";s:9:\"Meat|Dodo\";s:5:\"price\";s:9:\"4.00|3.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('141', '2723', '84', 'EBA', '100', '16.98', '1698.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"54\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('142', '2724', '78', 'ATA RICE', '333', '17.99', '5990.67', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"66\";s:4:\"name\";s:13:\"Assorted Meat\";s:5:\"price\";s:4:\"5.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('143', '2725', '79', 'RICE AND DODO', '88', '20.97', '1845.36', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|61\";s:4:\"name\";s:19:\"Assorted Meat|Salad\";s:5:\"price\";s:9:\"5.99|2.99\";}');


#
# TABLE STRUCTURE FOR: ti_order_options
#

DROP TABLE IF EXISTS `ti_order_options`;

CREATE TABLE `ti_order_options` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `order_option_name` varchar(128) NOT NULL,
  `order_option_price` decimal(15,2) NOT NULL,
  `order_menu_id` int(11) NOT NULL,
  `menu_option_value_id` int(11) NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('23', '2649', '79', 'Beef', '4.99', '79', '58');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('24', '2649', '79', 'Salad', '2.99', '79', '61');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('25', '2651', '78', 'Beef', '4.99', '84', '65');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('26', '2651', '79', 'Assorted Meat', '5.99', '85', '59');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('27', '2651', '79', 'Salad', '2.99', '85', '61');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('28', '2652', '78', 'Meat', '4.00', '87', '62');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('29', '2652', '79', 'Beef', '4.99', '88', '58');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('30', '2652', '79', 'Salad', '2.99', '88', '61');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('31', '2653', '79', 'Assorted Meat', '5.99', '90', '59');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('32', '2653', '79', 'Dodo', '3.99', '90', '60');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('33', '2654', '81', 'Jalapenos', '3.99', '92', '72');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('34', '2654', '81', 'Peperoni', '1.99', '92', '73');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('35', '2654', '81', 'Sweetcorn', '1.99', '92', '74');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('36', '2654', '78', 'Assorted Meat', '5.99', '94', '66');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('37', '2655', '78', 'Assorted Meat', '5.99', '97', '66');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('40', '2656', '81', 'Sweetcorn', '1.99', '101', '74');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('41', '2657', '85', 'Chicken', '2.99', '103', '68');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('42', '2657', '85', 'Salad', '2.99', '103', '71');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('43', '2666', '78', 'Beef', '4.99', '107', '65');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('44', '2668', '78', 'Beef', '4.99', '108', '65');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('45', '2669', '78', 'Beef', '4.99', '109', '65');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('46', '2670', '78', 'Beef', '4.99', '110', '65');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('47', '2671', '78', 'Beef', '4.99', '111', '65');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('48', '2672', '78', 'Chicken', '2.99', '112', '63');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('49', '2681', '78', 'Chicken', '2.99', '113', '63');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('50', '2682', '78', 'Fish', '3.00', '114', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('51', '2686', '78', 'Fish', '3.00', '115', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('52', '2687', '78', 'Fish', '3.00', '116', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('53', '2688', '78', 'Fish', '3.00', '117', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('54', '2689', '78', 'Fish', '3.00', '118', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('55', '2690', '78', 'Fish', '3.00', '119', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('56', '2691', '78', 'Fish', '3.00', '120', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('57', '2692', '78', 'Fish', '3.00', '121', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('58', '2693', '78', 'Fish', '3.00', '122', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('59', '2694', '78', 'Fish', '3.00', '123', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('60', '2695', '78', 'Fish', '3.00', '124', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('61', '2696', '78', 'Fish', '3.00', '125', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('62', '2697', '78', 'Fish', '3.00', '126', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('65', '2698', '84', 'Chicken', '2.99', '128', '53');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('67', '2706', '79', 'Assorted Meat', '5.99', '130', '59');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('68', '2706', '79', 'Salad', '2.99', '130', '61');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('69', '2712', '78', 'Chicken', '2.99', '131', '63');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('70', '2716', '79', 'Assorted Meat', '5.99', '133', '59');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('71', '2716', '79', 'Salad', '2.99', '133', '61');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('72', '2717', '78', 'Assorted Meat', '5.99', '134', '66');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('73', '2718', '78', 'Assorted Meat', '5.99', '135', '66');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('74', '2719', '79', 'Assorted Meat', '5.99', '137', '59');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('75', '2719', '79', 'Dodo', '3.99', '137', '60');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('76', '2720', '84', 'Beef', '4.99', '138', '54');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('77', '2722', '85', 'Meat', '4.00', '140', '67');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('78', '2722', '85', 'Dodo', '3.99', '140', '70');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('79', '2723', '84', 'Beef', '4.99', '141', '54');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('80', '2724', '78', 'Assorted Meat', '5.99', '142', '66');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('81', '2725', '79', 'Assorted Meat', '5.99', '143', '59');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('82', '2725', '79', 'Salad', '2.99', '143', '61');


#
# TABLE STRUCTURE FOR: ti_order_totals
#

DROP TABLE IF EXISTS `ti_order_totals`;

CREATE TABLE `ti_order_totals` (
  `order_total_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_total_id`,`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('29', '2641', 'cart_total', 'Sub Total', '369.84', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('30', '2641', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('31', '2641', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('32', '2642', 'cart_total', 'Sub Total', '398.79', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('33', '2642', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('34', '2642', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('50', '2649', 'cart_total', 'Sub Total', '589.70', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('51', '2649', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('52', '2649', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('53', '2650', 'cart_total', 'Sub Total', '433.58', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('54', '2650', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('55', '2650', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('56', '2651', 'cart_total', 'Sub Total', '826.09', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('57', '2651', 'coupon', 'Coupon', '100.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('58', '2652', 'cart_total', 'Sub Total', '754.37', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('59', '2652', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('60', '2653', 'cart_total', 'Sub Total', '1816.43', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('61', '2653', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('62', '2653', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('63', '2654', 'cart_total', 'Sub Total', '8554.89', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('64', '2654', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('65', '2654', 'coupon', 'Coupon', '100.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('66', '2655', 'cart_total', 'Sub Total', '89.95', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('67', '2655', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('68', '2655', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('69', '2656', 'cart_total', 'Sub Total', '1972.90', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('70', '2656', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('71', '2656', 'coupon', 'Coupon (2222) ', '100.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('72', '2657', 'cart_total', 'Sub Total', '461.54', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('73', '2657', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('74', '2668', 'cart_total', 'Sub Total', '1699.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('75', '2668', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('76', '2669', 'cart_total', 'Sub Total', '1699.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('77', '2669', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('78', '2670', 'cart_total', 'Sub Total', '1699.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('79', '2670', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('80', '2671', 'cart_total', 'Sub Total', '1699.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('81', '2671', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('82', '2672', 'cart_total', 'Sub Total', '1499.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('83', '2672', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('84', '2681', 'cart_total', 'Sub Total', '1499.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('85', '2681', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('86', '2682', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('87', '2682', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('88', '2686', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('89', '2686', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('90', '2687', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('91', '2687', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('92', '2688', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('93', '2688', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('94', '2689', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('95', '2689', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('96', '2690', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('97', '2690', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('98', '2691', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('99', '2691', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('100', '2692', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('101', '2692', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('102', '2693', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('103', '2693', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('104', '2694', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('105', '2694', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('106', '2695', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('107', '2695', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('108', '2696', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('109', '2696', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('110', '2697', 'cart_total', 'Sub Total', '1500.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('111', '2697', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('112', '2697', 'coupon', 'Coupon (3333) ', '30.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('113', '2698', 'cart_total', 'Sub Total', '1983.19', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('114', '2698', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('115', '2706', 'cart_total', 'Sub Total', '1073.75', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('116', '2706', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('117', '2712', 'cart_total', 'Sub Total', '1199.20', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('118', '2712', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('119', '2716', 'cart_total', 'Sub Total', '1597.63', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('120', '2716', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('121', '2717', 'cart_total', 'Sub Total', '1799.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('122', '2717', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('123', '2718', 'cart_total', 'Sub Total', '899.50', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('124', '2718', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('125', '2719', 'cart_total', 'Sub Total', '2209.99', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('126', '2719', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('127', '2720', 'cart_total', 'Sub Total', '1698.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('128', '2720', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('129', '2722', 'cart_total', 'Sub Total', '999.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('130', '2722', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('131', '2723', 'cart_total', 'Sub Total', '1698.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('132', '2723', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('133', '2724', 'cart_total', 'Sub Total', '5990.67', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('134', '2724', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('135', '2725', 'cart_total', 'Sub Total', '1845.36', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('136', '2725', 'delivery', 'Delivery', '10.00', '0');


#
# TABLE STRUCTURE FOR: ti_orders
#

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
) ENGINE=InnoDB AUTO_INCREMENT=2726 DEFAULT CHARSET=utf8;

INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2641', '41', 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', '117', '39', '', '25', '', 'cod', '1', '2015-02-08 21:06:06', '2014-06-27', '21:51:00', '369.84', '11', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2642', '41', 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', '117', '39', '', '29', '', 'cod', '1', '2015-02-18 00:50:07', '2014-06-18', '01:35:00', '398.79', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2649', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '115', '0', '', '49', '', 'cod', '2', '2015-02-14 19:45:22', '2014-07-14', '20:30:00', '599.70', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2650', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '118', '0', '', '29', '', 'cod', '2', '2015-02-20 14:00:03', '2015-04-08', '14:44:00', '443.58', '19', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', '1', '11');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2651', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '118', '0', '', '47', '', 'cod', '2', '2015-02-20 14:09:52', '2014-07-22', '14:54:00', '726.09', '11', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2652', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '118', '0', '', '46', '', 'cod', '2', '2015-01-20 14:20:22', '2014-07-20', '15:05:00', '754.37', '11', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2653', '40', 'Temi', 'Temi', 'temi@temi.com', '100000000', '115', '0', '', '119', '', 'cod', '2', '2015-01-21 01:03:20', '2014-07-21', '01:48:00', '1826.43', '14', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2654', '39', 'Demo', 'Demo', 'demo@demo.com', '100000000', '118', '41', '', '472', '', 'cod', '1', '2015-01-03 02:20:04', '2014-08-03', '03:04:00', '8454.89', '11', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:31.0) Gecko/20100101 Firefox/31.0 FirePHP/0.7.4', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2655', '40', 'Temi', 'Temi', 'temi@temi.com', '100000000', '115', '0', '', '5', '', 'cod', '2', '2015-01-08 14:44:26', '2014-10-08', '15:29:00', '89.95', '14', '192.168.192.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:32.0) Gecko/20100101 Firefox/32.0 FirePHP/0.7.4', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2656', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '118', '42', '', '107', '', 'cod', '1', '2015-04-12 22:32:23', '2015-04-12', '23:17:00', '1882.90', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2657', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '118', '42', '', '31', '', 'cod', '1', '2015-05-01 02:13:15', '2015-05-07', '14:30:00', '471.54', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2658', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 09:40:43', '2015-05-09', '10:23:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2659', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 09:43:27', '2015-05-09', '09:45:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2660', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 09:48:48', '2015-05-09', '10:32:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2661', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 09:51:26', '2015-05-09', '10:32:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2662', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 10:01:06', '2015-05-09', '10:32:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2663', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 10:01:19', '2015-05-09', '10:46:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2664', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 10:03:17', '2015-05-09', '10:48:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2665', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 10:09:55', '2015-05-09', '10:54:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2666', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 10:11:56', '2015-05-09', '10:56:00', '1699.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2667', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 18:18:00', '2015-05-09', '19:02:00', '1699.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2668', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:11:37', '2015-05-09', '21:56:00', '1699.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2669', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:12:21', '2015-05-09', '21:56:00', '1699.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2670', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:17:25', '2015-05-09', '21:56:00', '1699.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2671', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:18:43', '2015-05-09', '21:56:00', '1699.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2672', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:19:29', '2015-05-09', '22:03:00', '1499.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2673', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'c', '1', '2015-05-09 21:27:10', '2015-05-09', '22:11:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2674', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:27:54', '2015-05-09', '22:11:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2675', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:35:22', '2015-05-09', '22:20:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2676', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:36:59', '2015-05-09', '22:20:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2677', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:37:19', '2015-05-09', '22:20:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2678', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:37:31', '2015-05-09', '22:20:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2679', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:37:43', '2015-05-09', '22:20:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2680', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:38:05', '2015-05-09', '22:20:00', '1499.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2681', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:38:28', '2015-05-09', '22:23:00', '1499.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2682', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 21:45:59', '2015-05-09', '22:30:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2683', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'paypal_express', '1', '2015-05-09 21:59:50', '2015-05-09', '22:30:00', '1500.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2684', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'paypal_express', '1', '2015-05-09 22:00:53', '2015-05-09', '22:30:00', '1500.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2685', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'paypal_express', '1', '2015-05-09 22:20:21', '2015-05-09', '22:30:00', '1500.00', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2686', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:20:26', '2015-05-09', '22:30:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2687', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:21:34', '2015-05-09', '22:30:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2688', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:24:45', '2015-05-09', '22:30:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2689', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:25:28', '2015-05-09', '22:30:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2690', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:26:16', '2015-05-09', '22:30:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2691', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:34:06', '2015-05-09', '23:19:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2692', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:34:46', '2015-05-09', '23:19:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2693', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:34:57', '2015-05-09', '23:19:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2694', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:35:21', '2015-05-09', '23:19:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2695', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:36:37', '2015-05-09', '23:20:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2696', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'cod', '1', '2015-05-09 22:37:26', '2015-05-09', '23:21:00', '1500.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2697', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '100', '', 'cod', '1', '2015-05-09 22:51:32', '2015-05-09', '23:36:00', '1470.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2698', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '127', '', 'cod', '1', '2015-05-09 23:20:40', '2015-05-09', '23:45:00', '1993.19', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2699', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '10', '', 'cod', '1', '2015-05-09 23:28:42', '2015-05-09', '23:45:00', '179.90', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2700', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '10', '', 'cod', '1', '2015-05-09 23:29:07', '2015-05-09', '23:45:00', '179.90', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2701', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '10', '', 'cod', '1', '2015-05-09 23:29:46', '2015-05-09', '23:45:00', '179.90', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2702', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '10', '', 'cod', '1', '2015-05-09 23:31:14', '2015-05-09', '23:45:00', '179.90', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2703', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '28', '', 'cod', '1', '2015-05-09 23:35:42', '2015-05-09', '23:45:00', '549.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2704', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '28', '', 'cod', '1', '2015-05-09 23:35:52', '2015-05-09', '23:45:00', '549.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2705', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '28', '', 'cod', '1', '2015-05-09 23:36:23', '2015-05-09', '23:45:00', '549.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2706', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '55', '', 'cod', '1', '2015-05-09 23:37:14', '2015-05-09', '23:45:00', '1083.75', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2707', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '60', '', '', '1', '2015-05-09 23:53:31', '2015-05-09', '00:35:00', '909.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2708', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '60', '', 'cod', '1', '2015-05-09 23:53:46', '2015-05-09', '00:38:00', '909.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2709', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '60', '', 'cod', '1', '2015-05-09 23:55:43', '2015-05-09', '00:38:00', '909.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2710', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '60', '', 'cod', '1', '2015-05-09 23:55:58', '2015-05-09', '00:38:00', '909.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2711', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '44', '', '60', '', 'cod', '1', '2015-05-10 00:02:08', '2015-05-10', '09:45:00', '909.40', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2712', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '99', '', 'paypal_express', '1', '2015-05-10 00:14:37', '2015-05-10', '09:45:00', '1607.63', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2713', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '99', '', 'paypal_express', '1', '2015-05-10 01:00:48', '2015-05-10', '09:45:00', '1607.63', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2714', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '99', '', 'paypal_express', '1', '2015-05-10 01:10:57', '2015-05-10', '09:45:00', '1607.63', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2715', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '99', '', 'paypal_express', '1', '2015-05-10 01:33:14', '2015-05-10', '09:45:00', '1607.63', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2716', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '99', '', 'paypal_express', '1', '2015-05-10 01:42:31', '2015-05-10', '09:45:00', '1607.63', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2717', '40', 'Vivamus', 'Suscipit', 'sampoyigi@gmail.com', '7777050444', '117', '45', '', '100', '', 'paypal_express', '1', '2015-05-10 01:45:54', '2015-05-10', '09:45:00', '1809.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2718', '0', 'Nulla', 'Ipsum', 'lagos@tastyigniter.com', '4883930902', '117', '51', '', '50', '', 'paypal_express', '1', '2015-05-10 02:35:19', '2015-05-10', '12:00:00', '909.50', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2719', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '117', '42', '', '101', '', 'paypal_express', '2', '2015-05-10 14:19:07', '2015-05-10', '15:03:00', '2209.99', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2720', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '117', '42', '', '100', '', 'cod', '2', '2015-05-10 16:27:46', '2015-05-10', '17:12:00', '1698.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2721', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '117', '43', '', '46', '', 'cod', '1', '2015-05-10 16:30:18', '2015-05-10', '17:15:00', '919.09', '0', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2722', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '117', '43', '', '55', '', 'cod', '1', '2015-05-10 16:38:30', '2015-05-10', '17:15:00', '1009.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2723', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '120', '42', '', '100', '', 'cod', '1', '2015-05-10 22:47:33', '2015-05-10', '23:32:00', '1708.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2724', '39', 'Sam', 'Poyigi', 'demo@demo.com', '100000000', '120', '42', '', '333', '', 'cod', '1', '2015-05-10 22:58:59', '2015-05-10', '23:42:00', '6000.67', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:37.0) Gecko/20100101 Firefox/37.0', '1', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('2725', '0', 'Vivamus', 'Suscipit', 'lewisham@tastyigniter.com', '02088279103', '120', '52', '', '88', '', 'cod', '1', '2015-05-11 09:45:27', '2015-05-11', '10:28:00', '1855.36', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', '1', '0');


#
# TABLE STRUCTURE FOR: ti_pages
#

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `navigation`, `date_added`, `date_updated`, `status`) VALUES ('11', '11', 'About Us', 'About Us', 'About Us', '<h3 style=\"text-align: center;\"><span style=\"color: #993300;\">Aim</span></h3>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis massa ac magna sagittis, sit amet gravida metus gravida. Aenean dictum pellentesque erat, vitae adipiscing libero semper sit amet. Vestibulum nec nunc lorem. Duis vitae libero a libero hendrerit tincidunt in eu tellus. Aliquam consequat ultrices felis ut dictum. Nulla euismod felis a sem mattis ornare. Aliquam ut diam sit amet dolor iaculis molestie ac id nisl. Maecenas hendrerit convallis mi feugiat gravida. Quisque tincidunt, leo a posuere imperdiet, metus leo vestibulum orci, vel volutpat justo ligula id quam. Cras placerat tincidunt lorem eu interdum.</p>\r\n<h3 style=\"text-align: center;\"><span style=\"color: #993300;\">Mission</span></h3>\r\n<p>Ut eu pretium urna. In sed consectetur neque. In ornare odio erat, id ornare arcu euismod a. Ut dapibus sit amet erat commodo vestibulum. Praesent vitae lacus faucibus, rhoncus tortor et, bibendum justo. Etiam pharetra congue orci, eget aliquam orci. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend justo eros, sit amet fermentum tellus ullamcorper quis. Cras cursus mi at imperdiet faucibus. Proin iaculis, felis vitae luctus venenatis, ante tortor porta nisi, et ornare magna metus sit amet enim. Phasellus et turpis nec metus aliquet adipiscing. Etiam at augue nec odio lacinia tincidunt. Suspendisse commodo commodo ipsum ac sollicitudin. Nunc nec consequat lacus. Donec gravida rhoncus justo sed elementum.</p>\r\n<h3 style=\"text-align: center;\"><span style=\"color: #a52a2a;\">Vision</span></h3>\r\n<p>Praesent erat massa, consequat a nulla et, eleifend facilisis risus. Nullam libero mi, bibendum id eleifend vitae, imperdiet a nulla. Fusce congue porta ultricies. Vivamus felis lectus, egestas at pretium vitae, posuere a nibh. Mauris lobortis urna nec rhoncus consectetur. Fusce sed placerat sem. Nulla venenatis elit risus, non auctor arcu lobortis eleifend. Ut aliquet vitae velit a faucibus. Suspendisse quis risus sit amet arcu varius malesuada. Vestibulum vitae massa consequat, euismod lorem a, euismod lacus. Duis sagittis dolor risus, ac vehicula mauris lacinia quis. Nulla facilisi. Duis tristique ipsum nec egestas auctor. Nullam in felis vel ligula dictum tincidunt nec a neque. Praesent in egestas elit.</p>', '', '', '17', 'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}', '2014-04-19 16:57:21', '2015-05-07 12:39:52', '1');
INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `navigation`, `date_added`, `date_updated`, `status`) VALUES ('12', '11', 'Policy', 'Policy', 'Policy', '<div id=\"lipsum\">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ligula eros, semper a lorem et, venenatis volutpat dolor. Pellentesque hendrerit lectus feugiat nulla cursus, quis dapibus dolor porttitor. Donec velit enim, adipiscing ac orci id, congue tincidunt arcu. Proin egestas nulla eget leo scelerisque, et semper diam ornare. Suspendisse potenti. Suspendisse vitae bibendum enim. Duis eu ligula hendrerit, lacinia felis in, mollis nisi. Sed gravida arcu in laoreet dictum. Nulla faucibus lectus a mollis dapibus. Fusce vehicula convallis urna, et congue nulla ultricies in. Nulla magna velit, bibendum eu odio et, euismod rhoncus sem. Nullam quis magna fermentum, ultricies neque nec, blandit neque. Etiam nec congue arcu. Curabitur sed tellus quam. Cras adipiscing odio odio, et porttitor dui suscipit eget. Aliquam non est commodo, elementum turpis at, pellentesque lorem.</p>\r\n<p>Duis nec diam diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate est et lorem sagittis, et mollis libero ultricies. Nunc ultrices tortor vel convallis varius. In dolor dolor, scelerisque ac faucibus ut, aliquet ac sem. Praesent consectetur lacus quis tristique posuere. Nulla sed ultricies odio. Cras tristique vulputate facilisis.</p>\r\n<p>Mauris at metus in magna condimentum gravida eu tincidunt urna. Praesent sodales vel mi eu condimentum. Suspendisse in luctus purus. Vestibulum dignissim, metus non luctus accumsan, odio ligula pharetra massa, in eleifend turpis risus in diam. Sed non lorem nibh. Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci. Nulla eget quam sit amet risus rhoncus lacinia a ut eros. Praesent non libero nisi. Mauris tincidunt at purus sit amet adipiscing. Donec interdum, velit nec dignissim vehicula, libero ipsum imperdiet ligula, lacinia mattis augue dui ac lacus. Aenean molestie sed nunc at pulvinar. Fusce ornare lacus non venenatis rhoncus.</p>\r\n<p>Aenean at enim luctus ante commodo consequat nec ut mi. Sed porta adipiscing tempus. Aliquam sit amet ullamcorper ipsum, id adipiscing quam. Fusce iaculis odio ut nisi convallis hendrerit. Morbi auctor adipiscing ligula, sit amet aliquet ante consectetur at. Donec vulputate neque eleifend libero pellentesque, vitae lacinia enim ornare. Vestibulum fermentum erat blandit, ultricies felis ac, facilisis augue. Nulla facilisis mi porttitor, interdum diam in, lobortis ipsum. In molestie quam nisl, lacinia convallis tellus fermentum ac. Nulla quis velit augue. Fusce accumsan, lacus et lobortis blandit, neque magna gravida enim, dignissim ultricies tortor dui in dolor. Vestibulum vel convallis justo, quis venenatis elit. Aliquam erat volutpat. Nunc quis iaculis ligula. Suspendisse dictum sodales neque vitae faucibus. Fusce id tellus pretium, varius nunc et, placerat metus.</p>\r\n<p>Pellentesque quis facilisis mauris. Phasellus porta, metus a dignissim viverra, est elit luctus erat, nec ultricies ligula lorem eget sapien. Pellentesque ac justo velit. Maecenas semper accumsan nulla eget rhoncus. Aliquam vel urna sed nibh dignissim auctor. Integer volutpat lacus ac purus convallis, at lobortis nisi tincidunt. Vestibulum condimentum elit ac sapien placerat, at ornare libero hendrerit. Cras tincidunt nunc sit amet ante bibendum tempor. Fusce quam orci, suscipit sed eros quis, vulputate molestie metus. Nam hendrerit vitae felis et porttitor. Proin et commodo velit, id porta erat. Donec eu consectetur odio. Fusce porta odio risus. Aliquam vel erat feugiat, vestibulum elit eget, ornare sapien. Sed sed nulla justo. Sed a dolor eu justo lacinia blandit</p>\r\n</div>', '', '', '17', 'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}', '2014-04-19 17:21:23', '2015-05-16 09:18:39', '1');
INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `navigation`, `date_added`, `date_updated`, `status`) VALUES ('13', '11', 'Maintenance', 'Maintenance', 'Maintenance', '<h4><span style=\"color: #b22222;\">Site is under maintenance. Please check back later.</span></h4>', '', '', '0', 'a:1:{i:0;s:4:\"none\";}', '2014-04-21 16:30:37', '2014-07-28 00:47:24', '1');


#
# TABLE STRUCTURE FOR: ti_permalinks
#

DROP TABLE IF EXISTS `ti_permalinks`;

CREATE TABLE `ti_permalinks` (
  `permalink_id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `query` varchar(255) NOT NULL,
  PRIMARY KEY (`permalink_id`),
  UNIQUE KEY `uniqueSlug` (`slug`,`controller`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('11', 'traditional', 'menus', 'category_id=19');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('12', 'vegetarian', 'menus', 'category_id=20');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('13', 'soups', 'menus', 'category_id=21');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('14', 'specials', 'menus', 'category_id=24');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('16', 'salads', 'menus', 'category_id=17');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('18', 'appetizer', 'menus', 'category_id=15');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('19', 'main-course', 'menus', 'category_id=16');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('20', 'seafoods', 'menus', 'category_id=18');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('36', 'maintenance', 'pages', 'page_id=13');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('37', 'about-us', 'pages', 'page_id=11');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('41', 'rice-dishes', 'menus', 'category_id=26');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('44', 'nigeria', 'local', 'location_id=118');
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('46', 'lewisham', 'local', 'location_id=120');


#
# TABLE STRUCTURE FOR: ti_pp_payments
#

DROP TABLE IF EXISTS `ti_pp_payments`;

CREATE TABLE `ti_pp_payments` (
  `transaction_id` varchar(19) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `serialized` text NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ti_pp_payments` (`transaction_id`, `order_id`, `customer_id`, `serialized`) VALUES ('0GB8272596652870Y', '2718', '0', 'a:39:{s:13:\"RECEIVEREMAIL\";s:34:\"samadepoyigi-facilitator@gmail.com\";s:10:\"RECEIVERID\";s:13:\"G5Z477QKQLAML\";s:5:\"EMAIL\";s:17:\"eesyboii@live.com\";s:7:\"PAYERID\";s:13:\"6HUFG9X9ZTHZY\";s:11:\"PAYERSTATUS\";s:8:\"verified\";s:11:\"COUNTRYCODE\";s:2:\"GB\";s:10:\"SHIPTONAME\";s:11:\"Nulla Ipsum\";s:12:\"SHIPTOSTREET\";s:10:\"5 Poole Rd\";s:10:\"SHIPTOCITY\";s:7:\"Londndo\";s:17:\"SHIPTOCOUNTRYCODE\";s:2:\"GB\";s:17:\"SHIPTOCOUNTRYNAME\";s:14:\"United Kingdom\";s:9:\"SHIPTOZIP\";s:6:\"E9 7AE\";s:12:\"ADDRESSOWNER\";s:6:\"PayPal\";s:13:\"ADDRESSSTATUS\";s:9:\"Confirmed\";s:8:\"SALESTAX\";s:4:\"0.00\";s:10:\"SHIPAMOUNT\";s:5:\"10.00\";s:16:\"SHIPHANDLEAMOUNT\";s:4:\"0.00\";s:9:\"TIMESTAMP\";s:20:\"2015-05-10T01:35:42Z\";s:13:\"CORRELATIONID\";s:12:\"66eed9f6225f\";s:3:\"ACK\";s:7:\"Success\";s:7:\"VERSION\";s:4:\"76.0\";s:5:\"BUILD\";s:8:\"16566018\";s:9:\"FIRSTNAME\";s:3:\"Sam\";s:8:\"LASTNAME\";s:3:\"Sam\";s:13:\"TRANSACTIONID\";s:17:\"0GB8272596652870Y\";s:15:\"TRANSACTIONTYPE\";s:15:\"expresscheckout\";s:11:\"PAYMENTTYPE\";s:7:\"instant\";s:9:\"ORDERTIME\";s:20:\"2015-05-10T01:35:40Z\";s:3:\"AMT\";s:6:\"909.50\";s:6:\"TAXAMT\";s:4:\"0.00\";s:12:\"CURRENCYCODE\";s:3:\"GBP\";s:13:\"PAYMENTSTATUS\";s:7:\"Pending\";s:13:\"PENDINGREASON\";s:13:\"multicurrency\";s:10:\"REASONCODE\";s:4:\"None\";s:21:\"PROTECTIONELIGIBILITY\";s:10:\"Ineligible\";s:25:\"PROTECTIONELIGIBILITYTYPE\";s:4:\"None\";s:6:\"L_QTY0\";s:1:\"1\";s:9:\"L_TAXAMT0\";s:4:\"0.00\";s:15:\"L_CURRENCYCODE0\";s:3:\"GBP\";}');
INSERT INTO `ti_pp_payments` (`transaction_id`, `order_id`, `customer_id`, `serialized`) VALUES ('2EG91406F7010674L', '2719', '39', 'a:40:{s:13:\"RECEIVEREMAIL\";s:34:\"samadepoyigi-facilitator@gmail.com\";s:10:\"RECEIVERID\";s:13:\"G5Z477QKQLAML\";s:5:\"EMAIL\";s:17:\"eesyboii@live.com\";s:7:\"PAYERID\";s:13:\"6HUFG9X9ZTHZY\";s:11:\"PAYERSTATUS\";s:8:\"verified\";s:11:\"COUNTRYCODE\";s:2:\"GB\";s:10:\"SHIPTONAME\";s:7:\"Sam Sam\";s:12:\"SHIPTOSTREET\";s:14:\"1 Main Terrace\";s:10:\"SHIPTOCITY\";s:13:\"Wolverhampton\";s:11:\"SHIPTOSTATE\";s:13:\"West Midlands\";s:17:\"SHIPTOCOUNTRYCODE\";s:2:\"GB\";s:17:\"SHIPTOCOUNTRYNAME\";s:14:\"United Kingdom\";s:9:\"SHIPTOZIP\";s:7:\"W12 4LQ\";s:12:\"ADDRESSOWNER\";s:6:\"PayPal\";s:13:\"ADDRESSSTATUS\";s:9:\"Confirmed\";s:8:\"SALESTAX\";s:4:\"0.00\";s:10:\"SHIPAMOUNT\";s:4:\"0.00\";s:16:\"SHIPHANDLEAMOUNT\";s:4:\"0.00\";s:9:\"TIMESTAMP\";s:20:\"2015-05-10T13:19:36Z\";s:13:\"CORRELATIONID\";s:13:\"1d1551217895b\";s:3:\"ACK\";s:7:\"Success\";s:7:\"VERSION\";s:4:\"76.0\";s:5:\"BUILD\";s:8:\"16566018\";s:9:\"FIRSTNAME\";s:3:\"Sam\";s:8:\"LASTNAME\";s:3:\"Sam\";s:13:\"TRANSACTIONID\";s:17:\"2EG91406F7010674L\";s:15:\"TRANSACTIONTYPE\";s:15:\"expresscheckout\";s:11:\"PAYMENTTYPE\";s:7:\"instant\";s:9:\"ORDERTIME\";s:20:\"2015-05-10T13:19:35Z\";s:3:\"AMT\";s:7:\"2209.99\";s:6:\"TAXAMT\";s:4:\"0.00\";s:12:\"CURRENCYCODE\";s:3:\"GBP\";s:13:\"PAYMENTSTATUS\";s:7:\"Pending\";s:13:\"PENDINGREASON\";s:13:\"multicurrency\";s:10:\"REASONCODE\";s:4:\"None\";s:21:\"PROTECTIONELIGIBILITY\";s:10:\"Ineligible\";s:25:\"PROTECTIONELIGIBILITYTYPE\";s:4:\"None\";s:6:\"L_QTY0\";s:1:\"1\";s:9:\"L_TAXAMT0\";s:4:\"0.00\";s:15:\"L_CURRENCYCODE0\";s:3:\"GBP\";}');
INSERT INTO `ti_pp_payments` (`transaction_id`, `order_id`, `customer_id`, `serialized`) VALUES ('3CH33165AD7089737', '2716', '40', 'a:39:{s:13:\"RECEIVEREMAIL\";s:34:\"samadepoyigi-facilitator@gmail.com\";s:10:\"RECEIVERID\";s:13:\"G5Z477QKQLAML\";s:5:\"EMAIL\";s:17:\"eesyboii@live.com\";s:7:\"PAYERID\";s:13:\"6HUFG9X9ZTHZY\";s:11:\"PAYERSTATUS\";s:8:\"verified\";s:11:\"COUNTRYCODE\";s:2:\"GB\";s:10:\"SHIPTONAME\";s:16:\"Vivamus Suscipit\";s:12:\"SHIPTOSTREET\";s:12:\"175A Wick Rd\";s:10:\"SHIPTOCITY\";s:6:\"London\";s:17:\"SHIPTOCOUNTRYCODE\";s:2:\"GB\";s:17:\"SHIPTOCOUNTRYNAME\";s:14:\"United Kingdom\";s:9:\"SHIPTOZIP\";s:6:\"E9 5AF\";s:12:\"ADDRESSOWNER\";s:6:\"PayPal\";s:13:\"ADDRESSSTATUS\";s:9:\"Confirmed\";s:8:\"SALESTAX\";s:4:\"0.00\";s:10:\"SHIPAMOUNT\";s:5:\"10.00\";s:16:\"SHIPHANDLEAMOUNT\";s:4:\"0.00\";s:9:\"TIMESTAMP\";s:20:\"2015-05-10T00:44:24Z\";s:13:\"CORRELATIONID\";s:13:\"2a5f5622ce1f1\";s:3:\"ACK\";s:7:\"Success\";s:7:\"VERSION\";s:4:\"76.0\";s:5:\"BUILD\";s:8:\"16566018\";s:9:\"FIRSTNAME\";s:3:\"Sam\";s:8:\"LASTNAME\";s:3:\"Sam\";s:13:\"TRANSACTIONID\";s:17:\"3CH33165AD7089737\";s:15:\"TRANSACTIONTYPE\";s:15:\"expresscheckout\";s:11:\"PAYMENTTYPE\";s:7:\"instant\";s:9:\"ORDERTIME\";s:20:\"2015-05-10T00:42:43Z\";s:3:\"AMT\";s:7:\"1607.63\";s:6:\"TAXAMT\";s:4:\"0.00\";s:12:\"CURRENCYCODE\";s:3:\"GBP\";s:13:\"PAYMENTSTATUS\";s:7:\"Pending\";s:13:\"PENDINGREASON\";s:13:\"multicurrency\";s:10:\"REASONCODE\";s:4:\"None\";s:21:\"PROTECTIONELIGIBILITY\";s:10:\"Ineligible\";s:25:\"PROTECTIONELIGIBILITYTYPE\";s:4:\"None\";s:6:\"L_QTY0\";s:1:\"1\";s:9:\"L_TAXAMT0\";s:4:\"0.00\";s:15:\"L_CURRENCYCODE0\";s:3:\"GBP\";}');
INSERT INTO `ti_pp_payments` (`transaction_id`, `order_id`, `customer_id`, `serialized`) VALUES ('5P838156XS0462024', '2717', '40', 'a:39:{s:13:\"RECEIVEREMAIL\";s:34:\"samadepoyigi-facilitator@gmail.com\";s:10:\"RECEIVERID\";s:13:\"G5Z477QKQLAML\";s:5:\"EMAIL\";s:17:\"eesyboii@live.com\";s:7:\"PAYERID\";s:13:\"6HUFG9X9ZTHZY\";s:11:\"PAYERSTATUS\";s:8:\"verified\";s:11:\"COUNTRYCODE\";s:2:\"GB\";s:10:\"SHIPTONAME\";s:16:\"Vivamus Suscipit\";s:12:\"SHIPTOSTREET\";s:12:\"175A Wick Rd\";s:10:\"SHIPTOCITY\";s:6:\"London\";s:17:\"SHIPTOCOUNTRYCODE\";s:2:\"GB\";s:17:\"SHIPTOCOUNTRYNAME\";s:14:\"United Kingdom\";s:9:\"SHIPTOZIP\";s:6:\"E9 5AF\";s:12:\"ADDRESSOWNER\";s:6:\"PayPal\";s:13:\"ADDRESSSTATUS\";s:9:\"Confirmed\";s:8:\"SALESTAX\";s:4:\"0.00\";s:10:\"SHIPAMOUNT\";s:5:\"10.00\";s:16:\"SHIPHANDLEAMOUNT\";s:4:\"0.00\";s:9:\"TIMESTAMP\";s:20:\"2015-05-10T00:46:25Z\";s:13:\"CORRELATIONID\";s:13:\"81f694629b47e\";s:3:\"ACK\";s:7:\"Success\";s:7:\"VERSION\";s:4:\"76.0\";s:5:\"BUILD\";s:8:\"16566018\";s:9:\"FIRSTNAME\";s:3:\"Sam\";s:8:\"LASTNAME\";s:3:\"Sam\";s:13:\"TRANSACTIONID\";s:17:\"5P838156XS0462024\";s:15:\"TRANSACTIONTYPE\";s:15:\"expresscheckout\";s:11:\"PAYMENTTYPE\";s:7:\"instant\";s:9:\"ORDERTIME\";s:20:\"2015-05-10T00:46:23Z\";s:3:\"AMT\";s:7:\"1809.00\";s:6:\"TAXAMT\";s:4:\"0.00\";s:12:\"CURRENCYCODE\";s:3:\"GBP\";s:13:\"PAYMENTSTATUS\";s:7:\"Pending\";s:13:\"PENDINGREASON\";s:13:\"multicurrency\";s:10:\"REASONCODE\";s:4:\"None\";s:21:\"PROTECTIONELIGIBILITY\";s:10:\"Ineligible\";s:25:\"PROTECTIONELIGIBILITYTYPE\";s:4:\"None\";s:6:\"L_QTY0\";s:1:\"1\";s:9:\"L_TAXAMT0\";s:4:\"0.00\";s:15:\"L_CURRENCYCODE0\";s:3:\"GBP\";}');


#
# TABLE STRUCTURE FOR: ti_reservations
#

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
) ENGINE=InnoDB AUTO_INCREMENT=2447 DEFAULT CHARSET=utf8;

INSERT INTO `ti_reservations` (`reservation_id`, `location_id`, `table_id`, `guest_num`, `occasion_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `comment`, `reserve_time`, `reserve_date`, `date_added`, `date_modified`, `assignee_id`, `notify`, `ip_address`, `user_agent`, `status`) VALUES ('2445', '117', '7', '8', '2', '41', 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', '', '13:45:00', '2015-02-19', '2015-02-17', '2015-04-01', '0', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0', '18');
INSERT INTO `ti_reservations` (`reservation_id`, `location_id`, `table_id`, `guest_num`, `occasion_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `comment`, `reserve_time`, `reserve_date`, `date_added`, `date_modified`, `assignee_id`, `notify`, `ip_address`, `user_agent`, `status`) VALUES ('2446', '115', '7', '7', '4', '39', 'Sam', 'Poyigi', 'temi@temi.com', '100000000', '', '16:00:00', '2015-02-24', '2015-02-21', '2015-05-07', '11', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0', '18');


#
# TABLE STRUCTURE FOR: ti_reviews
#

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
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

INSERT INTO `ti_reviews` (`review_id`, `customer_id`, `sale_id`, `sale_type`, `author`, `location_id`, `quality`, `delivery`, `service`, `review_text`, `date_added`, `review_status`) VALUES ('100', '39', '2650', 'order', 'Sam Poyigi', '116', '3', '3', '3', 'Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci.', '2015-02-13 00:21:04', '1');
INSERT INTO `ti_reviews` (`review_id`, `customer_id`, `sale_id`, `sale_type`, `author`, `location_id`, `quality`, `delivery`, `service`, `review_text`, `date_added`, `review_status`) VALUES ('103', '39', '2641', 'order', 'Sam Poyigi', '116', '1', '1', '1', 'Mauris posuere orci enim, vel rhoncus nibh facilisis nec.', '2015-02-25 23:51:57', '1');
INSERT INTO `ti_reviews` (`review_id`, `customer_id`, `sale_id`, `sale_type`, `author`, `location_id`, `quality`, `delivery`, `service`, `review_text`, `date_added`, `review_status`) VALUES ('104', '39', '2446', 'reservation', 'Sam Poyigi', '115', '3', '5', '4', 'Aliquam erat volutpat. Maecenas tempus feugiat convallis. Etiam ultricies porttitor massa, tincidunt pharetra purus posuere non.', '2015-04-07 00:43:54', '1');


#
# TABLE STRUCTURE FOR: ti_security_questions
#

DROP TABLE IF EXISTS `ti_security_questions`;

CREATE TABLE `ti_security_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('11', 'Whats your pets name?', '1');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('12', 'What high school did you attend?', '2');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('13', 'What is your father\'s middle name?', '7');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('14', 'What is your mother\'s name?', '3');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('15', 'What is your place of birth?', '4');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('16', 'Whats your favourite teacher\'s name?', '5');


#
# TABLE STRUCTURE FOR: ti_settings
#

DROP TABLE IF EXISTS `ti_settings`;

CREATE TABLE `ti_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` varchar(45) NOT NULL,
  `item` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `item` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=13644 DEFAULT CHARSET=utf8;

INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('7870', 'prefs', 'mail_template_id', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('9225', 'config', 'site_desc', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('9241', 'config', 'search_radius', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('9249', 'config', 'ready_time', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('10894', 'config', 'index_file_url', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('11410', 'config', 'activity_timeout', '120', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('11411', 'config', 'activity_delete', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('11670', 'prefs', 'main_active_style', 'a:5:{s:12:\"extension_id\";i:0;s:4:\"name\";s:19:\"tastyigniter-orange\";s:5:\"title\";s:19:\"TastyIgniter Orange\";s:8:\"location\";s:4:\"main\";s:4:\"data\";a:14:{s:10:\"logo_width\";s:3:\"220\";s:8:\"logo_top\";s:1:\"0\";s:9:\"logo_left\";s:2:\"30\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:3:{s:10:\"background\";s:7:\"#fcfcfc\";s:5:\"image\";s:0:\"\";s:6:\"border\";s:7:\"#e7e7e7\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#0074a2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#9dc8e0\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#f4f4f4\";s:5:\"image\";s:0:\"\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#e7e7e7\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#428bca\";s:5:\"hover\";s:7:\"#2a6496\";}s:6:\"button\";a:4:{i:0;a:3:{s:10:\"background\";s:7:\"#ffffff\";s:6:\"border\";s:7:\"#cccccc\";s:4:\"type\";s:7:\"default\";}i:1;a:3:{s:10:\"background\";s:7:\"#428bca\";s:6:\"border\";s:7:\"#357ebd\";s:4:\"type\";s:7:\"primary\";}i:2;a:3:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";s:4:\"type\";s:7:\"success\";}i:3;a:3:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";s:4:\"type\";s:6:\"danger\";}}s:10:\"custom_css\";s:0:\"\";s:11:\"content_top\";a:2:{s:5:\"width\";s:3:\"200\";s:10:\"min_height\";s:3:\"250\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('11676', 'prefs', 'default_themes', 'a:2:{s:5:\"admin\";s:18:\"tastyigniter-blue/\";s:4:\"main\";s:20:\"tastyigniter-orange/\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('12142', 'config', 'encryption_key', 'muh6T37619LO09uJpk1679pCI06LHps4', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('12145', 'config', 'maintenance_page', '13', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('12216', 'prefs', 'ti_version', 'v1.3-beta', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('12217', 'ratings', 'ratings', 'a:1:{s:7:\"ratings\";a:5:{i:1;s:3:\"Bad\";i:2;s:5:\"Worse\";i:3;s:4:\"Good\";i:4;s:7:\"Average\";i:5;s:9:\"Excellent\";}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('12219', 'prefs', 'customizer_active_style', 'a:2:{s:4:\"main\";a:2:{i:0;s:19:\"tastyigniter-orange\";i:1;a:13:{s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"25\";s:19:\"logo_padding_bottom\";s:2:\"25\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#fdeae2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#333333\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#ffffff\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#428bca\";s:5:\"hover\";s:7:\"#2a6496\";}s:6:\"button\";a:4:{s:7:\"default\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:6:\"border\";s:7:\"#cccccc\";}s:7:\"primary\";a:2:{s:10:\"background\";s:7:\"#428bca\";s:6:\"border\";s:7:\"#357ebd\";}s:7:\"success\";a:2:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";}s:6:\"danger\";a:2:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";}}s:10:\"custom_css\";s:0:\"\";}}s:5:\"admin\";a:2:{i:0;s:17:\"tastyigniter-blue\";i:1;a:13:{s:10:\"logo_width\";s:3:\"220\";s:8:\"logo_top\";s:1:\"0\";s:9:\"logo_left\";s:2:\"30\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:3:{s:10:\"background\";s:7:\"#fcfcfc\";s:5:\"image\";s:0:\"\";s:6:\"border\";s:7:\"#e7e7e7\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#0074a2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#9dc8e0\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#f4f4f4\";s:5:\"image\";s:0:\"\";s:6:\"border\";s:7:\"#e7e7e7\";s:4:\"font\";s:7:\"#484848\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#428bca\";s:5:\"hover\";s:7:\"#2a6496\";}s:6:\"button\";a:4:{i:0;a:3:{s:10:\"background\";s:7:\"#ffffff\";s:6:\"border\";s:7:\"#cccccc\";s:4:\"type\";s:7:\"default\";}i:1;a:3:{s:10:\"background\";s:7:\"#428bca\";s:6:\"border\";s:7:\"#357ebd\";s:4:\"type\";s:7:\"primary\";}i:2;a:3:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";s:4:\"type\";s:7:\"success\";}i:3;a:3:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";s:4:\"type\";s:6:\"danger\";}}s:10:\"custom_css\";s:0:\"\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13251', 'config', 'stock_warning', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13252', 'config', 'stock_qty_warning', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13408', 'config', 'log_threshold', '2', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13586', 'config', 'site_name', 'TastyIgniter', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13587', 'config', 'site_email', 'info@tastyigniter.com', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13588', 'config', 'site_logo', 'data/logo.png', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13589', 'config', 'country_id', '222', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13590', 'config', 'timezone', 'Europe/London', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13591', 'config', 'currency_id', '226', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13592', 'config', 'language_id', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13593', 'config', 'customer_group_id', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13594', 'config', 'page_limit', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13595', 'config', 'meta_description', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13596', 'config', 'meta_keywords', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13597', 'config', 'menus_page_limit', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13598', 'config', 'show_menu_images', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13599', 'config', 'menu_images_h', '80', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13600', 'config', 'menu_images_w', '95', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13601', 'config', 'special_category_id', '24', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13602', 'config', 'registration_terms', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13603', 'config', 'checkout_terms', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13604', 'config', 'registration_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13605', 'config', 'customer_order_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13606', 'config', 'customer_reserve_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13608', 'config', 'maps_api_key', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13609', 'config', 'search_by', 'address', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13610', 'config', 'distance_unit', 'mi', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13611', 'config', 'future_orders', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13612', 'config', 'location_order', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13613', 'config', 'location_order_email', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13614', 'config', 'location_reserve_email', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13615', 'config', 'approve_reviews', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13616', 'config', 'order_status_new', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13617', 'config', 'order_status_complete', '15', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13618', 'config', 'order_status_cancel', '19', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13619', 'config', 'guest_order', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13620', 'config', 'delivery_time', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13621', 'config', 'collection_time', '15', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13622', 'config', 'reservation_mode', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13623', 'config', 'reservation_status', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13624', 'config', 'reservation_interval', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13625', 'config', 'reservation_turn', '60', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13626', 'config', 'image_manager', 'a:11:{s:8:\"max_size\";s:3:\"300\";s:11:\"thumb_width\";s:3:\"320\";s:12:\"thumb_height\";s:3:\"220\";s:7:\"uploads\";s:1:\"1\";s:10:\"new_folder\";s:1:\"1\";s:4:\"copy\";s:1:\"1\";s:4:\"move\";s:1:\"1\";s:6:\"rename\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";s:15:\"transliteration\";s:1:\"0\";s:13:\"remember_days\";s:1:\"7\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13627', 'config', 'protocol', 'smtp', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13628', 'config', 'mailtype', 'html', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13629', 'config', 'smtp_host', 'auth.smtp.1and1.co.uk', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13630', 'config', 'smtp_port', '587', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13631', 'config', 'smtp_user', 'info@tastyigniter.com', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13632', 'config', 'smtp_pass', 'Rack080d@', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13633', 'config', 'activity_online_time_out', '1200', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13634', 'config', 'activity_archive_time_out', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13635', 'config', 'permalink', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13636', 'config', 'maintenance_mode', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13637', 'config', 'maintenance_message', 'Site is under maintenance. Please check back later.', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13638', 'config', 'cache_mode', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13639', 'config', 'cache_time', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13642', 'config', 'main_address', 'a:12:{s:11:\"location_id\";s:3:\"117\";s:13:\"location_name\";s:7:\"Hackney\";s:9:\"address_1\";s:15:\"44 Darnley Road\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:14:\"Greater London\";s:5:\"state\";s:0:\"\";s:8:\"postcode\";s:6:\"E9 6QH\";s:10:\"country_id\";s:3:\"222\";s:7:\"country\";s:14:\"United Kingdom\";s:10:\"iso_code_2\";s:2:\"GB\";s:10:\"iso_code_3\";s:3:\"GBR\";s:6:\"format\";s:59:\"{address_1}\n{address_2}\n{city} {postcode} {state}\n{country}\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('13643', 'prefs', 'default_location_id', '117', '0');


#
# TABLE STRUCTURE FOR: ti_staff_groups
#

DROP TABLE IF EXISTS `ti_staff_groups`;

CREATE TABLE `ti_staff_groups` (
  `staff_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_group_name` varchar(32) NOT NULL,
  `location_access` tinyint(1) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`staff_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permission`) VALUES ('11', 'Super Staff', '0', 'a:2:{s:6:\"access\";a:43:{i:0;s:7:\"banners\";i:1;s:10:\"categories\";i:2;s:9:\"countries\";i:3;s:7:\"coupons\";i:4;s:10:\"currencies\";i:5;s:15:\"customer_groups\";i:6;s:9:\"customers\";i:7;s:18:\"customers_activity\";i:8;s:8:\"database\";i:9;s:10:\"error_logs\";i:10;s:10:\"extensions\";i:11;s:13:\"image_manager\";i:12;s:9:\"languages\";i:13;s:7:\"layouts\";i:14;s:9:\"locations\";i:15;s:14:\"mail_templates\";i:16;s:12:\"menu_options\";i:17;s:5:\"menus\";i:18;s:8:\"messages\";i:19;s:6:\"orders\";i:20;s:5:\"pages\";i:21;s:8:\"payments\";i:22;s:7:\"ratings\";i:23;s:12:\"reservations\";i:24;s:7:\"reviews\";i:25;s:18:\"security_questions\";i:26;s:8:\"settings\";i:27;s:12:\"staff_groups\";i:28;s:6:\"staffs\";i:29;s:8:\"statuses\";i:30;s:6:\"tables\";i:31;s:6:\"themes\";i:32;s:10:\"uri_routes\";i:33;s:14:\"account_module\";i:34;s:14:\"banners_module\";i:35;s:11:\"cart_module\";i:36;s:17:\"categories_module\";i:37;s:12:\"local_module\";i:38;s:12:\"pages_module\";i:39;s:18:\"reservation_module\";i:40;s:9:\"slideshow\";i:41;s:3:\"cod\";i:42;s:14:\"paypal_express\";}s:6:\"modify\";a:43:{i:0;s:7:\"banners\";i:1;s:10:\"categories\";i:2;s:9:\"countries\";i:3;s:7:\"coupons\";i:4;s:10:\"currencies\";i:5;s:15:\"customer_groups\";i:6;s:9:\"customers\";i:7;s:18:\"customers_activity\";i:8;s:8:\"database\";i:9;s:10:\"error_logs\";i:10;s:10:\"extensions\";i:11;s:13:\"image_manager\";i:12;s:9:\"languages\";i:13;s:7:\"layouts\";i:14;s:9:\"locations\";i:15;s:14:\"mail_templates\";i:16;s:12:\"menu_options\";i:17;s:5:\"menus\";i:18;s:8:\"messages\";i:19;s:6:\"orders\";i:20;s:5:\"pages\";i:21;s:8:\"payments\";i:22;s:7:\"ratings\";i:23;s:12:\"reservations\";i:24;s:7:\"reviews\";i:25;s:18:\"security_questions\";i:26;s:8:\"settings\";i:27;s:12:\"staff_groups\";i:28;s:6:\"staffs\";i:29;s:8:\"statuses\";i:30;s:6:\"tables\";i:31;s:6:\"themes\";i:32;s:10:\"uri_routes\";i:33;s:14:\"account_module\";i:34;s:14:\"banners_module\";i:35;s:11:\"cart_module\";i:36;s:17:\"categories_module\";i:37;s:12:\"local_module\";i:38;s:12:\"pages_module\";i:39;s:18:\"reservation_module\";i:40;s:9:\"slideshow\";i:41;s:3:\"cod\";i:42;s:14:\"paypal_express\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permission`) VALUES ('12', 'Super Access', '0', 'a:2:{s:6:\"access\";a:40:{i:0;s:7:\"banners\";i:1;s:10:\"categories\";i:2;s:9:\"countries\";i:3;s:7:\"coupons\";i:4;s:10:\"currencies\";i:5;s:15:\"customer_groups\";i:6;s:9:\"customers\";i:7;s:18:\"customers_activity\";i:8;s:8:\"database\";i:9;s:10:\"error_logs\";i:10;s:10:\"extensions\";i:11;s:13:\"image_manager\";i:12;s:9:\"languages\";i:13;s:7:\"layouts\";i:14;s:9:\"locations\";i:15;s:14:\"mail_templates\";i:16;s:12:\"menu_options\";i:17;s:5:\"menus\";i:18;s:8:\"messages\";i:19;s:6:\"orders\";i:20;s:5:\"pages\";i:21;s:8:\"payments\";i:22;s:7:\"ratings\";i:23;s:12:\"reservations\";i:24;s:7:\"reviews\";i:25;s:18:\"security_questions\";i:26;s:8:\"settings\";i:27;s:12:\"staff_groups\";i:28;s:6:\"staffs\";i:29;s:8:\"statuses\";i:30;s:6:\"tables\";i:31;s:6:\"themes\";i:32;s:10:\"uri_routes\";i:33;s:14:\"account_module\";i:34;s:11:\"cart_module\";i:35;s:17:\"categories_module\";i:36;s:12:\"local_module\";i:37;s:12:\"pages_module\";i:38;s:3:\"cod\";i:39;s:14:\"paypal_express\";}s:6:\"modify\";a:1:{i:0;s:17:\"categories_module\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permission`) VALUES ('13', 'Super Modify', '0', 'a:1:{s:6:\"modify\";a:43:{i:0;s:7:\"banners\";i:1;s:10:\"categories\";i:2;s:9:\"countries\";i:3;s:7:\"coupons\";i:4;s:10:\"currencies\";i:5;s:15:\"customer_groups\";i:6;s:9:\"customers\";i:7;s:18:\"customers_activity\";i:8;s:8:\"database\";i:9;s:10:\"error_logs\";i:10;s:10:\"extensions\";i:11;s:13:\"image_manager\";i:12;s:9:\"languages\";i:13;s:7:\"layouts\";i:14;s:9:\"locations\";i:15;s:14:\"mail_templates\";i:16;s:12:\"menu_options\";i:17;s:5:\"menus\";i:18;s:8:\"messages\";i:19;s:6:\"orders\";i:20;s:5:\"pages\";i:21;s:8:\"payments\";i:22;s:7:\"ratings\";i:23;s:12:\"reservations\";i:24;s:7:\"reviews\";i:25;s:18:\"security_questions\";i:26;s:8:\"settings\";i:27;s:12:\"staff_groups\";i:28;s:6:\"staffs\";i:29;s:8:\"statuses\";i:30;s:6:\"tables\";i:31;s:6:\"themes\";i:32;s:10:\"uri_routes\";i:33;s:14:\"account_module\";i:34;s:7:\"banners\";i:35;s:11:\"cart_module\";i:36;s:17:\"categories_module\";i:37;s:12:\"local_module\";i:38;s:12:\"pages_module\";i:39;s:18:\"reservation_module\";i:40;s:9:\"slideshow\";i:41;s:3:\"cod\";i:42;s:14:\"paypal_express\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permission`) VALUES ('14', 'Dummy', '0', 'a:1:{i:0;s:5:\"EMPTY\";}');


#
# TABLE STRUCTURE FOR: ti_staffs
#

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `ti_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_group_id`, `staff_location_id`, `timezone`, `language_id`, `date_added`, `staff_status`) VALUES ('12', 'Iana', 'sampoyigi@gmail.com', '12', '0', '0', '0', '2015-04-22', '1');
INSERT INTO `ti_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_group_id`, `staff_location_id`, `timezone`, `language_id`, `date_added`, `staff_status`) VALUES ('14', 'Admin', 'info@tastyigniter.com', '11', '0', '', '0', '2015-05-07', '1');


#
# TABLE STRUCTURE FOR: ti_status_history
#

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('11', '2641', '11', '0', '11', '0', 'order', 'Your order has been received.', '2014-06-27 09:33:49');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('12', '2445', '11', '0', '16', '0', 'reserve', 'Your table reservation has been confirmed.', '2014-06-27 09:40:03');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('13', '2446', '11', '0', '16', '0', 'reserve', 'Your table reservation has been confirmed.', '2014-06-27 09:41:38');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('14', '2446', '11', '11', '17', '0', 'reserve', 'Your table reservation has been canceled.', '2014-06-27 09:50:49');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('15', '20011', '0', '0', '16', '1', 'reserve', '', '2014-06-27 10:45:05');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('16', '2645', '0', '0', '1', '1', 'order', '', '2014-07-14 16:47:14');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('17', '2646', '0', '0', '1', '1', 'order', '', '2014-07-14 18:42:58');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('18', '2647', '0', '0', '1', '1', 'order', '', '2014-07-14 18:49:59');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('19', '2648', '0', '0', '1', '1', 'order', '', '2014-07-14 19:07:24');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('20', '2648', '0', '0', '1', '1', 'order', '', '2014-07-14 19:10:42');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('21', '2648', '0', '0', '1', '1', 'order', '', '2014-07-14 19:43:30');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('22', '2649', '0', '0', '1', '1', 'order', '', '2014-07-14 19:45:22');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('23', '2650', '0', '0', '1', '1', 'order', '', '2014-07-20 14:00:03');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('24', '2651', '0', '0', '1', '1', 'order', '', '2014-07-20 14:09:52');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('25', '2652', '0', '0', '11', '1', 'order', 'Your order has been received.', '2014-07-20 14:20:22');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('26', '2653', '0', '0', '11', '1', 'order', 'Your order has been received.', '2014-07-21 01:03:20');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('27', '2653', '12', '0', '14', '0', 'order', 'Your order will be with you shortly.', '2014-07-21 01:04:18');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('28', '2651', '12', '0', '11', '0', 'order', 'Your order has been received.', '2014-07-22 22:50:37');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('29', '2654', '0', '0', '11', '1', 'order', 'Your order has been received.', '2014-08-03 02:20:04');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('30', '2650', '12', '0', '15', '1', 'order', '', '2014-08-04 00:43:32');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('31', '2655', '0', '0', '11', '1', 'order', 'Your order has been received.', '2014-10-08 14:44:26');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('32', '2655', '12', '0', '14', '1', 'order', 'Your order will be with you shortly.', '2014-10-08 14:45:49');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('33', '2446', '11', '11', '17', '0', 'reserve', 'Your table reservation has been canceled.', '2015-03-29 19:59:21');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('34', '2446', '11', '11', '18', '0', 'reserve', 'Your table reservation is pending.', '2015-04-01 15:41:22');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('35', '2445', '11', '0', '18', '0', 'reserve', 'Your table reservation is pending.', '2015-04-01 15:41:40');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('36', '2650', '11', '11', '13', '1', 'order', 'Your order is in the kitchen', '2015-04-05 23:19:43');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('37', '2650', '11', '11', '19', '0', 'order', '', '2015-04-08 23:17:46');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('38', '2656', '0', '0', '0', '1', 'order', '', '2015-04-12 22:32:23');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('39', '2657', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-01 02:13:15');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('40', '2666', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 10:11:56');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('41', '2668', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 21:11:37');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('42', '2669', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 21:12:21');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('43', '2670', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 21:17:25');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('44', '2671', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 21:18:43');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('45', '2672', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 21:19:29');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('46', '2681', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 21:38:28');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('47', '2682', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 21:45:59');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('48', '2686', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:20:26');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('49', '2687', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:21:34');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('50', '2688', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:24:45');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('51', '2689', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:25:28');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('52', '2690', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:26:16');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('53', '2691', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:34:06');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('54', '2692', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:34:46');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('55', '2693', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:34:57');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('56', '2694', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:35:21');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('57', '2695', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:36:37');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('58', '2696', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:37:26');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('59', '2697', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 22:51:32');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('60', '2698', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 23:20:40');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('61', '2706', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-09 23:37:14');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('62', '2712', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 00:11:22');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('63', '2716', '0', '0', '0', '0', 'order', '', '2015-05-10 01:42:45');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('64', '2716', '0', '0', '0', '0', 'order', '', '2015-05-10 01:44:23');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('65', '2717', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 01:46:25');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('66', '2718', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 02:35:41');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('67', '2719', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 14:19:36');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('68', '2720', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 16:27:46');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('69', '2722', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 16:38:30');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('70', '2723', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 22:47:33');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('71', '2724', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-10 22:58:59');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('72', '2725', '0', '0', '11', '1', 'order', 'Your order has been received.', '2015-05-11 09:45:27');


#
# TABLE STRUCTURE FOR: ti_statuses
#

DROP TABLE IF EXISTS `ti_statuses`;

CREATE TABLE `ti_statuses` (
  `status_id` int(15) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) NOT NULL,
  `status_comment` text NOT NULL,
  `notify_customer` tinyint(1) NOT NULL,
  `status_for` varchar(10) NOT NULL,
  `status_color` varchar(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('11', 'Received', 'Your order has been received.', '1', 'order', '#686663');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('12', 'Pending', 'Your order is pending', '1', 'order', '#f0ad4e');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('13', 'Preparation', 'Your order is in the kitchen', '1', 'order', '#00c0ef');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('14', 'Delivery', 'Your order will be with you shortly.', '0', 'order', '#00a65a');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('15', 'Completed', '', '0', 'order', '#00a65a');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('16', 'Confirmed', 'Your table reservation has been confirmed.', '0', 'reserve', '#00a65a');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('17', 'Canceled', 'Your table reservation has been canceled.', '0', 'reserve', '#dd4b39');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('18', 'Pending', 'Your table reservation is pending.', '0', 'reserve', '');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`, `status_color`) VALUES ('19', 'Canceled', '', '0', 'order', '#ea0b29');


#
# TABLE STRUCTURE FOR: ti_tables
#

DROP TABLE IF EXISTS `ti_tables`;

CREATE TABLE `ti_tables` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(32) NOT NULL,
  `min_capacity` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `table_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('2', 'NN02', '2', '2', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('6', 'SW77', '10', '40', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('7', 'EW77', '6', '8', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('8', 'SE78', '4', '6', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('9', 'NE8', '8', '10', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('10', 'SW55', '9', '10', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('11', 'EW88', '2', '10', '0');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('12', 'EE732', '2', '8', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('14', 'FW79', '4', '10', '0');


#
# TABLE STRUCTURE FOR: ti_uri_routes
#

DROP TABLE IF EXISTS `ti_uri_routes`;

CREATE TABLE `ti_uri_routes` (
  `uri_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `uri_route` varchar(255) NOT NULL,
  `controller` varchar(128) NOT NULL,
  `priority` tinyint(11) NOT NULL,
  PRIMARY KEY (`uri_route_id`,`uri_route`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('1', 'locations', 'local/locations', '1');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('2', 'account', 'account/account', '2');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('3', '(:any)', 'pages', '3');


#
# TABLE STRUCTURE FOR: ti_users
#

DROP TABLE IF EXISTS `ti_users`;

CREATE TABLE `ti_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  PRIMARY KEY (`user_id`,`staff_id`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES ('12', '12', 'iana', '390af0f8fbebe68f316f63cf30cad24c443ae71d', '248826ae2');
INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES ('14', '14', 'tastyadmin', 'de971c954605610cfd2ecf7ef12872566df25325', '7699e31b0');


#
# TABLE STRUCTURE FOR: ti_working_hours
#

DROP TABLE IF EXISTS `ti_working_hours`;

CREATE TABLE `ti_working_hours` (
  `location_id` int(11) NOT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time NOT NULL DEFAULT '00:00:00',
  `closing_time` time NOT NULL DEFAULT '00:00:00',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`location_id`,`weekday`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('115', '0', '09:00:00', '17:00:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('115', '1', '09:00:00', '17:00:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('115', '2', '09:00:00', '17:00:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('115', '3', '09:00:00', '17:00:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('115', '4', '09:00:00', '17:00:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('115', '5', '09:00:00', '17:00:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('115', '6', '09:00:00', '17:00:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('117', '0', '09:00:00', '23:45:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('117', '1', '09:00:00', '23:45:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('117', '2', '09:00:00', '23:45:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('117', '3', '09:00:00', '23:45:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('117', '4', '09:00:00', '23:45:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('117', '5', '09:00:00', '23:45:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('117', '6', '09:00:00', '23:45:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('118', '0', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('118', '1', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('118', '2', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('118', '3', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('118', '4', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('118', '5', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('118', '6', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('120', '0', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('120', '1', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('120', '2', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('120', '3', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('120', '4', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('120', '5', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('120', '6', '00:00:00', '23:59:00', '0');


