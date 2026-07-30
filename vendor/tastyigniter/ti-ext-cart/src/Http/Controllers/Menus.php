<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Http\Requests\MenuRequest;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Http\Actions\LocationAwareController;

class Menus extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Menu::class,
            'title' => 'lang:igniter.cart::default.menus.text_title',
            'emptyMessage' => 'lang:igniter.cart::default.menus.text_empty',
            'defaultSort' => ['menu_id', 'DESC'],
            'configFile' => 'menu',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.cart::default.menus.text_form_name',
        'model' => Menu::class,
        'request' => MenuRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'menus/edit/{menu_id}',
            'redirectClose' => 'menus',
            'redirectNew' => 'menus/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'menus/edit/{menu_id}',
            'redirectClose' => 'menus',
            'redirectNew' => 'menus/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'menus',
        ],
        'delete' => [
            'redirect' => 'menus',
        ],
        'configFile' => 'menu',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Menus';

    public static function getSlug(): string
    {
        return 'menus';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'restaurant');
    }

    public function listExtendQuery($query): void
    {
        $query->with('stocks');
    }

    public function formExtendQuery($query): void
    {
        $query->with([
            'menu_options',
        ]);
    }
}
