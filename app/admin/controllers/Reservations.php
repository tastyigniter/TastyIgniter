<?php namespace Admin\Controllers;

use AdminAuth;
use AdminMenu;
use Template;

class Reservations extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Reservations_model',
            'title'        => 'lang:admin::reservations.text_title',
            'emptyMessage' => 'lang:admin::reservations.text_empty',
            'defaultSort'  => ['date_added', 'DESC'],
            'configFile'   => 'reservations_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::reservations.text_form_name',
        'model'      => 'Admin\Models\Reservations_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'reservations/edit/{reservation_id}',
            'redirectClose' => 'reservations',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'reservations',
        ],
        'delete'     => [
            'redirect' => 'reservations',
        ],
        'configFile' => 'reservations_model',
    ];

    protected $requiredPermissions = 'Admin.Reservations';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('reservations', 'sales');
    }

    public function edite()
    {
        if (post() AND $reservation_id = $this->_updateReservation()) {
            return $this->redirect($reservation_id);
        }

        $reservation_info = $this->Reservations_model->getReservation((int)get('id'));

        $title = (isset($reservation_info['reservation_id'])) ? $reservation_info['reservation_id'] : $this->lang->line('text_new');
        Template::setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        Template::setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        Template::setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
        Template::setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
        Template::setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => admin_url('reservations')]);

        $data = $this->getForm($reservation_info);

        Template::render('reservations/edit', $data);
    }

    public function getList()
    {
        if ($data['user_strict_location'] = AdminAuth::isStrictLocation()) {
            $this->setFilter('filter_location', AdminAuth::getLocationId());
        }

        $data = array_merge($this->getFilter(), $this->getSort(), $data, $this->getCalendar());

        $data['reservations'] = [];
        $results = $this->Reservations_model->paginateWithFilter($this->getFilter());
        foreach ($results->list as $result) {
            $data['reservations'][] = array_merge($result, [
                'reserve_date' => day_elapsed($result['reserve_date']),
                'reserve_time' => mdate('%H:%i', strtotime($result['reserve_time'])),
                'edit'         => $this->pageUrl($this->edit_url, ['id' => $result['reservation_id']]),
            ]);
        }

        $data['pagination'] = $results->pagination;

        $data['locations'] = $this->Locations_model->isEnabled()->dropdown('location_name');

        $data['statuses'] = $this->Statuses_model->isForReservation()->dropdown('status_name');

        $data['reserve_dates'] = $this->Reservations_model->getReservationDates();

        return $data;
    }

    public function getForm($reservation_info = [])
    {
        $data = $reservation_info;

        if (!empty($reservation_info['reservation_id'])) {
            $reservation_id = $reservation_info['reservation_id'];
            $data['_action'] = $this->pageUrl($this->edit_url, ['id' => $reservation_id]);
        }
        else {
            $reservation_id = 0;

            //$data['_action']	= $this->pageUrl($this->create_url);
            return $this->redirectBack();
        }

        AdminAuth::restrictLocation($reservation_info['location_id'], 'Admin.Reservations', $this->index_url);

        $data['min_capacity'] = $reservation_info['min_capacity'].' '.$this->lang->line('column_guest');;
        $data['max_capacity'] = $reservation_info['max_capacity'].' '.$this->lang->line('column_guest');;
        $data['guest_num'] = $reservation_info['guest_num'].' '.$this->lang->line('column_guest');;
        $data['occasion'] = $reservation_info['occasion_id'];
        $data['reserve_time'] = mdate('%H:%i', strtotime($reservation_info['reserve_time']));
        $data['reserve_date'] = mdate('%d %M %y', strtotime($reservation_info['reserve_date']));
        $data['date_added'] = mdate('%d %M %y', strtotime($reservation_info['date_added']));
        $data['date_modified'] = mdate('%d %M %y', strtotime($reservation_info['date_modified']));
        $data['status_id'] = $reservation_info['status'];

        $data['occasions'] = [
            '0' => 'not applicable',
            '1' => 'birthday',
            '2' => 'anniversary',
            '3' => 'general celebration',
            '4' => 'hen party',
            '5' => 'stag party',
        ];

        $data['staffs'] = $this->Staffs_model->isEnabled()->dropdown('staff_name');

        $data['statuses'] = $this->Statuses_model->isForReservation()->dropdown('status_name');

        $data['status_history'] = [];
        $status_history = $this->Statuses_model->getStatusHistories('reserve', $reservation_id);
        foreach ($status_history as $history) {
            $data['status_history'][] = array_merge($history, [
                'history_id' => $history['status_history_id'],
                'date_time'  => mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
            ]);
        }

        return $data;
    }

    public function _status_exists($str)
    {
        $reserve_status_exists = $this->Statuses_model->statusExists('reserve', get('id'), $str);
        if ($reserve_status_exists) {
            $this->form_validation->set_message('_status_exists', $this->lang->line('error_status_exists'));

            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    protected function getCalendar()
    {
        $data['calendar'] = '';

        if (get('show_calendar') == '1') {
            $day = (!$this->getFilter('filter_day')) ? date('d', time()) : $this->getFilter('filter_day');
            $month = (!$this->getFilter('filter_month')) ? date('m', time()) : $this->getFilter('filter_month');
            $year = (!$this->getFilter('filter_year')) ? date('Y', time()) : $this->getFilter('filter_year');

            $data['days'] = $this->calendar->get_total_days($month, $year);
            $data['months'] = ['01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
            $data['years'] = ['2011', '2012', '2013', '2014', '2015', '2016', '2017'];

            $calendar_data = $this->getCalendarData($data['days'], $month, $year, $day);

            Template::setButton('<i class="fa fa-list"></i>', [
                'title' => $this->lang->line('text_switch_to_list'),
                'class' => 'btn btn-default', 'href' => admin_url('reservations/'),
            ]);
            $data['calendar'] = $this->calendar->generate($year, $month, $calendar_data);
        }
        else {
            Template::setButton('<i class="fa fa-calendar"></i>', [
                'title' => $this->lang->line('text_switch_to_calendar'),
                'class' => 'btn btn-default', 'href' => admin_url('reservations?show_calendar=1'),
            ]);
        }

        return $data;
    }

    protected function getCalendarData($days, $month, $year, $day)
    {
        $total_tables = $this->Reservations_model->getTotalCapacityByLocation($this->filter['filter_location']);

        $reserve_dates = [];
        for ($i = 1; $i <= $days; $i++) {
            $reserve_dates[] = mdate('%Y-%m-%d', strtotime($year.'-'.$month.'-'.$i));
        }

        $calendar_data = [];
        $total_guests = $this->Reservations_model->getTotalGuestsByLocation($this->filter['filter_location'], $reserve_dates);
        foreach ($reserve_dates as $date) {
            $state = 'no_booking';
            if (isset($total_guests[$date]) AND $total_guest = $total_guests[$date]) {
                if ($total_guest > 0 AND $total_guest < $total_tables) {
                    $state = 'half_booked';
                }
                else if ($total_guest >= $total_tables) {
                    $state = 'booked';
                }
            }

            if (mdate('%d', strtotime($date)) == $day) {
                $state .= ' selected';
            }

            $calendar_data[mdate('%j', strtotime($date))] = $state;
        }

        $url = array_diff_key(array_filter(get()), array_flip(['filter_day', 'filter_month', 'filter_year']));
        $calendar_data['url'] = $this->pageUrl();
        $calendar_data['url_suffix'] = '?'.http_build_query($url).'&';

        return $calendar_data;
    }

    protected function _updateReservation()
    {
        if (is_numeric(get('id')) AND $this->validateForm() === TRUE) {
            if ($reservation_id = $this->Reservations_model->updateReservation(get('id'), post())) {
                log_activity(AdminAuth::getStaffId(), 'updated', 'reservations', get_activity_message('activity_custom',
                    ['{staff}', '{action}', '{context}', '{link}', '{item}'],
                    [AdminAuth::getStaffName(), 'updated', 'reservation', current_url(), get('id')]
                ));

                if (post('old_assignee_id') !== post('assignee_id') OR post('old_status_id') !== post('status_id')) {
                    $staff = $this->Staffs_model->getStaff(post('assignee_id'));
                    $staff_assignee = $this->pageUrl('staffs/edit?id='.$staff['staff_id']);

                    log_activity(AdminAuth::getStaffId(), 'assigned', 'reservations', get_activity_message('activity_assigned',
                        ['{staff}', '{action}', '{context}', '{link}', '{item}', '{assignee}'],
                        [AdminAuth::getStaffName(), 'assigned', 'reservation', current_url(), get('id'), "<a href=\"{$staff_assignee}\">{$staff['staff_name']}</a>"]
                    ));
                }

                flash()->success(sprintf($this->lang->line('alert_success'), 'Reservation updated'));
            }
            else {
                flash()->warning(sprintf($this->lang->line('alert_error_nothing'), 'updated'));
            }

            return $reservation_id;
        }
    }

    protected function _deleteReservation()
    {
        if (post('delete')) {
            $deleted_rows = $this->Reservations_model->deleteReservation(post('delete'));
            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Reservations' : 'Reservation';
                flash()->success(sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            }
            else {
                flash()->warning(sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        $rules[] = ['status', 'lang:admin::default.label_status', 'required|integer|callback__status_exists'];
        $rules[] = ['assignee_id', 'lang:admin::reservations.label_assign_staff', 'integer'];

        return $this->validatePasses($rules)->run();
    }
}