<?php namespace Main\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Exception;
use System\Classes\ComponentManager as ComponentsManager;

/**
 * Components
 * This widget is used by the system internally on the Layouts pages.
 *
 * @package Admin
 */
class Components extends BaseFormWidget
{
    protected static $onAddItemCalled;

    /**
     * @var ComponentsManager
     */
    protected $manager;

    //
    // Configurable properties
    //
    /**
     * @var array Form field configuration
     */
    public $form;

    public $prompt;

    protected $indexCount = 0;

    protected $components = [];

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'mode',
            'prompt',
        ]);

        $this->manager = ComponentsManager::instance();
        $this->processExistingItems();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('components/components');
    }

    public function loadAssets()
    {
        $this->addJs('~/app/admin/formwidgets/repeater/assets/js/jquery-sortable.js', 'jquery-sortable-js');

        $this->addCss('css/components.css', 'components-css');
        $this->addJs('js/components.js', 'components-js');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['components'] = $this->components;
        $this->vars['availableComponents'] = $this->getAvailableComponents();
        $this->vars['onAddEventHandler'] = $this->getEventHandler('onAddComponent');
        $this->vars['field'] = $this->formField;
    }

    public function onAddComponent()
    {
        $componentCode = post('code');
        if (!strlen($componentCode))
            return FALSE;

        $componentAlias = $this->getUniqueAlias($componentCode);
        $properties = $this->manager->findComponent($componentCode);
        $properties['alias'] = $componentAlias;

        $componentField = $this->makeComponentField($componentAlias, $properties);
        if (!$componentField)
            return FALSE;

        return $this->makePartial('components/component', [
            'component' => $componentField,
            'field' => $this->formField,
        ]);
    }

    protected function processExistingItems()
    {
        $itemIndexes = null;

        if (!$loadValue = (array)$this->getLoadValue())
            return;

        foreach ($loadValue as $alias => $properties) {
            $this->components[$alias] = $this->makeComponentField($alias, $properties);
        }
    }

    /**
     * @return array
     */
    protected function getAvailableComponents()
    {
        $components = [];
        $manager = ComponentsManager::instance();
        foreach ($manager->listComponents() as $code => $component) {
            try {
                $componentObj = $manager->makeComponent($code, null, $component);

                if ($componentObj->isHidden) continue;

                $components[$code] = (object)$component;
            }
            catch (Exception $ex) {
            }
        }

        return $components;
    }

    protected function makeComponentField($name, $properties)
    {
        [$code, $alias] = strpos($name, ' ')
            ? explode(' ', $name)
            : [$name, $name];

        $componentConfig = $this->manager->findComponent($code);

        try {
            $componentObj = $this->manager->makeComponent($code, $alias, $properties);
        }
        catch (Exception $ex) {
            flash()->warning("Could not load component {$code}");

            return null;
        }

        $componentObj->alias = $name;
        $componentConfig['alias'] = $name;

        $propertyConfig = $this->manager->getComponentPropertyConfig($componentObj);
        $propertyValues = $this->manager->getComponentPropertyValues($componentObj);
        $formWidget = $this->makeComponentFormWidget($name, $propertyConfig, $propertyValues);

        return (object)[
            'alias' => $alias,
            'meta' => (object)$componentConfig,
            'object' => $componentObj,
            'widget' => $formWidget,
        ];
    }

    protected function makeComponentFormWidget($alias, $propertyConfig, $propertyValues)
    {
        $formConfig = $this->mergeComponentFormConfig($this->form, $propertyConfig);
        $formConfig['model'] = $this->model;
        $formConfig['data'] = $propertyValues;
        $formConfig['previewMode'] = $this->previewMode;
        $formConfig['alias'] = $this->alias.'Form'.'-'.str_slug($alias);
        $formConfig['arrayName'] = $this->formField->getName().'['.$alias.']';

        $widget = $this->makeWidget('Admin\Widgets\Form', $formConfig);
        $widget->bindToController();

        return $widget;
    }

    protected function mergeComponentFormConfig($formConfig, $propertyConfig)
    {
        $fields = array_merge(
            array_get($formConfig, 'fields'),
            array_except($propertyConfig, ['alias'])
        );

        if (isset($propertyConfig['alias'])) {
            $fields['alias'] = array_merge($propertyConfig['alias'], $fields['alias']);
        }

        $formConfig['fields'] = $fields;

        return $formConfig;
    }

    protected function getUniqueAlias($alias)
    {
        if (!isset($this->components[$alias]))
            return $alias;

        $alias .= ' '.$alias;
        $alias .= 'Copy';

        return $alias;
    }
}