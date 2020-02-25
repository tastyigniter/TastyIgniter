<?php namespace Admin\Controllers;

use AdminMenu;
use Igniter\Flame\Exception\ApplicationException;

class Orders extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
        'Admin\Actions\LocationAwareController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Orders_model',
            'title' => 'lang:admin::lang.orders.text_title',
            'emptyMessage' => 'lang:admin::lang.orders.text_empty',
            'defaultSort' => ['order_id', 'DESC'],
            'configFile' => 'orders_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.orders.text_form_name',
        'model' => 'Admin\Models\Orders_model',
        'request' => 'Admin\Requests\Order',
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'orders/edit/{order_id}',
            'redirectClose' => 'orders',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'redirect' => 'orders',
        ],
        'delete' => [
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
        $model = $this->formFindModelObject($recordId);

        if (!$model->hasInvoice())
            throw new ApplicationException('Invoice has not yet been generated');

        $this->vars['model'] = $model;

        $this->suppressLayout = TRUE;
    }

    public function formExtendFieldsBefore($form)
    {
        if (!array_key_exists('invoice_no', $form->tabs['fields']))
            return;

        if (!$form->model->hasInvoice()) {
            array_pull($form->tabs['fields']['invoice_no'], 'addonRight');
        }
        else {
            $form->tabs['fields']['invoice_no']['addonRight']['attributes']['href'] = admin_url('orders/invoice/'.$form->model->getKey());
        }
    }

    public function formExtendQuery($query)
    {
        $query->with([
            'status_history' => function ($q) {
                $q->orderBy('date_added', 'desc');
            },
        ]);
    }
}