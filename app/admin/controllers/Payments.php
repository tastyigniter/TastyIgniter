<?php

namespace Admin\Controllers;

use Admin\Classes\PaymentGateways;
use Admin\Facades\AdminMenu;
use Admin\Models\Payments_model;
use Exception;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Support\Arr;
use System\Helpers\ValidationHelper;

class Payments extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'Admin\Models\Payments_model',
            'title' => 'lang:admin::lang.payments.text_title',
            'emptyMessage' => 'lang:admin::lang.payments.text_empty',
            'defaultSort' => ['updated_at', 'DESC'],
            'configFile' => 'payments_model',
        ],
    ];

    public $formConfig = [
        'name' => 'lang:admin::lang.payments.text_form_name',
        'model' => 'Admin\Models\Payments_model',
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'payments/edit/{code}',
            'redirectClose' => 'payments',
            'redirectNew' => 'payments/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'payments/edit/{code}',
            'redirectClose' => 'payments',
            'redirectNew' => 'payments/create',
        ],
        'delete' => [
            'redirect' => 'payments',
        ],
        'configFile' => 'payments_model',
    ];

    protected $requiredPermissions = 'Admin.Payments';

    protected $gateway;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('payments', 'sales');
    }

    public function index()
    {
        Payments_model::syncAll();

        $this->asExtension('ListController')->index();
    }

    /**
     * Finds a Model record by its primary identifier, used by edit actions. This logic
     * can be changed by overriding it in the controller.
     *
     * @param string $paymentCode
     *
     * @return Model
     * @throws \Exception
     */
    public function formFindModelObject($paymentCode = null)
    {
        if (!strlen($paymentCode)) {
            throw new Exception(lang('admin::lang.payments.alert_setting_missing_id'));
        }

        $model = $this->formCreateModelObject();

        // Prepare query and find model record
        $query = $model->newQuery();
        $this->fireEvent('admin.controller.extendFormQuery', [$query]);
        $this->formExtendQuery($query);
        $result = $query->whereCode($paymentCode)->first();

        if (!$result)
            throw new Exception(sprintf(lang('admin::lang.form.not_found'), $paymentCode));

        $result = $this->formExtendModel($result) ?: $result;

        return $result;
    }

    protected function getGateway($code)
    {
        if ($this->gateway !== null) {
            return $this->gateway;
        }

        if (!$gateway = PaymentGateways::instance()->findGateway($code)) {
            throw new Exception(sprintf(lang('admin::lang.payments.alert_code_not_found'), $code));
        }

        return $this->gateway = $gateway;
    }

    public function formExtendModel($model)
    {
        if (!$model->exists)
            $model->applyGatewayClass();

        return $model;
    }

    public function formExtendFields($form)
    {
        $model = $form->model;
        if ($model->exists) {
            $configFields = $model->getConfigFields();
            $form->addTabFields($configFields);
        }

        if ($form->context != 'create') {
            $field = $form->getField('code');
            $field->disabled = true;
        }
    }

    public function formBeforeCreate($model)
    {
        if (!strlen($code = post('Payment.payment')))
            throw new ApplicationException(lang('admin::lang.payments.alert_invalid_code'));

        $paymentGateway = PaymentGateways::instance()->findGateway($code);

        $model->class_name = $paymentGateway['class'];
    }

    public function formValidate($model, $form)
    {
        $rules = [
            'payment' => ['sometimes', 'required', 'alpha_dash'],
            'name' => ['required', 'min:2', 'max:128'],
            'code' => ['sometimes', 'required', 'alpha_dash', 'unique:payments,code'],
            'priority' => ['required', 'integer'],
            'description' => ['max:255'],
            'is_default' => ['required', 'integer'],
            'status' => ['required', 'integer'],
        ];

        $messages = [];

        $attributes = [
            'payment' => lang('admin::lang.payments.label_payments'),
            'name' => lang('admin::lang.label_name'),
            'code' => lang('admin::lang.payments.label_code'),
            'priority' => lang('admin::lang.payments.label_priority'),
            'description' => lang('admin::lang.label_description'),
            'is_default' => lang('admin::lang.payments.label_default'),
            'status' => lang('lang:admin::lang.label_status'),
        ];

        if ($form->model->exists) {
            $parsedRules = ValidationHelper::prepareRules($form->model->getConfigRules());

            if ($mergeRules = Arr::get($parsedRules, 'rules', $parsedRules))
                $rules = array_merge($rules, $mergeRules);

            if ($mergeMessages = $form->model->getConfigValidationMessages())
                $messages = array_merge($messages, $mergeMessages);

            if ($mergeAttributes = Arr::get($parsedRules, 'attributes', $form->model->getConfigValidationAttributes()))
                $attributes = array_merge($attributes, $mergeAttributes);
        }

        return $this->validatePasses($form->getSaveData(), $rules, $messages, $attributes);
    }
}
