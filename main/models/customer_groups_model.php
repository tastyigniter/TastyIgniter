<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Customer_groups_model extends CI_Model {

	public function getCustomerGroup($customer_group_id) {
		$this->db->from('customer_groups');

		$this->db->where('customer_group_id', $customer_group_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}
}

/* End of file customer_groups_model.php */
/* Location: ./main/models/customer_groups_model.php */