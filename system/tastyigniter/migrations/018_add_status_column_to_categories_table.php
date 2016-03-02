<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add status column to categories table
 */
class Migration_add_status_column_to_categories_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('categories', array('status TINYINT(4) NOT NULL DEFAULT "1"'));

		$this->db->set('status', '1');
		$this->db->update('categories');
	}

	public function down() {
		$this->dbforge->drop_column('categories', 'status');
	}
}

/* End of file 018_add_status_column_to_categories_table.php */
/* Location: ./setup/migrations/018_add_status_column_to_categories_table.php */