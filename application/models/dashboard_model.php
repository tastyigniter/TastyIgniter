<?php
class Dashboard_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getTotalCustomers() {

		return $this->db->count_all('customers');
	}

	public function getTotalMenus() {

		return $this->db->count_all('menus');
	}

	public function getTotalSales() {

		$this->db->select_sum('order_total', 'total_sales');
		$this->db->where('status_id >', '0');
		$query = $this->db->get('orders');
		
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['total_sales'];
		}
	}

	public function getTotalSalesByYear() {
		$year = date('Y');
		
		$this->db->select_sum('order_total', 'total_sales_by_year');
		$this->db->where('status_id >', '0');
		$this->db->where('YEAR(date_added)', $year);
		$query = $this->db->get('orders');
		
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['total_sales_by_year'];
		}
	}

	public function getTotalLostSales() {

		$this->db->select_sum('order_total', 'total_sales');
		$this->db->where('status_id', '13'); //$this->config->item('order_canceled')
		$query = $this->db->get('orders');
		
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['total_sales'];
		}
	}

	public function getTotalOrdersReceived() {

		$this->db->where('status_id', $this->config->item('order_received'));
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalOrdersCompleted() {

		$this->db->where('status_id', $this->config->item('order_completed'));
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalOrdersDelivered() {

		$this->db->where('order_type', '1');
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalOrdersPickedUp() {

		$this->db->where('order_type', '2');
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalTables() {

		return $this->db->count_all('tables');
	}

	public function getTotalTablesReserved() {

		$this->db->where('status', $this->config->item('reserve_status'));
		$this->db->from('reservations');
		
		return $this->db->count_all_results();
	}

	public function getTotalMenuReviews($menu_id) {
		
  		$rating_data = array();

		$this->db->where('menu_id', $menu_id);
		$this->db->from('reviews');
		$total_reviews = $this->db->count_all_results();

		if ($total_reviews > 0) {

			$ratings = $this->config->item('ratings');
			
			foreach ($ratings as $rating_id => $rating) {
				
				$this->db->where('menu_id', $menu_id);
				$this->db->where('rating_id', $rating_id);
				$this->db->from('reviews');
				$total_ratings = $this->db->count_all_results();

        		$rating_data['total'][$rating_id] = $total_ratings;
        		$rating_data['percent'][$rating_id] = ($total_ratings / $total_reviews) * 100;
			
			}
		}
		
		return $rating_data;
	}
}