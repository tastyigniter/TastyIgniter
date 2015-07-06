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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('1', '0', '5 Paragon Rd', '', 'London', '', 'SE9 7AE', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('2', '1', '5 Paragon Rd', '', 'London', '', 'E9 7AE', '222');


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `ti_banners` (`banner_id`, `name`, `type`, `click_url`, `language_id`, `alt_text`, `image_code`, `custom_code`, `status`) VALUES ('1', 'jbottega veneta', 'custom', 'menus', '11', 'I love cheesecake', 'a:1:{s:5:\"paths\";a:3:{i:0;s:14:\"data/pesto.jpg\";i:1;s:20:\"data/pounded_yam.jpg\";i:2;s:18:\"data/puff_puff.jpg\";}}', '<img src=\"http://tastyigniter.remote/assets/images/thumbs/pesto-200x200.jpg\" alt=\"I love cheesecake\" class=\"img-responsive\">', '1');


#
# TABLE STRUCTURE FOR: ti_categories
#

DROP TABLE IF EXISTS `ti_categories`;

CREATE TABLE `ti_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `ti_coupons_history` (`coupon_history_id`, `coupon_id`, `order_id`, `customer_id`, `code`, `min_total`, `amount`, `date_used`) VALUES ('1', '15', '20003', '1', '5555', '0.00', '-5000.00', '2015-05-26 14:06:01');


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`) VALUES ('1', 'Sam', 'Poyigi', 'sampoyigi@gmail.com', 'db4d62f5e619873e54c366c831d405e2c778da6d', '3b596eb24', '4883930902', '2', '16', 'Shokenu', '1', '11', '127.0.0.1', '2015-05-24 00:00:00', '1');


