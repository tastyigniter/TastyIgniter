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

INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('11', 'Half Sundays', '2222', 'F', '100.00', '500.00', '0', '0', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('12', 'Half Tuesdays', '3333', 'P', '30.00', '1000.00', '0', '0', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('13', 'Full Mondays', 'MTo6TuTg', 'P', '50.00', '0.00', '0', '1', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('14', 'Full Tuesdays', '4444', 'F', '500.00', '5000.00', '0', '0', '', '0000-00-00', '0000-00-00', '1', '0000-00-00');
INSERT INTO `ti_coupons` (`coupon_id`, `name`, `code`, `type`, `discount`, `min_total`, `redemptions`, `customer_redemptions`, `description`, `start_date`, `end_date`, `status`, `date_added`) VALUES ('15', 'Full Wednesdays', '5555', 'F', '5000.00', '5000.00', '0', '0', '', '2014-01-12', '0000-00-00', '1', '0000-00-00');


#
# TABLE STRUCTURE FOR: ti_customer_groups
#

INSERT INTO `ti_customer_groups` (`customer_group_id`, `group_name`, `description`, `approval`) VALUES ('11', 'Default', '', '0');


#
# TABLE STRUCTURE FOR: ti_customers
#

INSERT INTO `ti_customers` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`) VALUES ('39', 'Sam', 'Poyigi', 'temi@temi.com', 'a610f82a8ff7235182c8b5f5d65d783100611e7f', '69502ee1e', '100000000', '0', '11', 'Pike', '0', '11', '192.168.1.124', '2014-02-04 00:00:00', '1');


#
# TABLE STRUCTURE FOR: ti_customers_activity
#

INSERT INTO `ti_customers_activity` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`) VALUES ('17', '39', 'browser', 'Firefox', '192.168.1.124', '0', 'http://ptbs-macbook-pro.local/TastyIgniter/menus/seafoods', 'http://ptbs-macbook-pro.local/TastyIgniter/menus', '2014-06-21 17:43:52');
INSERT INTO `ti_customers_activity` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`) VALUES ('21', '39', 'browser', 'Firefox', '192.168.1.145', '0', 'http://ptbs-macbook-pro.local/TastyIgniter/admin/customers/edit?id=41', 'http://ptbs-macbook-pro.local/TastyIgniter/admin/customers', '2014-06-10 21:18:09');
INSERT INTO `ti_customers_activity` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`) VALUES ('20', '39', 'browser', 'Firefox', '127.0.0.1', '0', 'http://ptbs-macbook-pro.local/TastyIgniter/admin/reviews', 'http://ptbs-macbook-pro.local/TastyIgniter/admin/customers', '2014-06-10 20:10:42');


#
# TABLE STRUCTURE FOR: ti_locations
#

INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reservation_interval`, `reservation_turn`, `location_status`) VALUES ('115', 'Harrow', 'harrow@tastyigniter.com', '', '14 Lime Close', '', 'Greater London', '', 'HA3 7JD', '222', '02088279101', '51.600262', '-0.325915', '0', 'a:2:{s:4:\"path\";s:56:\"[{\"path\":\"}k~yHtt|@nzTg~_AcfAnyhAwy@zlg@i`Hw}e@itQxjP\"}]\";s:9:\"pathArray\";s:260:\"[{\"lat\":51.606550000000006,\"lng\":-0.31579},{\"lat\":51.49463,\"lng\":0.016890000000000002},{\"lat\":51.50601,\"lng\":-0.36111000000000004},{\"lat\":51.51541,\"lng\":-0.56813},{\"lat\":51.5617,\"lng\":-0.36865000000000003},{\"lat\":51.657270000000004,\"lng\":-0.45758000000000004}]\";}', '0', '1', '45', '0', '10.00', '500.00', '45', '0', '1');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reservation_interval`, `reservation_turn`, `location_status`) VALUES ('116', 'Earling', 'ealing@tastyIgniter.com', '', '8 Brookfield Avenue', '', 'Greater London', '', 'W5 1LA', '222', '02088279102', '51.526852', '-0.301442', '5', 'a:2:{s:4:\"path\";s:53:\"[{\"path\":\"yapyHfqu@hnApiA?j}B}mAhw@Cs|@{iB_^vkB{|A\"}]\";s:9:\"pathArray\";s:325:\"[{\"lat\":51.53325,\"lng\":-0.27940000000000004},{\"lat\":51.52056,\"lng\":-0.29133000000000003},{\"lat\":51.52056,\"lng\":-0.31155000000000005},{\"lat\":51.533190000000005,\"lng\":-0.32056},{\"lat\":51.533210000000004,\"lng\":-0.31070000000000003},{\"lat\":51.55030508566046,\"lng\":-0.3057364868163859},{\"lat\":51.53291,\"lng\":-0.29072000000000003}]\";}', '0', '0', '0', '0', '0.00', '0.00', '0', '0', '1');
INSERT INTO `ti_locations` (`location_id`, `location_name`, `location_email`, `description`, `location_address_1`, `location_address_2`, `location_city`, `location_state`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `covered_area`, `offer_delivery`, `offer_collection`, `ready_time`, `last_order_time`, `delivery_charge`, `min_delivery_total`, `reservation_interval`, `reservation_turn`, `location_status`) VALUES ('117', 'Hackney', 'hackney@tastyigniter.com', 'Nunc vestibulum quis tortor placerat fermentum. Vivamus et justo purus. Fusce rutrum erat eu mattis consectetur. Quisque felis lorem, imperdiet sed urna et, volutpat bibendum lacus. Phasellus euismod sem quis est semper, vel porttitor magna aliquam. Nullam sed erat sed erat semper mollis ac id dolor. Sed quis felis ipsum. Aliquam dolor est, iaculis eget libero sit amet, hendrerit cursus sapien.', '44 Darnley Road', '', 'Greater London', '', 'E9 6QH', '222', '02088279103', '51.544060', '-0.053999', '0', 'a:2:{s:4:\"path\";s:33:\"[{\"path\":\"ulsyHhqGrmA??j}BsmA?\"}]\";s:9:\"pathArray\";s:155:\"[{\"lat\":51.55035,\"lng\":-0.043890000000000005},{\"lat\":51.53777,\"lng\":-0.043890000000000005},{\"lat\":51.53777,\"lng\":-0.06411},{\"lat\":51.55035,\"lng\":-0.06411}]\";}', '1', '0', '45', '0', '0.00', '0.00', '45', '0', '1');


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


