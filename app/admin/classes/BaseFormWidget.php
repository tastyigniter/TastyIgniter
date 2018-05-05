<?php namespace Admin\Classes;

use System\Classes\BaseController;

/**
 * Form Widget base class
 * Widgets used specifically for forms
 *
 * Adapted from october\backend\classes\FormWidgetBase
 *
 * @package Admin
 */
class BaseFormWidget extends BaseWidget
{
    //
    // Configurable properties
    //

    /**
     * @var \Model Form model object.
     */
    public $model;

    /**
     * @var array Dataset containing field values, if none supplied model should be used.
     */
    public $data;

    /**
     * @var string Active session key, used for editing forms and deferred bindings.
     */
    public $sessionKey;

    /**
     * @var bool Render this form with uneditable preview data.
     */
    public $previewMode = FALSE;

    /**
     * @var bool Determines if this form field should display comments and labels.
     */
    public $showLabels = TRUE;

    //
    // Object properties
    //

    /**
     * @var \Admin\Classes\FormField Object containing general form field information.
     */
    protected $formField;

    /**
     * @var string Form field name.
     */
    protected $fieldName;

    /**
     * @var string Model attribute to get/set value from.
     */
    protected $valueFrom;

    /**
     * Constructor
     *
     * @param $controller BaseController Active controller object.
     * @param $formField \Admin\Classes\FormField Object containing general form field information.
     * @param $configuration array Configuration the relates to this widget.
     */
    public function __construct($controller, $formField, $configuration = [])
    {
        $this->formField = $formField;
        $this->fieldName = $formField->fieldName;
        $this->valueFrom = $formField->valueFrom;

        $this->config = $this->makeConfig($configuration);

        $this->fillFromConfig([
            'model',
            'data',
            'sessionKey',
            'previewMode',
            'showLabels',
        ]);

        parent::__construct($controller, $configuration);
    }

    /**
     * Returns a unique ID for this widget. Useful in creating HTML markup.
     *
     * @param null $suffix
     *
     * @return string
     */
    public function getId($suffix = null)
    {
        $id = parent::getId($suffix);
        $id .= '-'.$this->fieldName;

        return name_to_id($id);
    }

    /**
     * Process the postback value for this widget. If the value is omitted from
     * postback data, it will be NULL, otherwise it will be an empty string.
     *
     * @param mixed $value The existing value for this widget.
     *
     * @return string The new value for this widget.
     */
    public function getSaveValue($value)
    {
        return $value;
    }

    /**
     * Returns the value for this form field,
     * supports nesting via HTML array.
     * @return string
     */
    public function getLoadValue()
    {
        if ($this->formField->value !== null) {
            return $this->formField->value;
        }

        $defaultValue = !$this->model->exists
            ? $this->formField->getDefaultFromData($this->data ?: $this->model)
            : null;

        if ($value = post($this->formField->getName()))
            return $value;

        return $this->formField->getValueFromData($this->data ?: $this->model, $defaultValue);
    }
}
