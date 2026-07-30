<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Admin\Models\Status;
use Igniter\Cart\Http\Requests\OrderRequest;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Http\Actions\LocationAwareController;
use Igniter\User\Http\Actions\AssigneeController;
use Illuminate\Http\RedirectResponse;

class Orders extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
        AssigneeController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Order::class,
            'title' => 'lang:igniter.cart::default.orders.text_title',
            'emptyMessage' => 'lang:igniter.cart::default.orders.text_empty',
            'defaultSort' => ['order_id', 'DESC'],
            'configFile' => 'order',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.cart::default.orders.text_form_name',
        'model' => Order::class,
        'request' => OrderRequest::class,
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'orders/edit/{order_id}',
            'redirectClose' => 'orders',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'orders',
        ],
        'delete' => [
            'redirect' => 'orders',
        ],
        'configFile' => 'order',
    ];

    protected null|string|array $requiredPermissions = [
        'Admin.Orders',
        'Admin.AssignOrders',
        'Admin.DeleteOrders',
    ];

    public static function getSlug(): string
    {
        return 'orders';
    }

    public function __construct()
    {
        if (setting('orders_auto_refresh', false)) {
            $this->listConfig['list']['refreshInterval'] = (int)setting('orders_auto_refresh_interval', 15);
        }

        parent::__construct();

        AdminMenu::setContext('orders', 'sales');
    }

    public function index(): void
    {
        $this->asExtension('ListController')->index();

        $this->vars['statusesOptions'] = Status::getDropdownOptionsForOrder();
    }

    public function index_onDelete()
    {
        throw_unless($this->authorize('Admin.DeleteOrders'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(ListController::class)->index_onDelete();
    }

    public function index_onUpdateStatus(): RedirectResponse
    {
        /** @var null|Order $model */
        $model = $this->asExtension(FormController::class)->formFindModelObject((string)post('recordId'));
        /** @var null|Status $status */
        $status = Status::find((int)post('statusId'));
        if ($model && $status) {
            $model->addStatusHistory($status);
            flash()->success(sprintf(lang('igniter::admin.alert_success'), lang('igniter::admin.statuses.text_form_name').' updated'))->now();
        }

        return $this->redirectBack();
    }

    public function edit_onDelete($context, $recordId)
    {
        throw_unless($this->authorize('Admin.DeleteOrders'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(FormController::class)->edit_onDelete($context, $recordId);
    }

    public function invoice($context, $recordId = null): void
    {
        $model = $this->formFindModelObject($recordId);

        throw_unless($model->hasInvoice(),
            new FlashException(lang('igniter.cart::default.orders.alert_invoice_not_generated')),
        );

        $this->vars['model'] = $model;

        $this->layout = '';
    }

    public function listExtendQuery($query): void
    {
        $query->with('address');
    }

    public function formExtendQuery($query): void
    {
        $query->with([
            'status_history' => function($q): void {
                $q->orderBy('created_at', 'desc');
            },
            'status_history.status',
        ]);
    }
}
