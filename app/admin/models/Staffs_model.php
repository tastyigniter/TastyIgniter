<?php namespace Admin\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Model;

/**
 * Staffs Model Class
 * @package Admin
 */
class Staffs_model extends Model
{
    use Purgeable;

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'staffs';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'staff_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    protected $fillable = ['staff_name', 'staff_email', 'staff_group_id', 'staff_location_id', 'timezone',
        'language_id', 'date_added', 'staff_status'];

    public $relation = [
        'hasOne'    => [
            'user' => ['Admin\Models\Users_model', 'foreignKey' => 'staff_id', 'otherKey' => 'staff_id'],
        ],
        'belongsTo' => [
            'group'    => ['Admin\Models\Staff_groups_model', 'foreignKey' => 'staff_group_id', 'otherKey' => 'staff_group_id'],
            'location' => ['Admin\Models\Locations_model', 'foreignKey' => 'staff_location_id'],
        ],
    ];

    protected $hidden = ['password'];

    protected $purgeable = ['user'];

    protected $with = ['group'];

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('staff_name');
    }

    //
    // Scopes
    //

    public function scopeJoinTables($query)
    {
        $query->join('users', 'users.staff_id', '=', 'staffs.staff_id', 'left');
        $query->join('staff_groups', 'staff_groups.staff_group_id', '=', 'staffs.staff_group_id', 'left');
        $query->join('locations', 'locations.location_id', '=', 'staffs.staff_location_id', 'left');

        return $query;
    }

    public function scopeJoinUserTable($query)
    {
        $query->join('users', 'users.staff_id', '=', 'staffs.staff_id', 'left');

        return $query;
    }

    /**
     * Scope a query to only include enabled staff
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('staff_status', 1);
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
        $query->selectRaw($this->getTablePrefix('staffs').'.staff_id, staff_name, staff_email, staff_group_name, '.
            'location_name, date_added, staff_status');

        $query->joinTables();

        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['staff_name', 'location_name', 'staff_email']);
        }

        if (isset($filter['filter_group']) AND is_numeric($filter['filter_group'])) {
            $query->where('staffs.staff_group_id', $filter['filter_group']);
        }

        if (!empty($filter['filter_location'])) {
            $query->where('staffs.staff_location_id', $filter['filter_location']);
        }

        if (!empty($filter['filter_date'])) {
            $date = explode('-', $filter['filter_date']);
            $query->whereYear('date_added', $date[0]);
            $query->whereMonth('date_added', $date[1]);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('staff_status', $filter['filter_status']);
        }

        return $query;
    }

    //
    // Events
    //

    public function afterSave()
    {
//        $this->restorePurgedValues();
//
//        if (array_key_exists('user', $this->attributes))
//            $this->addStaffUser($this->attributes['user']);
    }

    //
    // Helpers
    //

    public function belongsToSuperGroup()
    {
        return ($this->staff_group_id == 11);
    }

    /**
     * Return all enabled staff
     * @return array
     */
    public function getStaffs()
    {
        return $this->where('staff_status', '1')->get();
    }

    /**
     * Find a single staff by staff_id
     *
     * @param int $staff_id
     *
     * @return mixed
     */
    public function getStaff($staff_id = null)
    {
        return $this->findOrNew($staff_id)->toArray();
    }

    /**
     * Find a staff user by staff_id
     *
     * @param int $staff_id
     *
     * @return mixed
     */
    public function getStaffUser($staff_id = null)
    {
        return $this->user()->firstOrNew(['staff_id' => $staff_id])->toArray();
    }

    /**
     * Return the dates of all staff
     * @return array
     */
    public function getStaffDates()
    {
        return $this->pluckDates('date_added');
    }

    /**
     * Return all staff email or id,
     * to use when sending messages to staff
     *
     * @param $type
     *
     * @return array
     */
    public function getStaffsForMessages($type)
    {
        $result = $this->selectRaw('staff_id, staff_email, staff_status')->where('staff_status', '1')->get();

        return $this->getEmailOrIdFromResult($result, $type);
    }

    /**
     * Return single staff email or id,
     * to use when sending messages to staff
     *
     * @param      $type
     * @param bool $staff_id
     *
     * @return array
     */
    public function getStaffForMessages($type, $staff_id = FALSE)
    {
        if (!empty($staff_id) AND is_array($staff_id)) {
            $result = $this->selectRaw('staff_id, staff_email, staff_status')
                           ->whereIn('staff_id', $staff_id)->get();

            return $this->getEmailOrIdFromResult($result, $type);
        }
    }

    /**
     * @param      $type
     * @param bool $staff_group_id
     *
     * @return array
     */
    public function getStaffsByGroupIdForMessages($type, $staff_group_id = FALSE)
    {
        if (is_numeric($staff_group_id)) {
            $result = $this->selectRaw('staff_id, staff_email, staff_status')
                           ->where('staff_group_id', $staff_group_id)->get();

            return $this->getEmailOrIdFromResult($result, $type);
        }
    }

    /**
     * @param $query
     * @param $type
     * @param array $result
     *
     * @return array
     */
    protected function getEmailOrIdFromResult($result, $type)
    {
        if (!empty($result)) {
            foreach ($result as $row) {
                $result[] = ($type == 'email') ? $row['staff_email'] : $row['staff_id'];
            }
        }

        return $result;
    }

    /**
     * List all staff matching the filter,
     * to fill select auto-complete options
     *
     * @param array $filter
     *
     * @return array
     */
    public static function getAutoComplete($filter = [])
    {
        if (is_array($filter) AND !empty($filter)) {
            $query = self::query();

            if (!empty($filter['staff_name'])) {
                $query->like('staff_name', $filter['staff_name']);
            }

            if (!empty($filter['staff_id'])) {
                $query->where('staff_id', $filter['staff_id']);
            }

            return $query->get();
        }
    }

    public function addStaffUser($user = [])
    {
        $userModel = $this->user()->firstOrCreate(['staff_id' => $this->getKey()]);

        if (isset($user['super_user']))
            $userModel->super_user = $user['super_user'];

        if (isset($user['username']))
            $userModel->username = $user['username'];

        if (isset($user['password']))
            $userModel->password = $userModel->getHasher()->make($user['password']);

        if ($userModel->wasRecentlyCreated)
            $userModel->date_activated = date('Y-m-d');

        dd($userModel);
        $userModel->save();
    }

    /**
     * Create a new or update existing staff
     *
     * @param int $staff_id
     * @param array $save
     *
     * @return bool|int The $staff_id of the affected row, or FALSE on failure
     */
    public function saveStaff($staff_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $_action = is_numeric($staff_id) ? 'updated' : 'added';

        if (is_single_location()) {
            $save['staff_location_id'] = $this->config->item('default_location_id');
        }

        $staffModel = $this->findOrNew($staff_id);
        $save['timezone'] = isset($save['timezone']) ? $save['timezone'] : '';
        $save['language_id'] = isset($save['language_id']) ? $save['language_id'] : '';

        if ($saved = $staffModel->fill($save)->save()) {
            $staff_id = $staffModel->getKey();

            if (!empty($save['password'])) {
                $user['salt'] = $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9);
                $user['password'] = sha1($salt.sha1($salt.sha1($save['password'])));

                if ($_action === 'added' AND !empty($save['username'])) {
                    $user['username'] = strtolower($save['username']);
                    $user['staff_id'] = $staff_id;
                    Users_model::insertGetId($user);
                }
                else {
                    Users_model::where('staff_id', $staff_id)->update($user);
                }
            }

            return $staff_id;
        }
    }

    /**
     * Reset a staff password,
     * new password is sent to staff email
     *
     * @param string $username
     *
     * @return bool
     */
    public function resetPassword($username = '')
    {
        return Users_model::resetPassword($username);
    }

    /**
     * Delete a single or multiple staff by staff_id
     *
     * @param string|array $staff_id
     *
     * @return int  The number of deleted rows
     */
    public function deleteStaff($staff_id)
    {
        if (is_numeric($staff_id)) $staff_id = [$staff_id];

        if (!empty($staff_id) AND ctype_digit(implode('', $staff_id))) {
            $affected_rows = $this->whereIn('staff_id', $staff_id)->delete();

            if ($affected_rows > 0) {
                Users_model::whereIn('staff_id', $staff_id)->delete();

                return $affected_rows;
            }
        }
    }

    /**
     * Send email to staff
     *
     * @param string $email
     * @param array $template
     * @param array $data
     *
     * @return bool
     */
    public function sendMail($email, $template, $data = [])
    {
        return Users_model::sendMail($email, $template, $data);
    }

    /**
     * Check if a staff id already exists in database
     *
     * @param int $staff_id
     *
     * @return bool
     */
    public function validateStaff($staff_id = null)
    {
        $query = $this->query();

        if (is_numeric($staff_id)) {
            $query->where('staff_id', $staff_id);
        }
        else {
            $query->where('staff_email', $staff_id);
        }

        return $query->first() ? TRUE : FALSE;
    }
}