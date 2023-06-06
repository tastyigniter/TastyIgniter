<?php

namespace Admin\Classes;

use Igniter\Flame\Traits\Singleton;
use System\Classes\ExtensionManager;

/**
 * Widget manager
 *
 * Adapted from october\backend\classes\WidgetManager
 */
class Widgets
{
    use Singleton;

    /**
     * @var array An array of list action widgets.
     */
    protected $bulkActionWidgets;

    /**
     * @var array Cache of list action widget registration callbacks.
     */
    protected $bulkActionWidgetCallbacks = [];

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

    protected $dashboardWidgetHints;

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
    // List Action Widgets
    //

    public function listBulkActionWidgets()
    {
        if ($this->bulkActionWidgets === null) {
            $this->bulkActionWidgets = [];

            // Load app widgets
            foreach ($this->bulkActionWidgetCallbacks as $callback) {
                $callback($this->instance());
            }

            // Load extension widgets
            $bundles = $this->extensionManager->getRegistrationMethodValues('registerListActionWidgets');
            foreach ($bundles as $widgets) {
                foreach ($widgets as $className => $widgetInfo) {
                    $this->registerBulkActionWidget($className, $widgetInfo);
                }
            }
        }

        return $this->bulkActionWidgets;
    }

    public function registerBulkActionWidget($className, $widgetInfo)
    {
        $widgetCode = $widgetInfo['code'] ?? null;

        if (!$widgetCode) {
            $widgetCode = get_class_id($className);
        }

        $this->bulkActionWidgets[$className] = $widgetInfo;
        $this->bulkActionWidgetHints[$widgetCode] = $className;
    }

    public function registerBulkActionWidgets(callable $definitions)
    {
        $this->bulkActionWidgetCallbacks[] = $definitions;
    }

    /**
     * Returns a class name from a list action widget code
     * Normalizes a class name or converts an code to it's class name.
     *
     * @param string $name Class name or form widget code.
     *
     * @return string The class name resolved, or the original name.
     */
    public function resolveBulkActionWidget($name)
    {
        if ($this->bulkActionWidgets === null) {
            $this->listBulkActionWidgets();
        }

        $hints = $this->bulkActionWidgetHints;

        if (isset($hints[$name])) {
            return $hints[$name];
        }

        $_name = normalize_class_name($name);
        if (isset($this->bulkActionWidgets[$_name])) {
            return $_name;
        }

        return $name;
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
        $widgetCode = $widgetInfo['code'] ?? null;

        if (!$widgetCode) {
            $widgetInfo['code'] = $widgetCode = get_class_id($className);
        }

        $this->dashboardWidgets[$className] = $widgetInfo;
        $this->dashboardWidgetHints[$widgetCode] = $className;
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

    public function resolveDashboardWidget($name)
    {
        if ($this->dashboardWidgets === null) {
            $this->listDashboardWidgets();
        }

        $hints = $this->dashboardWidgetHints;

        if (isset($hints[$name])) {
            return $hints[$name];
        }

        $_name = normalize_class_name($name);
        if (isset($this->dashboardWidgets[$_name])) {
            return $_name;
        }

        return $name;
    }
}
