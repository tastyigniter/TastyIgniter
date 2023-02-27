<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Facades\AdminLocation;
use Admin\Models\Stock_history_model;
use Admin\Widgets\Form;

/**
 * Stock Editor
 */
class StockEditor extends BaseFormWidget
{
    public $form = 'stocks_model';

    public $quantityKeyFrom = 'stock_qty';

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'quantityKeyFrom',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('stockeditor/stockeditor');
    }

    public function loadAssets()
    {
        $this->addCss('~/app/admin/widgets/table/assets/vendor/bootstrap-table/bootstrap-table.min.css', 'bootstrap-table-css');
        $this->addCss('~/app/admin/widgets/table/assets/css/table.css', 'table-css');

        $this->addJs('~/app/admin/widgets/table/assets/vendor/bootstrap-table/bootstrap-table.min.js', 'bootstrap-table-js');
        $this->addJs('~/app/admin/widgets/table/assets/js/table.js', 'table-js');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['value'] = $this->model->{$this->quantityKeyFrom};
        $this->vars['previewMode'] = $this->controller->getAction() == 'create';
    }

    public function getSaveValue($value)
    {
        return FormField::NO_SAVE_DATA;
    }

    public function onLoadRecord()
    {
        $formWidgets = [];
        $availableLocations = $this->getAvailableLocations();
        foreach ($availableLocations as $location) {
            $formWidgets[] = $this->makeStockFormWidget($location);
        }

        $stockableName = $this->model->getStockableName();

        return $this->makePartial('stockeditor/form', [
            'formTitle' => sprintf(lang('admin::lang.stocks.text_title_manage_stock'), ''),
            'formDescription' => sprintf(lang('admin::lang.stocks.text_stock_description'), $stockableName, count($availableLocations)),
            'formWidgets' => $formWidgets,
        ]);
    }

    public function onSaveRecord()
    {
        foreach ($this->getAvailableLocations() as $location) {
            $formWidget = $this->makeStockFormWidget($location);

            $saveData = $formWidget->getSaveData();

            $formWidget->model->fill(array_except($saveData, ['id', 'stock_action']));
            $formWidget->model->save();

            $stockActionQty = (int)array_get($saveData, 'stock_action.quantity');
            $stockActionState = array_get($saveData, 'stock_action.state');

            $formWidget->model->updateStock($stockActionQty, $stockActionState, [
                'staff_id' => $this->controller->getUser()->staff->getKey(),
            ]);
        }

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang('admin::lang.stocks.text_form_name').' updated'))->now();

        $this->prepareVars();

        return [
            '~#'.$this->formField->getId('container') => $this->makePartial('stockeditor/stockeditor'),
        ];
    }

    public function onLoadHistory()
    {
        return $this->makePartial('stockeditor/history', [
            'formTitle' => sprintf(lang('admin::lang.stocks.text_title_stock_history'), ''),
            'formWidget' => $this->makeHistoryFormWidget(),
        ]);
    }

    protected function getAvailableLocations()
    {
        $locations = $this->model->getStockableLocations();

        return $locations && $locations->isNotEmpty() ? $locations : AdminLocation::listLocations();
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
        $field->value = Stock_history_model::whereIn('stock_id', $stockIds)->orderBy('id', 'desc')->get();

        $widgetConfig = $this->loadConfig($this->form, ['list'], 'list');

        $widgetConfig['model'] = $this->model;
        $widgetConfig['data'] = [];
        $widgetConfig['alias'] = $this->alias.'FormStockHistory';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[stockHistory]';

        $widget = $this->makeFormWidget('Admin\FormWidgets\DataTable', $field, $widgetConfig);
        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
