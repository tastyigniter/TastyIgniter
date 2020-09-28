<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Models\Working_hours_model;
use Admin\Traits\FormModelWidget;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Location\Models\AbstractLocation;

class ScheduleEditor extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    /**
     * @var Orders_model|\Admin\Models\Reservations_model Form model object.
     */
    public $model;

    public $form;

    public $formTitle = 'admin::lang.locations.text_title_schedule';

    protected $availableSchedules = [
        AbstractLocation::OPENING,
        AbstractLocation::DELIVERY,
        AbstractLocation::COLLECTION,
    ];

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('scheduleeditor/scheduleeditor');
    }

    public function onLoadRecord()
    {
        $scheduleCode = post('recordId');
        if (!in_array($scheduleCode, $this->availableSchedules))
            throw new ApplicationException('Invalid schedule');

//        $model = $this->getRelationModel()->find($recordId);
//
//        if (!$model)
//            throw new ApplicationException('Record not found');

        $formTitle = sprintf(lang($this->formTitle), $scheduleCode);

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $scheduleCode,
            'formTitle' => $formTitle,
            'formWidget' => $this->makeScheduleFormWidget($scheduleCode),
        ]);
    }

    public function loadAssets()
    {
        $this->addJs('../../recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('js/scheduleeditor.js', 'scheduleeditor-js');
    }

    public function prepareVars()
    {
        $this->vars['schedules'] = $this->listSchedules();
        $this->vars['field'] = $this->formField;
    }

    protected function listSchedules()
    {
        return $this->availableSchedules;
    }

    protected function makeScheduleFormWidget($scheduleCode)
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = Working_hours_model::make();
        $widgetConfig['alias'] = $this->alias.'Form'.'schedule-editor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[scheduleData]';
        $widgetConfig['context'] = 'edit';
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
