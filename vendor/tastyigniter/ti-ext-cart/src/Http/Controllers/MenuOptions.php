<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Http\Requests\MenuOptionRequest;
use Igniter\Cart\Models\MenuOption;
use Igniter\Local\Http\Actions\LocationAwareController;

class MenuOptions extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => MenuOption::class,
            'title' => 'lang:igniter.cart::default.menu_options.text_title',
            'emptyMessage' => 'lang:igniter.cart::default.menu_options.text_empty',
            'defaultSort' => ['option_id', 'DESC'],
            'configFile' => 'menuoption',
            'back' => 'menus',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.cart::default.menu_options.text_form_name',
        'model' => MenuOption::class,
        'request' => MenuOptionRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'menu_options/edit/{option_id}',
            'redirectClose' => 'menu_options',
            'redirectNew' => 'menu_options/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'menu_options/edit/{option_id}',
            'redirectClose' => 'menu_options',
            'redirectNew' => 'menu_options/create',
        ],
        'preview' => [
            'title' => 'lang:admin::default.form.preview_title',
            'back' => 'menu_options',
        ],
        'delete' => [
            'redirect' => 'menu_options',
        ],
        'configFile' => 'menuoption',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Menus';

    public static function getSlug(): string
    {
        return 'menu_options';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'restaurant');
    }

    public function edit($context = null, $recordId = null): void
    {
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');

        $this->asExtension('FormController')->edit($context, $recordId);
    }
}
