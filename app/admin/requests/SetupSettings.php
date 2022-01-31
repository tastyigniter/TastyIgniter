<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class SetupSettings extends FormRequest
{
    public function attributes()
    {
        return [
            'order_email.*' => lang('system::lang.settings.label_order_email'),
            'tax_mode' => lang('system::lang.settings.label_tax_mode'),
            'tax_title' => lang('system::lang.settings.label_tax_title'),
            'tax_percentage' => lang('system::lang.settings.label_tax_percentage'),
            'tax_menu_price' => lang('system::lang.settings.label_tax_menu_price'),
            'tax_delivery_charge' => lang('system::lang.settings.label_tax_delivery_charge'),
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
            'tax_mode' => ['required', 'integer'],
            'tax_title' => ['max:32'],
            'tax_percentage' => ['required_if:tax_mode,1', 'numeric'],
            'tax_menu_price' => ['numeric'],
            'tax_delivery_charge' => ['numeric'],
            'processing_order_status' => ['required'],
            'completed_order_status' => ['required'],
            'canceled_order_status' => ['required', 'integer'],
            'default_reservation_status' => ['required', 'integer'],
            'confirmed_reservation_status' => ['required', 'integer'],
            'canceled_reservation_status' => ['required', 'integer'],
            'menus_page' => ['required', 'string'],
            'reservation_page' => ['required', 'string'],
            'guest_order' => ['required', 'integer'],
            'location_order' => ['required', 'integer'],
            'invoice_logo' => ['string'],
        ];
    }
}
