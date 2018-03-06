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
        $this->restorePurgedValues();

        if (array_key_exists('user', $this->attributes))
            $this->addStaffUser($this->attributes['user']);
    }

    //
    // Helpers
    //

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

    /**
     * Return the dates of all staff
     * @return array
     */
    public function getStaffDates()
    {
        return $this->pluckDates('date_added');
    }

    public function addStaffUser($user = [])
    {
        $userModel = $this->user()->firstOrNew(['staff_id' => $this->getKey()]);

        if (isset($user['super_user']))
            $userModel->super_user = $user['super_user'];

        if (isset($user['username']))
            $userModel->username = $user['username'];

        if (isset($user['password']))
            $userModel->password = $user['password'];

        if (!$userModel->exists) {
            $userModel->is_activated = TRUE;
            $userModel->date_activated = date('Y-m-d');
        }

        $userModel->save();
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
}