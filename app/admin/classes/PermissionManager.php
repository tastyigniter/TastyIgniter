<?php

namespace Admin\Classes;

use Igniter\Flame\Traits\Singleton;
use System\Classes\ExtensionManager;

class PermissionManager
{
    use Singleton;

    protected $permissions;

    /**
     * @var array A cache of permissions.
     */
    protected $permissionCache = [];

    /**
     * @var array Cache of registration callbacks.
     */
    protected $callbacks = [];

    protected static $permissionDefaults = [
        'code' => null,
        'label' => null,
        'description' => null,
        'priority' => 999,
    ];

    /**
     * Returns a list of the registered permissions.
     * @return array
     */
    public function listPermissions()
    {
        if ($this->permissionCache) {
            return $this->permissionCache;
        }

        foreach ($this->callbacks as $callback) {
            $callback($this);
        }

        $permissionBundles = ExtensionManager::instance()->getRegistrationMethodValues('registerPermissions');
        foreach ($permissionBundles as $owner => $permissionBundle) {
            if (!is_array($permissionBundle))
                continue;

            $this->registerPermissions($owner, $permissionBundle);
        }

        usort($this->permissions, function ($a, $b) {
            if ($a->priority == $b->priority) {
                return 0;
            }

            return $a->priority > $b->priority ? 1 : -1;
        });

        return $this->permissionCache = $this->permissions;
    }

    public function listGroupedPermissions()
    {
        $grouped = [];

        foreach ($this->listPermissions() as $permission) {
            $group = isset($permission->group)
                ? strtolower($permission->group)
                : 'Undefined group';

            if (!array_key_exists($group, $grouped)) {
                $grouped[$group] = [];
            }

            $grouped[$group][] = $permission;
        }

        return $grouped;
    }

    public function checkPermission($permissions, $checkPermissions, $checkAll)
    {
        $matched = false;
        foreach ($checkPermissions as $permission) {
            if ($this->checkPermissionStartsWith($permission, $permissions)
                || $this->checkPermissionEndsWith($permission, $permissions)
                || $this->checkPermissionMatches($permission, $permissions)
            ) $matched = true;

            if ($checkAll === false && $matched === true)
                return true;

            if ($checkAll === true && $matched === false)
                return false;
        }

        return !($checkAll === false);
    }

    protected function checkPermissionStartsWith($permission, $permissions)
    {
        if (strlen($permission) > 1 && ends_with($permission, '*')) {
            $checkPermission = substr($permission, 0, -1);

            foreach ($permissions as $groupPermission => $permitted) {
                // Let's make sure the available permission starts with our permission
                if ($checkPermission != $groupPermission
                    && starts_with($groupPermission, $checkPermission)
                    && $permitted == 1
                ) return true;
            }
        }
    }

    protected function checkPermissionEndsWith($permission, $permissions)
    {
        if (strlen($permission) > 1 && starts_with($permission, '*')) {
            $checkPermission = substr($permission, 1);

            foreach ($permissions as $groupPermission => $permitted) {
                // Let's make sure the available permission ends with our permission
                if ($checkPermission != $groupPermission
                    && ends_with($groupPermission, $checkPermission)
                    && $permitted == 1
                ) return true;
            }
        }
    }

    protected function checkPermissionMatches($permission, $permissions)
    {
        foreach ($permissions as $groupPermission => $permitted) {
            if ((strlen($groupPermission) > 1) && ends_with($groupPermission, '*')) {
                $checkMergedPermission = substr($groupPermission, 0, -1);

                // Let's make sure the our permission starts with available permission
                if ($checkMergedPermission != $permission
                    && starts_with($permission, $checkMergedPermission)
                    && $permitted == 1
                ) return true;
            }
            // Match permissions explicitly.
            elseif ($permission == $groupPermission && $permitted == 1) {
                return true;
            }
        }
    }

    //
    // Registration
    //

    public function registerPermissions($owner, array $definitions)
    {
        if (!$this->permissions) {
            $this->permissions = [];
        }

        foreach ($definitions as $code => $definition) {
            if (!isset($definition['label']) && isset($definition['description'])) {
                $definition['label'] = $definition['description'];
                unset($definition['description']);
            }

            $permission = (object)array_merge(self::$permissionDefaults, array_merge([
                'code' => $code,
                'owner' => $owner,
            ], $definition));

            $this->permissions[] = $permission;
        }
    }

    /**
     * Registers a callback function that defines permissions.
     * The callback function should register permissions by calling the manager's
     * registerPermissions() function. This instance is passed to the
     * callback function as an argument. Usage:
     * <pre>
     *   AdminAuth::registerCallback(function($manager){
     *       $manager->registerPermissions([...]);
     *   });
     * </pre>
     *
     * @param callable $callback A callable function.
     */
    public function registerCallback(callable $callback)
    {
        $this->callbacks[] = $callback;
    }
}
