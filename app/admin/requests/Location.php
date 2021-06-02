<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Location extends FormRequest
{
    public function rules()
    {
        return [
            ['location_name', 'admin::lang.label_name', 'required|between:2,32'],
            ['location_email', 'admin::lang.label_email', 'required|email:filter|max:96'],
            ['location_telephone', 'admin::lang.locations.label_telephone', 'sometimes'],
            ['location_address_1', 'admin::lang.locations.label_address_1', 'required|between:2,128'],
            ['location_address_2', 'admin::lang.locations.label_address_2', 'max:128'],
            ['location_city', 'admin::lang.locations.label_city', 'max:128'],
            ['location_state', 'admin::lang.locations.label_state', 'max:128'],
            ['location_postcode', 'admin::lang.locations.label_postcode', 'max:10'],
            ['location_country_id', 'admin::lang.locations.label_country', 'required|integer'],
            ['options.auto_lat_lng', 'admin::lang.locations.label_auto_lat_lng', 'required|boolean'],
            ['location_lat', 'admin::lang.locations.label_latitude', 'sometimes|required_if:options.auto_lat_lng,0|numeric'],
            ['location_lng', 'admin::lang.locations.label_longitude', 'sometimes|required_if:options.auto_lat_lng,0|numeric'],
            ['description', 'admin::lang.label_description', 'max:3028'],
            ['options.offer_delivery', 'admin::lang.locations.label_offer_delivery', 'boolean'],
            ['options.offer_collection', 'admin::lang.locations.label_offer_collection', 'boolean'],
            ['options.offer_reservation', 'admin::lang.locations.label_offer_collection', 'boolean'],
            ['options.delivery_time_interval', 'admin::lang.locations.label_delivery_time_interval', 'integer|min:5'],
            ['options.collection_time_interval', 'admin::lang.locations.label_collection_time_interval', 'integer|min:5'],
            ['options.delivery_lead_time', 'admin::lang.locations.label_delivery_lead_time', 'integer|min:5'],
            ['options.collection_lead_time', 'admin::lang.locations.label_collection_lead_time', 'integer|min:5'],
            ['options.future_orders.enable_delivery', 'admin::lang.locations.label_future_delivery_order', 'boolean'],
            ['options.future_orders.enable_collection', 'admin::lang.locations.label_future_collection_order', 'boolean'],
            ['options.future_orders.delivery_days', 'admin::lang.locations.label_future_delivery_days', 'integer'],
            ['options.future_orders.collection_days', 'admin::lang.locations.label_future_collection_days', 'integer'],
            ['options.payments.*', 'admin::lang.locations.label_payments'],
            ['options.reservation_time_interval', 'admin::lang.locations.label_reservation_time_interval|min:5', 'integer'],
            ['options.reservation_lead_time', 'admin::lang.locations.label_reservation_lead_time|min:5', 'integer'],
            ['options.auto_allocate_table', 'admin::lang.locations.label_auto_allocate_table', 'integer'],
            ['location_status', 'admin::lang.label_status', 'boolean'],
            ['permalink_slug', 'admin::lang.locations.label_permalink_slug', 'alpha_dash|max:255'],
            ['gallery.title', 'admin::lang.locations.label_gallery_title', 'max:128'],
            ['gallery.description', 'admin::lang.label_description', 'max:255'],
        ];
    }
}
