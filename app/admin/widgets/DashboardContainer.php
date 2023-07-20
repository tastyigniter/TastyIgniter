<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Classes\Widgets;
use Admin\Models\User_preferences_model;
use Admin\Traits\ValidatesForm;
use Igniter\Flame\Exception\ApplicationException;

class DashboardContainer extends BaseWidget
{
    use ValidatesForm;

    //
    // Configurable properties
    //

    /**
     * @var string The unique dashboard context name
     * Defines the context where the container is used.
     * Widget settings are saved in a specific context.
     */
    public $context = 'dashboard';

    /**
     * @var string Determines whether widgets could be added and deleted.
     */
    public $canManage = true;

    /**
     * @var string Determines whether widgets could be set as default.
     */
    public $canSetDefault = false;

    public $dateRangeFormat = 'MMMM D, YYYY';

    public $startDate;

    public $endDate;

    /**
     * @var array A list of default widgets to load.
     * This structure could be defined in the controller containerConfig property
     * Example structure:
     *
     * public $containerConfig = [
     *     'trafficOverview' => [
     *         'class' => Igniter\GoogleAnalytics\DashboardWidgets\TrafficOverview::class,
     *         'priority' => 1,
     *         'config' => [
     *             title => 'Traffic overview',
     *             width => 10,
     *          ],
     *     ]
     * ];
     */
    public $defaultWidgets = [];

    //
    // Object properties
    //

    /**
     * {@inheritdoc}
     */
    protected $defaultAlias = 'dashboardContainer';

    /**
     * @var array Collection of all dashboard widgets used by this container.
     */
    protected $dashboardWidgets = [];

    /**
     * @var bool Determines if dashboard widgets have been created.
     */
    protected $widgetsDefined = false;

    /**
     * Constructor.
     * @param $controller
     * @param array $config
     */
    public function __construct($controller, $config = [])
    {
        parent::__construct($controller, $config);

        $this->fillFromConfig();
    }

    /**
     * Ensure dashboard widgets are registered so they can also be bound to
     * the controller this allows their AJAX features to operate.
     * @return void
     */
    public function bindToController()
    {
        $this->defineDashboardWidgets();
        parent::bindToController();
    }

    /**
     * Renders this widget along with its collection of dashboard widgets.
     */
    public function render()
    {
        $this->vars['startDate'] = $this->startDate = $this->getStartDate();
        $this->vars['endDate'] = $this->endDate = $this->getEndDate();
        $this->vars['dateRangeFormat'] = $this->dateRangeFormat;

        return $this->makePartial('dashboardcontainer/dashboardcontainer');
    }

    public function loadAssets()
    {
        $this->addJs('~/app/admin/formwidgets/repeater/assets/vendor/sortablejs/Sortable.min.js', 'sortable-js');
        $this->addJs('~/app/admin/formwidgets/repeater/assets/vendor/sortablejs/jquery-sortable.js', 'jquery-sortable-js');

        $this->addJs('~/app/admin/assets/src/js/vendor/moment.min.js', 'moment-js');
        $this->addJs('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.js', 'daterangepicker-js');
        $this->addCss('~/app/admin/dashboardwidgets/charts/assets/vendor/daterange/daterangepicker.css', 'daterangepicker-css');

        $this->addCss('css/dashboardcontainer.css');
        $this->addJs('js/dashboardcontainer.js');
    }

    //
    // Event handlers
    //

    public function onRenderWidgets()
    {
        $this->defineDashboardWidgets();

        $this->vars['widgets'] = $this->dashboardWidgets;

        return ['#'.$this->getId('container') => $this->makePartial('dashboardcontainer/widget_container')];
    }

    public function onLoadAddPopup()
    {
        $this->vars['gridColumns'] = $this->getWidgetPropertyWidthOptions();
        $this->vars['widgets'] = collect(Widgets::instance()->listDashboardWidgets())->pluck('label', 'code');

        return ['#'.$this->getId('new-widget-modal-content') => $this->makePartial('new_widget_popup')];
    }

