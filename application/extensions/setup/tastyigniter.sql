#
# TABLE STRUCTURE FOR: address
#

DROP TABLE IF EXISTS address;
CREATE TABLE `address` (
  `address_id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_id` int(15) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: categories
#

DROP TABLE IF EXISTS categories;
CREATE TABLE `categories` (
  `category_id` int(15) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(32) NOT NULL,
  `category_description` text NOT NULL,
  `category_special` tinyint(4) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (15, 'Appetizer', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (16, 'Main Course', '', 1);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (17, 'Salads', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (18, 'Seafoods', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (19, 'Traditional', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (20, 'Vegetarian', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (21, 'Soups', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (22, 'Desserts', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (23, 'Drinks', '', 0);
INSERT INTO categories (`category_id`, `category_name`, `category_description`, `category_special`) VALUES (24, 'Specials', '', 1);


#
# TABLE STRUCTURE FOR: ti_sessions
#

DROP TABLE IF EXISTS ti_sessions;
CREATE TABLE `ti_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  `nearest_location` varchar(45) NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: countries
#

DROP TABLE IF EXISTS countries;
CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (1, 'Afghanistan', 'AF', 'AFG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (2, 'Albania', 'AL', 'ALB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (3, 'Algeria', 'DZ', 'DZA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (4, 'American Samoa', 'AS', 'ASM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (5, 'Andorra', 'AD', 'AND', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (6, 'Angola', 'AO', 'AGO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (7, 'Anguilla', 'AI', 'AIA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (8, 'Antarctica', 'AQ', 'ATA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (9, 'Antigua and Barbuda', 'AG', 'ATG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (10, 'Argentina', 'AR', 'ARG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (11, 'Armenia', 'AM', 'ARM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (12, 'Aruba', 'AW', 'ABW', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (13, 'Australia', 'AU', 'AUS', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (14, 'Austria', 'AT', 'AUT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (15, 'Azerbaijan', 'AZ', 'AZE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (16, 'Bahamas', 'BS', 'BHS', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (17, 'Bahrain', 'BH', 'BHR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (18, 'Bangladesh', 'BD', 'BGD', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (19, 'Barbados', 'BB', 'BRB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (20, 'Belarus', 'BY', 'BLR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (21, 'Belgium', 'BE', 'BEL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (22, 'Belize', 'BZ', 'BLZ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (23, 'Benin', 'BJ', 'BEN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (24, 'Bermuda', 'BM', 'BMU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (25, 'Bhutan', 'BT', 'BTN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (26, 'Bolivia', 'BO', 'BOL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (27, 'Bosnia and Herzegowina', 'BA', 'BIH', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (28, 'Botswana', 'BW', 'BWA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (29, 'Bouvet Island', 'BV', 'BVT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (30, 'Brazil', 'BR', 'BRA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (31, 'British Indian Ocean Territory', 'IO', 'IOT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (32, 'Brunei Darussalam', 'BN', 'BRN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (33, 'Bulgaria', 'BG', 'BGR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (34, 'Burkina Faso', 'BF', 'BFA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (35, 'Burundi', 'BI', 'BDI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (36, 'Cambodia', 'KH', 'KHM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (37, 'Cameroon', 'CM', 'CMR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (38, 'Canada', 'CA', 'CAN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (39, 'Cape Verde', 'CV', 'CPV', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (40, 'Cayman Islands', 'KY', 'CYM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (41, 'Central African Republic', 'CF', 'CAF', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (42, 'Chad', 'TD', 'TCD', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (43, 'Chile', 'CL', 'CHL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (44, 'China', 'CN', 'CHN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (45, 'Christmas Island', 'CX', 'CXR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (47, 'Colombia', 'CO', 'COL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (48, 'Comoros', 'KM', 'COM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (49, 'Congo', 'CG', 'COG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (50, 'Cook Islands', 'CK', 'COK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (51, 'Costa Rica', 'CR', 'CRI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (52, 'Cote D\'Ivoire', 'CI', 'CIV', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (53, 'Croatia', 'HR', 'HRV', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (54, 'Cuba', 'CU', 'CUB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (55, 'Cyprus', 'CY', 'CYP', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (56, 'Czech Republic', 'CZ', 'CZE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (57, 'Denmark', 'DK', 'DNK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (58, 'Djibouti', 'DJ', 'DJI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (59, 'Dominica', 'DM', 'DMA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (60, 'Dominican Republic', 'DO', 'DOM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (61, 'East Timor', 'TP', 'TMP', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (62, 'Ecuador', 'EC', 'ECU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (63, 'Egypt', 'EG', 'EGY', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (64, 'El Salvador', 'SV', 'SLV', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (65, 'Equatorial Guinea', 'GQ', 'GNQ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (66, 'Eritrea', 'ER', 'ERI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (67, 'Estonia', 'EE', 'EST', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (68, 'Ethiopia', 'ET', 'ETH', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (70, 'Faroe Islands', 'FO', 'FRO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (71, 'Fiji', 'FJ', 'FJI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (72, 'Finland', 'FI', 'FIN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (73, 'France', 'FR', 'FRA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (74, 'France, Metropolitan', 'FX', 'FXX', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (75, 'French Guiana', 'GF', 'GUF', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (76, 'French Polynesia', 'PF', 'PYF', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (77, 'French Southern Territories', 'TF', 'ATF', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (78, 'Gabon', 'GA', 'GAB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (79, 'Gambia', 'GM', 'GMB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (80, 'Georgia', 'GE', 'GEO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (81, 'Germany', 'DE', 'DEU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (82, 'Ghana', 'GH', 'GHA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (83, 'Gibraltar', 'GI', 'GIB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (84, 'Greece', 'GR', 'GRC', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (85, 'Greenland', 'GL', 'GRL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (86, 'Grenada', 'GD', 'GRD', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (87, 'Guadeloupe', 'GP', 'GLP', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (88, 'Guam', 'GU', 'GUM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (89, 'Guatemala', 'GT', 'GTM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (90, 'Guinea', 'GN', 'GIN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (91, 'Guinea-bissau', 'GW', 'GNB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (92, 'Guyana', 'GY', 'GUY', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (93, 'Haiti', 'HT', 'HTI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (95, 'Honduras', 'HN', 'HND', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (96, 'Hong Kong', 'HK', 'HKG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (97, 'Hungary', 'HU', 'HUN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (98, 'Iceland', 'IS', 'ISL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (99, 'India', 'IN', 'IND', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (100, 'Indonesia', 'ID', 'IDN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (102, 'Iraq', 'IQ', 'IRQ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (103, 'Ireland', 'IE', 'IRL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (104, 'Israel', 'IL', 'ISR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (105, 'Italy', 'IT', 'ITA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (106, 'Jamaica', 'JM', 'JAM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (107, 'Japan', 'JP', 'JPN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (108, 'Jordan', 'JO', 'JOR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (109, 'Kazakhstan', 'KZ', 'KAZ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (110, 'Kenya', 'KE', 'KEN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (111, 'Kiribati', 'KI', 'KIR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (112, 'North Korea', 'KP', 'PRK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (113, 'Korea, Republic of', 'KR', 'KOR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (114, 'Kuwait', 'KW', 'KWT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (115, 'Kyrgyzstan', 'KG', 'KGZ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (116, 'Lao People\'s Democratic Republic', 'LA', 'LAO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (117, 'Latvia', 'LV', 'LVA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (118, 'Lebanon', 'LB', 'LBN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (119, 'Lesotho', 'LS', 'LSO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (120, 'Liberia', 'LR', 'LBR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (122, 'Liechtenstein', 'LI', 'LIE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (123, 'Lithuania', 'LT', 'LTU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (124, 'Luxembourg', 'LU', 'LUX', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (125, 'Macau', 'MO', 'MAC', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (126, 'FYROM', 'MK', 'MKD', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (127, 'Madagascar', 'MG', 'MDG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (128, 'Malawi', 'MW', 'MWI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (129, 'Malaysia', 'MY', 'MYS', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (130, 'Maldives', 'MV', 'MDV', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (131, 'Mali', 'ML', 'MLI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (132, 'Malta', 'MT', 'MLT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (133, 'Marshall Islands', 'MH', 'MHL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (134, 'Martinique', 'MQ', 'MTQ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (135, 'Mauritania', 'MR', 'MRT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (136, 'Mauritius', 'MU', 'MUS', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (137, 'Mayotte', 'YT', 'MYT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (138, 'Mexico', 'MX', 'MEX', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (139, 'Micronesia, Federated States of', 'FM', 'FSM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (140, 'Moldova, Republic of', 'MD', 'MDA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (141, 'Monaco', 'MC', 'MCO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (142, 'Mongolia', 'MN', 'MNG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (143, 'Montserrat', 'MS', 'MSR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (144, 'Morocco', 'MA', 'MAR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (145, 'Mozambique', 'MZ', 'MOZ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (146, 'Myanmar', 'MM', 'MMR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (147, 'Namibia', 'NA', 'NAM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (148, 'Nauru', 'NR', 'NRU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (149, 'Nepal', 'NP', 'NPL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (150, 'Netherlands', 'NL', 'NLD', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (151, 'Netherlands Antilles', 'AN', 'ANT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (152, 'New Caledonia', 'NC', 'NCL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (153, 'New Zealand', 'NZ', 'NZL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (154, 'Nicaragua', 'NI', 'NIC', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (155, 'Niger', 'NE', 'NER', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (156, 'Nigeria', 'NG', 'NGA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (157, 'Niue', 'NU', 'NIU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (158, 'Norfolk Island', 'NF', 'NFK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (159, 'Northern Mariana Islands', 'MP', 'MNP', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (160, 'Norway', 'NO', 'NOR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (161, 'Oman', 'OM', 'OMN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (162, 'Pakistan', 'PK', 'PAK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (163, 'Palau', 'PW', 'PLW', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (164, 'Panama', 'PA', 'PAN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (165, 'Papua New Guinea', 'PG', 'PNG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (166, 'Paraguay', 'PY', 'PRY', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (167, 'Peru', 'PE', 'PER', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (168, 'Philippines', 'PH', 'PHL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (169, 'Pitcairn', 'PN', 'PCN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (170, 'Poland', 'PL', 'POL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (171, 'Portugal', 'PT', 'PRT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (172, 'Puerto Rico', 'PR', 'PRI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (173, 'Qatar', 'QA', 'QAT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (174, 'Reunion', 'RE', 'REU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (175, 'Romania', 'RO', 'ROM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (176, 'Russian Federation', 'RU', 'RUS', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (177, 'Rwanda', 'RW', 'RWA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (179, 'Saint Lucia', 'LC', 'LCA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (181, 'Samoa', 'WS', 'WSM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (182, 'San Marino', 'SM', 'SMR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (183, 'Sao Tome and Principe', 'ST', 'STP', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (184, 'Saudi Arabia', 'SA', 'SAU', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (185, 'Senegal', 'SN', 'SEN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (186, 'Seychelles', 'SC', 'SYC', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (187, 'Sierra Leone', 'SL', 'SLE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (188, 'Singapore', 'SG', 'SGP', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (189, 'Slovak Republic', 'SK', 'SVK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (190, 'Slovenia', 'SI', 'SVN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (191, 'Solomon Islands', 'SB', 'SLB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (192, 'Somalia', 'SO', 'SOM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (193, 'South Africa', 'ZA', 'ZAF', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (195, 'Spain', 'ES', 'ESP', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (196, 'Sri Lanka', 'LK', 'LKA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (197, 'St. Helena', 'SH', 'SHN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (199, 'Sudan', 'SD', 'SDN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (200, 'Suriname', 'SR', 'SUR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (202, 'Swaziland', 'SZ', 'SWZ', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (203, 'Sweden', 'SE', 'SWE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (204, 'Switzerland', 'CH', 'CHE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (205, 'Syrian Arab Republic', 'SY', 'SYR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (206, 'Taiwan', 'TW', 'TWN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (207, 'Tajikistan', 'TJ', 'TJK', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (209, 'Thailand', 'TH', 'THA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (210, 'Togo', 'TG', 'TGO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (211, 'Tokelau', 'TK', 'TKL', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (212, 'Tonga', 'TO', 'TON', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (213, 'Trinidad and Tobago', 'TT', 'TTO', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (214, 'Tunisia', 'TN', 'TUN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (215, 'Turkey', 'TR', 'TUR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (216, 'Turkmenistan', 'TM', 'TKM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (217, 'Turks and Caicos Islands', 'TC', 'TCA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (218, 'Tuvalu', 'TV', 'TUV', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (219, 'Uganda', 'UG', 'UGA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (220, 'Ukraine', 'UA', 'UKR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (221, 'United Arab Emirates', 'AE', 'ARE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (222, 'United Kingdom', 'GB', 'GBR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (223, 'United States', 'US', 'USA', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (224, 'United States Minor Outlying Islands', 'UM', 'UMI', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (225, 'Uruguay', 'UY', 'URY', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (226, 'Uzbekistan', 'UZ', 'UZB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (227, 'Vanuatu', 'VU', 'VUT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (228, 'Vatican City State (Holy See)', 'VA', 'VAT', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (229, 'Venezuela', 'VE', 'VEN', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (230, 'Viet Nam', 'VN', 'VNM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (231, 'Virgin Islands (British)', 'VG', 'VGB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (234, 'Western Sahara', 'EH', 'ESH', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (235, 'Yemen', 'YE', 'YEM', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (236, 'Yugoslavia', 'YU', 'YUG', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (237, 'Democratic Republic of Congo', 'CD', 'COD', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (238, 'Zambia', 'ZM', 'ZMB', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (239, 'Zimbabwe', 'ZW', 'ZWE', 1);
INSERT INTO countries (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `status`) VALUES (241, 'Iana Island', 'SA', 'GAA', 1);


#
# TABLE STRUCTURE FOR: coupons
#

DROP TABLE IF EXISTS coupons;
CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` varchar(10) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,2) NOT NULL,
  `min_total` decimal(15,2) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO coupons (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES (11, 'Half Sundays', '2222', 'F', '100.00', '500.00', '', '0000-00-00', '0000-00-00', 1, '0000-00-00');
INSERT INTO coupons (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES (12, 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', '', '0000-00-00', '0000-00-00', 1, '0000-00-00');
INSERT INTO coupons (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES (13, 'Full Mondays', 'MTo6TuTg', 'P', '50.00', '0.00', '', '0000-00-00', '0000-00-00', 1, '0000-00-00');
INSERT INTO coupons (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES (14, 'Full Tuesdays', '4444', 'F', '500.00', '500.00', '', '2014-01-07', '2014-03-31', 1, '0000-00-00');
INSERT INTO coupons (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES (15, 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', '', '2014-01-12', '2014-03-31', 1, '0000-00-00');


#
# TABLE STRUCTURE FOR: currencies
#

DROP TABLE IF EXISTS currencies;
CREATE TABLE `currencies` (
  `currency_id` int(5) NOT NULL AUTO_INCREMENT,
  `currency_title` varchar(32) CHARACTER SET utf8 NOT NULL,
  `currency_code` varchar(3) CHARACTER SET utf8 NOT NULL,
  `currency_symbol` varchar(12) CHARACTER SET utf8 NOT NULL,
  `currency_status` int(1) NOT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO currencies (`currency_id`, `currency_title`, `currency_code`, `currency_symbol`, `currency_status`) VALUES (7, 'Pounds', 'GBP', '£', 1);
INSERT INTO currencies (`currency_id`, `currency_title`, `currency_code`, `currency_symbol`, `currency_status`) VALUES (8, 'US Dollars', 'USD', '$', 1);
INSERT INTO currencies (`currency_id`, `currency_title`, `currency_code`, `currency_symbol`, `currency_status`) VALUES (9, 'Euro', 'EUR', '€', 1);
INSERT INTO currencies (`currency_id`, `currency_title`, `currency_code`, `currency_symbol`, `currency_status`) VALUES (10, 'Chinese yuan', 'CNY', '¥', 0);


#
# TABLE STRUCTURE FOR: customers
#

DROP TABLE IF EXISTS customers;
CREATE TABLE `customers` (
  `customer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `email` varchar(96) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL,
  `salt` varchar(9) CHARACTER SET utf8 NOT NULL,
  `telephone` varchar(32) CHARACTER SET utf8 NOT NULL,
  `address_id` int(11) NOT NULL,
  `security_question_id` int(11) NOT NULL,
  `security_answer` varchar(32) CHARACTER SET utf8 NOT NULL,
  `date_added` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: departments
#

DROP TABLE IF EXISTS departments;
CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(32) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`department_id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

INSERT INTO departments (`department_id`, `department_name`, `permission`) VALUES (11, 'Adminstrator', 'a:2:{s:6:\"access\";a:41:{i:0;s:12:\"admin/backup\";i:1;s:16:\"admin/categories\";i:2;s:9:\"admin/cod\";i:3;s:15:\"admin/countries\";i:4;s:13:\"admin/coupons\";i:5;s:16:\"admin/currencies\";i:6;s:15:\"admin/customers\";i:7;s:17:\"admin/departments\";i:8;s:16:\"admin/error_logs\";i:9;s:16:\"admin/extensions\";i:10;s:13:\"admin/layouts\";i:11;s:15:\"admin/locations\";i:12;s:18:\"admin/menu_options\";i:13;s:11:\"admin/menus\";i:14;s:14:\"admin/messages\";i:15;s:20:\"admin/order_statuses\";i:16;s:12:\"admin/orders\";i:17;s:14:\"admin/payments\";i:18;s:20:\"admin/paypal_express\";i:19;s:13:\"admin/ratings\";i:20;s:18:\"admin/reservations\";i:21;s:22:\"admin/reserve_statuses\";i:22;s:13:\"admin/reviews\";i:23;s:24:\"admin/security_questions\";i:24;s:14:\"admin/settings\";i:25;s:14:\"admin/specials\";i:26;s:12:\"admin/staffs\";i:27;s:12:\"admin/tables\";i:28;s:16:\"admin/uri_routes\";i:29;s:20:\"admin/account_module\";i:30;s:17:\"admin/cart_module\";i:31;s:23:\"admin/categories_module\";i:32;s:18:\"admin/local_module\";i:33;s:20:\"admin/account_module\";i:34;s:20:\"admin/account_module\";i:35;s:20:\"admin/account_module\";i:36;s:18:\"admin/local_module\";i:37;s:23:\"admin/categories_module\";i:38;s:17:\"admin/cart_module\";i:39;s:20:\"admin/account_module\";i:40;s:20:\"admin/account_module\";}s:6:\"modify\";a:41:{i:0;s:12:\"admin/backup\";i:1;s:16:\"admin/categories\";i:2;s:9:\"admin/cod\";i:3;s:15:\"admin/countries\";i:4;s:13:\"admin/coupons\";i:5;s:16:\"admin/currencies\";i:6;s:15:\"admin/customers\";i:7;s:17:\"admin/departments\";i:8;s:16:\"admin/error_logs\";i:9;s:16:\"admin/extensions\";i:10;s:13:\"admin/layouts\";i:11;s:15:\"admin/locations\";i:12;s:18:\"admin/menu_options\";i:13;s:11:\"admin/menus\";i:14;s:14:\"admin/messages\";i:15;s:20:\"admin/order_statuses\";i:16;s:12:\"admin/orders\";i:17;s:14:\"admin/payments\";i:18;s:20:\"admin/paypal_express\";i:19;s:13:\"admin/ratings\";i:20;s:18:\"admin/reservations\";i:21;s:22:\"admin/reserve_statuses\";i:22;s:13:\"admin/reviews\";i:23;s:24:\"admin/security_questions\";i:24;s:14:\"admin/settings\";i:25;s:14:\"admin/specials\";i:26;s:12:\"admin/staffs\";i:27;s:12:\"admin/tables\";i:28;s:16:\"admin/uri_routes\";i:29;s:20:\"admin/account_module\";i:30;s:17:\"admin/cart_module\";i:31;s:23:\"admin/categories_module\";i:32;s:18:\"admin/local_module\";i:33;s:20:\"admin/account_module\";i:34;s:20:\"admin/account_module\";i:35;s:20:\"admin/account_module\";i:36;s:18:\"admin/local_module\";i:37;s:23:\"admin/categories_module\";i:38;s:17:\"admin/cart_module\";i:39;s:20:\"admin/account_module\";i:40;s:20:\"admin/account_module\";}}');
INSERT INTO departments (`department_id`, `department_name`, `permission`) VALUES (12, 'Manager', 'a:1:{i:0;s:5:\"EMPTY\";}');
INSERT INTO departments (`department_id`, `department_name`, `permission`) VALUES (13, 'Lower', '');


#
# TABLE STRUCTURE FOR: extensions
#

DROP TABLE IF EXISTS extensions;
CREATE TABLE `extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) CHARACTER SET utf8 NOT NULL,
  `code` varchar(45) CHARACTER SET utf8 NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`extension_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

INSERT INTO extensions (`extension_id`, `type`, `code`, `name`) VALUES (33, 'module', 'local', 'Local');
INSERT INTO extensions (`extension_id`, `type`, `code`, `name`) VALUES (34, 'module', 'categories', 'Categories');
INSERT INTO extensions (`extension_id`, `type`, `code`, `name`) VALUES (35, 'module', 'cart', 'Cart');
INSERT INTO extensions (`extension_id`, `type`, `code`, `name`) VALUES (37, 'module', 'account', 'Account');


#
# TABLE STRUCTURE FOR: layout_routes
#

DROP TABLE IF EXISTS layout_routes;
CREATE TABLE `layout_routes` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `uri_route_id` int(11) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (46, 12, 2);
INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (47, 13, 1);
INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (48, 14, 5);
INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (55, 11, 12);
INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (56, 11, 13);
INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (57, 11, 14);
INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (58, 11, 15);
INSERT INTO layout_routes (`layout_route_id`, `layout_id`, `uri_route_id`) VALUES (59, 11, 16);


#
# TABLE STRUCTURE FOR: layouts
#

DROP TABLE IF EXISTS layouts;
CREATE TABLE `layouts` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO layouts (`layout_id`, `name`) VALUES (11, 'Account');
INSERT INTO layouts (`layout_id`, `name`) VALUES (12, 'Menus');
INSERT INTO layouts (`layout_id`, `name`) VALUES (13, 'Checkout');
INSERT INTO layouts (`layout_id`, `name`) VALUES (14, 'Payments');


#
# TABLE STRUCTURE FOR: location_tables
#

DROP TABLE IF EXISTS location_tables;
CREATE TABLE `location_tables` (
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  PRIMARY KEY (`location_id`,`table_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 1);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 2);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 6);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 7);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 8);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 9);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 10);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 11);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (115, 12);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (116, 2);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (116, 7);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (116, 9);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (116, 10);
INSERT INTO location_tables (`location_id`, `table_id`) VALUES (122, 13);


#
# TABLE STRUCTURE FOR: locations
#

DROP TABLE IF EXISTS locations;

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `location_email` varchar(96) NOT NULL,
  `location_address_1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `location_address_2` varchar(128) CHARACTER SET utf8 NOT NULL,
  `location_city` varchar(128) CHARACTER SET utf8 NOT NULL,
  `location_postcode` varchar(10) CHARACTER SET utf8 NOT NULL,
  `location_country_id` int(11) NOT NULL,
  `location_telephone` varchar(32) CHARACTER SET utf8 NOT NULL,
  `location_lat` float(10,6) NOT NULL,
  `location_lng` float(10,6) NOT NULL,
  `location_radius` int(11) NOT NULL,
  `offer_delivery` tinyint(1) NOT NULL,
  `offer_collection` tinyint(1) NOT NULL,
  `ready_time` int(11) NOT NULL,
  `delivery_charge` decimal(15,2) NOT NULL,
  `min_delivery_total` decimal(15,2) NOT NULL,
  `location_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (115, 'Harrow', 'harrow@tastyigniter.com', '14 Lime Close', '', 'Greater London', 'HA3 7JD', 222, '02088279101', '51.600262', '-0.325915', 25, 1, 1, 45, '10.00', '500.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (116, 'Earling', 'ealing@tastyIgniter.com', '8 Brookfield Avenue', '', 'Greater London', 'W5 1LA', 222, '02088279102', '51.526852', '-0.301442', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (117, 'Hackney', 'hackney@tastyigniter.com', '44 Darnley Road', '', 'Greater London', 'E9 6QH', 222, '02088279103', '51.544060', '-0.053999', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (119, 'Lambert', '', '30-34 Old Paradise Street', '', 'Greater London', 'SE11 6AX', 222, '02088279105', '51.493713', '-0.117626', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (120, 'Camden', '', '22 Kingsford Street', '', 'Greater London', 'NW5 4JT', 222, '02088279106', '51.551853', '-0.158162', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (121, 'Greenwich', '', '50 Vanbrugh Hill', '', 'Greater London', 'SE10 9HF', 222, '02088279107', '51.483055', '-0.003908', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (122, 'Lewisham', 'lewisham@tastyIgniter.com', '35 Lewisham High Street', '', 'Greater London', 'SE13 7HS', 222, '02088279108', '51.461731', '-0.011749', 25, 1, 0, 45, '10.00', '1000.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (123, 'Bromley', '', 'Harmony Way', '', 'Greater London', 'BR1 7HN', 222, '02088279109', '51.406155', '0.013073', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (124, 'Croydon', '', '26 Wellesley Road', '', 'Greater London', 'CR0 9XY', 222, '02088279110', '51.376038', '-0.097698', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (130, 'Westminster', '', '2 Caxton Street', '', 'Greater London', 'SW1H 0QW', 222, '02088279101', '51.498798', '-0.134334', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (131, 'Canary Wharf', '', '8 Firmount Avenue', '', 'Greater London', 'E14 9HH', 222, '02088279101', '51.506569', '-0.004563', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (135, 'Excel', 'excel@tastyigniter.com', '1 Western Gateway', 'Royal Victoria Dock', 'Greater London', 'E16 1XL', 222, '02088279114', '51.508492', '0.025040', 25, 1, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (136, 'Manchester', '', 'Sir Matt Busby Way', 'Old Trafford', 'Greater Manchester', 'M16 0RA', 222, '2030211', '53.462559', '-2.291032', 25, 0, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (141, 'Chaucer Place', 'chaucer@tastyIgniter.com', '40 Princess Street', '', 'London', 'SE16JS', 222, '0230302023', '51.495560', '-0.102558', 30, 1, 0, 0, '0.00', '0.00', 1);
INSERT INTO locations (`location_id`, `location_name`, `location_email`, `location_address_1`, `location_address_2`, `location_city`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `ready_time`, `delivery_charge`, `min_delivery_total`, `location_status`) VALUES (142, 'The Palms Shopping Mall', 'lagos@tastyigniter.com', 'Ozumba Mbadiwe Road', '', 'Lekki Peninsula', '101', 222, '33333333333', '6.439546', '3.430483', 30, 0, 0, 0, '0.00', '0.00', 1);


#
# TABLE STRUCTURE FOR: menu_options
#

DROP TABLE IF EXISTS menu_options;
CREATE TABLE `menu_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(32) NOT NULL,
  `option_price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO menu_options (`option_id`, `option_name`, `option_price`) VALUES (1, 'Chicken', '14.00');
INSERT INTO menu_options (`option_id`, `option_name`, `option_price`) VALUES (2, 'Fish', '20.00');
INSERT INTO menu_options (`option_id`, `option_name`, `option_price`) VALUES (3, 'Meat', '3.00');
INSERT INTO menu_options (`option_id`, `option_name`, `option_price`) VALUES (4, 'Beef', '9.00');
INSERT INTO menu_options (`option_id`, `option_name`, `option_price`) VALUES (11, 'Turkey', '4.00');


#
# TABLE STRUCTURE FOR: menus
#

DROP TABLE IF EXISTS menus;
CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `menu_description` text CHARACTER SET utf8 NOT NULL,
  `menu_price` decimal(15,2) NOT NULL,
  `menu_photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `menu_category_id` int(11) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `minimum_qty` int(11) NOT NULL,
  `subtract_stock` tinyint(1) NOT NULL,
  `menu_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (25, 'BUNS', '(Halibut fish, Salt, Pepper, Olive Oil, Flour, Butter, Garlic, Onion, Powder)', '100.00', 'buns.jpg', 15, 832, 3, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (26, 'STEAMED RICE', '', '70.00', 'steamed_rice.jpg', 24, 851, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (31, 'CHIN-CHIN', '', '200.00', 'chin-chin.jpg', 15, 960, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (32, 'SCOTCH EGG', '', '200.00', 'scotch_egg1.jpg', 15, 951, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (33, 'JOLLOF RICE', '', '70.00', 'jollof_rice.jpg', 24, 82, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (34, 'PUFF-PUFF', '', '22.00', 'puff_puff.jpg', 15, 82, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (38, 'VEGETABLE FRIED RICE', '', '9.99', 'vegetable-fried-rice.jpg', 16, 102, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (39, 'Boli and Epa', '', '5.00', 'boliandepa.jpg', 15, 1000, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (40, 'Akara', '', '3.00', 'akara.jpg', 15, 100, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (41, 'Rice and Beans', '', '12.00', 'rice_and_beans.jpg', 16, 1000, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (45, 'Rice and Dodo', '', '9.00', 'rice_and_dodo.jpg', 16, 1000, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (46, 'Pounded Yam', '', '12.00', 'pounded_yam.jpg', 16, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (47, 'Coconut Rice', '', '9.00', 'coconut_rice.jpg', 16, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (48, 'Eba', '', '12.00', 'eba-and-soup.jpg', 16, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (49, 'Yam Porridge', '', '9.99', 'yam_porridge.jpg', 16, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (50, 'African Salad', '', '3.00', '0', 17, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (52, 'Spinach Salad', '', '3.00', 'Spinach_Salad.jpg', 17, 94, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (53, 'Seafood Salad', '', '3.00', 'seafoods_salad.JPG', 17, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (54, 'Cheese Cake', '', '3.00', 'cheeasecake.jpg', 22, 70, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (55, 'MEAT PIE', '', '3.99', 'meat_pie.jpg', 15, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (56, 'SUYA (PEPPER STEAK MEAT)', '', '3.99', 'suya.jpg', 15, 1000, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (57, 'BEANS AND CORN', '', '9.99', 'bean-and-corn-salad.jpg', 16, 1000, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (58, 'GRILLED CHICKEN SPINACH SALAD', '', '4.99', 'Seared_Ahi_Spinach_Salad.jpg', 24, 4, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (59, 'SPECIAL SHRIMP DELUXE', '', '9.99', 'deluxe_bbq_shrimp-1.jpg', 18, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (60, 'SAUTEED CATFISH FILLET WITH RICE AND VEGETABLES', '(Regular naija beans, Salt, Black Pepper, Fresh Tomatoes, Onion, Red Bell Pepper, Maggi, Palm Oil, Beef)', '20.00', 'MS-pan_seared_Mississippi_catfish_on_a_bed_of_river_rice.jpg', 24, 89, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (61, 'FRIED TILAPIA FILLET WITH RICE AND VEGETABLES', '', '20.00', 'DSC_0149-2.jpg', 24, 100, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (62, 'POUNDED YAM', '', '20.00', 'pounded_yam.jpg', 19, -2, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (64, 'WHOLE CATFISH', '', '220.00', 'FriedWholeCatfishPlate_lg.jpg', 18, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (65, 'WHOLE TILAPIA', '', '120.00', 'grilledtilapiatomatoescilantro1.jpg', 18, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (66, 'AMALA(YAM FLOUR)', '', '220.00', 'DSCF3711.JPG', 19, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (67, 'EBA (GRATED CASSAVA)', '', '90.00', 'Eba-(1).jpg', 19, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (68, 'VEGETABLE WITH MIXED VEGETABLES w/coconut rice', '', '122.00', 'short_ribs.JPG', 20, 90, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (69, 'BOILED Plantain w/spinach soup', '', '122.00', 'grilledtilapiatomatoescilantro1.jpg', 20, 0, 1, 0, 1);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (70, 'Testy', '', '23.00', '', 18, 0, 1, 0, 0);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (71, 'Testy', '', '23.00', '', 19, 0, 1, 0, 0);
INSERT INTO menus (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES (72, 'Testy', '', '3333.00', '', 0, 0, 1, 0, 0);


#
# TABLE STRUCTURE FOR: menus_specials
#

DROP TABLE IF EXISTS menus_specials;
CREATE TABLE `menus_specials` (
  `special_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `special_price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`special_id`,`menu_id`),
  UNIQUE KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

INSERT INTO menus_specials (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`) VALUES (17, 68, '2013-11-11', '2014-03-29', '7.00');
INSERT INTO menus_specials (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`) VALUES (21, 60, '2013-11-03', '2014-02-13', '30.00');
INSERT INTO menus_specials (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`) VALUES (20, 61, '2013-11-01', '2014-03-07', '30.00');
INSERT INTO menus_specials (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`) VALUES (22, 58, '2013-11-10', '2014-01-31', '50.00');
INSERT INTO menus_specials (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`) VALUES (36, 33, '2013-12-17', '2014-01-10', '700.00');


#
# TABLE STRUCTURE FOR: menus_to_options
#

DROP TABLE IF EXISTS menus_to_options;
CREATE TABLE `menus_to_options` (
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`,`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (26, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (26, 3);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (33, 11);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (38, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (38, 8);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (41, 2);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (46, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (46, 2);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (46, 3);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (46, 11);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (48, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (48, 5);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (48, 7);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (55, 4);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (67, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (67, 2);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (67, 12);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (67, 13);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (74, 2);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (74, 3);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (75, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (76, 0);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (76, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (76, 2);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (77, 1);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (77, 2);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (77, 3);
INSERT INTO menus_to_options (`menu_id`, `option_id`) VALUES (77, 4);


#
# TABLE STRUCTURE FOR: messages
#

DROP TABLE IF EXISTS messages;
CREATE TABLE `messages` (
  `message_id` int(15) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `type` varchar(32) NOT NULL,
  `subject` text CHARACTER SET utf8 NOT NULL,
  `body` text CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: order_menus
#

DROP TABLE IF EXISTS order_menus;
CREATE TABLE `order_menus` (
  `order_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `options` text NOT NULL,
  PRIMARY KEY (`order_menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: order_options
#

DROP TABLE IF EXISTS order_options;
CREATE TABLE `order_options` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `option_price` decimal(15,2) NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: orders
#

DROP TABLE IF EXISTS orders;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_customer_id` int(11) NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `email` varchar(96) CHARACTER SET utf8 NOT NULL,
  `telephone` varchar(32) CHARACTER SET utf8 NOT NULL,
  `order_location_id` int(11) NOT NULL,
  `order_address_id` int(11) NOT NULL,
  `cart` text CHARACTER SET utf8 NOT NULL,
  `total_items` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `payment` varchar(35) NOT NULL,
  `order_type` varchar(32) CHARACTER SET utf8 NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` date NOT NULL,
  `order_time` time NOT NULL,
  `order_total` decimal(15,2) NOT NULL,
  `status_id` int(11) NOT NULL,
  `order_staff_id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2400 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: payments
#

DROP TABLE IF EXISTS payments;
CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `payment_desc` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO payments (`payment_id`, `payment_name`, `payment_desc`) VALUES (1, 'Cash On Delivery', 'Pay on delivery');
INSERT INTO payments (`payment_id`, `payment_name`, `payment_desc`) VALUES (4, 'PayPal', 'Paypal payment');


#
# TABLE STRUCTURE FOR: pp_payments
#

DROP TABLE IF EXISTS pp_payments;
CREATE TABLE `pp_payments` (
  `transaction_id` varchar(19) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `serialized` text NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: reservations
#

DROP TABLE IF EXISTS reservations;
CREATE TABLE `reservations` (
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
  `notify` tinyint(4) NOT NULL,
  `ip_address` varchar(40) CHARACTER SET utf8 NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`reservation_id`),
  KEY `location_id` (`location_id`,`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2400 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: reviews
#

DROP TABLE IF EXISTS reviews;
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `author` varchar(32) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `rating_id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `date_added` date NOT NULL,
  `review_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `customer_id` (`customer_id`,`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: security_questions
#

DROP TABLE IF EXISTS security_questions;
CREATE TABLE `security_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` text NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO security_questions (`question_id`, `question_text`) VALUES (8, 'Whats your pets name?');
INSERT INTO security_questions (`question_id`, `question_text`) VALUES (9, 'What high school did you attend?');
INSERT INTO security_questions (`question_id`, `question_text`) VALUES (10, 'What is your father\'s middle name?');
INSERT INTO security_questions (`question_id`, `question_text`) VALUES (11, 'What is your mother\'s name?');
INSERT INTO security_questions (`question_id`, `question_text`) VALUES (13, 'What is your place of birth?');
INSERT INTO security_questions (`question_id`, `question_text`) VALUES (14, 'Whats your favourite teacher\'s name?');


#
# TABLE STRUCTURE FOR: settings
#

DROP TABLE IF EXISTS settings;
CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` varchar(45) NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=2081 DEFAULT CHARSET=utf8;

INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2080, 'config', 'log_path', '', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2079, 'config', 'log_threshold', '1', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2072, 'config', 'menus_width', '80', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2071, 'config', 'menus_height', '70', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2070, 'config', 'max_width', '6024', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2069, 'config', 'max_height', '4468', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2067, 'config', 'allowed_types', 'gif|jpg|png', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2068, 'config', 'max_size', '300', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2066, 'config', 'upload_path', 'assets/img', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2065, 'config', 'reserve_prefix', '1', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2064, 'config', 'reserve_status', '8', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2063, 'config', 'ready_time', '45', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2062, 'config', 'order_completed', '5', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2061, 'config', 'order_received', '2', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2060, 'config', 'allow_order', '1', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2059, 'config', 'distance_unit', 'mi', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2058, 'config', 'search_by', 'postcode', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2057, 'config', 'approve_reviews', '0', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2056, 'config', 'currency_id', '7', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2054, 'config', 'country_id', '222', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2053, 'config', 'site_logo', 'logo.png', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2052, 'config', 'page_limit', '20', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2049, 'config', 'site_name', 'TastyIgniter', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (2050, 'config', 'site_email', 'info@tastyigniter.com', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1856, 'account', 'account_module', 'a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"11\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}', 1);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1069, 'cart', 'cart_module', 'a:3:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:9:\"layout_id\";s:2:\"13\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:9:\"layout_id\";s:2:\"14\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"2\";s:6:\"status\";s:1:\"1\";}}', 1);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1070, 'categories', 'categories_module', 'a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}', 1);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1330, 'local', 'local_module', 'a:3:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:9:\"layout_id\";s:2:\"13\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:9:\"layout_id\";s:2:\"14\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}', 1);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1788, 'ratings', 'ratings', 'a:5:{i:1;s:3:\"Bad\";i:2;s:5:\"Worse\";i:3;s:4:\"Good\";i:4;s:7:\"Average\";i:5;s:9:\"Excellent\";}', 1);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1076, 'cod', 'cod_status', '1', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1075, 'cod', 'cod_order_status', '2', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (1074, 'cod', 'cod_total', '1', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (738, 'paypal_express', 'paypal_order_status', '2', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (736, 'paypal_express', 'paypal_sign', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AYzY6RzJVWuquyjw.VYZbV7LatXv', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (737, 'paypal_express', 'paypal_action', 'sale', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (735, 'paypal_express', 'paypal_pass', '1381080165', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (734, 'paypal_express', 'paypal_user', 'samadepoyigi-facilitator_api1.gmail.com', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (733, 'paypal_express', 'paypal_mode', 'sandbox', 0);
INSERT INTO settings (`setting_id`, `sort`, `key`, `value`, `serialized`) VALUES (732, 'paypal_express', 'paypal_status', '1', 0);


#
# TABLE STRUCTURE FOR: staffs
#

DROP TABLE IF EXISTS staffs;
CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `staff_email` varchar(96) CHARACTER SET utf8 NOT NULL,
  `staff_department` int(11) NOT NULL,
  `staff_location` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `staff_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


#
# TABLE STRUCTURE FOR: statuses
#

DROP TABLE IF EXISTS statuses;
CREATE TABLE `statuses` (
  `status_id` int(15) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(45) CHARACTER SET utf8 NOT NULL,
  `status_comment` text CHARACTER SET utf8 NOT NULL,
  `notify_customer` tinyint(1) NOT NULL,
  `status_for` varchar(10) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (1, 'Received', 'Your order has been received.', 1, 'order');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (2, 'Pending', 'Your order is pending', 1, 'order');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (3, 'Preparation', 'Your order is in the kitchen', 1, 'order');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (4, 'Delivery', 'Your order will be with you shortly.', 0, 'order');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (5, 'Completed', '', 0, 'order');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (8, 'Reserved', 'Your table has been reserved.', 0, 'reserve');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (9, 'Pick Up', 'Your order is ready for collection.', 0, 'reserve');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (11, 'Pending', '', 0, 'reserve');
INSERT INTO statuses (`status_id`, `status_name`, `status_comment`, `notify_customer`, `status_for`) VALUES (12, 'Pick Up', 'Your order is ready for collection.', 0, 'reserve');


#
# TABLE STRUCTURE FOR: tables
#

DROP TABLE IF EXISTS tables;
CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `min_capacity` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `table_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (1, 'NN01', 2, 2, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (2, 'NN02', 2, 3, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (6, 'SW77', 2, 4, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (7, 'EW77', 4, 8, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (8, 'SE78', 4, 6, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (9, 'NE8', 2, 10, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (10, 'SW55', 3, 10, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (11, 'EW88', 2, 10, 0);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (12, 'EE732', 2, 8, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (13, 'EW79', 2, 15, 1);
INSERT INTO tables (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES (14, 'FW79', 4, 10, 0);

#
# TABLE STRUCTURE FOR: uri_routes
#

DROP TABLE IF EXISTS uri_routes;
CREATE TABLE `uri_routes` (
  `uri_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) NOT NULL,
  `controller` varchar(64) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`uri_route_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (1, 'checkout', 'main/checkout', 8, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (2, 'menus', 'main/menus', 4, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (3, 'aboutus', 'main/home/aboutus', 2, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (4, 'contact', 'main/contact', 3, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (5, 'payments', 'main/payments', 9, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (6, 'find/table', 'main/find_table', 19, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (7, 'reserve/table', 'main/reserve_table', 20, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (8, 'account/login', 'main/login', 10, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (10, 'account/register', 'main/register', 12, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (11, 'account/password/reset', 'main/password_reset', 18, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (12, 'account', 'main/account', 13, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (13, 'account/details', 'main/details', 14, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (14, 'account/address', 'main/address', 15, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (15, 'account/orders', 'main/orders', 16, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (16, 'account/inbox', 'main/inbox', 17, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (17, 'menus/category/:num', 'main/menus', 5, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (18, 'menus/review', 'main/menus/review', 6, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (19, 'menus/write_review', 'main/menus/write_review', 7, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (29, 'account/logout', 'main/logout', 11, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (30, 'home', 'main/home', 1, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (31, 'checkout/success', 'main/checkout/success', 0, 1);
INSERT INTO uri_routes (`uri_route_id`, `route`, `controller`, `priority`, `status`) VALUES (32, 'account/inbox/view/:num', 'main/inbox/view', 21, 1);

#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL,
  `salt` varchar(9) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`user_id`,`staff_id`,`username`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: working_hours
#

DROP TABLE IF EXISTS working_hours;
CREATE TABLE `working_hours` (
  `location_id` int(11) NOT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  PRIMARY KEY (`location_id`,`weekday`),
  KEY `weekday` (`weekday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO working_hours (`location_id`, `weekday`, `opening_time`, `closing_time`) VALUES (122, 0, '11:00:00', '23:00:00');
INSERT INTO working_hours (`location_id`, `weekday`, `opening_time`, `closing_time`) VALUES (122, 1, '11:00:00', '23:00:00');
INSERT INTO working_hours (`location_id`, `weekday`, `opening_time`, `closing_time`) VALUES (122, 2, '11:00:00', '23:00:00');
INSERT INTO working_hours (`location_id`, `weekday`, `opening_time`, `closing_time`) VALUES (122, 3, '11:00:00', '23:00:00');
INSERT INTO working_hours (`location_id`, `weekday`, `opening_time`, `closing_time`) VALUES (122, 4, '11:00:00', '23:00:00');
INSERT INTO working_hours (`location_id`, `weekday`, `opening_time`, `closing_time`) VALUES (122, 5, '11:00:00', '23:00:00');
INSERT INTO working_hours (`location_id`, `weekday`, `opening_time`, `closing_time`) VALUES (122, 6, '11:00:00', '23:00:00');