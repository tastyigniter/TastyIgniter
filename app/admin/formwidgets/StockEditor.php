<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Models\Menu_option_values_model;
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
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('stockeditor/stockeditor');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['value'] = $this->model->{$this->quantityKeyFrom};
    }

    public function onLoadRecord()
    {
        $formWidgets = [];
        $availableLocations = $this->getAvailableLocations();
        foreach ($availableLocations as $location) {
            $formWidgets[] = $this->makeStockFormWidget($location);
        }

        $stockableName = $this->getStockableName();

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

    protected function getAvailableLocations()
    {
        if ($this->model instanceof Menu_option_values_model)
            return $this->model->option->locations;

        return $this->model->locations;
    }

    protected function makeStockFormWidget($location)
    {
        $widgetConfig = is_string($this->form)
            ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;

        $widgetConfig['model'] = $this->model->getStockByLocation($location);
        $widgetConfig['alias'] = 'StockEditor';
        $widgetConfig['arrayName'] = 'Stock['.$location->getKey().']';
        $widgetConfig['context'] = $this->formField->context;
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }

    protected function getStockableName()
    {
        return $this->model instanceof Menu_option_values_model
            ? $this->model->value
            : $this->model->menu_name;
    }
}
