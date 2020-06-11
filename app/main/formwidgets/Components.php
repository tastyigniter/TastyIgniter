<?php namespace Main\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Carbon\Carbon;
use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Main\Classes\ThemeManager;
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

    public $addTitle = 'main::lang.components.button_new';

    public $editTitle = 'main::lang.components.button_edit';

    protected $components = [];

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'mode',
            'prompt',
        ]);

        $this->manager = ComponentsManager::instance();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('components/components');
    }

    public function loadAssets()
    {
        $this->addJs('~/app/admin/formwidgets/recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');

        $this->addJs('~/app/admin/formwidgets/repeater/assets/vendor/sortablejs/Sortable.min.js', 'sortable-js');
        $this->addJs('~/app/admin/formwidgets/repeater/assets/vendor/sortablejs/jquery-sortable.js', 'jquery-sortable-js');

        $this->addCss('css/components.css', 'components-css');
        $this->addJs('js/components.js', 'components-js');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['components'] = $this->getComponents();
    }

    public function getSaveValue($value)
    {
        $result = [];
        $components = array_get($this->data->settings, 'components');
        foreach ((array)$value as $index => $alias) {
            $result[sprintf('[%s]', $alias)] = $components[$alias];
        }

        return $result;
    }

    public function onLoadRecord()
    {
        $codeAlias = post('recordId');
        $componentObj = $this->makeComponentBy($codeAlias);
        $context = !is_null($codeAlias) ? 'edit' : 'create';

        return $this->makePartial('~/app/admin/formwidgets/recordeditor/form', [
            'formRecordId' => $codeAlias,
            'formTitle' => lang($context == 'create' ? $this->addTitle : $this->editTitle),
            'formWidget' => $this->makeComponentFormWidget($context, $componentObj),
        ]);
    }

    public function onSaveRecord()
    {
        $isCreateContext = !strlen(post('recordId'));
        $codeAlias = $isCreateContext
            ? post($this->formField->arrayName.'[componentData][component]')
            : post('recordId');

        if (!strlen($codeAlias))
            throw new ApplicationException('Invalid component selected');

        if (!$template = $this->getTemplate())
            throw new ApplicationException('Template file not found');

        $this->updateComponent($codeAlias, $isCreateContext, $template);

        flash()->success(sprintf(lang('admin::lang.alert_success'),
            'Component '.($isCreateContext ? 'added' : 'updated')))->now();

        $template = $this->getTemplate();
        $this->formField->value = array_get($template->settings, 'components');
        $this->controller->setTemplateValue('mTime', $template->mTime);

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('container') => $this->makePartial('container', [
                'components' => $this->getComponents(),
            ]),
        ];
    }

    public function onRemoveComponent()
    {
        $codeAlias = post('code');
        if (!strlen($codeAlias))
            throw new ApplicationException('Invalid component selected');

        $template = $this->getTemplate();

        $attributes = $template->attributes;
        unset($attributes[sprintf('[%s]', $codeAlias)]);
        $template->attributes = $attributes;

        $template->mTime = Carbon::now()->timestamp;
        $template->save();

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Component removed'))->now();

        $this->controller->setTemplateValue('mTime', $template->mTime);

        return ['#notification' => $this->makePartial('flash')];
    }

    protected function getComponents()
    {
        $components = [];
        if (!$loadValue = (array)$this->getLoadValue())
            return $components;

        foreach ($loadValue as $codeAlias => $properties) {
            [$code, $alias] = $this->getCodeAlias($codeAlias);

            $definition = array_merge([
                'alias' => $codeAlias,
                'name' => $codeAlias,
                'description' => null,
                'fatalError' => null,
            ], $this->manager->findComponent($code) ?? []);

            try {
                $this->manager->makeComponent($code, $alias, $properties);
                $definition['alias'] = $codeAlias;
            }
            catch (Exception $ex) {
                $definition['fatalError'] = $ex->getMessage();
            }

            $components[$codeAlias] = (object)$definition;
        }

        return $components;
    }

    protected function makeComponentBy($codeAlias)
    {
        $componentObj = null;
        if (strlen($codeAlias)) {
            [$code, $alias] = $this->getCodeAlias($codeAlias);
            $propertyValues = array_get((array)$this->getLoadValue(), $codeAlias, []);
            $componentObj = $this->manager->makeComponent($code, $alias, $propertyValues);
            $componentObj->alias = $codeAlias;
        }

        return $componentObj;
    }

    protected function makeComponentFormWidget($context, $componentObj = null)
    {
        $propertyConfig = $propertyValues = [];
        if ($componentObj) {
            $propertyConfig = $this->manager->getComponentPropertyConfig($componentObj);
            $propertyValues = $this->manager->getComponentPropertyValues($componentObj);
        }

        $formConfig = $this->mergeComponentFormConfig($this->form, $propertyConfig);
        $formConfig['model'] = $this->model;
        $formConfig['data'] = $propertyValues;
        $formConfig['alias'] = $this->alias.'ComponentForm';
        $formConfig['arrayName'] = $this->formField->arrayName.'[componentData]';
        $formConfig['previewMode'] = $this->previewMode;
        $formConfig['context'] = $context;

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
        $existingComponents = (array)$this->getLoadValue();
        while (isset($existingComponents[$alias])) {
            if (strpos($alias, ' ') === FALSE)
                $alias .= ' '.$alias;

            $alias .= 'Copy';
        }

        return $alias;
    }

    protected function getCodeAlias($name)
    {
        return strpos($name, ' ') ? explode(' ', $name) : [$name, $name];
    }

    protected function getTemplate()
    {
        $fileName = sprintf('%s/%s',
            $this->controller->getTemplateValue('type'),
            $this->controller->getTemplateValue('file')
        );

        return ThemeManager::instance()->readFile($fileName, $this->model->code);
    }

    protected function updateComponent($codeAlias, $isCreateContext, $template)
    {
        $componentObj = $this->makeComponentBy($codeAlias);
        $form = $this->makeComponentFormWidget('edit', $componentObj);
        $properties = $isCreateContext
            ? $this->manager->getComponentPropertyValues($componentObj)
            : $form->getSaveData();

        $properties = $this->convertComponentPropertyValues($properties);

        if ($isCreateContext) {
            $alias = sprintf('[%s]', $this->getUniqueAlias($codeAlias));
            $template->update(['settings' => [$alias => $properties]]);
        }
        else {
            $alias = sprintf('[%s]', $codeAlias);
            $template->updateComponent($alias, $properties);
        }
    }

    protected function convertComponentPropertyValues($properties)
    {
        $properties['alias'] = sprintf('[%s]', $properties['alias']);

        return array_map(function ($propertyValue) {
            if (is_numeric($propertyValue))
                $propertyValue += 0; // Convert to int or float

            return $propertyValue;
        }, $properties);
    }
}