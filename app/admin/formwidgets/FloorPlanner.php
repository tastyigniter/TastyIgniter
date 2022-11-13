<?php

namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Admin\Traits\FormModelWidget;
use Admin\Traits\ValidatesForm;

/**
 * Floor planner
 * Renders a floor planner field.
 *
 */
class FloorPlanner extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    //
    // Configurable properties
    //

    /**
     * @var string Relation name, if this field name does not represents a model relationship.
     */
    public $relationFrom;

    /**
     * @var array Default available colors
     */
    public $sectionColors = [
        '#1abc9c', '#16a085',
        '#9b59b6', '#8e44ad',
        '#34495e', '#2b3e50',
        '#f1c40f', '#f39c12',
        '#e74c3c', '#c0392b',
        '#95a5a6', '#7f8c8d',
    ];

    public $connectorField = 'dining_tables';

    public $formTitle = 'Edit table';

    /**
     * @var string Use a custom scope method for the list query.
     */
    public $scope;

    //
    // Object properties
    //

    protected $defaultAlias = 'floorplanner';

    public function initialize()
    {
        $this->fillFromConfig([
            'sectionColors',
            'relationFrom',
            'connectorField',
            'formTitle',
            'scope',
        ]);
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('floorplanner/floorplanner');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['field'] = $this->formField;
        $this->vars['sectionColors'] = $this->sectionColors();
        $this->vars['diningTables'] = $this->formField->options();
        $this->vars['connectorWidgetAlias'] = $this->getConnectorWidgetAlias();
    }

    public function loadAssets()
    {
        $this->addJs('https://unpkg.com/konva@8.3.12/konva.min.js', 'konva-js');
        $this->addCss('css/floorplanner.css', 'floorplanner-css');
        $this->addJs('js/floorplanner.js', 'floorplanner-js');
    }

    public function onSaveState()
    {
        $state = json_decode(post('state'), true);

        $this->validate($state, [
            'stage.x' => ['required', 'numeric'],
            'stage.y' => ['required', 'numeric'],
            'stage.scaleX' => ['required', 'numeric'],
            'stage.scaleY' => ['required', 'numeric'],
            'groups.*.x' => ['required', 'numeric'],
            'groups.*.y' => ['required', 'numeric'],
            'groups.*.rotation' => ['required', 'numeric'],
        ]);

        $this->model->floor_plan = array_only($state, 'stage');
        $this->model->save();

        collect(array_get($state, 'groups'))->each(function ($group) {
            $id = str_after(array_get($group, 'id'), 'group-');
            if ($table = $this->model->dining_tables()->find($id)) {
                $table->seat_layout = $group;
                $table->save();
            }
        });
    }

    public function getSaveValue($value)
    {
        return FormField::NO_SAVE_DATA;
    }

    protected function sectionColors()
    {
        $colors = [];
        foreach ($this->sectionColors as $color) {
            $colors[$color] = $color;
        }

        return $colors;
    }

    protected function getConnectorWidgetAlias()
    {
        $form = $this->controller->widgets['form'];

        return $form->alias.studly_case(name_to_id($this->connectorField));
    }
}
