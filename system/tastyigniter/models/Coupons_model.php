<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Coupons_model extends TI_Model {

    public function getCount($filter = array()) {
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
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
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
		$this->db->from('coupons_history');
		$this->db->join('orders', 'orders.order_id = coupons_history.order_id', 'left');

		$this->db->where('coupons_history.coupon_id', $coupon_id);
		//$this->db->group_by('coupons_history.customer_id');
		$this->db->order_by('coupons_history.date_used', 'DESC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function saveCoupon($coupon_id, $save = array()) {
        if (empty($save)) return FALSE;

		if (!empty($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (!empty($save['code'])) {
			$this->db->set('code', $save['code']);
		}

		if (!empty($save['type'])) {
			$this->db->set('type', $save['type']);
		}

		if (!empty($save['discount'])) {
			$this->db->set('discount', $save['discount']);
		}

		if (!empty($save['min_total'])) {
			$this->db->set('min_total', $save['min_total']);
		}

		if ($save['redemptions'] > 0) {
			$this->db->set('redemptions', $save['redemptions']);
		} else {
			$this->db->set('redemptions', '0');
		}

		if ($save['customer_redemptions'] > 0) {
			$this->db->set('customer_redemptions', $save['customer_redemptions']);
		} else {
			$this->db->set('customer_redemptions', '0');
		}

        if (!empty($save['validity']) AND !empty($save['validity_times'])) {
			$this->db->set('validity', $save['validity']);

			if ($save['validity'] == 'fixed') {
				if (!empty($save['validity_times']['fixed_date'])) {
					$this->db->set('fixed_date', mdate('%Y-%m-%d', strtotime($save['validity_times']['fixed_date'])));
				}

				if (!empty($save['validity_times']['fixed_from_time'])) {
					$this->db->set('fixed_from_time', mdate('%H:%i', strtotime($save['validity_times']['fixed_from_time'])));
				} else {
                    $this->db->set('fixed_from_time', mdate('%H:%i', strtotime('12:00 AM')));
                }

				if (!empty($save['validity_times']['fixed_to_time'])) {
					$this->db->set('fixed_to_time', mdate('%H:%i', strtotime($save['validity_times']['fixed_to_time'])));
                } else {
                    $this->db->set('fixed_to_time', mdate('%H:%i', strtotime('11:59 PM')));
				}
			} else if ($save['validity'] == 'period') {
				if (!empty($save['validity_times']['period_start_date'])) {
					$this->db->set('period_start_date', mdate('%Y-%m-%d', strtotime($save['validity_times']['period_start_date'])));
				}

				if (!empty($save['validity_times']['period_end_date'])) {
					$this->db->set('period_end_date', mdate('%Y-%m-%d', strtotime($save['validity_times']['period_end_date'])));
				}
			} else if ($save['validity'] == 'recurring') {
				if (!empty($save['validity_times']['recurring_every'])) {
					$this->db->set('recurring_every', implode(', ', $save['validity_times']['recurring_every']));
				}

				if (!empty($save['validity_times']['recurring_from_time'])) {
					$this->db->set('recurring_from_time', mdate('%H:%i', strtotime($save['validity_times']['recurring_from_time'])));
                } else {
                    $this->db->set('recurring_from_time', mdate('%H:%i', strtotime('12:00 AM')));
				}

				if (!empty($save['validity_times']['recurring_to_time'])) {
					$this->db->set('recurring_to_time', mdate('%H:%i', strtotime($save['validity_times']['recurring_to_time'])));
                } else {
                    $this->db->set('recurring_to_time', mdate('%H:%i', strtotime('11:59 PM')));
				}
			}
		}

		if (!empty($save['description'])) {
			$this->db->set('description', $save['description']);
		}

		if ($save['status'] === '1') {
			$this->db->set('status', $save['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($coupon_id)) {
            $this->db->where('coupon_id', $coupon_id);
            $query = $this->db->update('coupons');
        } else {
            $this->db->set('date_added', mdate('%Y-%m-%d', time()));
            $query = $this->db->insert('coupons');
            $coupon_id = $this->db->insert_id();
        }

        return $coupon_id;
    }

	public function deleteCoupon($coupon_id) {
        if (is_numeric($coupon_id)) $coupon_id = array($coupon_id);

        if (!empty($coupon_id) AND ctype_digit(implode('', $coupon_id))) {
            $this->db->where_in('coupon_id', $coupon_id);
            $this->db->delete('coupons');

            return $this->db->affected_rows();
        }
	}
}

/* End of file coupons_model.php */
/* Location: ./system/tastyigniter/models/coupons_model.php */