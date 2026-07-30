<?php

declare(strict_types=1);

namespace Igniter\Pages\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Pages\Http\Requests\PageRequest;
use Igniter\Pages\Models\Menu;
use Igniter\Pages\Models\Page;

class Pages extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Page::class,
            'title' => 'lang:igniter.pages::default.text_title',
            'emptyMessage' => 'lang:igniter.pages::default.text_empty',
            'defaultSort' => ['page_id', 'DESC'],
            'configFile' => 'page',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.pages::default.text_form_name',
        'model' => Page::class,
        'request' => PageRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/pages/pages/edit/{page_id}',
            'redirectClose' => 'igniter/pages/pages',
            'redirectNew' => 'igniter/pages/pages/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/pages/pages/edit/{page_id}',
            'redirectClose' => 'igniter/pages/pages',
            'redirectNew' => 'igniter/pages/pages/create',
        ],
        'delete' => [
            'redirect' => 'igniter/pages/pages',
        ],
        'configFile' => 'page',
    ];

    protected null|string|array $requiredPermissions = 'Igniter.Pages.*';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('pages', 'design');
    }

    public function index(): void
    {
        if ($this->getUser()->hasPermission('Igniter.PageMenus.Manage')) {
            Menu::syncAll();
        }

        $this->asExtension('ListController')->index();
    }
}
