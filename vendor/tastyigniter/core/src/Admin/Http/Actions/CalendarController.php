<?php

declare(strict_types=1);

namespace Igniter\Admin\Http\Actions;

use Igniter\Admin\Facades\Template;
use Igniter\Admin\Widgets\Calendar;
use Igniter\Admin\Widgets\Toolbar;
use Igniter\System\Classes\ControllerAction;

class CalendarController extends ControllerAction
{
    /** The primary calendar alias to use. */
    protected string $primaryAlias = 'calendar';

    /**
     * Define controller calendar configuration array.
     *  $calendarConfig = [
     *      'calendar'  => [
     *          'title'         => 'lang:text_title',
     *          'configFile'   => null,
     *      ],
     *  ];
     */
    public array $calendarConfig = [];

    /**
     * @var Calendar[] Reference to the list widget objects
     */
    protected array $calendarWidgets = [];

    protected ?Toolbar $toolbarWidget = null;

    public array $requiredProperties = ['calendarConfig'];

    /**
     * @var array Required controller configuration array keys
     */
    protected array $requiredConfig = ['configFile'];

    public function __construct($controller)
    {
        parent::__construct($controller);

        $this->calendarConfig = $controller->calendarConfig;
        $this->primaryAlias = key($controller->calendarConfig);

        // Build configuration
        $this->setConfig($controller->calendarConfig[$this->primaryAlias], $this->requiredConfig);

        $this->hideAction([
            'renderCalendar',
            'refreshCalendar',
            'getCalendarWidget',
            'calendarExtendModel',
        ]);
    }

    public function calendar(): void
    {
        $pageTitle = lang($this->getConfig('title', 'lang:text_title'));
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        $this->makeCalendars();
    }

    protected function makeCalendars(): array
    {
        $this->calendarWidgets = [];

        foreach (array_keys($this->calendarConfig) as $alias) {
            $this->calendarWidgets[$alias] = $this->makeCalendar($alias);
        }

        return $this->calendarWidgets;
    }

    /**
     * Prepare the widgets used by this action
     */
    protected function makeCalendar(?string $alias = null): Calendar
    {
        $alias ??= $this->primaryAlias;

        $calendarConfig = $this->makeConfig($this->calendarConfig[$alias], $this->requiredConfig);
        $calendarConfig['alias'] = $alias;

        // Prep the list widget config
        $configFile = $calendarConfig['configFile'];
        $modelConfig = $this->loadConfig($configFile, ['calendar'], 'calendar');

        /** @var Calendar $widget */
        $widget = $this->makeWidget(Calendar::class, $calendarConfig);

        $widget->bindEvent('calendar.generateEvents', fn($startAt, $endAt) => $this->controller->calendarGenerateEvents($startAt, $endAt));

        $widget->bindEvent('calendar.updateEvent', fn($eventId, $startAt, $endAt) => $this->controller->calendarUpdateEvent($eventId, $startAt, $endAt));

        $widget->bindToController();

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar'], $this->controller->widgets['toolbar'])) {
            $this->toolbarWidget = $this->controller->widgets['toolbar'];
            $this->toolbarWidget->reInitialize($modelConfig['toolbar']);
        }

        return $widget;
    }

    public function renderCalendar(?string $alias = null, bool $noToolbar = false): string
    {
        if (is_null($alias) || !isset($this->calendarConfig[$alias])) {
            $alias = $this->primaryAlias;
        }

        $list = [];

        if (!$noToolbar && !is_null($this->toolbarWidget)) {
            $list[] = $this->toolbarWidget->render();
        }

        $list[] = $this->calendarWidgets[$alias]->render();

        return implode(PHP_EOL, $list);
    }

    public function renderCalendarToolbar(): ?string
    {
        return $this->toolbarWidget?->render() ?: null;
    }

    /**
     * Returns the widget used by this behavior.
     */
    public function getCalendarWidget(?string $alias = null): Calendar
    {
        if (!$alias) {
            $alias = $this->primaryAlias;
        }

        return array_get($this->calendarWidgets, $alias);
    }

    public function calendarGenerateEvents(?string $startAt, ?string $endAt): array
    {
        return [];
    }

    public function calendarUpdateEvent(string $eventId, ?string $startAt, ?string $endAt) {}
}
