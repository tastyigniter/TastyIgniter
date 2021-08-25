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

    public $attributes;

    public $popupTitle;

    //
    // Object properties
    //

    /**
     * @var \Admin\Widgets\Lists
     */
    protected $actionButton;

    public function __construct($controller, $actionButton, $config = [])
    {
        $this->actionButton = $actionButton;

        $this->config = $this->makeConfig($config);

        $this->fillFromConfig([
            'label',
            'attributes',
            'popupTitle',
        ]);

        parent::__construct($controller, $config);
    }

    public function hasPopup()
    {
        return FALSE;
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

    public function handleAction($checkedIds, $records)
    {
    }
}
