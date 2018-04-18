<?php namespace Admin\Controllers;

use Admin\Classes\AdminController;
use AdminMenu;

class Menus extends AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Menus_model',
            'title'        => 'lang:admin::menus.text_title',
            'emptyMessage' => 'lang:admin::menus.text_empty',
            'defaultSort'  => ['menu_id', 'DESC'],
            'configFile'   => 'menus_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::menus.text_form_name',
        'model'      => 'Admin\Models\Menus_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'menus/edit/{menu_id}',
            'redirectClose' => 'menus',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'menus/edit/{menu_id}',
            'redirectClose' => 'menus',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'menus',
        ],
        'delete'     => [
            'redirect' => 'menus',
        ],
        'configFile' => 'menus_model',
    ];

    protected $requiredPermissions = 'Admin.Menus';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('menus', 'kitchen');
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['menu_name', 'lang:admin::menus.label_name', 'required|min:2|max:255'],
            ['menu_description', 'lang:admin::menus.label_description', 'min:2|max:1028'],
            ['menu_price', 'lang:admin::menus.label_price', 'required|numeric'],
            ['categories.*', 'lang:admin::menus.label_category', 'required|integer'],
            ['menu_photo', 'lang:admin::menus.label_image'],
            ['stock_qty', 'lang:admin::menus.label_stock_qty', 'integer'],
            ['minimum_qty', 'lang:admin::menus.label_minimum_qty', 'required|integer'],
            ['subtract_stock', 'lang:admin::menus.label_subtract_stock', 'required|integer'],
            ['menu_status', 'lang:admin::default.label_status', 'required|integer'],
            ['mealtime_id', 'lang:admin::menus.label_mealtime', 'integer'],
            ['menu_priority', 'lang:admin::menus.label_menu_priority', 'integer'],
            ['special.special_id', 'lang:admin::menus.label_special_status', 'integer'],
            ['special.special_status', 'lang:admin::menus.label_special_status', 'required|integer'],
        ];

        $rules[] = ['menu_options.*.option_id', 'lang:admin::menus.label_option_id', 'required|integer'];
        $rules[] = ['menu_options.*.menu_id', 'lang:admin::menus.label_option', 'integer'];
        $rules[] = ['menu_options.*.menu_option_id', 'lang:admin::menus.label_option', 'integer'];
        $rules[] = ['menu_options.*.required', 'lang:admin::menus.label_option_required', 'required|integer'];

        $rules[] = ['menu_options.*.menu_option_values.*', 'lang:admin::menus.label_option', 'required'];
        $rules[] = ['menu_options.*.menu_option_values.*.menu_option_value_id', 'lang:admin::menus.label_option_value_id', 'numeric'];
        $rules[] = ['menu_options.*.menu_option_values.*.option_value_id', 'lang:admin::menus.label_option_value', 'required|integer'];
        $rules[] = ['menu_options.*.menu_option_values.*.new_price', 'lang:admin::menus.label_option_price', 'numeric'];
        $rules[] = ['menu_options.*.menu_option_values.*.quantity', 'lang:admin::menus.label_option_qty', 'numeric'];
        $rules[] = ['menu_options.*.menu_option_values.*.subtract_stock', 'lang:admin::menus.label_option_subtract_stock', 'numeric'];

        $rules[] = ['special.start_date', 'lang:admin::menus.label_start_date', 'valid_date'];
        $rules[] = ['special.end_date', 'lang:admin::menus.label_end_date', 'valid_date'];
        $rules[] = ['special.special_price', 'lang:admin::menus.label_special_price', 'numeric'];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}