<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add column status to the coupons_history table
 */
class Migration_add_column_status_to_coupons_history_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('coupons_history', array('status TINYINT NOT NULL'));

		$this->db->set('status', '1');
		$this->db->update('coupons_history');
	}

	public function down() {
		$this->dbforge->drop_column('coupons_history', 'status');
	}
}

/* End of file 021_add_column_status_to_coupons_history_table.php */
/* Location: ./setup/migrations/021_add_column_status_to_coupons_history_table.php */