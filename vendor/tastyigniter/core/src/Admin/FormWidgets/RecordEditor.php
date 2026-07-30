<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Html\HtmlFacade as Html;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

/**
 * Record Editor
 */
class RecordEditor extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    public null|string|array $form = null;

    public ?string $modelClass = null;

    public ?string $addonLeft = null;

    public ?string $addonRight = null;

    public ?string $popupSize = null;

    public string $formName = 'Record';

    public bool $hideEditButton = false;

    public bool $hideDeleteButton = false;

    public bool $hideCreateButton = false;

    public ?string $attachToField = null;

    public string $addLabel = 'New';

    public string $editLabel = 'Edit';

    public string $deleteLabel = 'Delete';

    public string $attachLabel = 'Attach';

    //
    // Object properties
    //

    protected string $defaultAlias = 'recordeditor';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'form',
            'formName',
            'modelClass',
            'hideCreateButton',
            'hideEditButton',
            'hideDeleteButton',
            'attachToField',
            'addLabel',
            'editLabel',
            'deleteLabel',
            'popupSize',
        ]);

        $this->makeRecordFormWidgetFromRequest();
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('recordeditor/recordeditor');
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('formwidgets/repeater.js', 'repeater-js');
        $this->addCss('formwidgets/recordeditor.css', 'recordeditor-css');

        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->makeFormField();
        $this->vars['addonLeft'] = $this->makeFieldAddon('left');
        $this->vars['addonRight'] = $this->makeFieldAddon('right');

        $this->vars['addLabel'] = $this->addLabel;
        $this->vars['editLabel'] = $this->editLabel;
        $this->vars['deleteLabel'] = $this->deleteLabel;
        $this->vars['attachLabel'] = $this->attachLabel;
        $this->vars['showEditButton'] = !$this->hideEditButton;
        $this->vars['showDeleteButton'] = !$this->hideDeleteButton;
        $this->vars['showCreateButton'] = !$this->hideCreateButton;
        $this->vars['showAttachButton'] = !empty($this->attachToField);
    }

    public function onLoadRecord(): string
    {
        $model = !empty($recordId = post('recordId', ''))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle' => ($model->exists ? $this->editLabel : $this->addLabel).' '.lang($this->formName),
            'formWidget' => $this->makeRecordFormWidget($model),
        ]);
    }

    public function onSaveRecord(): array
    {
        $model = !empty($recordId = post('recordId', ''))
            ? $this->findFormModel($recordId)
            : $this->createFormModel();

        $form = $this->makeRecordFormWidget($model);

        $saveData = $this->validateFormWidget($form, $form->getSaveData());

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function() use ($modelsToSave) {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });

        flash()->success(sprintf(lang('igniter::admin.alert_success'),
            lang($this->formName).' '.($form->context == 'create' ? 'created' : 'updated')))->now();

        return $this->reload();
    }

    public function onDeleteRecord(): array
    {
        $model = $this->findFormModel(post('recordId', ''));

        $model->delete();

        flash()->success(sprintf(lang('igniter::admin.alert_success'), lang($this->formName).' deleted'))->now();

        return $this->reload();
    }

    public function onAttachRecord(): array
    {
        throw_unless($recordId = post('recordId'),
            new FlashException('Please select a record to attach.'),
        );

        $model = $this->findFormModel($recordId);

        if ($this->modelMethodExists($model, 'attachRecordTo')) {
            $model->attachRecordTo($this->model);

            flash()->success(sprintf(lang('igniter::admin.alert_success'), lang($this->formName).' attached'))->now();
        }

        /** @var null|Form $formWidget */
        $formWidget = $this->getController()->widgets['form'] ?? null;
        $response = $formWidget?->getFormWidget($this->attachToField)->reload() ?? [];

        return array_merge([
            '#notification' => $this->makePartial('flash'),
        ], $response);
    }

    protected function makeRecordFormWidget(Model $model): Form
    {
        $context = $model->exists ? 'edit' : 'create';

        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'RecordEditor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[recordData]';
        $widgetConfig['context'] = $context;

        /** @var Form $widget */
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        return $widget;
    }

    protected function makeFieldAddon(string $string): ?string
    {
        $name = camel_case('addon_'.$string);
        $config = $this->{$name};

        if (!$config) {
            return null;
        }

        if (!is_array($config)) {
            $config = [$config];
        }

        $config = (object)array_merge([
            'tag' => 'div',
            'label' => 'Label',
            'attributes' => [],
        ], $config);

        return '<'.$config->tag.Html::attributes($config->attributes).'>'.lang($config->label).'</'.$config->tag.'>';
    }

    protected function getRecordEditorOptions(): array|Collection
    {
        $model = $this->createFormModel();
        $methodName = 'get'.studly_case($this->fieldName).'RecordEditorOptions';

        throw_if(
            !$this->modelMethodExists($model, $methodName) && !$this->modelMethodExists($model, 'getRecordEditorOptions'),
            new FlashException(sprintf(lang('igniter::admin.alert_missing_method'), 'getRecordEditorOptions', $model::class)),
        );

        if ($this->modelMethodExists($model, $methodName)) {
            $result = $model->$methodName($this->model, $this->fieldName);
        } else {
            $result = $model->getRecordEditorOptions($this->model, $this->fieldName);
        }

        return $result;
    }

    protected function makeRecordFormWidgetFromRequest()
    {
        if (empty($requestData = request()->header('X-IGNITER-RECORD-EDITOR-REQUEST-DATA', ''))) {
            return;
        }

        if (empty($recordId = array_get(json_decode($requestData, true), $this->alias.'.recordId', ''))) {
            return;
        }

        $model = $this->findFormModel($recordId);

        $this->makeRecordFormWidget($model);
    }

    protected function makeFormField(): FormField
    {
        $field = clone $this->formField;

        $field->options(fn(): Collection|array => $this->getRecordEditorOptions());

        return $field;
    }

    protected function modelMethodExists(Model $model, string $methodName): bool
    {
        if (method_exists($model, 'methodExists')) {
            return $model->methodExists($methodName);
        }

        return method_exists($model, $methodName);
    }
}
