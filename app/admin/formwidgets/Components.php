<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use System\Classes\ComponentManager as ComponentsManager;

/**
 * Components
 * This widget is used by the system internally on the Layouts pages.
 *
 * @package Admin
 */
class Components extends BaseFormWidget
{
    //
    // Configurable properties
    //
    protected static $onAddItemCalled;

    /**
     * @var array Form field configuration
     */
    public $form;

    protected $components;

    protected $indexCount = 0;

    protected $partialComponents;

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'mode',
        ]);

        if (!self::$onAddItemCalled) {
            $this->processExistingItems();
        }
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('components/components');
    }

    public function loadAssets()
    {
        $this->addCss('css/components.css', 'components-css');
        $this->addJs('js/components.js', 'components-js');
    }

    public function getLoadValue()
    {
        $value = parent::getLoadValue();
        if ($value instanceof Collection)
            $value = $value->groupBy('partial')->toArray();

        if (!is_array($value))
            return [];

        $result = [];
        foreach ($value as $partial => $components) {
            foreach ($components as $code => $component) {
                $component['code'] = isset($component['module_code']) ? $component['module_code'] : $code;
                $result[$partial][] = $component;
            }
        }

        return $result;
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['components'] = $this->getVisibleComponents();
        $this->vars['themePartials'] = $this->getThemePartials();
        $this->vars['onAddEventHandler'] = $this->getEventHandler('onAddComponent');
        $this->vars['field'] = $this->formField;
    }

    public function getThemePartials()
    {
        $result = [];
        foreach (get_partial_areas('main') as $partial) {
            $result[$partial['id']] = (object)$partial;
        }

        return $result;
    }

    public function getPartialComponents($partial)
    {
        if (!$this->partialComponents OR !array_key_exists($partial->id, $this->partialComponents))
            return [];

        return $this->partialComponents[$partial->id];
    }

    public function processExistingItems()
    {
        $itemIndexes = null;

        $loadValue = $this->getLoadValue();

        foreach ($loadValue as $partial => $components) {

            foreach ($components as $component) {
                if (!isset($component['module_code']) OR !strlen($component['module_code']))
                    return null;

                $componentCode = $component['module_code'];
                $componentObj = $this->makeComponentFormWidget($componentCode, $component);
                $this->indexCount++;

                $this->partialComponents[$componentObj->partial][] = $componentObj;
            }
        }
    }

    public function onAddComponent()
    {
        self::$onAddItemCalled = TRUE;

        $postData = post();
        if (!$postData OR !isset($postData['code']))
            return FALSE;

        $this->prepareVars();

        $postData['layout_id'] = $this->model->getKey();
        $postData['module_code'] = $postData['code'];
        $postData['alias'] = $postData['code'];
        $postData['options'] = [];
        $this->vars['component'] = $this->makeComponentFormWidget($postData['code'], $postData);

        $itemContainer = '@#'.$this->getId('partial-'.$postData['partial']);

        return [$itemContainer => $this->makePartial('components/component')];
    }

    protected function makeComponentFormWidget($componentCode, $component)
    {
        $manager = ComponentsManager::instance();

        if ($componentFound = $manager->findComponent($componentCode))
            $component = array_merge($componentFound, $component);

        if (!isset($component['name']))
            $component['name'] = $component['code'];

        $componentObj = $component;
        $componentObj['disabled'] = !is_array($componentFound);

        $componentModel = Layout_modules_model::findOrNew(
            isset($componentObj['layout_module_id']) ? $componentObj['layout_module_id'] : null
        );

        $componentPropertyConfig = [];
        try {
            $componentObj['component'] = $manager->makeComponent($componentCode, null, $component);

            $componentPropertyConfig = $manager->getComponentPropertyConfig($componentObj['component']);

            $component['options'] = array_merge(
                $manager->getComponentPropertyValues($componentObj['component']),
                is_array($component['options']) ? $component['options'] : []
            );
        } catch (Exception $ex) {
            //@todo: create unknown component object
            $componentObj['component'] = null;
        }

        $formConfig = $this->mergeComponentFormConfig($this->form, $componentPropertyConfig);
        $formConfig['model'] = $componentModel->fill($component);
        $formConfig['previewMode'] = $this->previewMode;
        $formConfig['alias'] = $this->alias.'Form'.$componentObj['partial'].'-'.uniqid($componentCode);
        $formConfig['arrayName'] = $this->formField->getName().'['.$componentObj['partial'].']['.uniqid().']';

        $componentObj['widget'] = $this->makeWidget('Admin\Widgets\Form', $formConfig);
        $componentObj['widget']->bindToController();

        return (object)$componentObj;
    }

    /**
     * @return array
     */
    protected function getVisibleComponents()
    {
        $components = [];
        $manager = ComponentsManager::instance();
        foreach ($manager->listComponents() as $code => $component) {
            try {
                $componentObj = $manager->makeComponent($code, null, $component);

                if ($componentObj->isHidden) continue;
            } catch (Exception $ex) {
            }

            $components[$code] = $component;
        }

        return $components;
    }

    protected function mergeComponentFormConfig($configForm, $propertyConfig)
    {
        $fields = [];

        if (isset($propertyConfig['alias'])) {
            $fields['alias'] = $propertyConfig['alias'];
        }

        $nameArray = 'options';
        foreach (array_except($propertyConfig, ['alias']) as $name => $property) {
            $nameExploded = explode('[', $name);
            $name = (count($nameExploded) > 1)
                ? $nameArray.'['.$nameExploded[0].']'.substr($name, strlen($nameExploded[0]))
                : $nameArray.'['.$nameExploded[0].']';

            $fields[$name] = $property;
        }

        $configForm['fields'] = array_merge($fields, $configForm['fields']);

        return $configForm;
    }

    protected function fillModelFromComponentProperties($model, $component)
    {
        $model->fill($properties);
    }
}