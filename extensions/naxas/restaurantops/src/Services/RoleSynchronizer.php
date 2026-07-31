<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Services;

use Igniter\User\Classes\PermissionManager;
use Igniter\User\Models\UserRole;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Support\RoleProfiles;

final class RoleSynchronizer
{
    public function __construct(
        private readonly AuditLogger $audit,
        private readonly PermissionManager $permissionManager,
    ) {}

    public function sync(bool $dryRun = true, bool $createMissing = false, bool $addMissingPermissions = false, ?string $only = null): array
    {
        $result = ['detected' => [], 'created' => [], 'updated' => [], 'conflicts' => [], 'missing permissions' => [], 'skipped' => []];
        $profiles = RoleProfiles::all();
        $registered = collect($this->permissionManager->listPermissions())->pluck('code')->all();
        $referenced = collect($profiles)->pluck('permissions')->flatten()->unique()->all();
        $result['missing permissions'] = array_values(array_diff($referenced, $registered));

        if ($result['missing permissions']) {
            $this->audit->info('restaurant_ops.role_sync_blocked', ['missing_permissions' => $result['missing permissions']]);

            return $result;
        }

        foreach ($profiles as $profile => $definition) {
            if ($only && ! in_array($only, [$profile, $definition['code']], true)) {
                continue;
            }

            $result['detected'][] = $definition['code'];
            $role = UserRole::query()->where('code', $definition['code'])->first();
            if (! $role) {
                if (! $createMissing || $dryRun) {
                    $result['skipped'][] = $definition['code'].' (missing)';

                    continue;
                }

                $role = UserRole::query()->create([
                    'name' => $definition['name'], 'code' => $definition['code'],
                    'description' => 'Standard Restaurant Operations role. Permissions may be customized.',
                    'permissions' => array_fill_keys($definition['permissions'], 1),
                ]);
                $result['created'][] = $definition['code'];
                $this->audit->info('restaurant_ops.role_created', ['role_id' => $role->getKey(), 'profile' => $profile]);

                continue;
            }

            $missing = array_diff($definition['permissions'], array_keys((array) $role->permissions));
            if (! $missing) {
                continue;
            }

            if ((! $addMissingPermissions && ! $createMissing) || $dryRun) {
                $result['skipped'][] = $definition['code'].' ('.count($missing).' permissions missing)';

                continue;
            }

            $role->permissions = array_replace((array) $role->permissions, array_fill_keys($missing, 1));
            $role->save();
            $result['updated'][] = $definition['code'].' (+'.count($missing).')';
            $this->audit->info('restaurant_ops.role_permissions_added', ['role_id' => $role->getKey(), 'count' => count($missing)]);
        }

        $this->audit->info($dryRun ? 'restaurant_ops.role_sync_preview' : 'restaurant_ops.role_sync', array_map('count', $result));

        return $result;
    }
}
