<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Services;

use Igniter\User\Models\UserRole;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Support\RoleProfiles;

final class RoleSynchronizer
{
    public function __construct(private readonly AuditLogger $audit) {}

    public function sync(bool $dryRun = true, bool $createMissing = false, bool $addMissingPermissions = false, ?string $only = null): array
    {
        $result = ['detected' => [], 'created' => [], 'updated' => [], 'conflicts' => [], 'skipped' => []];
        foreach (RoleProfiles::all() as $profile => $definition) {
            if ($only && ! in_array($only, [$profile, $definition['code']], true)) {
                continue;
            }

            $role = UserRole::query()->where('code', $definition['code'])->first();
            if (! $role) {
                $sameName = UserRole::query()->where('name', $definition['name'])->first();
                if ($sameName) {
                    $result['conflicts'][] = $definition['name'].' uses code '.($sameName->code ?: '(empty)');

                    continue;
                }

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

            $result['detected'][] = $definition['code'];
            $missing = array_diff($definition['permissions'], array_keys((array) $role->permissions));
            if (! $missing) {
                continue;
            }

            if (! $addMissingPermissions || $dryRun) {
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
