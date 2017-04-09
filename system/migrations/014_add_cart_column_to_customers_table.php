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
 * Add column cart to the customers table
 */
class Migration_add_cart_column_to_customers_table extends TI_Migration {

	public function up() {
		$this->dbforge->add_column('customers', array('cart TEXT NOT NULL'));
	}

	public function down() {
		$this->dbforge->drop_column('customers', 'cart');
	}
}

/* End of file 014_add_cart_column_to_customers_table.php */
/* Location: ./system/tastyigniter/migrations/014_add_cart_column_to_customers_table.php */