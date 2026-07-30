<?php

declare(strict_types=1);

namespace Igniter\Admin\Widgets;

use Carbon\Carbon;
use Igniter\Admin\Classes\BaseWidget;
use Igniter\Flame\Exception\SystemException;
use Override;

class Calendar extends BaseWidget
{
    /** Defines the width-to-height aspect ratio of the calendar. */
    public int $aspectRatio = 2;

    /** Determines whether the events on the calendar can be modified. */
    public bool $editable = true;

    /** Defines the number of events displayed on a day */
    public int $eventLimit = 5;

    /** Defines initial date displayed when the calendar first loads. */
    public ?string $defaultDate = null;

    /** Defines the event popover partial. */
    public ?string $popoverPartial = null;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'aspectRatio',
            'editable',
            'eventLimit',
            'defaultDate',
            'popoverPartial',
        ]);
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('js/vendor.datetime.js', 'vendor-datetime-js');
        $this->addCss('formwidgets/datepicker.css', 'datepicker-css');

        $this->addJs('js/locales/fullcalendar/locales-all.min.js', 'fullcalendar-locales-js');

        $this->addJs('calendar.js', 'calendar-js');
        $this->addCss('calendar.css', 'calendar-css');
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('calendar/calendar');
    }

    public function prepareVars(): void
    {
        $this->vars['aspectRatio'] = $this->aspectRatio;
        $this->vars['editable'] = $this->editable;
        $this->vars['defaultDate'] = $this->defaultDate ?: Carbon::now()->toDateString();
        $this->vars['eventLimit'] = $this->eventLimit;
    }

    public function onGenerateEvents(): array
    {
        $startAt = request()->input('start');
        $endAt = request()->input('end');

        $eventResults = $this->fireEvent('calendar.generateEvents', [$startAt, $endAt]);

        $generatedEvents = [];
        if (count($eventResults) > 0) {
            $generatedEvents = array_merge(...$eventResults);
        }

        return [
            'generatedEvents' => $generatedEvents,
        ];
    }

    public function onUpdateEvent(): void
    {
        $eventId = request()->input('eventId', '');
        $startAt = request()->input('start');
        $endAt = request()->input('end');

        $this->fireEvent('calendar.updateEvent', [$eventId, $startAt, $endAt]);
    }

    public function renderPopoverPartial(): mixed
    {
        if (!$this->popoverPartial) {
            throw new SystemException(sprintf(lang('igniter::admin.calendar.missing_partial'), $this->controller::class));
        }

        return $this->makePartial($this->popoverPartial);
    }
}
