<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Http\Requests\CategoryRequest;
use Igniter\Cart\Models\Category;
use Igniter\Local\Http\Actions\LocationAwareController;

class Categories extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Category::class,
            'title' => 'lang:igniter.cart::default.categories.text_title',
            'emptyMessage' => 'lang:igniter.cart::default.categories.text_empty',
            'defaultSort' => ['category_id', 'DESC'],
            'configFile' => 'category',
            'back' => 'menus',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.cart::default.categories.text_form_name',
        'model' => Category::class,
        'request' => CategoryRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'categories/edit/{category_id}',
            'redirectClose' => 'categories',
            'redirectNew' => 'categories/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'categories/edit/{category_id}',
            'redirectClose' => 'categories',
            'redirectNew' => 'categories/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'categories',
        ],
        'delete' => [
            'redirect' => 'categories',
        ],
        'configFile' => 'category',
    ];

    protected null|string|array $requiredPermissions = ['Admin.Categories'];

    public static function getSlug(): string
    {
        return 'categories';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'restaurant');
    }

    public function formBeforeSave($model): void
    {
        if (!$model->getRgt() || !$model->getLft()) {
            $model->fixTree();
        }

        $category = resolve(Category::class);
        if ($category->isBroken()) {
            $category->fixTree();
        }
    }
}
