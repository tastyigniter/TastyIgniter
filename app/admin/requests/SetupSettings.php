<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class SetupSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'order_email.*' => lang('system::lang.settings.label_order_email'),
            'processing_order_status' => lang('system::lang.settings.label_processing_order_status'),
            'completed_order_status' => lang('system::lang.settings.label_completed_order_status'),
            'canceled_order_status' => lang('system::lang.settings.label_canceled_order_status'),
            'default_reservation_status' => lang('system::lang.settings.label_default_reservation_status'),
            'confirmed_reservation_status' => lang('system::lang.settings.label_confirmed_reservation_status'),
            'canceled_reservation_status' => lang('system::lang.settings.label_canceled_reservation_status'),
            'menus_page' => lang('system::lang.settings.label_menus_page'),
            'reservation_page' => lang('system::lang.settings.label_reservation_page'),
            'guest_order' => lang('system::lang.settings.label_guest_order'),
            'location_order' => lang('system::lang.settings.label_location_order'),
            'invoice_prefix' => lang('system::lang.settings.label_invoice_prefix'),
            'invoice_logo' => lang('system::lang.settings.label_invoice_logo'),
        ];
    }

    public function rules()
    {
        return [
            'order_email.*' => ['required', 'alpha'],
            'processing_order_status' => ['required'],
            'completed_order_status' => ['required'],
            'canceled_order_status' => ['required', 'integer'],
            'default_reservation_status' => ['required', 'integer'],
            'confirmed_reservation_status' => ['required', 'integer'],
            'canceled_reservation_status' => ['required', 'integer'],
            'guest_order' => ['required', 'integer'],
            'location_order' => ['required', 'integer'],
            'invoice_logo' => ['string'],
        ];
    }
}
