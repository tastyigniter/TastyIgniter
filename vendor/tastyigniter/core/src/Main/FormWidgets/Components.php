<?php

declare(strict_types=1);

namespace Igniter\Main\FormWidgets;

use Carbon\Carbon;
use Exception;
use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Pagic\Model;
use Igniter\Flame\Support\Facades\File;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Models\Theme;
use Igniter\Main\Template\Layout;
use Igniter\Main\Template\Page;
use Igniter\System\Classes\BaseComponent;
use Igniter\System\Classes\ComponentManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Component as BladeComponent;
use Livewire\Component as LivewireComponent;
use Override;
use stdClass;

/**
 * Components
 * This widget is used by the system internally on the Layouts pages.
 * @property-read Theme $model
 */
class Components extends BaseFormWidget
{
    use ValidatesForm;

    protected ComponentManager $manager;

    //
    // Configurable properties
    //

    public null|string|array $form = null;

    public ?string $prompt = 'igniter::admin.text_please_select';

    public string $addTitle = 'igniter::main.components.button_new';

    public string $editTitle = 'igniter::main.components.button_edit';

    public string $copyPartialTitle = 'igniter::main.components.button_copy_partial';

    protected array $components = [];

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'mode',
            'prompt',
        ]);

        $this->manager = resolve(ComponentManager::class);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('components/components');
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');

        $this->addCss('components.css', 'components-css');
        $this->addJs('components.js', 'components-js');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['components'] = $this->getComponents();
        $this->vars['templateComponents'] = $this->loadTemplateComponents();
    }

    #[Override]
    public function getSaveValue(mixed $value): int
    {
        if (is_array($value)) {
            $this->data->fileSource->sortComponents($value);
        }

        return FormField::NO_SAVE_DATA;
    }

    public function onLoadRecord(): string
    {
        $data = $this->validate(post(), [
            'alias' => ['string'],
            'context' => ['required', 'string', 'in:edit,partial'],
        ]);

        $codeAlias = array_get($data, 'alias');
        $componentObj = $this->makeComponentBy($codeAlias);
        $context = array_get($data, 'context');

        throw_if($componentObj && $componentObj->isHidden(), new FlashException('Selected component is hidden'));

        throw_if($context === 'partial' && $this->manager->isConfigurableComponent($codeAlias),
            new FlashException('Selected component is not configurable, hence cannot override partial.'));

        $formTitle = $context == 'partial' ? $this->copyPartialTitle : $this->editTitle;

        return $this->makePartial('igniter.admin::formwidgets/recordeditor/form', [
            'formRecordId' => $codeAlias,
            'formTitle' => lang($formTitle),
            'formWidget' => $this->makeComponentFormWidget($context, $componentObj),
        ]);
    }

    public function onSaveRecord(): array|RedirectResponse
    {
        if (resolve(ThemeManager::class)->isLocked($this->model->code)) {
            throw new FlashException(lang('igniter::system.themes.alert_theme_locked'));
        }

        $data = $this->validate(post(), [
            'recordId' => ['nullable', 'string'],
            name_to_dot_string($this->formField->arrayName).'.componentData' => ['array'],
        ]);

        $codeAlias = array_get($data, 'recordId');
        [$code,] = $this->manager->getCodeAlias($codeAlias);

        $isConfigurable = $this->manager->isConfigurableComponent($code);
        if ($isCreateContext = (strtolower(request()->method()) === 'post')) {
            if (!array_has($this->getComponents(), $codeAlias)) {
                throw new FlashException('Invalid component selected');
            }

            $codeAlias = $this->getUniqueAlias($codeAlias);
        } elseif (!array_has($this->loadTemplateComponents(), $codeAlias)) {
            throw new FlashException('Invalid component selected');
        }

        if (!$template = $this->data->fileSource) {
            throw new FlashException('Template file not found');
        }

        $partialToOverride = array_get($data, name_to_dot_string($this->formField->arrayName.'[componentData][partial]'));
        if (!$isConfigurable && $partialToOverride) {
            $this->overrideComponentPartial($codeAlias, $partialToOverride);

            flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Component partial copied'))->now();

            return $this->controller->redirectBack();
        }

        $this->updateComponent($codeAlias, $isCreateContext, $template);

        flash()->success(sprintf(lang('igniter::admin.alert_success'),
            'Component '.($isCreateContext ? 'added' : 'updated'),
        ))->now();

        $this->formField->value = array_get($template->settings, 'components');

        $this->fireEvent('updated', [$codeAlias]);

        return $this->reload();
    }

    public function onRemoveComponent(): array
    {
        if (!$codeAlias = post('code')) {
            throw new FlashException('Invalid component selected');
        }

        if (!$template = $this->data->fileSource) {
            throw new FlashException('Template file not found');
        }

        $attributes = $template->getAttributes();
        unset($attributes['settings']['components'][$codeAlias]);
        $template->setRawAttributes($attributes);

        $template->mTime = Carbon::now()->timestamp;
        $template->save();

        flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Component removed'))->now();

        $this->formField->value = array_get($template->settings, 'components');

        $this->fireEvent('updated', [$codeAlias]);

        return $this->reload();
    }

    public function isConfigurableComponent(stdClass|BaseComponent $componentObj): bool
    {
        if ($componentObj instanceof stdClass && !isset($componentObj->path)) {
            return false;
        }

        return $this->manager->isConfigurableComponent(
            $componentObj instanceof stdClass ? $componentObj->path : $componentObj::class,
        );
    }

    protected function getComponents(): array
    {
        return $this->model::getComponentOptions();
    }

    protected function loadTemplateComponents(): array
    {
        $components = [];
        if (!$loadValue = (array)$this->getLoadValue()) {
            return $components;
        }

        foreach ($loadValue as $codeAlias => $properties) {
            $definition = [
                'alias' => $codeAlias,
                'name' => $codeAlias,
                'description' => null,
                'fatalError' => null,
                'isConfigurable' => null,
            ];

            try {
                [$code,] = $this->manager->getCodeAlias($codeAlias);
                $componentObj = $this->manager->makeComponent($code, null, $properties);

                if ($componentObj->isHidden()) {
                    continue;
                }

                $definition = array_merge($definition, $this->manager->findComponent($code) ?? []);
            } catch (Exception $ex) {
                $definition['fatalError'] = $ex->getMessage();
            }

            $components[$codeAlias] = (object)$definition;
        }

        return $components;
    }

    protected function makeComponentBy(string $codeAlias): null|BaseComponent|LivewireComponent|BladeComponent
    {
        $componentObj = null;
        if (!empty($codeAlias)) {
            [$code,] = $this->manager->getCodeAlias($codeAlias);
            $propertyValues = array_get((array)$this->getLoadValue(), $codeAlias, []);
            $componentObj = $this->manager->makeComponent([$code, $codeAlias], null, $propertyValues);
        }

        return $componentObj;
    }

    protected function makeComponentFormWidget(
        string $context,
        null|BaseComponent|LivewireComponent|BladeComponent $componentObj = null,
    ): Form {
        $propertyConfig = [];
        $propertyValues = [];
        if ($componentObj !== null) {
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

        /** @var Form $widget */
        $widget = $this->makeWidget(Form::class, $formConfig);

        if ($componentObj instanceof BaseComponent) {
            $widget->bindEvent('form.extendFields', function($allFields) use ($widget, $componentObj) {
                if (!$formField = $widget->getField('partial')) {
                    return;
                }

                $this->extendPartialField($formField, $componentObj);
            });
        }

        $widget->bindToController();

        return $widget;
    }

    protected function mergeComponentFormConfig(array $formConfig, array $propertyConfig): array
    {
        $fields = array_merge(
            array_get($formConfig, 'fields'),
            array_except($propertyConfig, ['alias']),
        );

        if (isset($propertyConfig['alias'])) {
            $fields['alias'] = array_merge($propertyConfig['alias'], $fields['alias']);
        }

        $formConfig['fields'] = $fields;

        return $formConfig;
    }

    protected function getUniqueAlias(string $alias): string
    {
        $existingComponents = (array)$this->getLoadValue();
        while (isset($existingComponents[$alias])) {
            if (!str_contains($alias, ' ')) {
                $alias .= ' '.$alias;
            }

            $alias .= 'Copy';
        }

        return $alias;
    }

    protected function updateComponent(string $codeAlias, bool $isCreateContext, Page|Layout $template)
    {
        throw_unless($componentObj = $this->makeComponentBy($codeAlias), new FlashException('Invalid component selected'));

        throw_if($componentObj->isHidden(), new FlashException('Selected component is hidden'));

        $form = $this->makeComponentFormWidget('edit', $componentObj);

        $properties = [];

        if (!$isCreateContext) {
            $properties = $form->getSaveData();

            $properties = $this->convertComponentPropertyValues($properties);

            [$rules, $attributes] = $this->manager->getComponentPropertyRules($componentObj);
            $this->validate($properties, $rules, [], $attributes);
        }

        $template->updateComponent($codeAlias, $properties);
    }

    protected function convertComponentPropertyValues(array $properties): array
    {
        return array_map(function($propertyValue) {
            if (is_numeric($propertyValue)) {
                $propertyValue += 0;
            } // Convert to int or float

            return $propertyValue;
        }, $properties);
    }

    protected function extendPartialField(FormField $formField, BaseComponent $componentObj)
    {
        $activeTheme = $this->model->getTheme();
        $themePartialPath = sprintf('%s/%s/%s/', $activeTheme->name, '_partials', $componentObj->alias);

        $componentPath = $componentObj->getPath();
        if (File::isPathSymbol($componentPath)) {
            $componentPath = File::symbolizePath($componentPath);
        }

        $formField->comment = sprintf(lang('igniter::system.themes.help_override_partial'), $themePartialPath);

        $formField->options(fn() => collect(File::glob($componentPath.'/*.blade.php'))
            ->mapWithKeys(function($path): array {
                $name = str_before(File::basename($path), '.'.Model::DEFAULT_EXTENSION);

                return [$name => $name];
            }));
    }

    protected function overrideComponentPartial(string $codeAlias, string $fileName)
    {
        $componentObj = $this->makeComponentBy($codeAlias);

        throw_if($componentObj && $componentObj->isHidden(), new FlashException('Selected component is hidden'));

        $activeTheme = $this->model->getTheme();
        $themePartialPath = sprintf('%s/%s/%s/%s.%s', $activeTheme->path, '_partials', $componentObj->alias, $fileName, Model::DEFAULT_EXTENSION);

        $componentPath = $componentObj->getPath();
        if (File::isPathSymbol($componentPath)) {
            $componentPath = File::symbolizePath($componentPath);
        }

        $componentPath .= DIRECTORY_SEPARATOR.$fileName.'.'.Model::DEFAULT_EXTENSION;

        if (!File::exists($componentPath)) {
            throw new FlashException(lang('igniter::system.themes.alert_component_partial_not_found'));
        }

        if (!File::isDirectory(dirname($themePartialPath))) {
            File::makeDirectory(dirname($themePartialPath), 077, true, true);
        }

        File::copy($componentPath, $themePartialPath);

        $this->fireEvent('partialCopied', [$codeAlias.'.'.$fileName]);
    }
}
