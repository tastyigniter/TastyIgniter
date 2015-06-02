<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reviews extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor
        $this->user->restrict('Admin.Reviews');
        $this->load->library('pagination');
		$this->load->model('Reviews_model'); // load the reviews model
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

    	if (is_numeric($this->input->get('filter_location'))) {
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

		$this->template->setTitle('Reviews');
		$this->template->setHeading('Reviews');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty']			= 'There are no reviews available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_location'] 		= site_url('reviews'.$url.'sort_by=location_name&order_by='.$order_by);
		$data['sort_author'] 		= site_url('reviews'.$url.'sort_by=author&order_by='.$order_by);
		$data['sort_id'] 			= site_url('reviews'.$url.'sort_by=sale_id&order_by='.$order_by);
		$data['sort_status']		= site_url('reviews'.$url.'sort_by=review_status&order_by='.$order_by);
		$data['sort_date'] 			= site_url('reviews'.$url.'sort_by=date_added&order_by='.$order_by);

		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$reviews = array();
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
			$month_year = '';
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

		if ($this->input->post('delete') AND $this->_deleteReview() === TRUE) {

			redirect('reviews');
		}

		$this->template->setPartials(array('header', 'footer'));
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

		$title = (isset($review_info['location_name'])) ? $review_info['location_name'] : 'New';
		$this->template->setTitle('Review: '. $title);
		$this->template->setHeading('Review: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('reviews'));

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

		if ($this->input->post() AND $review_id = $this->_saveReview()) {
			if ($this->input->post('save_close') === '1') {
				redirect('reviews');
			}

			redirect('reviews/edit?id='. $review_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('reviews_edit', $data);
	}

	private function _saveReview() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($review_id = $this->Reviews_model->saveReview($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Review ' . $save_type . ' successfully.');
			} else {
                $this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $review_id;
		}
	}

	private function _deleteReview() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Reviews_model->deleteReview($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Reviews': 'Review';
                $this->alert->set('success', $prefix.' deleted successfully.');
            } else {
                $this->alert->set('warning', 'An error occurred, nothing deleted.');
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('sale_type', 'Sale Type', 'xss_clean|trim|required|alpha');
		$this->form_validation->set_rules('sale_id', 'Sale ID', 'xss_clean|trim|required|integer|callback__check_sale_id');
		$this->form_validation->set_rules('location_id', 'Location', 'xss_clean|trim|required|integer|callback__check_location');
		$this->form_validation->set_rules('customer_id', 'Customer', 'xss_clean|trim|required|integer|callback__check_customer');
		$this->form_validation->set_rules('author', 'Author', 'xss_clean|trim|required');
		$this->form_validation->set_rules('rating[quality]', 'Quality Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[delivery]', 'Delivery Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[service]', 'Service Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('review_text', 'Rating Text', 'xss_clean|trim|required|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('review_status', 'Rating Status', 'xss_clean|trim|required|integer');

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
	        	$this->form_validation->set_message('_check_sale_id', 'The %s entered can not be found in orders');
				return FALSE;
			} else {
				return TRUE;
			}
		} else if ($this->input->post('sale_type') === 'reservation') {
			$this->load->model('Reservations_model');
			if ( ! $this->Reservations_model->validateReservation($sale_id)) {
	        	$this->form_validation->set_message('_check_sale_id', 'The %s entered can not be found in reservations');
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	public function _check_location($location_id) {
		$this->load->model('Locations_model');
		if ( ! $this->Locations_model->validateLocation($location_id)) {
        	$this->form_validation->set_message('_check_location', 'The %s entered can not be found');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function _check_customer($customer_id) {
		$this->load->model('Customers_model');
		if ( ! $this->Customers_model->validateCustomer($customer_id)) {
        	$this->form_validation->set_message('_check_customer', 'The %s entered can not be found');
			return FALSE;
		} else {
			return TRUE;
		}
	}

}

/* End of file reviews.php */
/* Location: ./admin/controllers/reviews.php */