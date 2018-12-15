<?php namespace Admin\Controllers;

use AdminMenu;

class Reviews extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Reviews_model',
            'title' => 'lang:admin::lang.reviews.text_title',
            'emptyMessage' => 'lang:admin::lang.reviews.text_empty',
            'defaultSort' => ['date_added', 'DESC'],
            'configFile' => 'reviews_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.reviews.text_form_name',
        'model' => 'Admin\Models\Reviews_model',
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

        AdminMenu::setContext('reviews', 'sales');
    }

    public function formValidate($model, $form)
    {
        $rules = [
            ['sale_type', 'lang:admin::lang.reviews.label_sale_type', 'required'],
            ['sale_id', 'lang:admin::lang.reviews.label_sale_id', 'required|integer'],
            ['location_id', 'lang:admin::lang.reviews.label_location', 'required|integer'],
            ['customer_id', 'lang:admin::lang.reviews.label_customer', 'required|integer'],
            ['quality', 'lang:admin::lang.reviews.label_quality', 'required|integer|min:1'],
            ['delivery', 'lang:admin::lang.reviews.label_delivery', 'required|integer|min:1'],
            ['service', 'lang:admin::lang.reviews.label_service', 'required|integer|min:1'],
            ['review_text', 'lang:admin::lang.reviews.label_text', 'required|min:2|max:1028'],
            ['review_status', 'lang:admin::lang.label_status', 'required|integer'],
        ];

        $this->validateAfter(function ($validator) {
            if ($message = $this->saleIdDoesNotExists()) {
                $validator->errors()->add('sale_id', $message);
            }
        });

        return $this->validatePasses($form->getSaveData(), $rules);
    }

    protected function saleIdDoesNotExists()
    {
        $saleId = post('Review.sale_id');
        $saleType = post('Review.sale_type');

        if ($saleId AND $saleType AND !$this->getFormModel()->findBy($saleType, $saleId)) {
            return lang(($saleType == 'orders')
                ? 'admin::lang.reviews.error_not_found_in_order'
                : 'admin::lang.reviews.error_not_found_in_reservation'
            );
        }

        return FALSE;
    }
}