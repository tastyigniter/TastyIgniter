<?php 

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('currency'); // load the currency library
		$this->load->model('Dashboard_model');
		$this->load->model('Locations_model'); // load the menus model
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/dashboard.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		$filter['page'] = 1;
		$filter['limit'] = 10;
				
		//Showing Summaries
		$data['heading'] 				= 'Dashboard';
		$data['total_sales'] 			= $this->currency->format($this->Dashboard_model->getTotalSales());
		$data['total_sales_by_year'] 	= $this->currency->format($this->Dashboard_model->getTotalSalesByYear());
		$data['total_lost_sales'] 		= $this->currency->format($this->Dashboard_model->getTotalLostSales());
		$data['total_customers'] 		= $this->Dashboard_model->getTotalCustomers();
		$data['total_orders'] 			= $this->Dashboard_model->getTotalOrders();
		$data['total_orders_completed'] = $this->Dashboard_model->getTotalOrdersCompleted();
		$data['total_delivery_orders'] 	= $this->Dashboard_model->getTotalDeliveryOrders();
		$data['total_collection_orders'] = $this->Dashboard_model->getTotalCollectionOrders();
		$data['total_tables_reserved'] 	= $this->Dashboard_model->getTotalTablesReserved();
		$data['total_menus'] 			= $this->Dashboard_model->getTotalMenus();

		$data['months'] = array();
		$pastMonth = date('Y-m-d', strtotime(date('Y-m-01') .' -3 months'));
		$futureMonth = date('Y-m-d', strtotime(date('Y-m-01') .' +3 months'));
		for ($i = $pastMonth; $i <= $futureMonth; $i = date('Y-m-d', strtotime($i .' +1 months'))) {
			$data['months'][mdate('%Y-%m', strtotime($i))] = mdate('%F', strtotime($i));
		}
		
		$data['default_location_id'] = $this->config->item('default_location_id');

		$this->load->model('Locations_model');	    
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}
		
		$this->load->model('Orders_model');
		$results = $this->Orders_model->getList($filter);
		$data['orders'] = array();
		foreach ($results as $result) {					
			$current_date = mdate('%d-%m-%Y', time());
			$date_added = mdate('%d-%m-%Y', strtotime($result['date_added']));
			
			if ($current_date === $date_added) {
				$date_added = 'Today';
			} else {
				$date_added = mdate('%d %M %y', strtotime($date_added));
			}
			
			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_status'		=> $result['status_name'],
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_type' 		=> ($result['order_type'] === '1') ? 'Delivery' : 'Collection',
				'date_added'		=> $date_added,
				'edit' 				=> $this->config->site_url('admin/orders/edit?id=' . $result['order_id'])
			);
		}
				
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/dashboard', $data);
	}
	
	public function chart() {
		$json = array();
		
		$results = array();
		$json['customers'] = array();
		$json['orders'] = array();
		$json['reservations'] = array();
		$json['xaxis'] = array();
		
		$json['customers']['label'] = 'Total Customers';
		$json['orders']['label'] = 'Total Orders';
		$json['reservations']['label'] = 'Total Reservations';
		
		$range = 'month';
		
		if ($this->input->get('range')) {
			$range = $this->input->get('range');
		}
		
		if ($range) {
			switch ($range) {
			case 'today':
				for ($i = 0; $i < 24; $i++) {
					$results[] = $this->Dashboard_model->getTodayChart($i);
					$json['xaxis'][] = array($i, mdate('%Hhr', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'yesterday':
				for ($i = 0; $i < 24; $i++) {
					$results[] = $this->Dashboard_model->getYesterdayChart($i);
					$json['xaxis'][] = array($i, mdate('%Hhr', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days'); 
				
				for ($i = 0; $i < 7; $i++) {
					$date = mdate('%Y-%m-%d', $date_start + ($i * 86400));
					$results[$i] = $this->Dashboard_model->getThisWeekChart($date);
					$json['xaxis'][] = array($i, mdate('%d %D', strtotime($date)));
				}
				break;
			case 'last_week':
				$date_start = strtotime('last week'); 
				
				for ($i = 0; $i < 7; $i++) {
					$date = mdate('%Y-%m-%d', $date_start - (-$i * 86400));
					$results[$i] = $this->Dashboard_model->getThisWeekChart($date);
					$json['xaxis'][] = array($i, mdate('%d %D', strtotime($date)));
				}
				break;
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;
					$results[$i] = $this->Dashboard_model->getMonthChart($date);					
					$json['xaxis'][] = array($i, mdate('%d %M', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$results[$i] = $this->Dashboard_model->getYearChart(date('Y'), $i);					
					$json['xaxis'][] = array($i, mdate('%M %y', mktime(0, 0, 0, $i, 1, date('Y'))));
				}			
				break;	
			default:
				$year_month = $range;
				for ($i = 1; $i <= date('t', strtotime($year_month)); $i++) {
					$date = $year_month . '-' . $i;
					$results[$i] = $this->Dashboard_model->getMonthChart($date);					
					$json['xaxis'][] = array($i, mdate('%d %M', strtotime($date)));
				}
				break;	
			} 
		}
		
		if (!empty($results)) {
			foreach ($results as $key => $result) {
				if ($result['customers'] > 0) {
					$json['customers']['data'][] = array($key, (int)$result['customers']);
				} else {
					$json['customers']['data'][] = array($key, 0);
				}

				if ($result['orders'] > 0) {
					$json['orders']['data'][]  = array($key, (int)$result['orders']);
				} else {
					$json['orders']['data'][]  = array($key, 0);
				}
			
				if ($result['reservations'] > 0) {
					$json['reservations']['data'][]  = array($key, (int)$result['reservations']);
				} else {
					$json['reservations']['data'][]  = array($key, 0);
				}
			}
		}
		
		$this->output->set_output(json_encode($json));
	}

	public function admin() {
		$this->index();
	}
}