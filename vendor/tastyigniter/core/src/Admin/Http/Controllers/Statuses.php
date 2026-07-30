<?php

declare(strict_types=1);

namespace Igniter\Admin\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Http\Requests\StatusRequest;
use Igniter\Admin\Models\Status;

class Statuses extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Status::class,
            'title' => 'lang:igniter::admin.statuses.text_title',
            'emptyMessage' => 'lang:igniter::admin.statuses.text_empty',
            'defaultSort' => ['status_id', 'DESC'],
            'configFile' => 'status',
            'back' => 'settings',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter::admin.statuses.text_form_name',
        'model' => Status::class,
        'request' => StatusRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'statuses/edit/{status_id}',
            'redirectClose' => 'statuses',
            'redirectNew' => 'statuses/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'statuses/edit/{status_id}',
            'redirectClose' => 'statuses',
            'redirectNew' => 'statuses/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'statuses',
        ],
        'delete' => [
            'redirect' => 'statuses',
        ],
        'configFile' => 'status',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Statuses';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('statuses', 'sales');
    }
}
