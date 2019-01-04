<?php namespace System\Models;

use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Model;
use System\Classes\ExtensionManager;

/**
 * Permissions Model Class
 * @package System
 */
class Permissions_model extends Model
{
    use LogsActivity;

    /**
     * @var string The database table name
     */
    protected $table = 'permissions';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'permission_id';

    public $casts = [
        'action' => 'serialize',
    ];

    protected static $permissionDefaults = [
        'name' => null,
        'description' => null,
        'group' => null,
        'action' => ['access', 'add', 'manage', 'delete'],
    ];

    /**
     * @var array A cache of permissions.
     */
    protected static $permissionCache = [];

    /**
     * @var array Cache of registration callbacks.
     */
    protected static $callbacks = [];

    protected static $registeredPermissions;

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    //
    // Accessors & Mutators
    //

    public function getActionTextAttribute($value)
    {
        return (!empty($this->action)) ? ucwords(implode(' | ', $this->action)) : '';
    }

    public function getGroupAttribute($value)
    {
        return current(explode('.', $this->name));
    }

    //
    // Helpers
    //

    public function getMessageForEvent($eventName)
    {
        return parse_values(['event' => $eventName], lang('system::lang.permissions.activity_event_log'));
    }

    public function getActionOptions()
    {
        return [
            'access' => lang('system::lang.permissions.text_access'),
            'manage' => lang('system::lang.permissions.text_manage'),
            'add' => lang('system::lang.permissions.text_add'),
            'delete' => lang('system::lang.permissions.text_delete'),
        ];
    }

    //
    // Manager
    //

    /**
     * Synchronise all permissions to the database.
     * @return void
     */
    public static function syncAll()
    {
        $permissions = (array)(new static())->listRegisteredPermissions();
        $dbPermissions = (array)self::lists('is_custom', 'name')->toArray();
        $newPermissions = array_diff_key($permissions, $dbPermissions);

        // Clean up non-customized permissions
        foreach ($dbPermissions as $name => $is_custom) {
            if ($is_custom)
                continue;

            if (!array_key_exists($name, $permissions))
                self::whereName($name)->delete();
        }

        // Create new permissions
        foreach ($newPermissions as $name => $permission) {
            $permissionModel = self::make();
            $permissionModel->name = $name;
            $permissionModel->action = $permission->action;
            $permissionModel->description = $permission->description;
            $permissionModel->status = 1;
            $permissionModel->is_custom = 0;
            $permissionModel->disableLogging();
            $permissionModel->save();
        }
    }

    public static function listPermissions()
    {
        $registeredPermissions = (array)self::listRegisteredPermissions();
        $dbPermissions = (array)self::all()->keyBy('name')->all();
        $permissions = $registeredPermissions + $dbPermissions;
        ksort($permissions);

        return $permissions;
    }

    public static function listPermissionActions()
    {
        $actions = [];

        foreach (self::listPermissions() as $permission => $model) {
            $actions[$permission] = $model->action;
        }

        return $actions;
    }

    public static function listTabbedPermissions()
    {
        $groups = [];

        foreach (self::listPermissions() as $permission) {
            $group = isset($permission->group)
                ? strtolower($permission->group)
                : 'Undefined group';

            if (!array_key_exists($group, $groups)) {
                $groups[$group] = [];
            }

            $groups[$group][] = $permission;
        }

        return $groups;
    }

    //
    // Registration
    //

    /**
     * Returns a list of the registered permissions.
     * @return array
     */
    public static function listRegisteredPermissions()
    {
        if (self::$registeredPermissions === null) {
            (new static)->loadRegisteredPermissions();
        }

        return self::$registeredPermissions;
    }

    /**
     * Loads registered permissions from extensions
     * @return void
     */
    public function loadRegisteredPermissions()
    {
        foreach (static::$callbacks as $callback) {
            $callback($this);
        }

        $permissionBundles = ExtensionManager::instance()->getRegistrationMethodValues('registerPermissions');
        foreach ($permissionBundles as $permissionBundle) {
            if (!is_array($permissionBundle))
                continue;

            $this->registerPermissions($permissionBundle);
        }
    }

    /**
     * Registers permissions.
     */
    public function registerPermissions(array $definitions)
    {
        if (!static::$registeredPermissions) {
            static::$registeredPermissions = [];
        }

        foreach ($definitions as $name => $definition) {
            $permission = (object)array_merge(self::$permissionDefaults, array_merge([
                'group' => strtolower(current(explode('.', $name))),
            ], $definition));

            $permission->name = $name;

            static::$registeredPermissions[$permission->name] = $permission;
        }
    }

    /**
     * Registers a callback function that defines permissions.
     * The callback function should register permissions by calling the manager's
     * registerPermissions() function. This instance is passed to the
     * callback function as an argument. Usage:
     * <pre>
     *   Permissions_model::registerCallback(function($permission){
     *       $permission->registerPermissions([...]);
     *   });
     * </pre>
     *
     * @param callable $callback A callable function.
     */
    public static function registerCallback(callable $callback)
    {
        self::$callbacks[] = $callback;
    }
}