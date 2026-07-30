<?php

declare(strict_types=1);

namespace Igniter\Local\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Admin\Widgets\Form;
use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Html\HtmlFacade as Html;
use Igniter\Local\Models\LocationArea;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

/**
 * Map Area
 */
class MapArea extends BaseFormWidget
{
    use FormModelWidget;
    use ValidatesForm;

    const SORT_PREFIX = '___dragged_';

    //
    // Configurable properties
    //

    public $form;

    public $modelClass = LocationArea::class;

    public $prompt = 'lang:igniter.local::default.text_add_new_area';

    public $formName = 'lang:igniter.local::default.text_edit_area';

    public $addLabel = 'New';

    public $editLabel = 'Edit';

    public $deleteLabel = 'Delete';

    public $sortColumnName = 'priority';

    public $sortable = true;

    //
    // Object properties
    //

    protected string $defaultAlias = 'maparea';

    protected $areaColors;

    protected $shapeDefaultProperties = [
        'id' => null,
        'default' => 'address',
        'options' => [],
        'circle' => [],
        'polygon' => [],
        'vertices' => [],
        'serialized' => false,
        'editable' => false,
    ];

    protected $sortableInputName;

    protected $formWidget;

    protected $mapAreas;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'modelClass',
            'prompt',
            'form',
            'formName',
            'addLabel',
            'editLabel',
            'deleteLabel',
            'sortable',
        ]);

        $this->areaColors = LocationArea::$areaColors;

        $fieldName = $this->formField->getName(false);
        $this->sortableInputName = self::SORT_PREFIX.$fieldName;
    }

    #[Override]
    public function loadAssets(): void
    {
        $this->addJs('formwidgets/repeater.js', 'repeater-js');
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');

        $this->addCss('maparea.css', 'maparea-css');
        $this->addJs('maparea.js', 'maparea-js');

        // Make the mapview assets available
        if (strlen((string)($key = setting('maps_api_key'))) !== 0) {
            $url = 'https://maps.googleapis.com/maps/api/js?key=%s&libraries=geometry';
            $this->addJs(sprintf($url, $key),
                ['name' => 'google-maps-js', 'async' => null, 'defer' => null],
            );
        }

        $this->addJs('mapview.js', 'mapview-js');
        $this->addJs('mapview.shape.js', 'mapview-shape-js');
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('maparea/maparea');
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->formField;
        $this->vars['mapAreas'] = $this->getMapAreas();
        $this->vars['sortable'] = $this->sortable;
        $this->vars['sortableInputName'] = $this->sortableInputName;

        $this->vars['prompt'] = $this->prompt;
    }

    #[Override]
    public function getSaveValue(mixed $value): mixed
    {
        if (!$this->sortable) {
            return FormField::NO_SAVE_DATA;
        }

        $items = $this->formField->value;
        if (!$items instanceof Collection) {
            return $items;
        }

        $sortedIndexes = (array)post($this->sortableInputName);
        $sortedIndexes = array_flip($sortedIndexes);

        $value = [];
        foreach ($items as $index => $item) {
            $value[$index] = [
                $item->getKeyName() => $item->getKey(),
                $this->sortColumnName => $sortedIndexes[$item->getKey()],
            ];
        }

        return $value;
    }

    public function onLoadRecord(): string
    {
        $model = strlen((string)$areaId = post('recordId')) !== 0
            ? $this->findFormModel($areaId)
            : $this->createFormModel();

        return $this->makePartial('maparea/area_form', [
            'formAreaId' => $areaId,
            'formTitle' => ($model->exists ? $this->editLabel : $this->addLabel).' '.lang($this->formName),
            'formWidget' => $this->makeAreaFormWidget($model, 'edit'),
        ]);
    }

    public function onSaveRecord(): array
    {
        $model = strlen((string)$areaId = post('areaId')) !== 0
            ? $this->findFormModel($areaId)
            : $this->createFormModel();

        $form = $this->makeAreaFormWidget($model, 'edit');

        $saveData = $this->validateFormWidget($form, $form->getSaveData());

        $modelsToSave = $this->prepareModelsToSave($model, $saveData);

        DB::transaction(function() use ($modelsToSave): void {
            foreach ($modelsToSave as $modelToSave) {
                $modelToSave->saveOrFail();
            }
        });

        flash()->success(sprintf(lang('igniter::admin.alert_success'),
            'Area '.($form->context == 'create' ? 'created' : 'updated'),
        ))->now();

        $this->formField->value = null;
        $this->model->reloadRelations();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
            '.map-area-container' => $this->makePartial('maparea/areas'),
        ];
    }

    public function onDeleteArea(): array
    {
        throw_unless($areaId = input('areaId'),
            new FlashException(lang('igniter.local::default.alert_invalid_area')),
        );

        throw_unless($model = $this->getRelationModel()->find($areaId),
            new FlashException(sprintf(lang('igniter::admin.form.not_found'), $areaId)),
        );

        $model->delete();

        flash()->success(sprintf(lang('igniter::admin.alert_success'), lang($this->formName).' deleted'))->now();

        $this->prepareVars();

        return [
            '#notification' => $this->makePartial('flash'),
        ];
    }

    public function getMapShapeAttributes($area)
    {
        $areaColor = $area->color;

        $attributes = [
            'data-id' => $area->area_id ?? 1,
            'data-name' => $area->name ?? '',
            'data-default' => $area->type ?? 'address',
            'data-color' => $areaColor,
            'data-polygon' => $area->boundaries['polygon'] ?? null,
            'data-circle' => $area->boundaries['circle'] ?? null,
            'data-vertices' => $area->boundaries['vertices'] ?? null,
            'data-editable' => $this->previewMode ? 'false' : 'true',
            'data-options' => json_encode([
                'fillColor' => $areaColor,
                'strokeColor' => $areaColor,
                'distanceUnit' => setting('distance_unit'),
            ]),
        ];

        return Html::attributes($attributes);
    }

    protected function getMapAreas()
    {
        $loadValue = $this->getLoadValue() ?? [];

        $loadValue = $loadValue instanceof Collection
            ? $loadValue->toArray()
            : $loadValue;

        if ($this->sortable) {
            $loadValue = sort_array($loadValue, $this->sortColumnName);
        }

        $result = [];

        foreach ($loadValue as $key => $area) {
            if (!isset($area['color']) || !strlen((string)$area['color'])) {
                $index = min($key, count($this->areaColors));
                $area['color'] = $this->areaColors[$index] ?? $this->areaColors[0];
            }

            $result[$key] = (object)$area;
        }

        return $this->mapAreas = $result;
    }

    protected function makeAreaFormWidget($model, $context)
    {
        if (is_null($model->location_id)) {
            $model->location_id = $this->model->getKey();
        }

        $config = is_string($this->form) ? $this->loadConfig($this->form, ['form'], 'form') : $this->form;
        $config['context'] = $context;
        $config['model'] = $model;
        $config['alias'] = $this->alias.'Form';
        $config['arrayName'] = $this->formField->arrayName.'[areaData]';

        $widget = $this->makeWidget(Form::class, $config);
        $widget->bindToController();

        return $this->formWidget = $widget;
    }
}