    public function onLoadUpdatePopup()
    {
        $widgetAlias = trim(post('widgetAlias'));

        if (!$widgetAlias)
            throw new ApplicationException(lang('admin::lang.dashboard.alert_select_widget_to_update'));

        $this->vars['widgetAlias'] = $widgetAlias;
        $this->vars['widget'] = $widget = $this->findWidgetByAlias($widgetAlias);
        $this->vars['widgetForm'] = $this->getFormWidget($widgetAlias, $widget);

        return ['#'.$widgetAlias.'-modal-content' => $this->makePartial('widget_form')];
    }

    public function onAddWidget()
    {
        $validated = $this->validate(request()->post(), [
            'widget' => ['required', 'alpha_dash'],
            'size' => ['nullable', 'integer'],
        ]);

        throw_unless(
            $widgetClass = Widgets::instance()->resolveDashboardWidget($widgetCode = array_get($validated, 'widget')),
            new ApplicationException(lang('admin::lang.dashboard.alert_widget_class_not_found'))
        );

        $widget = $this->makeWidget($widgetClass, ['widget' => $widgetCode]);
        throw_unless(
            $widget instanceof \Admin\Classes\BaseDashboardWidget,
            new ApplicationException(lang('admin::lang.dashboard.alert_invalid_widget'))
        );

        $widgetAlias = $widgetCode.'_'.str_random(5);
        $this->addWidget($widgetAlias, $widget, array_get($validated, 'size'));

        return [
            '@#'.$this->getId('container-list') => $this->makePartial('widget_item', [
                'widget' => $widget,
                'widgetAlias' => $widgetAlias,
            ]),
        ];
    }

    public function onResetWidgets()
    {
        if (!$this->canManage) {
            throw new ApplicationException(lang('admin::lang.alert_access_denied'));
        }

        $this->resetWidgets();

        $this->vars['widgets'] = $this->dashboardWidgets;

        flash()->success(lang('admin::lang.dashboard.alert_reset_layout_success'));

        return ['#'.$this->getId('container-list') => $this->makePartial('widget_list')];
    }

    public function onSetAsDefault()
    {
        if (!$this->canSetDefault) {
            throw new ApplicationException(lang('admin::lang.alert_access_denied'));
        }

        $widgets = $this->getWidgetsFromUserPreferences();

        params()->set($this->getSystemParametersKey(), $widgets);

        flash()->success(lang('admin::lang.dashboard.make_default_success'));
    }

    public function onUpdateWidget()
    {
        if (!$this->canManage) {
            throw new ApplicationException(lang('admin::lang.alert_access_denied'));
        }

        $alias = post('alias');
        $widget = $this->findWidgetByAlias($alias);

        [$rules, $attributes] = $widget->getPropertyRules();

        $validated = $this->validate(request()->post($alias.'_fields'), array_merge([
            'width' => ['numeric'],
        ], $rules), $attributes);

        $widget->mergeProperties($validated);

        $this->saveWidgetProperties($alias, $widget->getPropertiesToSave());

        $widget->initialize();

        $this->widgetsDefined = false;

        return $this->onRenderWidgets();
    }

    public function onRemoveWidget()
    {
        $alias = post('alias');

        $this->removeWidget($alias);
    }

    /**
     * @param \Admin\Classes\BaseDashboardWidget $widget
     * @param $size
     *
     * @return array
     * @throws \Igniter\Flame\Exception\ApplicationException
     */
    public function addWidget($widgetAlias, $widget, $size)
    {
        if (!$this->canManage) {
            throw new ApplicationException(lang('admin::lang.alert_access_denied'));
        }

        $widgets = $this->getWidgetsFromUserPreferences();

        $nextPriority = collect($widgets)->max('priority') + 1;

        $widget->setProperty('width', $size);
        $widget->setProperty('priority', $nextPriority);

        $widgets[$widgetAlias] = $widget->getPropertiesToSave();

        $this->setWidgetsToUserPreferences($widgets);
    }

