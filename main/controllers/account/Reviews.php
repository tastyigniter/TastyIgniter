<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reviews extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
            redirect('account/login');
        }

        $this->load->model('Reviews_model');													// loads messages model

        $this->lang->load('account/reviews');

		if ($this->config->item('allow_reviews') === '1') {
			$this->alert->set('alert', $this->lang->line('alert_review_disabled'));
			redirect('account/account');
		}
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

        $filter['filter_status'] = '1';

        $this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reviews');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['back_url'] 					= site_url('account/account');

		//create array of ratings data to pass to view
		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';

		$data['reviews'] = array();
		$results = $this->Reviews_model->getList($filter);									// retrieve all customer reviews from getMainList method in Reviews model
		foreach ($results as $result) {
			$data['reviews'][] = array(															// create array of customer reviews to pass to view
				'sale_id'			=> $result['sale_id'],
				'sale_type'			=> $result['sale_type'],
				'location_name'		=> $result['location_name'],
				'quality' 			=> $result['quality'],
				'delivery' 			=> $result['delivery'],
				'service' 			=> $result['service'],
				'date'				=> mdate($date_format, strtotime($result['date_added'])),
				'view' 				=> site_url('account/reviews/view/'. $result['review_id'])
			);
		}

		$prefs['base_url'] 			= site_url('account/reviews'.$url);
		$prefs['total_rows'] 		= $this->Reviews_model->getCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('account/reviews', $data);
	}

	public function view() {
		$review_id = (int)$this->uri->rsegment(3);

		// retrieve specific customer message based on message id to be passed to view
		if ( ! ($result = $this->Reviews_model->getReview($review_id, $this->customer->getId()))) {																		// check if customer_id is set in uri string
  			redirect('account/reviews');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reviews');
		$this->template->setBreadcrumb($this->lang->line('text_view_review'), 'account/reviews/view');

		$this->template->setTitle($this->lang->line('text_view_review'));
		$this->template->setHeading($this->lang->line('text_view_review'));

		$data['back_url'] 					= site_url('account/reviews');

		//create array of ratings data to pass to view
		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['location_name'] 		= $result['location_name'];
		$data['sale_id'] 			= $result['sale_id'];
		$data['sale_type'] 			= $result['sale_type'];
		$data['author'] 			= $result['author'];
		$data['quality'] 			= $result['quality'];
		$data['delivery'] 			= $result['delivery'];
		$data['service'] 			= $result['service'];
		$data['date'] 				= mdate("{$time_format} - {$date_format}", strtotime($result['date_added']));
		$data['review_text'] 		= $result['review_text'];

		$this->template->render('account/review_view', $data);
	}

	public function add() {
		$data['_action']	= site_url('account/reviews/add/'. $this->uri->rsegment(3) .'/'. $this->uri->rsegment(4) .'/'. $this->uri->rsegment(5));

		if ($this->Reviews_model->checkReviewed($this->uri->rsegment(3), $this->uri->rsegment(4), $this->customer->getId())) {
			$this->alert->set('danger', $this->lang->line('alert_review_duplicate'));
  			redirect('account/reviews');
		}

		$this->load->model('Statuses_model');

		if ($this->uri->rsegment(3) === 'reservation') {
			$status_exists = $this->Statuses_model->statusExists('reserve', $this->uri->rsegment(4), $this->config->item('confirmed_reservation_status'));
		} else {
			$status_exists = $this->Statuses_model->statusExists('order', $this->uri->rsegment(4), $this->config->item('completed_order_status'));
		}

		if ($status_exists !== TRUE) {
			$this->alert->set('danger', $this->lang->line('alert_review_status_history'));
			redirect('account/reviews');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reviews');
		$this->template->setBreadcrumb($this->lang->line('text_write_review'), 'account/reviews/add');

		$this->template->setTitle($this->lang->line('text_write_review'));
		$this->template->setHeading($this->lang->line('text_write_review'));

		$data['back_url'] 				= site_url('account/reviews');

		$data['customer_id'] = $this->customer->getId();									// retriveve customer id from customer library
		$data['customer_name'] = $this->customer->getFirstName() .' '. $this->customer->getLastName(); // retrieve and concatenate customer's first and last name from customer library

		$this->load->model('Locations_model');
		$result = $this->Locations_model->getLocation($this->uri->rsegment(5));

		$data['location_id'] 			= $result['location_id'];
		$data['restaurant_name'] 		= $result['location_name'];

		//create array of ratings data to pass to view
		$ratings = $this->config->item('ratings');
		$data['ratings'] = $ratings['ratings'];

		if ($this->input->post('rating')) {
			$data['rating'] = $this->input->post('rating');
		} else {
			$data['rating'] = array('quality' => '0', 'delivery' => '0', 'service' => '0');
		}

		if ($this->input->post() AND $this->_addReview() === TRUE) {
			redirect('account/reviews');
		}

		$this->template->render('account/review_add', $data);
	}

	private function _addReview() {
		$add = array();

		if ($this->validateForm() === TRUE) {
			$add['sale_type'] 			= $this->uri->rsegment(3);
			$add['sale_id'] 			= (int)$this->uri->rsegment(4);
			$add['location_id'] 		= (int)$this->uri->rsegment(5);
			$add['customer_id'] 		= $this->input->post('customer_id');
			$add['author'] 				= $this->customer->getFirstName() .' '. $this->customer->getLastName();
			$add['rating'] 				= $this->input->post('rating');
			$add['review_text'] 		= $this->input->post('review_text');

			if ($this->Reviews_model->saveReview(NULL, $add)) {
				$this->alert->set('success', $this->lang->line('alert_review_success'));
			} else {
				$this->alert->set('danger', $this->lang->line('alert_review_error'));
			}

			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('location_id', 'lang:label_restaurant', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('customer_id', 'lang:label_author', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[quality]', 'lang:label_quality', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[delivery]', 'lang:label_delivery', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[service]', 'lang:label_service', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('review_text', 'lang:label_review', 'xss_clean|trim|required|min_length[2]|max_length[1028]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reviews.php */
/* Location: ./main/controllers/reviews.php */