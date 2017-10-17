<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Orders extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

        if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
            redirect('account/login');
        }

        $this->load->model('Orders_model');														// load orders model
        $this->load->model('Addresses_model');														// load addresses model

		$this->load->library('currency'); 														// load the currency library

        $this->lang->load('account/orders');
	}

	public function index() {
		$url = '?';
		$filter = array();
		$filter['customer_id'] = (int) $this->customer->getId();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

        $filter['sort_by'] = $data['sort_by'] = 'date_added';
        $filter['order_by'] = $data['order_by'] = 'DESC';

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/orders');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['back_url'] 				= site_url('account/account');

        $this->load->library('location');
		$this->location->initialize();

		if ($this->location->local()) {
            $data['new_order_url'] = site_url('local?location_id='.$this->location->getId());
        } else {
            $data['new_order_url'] = site_url('local/all');
        }

		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['orders'] = array();
		$results = $this->Orders_model->getList($filter);			// retrieve customer orders based on customer id from getMainOrders method in Orders model
		foreach ($results as $result) {

			// if order type is equal to 1, order type is delivery else collection
            $order_type = ($result['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection');

			$data['orders'][] = array(															// create array of customer orders to pass to view
				'order_id' 				=> $result['order_id'],
				'location_name' 		=> $result['location_name'],
				'date_added' 			=> day_elapsed($result['date_added']),
				'order_date' 			=> day_elapsed($result['order_date']),
				'order_time'			=> mdate($time_format, strtotime($result['order_time'])),
				'total_items'			=> $result['total_items'],
				'order_total' 			=> $this->currency->format($result['order_total']),		// add currency symbol and format order total to two decimal places
				'order_type' 			=> ucwords(strtolower($order_type)),					// convert string to lower case and capitalize first letter
				'status_name' 			=> $result['status_name'],
				'view' 					=> site_url('account/orders/view/' . $result['order_id']),
				'reorder' 				=> site_url('account/orders/reorder/'. $result['order_id'] .'/'. $result['location_id']),
				'leave_review' 			=> site_url('account/reviews/add/order/'. $result['order_id'] .'/'. $result['location_id'])
			);
		}

		$prefs['base_url'] 			= site_url('account/orders'.$url);
		$prefs['total_rows'] 		= $this->Orders_model->getCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('account/orders', $data);
	}

	public function view() {
		if ($result = $this->Orders_model->getOrder($this->uri->rsegment(3), $this->customer->getId())) {															// check if customer_id is set in uri string
			$order_id = (int)$this->uri->rsegment(3);
		} else {
  			redirect('account/orders');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/orders');
		$this->template->setBreadcrumb($this->lang->line('text_view_heading'), 'account/orders/view');

		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));

		$data['reorder_url'] 			= site_url('account/orders/reorder/'. $order_id .'/'. $result['location_id']);
		$data['back_url'] 				= site_url('account/orders');

		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['order_id'] 		        = $result['order_id'];
        $data['date_added'] 	        = mdate($date_format, strtotime($result['date_added']));
		$data['order_time'] 	        = mdate($time_format, strtotime($result['order_time']));
		$data['order_date'] 	        = mdate($date_format, strtotime($result['order_date']));
		$data['order_type'] 		    = $result['order_type'];

        $this->load->library('country');
        $this->load->model('Locations_model');														// load orders model
        $location_address = $this->Locations_model->getAddress($result['location_id']);

        $data['location_name'] = ($location_address) ? $location_address['location_name'] : '';
        $data['location_address'] = ($location_address) ? $this->country->addressFormat($location_address) : '';

        $delivery_address = $this->Addresses_model->getAddress($result['customer_id'], $result['address_id']);
        $data['delivery_address'] = $this->country->addressFormat($delivery_address);

        $data['menus'] = array();
        $order_menus = $this->Orders_model->getOrderMenus($result['order_id']);
		$order_menu_options = $this->Orders_model->getOrderMenuOptions($result['order_id']);
		foreach ($order_menus as $order_menu) {
            $option_data = array();

			if (!empty($order_menu_options)) {
				foreach ($order_menu_options as $menu_option) {
					if ($order_menu['order_menu_id'] === $menu_option['order_menu_id']) {
						$option_data[] = $menu_option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($menu_option['order_option_price']);
					}
				}
			}

            $data['menus'][] = array(
                'id' 			=> $order_menu['menu_id'],
                'name' 			=> $order_menu['name'],
                'qty' 			=> $order_menu['quantity'],
                'price' 		=> $this->currency->format($order_menu['price']),
                'subtotal' 		=> $this->currency->format($order_menu['subtotal']),
				'comment' 		=> $order_menu['comment'],
				'options'		=> implode(', ', $option_data)
            );
        }

        $data['totals'] = array();
        $order_totals = $this->Orders_model->getOrderTotals($result['order_id']);
		foreach ($order_totals as $order_total) {
			if ($data['order_type'] !== '1' AND $order_total['code'] === 'delivery') continue;

			$data['totals'][] = array(
				'code'     => $order_total['code'],
				'title'    => htmlspecialchars_decode($order_total['title']),
				'value'    => $this->currency->format($order_total['value']),
				'priority' => $order_total['priority'],
			);
		}

        $data['order_total'] 		= $this->currency->format($result['order_total']);
        $data['total_items']		= $result['total_items'];

		if ($payment = $this->extension->getPayment($result['payment'])) {
			$data['payment'] = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title']: $payment['title'];
		} else {
			$data['payment'] = $this->lang->line('text_no_payment');
		}

		$this->template->render('account/orders_view', $data);
	}

	public function reorder() {
		$this->load->library('cart'); 															// load the cart library
		if ($order_menus = $this->Orders_model->getOrderMenus($this->uri->rsegment(3))) {
			foreach ($order_menus as $menu) {
                $this->cart->insert(array(
					'id' 			=> $menu['menu_id'],
					'name' 			=> $menu['name'],
					'qty' 			=> $menu['quantity'],
					'price' 		=> $menu['price'],
					'comment' 		=> $menu['comment'],
					'options'		=> (!empty($menu['option_values'])) ? unserialize($menu['option_values']) : array()
				));
			}

			$this->alert->set('alert', sprintf($this->lang->line('alert_reorder_success'), $this->uri->rsegment(3)));
			redirect('local?location_id='.$this->uri->rsegment(4));
		} else {
  			redirect('account/orders');
		}
	}
}

/* End of file orders.php */
/* Location: ./main/controllers/orders.php */