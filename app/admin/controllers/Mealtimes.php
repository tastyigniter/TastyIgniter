<?php namespace Admin\Controllers;

use AdminMenu;

class Mealtimes extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Mealtimes_model',
            'title' => 'lang:admin::lang.mealtimes.text_title',
            'emptyMessage' => 'lang:admin::lang.mealtimes.text_empty',
            'defaultSort' => ['order_id', 'DESC'],
            'configFile' => 'mealtimes_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.mealtimes.text_form_name',
        'model' => 'Admin\Models\Mealtimes_model',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'mealtimes/edit/{mealtime_id}',
            'redirectClose' => 'mealtimes',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'mealtimes',
        ],
        'delete' => [
            'redirect' => 'mealtimes',
        ],
        'configFile' => 'mealtimes_model',
    ];

    protected $requiredPermissions = 'Admin.Mealtimes';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('mealtimes', 'kitchen');
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['mealtime_name', 'lang:admin::lang.mealtimes.label_mealtime_name', 'required|min:2|max:128'],
            ['start_time', 'lang:admin::lang.mealtimes.label_start_time', 'required|valid_time'],
            ['end_time', 'lang:admin::lang.mealtimes.label_end_time', 'required|valid_time'],
            ['mealtime_status', 'lang:admin::lang.mealtimes.label_mealtime_status', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $rules);
    }
}