<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Models\Tables_model;
use Admin\Traits\FormModelWidget;
use Admin\Widgets\Form;
use Igniter\Flame\Exception\ApplicationException;

/**
 * Seat Map
 *
 * @package Admin
 */
class SeatMap extends BaseFormWidget
{
    use FormModelWidget;

    //
    // Object properties
    //

    protected $defaultAlias = 'seatmap';

    protected $sortableInputName;

    public $sortColumnName = 'priority';

    protected $form;

    protected $formWidgets = [];

    public function initialize()
    {
        $this->fillFromConfig([
            'prompt',
            'form',
        ]);
    }

    public function loadAssets()
    {
        $this->addJs('js/seatmap.js', 'seatmap-js');
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('seatmap/seatmap');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['seats'] = $this->getRelationObject()->get();

        $this->vars['sortableInputName'] = $this->sortableInputName;
    }

    public function onRefresh()
    {
        $this->prepareVars();

        return [
            '#'.$this->getId('seats') => $this->makePartial('seats'),
        ];
    }

    public function onAttachTable()
    {
        $tableId = post('Location._table');
        if (!$table = Tables_model::find($tableId))
            throw new ApplicationException('Please select a table to attach');

        $this->getRelationObject()->syncWithoutDetaching([$table->getKey()]);

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Table attached'))->now();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('seats') => $this->makePartial('seats'),
        ];
    }

    public function onLoadRecord()
    {
        $recordId = post('recordId');
        $model = $this->getRelationModel()->find($recordId);

        if (!$model)
            throw new ApplicationException('Record not found');

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle' => 'Edit '.lang($this->formName),
            'formWidget' => $this->makeItemFormWidget($model, 'edit'),
        ]);
    }

    public function onDeleteRecord()
    {
        if (!strlen($recordId = post('recordId')))
            return FALSE;

        $this->getRelationObject()->detach($recordId);

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($this->formName).' deleted'))->now();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('seats') => $this->makePartial('seats'),
        ];
    }

    protected function makeItemFormWidget($model, $context)
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'Form'.'seatmap';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[seatmapData]';
        $widgetConfig['context'] = $context;
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
