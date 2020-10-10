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

    public $form;

    public $popupSize = 'modal-lg';

    public $formTitle = 'admin::lang.locations.text_title_schedule';

    protected $availableSchedules = [
        AbstractLocation::OPENING,
        AbstractLocation::DELIVERY,
        AbstractLocation::COLLECTION,
    ];

    protected $schedulesCache;

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

    public function onSaveRecord()
    {
    }

    public function loadAssets()
    {
        $this->addCss('../../datepicker/assets/vendor/clockpicker/bootstrap-clockpicker.min.css', 'bootstrap-clockpicker-css');
        $this->addJs('../../datepicker/assets/vendor/clockpicker/bootstrap-clockpicker.min.js', 'bootstrap-clockpicker-js');
        $this->addCss('../../datepicker/assets/css/clockpicker.css', 'clockpicker-css');
        $this->addJs('../../datepicker/assets/js/clockpicker.js', 'clockpicker-js');

        $this->addJs('../../recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('vendor/timesheet/timesheet.js', 'timesheet-js');
        $this->addJs('js/scheduleeditor.js', 'scheduleeditor-js');
        $this->addCss('vendor/timesheet/timesheet.css', 'timesheet-css');
        $this->addCss('css/scheduleeditor.css', 'scheduleeditor-css');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['schedules'] = $this->listSchedules();
    }

    protected function listSchedules()
    {
        if ($this->schedulesCache)
            return $this->schedulesCache;

        $schedules = [];
        foreach ($this->availableSchedules as $schedule) {
            $schedules[$schedule] = $this->loadSchedule($schedule);
        }

        return $this->schedulesCache = $schedules;
    }

    protected function loadSchedule($schedule)
    {
        $scheduleObj = new \stdClass();

        $scheduleObj->code = $schedule;
        $scheduleObj->hours = $this->getScheduleHours($schedule);
        $scheduleObj->config = array_get($this->model->getOption('hours', []), $schedule, []);

        return $scheduleObj;
    }

    protected function getScheduleHours($schedule)
    {
        $weekdays = Working_hours_model::make()->getWeekDaysOptions();

        $hours = $this->model->getWorkingHoursByType($schedule);

        return collect($weekdays)->map(function ($day, $index) use ($hours) {
            $hourObj = new \stdClass();

            $hourObj->day = $day;
            $hourObj->hour = $hours->get($index);

            return $hourObj;
        });
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
