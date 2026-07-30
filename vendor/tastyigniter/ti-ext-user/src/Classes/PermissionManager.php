<?php

declare(strict_types=1);

namespace Igniter\User\Classes;

use Igniter\System\Classes\ExtensionManager;

class PermissionManager
{
    protected $permissions = [];

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
        'group' => 'Undefined group',
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

        $permissionBundles = resolve(ExtensionManager::class)->getRegistrationMethodValues('registerPermissions');
        foreach ($permissionBundles as $owner => $permissionBundle) {
            if (!is_array($permissionBundle)) {
                continue;
            }

            $this->registerPermissions($owner, $permissionBundle);
        }

        usort($this->permissions, fn($a, $b): int => $a->priority <=> $b->priority);

        return $this->permissionCache = $this->permissions;
    }

    public function listGroupedPermissions()
    {
        $grouped = [];

        foreach ($this->listPermissions() as $permission) {
            $group = strtolower(strlen((string)$permission->group) !== 0 ? $permission->group : 'Undefined group');

            $permission->group ??= $group;

            if (!array_key_exists($group, $grouped)) {
                $grouped[$group] = [];
            }

            $grouped[$group][] = $permission;
        }

        return $grouped;
    }

    public function checkPermission($permissions, $checkPermissions, $checkAll)
    {
        foreach ($checkPermissions as $permission) {
            $matched = false;
            if ($this->checkPermissionStartsWith($permission, $permissions)
                || $this->checkPermissionEndsWith($permission, $permissions)
                || $this->checkPermissionMatches($permission, $permissions)
            ) {
                $matched = true;
            }

            if ($checkAll === false && $matched) {
                return true;
            }

            if ($checkAll === true && $matched === false) {
                return false;
            }
        }

        return $checkAll !== false;
    }

    protected function checkPermissionStartsWith($permission, $permissions): ?bool
    {
        $checkPermission = (strlen((string)$permission) > 1 && ends_with($permission, '*'))
            ? substr((string)$permission, 0, -1) : $permission;

        foreach ($permissions as $groupPermission => $permitted) {
            $groupPermission = (strlen((string)$groupPermission) > 1 && ends_with($groupPermission, '*'))
                ? substr((string)$groupPermission, 0, -1) : $groupPermission;

            // Let's make sure the available permission starts with our permission
            if ($checkPermission != $groupPermission
                && (starts_with($groupPermission, $checkPermission) || starts_with($checkPermission, $groupPermission))
                && $permitted == 1
            ) {
                return true;
            }
        }

        return null;
    }

    protected function checkPermissionEndsWith($permission, $permissions): ?bool
    {
        $checkPermission = (strlen((string)$permission) > 1 && starts_with($permission, '*'))
            ? substr((string)$permission, 1) : $permission;

        foreach ($permissions as $groupPermission => $permitted) {
            $groupPermission = (strlen((string)$groupPermission) > 1 && starts_with($groupPermission, '*'))
                ? substr((string)$groupPermission, 1) : $groupPermission;

            // Let's make sure the available permission ends with our permission
            if ($checkPermission != $groupPermission
                && (ends_with($groupPermission, $checkPermission) || ends_with($checkPermission, $groupPermission))
                && $permitted == 1
            ) {
                return true;
            }
        }

        return null;
    }

    protected function checkPermissionMatches($permission, $permissions): ?bool
    {
        foreach ($permissions as $groupPermission => $permitted) {
            if ($permission == $groupPermission && $permitted == 1) {
                return true;
            }
        }

        return null;
    }

    //
    // Registration
    //

    public function registerPermissions($owner, array $definitions): void
    {
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
    public function registerCallback(callable $callback): void
    {
        $this->callbacks[] = $callback;
    }
}
