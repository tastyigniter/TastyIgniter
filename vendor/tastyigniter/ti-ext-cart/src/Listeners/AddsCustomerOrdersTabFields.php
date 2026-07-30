<?php

declare(strict_types=1);

namespace Igniter\Cart\Listeners;

use Igniter\Admin\Widgets\Form;
use Igniter\User\Models\Customer;

class AddsCustomerOrdersTabFields
{
    public function __invoke(Form $form): void
    {
        if (!$form->model instanceof Customer) {
            return;
        }

        $form->addTabFields([
            'orders' => [
                'tab' => 'lang:igniter.cart::default.text_tab_orders',
                'type' => 'datatable',
                'context' => ['edit', 'preview'],
                'useAjax' => true,
                'defaultSort' => ['order_id', 'desc'],
                'columns' => [
                    'order_id' => [
                        'title' => 'lang:igniter::admin.column_id',
                    ],
                    'customer_name' => [
                        'title' => 'lang:igniter.cart::default.orders.column_customer_name',
                    ],
                    'status_name' => [
                        'title' => 'lang:igniter::admin.label_status',
                    ],
                    'order_type_name' => [
                        'title' => 'lang:igniter::admin.label_type',
                    ],
                    'order_total' => [
                        'title' => 'lang:igniter.cart::default.orders.column_total',
                    ],
                    'order_time' => [
                        'title' => 'lang:igniter.cart::default.orders.column_time',
                    ],
                    'order_date' => [
                        'title' => 'lang:igniter.cart::default.orders.column_date',
                    ],
                ],
            ],
        ]);
    }
}
