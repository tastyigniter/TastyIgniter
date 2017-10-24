<?php namespace Admin\Controllers;

use AdminMenu;

class Pages extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Pages_model',
            'title'        => 'lang:admin::pages.text_title',
            'emptyMessage' => 'lang:admin::pages.text_empty',
            'defaultSort'  => ['country_name', 'ASC'],
            'configFile'   => 'pages_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::pages.text_form_name',
        'model'      => 'Admin\Models\Pages_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'pages/edit/{page_id}',
            'redirectClose' => 'pages',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'pages/edit/{page_id}',
            'redirectClose' => 'pages',
        ],
        'delete'     => [
            'redirect' => 'pages',
        ],
        'configFile' => 'pages_model',
    ];

    protected $requiredPermissions = 'Site.Pages';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('pages', 'design');
    }

    public function formValidate($model, $form)
    {
        $rules[] = ['language_id', 'lang:admin::pages.label_language', 'required|integer'];
        $rules[] = ['name', 'lang:admin::pages.label_name', 'required|min:2|max:255'];
        $rules[] = ['title', 'lang:admin::pages.label_title', 'required|min:2|max:255'];
        $rules[] = ['permalink_slug', 'lang:admin::pages.label_permalink_slug', 'max:255'];
        $rules[] = ['content', 'lang:admin::pages.label_content', 'required|min:2'];
        $rules[] = ['meta_description', 'lang:admin::pages.label_meta_description', 'min:2|max:255'];
        $rules[] = ['meta_keywords', 'lang:admin::pages.label_meta_keywords', 'min:2|max:255'];
        $rules[] = ['layout_id', 'lang:admin::pages.label_layout', 'integer'];
        $rules[] = ['navigation[]', 'lang:admin::pages.label_navigation', 'required'];
        $rules[] = ['status', 'lang:admin::default.label_status', 'required|integer'];

        return $this->validatePasses($form->getSaveData(), $rules);
    }
}