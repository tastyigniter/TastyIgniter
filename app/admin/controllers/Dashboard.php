<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Dashboard extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->load->model('Dashboard_model');
        $this->load->model('Locations_model');
        $this->load->model('Themes_model');
        $this->load->model('Updates_model');

        $this->load->library('currency'); // load the currency library

		$this->lang->load('dashboard');
	}

	public function index() {
		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_check_updates'), array('class' => 'btn btn-default', 'href' => site_url('updates')));

        $this->template->setStyleTag(assets_url('js/daterange/daterangepicker-bs3.css'), 'daterangepicker-css', '100400');
        $this->template->setScriptTag(assets_url('js/daterange/moment.min.js'), 'daterange-moment-js', '1000451');
        $this->template->setScriptTag(assets_url('js/daterange/daterangepicker.js'), 'daterangepicker-js', '1000452');
        $this->template->setStyleTag(assets_url('js/morris/morris.css'), 'chart-css', '100500');
        $this->template->setScriptTag(assets_url('js/morris/raphael-min.js'), 'raphael-min-js', '1000453');
        $this->template->setScriptTag(assets_url('js/morris/morris.min.js'), 'morris-min-js', '1000454');

		$data['total_menus'] 		    = $this->Dashboard_model->getTotalMenus();
		$data['current_month'] 			= mdate('%Y-%m', time());

		$data['months'] = array();
		$pastMonth = date('Y-m-d', strtotime(date('Y-m-01') .' -3 months'));
		$futureMonth = date('Y-m-d', strtotime(date('Y-m-01') .' +3 months'));
		for ($i = $pastMonth; $i <= $futureMonth; $i = date('Y-m-d', strtotime($i .' +1 months'))) {
			$data['months'][mdate('%Y-%m', strtotime($i))] = mdate('%F', strtotime($i));
		}

		$data['default_location_id'] = $this->config->item('default_location_id');

		$data['locations'] = array();
		$results = $this->Locations_model->getLocations();
		foreach ($results as $result) {
			$data['locations'][] = array(
				'location_id'	=>	$result['location_id'],
				'location_name'	=>	$result['location_name'],
			);
		}

        $filter = array();
        $filter['page'] = '1';
        $filter['limit'] = '5';

        $data['activities'] = array();
        $this->load->model('Activities_model');
        $results = $this->Activities_model->getList($filter);
        foreach ($results as $result) {
            $data['activities'][] = array(
                'activity_id'	    => $result['activity_id'],
                'icon'			    => 'fa fa-tasks',
                'message'			=> $result['message'],
                'time'		        => mdate('%h:%i %A', strtotime($result['date_added'])),
                'time_elapsed'		=> time_elapsed($result['date_added']),
                'state'			    => $result['status'] === '1' ? 'read' : 'unread',
            );
        }

        $data['top_customers'] = array();
		$filter['limit'] = 6;
		$results = $this->Dashboard_model->getTopCustomers($filter);
        foreach ($results as $result) {
            $data['top_customers'][] = array(
                'first_name'	    => $result['first_name'],
                'last_name'	    	=> $result['last_name'],
                'total_orders'		=> $result['total_orders'],
                'total_sale'		=> $this->currency->format($result['total_sale']),
            );
        }

        $filter = array();
		$filter['page'] = '1';
		$filter['limit'] = 10;
		$filter['sort_by'] = 'orders.date_added';
		$filter['order_by'] = 'DESC';
		$data['order_by_active'] = 'DESC';

		if ($this->user->isStrictLocation()) {
			$filter['filter_location'] = $this->user->getLocationId();
		}

		$data['orders'] = array();
        $this->load->model('Orders_model');
        $results = $this->Orders_model->getList($filter);
		foreach ($results as $result) {
			$current_date = mdate('%d-%m-%Y', time());
			$date_added = mdate('%d-%m-%Y', strtotime($result['date_added']));

			if ($current_date === $date_added) {
				$date_added = $this->lang->line('text_today');
			} else {
				$date_added = mdate('%d %M %y', strtotime($date_added));
			}

			$data['orders'][] = array(
				'order_id'			=> $result['order_id'],
				'location_name'		=> $result['location_name'],
				'first_name'		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
                'order_status'		=> $result['status_name'],
                'status_color'		=> $result['status_color'],
				'order_time'		=> mdate('%H:%i', strtotime($result['order_time'])),
				'order_type' 		=> ($result['order_type'] === '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection'),
				'date_added'		=> $date_added,
				'edit' 				=> site_url('orders/edit?id=' . $result['order_id'])
			);
		}

		$data['news_feed'] = $this->Dashboard_model->getNewsFeed();  // Get four items from the feed

		if ($this->config->item('auto_update_currency_rates') === '1') {
			$this->load->model('Currencies_model');
			if ($this->Currencies_model->updateRates()) {
				$this->alert->set('success_now', $this->lang->line('alert_rates_updated'));
			}
		}

		if ( ! $this->Updates_model->lastVersionCheck()) {
			$this->alert->set('success_now', sprintf($this->lang->line('text_last_version_check'), site_url('updates')));
		}

		$this->template->render('dashboard', $data);
	}

	public function statistics() {
		$json = array();

		$stat_range = 'today';
		if ($this->input->get('stat_range')) {
			$stat_range = $this->input->get('stat_range');
		}

		$result = $this->Dashboard_model->getStatistics($stat_range);
		$json['sales'] 				= (empty($result['sales'])) ? $this->currency->format('0.00') : $this->currency->format($result['sales']);
		$json['lost_sales'] 		= (empty($result['lost_sales'])) ? $this->currency->format('0.00') : $this->currency->format($result['lost_sales']);
		$json['cash_payments'] 		= (empty($result['cash_payments'])) ? $this->currency->format('0.00') : $this->currency->format($result['cash_payments']);
		$json['customers'] 			= (empty($result['customers'])) ? '0' : $result['customers'];
		$json['orders'] 			= (empty($result['orders'])) ? '0' : $result['orders'];
		$json['orders_completed'] 	= (empty($result['orders_completed'])) ? '0' : $result['orders_completed'];
		$json['delivery_orders'] 	= (empty($result['delivery_orders'])) ? '0' : $result['delivery_orders'];
		$json['collection_orders'] 	= (empty($result['collection_orders'])) ? '0' : $result['collection_orders'];
		$json['tables_reserved'] 	= (empty($result['tables_reserved'])) ? '0' : $result['tables_reserved'];

		$this->output->set_output(json_encode($json));
	}

	public function chart() {
		$json = array();
		$results = array();

        $json['labels'] = array('Total Customers', 'Total Orders', 'Total Reservations', 'Total Reviews');
        $json['colors'] = array('#63ADD0', '#5CB85C', '#337AB7', '#D9534F');

        $dateRanges = '1';
        if ($this->input->get('start_date') AND $this->input->get('start_date') !== 'undefined') {
            if ($this->input->get('end_date') AND $this->input->get('end_date') !== 'undefined') {
                $dateRanges = $this->getDatesFromRange($this->input->get('start_date'), $this->input->get('end_date'));
            }
        }

        $timestamp = strtotime($this->input->get('start_date'));

        if (count($dateRanges) <= 1) {
            for ($i = 0; $i < 24; $i++) {
                $data = $this->Dashboard_model->getTodayChart($i);
                $data['time'] = mdate('%H:%i', mktime($i, 0, 0, date('n', $timestamp), date('j', $timestamp), date('Y', $timestamp)));
                $results[] = $data;
            }
        } else {
            for ($i = 0; $i < count($dateRanges); $i++) {
                $data = $this->Dashboard_model->getDateChart($dateRanges[$i]);
                $data['time'] = mdate('%d %M', strtotime($dateRanges[$i]));
                $results[] = $data;
            }
        }

		if (!empty($results)) {
            foreach ($results as $key => $value) {
                $json['data'][] = $value;
            }
        }

		$this->output->set_output(json_encode($json));
	}

    private function getDatesFromRange($start, $end) {
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(
            new DateTime($start),
            $interval,
            $realEnd
        );

        foreach($period as $date) {
            $array[] = $date->format('Y-m-d');
        }

        return $array;
    }

    public function admin() {
		$this->index();
	}
}

/* End of file dashboard.php */
/* Location: ./admin/controllers/dashboard.php */