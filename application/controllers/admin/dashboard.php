<?php 

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('currency'); // load the currency library
		$this->load->model('Dashboard_model');
	}

	public function admin() {
		$this->index();
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

		$filter = array();
		$filter['page'] = 1;
		$filter['limit'] = 10;
				
		//Showing Summaries
		$data['heading'] 				= 'Dashboard';
		$data['text_empty'] 			= 'There are no orders available.';
		$data['total_sales'] 			= $this->currency->format($this->Dashboard_model->getTotalSales());
		$data['total_sales_by_year'] 	= $this->currency->format($this->Dashboard_model->getTotalSalesByYear());
		$data['total_lost_sales'] 		= $this->currency->format($this->Dashboard_model->getTotalLostSales());
		$data['total_customers'] 		= $this->Dashboard_model->getTotalCustomers();
		$data['total_orders_received'] 	= $this->Dashboard_model->getTotalOrdersReceived();
		$data['total_orders_completed'] = $this->Dashboard_model->getTotalOrdersCompleted();
		$data['total_orders_delivered'] = $this->Dashboard_model->getTotalOrdersDelivered();
		$data['total_orders_picked'] 	= $this->Dashboard_model->getTotalOrdersPickedUp();
		$data['total_tables_reserved'] 	= $this->Dashboard_model->getTotalTablesReserved();
		$data['total_menus'] 			= $this->Dashboard_model->getTotalMenus();

		$this->load->model('Menus_model'); // load the menus model
		
		$data['menus'] = $this->Menus_model->getAdminMenus();
		
		$this->load->model('Orders_model');

		$results = $this->Orders_model->getList($filter);
		
		//load category data into array
		$data['orders'] = array();
		foreach ($results as $result) {					
			
			$current_date = mdate('%d-%m-%Y', time());
			$date_added = mdate('%d-%m-%Y', strtotime($result['date_added']));
			
			if ($current_date === $date_added) {
				$date_added = 'Today';
   			} else if($date_added === mdate('%d-%m-%Y', time() - (24 * 60 * 60))) {
				$date_added = 'Yesterday';
			} else {
				$date_added = $date_added;
			}
			
			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_status'		=> $result['status_name'],
				'staff_name'		=> $result['staff_name'],
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'date_added'		=> $date_added,
				'date_modified'		=> mdate('%d-%m-%Y', strtotime($result['date_modified'])),
				'edit' 				=> $this->config->site_url('admin/orders/edit?id=' . $result['order_id'])
			);
		}
				
		if ($this->input->post('select_menu')) {
			$menu_id = $this->input->post('select_menu');
			$menu_data = $this->Menus_model->getAdminMenu($menu_id);
			$data['menu_name'] = $menu_data['menu_name'];
		
			//retrieve database query based on food_id
			$data['ratings_results'] = $this->Dashboard_model->getTotalMenuReviews($menu_id);
		} else {
			$data['menu_name'] = '';
			$data['ratings_results'] = array();		
		}	
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/dashboard', $data);
	}
}