<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add 'currency_rate, symbol_position, thousand_sign...' columns to 'currencies' table
 */
class Migration_add_columns_to_currencies_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('currencies', array('currency_rate DECIMAL(15,8) NOT NULL AFTER currency_symbol'));
		$this->dbforge->add_column('currencies', array('symbol_position TINYINT NOT NULL AFTER currency_rate'));
		$this->dbforge->add_column('currencies', array('thousand_sign CHAR(1) NOT NULL AFTER symbol_position'));
		$this->dbforge->add_column('currencies', array('decimal_sign CHAR(1) NOT NULL AFTER thousand_sign'));
		$this->dbforge->add_column('currencies', array('decimal_position CHAR(1) NOT NULL AFTER decimal_sign'));
		$this->dbforge->add_column('currencies', array('date_modified DATETIME NOT NULL AFTER currency_status'));

		$this->db->set('symbol_position', '0');
		$this->db->set('thousand_sign', ',');
		$this->db->set('decimal_sign', '.');
		$this->db->set('decimal_position', '2');
		$this->db->set('date_modified', mdate('%Y-%m-%d %H:%i:%s', strtotime('-1 day')));
		$this->db->update('currencies');
	}

	public function down() {
		$this->dbforge->drop_column('currencies', 'currency_rate');
		$this->dbforge->drop_column('currencies', 'symbol_position');
		$this->dbforge->drop_column('currencies', 'thousand_sign');
		$this->dbforge->drop_column('currencies', 'decimal_sign');
		$this->dbforge->drop_column('currencies', 'decimal_position');
		$this->dbforge->drop_column('currencies', 'date_modified');
	}
}

/* End of file 019_add_columns_to_currencies_table.php */
/* Location: ./setup/migrations/019_add_columns_to_currencies_table.php */