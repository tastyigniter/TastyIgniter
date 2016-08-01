<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Reservations extends Main_Controller
{

	public $list_filters = array(
		'sort_by'  => 'reserve_date',
		'order_by' => 'DESC',
	);

	public function __construct() {
		parent::__construct();                                                                    //  calls the constructor

		if (!$this->customer->isLogged()) {                                                    // if customer is not logged in redirect to account login page
			$this->redirect('account/login');
		}

		$this->load->library('currency');                                                        // load the currency library

		$this->load->model('Reservations_model');                                                        // load orders model

		$this->lang->load('account/reservations');

		if ($this->config->item('reservation_mode') !== '1') {
			$this->alert->set('alert', $this->lang->line('alert_reservation_disabled'));
			$this->redirect('account/account');
		}
	}

	public function index() {
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reservations');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->list_filters['customer_id'] = (int)$this->customer->getId();

		$data['back_url'] = $this->pageUrl('account/account');
		$data['new_reservation_url'] = $this->pageUrl('reservation');

		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['reservations'] = array();
		$results = $this->Reservations_model->paginate($this->list_filters, 'account/reservations');                                // retrieve customer reservations based on customer id from getMainReservations method in Reservations model
		foreach ($results->list as $result) {
			$data['reservations'][] = array_merge($result, array(                                                    // create array of customer reservations to pass to view
				'reserve_date' => day_elapsed($result['reserve_date']),
				'reserve_time' => mdate($time_format, strtotime($result['reserve_time'])),
				'view'         => $this->pageUrl('account/reservations/view/' . $result['reservation_id']),
				'leave_review' => $this->pageUrl('account/reviews/add/reservation/' . $result['reservation_id'] . '/' . $result['location_id']),
			));
		}

		$data['pagination'] = $results->pagination;

		$this->template->render('account/reservations', $data);
	}

	public function view() {
		$this->load->library('country');
		$this->load->model('Locations_model');                                                        // load locations model

		$result = $this->Reservations_model->getReservation($this->uri->rsegment(3), $this->customer->getId());

		if (empty($result) OR empty($result['reservation_id']) OR empty($result['status']) OR $result['status'] <= 0) {                                                            // check if customer_id is set in uri string
			$this->redirect('account/reservations');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/reservations');
		$this->template->setBreadcrumb($this->lang->line('text_view_heading'), 'account/reservations/view');

		$this->template->setTitle($this->lang->line('text_view_heading'));
		$this->template->setHeading($this->lang->line('text_view_heading'));

		$data['back_url'] = $this->pageUrl('account/reservations');

		$date_format = ($this->config->item('date_format')) ? $this->config->item('date_format') : '%d %M %y';
		$time_format = ($this->config->item('time_format')) ? $this->config->item('time_format') : '%h:%i %a';

		$data['occasions'] = array(
			'0' => 'not applicable',
			'1' => 'birthday',
			'2' => 'anniversary',
			'3' => 'general celebration',
			'4' => 'hen party',
			'5' => 'stag party',
		);

		$data['reservation_id'] = $result['reservation_id'];
		$data['guest_num'] = $result['guest_num'] . ' person(s)';
		$data['reserve_date'] = mdate($date_format, strtotime($result['reserve_date']));
		$data['reserve_time'] = mdate($time_format, strtotime($result['reserve_time']));
		$data['occasion_id'] = $result['occasion_id'];
		$data['status_name'] = $result['status_name'];
		$data['table_name'] = $result['table_name'];

		$data['first_name'] = $result['first_name'];
		$data['last_name'] = $result['last_name'];
		$data['email'] = $result['email'];
		$data['telephone'] = $result['telephone'];
		$data['comment'] = $result['comment'];

		$location_address = $this->Locations_model->getAddress($result['location_id']);
		$data['location_name'] = $location_address['location_name'];
		$data['location_address'] = $this->country->addressFormat($location_address);

		$this->template->render('account/reservations_view', $data);
	}
}

/* End of file Reservations.php */
/* Location: ./main/controllers/Reservations.php */