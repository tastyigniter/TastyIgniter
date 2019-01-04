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

    const UPDATED_AT = null;

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
        'hasOne' => [
            'user' => ['Admin\Models\Users_model', 'foreignKey' => 'staff_id', 'otherKey' => 'staff_id'],
        ],
        'belongsTo' => [
            'group' => ['Admin\Models\Staff_groups_model', 'foreignKey' => 'staff_group_id'],
            'location' => ['Admin\Models\Locations_model', 'foreignKey' => 'staff_location_id'],
            'language' => ['System\Models\Languages_model'],
        ],
    ];

    protected $hidden = ['password'];

    protected $purgeable = ['user'];

    protected $with = ['group'];

    public function getFullNameAttribute($value)
    {
        return $this->staff_name;
    }

    public function getEmailAttribute()
    {
        return $this->staff_email;
    }

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('staff_name');
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled staff
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('staff_status', 1);
    }

    public function scopeWhereNotSuperUser($query)
    {
        $query->whereHas('user', function ($q) {
            $q->where('super_user', '!=', 1);
        });
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