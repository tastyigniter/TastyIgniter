<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dashboard Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Dashboard_model.php
 * @link           http://docs.tastyigniter.com
 */
class Dashboard_model extends TI_Model {

	public function getStatistics($stat_range = '') {
		$results = $range_query = array();

		if ($stat_range === '') return $results;

		if ($stat_range === 'today') {
			$range_query = array('DATE(date_added)' => date('Y-m-d'));
		} else if ($stat_range === 'week') {
			$range_query = array('WEEK(date_added)' => date('W'));
		} else if ($stat_range === 'month') {
			$range_query = array('MONTH(date_added)' => date('m'));
		} else if ($stat_range === 'year') {
			$range_query = array('YEAR(date_added)' => date('Y'));
		}

		$results['sales'] = $this->getTotalSales($range_query);
		$results['lost_sales'] = $this->getTotalLostSales($range_query);
		$results['customers'] = $this->getTotalCustomers($range_query);
		$results['orders'] = $this->getTotalOrders($range_query);
		$results['orders_completed'] = $this->getTotalOrdersCompleted($range_query);
		$results['delivery_orders'] = $this->getTotalDeliveryOrders($range_query);
		$results['collection_orders'] = $this->getTotalCollectionOrders($range_query);
		$results['tables_reserved'] = $this->getTotalTablesReserved($range_query);
		$results['cash_payments'] = $this->getTotalCashPayments($range_query);

		return $results;
	}

	public function getTotalMenus() {
		return $this->db->count_all('menus');
	}