#
# TABLE STRUCTURE FOR: ti_customers_online
#

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
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('11', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', 'admin/customers_online?filter_type=all', '2015-05-24 11:56:21', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('12', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', '', '2015-05-24 11:59:39', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('13', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', '', '2015-05-24 12:01:56', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('14', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'reserve', 'menus', '2015-05-24 12:05:34', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('15', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'reserve', '2015-05-24 12:10:07', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('16', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'local', 'menus', '2015-05-24 12:13:56', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('17', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 12:17:37', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('18', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 12:20:08', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('19', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'favicon.ico', '', '2015-05-24 13:42:54', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('20', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 14:33:17', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('21', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 14:43:17', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('22', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 15:22:10', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('23', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 16:30:57', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('24', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 16:38:11', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('25', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 16:40:45', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('26', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 17:13:41', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('27', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout', '2015-05-24 17:17:09', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('28', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout', '2015-05-24 17:22:15', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('29', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout', '2015-05-24 17:28:10', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('30', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout', '2015-05-24 17:37:45', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('31', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout', '2015-05-24 17:42:03', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('32', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout', '2015-05-24 17:53:53', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('33', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', '', '2015-05-24 17:56:31', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('34', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'checkout', '2015-05-24 17:59:12', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('35', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'account/login', '2015-05-24 18:05:41', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('36', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-24 18:12:14', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('37', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', '', '2015-05-24 18:22:39', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('38', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'checkout', '2015-05-24 18:27:20', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('39', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'checkout', '2015-05-24 18:29:37', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('40', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'checkout', '2015-05-24 18:33:52', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('41', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'checkout', '2015-05-24 18:35:58', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('42', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', '', '2015-05-24 18:40:46', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('43', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'checkout', '2015-05-24 18:45:13', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('44', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout/success', '2015-05-24 18:54:38', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('45', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'checkout/success', '2015-05-24 19:05:41', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('46', '1', 'browser', 'Firefox', '127.0.0.1', '0', '', 'about-us', '2015-05-24 19:14:13', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('47', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'contact', '', '2015-05-24 19:34:55', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('48', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', 'contact', '2015-05-25 02:21:35', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('49', '1', 'browser', 'Firefox', '127.0.0.1', '0', '', 'menus', '2015-05-25 11:38:40', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('50', '1', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-05-25 11:41:35', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('51', '1', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-05-25 11:52:09', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('52', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'reserve', 'menus', '2015-05-25 12:17:59', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('53', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-05-25 17:23:28', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('54', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-05-25 17:38:45', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('55', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-05-25 19:07:28', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('56', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account', 'reserve', '2015-05-25 20:27:07', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('57', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox', 'account', '2015-05-26 13:35:00', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('58', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox', 'account/inbox', '2015-05-26 13:37:49', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('59', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox/view/43', 'account/inbox', '2015-05-26 13:40:03', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('60', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox/view/44', 'account/inbox', '2015-05-26 13:42:37', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('61', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox', 'account/inbox/view/44', '2015-05-26 13:44:42', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('62', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox', 'account/inbox/view/44', '2015-05-26 13:47:46', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('63', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/reviews', 'account/reviews/add/order/20002/11', '2015-05-26 13:52:33', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('64', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/orders', 'account/reviews', '2015-05-26 14:05:15', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('65', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/reservations', 'account/reviews', '2015-05-26 14:07:19', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('66', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'checkout', 'menus', '2015-05-26 15:58:03', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('67', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'locations', 'local/reviews', '2015-05-26 16:07:26', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('68', '1', 'browser', 'Firefox', '127.0.0.1', '0', '', 'locations', '2015-05-27 21:33:25', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('69', '1', 'browser', 'Firefox', '127.0.0.1', '0', '', 'locations', '2015-05-28 22:28:47', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('70', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'favicon.ico', '', '2015-05-28 22:42:52', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('71', '1', 'browser', 'Firefox', '127.0.0.1', '0', '', 'setup/setup', '2015-05-31 13:02:36', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('72', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 01:03:08', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('73', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 01:46:46', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('74', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 01:49:17', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('75', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 01:51:30', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('76', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 02:15:11', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('77', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 02:20:33', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('78', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 02:24:55', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('79', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 02:31:37', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('80', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 02:34:07', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('81', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 02:36:28', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('82', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 11:37:12', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('83', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 11:59:44', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('84', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 12:08:08', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('85', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 12:12:42', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('86', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 12:28:56', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('87', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 12:32:20', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('88', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 14:13:07', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('89', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 14:34:21', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('90', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 14:41:03', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('91', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 15:26:48', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('92', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 15:32:53', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('93', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', '', '2015-06-02 15:57:07', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('94', '0', 'browser', 'Chrome', '127.0.0.1', '0', '', '', '2015-06-02 15:59:36', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('95', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', 'admin/customers_online', '2015-06-02 16:07:06', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('96', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'categories_module/categories_module', '', '2015-06-02 18:07:09', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('97', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-06-02 19:45:26', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('98', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-06-02 19:50:22', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('99', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-06-02 20:01:00', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('100', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-06-02 20:35:07', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('101', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-06-02 21:14:41', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('102', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', '', '2015-06-02 21:38:16', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('103', '0', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', '', '2015-06-02 21:50:08', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('104', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox', '', '2015-06-02 21:52:17', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('105', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox', '', '2015-06-02 22:18:22', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('106', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'account/inbox', '', '2015-06-02 23:34:00', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('107', '1', 'browser', 'Firefox', '127.0.0.1', '0', 'menus', '', '2015-06-03 00:11:13', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('108', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', 'admin/extensions/edit?action=edit&name=account_module', '2015-06-03 00:38:34', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('109', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', 'admin/extensions/edit?action=edit&name=slideshow', '2015-06-03 01:10:33', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('110', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', 'admin/extensions/edit?action=edit&name=account_module', '2015-06-03 01:14:56', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('111', '0', 'browser', 'Chrome', '127.0.0.1', '0', '', 'admin/tables', '2015-06-03 03:30:19', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('112', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', 'admin/currencies', '2015-06-03 11:18:46', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('113', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', 'admin/currencies', '2015-06-03 11:21:05', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('114', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'favicon.ico', 'admin/database', '2015-06-03 13:20:46', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('115', '0', 'browser', 'Chrome', '127.0.0.1', '0', 'reserve', 'menus', '2015-06-03 20:58:19', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.18 Safari/537.36');
INSERT INTO `ti_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES ('116', '0', 'browser', 'Firefox', '127.0.0.1', '0', '', 'admin/notifications', '2015-06-04 01:34:40', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0');


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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('11', 'module', 'account_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"11\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Account');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('12', 'module', 'local_module', 'a:1:{s:7:\"layouts\";N;}', '1', '1', 'Local');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('13', 'module', 'categories_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Categories');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('14', 'module', 'cart_module', 'a:3:{s:16:\"show_cart_images\";s:1:\"0\";s:13:\"cart_images_h\";s:3:\"120\";s:13:\"cart_images_w\";s:3:\"120\";}', '1', '1', 'Cart');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('15', 'module', 'reservation_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"16\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Reservation');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('16', 'module', 'slideshow', 'a:6:{s:11:\"dimension_h\";s:3:\"420\";s:11:\"dimension_w\";s:4:\"1170\";s:6:\"effect\";s:4:\"fade\";s:5:\"speed\";s:3:\"500\";s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"15\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}s:6:\"slides\";a:3:{i:0;a:3:{s:4:\"name\";s:9:\"slide.png\";s:9:\"image_src\";s:14:\"data/slide.jpg\";s:7:\"caption\";s:0:\"\";}i:1;a:3:{s:4:\"name\";s:10:\"slide1.png\";s:9:\"image_src\";s:15:\"data/slide1.jpg\";s:7:\"caption\";s:0:\"\";}i:2;a:3:{s:4:\"name\";s:10:\"slide2.png\";s:9:\"image_src\";s:15:\"data/slide2.jpg\";s:7:\"caption\";s:0:\"\";}}}', '1', '1', 'Slideshow');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('18', 'payment', 'cod', 'a:5:{s:4:\"name\";N;s:11:\"order_total\";s:7:\"1000.00\";s:12:\"order_status\";s:2:\"11\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}', '1', '1', 'Cash On Delivery');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('20', 'module', 'pages_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"17\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1', '1', 'Pages');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('21', 'payment', 'paypal_express', 'a:11:{s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:8:\"api_mode\";s:7:\"sandbox\";s:8:\"api_user\";s:39:\"samadepoyigi-facilitator_api1.gmail.com\";s:8:\"api_pass\";s:10:\"1381080165\";s:13:\"api_signature\";s:56:\"AFcWxV21C7fd0v3bYYYRCpSSRl31AYzY6RzJVWuquyjw.VYZbV7LatXv\";s:10:\"api_action\";s:4:\"sale\";s:10:\"return_uri\";s:24:\"paypal_express/authorize\";s:10:\"cancel_uri\";s:21:\"paypal_express/cancel\";s:11:\"order_total\";s:4:\"0.00\";s:12:\"order_status\";s:2:\"11\";}', '1', '1', 'PayPal Express');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('23', 'theme', 'tastyigniter-orange', 'a:13:{s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"25\";s:19:\"logo_padding_bottom\";s:2:\"25\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#fdeae2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#333333\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#ffffff\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#428bca\";s:5:\"hover\";s:7:\"#2a6496\";}s:6:\"button\";a:4:{s:7:\"default\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:6:\"border\";s:7:\"#cccccc\";}s:7:\"primary\";a:2:{s:10:\"background\";s:7:\"#428bca\";s:6:\"border\";s:7:\"#357ebd\";}s:7:\"success\";a:2:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";}s:6:\"danger\";a:2:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";}}s:10:\"custom_css\";s:0:\"\";}', '1', '1', 'TastyIgniter Orange');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('24', 'theme', 'tastyigniter-blue', '', '1', '0', 'TastyIgniter Blue');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`) VALUES ('25', 'module', 'banners_module', 'a:1:{s:7:\"banners\";a:1:{i:1;a:3:{s:9:\"banner_id\";s:1:\"1\";s:5:\"width\";s:3:\"200\";s:6:\"height\";s:3:\"200\";}}}', '1', '1', 'Banners');


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
  `module_code` varchar(128) NOT NULL,
  `position` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`layout_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('9', '13', 'local_module', 'top', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('10', '13', 'cart_module', 'right', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('11', '15', 'slideshow', 'top', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('14', '18', 'local_module', 'top', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('15', '16', 'reservation_module', 'left', '0', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('19', '17', 'pages_module', 'right', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('24', '11', 'account_module', 'left', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('32', '12', 'local_module', 'top', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('33', '12', 'categories_module', 'left', '1', '1');
INSERT INTO `ti_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `position`, `priority`, `status`) VALUES ('34', '12', 'cart_module', 'right', '2', '1');


#
# TABLE STRUCTURE FOR: ti_layout_routes
#

DROP TABLE IF EXISTS `ti_layout_routes`;

CREATE TABLE `ti_layout_routes` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `uri_route` varchar(128) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('18', '14', 'payments');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('19', '13', 'checkout');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('20', '15', 'home');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('22', '17', 'pages/page/(:num)');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('23', '17', 'pages');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('29', '18', 'local');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('30', '18', 'local/reviews');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('36', '11', 'account/inbox');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('37', '11', 'account/orders');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('38', '11', 'account/address');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('39', '11', 'account/details');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('40', '11', 'account');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('41', '16', 'reserve');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('44', '12', 'menus');


#
# TABLE STRUCTURE FOR: ti_layouts
#

DROP TABLE IF EXISTS `ti_layouts`;

CREATE TABLE `ti_layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('11', 'Account');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('12', 'Menus');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('13', 'Checkout');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('14', 'Payments');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_interval`, `reservation_turn`, `location_status`, `collection_time`, `options`) VALUES ('11', 'Lewisham', 'lewisham@tastyigniter.com', '', '44 Darnley Road', '', 'Greater London', '', 'E9 6QH', '1', '1203392202', '51.544060', '-0.053999', '0', '1', '1', '0', '0', '0', '0', '1', '0', 'a:2:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}s:14:\"delivery_areas\";a:4:{i:1;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"_yryHzpHff@??d~@gf@?\"}]\";s:8:\"vertices\";s:213:\"[{\"lat\":51.54720410349442,\"lng\":-0.04894346111586856},{\"lat\":51.54091589650558,\"lng\":-0.04894346111586856},{\"lat\":51.54091589650558,\"lng\":-0.05905453888408374},{\"lat\":51.54720410349442,\"lng\":-0.05905453888408374}]\";s:6:\"circle\";s:71:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}i:2;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"kvtyHrfJrmA??j}BsmA?\"}]\";s:8:\"vertices\";s:213:\"[{\"lat\":51.55701919438532,\"lng\":-0.05753500165019432},{\"lat\":51.54444462450928,\"lng\":-0.05753500165019432},{\"lat\":51.54444462450928,\"lng\":-0.07775715728530486},{\"lat\":51.55701919438532,\"lng\":-0.07775715728530486}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":1000}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 2\";s:6:\"charge\";s:1:\"4\";s:10:\"min_amount\";s:2:\"10\";}i:3;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"kvuyH`dBztB??r|D{tB?\"}]\";s:8:\"vertices\";s:211:\"[{\"lat\":51.56213712495005,\"lng\":-0.0161730813927079},{\"lat\":51.543276088888334,\"lng\":-0.0161730813927079},{\"lat\":51.543276088888334,\"lng\":-0.0465063150916194},{\"lat\":51.56213712495005,\"lng\":-0.0465063150916194}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":1500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 3\";s:6:\"charge\";s:2:\"30\";s:10:\"min_amount\";s:3:\"300\";}i:4;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"gmqyHlhEf|C??x{Fg|C?\"}]\";s:8:\"vertices\";s:215:\"[{\"lat\":51.540197198060916,\"lng\":-0.032231891578248906},{\"lat\":51.5150352815208,\"lng\":-0.032231891578248906},{\"lat\":51.5150352815208,\"lng\":-0.07267620363654714},{\"lat\":51.540197198060916,\"lng\":-0.07267620363654714}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":2000}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 4\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"200\";}}}');


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

INSERT INTO `ti_mail_templates` (`template_id`, `name`, `language_id`, `date_added`, `date_updated`, `status`) VALUES ('11', 'Default', '1', '2014-04-16 01:49:52', '2014-06-16 14:44:13', '1');


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
  `subtract_stock` tinyint(4) NOT NULL,
  PRIMARY KEY (`menu_option_value_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('52', '25', '84', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('53', '25', '84', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('54', '25', '84', '22', '11', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('55', '26', '79', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('56', '26', '79', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('57', '26', '79', '22', '10', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('58', '26', '79', '22', '11', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('59', '26', '79', '22', '12', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('60', '27', '79', '24', '13', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('61', '27', '79', '24', '14', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('62', '28', '78', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('63', '28', '78', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('64', '28', '78', '22', '10', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('65', '28', '78', '22', '11', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('66', '28', '78', '22', '12', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('67', '22', '85', '22', '8', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('68', '22', '85', '22', '9', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('69', '22', '85', '22', '10', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('70', '24', '85', '24', '13', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('71', '24', '85', '24', '14', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('72', '23', '81', '23', '7', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('73', '23', '81', '23', '6', '0.00', '0', '0');
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES ('74', '23', '81', '23', '15', '0.00', '0', '0');


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
INSERT INTO `ti_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `option_values`) VALUES ('23', '23', '81', '0', 'a:3:{i:1;a:3:{s:15:\"option_value_id\";s:1:\"7\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:2;a:3:{s:15:\"option_value_id\";s:1:\"6\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}i:3;a:3:{s:15:\"option_value_id\";s:2:\"15\";s:5:\"price\";s:0:\"\";s:20:\"menu_option_value_id\";s:0:\"\";}}');
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

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('76', 'PUFF-PUFF', 'Traditional Nigerian donut ball, rolled in sugar', '4.99', 'data/puff_puff.jpg', '15', '796', '3', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('77', 'SCOTCH EGG', 'Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.', '2.00', 'data/scotch_egg.jpg', '15', '0', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('78', 'ATA RICE', 'Small pieces of beef, goat, stipe, and tendon sautéed in crushed green Jamaican pepper.', '12.00', 'data/Seared_Ahi_Spinach_Salad.jpg', '16', '1000', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('79', 'RICE AND DODO', '(plantains) w/chicken, fish, beef or goat', '11.99', 'data/rice_and_dodo.jpg', '16', '651', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('80', 'Special Shrimp Deluxe', 'Fresh shrimp sautéed in blended mixture of tomatoes, onion, peppers over choice of rice', '12.99', 'data/deluxe_bbq_shrimp-1.jpg', '18', '265', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('81', 'Whole catfish with rice and vegetables', 'Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste', '13.99', 'data/FriedWholeCatfishPlate_lg.jpg', '24', '145', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('82', 'African Salad', 'With baked beans, egg, tuna, onion, tomatoes , green peas and carrot with your choice of dressing.', '8.99', '', '17', '500', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('83', 'Seafood Salad', 'With shrimp, egg and imitation crab meat', '5.99', 'data/seafoods_salad.JPG', '17', '490', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('84', 'EBA', 'Grated cassava', '11.99', 'data/eba.jpg', '16', '407', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('85', 'AMALA', 'Yam flour', '11.99', 'data/DSCF3711.JPG', '19', '470', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('86', 'YAM PORRIDGE', 'in tomatoes sauce', '9.99', 'data/yam_porridge.jpg', '20', '457', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('87', 'Boiled Plantain', 'w/spinach soup', '9.99', 'data/pesto.jpg', '19', '434', '1', '1', '1');


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
# TABLE STRUCTURE FOR: ti_message_recipients
#

DROP TABLE IF EXISTS `ti_message_recipients`;

CREATE TABLE `ti_message_recipients` (
  `message_recipient_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `key` varchar(32) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`message_recipient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('28', '41', '0', '1', 'customer_email', 'sampoyigi@gmail.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('29', '39', '1', '0', 'staff_id', '12');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('30', '40', '0', '1', 'staff_id', '11');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('31', '40', '1', '0', 'staff_id', '12');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('32', '43', '1', '1', 'customer_id', '1');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('33', '44', '1', '1', 'customer_id', '1');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('34', '45', '0', '1', 'customer_email', 'sampoyigi@gmail.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('35', '46', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('36', '46', '0', '1', 'staff_email', 'iana@iana.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('37', '47', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('38', '47', '0', '1', 'staff_email', 'iana@iana.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('39', '48', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('40', '49', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('41', '49', '0', '1', 'staff_email', 'iana@iana.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('42', '50', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('43', '50', '0', '1', 'staff_email', 'iana@iana.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('44', '51', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('45', '51', '0', '1', 'staff_email', 'iana@iana.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('46', '52', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('47', '52', '0', '1', 'staff_email', 'iana@iana.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('48', '53', '0', '1', 'staff_email', 'info@tastyigniter.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('49', '53', '0', '1', 'staff_email', 'iana@iana.com');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('50', '54', '1', '0', 'staff_id', '11');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('51', '54', '0', '1', 'staff_id', '12');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('52', '55', '0', '1', 'staff_id', '11');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('53', '56', '1', '0', 'staff_id', '11');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('54', '56', '0', '1', 'staff_id', '12');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('55', '57', '0', '1', 'staff_id', '11');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('56', '57', '1', '0', 'staff_id', '12');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('57', '58', '0', '1', 'staff_id', '11');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('58', '58', '0', '1', 'staff_id', '12');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('59', '59', '0', '1', 'staff_id', '11');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('60', '59', '0', '1', 'staff_id', '12');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('61', '60', '0', '1', 'customer_id', '1');
INSERT INTO `ti_message_recipients` (`message_recipient_id`, `message_id`, `state`, `status`, `key`, `value`) VALUES ('62', '61', '0', '1', 'staff_id', '13');


#
# TABLE STRUCTURE FOR: ti_messages
#

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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('28', '11', '2015-05-25 17:15:59', 'email', 'customer_group', 'Aliquam erat volutpat.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('29', '11', '2015-05-25 17:18:09', 'email', 'customer_group', 'Aliquam erat volutpat.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('30', '11', '2015-05-25 17:19:30', 'email', 'customer_group', 'Aliquam erat volutpat.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('31', '11', '2015-05-25 17:20:49', 'email', 'all_staffs', 'Aliquam erat volutpat.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('32', '11', '2015-05-25 17:21:00', 'email', 'all_staffs', 'Nullam at hendrerit orci', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('33', '11', '2015-05-25 17:21:10', 'email', 'all_staffs', 'Fusce quis condimentum quam', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut nibh varius ultricies. Ut sed lorem non odio volutpat malesuada. Ut in erat porttitor, posuere mi vitae, suscipit ex. Ut tempus elit at urna molestie luctus. Etiam ac laoreet elit, vel condimentum arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam in mauris sit amet justo gravida tempor sed a augue. Sed accumsan elementum viverra. Etiam feugiat est ut sapien feugiat facilisis. Sed tempor diam est, vitae ultrices erat ultrices id. Integer egestas dolor sem. Fusce rhoncus nisi eget purus commodo, nec consequat orci pellentesque. Nullam at hendrerit orci, sit amet hendrerit leo. Proin rutrum feugiat auctor. Ut eu massa quis leo tincidunt scelerisque.</p>\r\n<p>&nbsp;</p>\r\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent luctus urna vitae sagittis ultricies. Sed imperdiet vulputate justo, quis ullamcorper urna fringilla sit amet. Donec eleifend vitae augue eget laoreet. Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('34', '11', '2015-05-25 18:18:31', 'account', 'all_staffs', 'Aenean quis consequat erat.', '<p>Aenean quis consequat erat. Nulla dictum iaculis pretium. Phasellus vel metus nec massa aliquam dapibus. Ut blandit arcu quam, nec posuere tortor vehicula id. Phasellus feugiat turpis urna, in fermentum tortor tristique in. Integer a dictum enim. Duis iaculis ullamcorper massa vel lacinia. Fusce quis condimentum quam. Quisque ut facilisis quam.</p>\r\n<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec quis sem ac leo ultrices bibendum. Donec gravida, massa sed condimentum imperdiet, nisi turpis lobortis nunc, nec rhoncus metus nunc et magna. Aliquam at leo sit amet leo ullamcorper ullamcorper vel a urna. Sed quis pulvinar metus, feugiat suscipit lorem. Donec sodales nunc sit amet efficitur hendrerit. Quisque nunc est, tempor a viverra ac, eleifend vitae nisl. Proin libero nibh, auctor vitae magna eget, ornare lacinia arcu. Phasellus ultricies blandit urna, vitae tincidunt ante imperdiet non. Ut eget ornare neque. Duis feugiat dictum facilisis. Vivamus tristique tellus sit amet nunc tempus mattis. Suspendisse aliquam odio justo, in posuere sapien cursus ac.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('35', '11', '2015-05-25 18:21:07', 'account', 'all_staffs', 'Quisque molestie fringilla porta.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('36', '11', '2015-05-25 18:22:35', 'account', 'all_staffs', 'Quisque molestie fringilla porta.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '0');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('37', '11', '2015-05-28 23:01:56', 'email', 'staffs', 'Quisque molestie fringilla porta.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '0');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('38', '11', '2015-05-25 18:51:27', 'account', 'all_newsletters', 'Quisque molestie fringilla porta.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('39', '11', '2015-05-25 19:16:43', 'account', 'staff_group', 'Aenean quis consequat erat.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('40', '11', '2015-05-25 19:34:52', 'account', 'all_staffs', 'Vivamus quis turpis pharetra', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('41', '11', '2015-05-25 19:16:12', 'email', 'all_newsletters', 'Aenean quis consequat erat.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('42', '11', '2015-05-25 19:09:54', 'account', 'all_newsletters', 'Aenean quis consequat erat.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('43', '11', '2015-05-25 21:42:44', 'account', 'all_customers', 'In convallis ac nibh eu varius.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('44', '11', '2015-05-25 21:42:56', 'account', 'all_customers', 'Phasellus pharetra', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('45', '11', '2015-05-25 21:43:09', 'email', 'all_customers', 'Generated 5 paragraphs,', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('46', '11', '2015-05-25 21:43:21', 'email', 'all_staffs', 'Sed pharetra leo eget', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('47', '11', '2015-05-25 21:43:31', 'email', 'all_staffs', 'Fusce non rhoncus dolor.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('48', '11', '2015-05-25 21:43:50', 'email', 'staff_group', 'Pellentesque et ipsum nisl.', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('49', '11', '2015-05-25 21:44:17', 'email', 'all_staffs', 'Aenean eget euismod massa', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('50', '11', '2015-05-25 21:44:26', 'email', 'all_staffs', 'Aenean eget euismod massa', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('51', '11', '2015-05-25 21:44:48', 'email', 'all_staffs', 'Aenean eget euismod massa', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('52', '11', '2015-05-25 21:48:08', 'email', 'all_staffs', 'Aenean eget euismod massa', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('53', '11', '2015-05-25 21:48:22', 'email', 'all_staffs', 'Aenean eget euismod massa', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('54', '11', '2015-05-25 21:48:33', 'account', 'all_staffs', 'Aenean eget euismod massa', '<p>Etiam lacinia sodales sem at efficitur. Phasellus cursus vestibulum sollicitudin. Nunc dictum sem nibh, eget sollicitudin urna malesuada nec. Fusce congue vestibulum purus, sit amet tempor metus lobortis commodo. Pellentesque semper nisi sit amet tortor tincidunt efficitur. Quisque vehicula tempor dictum. Etiam ut urna mi. Aliquam erat volutpat. Aenean eget euismod massa.</p>\r\n<p>Curabitur pellentesque mi nec turpis volutpat ullamcorper. Sed pharetra leo eget consequat bibendum. Donec non sem diam. Aenean posuere auctor nisi vitae imperdiet. Quisque molestie fringilla porta. Praesent nunc urna, vulputate ac quam eu, auctor ullamcorper nisi. Pellentesque et ipsum nisl. Nam interdum ex sit amet nulla iaculis elementum. Fusce non rhoncus dolor. In convallis ac nibh eu varius. Phasellus pharetra nisi sed magna efficitur tempor. Nullam sed lorem eu nibh congue convallis porta quis sapien.</p>\r\n<div id=\"generated\">Generated 5 paragraphs, 448 words, 3001 bytes of <a title=\"Lorem Ipsum\" href=\"http://www.lipsum.com/\">Lorem Ipsum</a></div>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('55', '11', '2015-05-25 21:49:09', 'account', 'staff_group', 'Etiam mollis mauris eu magna', '<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('56', '11', '2015-05-25 21:49:30', 'account', 'all_staffs', 'Praesent dapibus', '<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('57', '11', '2015-05-25 21:49:47', 'account', 'all_staffs', 'Curabitur iaculis mattis magna', '<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('58', '11', '2015-05-25 21:49:57', 'account', 'all_staffs', 'Vivamus luctus tincidunt', '<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('59', '11', '2015-05-25 21:50:20', 'account', 'all_staffs', 'Donec sodales ante et leo', '<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('60', '11', '2015-05-25 21:50:52', 'account', 'all_newsletters', 'Donec sodales ante et leo', '<p>Ut convallis ligula dui, vitae pharetra magna ultricies eu. Etiam pellentesque purus suscipit felis hendrerit dictum. Cras tristique egestas quam eget volutpat. Nulla dapibus quis odio ac elementum. Praesent vel aliquam dolor. Phasellus gravida non enim facilisis lobortis. Donec sodales ante et leo sollicitudin, sit amet condimentum lectus vulputate. Vivamus ut auctor sapien, sit amet bibendum elit. Aenean id tortor a justo eleifend interdum. Curabitur gravida fermentum mauris, vitae semper purus. Sed eu elit consectetur, fermentum lorem vitae, fermentum neque. Vivamus luctus tincidunt finibus. Suspendisse potenti. Proin a dapibus arcu. Praesent dapibus, mi sed porttitor porta, elit orci accumsan mauris, vitae facilisis sem tellus non nibh. Etiam mollis mauris eu magna tincidunt, et facilisis ante luctus.</p>\r\n<p>Curabitur iaculis mattis magna eget pulvinar. Proin scelerisque, sem a eleifend venenatis, justo eros dictum sapien, id placerat enim nisi id tortor. Cras tincidunt neque in urna consequat, ac bibendum tortor commodo. Mauris efficitur, ante in fringilla suscipit, turpis mi finibus sem, vel mattis orci leo id eros. Aliquam feugiat, lacus sed ultricies suscipit, neque orci dignissim ex, vehicula mollis mauris purus vitae leo. Fusce elementum, dolor ut consectetur tincidunt, nulla lectus mattis lorem, vitae faucibus enim augue eu massa. Nulla a arcu ipsum.</p>', '1');
INSERT INTO `ti_messages` (`message_id`, `sender_id`, `date_added`, `send_type`, `recipient`, `subject`, `body`, `status`) VALUES ('61', '11', '2015-06-03 21:13:52', 'account', 'staffs', 'Hey Buddy', '<p>Supppie</p>', '1');


#
# TABLE STRUCTURE FOR: ti_migrations
#

DROP TABLE IF EXISTS `ti_migrations`;

CREATE TABLE `ti_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ti_migrations` (`version`) VALUES ('6');


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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('11', 'updated', 'extension', '', '14', '0', '0', '0', '2015-05-24 12:10:03');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('12', 'updated', 'location', '', '11', '0', '0', '0', '2015-05-24 12:11:03');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('13', 'updated', 'location', '', '11', '0', '0', '0', '2015-05-24 12:13:09');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('14', 'updated', 'extension', '', '14', '0', '0', '0', '2015-05-24 14:33:35');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('15', 'updated', 'extension', '', '14', '0', '0', '0', '2015-05-24 14:34:57');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('16', 'updated', 'extension', '', '14', '0', '0', '0', '2015-05-24 17:15:10');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('17', 'updated', 'extension', '', '14', '0', '0', '0', '2015-05-24 17:20:34');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('18', 'updated', 'extension', '', '25', '0', '0', '0', '2015-05-24 17:28:03');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('19', 'added', 'customer', '', '1', '0', '0', '0', '2015-05-24 18:23:50');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('20', 'changed', 'order', '', '1', '11', '12', '0', '2015-05-25 14:22:40');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('21', 'assigned', 'order', '', '1', '11', '11', '0', '2015-05-25 14:22:40');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('22', 'added', 'staff', '', '12', '0', '0', '0', '2015-05-25 14:54:37');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('23', 'updated', 'staff', '', '12', '0', '0', '0', '2015-05-25 14:55:03');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('24', 'added', 'review', '', '1', '0', '1', '0', '2015-05-26 13:49:43');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('25', 'updated', 'review', '', '1', '0', '1', '0', '2015-05-26 13:52:27');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('26', 'updated', 'review', '', '1', '0', '1', '0', '2015-05-26 13:52:30');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('27', 'updated', 'menu', '', '76', '0', '0', '0', '2015-06-02 01:39:54');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('28', 'updated', 'menu', '', '76', '0', '0', '0', '2015-06-02 01:58:36');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('29', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 13:41:39');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('30', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 13:48:21');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('31', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 13:48:31');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('32', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 13:54:30');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('33', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 14:06:09');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('34', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 15:33:32');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('35', 'updated', 'staff', '', '11', '0', '0', '0', '2015-06-02 15:34:03');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('36', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 15:44:22');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('37', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 15:44:37');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('38', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-02 15:46:02');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('39', 'added', 'staff', '', '13', '0', '0', '0', '2015-06-02 16:00:11');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('40', 'updated', 'staff', '', '13', '0', '0', '0', '2015-06-02 16:01:02');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('41', 'updated', 'extension', '', '14', '0', '0', '0', '2015-06-02 17:30:48');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('42', 'updated', 'extension', '', '11', '0', '0', '0', '2015-06-03 01:08:49');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('43', 'updated', 'staff', '', '12', '0', '0', '0', '2015-06-03 15:40:42');
INSERT INTO `ti_notifications` (`notification_id`, `action`, `object`, `suffix`, `object_id`, `actor_id`, `subject_id`, `status`, `date_added`) VALUES ('44', 'updated', 'staff', '', '13', '0', '0', '0', '2015-06-03 20:52:27');


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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('1', '1', '76', 'PUFF-PUFF', '60', '4.99', '299.40', '');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('2', '1', '79', 'RICE AND DODO', '4', '21.97', '87.88', 'a:3:{s:20:\"menu_option_value_id\";s:5:\"59|60\";s:4:\"name\";s:18:\"Assorted Meat|Dodo\";s:5:\"price\";s:9:\"5.99|3.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('3', '1', '78', 'ATA RICE', '100', '15.00', '1500.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"64\";s:4:\"name\";s:4:\"Fish\";s:5:\"price\";s:4:\"3.00\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('4', '20002', '78', 'ATA RICE', '1000', '16.99', '16990.00', 'a:3:{s:20:\"menu_option_value_id\";s:2:\"65\";s:4:\"name\";s:4:\"Beef\";s:5:\"price\";s:4:\"4.99\";}');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES ('5', '20003', '78', 'ATA RICE', '1000', '16.99', '16990.00', '');


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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('3', '1', '78', 'Fish', '3.00', '3', '64');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`, `order_menu_id`, `menu_option_value_id`) VALUES ('4', '20002', '78', 'Beef', '4.99', '4', '65');


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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('1', '1', 'cart_total', 'Sub Total', '1887.28', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('2', '1', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('3', '20002', 'cart_total', 'Sub Total', '16990.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('4', '20002', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('5', '20003', 'cart_total', 'Sub Total', '16990.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('6', '20003', 'delivery', 'Delivery', '10.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('7', '20003', 'coupon', 'Coupon (5555) ', '5000.00', '0');


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
) ENGINE=InnoDB AUTO_INCREMENT=20004 DEFAULT CHARSET=utf8;

INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('1', '0', 'Nulla', 'Ipsum', 'nulla@lpsum.com', '3829029289', '11', '1', '', '164', '', 'cod', '1', '2015-05-24 17:59:54', '2015-05-25', '14:32:00', '1897.28', '12', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0', '0', '11');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('20002', '1', 'Sam', 'Poyigi', 'sampoyigi@gmail.com', '4883930902', '11', '2', '', '1000', '', 'cod', '1', '2015-05-24 18:45:13', '2015-05-24', '14:32:00', '17000.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0', '0', '0');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`, `assignee_id`) VALUES ('20003', '1', 'Sam', 'Poyigi', 'sampoyigi@gmail.com', '4883930902', '11', '2', '', '1000', '', 'cod', '1', '2015-05-26 14:06:01', '2015-05-26', '14:50:00', '12000.00', '11', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:38.0) Gecko/20100101 Firefox/38.0', '0', '0');


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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

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
INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES ('42', 'lewisham', 'local', 'location_id=11');


#
# TABLE STRUCTURE FOR: ti_permissions
#

DROP TABLE IF EXISTS `ti_permissions`;

CREATE TABLE `ti_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('11', 'Admin.Banners', 'Ability to access, manage, add and delete banners', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('12', 'Admin.Categories', 'Ability to access, manage, add and delete categories', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('13', 'Site.Countries', 'Ability to manage, add and delete site countries', 'a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('14', 'Admin.Coupons', 'Ability to access, manage, add and delete coupons', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('15', 'Site.Currencies', 'Ability to access, manage, add and delete site currencies', 'a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('16', 'Admin.CustomerGroups', 'Ability to access, manage, add and delete customer groups', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('17', 'Admin.Customers', 'Ability to access, manage, add and delete customers', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('18', 'Admin.CustomersOnline', 'Ability to access online customers', 'a:1:{i:0;s:6:\"access\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('19', 'Admin.Database', 'Ability to access, backup, restore and manage database tables', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('20', 'Admin.ErrorLogs', 'Ability to access and delete error logs file', 'a:2:{i:0;s:6:\"access\";i:1;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('21', 'Admin.Modules', 'Ability to access, manage, add and delete extension modules', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('22', 'Admin.MediaManager', 'Ability to access, manage, add and delete media items', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('23', 'Site.Languages', 'Ability to manage, add and delete site languages', 'a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('24', 'Site.Layouts', 'Ability to manage, add and delete site layouts', 'a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('25', 'Admin.Locations', 'Ability to access, manage, add and delete locations', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('26', 'Admin.MailTemplates', 'Ability to access, manage, add and delete mail templates', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('27', 'Admin.MenuOptions', 'Ability to access, manage, add and delete menu option items', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('28', 'Admin.Menus', 'Ability to access, manage, add and delete menu items', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('29', 'Admin.Messages', 'Ability to add and delete messages', 'a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('30', 'Admin.Orders', 'Ability to access, manage, add and delete orders', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('31', 'Site.Pages', 'Ability to manage, add and delete site pages', 'a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('32', 'Admin.Payments', 'Ability to access, add and delete extension payments', 'a:3:{i:0;s:6:\"access\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('33', 'Admin.Permissions', 'Ability to manage, add and delete staffs permissions', 'a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('34', 'Admin.Ratings', 'Ability to add and delete review ratings', 'a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('35', 'Admin.Reservations', 'Ability to access, manage, add and delete reservations', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('36', 'Admin.Reviews', 'Ability to access, manage, add and delete user reviews', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('37', 'Admin.SecurityQuestions', 'Ability to add and delete customer registration security questions', 'a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('38', 'Site.Settings', 'Ability to manage system settings', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('39', 'Admin.StaffGroups', 'Ability to access, manage, add and delete staff groups', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('40', 'Admin.Staffs', 'Ability to access, manage, add and delete staffs', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('42', 'Admin.Statuses', 'Ability to access, manage, add and delete orders and reservations statuses', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('43', 'Admin.Tables', 'Ability to access, manage, add and delete reservations tables', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('44', 'Site.Themes', 'Ability to access, manage site themes', 'a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('45', 'Module.AccountModule', 'Ability to manage account module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('46', 'Module.BannersModule', 'Ability to manage banners module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('47', 'Module.CartModule', 'Ability to manage cart module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('48', 'Module.CategoriesModule', 'Ability to manage categories module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('49', 'Module.LocalModule', 'Ability to manage local module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('50', 'Module.PagesModule', 'Ability to manage pages module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('51', 'Module.ReservationModule', 'Ability to manage reservation module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('52', 'Module.Slideshow', 'Ability to manage slideshow module', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('53', 'Payment.Cod', 'Ability to manage cash on delivery payment', 'a:1:{i:0;s:6:\"manage\";}', '1');
INSERT INTO `ti_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES ('54', 'Payment.PaypalExpress', 'Ability to manage paypal express payment', 'a:1:{i:0;s:6:\"manage\";}', '1');


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `ti_reviews` (`review_id`, `customer_id`, `sale_id`, `sale_type`, `author`, `location_id`, `quality`, `delivery`, `service`, `review_text`, `date_added`, `review_status`) VALUES ('1', '1', '20002', 'order', 'Sam Poyigi', '11', '5', '4', '3', 'Curabitur molestie augue nec laoreet gravida. Ut consequat id ipsum id porttitor. In vel ante vel risus dapibus tempor sit amet quis tellus. In placerat hendrerit tellus, ac dapibus nulla congue quis. Sed ac suscipit sem. Suspendisse eget molestie libero, non rutrum felis. Phasellus eu varius augue, nec viverra massa. In vel lacus id diam laoreet pellentesque id et velit.', '2015-05-26 13:49:43', '1');


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
) ENGINE=InnoDB AUTO_INCREMENT=14926 DEFAULT CHARSET=utf8;

INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('7870', 'prefs', 'mail_template_id', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('8500', 'ratings', 'ratings', 'a:1:{s:7:\"ratings\";a:5:{i:1;s:3:\"Bad\";i:2;s:5:\"Worse\";i:3;s:4:\"Good\";i:4;s:7:\"Average\";i:5;s:9:\"Excellent\";}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('9225', 'config', 'site_desc', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('9241', 'config', 'search_radius', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('9249', 'config', 'ready_time', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('10855', 'config', 'stock_warning', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('10856', 'config', 'stock_qty_warning', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('10889', 'config', 'log_threshold', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('10894', 'config', 'index_file_url', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('10971', 'prefs', 'default_themes', 'a:2:{s:5:\"admin\";s:18:\"tastyigniter-blue/\";s:4:\"main\";s:20:\"tastyigniter-orange/\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14357', 'config', '	canceled_reservation_status', '17', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14397', 'config', '	confirmed_reservation_status', '16', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14400', 'prefs', 'ti_setup', '6', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14868', 'prefs', 'default_location_id', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14869', 'config', 'site_name', 'TastyIgniter', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14870', 'config', 'site_email', 'info@tastyigniter.com', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14871', 'config', 'site_logo', 'data/logo.png', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14872', 'config', 'country_id', '222', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14873', 'config', 'timezone', 'Europe/London', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14874', 'config', 'currency_id', '226', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14875', 'config', 'language_id', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14876', 'config', 'customer_group_id', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14877', 'config', 'page_limit', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14878', 'config', 'meta_description', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14879', 'config', 'meta_keywords', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14880', 'config', 'menus_page_limit', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14881', 'config', 'show_menu_images', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14882', 'config', 'menu_images_h', '80', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14883', 'config', 'menu_images_w', '95', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14884', 'config', 'special_category_id', '15', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14885', 'config', 'registration_terms', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14886', 'config', 'checkout_terms', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14887', 'config', 'registration_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14888', 'config', 'customer_order_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14889', 'config', 'customer_reserve_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14890', 'config', 'main_address', 'a:6:{s:9:\"address_1\";s:15:\"44 Darnley Road\";s:9:\"address_2\";s:0:\"\";s:4:\"city\";s:14:\"Greater London\";s:8:\"postcode\";s:6:\"E9 6QH\";s:11:\"location_id\";s:2:\"11\";s:10:\"country_id\";s:1:\"1\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14891', 'config', 'maps_api_key', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14892', 'config', 'search_by', 'address', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14893', 'config', 'distance_unit', 'mi', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14894', 'config', 'future_orders', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14895', 'config', 'location_order', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14896', 'config', 'location_order_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14897', 'config', 'location_reserve_email', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14898', 'config', 'approve_reviews', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14899', 'config', 'new_order_status', '11', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14900', 'config', 'complete_order_status', '15', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14901', 'config', 'canceled_order_status', '19', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14902', 'config', 'guest_order', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14903', 'config', 'delivery_time', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14904', 'config', 'collection_time', '15', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14905', 'config', 'reservation_mode', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14906', 'config', 'new_reservation_status', '18', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14907', 'config', 'confirmed_reservation_status', '16', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14908', 'config', 'canceled_reservation_status', '17', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14909', 'config', 'reservation_interval', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14910', 'config', 'reservation_turn', '60', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14911', 'config', 'image_manager', 'a:11:{s:8:\"max_size\";s:3:\"300\";s:11:\"thumb_width\";s:3:\"320\";s:12:\"thumb_height\";s:3:\"220\";s:7:\"uploads\";s:1:\"1\";s:10:\"new_folder\";s:1:\"1\";s:4:\"copy\";s:1:\"1\";s:4:\"move\";s:1:\"1\";s:6:\"rename\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";s:15:\"transliteration\";s:1:\"0\";s:13:\"remember_days\";s:1:\"7\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14912', 'config', 'protocol', 'mail', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14913', 'config', 'mailtype', 'html', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14914', 'config', 'smtp_host', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14915', 'config', 'smtp_port', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14916', 'config', 'smtp_user', 'tastyadmin', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14917', 'config', 'smtp_pass', 'demoadmin', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14918', 'config', 'customer_online_time_out', '120', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14919', 'config', 'customer_online_archive_time_out', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14920', 'config', 'permalink', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14921', 'config', 'maintenance_mode', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14922', 'config', 'maintenance_message', 'Site is under maintenance. Please check back later.', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14923', 'config', 'cache_mode', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14924', 'config', 'cache_time', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES ('14925', 'prefs', 'customizer_active_style', 'a:1:{s:4:\"main\";a:2:{i:0;s:19:\"tastyigniter-orange\";i:1;a:13:{s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"25\";s:19:\"logo_padding_bottom\";s:2:\"25\";s:11:\"font_family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:11:\"font_weight\";s:6:\"normal\";s:9:\"font_size\";s:2:\"13\";s:10:\"font_color\";s:7:\"#333333\";s:4:\"body\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";}s:6:\"header\";a:3:{s:10:\"background\";s:7:\"#fdeae2\";s:5:\"image\";s:0:\"\";s:5:\"color\";s:7:\"#333333\";}s:7:\"sidebar\";a:4:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#ffffff\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#428bca\";s:5:\"hover\";s:7:\"#2a6496\";}s:6:\"button\";a:4:{s:7:\"default\";a:2:{s:10:\"background\";s:7:\"#ffffff\";s:6:\"border\";s:7:\"#cccccc\";}s:7:\"primary\";a:2:{s:10:\"background\";s:7:\"#428bca\";s:6:\"border\";s:7:\"#357ebd\";}s:7:\"success\";a:2:{s:10:\"background\";s:7:\"#5cb85c\";s:6:\"border\";s:7:\"#4cae4c\";}s:6:\"danger\";a:2:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d43f3a\";}}s:10:\"custom_css\";s:0:\"\";}}}', '1');


#
# TABLE STRUCTURE FOR: ti_staff_groups
#

DROP TABLE IF EXISTS `ti_staff_groups`;

CREATE TABLE `ti_staff_groups` (
  `staff_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_group_name` varchar(32) NOT NULL,
  `location_access` tinyint(1) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`staff_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permissions`) VALUES ('11', 'Administrator', '0', 'a:44:{i:11;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:12;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:13;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:14;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:15;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:16;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:17;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:18;a:1:{i:0;s:6:\"access\";}i:19;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:20;a:2:{i:0;s:6:\"access\";i:1;s:6:\"delete\";}i:21;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:22;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:25;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:26;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:27;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:28;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:29;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:30;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:32;a:3:{i:0;s:6:\"access\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:33;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:34;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:35;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:36;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:37;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:39;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:40;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:41;a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}i:42;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:43;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:23;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:24;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:31;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:38;a:1:{i:0;s:6:\"manage\";}i:44;a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}i:45;a:1:{i:0;s:6:\"manage\";}i:46;a:1:{i:0;s:6:\"manage\";}i:47;a:1:{i:0;s:6:\"manage\";}i:48;a:1:{i:0;s:6:\"manage\";}i:49;a:1:{i:0;s:6:\"manage\";}i:50;a:1:{i:0;s:6:\"manage\";}i:51;a:1:{i:0;s:6:\"manage\";}i:52;a:1:{i:0;s:6:\"manage\";}i:53;a:1:{i:0;s:6:\"manage\";}i:54;a:1:{i:0;s:6:\"manage\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permissions`) VALUES ('12', 'Super Access', '0', 'a:23:{i:11;a:1:{i:0;s:6:\"access\";}i:12;a:1:{i:0;s:6:\"access\";}i:14;a:1:{i:0;s:6:\"access\";}i:16;a:1:{i:0;s:6:\"access\";}i:17;a:1:{i:0;s:6:\"access\";}i:18;a:1:{i:0;s:6:\"access\";}i:19;a:1:{i:0;s:6:\"access\";}i:20;a:1:{i:0;s:6:\"access\";}i:21;a:2:{i:0;s:6:\"access\";i:1;s:6:\"manage\";}i:22;a:1:{i:0;s:6:\"access\";}i:25;a:1:{i:0;s:6:\"access\";}i:26;a:1:{i:0;s:6:\"access\";}i:27;a:1:{i:0;s:6:\"access\";}i:28;a:1:{i:0;s:6:\"access\";}i:30;a:1:{i:0;s:6:\"access\";}i:32;a:1:{i:0;s:6:\"access\";}i:35;a:1:{i:0;s:6:\"access\";}i:36;a:1:{i:0;s:6:\"access\";}i:39;a:1:{i:0;s:6:\"access\";}i:40;a:1:{i:0;s:6:\"access\";}i:42;a:1:{i:0;s:6:\"access\";}i:43;a:1:{i:0;s:6:\"access\";}i:44;a:1:{i:0;s:6:\"access\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `location_access`, `permissions`) VALUES ('13', 'Manager', '0', 'a:37:{i:11;a:1:{i:0;s:6:\"manage\";}i:12;a:1:{i:0;s:6:\"manage\";}i:13;a:1:{i:0;s:6:\"manage\";}i:14;a:1:{i:0;s:6:\"manage\";}i:15;a:1:{i:0;s:6:\"manage\";}i:16;a:1:{i:0;s:6:\"manage\";}i:17;a:1:{i:0;s:6:\"manage\";}i:19;a:1:{i:0;s:6:\"manage\";}i:21;a:1:{i:0;s:6:\"manage\";}i:22;a:1:{i:0;s:6:\"manage\";}i:25;a:1:{i:0;s:6:\"manage\";}i:26;a:1:{i:0;s:6:\"manage\";}i:27;a:1:{i:0;s:6:\"manage\";}i:28;a:1:{i:0;s:6:\"manage\";}i:30;a:1:{i:0;s:6:\"manage\";}i:33;a:1:{i:0;s:6:\"manage\";}i:35;a:1:{i:0;s:6:\"manage\";}i:36;a:1:{i:0;s:6:\"manage\";}i:39;a:1:{i:0;s:6:\"manage\";}i:40;a:1:{i:0;s:6:\"manage\";}i:42;a:1:{i:0;s:6:\"manage\";}i:43;a:1:{i:0;s:6:\"manage\";}i:23;a:1:{i:0;s:6:\"manage\";}i:24;a:1:{i:0;s:6:\"manage\";}i:31;a:1:{i:0;s:6:\"manage\";}i:38;a:1:{i:0;s:6:\"manage\";}i:44;a:1:{i:0;s:6:\"manage\";}i:45;a:1:{i:0;s:6:\"manage\";}i:46;a:1:{i:0;s:6:\"manage\";}i:47;a:1:{i:0;s:6:\"manage\";}i:48;a:1:{i:0;s:6:\"manage\";}i:49;a:1:{i:0;s:6:\"manage\";}i:50;a:1:{i:0;s:6:\"manage\";}i:51;a:1:{i:0;s:6:\"manage\";}i:52;a:1:{i:0;s:6:\"manage\";}i:53;a:1:{i:0;s:6:\"manage\";}i:54;a:1:{i:0;s:6:\"manage\";}}');


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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO `ti_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_group_id`, `staff_location_id`, `timezone`, `language_id`, `date_added`, `staff_status`) VALUES ('11', 'Admin', 'info@tastyigniter.com', '11', '0', '0', '0', '2015-05-24', '1');
INSERT INTO `ti_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_group_id`, `staff_location_id`, `timezone`, `language_id`, `date_added`, `staff_status`) VALUES ('12', 'Iana', 'iana@iana.com', '13', '0', '0', '0', '2015-05-25', '1');
INSERT INTO `ti_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_group_id`, `staff_location_id`, `timezone`, `language_id`, `date_added`, `staff_status`) VALUES ('13', 'Sam', 'sampoyigi@gmail.com', '12', '0', '0', '0', '2015-06-02', '1');


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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('1', '1', '0', '0', '11', '0', 'order', 'Your order has been received.', '2015-05-24 17:59:54');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('2', '20002', '0', '0', '11', '0', 'order', 'Your order has been received.', '2015-05-24 18:45:13');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('3', '1', '11', '11', '12', '1', 'order', 'Your order is pending', '2015-05-25 14:22:40');
INSERT INTO `ti_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES ('4', '20003', '0', '0', '11', '0', 'order', 'Your order has been received.', '2015-05-26 14:06:01');


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
  `status_color` varchar(32) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES ('11', '11', 'tastyadmin', '3d6a9de5c72bd6dc71bcf99dc4e201ab73727bee', 'a995e5198');
INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES ('12', '12', 'iana', 'ae43b2b9482171182960abb86d82235725820d3f', 'a349c4be7');
INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES ('13', '13', 'sam', '33aaf35fd6e44430381c4d9d73ba251a5946655e', '7ccb62dc5');


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

INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('11', '0', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('11', '1', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('11', '2', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('11', '3', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('11', '4', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('11', '5', '00:00:00', '23:59:00', '0');
INSERT INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`) VALUES ('11', '6', '00:00:00', '23:59:00', '0');


