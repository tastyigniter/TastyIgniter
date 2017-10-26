<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Admin\Classes\FormField;
use Admin\Classes\FormTabs;
use Admin\Classes\Widgets;
use Event;
use Exception;
use Model;

class Form extends BaseWidget
{
    //
    // Configurable properties
    //

    /**
     * @var array Form field configuration.
     */
    public $fields;

    /**
     * @var array Primary tab configuration.
     */
    public $tabs;

    /**
     * @var array Secondary tab configuration.
     */
    public $secondaryTabs;

    /**
     * @var Model Form model object.
     */
    public $model;

    /**
     * @var array Dataset containing field values, if none supplied, model is used.
     */
    public $data;

    /**
     * @var string The context of this form, fields that do not belong
     * to this context will not be shown.
     */
    public $context = null;

    /**
     * @var string If the field element names should be contained in an array.
     * Eg: <input name="nameArray[fieldName]" />
     */
    public $arrayName;

    //
    // Object properties
    //

    protected $defaultAlias = 'form';

    /**
     * @var boolean Determines if field definitions have been created.
     */
    protected $fieldsDefined = FALSE;

    /**
     * @var array Collection of all fields used in this form.
     * @see \Admin\Classes\FormField
     */
    protected $allFields = [];

    /**
     * @var object Collection of tab sections used in this form.
     * @see \Admin\Classes\FormTabs
     */
    protected $allTabs = [
        'outside'   => null,
        'primary'   => null,
        'secondary' => null,
    ];

    /**
     * @var array Collection of all form widgets used in this form.
     */
    protected $formWidgets = [];

    /**
     * @var string Active session key, used for editing forms and deferred bindings.
     */
    public $sessionKey;

    /**
     * @var bool Render this form with uneditable preview data.
     */
    public $previewMode = FALSE;

    /**
     * @var \Admin\Classes\Widgets
     */
    protected $widgetManager;

    public function initialize()
    {
        $this->fillFromConfig([
            'fields',
            'tabs',
            'secondaryTabs',
            'model',
            'data',
            'arrayName',
            'context',
        ]);

        $this->widgetManager = Widgets::instance();
        $this->allTabs = (object)$this->allTabs;
        $this->validateModel();
    }

    /**
     * Ensure fields are defined and form widgets are registered so they can
     * also be bound to the controller this allows their AJAX features to
     * operate.
     * @return void
     */
    public function bindToController()
    {
        $this->defineFormFields();
        parent::bindToController();
    }

