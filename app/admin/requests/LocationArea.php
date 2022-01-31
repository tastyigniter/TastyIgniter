<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class LocationArea extends FormRequest
{
    public function attributes()
    {
        return [
            'type' => lang('admin::lang.locations.label_area_type'),
            'name' => lang('admin::lang.locations.label_area_name'),
            'area_id' => lang('admin::lang.locations.label_area_id'),
            'boundaries.components' => lang('admin::lang.locations.label_address_component'),
            'boundaries.components.*.type' => lang('admin::lang.locations.label_address_component_type'),
            'boundaries.components.*.value' => lang('admin::lang.locations.label_address_component_value'),
            'boundaries.polygon' => lang('admin::lang.locations.label_area_shape'),
            'boundaries.circle' => lang('admin::lang.locations.label_area_circle'),
            'boundaries.vertices' => lang('admin::lang.locations.label_area_vertices'),
            'boundaries.distance.*.type' => lang('admin::lang.locations.label_area_distance'),
            'boundaries.distance.*.distance' => lang('admin::lang.locations.label_area_distance'),
            'boundaries.distance.*.charge' => lang('admin::lang.locations.label_area_charge'),
            'conditions' => lang('admin::lang.locations.label_delivery_condition'),
            'conditions.*.amount' => lang('admin::lang.locations.label_area_charge'),
            'conditions.*.type' => lang('admin::lang.locations.label_charge_condition'),
            'conditions.*.total' => lang('admin::lang.locations.label_area_min_amount'),
        ];
    }

    public function rules()
    {
        return [
            'type' => ['sometimes', 'required', 'string'],
            'name' => ['sometimes', 'required', 'string'],
            'area_id' => ['integer'],
            'boundaries.components' => ['sometimes', 'required_if:type,address'],
            'boundaries.components.*.type' => ['sometimes', 'required', 'string'],
            'boundaries.components.*.value' => ['sometimes', 'required', 'string'],
            'boundaries.polygon' => ['sometimes', 'required_if:type,polygon'],
            'boundaries.circle' => ['sometimes', 'required_if:type,circle', 'json'],
            'boundaries.vertices' => ['sometimes', 'required_unless:type,address', 'json'],
            'boundaries.distance.*.type' => ['sometimes', 'required', 'string'],
            'boundaries.distance.*.distance' => ['sometimes', 'required', 'numeric'],
            'boundaries.distance.*.charge' => ['sometimes', 'required', 'numeric'],
            'conditions' => ['sometimes', 'required'],
            'conditions.*.amount' => ['sometimes', 'required', 'numeric'],
            'conditions.*.type' => ['sometimes', 'required', 'alpha_dash'],
            'conditions.*.total' => ['sometimes', 'required', 'numeric'],
        ];
    }

    protected function useDataFrom()
    {
        return static::DATA_TYPE_POST;
    }
}
