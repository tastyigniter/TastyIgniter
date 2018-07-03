<?php namespace Admin\Controllers;

use AdminMenu;

/**
 * Admin Controller Class Tables
 */
class Tables extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Tables_model',
            'title'        => 'lang:admin::lang.tables.text_title',
            'emptyMessage' => 'lang:admin::lang.tables.text_empty',
            'defaultSort'  => ['table_id', 'ASC'],
            'configFile'   => 'tables_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::lang.tables.text_form_name',
        'model'      => 'Admin\Models\Tables_model',
        'create'     => [
            'title'         => 'lang:admin::lang.form.create_title',
            'redirect'      => 'tables/edit/{table_id}',
            'redirectClose' => 'tables',
        ],
        'edit'       => [
            'title'         => 'lang:admin::lang.form.edit_title',
            'redirect'      => 'tables/edit/{table_id}',
            'redirectClose' => 'tables',
        ],
        'preview'    => [
            'title'    => 'lang:admin::lang.form.preview_title',
            'redirect' => 'tables',
        ],
        'delete'     => [
            'redirect' => 'tables',
        ],
        'configFile' => 'tables_model',
    ];

    protected $requiredPermissions = 'Admin.Tables';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('tables', 'restaurant');
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['table_name', 'lang:admin::lang.tables.label_name', 'required|min:2|max:255'],
            ['min_capacity', 'lang:admin::lang.tables.label_min_capacity', 'required|integer|min:1'],
            ['max_capacity', 'lang:admin::lang.tables.label_capacity', 'required|integer|min:1'],
            ['table_status', 'lang:admin::lang.label_status', 'required|integer'],
        ];

        $this->validateAfter(function ($validator) {
            if ($message = $this->capacityIsInvalid()) {
                $validator->errors()->add('max_capacity', $message);
            }
        });

        return $this->validatePasses($form->getSaveData(), $rules);
    }

    protected function capacityIsInvalid()
    {
        if (post('Table.max_capacity') < post('Table.min_capacity')) {
            return lang('admin::lang.tables.error_capacity');
        }

        return FALSE;
    }
}