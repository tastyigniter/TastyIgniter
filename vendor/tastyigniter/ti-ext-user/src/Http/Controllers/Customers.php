<?php

declare(strict_types=1);

namespace Igniter\User\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Flame\Exception\FlashException;
use Igniter\User\Facades\Auth;
use Igniter\User\Http\Requests\CustomerRequest;
use Igniter\User\Models\Customer;
use Illuminate\Http\RedirectResponse;

use function flash;
use function lang;
use function post;

/**
 * @mixin ListController
 * @mixin FormController
 */
class Customers extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Customer::class,
            'title' => 'lang:igniter.user::default.customers.text_title',
            'emptyMessage' => 'lang:igniter.user::default.customers.text_empty',
            'defaultSort' => ['customer_id', 'DESC'],
            'configFile' => 'customer',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.user::default.customers.text_form_name',
        'model' => Customer::class,
        'request' => CustomerRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
            'redirectNew' => 'customers/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'customers/edit/{customer_id}',
            'redirectClose' => 'customers',
            'redirectNew' => 'customers/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'back' => 'customers',
        ],
        'delete' => [
            'redirect' => 'customers',
        ],
        'configFile' => 'customer',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Customers';

    public static function getSlug(): string
    {
        return 'customers';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('customers');
    }

    public function index_onDelete()
    {
        throw_unless($this->authorize('Admin.DeleteCustomers'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(ListController::class)->index_onDelete();
    }

    public function edit_onDelete(string $context, int|string|null $recordId)
    {
        throw_unless($this->authorize('Admin.DeleteCustomers'),
            new FlashException(lang('igniter::admin.alert_user_restricted')),
        );

        return $this->asExtension(FormController::class)->edit_onDelete($context, $recordId);
    }

    public function onImpersonate(string $context, int|string|null $recordId = null): void
    {
        throw_unless($this->authorize('Admin.ImpersonateCustomers'),
            new FlashException(lang('igniter.user::default.customers.alert_login_restricted')),
        );

        $id = post('recordId', $recordId);
        /** @var Customer $customer */
        $customer = $this->formFindModelObject($id);
        Auth::stopImpersonate();
        Auth::impersonate($customer);
        flash()->success(sprintf(lang('igniter.user::default.customers.alert_impersonate_success'), $customer->full_name));
    }

    public function edit_onActivate(string $context, int|string|null $recordId = null): RedirectResponse
    {
        /** @var Customer $customer */
        $customer = $this->formFindModelObject($recordId);
        $customer->completeActivation($customer->getActivationCode());

        flash()->success(lang('igniter.user::default.customers.alert_activation_success'));

        return $this->redirectBack();
    }

    public function formExtendModel($model): void
    {
        if ($model->exists && !$model->is_activated) {
            Template::setButton(lang('igniter.user::default.customers.button_activate'), [
                'class' => 'btn btn-primary',
                'data-request' => 'onActivate',
            ]);
        }
    }
}
