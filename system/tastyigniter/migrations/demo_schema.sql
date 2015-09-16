#
# TABLE STRUCTURE FOR: ti_categories
#

REPLACE INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`)
VALUES
	(15, 'Appetizer', '', 0, 'data/no_photo.png'),
	(16, 'Main Course', '', 0, ''),
	(17, 'Salads', '', 0, ''),
	(18, 'Seafoods', '', 0, ''),
	(19, 'Traditional', '', 0, ''),
	(20, 'Vegetarian', '', 0, ''),
	(21, 'Soups', '', 0, ''),
	(22, 'Desserts', '', 0, ''),
	(23, 'Drinks', '', 0, ''),
	(24, 'Specials', '', 0, ''),
	(26, 'Rice Dishes', '', 16, 'data/vegetable-fried-rice.jpg');


#
# TABLE STRUCTURE FOR: ti_coupons
#

REPLACE INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`, `description`, `status`, `date_added`) VALUES
(11, 'Half Sundays', '2222', 'F', '100.00', '500.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00'),
(12, 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00'),
(13, 'Full Mondays', 'MTo6TuTg', 'P', '50.00', '0.00', 0, 1, 'forever', NULL, '00:00:00', '23:59:00', NULL, NULL, '', '00:00:00', '23:59:00', '', 1, '0000-00-00'),
(14, 'Full Tuesdays', '4444', 'F', '500.00', '5000.00', 0, 0, 'recurring', NULL, '00:00:00', '23:59:00', NULL, NULL, '0, 2, 4, 5, 6', '00:00:00', '23:59:00', '', 1, '0000-00-00'),
(15, 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00');

#
# TABLE STRUCTURE FOR: ti_location_tables
#

REPLACE INTO `ti_location_tables` (`location_id`, `table_id`)
VALUES
  (11, 7),
  (11, 16),
  (11, 17),
  (11, 18),
  (11, 19),
  (11, 20),
  (11, 22);

#
# TABLE STRUCTURE FOR: ti_locations
#

REPLACE INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `last_order_time`, `reservation_time_interval`, `reservation_stay_time`, `location_status`, `collection_time`, `options`, `location_image`)
VALUES
  (11, 'Lewisham', 'lewisham@tastyigniter.com', 'Mauris maximus tempor ligula vitae placerat. Proin at orci fermentum, aliquam turpis sit amet, ultrices risus. Donec pellentesque justo in pharetra rutrum. Cras ac dui eu orci lacinia consequat vitae quis sapien. Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada. Mauris iaculis ac nisi at euismod. Nunc sit amet luctus ipsum. Pellentesque eget lobortis turpis. Vivamus mattis, massa ac vulputate vulputate, risus purus tincidunt nibh, vitae pellentesque ex nibh at mi. Donec placerat, urna quis interdum tempus, tellus nulla commodo leo, vitae auctor orci est congue eros. In vel ex quis orci blandit porttitor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus tincidunt risus non mattis semper.', '44 Darnley Road', '', 'Greater London', '', 'E9 6QH', 222, '1203392202', 51.544060, -0.053999, 0, 1, 1, 20, 0, 0, 0, 1, 10, 'a:3:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}}}s:8:\"payments\";a:2:{i:0;s:3:\"cod\";i:1;s:14:\"paypal_express\";}s:14:\"delivery_areas\";a:4:{i:1;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"_yryHzpHff@??d~@gf@?\"}]\";s:8:\"vertices\";s:219:\"[{\"lat\":51.547200000000004,\"lng\":-0.048940000000000004},{\"lat\":51.54092000000001,\"lng\":-0.048940000000000004},{\"lat\":51.54092000000001,\"lng\":-0.059050000000000005},{\"lat\":51.547200000000004,\"lng\":-0.059050000000000005}]\";s:6:\"circle\";s:71:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}i:2;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"kvtyHrfJrmA??j}BsmA?\"}]\";s:8:\"vertices\";s:177:\"[{\"lat\":51.55702,\"lng\":-0.05754000000000001},{\"lat\":51.54444,\"lng\":-0.05754000000000001},{\"lat\":51.54444,\"lng\":-0.07776000000000001},{\"lat\":51.55702,\"lng\":-0.07776000000000001}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":1000}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 2\";s:6:\"charge\";s:1:\"4\";s:10:\"min_amount\";s:2:\"10\";}i:3;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"kvuyH`dBztB??r|D{tB?\"}]\";s:8:\"vertices\";s:147:\"[{\"lat\":51.56214000000001,\"lng\":-0.01617},{\"lat\":51.54328,\"lng\":-0.01617},{\"lat\":51.54328,\"lng\":-0.04651},{\"lat\":51.56214000000001,\"lng\":-0.04651}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":1500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 3\";s:6:\"charge\";s:2:\"30\";s:10:\"min_amount\";s:3:\"300\";}i:4;a:7:{s:5:\"shape\";s:34:\"[{\"shape\":\"gmqyHlhEf|C??x{Fg|C?\"}]\";s:8:\"vertices\";s:193:\"[{\"lat\":51.540200000000006,\"lng\":-0.03223},{\"lat\":51.515040000000006,\"lng\":-0.03223},{\"lat\":51.515040000000006,\"lng\":-0.07268000000000001},{\"lat\":51.540200000000006,\"lng\":-0.07268000000000001}]\";s:6:\"circle\";s:72:\"[{\"center\":{\"lat\":51.54406,\"lng\":-0.05399899999997615}},{\"radius\":2000}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 4\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"200\";}}}', 'data/meat_pie.jpg'),
  (12, 'Hackney\'s Branch', 'hackney@tastyigniter.com', 'Vestibulum mattis elementum justo quis vehicula. Fusce a elementum tellus, non tincidunt felis. Maecenas a dui dictum, dictum risus id, tempor enim. Curabitur fermentum elit eu iaculis tristique. Sed lobortis purus sed dui rhoncus fringilla. Integer orci ante, placerat a purus vel, commodo convallis nisi. Maecenas tristique, dui in ullamcorper hendrerit, dui odio pellentesque erat, rutrum vulputate enim ante vel nulla.', '400 Lewisham Way', '', 'Lewisham', '', 'SE10 9HF', 222, '949200202', 51.469627, -0.008745, 0, 1, 1, 0, 0, 0, 0, 1, 0, 'a:1:{s:13:\"opening_hours\";a:4:{s:12:\"opening_type\";s:5:\"daily\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:7:\"2:00 AM\";s:5:\"close\";s:7:\"5:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}}', 'data/steamed_rice.jpg'),
  (13, 'Earling Closed', 'earling@tastyigniter.com', '', '14 Lime Close', '', 'London', '', 'HA3 7JG', 222, '949200202', 51.600262, -0.325915, 0, 0, 1, 0, 0, 0, 0, 1, 0, 'a:2:{s:13:\"opening_hours\";a:3:{s:12:\"opening_type\";s:5:\"daily\";s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"0\";}}}s:14:\"delivery_areas\";a:3:{i:1;a:7:{s:5:\"shape\";s:35:\"[{\"shape\":\"ix}yHht}@hf@??h~@if@?\"}]\";s:8:\"vertices\";s:211:\"[{\"lat\":51.60340610349442,\"lng\":-0.32085320675355433},{\"lat\":51.59711789650558,\"lng\":-0.32085320675355433},{\"lat\":51.59711789650558,\"lng\":-0.3309767932464638},{\"lat\":51.60340610349442,\"lng\":-0.3309767932464638}]\";s:6:\"circle\";s:94:\"[{\"center\":{\"lat\":51.62179581812303,\"lng\":-0.37947844769109906}},{\"radius\":2327.919015915706}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 1\";s:6:\"charge\";s:1:\"0\";s:10:\"min_amount\";s:1:\"0\";}i:2;a:7:{s:5:\"shape\";s:35:\"[{\"shape\":\"}k~yHtt|@rmA??p}BsmA?\"}]\";s:8:\"vertices\";s:215:\"[{\"lat\":51.606550206988835,\"lng\":-0.31579141345764583},{\"lat\":51.593973793011166,\"lng\":-0.31579141345764583},{\"lat\":51.593973793011166,\"lng\":-0.3360385865423723},{\"lat\":51.606550206988835,\"lng\":-0.3360385865423723}]\";s:6:\"circle\";s:93:\"[{\"center\":{\"lat\":51.5834115850791,\"lng\":-0.3441036832577993}},{\"radius\":1997.0467357168989}]\";s:4:\"type\";s:6:\"circle\";s:4:\"name\";s:6:\"Area 2\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:3:\"100\";}i:3;a:7:{s:5:\"shape\";s:41:\"[{\"shape\":\"osbzHxjr@xhFfiHjdCxiQogJ}x@\"}]\";s:8:\"vertices\";s:212:\"[{\"lat\":51.62823967264574,\"lng\":-0.26300775726963366},{\"lat\":51.590829689516745,\"lng\":-0.3107296200626024},{\"lat\":51.56949495892793,\"lng\":-0.40461508941007196},{\"lat\":51.62717405249217,\"lng\":-0.3953453750546032}]\";s:6:\"circle\";s:73:\"[{\"center\":{\"lat\":51.600262,\"lng\":-0.32591500000000906}},{\"radius\":1500}]\";s:4:\"type\";s:5:\"shape\";s:4:\"name\";s:6:\"Area 3\";s:6:\"charge\";s:2:\"10\";s:10:\"min_amount\";s:1:\"0\";}}}', 'data/pesto.jpg');

#
# TABLE STRUCTURE FOR: ti_menu_options
#

REPLACE INTO `ti_menu_options` (`menu_option_id`, `menu_id`, `option_id`, `required`, `option_values`) VALUES
(22, 85, 22, 1, 'a:3:{i:3;a:3:{s:15:"option_value_id";s:1:"8";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}i:4;a:3:{s:15:"option_value_id";s:1:"9";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}i:5;a:3:{s:15:"option_value_id";s:2:"10";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}}'),
(23, 81, 23, 0, 'a:3:{i:1;a:3:{s:15:"option_value_id";s:1:"7";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}i:2;a:3:{s:15:"option_value_id";s:1:"6";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}i:3;a:3:{s:15:"option_value_id";s:2:"15";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}}'),
(24, 85, 24, 1, 'a:2:{i:1;a:3:{s:15:"option_value_id";s:2:"13";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}i:2;a:3:{s:15:"option_value_id";s:2:"14";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:0:"";}}'),
(25, 84, 22, 0, 'a:3:{i:1;a:3:{s:15:"option_value_id";s:1:"8";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"52";}i:2;a:3:{s:15:"option_value_id";s:1:"9";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"53";}i:3;a:3:{s:15:"option_value_id";s:2:"11";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"54";}}'),
(26, 79, 22, 0, 'a:5:{i:1;a:3:{s:15:"option_value_id";s:1:"8";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"55";}i:2;a:3:{s:15:"option_value_id";s:1:"9";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"56";}i:3;a:3:{s:15:"option_value_id";s:2:"10";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"57";}i:4;a:3:{s:15:"option_value_id";s:2:"11";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"58";}i:5;a:3:{s:15:"option_value_id";s:2:"12";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"59";}}'),
(27, 79, 24, 1, 'a:2:{i:6;a:3:{s:15:"option_value_id";s:2:"13";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"60";}i:7;a:3:{s:15:"option_value_id";s:2:"14";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"61";}}'),
(28, 78, 22, 1, 'a:5:{i:1;a:3:{s:15:"option_value_id";s:1:"8";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"62";}i:2;a:3:{s:15:"option_value_id";s:1:"9";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"63";}i:3;a:3:{s:15:"option_value_id";s:2:"10";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"64";}i:4;a:3:{s:15:"option_value_id";s:2:"11";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"65";}i:5;a:3:{s:15:"option_value_id";s:2:"12";s:5:"price";s:0:"";s:20:"menu_option_value_id";s:2:"66";}}');


#
# TABLE STRUCTURE FOR: ti_menu_option_values
#

REPLACE INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES
(52, 25, 84, 22, 8, '0.00', 0, 0),
(53, 25, 84, 22, 9, '0.00', 0, 0),
(54, 25, 84, 22, 11, '0.00', 0, 0),
(55, 26, 79, 22, 8, '0.00', 0, 0),
(56, 26, 79, 22, 9, '0.00', 0, 0),
(57, 26, 79, 22, 10, '0.00', 0, 0),
(58, 26, 79, 22, 11, '0.00', 0, 0),
(59, 26, 79, 22, 12, '0.00', 0, 0),
(60, 27, 79, 24, 13, '0.00', 0, 0),
(61, 27, 79, 24, 14, '0.00', 0, 0),
(62, 28, 78, 22, 8, '0.00', 0, 0),
(63, 28, 78, 22, 9, '0.00', 0, 0),
(64, 28, 78, 22, 10, '0.00', 0, 0),
(65, 28, 78, 22, 11, '0.00', 0, 0),
(66, 28, 78, 22, 12, '0.00', 0, 0),
(67, 22, 85, 22, 8, '0.00', 0, 0),
(68, 22, 85, 22, 9, '0.00', 0, 0),
(69, 22, 85, 22, 10, '0.00', 0, 0),
(70, 24, 85, 24, 13, '0.00', 0, 0),
(71, 24, 85, 24, 14, '0.00', 0, 0),
(72, 23, 81, 23, 7, '0.00', 0, 0),
(73, 23, 81, 23, 6, '0.00', 0, 0),
(74, 23, 81, 23, 15, '0.00', 0, 0);


#
# TABLE STRUCTURE FOR: ti_options
#

REPLACE INTO `ti_options` (`option_id`, `option_name`, `display_type`, `priority`) VALUES
(22, 'Cooked', 'radio', 1),
(23, 'Toppings', 'checkbox', 2),
(24, 'Dressing', 'select', 3);


#
# TABLE STRUCTURE FOR: ti_option_values
#

REPLACE INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES
(6, 23, 'Peperoni', '1.99', 2),
(7, 23, 'Jalapenos', '3.99', 1),
(8, 22, 'Meat', '4.00', 1),
(9, 22, 'Chicken', '2.99', 2),
(10, 22, 'Fish', '3.00', 3),
(11, 22, 'Beef', '4.99', 4),
(12, 22, 'Assorted Meat', '5.99', 5),
(13, 24, 'Dodo', '3.99', 1),
(14, 24, 'Salad', '2.99', 2),
(15, 23, 'Sweetcorn', '1.99', 3);

#
# TABLE STRUCTURE FOR: ti_menus
#

REPLACE INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES
(76, 'PUFF-PUFF', 'Traditional Nigerian donut ball, rolled in sugar', '4.99', 'data/puff_puff.jpg', 24, 856, 3, 1, 1),
(77, 'SCOTCH EGG', 'Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.', '2.00', 'data/scotch_egg.jpg', 15, 0, 1, 1, 1),
(78, 'ATA RICE', 'Small pieces of beef, goat, stipe, and tendon sautéed in crushed green Jamaican pepper.', '12.00', 'data/Seared_Ahi_Spinach_Salad.jpg', 16, 1000, 1, 0, 1),
(79, 'RICE AND DODO', '(plantains) w/chicken, fish, beef or goat', '11.99', 'data/rice_and_dodo.jpg', 16, 655, 1, 1, 1),
(80, 'Special Shrimp Deluxe', 'Fresh shrimp sautéed in blended mixture of tomatoes, onion, peppers over choice of rice', '12.99', 'data/deluxe_bbq_shrimp-1.jpg', 18, 265, 1, 1, 1),
(81, 'Whole catfish with rice and vegetables', 'Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste', '13.99', 'data/FriedWholeCatfishPlate_lg.jpg', 24, 145, 1, 1, 1),
(82, 'African Salad', 'With baked beans, egg, tuna, onion, tomatoes , green peas and carrot with your choice of dressing.', '8.99', '', 17, 500, 1, 0, 1),
(83, 'Seafood Salad', 'With shrimp, egg and imitation crab meat', '5.99', 'data/seafoods_salad.JPG', 17, 490, 1, 1, 1),
(84, 'EBA', 'Grated cassava', '11.99', 'data/eba.jpg', 16, 407, 1, 1, 1),
(85, 'AMALA', 'Yam flour', '11.99', 'data/DSCF3711.JPG', 19, 470, 1, 1, 1),
(86, 'YAM PORRIDGE', 'in tomatoes sauce', '9.99', 'data/yam_porridge.jpg', 20, 457, 1, 1, 1),
(87, 'Boiled Plantain', 'w/spinach soup', '9.99', 'data/pesto.jpg', 19, 434, 1, 1, 1);


#
# TABLE STRUCTURE FOR: ti_menus_specials
#

REPLACE INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES
(51, 81, '2014-04-10', '2014-04-30', '6.99', 1),
(52, 76, '2014-04-23', '2014-07-31', '10.00', 1),
(53, 86, '0000-00-00', '0000-00-00', '0.00', 0),
(54, 87, '0000-00-00', '0000-00-00', '0.00', 0),
(57, 84, '0000-00-00', '0000-00-00', '0.00', 0),
(58, 77, '0000-00-00', '0000-00-00', '0.00', 0),
(59, 78, '0000-00-00', '0000-00-00', '0.00', 0),
(60, 79, '0000-00-00', '0000-00-00', '0.00', 0),
(61, 85, '0000-00-00', '0000-00-00', '0.00', 0);

#
# TABLE STRUCTURE FOR: ti_permalinks
#

REPLACE INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`)
VALUES
	(12, 'vegetarian', 'menus', 'category_id=20'),
  (13, 'soups', 'menus', 'category_id=21'),
  (14, 'specials', 'menus', 'category_id=24'),
  (16, 'salads', 'menus', 'category_id=17'),
  (18, 'appetizer', 'menus', 'category_id=15'),
  (19, 'main-course', 'menus', 'category_id=16'),
  (20, 'seafoods', 'menus', 'category_id=18'),
  (21, 'traditional', 'menus', 'category_id=19'),
  (41, 'rice-dishes', 'menus', 'category_id=26'),
  (42, 'lewisham', 'local', 'location_id=11'),
  (43, 'hackney', 'local', 'location_id=12'),
  (44, 'earling', 'local', 'location_id=13');

#
# TABLE STRUCTURE FOR: ti_tables
#

REPLACE INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`)
VALUES
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

