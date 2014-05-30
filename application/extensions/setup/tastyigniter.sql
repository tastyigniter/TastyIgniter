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
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


#
# TABLE STRUCTURE FOR: ti_categories
#

DROP TABLE IF EXISTS `ti_categories`;

CREATE TABLE `ti_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) NOT NULL,
  `category_description` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('15', 'Appetizer', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('16', 'Main Course', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('17', 'Salads', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('18', 'Seafoods', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('19', 'Traditional', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('20', 'Vegetarian', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('21', 'Soups', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('22', 'Desserts', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('23', 'Drinks', '');
INSERT INTO `ti_categories` (`category_id`, `category_name`, `category_description`) VALUES ('24', 'Specials', '');


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
) ENGINE=MyISAM AUTO_INCREMENT=242 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

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
  `name` varchar(128) NOT NULL,
  `code` varchar(15) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,2) NOT NULL,
  `min_total` decimal(15,2) NOT NULL,
  `redemptions` int(11) NOT NULL,
  `customer_redemptions` int(11) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('11', 'Half Sundays', '2222', 'F', '100.00', '500.00', '0', '0', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('12', 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', '0', '0', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('13', 'Full Mondays', 'MTo6TuTg', 'P', '50.00', '0.00', '0', '1', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('14', 'Full Tuesdays', '4444', 'F', '500.00', '5000.00', '0', '0', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('15', 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', '0', '0', '', '2014-01-12', '0000-00-00', '1', '0000-00-00');


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
  `amount` decimal(15,2) NOT NULL,
  `date_used` datetime NOT NULL,
  PRIMARY KEY (`coupon_history_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


#
# TABLE STRUCTURE FOR: ti_currencies
#

DROP TABLE IF EXISTS `ti_currencies`;

