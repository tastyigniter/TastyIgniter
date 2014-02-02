<?php
class Coupons_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
	
    public function record_count() {
        return $this->db->count_all('coupons');
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('coupons');
			
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function getCoupons() {
		$this->db->from('coupons');
			
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCoupon($coupon_id) {
		$this->db->from('coupons');
		$this->db->where('coupon_id', $coupon_id);
			
		$query = $this->db->get();
		return $query->row_array();
	}

	public function checkCoupon($code) {
		if (!empty($code)) {
			$this->db->from('coupons');
			$this->db->where('code', $code);
			$this->db->where('((start_date <= CURRENT_DATE() OR start_date = 0000-00-00)');
			$this->db->where('(end_date >= CURRENT_DATE() OR end_date = 0000-00-00))');

			$this->db->where('status', '1');
			
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function addCoupon($add = array()) {

		if (!empty($add['name'])) {
			$this->db->set('name', $add['name']);
		}
				
		if (!empty($add['code'])) {
			$this->db->set('code', $add['code']);
		}
		
		if (!empty($add['type'])) {
			$this->db->set('type', $add['type']);
		}
		
		if (!empty($add['discount'])) {
			$this->db->set('discount', $add['discount']);
		}
		
		if (!empty($add['min_total'])) {
			$this->db->set('min_total', $add['min_total']);
		}
		
		if (!empty($add['description'])) {
			$this->db->set('description', $add['description']);
		}
		
		if (!empty($add['start_date'])) {
			$this->db->set('start_date', $add['start_date']);
		}
		
		if (!empty($add['end_date'])) {
			$this->db->set('end_date', $add['end_date']);
		}
		
		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}
		
		if ($add['status'] === '1') {
			$this->db->set('status', $add['status']);
		} else {
			$this->db->set('status', '0');
		}

		$this->db->insert('coupons');
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function updateCoupon($update = array()) {

		if (!empty($update['name'])) {
			$this->db->set('name', $update['name']);
		}
				
		if (!empty($update['code'])) {
			$this->db->set('code', $update['code']);
		}
		
		if (!empty($update['type'])) {
			$this->db->set('type', $update['type']);
		}
		
		if (!empty($update['discount'])) {
			$this->db->set('discount', $update['discount']);
		}
		
		if (!empty($update['min_total'])) {
			$this->db->set('min_total', $update['min_total']);
		}
		
		if (!empty($update['description'])) {
			$this->db->set('description', $update['description']);
		}
		
		if (!empty($update['start_date'])) {
			$this->db->set('start_date', $update['start_date']);
		}
		
		if (!empty($update['end_date'])) {
			$this->db->set('end_date', $update['end_date']);
		}
		
		if (!empty($update['date_added'])) {
			$this->db->set('date_added', $update['date_added']);
		}
		
		if ($update['status'] === '1') {
			$this->db->set('status', $update['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (!empty($update['coupon_id'])) {
			$this->db->where('coupon_id', $update['coupon_id']);
			$this->db->update('coupons'); 
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteCoupon($coupon_id) {
		$this->db->where('coupon_id', $coupon_id);
		
		$this->db->delete('coupons');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}
