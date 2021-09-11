<?php

namespace Admin\Classes;

/**
 * Bulk Action Widget base class
 * Widgets used specifically for lists
 */
class BaseBulkActionWidget extends BaseWidget
{
    public $code;

    public $label;

    public $type;

    public $popupTitle;

    //
    // Object properties
    //

    protected $defaultConfig = [];

    /**
     * @var \Admin\Widgets\Lists
     */
    protected $actionButton;

    public function __construct($controller, $actionButton, $config = [])
    {
        $this->actionButton = $actionButton;

        $this->config = $this->makeConfig(array_merge_recursive($this->defaultConfig, $config));

        $this->fillFromConfig([
            'label',
            'popupTitle',
        ]);

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

    public function getActionButton()
    {
        return $this->actionButton;
    }

    public function handleAction($requestData, $records)
    {
    }
}
