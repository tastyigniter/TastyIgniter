<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Http\Requests\IngredientRequest;
use Igniter\Cart\Models\Ingredient;
use Igniter\Local\Http\Actions\LocationAwareController;

class Ingredients extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Ingredient::class,
            'title' => 'lang:igniter.cart::default.ingredients.text_title',
            'emptyMessage' => 'lang:igniter.cart::default.ingredients.text_empty',
            'defaultSort' => ['ingredient_id', 'DESC'],
            'configFile' => 'ingredient',
            'back' => 'menus',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.cart::default.ingredients.text_form_name',
        'model' => Ingredient::class,
        'request' => IngredientRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'ingredients/edit/{ingredient_id}',
            'redirectClose' => 'ingredients',
            'redirectNew' => 'ingredients/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'ingredients/edit/{ingredient_id}',
            'redirectClose' => 'ingredients',
            'redirectNew' => 'ingredients/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'ingredients',
        ],
        'delete' => [
            'redirect' => 'ingredients',
        ],
        'configFile' => 'ingredient',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Ingredients';

    public static function getSlug(): string
    {
        return 'ingredients';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'restaurant');
    }
}
