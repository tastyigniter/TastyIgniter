<?php

namespace Admin\Controllers;

use Admin\ActivityTypes\StatusUpdated;
use Admin\Facades\AdminMenu;
use Admin\Models\Order;
use Admin\Models\Status;
use Igniter\Flame\Exception\ApplicationException;

class Orders extends \Admin\Classes\AdminController
{
    public $implement = [
        \Admin\Actions\ListController::class,
        \Admin\Actions\FormController::class,
        \Admin\Actions\LocationAwareController::class,
        \Admin\Actions\AssigneeController::class,
    ];

    public $listConfig = [
        'list' => [
            'model' => \Admin\Models\Order::class,
            'title' => 'lang:admin::lang.orders.text_title',
            'emptyMessage' => 'lang:admin::lang.orders.text_empty',
            'defaultSort' => ['order_id', 'DESC'],
            'configFile' => 'order',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.orders.text_form_name',
        'model' => \Admin\Models\Order::class,
        'request' => \Admin\Requests\Order::class,
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
        'configFile' => 'order',
    ];

    protected $requiredPermissions = [
        'Admin.Orders',
        'Admin.AssignOrders',
        'Admin.DeleteOrders',
    ];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('orders', 'sales');
    }

    public function index()
    {
        $this->asExtension('ListController')->index();

        $this->vars['statusesOptions'] = \Admin\Models\Status::getDropdownOptionsForOrder();
    }

    public function index_onDelete()
    {
        if (!$this->getUser()->hasPermission('Admin.DeleteOrders'))
            throw new ApplicationException(lang('admin::lang.alert_user_restricted'));

        return $this->asExtension(\Admin\Actions\ListController::class)->index_onDelete();
    }

    public function index_onUpdateStatus()
    {
        $model = Order::find((int)post('recordId'));
        $status = Status::find((int)post('statusId'));
        if (!$model || !$status)
            return;

        if ($record = $model->addStatusHistory($status))
            StatusUpdated::log($record, $this->getUser());

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang('admin::lang.statuses.text_form_name').' updated'))->now();

        return $this->redirectBack();
    }

    public function edit_onDelete($context, $recordId)
    {
        if (!$this->getUser()->hasPermission('Admin.DeleteOrders'))
            throw new ApplicationException(lang('admin::lang.alert_user_restricted'));

        return $this->asExtension(\Admin\Actions\FormController::class)->edit_onDelete($context, $recordId);
    }

    public function invoice($context, $recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        if (!$model->hasInvoice())
            throw new ApplicationException(lang('admin::lang.orders.alert_invoice_not_generated'));

        $this->vars['model'] = $model;

        $this->suppressLayout = TRUE;
    }

    public function formExtendQuery($query)
    {
        $query->with([
            'status_history' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
        ]);
    }
}