	public function getTotalSales($range_query) {
		$total_sales = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->select_sum('order_total', 'total_sales');
			$this->db->where('status_id >', '0');
			$this->db->where($range_query);
			$query = $this->db->get('orders');

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$total_sales = $row['total_sales'];
			}
		}

		return $total_sales;
	}

	public function getTotalLostSales($range_query) {
		$total_lost_sales = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->select_sum('order_total', 'total_lost_sales');
			$this->db->where($range_query);

			$this->db->group_start();
			$this->db->where('status_id <=', '0');
			$this->db->or_where('status_id', $this->config->item('canceled_order_status'));
			$this->db->group_end();

			$query = $this->db->get('orders');

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$total_lost_sales = $row['total_lost_sales'];
			}
		}

		return $total_lost_sales;
	}

	public function getTotalCashPayments($range_query = '') {
		$cash_payments = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->select_sum('order_total', 'cash_payments');
			$this->db->where('status_id >', '0');
			$this->db->where('payment', 'cod');
			$this->db->where($range_query);
			$query = $this->db->get('orders');

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$cash_payments = $row['cash_payments'];
			}
		}

		return $cash_payments;
	}

	public function getTotalCustomers($range_query) {
		$total_customers = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->from('customers');
			$total_customers = $this->db->count_all_results();
		}

		return $total_customers;
	}

	public function getTotalOrders($range_query) {
		$total_orders = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->from('orders');
			$total_orders = $this->db->count_all_results();
		}

		return $total_orders;
	}

	public function getTotalOrdersCompleted($range_query = '') {
		$total_orders_completed = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->where_in('status_id', (array) $this->config->item('completed_order_status'));
			$this->db->from('orders');
			$total_orders_completed = $this->db->count_all_results();
		}

		return $total_orders_completed;
	}

	public function getTotalDeliveryOrders($range_query = '') {
		$total_delivery_orders = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->where('order_type', '1');
			$this->db->from('orders');

			$total_delivery_orders = $this->db->count_all_results();
		}

		return $total_delivery_orders;
	}

	public function getTotalCollectionOrders($range_query = '') {
		$total_collection_orders = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->where('order_type', '2');
			$this->db->from('orders');

			$total_collection_orders = $this->db->count_all_results();
		}

		return $total_collection_orders;
	}

	public function getTotalTables() {
		return $this->db->count_all_results('tables');
	}

	public function getTotalTablesReserved($range_query = '') {
		$total_tables_reserved = 0;

		if (is_array($range_query) AND ! empty($range_query)) {
			$this->db->where($range_query);
			$this->db->where('status >', '0');
			$this->db->from('reservations');
			$total_tables_reserved = $this->db->count_all_results();
		}

		return $total_tables_reserved;
	}

	public function getTodayChart($hour = FALSE) {
		$result = array();

		$this->db->where('DATE(date_added)', 'DATE(NOW())');
		$this->db->where('HOUR(date_added)', $hour);
		$this->db->order_by('date_added', 'ASC');
		if ($this->db->from('customers')) {
			$result['customers'] = $this->db->count_all_results();
		}

		$this->db->where('status_id >', '0');
		$this->db->where('DATE(date_added)', 'DATE(NOW())', FALSE);
		$this->db->where('HOUR(order_time)', $hour);
		$this->db->group_by('HOUR(order_time)');
		$this->db->order_by('date_added', 'ASC');
		if ($this->db->from('orders')) {
			$result['orders'] = $this->db->count_all_results();
		}

		$this->db->where('status >', '0');
		$this->db->where('DATE(reserve_date)', 'DATE(NOW())', FALSE);
		$this->db->where('HOUR(reserve_time)', $hour);
		$this->db->group_by('HOUR(reserve_time)');
		$this->db->order_by('reserve_date', 'ASC');
		if ($this->db->from('reservations')) {
			$result['reservations'] = $this->db->count_all_results();
		}

		$this->db->where('DATE(date_added)', 'DATE(NOW())', FALSE);
		$this->db->where('HOUR(date_added)', $hour);
		$this->db->order_by('date_added', 'ASC');
		if ($this->db->from('reviews')) {
			$result['reviews'] = $this->db->count_all_results();
		}

		return $result;
	}

	public function getDateChart($date = FALSE) {
		$result = array();

		$this->db->where('DATE(date_added)', $date);
		$this->db->group_by('DAY(date_added)');
		if ($this->db->from('customers')) {
			$result['customers'] = $this->db->count_all_results();
		}

		$this->db->where('status_id >', '0');
		$this->db->where('DATE(date_added)', $date);
		$this->db->group_by('DAY(date_added)');
		if ($this->db->from('orders')) {
			$result['orders'] = $this->db->count_all_results();
		}

		$this->db->where('status >', '0');
		$this->db->where('DATE(reserve_date)', $date);
		$this->db->group_by('DAY(reserve_date)');
		if ($this->db->from('reservations')) {
			$result['reservations'] = $this->db->count_all_results();
		}

		$this->db->where('DATE(date_added)', $date);
		$this->db->group_by('DAY(date_added)');
		if ($this->db->from('reviews')) {
			$result['reviews'] = $this->db->count_all_results();
		}

		return $result;
	}

	public function getYearChart($year = FALSE, $month = FALSE) {
		$result = array();

		$this->db->where('YEAR(date_added)', (int) $year);
		$this->db->where('MONTH(date_added)', (int) $month);
		$this->db->group_by('MONTH(date_added)');
		if ($this->db->from('customers')) {
			$result['customers'] = $this->db->count_all_results();
		}

		$this->db->where('status_id >', '0');
		$this->db->where('YEAR(date_added)', (int) $year);
		$this->db->where('MONTH(date_added)', (int) $month);
		$this->db->group_by('MONTH(date_added)');
		if ($this->db->from('orders')) {
			$result['orders'] = $this->db->count_all_results();
		}

		$this->db->where('status >', '0');
		$this->db->where('YEAR(reserve_date)', (int) $year);
		$this->db->where('MONTH(reserve_date)', (int) $month);
		$this->db->group_by('MONTH(reserve_date)');
		if ($this->db->from('reservations')) {
			$result['reservations'] = $this->db->count_all_results();
		}

		$this->db->where('YEAR(date_added)', (int) $year);
		$this->db->where('MONTH(date_added)', (int) $month);
		$this->db->group_by('MONTH(date_added)');
		if ($this->db->from('reviews')) {
			$result['reviews'] = $this->db->count_all_results();
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

	public function getTopCustomers($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('customers.customer_id, customers.first_name, customers.last_name, COUNT(order_id) AS total_orders');
			$this->db->select_sum('order_total', 'total_sale');
			$this->db->from('customers');
			$this->db->join('orders', 'orders.customer_id = customers.customer_id', 'left');
			$this->db->group_by('customer_id');
			$this->db->order_by('total_orders', 'DESC');

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getNewsFeed($number = 5, $expiry = 3) {
		$this->load->library('feed_parser');

		$this->feed_parser->set_feed_url('http://feeds.feedburner.com/Tastyigniter');
		$this->feed_parser->set_cache_life($expiry);

		return $this->feed_parser->getFeed($number);
	}
}

/* End of file dashboard_model.php */
/* Location: ./system/tastyigniter/models/dashboard_model.php */