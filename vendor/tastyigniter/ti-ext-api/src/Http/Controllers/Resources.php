<?php

declare(strict_types=1);

namespace Igniter\Api\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Api\Http\Requests\ResourceRequest;
use Igniter\Api\Models\Resource;

/**
 * API Resources Admin Controller
 */
class Resources extends AdminController
{
    public array $implement = [
        FormController::class,
        ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Resource::class,
            'title' => 'APIs',
            'emptyMessage' => 'lang:admin::lang.list.text_empty',
            'defaultSort' => ['id', 'DESC'],
            'configFile' => 'resource',
        ],
    ];

    public array $formConfig = [
        'name' => 'APIs',
        'model' => Resource::class,
        'request' => ResourceRequest::class,
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/api/resources/edit/{id}',
            'redirectClose' => 'igniter/api/resources',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'back' => 'igniter/api/resources',
        ],
        'delete' => [
            'redirect' => 'igniter/api/resources',
        ],
        'configFile' => 'resource',
    ];

    protected null|string|array $requiredPermissions = 'Igniter.Api.*';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('resources', 'tools');
    }

    public function index(): void
    {
        Resource::syncAll();

        $this->asExtension('ListController')->index();
    }
}
