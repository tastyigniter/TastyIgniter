<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Support;

final class PermissionDefinitions
{
    private const GROUPS = [
        'Operations' => ['Access', 'BranchDashboard', 'HeadOfficeDashboard', 'Audit.View'],
        'LocationContext' => ['Access', 'Switch', 'ViewAll', 'Manage'],
        'POS' => ['Access', 'Order.Create', 'Order.Edit', 'Order.Hold', 'Order.Recall', 'Discount.Apply', 'Discount.Approve', 'Void.Request', 'Void.Approve', 'Payment.Settle', 'Payment.Create', 'Payment.View', 'Payment.ReprintReceipt', 'Payment.Reverse.Request', 'Payment.Reverse.Approve', 'Payment.Refund', 'Receipt.Reprint'],
        'DineIn' => ['Access', 'Table.Open', 'Table.Transfer', 'Table.Merge', 'Bill.Split', 'Bill.Request', 'Session.OverrideClose'],
        'Waiter' => ['Access', 'Order.Create', 'Order.Edit', 'Kitchen.Send', 'Bill.Request', 'Void.Request', 'Discount.Request'],
        'Kitchen' => ['Access', 'Ticket.Accept', 'Ticket.Prepare', 'Ticket.Ready', 'Ticket.Complete', 'Ticket.Cancel', 'Ticket.Refire'],
        'Shifts' => ['Access', 'Open', 'CashMovement.Create', 'Close', 'ViewOwn', 'ViewBranch', 'PaymentSummary.View', 'Approve', 'ForceClose'],
        'Reports' => ['BranchSales', 'Consolidated', 'PaymentSummary', 'DiscountsVoids', 'ShiftVariance'],
        'MenuConfig' => ['Access', 'View', 'Manage', 'Variants.Manage', 'Modifiers.Manage', 'Combos.Manage', 'Pricing.Manage', 'Availability.Manage', 'KitchenRouting.Manage', 'LocationOverrides.Manage'],
    ];

    public static function all(): array
    {
        $definitions = [];
        foreach (self::GROUPS as $module => $actions) {
            foreach ($actions as $action) {
                $code = 'Restaurant.'.$module.'.'.$action;
                $key = strtolower(str_replace('.', '_', $module.'_'.$action));
                $definitions[$code] = [
                    'label' => 'Naxas.RestaurantOps::default.permissions.'.$key,
                    'group' => 'Naxas.RestaurantOps::default.permission_groups.'.strtolower($module),
                    'description' => 'Naxas.RestaurantOps::default.permission_description',
                ];
            }
        }

        return $definitions;
    }

    public static function locationContext(): array
    {
        return array_intersect_key(self::all(), array_flip([
            'Restaurant.LocationContext.Access',
            'Restaurant.LocationContext.Switch',
            'Restaurant.LocationContext.ViewAll',
            'Restaurant.LocationContext.Manage',
        ]));
    }
}
