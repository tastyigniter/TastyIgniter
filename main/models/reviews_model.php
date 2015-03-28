<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reviews_model extends CI_Model {

    public function getCount($filter = array()) {
		if ((!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) OR (!empty($filter['location_id']) AND is_numeric($filter['location_id']))) {
			if (!empty($filter['customer_id'])) {
				$this->db->where('customer_id', $filter['customer_id']);
			}

			if (!empty($filter['location_id'])) {
				$this->db->where('reviews.location_id', $filter['location_id']);
			}

			$this->db->where('review_status', '1');

			$this->db->from('reviews');
			return $this->db->count_all_results();
		}
    }

	public function getList($filter = array()) {
		$result = array();
		if ((!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) OR (!empty($filter['location_id']) AND is_numeric($filter['location_id']))) {
			if (!empty($filter['page']) AND $filter['page'] !== 0) {
				$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
			}

			if ($this->db->limit($filter['limit'], $filter['page'])) {
				$this->db->from('reviews');
				$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

				$this->db->where('review_status', '1');

				if (!empty($filter['customer_id'])) {
					$this->db->where('customer_id', $filter['customer_id']);
				}

				if (!empty($filter['location_id'])) {
					$this->db->where('reviews.location_id', $filter['location_id']);
				}

				$query = $this->db->get();
				if ($query->num_rows() > 0) {
					$result = $query->result_array();
				}
			}
		}

		return $result;
	}

	public function getReviews($customer_id = FALSE) {
		if ($customer_id !== FALSE) {
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			$this->db->where('review_status', '1');
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getReview($customer_id, $review_id, $sale_type = '') {
		if (!empty($customer_id) AND !empty($review_id)) {
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			$this->db->where('customer_id', $customer_id);
			$this->db->where('review_id', $review_id);

			if ($sale_type !== '') {
				$this->db->where('sale_type', $sale_type);
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getTotalLocationReviews($location_id) {
		$this->db->where('location_id', $location_id);
		$this->db->where('review_status', '1');
		$this->db->from('reviews');
		$total_reviews = $this->db->count_all_results();

		return $total_reviews;
	}

	public function checkReviewed($sale_type = 'order', $sale_id = '', $customer_id = '') {
		if ($sale_type === 'reservation') {
			$check_query = $this->db->get_where('reservations', array('reservation_id' => $sale_id, 'customer_id' => $customer_id));
		} else {
			$check_query = $this->db->get_where('orders', array('order_id' => $sale_id, 'customer_id' => $customer_id));
		}

		if ($check_query->num_rows() > 0) {
			$this->db->from('reviews');

			$this->db->where('customer_id', $customer_id);

			$this->db->where('sale_type', $sale_type);
			$this->db->where('sale_id', $sale_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return TRUE;
			}
		}

		return FALSE;
	}

	public function addReview($add = array()) {
		$query = FALSE;

		if (!empty($add['sale_type'])) {
			$this->db->set('sale_type', $add['sale_type']);
		}

		if (!empty($add['sale_id'])) {
			$this->db->set('sale_id', $add['sale_id']);
		}

		if (!empty($add['location_id'])) {
			$this->db->set('location_id', $add['location_id']);
		}

		if (!empty($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (!empty($add['author'])) {
			$this->db->set('author', $add['author']);
		}

		if (!empty($add['rating'])) {
			if (isset($add['rating']['quality'])) {
				$this->db->set('quality', $add['rating']['quality']);
			}

			if (isset($add['rating']['delivery'])) {
				$this->db->set('delivery', $add['rating']['delivery']);
			}

			if (isset($add['rating']['service'])) {
				$this->db->set('service', $add['rating']['service']);
			}
		}

		if (!empty($add['review_text'])) {
			$this->db->set('review_text', $add['review_text']);
		}

		if ($this->config->item('approve_reviews') === '1') {
			$this->db->set('review_status', '0');
		} else {
			$this->db->set('review_status', '1');
		}

		if (!empty($add)) {
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			if ($this->db->insert('reviews')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}
}

/* End of file reviews_model.php */
/* Location: ./main/models/reviews_model.php */