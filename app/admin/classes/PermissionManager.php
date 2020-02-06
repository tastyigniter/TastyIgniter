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

    public function getAvailablePermissions($group)
    {
        $permissions = [];
        if ($group AND is_array($group->permissions)) {
            $permissions = $group->permissions;
        }

        return $permissions;
    }

    public function checkGroupPermission($group, $permissions, $checkAll)
    {
        $matched = FALSE;
        foreach ($permissions as $permission) {
            if ($this->checkGroupPermissionStartsWith($group, $permission)
                OR $this->checkGroupPermissionEndsWith($group, $permission)
                OR $this->checkGroupPermissionMatches($group, $permission)
            ) $matched = TRUE;

            if ($checkAll === FALSE AND $matched === TRUE)
                return TRUE;

            if ($checkAll === TRUE AND $matched === FALSE)
                return FALSE;
        }

        return !($checkAll === FALSE);
    }

    protected function checkGroupPermissionStartsWith($group, $permission)
    {
        $groupPermissions = $this->getAvailablePermissions($group);
        if (strlen($permission) > 1 AND ends_with($permission, '*')) {
            $checkPermission = substr($permission, 0, -1);

            foreach ($groupPermissions as $groupPermission => $permitted) {
                // Let's make sure the available permission starts with our permission
                if ($checkPermission != $groupPermission
                    AND starts_with($groupPermission, $checkPermission)
                    AND $permitted == 1
                ) return TRUE;
            }
        }
    }

    protected function checkGroupPermissionEndsWith($group, $permission)
    {
        $groupPermissions = $this->getAvailablePermissions($group);
        if (strlen($permission) > 1 AND starts_with($permission, '*')) {
            $checkPermission = substr($permission, 1);

            foreach ($groupPermissions as $groupPermission => $permitted) {
                // Let's make sure the available permission ends with our permission
                if ($checkPermission != $groupPermission
                    AND ends_with($groupPermission, $checkPermission)
                    AND $permitted == 1
                ) return TRUE;
            }
        }
    }

    protected function checkGroupPermissionMatches($group, $permission)
    {
        $groupPermissions = $this->getAvailablePermissions($group);
        foreach ($groupPermissions as $groupPermission => $permitted) {
            if ((strlen($groupPermission) > 1) AND ends_with($groupPermission, '*')) {
                $checkMergedPermission = substr($groupPermission, 0, -1);

                // Let's make sure the our permission starts with available permission
                if ($checkMergedPermission != $permission
                    AND starts_with($permission, $checkMergedPermission)
                    AND $permitted == 1
                ) return TRUE;
            }
            // Match permissions explicitly.
            elseif ($permission == $groupPermission AND $permitted == 1) {
                return TRUE;
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
            if (!isset($definition['label']) AND isset($definition['description'])) {
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