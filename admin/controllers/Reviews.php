<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Reviews extends Admin_Controller
{

	public $list_filters = array(
		'filter_search'   => '',
		'filter_location' => '',
		'filter_date'     => '',
		'filter_status'   => '',
		'sort_by'         => 'reviews.date_added',
		'order_by'        => 'DESC',
	);

	public $sort_columns = array('location_name', 'author', 'sale_id', 'sale_type', 'review_status', 'date_added');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Reviews');

		$this->load->model('Reviews_model'); // load the reviews model

		$this->lang->load('reviews');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteReview() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('reviews', $data);
	}

	public function edit() {
		if ($this->input->post() AND $review_id = $this->_saveReview()) {
			$this->redirect($review_id);
		}

		$review_info = $this->Reviews_model->getReview((int)$this->input->get('id'));

		$title = (isset($review_info['location_name'])) ? $review_info['location_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('reviews')));

		$data = $this->getForm($review_info);

		$this->template->render('reviews_edit', $data);
	}

	protected function getList() {
		if ($data['user_strict_location'] = $this->user->isStrictLocation()) {
			$this->list_filters['filter_location'] = $this->user->getLocationId();
		}

		$data = array_merge($this->list_filters, $this->sort_columns, $data);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$data['reviews'] = array();
		$results = $this->Reviews_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $review) {
			$data['reviews'][] = array_merge($review, array(
				'date_added' => mdate('%d %M %y', strtotime($review['date_added'])),
				'edit'       => $this->pageUrl($this->edit_url, array('id' => $review['review_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		$this->load->model('Locations_model');
		$data['locations'] = $this->Locations_model->isEnabled()->dropdown('location_name');

		$data['review_dates'] = array();
		$review_dates = $this->Reviews_model->getReviewDates();
		foreach ($review_dates as $review_date) {
			$month_year = $review_date['year'] . '-' . $review_date['month'];
			$data['review_dates'][$month_year] = mdate('%F %Y', strtotime($review_date['date_added']));
		}

		return $data;
	}

	protected function getForm($review_info) {
		$data = $review_info;

		$review_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($review_info['review_id'])) {
			$review_id = $review_info['review_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $review_id));
		}

		$data['review_id'] = $review_info['review_id'];
		$data['location_id'] = $review_info['location_id'];
		$data['sale_id'] = $review_info['sale_id'];
		$data['sale_type'] = $review_info['sale_type'];
		$data['customer_id'] = $review_info['customer_id'];
		$data['author'] = $review_info['author'];
		$data['quality'] = ($this->input->post('rating[quality]')) ? $this->input->post('rating[quality]') : $review_info['quality'];
		$data['delivery'] = ($this->input->post('rating[delivery]')) ? $this->input->post('rating[delivery]') : $review_info['delivery'];
		$data['service'] = ($this->input->post('rating[service]')) ? $this->input->post('rating[service]') : $review_info['service'];
		$data['review_text'] = $review_info['review_text'];
		$data['date_added'] = $review_info['date_added'];
		$data['review_status'] = $review_info['review_status'];

		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$this->load->model('Locations_model');
		$data['locations'] = $this->Locations_model->isEnabled()->dropdown('location_name');

		return $data;
	}

	protected function _saveReview() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($review_id = $this->Reviews_model->saveReview($this->input->get('id'), $this->input->post())) {
				log_activity($this->user->getStaffId(), $save_type, 'reviews', get_activity_message('activity_custom',
					array('{staff}', '{action}', '{context}', '{link}', '{item}'),
					array($this->user->getStaffName(), $save_type, 'review', current_url(), $this->input->get('id'))
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Review ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $review_id;
		}
	}

	protected function _deleteReview() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Reviews_model->deleteReview($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Reviews' : 'Review';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('sale_type', 'lang:label_sale_type', 'xss_clean|trim|required|alpha');
		$rules[] = array('sale_id', 'lang:label_sale_id', 'xss_clean|trim|required|integer|callback__check_sale_id');
		$rules[] = array('location_id', 'lang:label_location', 'xss_clean|trim|required|integer|callback__check_location');
		$rules[] = array('customer_id', 'lang:label_customer', 'xss_clean|trim|required|integer|callback__check_customer');
		$rules[] = array('author', 'lang:label_author', 'xss_clean|trim|required');
		$rules[] = array('rating[quality]', 'lang:label_quality', 'xss_clean|trim|required|integer');
		$rules[] = array('rating[delivery]', 'lang:label_delivery', 'xss_clean|trim|required|integer');
		$rules[] = array('rating[service]', 'lang:label_service', 'xss_clean|trim|required|integer');
		$rules[] = array('review_text', 'lang:label_text', 'xss_clean|trim|required|min_length[2]|max_length[1028]');
		$rules[] = array('review_status', 'lang:label_status', 'xss_clean|trim|required|integer');

		return $this->Reviews_model->set_rules($rules)->validate();
	}

	public function _check_sale_id($sale_id) {
		if ($this->input->post('sale_type') === 'order') {
			$this->load->model('Orders_model');
			if (!$this->Orders_model->validateOrder($sale_id)) {
				$this->form_validation->set_message('_check_sale_id', $this->lang->line('error_not_found_in_order'));

				return FALSE;
			} else {
				return TRUE;
			}
		} else if ($this->input->post('sale_type') === 'reservation') {
			$this->load->model('Reservations_model');
			if (!$this->Reservations_model->validateReservation($sale_id)) {
				$this->form_validation->set_message('_check_sale_id', $this->lang->line('error_not_found_in_reservation'));

				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	public function _check_location($location_id) {
		$this->load->model('Locations_model');
		if (!$this->Locations_model->validateLocation($location_id)) {
			$this->form_validation->set_message('_check_location', $this->lang->line('error_not_found'));

			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function _check_customer($customer_id) {
		$this->load->model('Customers_model');
		if (!$this->Customers_model->validateCustomer($customer_id)) {
			$this->form_validation->set_message('_check_customer', $this->lang->line('error_not_found'));

			return FALSE;
		} else {
			return TRUE;
		}
	}

}

/* End of file Reviews.php */
/* Location: ./admin/controllers/Reviews.php */