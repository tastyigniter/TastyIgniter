<?php
class Reviews_model extends CI_Model {

    public function record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('author', $filter['filter_search']);
			$this->db->or_like('location_name', $filter['filter_search']);
			$this->db->or_like('order_id', $filter['filter_search']);
		}

		if (!empty($filter['filter_location'])) {
			$this->db->where('reviews.location_id', $filter['filter_location']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('review_status', $filter['filter_status']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		$this->db->from('reviews');
		$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');
		return $this->db->count_all_results();
    }
	
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}
		
			if (!empty($filter['filter_location'])) {
				$this->db->where('reviews.location_id', $filter['filter_location']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('author', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('order_id', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('review_status', $filter['filter_status']);
			}
	
			if (!empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			$query = $this->db->get();
			$result = array();
	
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
	
			return $result;
		}
	}

	public function getMainReviews($customer_id) {
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
		
	public function getReview($review_id) {
		$this->db->from('reviews');
		$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

		$this->db->where('review_id', $review_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getReviewDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('reviews');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
	
	public function getCustomerReview($customer_id, $review_id, $order_id, $location_id) {
		if (!empty($customer_id) AND !empty($review_id) AND !empty($order_id) AND !empty($location_id)) {
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			$this->db->where('customer_id', $customer_id);
			$this->db->where('review_id', $review_id);
			$this->db->where('order_id', $order_id);
			$this->db->where('reviews.location_id', $location_id);

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

	public function checkCustomerReview($customer_id = '', $location_id = '', $order_id = '') {
		$location_query = $this->db->get_where('locations', array('location_id' => $location_id));
		$order_query = $this->db->get_where('orders', array('order_id' => $order_id, 'customer_id' => $customer_id));
		
		if ($location_query->num_rows() > 0 AND $order_query->num_rows() > 0) {
			$this->db->from('reviews');

			$this->db->where('customer_id', $customer_id);
			$this->db->where('location_id', $location_id);
			$this->db->where('order_id', $order_id);
		
			$query = $this->db->get();
		
			if ($query->num_rows() > 0) {
				return FALSE;		
			}

			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function updateReview($update = array()) {
		$query = FALSE;

		if (!empty($update['order_id'])) {
			$this->db->set('order_id', $update['order_id']);
		}

		if (!empty($update['location_id'])) {
			$this->db->set('location_id', $update['location_id']);
		}

		if (!empty($update['customer_id'])) {
			$this->db->set('customer_id', $update['customer_id']);
		}

		if (!empty($update['author'])) {
			$this->db->set('author', $update['author']);
		}

		if (!empty($update['quality'])) {
			$this->db->set('quality', $update['quality']);
		}

		if (!empty($update['delivery'])) {
			$this->db->set('delivery', $update['delivery']);
		}

		if (!empty($update['service'])) {
			$this->db->set('service', $update['service']);
		}

		if (!empty($update['review_text'])) {
			$this->db->set('review_text', $update['review_text']);
		}

		if ($update['review_status'] === '1') {
			$this->db->set('review_status', '1');
		} else {
			$this->db->set('review_status', '0');
		}

		if (!empty($update['review_id'])) {
			$this->db->where('review_id', $update['review_id']);
			$query = $this->db->update('reviews'); 
		}
				
		return $query;
	}
	
	public function addReview($add = array()) {
		$query = FALSE;

		if (!empty($add['location_id'])) {
			$this->db->set('location_id', $add['location_id']);
		}

		if (!empty($add['order_id'])) {
			$this->db->set('order_id', $add['order_id']);
		}

		if (!empty($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (!empty($add['author'])) {
			$this->db->set('author', $add['author']);
		}

		if (!empty($add['quality'])) {
			$this->db->set('quality', $add['quality']);
		}

		if (!empty($add['delivery'])) {
			$this->db->set('delivery', $add['delivery']);
		}

		if (!empty($add['service'])) {
			$this->db->set('service', $add['service']);
		}

		if (!empty($add['review_text'])) {
			$this->db->set('review_text', $add['review_text']);
		}

		if ($add['review_status'] === '1') {
			$this->db->set('review_status', '1');
		} else {
			$this->db->set('review_status', '0');
		}

		if (!empty($add)) {
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			if ($this->db->insert('reviews')) {
				$query = $this->db->insert_id();
			}
		}
		
		return $query;
	}
	
	public function deleteReview($review_id) {
		if (is_numeric($review_id)) {
			$this->db->where('review_id', $review_id);
			$this->db->delete('reviews');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file reviews_model.php */
/* Location: ./application/models/reviews_model.php */