<?php namespace Admin\Controllers;

use AdminMenu;
use Igniter\Flame\Exception\ApplicationException;

class Orders extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Orders_model',
            'title' => 'lang:admin::lang.orders.text_title',
            'emptyMessage' => 'lang:admin::lang.orders.text_empty',
            'defaultSort' => ['order_date', 'DESC'],
            'configFile' => 'orders_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.orders.text_form_name',
        'model' => 'Admin\Models\Orders_model',
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

    public function edit_onGenerateInvoice($context = null, $recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        if ($invoiceNo = $model->generateInvoice()) {
            flash()->success(sprintf(lang('admin::lang.alert_success'), 'Invoice generated'));
        }
        else {
            flash()->danger(sprintf(lang('admin::lang.alert_error_nothing'), 'generated'));
        }

        return $this->refresh();
    }

    public function formExtendFieldsBefore($form)
    {
        if (!$form->model->hasInvoice() AND (bool)setting('auto_invoicing')) {
            array_pull($form->fields['invoice_id'], 'addonRight');
        }

        if ($form->model->hasInvoice()) {
            $form->fields['invoice_id']['addonRight']['label'] = 'admin::lang.orders.button_view_invoice';
            $form->fields['invoice_id']['addonRight']['tag'] = 'a';
            $form->fields['invoice_id']['addonRight']['attributes']['href'] = admin_url('orders/invoice/'.$form->model->getKey());
            $form->fields['invoice_id']['addonRight']['attributes']['target'] = '_blank';

            unset(
                $form->fields['invoice_id']['addonRight']['attributes']['data-request'],
                $form->fields['invoice_id']['addonRight']['attributes']['type']
            );
        }
    }

    public function formExtendQuery($query)
    {
        $query->with([
            'assignee',         // Eager loaded for LogsActivities
            'status_history' => function ($q) {
                $q->orderBy('date_added', 'desc');
            },
        ]);
    }

    public function formValidate($model, $form)
    {
        $namedRules = [
            ['status_id', 'lang:admin::lang.label_status', 'required|integer|exists:statuses'],
            ['statusData.status_id', 'lang:admin::lang.orders.label_status', 'required|same:status_id'],
            ['statusData.comment', 'lang:admin::lang.orders.label_comment', 'max:1500'],
            ['statusData.notify', 'lang:admin::lang.orders.label_notify', 'required|integer'],
            ['assignee_id', 'lang:admin::lang.orders.label_assign_staff', 'required|integer'],
        ];

        return $this->validatePasses(post($form->arrayName), $namedRules);
    }
}