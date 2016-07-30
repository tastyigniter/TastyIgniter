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
class Dashboard_model extends TI_Model
{

	/**
	 * Dashboard_model constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Orders_model');
		$this->load->model('Reservations_model');
		$this->load->model('Customers_model');
		$this->load->model('Menus_model');
		$this->load->model('Tables_model');
		$this->load->model('Reviews_model');
	}

	/**
	 * Return the statistics data
	 *
	 * @param string $stat_range
	 *
	 * @return array
	 */
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

	/**
	 * Return the total number of menus in database
	 *
	 * @return mixed
	 */
	public function getTotalMenus() {
		return $this->Menus_model->count_all();
	}

	/**
	 * Return the total amount of order sales
	 *
	 * @param $range_query
	 *
	 * @return int
	 */
	public function getTotalSales($range_query) {
		$total_sales = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$this->Orders_model->select_sum('order_total', 'total_sales');
			$this->Orders_model->where('status_id >', '0');

			if ($row = $this->Orders_model->find($range_query)) {
				$total_sales = $row['total_sales'];
			}
		}

		return $total_sales;
	}

	/**
	 * Return the total amount of lost order sales
	 *
	 * @param $range_query
	 *
	 * @return int
	 */
	public function getTotalLostSales($range_query) {
		$total_lost_sales = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$this->Orders_model->select_sum('order_total', 'total_lost_sales');
			$this->Orders_model->group_start();
			$this->Orders_model->where('status_id <=', '0');
			$this->Orders_model->or_where('status_id', $this->config->item('canceled_order_status'));
			$this->Orders_model->group_end();

			if ($row = $this->Orders_model->find($range_query)) {
				$total_lost_sales = $row['total_lost_sales'];
			}
		}

		return $total_lost_sales;
	}

	/**
	 * Return the total amount of cash payment order sales
	 *
	 * @param string $range_query
	 *
	 * @return int
	 */
	public function getTotalCashPayments($range_query = '') {
		$cash_payments = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$this->Orders_model->select_sum('order_total', 'cash_payments');
			$this->Orders_model->where('status_id >', '0');
			$this->Orders_model->where('payment', 'cod');

			if ($row = $this->Orders_model->find($range_query)) {
				$cash_payments = $row['cash_payments'];
			}
		}

		return $cash_payments;
	}

	/**
	 * Return the total number of customers
	 *
	 * @param $range_query
	 *
	 * @return int
	 */
	public function getTotalCustomers($range_query) {
		$total_customers = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_customers = $this->Customers_model->count($range_query);
		}

		return $total_customers;
	}

	/**
	 * Return the total number of orders placed
	 *
	 * @param $range_query
	 *
	 * @return int
	 */
	public function getTotalOrders($range_query) {
		$total_orders = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_orders = $this->Orders_model->count($range_query);
		}

		return $total_orders;
	}

	/**
	 * Return the total number of completed orders
	 *
	 * @param string $range_query
	 *
	 * @return int
	 */
	public function getTotalOrdersCompleted($range_query = '') {
		$total_orders_completed = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$this->Orders_model->where_in('status_id', (array)$this->config->item('completed_order_status'));
			$total_orders_completed = $this->Orders_model->count($range_query);
		}

		return $total_orders_completed;
	}

	/**
	 * Return the total number of delivery orders
	 *
	 * @param string $range_query
	 *
	 * @return int
	 */
	public function getTotalDeliveryOrders($range_query = '') {
		$total_delivery_orders = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$this->Orders_model->where('order_type', '1');
			$total_delivery_orders = $this->Orders_model->count($range_query);
		}

		return $total_delivery_orders;
	}

	/**
	 * Return the total number of collection orders
	 *
	 * @param string $range_query
	 *
	 * @return int
	 */
	public function getTotalCollectionOrders($range_query = '') {
		$total_collection_orders = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$this->Orders_model->where('order_type', '2');
			$total_collection_orders = $this->Orders_model->count($range_query);
		}

		return $total_collection_orders;
	}

	/**
	 * Return the total number of tables
	 *
	 * @return mixed
	 */
	public function getTotalTables() {
		return $this->Tables_model->count_all();
	}

	/**
	 * Return the total number of table reservations
	 *
	 * @param string $range_query
	 *
	 * @return int
	 */
	public function getTotalTablesReserved($range_query = '') {
		$total_tables_reserved = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$this->Reservations_model->where('status >', '0');
			$total_tables_reserved = $this->Reservations_model->count($range_query);
		}

		return $total_tables_reserved;
	}

	/**
	 * Return the chart data by hour of the day
	 *
	 * @param bool $hour
	 *
	 * @return array
	 */
	public function getTodayChart($hour = FALSE) {
		$result = array();

		$this->Customers_model->where('DATE(date_added)', 'DATE(NOW())');
		$this->Customers_model->where('HOUR(date_added)', $hour);
		$result['customers'] = $this->Customers_model->order_by('date_added')->count();

		$this->Orders_model->where('status_id >', '0');
		$this->Orders_model->where('DATE(date_added)', 'DATE(NOW())', FALSE);
		$this->Orders_model->where('HOUR(order_time)', $hour);
		$this->Orders_model->group_by('HOUR(order_time)');
		$result['orders'] = $this->Orders_model->order_by('date_added')->count();

		$this->Reservations_model->where('status >', '0');
		$this->Reservations_model->where('DATE(reserve_date)', 'DATE(NOW())', FALSE);
		$this->Reservations_model->where('HOUR(reserve_time)', $hour);
		$this->Reservations_model->group_by('HOUR(reserve_time)');
		$result['reservations'] = $this->Reservations_model->order_by('reserve_date')->count();

		$this->Reviews_model->where('DATE(date_added)', 'DATE(NOW())', FALSE);
		$this->Reviews_model->where('HOUR(date_added)', $hour);
		$result['reviews'] = $this->Reviews_model->order_by('date_added')->count();

		return $result;
	}

	/**
	 * Return the chart data by date
	 *
	 * @param bool $date
	 *
	 * @return array
	 */
	public function getDateChart($date = FALSE) {
		$result = array();

		$this->Customers_model->where('DATE(date_added)', $date);
		$this->Customers_model->group_by('DAY(date_added)');
		$result['customers'] = $this->Customers_model->count();

		$this->Orders_model->where('status_id >', '0');
		$this->Orders_model->where('DATE(date_added)', $date);
		$this->Orders_model->group_by('DAY(date_added)');
		$result['orders'] = $this->Orders_model->count();

		$this->Reservations_model->where('status >', '0');
		$this->Reservations_model->where('DATE(reserve_date)', $date);
		$this->Reservations_model->group_by('DAY(reserve_date)');
		$result['reservations'] = $this->Reservations_model->count();

		$this->Reviews_model->where('DATE(date_added)', $date);
		$this->Reviews_model->group_by('DAY(date_added)');
		$result['reviews'] = $this->Reviews_model->count();

		return $result;
	}

	/**
	 * Return the chart data by year and month
	 *
	 * @param bool $year
	 * @param bool $month
	 *
	 * @return array
	 */
	public function getYearChart($year = FALSE, $month = FALSE) {
		$result = array();

		$this->Customers_model->where('YEAR(date_added)', (int)$year);
		$this->Customers_model->where('MONTH(date_added)', (int)$month);
		$this->Customers_model->group_by('MONTH(date_added)');
		$result['customers'] = $this->Customers_model->count();

		$this->Orders_model->where('status_id >', '0');
		$this->Orders_model->where('YEAR(date_added)', (int)$year);
		$this->Orders_model->where('MONTH(date_added)', (int)$month);
		$this->Orders_model->group_by('MONTH(date_added)');
		$result['orders'] = $this->Orders_model->count();

		$this->Reservations_model->where('status >', '0');
		$this->Reservations_model->where('YEAR(reserve_date)', (int)$year);
		$this->Reservations_model->where('MONTH(reserve_date)', (int)$month);
		$this->Reservations_model->group_by('MONTH(reserve_date)');
		$result['reservations'] = $this->Reservations_model->count();

		$this->Reviews_model->where('YEAR(date_added)', (int)$year);
		$this->Reviews_model->where('MONTH(date_added)', (int)$month);
		$this->Reviews_model->group_by('MONTH(date_added)');
		$result['reviews'] = $this->Reviews_model->count();

		return $result;
	}

	/**
	 * Return review chart menu and rating
	 *
	 * @param $rating_id
	 * @param $menu_id
	 *
	 * @return mixed
	 */
	public function getReviewChart($rating_id, $menu_id) {
		$this->Reviews_model->where('menu_id', $menu_id);
		$this->Reviews_model->where('rating_id', $rating_id);
		$total_ratings = $this->Reviews_model->count();

		return $total_ratings;
	}

	/**
	 * Return the total orders made by all customers
	 *
	 * @param array $filter limit the result
	 *
	 * @return array
	 */
	public function getTopCustomers($filter = array()) {
		if (isset($filter['limit']) AND isset($filter['page'])) {
			$this->Customers_model->limit($filter['limit'], $filter['page']);
		}

		$this->Customers_model->select('customers.customer_id, customers.first_name, customers.last_name, COUNT(order_id) AS total_orders');
		$this->Customers_model->select_sum('order_total', 'total_sale');
		$this->Customers_model->group_by('customer_id');
		$this->Customers_model->join('orders', 'orders.customer_id = customers.customer_id', 'left');

		return $this->Customers_model->order_by('total_orders', 'DESC')->find_all();
	}

	/**
	 * Fetch tastyigniter news feed data
	 *
	 * @param int $number limit the number of results show
	 * @param int $expiry cache expiry
	 *
	 * @return mixed
	 */
	public function getNewsFeed($number = 5, $expiry = 3) {
		$this->load->library('feed_parser');

		$this->feed_parser->set_feed_url('http://feeds.feedburner.com/Tastyigniter');
		$this->feed_parser->set_cache_life($expiry);

		return $this->feed_parser->getFeed($number);
	}
}

/* End of file Dashboard_model.php */
/* Location: ./system/tastyigniter/models/Dashboard_model.php */