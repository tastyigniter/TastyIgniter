<?php namespace Admin\Traits;

use Admin\Classes\FormField;
use Exception;

/**
 * Widget Maker Trait Class
 *
 * Adapted from october\backend\traits\WidgetMaker.php
 *
 * @package Admin
 */
trait WidgetMaker
{
    /**
     * Makes a widget object with the supplied configuration
     * ex. model config
     *
     * @param string $class Widget class name
     * @param array $widgetConfig An array of config.
     *
     * @return \Admin\Classes\BaseWidget The widget object
     */
    public function makeWidget($class, $widgetConfig = [])
    {
        $controller = property_exists($this, 'controller') && $this->controller
            ? $this->controller
            : $this;

        if (!class_exists($class)) {
            throw new Exception(sprintf("The Widget class name '%s' has not been registered", $class));
        }

        return new $class($controller, $widgetConfig);
    }

    /**
     * Makes a form widget object with the supplied form field and widget configuration.
     *
     * @param string $class Widget class name
     * @param mixed $fieldConfig A field name, an array of config or a FormField object.
     * @param array $widgetConfig An array of config.
     *
     * @return \Admin\Classes\BaseFormWidget The widget object
     * @throws \Exception
     */
    public function makeFormWidget($class, $fieldConfig = [], $widgetConfig = [])
    {
        $controller = (property_exists($this, 'controller') AND $this->controller)
            ? $this->controller
            : $this;

        if (!class_exists($class)) {
            throw new Exception(sprintf("The Widget class name '%s' has not been registered", $class));
        }

        if (is_string($fieldConfig)) {
            $fieldConfig = ['name' => $fieldConfig];
        }

        if (is_array($fieldConfig)) {
            $formField = new FormField(
                array_get($fieldConfig, 'name'),
                array_get($fieldConfig, 'label')
            );
            $formField->displayAs('widget', $fieldConfig);
        }
        else {
            $formField = $fieldConfig;
        }

        $widgetConfig['vars'] = $this->vars;

        return new $class($controller, $formField, $widgetConfig);
    }
}
