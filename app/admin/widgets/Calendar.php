<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Carbon\Carbon;
use Exception;
use Input;

class Calendar extends BaseWidget
{
    /**
     * @var string Defines the width-to-height aspect ratio of the calendar.
     */
    public $aspectRatio = 2;

    /**
     * @var string Determines whether the events on the calendar can be modified.
     */
    public $editable = TRUE;

    /**
     * @var string Defines the number of events displayed on a day
     */
    public $eventLimit = 5;

    /**
     * @var string Defines initial date displayed when the calendar first loads.
     */
    public $defaultDate;

    /**
     * @var string Defines the event popover partial.
     */
    public $popoverPartial;

    public function initialize()
    {
        $this->fillFromConfig([
            'aspectRatio',
            'editable',
            'eventLimit',
            'defaultDate',
            'popoverPartial',
        ]);
    }

    public function loadAssets()
    {
        $this->addCss('~/app/admin/formwidgets/datepicker/assets/vendor/datepicker/bootstrap-datepicker.min.css', 'bootstrap-datepicker-css');
        $this->addJs('~/app/admin/formwidgets/datepicker/assets/vendor/datepicker/bootstrap-datepicker.min.js', 'bootstrap-datepicker-js');

        $this->addCss('~/app/admin/formwidgets/datepicker/assets/css/datepicker.css', 'datepicker-css');
        $this->addJs('~/app/admin/formwidgets/datepicker/assets/js/datepicker.js', 'datepicker-js');

        $this->addJs('~/app/system/assets/ui/js/vendor/mustache.js', 'mustache-js');
        $this->addJs('~/app/system/assets/ui/js/vendor/moment.min.js', 'moment-js');

        $this->addJs('vendor/fullcalendar/fullcalendar.min.js', 'fullcalendar-js');
        $this->addCss('vendor/fullcalendar/fullcalendar.min.css', 'fullcalendar-css');

        $this->addJs('js/calendar.js', 'calendar-js');
        $this->addCss('css/calendar.css', 'calendar-css');
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('calendar/calendar');
    }

    public function prepareVars()
    {
        $this->vars['aspectRatio'] = $this->aspectRatio;
        $this->vars['editable'] = $this->editable;
        $this->vars['defaultDate'] = $this->defaultDate ?: Carbon::now()->toDateString();
        $this->vars['eventLimit'] = $this->eventLimit;
    }

    public function onGenerateEvents()
    {
        $startAt = Input::get('start');
        $endAt = Input::get('end');

        $eventResults = $this->fireEvent('calendar.generateEvents', [$startAt, $endAt]);

        $generatedEvents = [];
        if (count($eventResults)) {
            $generatedEvents = $eventResults[0];
        }

        return [
            'generatedEvents' => $generatedEvents,
        ];
    }

    public function onUpdateEvent()
    {
        $eventId = Input::get('eventId');
        $startAt = Input::get('start');
        $endAt = Input::get('end');

        $this->fireEvent('calendar.updateEvent', [$eventId, $startAt, $endAt]);
    }

    public function renderPopoverPartial()
    {
        if (!strlen($this->popoverPartial)) {
            throw new Exception(sprintf(lang('admin::lang.calendar.missing_partial'), get_class($this->controller)));
        }

        return $this->makePartial($this->popoverPartial);
    }
}