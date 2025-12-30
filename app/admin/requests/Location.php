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
        $method = Request::method();

        $rules = [
            'location_name' => ['between:2,32'],
            'location_email' => ['email:filter', 'max:96'],
            'location_telephone' => ['sometimes'],
            'location_address_1' => ['between:2,128'],
            'location_address_2' => ['max:128'],
            'location_city' => ['max:128'],
            'location_state' => ['max:128'],
            'location_postcode' => ['max:10'],
            'location_country_id' => ['integer'],
            'options.auto_lat_lng' => ['boolean'],
            'location_lat' => ['sometimes', 'numeric'],
            'location_lng' => ['sometimes', 'numeric'],
            'description' => ['max:3028'],
            'location_status' => ['boolean'],
            'permalink_slug' => ['alpha_dash', 'max:255'],
            'gallery.title' => ['max:128'],
            'gallery.description' => ['max:255'],
        ];

        if ($method == 'post') {
            $rules['location_name'][] = 'required';
            $rules['location_email'][] = 'required';
            $rules['options.auto_lat_lng'][] = 'required';
            $rules['location_lng'][] = 'required';
            $rules['location_country_id'][] = 'required';
        }

        return $rules;
    }
}
