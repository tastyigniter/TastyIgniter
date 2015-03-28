<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Coupons_model extends CI_Model {

 	public function getCouponByCode($code) {
		$this->db->from('coupons');
		$this->db->where('code', $code);

		$query = $this->db->get();
		return $query->row_array();
	}
}

/* End of file coupons_model.php */
/* Location: ./main/models/coupons_model.php */