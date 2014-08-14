<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Dashboard_model extends CI_Model {

	public function getStatistics($stat_range = '') {
		$results = array();
		if ($stat_range === '') {
			return $results;
		} 
		
		$results['sales'] 				= $this->Dashboard_model->getTotalSales($stat_range);
		$results['lost_sales'] 			= $this->Dashboard_model->getTotalLostSales($stat_range);
		$results['customers'] 			= $this->Dashboard_model->getTotalCustomers($stat_range);
		$results['orders'] 				= $this->Dashboard_model->getTotalOrders($stat_range);
		$results['orders_completed'] 	= $this->Dashboard_model->getTotalOrdersCompleted($stat_range);
		$results['delivery_orders'] 	= $this->Dashboard_model->getTotalDeliveryOrders($stat_range);
		$results['collection_orders'] 	= $this->Dashboard_model->getTotalCollectionOrders($stat_range);
		$results['tables_reserved'] 	= $this->Dashboard_model->getTotalTablesReserved($stat_range);
	
		return $results;
	}
	
	public function getTotalMenus() {
		return $this->db->count_all('menus');
	}

	public function getTotalSales($stat_range = '') {
		$total_sales = 0;
		
		if ($stat_range !== '' AND !empty($stat_range)) {
			$this->db->select_sum('order_total', 'total_sales');
			$this->db->where('status_id >', '0');
			
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			$query = $this->db->get('orders');
			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$total_sales = $row['total_sales'];
			}
		}
		
		return $total_sales;
	}

	public function getTotalLostSales($stat_range = '') {
		$total_lost_sales = 0;

		if ($stat_range !== '' AND !empty($stat_range)) {
			$this->db->select_sum('order_total', 'total_lost_sales');
			$this->db->where('status_id', '13'); //$this->config->item('order_canceled')
			$query = $this->db->get('orders');
		
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$total_lost_sales =  $row['total_lost_sales'];
			}
		}
		
		return $total_lost_sales;
	}

	public function getTotalCustomers($stat_range = '') {
		$total_customers = 0;

		if ($stat_range !== '' AND !empty($stat_range)) {
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			$this->db->from('customers');
			$total_customers = $this->db->count_all_results();
		}

		return $total_customers;
	}

	public function getTotalOrders($stat_range = '') {
		$total_orders = 0;

		if ($stat_range !== '' AND !empty($stat_range)) {
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			$this->db->from('orders');
			$total_orders = $this->db->count_all_results();
		}

		return $total_orders;
	}

	public function getTotalOrdersCompleted($stat_range = '') {
		$total_orders_completed = 0;

		if ($stat_range !== '' AND !empty($stat_range)) {
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			$this->db->where('status_id', $this->config->item('order_status_complete'));
			$this->db->from('orders');
			$total_orders_completed = $this->db->count_all_results();
		}

		return $total_orders_completed;
	}

	public function getTotalDeliveryOrders($stat_range = '') {
		$total_delivery_orders = 0;

		if ($stat_range !== '' AND !empty($stat_range)) {
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			$this->db->where('order_type', '1');
			$this->db->from('orders');
		
			$total_delivery_orders = $this->db->count_all_results();
		}

		return $total_delivery_orders;
	}

	public function getTotalCollectionOrders($stat_range = '') {
		$total_collection_orders = 0;

		if ($stat_range !== '' AND !empty($stat_range)) {
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			$this->db->where('order_type', '2');
			$this->db->from('orders');
		
			$total_collection_orders = $this->db->count_all_results();
		}

		return $total_collection_orders;
	}

	public function getTotalTables() {
		return $this->db->count_all_results('tables');
	}

	public function getTotalTablesReserved($stat_range = '') {
		$total_tables_reserved = 0;

		if ($stat_range !== '' AND !empty($stat_range)) {
			if ($stat_range === 'today') {
				$this->db->where('DATE(date_added)', date('Y-m-d'));
			} else if ($stat_range === 'week') { 
				$this->db->where('WEEK(date_added)', date('W'));
			} else if ($stat_range === 'month') { 
				$this->db->where('MONTH(date_added)', date('m'));
			} else if ($stat_range === 'year') { 
				$this->db->where('YEAR(date_added)', date('Y'));
			}

			$this->db->where('status >', '0');
			$this->db->from('reservations');
			$total_tables_reserved = $this->db->count_all_results();
		}

		return $total_tables_reserved;
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
}

/* End of file dashboard_model.php */
/* Location: ./application/models/dashboard_model.php */