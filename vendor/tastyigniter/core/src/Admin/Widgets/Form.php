<?php

declare(strict_types=1);

namespace Igniter\Admin\Widgets;

use Closure;
use Exception;
use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\BaseWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Classes\FormTabs;
use Igniter\Admin\Classes\Widgets;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Flame\Exception\SystemException;
use Igniter\Local\Traits\LocationAwareWidget;
use Igniter\User\Facades\AdminAuth;
use Override;

class Form extends BaseWidget
{
    use FormModelWidget;
    use LocationAwareWidget;

    //
    // Configurable properties
    //

    /** Form field configuration. */
    public ?array $fields = null;

    /** Primary tab configuration. */
    public ?array $tabs = null;

    /** Secondary tab configuration. */
    public array $secondaryTabs = [];

    /** The active tab name of this form. */
    public ?string $activeTab = null;

    /** Form model object. */
    public ?object $model = null;

    /** Dataset containing field values, if none supplied, model is used. */
    public mixed $data = null;

    /** The context of this form, fields that do not belong to this context will not be shown. */
    public ?string $context = null;

    /** If the field element names should be contained in an array. Eg: <input name="nameArray[fieldName]" /> */
    public ?string $arrayName = null;

    //
    // Object properties
    //

    protected string $defaultAlias = 'form';

    /** Determines if field definitions have been created. */
    protected bool $fieldsDefined = false;

    /** Collection of all fields used in this form.  */
    protected array $allFields = [];

    /** Collection of tab sections used in this form.  */
    protected array $allTabs = [
        'outside' => null,
        'primary' => null,
        'secondary' => null,
    ];

    /** Collection of all form widgets used in this form. */
    protected array $formWidgets = [];

    /** Render this form with uneditable preview data. */
    public bool $previewMode = false;

    protected Widgets $widgetManager;

