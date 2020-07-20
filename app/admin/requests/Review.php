<?php

namespace Admin\Requests;

use System\Classes\FormRequest;

class Review extends FormRequest
{
    public function rules()
    {
        return [
            ['sale_type', 'admin::lang.reviews.label_sale_type', 'required'],
            ['sale_id', 'admin::lang.reviews.label_sale_id', 'required|integer|saleIdExists'],
            ['location_id', 'admin::lang.reviews.label_location', 'required|integer'],
            ['customer_id', 'admin::lang.reviews.label_customer', 'required|integer'],
            ['quality', 'admin::lang.reviews.label_quality', 'required|integer|min:1'],
            ['delivery', 'admin::lang.reviews.label_delivery', 'required|integer|min:1'],
            ['service', 'admin::lang.reviews.label_service', 'required|integer|min:1'],
            ['review_text', 'admin::lang.reviews.label_text', 'required|between:2,1028'],
            ['review_status', 'admin::lang.label_status', 'required|boolean'],
        ];
    }

    protected function prepareSaleIdExistsRule($parameters, $field)
    {
        return sprintf('exists:%s,%s_id', $this->inputWith('sale_type', ''), str_singular($this->inputWith('sale_type', '')));
    }
}
