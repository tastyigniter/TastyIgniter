<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Http\Requests\MealtimeRequest;
use Igniter\Cart\Models\Mealtime;
use Igniter\Local\Http\Actions\LocationAwareController;

class Mealtimes extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Mealtime::class,
            'title' => 'lang:igniter.cart::default.mealtimes.text_title',
            'emptyMessage' => 'lang:igniter.cart::default.mealtimes.text_empty',
            'defaultSort' => ['mealtime_id', 'DESC'],
            'configFile' => 'mealtime',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.cart::default.mealtimes.text_form_name',
        'model' => Mealtime::class,
        'request' => MealtimeRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
            'redirectNew' => 'mealtimes/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
            'redirectNew' => 'mealtimes/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'mealtimes',
        ],
        'delete' => [
            'redirect' => 'mealtimes',
        ],
        'configFile' => 'mealtime',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Mealtimes';

    public static function getSlug(): string
    {
        return 'mealtimes';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mealtimes', 'restaurant');
    }
}
