<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reviews extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Reviews');

        $this->load->model('Reviews_model'); // load the reviews model

        $this->load->library('pagination');

        $this->lang->load('reviews');
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

		if ($this->input->get('filter_date')) {
			$filter['filter_date'] = $data['filter_date'] = $this->input->get('filter_date');
			$url .= 'filter_date='.$filter['filter_date'].'&';
		} else {
			$filter['filter_date'] = $data['filter_date'] = '';
		}

		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}

		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'reviews.date_added';
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
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		if ($this->input->post('delete') AND $this->_deleteReview() === TRUE) {
			redirect('reviews');
		}

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_location'] 		= site_url('reviews'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_author'] 		= site_url('reviews'.$url.'sort_by=author&order_by='.$order_by);
		$data['sort_id'] 			= site_url('reviews'.$url.'sort_by=sale_id&order_by='.$order_by);
		$data['sort_status']		= site_url('reviews'.$url.'sort_by=review_status&order_by='.$order_by);
		$data['sort_date'] 			= site_url('reviews'.$url.'sort_by=date_added&order_by='.$order_by);

		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$reviews = $this->Reviews_model->getList($filter);
		$data['reviews'] = array();
		foreach ($reviews as $review) {
			$data['reviews'][] = array(
				'review_id' 		=> $review['review_id'],
				'location_name' 	=> $review['location_name'],
				'author' 			=> $review['author'],
				'quality' 			=> $review['quality'],
				'delivery' 			=> $review['delivery'],
				'service' 			=> $review['service'],
				'sale_type' 		=> $review['sale_type'],
				'sale_id' 			=> $review['sale_id'],
				'date_added' 		=> mdate('%d %M %y', strtotime($review['date_added'])),
				'review_status' 	=> $review['review_status'],
				'edit' 				=> site_url('reviews/edit?id=' . $review['review_id'])
			);
		}

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$data['review_dates'] = array();
		$review_dates = $this->Reviews_model->getReviewDates();
		foreach ($review_dates as $review_date) {
			$month_year = $review_date['year'].'-'.$review_date['month'];
			$data['review_dates'][$month_year] = mdate('%F %Y', strtotime($review_date['date_added']));
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('reviews'.$url);
		$config['total_rows'] 		= $this->Reviews_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('reviews', $data);
	}

	public function edit() {
		$review_info = $this->Reviews_model->getReview((int) $this->input->get('id'));

		if ($review_info) {
			$review_id = $review_info['review_id'];
			$data['_action']	= site_url('reviews/edit?id='. $review_id);
		} else {
		    $review_id = is_numeric($this->input->get('id')) AND $this->validateForm();
			$data['_action']	= site_url('reviews/edit');
		}

		$title = (isset($review_info['location_name'])) ? $review_info['location_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('reviews')));

		if ($this->input->post() AND $review_id = $this->_saveReview()) {
			if ($this->input->post('save_close') === '1') {
				redirect('reviews');
			}

			redirect('reviews/edit?id='. $review_id);
		}

		$data['review_id'] 			= $review_info['review_id'];
		$data['location_id'] 		= $review_info['location_id'];
		$data['sale_id'] 			= $review_info['sale_id'];
		$data['sale_type'] 			= $review_info['sale_type'];
		$data['customer_id'] 		= $review_info['customer_id'];
		$data['author'] 			= $review_info['author'];
		$data['quality'] 			= $review_info['quality'];
		$data['delivery'] 			= $review_info['delivery'];
		$data['service'] 			= $review_info['service'];
		$data['review_text'] 		= $review_info['review_text'];
		$data['date_added'] 		= $review_info['date_added'];
		$data['review_status'] 		= $review_info['review_status'];

		$ratings = $this->config->item('ratings');
		$data['ratings'] 			= $ratings['ratings'];

		$this->load->model('Locations_model');
		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

		$this->template->render('reviews_edit', $data);
	}

	private function _saveReview() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($review_id = $this->Reviews_model->saveReview($this->input->get('id'), $this->input->post())) {
                log_activity($this->user->getStaffId(), $save_type, 'reviews', get_activity_message('activity_custom',
                    array('{staff}', '{action}', '{context}', '{link}', '{item}'),
                    array($this->user->getStaffName(), $save_type, 'review', current_url(), $this->input->get('id'))
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Review '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $review_id;
		}
	}

	private function _deleteReview() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Reviews_model->deleteReview($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Reviews': 'Review';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('sale_type', 'lang:label_sale_type', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('sale_id', 'lang:label_sale_id', 'xss_clean|trim|required|integer|callback__check_sale_id');
		$this->form_validation->set_rules('location_id', 'lang:label_location', 'xss_clean|trim|required|integer|callback__check_location');
		$this->form_validation->set_rules('customer_id', 'lang:label_customer', 'xss_clean|trim|required|integer|callback__check_customer');
		$this->form_validation->set_rules('author', 'lang:label_author', 'xss_clean|trim|required');
		$this->form_validation->set_rules('rating[quality]', 'lang:label_quality', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[delivery]', 'lang:label_delivery', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[service]', 'lang:label_service', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('review_text', 'lang:label_text', 'xss_clean|trim|required|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('review_status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _check_sale_id($sale_id) {
		if ($this->input->post('sale_type') === 'order') {
			$this->load->model('Orders_model');
			if ( ! $this->Orders_model->validateOrder($sale_id)) {
	        	$this->form_validation->set_message('_check_sale_id', $this->lang->line('error_not_found_in_order'));
				return FALSE;
			} else {
				return TRUE;
			}
		} else if ($this->input->post('sale_type') === 'reservation') {
			$this->load->model('Reservations_model');
			if ( ! $this->Reservations_model->validateReservation($sale_id)) {
	        	$this->form_validation->set_message('_check_sale_id', $this->lang->line('error_not_found_in_reservation'));
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	public function _check_location($location_id) {
		$this->load->model('Locations_model');
		if ( ! $this->Locations_model->validateLocation($location_id)) {
        	$this->form_validation->set_message('_check_location', $this->lang->line('error_not_found'));
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function _check_customer($customer_id) {
		$this->load->model('Customers_model');
		if ( ! $this->Customers_model->validateCustomer($customer_id)) {
        	$this->form_validation->set_message('_check_customer', $this->lang->line('error_not_found'));
			return FALSE;
		} else {
			return TRUE;
		}
	}

}

/* End of file reviews.php */
/* Location: ./admin/controllers/reviews.php */