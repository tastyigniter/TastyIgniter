<?php
class Reviews_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
        return $this->db->count_all('reviews');
    }
	
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('reviews');
			//$this->db->join('customers', 'customers.customer_id = reviews.customer_id', 'left');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');
			$this->db->order_by('reviews.date_added', 'DESC');

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

	public function getMainReview($review_id, $customer_id) {
		$this->db->from('reviews');
		$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

		$this->db->where('review_id', $review_id);
		$this->db->where('customer_id', $customer_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
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
		
	public function reviewMenu($customer_id, $customer_name, $menu_id, $rating_id, $review_text, $date_added) {
	
		$this->load->model('Cart_model'); // load the menus model

		//$review_data = $this->checkReview($menu_id, $customer_id);
		
		if ($this->Cart_model->getMenu($menu_id)) {
 					
			$this->db->set('customer_id', $customer_id);
			$this->db->set('author', $customer_name);
			$this->db->set('menu_id', $menu_id);
			$this->db->set('rating_id', $rating_id);
			$this->db->set('review_text', $review_text);
			$this->db->set('date_added', $date_added);
			
			if ($this->config->item('approve_reviews') === '1') {
				$this->db->set('review_status', '0');			
			} else {
				$this->db->set('review_status', '1');			
			}			
			
			$this->db->insert('reviews');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function updateReview($update = array()) {
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
			$this->db->update('reviews'); 
		}
				
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function addReview($add = array()) {
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

		$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));

		$this->db->insert('reviews'); 

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function deleteReview($review_id) {
		$this->db->where('review_id', $review_id);
			
		return $this->db->delete('reviews');
	}
}