<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Activities extends Admin_Controller
{

    public $filter = [
        'filter_status' => '',
    ];

    public $default_sort = ['date_added', 'DESC'];

    public function __construct()
    {
        parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Activities');

        $this->load->model('Activities_model');

        $this->lang->load('activities');
    }

    public function index()
    {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));

        $data = $this->getList();

        $this->template->render('activities', $data);
    }

    public function latest()
    {
        $this->setFilter(['page' => '1', 'limit' => '10']);

        $data['activities'] = [];
        foreach ($this->getList()['activities'] as $activities) {
            foreach ($activities as $activity) {
                $data['activities'][] = $activity;
            }
        }

        $this->template->render('activities_latest', $data);
    }

    public function recent()
    {
        $this->setFilter(['page' => '1', 'limit' => '10']);

        $data['activities'] = [];
        foreach ($this->getList()['activities'] as $activities) {
            foreach ($activities as $activity) {
                $data['activities'][] = $activity;
            }
        }

        $this->template->render('activities', $data);
    }

    public function getList()
    {
        $data = $this->getFilter();

        $data['activities'] = [];
        $results = $this->Activities_model->paginateWithFilter($this->getFilter());
        foreach ($results->list as $result) {
            $result['day_elapsed'] = day_elapsed($result['date_added']);
            $data['activities'][$result['day_elapsed']][] = array_merge($result, [
                'time'         => mdate('%h:%i %A', strtotime($result['date_added'])),
                'time_elapsed' => time_elapsed($result['date_added']),
                'icon'         => 'fa fa-tasks',
                'state'        => $result['status'] == '1' ? 'read' : 'unread',
            ]);
        }

        $data['pagination'] = $results->pagination;

        return $data;
    }
}

/* End of file Activities.php */
/* Location: ./admin/controllers/Activities.php */