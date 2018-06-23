<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Widgets\Form;
use Exception;

/**
 * Status Editor
 *
 * @package Admin
 */
class StatusEditor extends BaseFormWidget
{
    /**
     * @var string Relation column to display for the name
     */
    public $nameFrom = 'status_name';

    /**
     * @var string Relation column to display for the color
     */
    public $colorFrom = 'status_color';

    public $relationFrom = 'status';

    /**
     * @var string Text to display for the title of the popup list form
     */
    public $formTitle = 'Edit Status';

    protected $buttonLabel = 'Edit';

    //
    // Object properties
    //

    protected $defaultAlias = 'statuseditor';

    protected $form;

    public function initialize()
    {
        $this->fillFromConfig([
            'form',
            'formTitle',
            'buttonLabel',
            'relationFrom',
            'nameFrom',
            'colorFrom',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('statuseditor/statuseditor');
    }

    public function loadAssets()
    {
        $this->addJs('js/statuseditor.js', 'statuseditor-js');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['value'] = $this->formField->value;
        $this->vars['fieldOptions'] = $this->formField->options();

        $this->vars['formTitle'] = $this->formTitle;
        $this->vars['buttonLabel'] = $this->buttonLabel;
        $this->vars['nameFrom'] = $this->nameFrom;
        $this->vars['colorFrom'] = $this->colorFrom;
        $this->vars['statusFormWidget'] = $this->makeStatusFormWidget();
    }

    public function getSaveValue($value)
    {
        $statusData = array_merge(post($this->formField->arrayName.'.statusData', []), [
            'staff_id' => $this->getController()->getUser()->staff->getKey(),
        ]);

        $this->model->statusData = $statusData;

        return $value;
    }

    protected function makeStatusFormWidget()
    {
        $widgetConfig = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $widgetConfig['model'] = $model = $this->getRelationModel();
        $widgetConfig['data'] = $model->first();
        $widgetConfig['alias'] = $this->alias.'status-editor';
        $widgetConfig['arrayName'] = $this->formField->arrayName.'[statusData]';
        $widget = $this->makeWidget(Form::class, $widgetConfig);

        $widget->bindToController();

        return $widget;
    }

    /**
     * Returns the model of a relation type.
     * @return \Admin\FormWidgets\Relation
     * @throws \Exception
     */
    protected function getRelationModel()
    {
        list($model, $attribute) = $this->formField->resolveModelAttribute($this->model, $this->relationFrom);

        if (!$model OR !$model->hasRelation($attribute)) {
            throw new Exception(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $this->relationFrom
            ));
        }

        return $model->{$attribute}();
    }
}
