<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add column cart to the customers table
 */
class Migration_add_cart_column_to_customers_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('customers', array('cart TEXT NOT NULL'));
	}

	public function down() {
		$this->dbforge->drop_column('customers', 'cart');
	}
}

/* End of file 014_add_cart_column_to_customers_table.php */
/* Location: ./setup/migrations/014_add_cart_column_to_customers_table.php */