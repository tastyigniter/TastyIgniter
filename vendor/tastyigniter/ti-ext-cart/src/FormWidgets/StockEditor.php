<?php

declare(strict_types=1);

namespace Igniter\Cart\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\FormWidgets\DataTable;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Models\StockHistory;
use Igniter\User\Facades\AdminAuth;
use Override;

/**
 * Stock Editor
 */
class StockEditor extends BaseFormWidget
{
    public $form = 'stock';

    public $quantityKeyFrom = 'stock_qty';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'quantityKeyFrom',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('stockeditor/stockeditor');
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addCss('widgets/table.css', 'table-css');
        $this->addJs('widgets/table.js', 'table-js');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['value'] = $this->model->{$this->quantityKeyFrom};
        $this->vars['previewMode'] = $this->controller->getAction() === 'create';
    }

    #[Override]
    public function getSaveValue(mixed $value): int
    {
        return FormField::NO_SAVE_DATA;
    }

    public function onLoadRecord(): string
    {
        $formWidgets = [];
        $availableLocations = $this->getAvailableLocations();
        foreach ($availableLocations as $location) {
            $formWidgets[] = $this->makeStockFormWidget($location);
        }

        $stockableName = $this->model->getStockableName();

        return $this->makePartial('stockeditor/form', [
            'formTitle' => sprintf(lang('igniter.cart::default.stocks.text_title_manage_stock'), ''),
            'formDescription' => sprintf(lang('igniter.cart::default.stocks.text_stock_description'), $stockableName, count($availableLocations)),
            'formWidgets' => $formWidgets,
        ]);
    }

    public function onSaveRecord(): array
    {
        foreach ($this->getAvailableLocations() as $location) {
            $formWidget = $this->makeStockFormWidget($location);

            $saveData = $formWidget->getSaveData();

            $formWidget->model->fill(array_except($saveData, ['id', 'stock_action']));
            $formWidget->model->save();

            $stockActionQty = (int)array_get($saveData, 'stock_action.quantity');
            $stockActionState = array_get($saveData, 'stock_action.state');

            $formWidget->model->updateStock($stockActionQty, $stockActionState, [
                'user_id' => $this->controller->getUser()?->getKey(),
            ]);
        }

        flash()->success(sprintf(lang('igniter::admin.alert_success'), lang('igniter.cart::default.stocks.text_form_name').' updated'))->now();

        $this->model->refresh();

        $this->prepareVars();

        return [
            '~#'.$this->formField->getId('container') => $this->makePartial('stockeditor/stockeditor'),
        ];
    }

    public function onLoadHistory(): string
    {
        return $this->makePartial('stockeditor/history', [
            'formTitle' => sprintf(lang('igniter.cart::default.stocks.text_title_stock_history'), ''),
            'formWidget' => $this->makeHistoryFormWidget(),
        ]);
    }

    protected function getAvailableLocations()
    {
        $locations = $this->model->getStockableLocations();
        if ($locations && $locations->isNotEmpty()) {
            return $locations;
        }

        // @phpstan-ignore method.notFound
        return AdminAuth::user()?->getAvailableLocations() ?? collect();
    }

    protected function makeStockFormWidget($location)
    {
        $widgetConfig = is_string($this->form)
            ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;

        $widgetConfig['model'] = $this->model->getStockByLocation($location);
        $widgetConfig['alias'] = 'StockEditor';
        $widgetConfig['arrayName'] = 'Stock['.$location->getKey().']';
        $widgetConfig['context'] = $this->controller->getFormContext();
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        $widget->previewMode = $this->previewMode;

        return $widget;
    }

    protected function makeHistoryFormWidget()
    {
        $field = clone $this->formField;

        $stockIds = $this->model->stocks->pluck('id')->all();
        $field->value = StockHistory::whereIn('stock_id', $stockIds)->orderBy('id', 'desc')->get();

        $widgetConfig = $this->loadConfig($this->form, ['list'], 'list');
        $widgetConfig['model'] = $this->model;
        $widgetConfig['data'] = [];
        $widgetConfig['alias'] = $this->alias.'FormStockHistory';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[stockHistory]';

        $widget = $this->makeFormWidget(DataTable::class, $field, $widgetConfig);
        $widget->bindToController();

        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