    protected array $optionModelTypes = [];

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'fields',
            'tabs',
            'secondaryTabs',
            'model',
            'data',
            'arrayName',
            'context',
            'previewMode',
        ]);

        $this->optionModelTypes = [
            'select', 'selectlist',
            'radio', 'radiolist', 'radiotoggle',
            'checkbox', 'checkboxlist', 'checkboxtoggle',
            'partial',
        ];

        $this->widgetManager = resolve(Widgets::class);
        $this->validateModel();
    }

    /**
     * Ensure fields are defined and form widgets are registered so they can
     * also be bound to the controller this allows their AJAX features to
     * operate.
     */
    #[Override]
    public function bindToController(): void
    {
        $this->defineFormFields();
        parent::bindToController();
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('form.js', 'form-js');
        $this->addJs('formwidget.js', 'formwidget-js');
    }

    /**
     * Renders the widget.
     * Options:
     *  - preview: Render this form as an uneditable preview. Default: false
     *  - useContainer: Wrap the result in a container, used by AJAX. Default: true
     *  - section: Which form section to render. Default: null
     *     - outside: Renders the Outside Fields section.
     *     - primary: Renders the Primary Tabs section.
     *     - secondary: Renders the Secondary Tabs section.
     *     - null: Renders all sections
     *
     * @return string|bool The rendered partial contents, or false if suppressing an exception
     */
    #[Override]
    public function render(array $options = []): mixed
    {
        if (isset($options['preview'])) {
            $this->previewMode = $options['preview'];
        }

        if (!isset($options['useContainer'])) {
            $options['useContainer'] = true;
        }

        if (!isset($options['section'])) {
            $options['section'] = null;
        }

        $extraVars = [];
        $targetPartial = 'form/form';

        // Determine the partial to use based on the supplied section option
        if ($section = $options['section']) {
            $section = strtolower((string)$section);

            if (isset($this->allTabs[$section])) {
                $extraVars['tabs'] = $this->allTabs[$section];
            }

            $targetPartial = 'form/form_section';
            $extraVars['renderSection'] = $section;
        }

        // Apply a container to the element
        if ($options['useContainer']) {
            $targetPartial = 'form/form_container';
        }

        $this->prepareVars();

        return $this->makePartial($targetPartial, $extraVars);
    }

    /**
     * Renders a single form field
     * Options:
     *  - useContainer: Wrap the result in a container, used by AJAX. Default: true
     */
    public function renderField(string|FormField $field, array $options = []): mixed
    {
        if (is_string($field)) {
            if (!isset($this->allFields[$field])) {
                throw new SystemException(sprintf(
                    lang('igniter::admin.form.missing_definition'),
                    $field,
                ));
            }

            $field = $this->allFields[$field];
        }

        if (!isset($options['useContainer'])) {
            $options['useContainer'] = true;
        }

        $targetPartial = $options['useContainer'] ? 'form/field_container' : 'form/field';

        $this->prepareVars();

        return $this->makePartial($targetPartial, ['field' => $field]);
    }

    /**
     * Renders the HTML element for a field
     *
     * @return string|bool The rendered partial contents, or false if suppressing an exception
     */
    public function renderFieldElement(FormField $field): mixed
    {
        return $this->makePartial(
            'form/field_'.$field->type,
            [
                'field' => $field,
                'formModel' => $this->model,
            ],
        );
    }

    /**
     * Prepares the form data
     * @return void
     */
    protected function prepareVars()
    {
        $this->defineFormFields();
        $this->applyFiltersFromModel();
        $this->vars['activeTab'] = $this->getActiveTab();
        $this->vars['outsideTabs'] = $this->allTabs['outside'];
        $this->vars['primaryTabs'] = $this->allTabs['primary'];
    }

    /**
     * Sets or resets form field values.
     *
     * @param array $data
     *
     * @return array
     */
    public function setFormValues(mixed $data = null): mixed
    {
        $data ??= $this->getSaveData();

        $this->prepareModelsToSave($this->model, $data);

        if ($this->data !== $this->model) {
            $this->data = (object)array_merge((array)$this->data, (array)$data);
        }

        foreach ($this->allFields as $field) {
            $field->value = $this->getFieldValue($field);
        }

        return $data;
    }

    /**
     * Event handler for refreshing the form.
     */
    public function onRefresh(): array
    {
        $result = [];
        $saveData = $this->getSaveData();

        // Extensibility
        $dataHolder = (object)['data' => $saveData];
        $this->fireSystemEvent('admin.form.beforeRefresh', [$dataHolder]);
        $saveData = $dataHolder->data;

        $this->setFormValues($saveData);
        $this->prepareVars();

        // Extensibility
        $this->fireSystemEvent('admin.form.refreshFields', [$this->allFields]);

        if (($updateFields = post('fields')) && is_array($updateFields)) {
            foreach ($updateFields as $field) {
                if (!isset($this->allFields[$field])) {
                    continue;
                }

                $fieldObject = $this->allFields[$field];
                $result['#'.$fieldObject->getId('group')] = $this->makePartial('field', ['field' => $fieldObject]);
            }
        }

        if (empty($result)) {
            $result = ['#'.$this->getId() => $this->makePartial('form')];
        }

        // Extensibility
        $eventResults = $this->fireSystemEvent('admin.form.refresh', [$result], false);
        foreach (array_filter($eventResults) as $eventResult) {
            $result = $eventResult + $result;
        }

        return $result;
    }

    /**
     * Event handler for storing the active tab.
     */
    public function onActiveTab(): void
    {
        $data = validator(post(), [
            'tab' => ['required', 'string'],
        ])->validate();

        if ($this->context !== 'create') {
            $this->putSession($this->activeTabSessionKey(), $data['tab']);
        }
    }

    /**
     * Programmatically add fields, used internally and for extensibility.
     */
    public function addFields(array $fields, string $addToArea = ''): void
    {
        foreach ($fields as $name => $config) {
            // Check if admin has permissions to show this field
            $permissions = array_get($config, 'permissions');
            if (!empty($permissions) && !AdminAuth::getUser()?->hasPermission($permissions, false)) {
                continue;
            }

            $fieldObj = $this->makeFormField($name, $config);
            $fieldTab = is_array($config) ? array_get($config, 'tab') : null;

            // Check that the form field matches the active context
            if ($fieldObj->context !== null) {
                $context = is_array($fieldObj->context) ? $fieldObj->context : [$fieldObj->context];
                if (!in_array($this->getContext(), $context)) {
                    continue;
                }
            }

            $this->allFields[$name] = $fieldObj;

            if (strtolower($addToArea) === FormTabs::SECTION_PRIMARY) {
                $this->allTabs['primary']->addField($name, $fieldObj, $fieldTab);
            } else {
                $this->allTabs['outside']->addField($name, $fieldObj);
            }
        }
    }

    /**
     * Add tab fields.
     */
    public function addTabFields(array $fields): void
    {
        $this->addFields($fields, 'primary');
    }

    /**
     * Programmatically remove a field.
     */
    public function removeField(string $name): bool
    {
        if (!isset($this->allFields[$name])) {
            return false;
        }

        // Remove from tabs
        $this->allTabs['primary']->removeField($name);
        $this->allTabs['outside']->removeField($name);

        // Remove from main collection
        unset($this->allFields[$name]);

        return true;
    }

    /**
     * Programmatically remove all fields belonging to a tab.
     */
    public function removeTab(string $name): void
    {
        foreach ($this->allFields as $fieldName => $field) {
            if ($field->tab == $name) {
                $this->removeField($fieldName);
            }
        }
    }

    /**
     * Creates a form field object from name and configuration.
     */
    public function makeFormField(string $name, string|array $config): FormField
    {
        $label = $config['label'] ?? null;
        [$fieldName, $fieldContext] = $this->getFieldName($name);

        $field = new FormField($fieldName, $label);
        if ($fieldContext) {
            $field->context = $fieldContext;
        }

        $field->arrayName = $this->arrayName;
        $field->idPrefix = $this->getId();

        // Simple field type
        if (is_string($config)) {
            if ($this->isFormWidget($config)) {
                $field->displayAs('widget', ['widget' => $config]);
            } else {
                $field->displayAs($config);
            }
        } // Defined field type
        else {
            $fieldType = $config['type'] ?? null;
            if (!is_string($fieldType) && !is_null($fieldType)) {
                throw new SystemException(sprintf(
                    lang('igniter::admin.form.field_invalid_type'), gettype($fieldType),
                ));
            }

            // Widget with configuration
            if ($this->isFormWidget($fieldType)) {
                $config['widget'] = $fieldType;
                $fieldType = 'widget';
            }

            $field->displayAs($fieldType, $config);
        }

        // Set field value
        $field->value = $this->getFieldValue($field);

        // Get field options from model
        if (in_array($field->type, $this->optionModelTypes)) {
            // Defer the execution of option data collection
            $field->options(function() use ($field, $config) {
                $fieldOptions = $config['options'] ?? null;

                return $this->getOptionsFromModel($field, $fieldOptions);
            });
        }

        return $field;
    }

    /**
     * Makes a widget object from a form field object.
     */
    public function makeFormFieldWidget(FormField $field): ?BaseFormWidget
    {
        if ($field->type !== 'widget') {
            return null;
        }

        if (isset($this->formWidgets[$field->fieldName])) {
            return $this->formWidgets[$field->fieldName];
        }

        $widgetConfig = $this->makeConfig($field->config);
        $widgetConfig['alias'] = $this->alias.studly_case(name_to_id($field->fieldName));
        $widgetConfig['previewMode'] = $this->previewMode;
        $widgetConfig['model'] = $this->model;
        $widgetConfig['data'] = $this->data;

        $widgetName = $widgetConfig['widget'];
        $widgetClass = $this->widgetManager->resolveFormWidget($widgetName);

        if (!class_exists($widgetClass)) {
            throw new SystemException(sprintf(lang('igniter::admin.alert_widget_class_name'), $widgetClass));
        }

        $widget = $this->makeFormWidget($widgetClass, $field, $widgetConfig);

        // If options config is defined, request options from the model.
        if (isset($field->config['options'])) {
            $field->options(fn() => $this->getOptionsFromModel($field, $field->config['options']));
        }

        return $this->formWidgets[$field->fieldName] = $widget;
    }

    /**
     * Get all the loaded form widgets for the instance.
     */
    public function getFormWidgets(): array
    {
        return $this->formWidgets;
    }

    /**
     * Get a specified form widget
     *
     * @param string $field
     */
    public function getFormWidget($field): ?BaseFormWidget
    {
        return $this->formWidgets[$field] ?? null;
    }

    /**
     * Get all the registered fields for the instance.
     */
    public function getFields(): array
    {
        return $this->allFields;
    }

    /**
     * Get a specified field object
     */
    public function getField($field): ?FormField
    {
        return $this->allFields[$field] ?? null;
    }

    /**
     * Get all tab objects for the instance.
     */
    public function getTabs(): array
    {
        return $this->allTabs;
    }

    /**
     * Get a specified tab object.
     * Options: outside, primary, secondary.
     */
    public function getTab($tab): ?FormTabs
    {
        return $this->allTabs[$tab] ?? null;
    }

    /**
     * Parses a field's name
     *
     * @param string $field Field name
     *
     * @return array [columnName, context]
     */
    public function getFieldName($field): array
    {
        if (!str_contains($field, '@')) {
            return [$field, null];
        }

        return explode('@', $field);
    }

    /**
     * Looks up the field value.
     *
     * @return string
     * @throws Exception
     */
    public function getFieldValue(string|FormField $field): mixed
    {
        if (is_string($field)) {
            if (!isset($this->allFields[$field])) {
                throw new SystemException(lang(
                    'igniter::admin.form.missing_definition',
                    ['field' => $field],
                ));
            }

            $field = $this->allFields[$field];
        }

        $defaultValue = $field->getDefaultFromData($this->data);

        if ($value = post($field->getName())) {
            return $value;
        }

        return $field->getValueFromData($this->data, $defaultValue);
    }

    /**
     * Returns a HTML encoded value containing the other fields this
     * field depends on
     */
    public function getFieldDepends(FormField $field): array
    {
        return $field->dependsOn;
    }

    /**
     * Helper method to determine if field should be rendered
     * with label and comments.
     */
    public function showFieldLabels(FormField $field): bool
    {
        if ($field->type === 'section') {
            return false;
        }

        if ($field->type === 'widget') {
            return $this->makeFormFieldWidget($field)->showLabels;
        }

        return true;
    }

    /**
     * Returns post data from a submitted form.
     */
    public function getSaveData(): array
    {
        $this->defineFormFields();

        $result = [];

        // Source data
        $data = $this->arrayName ? post($this->arrayName) : post();

        if (!$data) {
            $data = [];
        }

        // Spin over each field and extract the postback value
        foreach ($this->allFields as $field) {
            // Disabled and hidden should be omitted from data set
            if ($field->disabled || $field->hidden || starts_with($field->fieldName, '_')) {
                continue;
            }

            // Handle HTML array, eg: item[key][another]
            $parts = name_to_array($field->fieldName);
            $value = $this->dataArrayGet($data, $parts, false);
            if (is_null($value) && in_array($field->type, ['checkboxtoggle', 'radiotoggle'])) {
                $this->dataArraySet($result, $parts, $value);
            } elseif ($value !== false) {
                $value = match ($field->type) {
                    // Number and switch fields should be converted to integers
                    'number', 'switch' => !is_null($value) ? (int)$value : null,
                    default => $value,
                };

                $this->dataArraySet($result, $parts, $value);
            }
        }

        // Give widgets an opportunity to process the data.
        foreach ($this->formWidgets as $field => $widget) {
            $parts = name_to_array($field);

            if (isset($widget->config['disabled']) && $widget->config['disabled']) {
                continue;
            }

            $widgetValue = $widget->getSaveValue($this->dataArrayGet($result, $parts));
            $this->dataArraySet($result, $parts, $widgetValue);
        }

        return $result;
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    protected function activeTabSessionKey(): string
    {
        $recordId = $this->model?->getKey() ?? md5((string)request()->url());

        return 'activeTab.'.$this->context.'.'.$recordId;
    }

    public function getActiveTab(): ?string
    {
        $tabs = $this->allTabs['primary'];
        $type = $tabs->section;

        $defaultTab = '#'.$type.'tab-1';
        $activeTab = ($this->context !== 'create' ? $this->getSession($this->activeTabSessionKey()) : null) ?? $defaultTab;
        $activeTabIndex = (int)str_after($activeTab, $defaultTab);

        // In cases where a tab has been removed, the first tab becomes the active tab
        $activeTab = ($activeTabIndex <= count($tabs->fields))
            ? $activeTab : $defaultTab;

        return $this->activeTab = $activeTab;
    }

    public function getCookieKey(): string
    {
        return $this->makeSessionKey().'-'.$this->context;
    }

    /**
     * Returns the active context for displaying the form.
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * Validate the supplied form model.
     */
    protected function validateModel(): mixed
    {
        if ($this->model === null) {
            throw new SystemException(sprintf(
                lang('igniter::admin.form.missing_model'), $this->controller::class,
            ));
        }

        $this->data = !is_null($this->data) ? (object)$this->data : $this->model;

        return $this->model;
    }

    /**
     * Creates a flat array of form fields from the configuration.
     * Also slots fields in to their respective tabs.
     */
    protected function defineFormFields()
    {
        if ($this->fieldsDefined) {
            return;
        }

        // Extensibility
        $this->fireSystemEvent('admin.form.extendFieldsBefore');

        // Outside fields
        if (!is_array($this->fields)) {
            $this->fields = [];
        }

        $this->allTabs['outside'] = new FormTabs(FormTabs::SECTION_OUTSIDE, $this->config);
        $this->addFields($this->fields);

        // Primary Tabs + Fields
        if (!isset($this->tabs['fields']) || !is_array($this->tabs['fields'])) {
            $this->tabs['fields'] = [];
        }

        $this->allTabs['primary'] = new FormTabs(FormTabs::SECTION_PRIMARY, $this->tabs);
        $this->addFields($this->tabs['fields'], FormTabs::SECTION_PRIMARY);

        // Extensibility
        $this->fireSystemEvent('admin.form.extendFields', [$this->allFields]);

        // Check that the form field matches the active location context
        foreach ($this->allFields as $field) {
            if ($this->isLocationAware($field->config)) {
                $field->disabled = true;
            }
        }

        // Convert automatic spanned fields
        foreach ($this->allTabs['outside']->getFields() as $fields) {
            $this->processAutoSpan($fields);
        }

        foreach ($this->allTabs['primary']->getFields() as $fields) {
            $this->processAutoSpan($fields);
        }

        // At least one tab section should stretch
        if (
            $this->allTabs['primary']->stretch === null
            && $this->allTabs['outside']->stretch === null
        ) {
            if ($this->allTabs['primary']->hasFields()) {
                $this->allTabs['primary']->stretch = true;
            } else {
                $this->allTabs['outside']->stretch = true;
            }
        }

        // Bind all form widgets to controller
        foreach ($this->allFields as $field) {
            if ($field->type !== 'widget') {
                continue;
            }

            $widget = $this->makeFormFieldWidget($field);
            $widget->bindToController();
        }

        $this->fieldsDefined = true;
    }

    /**
     * Converts fields with a span set to 'auto' as either
     * 'left' or 'right' depending on the previous field.
     */
    protected function processAutoSpan(array $fields)
    {
        $prevSpan = null;

        foreach ($fields as $field) {
            if (strtolower((string)$field->span) === 'auto') {
                $field->span = $prevSpan === 'left' ? 'right' : 'left';
            }

            $prevSpan = $field->span;
        }
    }

    /**
     * Check if a field type is a widget or not
     */
    protected function isFormWidget(?string $fieldType): bool
    {
        if ($fieldType === null) {
            return false;
        }

        if (strpos($fieldType, '\\')) {
            return true;
        }

        $widgetClass = $this->widgetManager->resolveFormWidget($fieldType);

        if (!class_exists($widgetClass)) {
            return false;
        }

        return is_subclass_of($widgetClass, BaseFormWidget::class);
    }

    /**
     * Allow the model to filter fields.
     */
    protected function applyFiltersFromModel()
    {
        if (method_exists($this->model, 'filterFields')) {
            $this->model->filterFields($this, $this->allFields, $this->context);
        }

        $this->fireSystemEvent('admin.form.filterFields', [$this->allFields, $this->context]);
    }

    /**
     * Looks at the model for defined options.
     */
    protected function getOptionsFromModel(FormField $field, null|string|array|Closure $fieldOptions): mixed
    {
        // Advanced usage, supplied options are callable
        if (is_callable($fieldOptions)) {
            $fieldOptions = $fieldOptions($this, $field);
        }

        // Refer to the model method or any of its behaviors
        if (!is_array($fieldOptions) && !$fieldOptions) {
            [$model, $attribute] = $field->resolveModelAttribute($this->model, $field->fieldName);

            $methodName = 'get'.studly_case($attribute).'Options';
            if (
                !$this->objectMethodExists($model, $methodName) &&
                !$this->objectMethodExists($model, 'getDropdownOptions')
            ) {
                throw new SystemException(sprintf(lang('igniter::admin.form.options_method_not_exists'),
                    $model::class, $methodName, $field->fieldName,
                ));
            }

            $fieldOptions = $this->objectMethodExists($model, $methodName)
                ? $model->$methodName($field->value, $this->data)
                : $model->getDropdownOptions($attribute, $field->value, $this->data);
        } // Field options are an explicit method reference
        elseif (is_string($fieldOptions)) {
            if (!$this->objectMethodExists($this->model, $fieldOptions)) {
                throw new SystemException(sprintf(lang('igniter::admin.form.options_method_not_exists'),
                    $this->model::class, $fieldOptions, $field->fieldName,
                ));
            }

            $fieldOptions = $this->model->$fieldOptions($field->value, $field->fieldName, $this->data);
        }

        return $fieldOptions;
    }

    /**
     * Internal helper for method existence checks.
     */
    protected function objectMethodExists(mixed $object, string $method): bool
    {
        if (method_exists($object, 'methodExists')) {
            return $object->methodExists($method);
        }

        return method_exists($object, $method);
    }

    /**
     * Variant to array_get() but preserves dots in key names.
     *
     * @return array|string
     */
    protected function dataArrayGet(array $array, array $parts, $default = null): mixed
    {
        if (count($parts) === 1) {
            $key = array_shift($parts);

            return array_key_exists($key, $array) ? $array[$key] : $default;
        }

        foreach ($parts as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Variant to array_set() but preserves dots in key names.
     */
    protected function dataArraySet(array &$array, array $parts, $value): array
    {
        while (count($parts) > 1) {
            $key = array_shift($parts);

            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($parts)] = $value;

        return $array;
    }
}
