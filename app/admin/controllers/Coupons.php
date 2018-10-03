<?php namespace Admin\Controllers;

use AdminMenu;

class Coupons extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Coupons_model',
            'title' => 'lang:admin::lang.coupons.text_title',
            'emptyMessage' => 'lang:admin::lang.coupons.text_empty',
            'defaultSort' => ['date_added', 'DESC'],
            'configFile' => 'coupons_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.coupons.text_form_name',
        'model' => 'Admin\Models\Coupons_model',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'coupons/edit/{coupon_id}',
            'redirectClose' => 'coupons',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'coupons/edit/{coupon_id}',
            'redirectClose' => 'coupons',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'coupons',
        ],
        'delete' => [
            'redirect' => 'coupons',
        ],
        'configFile' => 'coupons_model',
    ];

    protected $requiredPermissions = 'Admin.Coupons';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('coupons', 'marketing');
    }

    public function listOverrideColumnValue($record, $column, $alias = null)
    {
        if ($column->columnName == 'validity') {
            return ucwords($record->validity);
        }
    }

    public function formValidate($model, $form)
    {
        $namedRules = [
            ['name', 'lang:admin::lang.coupons.label_name', 'required|min:2|max:128'],
            ['code', 'lang:admin::lang.coupons.label_code', 'required|min:2|max:15'
                .(($form->context == 'create') ? '|unique:coupons,code' : '')],
            ['type', 'lang:admin::lang.coupons.label_type', 'required|string|size:1'],
            ['discount', 'lang:admin::lang.coupons.label_discount', 'required|numeric'
                .(($model->type == 'P') ? '|max:100' : '')],
            ['min_total', 'lang:admin::lang.coupons.label_min_total', 'numeric'],
            ['redemptions', 'lang:admin::lang.coupons.label_redemption', 'integer'],
            ['customer_redemptions', 'lang:admin::lang.coupons.label_customer_redemption', 'integer'],
            ['description', 'lang:admin::lang.coupons.label_description', 'min:2|max:1028'],
            ['validity', 'lang:admin::lang.coupons.label_validity', 'required'],
            ['fixed_date', 'lang:admin::lang.coupons.label_fixed_date', 'required_if:validity,fixed|date'],
            ['fixed_from_time', 'lang:admin::lang.coupons.label_fixed_from_time', 'required_if:validity,fixed|valid_time'],
            ['fixed_to_time', 'lang:admin::lang.coupons.label_fixed_to_time', 'required_if:validity,fixed|valid_time'],
            ['period_start_date', 'lang:admin::lang.coupons.label_period_start_date', 'required_if:validity,period|date'],
            ['period_end_date', 'lang:admin::lang.coupons.label_period_end_date', 'required_if:validity,period|date'],
            ['recurring_every', 'lang:admin::lang.coupons.label_recurring_every', 'required_if:validity,recurring'],
            ['recurring_from_time', 'lang:admin::lang.coupons.label_recurring_from_time', 'required_if:validity,recurring|valid_time'],
            ['recurring_to_time', 'lang:admin::lang.coupons.label_recurring_to_time', 'required_if:validity,recurring|valid_time'],
            ['order_restriction', 'lang:admin::lang.coupons.label_order_restriction', 'integer'],
            ['status', 'lang:admin::lang.label_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $namedRules);
    }
}