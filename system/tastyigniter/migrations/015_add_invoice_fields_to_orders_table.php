<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add columns invoice_no, invoice_prefix and invoice_date to the orders table
 */
class Migration_add_invoice_fields_to_orders_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('orders', array('invoice_no INT(11) NOT NULL'));
		$this->dbforge->add_column('orders', array('invoice_prefix VARCHAR(32) NOT NULL'));
		$this->dbforge->add_column('orders', array('invoice_date DATETIME NOT NULL'));
	}

	public function down() {
		$this->dbforge->drop_column('orders', 'invoice_no');
		$this->dbforge->drop_column('orders', 'invoice_prefix');
		$this->dbforge->drop_column('orders', 'invoice_date');
	}
}

/* End of file 015_add_invoice_fields_to_orders_table.php */
/* Location: ./setup/migrations/015_add_invoice_fields_to_orders_table.php */