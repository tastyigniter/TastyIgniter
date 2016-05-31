<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Orders extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Orders');

        $this->load->model('Customers_model');
        $this->load->model('Addresses_model');
        $this->load->model('Locations_model');
        $this->load->model('Orders_model');
        $this->load->model('Statuses_model');
        $this->load->model('Staffs_model');
        $this->load->model('Countries_model');

        $this->load->library('pagination');
        $this->load->library('currency'); // load the currency library

        $this->lang->load('orders');
    }

	public function index() {
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

		if ($data['user_strict_location'] = $this->user->isStrictLocation()) {
			$filter['filter_location'] = $data['filter_location'] = $this->user->getLocationId();
			$url .= 'filter_location='.$filter['filter_location'].'&';
		} else if (is_numeric($this->input->get('filter_location'))) {
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

		if ($this->input->get('filter_payment')) {
			$filter['filter_payment'] = $data['filter_payment'] = $this->input->get('filter_payment');
			$url .= 'filter_payment='.$filter['filter_payment'].'&';
		} else {
			$filter['filter_payment'] = $data['filter_payment'] = '';
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

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));

		if ($this->input->post('delete') AND $this->_deleteOrder() === TRUE) {
			redirect('orders');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_id'] 			= site_url('orders'.$url.'sort_by=order_id&order_by='.$order_by);
		$data['sort_location'] 		= site_url('orders'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_customer'] 		= site_url('orders'.$url.'sort_by=first_name&order_by='.$order_by);
		$data['sort_status'] 		= site_url('orders'.$url.'sort_by=status_name&order_by='.$order_by);
		$data['sort_type'] 			= site_url('orders'.$url.'sort_by=order_type&order_by='.$order_by);
		$data['sort_payment'] 		= site_url('orders'.$url.'sort_by=payment&order_by='.$order_by);
		$data['sort_total'] 		= site_url('orders'.$url.'sort_by=order_total&order_by='.$order_by);
		$data['sort_time']			= site_url('orders'.$url.'sort_by=order_time&order_by='.$order_by);
		$data['sort_date'] 			= site_url('orders'.$url.'sort_by=date_added&order_by='.$order_by);

		$results = $this->Orders_model->getList($filter);

		$data['orders'] = array();
		foreach ($results as $result) {
			$payment_title = '--';
			if ($payment = $this->extension->getPayment($result['payment'])) {
				$payment_title = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title']: $payment['title'];
			}

			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'order_type' 		=> ($result['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection'),
				'payment'			=> $payment_title,
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_date'		=> day_elapsed($result['order_date']),
				'order_status'		=> $result['status_name'],
				'status_color'		=> $result['status_color'],
				'order_total'		=> $this->currency->format($result['order_total']),
				'date_added'		=> day_elapsed($result['date_added']),
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

		$data['payments'] = array();
		$payments = $this->extension->getPayments();
		foreach ($payments as $payment) {
			$data['payments'][] = array(
				'name'  => $payment['name'],
				'title' => $payment['title'],
			);
		}

		$data['order_dates'] = array();
		$order_dates = $this->Orders_model->getOrderDates();
		foreach ($order_dates as $order_date) {
			$month_year = $order_date['year'].'-'.$order_date['month'];
			$data['order_dates'][$month_year] = mdate('%F %Y', strtotime($order_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('orders'.$url);
		$config['total_rows'] 		= $this->Orders_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('orders', $data);
	}

	public function edit() {
		$order_info = $this->Orders_model->getOrder((int) $this->input->get('id'));

		if ($order_info) {
			$order_id = $order_info['order_id'];
			$data['_action']	= site_url('orders/edit?id='. $order_id);
		} else {
		    $order_id = 0;
			//$data['_action']	= site_url('orders/edit');
			redirect('orders');
		}

		$title = (isset($order_info['order_id'])) ? $order_info['order_id'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('orders')));

		if ($this->input->post() AND $this->_updateOrder() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('orders');
			}

			redirect('orders/edit?id='. $order_id);
		}

		$data['order_id'] 			= $order_info['order_id'];
		$data['invoice_no'] 		= !empty($order_info['invoice_no']) ? $order_info['invoice_prefix'].$order_info['invoice_no'] : '';
		$data['customer_id'] 		= $order_info['customer_id'];
		$data['customer_edit'] 		= site_url('customers/edit?id=' . $order_info['customer_id']);
		$data['first_name'] 		= $order_info['first_name'];
		$data['last_name'] 			= $order_info['last_name'];
		$data['email'] 				= $order_info['email'];
		$data['telephone'] 			= $order_info['telephone'];
		$data['date_added'] 		= mdate('%d %M %y - %H:%i', strtotime($order_info['date_added']));
		$data['date_modified'] 		= mdate('%d %M %y', strtotime($order_info['date_modified']));
		$data['order_time'] 		= mdate('%H:%i', strtotime($order_info['order_time']));
		$data['order_type'] 		= ($order_info['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection');
		$data['status_id'] 			= $order_info['status_id'];
		$data['status_name'] 	    = $order_info['status_name'];
		$data['assignee_id'] 		= $order_info['assignee_id'];
		$data['comment'] 			= $order_info['comment'];
		$data['notify'] 			= $order_info['notify'];
		$data['ip_address'] 		= $order_info['ip_address'];
		$data['user_agent'] 		= $order_info['user_agent'];
		$data['check_order_type'] 	= $order_info['order_type'];

		$data['paypal_details'] = array();
		if ($payment = $this->extension->getPayment($order_info['payment'])) {
			if ($payment['name'] === 'paypal_express') {
				$this->load->model('paypal_express/Paypal_model');
				$data['paypal_details'] = (isset($this->Paypal_model)) ? $this->Paypal_model->getPaypalDetails($order_info['order_id'], $order_info['customer_id']) : array();
			}

			$data['payment'] = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title']: $payment['title'];
		} else {
			$data['payment'] = $this->lang->line('text_no_payment');
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
				'status_comment'	=> nl2br($statuses['status_comment'])
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
				'status_color'	=> $history['status_color'],
				'notify'		=> $history['notify'],
				'comment'		=> nl2br($history['comment'])
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
			$customer_address = $this->Addresses_model->getAddress($order_info['customer_id'], $order_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		} else if (!empty($order_info['address_id'])) {
			$customer_address = $this->Addresses_model->getGuestAddress($order_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		}

		$data['cart_items'] = array();
		$cart_items = $this->Orders_model->getOrderMenus($order_info['order_id']);
        $menu_options = $this->Orders_model->getOrderMenuOptions($order_info['order_id']);
		foreach ($cart_items as $cart_item) {
			$option_data = array();

			if (!empty($menu_options)) {
				foreach ($menu_options as $menu_option) {
					if ($cart_item['order_menu_id'] === $menu_option['order_menu_id']) {
						$option_data[] = $menu_option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($menu_option['order_option_price']);
					}
				}
			}

			$data['cart_items'][] = array(
				'id' 			=> $cart_item['menu_id'],
				'name' 			=> $cart_item['name'],
				'qty' 			=> $cart_item['quantity'],
				'price' 		=> $this->currency->format($cart_item['price']),
				'subtotal' 		=> $this->currency->format($cart_item['subtotal']),
				'comment' 		=> $cart_item['comment'],
				'options'		=> implode('<br /> ', $option_data)
			);
		}

		$data['totals'] = array();
		$order_totals = $this->Orders_model->getOrderTotals($order_info['order_id']);
		foreach ($order_totals as $total) {
			if ($order_info['order_type'] === '2' AND $total['code'] == 'delivery') {
				continue;
			}

			$data['totals'][] = array(
				'code'  => $total['code'],
				'title' => htmlspecialchars_decode($total['title']),
				'value' => $this->currency->format($total['value']),
				'priority' => $total['priority'],
			);
		}

		$data['order_total'] 		= $this->currency->format($order_info['order_total']);
		$data['total_items']		= $order_info['total_items'];

		$this->template->render('orders_edit', $data);
	}

	public function create_invoice() {
		$json = array();

		if (is_numeric($this->input->post('order_id'))) {
			$json['invoice_no'] = $this->Orders_model->createInvoiceNo($this->input->post('order_id'));

			if ($json['invoice_no'] === TRUE) {
				$this->alert->set('warning', $this->lang->line('alert_order_not_completed'));
			} else if (!empty($json['invoice_no'])) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Invoice generated'));
			} else {
				$this->alert->set('error', sprintf($this->lang->line('alert_error_nothing'), 'generated'));
			}

			$json['redirect'] = site_url('orders/edit?id='.$this->input->post('order_id'));
		}

		$this->output->set_output(json_encode($json));
	}

	public function invoice() {
		$this->output->enable_profiler(FALSE);
		$action = $this->uri->rsegment('3');

		$this->template->setStyleTag('css/bootstrap.min.css', 'bootstrap-css', '1');
		$this->template->setStyleTag('css/fonts.css', 'fonts-css', '2');

		$this->load->model('Image_tool_model');
		$data['invoice_logo'] 		= $this->Image_tool_model->resize($this->config->item('site_logo'));

		$invoice_info = $this->Orders_model->getInvoice($this->uri->rsegment('4'));

		$data['order_id'] = $invoice_info['order_id'];
		$data['invoice_no'] = $invoice_info['invoice_prefix'] . $invoice_info['invoice_no'];
		$data['customer_id'] = $invoice_info['customer_id'];
		$data['first_name'] = $invoice_info['first_name'];
		$data['last_name'] = $invoice_info['last_name'];
		$data['email'] = $invoice_info['email'];
		$data['telephone'] = $invoice_info['telephone'];
		$data['date_added'] = mdate('%F %d, %Y', strtotime($invoice_info['date_added']));
		$data['invoice_date'] = mdate('%F %d, %Y', strtotime($invoice_info['invoice_date']));
		$data['date_modified'] = mdate('%d %M %y', strtotime($invoice_info['date_modified']));
		$data['order_time'] = mdate('%H:%i', strtotime($invoice_info['order_time']));
		$data['order_type'] = ($invoice_info['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection');
		$data['comment'] = $invoice_info['comment'];
		$data['check_order_type'] = $invoice_info['order_type'];

		if ($payment = $this->extension->getPayment($invoice_info['payment'])) {
			if ($payment['name'] === 'paypal_express') {
				$this->load->model('paypal_express/Paypal_model');
				$data['paypal_details'] = (isset($this->Paypal_model)) ? $this->Paypal_model->getPaypalDetails($invoice_info['order_id'], $invoice_info['customer_id']) : '';
			}

			$data['payment'] = ! empty($payment['ext_data']['title']) ? $payment['ext_data']['title'] : $payment['title'];
		} else {
			$data['payment'] = 'No Payment';
		}

		$this->load->library('country');
		$data['location_name'] = $data['location_address'] = '';
		if ( ! empty($invoice_info['location_id'])) {
			$location_address = $this->Locations_model->getAddress($invoice_info['location_id']);
			if ($location_address) {
				$data['location_name'] = $location_address['location_name'];
				$data['location_address'] = $this->country->addressFormat($location_address);
			}
		}

		$data['customer_address'] = '';
		if ( ! empty($invoice_info['customer_id'])) {
			$customer_address = $this->Addresses_model->getAddress($invoice_info['customer_id'], $invoice_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		} else if ( ! empty($invoice_info['address_id'])) {
			$customer_address = $this->Addresses_model->getGuestAddress($invoice_info['address_id']);
			$data['customer_address'] = $this->country->addressFormat($customer_address);
		}

		$data['cart_items'] = array();
		$cart_items = $this->Orders_model->getOrderMenus($invoice_info['order_id']);
		$menu_options = $this->Orders_model->getOrderMenuOptions($invoice_info['order_id']);
		foreach ($cart_items as $cart_item) {
			$option_data = array();

			if ( ! empty($menu_options)) {
				foreach ($menu_options as $menu_option) {
					if ($cart_item['order_menu_id'] === $menu_option['order_menu_id']) {
						$option_data[] = $menu_option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($menu_option['order_option_price']);
					}
				}
			}

			$data['cart_items'][] = array(
				'id'       => $cart_item['menu_id'],
				'name'     => $cart_item['name'],
				'qty'      => $cart_item['quantity'],
				'price'    => $this->currency->format($cart_item['price']),
				'subtotal' => $this->currency->format($cart_item['subtotal']),
				'comment'  => $cart_item['comment'],
				'options'  => implode(', ', $option_data)
			);
		}

		$data['totals'] = array();
		$order_totals = $this->Orders_model->getOrderTotals($invoice_info['order_id']);
		foreach ($order_totals as $name => $total) {
			if ($total['code'] == 'delivery' AND $invoice_info['order_type'] === '2') {
				continue;
			}

			$data['totals'][] = array(
				'code'  => $total['code'],
				'title' => htmlspecialchars_decode($total['title']),
				'value' => $this->currency->format($total['value']),
				'priority' => $total['priority'],
			);
		}

		$data['order_total'] = $this->currency->format($invoice_info['order_total']);

		if ($action === 'view') {
			$this->load->view($this->config->item(ADMINDIR, 'default_themes').'orders_invoice', $data);
		}
	}

	private function _updateOrder() {
    	if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) {

			if ($this->Orders_model->updateOrder($this->input->get('id'), $this->input->post())) {
                log_activity($this->user->getStaffId(), 'updated', 'orders', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), 'updated', 'order', current_url(), '#'.$this->input->get('id'))
                ));

                if ($this->input->post('assignee_id') AND $this->input->post('old_assignee_id') !== $this->input->post('assignee_id')) {
                    $staff = $this->Staffs_model->getStaff($this->input->post('assignee_id'));
	                $staff_assignee = site_url('staffs/edit?id='.$staff['staff_id']);

	                log_activity($this->user->getStaffId(), 'assigned', 'orders', get_activity_message('activity_assigned',
                        array('{staff}', '{action}', '{context}', '{link}', '{item}', '{assignee}'),
                        array($this->user->getStaffName(), 'assigned', 'order', current_url(), '#'.$this->input->get('id'), "<a href=\"{$staff_assignee}\">{$staff['staff_name']}</a>")
                    ));
                }

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Order updated'));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function _deleteOrder() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Orders_model->deleteOrder($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Orders': 'Order';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('order_status', 'lang:label_status', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('assignee_id', 'lang:label_assign_staff', 'xss_clean|trim|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file orders.php */
/* Location: ./admin/controllers/orders.php */