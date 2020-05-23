<?php namespace Admin\Controllers;

use AdminMenu;

class Reviews extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Reviews_model',
            'title' => 'lang:admin::lang.reviews.text_title',
            'emptyMessage' => 'lang:admin::lang.reviews.text_empty',
            'defaultSort' => ['review_id', 'DESC'],
            'configFile' => 'reviews_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.reviews.text_form_name',
        'model' => 'Admin\Models\Reviews_model',
        'request' => 'Admin\Requests\Review',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'reviews/edit/{review_id}',
            'redirectClose' => 'reviews',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'reviews/edit/{review_id}',
            'redirectClose' => 'reviews',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'reviews',
        ],
        'delete' => [
            'redirect' => 'reviews',
        ],
        'configFile' => 'reviews_model',
    ];

    protected $requiredPermissions = 'Admin.Reviews';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('reviews', 'restaurant');
    }
}