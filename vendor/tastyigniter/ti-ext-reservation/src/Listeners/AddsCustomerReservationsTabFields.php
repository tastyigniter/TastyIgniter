<?php

declare(strict_types=1);

namespace Igniter\Reservation\Listeners;

use Igniter\Admin\Widgets\Form;
use Igniter\User\Models\Customer;

class AddsCustomerReservationsTabFields
{
    public function __invoke(Form $form): void
    {
        if (!$form->model instanceof Customer) {
            return;
        }

        $form->addTabFields([
            'reservations' => [
                'tab' => 'lang:igniter.reservation::default.text_tab_reservations',
                'type' => 'datatable',
                'context' => ['edit', 'preview'],
                'useAjax' => true,
                'defaultSort' => ['reservation_id', 'desc'],
                'columns' => [
                    'reservation_id' => [
                        'title' => lang('igniter::admin.column_id'),
                    ],
                    'customer_name' => [
                        'title' => lang('igniter::admin.label_name'),
                    ],
                    'status_name' => [
                        'title' => lang('igniter::admin.label_status'),
                    ],
                    'table_name' => [
                        'title' => lang('igniter.reservation::default.column_table'),
                    ],
                    'reserve_time' => [
                        'title' => lang('igniter.reservation::default.column_time'),
                    ],
                    'reserve_date' => [
                        'title' => lang('igniter.reservation::default.column_date'),
                    ],
                ],
            ],
        ]);
    }
}
