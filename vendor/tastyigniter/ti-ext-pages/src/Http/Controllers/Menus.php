<?php

declare(strict_types=1);

namespace Igniter\Pages\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Widgets\Form;
use Igniter\Pages\Http\Requests\MenuRequest;
use Igniter\Pages\Models\Menu;
use Igniter\Pages\Models\MenuItem;
use Illuminate\Support\Facades\Request;

/**
 * Menus Admin Controller
 */
class Menus extends AdminController
{
    public array $implement = [
        FormController::class,
        ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Menu::class,
            'title' => 'Static Menus',
            'emptyMessage' => 'lang:admin::lang.list.text_empty',
            'defaultSort' => ['id', 'DESC'],
            'configFile' => 'menu',
        ],
    ];

    public array $formConfig = [
        'name' => 'Static Menu',
        'model' => Menu::class,
        'request' => MenuRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/pages/menus/edit/{id}',
            'redirectClose' => 'igniter/pages/menus',
            'redirectNew' => 'igniter/pages/menus/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/pages/menus/edit/{id}',
            'redirectClose' => 'igniter/pages/menus',
            'redirectNew' => 'igniter/pages/menus/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'back' => 'igniter/pages/menus',
        ],
        'delete' => [
            'redirect' => 'igniter/pages/menus',
        ],
        'configFile' => 'menu',
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

    public function edit($context, $recordId): void
    {
        $this->addJs('igniter.pages::/js/menuitemseditor.js');

        $this->asExtension('FormController')->edit($context, $recordId);
    }

    public function edit_onNewItem($context, $recordId): array
    {
        $model = $this->asExtension('FormController')->formFindModelObject($recordId);
        $model->items()->create([
            'menu_id' => $recordId,
            'code' => 'new-item',
            'title' => 'New Item',
            'type' => 'url',
            'url' => '/',
        ]);

        $model->reload();
        $this->asExtension('FormController')->initForm($model, $context);

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Menu item created'))->now();

        /** @var Form $form */
        $form = $this->widgets['form'];
        $formField = $form->getField('items');

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$formField->getId('group') => $form->renderField($formField, [
                'useContainer' => false,
            ]),
        ];
    }

    public function edit_onGetMenuItemTypeInfo($context, $recordId): array
    {
        $this->asExtension('FormController')->formFindModelObject($recordId);

        $type = Request::input('type');

        return [
            'menuItemTypeInfo' => MenuItem::getTypeInfo($type),
        ];
    }
}
