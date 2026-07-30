<?php

declare(strict_types=1);

namespace Igniter\Frontend\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Frontend\Models\Slider;

class Sliders extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Slider::class,
            'title' => 'lang:igniter.frontend::default.slider.text_title',
            'emptyMessage' => 'lang:igniter.frontend::default.slider.text_empty',
            'defaultSort' => ['id', 'DESC'],
            'configFile' => 'slider',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.frontend::default.slider.text_form_name',
        'model' => Slider::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/frontend/sliders/edit/{id}',
            'redirectClose' => 'igniter/frontend/sliders',
            'redirectNew' => 'igniter/frontend/sliders/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/frontend/sliders/edit/{id}',
            'redirectClose' => 'igniter/frontend/sliders',
            'redirectNew' => 'igniter/frontend/sliders/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'back' => 'igniter/frontend/sliders',
        ],
        'delete' => [
            'redirect' => 'igniter/frontend/sliders',
        ],
        'configFile' => 'slider',
    ];

    protected null|string|array $requiredPermissions = 'Igniter.FrontEnd.ManageSlideshow';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('sliders', 'design');
    }

    public function formValidate($model, $form): array
    {
        $rules = [
            ['name', 'admin::lang.label_name', 'required|string'],
            ['code', 'igniter.frontend::default.slider.label_code', 'required|alpha_dash'],
            ['images', 'igniter.frontend::default.slider.label_images', 'sometimes|required|array'],
            ['images.*', 'igniter.frontend::default.slider.label_image', 'required|string'],
        ];

        return $this->validate(post($form->arrayName), $rules);
    }
}
