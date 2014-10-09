#
# TABLE STRUCTURE FOR: ti_addresses
#

INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('37', '41', '16 Bromley Hill', '', 'Bromley', '', 'BR1 4JX', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('38', '41', '555 Lewisham Way', '', 'London', '', 'CR0 9XY', '222');
INSERT INTO `ti_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`) VALUES ('39', '41', '14 Lime Close', '', 'London', '', 'HA3 7JD', '222');


#
# TABLE STRUCTURE FOR: ti_categories
#

INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('15', 'Appetizer', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('16', 'Main Course', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('17', 'Salads', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('18', 'Seafoods', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('19', 'Traditional', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('20', 'Vegetarian', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('21', 'Soups', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('22', 'Desserts', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('23', 'Drinks', '');
INSERT INTO `ti_categories` (`category_id`, `name`, `description`) VALUES ('24', 'Specials', '');


#
# TABLE STRUCTURE FOR: ti_coupons
#

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`, `description`, `status`, `date_added`) VALUES
(11, 'Half Sundays', '2222', 'F', '100.00', '500.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00'),
(12, 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00'),
(13, 'Full Mondays', 'MTo6TuTg', 'P', '50.00', '0.00', 0, 1, 'forever', NULL, '00:00:00', '23:59:00', NULL, NULL, '', '00:00:00', '23:59:00', '', 1, '0000-00-00'),
(14, 'Full Tuesdays', '4444', 'F', '500.00', '5000.00', 0, 0, 'recurring', NULL, '00:00:00', '23:59:00', NULL, NULL, '0, 2, 4, 5, 6', '00:00:00', '23:59:00', '', 1, '0000-00-00'),
(15, 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00');

#
# TABLE STRUCTURE FOR: ti_customer_groups
#

INSERT INTO `ti_customer_groups` (`customer_group_id`, `group_name`, `description`, `approval`) VALUES ('11', 'Default', '', '0');


#
# TABLE STRUCTURE FOR: ti_customers
#

INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`) VALUES ('39', 'Sam', 'Poyigi', 'demo@demo.com', 'a610f82a8ff7235182c8b5f5d65d783100611e7f', '69502ee1e', '100000000', '0', '11', 'Pike', '0', '11', '192.168.1.124', '2014-02-04 00:00:00', '1');


#
# TABLE STRUCTURE FOR: ti_locations
#

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `delivery_time`, `collection_time`, `last_order_time`, `reservation_interval`, `reservation_turn`, `options`, `location_status`) VALUES
(115, 'Harrow', 'harrow@tastyigniter.com', '', '14 Lime Close', '', 'Greater London', '', 'HA3 7JG', 222, '02088279101', 51.600262, -0.325915, 0, 'a:2:{s:4:"path";s:56:"[{"path":"}k~yHtt|@nzTg~_AcfAnyhAwy@zlg@i`Hw}e@itQxjP"}]";s:9:"pathArray";s:260:"[{"lat":51.606550000000006,"lng":-0.31579},{"lat":51.49463,"lng":0.016890000000000002},{"lat":51.50601,"lng":-0.36111000000000004},{"lat":51.51541,"lng":-0.56813},{"lat":51.5617,"lng":-0.36865000000000003},{"lat":51.657270000000004,"lng":-0.45758000000000004}]";}', 1, 1, 45, 0, 0, 45, 0, 'a:3:{s:13:"opening_hours";a:4:{s:12:"opening_type";s:5:"daily";s:10:"daily_days";a:7:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";i:5;s:1:"5";i:6;s:1:"6";}s:11:"daily_hours";a:3:{s:4:"open";s:7:"9:00 AM";s:5:"close";s:7:"5:00 PM";s:6:"status";s:1:"0";}s:14:"flexible_hours";a:7:{i:0;a:4:{s:3:"day";s:1:"0";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:1;a:4:{s:3:"day";s:1:"1";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:2;a:4:{s:3:"day";s:1:"2";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:3;a:4:{s:3:"day";s:1:"3";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:4;a:4:{s:3:"day";s:1:"4";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:5;a:4:{s:3:"day";s:1:"5";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:6;a:4:{s:3:"day";s:1:"6";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}}}s:8:"payments";a:2:{i:0;s:3:"cod";i:1;s:14:"paypal_express";}s:14:"delivery_areas";a:1:{i:1;a:7:{s:5:"shape";s:40:"[{"shape":"kj`zHpku@bkG`q@puAteQaaJfB"}]";s:8:"vertices";s:191:"[{"lat":51.61654000000001,"lng":-0.27849},{"lat":51.573640000000005,"lng":-0.28650000000000003},{"lat":51.55979000000001,"lng":-0.37973},{"lat":51.616440000000004,"lng":-0.38025000000000003}]";s:6:"circle";s:82:"[{"center":{"k":51.600262,"A":-0.32591500000000906}},{"radius":3847.228272498041}]";s:4:"type";s:5:"shape";s:4:"name";s:6:"Area 1";s:6:"charge";s:1:"0";s:10:"min_amount";s:1:"0";}}}', 1),
(116, 'Earling', 'ealing@tastyIgniter.com', 'Donec a velit est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce fringilla vestibulum faucibus. Mauris vestibulum eu erat sit amet bibendum. Suspendisse ornare tellus et varius rutrum.', '8 Brookfield Avenue', '', 'Greater London', '', 'W5 1LA', 222, '02088279102', 51.526852, -0.301442, 5, 'a:2:{s:4:"path";s:53:"[{"path":"yapyHfqu@hnApiA?j}B}mAhw@Cs|@{iB_^vkB{|A"}]";s:9:"pathArray";s:325:"[{"lat":51.53325,"lng":-0.27940000000000004},{"lat":51.52056,"lng":-0.29133000000000003},{"lat":51.52056,"lng":-0.31155000000000005},{"lat":51.533190000000005,"lng":-0.32056},{"lat":51.533210000000004,"lng":-0.31070000000000003},{"lat":51.55030508566046,"lng":-0.3057364868163859},{"lat":51.53291,"lng":-0.29072000000000003}]";}', 0, 0, 0, 0, 0, 0, 0, 'a:3:{s:13:"opening_hours";a:4:{s:12:"opening_type";s:4:"24_7";s:10:"daily_days";a:7:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"2";i:3;s:1:"3";i:4;s:1:"4";i:5;s:1:"5";i:6;s:1:"6";}s:11:"daily_hours";a:3:{s:4:"open";s:5:"09:00";s:5:"close";s:5:"17:00";s:6:"status";s:1:"0";}s:14:"flexible_hours";a:7:{i:0;a:4:{s:3:"day";s:1:"0";s:4:"open";s:5:"00:00";s:5:"close";s:5:"23:59";s:6:"status";s:1:"0";}i:1;a:4:{s:3:"day";s:1:"1";s:4:"open";s:5:"00:00";s:5:"close";s:5:"23:59";s:6:"status";s:1:"0";}i:2;a:4:{s:3:"day";s:1:"2";s:4:"open";s:5:"00:00";s:5:"close";s:5:"23:59";s:6:"status";s:1:"0";}i:3;a:4:{s:3:"day";s:1:"3";s:4:"open";s:5:"00:00";s:5:"close";s:5:"23:59";s:6:"status";s:1:"0";}i:4;a:4:{s:3:"day";s:1:"4";s:4:"open";s:5:"00:00";s:5:"close";s:5:"23:59";s:6:"status";s:1:"0";}i:5;a:4:{s:3:"day";s:1:"5";s:4:"open";s:5:"00:00";s:5:"close";s:5:"23:59";s:6:"status";s:1:"0";}i:6;a:4:{s:3:"day";s:1:"6";s:4:"open";s:5:"00:00";s:5:"close";s:5:"23:59";s:6:"status";s:1:"0";}}}s:8:"payments";a:2:{i:0;s:3:"cod";i:1;s:14:"paypal_express";}s:14:"delivery_areas";b:0;}', 1),
(117, 'Hackney', 'hackney@tastyigniter.com', 'Nunc vestibulum quis tortor placerat fermentum. Vivamus et justo purus. Fusce rutrum erat eu mattis consectetur. Quisque felis lorem, imperdiet sed urna et, volutpat bibendum lacus. Phasellus euismod sem quis est semper, vel porttitor magna aliquam. Nullam sed erat sed erat semper mollis ac id dolor. Sed quis felis ipsum. Aliquam dolor est, iaculis eget libero sit amet, hendrerit cursus sapien.', '44 Darnley Road', '', 'Greater London', '', 'E9 6QH', 222, '02088279103', 51.544060, -0.053999, 0, 'a:2:{s:4:"path";s:33:"[{"path":"ulsyHhqGrmA??j}BsmA?"}]";s:9:"pathArray";s:155:"[{"lat":51.55035,"lng":-0.043890000000000005},{"lat":51.53777,"lng":-0.043890000000000005},{"lat":51.53777,"lng":-0.06411},{"lat":51.55035,"lng":-0.06411}]";}', 1, 1, 45, 0, 0, 45, 0, 'a:3:{s:13:"opening_hours";a:4:{s:12:"opening_type";s:5:"daily";s:10:"daily_days";a:5:{i:0;s:1:"0";i:1;s:1:"1";i:2;s:1:"4";i:3;s:1:"5";i:4;s:1:"6";}s:11:"daily_hours";a:3:{s:4:"open";s:7:"9:00 AM";s:5:"close";s:8:"11:45 PM";s:6:"status";s:1:"0";}s:14:"flexible_hours";a:7:{i:0;a:4:{s:3:"day";s:1:"0";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:1;a:4:{s:3:"day";s:1:"1";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:2;a:4:{s:3:"day";s:1:"2";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:3;a:4:{s:3:"day";s:1:"3";s:4:"open";s:7:"6:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:4;a:4:{s:3:"day";s:1:"4";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"1";}i:5;a:4:{s:3:"day";s:1:"5";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}i:6;a:4:{s:3:"day";s:1:"6";s:4:"open";s:8:"12:00 AM";s:5:"close";s:8:"11:59 PM";s:6:"status";s:1:"0";}}}s:8:"payments";a:2:{i:0;s:3:"cod";i:1;s:14:"paypal_express";}s:14:"delivery_areas";a:3:{i:1;a:7:{s:5:"shape";s:40:"[{"shape":"ma|yHehT~cIybHad@hxW}{G_sK"}]";s:8:"vertices";s:210:"[{"lat":51.594625707631195,"lng":0.1089853027343679},{"lat":51.54262821987109,"lng":0.15568036132799534},{"lat":51.54855649291098,"lng":0.028753789062420765},{"lat":51.59414620307117,"lng":0.09338530273441847}]";s:6:"circle";s:90:"[{"center":{"k":51.572716499153415,"A":0.0694251963965371}},{"radius":2330.0925613871304}]";s:4:"type";s:5:"shape";s:4:"name";s:6:"Area 1";s:6:"charge";s:2:"10";s:10:"min_amount";s:3:"100";}i:2;a:7:{s:5:"shape";s:39:"[{"shape":"ut_zHshCnmCiCrq@liJyrCc{@"}]";s:8:"vertices";s:182:"[{"lat":51.61307000000001,"lng":0.02202},{"lat":51.590270000000004,"lng":0.02271},{"lat":51.582170000000005,"lng":-0.035280000000000006},{"lat":51.60582,"lng":-0.025660000000000002}]";s:6:"circle";s:89:"[{"center":{"k":51.519712578863476,"A":0.0692538686523676}},{"radius":3443.387539026636}]";s:4:"type";s:5:"shape";s:4:"name";s:6:"Area 2";s:6:"charge";s:1:"4";s:10:"min_amount";s:2:"44";}i:3;a:7:{s:5:"shape";s:36:"[{"shape":"kgxyHdTliJyBaCpkPk|Jc^"}]";s:8:"vertices";s:191:"[{"lat":51.575100000000006,"lng":-0.0033900000000000002},{"lat":51.51711,"lng":-0.0027800000000000004},{"lat":51.51776,"lng":-0.09183000000000001},{"lat":51.57878,"lng":-0.08685000000000001}]";s:6:"circle";s:81:"[{"center":{"k":51.54406,"A":-0.05399899999997615}},{"radius":3211.337478868781}]";s:4:"type";s:6:"circle";s:4:"name";s:6:"Area 3";s:6:"charge";s:2:"10";s:10:"min_amount";s:3:"100";}}}', 1);

#
# TABLE STRUCTURE FOR: ti_location_tables
#

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
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('117', '7');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('117', '8');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('117', '12');
INSERT INTO `ti_location_tables` (`location_id`, `table_id`) VALUES ('122', '13');


#
# TABLE STRUCTURE FOR: ti_menu_options
#

INSERT INTO `ti_menu_options` (`menu_option_id`, `menu_id`, `option_id`, `required`, `option_values`) VALUES
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
 
INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `substract_stock`) VALUES
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
 
INSERT INTO `ti_options` (`option_id`, `option_name`, `display_type`, `priority`) VALUES
(22, 'Cooked', 'radio', 1),
(23, 'Toppings', 'checkbox', 2),
(24, 'Dressing', 'select', 3);


#
# TABLE STRUCTURE FOR: ti_option_values
#
 
INSERT INTO `ti_option_values` (`option_value_id`, `option_id`, `value`, `price`, `priority`) VALUES
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

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES
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

INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES
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
# TABLE STRUCTURE FOR: ti_order_menus
#

INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `option_values`) VALUES
(78, 2649, 76, 'PUFF-PUFF', 39, '10.00', '390.00', ''),
(79, 2649, 79, 'RICE AND DODO', 10, '19.97', '199.70', ''),
(80, 2650, 78, 'ATA RICE', 8, '16.99', '135.92', ''),
(81, 2650, 76, 'PUFF-PUFF', 9, '10.00', '90.00', ''),
(82, 2650, 79, 'RICE AND DODO', 11, '17.97', '197.67', ''),
(83, 2650, 87, 'Boiled Plantain', 1, '9.99', '9.99', ''),
(84, 2651, 78, 'ATA RICE', 10, '16.99', '169.90', 'a:3:{s:20:"menu_option_value_id";s:2:"65";s:4:"name";s:4:"Beef";s:5:"price";s:4:"4.99";}'),
(85, 2651, 79, 'RICE AND DODO', 22, '20.97', '461.34', 'a:3:{s:20:"menu_option_value_id";s:5:"59|61";s:4:"name";s:19:"Assorted Meat|Salad";s:5:"price";s:9:"5.99|2.99";}'),
(86, 2651, 80, 'Special Shrimp Deluxe', 15, '12.99', '194.85', ''),
(87, 2652, 78, 'ATA RICE', 15, '16.00', '240.00', 'a:3:{s:20:"menu_option_value_id";s:2:"62";s:4:"name";s:4:"Meat";s:5:"price";s:4:"4.00";}'),
(88, 2652, 79, 'RICE AND DODO', 16, '19.97', '319.52', 'a:3:{s:20:"menu_option_value_id";s:5:"58|61";s:4:"name";s:10:"Beef|Salad";s:5:"price";s:9:"4.99|2.99";}'),
(89, 2652, 80, 'Special Shrimp Deluxe', 15, '12.99', '194.85', ''),
(90, 2653, 79, 'RICE AND DODO', 19, '21.97', '417.43', 'a:3:{s:20:"menu_option_value_id";s:5:"59|60";s:4:"name";s:18:"Assorted Meat|Dodo";s:5:"price";s:9:"5.99|3.99";}'),
(91, 2653, 81, 'Whole Catfish with rice and vegetables', 100, '13.99', '1399.00', ''),
(92, 2654, 81, 'Whole catfish with rice and vegetables', 221, '21.96', '4853.16', 'a:3:{s:20:"menu_option_value_id";s:8:"72|73|74";s:4:"name";s:28:"Jalapenos|Peperoni|Sweetcorn";s:5:"price";s:14:"3.99|1.99|1.99";}'),
(93, 2654, 80, 'Special Shrimp Deluxe', 13, '12.99', '168.87', ''),
(94, 2654, 78, 'ATA RICE', 100, '17.99', '1799.00', 'a:3:{s:20:"menu_option_value_id";s:2:"66";s:4:"name";s:13:"Assorted Meat";s:5:"price";s:4:"5.99";}'),
(95, 2654, 82, 'African Salad', 100, '8.99', '899.00', ''),
(96, 2654, 79, 'RICE AND DODO', 38, '21.97', '834.86', ''),
(97, 2655, 78, 'ATA RICE', 5, '17.99', '89.95', 'a:3:{s:20:"menu_option_value_id";s:2:"66";s:4:"name";s:13:"Assorted Meat";s:5:"price";s:4:"5.99";}');
 

#
# TABLE STRUCTURE FOR: ti_order_options
#

INSERT INTO `ti_order_options` (`order_option_id`, `order_menu_id`, `menu_option_value_id`, `order_id`, `menu_id`, `order_option_name`, `order_option_price`) VALUES
(23, 79, 58, 2649, 79, 'Beef', '4.99'),
(24, 79, 61, 2649, 79, 'Salad', '2.99'),
(25, 84, 65, 2651, 78, 'Beef', '4.99'),
(26, 85, 59, 2651, 79, 'Assorted Meat', '5.99'),
(27, 85, 61, 2651, 79, 'Salad', '2.99'),
(28, 87, 62, 2652, 78, 'Meat', '4.00'),
(29, 88, 58, 2652, 79, 'Beef', '4.99'),
(30, 88, 61, 2652, 79, 'Salad', '2.99'),
(31, 90, 59, 2653, 79, 'Assorted Meat', '5.99'),
(32, 90, 60, 2653, 79, 'Dodo', '3.99'),
(33, 92, 72, 2654, 81, 'Jalapenos', '3.99'),
(34, 92, 73, 2654, 81, 'Peperoni', '1.99'),
(35, 92, 74, 2654, 81, 'Sweetcorn', '1.99'),
(36, 94, 66, 2654, 78, 'Assorted Meat', '5.99'),
(37, 97, 66, 2655, 78, 'Assorted Meat', '5.99');
 

#
# TABLE STRUCTURE FOR: ti_order_totals
#

INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES
(29, 2641, 'cart_total', 'Sub Total', '369.84', 0),
(30, 2641, 'delivery', 'Delivery', '0.00', 0),
(31, 2641, 'coupon', 'Coupon', '0.00', 0),
(32, 2642, 'cart_total', 'Sub Total', '398.79', 0),
(33, 2642, 'delivery', 'Delivery', '0.00', 0),
(34, 2642, 'coupon', 'Coupon', '0.00', 0),
(50, 2649, 'cart_total', 'Sub Total', '589.70', 0),
(51, 2649, 'delivery', 'Delivery', '10.00', 0),
(52, 2649, 'coupon', 'Coupon', '0.00', 0),
(53, 2650, 'cart_total', 'Sub Total', '433.58', 0),
(54, 2650, 'delivery', 'Delivery', '10.00', 0),
(55, 2650, 'coupon', 'Coupon', '0.00', 0),
(56, 2651, 'cart_total', 'Sub Total', '826.09', 0),
(57, 2651, 'coupon', 'Coupon', '100.00', 0),
(58, 2652, 'cart_total', 'Sub Total', '754.37', 0),
(59, 2652, 'coupon', 'Coupon', '0.00', 0),
(60, 2653, 'cart_total', 'Sub Total', '1816.43', 0),
(61, 2653, 'delivery', 'Delivery', '10.00', 0),
(62, 2653, 'coupon', 'Coupon', '0.00', 0),
(63, 2654, 'cart_total', 'Sub Total', '8554.89', 0),
(64, 2654, 'delivery', 'Delivery', '0.00', 0),
(65, 2654, 'coupon', 'Coupon', '100.00', 0),
(66, 2655, 'cart_total', 'Sub Total', '89.95', 0),
(67, 2655, 'delivery', 'Delivery', '0.00', 0),
(68, 2655, 'coupon', 'Coupon', '0.00', 0);

#
# TABLE STRUCTURE FOR: ti_orders
#

INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`) VALUES
(2641, 41, 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', 117, 39, '', 25, '', 'cod', '1', '2014-06-08 21:06:06', '2014-06-27', '21:51:00', '369.84', 11, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', 1),
(2642, 41, 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', 117, 39, '', 29, '', 'cod', '1', '2014-06-18 00:50:07', '2014-06-18', '01:35:00', '398.79', 1, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0', 1),
(2649, 39, 'Sam', 'Poyigi', 'demo@demo.com', '100000000', 115, 0, '', 49, '', 'cod', '2', '2014-07-14 19:45:22', '2014-07-14', '20:30:00', '599.70', 1, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', 1),
(2650, 39, 'Sam', 'Poyigi', 'demo@demo.com', '100000000', 118, 0, '', 29, '', 'cod', '2', '2014-07-20 14:00:03', '2014-08-04', '14:44:00', '443.58', 15, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', 1),
(2651, 39, 'Sam', 'Poyigi', 'demo@demo.com', '100000000', 118, 0, '', 47, '', 'cod', '2', '2014-07-20 14:09:52', '2014-07-22', '14:54:00', '726.09', 11, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', 1),
(2652, 39, 'Sam', 'Poyigi', 'demo@demo.com', '100000000', 118, 0, '', 46, '', 'cod', '2', '2014-07-20 14:20:22', '2014-07-20', '15:05:00', '754.37', 11, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', 1),
(2653, 40, 'Temi', 'Temi', 'temi@temi.com', '100000000', 115, 0, '', 119, '', 'cod', '2', '2014-07-21 01:03:20', '2014-07-21', '01:48:00', '1826.43', 14, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', 1),
(2654, 39, 'Demo', 'Demo', 'demo@demo.com', '100000000', 118, 41, '', 472, '', 'cod', '1', '2014-08-03 02:20:04', '2014-08-03', '03:04:00', '8454.89', 11, '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:31.0) Gecko/20100101 Firefox/31.0 FirePHP/0.7.4', 1),
(2655, 40, 'Temi', 'Temi', 'temi@temi.com', '100000000', 115, 0, '', 5, '', 'cod', '2', '2014-10-08 14:44:26', '2014-10-08', '15:29:00', '89.95', 14, '192.168.192.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:32.0) Gecko/20100101 Firefox/32.0 FirePHP/0.7.4', 1);


#
# TABLE STRUCTURE FOR: ti_permalinks
#

INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES
(11, 'traditional', 'category_id=19'),
(12, 'vegetarian', 'category_id=20'),
(13, 'soups', 'category_id=21'),
(14, 'specials', 'category_id=24'),
(16, 'salads', 'category_id=17'),
(18, 'appetizer', 'category_id=15'),
(19, 'main-course', 'category_id=16'),
(20, 'seafoods', 'category_id=18'),
(36, 'maintenance', 'page_id=13'),
(37, 'about-us', 'page_id=11'),
(38, 'lewisham', 'location_id=118');

#
# TABLE STRUCTURE FOR: ti_reservations
#

INSERT INTO `ti_reservations` (`reservation_id`, `location_id`, `table_id`, `guest_num`, `occasion_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `comment`, `reserve_time`, `reserve_date`, `date_added`, `date_modified`, `staff_id`, `notify`, `ip_address`, `user_agent`, `status`) VALUES ('2445', '117', '7', '8', '2', '41', 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', '', '13:45:00', '2014-06-19', '2014-06-17', '2014-06-17', '0', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0', '8');
INSERT INTO `ti_reservations` (`reservation_id`, `location_id`, `table_id`, `guest_num`, `occasion_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `comment`, `reserve_time`, `reserve_date`, `date_added`, `date_modified`, `staff_id`, `notify`, `ip_address`, `user_agent`, `status`) VALUES ('2446', '115', '7', '7', '4', '39', 'Sam', 'Poyigi', 'temi@temi.com', '100000000', '', '16:00:00', '2014-06-24', '2014-06-21', '2014-06-21', '0', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0', '11');


#
# TABLE STRUCTURE FOR: ti_reviews
#

INSERT INTO `ti_reviews` (`review_id`, `customer_id`, `order_id`, `author`, `location_id`, `quality`, `delivery`, `service`, `review_text`, `date_added`, `review_status`) VALUES ('100', '41', '2596', 'Lorem Ipsum', '116', '3', '3', '3', 'Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci.', '2014-04-14 00:21:04', '0');
INSERT INTO `ti_reviews` (`review_id`, `customer_id`, `order_id`, `author`, `location_id`, `quality`, `delivery`, `service`, `review_text`, `date_added`, `review_status`) VALUES ('103', '39', '2601', 'Sam Poyigi', '116', '1', '1', '1', 'Mauris posuere orci enim, vel rhoncus nibh facilisis nec.', '2014-04-25 23:51:57', '0');


#
# TABLE STRUCTURE FOR: ti_status_history
#
 
INSERT INTO `ti_status_history` (`status_history_id`, `order_id`, `staff_id`, `assigned_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES
(11, 2641, 11, 0, 11, 0, 'order', 'Your order has been received.', '2014-06-27 09:33:49'),
(12, 2445, 11, 0, 16, 0, 'reserve', 'Your table reservation has been confirmed.', '2014-06-27 09:40:03'),
(13, 2446, 11, 0, 16, 0, 'reserve', 'Your table reservation has been confirmed.', '2014-06-27 09:41:38'),
(14, 2446, 11, 11, 17, 0, 'reserve', 'Your table reservation has been canceled.', '2014-06-27 09:50:49'),
(15, 20011, 0, 0, 16, 1, 'reserve', '', '2014-06-27 10:45:05'),
(16, 2645, 0, 0, 1, 1, 'order', '', '2014-07-14 16:47:14'),
(17, 2646, 0, 0, 1, 1, 'order', '', '2014-07-14 18:42:58'),
(18, 2647, 0, 0, 1, 1, 'order', '', '2014-07-14 18:49:59'),
(19, 2648, 0, 0, 1, 1, 'order', '', '2014-07-14 19:07:24'),
(20, 2648, 0, 0, 1, 1, 'order', '', '2014-07-14 19:10:42'),
(21, 2648, 0, 0, 1, 1, 'order', '', '2014-07-14 19:43:30'),
(22, 2649, 0, 0, 1, 1, 'order', '', '2014-07-14 19:45:22'),
(23, 2650, 0, 0, 1, 1, 'order', '', '2014-07-20 14:00:03'),
(24, 2651, 0, 0, 1, 1, 'order', '', '2014-07-20 14:09:52'),
(25, 2652, 0, 0, 11, 1, 'order', 'Your order has been received.', '2014-07-20 14:20:22'),
(26, 2653, 0, 0, 11, 1, 'order', 'Your order has been received.', '2014-07-21 01:03:20'),
(27, 2653, 12, 0, 14, 0, 'order', 'Your order will be with you shortly.', '2014-07-21 01:04:18'),
(28, 2651, 12, 0, 11, 0, 'order', 'Your order has been received.', '2014-07-22 22:50:37'),
(29, 2654, 0, 0, 11, 1, 'order', 'Your order has been received.', '2014-08-03 02:20:04'),
(30, 2650, 12, 0, 15, 1, 'order', '', '2014-08-04 00:43:32'),
(31, 2655, 0, 0, 11, 1, 'order', 'Your order has been received.', '2014-10-08 14:44:26'),
(32, 2655, 12, 0, 14, 1, 'order', 'Your order will be with you shortly.', '2014-10-08 14:45:49');
 
 
#
# TABLE STRUCTURE FOR: ti_tables
#

INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('2', 'NN02', '2', '2', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('6', 'SW77', '2', '4', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('7', 'EW77', '6', '8', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('8', 'SE78', '4', '6', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('9', 'NE8', '8', '10', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('10', 'SW55', '9', '10', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('11', 'EW88', '2', '10', '0');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('12', 'EE732', '2', '8', '1');
INSERT INTO `ti_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`) VALUES ('14', 'FW79', '4', '10', '0');
