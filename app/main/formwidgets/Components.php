<?php

namespace Main\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Traits\ValidatesForm;
use Carbon\Carbon;
use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Flame\Support\Facades\File;
use Main\Classes\ThemeManager;
use System\Classes\ComponentManager as ComponentsManager;

/**
 * Components
 * This widget is used by the system internally on the Layouts pages.
 */
class Components extends BaseFormWidget
{
    use ValidatesForm;

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

    public $copyPartialTitle = 'main::lang.components.button_copy_partial';

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
        $this->validate(post(), [
            'alias' => ['string'],
            'context' => ['required', 'string', 'in:create,edit,partial'],
        ]);

        $codeAlias = post('alias');
        $componentObj = $this->makeComponentBy($codeAlias);
        $context = post('context');

        $formTitle = $context == 'create' ? $this->addTitle : $this->editTitle;
        if ($context === 'partial')
            $formTitle = $this->copyPartialTitle;

        return $this->makePartial('~/app/admin/formwidgets/recordeditor/form', [
            'formRecordId' => $codeAlias,
            'formTitle' => lang($formTitle),
            'formWidget' => $this->makeComponentFormWidget($context, $componentObj),
        ]);
    }

    public function onSaveRecord()
    {
        if (ThemeManager::instance()->isLocked($this->model->code)) {
            flash()->danger(lang('system::lang.themes.alert_theme_locked'))->important();

            return;
        }

        $this->validate(post(), ['recordId' => ['string']]);

        $isCreateContext = request()->method() === 'POST';
        $codeAlias = $isCreateContext
            ? post($this->formField->arrayName.'[componentData][component]')
            : post('recordId');

        if (!strlen($codeAlias))
            throw new ApplicationException('Invalid component selected');

        if (!$template = $this->getTemplate())
            throw new ApplicationException('Template file not found');

        $partialToOverride = post($this->formField->arrayName.'[componentData][partial]');

        if (strlen($partialToOverride)) {
            $this->overrideComponentPartial($codeAlias, $partialToOverride);

            flash()->success(sprintf(lang('admin::lang.alert_success'),
                'Component partial copied'
            ))->now();
        }
        else {
            $this->updateComponent($codeAlias, $isCreateContext, $template);

            flash()->success(sprintf(lang('admin::lang.alert_success'),
                'Component '.($isCreateContext ? 'added' : 'updated')
            ))->now();

            $template = $this->getTemplate();
            $this->formField->value = array_get($template->settings, 'components');
            $this->controller->setTemplateValue('mTime', $template->mTime);
        }

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

        $attributes = $template->getAttributes();
        unset($attributes[sprintf('[%s]', $codeAlias)]);
        $template->setRawAttributes($attributes);

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
            $propertyConfig = $context === 'edit' ? $this->manager->getComponentPropertyConfig($componentObj) : [];
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

        $widget->bindEvent('form.extendFields', function ($allFields) use ($widget, $componentObj) {
            if (!$formField = $widget->getField('partial'))
                return;

            $this->extendPartialField($formField, $componentObj);
        });

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
            if (strpos($alias, ' ') === false)
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

            return $template->update(['settings' => [$alias => $properties]]);
        }

        [$rules, $attributes] = $this->manager->getComponentPropertyRules($componentObj);
        $this->validate($properties, $rules, [], $attributes);

        $alias = sprintf('[%s]', $codeAlias);
        $template->updateComponent($alias, $properties);
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

    protected function extendPartialField($formField, $componentObj)
    {
        $activeTheme = $this->model->getTheme();
        $themePartialPath = sprintf('%s/%s/%s/', $activeTheme->name, '_partials', $componentObj->alias);

        $formField->comment(sprintf(lang('system::lang.themes.help_override_partial'), $themePartialPath));

        $formField->options(function () use ($componentObj) {
            return collect(File::glob($componentObj->getPath().'/*.blade.php'))
                ->mapWithKeys(function ($path) {
                    return [File::basename($path) => str_before(File::basename($path), '.blade.php')];
                });
        });
    }

    protected function overrideComponentPartial($codeAlias, $fileName)
    {
        $componentObj = $this->makeComponentBy($codeAlias);

        $activeTheme = $this->model->getTheme();
        $themePartialPath = sprintf('%s/%s/%s', $activeTheme->path, '_partials', $componentObj->alias);

        if (!File::exists($componentObj->getPath().'/'.$fileName))
            throw new ApplicationException('The selected component partial does not exist in the component directory');

        if (File::exists($themePartialPath.'/'.$fileName))
            throw new ApplicationException('The selected component partial already exists in active theme partials directory.');

        if (!File::exists($themePartialPath))
            File::makeDirectory($themePartialPath, 077, true);

        File::copy($componentObj->getPath().'/'.$fileName, $themePartialPath.'/'.$fileName);
    }
}