    public function onSetWidgetPriorities()
    {
        $validated = $this->validate(request()->post(), [
            'aliases' => ['required', 'array'],
            'aliases.*' => ['alpha_dash'],
        ]);

        $aliases = array_get($validated, 'aliases');

        $this->setWidgetsToUserPreferences(
            collect($this->getWidgetsFromUserPreferences())
                ->mapWithKeys(function ($widget, $alias) use ($aliases) {
                    $widget['priority'] = (int)array_search($alias, $aliases);

                    return [$alias => $widget];
                })->all()
        );

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Dashboard widgets updated'))->now();
    }

    public function onSetDateRange()
    {
        $validated = $this->validate(request()->post(), [
            'start' => ['nullable', 'date'],
            'end' => ['nullable', 'date'],
        ]);

        $start = make_carbon(array_get($validated, 'start'));
        $end = make_carbon(array_get($validated, 'end'));
        if ($start->isSameDay($end)) {
            $start = $start->startOfDay();
            $end = $end->endOfDay();
        }

        $this->vars['startDate'] = $this->startDate = $start;
        $this->vars['endDate'] = $this->endDate = $end;

        $this->putSession('startDate', $start);
        $this->putSession('endDate', $end);

        $this->widgetsDefined = false;

        return $this->onRenderWidgets();
    }

    //
    // Helpers
    //

    public function getStartDate()
    {
        return $this->getSession('startDate', now()->subDays(29));
    }

    public function getEndDate()
    {
        return $this->getSession('endDate', now());
    }

    /**
     * Registers the dashboard widgets that will be included in this container.
     * The chosen widgets are based on the user preferences.
     */
    protected function defineDashboardWidgets()
    {
        if ($this->widgetsDefined) {
            return;
        }

        $start = $this->getStartDate();
        $end = $this->getEndDate();

        $widgets = collect($this->getWidgetsFromUserPreferences())
            ->sortBy('priority')
            ->mapWithKeys(function ($widgetInfo, $alias) use ($start, $end) {
                if ($widget = $this->makeDashboardWidget($alias, $widgetInfo)) {
                    $widget->setProperty('startDate', $start);
                    $widget->setProperty('endDate', $end);

                    return [$alias => $widget];
                }

                return [];
            })->filter()->all();

        $this->dashboardWidgets = $widgets;

        $this->widgetsDefined = true;
    }

    protected function makeDashboardWidget($alias, $widgetConfig)
    {
        $widgetConfig['alias'] = $alias;

        $widgetConfig['widget'] = $widgetCode = $widgetConfig['widget'] ?? $widgetConfig['class'] ?? $alias;
        $widgetClass = Widgets::instance()->resolveDashboardWidget($widgetCode);

        $widget = $this->makeWidget($widgetClass, $widgetConfig);
        $widget->bindToController();

        return $widget;
    }

    protected function resetWidgets()
    {
        $this->resetWidgetsUserPreferences();

        $this->widgetsDefined = false;

        $this->defineDashboardWidgets();
    }

    protected function removeWidget($alias)
    {
        if (!$this->canManage) {
            throw new ApplicationException(lang('admin::lang.alert_access_denied'));
        }

        $widgets = $this->getWidgetsFromUserPreferences();

        if (isset($widgets[$alias])) {
            unset($widgets[$alias]);
        }

        $this->setWidgetsToUserPreferences($widgets);
    }

    protected function getFormWidget($alias, $widget)
    {
        $formConfig['fields'] = $this->getWidgetPropertyConfig($widget);

        $formConfig['model'] = User_preferences_model::onUser();
        $formConfig['data'] = $this->getWidgetPropertyValues($widget);
        $formConfig['previewMode'] = $this->previewMode;
        $formConfig['alias'] = $this->alias.studly_case('Form_'.$alias);
        $formConfig['arrayName'] = $alias.'_fields';

        $formWidget = $this->makeWidget('Admin\Widgets\Form', $formConfig);
        $formWidget->bindToController();

        return $formWidget;
    }

