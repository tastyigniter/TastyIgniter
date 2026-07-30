<?php

declare(strict_types=1);

namespace Igniter\Local\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Classes\OrderTypes;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\WorkingHour;
use Illuminate\Support\Facades\DB;
use Override;

class ScheduleEditor extends BaseFormWidget
{
    use ValidatesForm;

    /**
     * @var Location Form model object.
     */
    public ?Model $model = null;

    public $form;

    public $popupSize = 'modal-lg';

    public $formTitle = 'igniter.local::default.text_title_schedule';

    protected $availableSchedules = [
        Location::OPENING,
        Location::DELIVERY,
        Location::COLLECTION,
    ];

    protected $schedulesCache;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'popupSize',
            'formTitle',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('scheduleeditor/scheduleeditor');
    }

    public function prepareVars(): void
    {
        $this->model->getWorkingHours();

        $this->vars['field'] = $this->formField;
        $this->vars['schedules'] = $this->listSchedules();
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('vendor/timesheet/timesheet.js', 'timesheet-js');
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('scheduleeditor.js', 'scheduleeditor-js');

        $this->addCss('vendor/timesheet/timesheet.css', 'timesheet-css');
        $this->addCss('scheduleeditor.css', 'scheduleeditor-css');
    }

    public function onLoadRecord(): string
    {
        throw_unless($scheduleCode = input('recordId'),
            new FlashException(lang('igniter.local::default.alert_schedule_not_found')),
        );

        $scheduleItem = $this->getSchedule($scheduleCode);

        $formTitle = sprintf(lang($this->formTitle), lang($scheduleItem->name));

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $scheduleCode,
            'formTitle' => $formTitle,
            'formWidget' => $this->makeScheduleFormWidget($scheduleItem),
        ]);
    }

    public function onSaveRecord(): array
    {
        throw_unless($scheduleCode = input('recordId'),
            new FlashException(lang('igniter.local::default.alert_schedule_not_found')),
        );

        $scheduleItem = $this->getSchedule($scheduleCode);

        $form = $this->makeScheduleFormWidget($scheduleItem);

        $saveData = $this->validateFormWidget($form, $form->getSaveData());

        DB::transaction(function() use ($scheduleCode, $saveData): void {
            $this->model->updateSchedule($scheduleCode, $saveData);

            // Check overlaps
            $this->model->newWorkingSchedule($scheduleCode);
        });

        $formName = sprintf('%s %s', $scheduleCode, lang('igniter.local::default.text_schedule'));
        flash()->success(sprintf(lang('igniter::admin.alert_success'), ucfirst($formName).' '.'updated'))->now();

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
        throw_unless($schedule = array_get($this->listSchedules(), $scheduleCode),
            new FlashException(lang('igniter.local::default.alert_schedule_not_loaded')),
        );

        return $schedule;
    }

    protected function listSchedules()
    {
        if ($this->schedulesCache) {
            return $this->schedulesCache;
        }

        $schedules = collect(resolve(OrderTypes::class)->listOrderTypes())
            ->prepend(['name' => 'igniter::admin.text_opening'], Location::OPENING)
            ->mapWithKeys(function($definition, $code): array {
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
        $widgetConfig['model'] = new WorkingHour;
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
