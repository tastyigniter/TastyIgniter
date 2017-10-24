<?php namespace Admin\Models;

use Model;

/**
 * Dashboard Model Class
 *
 * @package Admin
 */
class Dashboard_model extends Model
{

	/**
	 * Dashboard_model constructor.
	 */
	public function __construct()
	{
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
	public function getStatistics($stat_range = '')
	{
		$results = $range_query = [];

		if ($stat_range === '') return $results;

		if ($stat_range === 'today') {
			$range_query = ['DATE(date_added) = ?', date('Y-m-d')];
		} else if ($stat_range === 'week') {
			$range_query = ['WEEK(date_added) = ?', date('W')];
		} else if ($stat_range === 'month') {
			$range_query = ['MONTH(date_added) = ?', date('m')];
		} else if ($stat_range === 'year') {
			$range_query = ['YEAR(date_added) = ?', date('Y')];
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
	public function getTotalMenus()
	{
		return $this->Menus_model->count();
	}

	/**
	 * Return the total amount of order sales
	 *
	 * @param $range_query
	 *
	 * @return int
	 */
	public function getTotalSales($range_query)
	{
		$total_sales = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$row = $this->Orders_model->where('status_id', '>', '0')->selectRaw("SUM(order_total) as total_sales")
										->whereRaw($range_query[0], $range_query[1])->first();

			if (!empty($row)) {
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
	public function getTotalLostSales($range_query)
	{
		$total_lost_sales = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$row = $this->Orders_model->query()->selectRaw("SUM(order_total) as total_lost_sales")->where(function ($query) {
				$query->where('status_id', '<=', '0');
				$query->orWhere('status_id', $this->config->item('canceled_order_status'));
			})->whereRaw($range_query[0], $range_query[1])->first();

			if (!empty($row)) {
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
	public function getTotalCashPayments($range_query = '')
	{
		$cash_payments = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$row = $this->Orders_model->where('status_id', '>', '0')
				->selectRaw("SUM(order_total) as cash_payments")->where('payment', 'cod')->first();

			if (!empty($row)) {
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
	public function getTotalCustomers($range_query)
	{
		$total_customers = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_customers = $this->Customers_model->whereRaw($range_query[0], $range_query[1])->count();
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
	public function getTotalOrders($range_query)
	{
		$total_orders = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_orders = $this->Orders_model->whereRaw($range_query[0], $range_query[1])->count();
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
	public function getTotalOrdersCompleted($range_query = '')
	{
		$total_orders_completed = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_orders_completed = $this->Orders_model->whereIn('status_id', (array)$this->config->item('completed_order_status'))
														 ->whereRaw($range_query[0], $range_query[1])->count();
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
	public function getTotalDeliveryOrders($range_query = '')
	{
		$total_delivery_orders = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_delivery_orders = $this->Orders_model->where('order_type', '1')->whereRaw($range_query[0], $range_query[1])->count();
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
	public function getTotalCollectionOrders($range_query = '')
	{
		$total_collection_orders = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_collection_orders = $this->Orders_model->where('order_type', '2')->whereRaw($range_query[0], $range_query[1])->count();
		}

		return $total_collection_orders;
	}

	/**
	 * Return the total number of tables
	 *
	 * @return mixed
	 */
	public function getTotalTables()
	{
		return $this->Tables_model->count();
	}

	/**
	 * Return the total number of table reservations
	 *
	 * @param string $range_query
	 *
	 * @return int
	 */
	public function getTotalTablesReserved($range_query = '')
	{
		$total_tables_reserved = 0;

		if (is_array($range_query) AND !empty($range_query)) {
			$total_tables_reserved = $this->Reservations_model->where('status', '>', '0')->whereRaw($range_query[0], $range_query[1])->count();
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
	public function getTodayChart($hour = FALSE)
	{
		$result = [];

		$result['customers'] = $this->Customers_model->whereDate('date_added', 'DATE(NOW())')
													 ->whereRaw('HOUR(date_added)', $hour)->orderBy('date_added')->count();

		$result['orders'] = $this->Orders_model->where('status_id', '>', '0')
											   ->whereDate('date_added', 'DATE(NOW())', FALSE)->whereRaw('HOUR(order_time)', $hour)
											   ->orderBy('date_added')->count();

		$result['reservations'] = $this->Reservations_model->where('status', '>', '0')
														   ->whereDate('reserve_date', 'DATE(NOW())', FALSE)->whereRaw('HOUR(reserve_time)', $hour)
														   ->orderBy('reserve_date')->count();

		$result['reviews'] = $this->Reviews_model->whereDate('date_added', 'DATE(NOW())', FALSE)
												 ->where('HOUR(date_added)', $hour)
												 ->orderBy('date_added')->count();

		return $result;
	}

	/**
	 * Return the chart data by date
	 *
	 * @param bool $date
	 *
	 * @return array
	 */
	public function getDateChart($date = FALSE)
	{
		$result = [];

		$DB = $this->queryBuilder();

		$result['customers'] = $this->Customers_model->whereDate('date_added', $date)
													 ->selectRaw("date_added")->groupBy($DB->raw('DAY(date_added)'))
													 ->count();

		$result['orders'] = $this->Orders_model->where('status_id', '>', '0')
											   ->whereDate('date_added', $date)
											   ->selectRaw("date_added")->groupBy($DB->raw('DAY(date_added)'))
											   ->count();

		$result['reservations'] = $this->Reservations_model->where('status', '>', '0')
														   ->whereDate('reserve_date', $date)
														   ->selectRaw("date_added")->groupBy($DB->raw('DAY(reserve_date)'))
														   ->count();

		$result['reviews'] = $this->Reviews_model->whereDate('date_added', $date)
												 ->selectRaw("date_added")->groupBy($DB->raw('DAY(date_added)'))
												 ->count();

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
	public function getYearChart($year = FALSE, $month = FALSE)
	{
		$result = [];

		$DB = $this->queryBuilder();
		$result['customers'] = $this->Customers_model->whereYear('date_added', (int)$year)
													 ->whereMonth('date_added', (int)$month)
													 ->groupBy($DB->raw("MONTH(date_added)"))
													 ->count();

		$result['orders'] = $this->Orders_model->where('status_id', '>', '0')
											   ->whereYear('date_added', (int)$year)
											   ->whereMonth('date_added', (int)$month)
											   ->groupBy($DB->raw("MONTH(date_added)"))
											   ->count();

		$result['reservations'] = $this->Reservations_model->where('status', '>', '0')
														   ->whereYear('reserve_date', (int)$year)
														   ->whereMonth('reserve_date', (int)$month)
														   ->groupBy($DB->raw("MONTH(reserve_date)"))
														   ->count();

		$result['reviews'] = $this->Reviews_model->whereYear('date_added', (int)$year)
												 ->whereMonth('date_added', (int)$month)
												 ->groupBy($DB->raw("MONTH(date_added)"))
												 ->count();

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
	public function getReviewChart($rating_id, $menu_id)
	{
		$total_ratings = $this->Reviews_model->where('menu_id', $menu_id)
											 ->where('rating_id', $rating_id)->count();

		return $total_ratings;
	}

	/**
	 * Return the total orders made by all customers
	 *
	 * @param array $filter limit the result
	 *
	 * @return array
	 */
	public function getTopCustomers($filter = [])
	{
		if (isset($filter['limit']) AND isset($filter['page'])) {
			$this->Customers_model->limit($filter['limit'], $filter['page']);
		}

		$customersTable = $this->getTablePrefix('customers');

		return $this->Customers_model->groupBy('customer_id')->orderBy('total_orders', 'DESC')
									 ->selectRaw("SUM(order_total) as total_sale")->selectRaw("{$customersTable}.customer_id, {$customersTable}.first_name, {$customersTable}.last_name, " .
				"COUNT(order_id) AS total_orders")
									 ->join('orders', 'orders.customer_id', '=', 'customers.customer_id', 'left')->get();
	}

	/**
	 * Fetch tastyigniter news feed data
	 *
	 * @param int $number limit the number of results show
	 * @param int $expiry cache expiry
	 *
	 * @return mixed
	 */
	public function getNewsFeed($number = 5, $expiry = 3)
	{
		$this->load->library('feed_parser');

		$this->feed_parser->set_feed_url('http://feeds.feedburner.com/Tastyigniter');
		$this->feed_parser->set_cache_life($expiry);

		return $this->feed_parser->getFeed($number);
	}
}