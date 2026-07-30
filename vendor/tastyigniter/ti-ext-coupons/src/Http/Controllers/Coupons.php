<?php

declare(strict_types=1);

namespace Igniter\Coupons\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Coupons\Http\Requests\CouponRequest;
use Igniter\Coupons\Models\Coupon;
use Igniter\Local\Http\Actions\LocationAwareController;

class Coupons extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public $locationConfig = [
        'addAbsenceConstraint' => true,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Coupon::class,
            'title' => 'igniter.coupons::default.text_title',
            'emptyMessage' => 'igniter.coupons::default.text_empty',
            'defaultSort' => ['coupon_id', 'DESC'],
            'configFile' => 'coupon',
        ],
    ];

    public array $formConfig = [
        'name' => 'igniter.coupons::default.text_form_name',
        'model' => Coupon::class,
        'request' => CouponRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/coupons/coupons/edit/{coupon_id}',
            'redirectClose' => 'igniter/coupons/coupons',
            'redirectNew' => 'igniter/coupons/coupons/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/coupons/coupons/edit/{coupon_id}',
            'redirectClose' => 'igniter/coupons/coupons',
            'redirectNew' => 'igniter/coupons/coupons/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'back' => 'igniter/coupons/coupons',
        ],
        'delete' => [
            'redirect' => 'igniter/coupons/coupons',
        ],
        'configFile' => 'coupon',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Coupons';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('coupons', 'marketing');
    }

    public function listOverrideColumnValue($record, $column, $alias = null): ?string
    {
        return $column->columnName == 'validity' ? ucwords((string)$record->validity) : null;
    }
}
