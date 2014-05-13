#
# TABLE STRUCTURE FOR: ti_address
#

DROP TABLE IF EXISTS `ti_address`;

CREATE TABLE `ti_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(15) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_categories
#

DROP TABLE IF EXISTS `ti_categories`;

CREATE TABLE `ti_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) NOT NULL,
  `category_description` text NOT NULL,
  `category_special` tinyint(1) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('15', 'Appetizer', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('16', 'Main Course', '', '1');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('17', 'Salads', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('18', 'Seafoods', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('19', 'Traditional', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('20', 'Vegetarian', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('21', 'Soups', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('22', 'Desserts', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('23', 'Drinks', '', '0');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`, `category_special`) VALUES ('24', 'Specials', '', '1');


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
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('1', 'Afghanistan', 'AF', 'AFG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('2', 'Albania', 'AL', 'ALB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('3', 'Algeria', 'DZ', 'DZA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('4', 'American Samoa', 'AS', 'ASM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('5', 'Andorra', 'AD', 'AND', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('6', 'Angola', 'AO', 'AGO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('7', 'Anguilla', 'AI', 'AIA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('8', 'Antarctica', 'AQ', 'ATA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('9', 'Antigua and Barbuda', 'AG', 'ATG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('10', 'Argentina', 'AR', 'ARG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('11', 'Armenia', 'AM', 'ARM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('12', 'Aruba', 'AW', 'ABW', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('13', 'Australia', 'AU', 'AUS', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('14', 'Austria', 'AT', 'AUT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('15', 'Azerbaijan', 'AZ', 'AZE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('16', 'Bahamas', 'BS', 'BHS', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('17', 'Bahrain', 'BH', 'BHR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('18', 'Bangladesh', 'BD', 'BGD', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('19', 'Barbados', 'BB', 'BRB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('20', 'Belarus', 'BY', 'BLR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('21', 'Belgium', 'BE', 'BEL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('22', 'Belize', 'BZ', 'BLZ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('23', 'Benin', 'BJ', 'BEN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('24', 'Bermuda', 'BM', 'BMU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('25', 'Bhutan', 'BT', 'BTN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('26', 'Bolivia', 'BO', 'BOL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('27', 'Bosnia and Herzegowina', 'BA', 'BIH', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('28', 'Botswana', 'BW', 'BWA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('29', 'Bouvet Island', 'BV', 'BVT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('30', 'Brazil', 'BR', 'BRA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('31', 'British Indian Ocean Territory', 'IO', 'IOT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('32', 'Brunei Darussalam', 'BN', 'BRN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('33', 'Bulgaria', 'BG', 'BGR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('34', 'Burkina Faso', 'BF', 'BFA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('35', 'Burundi', 'BI', 'BDI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('36', 'Cambodia', 'KH', 'KHM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('37', 'Cameroon', 'CM', 'CMR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('38', 'Canada', 'CA', 'CAN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('39', 'Cape Verde', 'CV', 'CPV', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('40', 'Cayman Islands', 'KY', 'CYM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('41', 'Central African Republic', 'CF', 'CAF', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('42', 'Chad', 'TD', 'TCD', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('43', 'Chile', 'CL', 'CHL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('44', 'China', 'CN', 'CHN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('45', 'Christmas Island', 'CX', 'CXR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('46', 'Cocos (Keeling) Islands', 'CC', 'CCK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('47', 'Colombia', 'CO', 'COL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('48', 'Comoros', 'KM', 'COM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('49', 'Congo', 'CG', 'COG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('50', 'Cook Islands', 'CK', 'COK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('51', 'Costa Rica', 'CR', 'CRI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('52', 'Cote D\'Ivoire', 'CI', 'CIV', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('53', 'Croatia', 'HR', 'HRV', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('54', 'Cuba', 'CU', 'CUB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('55', 'Cyprus', 'CY', 'CYP', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('56', 'Czech Republic', 'CZ', 'CZE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('57', 'Denmark', 'DK', 'DNK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('58', 'Djibouti', 'DJ', 'DJI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('59', 'Dominica', 'DM', 'DMA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('60', 'Dominican Republic', 'DO', 'DOM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('61', 'East Timor', 'TP', 'TMP', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('62', 'Ecuador', 'EC', 'ECU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('63', 'Egypt', 'EG', 'EGY', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('64', 'El Salvador', 'SV', 'SLV', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('65', 'Equatorial Guinea', 'GQ', 'GNQ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('66', 'Eritrea', 'ER', 'ERI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('67', 'Estonia', 'EE', 'EST', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('68', 'Ethiopia', 'ET', 'ETH', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('69', 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('70', 'Faroe Islands', 'FO', 'FRO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('71', 'Fiji', 'FJ', 'FJI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('72', 'Finland', 'FI', 'FIN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('73', 'France', 'FR', 'FRA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('74', 'France, Metropolitan', 'FX', 'FXX', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('75', 'French Guiana', 'GF', 'GUF', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('76', 'French Polynesia', 'PF', 'PYF', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('77', 'French Southern Territories', 'TF', 'ATF', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('78', 'Gabon', 'GA', 'GAB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('79', 'Gambia', 'GM', 'GMB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('80', 'Georgia', 'GE', 'GEO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('81', 'Germany', 'DE', 'DEU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('82', 'Ghana', 'GH', 'GHA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('83', 'Gibraltar', 'GI', 'GIB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('84', 'Greece', 'GR', 'GRC', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('85', 'Greenland', 'GL', 'GRL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('86', 'Grenada', 'GD', 'GRD', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('87', 'Guadeloupe', 'GP', 'GLP', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('88', 'Guam', 'GU', 'GUM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('89', 'Guatemala', 'GT', 'GTM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('90', 'Guinea', 'GN', 'GIN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('91', 'Guinea-bissau', 'GW', 'GNB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('92', 'Guyana', 'GY', 'GUY', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('93', 'Haiti', 'HT', 'HTI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('94', 'Heard and Mc Donald Islands', 'HM', 'HMD', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('95', 'Honduras', 'HN', 'HND', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('96', 'Hong Kong', 'HK', 'HKG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('97', 'Hungary', 'HU', 'HUN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('98', 'Iceland', 'IS', 'ISL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('99', 'India', 'IN', 'IND', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('100', 'Indonesia', 'ID', 'IDN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('101', 'Iran (Islamic Republic of)', 'IR', 'IRN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('102', 'Iraq', 'IQ', 'IRQ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('103', 'Ireland', 'IE', 'IRL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('104', 'Israel', 'IL', 'ISR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('105', 'Italy', 'IT', 'ITA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('106', 'Jamaica', 'JM', 'JAM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('107', 'Japan', 'JP', 'JPN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('108', 'Jordan', 'JO', 'JOR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('109', 'Kazakhstan', 'KZ', 'KAZ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('110', 'Kenya', 'KE', 'KEN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('111', 'Kiribati', 'KI', 'KIR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('112', 'North Korea', 'KP', 'PRK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('113', 'Korea, Republic of', 'KR', 'KOR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('114', 'Kuwait', 'KW', 'KWT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('115', 'Kyrgyzstan', 'KG', 'KGZ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('116', 'Lao People\'s Democratic Republic', 'LA', 'LAO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('117', 'Latvia', 'LV', 'LVA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('118', 'Lebanon', 'LB', 'LBN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('119', 'Lesotho', 'LS', 'LSO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('120', 'Liberia', 'LR', 'LBR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('121', 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('122', 'Liechtenstein', 'LI', 'LIE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('123', 'Lithuania', 'LT', 'LTU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('124', 'Luxembourg', 'LU', 'LUX', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('125', 'Macau', 'MO', 'MAC', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('126', 'FYROM', 'MK', 'MKD', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('127', 'Madagascar', 'MG', 'MDG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('128', 'Malawi', 'MW', 'MWI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('129', 'Malaysia', 'MY', 'MYS', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('130', 'Maldives', 'MV', 'MDV', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('131', 'Mali', 'ML', 'MLI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('132', 'Malta', 'MT', 'MLT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('133', 'Marshall Islands', 'MH', 'MHL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('134', 'Martinique', 'MQ', 'MTQ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('135', 'Mauritania', 'MR', 'MRT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('136', 'Mauritius', 'MU', 'MUS', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('137', 'Mayotte', 'YT', 'MYT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('138', 'Mexico', 'MX', 'MEX', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('139', 'Micronesia, Federated States of', 'FM', 'FSM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('140', 'Moldova, Republic of', 'MD', 'MDA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('141', 'Monaco', 'MC', 'MCO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('142', 'Mongolia', 'MN', 'MNG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('143', 'Montserrat', 'MS', 'MSR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('144', 'Morocco', 'MA', 'MAR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('145', 'Mozambique', 'MZ', 'MOZ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('146', 'Myanmar', 'MM', 'MMR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('147', 'Namibia', 'NA', 'NAM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('148', 'Nauru', 'NR', 'NRU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('149', 'Nepal', 'NP', 'NPL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('150', 'Netherlands', 'NL', 'NLD', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('151', 'Netherlands Antilles', 'AN', 'ANT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('152', 'New Caledonia', 'NC', 'NCL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('153', 'New Zealand', 'NZ', 'NZL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('154', 'Nicaragua', 'NI', 'NIC', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('155', 'Niger', 'NE', 'NER', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('156', 'Nigeria', 'NG', 'NGA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('157', 'Niue', 'NU', 'NIU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('158', 'Norfolk Island', 'NF', 'NFK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('159', 'Northern Mariana Islands', 'MP', 'MNP', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('160', 'Norway', 'NO', 'NOR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('161', 'Oman', 'OM', 'OMN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('162', 'Pakistan', 'PK', 'PAK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('163', 'Palau', 'PW', 'PLW', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('164', 'Panama', 'PA', 'PAN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('165', 'Papua New Guinea', 'PG', 'PNG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('166', 'Paraguay', 'PY', 'PRY', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('167', 'Peru', 'PE', 'PER', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('168', 'Philippines', 'PH', 'PHL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('169', 'Pitcairn', 'PN', 'PCN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('170', 'Poland', 'PL', 'POL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('171', 'Portugal', 'PT', 'PRT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('172', 'Puerto Rico', 'PR', 'PRI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('173', 'Qatar', 'QA', 'QAT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('174', 'Reunion', 'RE', 'REU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('175', 'Romania', 'RO', 'ROM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('176', 'Russian Federation', 'RU', 'RUS', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('177', 'Rwanda', 'RW', 'RWA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('178', 'Saint Kitts and Nevis', 'KN', 'KNA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('179', 'Saint Lucia', 'LC', 'LCA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('180', 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('181', 'Samoa', 'WS', 'WSM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('182', 'San Marino', 'SM', 'SMR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('183', 'Sao Tome and Principe', 'ST', 'STP', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('184', 'Saudi Arabia', 'SA', 'SAU', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('185', 'Senegal', 'SN', 'SEN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('186', 'Seychelles', 'SC', 'SYC', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('187', 'Sierra Leone', 'SL', 'SLE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('188', 'Singapore', 'SG', 'SGP', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('189', 'Slovak Republic', 'SK', 'SVK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('190', 'Slovenia', 'SI', 'SVN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('191', 'Solomon Islands', 'SB', 'SLB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('192', 'Somalia', 'SO', 'SOM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('193', 'South Africa', 'ZA', 'ZAF', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('194', 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('195', 'Spain', 'ES', 'ESP', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('196', 'Sri Lanka', 'LK', 'LKA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('197', 'St. Helena', 'SH', 'SHN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('198', 'St. Pierre and Miquelon', 'PM', 'SPM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('199', 'Sudan', 'SD', 'SDN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('200', 'Suriname', 'SR', 'SUR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('201', 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('202', 'Swaziland', 'SZ', 'SWZ', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('203', 'Sweden', 'SE', 'SWE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('204', 'Switzerland', 'CH', 'CHE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('205', 'Syrian Arab Republic', 'SY', 'SYR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('206', 'Taiwan', 'TW', 'TWN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('207', 'Tajikistan', 'TJ', 'TJK', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('208', 'Tanzania, United Republic of', 'TZ', 'TZA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('209', 'Thailand', 'TH', 'THA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('210', 'Togo', 'TG', 'TGO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('211', 'Tokelau', 'TK', 'TKL', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('212', 'Tonga', 'TO', 'TON', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('213', 'Trinidad and Tobago', 'TT', 'TTO', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('214', 'Tunisia', 'TN', 'TUN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('215', 'Turkey', 'TR', 'TUR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('216', 'Turkmenistan', 'TM', 'TKM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('217', 'Turks and Caicos Islands', 'TC', 'TCA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('218', 'Tuvalu', 'TV', 'TUV', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('219', 'Uganda', 'UG', 'UGA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('220', 'Ukraine', 'UA', 'UKR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('221', 'United Arab Emirates', 'AE', 'ARE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('222', 'United Kingdom', 'GB', 'GBR', '{address_1}\n{address_2}\n{city} {postcode} {state}\n{country}', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('223', 'United States', 'US', 'USA', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('224', 'United States Minor Outlying Islands', 'UM', 'UMI', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('225', 'Uruguay', 'UY', 'URY', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('226', 'Uzbekistan', 'UZ', 'UZB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('227', 'Vanuatu', 'VU', 'VUT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('228', 'Vatican City State (Holy See)', 'VA', 'VAT', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('229', 'Venezuela', 'VE', 'VEN', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('230', 'Viet Nam', 'VN', 'VNM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('231', 'Virgin Islands (British)', 'VG', 'VGB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('232', 'Virgin Islands (U.S.)', 'VI', 'VIR', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('233', 'Wallis and Futuna Islands', 'WF', 'WLF', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('234', 'Western Sahara', 'EH', 'ESH', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('235', 'Yemen', 'YE', 'YEM', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('236', 'Yugoslavia', 'YU', 'YUG', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('237', 'Democratic Republic of Congo', 'CD', 'COD', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('238', 'Zambia', 'ZM', 'ZMB', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('239', 'Zimbabwe', 'ZW', 'ZWE', '', '1');
INSERT INTO `ti_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`) VALUES ('241', 'Iana Island', 'SA', 'GAA', '', '1');


#
# TABLE STRUCTURE FOR: ti_coupons
#

DROP TABLE IF EXISTS `ti_coupons`;

CREATE TABLE `ti_coupons` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `type` char(1) CHARACTER SET utf8 NOT NULL,
  `discount` decimal(15,2) NOT NULL,
  `min_total` decimal(15,2) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('12', 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('14', 'Full Tuesdays', '4444', 'F', '500.00', '500.00', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('15', 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', '', '2014-01-12', '2014-03-31', '1', '0000-00-00');


#
# TABLE STRUCTURE FOR: ti_currencies
#

DROP TABLE IF EXISTS `ti_currencies`;

CREATE TABLE `ti_currencies` (
  `currency_id` int(5) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(32) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_symbol` varchar(12) NOT NULL,
  `currency_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `ti_currencies` (`currency_id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_status`) VALUES ('7', 'Pounds', 'GBP', '£', '1');
INSERT INTO `ti_currencies` (`currency_id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_status`) VALUES ('8', 'US Dollars', 'USD', '$', '1');
INSERT INTO `ti_currencies` (`currency_id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_status`) VALUES ('9', 'Euro', 'EUR', '€', '1');
INSERT INTO `ti_currencies` (`currency_id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_status`) VALUES ('10', 'Chinese yuan', 'CNY', '¥', '0');
INSERT INTO `ti_currencies` (`currency_id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_status`) VALUES ('11', 'Naira', 'NGN', '₦', '0');


#
# TABLE STRUCTURE FOR: ti_customers
#

DROP TABLE IF EXISTS `ti_customers`;

CREATE TABLE `ti_customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `address_id` int(11) NOT NULL,
  `security_question_id` int(11) NOT NULL,
  `security_answer` varchar(32) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `date_added` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


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
  `country_name` varchar(128) NOT NULL,
  `country_code` varchar(4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_extensions
#

DROP TABLE IF EXISTS `ti_extensions`;

CREATE TABLE `ti_extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('33', 'module', 'local', 'Local');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('34', 'module', 'categories', 'Categories');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('35', 'module', 'cart', 'Cart');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('37', 'module', 'account', 'Account');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('38', 'module', 'slideshow', 'Slideshow');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('39', 'module', 'reservation', 'Reservation');


#
# TABLE STRUCTURE FOR: ti_layout_routes
#

DROP TABLE IF EXISTS `ti_layout_routes`;

CREATE TABLE `ti_layout_routes` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `uri_route_id` int(11) NOT NULL,
  `uri_route` varchar(40) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('91', '11', '0', 'account');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('92', '11', '0', 'account/details');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('93', '11', '0', 'account/address');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('94', '11', '0', 'account/address/edit');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('95', '11', '0', 'account/orders');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('96', '11', '0', 'account/inbox');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('97', '12', '0', 'menus');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('100', '14', '0', 'payments');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('101', '13', '0', 'checkout');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('102', '15', '0', 'home');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('105', '17', '0', 'reserve/table');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route_id`, `uri_route`) VALUES ('106', '17', '0', 'find/table');


#
# TABLE STRUCTURE FOR: ti_layouts
#

DROP TABLE IF EXISTS `ti_layouts`;

CREATE TABLE `ti_layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('11', 'Account');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('12', 'Menus');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('13', 'Checkout');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('14', 'Payments');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('15', 'Home');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('17', 'Reservation');


#
# TABLE STRUCTURE FOR: ti_location_tables
#

DROP TABLE IF EXISTS `ti_location_tables`;

CREATE TABLE `ti_location_tables` (
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_locations
#

DROP TABLE IF EXISTS `ti_locations`;

CREATE TABLE `ti_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(32) NOT NULL,
  `location_email` varchar(96) CHARACTER SET utf8 NOT NULL,
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
  `covered_area` text NOT NULL,
  `offer_delivery` tinyint(1) NOT NULL,
  `offer_collection` tinyint(1) NOT NULL,
  `ready_time` int(11) NOT NULL,
  `last_order_time` int(11) NOT NULL,
  `delivery_charge` decimal(15,2) NOT NULL,
  `min_delivery_total` decimal(15,2) NOT NULL,
  `reserve_interval` int(11) NOT NULL,
  `reserve_turn` int(11) NOT NULL,
  `location_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reserve_interval`, `reserve_turn`, `location_status`) VALUES ('115', 'Harrow', 'harrow@tastyigniter.com', '14 Lime Close', '', 'Greater London', '', 'HA3 7JD', '222', '02088279101', '51.600262', '-0.325915', '0', 'a:2:{s:4:\"path\";s:56:\"[{\"path\":\"}k~yHtt|@nzTg~_AcfAnyhAwy@zlg@i`Hw}e@itQxjP\"}]\";s:9:\"pathArray\";s:260:\"[{\"lat\":51.606550000000006,\"lng\":-0.31579},{\"lat\":51.49463,\"lng\":0.016890000000000002},{\"lat\":51.50601,\"lng\":-0.36111000000000004},{\"lat\":51.51541,\"lng\":-0.56813},{\"lat\":51.5617,\"lng\":-0.36865000000000003},{\"lat\":51.657270000000004,\"lng\":-0.45758000000000004}]\";}', '0', '1', '45', '0', '10.00', '500.00', '45', '0', '1');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reserve_interval`, `reserve_turn`, `location_status`) VALUES ('116', 'Earling', 'ealing@tastyIgniter.com', '8 Brookfield Avenue', '', 'Greater London', '', 'W5 1LA', '222', '02088279102', '51.526852', '-0.301442', '5', 'a:2:{s:4:\"path\";s:53:\"[{\"path\":\"yapyHfqu@hnApiA?j}B}mAhw@Cs|@{iB_^vkB{|A\"}]\";s:9:\"pathArray\";s:325:\"[{\"lat\":51.53325,\"lng\":-0.27940000000000004},{\"lat\":51.52056,\"lng\":-0.29133000000000003},{\"lat\":51.52056,\"lng\":-0.31155000000000005},{\"lat\":51.533190000000005,\"lng\":-0.32056},{\"lat\":51.533210000000004,\"lng\":-0.31070000000000003},{\"lat\":51.55030508566046,\"lng\":-0.3057364868163859},{\"lat\":51.53291,\"lng\":-0.29072000000000003}]\";}', '0', '0', '0', '0', '0.00', '0.00', '0', '0', '1');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reserve_interval`, `reserve_turn`, `location_status`) VALUES ('117', 'Hackney', 'hackney@tastyigniter.com', '44 Darnley Road', '', 'Greater London', '', 'E9 6QH', '222', '02088279103', '51.544060', '-0.053999', '0', 'a:2:{s:4:\"path\";s:33:\"[{\"path\":\"ulsyHhqGrmA??j}BsmA?\"}]\";s:9:\"pathArray\";s:215:\"[{\"lat\":51.550348206988836,\"lng\":-0.04388792218242088},{\"lat\":51.53777179301117,\"lng\":-0.04388792218242088},{\"lat\":51.53777179301117,\"lng\":-0.06411007781753142},{\"lat\":51.550348206988836,\"lng\":-0.06411007781753142}]\";}', '1', '0', '45', '0', '0.00', '0.00', '0', '0', '1');


#
# TABLE STRUCTURE FOR: ti_menu_options
#

DROP TABLE IF EXISTS `ti_menu_options`;

CREATE TABLE `ti_menu_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(32) NOT NULL,
  `option_price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('14', 'Assorted Chicken', '4.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('13', 'Assorted Beef', '3.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('12', 'Chicken', '3.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('15', 'Meat', '4.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('16', 'Fish', '4.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('17', 'Assorted Fish', '3.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('18', 'Assorted Meat', '3.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('19', 'Titus', '3.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('20', 'Beef', '3.00');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('21', 'Turkey', '4.99');
INSERT INTO `ti_menu_options` (`option_id`, `option_name`, `option_price`) VALUES ('22', 'Dodo', '3.99');


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
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('88', 'GOAT MEAT PEPPER SOUP', 'Chopped goat meat inside soup made up of a mixture of local African herbs and hot spices', '60.99', 'data/no_photo.png', '21', '1000', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('87', 'Boiled Plantain', 'w/spinach soup', '9.99', 'data/pesto.jpg', '20', '500', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('86', 'YAM PORRIDGE', 'in tomatoes sauce', '9.99', 'data/yam_porridge.jpg', '20', '492', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('85', 'AMALA(YAM FLOUR)', '', '11.99', 'data/DSCF3711.JPG', '19', '491', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('84', 'EBA (GRATED CASSAVA)', '', '11.99', 'data/eba.jpg', '19', '462', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('83', 'Seafood Salad', 'With shrimp, egg and imitation crab meat', '5.99', 'data/seafoods_salad.JPG', '17', '500', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('81', 'Whole Catfish with rice and vegetables', 'Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste', '13.99', 'data/FriedWholeCatfishPlate_lg.jpg', '24', '499', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('80', 'Special Shrimp Deluxe', 'Fresh shrimp sautéed in blended mixture of tomatoes, onion, peppers over choice of rice', '12.99', 'data/deluxe_bbq_shrimp-1.jpg', '18', '500', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('82', 'African Salad', 'With baked beans, egg, tuna, onion, tomatoes , green peas and carrot with your choice of dressing.', '8.99', '', '17', '500', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('79', 'RICE AND DODO', '(plantains) w/chicken, fish, beef or goat', '11.99', 'data/rice_and_dodo.jpg', '16', '974', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('77', 'SCOTCH EGG', 'Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.', '2.00', 'data/scotch_egg.jpg', '15', '973', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('76', 'PUFF-PUFF', 'Traditional Nigerian donut ball, rolled in sugar', '4.99', 'data/puff_puff.jpg', '15', '1000', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('78', 'ATA RICE', 'Small pieces of beef, goat, stipe, and tendon sautéed in crushed green Jamaican pepper.', '12.00', 'data/Seared_Ahi_Spinach_Salad.jpg', '16', '1000', '1', '0', '1');


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
  PRIMARY KEY (`special_id`,`menu_id`),
  UNIQUE KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('51', '81', '2014-04-10', '2014-04-30', '6.99', '1');


#
# TABLE STRUCTURE FOR: ti_menus_to_options
#

DROP TABLE IF EXISTS `ti_menus_to_options`;

CREATE TABLE `ti_menus_to_options` (
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('78', '12');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('78', '15');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('78', '16');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('79', '16');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('79', '22');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('84', '13');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('84', '14');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('84', '17');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('85', '17');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('85', '18');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('86', '12');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('86', '16');
INSERT INTO `ti_menus_to_options` (`menu_id`, `option_id`) VALUES ('86', '20');


#
# TABLE STRUCTURE FOR: ti_messages
#

DROP TABLE IF EXISTS `ti_messages`;

CREATE TABLE `ti_messages` (
  `message_id` int(15) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `time` time NOT NULL,
  `type` varchar(32) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `label` varchar(32) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `read_status` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


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
  `options` text NOT NULL,
  `order_option_id` int(11) NOT NULL,
  PRIMARY KEY (`order_menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_order_options
#

DROP TABLE IF EXISTS `ti_order_options`;

CREATE TABLE `ti_order_options` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `option_price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_order_total
#

DROP TABLE IF EXISTS `ti_order_total`;

CREATE TABLE `ti_order_total` (
  `order_total_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_total_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


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
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20011 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_payments
#

DROP TABLE IF EXISTS `ti_payments`;

CREATE TABLE `ti_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `payment_desc` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `ti_payments` (`payment_id`, `payment_name`, `payment_desc`) VALUES ('11', 'Cash On Delivery', 'Pay on delivery');
INSERT INTO `ti_payments` (`payment_id`, `payment_name`, `payment_desc`) VALUES ('12', 'PayPal', 'Paypal payment');


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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


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
  `first_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `email` varchar(96) CHARACTER SET utf8 NOT NULL,
  `telephone` varchar(45) CHARACTER SET utf8 NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `reserve_time` time NOT NULL,
  `reserve_date` date NOT NULL,
  `date_added` date NOT NULL,
  `date_modified` date NOT NULL,
  `staff_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `ip_address` varchar(40) CHARACTER SET utf8 NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`reservation_id`),
  KEY `location_id` (`location_id`,`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20011 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_reviews
#

DROP TABLE IF EXISTS `ti_reviews`;

CREATE TABLE `ti_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `author` varchar(32) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `delivery` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `date_added` datetime NOT NULL,
  `review_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`review_id`),
  UNIQUE KEY `customer_id_2` (`customer_id`,`order_id`,`location_id`),
  KEY `customer_id` (`customer_id`,`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_security_questions
#

DROP TABLE IF EXISTS `ti_security_questions`;

CREATE TABLE `ti_security_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('8', 'Whats your pets name?', '1');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('9', 'What high school did you attend?', '2');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('10', 'What is your father\'s middle name?', '7');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('11', 'What is your mother\'s name?', '3');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('13', 'What is your place of birth?', '4');
INSERT INTO `ti_security_questions` (`question_id`, `text`, `priority`) VALUES ('14', 'Whats your favourite teacher\'s name?', '5');


#
# TABLE STRUCTURE FOR: ti_settings
#

DROP TABLE IF EXISTS `ti_settings`;

CREATE TABLE `ti_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` varchar(45) NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=5107 DEFAULT CHARSET=utf8;

INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3516', 'paypal_express', 'paypal_total', '0.00', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5106', 'config', 'encryption_key', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5104', 'config', 'log_threshold', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5105', 'config', 'log_path', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3514', 'paypal_express', 'paypal_sign', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3515', 'paypal_express', 'paypal_action', 'sale', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3022', 'account', 'account_module', 'a:1:{s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"11\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('4289', 'local', 'local_module', 'a:1:{s:7:\"modules\";a:3:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:9:\"layout_id\";s:2:\"13\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:9:\"layout_id\";s:2:\"14\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3188', 'cart', 'cart_module', 'a:1:{s:7:\"modules\";a:3:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:9:\"layout_id\";s:2:\"13\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:9:\"layout_id\";s:2:\"14\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('2564', 'categories', 'categories_module', 'a:1:{s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3513', 'paypal_express', 'paypal_pass', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3512', 'paypal_express', 'paypal_user', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3511', 'paypal_express', 'paypal_mode', 'sandbox', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3555', 'ratings', 'ratings', 'a:5:{i:1;s:3:\"Bad\";i:2;s:5:\"Worse\";i:3;s:4:\"Good\";i:4;s:7:\"Average\";i:5;s:9:\"Excellent\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('2248', 'cod', 'cod_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('2247', 'cod', 'cod_order_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('2246', 'cod', 'cod_total', '0.00', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5103', 'config', 'smtp_pass', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5102', 'config', 'smtp_user', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5101', 'config', 'smtp_port', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5100', 'config', 'smtp_host', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5099', 'config', 'mailtype', 'html', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5098', 'config', 'protocol', 'smtp', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5097', 'config', 'reserve_turn', '120', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5096', 'config', 'reserve_interval', '15', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5095', 'config', 'reserve_status', '8', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5094', 'config', 'reserve_mode', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5093', 'config', 'ready_time', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5092', 'config', 'guest_order', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5091', 'config', 'order_status_complete', '5', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5090', 'config', 'order_status_new', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5089', 'config', 'approve_reviews', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5088', 'config', 'send_reserve_email', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5085', 'config', 'search_radius', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3510', 'paypal_express', 'paypal_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5087', 'config', 'send_order_email', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3517', 'paypal_express', 'paypal_order_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5086', 'config', 'location_order', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5084', 'config', 'distance_unit', 'mi', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5083', 'config', 'search_by', 'postcode', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3901', 'reservation', 'reservation_module', 'a:2:{s:11:\"dimension_h\";b:0;s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"17\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5082', 'config', 'maps_api_key', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('4726', 'slideshow', 'slideshow_module', 'a:6:{s:11:\"dimension_h\";s:3:\"300\";s:11:\"dimension_w\";s:4:\"1084\";s:6:\"effect\";s:9:\"sliceDown\";s:5:\"speed\";s:3:\"500\";s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"15\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}s:6:\"images\";a:4:{i:0;s:14:\"data/slide.jpg\";i:1;s:15:\"data/slide1.jpg\";i:2;s:15:\"data/slide2.jpg\";i:3;s:13:\"data/suya.jpg\";}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5081', 'config', 'special_category_id', '24', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5080', 'config', 'menu_images_w', '95', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5079', 'config', 'menu_images_h', '80', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('4292', 'image_tool', 'image_tool', 'a:18:{s:11:\"root_folder\";s:4:\"data\";s:8:\"max_size\";s:3:\"300\";s:12:\"thumb_height\";s:3:\"128\";s:11:\"thumb_width\";s:3:\"128\";s:17:\"thumb_height_mini\";s:2:\"64\";s:16:\"thumb_width_mini\";s:2:\"64\";s:8:\"show_ext\";s:1:\"0\";s:7:\"uploads\";s:1:\"1\";s:10:\"new_folder\";s:1:\"1\";s:4:\"copy\";s:1:\"1\";s:4:\"move\";s:1:\"1\";s:6:\"rename\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";s:11:\"allowed_ext\";s:29:\"jpg|jpeg|png|gif|bmp|tiff|svg\";s:12:\"hidden_files\";s:0:\"\";s:14:\"hidden_folders\";s:0:\"\";s:15:\"transliteration\";s:1:\"1\";s:13:\"remember_days\";s:1:\"7\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5078', 'config', 'show_menu_images', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5077', 'config', 'page_limit', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5076', 'config', 'default_location_id', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5075', 'config', 'currency_id', '7', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5074', 'config', 'timezone', 'Europe/London', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5073', 'config', 'country_id', '222', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5072', 'config', 'site_logo', 'data/logo-right.png', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5071', 'config', 'site_desc', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5070', 'config', 'site_email', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5069', 'config', 'site_name', '', '0');


#
# TABLE STRUCTURE FOR: ti_staff_groups
#

DROP TABLE IF EXISTS `ti_staff_groups`;

CREATE TABLE `ti_staff_groups` (
  `staff_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_group_name` varchar(32) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`staff_group_id`),
  KEY `department_id` (`staff_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `permission`) VALUES ('11', 'Super Staff', 'a:2:{s:6:\"access\";a:37:{i:0;s:12:\"admin/backup\";i:1;s:16:\"admin/categories\";i:2;s:9:\"admin/cod\";i:3;s:15:\"admin/countries\";i:4;s:13:\"admin/coupons\";i:5;s:16:\"admin/currencies\";i:6;s:15:\"admin/customers\";i:7;s:16:\"admin/error_logs\";i:8;s:16:\"admin/extensions\";i:9;s:19:\"admin/image_manager\";i:10;s:16:\"admin/image_tool\";i:11;s:13:\"admin/layouts\";i:12;s:15:\"admin/locations\";i:13;s:18:\"admin/menu_options\";i:14;s:11:\"admin/menus\";i:15;s:14:\"admin/messages\";i:16;s:20:\"admin/order_statuses\";i:17;s:12:\"admin/orders\";i:18;s:14:\"admin/payments\";i:19;s:20:\"admin/paypal_express\";i:20;s:13:\"admin/ratings\";i:21;s:18:\"admin/reservations\";i:22;s:22:\"admin/reserve_statuses\";i:23;s:13:\"admin/restore\";i:24;s:13:\"admin/reviews\";i:25;s:24:\"admin/security_questions\";i:26;s:14:\"admin/settings\";i:27;s:18:\"admin/staff_groups\";i:28;s:12:\"admin/staffs\";i:29;s:12:\"admin/tables\";i:30;s:16:\"admin/uri_routes\";i:31;s:20:\"admin/account_module\";i:32;s:17:\"admin/cart_module\";i:33;s:23:\"admin/categories_module\";i:34;s:18:\"admin/local_module\";i:35;s:24:\"admin/reservation_module\";i:36;s:22:\"admin/slideshow_module\";}s:6:\"modify\";a:37:{i:0;s:12:\"admin/backup\";i:1;s:16:\"admin/categories\";i:2;s:9:\"admin/cod\";i:3;s:15:\"admin/countries\";i:4;s:13:\"admin/coupons\";i:5;s:16:\"admin/currencies\";i:6;s:15:\"admin/customers\";i:7;s:16:\"admin/error_logs\";i:8;s:16:\"admin/extensions\";i:9;s:19:\"admin/image_manager\";i:10;s:16:\"admin/image_tool\";i:11;s:13:\"admin/layouts\";i:12;s:15:\"admin/locations\";i:13;s:18:\"admin/menu_options\";i:14;s:11:\"admin/menus\";i:15;s:14:\"admin/messages\";i:16;s:20:\"admin/order_statuses\";i:17;s:12:\"admin/orders\";i:18;s:14:\"admin/payments\";i:19;s:20:\"admin/paypal_express\";i:20;s:13:\"admin/ratings\";i:21;s:18:\"admin/reservations\";i:22;s:22:\"admin/reserve_statuses\";i:23;s:13:\"admin/restore\";i:24;s:13:\"admin/reviews\";i:25;s:24:\"admin/security_questions\";i:26;s:14:\"admin/settings\";i:27;s:18:\"admin/staff_groups\";i:28;s:12:\"admin/staffs\";i:29;s:12:\"admin/tables\";i:30;s:16:\"admin/uri_routes\";i:31;s:20:\"admin/account_module\";i:32;s:17:\"admin/cart_module\";i:33;s:23:\"admin/categories_module\";i:34;s:18:\"admin/local_module\";i:35;s:24:\"admin/reservation_module\";i:36;s:22:\"admin/slideshow_module\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `permission`) VALUES ('12', 'Manager', 'a:1:{s:6:\"access\";a:36:{i:0;s:12:\"admin/backup\";i:1;s:16:\"admin/categories\";i:2;s:9:\"admin/cod\";i:3;s:15:\"admin/countries\";i:4;s:13:\"admin/coupons\";i:5;s:16:\"admin/currencies\";i:6;s:15:\"admin/customers\";i:7;s:16:\"admin/error_logs\";i:8;s:16:\"admin/extensions\";i:9;s:19:\"admin/image_manager\";i:10;s:16:\"admin/image_tool\";i:11;s:13:\"admin/layouts\";i:12;s:15:\"admin/locations\";i:13;s:18:\"admin/menu_options\";i:14;s:11:\"admin/menus\";i:15;s:14:\"admin/messages\";i:16;s:20:\"admin/order_statuses\";i:17;s:12:\"admin/orders\";i:18;s:14:\"admin/payments\";i:19;s:20:\"admin/paypal_express\";i:20;s:13:\"admin/ratings\";i:21;s:18:\"admin/reservations\";i:22;s:22:\"admin/reserve_statuses\";i:23;s:13:\"admin/restore\";i:24;s:13:\"admin/reviews\";i:25;s:24:\"admin/security_questions\";i:26;s:14:\"admin/settings\";i:27;s:12:\"admin/staffs\";i:28;s:12:\"admin/tables\";i:29;s:16:\"admin/uri_routes\";i:30;s:20:\"admin/account_module\";i:31;s:17:\"admin/cart_module\";i:32;s:23:\"admin/categories_module\";i:33;s:18:\"admin/local_module\";i:34;s:24:\"admin/reservation_module\";i:35;s:22:\"admin/slideshow_module\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `permission`) VALUES ('13', 'Administrator', 'a:0:{}');


#
# TABLE STRUCTURE FOR: ti_staffs
#

DROP TABLE IF EXISTS `ti_staffs`;

CREATE TABLE `ti_staffs` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `staff_email` varchar(96) CHARACTER SET utf8 NOT NULL,
  `staff_group_id` int(11) NOT NULL,
  `staff_location` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `staff_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_status_history
#

DROP TABLE IF EXISTS `ti_status_history`;

CREATE TABLE `ti_status_history` (
  `status_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `assigned_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `for` varchar(32) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`status_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_statuses
#

DROP TABLE IF EXISTS `ti_statuses`;

CREATE TABLE `ti_statuses` (
  `status_id` int(15) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `status_comment` text CHARACTER SET utf8 NOT NULL,
  `notify_customer` tinyint(1) NOT NULL,
  `status_for` varchar(10) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('1', 'Received', 'Your order has been received.', '1', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('2', 'Pending', 'Your order is pending', '1', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('3', 'Preparation', 'Your order is in the kitchen', '1', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('4', 'Delivery', 'Your order will be with you shortly.', '0', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('5', 'Completed', '', '0', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('8', 'Confirmed', 'Your table reservation has been confirmed.', '0', 'reserve');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('9', 'Canceled', 'Your table reservation has been canceled.', '0', 'reserve');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('11', 'Pending', '', '0', 'reserve');


#
# TABLE STRUCTURE FOR: ti_tables
#

DROP TABLE IF EXISTS `ti_tables`;

CREATE TABLE `ti_tables` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `min_capacity` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `table_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('1', 'NN01', '2', '2', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('2', 'NN02', '2', '2', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('6', 'SW77', '2', '4', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('7', 'EW77', '6', '8', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('8', 'SE78', '4', '6', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('9', 'NE8', '8', '10', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('10', 'SW55', '9', '10', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('11', 'EW88', '2', '10', '0');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('12', 'EE732', '2', '8', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('13', 'EW79', '10', '15', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('14', 'FW79', '4', '10', '0');


#
# TABLE STRUCTURE FOR: ti_uri_routes
#

DROP TABLE IF EXISTS `ti_uri_routes`;

CREATE TABLE `ti_uri_routes` (
  `uri_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `uri_route` varchar(255) CHARACTER SET utf8 NOT NULL,
  `controller` varchar(64) NOT NULL,
  `priority` tinyint(11) NOT NULL,
  PRIMARY KEY (`uri_route_id`),
  UNIQUE KEY `uri_route` (`uri_route`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('1', 'home', 'main/home', '1');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('2', 'aboutus', 'main/home/aboutus', '2');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('3', 'contact', 'main/contact', '3');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('4', 'menus', 'main/menus', '4');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('5', 'menus/review', 'main/menus/review', '5');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('6', 'menus/write_review', 'main/menus/write_review', '6');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('7', 'checkout', 'main/checkout', '7');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('8', 'checkout/success', 'main/checkout/success', '8');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('9', 'payments', 'main/payments', '9');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('10', 'payments/paypal', 'main/payments/paypal', '10');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('11', 'account', 'main/account', '11');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('12', 'account/login', 'main/login', '12');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('13', 'account/logout', 'main/logout', '13');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('14', 'account/register', 'main/register', '14');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('15', 'account/password/reset', 'main/password_reset', '15');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('16', 'account/details', 'main/details', '16');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('17', 'account/address', 'main/address', '17');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('18', 'account/address/edit', 'main/address/edit', '18');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('19', 'account/orders', 'main/orders', '19');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('20', 'account/orders/view', 'main/orders/view', '20');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('21', 'account/reviews', 'main/reviews', '21');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('22', 'account/reviews/add', 'main/reviews/add', '22');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('23', 'account/reviews/view', 'main/reviews/view', '23');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('24', 'account/inbox', 'main/inbox', '24');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('25', 'account/inbox/view', 'main/inbox/view', '25');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('26', 'find/table', 'main/find_table', '26');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('27', 'reserve/table', 'main/reserve_table', '27');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('28', 'reserve/success', 'main/reserve_table/success', '28');


#
# TABLE STRUCTURE FOR: ti_users
#

DROP TABLE IF EXISTS `ti_users`;

CREATE TABLE `ti_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL,
  `salt` varchar(9) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`user_id`,`staff_id`,`username`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: ti_working_hours
#

DROP TABLE IF EXISTS `ti_working_hours`;

CREATE TABLE `ti_working_hours` (
  `location_id` int(11) NOT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  PRIMARY KEY (`location_id`,`weekday`),
  KEY `weekday` (`weekday`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