    protected function findWidgetByAlias($alias)
    {
        $this->defineDashboardWidgets();

        $widgets = $this->dashboardWidgets;
        if (!isset($widgets[$alias])) {
            throw new ApplicationException(lang('admin::lang.dashboard.alert_widget_not_found'));
        }

        return $widgets[$alias];
    }

    protected function getWidgetClassName($widget)
    {
        return get_class($widget);
    }

    protected function getWidgetPropertyConfigTitle($widget)
    {
        $config = $this->getWidgetPropertyConfig($widget);

        return array_get($config, 'title');
    }

    /**
     * @param \Admin\Classes\BaseDashboardWidget $widget
     *
     * @return array
     */
    protected function getWidgetPropertyConfig($widget)
    {
        $properties = $widget->defineProperties();

        $result = [
            'width' => [
                'property' => 'width',
                'label' => lang('admin::lang.dashboard.label_widget_columns'),
                'comment' => lang('admin::lang.dashboard.help_widget_columns'),
                'type' => 'select',
                'options' => $this->getWidgetPropertyWidthOptions(),
            ],
        ];

        foreach ($properties as $name => $params) {
            $propertyType = array_get($params, 'type', 'text');

            if (!$this->checkWidgetPropertyType($propertyType)) continue;

            $property = [
                'property' => $name,
                'label' => isset($params['label']) ? lang($params['label']) : $name,
                'type' => $propertyType,
            ];

            foreach ($params as $key => $value) {
                if (isset($property[$key])) {
                    continue;
                }

                $property[$key] = !is_array($value) ? lang($value) : $value;
            }

            $result[$name] = $property;
        }

        return $result;
    }

    /**
     * @param \Admin\Classes\BaseDashboardWidget $widget
     *
     * @return array
     */
    protected function getWidgetPropertyValues($widget)
    {
        $result = [];

        $properties = $widget->defineProperties();
        foreach ($properties as $name => $params) {
            $result[$name] = lang($widget->property($name));
        }

        $result['width'] = $widget->property('width');

        return $result;
    }

    protected function getWidgetPropertyWidthOptions()
    {
        $sizes = [];
        for ($i = 1; $i <= 12; $i++) {
            $sizes[$i] = $i;
        }

        return $sizes;
    }

    protected function checkWidgetPropertyType($type)
    {
        return in_array($type, [
            'text',
            'textarea',
            'number',
            'checkbox',
            'radio',
            'select',
            'selectlist',
            'switch',
        ]);
    }

    //
    // User Preferences
    //

    protected function getWidgetsFromUserPreferences()
    {
        $defaultWidgets = params()->get($this->getSystemParametersKey(), $this->defaultWidgets);

        $widgets = User_preferences_model::onUser()
            ->get($this->getUserPreferencesKey(), $defaultWidgets);

        if (!is_array($widgets)) {
            return [];
        }

        return $widgets;
    }

    protected function setWidgetsToUserPreferences($widgets)
    {
        User_preferences_model::onUser()->set($this->getUserPreferencesKey(), $widgets);
    }

    protected function resetWidgetsUserPreferences()
    {
        User_preferences_model::onUser()->reset($this->getUserPreferencesKey());
    }

    protected function saveWidgetProperties($alias, $properties)
    {
        $widgets = $this->getWidgetsFromUserPreferences();

        if (isset($widgets[$alias])) {
            $widgets[$alias] = $properties;

            $this->setWidgetsToUserPreferences($widgets);
        }
    }

    protected function getUserPreferencesKey()
    {
        return 'admin_dashboardwidgets_'.$this->context;
    }

    protected function getSystemParametersKey()
    {
        return 'admin_dashboardwidgets_default_'.$this->context;
    }

    protected function getUniqueAlias($widgets)
    {
        $num = count($widgets);
        do {
            $num++;
            $alias = 'dashboard_container_'.$this->context.'_'.$num;
        } while (array_key_exists($alias, $widgets));

        return $alias;
    }
}
