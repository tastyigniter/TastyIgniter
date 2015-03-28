<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Orders extends Admin_Controller {

	private $error = array();

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->library('currency'); // load the currency library
		$this->load->model('Customers_model');
		$this->load->model('Addresses_model');
		$this->load->model('Locations_model');
		$this->load->model('Orders_model');
		$this->load->model('Statuses_model');
		$this->load->model('Staffs_model');
		$this->load->model('Paypal_model');
		$this->load->model('Countries_model');
	}

	public function index() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'orders')) {
  			redirect('permission');
		}

		$url = '?';
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		if ($this->input->get('filter_search')) {
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}

    	if (is_numeric($this->input->get('filter_location'))) {
			$filter['filter_location'] = $data['filter_location'] = $this->input->get('filter_location');
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else {
			$filter['filter_location'] = $data['filter_location'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
			$data['filter_status'] = '';
		}

		if (is_numeric($this->input->get('filter_type'))) {
			$filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
			$url .= 'filter_type='.$filter['filter_type'].'&';
		} else {
			$filter['filter_type'] = $data['filter_type'] = '';
		}

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'date_added';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}

		$this->template->setTitle('Orders');
		$this->template->setHeading('Orders');
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no orders available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_id'] 			= site_url('orders'.$url.'sort_by=order_id&order_by='.$order_by);
		$data['sort_location'] 		= site_url('orders'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_customer'] 		= site_url('orders'.$url.'sort_by=first_name&order_by='.$order_by);
		$data['sort_status'] 		= site_url('orders'.$url.'sort_by=status_name&order_by='.$order_by);
		$data['sort_type'] 			= site_url('orders'.$url.'sort_by=order_type&order_by='.$order_by);
		$data['sort_total'] 		= site_url('orders'.$url.'sort_by=order_total&order_by='.$order_by);
		$data['sort_time']			= site_url('orders'.$url.'sort_by=order_time&order_by='.$order_by);
		$data['sort_date'] 			= site_url('orders'.$url.'sort_by=date_added&order_by='.$order_by);

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
				'order_type' 		=> ($result['order_type'] === '1') ? 'Delivery' : 'Collection',
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_status'		=> $result['status_name'],
				'order_total'		=> $this->currency->format($result['order_total']),
				'date_added'		=> $date_added,
				'edit' 				=> site_url('orders/edit?id=' . $result['order_id'])
			);
		}

		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('order');
		foreach ($statuses as $statuses) {
			$data['statuses'][] = array(
				'status_id'			=> $statuses['status_id'],
				'status_name'		=> $statuses['status_name']
			);
		}

		$data['order_dates'] = array();
		$order_dates = $this->Orders_model->getOrderDates();
		foreach ($order_dates as $order_date) {
			$month_year = '';
			$month_year = $order_date['year'].'-'.$order_date['month'];
			$data['order_dates'][$month_year] = mdate('%F %Y', strtotime($order_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('orders').$url;
		$config['total_rows'] 		= $this->Orders_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteOrder() === TRUE) {
			redirect('orders');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('orders', $data);
	}

	public function edit() {
		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'orders')) {
  			redirect('permission');
		}

		$order_info = $this->Orders_model->getOrder((int) $this->input->get('id'));

		if ($order_info) {
			$order_id = $order_info['order_id'];
			$data['action']	= site_url('orders/edit?id='. $order_id);
		} else {
		    $order_id = 0;
			//$data['action']	= site_url('orders/edit');
			redirect('orders');
		}

		$title = (isset($order_info['order_id'])) ? $order_info['order_id'] : 'New';
		$this->template->setTitle('Order: '. $title);
		$this->template->setHeading('Order: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('orders'));

		$data['text_empty'] 		= 'There are no status history for this order.';

		$data['order_id'] 			= $order_info['order_id'];
		$data['customer_id'] 		= $order_info['customer_id'];
		$data['customer_edit'] 		= site_url('customers/edit?id=' . $order_info['customer_id']);
		$data['first_name'] 		= $order_info['first_name'];
		$data['last_name'] 			= $order_info['last_name'];
		$data['email'] 				= $order_info['email'];
		$data['telephone'] 			= $order_info['telephone'];
		$data['date_added'] 		= mdate('%d %M %y - %H:%i', strtotime($order_info['date_added']));
		$data['date_modified'] 		= mdate('%d %M %y', strtotime($order_info['date_modified']));
		$data['order_time'] 		= mdate('%H:%i', strtotime($order_info['order_time']));
		$data['order_type'] 		= ($order_info['order_type'] === '1') ? 'Delivery' : 'Collection';
		$data['status_id'] 			= $order_info['status_id'];
		$data['assignee_id'] 		= $order_info['assignee_id'];
		$data['comment'] 			= $order_info['comment'];
		$data['notify'] 			= $order_info['notify'];
		$data['ip_address'] 		= $order_info['ip_address'];
		$data['user_agent'] 		= $order_info['user_agent'];
		$data['check_order_type'] 	= $order_info['order_type'];

		if ($order_info['payment'] === 'paypal_express') {
			$data['payment'] = 'PayPal';
			$data['paypal_details'] = $this->Paypal_model->getPaypalDetails($order_info['order_id'], $order_info['customer_id']);
		} else if ($order_info['payment'] === 'cod') {
			$data['payment'] = 'Cash On Delivery';
			$data['paypal_details'] = array();
		} else {
			$data['payment'] = 'No Payment';
			$data['paypal_details'] = array();
		}

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();
		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$data['staffs'] = array();
		$staffs = $this->Staffs_model->getStaffs();
		foreach ($staffs as $staff) {
			$data['staffs'][] = array(
				'staff_id'		=> $staff['staff_id'],
				'staff_name'	=> $staff['staff_name']
			);
		}

		$data['statuses'] = array();
		$statuses = $this->Statuses_model->getStatuses('order');
		foreach ($statuses as $statuses) {
			$data['statuses'][] = array(
				'status_id'			=> $statuses['status_id'],
				'status_name'		=> $statuses['status_name'],
				'notify'			=> $statuses['notify_customer'],
				'status_comment'	=> $statuses['status_comment']
			);
		}

		$data['status_history'] = array();
		$status_history = $this->Statuses_model->getStatusHistories('order', $order_id);
		foreach ($status_history as $history) {
			$data['status_history'][] = array(
				'history_id'	=> $history['status_history_id'],
				'date_time'		=> mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
				'staff_name'	=> $history['staff_name'],
				'assignee_id'	=> $history['assignee_id'],
				'status_name'	=> $history['status_name'],
				'notify'		=> $history['notify'],
				'comment'		=> $history['comment']
			);
		}

		$this->load->library('country');
		$data['location_name'] = $data['location_address'] = '';
		if (!empty($order_info['location_id'])) {
			$location_address = $this->Locations_model->getAddress($order_info['location_id']);
			if ($location_address) {
				$data['location_name'] = $location_address['location_name'];
				$data['location_address'] = $this->country->addressFormat($location_address);
			}
		}

		$data['customer_address'] = '';
		if (!empty($order_info['customer_id'])) {
			$customer_address = $this->Addresses_model->getCustomerAddress($order_info['customer_id'], $order_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		} else if (!empty($order_info['address_id'])) {
			$customer_address = $this->Addresses_model->getGuestAddress($order_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		}

		$data['cart_items'] = array();
		$cart_items = $this->Orders_model->getOrderMenus($order_info['order_id']);
		foreach ($cart_items as $cart_item) {
			$option_data = array();
			$menu_options = $this->Orders_model->getOrderMenuOptions($order_info['order_id'], $cart_item['menu_id']);
			if ($menu_options) {
				foreach ($menu_options as $menu_option) {
					$option_data[] = $menu_option['order_option_name'];
				}
			}

			$options = array();
			if (!empty($cart_item['order_option_id'])) {
				$options = array('name' => $cart_item['option_name'], 'price' => $cart_item['option_price']);
			}

			$data['cart_items'][] = array(
				'id' 			=> $cart_item['menu_id'],
				'name' 			=> $cart_item['name'],
				'qty' 			=> $cart_item['quantity'],
				'price' 		=> $this->currency->format($cart_item['price']),
				'subtotal' 		=> $this->currency->format($cart_item['subtotal']),
				'options'		=> implode(', ', $option_data)
			);
		}

		$data['totals'] = array();
		$order_totals = $this->Orders_model->getOrderTotals($order_info['order_id']);
		foreach ($order_totals as $total) {
			$title = $total['title'];
			$value = $this->currency->format($total['value']);

			if ($total['code'] == 'coupon') {
				$coupon = $this->Orders_model->getOrderCoupon($order_info['order_id']);
				$title = $total['title'] .'('. $coupon['code'] .')';
				$value = $this->currency->format($coupon['amount']);
			}

			$data['totals'][] = array(
				'title' 		=> $title,
				'code' 			=> $total['code'],
				'value' 		=> $value
			);
		}

		$data['order_total'] 		= $this->currency->format($order_info['order_total']);
		$data['total_items']		= $order_info['total_items'];

		if ($this->input->post() AND $this->_updateOrder($order_info['status_id'], $data['assignee_id']) === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('orders');
			}

			redirect('orders/edit?id='. $order_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('orders_edit', $data);
	}

	public function _updateOrder($status_id = FALSE, $assignee_id = 0) {
    	if (!$this->user->hasPermissions('modify', 'orders')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {
			$update = array();
			$history = array();
			$current_time = time();														// retrieve current timestamp

			$update['order_id'] = (int)$this->input->get('id');
			$update['status_id'] = (int)$this->input->post('order_status');
			$update['date_modified'] =  mdate('%Y-%m-%d', $current_time);

			$update['object_id'] 		= $update['order_id'];
			$update['staff_id']			= $this->user->getStaffId();
			$update['old_assignee_id']	= (int)$assignee_id;
			$update['assignee_id']		= (int)$this->input->post('assignee_id');
			$update['notify']			= $this->input->post('notify');
			$update['comment']			= $this->input->post('status_comment');
			$update['date_added']		= mdate('%Y-%m-%d %H:%i:%s', $current_time);

			if ($this->Orders_model->updateOrder($update, $status_id)) {
				$this->alert->set('success', 'Order updated sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing updated.');
			}

			return TRUE;
		}
	}

	public function _deleteOrder() {
    	if (!$this->user->hasPermissions('modify', 'orders')) {
			$this->alert->set('warning', 'Warning: You do not have permission to delete!');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Orders_model->deleteOrder($value);
			}

			$this->alert->set('success', 'Order deleted sucessfully!');
		}

		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('order_status', 'Order Status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('assigned_staff', 'Assign Staff', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file orders.php */
/* Location: ./admin/controllers/orders.php */