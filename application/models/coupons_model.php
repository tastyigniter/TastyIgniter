<?php
class Coupons_model extends CI_Model {

    public function record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('name', $filter['filter_search']);
			$this->db->or_like('code', $filter['filter_search']);
		}

		if (!empty($filter['filter_type'])) {
			$this->db->where('type', $filter['filter_type']);
		}

		if (!empty($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('coupons');
		return $this->db->count_all_results();
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
			
		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('coupons');
			
			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
			
			if (!empty($filter['filter_search'])) {
				$this->db->like('name', $filter['filter_search']);
				$this->db->or_like('code', $filter['filter_search']);
			}

			if (!empty($filter['filter_type'])) {
				$this->db->where('type', $filter['filter_type']);
			}
	
			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}
	
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}

	public function getCoupons() {
		$this->db->from('coupons');
			
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getCoupon($coupon_id) {
		$this->db->from('coupons');
		$this->db->where('coupon_id', $coupon_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getCouponByCode($code) {
		$this->db->from('coupons');
		$this->db->where('code', $code);
			
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getCouponHistories($coupon_id) {
		$this->db->select('*, COUNT('. $this->db->dbprefix('coupons_history.order_id'). ') AS used');
		$this->db->from('coupons_history');
		$this->db->join('orders', 'orders.order_id = coupons_history.order_id', 'left');

		$this->db->where('coupons_history.coupon_id', $coupon_id);
		$this->db->group_by('coupons_history.customer_id'); 
					
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
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

	public function checkCouponHistory($coupon_id) {
		if (!empty($coupon_id)) {
			$this->db->where('coupon_id', $coupon_id);
			$this->db->from('coupons_history');
		
			return $this->db->count_all_results();
		}
	}

	public function checkCustomerCouponHistory($coupon_id, $customer_id) {
		if (!empty($coupon_id)) {
			$this->db->where('coupon_id', $coupon_id);
			$this->db->where('customer_id', $customer_id);
			$this->db->from('coupons_history');
		
			return $this->db->count_all_results();
		}
	}

	public function updateCoupon($update = array()) {
		$query = FALSE;

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
		
		if ($update['redemptions'] > 0) {
			$this->db->set('redemptions', $update['redemptions']);
		} else {
			$this->db->set('redemptions', '0');
		}

		if ($update['customer_redemptions'] > 0) {
			$this->db->set('customer_redemptions', $update['customer_redemptions']);
		} else {
			$this->db->set('customer_redemptions', '0');
		}

		if (!empty($update['description'])) {
			$this->db->set('description', $update['description']);
		}
		
		if (!empty($update['start_date'])) {
			$this->db->set('start_date', mdate('%Y-%m-%d', strtotime($update['start_date'])));
		}
		
		if (!empty($update['end_date'])) {
			$this->db->set('end_date', mdate('%Y-%m-%d', strtotime($update['end_date'])));
		}
		
		if ($update['status'] === '1') {
			$this->db->set('status', $update['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (!empty($update['coupon_id'])) {
			$this->db->where('coupon_id', $update['coupon_id']);
			$query = $this->db->update('coupons'); 
		}
		
		return $query;
	}

	public function addCoupon($add = array()) {
		$query = FALSE;
		
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
		
		if ($add['redemptions'] > 0) {
			$this->db->set('redemptions', $add['redemptions']);
		} else {
			$this->db->set('redemptions', '0');
		}

		if ($add['customer_redemptions'] > 0) {
			$this->db->set('customer_redemptions', $add['customer_redemptions']);
		} else {
			$this->db->set('customer_redemptions', '0');
		}

		if (!empty($add['description'])) {
			$this->db->set('description', $add['description']);
		}
		
		if (!empty($add['start_date'])) {
			$this->db->set('start_date', mdate('%Y-%m-%d', strtotime($add['start_date'])));
		}
		
		if (!empty($add['end_date'])) {
			$this->db->set('end_date', mdate('%Y-%m-%d', strtotime($add['end_date'])));
		}
		
		if ($add['status'] === '1') {
			$this->db->set('status', $add['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (!empty($add)) {
			$this->db->set('date_added', mdate('%Y-%m-%d', time()));

			if ($this->db->insert('coupons')) {
				$query = $this->db->insert_id();
			}
		}
		
		return $query;
	}

	public function deleteCoupon($coupon_id) {
		if (is_numeric($coupon_id)) {
			$this->db->where('coupon_id', $coupon_id);
			$this->db->delete('coupons');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file coupons_model.php */
/* Location: ./application/models/coupons_model.php */