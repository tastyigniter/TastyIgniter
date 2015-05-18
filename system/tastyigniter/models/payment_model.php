<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Payment_model extends TI_Model {

	public function getPaypalDetails($order_id, $customer_id) {
		$this->db->from('pp_payments');
		$this->db->where('order_id', $order_id);
		$this->db->where('customer_id', $customer_id);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			return unserialize($row['serialized']);
		}
	}
}

/* End of file payment_model.php */
/* Location: ./system/tastyigniter/models/payment_model.php */