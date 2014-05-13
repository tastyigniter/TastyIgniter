<?php
class Dashboard_model extends CI_Model {

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

	public function getTodayChart($type = FALSE, $hour = FALSE) {
		$result = array();
		$result['total'] = 0;
		
		if ($type === 'customers') {
			$this->db->where('DATE(date_added)', 'DATE(NOW())');
			$this->db->where('HOUR(date_added)', $hour);
			$this->db->order_by('date_added', 'ASC');		
			$this->db->from('customers');
		
			$result['total'] = $this->db->count_all_results();
		
		} else if ($type === 'orders') {
			$this->db->where('status_id >', '0');
			$this->db->where('DATE(date_added)', 'DATE(NOW())', FALSE);
			$this->db->where('HOUR(order_time)', $hour);
			$this->db->group_by('HOUR(order_time)'); 
			$this->db->order_by('date_added', 'ASC');		
			$this->db->from('orders');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reservations') {
			$this->db->where('status >', '0');
			$this->db->where('DATE(reserve_date)', 'DATE(NOW())', FALSE);
			$this->db->where('HOUR(reserve_time)', $hour);
			$this->db->group_by('HOUR(reserve_time)'); 
			$this->db->order_by('reserve_date', 'ASC');		
			$this->db->from('reservations');
		
			$result['total'] = $this->db->count_all_results();
		
		} else if ($type === 'reviews') {
			$this->db->where('DATE(date_added)', 'DATE(NOW())', FALSE);
			$this->db->where('HOUR(date_added)', $hour);
			$this->db->order_by('date_added', 'ASC');		
			$this->db->from('reviews');
		
			$result['total'] = $this->db->count_all_results();
		}
		
		return $result;
	}

	public function getYesterdayChart($type = FALSE, $hour = FALSE) {
		$result = array();
		$result['total'] = 0;
		
		if ($type === 'customers') {
			$this->db->where('DATE(date_added)', 'DATE(NOW())');
			$this->db->order_by('date_added', 'ASC');		
			$this->db->from('customers');
		
			$result['total'] = $this->db->count_all_results();
		
		} else if ($type === 'orders') {
			$this->db->where('status_id >', '0');
			$this->db->where('DATE(date_added)', 'DATE(CURDATE() - 1)', FALSE);
			$this->db->where('HOUR(order_time)', $hour);
			$this->db->group_by('HOUR(order_time)'); 
			$this->db->order_by('date_added', 'ASC');		
			$this->db->from('orders');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reservations') {
			$this->db->where('status >', '0');
			$this->db->where('DATE(reserve_date)', 'DATE(CURDATE() - 1)', FALSE);
			$this->db->where('HOUR(reserve_time)', $hour);
			$this->db->group_by('HOUR(reserve_time)'); 
			$this->db->order_by('reserve_date', 'ASC');		
			$this->db->from('reservations');
		
			$result['total'] = $this->db->count_all_results();
		
		} else if ($type === 'reviews') {
			$this->db->where('DATE(date_added)', 'DATE(NOW())', FALSE);
			$this->db->where('HOUR(date_added)', $hour);
			$this->db->order_by('date_added', 'ASC');		
			$this->db->from('reviews');
		
			$result['total'] = $this->db->count_all_results();
		}
		
		return $result;
	}

	public function getThisWeekChart($type = FALSE, $date = FALSE) {
		$result = array();
		$result['total'] = 0;
		
		if ($type === 'customers') {
			$this->db->where('DATE(date_added)', $date);
			$this->db->group_by('DATE(date_added)'); 
			$this->db->from('customers');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'orders') {
			$this->db->where('status_id >', '0');
			$this->db->where('DATE(date_added)', $date);
			$this->db->group_by('DATE(date_added)'); 
			$this->db->from('orders');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reservations') {
			$this->db->where('status >', '0');
			$this->db->where('DATE(reserve_date)', $date);
			$this->db->group_by('DATE(reserve_date)'); 
			$this->db->from('reservations');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reviews') {
			$this->db->where('DATE(date_added)', $date);
			$this->db->group_by('DATE(date_added)'); 
			$this->db->from('reviews');
		
			$result['total'] = $this->db->count_all_results();
		}
		
		return $result;
	}
	
	public function getMonthChart($type = FALSE, $date = FALSE) {
		$result = array();
		$result['total'] = 0;

		if ($type === 'customers') {
			$this->db->where('DATE(date_added)', $date);
			$this->db->group_by('DAY(date_added)'); 
			$this->db->from('customers');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'orders') {
			$this->db->where('status_id >', '0');
			$this->db->where('DATE(date_added)', $date);
			$this->db->group_by('DAY(date_added)'); 
			$this->db->from('orders');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reservations') {
			$this->db->where('status >', '0');
			$this->db->where('DATE(reserve_date)', $date);
			$this->db->group_by('DAY(reserve_date)'); 
			$this->db->from('reservations');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reviews') {
			$this->db->where('DATE(date_added)', $date);
			$this->db->group_by('DAY(date_added)'); 
			$this->db->from('reviews');
		
			$result['total'] = $this->db->count_all_results();
		}
		
		return $result;
	}

	public function getYearChart($type = FALSE, $year = FALSE, $month = FALSE) {
		$result = array();
		$result['total'] = 0;

		if ($type === 'customers') {
			$this->db->where('YEAR(date_added)', (int)$year);
			$this->db->where('MONTH(date_added)', (int)$month);
			$this->db->group_by('MONTH(date_added)'); 
			$this->db->from('customers');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'orders') {
			$this->db->where('status_id >', '0');
			$this->db->where('YEAR(date_added)', (int)$year);
			$this->db->where('MONTH(date_added)', (int)$month);
			$this->db->group_by('MONTH(date_added)'); 
			$this->db->from('orders');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reservations') {
			$this->db->where('status >', '0');
			$this->db->where('YEAR(reserve_date)', (int)$year);
			$this->db->where('MONTH(reserve_date)', (int)$month);
			$this->db->group_by('MONTH(reserve_date)'); 
			$this->db->from('reservations');
		
			$result['total'] = $this->db->count_all_results();

		} else if ($type === 'reviews') {
			$this->db->where('YEAR(date_added)', (int)$year);
			$this->db->where('MONTH(date_added)', (int)$month);
			$this->db->group_by('MONTH(date_added)'); 
			$this->db->from('reviews');
		
			$result['total'] = $this->db->count_all_results();
		}
		
		return $result;
	}

	public function getReviewChart($rating_id, $menu_id) {
		$total_ratings = 0;
		$this->db->where('menu_id', $menu_id);
		$this->db->where('rating_id', $rating_id);
		$this->db->from('reviews');
		$total_ratings = $this->db->count_all_results();
		
		return $total_ratings;
	}

	public function getTotalOrders() {
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalOrdersCompleted() {

		$this->db->where('status_id', $this->config->item('order_status_complete'));
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalDeliveryOrders() {

		$this->db->where('order_type', '1');
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalCollectionOrders() {

		$this->db->where('order_type', '2');
		$this->db->from('orders');
		
		return $this->db->count_all_results();
	}

	public function getTotalTables() {

		return $this->db->count_all('tables');
	}

	public function getTotalTablesReserved() {

		$this->db->where('status >', '0');
		$this->db->from('reservations');
		
		return $this->db->count_all_results();
	}
}

/* End of file dashboard_model.php */
/* Location: ./application/models/dashboard_model.php */