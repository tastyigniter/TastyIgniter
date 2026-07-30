<?php

declare(strict_types=1);

namespace Igniter\Main\FormWidgets;

use Exception;
use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Pagic\Model;
use Igniter\Flame\Pagic\TemplateSandbox;
use Igniter\Main\Classes\Theme;
use Igniter\Main\Classes\ThemeManager;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\RedirectResponse;
use Override;

/**
 * Template Editor
 * @property-read \Igniter\Main\Models\Theme $model
 */
class TemplateEditor extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    public null|string|array $form = null;

    public string $placeholder = 'igniter::system.themes.text_select_file';

    public string $formName = 'igniter::system.themes.label_template';

    public string $addLabel = 'igniter::system.themes.button_new_source';

    public string $editLabel = 'igniter::system.themes.button_rename_source';

    public string $deleteLabel = 'igniter::system.themes.button_delete_source';

    //
    // Object properties
    //

    protected string $defaultAlias = 'templateeditor';

    protected ThemeManager $manager;

    protected array $templateConfig = [
        '_pages' => 'igniter::models/main/page',
        '_partials' => 'igniter::models/main/partial',
        '_layouts' => 'igniter::models/main/layout',
        '_content' => 'igniter::models/main/content',
    ];

    protected ?Form $templateWidget = null;

    protected ?string $templateType = null;

    protected ?string $templateFile = null;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'formName',
            'addLabel',
            'editLabel',
            'deleteLabel',
            'placeholder',
        ]);

        $this->manager = resolve(ThemeManager::class);
        if (!$this->previewMode = $this->manager->isLocked($this->model->code)) {
            $this->templateWidget = $this->makeTemplateFormWidget();
        }
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        if (!is_null($this->templateWidget)) {
            $this->setTemplateValue('mTime', $this->getTemplateModifiedTime());
        }

        return $this->makePartial('templateeditor/templateeditor');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['fieldOptions'] = $this->getTemplateEditorOptions();
        $this->vars['templateTypes'] = $templateTypes = $this->getTemplateTypes();

        $this->vars['selectedTemplateType'] = $templateType = $this->getTemplateType();
        $this->vars['selectedTemplateFile'] = $this->getTemplateFile();
        $this->vars['selectedTypeLabel'] = str_singular(lang($templateTypes[$templateType]));

        $this->vars['templateWidget'] = $this->templateWidget;
        $this->vars['templatePrimaryTabs'] = optional($this->templateWidget)->getTab('outside');
        $this->vars['templateSecondaryTabs'] = optional($this->templateWidget)->getTab('primary');
    }

    /**
     * Reloads the widgets primary contents.
     */
    #[Override]
    public function reload(): array
    {
        $this->templateWidget = $this->makeTemplateFormWidget();
        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('container') => $this->makePartial('templateeditor/container'),
        ];
    }

    public function onChooseFile(): RedirectResponse
    {
        $data = $this->validate(post('Theme.source.template'), [
            'type' => ['required', 'in:_pages,_partials,_layouts,_content'],
            'file' => ['sometimes', 'nullable', 'string'],
        ], [], [
            'type' => 'Source Type',
            'file' => 'Source File',
        ]);

        $this->setTemplateValue('type', array_get($data, 'type'));
        $this->setTemplateValue('file', array_get($data, 'file'));

        return $this->controller->refresh();
    }

    public function onManageSource(): RedirectResponse
    {
        if ($this->manager->isLocked($this->model->code)) {
            throw new FlashException(lang('igniter::system.themes.alert_theme_locked'));
        }

        $data = $this->validate(post(), [
            'action' => ['required', 'in:delete,rename,new'],
            'name' => ['present', 'regex:/^[a-zA-Z-_\.\/]+$/'],
        ], [], [
            'action' => 'Source Action',
            'name' => 'Source Name',
        ]);

        $fileAction = array_get($data, 'action');
        $newFileName = sprintf('%s/%s', $this->getTemplateType(), array_get($data, 'name'));
        $fileName = $this->getFilename();

        if ($fileAction == 'rename') {
            $this->manager->renameFile($fileName, $newFileName, $this->model->code);
            flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Template file renamed '));
        } elseif ($fileAction == 'delete') {
            $this->manager->deleteFile($fileName, $this->model->code);
            flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Template file deleted '));
        } else {
            $this->manager->newFile($newFileName, $this->model->code);
            flash()->success(sprintf(lang('igniter::admin.alert_success'), 'Template file created '));
        }

        $this->setTemplateValue('file', array_get($data, 'name'));

        return $this->controller->refresh();
    }

    public function onSaveSource(): void
    {
        if ($this->manager->isLocked($this->model->code)) {
            throw new FlashException(lang('igniter::system.themes.alert_theme_locked'));
        }

        $data = post('Theme.source');

        $this->validateAfter(function(Validator $validator) {
            if ($this->wasTemplateModified()) {
                $validator->errors()->add('markup', lang('igniter::system.themes.alert_changes_confirm'));
            }
        });

        $this->validate($data,
            array_get($this->templateWidget->config ?? [], 'rules', []),
            array_get($this->templateWidget->config ?? [], 'validationMessages', []),
            array_get($this->templateWidget->config ?? [], 'validationAttributes', []),
        );

        $formData = $this->getTemplateAttributes();

        $this->templateWidget?->data->fileSource->fill($formData)->save();
    }

    protected function makeTemplateFormWidget(): ?Form
    {
        try {
            $template = $this->manager->readFile($this->getFilename(), $this->model->code);
        } catch (Exception) {
            return null;
        }

        $configFile = $this->templateConfig[$this->getTemplateType()];
        $widgetConfig = $this->loadConfig($configFile, ['form'], 'form');

        $widgetConfig['data'] = [
            'fileName' => $template->getFileName(),
            'baseFileName' => $template->getBaseFileName(),
            'settings' => $template->settings ?? [],
            'markup' => $template->getMarkup(),
            'codeSection' => $template->getCode(),
            'fileSource' => $template,
        ];

        $widgetConfig['model'] = $this->model;
        $widgetConfig['arrayName'] = $this->formField->arrayName;
        $widgetConfig['context'] = 'edit';

        /** @var Form $widget */
        $widget = $this->makeWidget(Form::class, $widgetConfig);
        $widget->bindToController();

        if ($componentsWidget = $widget->getFormWidget('settings[components]')) {
            $componentsWidget->bindEvent('partialCopied', function($partialName) {
                $this->setTemplateValue('type', '_partials');
                $this->setTemplateValue('file', $partialName);
            });

            $componentsWidget->bindEvent('updated', function($partialName) {
                $this->setTemplateValue('mTime', $this->getTemplateModifiedTime());
            });
        }

        return $widget;
    }

    protected function getTemplateEditorOptions(): array
    {
        if (!($themeObject = $this->model->getTheme()) || !$themeObject instanceof Theme) {
            throw new FlashException('Missing theme object on '.$this->model::class);
        }

        /** @var Model $templateClass */
        $templateClass = $themeObject->getTemplateClass($this->getTemplateType());

        return $templateClass::getDropdownOptions($themeObject->getName(), true);
    }

    protected function getTemplateTypes(): array
    {
        return [
            '_pages' => 'igniter::system.themes.label_type_page',
            '_partials' => 'igniter::system.themes.label_type_partial',
            '_layouts' => 'igniter::system.themes.label_type_layout',
            '_content' => 'igniter::system.themes.label_type_content',
        ];
    }

    protected function getTemplateAttributes(): array
    {
        $templateSanitizer = resolve(TemplateSandbox::class);
        $formData = $this->templateWidget?->getSaveData() ?? [];

        $code = (string)array_get($formData, 'codeSection', '');
        $code = preg_replace('/^\<\?php/', '', $code);
        $code = preg_replace('/^\<\?/', '', (string)preg_replace('/\?>$/', '', (string)$code));

        $result['code'] = trim((string)$code, PHP_EOL) !== '' && trim((string)$code, PHP_EOL) !== '0'
            ? $templateSanitizer->sanitize(trim((string)$code, PHP_EOL))
            : null;
        $result['markup'] = array_get($formData, 'markup')
            ? $templateSanitizer->sanitize((string)array_get($formData, 'markup'))
            : null;

        $settings = array_get($formData, 'settings', []);

        return array_merge(array_except($settings, ['components']), $result);
    }

    protected function wasTemplateModified(): bool
    {
        $sessionTime = $this->getTemplateValue('mTime');
        $mTime = $this->getTemplateModifiedTime();

        return $sessionTime != $mTime;
    }

    protected function getTemplateModifiedTime(): ?int
    {
        return $this->templateWidget?->data?->fileSource->mTime ?? null;
    }

    public function getTemplateValue(string $name, mixed $default = null): mixed
    {
        return $this->getSession($this->model->code.'-selected-'.$name, $default);
    }

    public function setTemplateValue(string $name, mixed $value): void
    {
        $this->putSession($this->model->code.'-selected-'.$name, $value);
    }

    public function getTemplateType(): string
    {
        return $this->getTemplateValue('type') ?? '_pages';
    }

    public function getTemplateFile(): string
    {
        return $this->getTemplateValue('file') ?? '';
    }

    protected function getFilename(): string
    {
        return sprintf('%s/%s', $this->getTemplateType(), $this->getTemplateFile());
    }
}
