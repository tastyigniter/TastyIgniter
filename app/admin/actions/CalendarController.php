<?php

namespace Admin\Actions;

use System\Classes\BaseController;
use System\Classes\ControllerAction;
use Template;

class CalendarController extends ControllerAction
{
    /**
     * @var string The primary calendar alias to use.
     */
    protected $primaryAlias = 'calendar';

    /**
     * Define controller calendar configuration array.
     *  $calendarConfig = [
     *      'calendar'  => [
     *          'title'         => 'lang:text_title',
     *          'configFile'   => null,
     *      ],
     *  ];
     * @var array
     */
    public $calendarConfig;

    /**
     * @var \Admin\Widgets\Calendar[] Reference to the list widget objects
     */
    protected $calendarWidgets;

    /**
     * @var \Admin\Widgets\Toolbar[] Reference to the toolbar widget objects.
     */
    protected $toolbarWidget;

    /**
     * @var \Admin\Widgets\Filter[] Reference to the filter widget objects.
     */
    protected $filterWidgets = [];

    public $requiredProperties = ['calendarConfig'];

    /**
     * @var array Required controller configuration array keys
     */
    protected $requiredConfig = ['configFile'];

    /**
     * List_Controller constructor.
     *
     * @param BaseController $controller
     *
     * @throws \Exception
     */
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

    public function calendar()
    {
        $pageTitle = lang($this->getConfig('title', 'lang:text_title'));
        Template::setTitle($pageTitle);
        Template::setHeading($pageTitle);

        $this->makeCalendars();
    }

    /**
     * Creates all the widgets based on the model config.
     *
     * @return array List of Admin\Classes\BaseWidget objects
     */
    protected function makeCalendars()
    {
        $this->calendarWidgets = [];

        foreach ($this->calendarConfig as $alias => $config) {
            $this->calendarWidgets[$alias] = $this->makeCalendar($alias);
        }

        return $this->calendarWidgets;
    }

    /**
     * Prepare the widgets used by this action
     *
     * @param $alias
     *
     * @return \Admin\Classes\BaseWidget
     */
    protected function makeCalendar($alias)
    {
        if (!isset($this->calendarConfig[$alias]))
            $alias = $this->primaryAlias;

        $calendarConfig = $this->makeConfig($this->calendarConfig[$alias], $this->requiredConfig);
        $calendarConfig['alias'] = $alias;

        // Prep the list widget config
        $configFile = $calendarConfig['configFile'];
        $modelConfig = $this->loadConfig($configFile, ['calendar'], 'calendar');

        $widget = $this->makeWidget('Admin\Widgets\Calendar', $calendarConfig);

        $widget->bindEvent('calendar.generateEvents', function ($startAt, $endAt) {
            return $this->controller->calendarGenerateEvents($startAt, $endAt);
        });

        $widget->bindEvent('calendar.updateEvent', function ($eventId, $startAt, $endAt) {
            return $this->controller->calendarUpdateEvent($eventId, $startAt, $endAt);
        });

        $widget->bindToController();

        // Prep the optional toolbar widget
        if (isset($modelConfig['toolbar']) AND isset($this->controller->widgets['toolbar'])) {
            $this->toolbarWidget = $this->controller->widgets['toolbar'];
            if ($this->toolbarWidget instanceof \Admin\Widgets\Toolbar)
                $this->toolbarWidget->addButtons(array_get($modelConfig['toolbar'], 'buttons', []));
        }

        return $widget;
    }

    public function renderCalendar($alias = null)
    {
        if (is_null($alias) OR !isset($this->listConfig[$alias]))
            $alias = $this->primaryAlias;

        $list = [];

        if (!is_null($this->toolbarWidget)) {
            $list[] = $this->toolbarWidget->render();
        }

        if (isset($this->filterWidgets[$alias])) {
            $list[] = $this->filterWidgets[$alias]->render();
        }

        $list[] = $this->calendarWidgets[$alias]->render();

        return implode(PHP_EOL, $list);
    }

    /**
     * Returns the widget used by this behavior.
     *
     * @param string $alias
     *
     * @return \Admin\Classes\BaseWidget
     */
    public function getCalendarWidget($alias = null)
    {
        if (!$alias) {
            $alias = $this->primaryAlias;
        }

        return array_get($this->calendarWidgets, $alias);
    }

    public function calendarGenerateEvents($startAt, $endAt)
    {
        return [];
    }

    public function calendarUpdateEvent($eventId, $startAt, $endAt)
    {
    }
}