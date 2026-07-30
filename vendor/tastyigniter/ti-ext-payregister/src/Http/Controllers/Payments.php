<?php

declare(strict_types=1);

namespace Igniter\PayRegister\Http\Controllers;

use Exception;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\FlashException;
use Igniter\PayRegister\Classes\PaymentGateways;
use Igniter\PayRegister\Models\Payment;
use Igniter\System\Helpers\ValidationHelper;
use Illuminate\Support\Arr;

class Payments extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Payment::class,
            'title' => 'lang:igniter.payregister::default.text_title',
            'emptyMessage' => 'lang:igniter.payregister::default.text_empty',
            'defaultSort' => ['updated_at', 'DESC'],
            'configFile' => 'payment',
            'back' => 'settings',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.payregister::default.text_form_name',
        'model' => Payment::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'payments/edit/{code}',
            'redirectClose' => 'payments',
            'redirectNew' => 'payments/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'payments/edit/{code}',
            'redirectClose' => 'payments',
            'redirectNew' => 'payments/create',
        ],
        'delete' => [
            'redirect' => 'payments',
        ],
        'configFile' => 'payment',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Payments';

    protected $gateway;

    public static function getSlug(): string
    {
        return 'payments';
    }

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('settings', 'system');
    }

    public function index(): void
    {
        Payment::syncAll();

        $this->asExtension('ListController')->index();
    }

    public function index_onSetDefault($context = null)
    {
        $data = $this->validate(post(), [
            'default' => 'required|alpha_dash|exists:'.Payment::class.',code',
        ]);

        if (Payment::updateDefault($data['default'])) {
            flash()->success(sprintf(lang('igniter::admin.alert_success'), lang('igniter.payregister::default.alert_set_default')));
        }

        return $this->asExtension(ListController::class)->refreshList('list');
    }

    public function listOverrideColumnValue($record, $column, $alias = null): void
    {
        if ($column->type == 'button' && $column->columnName == 'default') {
            $column->iconCssClass = $record->is_default ? 'fa fa-star' : 'fa fa-star-o';
        }
    }

    /**
     * Finds a Model record by its primary identifier, used by edit actions. This logic
     * can be changed by overriding it in the controller.
     *
     * @param string $paymentCode
     *
     * @return Model
     * @throws Exception
     */
    public function formFindModelObject($paymentCode = null)
    {
        throw_unless(strlen((string)$paymentCode),
            new FlashException(lang('igniter.payregister::default.alert_setting_missing_id')),
        );

        $model = $this->asExtension(FormController::class)->formCreateModelObject();

        // Prepare query and find model record
        $query = $model->newQuery();
        $this->fireEvent('admin.controller.extendFormQuery', [$query]);
        $this->asExtension(FormController::class)->formExtendQuery($query);

        throw_unless($result = $query->whereCode($paymentCode)->first(),
            new FlashException(lang('igniter::admin.form.not_found')),
        );

        return $this->formExtendModel($result) ?: $result;
    }

    public function formExtendModel($model)
    {
        if (!$model->exists) {
            $model->applyGatewayClass();
        }

        return $model;
    }

    public function formExtendFieldsBefore($form): void
    {
        $model = $form->model;
        if ($model->exists) {
            $form->tabs['fields'] = array_merge($form->tabs['fields'] ?? [], $model->getConfigFields());
        }

        if ($form->context != 'create') {
            array_set($form->fields, 'code.disabled', true);
        }
    }

    public function formBeforeCreate($model): void
    {
        throw_unless(strlen((string)($code = post('Payment.payment'))),
            new FlashException(lang('igniter.payregister::default.alert_invalid_code')),
        );

        $paymentGateway = resolve(PaymentGateways::class)->findGateway($code);

        $model->class_name = $paymentGateway['class'];
    }

    public function formAfterUpdate($model): void
    {
        if ($model->status) {
            Payment::syncAll();
        }
    }

    public function formValidate($model, $form): array
    {
        $rules = [
            'payment' => ['sometimes', 'required', 'alpha_dash'],
            'name' => ['required', 'min:2', 'max:255'],
            'code' => ['sometimes', 'required', 'alpha_dash', 'unique:payments,code'],
            'priority' => ['required', 'integer'],
            'description' => ['max:255'],
            'is_default' => ['required', 'integer'],
            'status' => ['required', 'integer'],
        ];

        $messages = [];

        $attributes = [
            'payment' => lang('igniter.payregister::default.label_payments'),
            'name' => lang('igniter::admin.label_name'),
            'code' => lang('igniter.payregister::default.label_code'),
            'priority' => lang('igniter.payregister::default.label_priority'),
            'description' => lang('igniter::admin.label_description'),
            'is_default' => lang('igniter.payregister::default.label_default'),
            'status' => lang('lang:igniter::admin.label_status'),
        ];

        if ($form->model->exists) {
            $parsedRules = ValidationHelper::prepareRules($form->model->getConfigRules());

            if ($mergeRules = Arr::get($parsedRules, 'rules', $parsedRules)) {
                $rules = array_merge($rules, $mergeRules);
            }

            if ($mergeMessages = $form->model->getConfigValidationMessages()) {
                $messages = array_merge($messages, $mergeMessages);
            }

            if ($mergeAttributes = Arr::get($parsedRules, 'attributes', $form->model->getConfigValidationAttributes())) {
                $attributes = array_merge($attributes, $mergeAttributes);
            }
        }

        return $this->validate($form->getSaveData(), $rules, $messages, $attributes);
    }
}
