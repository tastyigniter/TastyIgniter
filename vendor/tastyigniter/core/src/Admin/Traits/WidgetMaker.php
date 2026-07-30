<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Exception;
use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\BaseWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Flame\Exception\SystemException;

/**
 * Widget Maker Trait Class
 *
 * Adapted from october\backend\traits\WidgetMaker.php
 */
trait WidgetMaker
{
    /**
     * Makes a widget object with the supplied configuration
     * ex. model config
     */
    public function makeWidget(
        string $class,
        array $widgetConfig = [],
    ): BaseWidget {
        $controller = (property_exists($this, 'controller')) ? $this->controller : $this;

        if (!class_exists($class)) {
            throw new SystemException(sprintf(lang('igniter::admin.alert_widget_class_name'), $class));
        }

        return new $class($controller, $widgetConfig);
    }

    /**
     * Makes a form widget object with the supplied form field and widget configuration.
     *
     * @param string $class Widget class name
     * @param string|array|FormField $fieldConfig A field name, an array of config or a FormField object.
     * @param array $widgetConfig An array of config.
     *
     * @return BaseFormWidget The widget object
     * @throws Exception
     */
    public function makeFormWidget(
        string $class,
        string|array|FormField $fieldConfig = [],
        array $widgetConfig = [],
    ): BaseFormWidget {
        $controller = (property_exists($this, 'controller')) ? $this->controller : $this;

        if (!class_exists($class)) {
            throw new SystemException(sprintf(lang('igniter::admin.alert_widget_class_name'), $class));
        }

        if (is_string($fieldConfig)) {
            $fieldConfig = ['name' => $fieldConfig];
        }

        if (is_array($fieldConfig)) {
            $formField = new FormField(
                array_get($fieldConfig, 'name'),
                array_get($fieldConfig, 'label'),
            );
            $formField->displayAs('widget', $fieldConfig);
        } else {
            $formField = $fieldConfig;
        }

        $widgetConfig['vars'] = $this->vars;

        return new $class($controller, $formField, $widgetConfig);
    }
}
