<?php namespace System\Models;

use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Model;
use Modules;
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
        'code'        => null,
        'description' => null,
        'action'      => ['access', 'add', 'manage', 'delete'],
    ];

    /**
     * @var array A cache of permissions.
     */
    protected static $permissionCache = [];

    /**
     * @var array Cache of registration callbacks.
     */
    private static $callbacks = [];

    protected static $registeredPermissions;

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
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
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['name']);
        }

        if (is_numeric($filter['filter_status'])) {
            $query->where('status', $filter['filter_status']);
        }

        return $query;
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

    public function getActionOptions()
    {
        return [
            'access' => lang('system::permissions.text_access'),
            'manage' => lang('system::permissions.text_manage'),
            'add'    => lang('system::permissions.text_add'),
            'delete' => lang('system::permissions.text_delete'),
        ];
    }

    //
    // Manager
    //

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

        $extensions = ExtensionManager::instance()->getExtensions();
        foreach ($extensions as $extensionId => $extensionObj) {
            $permissions = $extensionObj->registerPermissions();
            if (!is_array($permissions)) {
                continue;
            }

            $this->registerPermissions($permissions);
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
            $permission = (object)array_merge(self::$permissionDefaults, array_merge($definition, [
                'name'  => $name,
                'group' => current(explode('.', $name)),
            ]));

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