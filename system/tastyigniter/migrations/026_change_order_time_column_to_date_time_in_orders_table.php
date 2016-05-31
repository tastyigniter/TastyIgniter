<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add order_date column to the orders table
 */
class Migration_change_order_time_column_to_date_time_in_orders_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('orders', array('order_date DATE NOT NULL AFTER order_time'));

		$this->db->select('order_id, date_added');
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$this->db->set('order_date', mdate('%Y-%m-%d', strtotime($row['date_added'])));
				$this->db->where('order_id', $row['order_id']);
				$this->db->update('orders');
			}
		}
	}

	public function down() {
		$this->dbforge->drop_column('orders', 'order_date');
	}
}

/* End of file 026_change_order_time_column_to_date_time_in_orders_table.php */
/* Location: ./setup/migrations/026_change_order_time_column_to_date_time_in_orders_table.php */