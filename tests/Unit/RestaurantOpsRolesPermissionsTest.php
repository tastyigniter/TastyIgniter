<?php

namespace Tests\Unit;

use Naxas\RestaurantOps\Support\PermissionDefinitions;
use Naxas\RestaurantOps\Support\RoleProfiles;
use Tests\TestCase;

class RestaurantOpsRolesPermissionsTest extends TestCase
{
    public function test_permission_catalog_is_explicit_unique_and_translatable(): void
    {
        $permissions = PermissionDefinitions::all();

        $this->assertCount(54, $permissions);
        $this->assertCount(54, array_unique(array_keys($permissions)));
        $this->assertSame([
            'Restaurant.LocationContext.Access', 'Restaurant.LocationContext.Switch',
            'Restaurant.LocationContext.ViewAll', 'Restaurant.LocationContext.Manage',
        ], array_keys(PermissionDefinitions::locationContext()));
        foreach ($permissions as $definition) {
            $this->assertStringStartsWith('naxas.restaurantops::default.permissions.', $definition['label']);
            $this->assertStringStartsWith('naxas.restaurantops::default.permission_groups.', $definition['group']);
        }
    }

    public function test_role_profiles_have_stable_codes_and_only_catalog_permissions(): void
    {
        $profiles = RoleProfiles::all();
        $this->assertSame([
            'restaurant_ops_owner', 'restaurant_ops_branch_manager', 'restaurant_ops_cashier',
            'restaurant_ops_waiter', 'restaurant_ops_kitchen',
        ], array_column($profiles, 'code'));

        $catalog = array_keys(PermissionDefinitions::all());
        foreach ($profiles as $profile) {
            $this->assertSame([], array_diff($profile['permissions'], $catalog));
            $this->assertContains('Restaurant.Operations.Access', $profile['permissions']);
            $this->assertContains('Restaurant.LocationContext.Access', $profile['permissions']);
        }

        $this->assertNotContains('Restaurant.POS.Payment.Settle', $profiles['waiter']['permissions']);
        $this->assertNotContains('Restaurant.Reports.BranchSales', $profiles['kitchen']['permissions']);
        $this->assertNotContains('Restaurant.Reports.Consolidated', $profiles['branch_manager']['permissions']);
    }
}
