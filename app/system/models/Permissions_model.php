<?php namespace System\Models;

use Model;
use Igniter\Flame\ActivityLog\Traits\LogsActivity;
use Modules;
use System\Classes\ExtensionManager;

/**
 * Permissions Model Class
 *
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

    /**
     * Return all permissions
     *
     * @return array
     */
    public static function getPermissions()
    {
        $result = [];
        $rows = self::isEnabled()->get()->toArray();
        foreach ($rows as $row) {
            $permission = explode('.', $row['name']);
            $domain = isset($permission[0]) ? $permission[0] : 'Admin';
            $controller = isset($permission[1]) ? $permission[1] : '';
            $result[$domain][] = array_merge($row, [
                'domain'     => $domain,
                'controller' => convert_camelcase_to_underscore($controller, TRUE),
            ]);
        }

        return $result;
    }

    /**
     * Find a single permission by permission_id
     *
     * @param int $permission_id
     *
     * @return mixed
     */
    public static function getPermission($permission_id)
    {
        return self::findOrNew($permission_id)->toArray();
    }

    /**
     * Find a single permission by permission_name
     *
     * @param string $permission_name
     *
     * @return mixed
     */
    public static function getPermissionByName($permission_name = null)
    {
        return self::where('name', $permission_name)->first();
    }

    /**
     * Find a single permission by multiple permission_id
     *
     * @param array $permission_id
     *
     * @return array
     */
    public static function getPermissionsByIds($permission_id = null)
    {
        $permissions_list = self::getPermissions();

        $results = [];
        foreach ($permissions_list as $domain => $permissions) {
            foreach ($permissions as $permission) {
                $results[$permission['permission_id']] = $permission;
            }
        }

        return (is_numeric($permission_id) AND isset($results[$permission_id])) ? $results[$permission_id] : $results;
    }

    /**
     * Create a new or update existing permission
     *
     * @param int $permission_id
     * @param array $save
     *
     * @return bool|int The $menu_id of the affected row, or FALSE on failure
     */
    public function savePermission($permission_id, $save = [])
    {
        if (empty($save) OR empty($save['name'])) return FALSE;

        if (isset($save['name'])) {
            if ($permission = self::getPermissionByName($save['name'])) {
                $permission_id = $permission['permission_id'];
            }
        }

        $save['action'] = empty($save['action']) ? [] : $save['action'];

        $permissionModel = $this->findOrNew($permission_id);

        $saved = $permissionModel->fill($save)->save();

        return $saved ? $permissionModel->getKey() : $saved;
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
        $permissions = (array)self::listRegisteredPermissions();
        $dbPermissions = self::lists('is_custom', 'name')->toArray();
        $newPermissions = array_diff_key($permissions, $dbPermissions);

        // Clean up permissions of uninstalled extensions.
//        foreach ($dbPermissions as $name => $is_custom) {
//            if (!$is_custom)
//                continue;
//
//            if (!array_key_exists($name, $permissions)) {
//                self::whereName($name)->delete();
//            }
//        }

        // Create new templates
        foreach ($newPermissions as $name => $permission) {
            $template = self::make();
            $template->name = $name;
            $template->description = $permission->description;
            $template->action = $permission->action;
            $template->status = 1;
            $template->is_custom = 1;
            $template->save();
        }
    }

    /**
     * Delete a single permission by permission_name
     *
     * @param string $permission_name
     *
     * @return int The number of deleted row
     */
    public function deletePermissionByName($permission_name)
    {
        if (is_string($permission_name) AND !ctype_space($permission_name)) {
            return $this->where('name', $permission_name)->delete();
        }
    }

    /**
     * Delete a single or multiple permission by permission_id
     *
     * @param string|array $permission_id
     *
     * @return int The number of deleted rows
     */
    public function deletePermission($permission_id)
    {
        if (is_numeric($permission_id)) $permission_id = [$permission_id];

        if (!empty($permission_id) AND ctype_digit(implode('', $permission_id))) {
            return $this->whereIn('permission_id', $permission_id)->delete();
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

    public static function listTabbedPermissions()
    {
        $groups = [];

        foreach (self::listPermissions() as $permission) {
            $group = isset($permission->group)
                ? strtolower($permission->group)
                : 'Undefined group index in permission array';

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