<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
namespace Igniter\Traits;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Widget Maker Trait Class
 *
 * Adapted from the October WidgetMaker Trait
 * @link https://github.com/octobercms/october/tree/master/modules/backend/traits/WidgetMaker.php
 *
 * @package Igniter\Traits
 * @author TastyIgniter Dev Team
 * @link https://docs.tastyigniter.com
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
     * @return \Igniter\Core\BaseWidget The widget object
     */
    public function makeWidget($class, $widgetConfig = [])
    {
        $controller = property_exists($this, 'controller') && $this->controller
            ? $this->controller
            : $this;

        if (!class_exists($class)) {
            show_error(sprintf("The Widget class name '%s' has not been registered", $class));
        }

        return new $class($controller, $widgetConfig);
    }

}

/* End of file WidgetMaker.php */
/* Location: ./system/tastyigniter/traits/WidgetMaker.php */
