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
            'model'        => 'Admin\Models\Reviews_model',
            'title'        => 'lang:admin::reviews.text_title',
            'emptyMessage' => 'lang:admin::reviews.text_empty',
            'defaultSort'  => ['date_added', 'DESC'],
            'configFile'   => 'reviews_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::reviews.text_form_name',
        'model'      => 'Admin\Models\Reviews_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'reviews/edit/{review_id}',
            'redirectClose' => 'reviews',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'reviews/edit/{review_id}',
            'redirectClose' => 'reviews',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'reviews',
        ],
        'delete'     => [
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
            ['sale_type', 'lang:admin::reviews.label_sale_type', 'required'],
            ['sale_id', 'lang:admin::reviews.label_sale_id', 'required|integer'],
            ['location_id', 'lang:admin::reviews.label_location', 'required|integer'],
            ['customer_id', 'lang:admin::reviews.label_customer', 'required|integer'],
            ['quality', 'lang:admin::reviews.label_quality', 'required|integer|min:1'],
            ['delivery', 'lang:admin::reviews.label_delivery', 'required|integer|min:1'],
            ['service', 'lang:admin::reviews.label_service', 'required|integer|min:1'],
            ['review_text', 'lang:admin::reviews.label_text', 'required|min:2|max:1028'],
            ['review_status', 'lang:admin::default.label_status', 'required|integer'],
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
        $saleModel = '\\Admin\\Models\\'.ucwords($saleType.'s_model');

        if (!$saleModel::find($saleId)) {
            return lang(($saleType == 'order')
                ? 'admin::reviews.error_not_found_in_order'
                : 'admin::reviews.error_not_found_in_reservation'
            );
        }

        return FALSE;
    }
}