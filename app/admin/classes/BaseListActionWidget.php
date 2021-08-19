<?php

namespace Admin\Classes;

/**
 * List Action Widget base class
 * Widgets used specifically for lists
 */
class BaseListActionWidget extends BaseWidget
{
    public function __construct($controller, $config = [])
    {
        $this->config = $this->makeConfig($config);

        $this->fillFromConfig([]);

        parent::__construct($controller, $config);
    }

    /**
     * Extra field configuration for the action.
     */
    public function defineFormFields()
    {
        return [];
    }

    /**
     * Defines validation rules for the custom fields.
     * @return array
     */
    public function defineValidationRules()
    {
        return [];
    }

    public function handleAction($checkedIds)
    {
    }
}
