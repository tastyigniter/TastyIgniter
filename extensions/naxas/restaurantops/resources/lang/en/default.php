<?php

$permissions = [];
$modules = [
    'Operations' => ['Access', 'BranchDashboard', 'HeadOfficeDashboard', 'Audit.View'],
    'LocationContext' => ['Access', 'Switch', 'ViewAll', 'Manage'],
    'POS' => ['Access', 'Order.Create', 'Order.Edit', 'Order.Hold', 'Order.Recall', 'Discount.Apply', 'Discount.Approve', 'Void.Request', 'Void.Approve', 'Payment.Settle', 'Payment.Refund', 'Receipt.Reprint'],
    'DineIn' => ['Access', 'Table.Open', 'Table.Transfer', 'Table.Merge', 'Bill.Split', 'Bill.Request', 'Session.OverrideClose'],
    'Waiter' => ['Access', 'Order.Create', 'Order.Edit', 'Kitchen.Send', 'Bill.Request', 'Void.Request', 'Discount.Request'],
    'Kitchen' => ['Access', 'Ticket.Accept', 'Ticket.Prepare', 'Ticket.Ready', 'Ticket.Complete', 'Ticket.Cancel', 'Ticket.Refire'],
    'Shifts' => ['Access', 'Open', 'CashMovement.Create', 'Close', 'ViewOwn', 'ViewBranch', 'Approve', 'ForceClose'],
    'Reports' => ['BranchSales', 'Consolidated', 'PaymentSummary', 'DiscountsVoids', 'ShiftVariance'],
    'MenuConfig' => ['Access', 'View', 'Manage', 'Variants.Manage', 'Modifiers.Manage', 'Combos.Manage', 'Pricing.Manage', 'Availability.Manage', 'KitchenRouting.Manage', 'LocationOverrides.Manage'],
];
foreach ($modules as $module => $actions) {
    foreach ($actions as $action) {
        $permissions[strtolower(str_replace('.', '_', $module.'_'.$action))] = trim(preg_replace('/(?<!^)[A-Z]/', ' $0', str_replace('.', ' ', $action)));
    }
}

return [
    'name' => 'Restaurant Operations',
    'permission_description' => 'Controls an explicit Restaurant Operations capability.',
    'permissions' => $permissions,
    'permission_groups' => [
        'operations' => 'Restaurant Operations — Foundation', 'locationcontext' => 'Restaurant Operations — Locations',
        'pos' => 'Restaurant Operations — POS', 'dinein' => 'Restaurant Operations — Dine-in',
        'waiter' => 'Restaurant Operations — Waiter', 'kitchen' => 'Restaurant Operations — Kitchen',
        'shifts' => 'Restaurant Operations — Shifts', 'reports' => 'Restaurant Operations — Reports',
        'menuconfig' => 'Restaurant Operations — Menu Configuration',
    ],
    'navigation' => [
        'operations' => 'Restaurant Operations', 'overview' => 'Operations Overview', 'head_office' => 'Head Office',
        'branch' => 'Branch Operations', 'cashier' => 'Cashier Workspace', 'waiter' => 'Waiter Workspace', 'kitchen' => 'Kitchen Workspace',
        'menu_configuration' => 'Menu Configuration',
    ],
    'menu_configuration' => [
        'title' => 'Menu Configuration', 'official_menu' => 'Edit official menu', 'variants' => 'Variants',
        'modifier_groups' => 'Attached modifier groups', 'shared_options' => 'Shared option metadata', 'combo' => 'Combo',
    ],
];