#
# TABLE STRUCTURE FOR: ti_menus
#

INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('87', 'Boiled Plantain', 'w/spinach soup', '9.99', 'data/pesto.jpg', '20', '435', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('86', 'YAM PORRIDGE', 'in tomatoes sauce', '9.99', 'data/yam_porridge.jpg', '20', '457', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('85', 'AMALA(YAM FLOUR)', '', '11.99', 'data/DSCF3711.JPG', '19', '470', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('84', 'EBA (GRATED CASSAVA)', '', '11.99', 'data/eba.jpg', '24', '433', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('83', 'Seafood Salad', 'With shrimp, egg and imitation crab meat', '5.99', 'data/seafoods_salad.JPG', '17', '490', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('81', 'Whole Catfish with rice and vegetables', 'Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste', '13.99', 'data/FriedWholeCatfishPlate_lg.jpg', '24', '487', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('80', 'Special Shrimp Deluxe', 'Fresh shrimp sautéed in blended mixture of tomatoes, onion, peppers over choice of rice', '12.99', 'data/deluxe_bbq_shrimp-1.jpg', '18', '341', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('82', 'African Salad', 'With baked beans, egg, tuna, onion, tomatoes , green peas and carrot with your choice of dressing.', '8.99', '', '17', '500', '1', '0', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('79', 'RICE AND DODO', '(plantains) w/chicken, fish, beef or goat', '11.99', 'data/rice_and_dodo.jpg', '16', '841', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('77', 'SCOTCH EGG', 'Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.', '2.00', 'data/scotch_egg.jpg', '15', '922', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('76', 'PUFF-PUFF', 'Traditional Nigerian donut ball, rolled in sugar', '4.99', 'data/puff_puff.jpg', '24', '935', '1', '1', '1');
INSERT INTO `ti_menus` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `menu_status`) VALUES ('78', 'ATA RICE', 'Small pieces of beef, goat, stipe, and tendon sautéed in crushed green Jamaican pepper.', '12.00', 'data/Seared_Ahi_Spinach_Salad.jpg', '16', '1000', '1', '0', '1');


#
# TABLE STRUCTURE FOR: ti_menus_to_options
#

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
# TABLE STRUCTURE FOR: ti_menus_specials
#

INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('51', '81', '2014-04-10', '2014-04-30', '6.99', '1');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('52', '76', '2014-04-23', '2014-07-31', '10.00', '1');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('53', '86', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('54', '87', '0000-00-00', '0000-00-00', '0.00', '0');
INSERT INTO `ti_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES ('57', '84', '0000-00-00', '0000-00-00', '0.00', '0');


#
# TABLE STRUCTURE FOR: ti_order_menus
#

INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('38', '2641', '78', 'ATA RICE', '1', '12.00', '12.00', '0');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('39', '2641', '78', 'ATA RICE', '3', '16.00', '48.00', '11');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('40', '2641', '78', 'ATA RICE', '3', '16.00', '48.00', '12');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('41', '2641', '78', 'ATA RICE', '2', '15.00', '30.00', '13');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('42', '2641', '79', 'RICE AND DODO', '6', '15.99', '95.94', '14');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('43', '2641', '84', 'EBA (GRATED CASSAVA)', '6', '15.99', '95.94', '15');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('44', '2641', '87', 'Boiled Plantain', '4', '9.99', '39.96', '15');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('45', '2642', '78', 'ATA RICE', '1', '12.00', '12.00', '0');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('46', '2642', '79', 'RICE AND DODO', '2', '11.99', '23.98', '0');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('47', '2642', '78', 'ATA RICE', '3', '15.00', '45.00', '16');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('48', '2642', '80', 'Special Shrimp Deluxe', '3', '12.99', '38.97', '16');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('49', '2642', '78', 'ATA RICE', '3', '15.00', '45.00', '16');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('50', '2642', '79', 'RICE AND DODO', '6', '15.99', '95.94', '16');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('51', '2642', '84', 'EBA (GRATED CASSAVA)', '6', '15.99', '95.94', '16');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('52', '2642', '87', 'Boiled Plantain', '4', '9.99', '39.96', '16');
INSERT INTO `ti_order_menus` (`order_menu_id`, `order_id`, `menu_id`, `name`, `quantity`, `price`, `subtotal`, `order_option_id`) VALUES ('53', '2642', '77', 'SCOTCH EGG', '1', '2.00', '2.00', '16');


#
# TABLE STRUCTURE FOR: ti_order_options
#

INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `option_id`, `option_name`, `option_price`) VALUES ('11', '2641', '78', '0', '', '0.00');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `option_id`, `option_name`, `option_price`) VALUES ('12', '2641', '78', '0', '', '0.00');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `option_id`, `option_name`, `option_price`) VALUES ('13', '2641', '78', '0', '', '0.00');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `option_id`, `option_name`, `option_price`) VALUES ('14', '2641', '79', '0', '', '0.00');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `option_id`, `option_name`, `option_price`) VALUES ('15', '2641', '84', '0', '', '0.00');
INSERT INTO `ti_order_options` (`order_option_id`, `order_id`, `menu_id`, `option_id`, `option_name`, `option_price`) VALUES ('16', '2642', '78', '0', '', '0.00');


#
# TABLE STRUCTURE FOR: ti_order_totals
#

INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('29', '2641', 'cart_total', 'Sub Total', '369.84', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('30', '2641', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('31', '2641', 'coupon', 'Coupon', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('32', '2642', 'cart_total', 'Sub Total', '398.79', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('33', '2642', 'delivery', 'Delivery', '0.00', '0');
INSERT INTO `ti_order_totals` (`order_total_id`, `order_id`, `code`, `title`, `value`, `priority`) VALUES ('34', '2642', 'coupon', 'Coupon', '0.00', '0');


#
# TABLE STRUCTURE FOR: ti_orders
#

INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`) VALUES ('2641', '41', 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', '117', '39', '', '25', '', 'cod', '1', '2014-06-08 21:06:06', '2014-06-08', '21:51:00', '369.84', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0 FirePHP/0.7.4', '1');
INSERT INTO `ti_orders` (`order_id`, `customer_id`, `first_name`, `last_name`, `email`, `telephone`, `location_id`, `address_id`, `cart`, `total_items`, `comment`, `payment`, `order_type`, `date_added`, `date_modified`, `order_time`, `order_total`, `status_id`, `ip_address`, `user_agent`, `notify`) VALUES ('2642', '41', 'Lorem', 'Ipsum', 'lorem@ipsum.com', '92202293', '117', '39', '', '29', '', 'cod', '1', '2014-06-18 00:50:07', '2014-06-18', '01:35:00', '398.79', '1', '192.168.1.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:30.0) Gecko/20100101 Firefox/30.0', '1');


#
# TABLE STRUCTURE FOR: ti_pages
#

INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `menu_location`, `date_added`, `date_updated`, `status`) VALUES ('11', '11', 'About Us', 'About Us', 'About Us', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis massa ac magna sagittis, sit amet gravida metus gravida. Aenean dictum pellentesque erat, vitae adipiscing libero semper sit amet. Vestibulum nec nunc lorem. Duis vitae libero a libero hendrerit tincidunt in eu tellus. Aliquam consequat ultrices felis ut dictum. Nulla euismod felis a sem mattis ornare. Aliquam ut diam sit amet dolor iaculis molestie ac id nisl. Maecenas hendrerit convallis mi feugiat gravida. Quisque tincidunt, leo a posuere imperdiet, metus leo vestibulum orci, vel volutpat justo ligula id quam. Cras placerat tincidunt lorem eu interdum.</p>\n\n<h3 style=\"text-align:center\"><span style=\"color:#A52A2A\">Mission</span></h3>\n\n<p>Ut eu pretium urna. In sed consectetur neque. In ornare odio erat, id ornare arcu euismod a. Ut dapibus sit amet erat commodo vestibulum. Praesent vitae lacus faucibus, rhoncus tortor et, bibendum justo. Etiam pharetra congue orci, eget aliquam orci. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend justo eros, sit amet fermentum tellus ullamcorper quis. Cras cursus mi at imperdiet faucibus. Proin iaculis, felis vitae luctus venenatis, ante tortor porta nisi, et ornare magna metus sit amet enim. Phasellus et turpis nec metus aliquet adipiscing. Etiam at augue nec odio lacinia tincidunt. Suspendisse commodo commodo ipsum ac sollicitudin. Nunc nec consequat lacus. Donec gravida rhoncus justo sed elementum.</p>\n\n<h3 style=\"text-align:center\"><span style=\"color:#A52A2A\">Vision</span></h3>\n\n<p>Praesent erat massa, consequat a nulla et, eleifend facilisis risus. Nullam libero mi, bibendum id eleifend vitae, imperdiet a nulla. Fusce congue porta ultricies. Vivamus felis lectus, egestas at pretium vitae, posuere a nibh. Mauris lobortis urna nec rhoncus consectetur. Fusce sed placerat sem. Nulla venenatis elit risus, non auctor arcu lobortis eleifend. Ut aliquet vitae velit a faucibus. Suspendisse quis risus sit amet arcu varius malesuada. Vestibulum vitae massa consequat, euismod lorem a, euismod lacus. Duis sagittis dolor risus, ac vehicula mauris lacinia quis. Nulla facilisi. Duis tristique ipsum nec egestas auctor. Nullam in felis vel ligula dictum tincidunt nec a neque. Praesent in egestas elit.</p>', '', '', '17', '3', '2014-04-19 16:57:21', '2014-06-18 20:12:32', '1');
INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `menu_location`, `date_added`, `date_updated`, `status`) VALUES ('13', '11', 'Maintenance', 'Maintenance', 'Maintenance', '<h4><span style=\"color:#B22222\">Site is under maintenance. Please check back later.</span></h4>', '', '', '17', '0', '2014-04-21 16:30:37', '2014-06-20 00:36:43', '1');
INSERT INTO `ti_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `menu_location`, `date_added`, `date_updated`, `status`) VALUES ('12', '11', 'Policy', 'Policy', 'Policy', '<div id=\"lipsum\">\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ligula eros, semper a lorem et, venenatis volutpat dolor. Pellentesque hendrerit lectus feugiat nulla cursus, quis dapibus dolor porttitor. Donec velit enim, adipiscing ac orci id, congue tincidunt arcu. Proin egestas nulla eget leo scelerisque, et semper diam ornare. Suspendisse potenti. Suspendisse vitae bibendum enim. Duis eu ligula hendrerit, lacinia felis in, mollis nisi. Sed gravida arcu in laoreet dictum. Nulla faucibus lectus a mollis dapibus. Fusce vehicula convallis urna, et congue nulla ultricies in. Nulla magna velit, bibendum eu odio et, euismod rhoncus sem. Nullam quis magna fermentum, ultricies neque nec, blandit neque. Etiam nec congue arcu. Curabitur sed tellus quam. Cras adipiscing odio odio, et porttitor dui suscipit eget. Aliquam non est commodo, elementum turpis at, pellentesque lorem.</p>\n\n<p>Duis nec diam diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate est et lorem sagittis, et mollis libero ultricies. Nunc ultrices tortor vel convallis varius. In dolor dolor, scelerisque ac faucibus ut, aliquet ac sem. Praesent consectetur lacus quis tristique posuere. Nulla sed ultricies odio. Cras tristique vulputate facilisis.</p>\n\n<p>Mauris at metus in magna condimentum gravida eu tincidunt urna. Praesent sodales vel mi eu condimentum. Suspendisse in luctus purus. Vestibulum dignissim, metus non luctus accumsan, odio ligula pharetra massa, in eleifend turpis risus in diam. Sed non lorem nibh. Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci. Nulla eget quam sit amet risus rhoncus lacinia a ut eros. Praesent non libero nisi. Mauris tincidunt at purus sit amet adipiscing. Donec interdum, velit nec dignissim vehicula, libero ipsum imperdiet ligula, lacinia mattis augue dui ac lacus. Aenean molestie sed nunc at pulvinar. Fusce ornare lacus non venenatis rhoncus.</p>\n\n<p>Aenean at enim luctus ante commodo consequat nec ut mi. Sed porta adipiscing tempus. Aliquam sit amet ullamcorper ipsum, id adipiscing quam. Fusce iaculis odio ut nisi convallis hendrerit. Morbi auctor adipiscing ligula, sit amet aliquet ante consectetur at. Donec vulputate neque eleifend libero pellentesque, vitae lacinia enim ornare. Vestibulum fermentum erat blandit, ultricies felis ac, facilisis augue. Nulla facilisis mi porttitor, interdum diam in, lobortis ipsum. In molestie quam nisl, lacinia convallis tellus fermentum ac. Nulla quis velit augue. Fusce accumsan, lacus et lobortis blandit, neque magna gravida enim, dignissim ultricies tortor dui in dolor. Vestibulum vel convallis justo, quis venenatis elit. Aliquam erat volutpat. Nunc quis iaculis ligula. Suspendisse dictum sodales neque vitae faucibus. Fusce id tellus pretium, varius nunc et, placerat metus.</p>\n\n<p>Pellentesque quis facilisis mauris. Phasellus porta, metus a dignissim viverra, est elit luctus erat, nec ultricies ligula lorem eget sapien. Pellentesque ac justo velit. Maecenas semper accumsan nulla eget rhoncus. Aliquam vel urna sed nibh dignissim auctor. Integer volutpat lacus ac purus convallis, at lobortis nisi tincidunt. Vestibulum condimentum elit ac sapien placerat, at ornare libero hendrerit. Cras tincidunt nunc sit amet ante bibendum tempor. Fusce quam orci, suscipit sed eros quis, vulputate molestie metus. Nam hendrerit vitae felis et porttitor. Proin et commodo velit, id porta erat. Donec eu consectetur odio. Fusce porta odio risus. Aliquam vel erat feugiat, vestibulum elit eget, ornare sapien. Sed sed nulla justo. Sed a dolor eu justo lacinia blandit.</p>\n</div>', '', '', '17', '3', '2014-04-19 17:21:23', '2014-04-30 18:59:20', '1');


#
# TABLE STRUCTURE FOR: ti_permalinks
#

INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('11', 'traditional', 'category_id=19');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('12', 'vegetarian', 'category_id=20');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('13', 'soups', 'category_id=21');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('14', 'specials', 'category_id=24');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('15', 'about-us', 'page_id=11');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('16', 'salads', 'category_id=17');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('17', 'maintenance', 'page_id=13');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('18', 'appetizer', 'category_id=15');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('19', 'main-course', 'category_id=16');
INSERT INTO `ti_permalinks` (`permalink_id`, `permalink`, `query`) VALUES ('20', 'seafoods', 'category_id=18');


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
