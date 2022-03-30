<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Models\Locations_model;
use Admin\Models\Working_hours_model;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Location\Models\AbstractLocation;
use Igniter\Flame\Location\OrderTypes;
use Illuminate\Support\Facades\DB;

class ScheduleEditor extends BaseFormWidget
{
    use ValidatesForm;

    /**
     * @var \Admin\Models\Locations_model Form model object.
     */
    public $model;

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
        $scheduleItem = $this->getSchedule($scheduleCode);

        $formTitle = sprintf(lang($this->formTitle), lang($scheduleItem->name));

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $scheduleCode,
            'formTitle' => $formTitle,
            'formWidget' => $this->makeScheduleFormWidget($scheduleItem),
        ]);
    }

    public function onSaveRecord()
    {
        $scheduleCode = post('recordId');
        $scheduleItem = $this->getSchedule($scheduleCode);

        $form = $this->makeScheduleFormWidget($scheduleItem);
        $saveData = $form->getSaveData();

        $this->validateFormWidget($form, $saveData);

        DB::transaction(function () use ($scheduleCode, $saveData) {
            $this->model->updateSchedule($scheduleCode, $saveData);

            // Check overlaps
            $this->model->newWorkingSchedule($scheduleCode);
        });

        $formName = sprintf('%s %s', $scheduleCode, lang('admin::lang.locations.text_schedule'));
        flash()->success(sprintf(lang('admin::lang.alert_success'), ucfirst($formName).' '.'updated'))->now();

        $this->model->reloadRelations();
        $this->schedulesCache = null;

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('schedules') => $this->makePartial('scheduleeditor/schedules'),
        ];
    }

    protected function getSchedule($scheduleCode)
    {
        if (!$schedule = array_get($this->listSchedules(), $scheduleCode))
            throw new ApplicationException(lang('admin::lang.locations.alert_schedule_not_loaded'));

        return $schedule;
    }

    protected function listSchedules()
    {
        if ($this->schedulesCache)
            return $this->schedulesCache;

        $schedules = collect(OrderTypes::instance()->listOrderTypes())
            ->prepend(['name' => 'admin::lang.text_opening'], Locations_model::OPENING)
            ->mapWithKeys(function ($definition, $code) {
                $scheduleItem = $this->model->createScheduleItem($code);
                $scheduleItem->name = array_get($definition, 'name');

                return [$code => $scheduleItem];
            })
            ->all();

        return $this->schedulesCache = $schedules;
    }

    protected function makeScheduleFormWidget($scheduleItem)
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = Working_hours_model::make();
        $widgetConfig['data'] = $scheduleItem;
        $widgetConfig['alias'] = $this->alias.'FormScheduleEditor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[scheduleData]';
        $widgetConfig['context'] = 'edit';
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }
}
