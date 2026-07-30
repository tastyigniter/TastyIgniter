<?php

declare(strict_types=1);

namespace Igniter\PayRegister\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\FormWidgets\DataTable;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\FlashException;
use Igniter\PayRegister\Models\PaymentLog;
use Override;

/**
 * PaymentAttempts Form Widget
 *
 * @property null|Order $model
 */
class PaymentAttempts extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    public $form;

    public $columns;

    public $formTitle = 'igniter.payregister::default.text_refund_title';

    /**
     * @var null|BaseFormWidget|string
     */
    protected $dataTableWidget;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'columns',
        ]);

        $this->makeDataTableWidget();
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('paymentattempts/paymentattempts');
    }

    #[Override]
    public function getSaveValue(mixed $value): int
    {
        return FormField::NO_SAVE_DATA;
    }

    public function onLoadRecord(): string
    {
        $paymentLogId = input('recordId');

        throw_unless($model = PaymentLog::find($paymentLogId), new FlashException('Record not found'));

        /** @var PaymentLog $model */
        $formTitle = sprintf(lang($this->formTitle), currency_format($model->order->order_total));

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $paymentLogId,
            'formTitle' => $formTitle,
            'formWidget' => $this->makeRefundFormWidget($model),
        ]);
    }

    public function onSaveRecord(): array
    {
        $paymentLogId = input('recordId');

        throw_unless($paymentLog = PaymentLog::find($paymentLogId), new FlashException('Record not found'));

        $paymentMethod = $this->model->payment_method;

        /** @var PaymentLog $paymentLog */
        throw_unless(
            $paymentMethod->canRefundPayment($paymentLog),
            new FlashException('No successful payment to refund'),
        );

        $widget = $this->makeRefundFormWidget($paymentLog);
        $data = $widget->getSaveData();

        $this->validate($data, $widget->config['rules'] ?? []);

        $paymentMethod->processRefundForm($data, $this->model, $paymentLog);

        flash()->success(lang('igniter.payregister::default.alert_refund_success'));

        return $this->reload();
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('igniter.payregister::/js/paymentattempts.js', 'paymentattempts-js');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['dataTableWidget'] = $this->makeDataTableWidget();
    }

    protected function makeDataTableWidget()
    {
        if (!is_null($this->dataTableWidget)) {
            return $this->dataTableWidget;
        }

        $field = clone $this->formField;

        $fieldConfig = $field->config;
        $fieldConfig['type'] = $fieldConfig['widget'] = 'datatable';
        $widgetConfig = $this->makeConfig($fieldConfig);

        $widgetConfig['model'] = $this->model;
        $widgetConfig['data'] = $this->data;
        $widgetConfig['alias'] = $this->alias.'FormPaymentAttempt';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[paymentAttempt]';

        $widget = $this->makeFormWidget(DataTable::class, $field, $widgetConfig);
        $widget->bindToController();

        $widget->previewMode = $this->previewMode;

        return $this->dataTableWidget = $widget;
    }

    protected function makeRefundFormWidget($model)
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['data'] = array_merge($model->toArray(), ['refund_amount' => $model->order->order_total]);
        $widgetConfig['alias'] = $this->alias.'FormPaymentAttempt';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[paymentAttempt]';
        $widgetConfig['context'] = 'edit';
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        return $widget;
    }
}
