<?php namespace Admin\Classes;

use System\Traits\PropertyContainer;

/**
 * Dashboard Widget base class
 * Dashboard widgets are used inside the DashboardContainer.
 *
 * @package Admin
 */
class BaseDashboardWidget extends BaseWidget
{
    use PropertyContainer;

    public function __construct($controller, $properties = [])
    {
        $this->properties = $this->validateProperties($properties);

        parent::__construct($controller);
    }
}