#
# TABLE STRUCTURE FOR: ti_working_hours
#

REPLACE INTO `ti_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`)
VALUES
  (11, 0, '00:00:00', '23:59:00', 1),
  (11, 1, '00:00:00', '23:59:00', 1),
  (11, 2, '00:00:00', '23:59:00', 1),
  (11, 3, '00:00:00', '23:59:00', 1),
  (11, 4, '00:00:00', '23:59:00', 1),
  (11, 5, '00:00:00', '23:59:00', 1),
  (11, 6, '00:00:00', '23:59:00', 1),
  (12, 0, '02:00:00', '17:59:00', 1),
  (12, 1, '02:00:00', '17:59:00', 1),
  (12, 2, '02:00:00', '17:59:00', 1),
  (12, 3, '02:00:00', '17:59:00', 1),
  (12, 4, '02:00:00', '17:59:00', 1),
  (12, 5, '02:00:00', '17:59:00', 1),
  (12, 6, '02:00:00', '17:59:00', 1),
  (13, 0, '00:00:00', '23:59:00', 0),
  (13, 1, '00:00:00', '23:59:00', 0),
  (13, 2, '00:00:00', '23:59:00', 0),
  (13, 3, '00:00:00', '23:59:00', 0),
  (13, 4, '00:00:00', '23:59:00', 0),
  (13, 5, '00:00:00', '23:59:00', 0),
  (13, 6, '00:00:00', '23:59:00', 0);