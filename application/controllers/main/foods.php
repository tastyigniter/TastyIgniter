<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Foods extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Foods_model');
	}

	public function index() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later

		//check if file exists in views
		if ( !file_exists('application/views/main/foods.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$data['category_id'] = $this->uri->segment(3, FALSE);
		
		$data['heading'] = 'View Menu';
		$data['text_no_foods'] = 'There are no foods in the selected category.';
				
		$data['continue'] = $this->config->site_url('foods');
		$data['checkout'] = $this->config->site_url('checkout');
		
		$this->load->library('currency');
		
		$data['quantities'] = $this->Foods_model->getQuantities();

		//load foods data into array	
		$data['foods'] = array();		
		$results = $this->Foods_model->getMainFoods($data['category_id']);
		foreach ($results as $result) {

			if ($result['food_photo']) {
				$food_photo_src = $this->config->base_url('assets/img/' . $result['food_photo']);
			} else {
				$food_photo_src = $this->config->base_url('assets/img/no_food_photo.png');
			}

			$data['foods'][] = array(
				'food_id'			=>	$result['food_id'],
				'food_name'			=>	$result['food_name'],
				'category_name'		=>	$result['category_name'],
				'food_price'		=>	$this->currency->symbol() . $result['food_price'],
				'has_option_id'		=>	unserialize($result['food_option']),
				'food_photo'		=>	$food_photo_src,
				'review_href' 		=> $this->config->site_url('foods/review/' . $result['food_id'])
			);
		}	

		$data['food_options'] = array();
		$results = $this->Foods_model->getFoodOptions();
		foreach ($results as $result) {
			$data['food_options'][] = array(
				'option_id' 	=> $result['option_id'],
				//'food_id' 		=> $result['food_id'],
				'option_name' 	=> $result['option_name'],
				'option_price' 	=> $this->currency->symbol() . $result['option_price']
			);
		}
														
		//load category data into array
		$data['categories'] = array();
		$results = $this->Foods_model->getCategories();
		foreach ($results as $result) {					
			$data['categories'][] = array(
				'category_id'	=>	$result['category_id'],
				'category_name'	=>	$result['category_name'],
				'href'			=>	$this->config->site_url('foods/category/' . $result['category_id'])
			);
		}
		
		$this->load->model('Reviews_model');
		//load ratings data into array
		$data['ratings'] = array();
		$results = $this->Reviews_model->getRatings();
		foreach ($results as $result) {					
			$data['ratings'][] = array(
				'rating_id'		=>	$result['rating_id'],
				'rating_name'	=>	$result['rating_name']
			);
		}

		//Location Settings
		$this->load->library('location');
		$data['nearest_location'] = $this->location->nearest();

		$this->load->model('Locations_model');

		$data['locations'] = array();

		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {					
			$data['locations'][] = array(
				'location_id'			=>	$result['location_id'],
				'location_name'			=>	$result['location_name'],
				'location_address'		=>	$result['location_address'],
				'location_region'		=>	$result['location_region'],
				'location_postcode'		=>	$result['location_postcode'],
				'location_phone_number'	=>	$result['location_phone_number']
			);
		}

		$this->load->view('main/header', $data);
		$this->load->view('main/foods', $data);
		$this->load->view('main/footer');
	}

	public function review() {
		$this->load->model('Reviews_model');

		$json = array();
		
		// Update Cart
		if (!$json) {

			$food_id = $this->input->post('food_id');
			$rating_id = $this->input->post('rating');
								
			if ( ! $this->customer->islogged()) {  
				
				$json['error'] = 'Error: Please login to rate foods';
				
			} else {
				
				$customer_id = $this->customer->getId();
				
				if ($this->Reviews_model->foodReview($food_id, $customer_id, $rating_id)) {
					
					$json['success'] = 'Rated!';
				
				}
			
			}
		}

		$this->output->set_output(json_encode($json));
	}	
}