    public function loadAssets()
    {
        $this->addJs('vendor/bootstrap-toggle/bootstrap-toggle.min.js', 'bootstrap-toggle-js');
        $this->addCss('vendor/bootstrap-toggle/bootstrap-toggle.min.css', 'bootstrap-toggle-css');

        $this->addJs('vendor/bootstrap-multiselect/bootstrap-multiselect.js', 'bootstrap-multiselect-js');
        $this->addCss('vendor/bootstrap-multiselect/bootstrap-multiselect.css', 'bootstrap-multiselect-css');

        $this->addJs('js/selectlist.js', 'selectlist-js');
        $this->addCss('css/selectlist.css', 'selectlist-css');

        $this->addJs('js/form.js', 'form-js');
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
     * @param array $options
     *
     * @return string|bool The rendered partial contents, or false if suppressing an exception
     */
    public function render($options = [])
    {
        if (isset($options['preview'])) {
            $this->previewMode = $options['preview'];
        }
        if (!isset($options['useContainer'])) {
            $options['useContainer'] = TRUE;
        }
        if (!isset($options['section'])) {
            $options['section'] = null;
        }

        $extraVars = [];
        $targetPartial = 'form/form';

        // Determine the partial to use based on the supplied section option
        if ($section = $options['section']) {
            $section = strtolower($section);

            if (isset($this->allTabs->{$section})) {
                $extraVars['tabs'] = $this->allTabs->{$section};
            }

            $targetPartial = 'form/form_section';
            $extraVars['renderSection'] = $section;
        }

        // Apply a container to the element
        if ($useContainer = $options['useContainer']) {
            $targetPartial = 'form/form_container';
        }

        $this->prepareVars();

        // Apply preview mode to widgets
        foreach ($this->formWidgets as $widget) {
            $widget->previewMode = $this->previewMode;
        }

        return $this->makePartial($targetPartial, $extraVars);
    }

    /**
     * Renders a single form field
     * Options:
     *  - useContainer: Wrap the result in a container, used by AJAX. Default: true
     *
     * @param string|array $field The field name or definition
     * @param array $options
     *
     * @return bool|string The rendered partial contents, or false if suppressing an exception
     * @throws \Exception
     */
    public function renderField($field, $options = [])
    {
        if (is_string($field)) {
            if (!isset($this->allFields[$field])) {
                throw new Exception(lang(
                    'text_form_missing_definition',
                    compact('field')
                ));
            }

            $field = $this->allFields[$field];
        }

        if (!isset($options['useContainer'])) {
            $options['useContainer'] = TRUE;
        }
        $targetPartial = $options['useContainer'] ? 'form/field_container' : 'form/field';

        $this->prepareVars();

        return $this->makePartial($targetPartial, ['field' => $field]);
    }

    /**
     * Renders the HTML element for a field
     *
     * @param \Admin\Classes\BaseFormWidget $field
     *
     * @return string|bool The rendered partial contents, or false if suppressing an exception
     */
    public function renderFieldElement($field)
    {
        return $this->makePartial(
            'form/field_'.$field->type,
            [
                'field'     => $field,
                'formModel' => $this->model,
            ]
        );
    }

    /**
     * Prepares the form data
     * @return void
     */
    public function prepareVars()
    {
        $this->defineFormFields();
        $this->applyFiltersFromModel();
        $this->vars['cookieKey'] = $this->getCookieKey();
        $this->vars['activeTab'] = $this->getActiveTab();
//        $this->vars['sessionKey'] = $this->getSessionKey();
        $this->vars['outsideTabs'] = $this->allTabs->outside;
        $this->vars['primaryTabs'] = $this->allTabs->primary;
    }

    /**
     * Programatically add fields, used internally and for extensibility.
     *
     * @param array $fields
     * @param string $addToArea
     *
     * @return void
     */
    public function addFields(array $fields, $addToArea = null)
    {
        foreach ($fields as $name => $config) {

            $fieldObj = $this->makeFormField($name, $config);
            $fieldTab = is_array($config) ? array_get($config, 'tab') : null;

            // Check that the form field matches the active context
            if ($fieldObj->context !== null) {
                $context = (is_array($fieldObj->context)) ? $fieldObj->context : [$fieldObj->context];
                if (!in_array($this->getContext(), $context)) {
                    continue;
                }
            }

            $this->allFields[$name] = $fieldObj;

            switch (strtolower($addToArea)) {
                case FormTabs::SECTION_PRIMARY:
                    $this->allTabs->primary->addField($name, $fieldObj, $fieldTab);
                    break;
                default:
                    $this->allTabs->outside->addField($name, $fieldObj);
                    break;
            }
        }
    }

    /**
     * Add tab fields.
     *
     * @param array $fields
     *
     * @return void
     */
    public function addTabFields(array $fields)
    {
        $this->addFields($fields, 'primary');
    }

    /**
     * Programatically remove a field.
     *
     * @param string $name
     *
     * @return bool
     */
    public function removeField($name)
    {
        if (!isset($this->allFields[$name])) {
            return FALSE;
        }

        // Remove from tabs
        $this->allTabs->primary->removeField($name);
        $this->allTabs->outside->removeField($name);

        // Remove from main collection
        unset($this->allFields[$name]);

        return TRUE;
    }

    /**
     * Programmatically remove all fields belonging to a tab.
     *
     * @param string $name
     */
    public function removeTab($name)
    {
        foreach ($this->allFields as $fieldName => $field) {
            if ($field->tab == $name) {
                $this->removeField($fieldName);
            }
        }
    }

    /**
     * Creates a form field object from name and configuration.
     *
     * @param string $name
     * @param array $config
     *
     * @return \Admin\Classes\FormField
     * @throws \Exception
     */
    public function makeFormField($name, $config = [])
    {
        $label = (isset($config['label'])) ? $config['label'] : null;
        list($fieldName, $fieldContext) = $this->getFieldName($name);

        $field = new FormField($fieldName, $label);
        if ($fieldContext) {
            $field->context = $fieldContext;
        }
        $field->arrayName = $this->arrayName;
        $field->idPrefix = $this->getId();

        // Simple field type
        if (is_string($config)) {

            if ($this->isFormWidget($config) !== FALSE) {
                $field->displayAs('widget', ['widget' => $config]);
            }
            else {
                $field->displayAs($config);
            }
        } // Defined field type
        else {

            $fieldType = isset($config['type']) ? $config['type'] : null;
            if (!is_string($fieldType) AND !is_null($fieldType)) {
                throw new Exception(lang(
                    sprintf('text_form_field_invalid_type', gettype($fieldType))
                ));
            }

            // Widget with configuration
            if ($this->isFormWidget($fieldType) !== FALSE) {
                $config['widget'] = $fieldType;
                $fieldType = 'widget';
            }

            $field->displayAs($fieldType, $config);
        }

        // Set field value
        $field->value = $this->getFieldValue($field);

        // Check model if field is required
//        if (!$field->required AND $this->model AND method_exists($this->model, 'isAttributeRequired')) {
//            $field->required = $this->model->isAttributeRequired($field->fieldName);
//        }

        // Get field options from model
        $optionModelTypes = ['select', 'selectlist', 'radio', 'checkbox', 'checkboxlist', 'partial'];
        if (in_array($field->type, $optionModelTypes, FALSE)) {

            // Defer the execution of option data collection
            $field->options(function () use ($field, $config) {
                $fieldOptions = isset($config['options']) ? $config['options'] : null;
                $fieldOptions = $this->getOptionsFromModel($field, $fieldOptions);

                return $fieldOptions;
            });
        }

        return $field;
    }

    /**
     * Makes a widget object from a form field object.
     *
     * @param FormField $field
     *
     * @return \Admin\Classes\BaseFormWidget|null
     * @throws \Exception
     */
    public function makeFormFieldWidget($field)
    {
        if ($field->type !== 'widget') {
            return null;
        }

        if (isset($this->formWidgets[$field->fieldName])) {
            return $this->formWidgets[$field->fieldName];
        }

        $widgetConfig = $this->makeConfig($field->config);
        $widgetConfig['alias'] = $this->alias.studly_case(name_to_id($field->fieldName));
        $widgetConfig['sessionKey'] = $this->getSessionKey();
        $widgetConfig['previewMode'] = $this->previewMode;
        $widgetConfig['model'] = $this->model;
        $widgetConfig['data'] = $this->data;

        $widgetName = $widgetConfig['widget'];
        $widgetClass = $this->widgetManager->resolveFormWidget($widgetName);

        if (!class_exists($widgetClass)) {
            throw new Exception(sprintf("The Widget class name '%s' has not been registered", $widgetClass));
        }

        $widget = $this->makeFormWidget($widgetClass, $field, $widgetConfig);

        // If options config is defined, request options from the model.
        if (isset($field->config['options'])) {
            $field->options(function () use ($field) {
                $fieldOptions = $field->config['options'];
                if ($fieldOptions === TRUE) $fieldOptions = null;
                $fieldOptions = $this->getOptionsFromModel($field, $fieldOptions);

                return $fieldOptions;
            });
        }

        return $this->formWidgets[$field->fieldName] = $widget;
    }

    /**
     * Get all the loaded form widgets for the instance.
     * @return array
     */
    public function getFormWidgets()
    {
        return $this->formWidgets;
    }

    /**
     * Get a specified form widget
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getFormWidget($field)
    {
        if (isset($this->formWidgets[$field])) {
            return $this->formWidgets[$field];
        }

        return null;
    }

    /**
     * Get all the registered fields for the instance.
     * @return array
     */
    public function getFields()
    {
        return $this->allFields;
    }

    /**
     * Get a specified field object
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getField($field)
    {
        if (isset($this->allFields[$field])) {
            return $this->allFields[$field];
        }

        return null;
    }

    /**
     * Get all tab objects for the instance.
     * @return object[FormTabs]
     */
    public function getTabs()
    {
        return $this->allTabs;
    }

    /**
     * Get a specified tab object.
     * Options: outside, primary, secondary.
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getTab($tab)
    {
        if (isset($this->allTabs->$tab)) {
            return $this->allTabs->$tab;
        }

        return null;
    }

    /**
     * Parses a field's name
     *
     * @param string $field Field name
     *
     * @return array [columnName, context]
     */
    public function getFieldName($field)
    {
        if (strpos($field, '@') === FALSE) {
            return [$field, null];
        }

        return explode('@', $field);
    }

    /**
     * Looks up the field value.
     *
     * @param mixed $field
     *
     * @return string
     * @throws \Exception
     */
    public function getFieldValue($field)
    {
        if (is_string($field)) {
            if (!isset($this->allFields[$field])) {
                throw new Exception(lang(
                    'text_form_missing_definition',
                    compact('field')
                ));
            }

            $field = $this->allFields[$field];
        }

        $defaultValue = !$this->model->exists
            ? $field->getDefaultFromData($this->data)
            : null;

        if ($value = post($field->getName()))
            return $value;

        return $field->getValueFromData($this->data, $defaultValue);
    }

    /**
     * Returns a HTML encoded value containing the other fields this
     * field depends on
     *
     * @param  \Admin\Classes\FormField $field
     *
     * @return string
     */
    public function getFieldDepends($field)
    {
        if (!$field->dependsOn) {
            return '';
        }

        $dependsOn = is_array($field->dependsOn) ? $field->dependsOn : [$field->dependsOn];
        $dependsOn = htmlspecialchars(json_encode($dependsOn), ENT_QUOTES, 'UTF-8');

        return $dependsOn;
    }

    /**
     * Helper method to determine if field should be rendered
     * with label and comments.
     *
     * @param  \Admin\Classes\FormField $field
     *
     * @return boolean
     */
    public function showFieldLabels($field)
    {
        if (in_array($field->type, ['section'])) {
            return FALSE;
        }

        if ($field->type === 'widget') {
            $widget = $this->makeFormFieldWidget($field);

            return $widget->showLabels;
        }

        return TRUE;
    }

    /**
     * Returns post data from a submitted form.
     * @return array
     */
    public function getSaveData()
    {
        $this->defineFormFields();

        $result = [];

        // Source data
        $data = $this->getSourceData();

        if (!$data)
            $data = [];

        // Spin over each field and extract the postback value
        foreach ($this->allFields as $field) {
            // Disabled and hidden should be omitted from data set
            if ($field->disabled OR $field->hidden OR starts_with($field->fieldName, '_')) {
                continue;
            }

            // Handle HTML array, eg: item[key][another]
            $parts = name_to_array($field->fieldName);
            if (($value = $this->dataArrayGet($data, $parts)) !== null) {

                // Number fields should be converted to integers
                if ($field->type === 'number') {
                    $value = !strlen(trim($value)) ? null : (float)$value;
                }

                $this->dataArraySet($result, $parts, $value);
            }
        }

        // Give widgets an opportunity to process the data.
        foreach ($this->formWidgets as $field => $widget) {
            $parts = name_to_array($field);

            $widgetValue = $widget->getSaveValue($this->dataArrayGet($result, $parts));
            $this->dataArraySet($result, $parts, $widgetValue);
        }

        return $result;
    }

    public function getActiveTab()
    {
        $activeTabs = @json_decode($_COOKIE['ti_activeFormTabs'], TRUE);

        $cookieKey = $this->getCookieKey();

        return isset($activeTabs[$cookieKey]) ? $activeTabs[$cookieKey] : null;
    }

    public function getCookieKey()
    {
        return $this->makeSessionKey().'-'.$this->context;
    }

    /**
     * Returns the active session key.
     * @return \Illuminate\Routing\Route|mixed|string
     */
    public function getSessionKey()
    {
        if ($this->sessionKey) {
            return $this->sessionKey;
        }

        if (post('_session_key')) {
            return $this->sessionKey = post('_session_key');
        }

        return $this->sessionKey = uniqid();
    }

    /**
     * Returns the active context for displaying the form.
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Validate the supplied form model.
     * @return mixed
     * @throws \Exception
     */
    protected function validateModel()
    {
        if (!$this->model) {
            throw new Exception(lang(
                sprintf('text_form_missing_model', get_class($this->controller))
            ));
        }

        $this->data = isset($this->data) ? (object)$this->data : $this->model;

        return $this->model;
    }

    /**
     * Creates a flat array of form fields from the configuration.
     * Also slots fields in to their respective tabs.
     * @return void
     */
    protected function defineFormFields()
    {
        if ($this->fieldsDefined) {
            return;
        }

        // Extensibility
        Event::fire('admin.form.extendFieldsBefore', [$this]);
        $this->fireEvent('form.extendFieldsBefore');

        // Outside fields
        if (!isset($this->fields) OR !is_array($this->fields)) {
            $this->fields = [];
        }

        $this->allTabs->outside = new FormTabs(FormTabs::SECTION_OUTSIDE, $this->config);
        $this->addFields($this->fields);

        // Primary Tabs + Fields
        if (!isset($this->tabs['fields']) OR !is_array($this->tabs['fields'])) {
            $this->tabs['fields'] = [];
        }

        $this->allTabs->primary = new FormTabs(FormTabs::SECTION_PRIMARY, $this->tabs);
        $this->addFields($this->tabs['fields'], FormTabs::SECTION_PRIMARY);

        // Extensibility
        $this->fireEvent('form.extendFields', [$this->allFields]);
        Event::fire('admin.form.extendFields', [$this, $this->allFields]);

        // Convert automatic spanned fields
        foreach ($this->allTabs->outside->getFields() as $fields) {
            $this->processAutoSpan($fields);
        }

        foreach ($this->allTabs->primary->getFields() as $fields) {
            $this->processAutoSpan($fields);
        }

        // At least one tab section should stretch
        if (
            $this->allTabs->primary->stretch === null
            AND $this->allTabs->outside->stretch === null
        ) {
            if ($this->allTabs->primary->hasFields()) {
                $this->allTabs->primary->stretch = TRUE;
            }
            else {
                $this->allTabs->outside->stretch = TRUE;
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

        $this->fieldsDefined = TRUE;
    }

    /**
     * Converts fields with a span set to 'auto' as either
     * 'left' or 'right' depending on the previous field.
     * @return void
     */
    protected function processAutoSpan($fields)
    {
        $prevSpan = null;

        foreach ($fields as $field) {
            if (strtolower($field->span) === 'auto') {
                if ($prevSpan === 'left') {
                    $field->span = 'right';
                }
                else {
                    $field->span = 'left';
                }
            }

            $prevSpan = $field->span;
        }
    }

    /**
     * Check if a field type is a widget or not
     *
     * @param  string $fieldType
     *
     * @return boolean
     */
    protected function isFormWidget($fieldType)
    {
        if ($fieldType === null) {
            return FALSE;
        }

        if (strpos($fieldType, '\\')) {
            return TRUE;
        }

        $widgetClass = $this->widgetManager->resolveFormWidget($fieldType);

        if (!class_exists($widgetClass)) {
            return FALSE;
        }

        if (is_subclass_of($widgetClass, 'Admin\Classes\BaseFormWidget')) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Allow the model to filter fields.
     */
    protected function applyFiltersFromModel()
    {
        if (method_exists($this->model, 'filterFields')) {
            $this->model->filterFields((object)$this->allFields, $this->getContext());
        }
    }

    /**
     * Looks at the model for defined options.
     *
     * @param FormField $field
     * @param $fieldOptions
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getOptionsFromModel($field, $fieldOptions)
    {
        // Advanced usage, supplied options are callable
        if (is_array($fieldOptions) AND is_callable($fieldOptions)) {
            $fieldOptions = call_user_func($fieldOptions, $this, $field);
        }

        // Refer to the model method or any of its behaviors
        if (!is_array($fieldOptions) AND !$fieldOptions) {
            list($model, $attribute) = $field->resolveModelAttribute($this->model, $field->fieldName);

            $methodName = 'get'.studly_case($attribute).'Options';
            if (
                !$this->objectMethodExists($model, $methodName) AND
                !$this->objectMethodExists($model, 'getDropdownOptions')
            ) {
                throw new Exception(sprintf(lang('admin::default.options_method_not_exists'),
                    get_class($model), $methodName, $field->fieldName
                ));
            }

            if ($this->objectMethodExists($model, $methodName)) {
                $fieldOptions = $model->$methodName($field->value, $this->data);
            }
            else {
                $fieldOptions = $model->getDropdownOptions($attribute, $field->value, $this->data);
            }
        } // Field options are an explicit method reference
        elseif (is_string($fieldOptions)) {
            if (!$this->objectMethodExists($this->model, $fieldOptions)) {
                throw new Exception(sprintf(lang('admin::default.options_method_not_exists'),
                    get_class($this->model), $fieldOptions, $field->fieldName
                ));
            }

            $fieldOptions = $this->model->$fieldOptions($field->value, $field->fieldName);
        }

        return $fieldOptions;
    }

    /**
     * Internal helper for method existence checks.
     *
     * @param  object $object
     * @param  string $method
     *
     * @return boolean
     */
    protected function objectMethodExists($object, $method)
    {
        if (method_exists($object, 'methodExists')) {
            return $object->methodExists($method);
        }

        return method_exists($object, $method);
    }

    /**
     * Variant to array_get() but preserves dots in key names.
     *
     * @param array $array
     * @param array $parts
     * @param null $default
     *
     * @return array|string
     */
    protected function dataArrayGet(array $array, array $parts, $default = null)
    {
        if ($parts === null) {
            return $array;
        }

        if (count($parts) === 1) {
            $key = array_shift($parts);
            if (isset($array[$key])) {
                return $array[$key];
            }
            else {
                return $default;
            }
        }

        foreach ($parts as $segment) {
            if (!is_array($array) OR !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Variant to array_set() but preserves dots in key names.
     *
     * @param array $array
     * @param array $parts
     * @param string $value
     *
     * @return array|string
     */
    protected function dataArraySet(array &$array, array $parts, $value)
    {
        if ($parts === null) {
            return $value;
        }

        while (count($parts) > 1) {
            $key = array_shift($parts);

            if (!isset($array[$key]) OR !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array =& $array[$key];
        }

        $array[array_shift($parts)] = $value;

        return $array;
    }

    protected function getSourceData()
    {
        return $this->arrayName
            ? post($this->arrayName)
            : post();
    }
}
