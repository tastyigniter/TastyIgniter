<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Location extends FormRequest
{
    public function attributes()
    {
        return [
            'location_name' => lang('admin::lang.label_name'),
            'location_email' => lang('admin::lang.label_email'),
            'location_telephone' => lang('admin::lang.locations.label_telephone'),
            'location_address_1' => lang('admin::lang.locations.label_address_1'),
            'location_address_2' => lang('admin::lang.locations.label_address_2'),
            'location_city' => lang('admin::lang.locations.label_city'),
            'location_state' => lang('admin::lang.locations.label_state'),
            'location_postcode' => lang('admin::lang.locations.label_postcode'),
            'location_country_id' => lang('admin::lang.locations.label_country'),
            'options.auto_lat_lng' => lang('admin::lang.locations.label_auto_lat_lng'),
            'location_lat' => lang('admin::lang.locations.label_latitude'),
            'location_lng' => lang('admin::lang.locations.label_longitude'),
            'description' => lang('admin::lang.label_description'),
            'location_status' => lang('admin::lang.label_status'),
            'permalink_slug' => lang('admin::lang.locations.label_permalink_slug'),
            'gallery.title' => lang('admin::lang.locations.label_gallery_title'),
            'gallery.description' => lang('admin::lang.label_description'),
        ];
    }

    public function rules()
    {
        return [
            'location_name' => ['required', 'between:2,32'],
            'location_email' => ['required', 'email:filter', 'max:96'],
            'location_telephone' => ['sometimes'],
            'location_address_1' => ['required', 'between:2,128'],
            'location_address_2' => ['max:128'],
            'location_city' => ['max:128'],
            'location_state' => ['max:128'],
            'location_postcode' => ['max:10'],
            'location_country_id' => ['required', 'integer'],
            'options.auto_lat_lng' => ['required', 'boolean'],
            'location_lat' => ['sometimes', 'numeric'],
            'location_lng' => ['sometimes', 'numeric'],
            'description' => ['max:3028'],
            'location_status' => ['boolean'],
            'permalink_slug' => ['alpha_dash', 'max:255'],
            'gallery.title' => ['max:128'],
            'gallery.description' => ['max:255'],
        ];
    }
}
