<?php namespace Admin\Controllers;

use Admin\Models\Status_history_model;
use Admin\Models\Statuses_model;
use AdminAuth;
use AdminMenu;

class Orders extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Orders_model',
            'title'        => 'lang:admin::orders.text_title',
            'emptyMessage' => 'lang:admin::orders.text_empty',
            'defaultSort'  => ['order_date', 'DESC'],
            'configFile'   => 'orders_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::orders.text_form_name',
        'model'      => 'Admin\Models\Orders_model',
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'orders/edit/{order_id}',
            'redirectClose' => 'orders',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'orders',
        ],
        'delete'     => [
            'redirect' => 'orders',
        ],
        'configFile' => 'orders_model',
    ];

    protected $requiredPermissions = 'Admin.Orders';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('orders', 'sales');
    }

    public function invoice($context, $recordId = null)
    {
    }

    public function onGenerateInvoice()
    {
    }

    public function formExtendQuery($query)
    {
        $query->with([
            'status_history' => function ($q) {
                $q->orderBy('date_added', 'desc');
            },
        ]);
    }

    public function formBeforeSave($model)
    {
        if (!$statusData = post('Order.statusData'))
            return;

        if (!$status = Statuses_model::find($statusData['status_id']))
            return;
//
//        if (Status_history_model::alreadyExists($model, $statusData['status_id']))
//            return;

        $statusData = array_merge($statusData, [
            'staff_id' => AdminAuth::getUser()->staff->getKey(),
        ]);

        Status_history_model::addStatusHistory($status, $model, $statusData);
    }

    public function formValidate($model, $form)
    {
        $namedRules = [
            ['status_id', 'lang:admin::default.label_status', 'required|integer|exists:statuses'],
            ['location_id', 'lang:admin::orders.text_restaurant', 'required|integer'],
            ['statusData.status_id', 'lang:admin::orders.label_status', 'required|same:status_id'],
            ['statusData.comment', 'lang:admin::orders.label_comment', 'max:1500'],
            ['statusData.notify', 'lang:admin::orders.label_notify', 'required|integer'],
            ['assignee_id', 'lang:admin::orders.label_assign_staff', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $namedRules);
    }
}