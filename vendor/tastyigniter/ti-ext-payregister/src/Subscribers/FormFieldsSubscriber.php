<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Subscribers;

use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\Order;
use Illuminate\Contracts\Events\Dispatcher;

class FormFieldsSubscriber
{
    public function subscribe(Dispatcher $events): array
    {
        return [
            'admin.form.extendFieldsBefore' => 'handle',
        ];
    }

    public function handle(Form $form): void
    {
        if ($form->model instanceof Order) {
            $form->tabs['fields']['payment_logs'] = [
                'tab' => 'lang:igniter.payregister::default.text_payment_logs',
                'type' => 'paymentattempts',
                'useAjax' => true,
                'defaultSort' => ['payment_log_id', 'desc'],
                'form' => 'igniter.payregister::/models/paymentlog',
                'columns' => [
                    'date_added_since' => [
                        'title' => 'lang:igniter.cart::default.orders.column_time_date',
                    ],
                    'payment_name' => [
                        'title' => 'lang:igniter.cart::default.orders.label_payment_method',
                    ],
                    'message' => [
                        'title' => 'lang:igniter.cart::default.orders.column_comment',
                    ],
                    'is_refundable' => [
                        'title' => 'Action',
                        'partial' => 'igniter.payregister::_partials/refund_button',
                    ],
                ],
            ];
        }
    }
}
