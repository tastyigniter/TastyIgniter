<?php namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Classes\Widgets;
use Admin\Models\User_preferences_model;
use ApplicationException;

class DashboardContainer extends BaseWidget
{
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
    public $canAddAndDelete = TRUE;

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
     * @inheritDoc
     */
    protected $defaultAlias = 'dashboardContainer';

    /**
     * @var array Collection of all dashboard widgets used by this container.
     */
    protected $dashboardWidgets = [];

    /**
     * @var boolean Determines if dashboard widgets have been created.
     */
    protected $widgetsDefined = FALSE;

    /**
     * Constructor.
     * @param $controller
     * @param array $config
     */
    public function __construct($controller, $config = [])
    {
        parent::__construct($controller, $config);

        $this->fillFromConfig();
        $this->bindToController();
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
        return $this->makePartial('dashboardcontainer/dashboardcontainer');
    }

    public function loadAssets()
    {
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
        $this->vars['widgets'] = Widgets::instance()->listDashboardWidgets();

        return ['#'.$this->getId('new-widget-modal-content') => $this->makePartial('new_widget_popup')];
    }

    public function onLoadUpdatePopup()
    {
        $widgetAlias = trim(post('widgetAlias'));

        if (!$widgetAlias)
            throw new ApplicationException('Please select a widget to update.');

        $this->vars['widgetAlias'] = $widgetAlias;
        $this->vars['widget'] = $widget = $this->findWidgetByAlias($widgetAlias);
        $this->vars['widgetForm'] = $this->getFormWidget($widgetAlias, $widget);

        return ['#'.$widgetAlias.'-modal-content' => $this->makePartial('widget_form')];
    }

    public function onAddWidget()
    {
        $className = trim(post('className'));
        $size = trim(post('size'));

        if (!$className)
            throw new ApplicationException('Please select a widget to add.');

        if (!class_exists($className))
            throw new ApplicationException('The selected class does not exist.');

        $widget = new $className($this->controller);
        if (!($widget instanceof \Admin\Classes\BaseDashboardWidget))
            throw new ApplicationException('The selected class is not a dashboard widget.');

        $widgetInfo = $this->addWidget($widget, $size);

        return [
            '@#'.$this->getId('container-list') => $this->makePartial('widget_item', [
                'widget' => $widget,
                'widgetAlias' => $widgetInfo['alias'],
                'priority' => $widgetInfo['priority'],
            ]),
        ];
    }

    public function onResetWidgets()
    {
        $this->resetWidgets();

        $this->vars['widgets'] = $this->dashboardWidgets;

        flash()->success(lang('admin::lang.dashboard.alert_reset_layout_success'));

        return ['#'.$this->getId('container-list') => $this->makePartial('widget_list')];
    }

    public function onSetAsDefault()
    {
        $widgets = $this->getWidgetsFromUserPreferences();

        params()->set($this->getSystemParametersKey(), $widgets);

        flash()->success(lang('admin::lang.dashboard.make_default_success'));
    }

    public function onUpdateWidget()
    {
        $alias = post('alias');

        $widget = $this->findWidgetByAlias($alias);

        $widget->setProperties(post('fields'));

        $this->saveWidgetProperties($alias, $widget->getProperties());

        $widget->initialize();

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
     * @throws \ApplicationException
     */
    public function addWidget($widget, $size)
    {
        if (!$this->canAddAndDelete) {
            throw new ApplicationException('Access denied.');
        }

        $widgets = $this->getWidgetsFromUserPreferences();

        $priority = 0;
        foreach ($widgets as $widgetInfo) {
            $priority = max($priority, $widgetInfo['priority']);
        }

        $priority++;

        $widget->setProperty('width', $size);

        $alias = $this->getUniqueAlias($widgets);

        $widgets[$alias] = [
            'class' => get_class($widget),
            'config' => $widget->getProperties(),
            'priority' => $priority,
        ];

        $this->setWidgetsToUserPreferences($widgets);

        return [
            'alias' => $alias,
            'priority' => $widgets[$alias]['priority'],
        ];
    }

    public function onSetWidgetOrders()
    {
        $aliases = trim(post('aliases'));
        $orders = trim(post('orders'));

        if (!$aliases) {
            throw new ApplicationException('Invalid aliases string.');
        }

        if (!$orders) {
            throw new ApplicationException('Invalid orders string.');
        }

        $aliases = explode(',', $aliases);
        $orders = explode(',', $orders);

        if (count($aliases) != count($orders)) {
            throw new ApplicationException('Invalid data posted.');
        }

        $widgets = $this->getWidgetsFromUserPreferences();
        foreach ($aliases as $index => $alias) {
            if (isset($widgets[$alias])) {
                $widgets[$alias]['sortOrder'] = $orders[$index];
            }
        }

        $this->setWidgetsToUserPreferences($widgets);
    }

    //
    // Helpers
    //

    /**
     * Registers the dashboard widgets that will be included in this container.
     * The chosen widgets are based on the user preferences.
     */
    protected function defineDashboardWidgets()
    {
        if ($this->widgetsDefined) {
            return;
        }

        $result = [];
        $widgets = $this->getWidgetsFromUserPreferences();
        foreach ($widgets as $alias => $widgetInfo) {
            if ($widget = $this->makeDashboardWidget($alias, $widgetInfo)) {
                $result[$alias] = ['widget' => $widget, 'priority' => $widgetInfo['priority']];
            }
        }

        uasort($result, function ($a, $b) {
            return $a['priority'] - $b['priority'];
        });

        $this->dashboardWidgets = $result;

        $this->widgetsDefined = TRUE;
    }

    protected function makeDashboardWidget($alias, $widgetInfo)
    {
        $config = $widgetInfo['config'];
        $config['alias'] = $alias;

        $className = $widgetInfo['class'];
        if (!class_exists($className)) {
            return;
        }

        $widget = $this->makeWidget($className, $config);
        $widget->bindToController();

        return $widget;
    }

    protected function resetWidgets()
    {
        $this->resetWidgetsUserPreferences();

        $this->widgetsDefined = FALSE;

        $this->defineDashboardWidgets();
    }

    protected function removeWidget($alias)
    {
        if (!$this->canAddAndDelete) {
            throw new ApplicationException('Access denied.');
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
        $formConfig['alias'] = $this->alias.'Form'.'-'.$alias;
        $formConfig['arrayName'] = 'fields';

        $formWidget = $this->makeWidget('Admin\Widgets\Form', $formConfig);
        $formWidget->bindToController();

        return $formWidget;
    }

    protected function findWidgetByAlias($alias)
    {
        $this->defineDashboardWidgets();

        $widgets = $this->dashboardWidgets;
        if (!isset($widgets[$alias])) {
            throw new ApplicationException('The specified widget is not found.');
        }

        return $widgets[$alias]['widget'];
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

        $property = [
            'property' => 'width',
            'label' => lang('admin::lang.dashboard.label_widget_columns'),
            'comment' => lang('admin::lang.dashboard.help_widget_columns'),
            'type' => 'select',
            'options' => $this->getWidgetPropertyWidthOptions(),
        ];
        $result['width'] = $property;

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

    public function getWidgetPropertyWidthOptions()
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
            'number',
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
            $widgets[$alias]['config'] = $properties;

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