CREATE TABLE `ti_currencies` (
  `currency_id` int(5) NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('1', '1', 'Afghani', 'AFN', '؋', 'AF', 'AFG', '4', 'AF.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('2', '2', 'Lek', 'ALL', 'Lek', 'AL', 'ALB', '8', 'AL.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('3', '3', 'Dinar', 'DZD', '', 'DZ', 'DZA', '12', 'DZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('4', '4', 'Dollar', 'USD', '$', 'AS', 'ASM', '16', 'AS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('5', '5', 'Euro', 'EUR', '€', 'AD', 'AND', '20', 'AD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('6', '6', 'Kwanza', 'AOA', 'Kz', 'AO', 'AGO', '24', 'AO.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('7', '7', 'Dollar', 'XCD', '$', 'AI', 'AIA', '660', 'AI.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('8', '8', 'Antarctican', 'AQD', 'A$', 'AQ', 'ATA', '10', 'AQ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('9', '9', 'Dollar', 'XCD', '$', 'AG', 'ATG', '28', 'AG.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('10', '10', 'Peso', 'ARS', '$', 'AR', 'ARG', '32', 'AR.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('11', '11', 'Dram', 'AMD', '', 'AM', 'ARM', '51', 'AM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('12', '12', 'Guilder', 'AWG', 'ƒ', 'AW', 'ABW', '533', 'AW.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('13', '13', 'Dollar', 'AUD', '$', 'AU', 'AUS', '36', 'AU.png', '1');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('14', '14', 'Euro', 'EUR', '€', 'AT', 'AUT', '40', 'AT.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('15', '15', 'Manat', 'AZN', 'ман', 'AZ', 'AZE', '31', 'AZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('16', '16', 'Dollar', 'BSD', '$', 'BS', 'BHS', '44', 'BS.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('17', '17', 'Dinar', 'BHD', '', 'BH', 'BHR', '48', 'BH.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('18', '18', 'Taka', 'BDT', '', 'BD', 'BGD', '50', 'BD.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('19', '19', 'Dollar', 'BBD', '$', 'BB', 'BRB', '52', 'BB.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('20', '20', 'Ruble', 'BYR', 'p.', 'BY', 'BLR', '112', 'BY.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('21', '21', 'Euro', 'EUR', '€', 'BE', 'BEL', '56', 'BE.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('22', '22', 'Dollar', 'BZD', 'BZ$', 'BZ', 'BLZ', '84', 'BZ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('23', '23', 'Franc', 'XOF', '', 'BJ', 'BEN', '204', 'BJ.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('24', '24', 'Dollar', 'BMD', '$', 'BM', 'BMU', '60', 'BM.png', '0');
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('25', '25', 'Ngultrum', 'BTN', '', 'BT', 'BTN', '64', 'BT.png', '0');
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
INSERT INTO `ti_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`) VALUES ('36', '35', 'Franc', 'BIF', '', 'BI', 'BDI', '108', 'BI.png', '0');
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
  `ip_address` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
  `request_uri` text NOT NULL,
  `referrer_uri` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('51', 'module', 'reservation', 'Reservation');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('50', 'module', 'local', 'Local');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('49', 'module', 'categories', 'Categories');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('48', 'module', 'cart', 'Cart');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('52', 'module', 'slideshow', 'Slideshow');
INSERT INTO `ti_extensions` (`extension_id`, `type`, `code`, `name`) VALUES ('47', 'module', 'account', 'Account');


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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_languages` (`language_id`, `code`, `name`, `image`, `directory`, `status`) VALUES ('1', 'en', 'English', 'gb.png', 'english', '1');


#
# TABLE STRUCTURE FOR: ti_layout_routes
#

DROP TABLE IF EXISTS `ti_layout_routes`;

CREATE TABLE `ti_layout_routes` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `uri_route` varchar(128) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('114', '19', 'local');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('112', '11', 'account/inbox');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('111', '11', 'account/orders');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('110', '11', 'account/address');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('109', '11', 'account/details');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('108', '11', 'account');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('97', '12', 'menus');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('100', '14', 'payments');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('101', '13', 'checkout');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('102', '15', 'home');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('105', '17', 'reserve/table');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('106', '17', 'find/table');
INSERT INTO `ti_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES ('113', '18', 'pages/page/(:num)');


#
# TABLE STRUCTURE FOR: ti_layouts
#

DROP TABLE IF EXISTS `ti_layouts`;

CREATE TABLE `ti_layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('11', 'Account');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('12', 'Menus');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('13', 'Checkout');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('14', 'Payments');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('15', 'Home');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('17', 'Reservation');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('18', 'Page');
INSERT INTO `ti_layouts` (`layout_id`, `name`) VALUES ('19', 'Local');


#
# TABLE STRUCTURE FOR: ti_location_tables
#

DROP TABLE IF EXISTS `ti_location_tables`;

CREATE TABLE `ti_location_tables` (
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`table_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('115', '1');
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
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('122', '13');


#
# TABLE STRUCTURE FOR: ti_locations
#

DROP TABLE IF EXISTS `ti_locations`;

CREATE TABLE `ti_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(32) NOT NULL,
  `location_email` varchar(96) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reserve_interval`, `reserve_turn`, `location_status`) VALUES ('115', 'Harrow', 'harrow@tastyigniter.com', '14 Lime Close', '', 'Greater London', '', 'HA3 7JD', '222', '02088279101', '51.600262', '-0.325915', '0', 'a:2:{s:4:\"path\";s:56:\"[{\"path\":\"}k~yHtt|@nzTg~_AcfAnyhAwy@zlg@i`Hw}e@itQxjP\"}]\";s:9:\"pathArray\";s:260:\"[{\"lat\":51.606550000000006,\"lng\":-0.31579},{\"lat\":51.49463,\"lng\":0.016890000000000002},{\"lat\":51.50601,\"lng\":-0.36111000000000004},{\"lat\":51.51541,\"lng\":-0.56813},{\"lat\":51.5617,\"lng\":-0.36865000000000003},{\"lat\":51.657270000000004,\"lng\":-0.45758000000000004}]\";}', '0', '1', '45', '0', '10.00', '500.00', '45', '0', '1');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reserve_interval`, `reserve_turn`, `location_status`) VALUES ('116', 'Earling', 'ealing@tastyIgniter.com', '8 Brookfield Avenue', '', 'Greater London', '', 'W5 1LA', '222', '02088279102', '51.526852', '-0.301442', '5', 'a:2:{s:4:\"path\";s:53:\"[{\"path\":\"yapyHfqu@hnApiA?j}B}mAhw@Cs|@{iB_^vkB{|A\"}]\";s:9:\"pathArray\";s:325:\"[{\"lat\":51.53325,\"lng\":-0.27940000000000004},{\"lat\":51.52056,\"lng\":-0.29133000000000003},{\"lat\":51.52056,\"lng\":-0.31155000000000005},{\"lat\":51.533190000000005,\"lng\":-0.32056},{\"lat\":51.533210000000004,\"lng\":-0.31070000000000003},{\"lat\":51.55030508566046,\"lng\":-0.3057364868163859},{\"lat\":51.53291,\"lng\":-0.29072000000000003}]\";}', '0', '0', '0', '0', '0.00', '0.00', '0', '0', '1');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reserve_interval`, `reserve_turn`, `location_status`) VALUES ('117', 'Hackney', 'hackney@tastyigniter.com', '44 Darnley Road', '', 'Greater London', '', 'E9 6QH', '222', '02088279103', '51.544060', '-0.053999', '0', 'a:2:{s:4:\"path\";s:33:\"[{\"path\":\"ulsyHhqGrmA??j}BsmA?\"}]\";s:9:\"pathArray\";s:215:\"[{\"lat\":51.550348206988836,\"lng\":-0.04388792218242088},{\"lat\":51.53777179301117,\"lng\":-0.04388792218242088},{\"lat\":51.53777179301117,\"lng\":-0.06411007781753142},{\"lat\":51.550348206988836,\"lng\":-0.06411007781753142}]\";}', '1', '0', '45', '0', '0.00', '0.00', '0', '0', '1');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reserve_interval`, `reserve_turn`, `location_status`) VALUES ('118', 'Lewisham', 'lewisham@tastyigniter.com', 'Lewisham Way', '', 'London', '', 'SE4 1UT', '222', '020 8692 8888', '51.470467', '-0.028968', '0', 'a:2:{s:4:\"path\";s:49:\"[{\"path\":\"mqeyHnd@zxDqrChnByiAix@flEqoCv~EsmA?\"}]\";s:9:\"pathArray\";s:303:\"[{\"lat\":51.47943,\"lng\":-0.006},{\"lat\":51.449686558418776,\"lng\":0.017608042602546448},{\"lat\":51.431884349662624,\"lng\":0.029576476593092593},{\"lat\":51.44104713440149,\"lng\":-0.003258708801240573},{\"lat\":51.464180000000006,\"lng\":-0.039060000000000004},{\"lat\":51.476760000000006,\"lng\":-0.039060000000000004}]\";}', '1', '1', '45', '0', '10.00', '0.00', '0', '0', '1');


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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_mail_templates` (`template_id`, `name`, `language_id`, `date_added`, `date_updated`, `status`) VALUES ('11', 'Default', '1', '2014-04-16 01:49:52', '2014-04-16 01:51:02', '1');


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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('1', '11', 'registration', 'Account Created at {site_name}', '<p>Hello {first_name} {last_name},</p><p>Your account has now been created and you can log in using your email address and password by visiting our website or at the following URL: {login_link}</p><p>Thank you for using.<br />\n{signature}</p>\n', '2014-04-16 00:56:00', '2014-04-16 20:39:59');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('2', '11', 'password_reset', 'Password Reset at {site_name}', '<p>Dear {first_name} {last_name},</p><p>Your password has been reset successfull! Please <a href=\"{login_link}\" target=\"_blank\">login</a> using your new password: {created_password}.</p><p><a href=\"{login_link}\" target=\"_blank\">{signature}</a></p>\n', '2014-04-16 00:56:00', '2014-04-17 13:35:11');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('3', '11', 'order', 'Order Successful - {order_number}', '<div><div class=\"text-align\"><p>Hello {first_name} {last_name},</p><p>Your order has been received and will be with you shortly.<br /><a href=\"{order_link}\">Click here</a> to view your order progress.<br />\nThanks for shopping with us online! &nbsp;</p><h3>Order Details</h3><p>Your order number is {order_number}<br />\nThis is a {order_type} order.<br /><strong>Order Date:</strong> {order_date}<br /><strong>Delivery Time</strong> {order_time}</p><h3>What you\'ve ordered:</h3></div></div><table border=\"1\" cellpadding=\"1\" cellspacing=\"1\"><tbody><tr><td><div><div class=\"text-align\">{menus}</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td></tr><tr><td><div><div class=\"text-align\">{quantity}x</div></div></td><td><div><div class=\"text-align\"><p>{name}</p><p>{options}{option_name} {option_price}{/options}</p></div></div></td><td><div><div class=\"text-align\">{price}</div></div></td><td><div><div class=\"text-align\">{subtotal}</div></div></td></tr><tr><td><div><div class=\"text-align\">{/menus}</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td><td><div><div class=\"text-align\">&nbsp;</div></div></td></tr></tbody></table><div><div class=\"text-align\"><p>&nbsp;</p><p>{order_totals}<br /><strong>{title}:</strong> {value}<br />\n{/order_totals}</p><p>Your delivery address {order_address}</p><p>Your local restaurant {location_name}</p><p>We hope to see you again soon.</p><p>{signature}</p></div></div>\n', '2014-04-16 00:56:00', '2014-04-18 13:37:34');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('4', '11', 'reservation', 'Table Reserved - {reserve_number}', '<p>Hello {first_name} {last_name},<br /><br />\nYour reservation at {location_name} has been booked for {reserve_guest} person(s) on {reserve_date} at {reserve_time}.</p><p>Thanks for reserving with us online!<br /><br />\nWe hope to see you again soon.<br />\n{signature}</p>\n', '2014-04-16 00:56:00', '2014-04-16 19:59:02');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('5', '11', 'internal', '', '', '2014-04-16 00:56:00', '2014-04-16 00:59:00');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('6', '11', 'contact', 'Thanks for contacting us', '<h3><strong>Dear {contact_name},</strong></h3><p>{contact_message}</p><div>Your {site_name} Team,<br />\n{signature}</div>\n', '2014-04-16 00:56:00', '2014-04-17 13:30:30');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('7', '11', 'order_alert', '', '', '2014-04-16 00:56:00', '2014-04-16 00:59:00');
INSERT INTO `ti_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`) VALUES ('8', '11', 'reservation_alert', '', '', '2014-04-16 00:56:00', '2014-04-16 00:59:00');


#
# TABLE STRUCTURE FOR: ti_menu_options
#

DROP TABLE IF EXISTS `ti_menu_options`;

CREATE TABLE `ti_menu_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(32) NOT NULL,
  `option_price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('88', 'GOAT MEAT PEPPER SOUP', 'Chopped goat meat inside soup made up of a mixture of local African herbs and hot spices', '60.99', 'data/no_photo.png', '21', '1000', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('87', 'Boiled Plantain', 'w/spinach soup', '9.99', 'data/pesto.jpg', '20', '456', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('86', 'YAM PORRIDGE', 'in tomatoes sauce', '9.99', 'data/yam_porridge.jpg', '20', '469', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('85', 'AMALA(YAM FLOUR)', '', '11.99', 'data/DSCF3711.JPG', '19', '473', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('84', 'EBA (GRATED CASSAVA)', '', '11.99', 'data/eba.jpg', '19', '448', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('83', 'Seafood Salad', 'With shrimp, egg and imitation crab meat', '5.99', 'data/seafoods_salad.JPG', '17', '492', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('81', 'Whole Catfish with rice and vegetables', 'Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste', '13.99', 'data/FriedWholeCatfishPlate_lg.jpg', '24', '499', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('80', 'Special Shrimp Deluxe', 'Fresh shrimp sautéed in blended mixture of tomatoes, onion, peppers over choice of rice', '12.99', 'data/deluxe_bbq_shrimp-1.jpg', '18', '360', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('82', 'African Salad', 'With baked beans, egg, tuna, onion, tomatoes , green peas and carrot with your choice of dressing.', '8.99', '', '17', '500', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('79', 'RICE AND DODO', '(plantains) w/chicken, fish, beef or goat', '11.99', 'data/rice_and_dodo.jpg', '16', '902', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('77', 'SCOTCH EGG', 'Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.', '2.00', 'data/scotch_egg.jpg', '15', '972', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('76', 'PUFF-PUFF', 'Traditional Nigerian donut ball, rolled in sugar', '4.99', 'data/puff_puff.jpg', '24', '971', '1', '1', '1');
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
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('51', '81', '2014-04-10', '2014-04-30', '6.99', '1');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('52', '76', '2014-04-23', '2014-05-31', '10.00', '1');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('53', '86', '0000-00-00', '0000-00-00', '0.00', '0');


#
# TABLE STRUCTURE FOR: ti_menus_to_options
#

DROP TABLE IF EXISTS `ti_menus_to_options`;

CREATE TABLE `ti_menus_to_options` (
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


#
# TABLE STRUCTURE FOR: ti_online_activity
#

DROP TABLE IF EXISTS `ti_online_activity`;

CREATE TABLE `ti_online_activity` (
  `ip_address` varchar(40) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `access_type` varchar(128) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `request_uri` text NOT NULL,
  `referrer_uri` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
  `order_option_id` int(11) NOT NULL,
  PRIMARY KEY (`order_menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


#
# TABLE STRUCTURE FOR: ti_order_options
#

DROP TABLE IF EXISTS `ti_order_options`;

CREATE TABLE `ti_order_options` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_name` varchar(32) NOT NULL,
  `option_price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
  PRIMARY KEY (`order_total_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=2635 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `date_added`, `date_updated`, `status`) VALUES ('1', '1', 'About Us', 'About Us', 'About Us', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis massa ac magna sagittis, sit amet gravida metus gravida. Aenean dictum pellentesque erat, vitae adipiscing libero semper sit amet. Vestibulum nec nunc lorem. Duis vitae libero a libero hendrerit tincidunt in eu tellus. Aliquam consequat ultrices felis ut dictum. Nulla euismod felis a sem mattis ornare. Aliquam ut diam sit amet dolor iaculis molestie ac id nisl. Maecenas hendrerit convallis mi feugiat gravida. Quisque tincidunt, leo a posuere imperdiet, metus leo vestibulum orci, vel volutpat justo ligula id quam. Cras placerat tincidunt lorem eu interdum.</p>\n\n<h3 style=\"text-align:center\"><span style=\"color:#A52A2A\">Mission</span></h3>\n\n<p>Ut eu pretium urna. In sed consectetur neque. In ornare odio erat, id ornare arcu euismod a. Ut dapibus sit amet erat commodo vestibulum. Praesent vitae lacus faucibus, rhoncus tortor et, bibendum justo. Etiam pharetra congue orci, eget aliquam orci. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend justo eros, sit amet fermentum tellus ullamcorper quis. Cras cursus mi at imperdiet faucibus. Proin iaculis, felis vitae luctus venenatis, ante tortor porta nisi, et ornare magna metus sit amet enim. Phasellus et turpis nec metus aliquet adipiscing. Etiam at augue nec odio lacinia tincidunt. Suspendisse commodo commodo ipsum ac sollicitudin. Nunc nec consequat lacus. Donec gravida rhoncus justo sed elementum.</p>\n\n<h3 style=\"text-align:center\"><span style=\"color:#A52A2A\">Vision</span></h3>\n\n<p>Praesent erat massa, consequat a nulla et, eleifend facilisis risus. Nullam libero mi, bibendum id eleifend vitae, imperdiet a nulla. Fusce congue porta ultricies. Vivamus felis lectus, egestas at pretium vitae, posuere a nibh. Mauris lobortis urna nec rhoncus consectetur. Fusce sed placerat sem. Nulla venenatis elit risus, non auctor arcu lobortis eleifend. Ut aliquet vitae velit a faucibus. Suspendisse quis risus sit amet arcu varius malesuada. Vestibulum vitae massa consequat, euismod lorem a, euismod lacus. Duis sagittis dolor risus, ac vehicula mauris lacinia quis. Nulla facilisi. Duis tristique ipsum nec egestas auctor. Nullam in felis vel ligula dictum tincidunt nec a neque. Praesent in egestas elit.</p>', '', '', '18', '2014-04-19 16:57:21', '2014-04-22 01:12:32', '1');
INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `date_added`, `date_updated`, `status`) VALUES ('3', '1', 'Maintenance', 'Maintenance', 'Maintenance', '<h2 style=\"text-align: center;\"><span style=\"color:#B22222\">Site is under maintenance. Please check back later.</span></h2>', '', '', '0', '2014-04-21 16:30:37', '2014-04-22 02:02:40', '1');
INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `date_added`, `date_updated`, `status`) VALUES ('2', '1', 'Policy', 'Policy', 'Policy', '<div id=\"lipsum\">\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ligula eros, semper a lorem et, venenatis volutpat dolor. Pellentesque hendrerit lectus feugiat nulla cursus, quis dapibus dolor porttitor. Donec velit enim, adipiscing ac orci id, congue tincidunt arcu. Proin egestas nulla eget leo scelerisque, et semper diam ornare. Suspendisse potenti. Suspendisse vitae bibendum enim. Duis eu ligula hendrerit, lacinia felis in, mollis nisi. Sed gravida arcu in laoreet dictum. Nulla faucibus lectus a mollis dapibus. Fusce vehicula convallis urna, et congue nulla ultricies in. Nulla magna velit, bibendum eu odio et, euismod rhoncus sem. Nullam quis magna fermentum, ultricies neque nec, blandit neque. Etiam nec congue arcu. Curabitur sed tellus quam. Cras adipiscing odio odio, et porttitor dui suscipit eget. Aliquam non est commodo, elementum turpis at, pellentesque lorem.</p>\n\n<p>Duis nec diam diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate est et lorem sagittis, et mollis libero ultricies. Nunc ultrices tortor vel convallis varius. In dolor dolor, scelerisque ac faucibus ut, aliquet ac sem. Praesent consectetur lacus quis tristique posuere. Nulla sed ultricies odio. Cras tristique vulputate facilisis.</p>\n\n<p>Mauris at metus in magna condimentum gravida eu tincidunt urna. Praesent sodales vel mi eu condimentum. Suspendisse in luctus purus. Vestibulum dignissim, metus non luctus accumsan, odio ligula pharetra massa, in eleifend turpis risus in diam. Sed non lorem nibh. Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci. Nulla eget quam sit amet risus rhoncus lacinia a ut eros. Praesent non libero nisi. Mauris tincidunt at purus sit amet adipiscing. Donec interdum, velit nec dignissim vehicula, libero ipsum imperdiet ligula, lacinia mattis augue dui ac lacus. Aenean molestie sed nunc at pulvinar. Fusce ornare lacus non venenatis rhoncus.</p>\n\n<p>Aenean at enim luctus ante commodo consequat nec ut mi. Sed porta adipiscing tempus. Aliquam sit amet ullamcorper ipsum, id adipiscing quam. Fusce iaculis odio ut nisi convallis hendrerit. Morbi auctor adipiscing ligula, sit amet aliquet ante consectetur at. Donec vulputate neque eleifend libero pellentesque, vitae lacinia enim ornare. Vestibulum fermentum erat blandit, ultricies felis ac, facilisis augue. Nulla facilisis mi porttitor, interdum diam in, lobortis ipsum. In molestie quam nisl, lacinia convallis tellus fermentum ac. Nulla quis velit augue. Fusce accumsan, lacus et lobortis blandit, neque magna gravida enim, dignissim ultricies tortor dui in dolor. Vestibulum vel convallis justo, quis venenatis elit. Aliquam erat volutpat. Nunc quis iaculis ligula. Suspendisse dictum sodales neque vitae faucibus. Fusce id tellus pretium, varius nunc et, placerat metus.</p>\n\n<p>Pellentesque quis facilisis mauris. Phasellus porta, metus a dignissim viverra, est elit luctus erat, nec ultricies ligula lorem eget sapien. Pellentesque ac justo velit. Maecenas semper accumsan nulla eget rhoncus. Aliquam vel urna sed nibh dignissim auctor. Integer volutpat lacus ac purus convallis, at lobortis nisi tincidunt. Vestibulum condimentum elit ac sapien placerat, at ornare libero hendrerit. Cras tincidunt nunc sit amet ante bibendum tempor. Fusce quam orci, suscipit sed eros quis, vulputate molestie metus. Nam hendrerit vitae felis et porttitor. Proin et commodo velit, id porta erat. Donec eu consectetur odio. Fusce porta odio risus. Aliquam vel erat feugiat, vestibulum elit eget, ornare sapien. Sed sed nulla justo. Sed a dolor eu justo lacinia blandit.</p>\n</div>', '', '', '0', '2014-04-19 17:21:23', '2014-04-30 18:59:20', '1');


#
# TABLE STRUCTURE FOR: ti_payments
#

DROP TABLE IF EXISTS `ti_payments`;

CREATE TABLE `ti_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(32) NOT NULL,
  `payment_desc` text NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
  `staff_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`reservation_id`),
  KEY `location_id` (`location_id`,`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2444 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
  PRIMARY KEY (`review_id`, `order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


#
# TABLE STRUCTURE FOR: ti_security_questions
#

DROP TABLE IF EXISTS `ti_security_questions`;

CREATE TABLE `ti_security_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `priority` tinyint(1) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

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
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=6986 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6982', 'paypal_express', 'paypal_total', '0.00', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3022', 'account', 'account_module', 'a:1:{s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"11\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6983', 'paypal_express', 'paypal_order_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('2564', 'categories', 'categories_module', 'a:1:{s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6985', 'slideshow', 'slideshow_module', 'a:6:{s:11:\"dimension_h\";s:3:\"300\";s:11:\"dimension_w\";s:4:\"1084\";s:6:\"effect\";s:9:\"sliceDown\";s:5:\"speed\";s:3:\"500\";s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"15\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}s:6:\"images\";a:3:{i:0;s:14:\"data/slide.jpg\";i:1;s:15:\"data/slide1.jpg\";i:2;s:15:\"data/slide2.jpg\";}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6781', 'theme_settings', 'theme_settings', 'a:4:{s:11:\"allowed_img\";s:29:\"jpg|jpeg|png|gif|bmp|tiff|svg\";s:12:\"allowed_file\";s:18:\"txt|xml|js|php|css\";s:12:\"hidden_files\";s:0:\"\";s:14:\"hidden_folders\";s:0:\"\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('4289', 'local', 'local_module', 'a:1:{s:7:\"modules\";a:3:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:9:\"layout_id\";s:2:\"13\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:9:\"layout_id\";s:2:\"14\";s:8:\"position\";s:3:\"top\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6981', 'paypal_express', 'paypal_action', 'sale', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6980', 'paypal_express', 'paypal_sign', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AYzY6RzJVWuquyjw.VYZbV7LatXv', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('5885', 'ratings', 'ratings', 'a:5:{i:1;s:3:\"Bad\";i:2;s:5:\"Worse\";i:3;s:4:\"Good\";i:4;s:7:\"Average\";i:5;s:9:\"Excellent\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6647', 'cod', 'cod_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6646', 'cod', 'cod_order_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6645', 'cod', 'cod_total', '0.00', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6969', 'config', 'activity_timeout', '120', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6968', 'config', 'log_path', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6967', 'config', 'log_threshold', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6966', 'config', 'smtp_pass', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6965', 'config', 'smtp_user', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6964', 'config', 'smtp_port', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6963', 'config', 'smtp_host', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6962', 'config', 'mailtype', 'html', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6961', 'config', 'protocol', 'mail', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6960', 'config', 'themes_hidden_folders', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6959', 'config', 'themes_hidden_files', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6958', 'config', 'themes_allowed_file', 'txt|xml|js|php|css', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('3188', 'cart', 'cart_module', 'a:1:{s:7:\"modules\";a:3:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:9:\"layout_id\";s:2:\"13\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:9:\"layout_id\";s:2:\"14\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6957', 'config', 'themes_allowed_img', 'jpg|jpeg|png|gif|bmp|tiff|svg', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6956', 'config', 'reserve_turn', '120', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6955', 'config', 'reserve_interval', '15', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6954', 'config', 'reserve_status', '8', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6953', 'config', 'reserve_mode', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6952', 'config', 'ready_time', '45', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6951', 'config', 'guest_order', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6950', 'config', 'order_status_complete', '5', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6676', 'image_tool', 'image_tool', 'a:19:{s:11:\"root_folder\";s:4:\"data\";s:8:\"max_size\";s:3:\"300\";s:12:\"thumb_height\";s:3:\"120\";s:11:\"thumb_width\";s:3:\"120\";s:17:\"thumb_height_mini\";s:2:\"64\";s:16:\"thumb_width_mini\";s:2:\"64\";s:9:\"show_mini\";s:1:\"1\";s:8:\"show_ext\";s:1:\"0\";s:7:\"uploads\";s:1:\"1\";s:10:\"new_folder\";s:1:\"1\";s:4:\"copy\";s:1:\"1\";s:4:\"move\";s:1:\"1\";s:6:\"rename\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";s:11:\"allowed_ext\";s:29:\"jpg|jpeg|png|gif|bmp|tiff|svg\";s:12:\"hidden_files\";s:0:\"\";s:14:\"hidden_folders\";s:0:\"\";s:15:\"transliteration\";s:1:\"1\";s:13:\"remember_days\";s:1:\"7\";}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6949', 'config', 'order_status_new', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6948', 'config', 'approve_reviews', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6947', 'config', 'send_reserve_email', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6946', 'config', 'send_order_email', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6945', 'config', 'location_order', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6944', 'config', 'search_radius', '20', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6943', 'config', 'distance_unit', 'mi', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6942', 'config', 'search_by', 'postcode', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6941', 'config', 'maps_api_key', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6940', 'config', 'special_category_id', '24', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6939', 'config', 'menu_images_w', '95', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6938', 'config', 'menu_images_h', '80', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6937', 'config', 'show_menu_images', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6936', 'config', 'page_limit', '10', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6935', 'config', 'language_id', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6934', 'config', 'default_location_id', '118', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6933', 'config', 'currency_id', '226', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6932', 'config', 'timezone', 'Europe/London', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6931', 'config', 'country_id', '222', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6979', 'paypal_express', 'paypal_pass', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6930', 'config', 'site_logo', 'data/logo-right.png', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6929', 'config', 'site_desc', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6978', 'paypal_express', 'paypal_user', '', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6977', 'paypal_express', 'paypal_mode', 'sandbox', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6976', 'paypal_express', 'paypal_status', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6927', 'config', 'site_name', 'TastyIgniter', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6783', 'reservation', 'reservation_module', 'a:2:{s:11:\"dimension_h\";b:0;s:7:\"modules\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"17\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', '1');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6928', 'config', 'site_email', 'info@tastyigniter.com', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6970', 'config', 'encryption_key', 'muh6T37619LO09uJpk1679pCI06LHps4', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6971', 'config', 'index_file_url', '1', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6972', 'config', 'maintenance_mode', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6973', 'config', 'maintenance_page', '3', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6974', 'config', 'cache_mode', '0', '0');
INSERT INTO `ti_settings` (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES ('6975', 'config', 'cache_time', '', '0');


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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `permission`) VALUES ('11', 'Super Staff', 'a:2:{s:6:\"access\";a:43:{i:0;s:20:\"admin/account_module\";i:1;s:12:\"admin/backup\";i:2;s:17:\"admin/cart_module\";i:3;s:16:\"admin/categories\";i:4;s:23:\"admin/categories_module\";i:5;s:9:\"admin/cod\";i:6;s:15:\"admin/countries\";i:7;s:13:\"admin/coupons\";i:8;s:16:\"admin/currencies\";i:9;s:15:\"admin/customers\";i:10;s:24:\"admin/customers_activity\";i:11;s:16:\"admin/error_logs\";i:12;s:16:\"admin/extensions\";i:13;s:12:\"admin/footer\";i:14;s:12:\"admin/header\";i:15;s:19:\"admin/image_manager\";i:16;s:16:\"admin/image_tool\";i:17;s:15:\"admin/languages\";i:18;s:13:\"admin/layouts\";i:19;s:18:\"admin/local_module\";i:20;s:15:\"admin/locations\";i:21;s:20:\"admin/mail_templates\";i:22;s:18:\"admin/menu_options\";i:23;s:11:\"admin/menus\";i:24;s:14:\"admin/messages\";i:25;s:12:\"admin/orders\";i:26;s:11:\"admin/pages\";i:27;s:14:\"admin/payments\";i:28;s:20:\"admin/paypal_express\";i:29;s:13:\"admin/ratings\";i:30;s:24:\"admin/reservation_module\";i:31;s:18:\"admin/reservations\";i:32;s:13:\"admin/restore\";i:33;s:13:\"admin/reviews\";i:34;s:24:\"admin/security_questions\";i:35;s:14:\"admin/settings\";i:36;s:22:\"admin/slideshow_module\";i:37;s:18:\"admin/staff_groups\";i:38;s:12:\"admin/staffs\";i:39;s:14:\"admin/statuses\";i:40;s:12:\"admin/tables\";i:41;s:12:\"admin/themes\";i:42;s:16:\"admin/uri_routes\";}s:6:\"modify\";a:43:{i:0;s:20:\"admin/account_module\";i:1;s:12:\"admin/backup\";i:2;s:17:\"admin/cart_module\";i:3;s:16:\"admin/categories\";i:4;s:23:\"admin/categories_module\";i:5;s:9:\"admin/cod\";i:6;s:15:\"admin/countries\";i:7;s:13:\"admin/coupons\";i:8;s:16:\"admin/currencies\";i:9;s:15:\"admin/customers\";i:10;s:24:\"admin/customers_activity\";i:11;s:16:\"admin/error_logs\";i:12;s:16:\"admin/extensions\";i:13;s:12:\"admin/footer\";i:14;s:12:\"admin/header\";i:15;s:19:\"admin/image_manager\";i:16;s:16:\"admin/image_tool\";i:17;s:15:\"admin/languages\";i:18;s:13:\"admin/layouts\";i:19;s:18:\"admin/local_module\";i:20;s:15:\"admin/locations\";i:21;s:20:\"admin/mail_templates\";i:22;s:18:\"admin/menu_options\";i:23;s:11:\"admin/menus\";i:24;s:14:\"admin/messages\";i:25;s:12:\"admin/orders\";i:26;s:11:\"admin/pages\";i:27;s:14:\"admin/payments\";i:28;s:20:\"admin/paypal_express\";i:29;s:13:\"admin/ratings\";i:30;s:24:\"admin/reservation_module\";i:31;s:18:\"admin/reservations\";i:32;s:13:\"admin/restore\";i:33;s:13:\"admin/reviews\";i:34;s:24:\"admin/security_questions\";i:35;s:14:\"admin/settings\";i:36;s:22:\"admin/slideshow_module\";i:37;s:18:\"admin/staff_groups\";i:38;s:12:\"admin/staffs\";i:39;s:14:\"admin/statuses\";i:40;s:12:\"admin/tables\";i:41;s:12:\"admin/themes\";i:42;s:16:\"admin/uri_routes\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `permission`) VALUES ('12', 'Manager', 'a:1:{s:6:\"access\";a:43:{i:0;s:20:\"admin/account_module\";i:1;s:12:\"admin/backup\";i:2;s:17:\"admin/cart_module\";i:3;s:16:\"admin/categories\";i:4;s:23:\"admin/categories_module\";i:5;s:9:\"admin/cod\";i:6;s:15:\"admin/countries\";i:7;s:13:\"admin/coupons\";i:8;s:16:\"admin/currencies\";i:9;s:15:\"admin/customers\";i:10;s:24:\"admin/customers_activity\";i:11;s:16:\"admin/error_logs\";i:12;s:16:\"admin/extensions\";i:13;s:12:\"admin/footer\";i:14;s:12:\"admin/header\";i:15;s:19:\"admin/image_manager\";i:16;s:16:\"admin/image_tool\";i:17;s:15:\"admin/languages\";i:18;s:13:\"admin/layouts\";i:19;s:18:\"admin/local_module\";i:20;s:15:\"admin/locations\";i:21;s:20:\"admin/mail_templates\";i:22;s:18:\"admin/menu_options\";i:23;s:11:\"admin/menus\";i:24;s:14:\"admin/messages\";i:25;s:12:\"admin/orders\";i:26;s:11:\"admin/pages\";i:27;s:14:\"admin/payments\";i:28;s:20:\"admin/paypal_express\";i:29;s:13:\"admin/ratings\";i:30;s:24:\"admin/reservation_module\";i:31;s:18:\"admin/reservations\";i:32;s:13:\"admin/restore\";i:33;s:13:\"admin/reviews\";i:34;s:24:\"admin/security_questions\";i:35;s:14:\"admin/settings\";i:36;s:22:\"admin/slideshow_module\";i:37;s:18:\"admin/staff_groups\";i:38;s:12:\"admin/staffs\";i:39;s:14:\"admin/statuses\";i:40;s:12:\"admin/tables\";i:41;s:12:\"admin/themes\";i:42;s:16:\"admin/uri_routes\";}}');
INSERT INTO `ti_staff_groups` (`staff_group_id`, `staff_group_name`, `permission`) VALUES ('13', 'Administrator', 'a:0:{}');


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
  `date_added` date NOT NULL,
  `staff_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


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
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('1', 'Received', 'Your order has been received.', '1', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('2', 'Pending', 'Your order is pending', '1', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('3', 'Preparation', 'Your order is in the kitchen', '1', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('4', 'Delivery', 'Your order will be with you shortly.', '0', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('5', 'Completed', '', '0', 'order');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('8', 'Confirmed', 'Your table reservation has been confirmed.', '0', 'reserve');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('9', 'Canceled', 'Your table reservation has been canceled.', '0', 'reserve');
INSERT INTO `ti_statuses` (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES ('11', 'Pending', 'Your table reservation is pending.', '0', 'reserve');


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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

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
  `uri_route` varchar(255) NOT NULL,
  `controller` varchar(128) NOT NULL,
  `priority` tinyint(11) NOT NULL,
  PRIMARY KEY (`uri_route_id`),
  UNIQUE KEY `uri_route` (`uri_route`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('1', 'home', 'main/home', '1');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('2', 'aboutus', 'main/home/aboutus', '2');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('3', 'contact', 'main/contact', '3');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('4', 'local', 'main/local', '4');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('5', 'local/(:num)', 'main/local/$1', '5');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('6', 'menus', 'main/menus', '6');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('7', 'menus/category/(:num)', 'main/menus/category/$1', '7');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('8', 'checkout', 'main/checkout', '8');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('9', 'checkout/success', 'main/checkout/success', '9');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('10', 'payments', 'main/payments', '10');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('11', 'payments/paypal', 'main/payments/paypal', '11');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('12', 'account', 'main/account', '12');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('13', 'account/login', 'main/login', '13');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('14', 'account/logout', 'main/logout', '14');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('15', 'account/register', 'main/register', '15');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('16', 'account/password/reset', 'main/password_reset', '16');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('17', 'account/details', 'main/details', '17');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('18', 'account/address', 'main/address', '18');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('19', 'account/address/edit', 'main/address/edit', '19');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('20', 'account/address/edit/(:num)', 'main/address/edit/$1', '20');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('21', 'account/orders', 'main/orders', '21');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('22', 'account/orders/view/(:num)', 'main/orders/view/$1', '22');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('23', 'account/orders/reorder/(:num)', 'main/orders/reorder/$1', '23');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('24', 'account/reviews', 'main/reviews', '24');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('25', 'account/reviews/add/(:num)/(:num)', 'main/reviews/add/$1/$2', '25');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('26', 'account/reviews/view/(:num)/(:num)/(:num)', 'main/reviews/view/$1/$2/$3', '26');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('27', 'account/inbox', 'main/inbox', '27');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('28', 'account/inbox/view/(:num)', 'main/inbox/view/$1', '28');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('29', 'reserve/table', 'main/reserve_table', '29');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('30', 'reserve/success', 'main/reserve_table/success', '30');
INSERT INTO `ti_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES ('31', 'pages/page/(:num)', 'main/pages/page/$1', '31');


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
  PRIMARY KEY (`user_id`,`staff_id`,`username`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT INTO `ti_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES ('15', '4', 'tastyadmin', '484882570191a2f8cd1ecb5563e9eca003a3d34b', '3f65b0957');


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

