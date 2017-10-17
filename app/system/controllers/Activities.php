<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Activities extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Activities');

        $this->load->model('Activities_model');

        $this->load->library('pagination');

        $this->lang->load('activities');
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

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

		$data['activities'] = $activities = array();
		$results = $this->Activities_model->getList($filter);
		foreach ($results as $result) {
            $day_elapsed = day_elapsed($result['date_added']);

            $data['activities'][$day_elapsed][] = array(
				'activity_id'	    => $result['activity_id'],
				'domain'			=> $result['domain'],
				'action'			=> $result['action'],
				'icon'			    => 'fa fa-tasks',
				'message'			=> $result['message'],
                'time'		        => mdate('%h:%i %A', strtotime($result['date_added'])),
                'time_elapsed'		=> time_elapsed($result['date_added']),
                'day_elapsed'		=> $day_elapsed,
				'status'			=> $result['status'] === '1' ? 'read' : 'unread',
			);
		}

        $config['base_url'] 		= site_url('activities'.$url);
		$config['total_rows'] 		= $this->Activities_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('activities', $data);
	}

    public function latest() {
        $filter = array();
        $filter['page'] = '1';
        $filter['limit'] = '10';

        $data['activities'] = array();
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

        $this->template->render('activities_latest', $data);
    }

    public function recent() {
		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		$data['activities'] = array();
		$results = $this->Activities_model->getList($filter);
		foreach ($results as $result) {
			$data['activities'][] = array(
				'activity_id'	=> $result['activity_id'],
				'icon'				=> $result['icon'],
				'message'			=> $result['message'],
				'time'				=> $result['time'],
				'action'			=> $result['action'],
				'status'			=> $result['status'] === '1' ? 'read' : 'unread',
			);
		}

		$this->template->render('activities', $data);
	}
}

/* End of file activities.php */
/* Location: ./admin/controllers/activities.php */