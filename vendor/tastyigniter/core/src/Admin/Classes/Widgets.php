<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Igniter\System\Classes\ExtensionManager;

/**
 * Widget manager
 *
 * Adapted from october\backend\classes\WidgetManager
 */
class Widgets
{
    /** An array of list action widgets. */
    protected ?array $bulkActionWidgets = null;

    /** Cache of list action widget registration callbacks. */
    protected array $bulkActionWidgetCallbacks = [];

    /** An array of list action widgets hints. */
    protected array $bulkActionWidgetHints = [];

    /** An array of form widgets. */
    protected ?array $formWidgets = null;

    /** Cache of form widget registration callbacks. */
    protected array $formWidgetCallbacks = [];

    /** An array of form widgets hints. */
    protected array $formWidgetHints = [];

    /** An array of dashboard widgets. */
    protected ?array $dashboardWidgets = null;

    /** Cache of dashboard widget registration callbacks. */
    protected array $dashboardWidgetCallbacks = [];

    /** An array of dashboard widgets hints. */
    protected array $dashboardWidgetHints = [];

    /**
     * Initialize this singleton.
     */
    public function __construct(protected ExtensionManager $extensionManager) {}

    //
    // List Action Widgets
    //

    public function listBulkActionWidgets(): array
    {
        if ($this->bulkActionWidgets === null) {
            $this->bulkActionWidgets = [];

            // Load app widgets
            foreach ($this->bulkActionWidgetCallbacks as $callback) {
                $callback($this);
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

    public function registerBulkActionWidget(string $className, array $widgetInfo): void
    {
        $widgetCode = $widgetInfo['code'] ?? null;

        if (!$widgetCode) {
            $widgetCode = get_class_id($className);
        }

        $this->bulkActionWidgets[$className] = $widgetInfo;
        $this->bulkActionWidgetHints[$widgetCode] = $className;
    }

    public function registerBulkActionWidgets(callable $definitions): void
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
    public function resolveBulkActionWidget(string $name): string
    {
        if ($this->bulkActionWidgets === null) {
            $this->listBulkActionWidgets();
        }

        $hints = $this->bulkActionWidgetHints;

        if (isset($hints[$name])) {
            return $hints[$name];
        }

        if (isset($this->bulkActionWidgets[$name])) {
            return $name;
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
    public function listFormWidgets(): array
    {
        if ($this->formWidgets === null) {
            $this->formWidgets = [];

            // Load app widgets
            foreach ($this->formWidgetCallbacks as $callback) {
                $callback($this);
            }

            // Load extension widgets
            $extensions = $this->extensionManager->getExtensions();

            foreach ($extensions as $extension) {
                foreach ($extension->registerFormWidgets() as $className => $widgetInfo) {
                    $this->registerFormWidget($className, $widgetInfo);
                }
            }
        }

        return $this->formWidgets;
    }

    /**
     * Registers a single form widget.
     *
     * @param string $className Widget class name.
     * @param array $widgetInfo Registration information, can contain an 'code' key.
     */
    public function registerFormWidget(string $className, array $widgetInfo): void
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
     *       $manager->registerFormWidget(\Igniter\Admin\FormWidgets\CodeEditor::class, [
     *           'name' => 'Code editor',
     *           'code'  => 'codeeditor'
     *       ]);
     *   });
     * </pre>
     */
    public function registerFormWidgets(callable $definitions): void
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
    public function resolveFormWidget(string $name): string
    {
        if ($this->formWidgets === null) {
            $this->listFormWidgets();
        }

        $hints = $this->formWidgetHints;

        if (isset($hints[$name])) {
            return $hints[$name];
        }

        if (isset($this->formWidgets[$name])) {
            return $name;
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
    public function listDashboardWidgets(): array
    {
        if ($this->dashboardWidgets === null) {
            $this->dashboardWidgets = [];

            // Load app widgets
            foreach ($this->dashboardWidgetCallbacks as $callback) {
                $callback($this);
            }

            // Load extension widgets
            $extensions = $this->extensionManager->getExtensions();

            foreach ($extensions as $extension) {
                foreach ($extension->registerDashboardWidgets() as $className => $widgetInfo) {
                    $this->registerDashboardWidget($className, $widgetInfo);
                }
            }
        }

        return $this->dashboardWidgets;
    }

    /*
     * Registers a single dashboard widget.
     */
    public function registerDashboardWidget(string $className, array $widgetInfo): void
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
     *       $manager->registerDashboardWidget(\IgniterLab\GoogleAnalytics\DashboardWidgets\TrafficOverview::class, [
     *           'name'=>'Google Analytics traffic overview',
     *           'context'=>'dashboard'
     *       ]);
     *   });
     * </pre>
     */
    public function registerDashboardWidgets(callable $definitions): void
    {
        $this->dashboardWidgetCallbacks[] = $definitions;
    }

    public function resolveDashboardWidget(string $name): string
    {
        if ($this->dashboardWidgets === null) {
            $this->listDashboardWidgets();
        }

        $hints = $this->dashboardWidgetHints;

        if (isset($hints[$name])) {
            return $hints[$name];
        }

        if (isset($this->dashboardWidgets[$name])) {
            return $name;
        }

        return $name;
    }
}
