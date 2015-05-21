<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reviews extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Reviews_model');													// loads messages model
		$this->lang->load('account/reviews');
	}

	public function index() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

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
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reviews');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_view'] 				= $this->lang->line('text_view');
		$data['text_empty'] 			= $this->lang->line('text_empty');
		$data['column_sale_id'] 		= $this->lang->line('column_sale_id');
		$data['column_sale_type'] 		= $this->lang->line('column_sale_type');
		$data['column_restaurant'] 		= $this->lang->line('column_restaurant');
		$data['column_rating'] 			= $this->lang->line('column_rating');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_action'] 			= $this->lang->line('column_action');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('account/account');

		$ratings = $this->config->item('ratings');

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
				'date'				=> mdate('%d %M %y', strtotime($result['date_added'])),
				'view' 				=> site_url('account/reviews/view/'. $result['review_id'])
			);
		}

		$prefs['base_url'] 			= site_url('account/reviews').$url;
		$prefs['total_rows'] 		= $this->Reviews_model->getCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('account/reviews', $data);
	}

	public function view() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		$review_id = (int)$this->uri->rsegment(3);

		$result = $this->Reviews_model->getReview($review_id, $this->customer->getId());								// retrieve specific customer message based on message id to be passed to view
		if ( ! $result) {																		// check if customer_id is set in uri string
  			redirect('account/reviews');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reviews');
		$this->template->setBreadcrumb($this->lang->line('text_view_review'), 'account/reviews/view');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_view_review'));
		$this->template->setHeading($this->lang->line('text_view_review'));
		$data['text_heading'] 			= $this->lang->line('text_view_review');
		$data['column_date'] 			= $this->lang->line('column_date');
		$data['column_time'] 			= $this->lang->line('column_time');
		$data['column_subject'] 		= $this->lang->line('column_subject');
		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('account/reviews');

		$ratings = $this->config->item('ratings');

		$data['location_name'] 		= $result['location_name'];
		$data['sale_id'] 			= $result['sale_id'];
		$data['sale_type'] 			= $result['sale_type'];
		$data['author'] 			= $result['author'];
		$data['quality'] 			= $result['quality'];
		$data['delivery'] 			= $result['delivery'];
		$data['service'] 			= $result['service'];
		$data['date'] 				= mdate('%H:%i - %d %M %y', strtotime($result['date_added']));
		$data['review_text'] 		= $result['review_text'];

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('account/review_view', $data);
	}

	public function add() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		$sale_type 		= $this->uri->rsegment(3);
		$sale_id 		= $this->uri->rsegment(4);
		$location_id 	= $this->uri->rsegment(5);

		$data['action']	= site_url('account/reviews/add/'. $sale_type .'/'. $sale_id .'/'. $location_id);

		if ($this->Reviews_model->checkReviewed($sale_type, $sale_id, $this->customer->getId())) {
			$this->alert->set('alert', $this->lang->line('alert_duplicate'));
  			redirect('account/reviews');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reviews');
		$this->template->setBreadcrumb($this->lang->line('text_write_review'), 'account/reviews/add');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_write_review'));
		$this->template->setHeading($this->lang->line('text_write_review'));
		$data['text_heading'] 			= $this->lang->line('text_write_review');
		$data['entry_customer_name'] 	= $this->lang->line('entry_customer_name');
		$data['entry_restaurant'] 		= $this->lang->line('entry_restaurant');
		$data['entry_quality'] 			= $this->lang->line('entry_quality');
		$data['entry_delivery'] 		= $this->lang->line('entry_delivery');
		$data['entry_service'] 			= $this->lang->line('entry_service');
		$data['entry_review'] 			= $this->lang->line('entry_review');
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_review'] 			= $this->lang->line('button_review');
		// END of retrieving lines from language file to send to view.

		$data['back'] 					= site_url('account/reviews');

		$data['customer_id'] = $this->customer->getId();									// retriveve customer id from customer library
		$data['customer_name'] = $this->customer->getFirstName() .' '. $this->customer->getLastName(); // retrieve and concatenate customer's first and last name from customer library

		$this->load->model('Locations_model');
		$result = $this->Locations_model->getLocation($location_id);

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

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
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
				$this->alert->set('alert', $this->lang->line('alert_success'));
			} else {
				$this->alert->set('alert', $this->lang->line('alert_error'));
			}

			return TRUE;
		} else {
			return FALSE;
		}
	}

	private function validateForm() {
		$this->form_validation->set_rules('location_id', 'Location', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('customer_id', 'Author', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[quality]', 'Quality Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[delivery]', 'Delivery Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('rating[service]', 'Service Rating', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('review_text', 'Rating Text', 'xss_clean|trim|required|min_length[2]|max_length[1028]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reviews.php */
/* Location: ./main/controllers//reviews.php */