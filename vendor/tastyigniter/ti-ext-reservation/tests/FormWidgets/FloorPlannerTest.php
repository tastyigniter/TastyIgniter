<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\FormWidgets;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Classes\FormField;
use Igniter\Reservation\FormWidgets\FloorPlanner;
use Igniter\Reservation\Models\Reservation;
use Igniter\System\Facades\Assets;
use Mockery;

beforeEach(function(): void {
    $controller = new class extends AdminController {};
    $this->floorPlanner = new FloorPlanner($controller, new FormField('test_field', 'Floor planner'), []);
});

it('initializes with default configuration', function(): void {
    $this->floorPlanner->initialize();

    $colors = [
        '#1abc9c', '#16a085',
        '#9b59b6', '#8e44ad',
        '#34495e', '#2b3e50',
        '#f1c40f', '#f39c12',
        '#e74c3c', '#c0392b',
        '#95a5a6', '#7f8c8d',
    ];
    expect($this->floorPlanner->sectionColors)->toBe($colors)
        ->and($this->floorPlanner->connectorField)->toBe('dining_tables')
        ->and($this->floorPlanner->formTitle)->toBe('Edit table');
});

it('prepares vars', function(): void {
    $this->floorPlanner->prepareVars();

    expect($this->floorPlanner->vars['field'])->toBeInstanceOf(FormField::class)
        ->and($this->floorPlanner->vars)->toHaveKeys(['sectionColors', 'diningTables', 'connectorWidgetAlias']);
});

it('loads assets correctly', function(): void {
    Assets::shouldReceive('addJs')->with('https://unpkg.com/konva@8.3.12/konva.min.js', 'konva-js')->once();
    Assets::shouldReceive('addCss')->with('css/floorplanner.css', 'floorplanner-css')->once();
    Assets::shouldReceive('addJs')->with('js/floorplanner.js', 'floorplanner-js')->once();

    $this->floorPlanner->loadAssets();
});

it('saves state and updates model and tables', function(): void {
    $model = Mockery::mock(Reservation::class)->makePartial();

    $model->shouldReceive('save')->once();
    $model->shouldReceive('dining_tables')->andReturnSelf();
    $model->shouldReceive('find')->with('1')->andReturn($table = Mockery::mock());
    $table->shouldReceive('save')->once();
    $this->floorPlanner->model = $model;

    $state = json_encode([
        'stage' => ['x' => 0, 'y' => 0, 'scaleX' => 1, 'scaleY' => 1],
        'groups' => [['id' => 'group-1', 'x' => 0, 'y' => 0, 'rotation' => 0]],
    ]);
    request()->merge(['state' => $state]);

    $this->floorPlanner->onSaveState();
});

it('returns no save data for getSaveValue', function(): void {
    $result = $this->floorPlanner->getSaveValue('any value');

    expect($result)->toBe(FormField::NO_SAVE_DATA);
});
