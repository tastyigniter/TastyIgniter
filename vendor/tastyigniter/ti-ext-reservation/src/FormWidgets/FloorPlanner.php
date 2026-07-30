<?php

declare(strict_types=1);

namespace Igniter\Reservation\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningTable;
use Override;

/**
 * Floor planner
 * Renders a floor planner field.
 *
 * @property DiningArea $model
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

    protected string $defaultAlias = 'floorplanner';

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'sectionColors',
            'relationFrom',
            'connectorField',
            'formTitle',
            'scope',
        ]);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('floorplanner/floorplanner');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['sectionColors'] = $this->sectionColors();
        $this->vars['diningTables'] = $this->formField->options();
        $this->vars['connectorWidgetAlias'] = $this->getConnectorWidgetAlias();
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('https://unpkg.com/konva@8.3.12/konva.min.js', 'konva-js');
        $this->addCss('css/floorplanner.css', 'floorplanner-css');
        $this->addJs('js/floorplanner.js', 'floorplanner-js');
    }

    public function onSaveState(): void
    {
        $state = json_decode((string)input('state'), true);

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

        collect(array_get($state, 'groups'))->each(function($group): void {
            $id = str_after(array_get($group, 'id'), 'group-');
            /** @var DiningTable $table */
            if ($table = $this->model->dining_tables()->find($id)) {
                $table->seat_layout = $group;
                $table->save();
            }
        });
    }

    #[Override]
    public function getSaveValue(mixed $value): int
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

    protected function getConnectorWidgetAlias(): string
    {
        $formAlias = $this->controller->widgets['form']->alias ?? 'form';

        return $formAlias.studly_case(name_to_id($this->connectorField));
    }
}
