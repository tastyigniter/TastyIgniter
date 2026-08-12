<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Support;

final class RoleProfiles
{
    public const PROFILES = [
        'owner' => ['code' => 'restaurant_ops_owner', 'name' => 'Owner / Head Office'],
        'branch_manager' => ['code' => 'restaurant_ops_branch_manager', 'name' => 'Branch Manager'],
        'cashier' => ['code' => 'restaurant_ops_cashier', 'name' => 'Cashier'],
        'waiter' => ['code' => 'restaurant_ops_waiter', 'name' => 'Waiter'],
        'kitchen' => ['code' => 'restaurant_ops_kitchen', 'name' => 'Kitchen Staff'],
    ];

    public static function all(): array
    {
        $all = array_keys(PermissionDefinitions::all());

        return [
            'owner' => self::PROFILES['owner'] + ['permissions' => $all],
            'branch_manager' => self::PROFILES['branch_manager'] + ['permissions' => self::matching($all, [
                'Restaurant.Operations.', 'Restaurant.LocationContext.Access', 'Restaurant.LocationContext.Switch',
                'Restaurant.POS.', 'Restaurant.DineIn.', 'Restaurant.Tables.', 'Restaurant.Floors.', 'Restaurant.Waiter.', 'Restaurant.Kitchen.', 'Restaurant.Shifts.',
                'Restaurant.Reports.BranchSales', 'Restaurant.Reports.PaymentSummary', 'Restaurant.Reports.DiscountsVoids', 'Restaurant.Reports.ShiftVariance',
            ], ['Restaurant.Operations.HeadOfficeDashboard'])],
            'cashier' => self::PROFILES['cashier'] + ['permissions' => [
                'Restaurant.Operations.Access', 'Restaurant.LocationContext.Access', 'Restaurant.POS.Access',
                'Restaurant.POS.Order.Create', 'Restaurant.POS.Order.Edit', 'Restaurant.POS.Order.Hold', 'Restaurant.POS.Order.Recall',
                'Restaurant.POS.Discount.Apply', 'Restaurant.POS.Void.Request', 'Restaurant.POS.Payment.Settle', 'Restaurant.POS.Receipt.Reprint',
                'Restaurant.Shifts.Access', 'Restaurant.Shifts.Open', 'Restaurant.Shifts.CashMovement.Create', 'Restaurant.Shifts.Close', 'Restaurant.Shifts.ViewOwn',
                'Restaurant.Tables.View', 'Restaurant.Tables.Open', 'Restaurant.Tables.BillRequest', 'Restaurant.Tables.Close',
            ]],
            'waiter' => self::PROFILES['waiter'] + ['permissions' => [
                'Restaurant.Operations.Access', 'Restaurant.LocationContext.Access', 'Restaurant.DineIn.Access', 'Restaurant.DineIn.Table.Open',
                'Restaurant.Tables.View', 'Restaurant.Tables.Open', 'Restaurant.Tables.BillRequest',
                'Restaurant.DineIn.Bill.Request', 'Restaurant.Waiter.Access', 'Restaurant.Waiter.Order.Create', 'Restaurant.Waiter.Order.Edit',
                'Restaurant.Waiter.Kitchen.Send', 'Restaurant.Waiter.Bill.Request', 'Restaurant.Waiter.Void.Request', 'Restaurant.Waiter.Discount.Request',
            ]],
            'kitchen' => self::PROFILES['kitchen'] + ['permissions' => [
                'Restaurant.Operations.Access', 'Restaurant.LocationContext.Access', 'Restaurant.Kitchen.Access',
                'Restaurant.Kitchen.Ticket.Accept', 'Restaurant.Kitchen.Ticket.Prepare', 'Restaurant.Kitchen.Ticket.Ready', 'Restaurant.Kitchen.Ticket.Complete',
            ]],
        ];
    }

    private static function matching(array $permissions, array $allowed, array $excluded = []): array
    {
        return array_values(array_filter($permissions, fn (string $permission): bool => ! in_array($permission, $excluded, true)
            && collect($allowed)->contains(fn (string $prefix): bool => $permission === $prefix || str_starts_with($permission, $prefix))));
    }
}
