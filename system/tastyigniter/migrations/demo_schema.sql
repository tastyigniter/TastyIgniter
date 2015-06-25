#
# TABLE STRUCTURE FOR: ti_categories
#

INSERT INTO `ti_categories` (`category_id`, `name`, `description`, `parent_id`, `image`)
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

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `validity`, `fixed_date`, `fixed_from_time`, `fixed_to_time`, `period_start_date`, `period_end_date`, `recurring_every`, `recurring_from_time`, `recurring_to_time`, `description`, `status`, `date_added`) VALUES
(11, 'Half Sundays', '2222', 'F', '100.00', '500.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00'),
(12, 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00'),
(13, 'Full Mondays', 'MTo6TuTg', 'P', '50.00', '0.00', 0, 1, 'forever', NULL, '00:00:00', '23:59:00', NULL, NULL, '', '00:00:00', '23:59:00', '', 1, '0000-00-00'),
(14, 'Full Tuesdays', '4444', 'F', '500.00', '5000.00', 0, 0, 'recurring', NULL, '00:00:00', '23:59:00', NULL, NULL, '0, 2, 4, 5, 6', '00:00:00', '23:59:00', '', 1, '0000-00-00'),
(15, 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', 0, 0, 'forever', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '', 1, '0000-00-00');


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

INSERT INTO `ti_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES
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
# TABLE STRUCTURE FOR: ti_permalinks
#

INSERT INTO `ti_permalinks` (`permalink_id`, `slug`, `controller`, `query`)
VALUES
	(11, 'traditional', 'menus', 'category_id=19'),
	(12, 'vegetarian', 'menus', 'category_id=20'),
	(13, 'soups', 'menus', 'category_id=21'),
	(14, 'specials', 'menus', 'category_id=24'),
	(16, 'salads', 'menus', 'category_id=17'),
	(18, 'appetizer', 'menus', 'category_id=15'),
	(19, 'main-course', 'menus', 'category_id=16'),
	(20, 'seafoods', 'menus', 'category_id=18'),
	(41, 'rice-dishes', 'menus', 'category_id=26');
