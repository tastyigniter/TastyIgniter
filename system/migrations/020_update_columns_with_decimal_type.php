<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Update all columns with type DECIMAL(15,2) to DECIMAL(15,4)
 */
class Migration_update_columns_with_decimal_type extends TI_Migration {

	public function up() {
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('order_options')." MODIFY `order_option_price` DECIMAL(15,4);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons_history')." MODIFY `amount` DECIMAL(15,4);");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons_history')." MODIFY `min_total` DECIMAL(15,4);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('option_values')." MODIFY `price` DECIMAL(15,4);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons')." MODIFY `discount` DECIMAL(15,4);");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons')." MODIFY `min_total` DECIMAL(15,4);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('menu_option_values')." MODIFY `new_price` DECIMAL(15,4);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('menus')." MODIFY `menu_price` DECIMAL(15,4) NOT NULL;");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('menus_specials')." MODIFY `special_price` DECIMAL(15,4);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('orders')." MODIFY `order_total` DECIMAL(15,4);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('order_menus')." MODIFY `price` DECIMAL(15,4);");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('order_menus')." MODIFY `subtotal` DECIMAL(15,4);");
	}

	public function down() {
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('order_options')." MODIFY `order_option_price` DECIMAL(15,2);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons_history')." MODIFY `amount` DECIMAL(15,2);");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons_history')." MODIFY `min_total` DECIMAL(15,2);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('option_values')." MODIFY `price` DECIMAL(15,2);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons')." MODIFY `discount` DECIMAL(15,2);");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons')." MODIFY `min_total` DECIMAL(15,2);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('menu_option_values')." MODIFY `new_price` DECIMAL(15,2);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('menus')." MODIFY `menu_price` DECIMAL(15,2) NOT NULL;");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('menus_specials')." MODIFY `special_price` DECIMAL(15,2);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('orders')." MODIFY `order_total` DECIMAL(15,2);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('order_menus')." MODIFY `price` DECIMAL(15,2);");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('order_menus')." MODIFY `subtotal` DECIMAL(15,2);");
	}
}

/* End of file 020_update_columns_with_decimal_type.php */
/* Location: ./system/tastyigniter/migrations/020_update_columns_with_decimal_type.php */