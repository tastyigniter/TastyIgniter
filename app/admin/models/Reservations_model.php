<?php namespace Admin\Models;

use Model;

/**
 * Reservations Model Class
 *
 * @package Admin
 */
class Reservations_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'reservations';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'reservation_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_modified';

    public $relation = [
        'belongsTo' => [
            'reserved_table' => ['Admin\Models\Tables_model', 'foreignKey' => 'table_id'],
            'location'       => 'Admin\Models\Locations_model',
            'status'         => ['Admin\Models\Statuses_model', 'foreignKey' => 'status'],
            'staffs'         => ['Admin\Models\Staffs_model', 'foreignKey' => 'assignee_id'],
        ],
        'morphMany' => [
            'status_history' => ['Admin\Models\Status_history_model', 'name' => 'object'],
        ],
    ];

    public static $allowedSortingColumns = [
        'reservation_id asc', 'reservation_id desc',
        'reserve_date asc', 'reserve_date desc',
    ];

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page'      => 1,
            'pageLimit' => 20,
            'sort'      => 'address_id desc',
            'customer'  => null,
            'location'  => null,
        ], $options));

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, self::$allowedSortingColumns)) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query->paginate($pageLimit, $page);
    }

    public function scopeSelectQuery($query)
    {
        if (APPDIR === ADMINDIR) {
//            $query->select('*, reservations.date_added, reservations.date_modified, reservations.status, tables.table_id, staffs.staff_id, locations.location_id');
//        } else {
//            $query->select('reservation_id, table_name, reservations.location_id, location_name, location_address_1, location_address_2, location_city, location_postcode, location_country_id, table_name, min_capacity, max_capacity, guest_num, occasion_id, customer_id, first_name, last_name, telephone, email, reserve_time, reserve_date, status_name, reservations.date_added, reservations.date_modified, reservations.status, comment, notify, ip_address, user_agent');
        }

        return $query;
    }

    public function scopeJoinSelectTables($query)
    {
        $query->join('tables', 'tables.table_id', '=', 'reservations.table_id', 'left');
        $query->join('locations', 'locations.location_id', '=', 'reservations.location_id', 'left');
        $query->join('statuses', 'statuses.status_id', '=', 'reservations.status', 'left');

        if (APPDIR === ADMINDIR) {
            $query->join('staffs', 'staffs.staff_id', '=', 'reservations.assignee_id', 'left');
        }

        return $query;
    }

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        $query->joinSelectTables();

        if (APPDIR === ADMINDIR) {
            if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
                $query->search($filter['filter_search'], [
                    'reservation_id', 'location_name', 'first_name', 'last_name',
                    'table_name', 'staff_name',
                ]);
            }

            if (!empty($filter['filter_status'])) {
                $query->where('reservations.status', $filter['filter_status']);
            }

            if (!empty($filter['filter_location'])) {
                $query->where('reservations.location_id', $filter['filter_location']);
            }

            if (!empty($filter['filter_date'])) {
                $date = explode('-', $filter['filter_date']);
                $query->whereYear('reserve_date', $date[0]);
                $query->whereMonth('reserve_date', $date[1]);

                if (isset($date[2])) {
                    $query->whereDay('reserve_date', (int)$date[2]);
                }
            }
            else if (!empty($filter['filter_year']) AND !empty($filter['filter_month']) AND !empty($filter['filter_day'])) {
                $query->whereYear('reserve_date', $filter['filter_year']);
                $query->whereMonth('reserve_date', $filter['filter_month']);
                $query->whereDay('reserve_date', $filter['filter_day']);
            }
            else if (!empty($filter['filter_year']) AND !empty($filter['filter_month'])) {
                $query->whereYear('reserve_date', $filter['filter_year']);
                $query->whereMonth('reserve_date', $filter['filter_month']);
            }
        }
        else if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
            $query->where('customer_id', $filter['customer_id']);
        }

        return $query;
    }

    //
    // Accessors & Mutators
    //

    public function getCustomerNameAttribute($value)
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getReservationDateTimeAttribute($value)
    {
        return $this->order_date.' '.$this->order_time;
    }

    //
    // Helpers
    //

    public function getStatusColor()
    {
        $status = $this->status()->first();
        if (!$status)
            return null;

        return $status->status_color;
    }

    public function getOccasionOptions()
    {
        return [
            'not applicable',
            'birthday',
            'anniversary',
            'general celebration',
            'hen party',
            'stag party',
        ];
    }

    public function getOccasionAttribute()
    {
        $occasions = $this->getOccasionOptions();

        return isset($occasions[$this->occasion_id]) ? $occasions[$this->occasion_id] : $occasions[0];
    }

    public function getTableNameAttribute()
    {
        return isset($this->reserved_table) ? $this->reserved_table->table_name : null;
    }

    /**
     * Return all reservations
     *
     * @return array|bool
     */
    public function getReservations()
    {
        return $this->orderBy('reservation_id')->joinSelectTables()->get();
    }

    /**
     * Find a single reservation by reservation_id
     *
     * @param int $reservation_id
     * @param int $customer_id
     *
     * @return array
     */
    public function getReservation($reservation_id = null, $customer_id = null)
    {
        if ($reservation_id !== FALSE) {
            $query = $this->selectQuery()->joinSelectTables();

            if (APPDIR === MAINDIR AND $customer_id !== FALSE) {
                $query->where('customer_id', $customer_id);
            }

            return $query->findOrNew($reservation_id)->toArray();
        }
    }

    /**
     * Return the dates of all reservations
     *
     * @return array
     */
    public function getReservationDates()
    {
        return $this->pluckDates('reserve_date');
    }

    /**
     * Return maximum table capacity by location_id
     *
     * @param int $location_id
     *
     * @return int
     */
    public function getTotalCapacityByLocation($location_id = null)
    {
        $result = 0;

        $tablesTable = $this->getTablePrefix('tables');

        $this->load->model('Location_tables_model');
        $query = $this->Location_tables_model->selectRaw("SUM({$tablesTable}.max_capacity) as total_seats");

        if (!empty($location_id)) {
            $query->where('location_id', $location_id);
        }

        $query->join('tables', 'tables.table_id', '=', 'location_tables.table_id', 'left');

        $row = $query->first();
        if (!empty($row['total_seats'])) {
            $result = $row['total_seats'];
        }

        return $result;
    }

    /**
     * Return total reserved guest by location_id
     *
     * @param int $location_id
     * @param string|array $dates
     *
     * @return int
     */
    public function getTotalGuestsByLocation($location_id = null, $dates = null)
    {
        $result = [];

        $reservationsTable = $this->getTablePrefix('reservations');
        $query = $this->selectRaw("reserve_date, SUM({$reservationsTable}.guest_num) as total_guest, DAY(reserve_date) as reserve_day");
        //$query->where('status', (int)$this->config->item('default_reservation_status'));

        if (!empty($location_id)) {
            $query->where('location_id', $location_id);
        }

        if (!empty($dates)) {
            $dates = !is_array($dates) ? [$dates] : $dates;
            $query->whereDate('reserve_date', $dates);
        }

        $query->groupBy('reserve_day');

        if ($rows = $query->get()) {
            foreach ($rows as $row) {
                $result[$row['reserve_date']] = $row['total_guest'];
            }
        }

        return $result;
    }

    /**
     * Return all location tables by location_id and,
     * group by minimum table capacity
     *
     * @param int $location_id
     * @param int $guest_num
     *
     * @return array
     */
    public function getLocationTablesByMinCapacity($location_id, $guest_num)
    {
        $tables = [];

        if (isset($location_id, $guest_num)) {
            $this->load->model('Location_tables_model');

            $query = $this->Location_tables_model->where('location_id', $location_id)->where('table_status', '1');

            $query->where(function ($query) use ($guest_num) {
                $query->where('min_capacity', '<=', $guest_num);
                $query->where('max_capacity', '>=', $guest_num);
            });

            $query->orderBy('min_capacity');

            $query->join('tables', 'tables.table_id', '=', 'reservations.table_id', 'left');

            if ($rows = $query->get()) {
                foreach ($rows as $row) {
                    $tables[$row['table_id']] = $row;
                }
            }
        }

        return $tables;
    }

    /**
     * Find a single table available for reservation
     *
     * @param array $find
     *
     * @return array|string
     */
    public function findATable($find = [])
    {

        if (!isset($find['location']) OR !isset($find['guest_num']) OR empty($find['reserve_date']) OR empty($find['reserve_time']) OR empty($find['time_interval'])) {
            return 'NO_ARGUMENTS';
        }

        if (!($available_tables = $this->getLocationTablesByMinCapacity($find['location'], $find['guest_num']))) {
            return 'NO_TABLE';
        }

        $find['reserve_date_time'] = strtotime($find['reserve_date'].' '.$find['reserve_time']);
        $find['unix_start_time'] = strtotime('-'.($find['time_interval'] * 2).' mins', $find['reserve_date_time']);
        $find['unix_end_time'] = strtotime('+'.($find['time_interval'] * 2).' mins', $find['reserve_date_time']);

        $time_slots = time_range(mdate('%H:%i', $find['unix_start_time']), mdate('%H:%i', $find['unix_end_time']), $find['time_interval'], '%H:%i');
        $reserve_time_slot = array_flip($time_slots);

        $reserved_tables = $this->getReservedTableByDate($find, array_keys($available_tables));

        foreach ($reserved_tables as $reserved) {
            // remove available table if already reserved
            if (isset($available_tables[$reserved['table_id']])) {
                unset($available_tables[$reserved['table_id']]);
            }

            // remove reserve time slot if already reserved
            $reserve_time = mdate('%H:%i', strtotime($reserved['reserve_date'].' '.$reserved['reserve_time']));
            if (isset($reserve_time_slot[$reserve_time])) {
                unset($reserve_time_slot[$reserve_time]);
            }
        }

        if (empty($available_tables) OR empty($reserve_time_slot)) {
            return 'FULLY_BOOKED';
        }

        return ['table_found' => $available_tables, 'time_slots' => array_flip($reserve_time_slot)];
    }

    /**
     * Return all reserved tables by specified date
     *
     * @param array $find
     * @param int $table_id
     * @param bool $group
     *
     * @return array|bool
     */
    public function getReservedTableByDate($find = [], $table_id, $group = FALSE)
    {
        if (!isset($find['location']) OR !is_numeric($find['location']) OR empty($find['reserve_date']) OR empty($table_id)) {
            return FALSE;
        }

        $query = $this->where('location_id', $find['location']);

        is_array($table_id) OR $table_id = [$table_id];
        if (!empty($table_id)) {
            $query->whereIn('table_id', $table_id);
        }

        $query->where(function ($query) {
            $query->whereRaw('ADDTIME(reserve_date, reserve_time) >=', mdate('%Y-%m-%d %H:%i:%s', $find['unix_start_time']));
            $query->whereRaw('ADDTIME(reserve_date, reserve_time) <=', mdate('%Y-%m-%d %H:%i:%s', $find['unix_end_time']));
        });

        $results = [];
        if ($rows = $query->get()) {
            if ($group) {
                foreach ($rows as $row) {
                    $results[$row['table_id']][] = $row;
                }
            }
            else {
                $results = $rows;
            }
        }

        return $results;
    }

    /**
     * Return the total number of seats available by location_id
     *
     * @param int $location_id
     *
     * @return array
     */
    public function getTotalSeats($location_id)
    {
        $this->load->model('Location_tables_model');
        $query = $this->Location_tables_model->selectRaw("SUM(tables.max_capacity) as total_seats")
                                             ->where('location_id', $location_id);

        $query->join('tables', 'tables.table_id', '=', 'reservations.table_id', 'left');

        $row = $query->first();
        if (!empty($row['total_seats'])) {
            return $row['total_seats'];
        }
    }

    /**
     * Update an existing reservation
     *
     * @param int $reservation_id
     * @param array $update
     *
     * @return bool
     */
    public function updateReservation($reservation_id, $update = [])
    {
        if (empty($update)) return FALSE;

        if (is_numeric($reservation_id)) {
            $query = $this->find($reservation_id)->fill($update)->save();

            $status = $this->Statuses_model->getStatus($update['status']);

            if (isset($update['notify']) AND $update['notify'] == '1') {
                $mail_data = $this->getMailData($reservation_id);

                $mail_data['status_name'] = $status['status_name'];
                $mail_data['status_comment'] = !empty($update['status_comment']) ? $update['status_comment'] : lang('admin::reservations.text_no_comment');

                $this->load->model('Mail_templates_model');
                $mail_template = $this->Mail_templates_model->getDefaultTemplateData('reservation_update');
                $update['notify'] = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
            }

            if ($query === TRUE AND (int)$update['old_status_id'] !== (int)$update['status']) {
                $update['object_id'] = $reservation_id;
                $update['staff_id'] = AdminAuth::getStaffId();
                $update['status_id'] = (int)$update['status'];
                $update['comment'] = $update['status_comment'];
                $update['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());

                $this->Statuses_model->addStatusHistory('reserve', $update);
            }

            return TRUE;
        }
    }

    /**
     * Create a new reservation
     *
     * @param array $add
     *
     * @return bool
     */
    public function addReservation($add = [])
    {
        if (empty($add)) return FALSE;

        if (isset($add['reserve_date'])) {
            $add['reserve_date'] = mdate('%Y-%m-%d', strtotime($add['reserve_date']));
        }

        if ($reservation_id = $this->insertGetId($add)) {

            if (APPDIR === MAINDIR) {
                log_activity($add['customer_id'], 'reserved', 'reservations', get_activity_message('activity_reserved_table', ['{customer}', '{link}', '{reservation_id}'], [$add['first_name'].' '.$add['last_name'], admin_url('reservations/edit?id='.$reservation_id), $reservation_id]));
            }

            $notify = $this->sendConfirmationMail($reservation_id);

            $update = [
                'notify' => $notify,
                'status' => $this->config->item('default_reservation_status'),
            ];

            if ($this->where('reservation_id', $reservation_id)->update($update)) {
                $this->load->model('Statuses_model');
                $status = $this->Statuses_model->getStatus($this->config->item('default_reservation_status'));
                $reserve_history = [
                    'object_id'  => $reservation_id,
                    'status_id'  => $status['status_id'],
                    'notify'     => $notify,
                    'comment'    => $status['status_comment'],
                    'date_added' => mdate('%Y-%m-%d %H:%i:%s', time()),
                ];

                $this->Statuses_model->addStatusHistory('reserve', $reserve_history);
            }
        }

        return $reservation_id;
    }

    /**
     * Send the reservation confirmation email
     *
     * @param int $reservation_id
     *
     * @return string 0 on failure, or 1 on success
     */
    protected function sendConfirmationMail($reservation_id)
    {
        $this->load->model('Mail_templates_model');
        $mail_data = $this->getMailData($reservation_id);
        $config_reservation_email = is_array($this->config->item('reservation_email')) ? $this->config->item('reservation_email') : [];

        $notify = '0';
        if ($this->config->item('customer_reserve_email') == '1' OR in_array('customer', $config_reservation_email)) {
            $mail_template = $this->Mail_templates_model->getDefaultTemplateData('reservation');
            $notify = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
        }

        if (!empty($mail_data['location_email']) AND ($this->config->item('location_reserve_email') == '1' OR in_array('location', $config_reservation_email))) {
            $mail_template = $this->Mail_templates_model->getDefaultTemplateData('reservation_alert');
            $this->sendMail($mail_data['location_email'], $mail_template, $mail_data);
        }

        if (in_array('admin', $config_reservation_email)) {
            $mail_template = $this->Mail_templates_model->getDefaultTemplateData('reservation_alert');
            $this->sendMail($this->config->item('site_email'), $mail_template, $mail_data);
        }

        return $notify;
    }

    /**
     * Return the reservation data to build mail template
     *
     * @param int $reservation_id
     *
     * @return array
     */
    public function getMailData($reservation_id)
    {
        $data = [];

        if ($result = $this->getReservation($reservation_id)) {
            $this->load->library('country');

            $data['reservation_number'] = $result['reservation_id'];
            $data['reservation_view_url'] = root_url('main/reservations?id='.$result['reservation_id']);
            $data['reservation_time'] = mdate('%H:%i', strtotime($result['reserve_time']));
            $data['reservation_date'] = mdate('%l, %F %j, %Y', strtotime($result['reserve_date']));
            $data['reservation_guest_no'] = $result['guest_num'];
            $data['first_name'] = $result['first_name'];
            $data['last_name'] = $result['last_name'];
            $data['email'] = $result['email'];
            $data['telephone'] = $result['telephone'];
            $data['location_name'] = $result['location_name'];
            $data['location_email'] = $result['location_email'];
            $data['reservation_comment'] = $result['comment'];
        }

        return $data;
    }

    /**
     * Send an email
     *
     * @param string $email
     * @param array $mail_template
     * @param array $mail_data
     *
     * @return bool|string
     */
    public function sendMail($email, $mail_template = [], $mail_data = [])
    {
        if (empty($mail_template) OR !isset($mail_template['subject'], $mail_template['body']) OR empty($mail_data)) {
            return FALSE;
        }

        $this->load->library('email');

        $this->email->initialize();

        if (!empty($mail_data['status_comment'])) {
            $mail_data['status_comment'] = $this->email->parse_template($mail_data['status_comment'], $mail_data);
        }

        $this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
        $this->email->to(strtolower($email));
        $this->email->subject($mail_template['subject'], $mail_data);
        $this->email->message($mail_template['body'], $mail_data);

        if (!$this->email->send()) {
            log_message('debug', $this->email->print_debugger(['headers']));
            $notify = '0';
        }
        else {
            $notify = '1';
        }

        return $notify;
    }

    /**
     * Delete a single or multiple reservation by reservation_id
     *
     * @param string|array $reservation_id
     *
     * @return int  The number of deleted rows
     */
    public function deleteReservation($reservation_id)
    {
        if (is_numeric($reservation_id)) $reservation_id = [$reservation_id];

        if (!empty($reservation_id) AND ctype_digit(implode('', $reservation_id))) {
            return $this->whereIn('reservation_id', $reservation_id)->delete();
        }
    }
}