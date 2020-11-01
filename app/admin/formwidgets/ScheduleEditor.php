<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\FormWidgets\ScheduleEditor\Source\ScheduleSource;
use Admin\Models\Working_hours_model;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Location\Models\AbstractLocation;

class ScheduleEditor extends BaseFormWidget
{
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

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['schedules'] = $this->listSchedules();
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

    public function onLoadRecord()
    {
        $scheduleCode = post('recordId');
        if (!in_array($scheduleCode, $this->availableSchedules))
            throw new ApplicationException('Invalid schedule');

        $formTitle = sprintf(lang($this->formTitle), $scheduleCode);

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $scheduleCode,
            'formTitle' => $formTitle,
            'formWidget' => $this->makeScheduleFormWidget($scheduleCode),
        ]);
    }

    public function onSaveRecord()
    {
        $scheduleCode = post('recordId');
        if (!in_array($scheduleCode, $this->availableSchedules))
            throw new ApplicationException('Invalid schedule');

        $formName = sprintf('%s %s', $scheduleCode, lang('admin::lang.locations.text_schedule'));

        $form = $this->makeScheduleFormWidget($scheduleCode);
        $saveData = $form->getSaveData();

        $this->validate($saveData, $form->getConfig('rules', []));

        $this->saveSchedule($scheduleCode, $saveData);

        flash()->success(sprintf(lang('admin::lang.alert_success'), ucfirst($formName).' '.'updated'))->now();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('schedules') => $this->makePartial('scheduleeditor/schedules'),
        ];
    }

    protected function listSchedules()
    {
        if ($this->schedulesCache)
            return $this->schedulesCache;

        $schedules = [];
        foreach ($this->availableSchedules as $scheduleCode) {
            $schedules[$scheduleCode] = $this->loadSchedule($scheduleCode);
        }

        return $this->schedulesCache = $schedules;
    }

    protected function loadSchedule($scheduleCode)
    {
        $scheduleObj = new \stdClass();

        $scheduleObj->code = $scheduleCode;
        $scheduleObj->hours = $this->getScheduleHours($scheduleCode);
        $scheduleObj->config = array_get($this->model->getOption('hours', []), $scheduleCode, []);

        return $scheduleObj;
    }

    protected function getScheduleHours($scheduleCode)
    {
        $workingHours = $this->model->getWorkingHoursByType($scheduleCode);

        return collect(
            Working_hours_model::$weekDays
        )->map(function ($day, $index) use ($workingHours) {
            $hourObj = new \stdClass();

            $hours = ['--'];
            if ($workingHours) {
                $hours = $workingHours->where(
                    'weekday', $index
                )->map(function ($workingHour) {
                    return sprintf('%s-%s', $workingHour->getOpen(), $workingHour->getClose());
                })->all();
            }

            $hourObj->day = $day;
            $hourObj->hours = implode(', ', $hours);

            return $hourObj;
        });
    }

    protected function makeScheduleFormWidget($scheduleCode)
    {
        $scheduleData = array_get($this->model->getOption('hours'), $scheduleCode);

        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = Working_hours_model::make();
        $widgetConfig['data'] = new ScheduleSource($scheduleData);
        $widgetConfig['alias'] = $this->alias.'Form'.'schedule-editor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[scheduleData]';
        $widgetConfig['context'] = 'edit';
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }

    protected function saveSchedule($scheduleCode, $saveData)
    {
        $source = new ScheduleSource($saveData);

        $this->model->working_hours()->where('type', $scheduleCode)->delete();

        foreach ($source->getHours() as $day => $hours) {
            foreach ($hours as $hour) {
                $this->model->working_hours()->create([
                    'location_id' => $this->model->getKey(),
                    'weekday' => $hour['day'],
                    'type' => $scheduleCode,
                    'opening_time' => mdate('%H:%i', strtotime($hour['open'])),
                    'closing_time' => mdate('%H:%i', strtotime($hour['close'])),
                    'status' => $hour['status'],
                ]);
            }
        }

        $locationHours = $this->model->getOption('hours');
        array_set($locationHours, $scheduleCode, $saveData);
        $this->model->setOption('hours', $locationHours);

        return $this->model->save();
    }
}
