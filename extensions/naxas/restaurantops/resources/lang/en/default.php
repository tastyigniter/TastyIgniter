<?php

$permissions = [];
$modules = [
    'Operations' => ['Access', 'BranchDashboard', 'HeadOfficeDashboard', 'Audit.View'],
    'LocationContext' => ['Access', 'Switch', 'ViewAll', 'Manage'],
    'POS' => ['Access', 'Order.Create', 'Order.Edit', 'Order.Hold', 'Order.Recall', 'Discount.Apply', 'Discount.Approve', 'Void.Request', 'Void.Approve', 'Payment.Settle', 'Payment.Create', 'Payment.View', 'Payment.ReprintReceipt', 'Payment.Reverse.Request', 'Payment.Reverse.Approve', 'Payment.Refund', 'Receipt.Reprint'],
    'DineIn' => ['Access', 'Table.Open', 'Table.Transfer', 'Table.Merge', 'Bill.Split', 'Bill.Request', 'Session.OverrideClose'],
    'Tables' => ['View', 'Manage', 'Open', 'Transfer', 'Merge', 'Split', 'BillRequest', 'Close'],
    'Floors' => ['Manage'],
    'Waiter' => ['Access', 'Order.Create', 'Order.Edit', 'Kitchen.Send', 'Bill.Request', 'Void.Request', 'Discount.Request'],
    'Kitchen' => ['Access', 'Ticket.Accept', 'Ticket.Prepare', 'Ticket.Ready', 'Ticket.Complete', 'Ticket.Cancel', 'Ticket.Refire'],
    'Shifts' => ['Access', 'Open', 'CashMovement.Create', 'Close', 'ViewOwn', 'ViewBranch', 'PaymentSummary.View', 'Approve', 'ForceClose'],
    'Reports' => ['BranchSales', 'Consolidated', 'PaymentSummary', 'DiscountsVoids', 'ShiftVariance'],
    'MenuConfig' => ['Access', 'View', 'Manage', 'Variants.Manage', 'Modifiers.Manage', 'Combos.Manage', 'Pricing.Manage', 'Availability.Manage', 'KitchenRouting.Manage', 'LocationOverrides.Manage'],
];
foreach ($modules as $module => $actions) {
    foreach ($actions as $action) {
        $actionLabel = trim(preg_replace('/(?<!^)[A-Z]/', ' $0', str_replace('.', ' ', $action)));
        $permissions[strtolower(str_replace('.', '_', $module.'_'.$action))] = $module === 'MenuConfig'
            ? 'Menu Configuration: '.$actionLabel
            : $actionLabel;
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
        'menuconfig' => 'Restaurant Operations — Menu Configuration', 'tables' => 'Restaurant Operations — Tables',
        'floors' => 'Restaurant Operations — Floors',
    ],
    'navigation' => [
        'operations' => 'Restaurant Operations', 'overview' => 'Operations Overview', 'head_office' => 'Head Office',
        'branch' => 'Branch Operations', 'cashier' => 'Cashier Workspace', 'waiter' => 'Waiter Workspace', 'kitchen' => 'Kitchen Workspace',
        'menu_configuration' => 'Menu Operations Settings', 'menu_operations_settings' => 'Menu Operations Settings', 'shifts' => 'Shifts', 'active_shift' => 'My Active Shift', 'shift_review' => 'Branch Shift Review',
        'pos' => 'POS', 'active_orders' => 'Active Orders', 'held_orders' => 'Held Orders', 'table_map' => 'Table Map', 'tables' => 'Floors & Tables',
    ],
    'pos' => ['title' => 'Point of Sale', 'service' => 'Service type', 'customer' => 'Customer or guest', 'catalog' => 'Menu catalog', 'search' => 'Search menu', 'order' => 'Current order', 'totals' => 'Authoritative totals', 'hold' => 'Hold', 'recall' => 'Recall', 'confirm' => 'Confirm order', 'kitchen' => 'Send to Kitchen — queue available in a later phase', 'payment' => 'Prepare for Payment', 'no_shift' => 'Open your cashier shift before creating a POS order.'],
    'menu_configuration' => [
        'title' => 'Menu Operations Settings', 'catalog_title' => 'Choose an official menu item', 'official_menu' => 'Edit in official Menu Management', 'variants' => 'Operational variants',
        'modifier_groups' => 'Attached modifier groups', 'shared_options' => 'Shared option metadata', 'combo' => 'Combo',
    ],
    'shifts' => [
        'title' => 'Cashier Shifts', 'branch_help' => 'Branch-isolated cashier shift history and manager review.',
        'open' => 'Open Shift', 'already_open' => 'You already have an active shift:', 'opening_cash' => 'Opening cash',
        'terminal' => 'Terminal code (optional)', 'note' => 'Note', 'all_statuses' => 'All statuses', 'filter' => 'Filter',
        'cashier' => 'Cashier', 'opened' => 'Opened', 'status' => 'Status', 'expected' => 'Expected cash',
        'variance' => 'Variance', 'empty' => 'No shifts match the current filters.', 'shift' => 'Shift', 'location' => 'Location',
        'provider' => 'Payment source verification', 'movements' => 'Cash movements', 'type' => 'Type', 'amount' => 'Amount',
        'reason' => 'Reason', 'no_movements' => 'No cash movements.', 'timeline' => 'Audit timeline',
        'closing_requested' => 'Closing requested', 'submission' => 'Submission revision', 'approved' => 'Approved',
    ],
];
