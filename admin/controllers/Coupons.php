<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Coupons extends Admin_Controller
{
	public $filter = array(
		'filter_search' => '',
		'filter_type'   => '',
		'filter_status' => '',
	);
	
	public $default_sort = array('coupon_id', 'DESC');

	public $sort = array('name', 'code', 'type', 'discount', 'validity');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Coupons');

		$this->load->model('Coupons_model');

		$this->lang->load('coupons');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteCoupon() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('coupons', $data);
	}

	public function edit() {
		if ($this->input->post() AND $coupon_id = $this->_saveCoupon()) {
			$this->redirect($coupon_id);
		}

		$coupon_info = $this->Coupons_model->getCoupon((int)$this->input->get('id'));

		$title = (isset($coupon_info['name'])) ? $coupon_info['name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('coupons')));

		$this->template->setStyleTag(assets_url('js/datepicker/datepicker.css'), 'datepicker-css');
		$this->template->setScriptTag(assets_url("js/datepicker/bootstrap-datepicker.js"), 'bootstrap-datepicker-js');
		$this->template->setStyleTag(assets_url('js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css');
		$this->template->setScriptTag(assets_url("js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js');

		$data = $this->getForm($coupon_info);

		$this->template->render('coupons_edit', $data);
	}

	public function getList() {
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['coupons'] = array();
		$results = $this->Coupons_model->paginate($this->getFilter());
		foreach ($results->list as $result) {
			$data['coupons'][] = array_merge($result, array(
				'edit' => $this->pageUrl($this->edit_url, array('id' => $result['coupon_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($coupon_info = array()) {
		$data = $coupon_info;

		$coupon_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($coupon_info['coupon_id'])) {
			$coupon_id = $coupon_info['coupon_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $coupon_info['coupon_id']));
		}

		if ($this->input->post('validity')) {
			$data['validity'] = $this->input->post('validity');
		} else if (!empty($coupon_info['validity'])) {
			$data['validity'] = $coupon_info['validity'];
		} else {
			$data['validity'] = 'forever';
		}

		$data['coupon_id'] = $coupon_info['coupon_id'];
		$data['name'] = $coupon_info['name'];
		$data['code'] = $coupon_info['code'];
		$data['type'] = $coupon_info['type'];
		$data['discount'] = substr($coupon_info['discount'], 0, strripos($coupon_info['discount'], '.'));
		$data['min_total'] = substr($coupon_info['min_total'], 0, strripos($coupon_info['min_total'], '.'));
		$data['redemptions'] = $coupon_info['redemptions'];
		$data['customer_redemptions'] = $coupon_info['customer_redemptions'];
		$data['description'] = $coupon_info['description'];
		$data['fixed_date'] = (empty($coupon_info['fixed_date']) OR $coupon_info['fixed_date'] === '0000-00-00') ? '' : mdate('%d-%m-%Y', strtotime($coupon_info['fixed_date']));
		$data['fixed_from_time'] = (empty($coupon_info['fixed_from_time']) OR $coupon_info['fixed_from_time'] === '00:00:00') ? '' : mdate('%h:%i %a', strtotime($coupon_info['fixed_from_time']));
		$data['fixed_to_time'] = (empty($coupon_info['fixed_to_time']) OR $coupon_info['fixed_to_time'] === '00:00:00') ? '' : mdate('%h:%i %a', strtotime($coupon_info['fixed_to_time']));
		$data['period_start_date'] = (empty($coupon_info['period_start_date']) OR $coupon_info['period_start_date'] === '0000-00-00') ? '' : mdate('%d-%m-%Y', strtotime($coupon_info['period_start_date']));
		$data['period_end_date'] = (empty($coupon_info['period_end_date']) OR $coupon_info['period_end_date'] === '0000-00-00') ? '' : mdate('%d-%m-%Y', strtotime($coupon_info['period_end_date']));
		$data['recurring_every'] = (empty($coupon_info['recurring_every'])) ? array() : explode(', ', $coupon_info['recurring_every']);
		$data['recurring_from_time'] = (empty($coupon_info['recurring_from_time']) OR $coupon_info['recurring_from_time'] === '00:00:00') ? '' : mdate('%h:%i %a', strtotime($coupon_info['recurring_from_time']));
		$data['recurring_to_time'] = (empty($coupon_info['recurring_to_time']) OR $coupon_info['recurring_to_time'] === '00:00:00') ? '' : mdate('%h:%i %a', strtotime($coupon_info['recurring_to_time']));
		$data['order_restriction'] = $coupon_info['order_restriction'];
		$data['date_added'] = $coupon_info['date_added'];
		$data['status'] = $coupon_info['status'];

		$data['weekdays'] = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');

		$data['fixed_time'] = $this->lang->line('text_24_hour');
		if (isset($coupon_info['fixed_from_time'], $coupon_info['fixed_to_time']) AND ($coupon_info['fixed_from_time'] !== '00:00:00' OR $coupon_info['fixed_to_time'] !== '23:59:00')) {
			$data['fixed_time'] = $this->lang->line('text_custom');
		}

		$data['recurring_time'] = $this->lang->line('text_24_hour');
		if (isset($coupon_info['recurring_from_time'], $coupon_info['recurring_to_time']) AND ($coupon_info['recurring_from_time'] !== '00:00:00' OR $coupon_info['recurring_to_time'] !== '23:59:00')) {
			$data['recurring_time'] = $this->lang->line('text_custom');
		}

		$data['coupon_histories'] = array();
		$coupon_histories = $this->Coupons_model->getCouponHistories($coupon_id);
		foreach ($coupon_histories as $coupon_history) {
			$data['coupon_histories'][] = array_merge($coupon_history, array(
				'customer_name' => $coupon_history['first_name'] . ' ' . $coupon_history['last_name'],
				'date_used'     => mdate('%d %M %y', strtotime($coupon_history['date_used'])),
				'view'          => $this->pageUrl('orders/edit?id=' . $coupon_history['order_id']),
			));
		}

		return $data;
	}

	protected function _saveCoupon() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($coupon_id = $this->Coupons_model->saveCoupon($this->input->get('id'), $this->input->post())) {
				log_activity($this->user->getStaffId(), $save_type, 'coupons', get_activity_message('activity_custom',
					array('{staff}', '{action}', '{context}', '{link}', '{item}'),
					array($this->user->getStaffName(), $save_type, 'coupon', $this->pageUrl($this->edit_url, array('id' => $coupon_id)), $this->input->post('name'))
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Coupon ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $coupon_id;
		}
	}

	protected function _deleteCoupon() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Coupons_model->deleteCoupon($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Coupons' : 'Coupon';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$rules[] = array('code', 'lang:label_code', 'xss_clean|trim|required|min_length[2]|max_length[15]');
		$rules[] = array('type', 'lang:label_type', 'xss_clean|trim|required|exact_length[1]');
		$rules[] = array('discount', 'lang:label_discount', 'xss_clean|trim|required|numeric');

		if ($this->input->post('type') === 'P') {
			$rules[] = array('discount', 'lang:label_discount', 'less_than[100]');
		}

		$rules[] = array('min_total', 'lang:label_min_total', 'xss_clean|trim|numeric');
		$rules[] = array('redemptions', 'lang:label_redemption', 'xss_clean|trim|integer');
		$rules[] = array('customer_redemptions', 'lang:label_customer_redemption', 'xss_clean|trim|integer');
		$rules[] = array('description', 'lang:label_description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$rules[] = array('validity', 'lang:label_validity', 'xss_clean|trim|required');

		if ($this->input->post('validity') === 'fixed') {
			$rules[] = array('validity_times[fixed_date]', 'lang:label_fixed_date', 'xss_clean|trim|required|valid_date');
			$rules[] = array('fixed_time', 'lang:label_fixed_time', 'xss_clean|trim|required');

			if ($this->input->post('fixed_time') !== '24hours') {
				$rules[] = array('validity_times[fixed_from_time]', 'lang:label_fixed_from_time', 'xss_clean|trim|required|valid_time');
				$rules[] = array('validity_times[fixed_to_time]', 'lang:label_fixed_to_time', 'xss_clean|trim|required|valid_time');
			}
		} else if ($this->input->post('validity') === 'period') {
			$rules[] = array('validity_times[period_start_date]', 'lang:label_period_start_date', 'xss_clean|trim|required|valid_date');
			$rules[] = array('validity_times[period_end_date]', 'lang:label_period_end_date', 'xss_clean|trim|required|valid_date');
		} else if ($this->input->post('validity') === 'recurring') {
			$rules[] = array('validity_times[recurring_every]', 'lang:label_recurring_every', 'xss_clean|trim|required');
			if (isset($_POST['validity_times']['recurring_every'])) {
				foreach ($_POST['validity_times']['recurring_every'] as $key => $value) {
					$rules[] = array('validity_times[recurring_every][' . $key . ']', 'lang:label_recurring_every', 'xss_clean|required');
				}
			}

			$rules[] = array('recurring_time', 'lang:label_recurring_time', 'xss_clean|trim|required');
			if ($this->input->post('recurring_time') !== '24hours') {
				$rules[] = array('validity_times[recurring_from_time]', 'lang:label_recurring_from_time', 'xss_clean|trim|required|valid_time');
				$rules[] = array('validity_times[recurring_to_time]', 'lang:label_recurring_to_time', 'xss_clean|trim|required|valid_time');
			}
		}

		$rules[] = array('order_restriction', 'lang:label_order_restriction', 'xss_clean|trim|integer');
		$rules[] = array('status', 'lang:label_status', 'xss_clean|trim|required|integer');

		return $this->Coupons_model->set_rules($rules)->validate();
	}
}

/* End of file Coupons.php */
/* Location: ./admin/controllers/Coupons.php */