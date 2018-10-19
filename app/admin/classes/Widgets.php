<?php

namespace Admin\Classes;

use Igniter\Flame\Traits\Singleton;
use System\Classes\ExtensionManager;

/**
 * Widget manager
 *
 * Adapted from october\backend\classes\WidgetManager
 *
 * @package Admin
 */
class Widgets
{
    use Singleton;

    /**
     * @var array An array of form widgets.
     */
    protected $formWidgets;

    /**
     * @var array Cache of form widget registration callbacks.
     */
    protected $formWidgetCallbacks = [];

    /**
     * @var array An array of form widgets hints.
     */
    protected $formWidgetHints;

    /**
     * @var array An array of dashboard widgets.
     */
    protected $dashboardWidgets;

    /**
     * @var array Cache of dashboard widget registration callbacks.
     */
    protected $dashboardWidgetCallbacks = [];

    /**
     * @var ExtensionManager
     */
    protected $extensionManager;

    /**
     * Initialize this singleton.
     */
    protected function initialize()
    {
        $this->extensionManager = ExtensionManager::instance();
    }

    //
    // Form Widgets
    //

    /**
     * Returns a list of registered form widgets.
     * @return array Array keys are class names.
     */
    public function listFormWidgets()
    {
        if ($this->formWidgets === null) {
            $this->formWidgets = [];

            // Load app widgets
            foreach ($this->formWidgetCallbacks as $callback) {
                $callback($this->instance());
            }

            // Load extension widgets
            $extensions = $this->extensionManager->getExtensions();

            foreach ($extensions as $extension) {
                if (!is_array($widgets = $extension->registerFormWidgets())) {
                    continue;
                }

                foreach ($widgets as $className => $widgetInfo) {
                    $this->registerFormWidget($className, $widgetInfo);
                }
            }
        }

        return $this->formWidgets;
    }

    /**
     * Registers a single form form widget.
     *
     * @param string $className Widget class name.
     * @param array $widgetInfo Registration information, can contain an 'code' key.
     *
     * @return void
     */
    public function registerFormWidget($className, $widgetInfo = null)
    {
        $widgetCode = $widgetInfo['code'] ?? null;

        if (!$widgetCode) {
            $widgetCode = get_class_id($className);
        }

        $this->formWidgets[$className] = $widgetInfo;
        $this->formWidgetHints[$widgetCode] = $className;
    }

    /**
     * Manually registers form widget for consideration.
     * Usage:
     * <pre>
     *   WidgetManager::registerFormWidgets(function($manager){
     *       $manager->registerFormWidget('Backend\FormWidgets\CodeEditor', [
     *           'name' => 'Code editor',
     *           'code'  => 'codeeditor'
     *       ]);
     *   });
     * </pre>
     *
     * @param callable $definitions
     */
    public function registerFormWidgets(callable $definitions)
    {
        $this->formWidgetCallbacks[] = $definitions;
    }

    /**
     * Returns a class name from a form widget code
     * Normalizes a class name or converts an code to it's class name.
     *
     * @param string $name Class name or form widget code.
     *
     * @return string The class name resolved, or the original name.
     */
    public function resolveFormWidget($name)
    {
        if ($this->formWidgets === null) {
            $this->listFormWidgets();
        }

        $hints = $this->formWidgetHints;

        if (isset($hints[$name])) {
            return $hints[$name];
        }

        $_name = normalize_class_name($name);
        if (isset($this->formWidgets[$_name])) {
            return $_name;
        }

        return $name;
    }

    //
    // Dashboard Widgets
    //

    /**
     * Returns a list of registered dashboard widgets.
     * @return array Array keys are class names.
     */
    public function listDashboardWidgets()
    {
        if ($this->dashboardWidgets === null) {
            $this->dashboardWidgets = [];

            // Load app widgets
            foreach ($this->dashboardWidgetCallbacks as $callback) {
                $callback($this->instance());
            }

            // Load extension widgets
            $extensions = $this->extensionManager->getExtensions();

            foreach ($extensions as $extension) {
                if (!is_array($widgets = $extension->registerDashboardWidgets())) {
                    continue;
                }

                foreach ($widgets as $className => $widgetInfo) {
                    $this->registerDashboardWidget($className, $widgetInfo);
                }
            }
        }

        return $this->dashboardWidgets;
    }

    /*
     * Registers a single dashboard widget.
     */
    public function registerDashboardWidget($className, $widgetInfo)
    {
        $this->dashboardWidgets[$className] = $widgetInfo;
    }

    /**
     * Manually registers dashboard widget for consideration.
     * Usage:
     * <pre>
     *   Widgets::registerDashboardWidgets(function($manager){
     *       $manager->registerDashboardWidget('IgniterLab\GoogleAnalytics\DashboardWidgets\TrafficOverview', [
     *           'name'=>'Google Analytics traffic overview',
     *           'context'=>'dashboard'
     *       ]);
     *   });
     * </pre>
     *
     * @param callable $definitions
     */
    public function registerDashboardWidgets(callable $definitions)
    {
        $this->dashboardWidgetCallbacks[] = $definitions;
    }
}
