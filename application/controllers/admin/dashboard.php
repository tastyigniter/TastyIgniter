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
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
				
		$this->template->setTitle('Dashboard');
		$this->template->setHeading('Dashboard');

		//Showing Summaries
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

		$data['current_month'] 			= mdate('%Y-%m', time());
		
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

		$filter = array();
		$filter['page'] = '';
		$filter['limit'] = 10;
		$filter['sort_by'] = 'orders.date_added';
		$filter['order_by'] = 'DESC';
		$data['order_by_active'] = 'DESC';
		
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
				'edit' 				=> site_url('admin/orders/edit?id=' . $result['order_id'])
			);
		}
				
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'dashboard.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'dashboard', $data);
		} else {
			$this->template->render('themes/admin/default/', 'dashboard', $data);
		}
	}
	
	public function chart() {
		$json = array();
		
		$results = array();
		$json['totals'] = array();
		$json['xaxis'] = array();
		
		$range = 'month';
		if ($this->input->get('range')) {
			$range = $this->input->get('range');
		}
		
		$type = 'orders';
		if ($this->input->get('type')) {
			$type = $this->input->get('type');
		}
		
		if ($type === 'customers') {
			$json['totals']['label'] = 'Total Customers';
			$json['totals']['color'] = '#63add0';
		} else if ($type === 'orders') {
			$json['totals']['label'] = 'Total Orders';
			$json['totals']['color'] = '#ffb800';
		} else if ($type === 'reservations') {
			$json['totals']['label'] = 'Total Reservations';
			$json['totals']['color'] = '#ff6840';
		} else if ($type === 'reviews') {
			$json['totals']['label'] = 'Total Reviews';
			$json['totals']['color'] = '#00ae68';
		}
				
		if ($range) {
			switch ($range) {
			case 'today':
				for ($i = 0; $i < 24; $i++) {
					$results[] = $this->Dashboard_model->getTodayChart($type, $i);
					$json['xaxis'][] = array($i, mdate('%Hhr', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'yesterday':
				for ($i = 0; $i < 24; $i++) {
					$results[] = $this->Dashboard_model->getYesterdayChart($type, $i);
					$json['xaxis'][] = array($i, mdate('%Hhr', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days'); 
				
				for ($i = 0; $i < 7; $i++) {
					$date = mdate('%Y-%m-%d', $date_start + ($i * 86400));
					$results[$i] = $this->Dashboard_model->getThisWeekChart($type, $date);
					$json['xaxis'][] = array($i, mdate('%d %D', strtotime($date)));
				}
				break;
			case 'last_week':
				$date_start = strtotime('last week'); 
				
				for ($i = 0; $i < 7; $i++) {
					$date = mdate('%Y-%m-%d', $date_start - (-$i * 86400));
					$results[$i] = $this->Dashboard_model->getThisWeekChart($type, $date);
					$json['xaxis'][] = array($i, mdate('%d %D', strtotime($date)));
				}
				break;
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;
					$results[$i] = $this->Dashboard_model->getMonthChart($type, $date);					
					$json['xaxis'][] = array($i, mdate('%d %D', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$results[$i] = $this->Dashboard_model->getYearChart($type, date('Y'), $i);					
					$json['xaxis'][] = array($i, mdate('%M %Y', mktime(0, 0, 0, $i, 1, date('Y'))));
				}			
				break;	
			default:
				$year_month = $range;
				for ($i = 1; $i <= date('t', strtotime($year_month)); $i++) {
					$date = $year_month . '-' . $i;
					$results[$i] = $this->Dashboard_model->getMonthChart($type, $date);					
					$json['xaxis'][] = array($i, mdate('%d %D', strtotime($date)));
				}
				break;	
			} 
		}
		
		if (!empty($results)) {
			foreach ($results as $key => $result) {
				if ($result['total'] > 0) {
					$json['totals']['data'][] = array($key, (int)$result['total']);
				} else {
					$json['totals']['data'][] = array($key, 0);
				}
			}
		}
		
		$this->output->set_output(json_encode($json));
	}

	public function admin() {
		$this->index();
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */