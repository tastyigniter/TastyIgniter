<?php namespace Admin\FormWidgets;

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
        $this->manager = ComponentsManager::instance();
        $this->fillFromConfig([
            'form',
            'mode',
            'prompt',
        ]);

        $this->processExistingItems();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('components/components');
    }

    public function loadAssets()
    {
        $this->addJs(assets_url('js/vendor/jquery-sortable.js'), 'jquery-sortable-js');

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

    public function processExistingItems()
    {
        $itemIndexes = null;

        if (!$loadValue = $this->getLoadValue())
            return;

        foreach ($loadValue as $component => $properties) {
            list($name, $alias) = strpos($component, ' ')
                ? explode(' ', $component)
                : [$component, $component];

            if (!$component = $this->manager->findComponent($name))
                continue;

            $component['alias'] = $alias;

            $this->components[$alias] = $this->makeComponentFormWidget($component, $properties);
        }
    }

    public function onAddComponent()
    {
        $componentCode = post('code');
        if (!strlen($componentCode))
            return FALSE;

        $componentAlias = $this->getUniqueAlias($componentCode);

        $component = $this->manager->findComponent($componentCode);
        $component['alias'] = $componentAlias;

        $component = $this->makeComponentFormWidget($component, []);

        return $this->makePartial('components/component', [
            'component' => $component,
            'field'     => $this->formField,
        ]);
    }

    protected function makeComponentFormWidget($component, $properties)
    {
        $code = $component['code'];
        $alias = $component['alias'];

        try {
            $componentObj = $this->manager->makeComponent($code, $alias, $properties);

            $component['options'] = $this->manager->getComponentPropertyValues($componentObj);

            $componentPropertyConfig = $this->manager->getComponentPropertyConfig($componentObj);
        } catch (Exception $ex) {
            //@todo: create unknown component object
            $component = null;
        }

        $formConfig = $this->mergeComponentFormConfig($this->form, $componentPropertyConfig);
        $formConfig['model'] = $this->model;
        $formConfig['data'] = $component;
        $formConfig['previewMode'] = $this->previewMode;
        $formConfig['alias'] = $this->alias.'Form'.'-'.$alias;
        $formConfig['arrayName'] = $this->formField->getName().'['.$alias.']';

        $component['component'] = $component;
        $component['widget'] = $widget = $this->makeWidget('Admin\Widgets\Form', $formConfig);
        $widget->bindToController();

        return (object)$component;
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
            } catch (Exception $ex) {
            }

            $components[$code] = (object)$component;
        }

        return $components;
    }

    protected function mergeComponentFormConfig($configForm, $propertyConfig)
    {
        $fields = array_get($configForm, 'fields');

        if (isset($propertyConfig['alias'])) {
            $fields['alias'] = array_merge($propertyConfig['alias'], $fields['alias']);
        }

        $nameArray = 'options';
        foreach (array_except($propertyConfig, ['alias']) as $name => $property) {
            $nameExploded = explode('[', $name);
            $name = (count($nameExploded) > 1)
                ? $nameArray.'['.$nameExploded[0].']'.substr($name, strlen($nameExploded[0]))
                : $nameArray.'['.$nameExploded[0].']';

            $fields[$name] = $property;
        }

        $configForm['fields'] = $fields;

        return $configForm;
    }

    protected function getUniqueAlias($alias)
    {
        if (!isset($this->components[$alias]))
            return $alias;

        $alias .= 'Copy';

        return $alias;
    }
}