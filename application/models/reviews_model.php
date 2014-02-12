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
			$this->db->join('menus', 'menus.menu_id = reviews.menu_id', 'left');

			$query = $this->db->get();
			$result = array();
	
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
	
			return $result;
		}
	}

	public function getReviews() {
		$this->db->from('reviews');
		//$this->db->join('customers', 'customers.customer_id = reviews.customer_id', 'left');
		$this->db->join('menus', 'menus.menu_id = reviews.menu_id', 'left');

		if ($this->config->item('approve_reviews') === '1') {
			$this->db->where('review_status', '1');
		}
	}
		
	public function getRatings() {
		$this->db->from('ratings');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getReview($review_id) {
		$this->db->from('reviews');
		$this->db->join('menus', 'menus.menu_id = reviews.menu_id', 'left');

		$this->db->where('review_id', $review_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getTotalReviews() {
		$total_reviews = array();
		
		$this->db->select('menu_id, COUNT( menu_id ) AS total_reviews');
		$this->db->from('reviews');
		$this->db->group_by('menu_id');
		$this->db->having('total_reviews >= 1');
		$this->db->where('review_status', '1');

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$total_reviews = $query->result_array();
		}

		return $total_reviews;
	}

	public function checkReview($customer_id) {
		$this->db->from('reviews');

		$this->db->where('menu_id', $menu_id);
		$this->db->where('customer_id', $customer_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();		
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
		if (!empty($update['customer_id'])) {
			$this->db->set('customer_id', $update['customer_id']);
		}

		if (!empty($add['author'])) {
			$this->db->set('author', $add['author']);
		}

		if (!empty($update['menu_id'])) {
			$this->db->set('menu_id', $update['menu_id']);
		}

		if (!empty($update['rating_id'])) {
			$this->db->set('rating_id', $update['rating_id']);
		}

		if (!empty($update['review_text'])) {
			$this->db->set('review_text', $update['review_text']);
		}

		if (!empty($update['review_status'])) {
			$this->db->set('review_status', (int)$update['review_status']);
		}

		if (!empty($update['review_id'])) {
			$this->db->where('review_id', $update['review_id']);
			$this->db->update('reviews'); 
		}
				
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function updateRating($rating_id, $rating_name) {
		$this->db->set('rating_name', $rating_name);

		$this->db->where('rating_id', $rating_id);
		$this->db->update('ratings'); 
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function addReview($add = array()) {
		if (!empty($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (!empty($add['author'])) {
			$this->db->set('author', $add['author']);
		}

		if (!empty($add['menu_id'])) {
			$this->db->set('menu_id', $add['menu_id']);
		}

		if (!empty($add['rating_id'])) {
			$this->db->set('rating_id', $add['rating_id']);
		}

		if (!empty($add['review_text'])) {
			$this->db->set('review_text', $add['review_text']);
		}

		if (!empty($add['review_status'])) {
			$this->db->set('review_status', $add['review_status']);
		}

		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}

		$this->db->insert('reviews'); 

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function addRating($rating_name) {
		$insert_data = array();
		
		$insert_data['rating_name'] = $rating_name;
			
		return $this->db->insert('ratings', $insert_data);
	}

	public function deleteRating($rating_id) {
		$this->db->where('rating_id', $rating_id);
			
		return $this->db->delete('ratings');
	}

	public function deleteReview($review_id) {
		$this->db->where('review_id', $review_id);
			
		return $this->db->delete('reviews');
	}
	
	public function foodReview($food_id, $customer_id, $rating_id) {
	
		$review_data = $this->checkReview($food_id, $customer_id);
		
		if ($review_data) {
 					
			$this->db->where('review_id', $review_data['review_id']);
			$this->db->where('customer_id', $review_data['customer_id']);
			$this->db->where('food_id', $review_data['food_id']);
			return $this->db->update('reviews', $update = array('food_rating' => $rating_id));

		}
		
		if ( ! $review_data && $customer_id !== FALSE) {
			
			$update['customer_id'] = $customer_id;
			$update['food_id'] = $food_id;
			$update['food_rating'] = $rating_id;

			return $this->db->insert('reviews', $update);
					
		}
	}
}