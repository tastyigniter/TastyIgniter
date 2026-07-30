<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Igniter\Flame\Database\Model;
use Override;

/**
 * Form Widget base class
 * Widgets used specifically for forms
 *
 * Adapted from october\backend\classes\FormWidgetBase
 */
class BaseFormWidget extends BaseWidget
{
    //
    // Configurable properties
    //

    public ?Model $model = null;

    /** Dataset containing field values, if none supplied model should be used. */
    public mixed $data = null;

    /** Render this form with uneditable preview data. */
    public bool $previewMode = false;

    /** Determines if this form field should display comments and labels. */
    public bool $showLabels = true;

    protected string $fieldName;

    protected ?string $valueFrom = null;

    /**
     * Constructor
     *
     * @param $controller \Illuminate\Routing\Controller Active controller object.
     * @param $formField \Igniter\Admin\Classes\FormField Object containing general form field information.
     * @param $configuration array Configuration the relates to this widget.
     */
    public function __construct(AdminController $controller, protected FormField $formField, array $configuration = [])
    {
        $this->fieldName = $this->formField->fieldName;
        $this->valueFrom = $this->formField->valueFrom;

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

    /** Returns a unique ID for this widget. Useful in creating HTML markup. */
    #[Override]
    public function getId(?string $suffix = null): string
    {
        $id = parent::getId($suffix);
        $id .= '-'.$this->fieldName;

        return name_to_id($id);
    }

    /**
     * Process the postback value for this widget. If the value is omitted from
     * postback data, it will be NULL, otherwise it will be an empty string.
     */
    public function getSaveValue(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Returns the value for this form field,
     * supports nesting via HTML array.
     */
    public function getLoadValue(): mixed
    {
        if ($this->formField->value !== null) {
            return $this->formField->value;
        }

        $defaultValue = !$this->model->exists
            ? $this->formField->getDefaultFromData($this->data ?: $this->model)
            : null;

        if ($value = post($this->formField->getName())) {
            return $value;
        }

        return $this->formField->getValueFromData($this->data ?: $this->model, $defaultValue);
    }
}
