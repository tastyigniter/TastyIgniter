<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Models\Menu_options_model;
use Admin\Traits\FormModelWidget;
use Admin\Traits\ValidatesForm;
use Admin\Widgets\Form;
use Exception;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Support\Facades\DB;

/**
 * Menu Option Editor Widget
 */
class MenuOptionEditor extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    const INDEX_SEARCH = '___index__';

    const SORT_PREFIX = '___dragged_';

    //
    // Object properties
    //

    protected $defaultAlias = 'menuoptioneditor';

    protected $modelClass = Menu_options_model::class;

    //
    // Configurable properties
    //

    public $formName = 'Record';

    /**
     * @var array Form field configuration
     */
    public $form;

    public $pickerPlaceholder = 'lang:admin::lang.menu_options.help_menu_option';

    public $newRecordTitle = 'New %s';

    public $editRecordTitle = 'Edit %s';

    public $emptyMessage = 'admin::lang.list.text_empty';

    public $confirmMessage = 'admin::lang.alert_warning_confirm';

    public $popupSize = 'modal-lg';

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'formName',
            'pickerPlaceholder',
            'emptyMessage',
            'confirmMessage',
            'popupSize',
        ]);

        if ($this->formField->disabled || $this->formField->readOnly) {
            $this->previewMode = TRUE;
        }
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('menuoptioneditor/menuoptioneditor');
    }

    public function loadAssets()
    {
        $this->addJs('../../repeater/assets/vendor/sortablejs/Sortable.min.js', 'sortable-js');
        $this->addJs('../../repeater/assets/vendor/sortablejs/jquery-sortable.js', 'jquery-sortable-js');
        $this->addJs('../../repeater/assets/js/repeater.js', 'repeater-js');

        $this->addJs('../../recordeditor/assets/js/recordeditor.modal.js', 'recordeditor-modal-js');
        $this->addJs('../../recordeditor/assets/js/recordeditor.js', 'recordeditor-js');

        $this->addJs('js/menuoptioneditor.js', 'menuoptioneditor-js');
    }

    public function getSaveValue($value)
    {
        return FormField::NO_SAVE_DATA;
    }

    /**
     * Prepares the view data
     */
    public function prepareVars()
    {
        $this->vars['formField'] = $this->formField;
        $this->vars['fieldItems'] = $this->getLoadValue();

        $this->vars['pickerPlaceholder'] = $this->pickerPlaceholder;

        $this->vars['emptyMessage'] = $this->emptyMessage;
        $this->vars['confirmMessage'] = $this->confirmMessage;
    }

    public function reload()
    {
        $this->formField->value = null;
        $this->model->reloadRelations();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '#'.$this->getId('items') => $this->makePartial('menuoptioneditor/items'),
        ];
    }

    public function onAssignRecord()
    {
        $menuOptionId = post('optionId');
        if (!$menuOption = Menu_options_model::find($menuOptionId))
            throw new ApplicationException(lang('admin::lang.menu_options.alert_menu_option_not_attached'));

        if ($this->model->menu_option_values()->where('option_id', $menuOptionId)->exists())
            throw new ApplicationException(lang('admin::lang.menu_options.alert_menu_option_already_attached'));

        $menuOption->option_values()->get()->each(function ($model) {
            $this->model->menu_option_values()->create([
                'option_id' => $model->option_id,
                'option_value_id' => $model->option_value_id,
                'priority' => $model->priority,
            ]);
        });

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Menu item option assigned'))->now();

        return $this->reload();
    }

    public function onLoadRecord()
    {
        $formTitle = lang($this->editRecordTitle);

        if (!strlen($recordId = post('recordId')))
            throw new ApplicationException(lang('admin::lang.form.missing_id'));

        $model = $this->getLoadValue()->firstWhere('option_id', $recordId);

        if (!$model)
            throw new Exception(sprintf(lang('admin::lang.form.not_found'), $recordId));

        return $this->makePartial('recordeditor/form', [
            'formRecordId' => $recordId,
            'formTitle' => sprintf($formTitle, lang($this->formName)),
            'formWidget' => $this->makeItemFormWidget($model, 'edit'),
        ]);
    }

    public function onSaveRecord()
    {
        if (!strlen($recordId = post('recordId')))
            throw new ApplicationException(lang('admin::lang.form.missing_id'));

        $model = $this->getLoadValue()->firstWhere('option_id', $recordId);

        $form = $this->makeItemFormWidget($model, 'edit');

        $saveData = $this->prepareSaveData($model, $form->getSaveData());

        DB::transaction(function () use ($saveData) {
            $this->model->addMenuOptionValues($saveData);
        });

        flash()->success(sprintf(lang('admin::lang.alert_success'), 'Item updated'))->now();

        return $this->reload();
    }

    public function onDeleteRecord()
    {
        if (!strlen($recordId = post('recordId')))
            throw new ApplicationException(lang('admin::lang.form.missing_id'));

        $this->model->menu_option_values()
            ->where('option_id', $recordId)
            ->delete();

        flash()->success(sprintf(lang('admin::lang.alert_success'), lang($this->formName).' deleted'))->now();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
        ];
    }

    protected function getPickerOptions()
    {
        return $this->modelClass::getRecordEditorOptions();
    }

    protected function makeItemFormWidget($model, $context)
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model;
        $widgetConfig['alias'] = $this->alias.'FormMenuOptionEditor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[menuOptionEditorData]';
        $widgetConfig['context'] = $context;
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();
        $widget->previewMode = $this->previewMode;

        return $widget;
    }

    protected function prepareSaveData($model, $saveData)
    {
        $optionValues = collect(array_get($saveData, 'menu_option_values'))
            ->map(function ($optionValue) {
                $optionValue['new_price'] = $optionValue['price'];
                unset($optionValue['price']);

                return $optionValue;
            })
            ->all();

        return [$model->getKey() => $optionValues];
    }
}
