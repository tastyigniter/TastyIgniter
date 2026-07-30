<?php

declare(strict_types=1);

namespace Igniter\Coupons\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Coupons\Models\CouponHistory;

class Redemptions extends AdminController
{
    public array $implement = [
        ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => CouponHistory::class,
            'title' => 'igniter.coupons::default.text_title_redemptions',
            'emptyMessage' => 'igniter.coupons::default.text_redemptions_empty',
            'defaultSort' => ['coupon_history_id', 'DESC'],
            'showCheckboxes' => false,
            'configFile' => 'redemptions',
            'back' => 'igniter/coupons/coupons',
        ],
    ];

    protected null|string|array $requiredPermissions = 'Admin.Coupons';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('coupons', 'marketing');
    }
}
